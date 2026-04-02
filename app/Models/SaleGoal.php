<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SaleGoal extends Model
{
    protected $fillable = [
        'titulo', 'descricao', 'tipo', 'meta_valor', 'meta_procedimentos',
        'meta_pacientes_novos', 'periodo_inicio', 'periodo_fim',
        'status', 'clinic_id', 'responsavel_id',
    ];

    protected $casts = [
        'periodo_inicio'      => 'date',
        'periodo_fim'         => 'date',
        'meta_valor'          => 'decimal:2',
        'meta_procedimentos'  => 'integer',
        'meta_pacientes_novos'=> 'integer',
    ];

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class);
    }

    public function responsavel(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsavel_id');
    }

    public function entries(): HasMany
    {
        return $this->hasMany(SaleGoalEntry::class, 'sale_goal_id')->orderBy('data');
    }

    // ── Accessors ──────────────────────────────────────────────

    public function getTipoLabelAttribute(): string
    {
        return [
            'diaria'      => 'Diária',
            'semanal'     => 'Semanal',
            'mensal'      => 'Mensal',
            'trimestral'  => 'Trimestral',
            'anual'       => 'Anual',
        ][$this->tipo] ?? $this->tipo;
    }

    public function getStatusLabelAttribute(): string
    {
        return [
            'ativa'     => 'Ativa',
            'concluida' => 'Concluída',
            'cancelada' => 'Cancelada',
        ][$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute(): string
    {
        return [
            'ativa'     => 'success',
            'concluida' => 'primary',
            'cancelada' => 'secondary',
        ][$this->status] ?? 'secondary';
    }

    // ── Computed progress ──────────────────────────────────────

    public function getValorRealizadoAttribute(): float
    {
        return (float) $this->entries->sum('valor_realizado');
    }

    public function getProcedimentosRealizadosAttribute(): int
    {
        return (int) $this->entries->sum('procedimentos_realizados');
    }

    public function getPacientesNovosRealizadosAttribute(): int
    {
        return (int) $this->entries->sum('pacientes_novos');
    }

    public function getProgressoValorAttribute(): float
    {
        if (!$this->meta_valor || $this->meta_valor == 0) return 0;
        return min(100, round(($this->valor_realizado / $this->meta_valor) * 100, 1));
    }

    public function getProgressoProcedimentosAttribute(): float
    {
        if (!$this->meta_procedimentos || $this->meta_procedimentos == 0) return 0;
        return min(100, round(($this->procedimentos_realizados / $this->meta_procedimentos) * 100, 1));
    }

    public function getProgressoPacientesAttribute(): float
    {
        if (!$this->meta_pacientes_novos || $this->meta_pacientes_novos == 0) return 0;
        return min(100, round(($this->pacientes_novos_realizados / $this->meta_pacientes_novos) * 100, 1));
    }
}
