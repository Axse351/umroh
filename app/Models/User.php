<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'jamaah_id', // ← tambah ini
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    // ─── Relasi ──────────────────────────────────────────────────────────────

    public function jamaah()
    {
        return $this->belongsTo(Jamaah::class);
    }

    // ─── Role helpers ─────────────────────────────────────────────────────────

    public function isAdmin(): bool  { return $this->role === 'admin'; }
    public function isKasir(): bool  { return $this->role === 'kasir'; }
    public function isUser(): bool   { return $this->role === 'user'; }

    public function hasRole(string|array $roles): bool
    {
        return is_array($roles)
            ? in_array($this->role, $roles)
            : $this->role === $roles;
    }
}
