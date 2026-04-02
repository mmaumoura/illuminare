<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'avatar',
        'password',
        'role_id',
        'clinic_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // -------------------------------------------------------------------------
    // Relacionamentos
    // -------------------------------------------------------------------------

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class);
    }

    public function setting(): HasOne
    {
        return $this->hasOne(UserSetting::class);
    }

    // -------------------------------------------------------------------------
    // Helpers de Role
    // -------------------------------------------------------------------------

    public function hasRole(RoleEnum|string $role): bool
    {
        $slug = $role instanceof RoleEnum ? $role->value : $role;

        return $this->role?->slug === $slug;
    }

    public function hasAnyRole(array $roles): bool
    {
        $slugs = array_map(
            fn ($r) => $r instanceof RoleEnum ? $r->value : $r,
            $roles
        );

        return in_array($this->role?->slug, $slugs, true);
    }

    public function isAdministrador(): bool
    {
        return $this->hasRole(RoleEnum::Administrador);
    }

    public function isGestor(): bool
    {
        return $this->hasRole(RoleEnum::Gestor);
    }

    public function isColaborador(): bool
    {
        return $this->hasRole(RoleEnum::Colaborador);
    }

    public function isFranqueado(): bool
    {
        return $this->hasRole(RoleEnum::Franqueado);
    }

    /**
     * Returns the clinic_id this user is restricted to.
     * Franqueados and Colaboradores always see only their own clinic.
     * Administradores and Gestores see the session-selected clinic, or all (null).
     */
    public function clinicScope(): ?int
    {
        if ($this->isFranqueado() || $this->isColaborador()) {
            return $this->clinic_id;
        }

        // Admin/Gestor: respect the global clinic selector stored in session
        $sessionClinic = session('active_clinic_id');

        return $sessionClinic ? (int) $sessionClinic : null;
    }

    // -------------------------------------------------------------------------
    // Helpers de Permission
    // -------------------------------------------------------------------------

    public function hasPermission(string $slug): bool
    {
        return $this->role?->hasPermission($slug) ?? false;
    }
}
