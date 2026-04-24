<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Karyawan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kode_karyawan',
        'nama_lengkap',
        'nik',
        'jabatan',
        'divisi',
        'no_telepon',
        'email',
        'alamat',
        'tanggal_masuk',
        'tanggal_keluar',
        'status',
        'foto'
    ];

    protected $casts = [
        'tanggal_masuk'  => 'date',
        'tanggal_keluar' => 'date',
    ];

    public function aksesSystem()
    {
        return $this->hasOne(AksesSystem::class);
    }

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class);
    }
}
