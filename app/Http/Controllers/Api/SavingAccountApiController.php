<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class SavingAccountApiController extends Controller
{
    /**
     * GET /api/v1/saving-account
     *
     * Mengembalikan progress tabungan user berdasarkan pendaftaran aktif.
     * Transaksi = pembayaran berstatus 'diterima'.
     */
    public function show(Request $request)
    {
        $user = $request->user();

        $pendaftaran = Pendaftaran::with([
            'pembayarans' => fn($q) => $q
                ->where('status', 'diterima')
                ->orderBy('tanggal_bayar'),
        ])
            ->where('jamaah_id', $user->jamaah_id)
            ->latest()
            ->first();

        // Belum punya pendaftaran — kembalikan akun kosong
        if (!$pendaftaran) {
            return response()->json([
                'success' => true,
                'data'    => [
                    'id'            => '0',
                    'user_id'       => (string) $user->id,
                    'saving_type'   => 'umroh',
                    'target_amount' => 0,
                    'transactions'  => [],
                ],
            ]);
        }

        $transactions = $pendaftaran->pembayarans->map(fn($p) => [
            'id'          => (string) $p->id,
            'amount'      => (float) $p->jumlah_bayar,
            'type'        => 'deposit',
            'description' => $this->jenisLabel($p->jenis) . ' via ' . $this->metodeLabel($p->metode_bayar),
            'date'        => $p->tanggal_bayar->toDateString(),
        ]);

        return response()->json([
            'success' => true,
            'data'    => [
                'id'            => (string) $pendaftaran->id,
                'user_id'       => (string) $user->id,
                'saving_type'   => $pendaftaran->jenis, // 'haji' | 'umroh'
                'target_amount' => (float) $pendaftaran->harga_jual,
                'transactions'  => $transactions,
            ],
        ]);
    }

    private function jenisLabel(string $jenis): string
    {
        return match ($jenis) {
            'dp'        => 'Uang Muka',
            'cicilan'   => 'Cicilan',
            'pelunasan' => 'Pelunasan',
            default     => 'Pembayaran',
        };
    }

    private function metodeLabel(string $metode): string
    {
        return match ($metode) {
            'tunai'    => 'Tunai',
            'transfer' => 'Transfer',
            'qris'     => 'QRIS',
            'tabungan' => 'Tabungan',
            default    => $metode,
        };
    }
}
