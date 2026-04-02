<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code', 'name', 'category', 'brand', 'supplier',
        'cost_price', 'sale_price', 'stock_current', 'stock_minimum',
        'description', 'image_path', 'controls_stock', 'status',
    ];

    protected $casts = [
        'cost_price'     => 'decimal:2',
        'sale_price'     => 'decimal:2',
        'controls_stock' => 'boolean',
    ];

    public function clinics(): BelongsToMany
    {
        return $this->belongsToMany(Clinic::class, 'clinic_product');
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    public function getProfitMarginAttribute(): ?float
    {
        if (!$this->cost_price || $this->cost_price == 0) return null;
        return (($this->sale_price - $this->cost_price) / $this->cost_price) * 100;
    }

    public function getIsLowStockAttribute(): bool
    {
        return $this->controls_stock && $this->stock_current <= $this->stock_minimum;
    }
}
