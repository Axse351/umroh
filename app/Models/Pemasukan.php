<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pemasukan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'no_pemasukan',
        'sumber',
        'kategori',
        'jumlah',
        'tanggal',
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
