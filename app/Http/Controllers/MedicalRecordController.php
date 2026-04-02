<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Procedure;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MedicalRecordController extends Controller
{
    public function create(Patient $paciente): View
    {
        if ($clinicId = auth()->user()->clinicScope()) {
            abort_if($paciente->clinic_id !== $clinicId, 403);
        }

        $procedures    = Procedure::where('status', 'Ativo')->orderBy('name')->get();
        $professionals = User::orderBy('name')->get();

        return view('pacientes.prontuarios.create', [
            'paciente'      => $paciente,
            'procedures'    => $procedures,
            'professionals' => $professionals,
        ]);
    }

    public function store(Request $request, Patient $paciente): RedirectResponse
    {
        if ($clinicId = auth()->user()->clinicScope()) {
            abort_if($paciente->clinic_id !== $clinicId, 403);
        }

        $data = $request->validate([
            'record_date'     => 'required|date',
            'start_time'      => 'required|date_format:H:i',
            'end_time'        => 'nullable|date_format:H:i|after:start_time',
            'procedure_id'    => 'nullable|exists:procedures,id',
            'tooth_region'    => 'nullable|string|max:255',
            'evolution'       => 'required|string',
            'diagnosis'       => 'nullable|string',
            'treatment'       => 'nullable|string',
            'materials'       => 'nullable|string',
            'prescription'    => 'nullable|string',
            'guidelines'      => 'nullable|string',
            'next_session'    => 'nullable|date',
            'treatment_plan'  => 'nullable|string',
            'observations'    => 'nullable|string',
        ]);

        $data['patient_id']      = $paciente->id;
        $data['professional_id'] = auth()->id();

        $record = MedicalRecord::create($data);

        return redirect()->route('operacional.pacientes.prontuarios.show', [$paciente, $record])
            ->with('success', 'Prontuário criado com sucesso.');
    }

    public function show(Patient $paciente, MedicalRecord $prontuario): View
    {
        if ($clinicId = auth()->user()->clinicScope()) {
            abort_if($paciente->clinic_id !== $clinicId, 403);
        }

        abort_if($prontuario->patient_id !== $paciente->id, 404);
        $prontuario->load(['professional', 'procedure']);

        return view('pacientes.prontuarios.show', [
            'paciente'   => $paciente,
            'prontuario' => $prontuario,
        ]);
    }

    public function destroy(Patient $paciente, MedicalRecord $prontuario): RedirectResponse
    {
        if ($clinicId = auth()->user()->clinicScope()) {
            abort_if($paciente->clinic_id !== $clinicId, 403);
        }

        abort_if($prontuario->patient_id !== $paciente->id, 404);
        $prontuario->delete();

        return redirect()->route('operacional.pacientes.show', $paciente)
            ->with('success', 'Prontuário excluído.')
            ->with('active_tab', 'prontuarios');
    }
}
