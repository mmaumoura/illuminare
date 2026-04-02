<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    protected $fillable = [
        'titulo', 'descricao', 'arquivo_path', 'arquivo_nome',
        'arquivo_tamanho', 'mime_type', 'tags', 'image_folder_id', 'clinic_id', 'user_id',
    ];

    public function folder()
    {
        return $this->belongsTo(ImageFolder::class, 'image_folder_id');
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTagsArrayAttribute(): array
    {
        if (! $this->tags) {
            return [];
        }
        return array_filter(array_map('trim', explode(',', $this->tags)));
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
