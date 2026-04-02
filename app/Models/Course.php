<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'titulo', 'descricao', 'thumbnail_path', 'instrutor',
        'carga_horaria', 'status', 'clinic_id', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function lessons()
    {
        return $this->hasMany(CourseLesson::class)->orderBy('ordem');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'rascunho'  => 'Rascunho',
            'publicado' => 'Publicado',
            'arquivado' => 'Arquivado',
            default     => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'rascunho'  => 'yellow',
            'publicado' => 'green',
            'arquivado' => 'secondary',
            default     => 'secondary',
        };
    }

    public function getCargaHorariaFormattedAttribute(): string
    {
        if (! $this->carga_horaria) {
            return '—';
        }
        $h = intdiv($this->carga_horaria, 60);
        $m = $this->carga_horaria % 60;
        if ($h > 0 && $m > 0) {
            return "{$h}h {$m}min";
        }
        if ($h > 0) {
            return "{$h}h";
        }
        return "{$m}min";
    }
}
