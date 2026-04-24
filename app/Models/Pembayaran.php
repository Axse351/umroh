<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembayaran extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'no_pembayaran',
        'pendaftaran_id',
        'karyawan_id',
        'jumlah_bayar',
        'tanggal_bayar',
        'metode_bayar',
        'bank_tujuan',
        'no_rekening',
        'nama_pengirim',
        'bukti_bayar',
        'jenis',
        'status',
        'catatan'
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
