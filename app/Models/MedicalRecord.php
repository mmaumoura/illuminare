<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalRecord extends Model
{
    protected $fillable = [
        'patient_id', 'professional_id', 'record_date', 'start_time', 'end_time',
        'procedure_id', 'tooth_region', 'evolution', 'diagnosis', 'treatment',
        'materials', 'prescription', 'guidelines', 'next_session',
        'treatment_plan', 'observations',
    ];

    protected $casts = [
        'record_date'  => 'date',
        'next_session' => 'date',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function professional(): BelongsTo
    {
        return $this->belongsTo(User::class, 'professional_id');
    }

    public function procedure(): BelongsTo
    {
        return $this->belongsTo(Procedure::class);
    }
}
