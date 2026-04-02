<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrmClient extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'crm_clients';

    protected $fillable = [
        'nome_completo', 'email', 'telefone', 'data_nascimento', 'cpf',
        'tipo', 'clinic_id', 'cep', 'logradouro', 'numero', 'complemento',
        'bairro', 'cidade', 'estado', 'observacoes',
    ];

    protected $casts = [
        'data_nascimento' => 'date',
    ];

    // ── Relationships ─────────────────────────────────────────────────────────

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    public function opportunities()
    {
        return $this->hasMany(Opportunity::class);
    }

    public function tasks()
    {
        return $this->morphMany(Task::class, 'taskable');
    }

    // ── Accessors ─────────────────────────────────────────────────────────────

    public function getCpfFormatadoAttribute(): ?string
    {
        if (! $this->cpf) return null;
        $c = preg_replace('/\D/', '', $this->cpf);
        if (strlen($c) !== 11) return $this->cpf;
        return substr($c, 0, 3) . '.' . substr($c, 3, 3) . '.' . substr($c, 6, 3) . '-' . substr($c, 9, 2);
    }

    public function getTipoLabelAttribute(): string
    {
        return match ($this->tipo) {
            'cliente' => 'Cliente',
            'lead'    => 'Lead',
            default   => ucfirst($this->tipo),
        };
    }

    public function getTipoColorAttribute(): string
    {
        return match ($this->tipo) {
            'cliente' => 'success',
            'lead'    => 'blue',
            default   => 'secondary',
        };
    }

    public function getEnderecoCompletoAttribute(): string
    {
        $parts = array_filter([
            $this->logradouro,
            $this->numero,
            $this->complemento,
            $this->bairro,
            $this->cidade && $this->estado ? "{$this->cidade}/{$this->estado}" : ($this->cidade ?? $this->estado),
        ]);
        return implode(', ', $parts);
    }
}
