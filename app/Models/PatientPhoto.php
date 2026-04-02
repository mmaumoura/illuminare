<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientPhoto extends Model
{
    protected $fillable = [
        'patient_id', 'title', 'photo_date', 'type', 'region',
        'visible_to_patient', 'file_path', 'description', 'uploaded_by',
    ];

    protected $casts = [
        'photo_date'         => 'date',
        'visible_to_patient' => 'boolean',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
