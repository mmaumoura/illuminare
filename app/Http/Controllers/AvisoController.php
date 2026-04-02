<?php

namespace App\Http\Controllers;

use App\Models\Aviso;
use App\Models\Clinic;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AvisoController extends Controller
{
    public function index(Request $request): View
    {
        $user = auth()->user();

        $query = Aviso::with(['author', 'recipients'])
            ->orderByDesc('is_pinned')
            ->orderByDesc('created_at');

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('type')) {
            $query->where('type', 'like', '%' . $request->type . '%');
        }

        if ($request->filled('read_status') && !$user->isAdministrador()) {
            if ($request->read_status === 'nao_lido') {
                $query->where(fn($q) =>
                    $q->whereHas('recipients', fn($r) => $r->where('user_id', $user->id)->whereNull('read_at'))
                      ->orWhereDoesntHave('recipients', fn($r) => $r->where('user_id', $user->id))
                );
            } elseif ($request->read_status === 'lido') {
                $query->whereHas('recipients', fn($r) => $r->where('user_id', $user->id)->whereNotNull('read_at'));
            }
        }

        if (!$user->isAdministrador()) {
            $query->whereHas('recipients', fn($q) => $q->where('user_id', $user->id));
        }

        $avisos = $query->paginate(20)->withQueryString();

        return view('avisos.index', compact('avisos'));
    }

    public function create(): View
    {
        $clinicas = Clinic::orderBy('name')->get();

        return view('avisos.create', compact('clinicas'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'type'         => 'nullable|string|max:100',
            'content'      => 'required|string',
            'attachment'   => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx|max:5120',
            'priority'     => 'required|in:baixa,normal,alta,urgente',
            'expires_at'   => 'nullable|date',
            'is_pinned'    => 'nullable|boolean',
            'clinic_ids'   => 'nullable|array',
            'clinic_ids.*' => 'exists:clinics,id',
            'user_ids'     => 'nullable|array',
            'user_ids.*'   => 'exists:users,id',
        ]);

        $attachmentPath = null;
        $attachmentName = null;

        if ($request->hasFile('attachment')) {
            $file           = $request->file('attachment');
            $attachmentName = $file->getClientOriginalName();
            $attachmentPath = $file->store('avisos', 'public');
        }

        $aviso = Aviso::create([
            'user_id'         => auth()->id(),
            'title'           => $data['title'],
            'type'            => $data['type'] ?? null,
            'content'         => $data['content'],
            'attachment_path' => $attachmentPath,
            'attachment_name' => $attachmentName,
            'priority'        => $data['priority'],
            'expires_at'      => $data['expires_at'] ?? null,
            'is_pinned'       => $request->boolean('is_pinned'),
        ]);

        $recipientIds = [];

        if (!empty($data['user_ids'])) {
            $recipientIds = $data['user_ids'];
        } elseif (!empty($data['clinic_ids'])) {
            $recipientIds = User::whereIn('clinic_id', $data['clinic_ids'])
                ->pluck('id')
                ->toArray();
        }

        if (!empty($recipientIds)) {
            $aviso->recipients()->attach(array_unique($recipientIds));
        }

        return redirect()->route('operacional.avisos.index')
            ->with('success', 'Aviso criado com sucesso.');
    }

    public function show(Aviso $aviso): View
    {
        $user = auth()->user();

        $aviso->load(['author', 'recipients.clinic']);

        $pivot = $aviso->recipients()->where('user_id', $user->id)->first();
        if ($pivot && is_null($pivot->pivot->read_at)) {
            $aviso->recipients()->updateExistingPivot($user->id, ['read_at' => now()]);
        }

        return view('avisos.show', compact('aviso'));
    }

    public function destroy(Aviso $aviso): RedirectResponse
    {
        if ($aviso->attachment_path) {
            Storage::disk('public')->delete($aviso->attachment_path);
        }

        $aviso->delete();

        return redirect()->route('operacional.avisos.index')
            ->with('success', 'Aviso excluído.');
    }

    public function usersByClinic(Request $request)
    {
        $ids   = $request->query('clinic_ids', []);
        $users = User::whereIn('clinic_id', (array) $ids)
            ->orderBy('name')
            ->get(['id', 'name', 'clinic_id']);

        return response()->json($users);
    }
}
