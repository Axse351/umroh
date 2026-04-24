<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hotel extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kode_hotel',
        'nama_hotel',
        'lokasi',
        'bintang',
        'jarak_ke_masjid_meter',
        'no_telepon',
        'alamat',
        'fasilitas',
        'status'
    ];

    public function paketSebagaiMekkah()
    {
        return $this->hasMany(Paket::class, 'hotel_mekkah_id');
    }

    public function paketSebagaiMadinah()
    {
        return $this->hasMany(Paket::class, 'hotel_madinah_id');
    }
}
