<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produk extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kode_produk',
        'nama_produk',
        'kategori',
        'supplier_id',
        'stok',
        'stok_minimum',
        'satuan',
        'harga_beli',
        'harga_jual',
        'deskripsi',
        'foto',
        'status'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function pembelianDetails()
    {
        return $this->hasMany(PembelianDetail::class);
    }

    public function pengeluaranProduks()
    {
        return $this->hasMany(PengeluaranProduk::class);
    }

    public function stokOpnames()
    {
        return $this->hasMany(StokOpname::class);
    }

    public function getIsStokMinimumAttribute()
    {
        return $this->stok <= $this->stok_minimum;
    }
}
