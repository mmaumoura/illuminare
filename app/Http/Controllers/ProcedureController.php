<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use App\Models\Procedure;
use App\Models\ProcedureCost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProcedureController extends Controller
{
    private function rules(?int $id = null): array
    {
        return [
            'name'                    => 'required|string|max:255',
            'category'                => 'required|string|max:100',
            'status'                  => 'required|in:Ativo,Inativo',
            'price'                   => 'required|numeric|min:0',
            'commission'              => 'nullable|numeric|min:0|max:100',
            'duration_minutes'        => 'required|integer|min:1',
            'sessions_recommended'    => 'nullable|integer|min:1',
            'sessions_interval_days'  => 'nullable|integer|min:0',
            'clinics'                 => 'required|array|min:1',
            'clinics.*'               => 'exists:clinics,id',
            'description'             => 'nullable|string',
            'indications'             => 'nullable|string',
            'contraindications'       => 'nullable|string',
            'products_used'           => 'nullable|string',
            'equipment_needed'        => 'nullable|string',
            'pre_care'                => 'nullable|string',
            'post_care'               => 'nullable|string',
            'costs'                   => 'nullable|array',
            'costs.*.name'            => 'required_with:costs.*|string|max:255',
            'costs.*.value'           => 'required_with:costs.*|numeric|min:0',
        ];
    }

    private function syncCosts(Procedure $procedure, array $costs): void
    {
        $procedure->costs()->delete();
        foreach ($costs as $cost) {
            if (!empty($cost['name'])) {
                $procedure->costs()->create([
                    'name'  => $cost['name'],
                    'value' => $cost['value'] ?? 0,
                ]);
            }
        }
    }

    public function index(Request $request): View
    {
        $query = Procedure::with('clinics')->orderBy('name');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        $procedures = $query->paginate(25)->withQueryString();
        return view('procedimentos.index', compact('procedures'));
    }

    public function create(): View
    {
        $clinics = Clinic::orderBy('name')->get();
        return view('procedimentos.create', compact('clinics'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->rules());
        $clinicIds = $validated['clinics'];
        $costs     = $validated['costs'] ?? [];
        unset($validated['clinics'], $validated['costs']);

        $procedure = Procedure::create($validated);
        $procedure->clinics()->sync($clinicIds);
        $this->syncCosts($procedure, $costs);

        return redirect()->route('gestao.procedimentos.show', $procedure)
            ->with('success', 'Procedimento cadastrado com sucesso.');
    }

    public function show(Procedure $procedimento): View
    {
        $procedimento->load(['clinics', 'costs']);
        return view('procedimentos.show', ['procedure' => $procedimento]);
    }

    public function edit(Procedure $procedimento): View
    {
        $clinics = Clinic::orderBy('name')->get();
        $selectedClinicIds = $procedimento->clinics->pluck('id')->toArray();
        $procedimento->load('costs');
        return view('procedimentos.edit', [
            'procedure'         => $procedimento,
            'clinics'           => $clinics,
            'selectedClinicIds' => $selectedClinicIds,
        ]);
    }

    public function update(Request $request, Procedure $procedimento): RedirectResponse
    {
        $validated = $request->validate($this->rules($procedimento->id));
        $clinicIds = $validated['clinics'];
        $costs     = $validated['costs'] ?? [];
        unset($validated['clinics'], $validated['costs']);

        $procedimento->update($validated);
        $procedimento->clinics()->sync($clinicIds);
        $this->syncCosts($procedimento, $costs);

        return redirect()->route('gestao.procedimentos.show', $procedimento)
            ->with('success', 'Procedimento atualizado com sucesso.');
    }

    public function destroy(Procedure $procedimento): RedirectResponse
    {
        $procedimento->delete();
        return redirect()->route('gestao.procedimentos.index')
            ->with('success', 'Procedimento excluído com sucesso.');
    }
}
