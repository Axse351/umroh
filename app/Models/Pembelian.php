<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembelian extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'no_pembelian',
        'supplier_id',
        'karyawan_id',
        'tanggal_beli',
        'total',
        'status',
        'catatan'
    ];

    protected $casts = [
        'tanggal_beli' => 'date',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function details()
    {
        return $this->hasMany(PembelianDetail::class);
    }
}
