<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransaksiLayanan extends Model
{
    use SoftDeletes;

    protected $table = 'transaksi_layanans';

    protected $fillable = [
        'no_transaksi',
        'pendaftaran_id',
        'layanan_id',
        'qty',
        'harga_satuan',
        'total_harga',
        'tanggal_transaksi',
        'status',
        'catatan'
    ];

    protected $casts = [
        'tanggal_transaksi' => 'date',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }
}
