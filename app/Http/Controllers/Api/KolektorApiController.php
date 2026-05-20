<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jamaah;
use App\Models\Karyawan;
use App\Models\Keberangkatan;
use App\Models\Pembayaran;
use App\Models\Pendaftaran;
use App\Models\Setoran;
use App\Models\Tabungan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KolektorApiController extends Controller
{
    // ═══════════════════════════════════════════════════════════
    // JAMAAH (tidak berubah)
    // ═══════════════════════════════════════════════════════════

    public function jamaahIndex(Request $request)
    {
        $search = $request->search;

        $jamaah = Jamaah::when(
            $search,
            fn($q) => $q
                ->where('nama_lengkap', 'like', "%$search%")
                ->orWhere('nik', 'like', "%$search%")
                ->orWhere('no_passport', 'like', "%$search%")
        )
            ->with('user')
            ->latest()
            ->paginate(15);

        return response()->json(['success' => true, 'data' => $jamaah]);
    }

    public function jamaahShow(Jamaah $jamaah)
    {
        $jamaah->load('pendaftarans.keberangkatan.paket', 'tabungans', 'user');

        return response()->json(['success' => true, 'data' => $this->formatJamaah($jamaah)]);
    }

    public function jamaahStore(Request $request)
    {
        $request->validate([
            'nama_lengkap'    => 'required|string|max:255',
            'nik'             => 'required|string|size:16|unique:jamaah',
            'no_passport'     => 'nullable|string|unique:jamaah',
            'exp_passport'    => 'nullable|date',
            'jenis_kelamin'   => 'required|in:laki-laki,perempuan',
            'tempat_lahir'    => 'required|string|max:100',
            'tanggal_lahir'   => 'required|date',
            'alamat'          => 'required|string',
            'kota'            => 'required|string|max:100',
            'provinsi'        => 'required|string|max:100',
            'no_telepon'      => 'required|string|max:20',
            'email'           => 'nullable|email|unique:users,email',
            'golongan_darah'  => 'nullable|string|max:5',
            'pekerjaan'       => 'nullable|string|max:100',
            'nama_mahram'     => 'nullable|string|max:255',
            'hubungan_mahram' => 'nullable|string|max:100',
            'foto'            => 'nullable|image|max:2048',
            'foto_passport'   => 'nullable|image|max:2048',
            'foto_ktp'        => 'nullable|image|max:2048',
        ]);

        $jamaah = DB::transaction(function () use ($request) {
            $data                = $request->except(['foto', 'foto_passport', 'foto_ktp']);
            $data['kode_jamaah'] = 'JMH-' . strtoupper(uniqid());
            $data['status']      = 'aktif';

            foreach (['foto', 'foto_passport', 'foto_ktp'] as $field) {
                if ($request->hasFile($field)) {
                    $data[$field] = $request->file($field)->store('jamaah', 'public');
                }
            }

            $jamaah = Jamaah::create($data);

            $email    = $request->email
                ?? Str::slug($request->nama_lengkap) . '_' . $request->nik . '@jamaah.local';
            $password = $request->nik;

            User::create([
                'name'      => $request->nama_lengkap,
                'email'     => $email,
                'password'  => Hash::make($password),
                'role'      => 'user',
                'jamaah_id' => $jamaah->id,
            ]);

            return $jamaah;
        });

        return response()->json([
            'success' => true,
            'message' => 'Jamaah berhasil ditambahkan. Password default: NIK.',
            'data'    => $this->formatJamaah($jamaah->load('user')),
        ], 201);
    }

    // ═══════════════════════════════════════════════════════════
    // KEBERANGKATAN (tidak berubah)
    // ═══════════════════════════════════════════════════════════

    public function keberangkatanList(Request $request)
    {
        $jenis = $request->jenis;

        $list = Keberangkatan::with('paket')
            ->when($jenis, fn($q) => $q->whereHas(
                'paket',
                fn($p) => $p->where('jenis', $jenis)
            ))
            ->whereIn('status', ['open'])
            ->orderBy('tanggal_berangkat')
            ->get()
            ->map(fn($k) => [
                'id'                => $k->id,
                'nama_paket'        => $k->paket?->nama_paket,
                'jenis'             => $k->paket?->jenis,
                'tanggal_berangkat' => $k->tanggal_berangkat,
                'tanggal_kembali'   => $k->tanggal_kembali ?? $k->tanggal_pulang,
                'kuota'             => $k->kuota,
                'sisa_kuota'        => max(0, ($k->kuota ?? 0) - ($k->terisi ?? 0)),
                'harga_dasar'       => (float) ($k->paket?->harga_dasar ?? 0),
            ]);

        return response()->json(['success' => true, 'data' => $list]);
    }

    // ═══════════════════════════════════════════════════════════
    // PENDAFTARAN (tidak berubah)
    // ═══════════════════════════════════════════════════════════

    public function pendaftaranIndex(Request $request)
    {
        $search = $request->search;
        $jenis  = $request->jenis;
        $status = $request->status;

        $pendaftarans = Pendaftaran::with('jamaah', 'keberangkatan.paket')
            ->when($search, fn($q) => $q->whereHas(
                'jamaah',
                fn($j) =>
                $j->where('nama_lengkap', 'like', "%$search%")
                    ->orWhere('nik', 'like', "%$search%")
            ))
            ->when($jenis,  fn($q) => $q->where('jenis', $jenis))
            ->when($status, fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate(15);

        $data = $pendaftarans->getCollection()
            ->map(fn($p) => $this->formatPendaftaran($p))
            ->values();

        return response()->json([
            'success' => true,
            'data'    => [
                'current_page' => $pendaftarans->currentPage(),
                'last_page'    => $pendaftarans->lastPage(),
                'total'        => $pendaftarans->total(),
                'data'         => $data,
            ],
        ]);
    }

    public function pendaftaranStore(Request $request)
    {
        $request->validate([
            'jamaah_id'        => 'required|exists:jamaah,id',
            'keberangkatan_id' => 'required|exists:keberangkatans,id',
            'jenis'            => 'required|in:umroh,haji',
            'harga_jual'       => 'required|numeric|min:0',
            'dp_minimal'       => 'nullable|numeric|min:0',
            'batas_pelunasan'  => 'nullable|date',
            'catatan'          => 'nullable|string',
        ]);

        $sudahDaftar = Pendaftaran::where('jamaah_id', $request->jamaah_id)
            ->where('keberangkatan_id', $request->keberangkatan_id)
            ->whereNotIn('status', ['batal'])
            ->exists();

        if ($sudahDaftar) {
            return response()->json([
                'success' => false,
                'message' => 'Jamaah sudah terdaftar di keberangkatan ini.',
            ], 422);
        }

        $pendaftaran = Pendaftaran::create([
            'no_pendaftaran'   => 'REG-' . strtoupper(uniqid()),
            'jamaah_id'        => $request->jamaah_id,
            'keberangkatan_id' => $request->keberangkatan_id,
            'jenis'            => $request->jenis,
            'harga_jual'       => $request->harga_jual,
            'dp_minimal'       => $request->dp_minimal ?? 0,
            'batas_pelunasan'  => $request->batas_pelunasan,
            'status'           => 'draft',
            'catatan'          => $request->catatan,
            'tanggal_daftar'   => now(),
        ]);

        $pendaftaran->load('jamaah', 'keberangkatan.paket');

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran berhasil dibuat.',
            'data'    => $this->formatPendaftaran($pendaftaran),
        ], 201);
    }

    // ═══════════════════════════════════════════════════════════
    // PEMBAYARAN (tidak berubah)
    // ═══════════════════════════════════════════════════════════

    public function pembayaranStore(Request $request)
    {
        $request->validate([
            'pendaftaran_id' => 'required|exists:pendaftarans,id',
            'jumlah_bayar'   => 'required|numeric|min:1',
            'tanggal_bayar'  => 'required|date',
            'metode_bayar'   => 'required|in:tunai,transfer,debit,kredit,qris',
            'jenis'          => 'required|in:dp,cicilan,pelunasan,lainnya',
            'bank_tujuan'    => 'nullable|string|max:100',
            'no_rekening'    => 'nullable|string|max:50',
            'nama_pengirim'  => 'nullable|string|max:255',
            'bukti_bayar'    => 'nullable|image|max:2048',
            'catatan'        => 'nullable|string',
        ]);

        $data                  = $request->except('bukti_bayar');
        $data['no_pembayaran'] = 'PAY-' . strtoupper(uniqid());
        $data['karyawan_id']   = $this->resolveKaryawanId();
        $data['status']        = 'diterima';

        if ($request->hasFile('bukti_bayar')) {
            $data['bukti_bayar'] = $request->file('bukti_bayar')->store('pembayaran', 'public');
        }

        $pembayaran = Pembayaran::create($data);
        $this->updateStatusPendaftaran($pembayaran->pendaftaran_id);

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil diinput.',
            'data'    => $this->formatPembayaran($pembayaran->load('pendaftaran.jamaah')),
        ], 201);
    }

    public function pembayaranIndex(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $pembayarans = Pembayaran::with('pendaftaran.jamaah')
            ->when($search, fn($q) => $q->whereHas(
                'pendaftaran.jamaah',
                fn($j) =>
                $j->where('nama_lengkap', 'like', "%$search%")
            ))
            ->when($status, fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate(15);

        $data = $pembayarans->getCollection()
            ->map(fn($p) => $this->formatPembayaran($p))
            ->values();

        return response()->json([
            'success' => true,
            'data'    => [
                'current_page' => $pembayarans->currentPage(),
                'last_page'    => $pembayarans->lastPage(),
                'total'        => $pembayarans->total(),
                'data'         => $data,
            ],
        ]);
    }

    // ═══════════════════════════════════════════════════════════
    // TABUNGAN — ENDPOINT BARU UNTUK KOLEKTOR
    // ═══════════════════════════════════════════════════════════

    /**
     * GET /api/v1/kolektor/tabungan
     * Daftar semua tabungan aktif (untuk kolektor melihat & menagih setoran).
     */
    public function tabunganIndex(Request $request)
    {
        $search = $request->search;
        $jenis  = $request->jenis;   // umroh / haji
        $status = $request->status;  // aktif / selesai / batal

        $tabungans = Tabungan::with('jamaah')
            ->when($search, fn($q) => $q->whereHas(
                'jamaah',
                fn($j) =>
                $j->where('nama_lengkap', 'like', "%$search%")
                    ->orWhere('nik', 'like', "%$search%")
            ))
            ->when($jenis,  fn($q) => $q->where('jenis', $jenis))
            ->when($status, fn($q) => $q->where('status', $status))
            ->when(!$status, fn($q) => $q->where('status', 'aktif')) // default aktif saja
            ->latest()
            ->paginate(20);

        $data = $tabungans->getCollection()
            ->map(fn($t) => $this->formatTabungan($t))
            ->values();

        return response()->json([
            'success' => true,
            'data'    => [
                'current_page' => $tabungans->currentPage(),
                'last_page'    => $tabungans->lastPage(),
                'total'        => $tabungans->total(),
                'data'         => $data,
            ],
        ]);
    }

    /**
     * GET /api/v1/kolektor/tabungan/{tabungan}
     * Detail tabungan beserta riwayat setoran yang pernah dicatat kolektor ini.
     */
    public function tabunganShow(Tabungan $tabungan)
    {
        // ✅ Load sekali saja, tidak perlu load ulang di bawah
        $tabungan->load([
            'jamaah',
            'setorans' => fn($q) => $q->with('karyawan')->orderByDesc('tanggal_setor'),
        ]);

        $kolektorId = $this->resolveKaryawanId();

        $setoranSaya = $tabungan->setorans
            ->where('karyawan_id', $kolektorId)
            ->values();

        return response()->json([
            'success' => true,
            'data'    => [
                ...$this->formatTabungan($tabungan),
                // ✅ Batasi field — jangan kirim semua relasi nested
                'setorans'     => $tabungan->setorans
                    ->take(50)  // batasi 50 terakhir
                    ->map(fn($s) => $this->formatSetoran($s))
                    ->values(),
                'setoran_saya' => $setoranSaya
                    ->map(fn($s) => $this->formatSetoran($s))
                    ->values(),
            ],
        ]);
    }

    /**
     * POST /api/v1/kolektor/tabungan/{tabungan}/setor
     * Kolektor mencatat setoran dari jamaah.
     * Status default: 'pending' — admin harus konfirmasi.
     */
    public function tabunganSetor(Request $request, Tabungan $tabungan)
    {
        if ($tabungan->status !== 'aktif') {
            return response()->json([
                'success' => false,
                'message' => 'Tabungan tidak aktif, setoran tidak dapat diproses.',
            ], 422);
        }

        $request->validate([
            'jumlah_setor'  => 'required|numeric|min:1',
            'tanggal_setor' => 'required|date',
            'metode'        => 'required|in:tunai,transfer,debit,kredit,qris',
            'bukti_setor'   => 'nullable|image|max:2048',
            'catatan'       => 'nullable|string',
        ]);

        $kolektorId = $this->resolveKaryawanId();

        $data = [
            'no_setoran'    => 'SET-' . strtoupper(uniqid()),
            'tabungan_id'   => $tabungan->id,
            'karyawan_id'   => $kolektorId,
            'jumlah_setor'  => $request->jumlah_setor,
            'tanggal_setor' => $request->tanggal_setor,
            'jenis'         => 'setor',
            'metode'        => $request->metode,
            // Kolektor hanya submit, admin yang konfirmasi
            'status'        => 'pending',
            'catatan'       => $request->catatan,
        ];

        if ($request->hasFile('bukti_setor')) {
            $data['bukti_setor'] = $request->file('bukti_setor')->store('setoran', 'public');
        }

        $setoran = Setoran::create($data);
        // Saldo BELUM berubah — baru berubah setelah admin konfirmasi

        return response()->json([
            'success' => true,
            'message' => 'Setoran berhasil dicatat. Menunggu konfirmasi admin.',
            'data'    => $this->formatSetoran($setoran->load('karyawan')),
        ], 201);
    }

    /**
     * GET /api/v1/kolektor/tabungan/setoran-saya
     * Semua setoran yang pernah diinput kolektor yang sedang login.
     */
    public function setoranSaya(Request $request)
    {
        $kolektorId = $this->resolveKaryawanId();

        if (!$kolektorId) {
            return response()->json([
                'success' => false,
                'message' => 'Data kolektor tidak ditemukan untuk akun ini.',
            ], 404);
        }

        $status = $request->status; // pending / diterima / ditolak
        $jenis  = $request->jenis;  // umroh / haji

        $setorans = Setoran::with(['tabungan.jamaah', 'karyawan'])
            ->where('karyawan_id', $kolektorId)
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($jenis,  fn($q) => $q->whereHas('tabungan', fn($t) => $t->where('jenis', $jenis)))
            ->latest()
            ->paginate(20);

        $data = $setorans->getCollection()->map(fn($s) => [
            ...$this->formatSetoran($s),
            'nama_jamaah'       => $s->tabungan?->jamaah?->nama_lengkap,
            'no_rekening'       => $s->tabungan?->no_rekening_tabungan,
            'jenis_tabungan'    => $s->tabungan?->jenis,
        ])->values();

        return response()->json([
            'success' => true,
            'data'    => [
                'current_page' => $setorans->currentPage(),
                'last_page'    => $setorans->lastPage(),
                'total'        => $setorans->total(),
                'data'         => $data,
            ],
        ]);
    }

    // ═══════════════════════════════════════════════════════════
    // PRIVATE HELPERS
    // ═══════════════════════════════════════════════════════════

    /**
     * Cari karyawan_id dari user yang sedang login.
     * Asumsi: tabel karyawans punya kolom user_id atau email.
     */
    private function resolveKaryawanId(): ?int
    {
        $user = Auth::user();
        if (!$user) return null;

        return Karyawan::where('email', $user->email)
            ->value('id');
    }

    private function updateStatusPendaftaran(int $pendaftaranId): void
    {
        $pendaftaran = Pendaftaran::with('pembayarans')->find($pendaftaranId);
        if (!$pendaftaran) return;

        $totalBayar = $pendaftaran->pembayarans
            ->where('status', 'diterima')
            ->sum('jumlah_bayar');

        if ($totalBayar >= $pendaftaran->harga_jual) {
            $pendaftaran->update(['status' => 'lunas']);
        } elseif ($totalBayar >= $pendaftaran->dp_minimal && $pendaftaran->dp_minimal > 0) {
            $pendaftaran->update(['status' => 'dp_terbayar']);
        } else {
            $pendaftaran->update(['status' => 'draft']);
        }
    }

    // ── Formatters ────────────────────────────────────────────────────────────

    private function formatTabungan(Tabungan $t): array
    {
        $persen = $t->target_tabungan > 0
            ? min(100, round(($t->saldo / $t->target_tabungan) * 100, 1))
            : 0;

        return [
            'id'                    => $t->id,
            'no_rekening_tabungan'  => $t->no_rekening_tabungan,
            'jenis'                 => $t->jenis,
            'saldo'                 => (float) $t->saldo,
            'target_tabungan'       => (float) $t->target_tabungan,
            'sisa_target'           => max(0, (float) $t->target_tabungan - (float) $t->saldo),
            'persen_tercapai'       => $persen,
            'tanggal_buka'          => $t->tanggal_buka?->format('Y-m-d'),
            'tanggal_target'        => $t->tanggal_target?->format('Y-m-d'),
            'status'                => $t->status,
            'catatan'               => $t->catatan,
            'nama_jamaah'           => $t->jamaah?->nama_lengkap,
            'nik_jamaah'            => $t->jamaah?->nik,
            'no_telepon_jamaah'     => $t->jamaah?->no_telepon,
        ];
    }

    private function formatSetoran(Setoran $s): array
    {
        return [
            'id'            => $s->id,
            'no_setoran'    => $s->no_setoran,
            'jumlah_setor'  => (float) $s->jumlah_setor,
            'tanggal_setor' => $s->tanggal_setor?->format('Y-m-d'),
            'jenis'         => $s->jenis,
            'metode'        => $s->metode,
            'status'        => $s->status,
            'catatan'       => $s->catatan,
            'bukti_setor'   => $s->bukti_setor ? asset('storage/' . $s->bukti_setor) : null,
            'nama_kolektor' => $s->karyawan?->nama,
            'created_at'    => $s->created_at?->toDateTimeString(),
        ];
    }

    private function formatJamaah(Jamaah $j): array
    {
        return [
            'id'            => $j->id,
            'kode_jamaah'   => $j->kode_jamaah,
            'nama_lengkap'  => $j->nama_lengkap,
            'nik'           => $j->nik,
            'no_passport'   => $j->no_passport,
            'jenis_kelamin' => $j->jenis_kelamin,
            'no_telepon'    => $j->no_telepon,
            'kota'          => $j->kota,
            'provinsi'      => $j->provinsi,
            'foto'          => $j->foto ? asset('storage/' . $j->foto) : null,
            'status'        => $j->status,
            'user_email'    => $j->user?->email,
            'pendaftarans'  => $j->pendaftarans
                ?->map(fn($p) => $this->formatPendaftaran($p))
                ->values() ?? [],
        ];
    }

    private function formatPendaftaran(Pendaftaran $p): array
    {
        $totalBayar  = $p->pembayarans?->where('status', 'diterima')->sum('jumlah_bayar') ?? 0;
        $sisaTagihan = max(0, $p->harga_jual - $totalBayar);

        return [
            'id'                => $p->id,
            'no_pendaftaran'    => $p->no_pendaftaran,
            'jenis'             => $p->jenis,
            'status'            => $p->status,
            'harga_jual'        => (float) $p->harga_jual,
            'total_bayar'       => (float) $totalBayar,
            'sisa_tagihan'      => (float) $sisaTagihan,
            'dp_minimal'        => (float) $p->dp_minimal,
            'batas_pelunasan'   => $p->batas_pelunasan,
            'tanggal_daftar'    => $p->tanggal_daftar,
            'nama_jamaah'       => $p->jamaah?->nama_lengkap,
            'nik_jamaah'        => $p->jamaah?->nik,
            'nama_paket'        => $p->keberangkatan?->paket?->nama_paket,
            'tanggal_berangkat' => $p->keberangkatan?->tanggal_berangkat,
        ];
    }

    private function formatPembayaran(Pembayaran $p): array
    {
        return [
            'id'             => $p->id,
            'no_pembayaran'  => $p->no_pembayaran,
            'jumlah_bayar'   => (float) $p->jumlah_bayar,
            'tanggal_bayar'  => $p->tanggal_bayar,
            'metode_bayar'   => $p->metode_bayar,
            'jenis'          => $p->jenis,
            'status'         => $p->status,
            'catatan'        => $p->catatan,
            'bukti_bayar'    => $p->bukti_bayar ? asset('storage/' . $p->bukti_bayar) : null,
            'nama_jamaah'    => $p->pendaftaran?->jamaah?->nama_lengkap,
            'no_pendaftaran' => $p->pendaftaran?->no_pendaftaran,
            'created_at'     => $p->created_at?->toDateTimeString(),
        ];
    }

    /**
     * POST /api/v1/kolektor/tabungan
     * Kolektor membuka tabungan baru untuk jamaah.
     */
    public function tabunganStore(Request $request)
    {
        $request->validate([
            'jamaah_id'       => 'required|exists:jamaah,id',
            'jenis'           => 'required|in:umroh,haji',
            'target_tabungan' => 'required|numeric|min:1',
            'tanggal_target'  => 'nullable|date|after:today',
            'catatan'         => 'nullable|string',
        ]);

        // Cek apakah jamaah sudah punya tabungan aktif jenis yang sama
        $sudahAda = Tabungan::where('jamaah_id', $request->jamaah_id)
            ->where('jenis', $request->jenis)
            ->where('status', 'aktif')
            ->exists();

        if ($sudahAda) {
            return response()->json([
                'success' => false,
                'message' => 'Jamaah sudah memiliki tabungan ' . $request->jenis . ' yang aktif.',
            ], 422);
        }

        $tabungan = Tabungan::create([
            'no_rekening_tabungan' => 'TAB-' . strtoupper(uniqid()),
            'jamaah_id'            => $request->jamaah_id,
            'jenis'                => $request->jenis,
            'target_tabungan'      => $request->target_tabungan,
            'saldo'                => 0,
            'tanggal_buka'         => now()->toDateString(),
            'tanggal_target'       => $request->tanggal_target,
            'status'               => 'aktif',
            'catatan'              => $request->catatan,
        ]);

        $tabungan->load('jamaah');

        return response()->json([
            'success' => true,
            'message' => 'Tabungan berhasil dibuka.',
            'data'    => $this->formatTabungan($tabungan),
        ], 201);
    }
}
