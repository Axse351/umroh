<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pendaftaran extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'no_pendaftaran',
        'jamaah_id',
        'keberangkatan_id',
        'agent_id',
        'karyawan_id',
        'jenis',
        'tipe_kamar',
        'harga_jual',
        'dp_minimal',
        'tanggal_daftar',
        'batas_pelunasan',
        'status',
        'catatan'
    ];

    protected $casts = [
        'tanggal_daftar'   => 'date',
        'batas_pelunasan'  => 'date',
    ];

    public function jamaah()
    {
        return $this->belongsTo(Jamaah::class);
    }

    public function keberangkatan()
    {
        return $this->belongsTo(Keberangkatan::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function transaksiLayanans()
    {
        return $this->hasMany(TransaksiLayanan::class);
    }

    public function dokumens()
    {
        return $this->hasMany(Dokumen::class);
    }

    public function pengeluaranProduks()
    {
        return $this->hasMany(PengeluaranProduk::class);
    }

    public function getTotalBayarAttribute()
    {
        return $this->pembayarans()
            ->where('status', 'diterima')
            ->sum('jumlah_bayar');
    }

    public function getSisaTagihanAttribute()
    {
        return $this->harga_jual - $this->total_bayar;
    }

    public function getIsLunasAttribute()
    {
        return $this->sisa_tagihan <= 0;
    }
}
