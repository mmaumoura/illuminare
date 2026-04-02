<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProcedureCost extends Model
{
    protected $fillable = ['procedure_id', 'name', 'value'];

    protected $casts = [
        'value' => 'decimal:2',
    ];

    public function procedure(): BelongsTo
    {
        return $this->belongsTo(Procedure::class);
    }
}
