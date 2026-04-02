<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSetting extends Model
{
    protected $fillable = [
        'user_id',
        'theme',
        'theme_primary',
        'theme_base',
        'theme_font',
        'theme_radius',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
