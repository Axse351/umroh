<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokOpname extends Model
{
    protected $table = 'stok_opnames';

    protected $fillable = [
        'no_opname',
        'produk_id',
        'karyawan_id',
        'stok_sistem',
        'stok_fisik',
        'selisih',
        'tanggal_opname',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_opname' => 'date',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function getStatusSelisihAttribute()
    {
        if ($this->selisih > 0) return 'lebih';
        if ($this->selisih < 0) return 'kurang';
        return 'sesuai';
    }
}
