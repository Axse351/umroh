<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranApiController extends Controller
{
    /**
     * Daftar pendaftaran + pembayarannya (mutasi)
     */
    public function index(Request $request)
    {
        $user   = $request->user();
        $jenis  = $request->jenis;
        $status = $request->status;

        $query = Pendaftaran::with('jamaah', 'keberangkatan.paket', 'pembayarans')
            ->when($jenis, fn($q) => $q->where('jenis', $jenis))
            ->when($status, fn($q) => $q->where('status', $status));

        if (isset($user->jamaah_id)) {
            $query->where('jamaah_id', $user->jamaah_id);
        }

        $pendaftarans = $query->latest()->paginate(10);

        $data = $pendaftarans->getCollection()
            ->map(fn($p) => $this->formatPendaftaran($p))
            ->values();

        return response()->json([
            'success' => true,
            'data' => [
                'current_page' => $pendaftarans->currentPage(),
                'last_page'    => $pendaftarans->lastPage(),
                'per_page'     => $pendaftarans->perPage(),
                'total'        => $pendaftarans->total(),
                'data'         => $data,
            ],
        ]);
    }

    /**
     * SUMMARY: total masuk, pending, jumlah transaksi
     */
    public function summary(Request $request)
    {
        $user = $request->user();

        // Ambil semua pembayaran milik user (via pendaftaran)
        $query = Pembayaran::whereHas('pendaftaran', function ($q) use ($user) {
            if (isset($user->jamaah_id)) {
                $q->where('jamaah_id', $user->jamaah_id);
            }
        });

        $totalMasuk = (clone $query)->where('status', 'diterima')->sum('jumlah_bayar');
        $totalPending = (clone $query)->where('status', 'pending')->sum('jumlah_bayar');
        $jumlahTransaksi = (clone $query)->count();

        return response()->json([
            'success' => true,
            'data' => [
                'total_masuk'       => (float) $totalMasuk,
                'total_pending'     => (float) $totalPending,
                'jumlah_transaksi'  => (int) $jumlahTransaksi,
            ],
        ]);
    }

    /**
     * Detail pembayaran.
     */
    public function show(Pembayaran $pembayaran)
    {
        $pembayaran->load('pendaftaran.jamaah', 'karyawan');

        return response()->json([
            'success' => true,
            'data'    => $this->formatPembayaran($pembayaran),
        ]);
    }

    /**
     * Buat pembayaran baru (user upload bukti bayar)
     */
    public function store(Request $request)
    {
        $request->validate([
            'pendaftaran_id' => 'required|exists:pendaftarans,id',
            'jumlah_bayar'   => 'required|numeric|min:1',
            'tanggal_bayar'  => 'required|date',
            'metode_bayar'   => 'required|in:tunai,transfer,debit,kredit,qris',
            'bank_tujuan'    => 'nullable|string|max:100',
            'no_rekening'    => 'nullable|string|max:50',
            'nama_pengirim'  => 'nullable|string|max:255',
            'bukti_bayar'    => 'nullable|image|max:2048',
            'jenis'          => 'required|in:dp,cicilan,pelunasan,lainnya',
            'catatan'        => 'nullable|string',
        ]);

        $user        = $request->user();
        $pendaftaran = Pendaftaran::find($request->pendaftaran_id);

        if (isset($user->jamaah_id) && $pendaftaran->jamaah_id !== $user->jamaah_id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses ke pendaftaran ini.',
            ], 403);
        }

        $data                  = $request->except('bukti_bayar');
        $data['no_pembayaran'] = 'PAY-' . strtoupper(uniqid());
        $data['karyawan_id']   = null;
        $data['status']        = 'pending';

        if ($request->hasFile('bukti_bayar')) {
            $data['bukti_bayar'] = $request->file('bukti_bayar')->store('pembayaran', 'public');
        }

        $pembayaran = Pembayaran::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil diajukan dan menunggu verifikasi.',
            'data'    => $this->formatPembayaran($pembayaran->load('pendaftaran.jamaah')),
        ], 201);
    }

    // ─── PRIVATE HELPERS ───────────────────────────────────────────────────

    /**
     * Format data pendaftaran untuk mutasi (digunakan di index)
     */
    private function formatPendaftaran(Pendaftaran $p): array
    {
        // Hitung total bayar dari pembayaran yang sudah diterima
        $totalBayar = $p->pembayarans->where('status', 'diterima')->sum('jumlah_bayar');
        $sisaTagihan = max(0, $p->harga_jual - $totalBayar);

        return [
            'id'                 => $p->id,
            'no_pendaftaran'     => $p->no_pendaftaran,
            'jenis'              => $p->jenis,
            'status'             => $p->status,
            'harga_jual'         => (float) $p->harga_jual,
            'total_bayar'        => (float) $totalBayar,
            'sisa_tagihan'       => (float) $sisaTagihan,
            'dp_minimal'         => (float) $p->dp_minimal,
            'batas_pelunasan'    => $p->batas_pelunasan,
            'nama_jamaah'        => $p->jamaah?->nama_lengkap,
            'nama_paket'         => $p->keberangkatan?->paket?->nama_paket,
            'tanggal_berangkat'  => $p->keberangkatan?->tanggal_berangkat,
            'pembayarans'        => $p->pembayarans->map(fn($bayar) => $this->formatPembayaran($bayar))->values(),
        ];
    }

    /**
     * Format data pembayaran (digunakan di show dan di dalam formatPendaftaran)
     */
    private function formatPembayaran(Pembayaran $p): array
    {
        return [
            'id'             => $p->id,
            'no_pembayaran'  => $p->no_pembayaran,
            'jumlah_bayar'   => (float) $p->jumlah_bayar,
            'tanggal_bayar'  => $p->tanggal_bayar,
            'metode_bayar'   => $p->metode_bayar,
            'bank_tujuan'    => $p->bank_tujuan,
            'no_rekening'    => $p->no_rekening,
            'nama_pengirim'  => $p->nama_pengirim,
            'jenis'          => $p->jenis,
            'status'         => $p->status,
            'catatan'        => $p->catatan,
            'bukti_bayar'    => $p->bukti_bayar ? asset('storage/' . $p->bukti_bayar) : null,
            'pendaftaran'    => $p->pendaftaran ? [
                'id'           => $p->pendaftaran->id,
                'jamaah'       => $p->pendaftaran->jamaah ? [
                    'nama_lengkap' => $p->pendaftaran->jamaah->nama_lengkap,
                ] : null,
            ] : null,
            'created_at'     => $p->created_at?->toDateTimeString(),
        ];
    }
}
