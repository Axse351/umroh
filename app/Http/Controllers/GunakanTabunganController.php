<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pendaftaran;
use App\Models\Setoran;
use App\Models\Tabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GunakanTabunganController extends Controller
{
    /**
     * Halaman pilih tabungan untuk suatu pendaftaran.
     * GET /admin/pendaftaran/{pendaftaran}/gunakan-tabungan
     */
    public function show(Pendaftaran $pendaftaran)
    {
        $pendaftaran->load('jamaah', 'keberangkatan.paket', 'pembayarans');

        if ($pendaftaran->is_lunas) {
            return redirect()
                ->route('admin.pendaftaran.show', $pendaftaran)
                ->with('info', 'Tagihan pendaftaran ini sudah lunas.');
        }

        // Ambil semua tabungan aktif milik jamaah yang sama
        $tabungans = Tabungan::where('jamaah_id', $pendaftaran->jamaah_id)
            ->where('status', 'aktif')
            ->where('saldo', '>', 0)
            ->get();

        return view('pendaftaran.gunakan-tabungan', compact('pendaftaran', 'tabungans'));
    }

    /**
     * Proses penggunaan saldo tabungan sebagai pembayaran.
     * POST /admin/pendaftaran/{pendaftaran}/gunakan-tabungan
     */
    public function store(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            'tabungan_id'  => 'required|exists:tabungans,id',
            'jumlah_pakai' => 'required|numeric|min:1',
            'jenis'        => 'required|in:dp,cicilan,pelunasan,lainnya',
            'catatan'      => 'nullable|string|max:500',
        ]);

        $tabungan = Tabungan::findOrFail($request->tabungan_id);

        // ── Validasi kepemilikan ──────────────────────────────────────
        if ((int) $tabungan->jamaah_id !== (int) $pendaftaran->jamaah_id) {
            return back()->withErrors(['tabungan_id' => 'Tabungan tidak milik jamaah yang sama.']);
        }

        // ── Validasi saldo cukup ──────────────────────────────────────
        $jumlah = (float) $request->jumlah_pakai;

        if ($jumlah > $tabungan->saldo) {
            return back()->withErrors([
                'jumlah_pakai' => 'Jumlah melebihi saldo tabungan (Rp ' .
                    number_format($tabungan->saldo, 0, ',', '.') . ').',
            ])->withInput();
        }

        // ── Batasi ke sisa tagihan ────────────────────────────────────
        $sisaTagihan = $pendaftaran->sisa_tagihan;
        if ($jumlah > $sisaTagihan) {
            return back()->withErrors([
                'jumlah_pakai' => 'Jumlah melebihi sisa tagihan (Rp ' .
                    number_format($sisaTagihan, 0, ',', '.') . ').',
            ])->withInput();
        }

        DB::transaction(function () use ($request, $pendaftaran, $tabungan, $jumlah) {

            // 1. Buat record Pembayaran (langsung diterima)
            $pembayaran = Pembayaran::create([
                'no_pembayaran'         => 'PAY-TAB-' . strtoupper(uniqid()),
                'pendaftaran_id'        => $pendaftaran->id,
                'karyawan_id'           => auth()->user()->karyawan->id ?? null,
                'tabungan_id'           => $tabungan->id,
                'jumlah_bayar'          => $jumlah,
                'jumlah_dari_tabungan'  => $jumlah,
                'tanggal_bayar'         => now()->toDateString(),
                'metode_bayar'          => 'tabungan',
                'nama_pengirim'         => $tabungan->jamaah->nama_lengkap ?? '-',
                'jenis'                 => $request->jenis,
                'status'                => 'diterima',   // ← langsung diterima
                'catatan'               => $request->catatan
                    ?? 'Pembayaran menggunakan saldo tabungan ' . $tabungan->no_rekening_tabungan,
            ]);

            // 2. Catat mutasi penarikan di tabel setorans
            $setoran = Setoran::create([
                'no_setoran'    => 'SET-TAB-' . strtoupper(uniqid()),
                'tabungan_id'   => $tabungan->id,
                'jumlah_setor'  => $jumlah,
                'tanggal_setor' => now()->toDateString(),
                'jenis'         => 'tarik',
                'metode'        => 'tabungan',
                'karyawan_id'   => auth()->user()->karyawan->id ?? null,
                'status'        => 'diterima',
                'catatan'       => 'Penarikan untuk pembayaran pendaftaran ' . $pendaftaran->no_pendaftaran,
            ]);

            // 3. Kurangi saldo tabungan
            $tabungan->decrement('saldo', $jumlah);

            // 4. Update status pendaftaran jika perlu
            $pendaftaran->refresh();
            if ($pendaftaran->sisa_tagihan <= 0) {
                $pendaftaran->update(['status' => 'lunas']);
            } elseif (in_array($pendaftaran->status, ['draft', 'konfirmasi'])) {
                $pendaftaran->update(['status' => 'dp_terbayar']);
            }
        });

        return redirect()
            ->route('admin.pendaftaran.show', $pendaftaran)
            ->with('success', 'Saldo tabungan berhasil digunakan sebagai pembayaran.');
    }

    /**
     * API: ambil info tabungan (saldo, dll.) — dipanggil via AJAX di view.
     * GET /admin/tabungan/{tabungan}/info
     */
    public function infoTabungan(Tabungan $tabungan)
    {
        return response()->json([
            'id'                   => $tabungan->id,
            'no_rekening_tabungan' => $tabungan->no_rekening_tabungan,
            'jenis'                => $tabungan->jenis,
            'saldo'                => $tabungan->saldo,
            'saldo_format'         => number_format($tabungan->saldo, 0, ',', '.'),
            'target_tabungan'      => $tabungan->target_tabungan,
            'persen_tercapai'      => $tabungan->persen_tercapai,
        ]);
    }
}
