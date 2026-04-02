<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Opportunity extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'opportunities';

    protected $fillable = [
        'titulo', 'descricao', 'valor', 'estagio', 'probabilidade',
        'data_fechamento_previsto', 'data_fechamento_real',
        'crm_client_id', 'lead_id', 'user_id', 'clinic_id', 'motivo_perda',
    ];

    protected $casts = [
        'data_fechamento_previsto' => 'date',
        'data_fechamento_real'     => 'date',
        'valor'                    => 'decimal:2',
        'probabilidade'            => 'integer',
    ];

    // ── Relationships ─────────────────────────────────────────────────────────

    public function crmClient()
    {
        return $this->belongsTo(CrmClient::class);
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function tasks()
    {
        return $this->morphMany(Task::class, 'taskable');
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    public function getEstagioLabelAttribute(): string
    {
        return match ($this->estagio) {
            'prospeccao'   => 'Prospecção',
            'qualificacao' => 'Qualificação',
            'proposta'     => 'Proposta',
            'negociacao'   => 'Negociação',
            'fechamento'   => 'Fechamento',
            'ganho'        => 'Ganho',
            'perdido'      => 'Perdido',
            default        => ucfirst($this->estagio),
        };
    }

    public function getEstagioColorAttribute(): string
    {
        return match ($this->estagio) {
            'prospeccao'   => 'blue',
            'qualificacao' => 'azure',
            'proposta'     => 'yellow',
            'negociacao'   => 'orange',
            'fechamento'   => 'teal',
            'ganho'        => 'green',
            'perdido'      => 'red',
            default        => 'secondary',
        };
    }

    public function getContactNameAttribute(): string
    {
        return $this->crmClient?->nome_completo ?? $this->lead?->nome_completo ?? '—';
    }
}
