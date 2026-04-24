<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PengeluaranProduk extends Model
{
    use SoftDeletes;

    protected $table = 'pengeluaran_produks';

    protected $fillable = [
        'no_pengeluaran_produk',
        'produk_id',
        'pendaftaran_id',
        'karyawan_id',
        'qty',
        'tanggal_keluar',
        'keperluan',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_keluar' => 'date',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
