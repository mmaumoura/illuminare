<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Aviso extends Model
{
    protected $fillable = [
        'user_id', 'title', 'type', 'content',
        'attachment_path', 'attachment_name',
        'priority', 'expires_at', 'is_pinned',
    ];

    protected $casts = [
        'expires_at' => 'date',
        'is_pinned'  => 'boolean',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function recipients(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'aviso_recipient')
            ->withPivot('read_at')
            ->withTimestamps();
    }

    public function isReadBy(User $user): bool
    {
        return $this->recipients()
            ->where('user_id', $user->id)
            ->whereNotNull('aviso_recipient.read_at')
            ->exists();
    }

    public function priorityLabel(): string
    {
        return match($this->priority) {
            'baixa'   => 'Baixa',
            'normal'  => 'Normal',
            'alta'    => 'Alta',
            'urgente' => 'Urgente',
            default   => $this->priority,
        };
    }

    public function priorityColor(): string
    {
        return match($this->priority) {
            'baixa'   => 'success',
            'normal'  => 'info',
            'alta'    => 'warning',
            'urgente' => 'danger',
            default   => 'secondary',
        };
    }
}
