<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setoran extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'no_setoran',
        'tabungan_id',
        'karyawan_id',
        'jumlah_setor',
        'tanggal_setor',
        'jenis',
        'metode',
        'bukti_setor',
        'status',
        'catatan'
    ];

    protected $casts = [
        'tanggal_setor' => 'date',
    ];

    public function tabungan()
    {
        return $this->belongsTo(Tabungan::class);
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
