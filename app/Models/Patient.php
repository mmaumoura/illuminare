<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'clinic_id',
        'name', 'cpf', 'birth_date', 'email', 'phone',
        'cep', 'street', 'number', 'complement', 'neighborhood', 'city', 'state',
        'medical_history', 'allergies', 'current_medications',
        'emergency_contact_name', 'emergency_contact_phone',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(PatientDocument::class);
    }

    public function anamneses(): HasMany
    {
        return $this->hasMany(Anamnesis::class);
    }

    public function medicalRecords(): HasMany
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(PatientPhoto::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(PatientContract::class);
    }

    public function getFormattedBirthDateAttribute(): string
    {
        return $this->birth_date?->format('d/m/Y') ?? 'N\u00e3o informado';
    }

    public function getAgeAttribute(): ?int
    {
        return $this->birth_date?->age;
    }

    public function getFormattedCpfAttribute(): string
    {
        return $this->cpf ?? 'N\u00e3o informado';
    }
}
