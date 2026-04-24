<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jamaah extends Model
{
    use SoftDeletes;

    protected $table = 'jamaah';

    protected $fillable = [
        'kode_jamaah',
        'nama_lengkap',
        'nama_arab',
        'nik',
        'no_passport',
        'exp_passport',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'kota',
        'provinsi',
        'kode_pos',
        'no_telepon',
        'email',
        'pekerjaan',
        'pendidikan',
        'nama_mahram',
        'hubungan_mahram',
        'golongan_darah',
        'riwayat_penyakit',
        'foto',
        'foto_passport',
        'foto_ktp',
        'status'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'exp_passport'  => 'date',
    ];

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class);
    }

    public function tabungans()
    {
        return $this->hasMany(Tabungan::class);
    }

    public function dokumens()
    {
        return $this->hasMany(Dokumen::class);
    }

    public function getUmurAttribute()
    {
        return $this->tanggal_lahir->age;
    }
}
