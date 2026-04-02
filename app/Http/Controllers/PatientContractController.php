<?php

namespace App\Http\Controllers;

use App\Models\ContractTemplate;
use App\Models\Patient;
use App\Models\PatientContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PatientContractController extends Controller
{
    public function store(Request $request, Patient $paciente): RedirectResponse
    {
        $data = $request->validate([
            'contract_template_id' => 'required|exists:contract_templates,id',
        ]);

        $template = ContractTemplate::findOrFail($data['contract_template_id']);
        $clinic   = $paciente->clinic;

        $rendered = $template->render($paciente, $clinic);

        PatientContract::create([
            'patient_id'           => $paciente->id,
            'contract_template_id' => $template->id,
            'title'                => $template->title,
            'type'                 => $template->type,
            'content'              => $rendered,
        ]);

        return redirect()->route('operacional.pacientes.show', $paciente)
            ->with('success', 'Contrato gerado com sucesso.')
            ->with('active_tab', 'contratos');
    }

    public function show(Patient $paciente, PatientContract $contrato): View
    {
        abort_if($contrato->patient_id !== $paciente->id, 404);

        return view('pacientes.contratos.show', [
            'paciente' => $paciente,
            'contrato' => $contrato,
        ]);
    }

    public function destroy(Patient $paciente, PatientContract $contrato): RedirectResponse
    {
        abort_if($contrato->patient_id !== $paciente->id, 404);

        $contrato->delete();

        return redirect()->route('operacional.pacientes.show', $paciente)
            ->with('success', 'Contrato excluído.')
            ->with('active_tab', 'contratos');
    }
}
