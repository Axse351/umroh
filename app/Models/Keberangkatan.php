<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Keberangkatan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kode_keberangkatan',
        'paket_id',
        'tanggal_berangkat',
        'tanggal_pulang',
        'bandara_keberangkatan',
        'no_penerbangan_pergi',
        'no_penerbangan_pulang',
        'kuota',
        'terisi',
        'harga_double',
        'harga_triple',
        'harga_quad',
        'pembimbing_id',
        'status',
        'catatan'
    ];

    protected $casts = [
        'tanggal_berangkat' => 'date',
        'tanggal_pulang'    => 'date',
    ];

    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }

    public function pembimbing()
    {
        return $this->belongsTo(Karyawan::class, 'pembimbing_id');
    }

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class);
    }

    public function getSisaKuotaAttribute()
    {
        return $this->kuota - $this->terisi;
    }
}
