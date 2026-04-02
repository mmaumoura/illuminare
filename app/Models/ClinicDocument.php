<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClinicDocument extends Model
{
    protected $fillable = [
        'clinic_id',
        'type',
        'name',
        'path',
        'original_name',
        'mime_type',
        'size',
        'description',
        'uploaded_by',
    ];

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getFormattedSizeAttribute(): string
    {
        if (!$this->size) return '—';
        $kb = $this->size / 1024;
        if ($kb < 1024) return round($kb, 1).' KB';
        return round($kb / 1024, 1).' MB';
    }
}
