<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tabungan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'no_rekening_tabungan',
        'jamaah_id',
        'jenis',
        'target_tabungan',
        'saldo',
        'tanggal_buka',
        'tanggal_target',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_buka'    => 'date',
        'tanggal_target'  => 'date',
        'target_tabungan' => 'decimal:2',
        'saldo'           => 'decimal:2',
    ];

    // ─── Relations ───────────────────────────────────────────────────

    public function jamaah()
    {
        return $this->belongsTo(Jamaah::class);
    }

    public function setorans()
    {
        return $this->hasMany(Setoran::class);
    }

    /**
     * Pembayaran pendaftaran yang menggunakan saldo tabungan ini.
     */
    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }

    // ─── Accessors ───────────────────────────────────────────────────

    /**
     * Persentase ketercapaian target (0‑100).
     */
    public function getPersenTercapaiAttribute(): float
    {
        if ($this->target_tabungan <= 0) {
            return 0;
        }
        return min(100, round(($this->saldo / $this->target_tabungan) * 100, 1));
    }

    /**
     * Sisa yang masih perlu ditabung.
     */
    public function getSisaTargetAttribute(): float
    {
        return max(0, $this->target_tabungan - $this->saldo);
    }
}
