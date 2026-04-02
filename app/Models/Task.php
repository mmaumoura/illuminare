<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'titulo', 'descricao', 'tipo', 'prioridade', 'status',
        'data_vencimento', 'concluida_em',
        'user_id', 'assigned_by_id', 'taskable_type', 'taskable_id', 'clinic_id',
    ];

    protected $casts = [
        'data_vencimento' => 'datetime',
        'concluida_em'    => 'datetime',
    ];

    // ── Relationships ─────────────────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by_id');
    }

    public function taskable()
    {
        return $this->morphTo();
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    public function getTipoLabelAttribute(): string
    {
        return match ($this->tipo) {
            'ligacao'    => 'Ligação',
            'email'      => 'E-mail',
            'reuniao'    => 'Reunião',
            'follow_up'  => 'Follow-up',
            'outro'      => 'Outro',
            default      => ucfirst($this->tipo),
        };
    }

    public function getPrioridadeLabelAttribute(): string
    {
        return match ($this->prioridade) {
            'baixa'   => 'Baixa',
            'media'   => 'Média',
            'alta'    => 'Alta',
            'urgente' => 'Urgente',
            default   => ucfirst($this->prioridade),
        };
    }

    public function getPrioridadeColorAttribute(): string
    {
        return match ($this->prioridade) {
            'baixa'   => 'secondary',
            'media'   => 'blue',
            'alta'    => 'orange',
            'urgente' => 'red',
            default   => 'secondary',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pendente'     => 'Pendente',
            'em_andamento' => 'Em Andamento',
            'concluida'    => 'Concluída',
            'cancelada'    => 'Cancelada',
            default        => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pendente'     => 'yellow',
            'em_andamento' => 'blue',
            'concluida'    => 'green',
            'cancelada'    => 'red',
            default        => 'secondary',
        };
    }

    public function getIsAtrasadaAttribute(): bool
    {
        return $this->data_vencimento
            && $this->data_vencimento->isPast()
            && ! in_array($this->status, ['concluida', 'cancelada']);
    }
}
