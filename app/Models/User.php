<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'ativo'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'ativo' => 'boolean'
    ];

    // Controle de acesso ao Filament
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->ativo && in_array($this->role, ['admin', 'organizador', 'visualizador']);
    }

    // Métodos de permissão
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isOrganizador(): bool
    {
        return $this->role === 'organizador';
    }

    public function podeEditar(): bool
    {
        return in_array($this->role, ['admin', 'organizador']);
    }
}