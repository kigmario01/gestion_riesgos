<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'activo',
        'alias',
        'avatar',
        'intentos_fallidos',
        'bloqueado_hasta',
        'ultimo_acceso',
    ];

    public function getDisplayNameAttribute(): string
    {
        return $this->alias ?: $this->name;
    }

    public function getAvatarUrlAttribute(): ?string
    {
        return $this->avatar ? asset('storage/' . $this->avatar) : null;
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'bloqueado_hasta' => 'datetime',
            'ultimo_acceso' => 'datetime',
            'activo' => 'boolean',
        ];
    }
}
