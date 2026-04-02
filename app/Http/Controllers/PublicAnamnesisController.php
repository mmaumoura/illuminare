<?php

namespace App\Http\Controllers;

use App\Models\Anamnesis;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicAnamnesisController extends Controller
{
    public function fill(string $token): View
    {
        $anamnese = Anamnesis::where('token', $token)
            ->with('patient')
            ->firstOrFail();

        return view('anamneses.public-fill', ['anamnese' => $anamnese]);
    }

    public function submitFill(Request $request, string $token): RedirectResponse
    {
        $anamnese = Anamnesis::where('token', $token)->firstOrFail();

        $data = $request->validate([
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

        $data['filled_by'] = 'paciente';
        $data['filled_at'] = now();
        $data['status']    = empty($data['signature_data']) ? 'pendente_assinatura' : 'completa';

        if (!empty($data['signature_data'])) {
            $data['signed_at'] = now();
        }

        $anamnese->update($data);

        return redirect()->route('anamnese.public.obrigado', $token);
    }

    public function thanks(string $token): View
    {
        $anamnese = Anamnesis::where('token', $token)->firstOrFail();
        return view('anamneses.public-thanks', ['anamnese' => $anamnese]);
    }

    public function signature(string $token): View
    {
        $anamnese = Anamnesis::where('signature_token', $token)
            ->with('patient')
            ->firstOrFail();

        return view('anamneses.public-signature', ['anamnese' => $anamnese]);
    }

    public function submitSignature(Request $request, string $token): RedirectResponse
    {
        $anamnese = Anamnesis::where('signature_token', $token)->firstOrFail();

        $request->validate([
            'signature_data' => 'required|string',
        ]);

        $anamnese->update([
            'signature_data' => $request->input('signature_data'),
            'signed_at'      => now(),
            'status'         => 'completa',
        ]);

        return redirect()->route('anamnese.assinatura', $token)
            ->with('success', 'Assinatura registrada com sucesso!');
    }
}
