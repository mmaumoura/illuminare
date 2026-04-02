<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clinic extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'cnpj', 'phone', 'email', 'active', 'status',
        'cep', 'street', 'number', 'complement', 'neighborhood', 'city', 'state',
        'rep_name', 'rep_cpf', 'rep_phone', 'rep_email',
        'contract_start', 'contract_end', 'contract_notes',
    ];

    protected $casts = [
        'active'         => 'boolean',
        'contract_start' => 'date',
        'contract_end'   => 'date',
    ];

    public function patients(): HasMany
    {
        return $this->hasMany(Patient::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ClinicDocument::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function procedures(): BelongsToMany
    {
        return $this->belongsToMany(Procedure::class, 'clinic_procedure');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'clinic_product');
    }
}
