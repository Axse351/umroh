<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Layanan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kode_layanan',
        'nama_layanan',
        'jenis',
        'kategori',
        'harga',
        'deskripsi',
        'status'
    ];

    public function transaksiLayanans()
    {
        return $this->hasMany(TransaksiLayanan::class);
    }

    public function getTotalTerjualAttribute()
    {
        return $this->transaksiLayanans()
            ->where('status', 'selesai')
            ->sum('qty');
    }

    public function getTotalPendapatanAttribute()
    {
        return $this->transaksiLayanans()
            ->where('status', 'selesai')
            ->sum('total_harga');
    }
}
