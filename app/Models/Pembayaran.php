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
        'tabungan_id',           // ← baru: sumber dari tabungan
        'jumlah_bayar',
        'jumlah_dari_tabungan',  // ← baru: berapa yg ditarik dari tabungan
        'tanggal_bayar',
        'metode_bayar',
        'bank_tujuan',
        'no_rekening',
        'nama_pengirim',
        'bukti_bayar',
        'jenis',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_bayar'          => 'date',
        'jumlah_bayar'           => 'decimal:2',
        'jumlah_dari_tabungan'   => 'decimal:2',
    ];

    // ─── Relations ───────────────────────────────────────────────────

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    /**
     * Tabungan yang dipakai sebagai sumber dana pembayaran ini (nullable).
     */
    public function tabungan()
    {
        return $this->belongsTo(Tabungan::class);
    }

    // ─── Accessors ───────────────────────────────────────────────────

    public function getDariTabunganAttribute(): bool
    {
        return $this->tabungan_id !== null;
    }
}
