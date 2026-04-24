<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Pendaftaran;
use App\Models\Pembayaran;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\Tabungan;
use App\Models\Produk;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $laporans = Laporan::with('karyawan')->latest()->paginate(10);
        return view('laporan.index', compact('laporans'));
    }

    public function keuangan(Request $request)
    {
        $dari    = $request->dari    ?? now()->startOfMonth()->toDateString();
        $sampai  = $request->sampai  ?? now()->endOfMonth()->toDateString();

        $rekap = Laporan::rekapKeuangan($dari, $sampai);

        $pemasukans  = Pemasukan::whereBetween('tanggal', [$dari, $sampai])
            ->selectRaw('kategori, SUM(jumlah) as total')
            ->groupBy('kategori')->get();

        $pengeluarans = Pengeluaran::whereBetween('tanggal', [$dari, $sampai])
            ->selectRaw('kategori, SUM(jumlah) as total')
            ->groupBy('kategori')->get();

        return view('laporan.keuangan', compact('rekap', 'pemasukans', 'pengeluarans', 'dari', 'sampai'));
    }

    public function jamaah(Request $request)
    {
        $dari   = $request->dari   ?? now()->startOfMonth()->toDateString();
        $sampai = $request->sampai ?? now()->endOfMonth()->toDateString();
        $jenis  = $request->jenis;

        $rekap = Laporan::rekapJamaah($dari, $sampai, $jenis);

        $pendaftarans = Pendaftaran::with('jamaah', 'keberangkatan.paket')
            ->whereBetween('tanggal_daftar', [$dari, $sampai])
            ->when($jenis, fn($q) => $q->where('jenis', $jenis))
            ->latest()->get();

        return view('laporan.jamaah', compact('rekap', 'pendaftarans', 'dari', 'sampai', 'jenis'));
    }

    public function pembayaran(Request $request)
    {
        $dari   = $request->dari   ?? now()->startOfMonth()->toDateString();
        $sampai = $request->sampai ?? now()->endOfMonth()->toDateString();

        $pembayarans = Pembayaran::with('pendaftaran.jamaah')
            ->where('status', 'diterima')
            ->whereBetween('tanggal_bayar', [$dari, $sampai])
            ->latest()->get();

        $total = $pembayarans->sum('jumlah_bayar');

        return view('laporan.pembayaran', compact('pembayarans', 'total', 'dari', 'sampai'));
    }

    public function tabungan(Request $request)
    {
        $jenis = $request->jenis;
        $rekap = Laporan::rekapTabungan($jenis);

        $tabungans = Tabungan::with('jamaah')
            ->when($jenis, fn($q) => $q->where('jenis', $jenis))
            ->latest()->get();

        return view('laporan.tabungan', compact('rekap', 'tabungans', 'jenis'));
    }

    public function stok()
    {
        $rekap   = Laporan::rekapStok();
        $produks = Produk::with('supplier')->where('status', 'aktif')->get();
        return view('laporan.stok', compact('rekap', 'produks'));
    }

    public function keberangkatan(Request $request)
    {
        $tahun = $request->tahun ?? now()->year;

        $keberangkatans = \App\Models\Keberangkatan::with('paket', 'pendaftarans.jamaah')
            ->whereYear('tanggal_berangkat', $tahun)
            ->latest('tanggal_berangkat')->get();

        return view('laporan.keberangkatan', compact('keberangkatans', 'tahun'));
    }

    public function destroy(Laporan $laporan)
    {
        $laporan->delete();
        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dihapus.');
    }
}
