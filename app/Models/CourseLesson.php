<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseLesson extends Model
{
    protected $fillable = [
        'titulo', 'descricao', 'tipo', 'arquivo_path', 'arquivo_nome',
        'arquivo_tamanho', 'link_externo', 'conteudo_texto',
        'duracao_minutos', 'ordem', 'course_id',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function getTipoLabelAttribute(): string
    {
        return match ($this->tipo) {
            'video'  => 'Vídeo',
            'link'   => 'Link Externo',
            'pdf'    => 'PDF',
            'texto'  => 'Texto',
            default  => ucfirst($this->tipo),
        };
    }

    public function getTipoColorAttribute(): string
    {
        return match ($this->tipo) {
            'video'  => 'purple',
            'link'   => 'blue',
            'pdf'    => 'red',
            'texto'  => 'teal',
            default  => 'secondary',
        };
    }

    public function getDuracaoFormattedAttribute(): string
    {
        if (! $this->duracao_minutos) {
            return '—';
        }
        $h = intdiv($this->duracao_minutos, 60);
        $m = $this->duracao_minutos % 60;
        if ($h > 0 && $m > 0) {
            return "{$h}h {$m}min";
        }
        if ($h > 0) {
            return "{$h}h";
        }
        return "{$m}min";
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
