<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Anamnesis extends Model
{
    protected $table = 'anamneses';

    protected $fillable = [
        'patient_id', 'professional_id', 'token', 'signature_token',
        'status', 'filled_by', 'filled_at',
        'anamnesis_date', 'chief_complaint', 'current_history', 'treatment_objective',
        'last_dental_visit', 'brushing_frequency', 'uses_dental_floss',
        'gum_bleeding', 'tooth_sensitivity', 'bruxism', 'tmj_pain',
        'dental_treatments_history',
        'personal_history', 'family_history', 'chronic_diseases',
        'has_diabetes', 'has_hypertension', 'has_heart_disease',
        'has_blood_disorders', 'has_hepatitis', 'has_hiv',
        'previous_surgeries', 'current_medications', 'allergies',
        'anesthetic_allergy', 'latex_allergy', 'penicillin_allergy',
        'smoker', 'smoker_details', 'alcohol', 'alcohol_details',
        'exercises', 'exercise_details', 'sleep_quality', 'diet', 'water_intake',
        'menstrual_cycle', 'pregnancies', 'pregnant', 'breastfeeding',
        'oral_hygiene_level', 'soft_tissue_exam', 'hard_tissue_exam',
        'periodontal_status', 'occlusion',
        'observations', 'signature_data', 'signed_at',
    ];

    protected $casts = [
        'anamnesis_date'   => 'date',
        'filled_at'        => 'datetime',
        'signed_at'        => 'datetime',
        'uses_dental_floss'  => 'boolean',
        'gum_bleeding'       => 'boolean',
        'tooth_sensitivity'  => 'boolean',
        'bruxism'            => 'boolean',
        'tmj_pain'           => 'boolean',
        'has_diabetes'       => 'boolean',
        'has_hypertension'   => 'boolean',
        'has_heart_disease'  => 'boolean',
        'has_blood_disorders' => 'boolean',
        'has_hepatitis'      => 'boolean',
        'has_hiv'            => 'boolean',
        'anesthetic_allergy' => 'boolean',
        'latex_allergy'      => 'boolean',
        'penicillin_allergy' => 'boolean',
        'smoker'             => 'boolean',
        'alcohol'            => 'boolean',
        'exercises'          => 'boolean',
        'pregnant'           => 'boolean',
        'breastfeeding'      => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $anamnesis) {
            $anamnesis->token           = $anamnesis->token ?: Str::random(64);
            $anamnesis->signature_token = $anamnesis->signature_token ?: Str::random(64);
        });
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function professional(): BelongsTo
    {
        return $this->belongsTo(User::class, 'professional_id');
    }
}
