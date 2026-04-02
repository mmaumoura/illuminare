<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $fillable = [
        'titulo', 'descricao', 'tipo', 'arquivo_path', 'arquivo_nome',
        'arquivo_tamanho', 'conteudo_texto', 'training_folder_id', 'clinic_id', 'user_id',
    ];

    public function folder()
    {
        return $this->belongsTo(TrainingFolder::class, 'training_folder_id');
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTipoLabelAttribute(): string
    {
        return match ($this->tipo) {
            'pdf'    => 'PDF',
            'texto'  => 'Texto',
            'imagem' => 'Imagem',
            default  => ucfirst($this->tipo),
        };
    }

    public function getTipoColorAttribute(): string
    {
        return match ($this->tipo) {
            'pdf'    => 'red',
            'texto'  => 'blue',
            'imagem' => 'green',
            default  => 'secondary',
        };
    }

    public function getTipoIconAttribute(): string
    {
        return match ($this->tipo) {
            'pdf'    => 'file-type-pdf',
            'texto'  => 'file-text',
            'imagem' => 'photo',
            default  => 'file',
        };
    }

    public function getFileSizeFormattedAttribute(): string
    {
        if (! $this->arquivo_tamanho) {
            return '—';
        }
        $kb = $this->arquivo_tamanho / 1024;
        if ($kb < 1024) {
            return round($kb, 1) . ' KB';
        }
        return round($kb / 1024, 1) . ' MB';
    }
}
