<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kode_supplier',
        'nama_supplier',
        'kategori',
        'nama_pic',
        'no_telepon',
        'email',
        'alamat',
        'no_rekening',
        'nama_bank',
        'status'
    ];

    public function produks()
    {
        return $this->hasMany(Produk::class);
    }

    public function pembelians()
    {
        return $this->hasMany(Pembelian::class);
    }

    public function getTotalPembelianAttribute()
    {
        return $this->pembelians()
            ->where('status', 'diterima')
            ->sum('total');
    }
}
