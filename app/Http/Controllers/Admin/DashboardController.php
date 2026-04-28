<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jamaah;
use App\Models\Pendaftaran;
use App\Models\Paket;
use App\Models\Maskapai;
use App\Models\Pembayaran;
use App\Models\User;
use App\Models\Keberangkatan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Total User ───────────────────────────────────────────────
        $totalUser = User::count();

        // ── Total Jamaah (master data) ───────────────────────────────
        $totalJamaah = Jamaah::count();

        // ── Pendaftaran Haji ─────────────────────────────────────────
        // Kolom 'jenis' ada di tabel pendaftarans (bukan di jamaah)
        // Nilai: umroh | haji | haji_plus | haji_furoda
        $totalPendaftaranHaji    = Pendaftaran::whereIn('jenis', ['haji', 'haji_plus', 'haji_furoda'])->count();
        $pendaftaranHajiAktif    = Pendaftaran::whereIn('jenis', ['haji', 'haji_plus', 'haji_furoda'])
            ->whereNotIn('status', ['batal', 'refund', 'selesai'])
            ->count();
        $pendaftaranHajiSelesai  = Pendaftaran::whereIn('jenis', ['haji', 'haji_plus', 'haji_furoda'])
            ->where('status', 'selesai')
            ->count();
        $pendaftaranHajiBatal    = Pendaftaran::whereIn('jenis', ['haji', 'haji_plus', 'haji_furoda'])
            ->whereIn('status', ['batal', 'refund'])
            ->count();

        // ── Pendaftaran Umroh ────────────────────────────────────────
        $totalPendaftaranUmroh   = Pendaftaran::where('jenis', 'umroh')->count();
        $pendaftaranUmrohAktif   = Pendaftaran::where('jenis', 'umroh')
            ->whereNotIn('status', ['batal', 'refund', 'selesai'])
            ->count();
        $pendaftaranUmrohSelesai = Pendaftaran::where('jenis', 'umroh')
            ->where('status', 'selesai')
            ->count();
        $pendaftaranUmrohBatal   = Pendaftaran::where('jenis', 'umroh')
            ->whereIn('status', ['batal', 'refund'])
            ->count();

        // ── Maskapai ─────────────────────────────────────────────────
        $totalMaskapai = Maskapai::count();
        $maskapaiAktif = Maskapai::where('status', 'aktif')->count();

        // ── Paket ────────────────────────────────────────────────────
        $totalPaket = Paket::count();
        $paketHaji  = Paket::whereIn('jenis', ['haji', 'haji_plus', 'haji_furoda'])->count();
        $paketUmroh = Paket::where('jenis', 'umroh')->count();
        $paketAktif = Paket::where('status', 'aktif')->count();

        // ── Pembayaran ───────────────────────────────────────────────
        // Status: pending | verifikasi | diterima | ditolak
        // Kolom jumlah: jumlah_bayar (bukan jumlah)
        $totalPendapatan      = Pembayaran::where('status', 'diterima')->sum('jumlah_bayar');
        $pendapatanBulanIni   = Pembayaran::where('status', 'diterima')
            ->whereMonth('tanggal_bayar', Carbon::now()->month)
            ->whereYear('tanggal_bayar', Carbon::now()->year)
            ->sum('jumlah_bayar');
        $pembayaranPending    = Pembayaran::where('status', 'pending')->count();
        $pembayaranVerifikasi = Pembayaran::where('status', 'verifikasi')->count();
        $pembayaranDiterima   = Pembayaran::where('status', 'diterima')->count();
        $pembayaranDitolak    = Pembayaran::where('status', 'ditolak')->count();

        // ── Keberangkatan ────────────────────────────────────────────
        // Status: open | closed | berangkat | selesai | batal
        $keberangkatanMendatang = Keberangkatan::with('paket')
            ->where('tanggal_berangkat', '>=', Carbon::today())
            ->whereIn('status', ['open', 'closed', 'berangkat'])
            ->orderBy('tanggal_berangkat')
            ->take(5)
            ->get();

        $keberangkatanBulanIni  = Keberangkatan::whereMonth('tanggal_berangkat', Carbon::now()->month)
            ->whereYear('tanggal_berangkat', Carbon::now()->year)
            ->count();

        $totalKeberangkatan     = Keberangkatan::count();
        $keberangkatanAktif     = Keberangkatan::whereIn('status', ['open', 'closed'])->count();

        // ── Pendaftaran Terbaru ──────────────────────────────────────
        $pendaftaranTerbaru = Pendaftaran::with(['jamaah', 'keberangkatan.paket'])
            ->latest()
            ->take(6)
            ->get();

        // ── Grafik Pendaftaran 6 Bulan Terakhir ──────────────────────
        $grafikPendaftaran = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i);
            $grafikPendaftaran[] = [
                'bulan' => $bulan->translatedFormat('M Y'),
                'haji'  => Pendaftaran::whereIn('jenis', ['haji', 'haji_plus', 'haji_furoda'])
                    ->whereMonth('created_at', $bulan->month)
                    ->whereYear('created_at', $bulan->year)
                    ->count(),
                'umroh' => Pendaftaran::where('jenis', 'umroh')
                    ->whereMonth('created_at', $bulan->month)
                    ->whereYear('created_at', $bulan->year)
                    ->count(),
            ];
        }

        return view('admin.dashboard', compact(
            'totalUser',
            'totalJamaah',
            'totalPendaftaranHaji',
            'pendaftaranHajiAktif',
            'pendaftaranHajiSelesai',
            'pendaftaranHajiBatal',
            'totalPendaftaranUmroh',
            'pendaftaranUmrohAktif',
            'pendaftaranUmrohSelesai',
            'pendaftaranUmrohBatal',
            'totalMaskapai',
            'maskapaiAktif',
            'totalPaket',
            'paketHaji',
            'paketUmroh',
            'paketAktif',
            'totalPendapatan',
            'pendapatanBulanIni',
            'pembayaranPending',
            'pembayaranVerifikasi',
            'pembayaranDiterima',
            'pembayaranDitolak',
            'keberangkatanMendatang',
            'keberangkatanBulanIni',
            'totalKeberangkatan',
            'keberangkatanAktif',
            'pendaftaranTerbaru',
            'grafikPendaftaran',
        ));
    }
}
