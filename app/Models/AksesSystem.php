<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AksesSystem extends Model
{
    protected $table = 'akses_systems';

    protected $fillable = [
        'user_id',
        'karyawan_id',
        'role',
        'permissions',
        'status'
    ];

    protected $casts = [
        'permissions' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function hasPermission(string $permission): bool
    {
        if ($this->role === 'superadmin') return true;
        return in_array($permission, $this->permissions ?? []);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'superadmin';
    }
}
