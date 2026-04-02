<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleGoalEntry extends Model
{
    protected $fillable = [
        'sale_goal_id', 'data', 'valor_realizado',
        'procedimentos_realizados', 'pacientes_novos', 'notas', 'user_id',
    ];

    protected $casts = [
        'data'                     => 'date',
        'valor_realizado'          => 'decimal:2',
        'procedimentos_realizados' => 'integer',
        'pacientes_novos'          => 'integer',
    ];

    public function goal(): BelongsTo
    {
        return $this->belongsTo(SaleGoal::class, 'sale_goal_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
