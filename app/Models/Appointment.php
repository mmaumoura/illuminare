<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'type', 'title', 'description',
        'starts_at', 'ends_at',
        'patient_id', 'professional_id', 'clinic_id',
        'status', 'color', 'observations',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at'   => 'datetime',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function professional(): BelongsTo
    {
        return $this->belongsTo(User::class, 'professional_id');
    }

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class);
    }

    public function procedures(): BelongsToMany
    {
        return $this->belongsToMany(Procedure::class, 'appointment_procedure');
    }

    // -------------------------------------------------------------------------
    // Accessors
    // -------------------------------------------------------------------------

    public function getDurationLabelAttribute(): string
    {
        if (!$this->starts_at || !$this->ends_at) {
            return '—';
        }
        $diff = (int) $this->starts_at->diffInMinutes($this->ends_at);
        if ($diff <= 0) return '—';
        if ($diff < 60) return "{$diff} minutos";
        $h = intdiv($diff, 60);
        $m = $diff % 60;
        return $m ? "{$h}h {$m}min" : "{$h}h";
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'Confirmado' => 'success',
            'Realizado'  => 'primary',
            'Cancelado'  => 'danger',
            'Falta'      => 'warning',
            default      => 'secondary', // Agendado
        };
    }

    public function getTypeColorAttribute(): string
    {
        return match ($this->type) {
            'Agendamento de Paciente' => 'blue',
            'Agendamento Interno'     => 'green',
            'Bloqueio de Agenda'      => 'red',
            default                   => 'secondary',
        };
    }
}
