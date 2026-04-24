<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengeluaran extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'no_pengeluaran',
        'keperluan',
        'kategori',
        'jumlah',
        'tanggal',
        'penerima',
        'bukti',
        'keterangan',
        'karyawan_id'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public static function totalByKategori(string $kategori, $bulan = null, $tahun = null)
    {
        $query = static::where('kategori', $kategori);
        if ($bulan) $query->whereMonth('tanggal', $bulan);
        if ($tahun) $query->whereYear('tanggal', $tahun);
        return $query->sum('jumlah');
    }
}
