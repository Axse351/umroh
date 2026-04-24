<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $fillable = [
        'judul',
        'jenis',
        'periode_dari',
        'periode_sampai',
        'data',
        'karyawan_id',
        'file_path',
        'status'
    ];

    protected $casts = [
        'periode_dari'    => 'date',
        'periode_sampai'  => 'date',
        'data'            => 'array',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    // Rekap pemasukan vs pengeluaran
    public static function rekapKeuangan($dari, $sampai)
    {
        $pemasukan = Pemasukan::whereBetween('tanggal', [$dari, $sampai])
            ->sum('jumlah');

        $pengeluaran = Pengeluaran::whereBetween('tanggal', [$dari, $sampai])
            ->sum('jumlah');

        return [
            'total_pemasukan'  => $pemasukan,
            'total_pengeluaran' => $pengeluaran,
            'laba_bersih'      => $pemasukan - $pengeluaran,
        ];
    }

    // Rekap jamaah per periode
    public static function rekapJamaah($dari, $sampai, $jenis = null)
    {
        $query = Pendaftaran::whereBetween('tanggal_daftar', [$dari, $sampai]);
        if ($jenis) $query->where('jenis', $jenis);

        return [
            'total_daftar'   => $query->clone()->count(),
            'total_lunas'    => $query->clone()->where('status', 'lunas')->count(),
            'total_batal'    => $query->clone()->where('status', 'batal')->count(),
            'total_berangkat' => $query->clone()->where('status', 'berangkat')->count(),
            'total_omzet'    => $query->clone()->sum('harga_jual'),
        ];
    }

    // Rekap tabungan
    public static function rekapTabungan($jenis = null)
    {
        $query = Tabungan::query();
        if ($jenis) $query->where('jenis', $jenis);

        return [
            'total_rekening' => $query->clone()->count(),
            'total_saldo'    => $query->clone()->sum('saldo'),
            'total_target'   => $query->clone()->sum('target_tabungan'),
            'sudah_lunas'    => $query->clone()->where('status', 'selesai')->count(),
        ];
    }

    // Rekap stok produk
    public static function rekapStok()
    {
        return Produk::with('supplier')
            ->select('id', 'kode_produk', 'nama_produk', 'stok', 'stok_minimum', 'kategori')
            ->get()
            ->map(function ($p) {
                return [
                    'kode'        => $p->kode_produk,
                    'nama'        => $p->nama_produk,
                    'kategori'    => $p->kategori,
                    'stok'        => $p->stok,
                    'minimum'     => $p->stok_minimum,
                    'kritis'      => $p->is_stok_minimum,
                ];
            });
    }
}
