<?php

namespace App\Http\Controllers;

use App\Models\Anamnesis;
use App\Models\Patient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnamnesisController extends Controller
{
    public function create(Patient $paciente): View
    {
        if ($clinicId = auth()->user()->clinicScope()) {
            abort_if($paciente->clinic_id !== $clinicId, 403);
        }

        return view('pacientes.anamneses.create', ['paciente' => $paciente]);
    }

    public function store(Request $request, Patient $paciente): RedirectResponse
    {
        if ($clinicId = auth()->user()->clinicScope()) {
            abort_if($paciente->clinic_id !== $clinicId, 403);
        }

        $data = $request->validate([
            'anamnesis_date'            => 'required|date',
            'chief_complaint'           => 'nullable|string',
            'current_history'           => 'nullable|string',
            'treatment_objective'       => 'nullable|string',
            'last_dental_visit'         => 'nullable|string|max:255',
            'brushing_frequency'        => 'nullable|string|max:255',
            'uses_dental_floss'         => 'nullable|boolean',
            'gum_bleeding'              => 'nullable|boolean',
            'tooth_sensitivity'         => 'nullable|boolean',
            'bruxism'                   => 'nullable|boolean',
            'tmj_pain'                  => 'nullable|boolean',
            'dental_treatments_history' => 'nullable|string',
            'personal_history'          => 'nullable|string',
            'family_history'            => 'nullable|string',
            'chronic_diseases'          => 'nullable|string',
            'has_diabetes'              => 'nullable|boolean',
            'has_hypertension'          => 'nullable|boolean',
            'has_heart_disease'         => 'nullable|boolean',
            'has_blood_disorders'       => 'nullable|boolean',
            'has_hepatitis'             => 'nullable|boolean',
            'has_hiv'                   => 'nullable|boolean',
            'previous_surgeries'        => 'nullable|string',
            'current_medications'       => 'nullable|string',
            'allergies'                 => 'nullable|string',
            'anesthetic_allergy'        => 'nullable|boolean',
            'latex_allergy'             => 'nullable|boolean',
            'penicillin_allergy'        => 'nullable|boolean',
            'smoker'                    => 'nullable|boolean',
            'smoker_details'            => 'nullable|string|max:255',
            'alcohol'                   => 'nullable|boolean',
            'alcohol_details'           => 'nullable|string|max:255',
            'exercises'                 => 'nullable|boolean',
            'exercise_details'          => 'nullable|string|max:255',
            'sleep_quality'             => 'nullable|string|max:100',
            'diet'                      => 'nullable|string|max:100',
            'water_intake'              => 'nullable|string|max:100',
            'menstrual_cycle'           => 'nullable|string|max:255',
            'pregnancies'               => 'nullable|string|max:255',
            'pregnant'                  => 'nullable|boolean',
            'breastfeeding'             => 'nullable|boolean',
            'oral_hygiene_level'        => 'nullable|string|max:100',
            'soft_tissue_exam'          => 'nullable|string',
            'hard_tissue_exam'          => 'nullable|string',
            'periodontal_status'        => 'nullable|string|max:100',
            'occlusion'                 => 'nullable|string',
            'observations'              => 'nullable|string',
            'signature_data'            => 'nullable|string',
        ]);

        $data['patient_id']      = $paciente->id;
        $data['professional_id'] = auth()->id();
        $data['filled_by']       = 'profissional';
        $data['filled_at']       = now();

        $status = 'completa';
        if ($request->input('save_draft')) {
            $status = 'rascunho';
        } elseif (empty($data['signature_data'])) {
            $status = 'pendente_assinatura';
        }
        $data['status'] = $status;

        if (!empty($data['signature_data'])) {
            $data['signed_at'] = now();
        }

        $anamnesis = Anamnesis::create($data);

        return redirect()->route('operacional.pacientes.anamneses.show', [$paciente, $anamnesis])
            ->with('success', 'Ficha de anamnese criada com sucesso.');
    }

    public function generatePublicLink(Patient $paciente): RedirectResponse
    {
        if ($clinicId = auth()->user()->clinicScope()) {
            abort_if($paciente->clinic_id !== $clinicId, 403);
        }

        $anamnese = Anamnesis::create([
            'patient_id'      => $paciente->id,
            'professional_id' => auth()->id(),
            'anamnesis_date'  => today(),
            'status'          => 'rascunho',
            'filled_by'       => 'paciente',
        ]);

        return redirect()
            ->route('operacional.pacientes.show', $paciente)
            ->with('public_fill_link', route('anamnese.public.fill', $anamnese->token))
            ->with('active_tab', 'anamneses');
    }

    public function show(Patient $paciente, Anamnesis $anamnese): View
    {
        if ($clinicId = auth()->user()->clinicScope()) {
            abort_if($paciente->clinic_id !== $clinicId, 403);
        }

        abort_if($anamnese->patient_id !== $paciente->id, 404);
        $anamnese->load('professional');

        return view('pacientes.anamneses.show', [
            'paciente'  => $paciente,
            'anamnese'  => $anamnese,
        ]);
    }

    public function destroy(Patient $paciente, Anamnesis $anamnese): RedirectResponse
    {
        if ($clinicId = auth()->user()->clinicScope()) {
            abort_if($paciente->clinic_id !== $clinicId, 403);
        }

        abort_if($anamnese->patient_id !== $paciente->id, 404);
        $anamnese->delete();

        return redirect()->route('operacional.pacientes.show', $paciente)
            ->with('success', 'Ficha de anamnese excluída.')
            ->with('active_tab', 'anamneses');
    }
}
