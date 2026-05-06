<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jamaah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JamaahApiController extends Controller
{
    /**
     * Daftar semua jamaah milik user yang login.
     * Asumsikan: user->jamaah (relasi hasOne atau lewat pendaftaran).
     * Di sini kita kembalikan data jamaah yang terhubung dengan akun user.
     */
    public function index(Request $request)
    {
        $user   = $request->user();
        $search = $request->search;
        $jenis  = $request->jenis; // umroh / haji

        // Jika user punya relasi langsung ke jamaah (mis. jamaah_id di tabel users)
        // Sesuaikan query ini dengan struktur DB Anda
        $query = Jamaah::query();

        // Jika user hanya boleh melihat data jamaah miliknya sendiri:
        if (isset($user->jamaah_id)) {
            $query->where('id', $user->jamaah_id);
        }

        $query->when(
            $search,
            fn($q) => $q
                ->where('nama_lengkap', 'like', "%$search%")
                ->orWhere('nik', 'like', "%$search%")
                ->orWhere('no_passport', 'like', "%$search%")
        );

        $query->when(
            $jenis,
            fn($q) => $q
                ->whereHas('pendaftarans', fn($p) => $p->where('jenis', $jenis))
        );

        $jamaah = $query->with('pendaftarans.keberangkatan.paket')->latest()->paginate(10);

        return response()->json([
            'success' => true,
            'data'    => $jamaah,
        ]);
    }

    /**
     * Detail jamaah beserta pendaftaran, tabungan, dan dokumen.
     */
    public function show(Request $request, Jamaah $jamaah)
    {
        $jamaah->load('pendaftarans.keberangkatan.paket', 'tabungans', 'dokumens');

        return response()->json([
            'success' => true,
            'data'    => $this->formatJamaah($jamaah),
        ]);
    }

    /**
     * Update data jamaah (nama, kontak, dsb — bukan dokumen sensitif).
     */
    public function update(Request $request, Jamaah $jamaah)
    {
        $request->validate([
            'nama_lengkap'  => 'sometimes|required|string|max:255',
            'no_telepon'    => 'sometimes|required|string|max:20',
            'email'         => 'nullable|email',
            'alamat'        => 'nullable|string',
            'kota'          => 'nullable|string|max:100',
            'provinsi'      => 'nullable|string|max:100',
            'foto'          => 'nullable|image|max:2048',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            if ($jamaah->foto) Storage::disk('public')->delete($jamaah->foto);
            $data['foto'] = $request->file('foto')->store('jamaah', 'public');
        }

        $jamaah->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Data jamaah berhasil diperbarui.',
            'data'    => $this->formatJamaah($jamaah->fresh()),
        ]);
    }

    // ─── Helper ──────────────────────────────────────────────────────────────

    private function formatJamaah(Jamaah $jamaah): array
    {
        return [
            'id'             => $jamaah->id,
            'kode_jamaah'    => $jamaah->kode_jamaah,
            'nama_lengkap'   => $jamaah->nama_lengkap,
            'nik'            => $jamaah->nik,
            'no_passport'    => $jamaah->no_passport,
            'exp_passport'   => $jamaah->exp_passport,
            'jenis_kelamin'  => $jamaah->jenis_kelamin,
            'tempat_lahir'   => $jamaah->tempat_lahir,
            'tanggal_lahir'  => $jamaah->tanggal_lahir,
            'alamat'         => $jamaah->alamat,
            'kota'           => $jamaah->kota,
            'provinsi'       => $jamaah->provinsi,
            'no_telepon'     => $jamaah->no_telepon,
            'email'          => $jamaah->email,
            'foto'           => $jamaah->foto ? asset('storage/' . $jamaah->foto) : null,
            'foto_passport'  => $jamaah->foto_passport ? asset('storage/' . $jamaah->foto_passport) : null,
            'foto_ktp'       => $jamaah->foto_ktp ? asset('storage/' . $jamaah->foto_ktp) : null,
            'pendaftarans'   => $jamaah->pendaftarans ?? [],
            'tabungans'      => $jamaah->tabungans ?? [],
            'dokumens'       => $jamaah->dokumens ?? [],
        ];
    }
}
