<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome_completo', 'email', 'telefone', 'empresa', 'cargo',
        'status', 'origem', 'observacoes', 'valor_estimado',
        'user_id', 'clinic_id', 'crm_client_id', 'data_contato', 'convertido_em',
    ];

    protected $casts = [
        'data_contato'  => 'date',
        'convertido_em' => 'datetime',
        'valor_estimado'=> 'decimal:2',
    ];

    // ── Relationships ─────────────────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function crmClient()
    {
        return $this->belongsTo(CrmClient::class);
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

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'novo'        => 'Novo',
            'contatado'   => 'Contatado',
            'qualificado' => 'Qualificado',
            'convertido'  => 'Convertido',
            'perdido'     => 'Perdido',
            default       => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'novo'        => 'blue',
            'contatado'   => 'azure',
            'qualificado' => 'yellow',
            'convertido'  => 'green',
            'perdido'     => 'red',
            default       => 'secondary',
        };
    }

    public function getOrigemLabelAttribute(): string
    {
        return match ($this->origem) {
            'site'          => 'Site',
            'indicacao'     => 'Indicação',
            'redes_sociais' => 'Redes Sociais',
            'evento'        => 'Evento',
            'ligacao'       => 'Ligação',
            'email'         => 'E-mail',
            'outro'         => 'Outro',
            default         => ucfirst($this->origem),
        };
    }

    public function getTelefoneFormatadoAttribute(): string
    {
        if (! $this->telefone) return '';
        $t = preg_replace('/\D/', '', $this->telefone);
        if (strlen($t) === 11) {
            return '(' . substr($t, 0, 2) . ') ' . substr($t, 2, 5) . '-' . substr($t, 7, 4);
        }
        if (strlen($t) === 10) {
            return '(' . substr($t, 0, 2) . ') ' . substr($t, 2, 4) . '-' . substr($t, 6, 4);
        }
        return $this->telefone;
    }
}
