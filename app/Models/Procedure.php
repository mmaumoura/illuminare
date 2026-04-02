<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Procedure extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'category', 'price', 'commission', 'duration_minutes',
        'sessions_recommended', 'sessions_interval_days',
        'status', 'description', 'indications', 'contraindications',
        'products_used', 'equipment_needed', 'pre_care', 'post_care',
    ];

    protected $casts = [
        'price'      => 'decimal:2',
        'commission' => 'decimal:2',
    ];

    public function clinics(): BelongsToMany
    {
        return $this->belongsToMany(Clinic::class, 'clinic_procedure');
    }

    public function costs(): HasMany
    {
        return $this->hasMany(ProcedureCost::class)->orderBy('id');
    }

    public function getDurationLabelAttribute(): string
    {
        if (!$this->duration_minutes) return '—';
        if ($this->duration_minutes < 60) return $this->duration_minutes . 'min';
        $h = intdiv($this->duration_minutes, 60);
        $m = $this->duration_minutes % 60;
        return $m ? "{$h}h{$m}min" : "{$h}h";
    }
}
