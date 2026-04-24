<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paket extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kode_paket',
        'nama_paket',
        'jenis',
        'kategori',
        'durasi_hari',
        'maskapai_id',
        'hotel_mekkah_id',
        'hotel_madinah_id',
        'kapasitas',
        'harga_double',
        'harga_triple',
        'harga_quad',
        'include',
        'exclude',
        'itinerary',
        'status'
    ];

    public function maskapai()
    {
        return $this->belongsTo(Maskapai::class);
    }

    public function hotelMekkah()
    {
        return $this->belongsTo(Hotel::class, 'hotel_mekkah_id');
    }

    public function hotelMadinah()
    {
        return $this->belongsTo(Hotel::class, 'hotel_madinah_id');
    }

    public function keberangkatans()
    {
        return $this->hasMany(Keberangkatan::class);
    }
}
