<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use App\Models\ClinicDocument;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ClinicController extends Controller
{
    private function rules(): array
    {
        return [
            'name'           => 'required|string|max:255',
            'cnpj'           => 'nullable|string|max:18',
            'phone'          => 'nullable|string|max:20',
            'email'          => 'nullable|email|max:255',
            'status'         => 'required|in:Ativa,Inativa,Suspensa',
            'cep'            => 'nullable|string|max:9',
            'street'         => 'nullable|string|max:255',
            'number'         => 'nullable|string|max:20',
            'complement'     => 'nullable|string|max:100',
            'neighborhood'   => 'nullable|string|max:100',
            'city'           => 'nullable|string|max:100',
            'state'          => 'nullable|string|max:2',
            'rep_name'       => 'nullable|string|max:255',
            'rep_cpf'        => 'nullable|string|max:14',
            'rep_phone'      => 'nullable|string|max:20',
            'rep_email'      => 'nullable|email|max:255',
            'contract_start' => 'nullable|date',
            'contract_end'   => 'nullable|date|after_or_equal:contract_start',
            'contract_notes' => 'nullable|string',
        ];
    }

    public function index(Request $request): View
    {
        $query = Clinic::withCount('patients')->orderBy('name');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('cnpj', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        $clinics = $query->paginate(25)->withQueryString();
        return view('clinicas.index', compact('clinics'));
    }

    public function create(): View
    {
        return view('clinicas.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());
        $validated['active'] = $validated['status'] === 'Ativa';
        $clinic = Clinic::create($validated);

        return redirect()->route('gestao.clinicas.show', $clinic)
            ->with('success', 'Unidade cadastrada com sucesso.');
    }

    public function show(Clinic $clinica): View
    {
        $clinica->loadCount(['patients', 'users', 'documents']);
        $documents = $clinica->documents()->latest()->get();
        return view('clinicas.show', compact('clinica', 'documents'));
    }

    public function edit(Clinic $clinica): View
    {
        return view('clinicas.edit', compact('clinica'));
    }

    public function update(Request $request, Clinic $clinica): RedirectResponse
    {
        $validated = $request->validate($this->rules());
        $validated['active'] = $validated['status'] === 'Ativa';
        $clinica->update($validated);

        return redirect()->route('gestao.clinicas.show', $clinica)
            ->with('success', 'Unidade atualizada com sucesso.');
    }

    public function destroy(Clinic $clinica): RedirectResponse
    {
        $clinica->delete();
        return redirect()->route('gestao.clinicas.index')
            ->with('success', 'Unidade excluída com sucesso.');
    }

    // -------------------------------------------------------------------------
    // Documentos
    // -------------------------------------------------------------------------

    public function storeDocument(Request $request, Clinic $clinica): RedirectResponse
    {
        $validated = $request->validate([
            'doc_type'        => 'required|string|max:100',
            'doc_name'        => 'required|string|max:255',
            'doc_file'        => 'required|file|max:5120|mimes:pdf,doc,docx,jpg,jpeg,png',
            'doc_description' => 'nullable|string|max:1000',
        ]);

        $file = $request->file('doc_file');
        $path = $file->store("clinic-documents/{$clinica->id}", 'public');

        $clinica->documents()->create([
            'type'          => $validated['doc_type'],
            'name'          => $validated['doc_name'],
            'path'          => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type'     => $file->getMimeType(),
            'size'          => $file->getSize(),
            'description'   => $validated['doc_description'] ?? null,
            'uploaded_by'   => auth()->id(),
        ]);

        return redirect()->route('gestao.clinicas.show', $clinica)
            ->with('success', 'Documento adicionado com sucesso.');
    }

    public function updateDocument(Request $request, Clinic $clinica, ClinicDocument $document): RedirectResponse
    {
        abort_if($document->clinic_id !== $clinica->id, 404);

        $validated = $request->validate([
            'doc_name'        => 'required|string|max:255',
            'doc_type'        => 'required|string|max:100',
            'doc_description' => 'nullable|string|max:1000',
            'doc_file'        => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        $data = [
            'name'        => $validated['doc_name'],
            'type'        => $validated['doc_type'],
            'description' => $validated['doc_description'],
        ];

        if ($request->hasFile('doc_file')) {
            Storage::disk('public')->delete($document->path);
            $data['path'] = $request->file('doc_file')->store('clinicas/documentos', 'public');
        }

        $document->update($data);

        return redirect()->route('gestao.clinicas.show', $clinica)
            ->with('success', 'Documento atualizado com sucesso.');
    }

    public function destroyDocument(Clinic $clinica, ClinicDocument $document): RedirectResponse
    {
        abort_if($document->clinic_id !== $clinica->id, 404);

        Storage::disk('public')->delete($document->path);
        $document->delete();

        return redirect()->route('gestao.clinicas.show', $clinica)
            ->with('success', 'Documento removido com sucesso.');
    }
}

