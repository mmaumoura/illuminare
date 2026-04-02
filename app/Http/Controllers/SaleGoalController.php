<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use App\Models\SaleGoal;
use App\Models\SaleGoalEntry;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SaleGoalController extends Controller
{
    private function rules(): array
    {
        return [
            'titulo'               => 'required|string|max:255',
            'descricao'            => 'nullable|string',
            'tipo'                 => 'required|in:diaria,semanal,mensal,trimestral,anual',
            'meta_valor'           => 'nullable|numeric|min:0',
            'meta_procedimentos'   => 'nullable|integer|min:0',
            'meta_pacientes_novos' => 'nullable|integer|min:0',
            'periodo_inicio'       => 'required|date',
            'periodo_fim'          => 'required|date|after_or_equal:periodo_inicio',
            'status'               => 'required|in:ativa,concluida,cancelada',
            'clinic_id'            => 'nullable|exists:clinics,id',
            'responsavel_id'       => 'nullable|exists:users,id',
        ];
    }

    public function index(Request $request): View
    {
        $query = SaleGoal::with(['clinic', 'responsavel', 'entries'])->orderByDesc('periodo_inicio');

        if ($search = $request->input('search')) {
            $query->where('titulo', 'like', "%{$search}%");
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $goals = $query->paginate(20)->withQueryString();
        return view('metas.index', compact('goals'));
    }

    public function create(): View
    {
        $clinics    = Clinic::orderBy('name')->get();
        $usuarios   = User::orderBy('name')->get();
        return view('metas.create', compact('clinics', 'usuarios'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());
        SaleGoal::create($validated);

        return redirect()->route('comercial.metas.index')
            ->with('success', 'Meta cadastrada com sucesso.');
    }

    public function show(SaleGoal $meta): View
    {
        $meta->load(['clinic', 'responsavel', 'entries.user']);
        $entries = $meta->entries()->orderByDesc('data')->get();
        $today   = \Carbon\Carbon::today()->toDateString();
        $todayEntry = $meta->entries()->where('data', $today)->first();

        return view('metas.show', compact('meta', 'entries', 'todayEntry'));
    }

    public function edit(SaleGoal $meta): View
    {
        $clinics  = Clinic::orderBy('name')->get();
        $usuarios = User::orderBy('name')->get();
        return view('metas.edit', compact('meta', 'clinics', 'usuarios'));
    }

    public function update(Request $request, SaleGoal $meta): RedirectResponse
    {
        $validated = $request->validate($this->rules());
        $meta->update($validated);

        return redirect()->route('comercial.metas.show', $meta)
            ->with('success', 'Meta atualizada com sucesso.');
    }

    public function destroy(SaleGoal $meta): RedirectResponse
    {
        $meta->delete();
        return redirect()->route('comercial.metas.index')
            ->with('success', 'Meta excluída.');
    }

    // ── Daily entry ───────────────────────────────────────────────────────────

    public function storeEntry(Request $request, SaleGoal $meta): RedirectResponse
    {
        $validated = $request->validate([
            'data'                     => 'required|date',
            'valor_realizado'          => 'nullable|numeric|min:0',
            'procedimentos_realizados' => 'nullable|integer|min:0',
            'pacientes_novos'          => 'nullable|integer|min:0',
            'notas'                    => 'nullable|string|max:1000',
        ]);

        $validated['sale_goal_id'] = $meta->id;
        $validated['user_id']      = Auth::id();

        SaleGoalEntry::updateOrCreate(
            ['sale_goal_id' => $meta->id, 'data' => $validated['data']],
            $validated
        );

        return redirect()->route('comercial.metas.show', $meta)
            ->with('success', 'Registro salvo.');
    }

    public function destroyEntry(SaleGoal $meta, SaleGoalEntry $registro): RedirectResponse
    {
        $registro->delete();
        return redirect()->route('comercial.metas.show', $meta)
            ->with('success', 'Registro excluído.');
    }
}
