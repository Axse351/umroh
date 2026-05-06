<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Keberangkatan;
use Illuminate\Http\Request;

class KeberangkatanApiController extends Controller
{
    /**
     * Daftar keberangkatan yang masih open / tersedia.
     */
    public function index(Request $request)
    {
        $status = $request->status;
        $jenis  = $request->jenis;

        $keberangkatans = Keberangkatan::with('paket', 'pembimbing')
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($jenis, fn($q) => $q->whereHas('paket', fn($p) => $p->where('jenis', $jenis)))
            ->latest()
            ->paginate(10);

        // ✅ Ganti through() dengan map() + values()
        $data = $keberangkatans->getCollection()
            ->map(fn($k) => $this->formatKeberangkatan($k))
            ->values();

        return response()->json([
            'success' => true,
            'data' => [
                'current_page' => $keberangkatans->currentPage(),
                'last_page'    => $keberangkatans->lastPage(),
                'per_page'     => $keberangkatans->perPage(),
                'total'        => $keberangkatans->total(),
                'data'         => $data,
            ],
        ]);
    }

    /**
     * Detail satu keberangkatan beserta daftar jamaah.
     */
    public function show(Keberangkatan $keberangkatan)
    {
        $keberangkatan->load('paket', 'pembimbing', 'pendaftarans.jamaah');

        $data = $this->formatKeberangkatan($keberangkatan);
        $data['jumlah_pendaftar'] = $keberangkatan->pendaftarans->count();

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }

    // ─── Helper ──────────────────────────────────────────────────────────────

    private function formatKeberangkatan(Keberangkatan $k): array
    {
        return [
            'id'                        => $k->id,
            'kode_keberangkatan'        => $k->kode_keberangkatan,
            'tanggal_berangkat'         => $k->tanggal_berangkat,
            'tanggal_pulang'            => $k->tanggal_pulang,
            'bandara_keberangkatan'     => $k->bandara_keberangkatan,
            'no_penerbangan_pergi'      => $k->no_penerbangan_pergi,
            'no_penerbangan_pulang'     => $k->no_penerbangan_pulang,
            'kuota'                     => $k->kuota,
            'harga_double'              => $k->harga_double,
            'harga_triple'              => $k->harga_triple,
            'harga_quad'                => $k->harga_quad,
            'status'                    => $k->status,
            'catatan'                   => $k->catatan,
            'paket'                     => $k->paket ? [
                'id'          => $k->paket->id,
                'nama_paket'  => $k->paket->nama_paket,
                'jenis'       => $k->paket->jenis,
                'durasi'      => $k->paket->durasi ?? null,
                'deskripsi'   => $k->paket->deskripsi ?? null,
            ] : null,
            'pembimbing' => $k->pembimbing ? [
                'id'           => $k->pembimbing->id,
                'nama_lengkap' => $k->pembimbing->nama_lengkap,
                'no_telepon'   => $k->pembimbing->no_telepon,
            ] : null,
        ];
    }
}
