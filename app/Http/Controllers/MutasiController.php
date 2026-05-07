<?php

namespace App\Http\Controllers;

use App\Models\Jamaah;
use App\Models\Pembayaran;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class MutasiController extends Controller
{
    /**
     * Daftar jamaah yang memiliki riwayat pembayaran.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $jamaahs = Jamaah::whereHas('pendaftarans.pembayarans')
            ->when($search, fn($q) => $q->where('nama_lengkap', 'like', "%$search%")
                ->orWhere('no_identitas', 'like', "%$search%"))
            ->withCount('pendaftarans')
            ->with(['pendaftarans.pembayarans' => fn($q) => $q->where('status', 'diterima')])
            ->paginate(15);

        return view('mutasi.index', compact('jamaahs', 'search'));
    }

    /**
     * Detail mutasi pembayaran satu jamaah — semua pendaftaran & pembayaran.
     */
    public function show(Request $request, Jamaah $jamaah)
    {
        $jamaah->load([
            'pendaftarans' => fn($q) => $q->with([
                'paket',
                'pembayarans' => fn($q2) => $q2->orderBy('tanggal_bayar'),
            ])->orderBy('created_at'),
        ]);

        $totalTerbayar = $jamaah->pendaftarans
            ->flatMap->pembayarans
            ->where('status', 'diterima')
            ->sum('jumlah_bayar');

        $totalTagihan = $jamaah->pendaftarans->sum('total_harga');
        $sisaTagihan  = $totalTagihan - $totalTerbayar;

        return view('mutasi.show', compact('jamaah', 'totalTerbayar', 'totalTagihan', 'sisaTagihan'));
    }

    /**
     * Halaman cetak mutasi — layout minimal tanpa sidebar/navbar.
     */
    public function cetak(Jamaah $jamaah)
    {
        $jamaah->load([
            'pendaftarans' => fn($q) => $q->with([
                'paket',
                'pembayarans' => fn($q2) => $q2->orderBy('tanggal_bayar'),
            ])->orderBy('created_at'),
        ]);

        $totalTerbayar = $jamaah->pendaftarans
            ->flatMap->pembayarans
            ->where('status', 'diterima')
            ->sum('jumlah_bayar');

        $totalTagihan = $jamaah->pendaftarans->sum('total_harga');
        $sisaTagihan  = $totalTagihan - $totalTerbayar;

        return view('mutasi.cetak', compact('jamaah', 'totalTerbayar', 'totalTagihan', 'sisaTagihan'));
    }
}
