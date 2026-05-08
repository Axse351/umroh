<?php

namespace App\Http\Controllers;

use App\Models\Jamaah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class JamaahController extends Controller
{
    public function index(Request $request)
    {
        $jenis  = $request->jenis;
        $search = $request->search;

        $jamaah = Jamaah::when($search, fn($q) => $q
            ->where('nama_lengkap', 'like', "%$search%")
            ->orWhere('nik', 'like', "%$search%")
            ->orWhere('no_passport', 'like', "%$search%")
        )
        ->when($jenis, fn($q) => $q
            ->whereHas('pendaftarans', fn($p) => $p->where('jenis', $jenis))
        )
        ->with('user') // ← load relasi user
        ->latest()
        ->paginate(10);

        return view('jamaah.index', compact('jamaah', 'jenis', 'search'));
    }

    public function create()
    {
        return view('jamaah.create');
    }

    /**
     * Simpan jamaah + otomatis buat akun user.
     * Password default: NIK jamaah.
     * Jika email tidak diisi, generate email dummy.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap'  => 'required|string|max:255',
            'nik'           => 'required|string|size:16|unique:jamaah',
            'no_passport'   => 'nullable|string|unique:jamaah',
            'exp_passport'  => 'nullable|date',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'tempat_lahir'  => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'alamat'        => 'required|string',
            'kota'          => 'required|string|max:100',
            'provinsi'      => 'required|string|max:100',
            'no_telepon'    => 'required|string|max:20',
            'email'         => 'nullable|email|unique:users,email',
            'foto'          => 'nullable|image|max:2048',
            'foto_passport' => 'nullable|image|max:2048',
            'foto_ktp'      => 'nullable|image|max:2048',
        ]);

        // Pakai DB transaction agar jamaah & user dibuat atomik
        DB::transaction(function () use ($request) {
            $data                = $request->except(['foto', 'foto_passport', 'foto_ktp']);
            $data['kode_jamaah'] = 'JMH-' . strtoupper(uniqid());

            foreach (['foto', 'foto_passport', 'foto_ktp'] as $field) {
                if ($request->hasFile($field)) {
                    $data[$field] = $request->file($field)->store('jamaah', 'public');
                }
            }

            // 1. Buat jamaah dulu
            $jamaah = Jamaah::create($data);

            // 2. Tentukan email & password untuk akun user
            $email    = $request->email
                        ?? Str::slug($request->nama_lengkap) . '_' . $request->nik . '@jamaah.local';
            $password = $request->nik; // default password = NIK

            // 3. Buat user dengan role 'user', tautkan ke jamaah
            User::create([
                'name'       => $request->nama_lengkap,
                'email'      => $email,
                'password'   => Hash::make($password),
                'role'       => 'user',
                'jamaah_id'  => $jamaah->id,
            ]);
        });

        return redirect()
            ->route('admin.jamaah.index')
            ->with('success', 'Data jamaah & akun user berhasil dibuat. Password default: NIK jamaah.');
    }

    public function show(Jamaah $jamaah)
    {
        $jamaah->load('pendaftarans.keberangkatan.paket', 'tabungans', 'dokumens', 'user');
        return view('jamaah.show', compact('jamaah'));
    }

    public function edit(Jamaah $jamaah)
    {
        return view('jamaah.edit', compact('jamaah'));
    }

    public function update(Request $request, Jamaah $jamaah)
    {
        $request->validate([
            'nama_lengkap'  => 'required|string|max:255',
            'nik'           => 'required|string|size:16|unique:jamaah,nik,' . $jamaah->id,
            'no_passport'   => 'nullable|string|unique:jamaah,no_passport,' . $jamaah->id,
            'exp_passport'  => 'nullable|date',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'tempat_lahir'  => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'alamat'        => 'required|string',
            'kota'          => 'required|string|max:100',
            'provinsi'      => 'required|string|max:100',
            'no_telepon'    => 'required|string|max:20',
            'email'         => 'nullable|email',
            'foto'          => 'nullable|image|max:2048',
            'foto_passport' => 'nullable|image|max:2048',
            'foto_ktp'      => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['foto', 'foto_passport', 'foto_ktp']);

        foreach (['foto', 'foto_passport', 'foto_ktp'] as $field) {
            if ($request->hasFile($field)) {
                if ($jamaah->$field) Storage::disk('public')->delete($jamaah->$field);
                $data[$field] = $request->file($field)->store('jamaah', 'public');
            }
        }

        $jamaah->update($data);

        // Sinkron nama & email di tabel users juga
        if ($jamaah->user) {
            $jamaah->user->update([
                'name'  => $request->nama_lengkap,
                'email' => $request->email ?? $jamaah->user->email,
            ]);
        }

        return redirect()
            ->route('admin.jamaah.index')
            ->with('success', 'Data jamaah berhasil diperbarui.');
    }

    public function destroy(Jamaah $jamaah)
    {
        foreach (['foto', 'foto_passport', 'foto_ktp'] as $field) {
            if ($jamaah->$field) Storage::disk('public')->delete($jamaah->$field);
        }

        // User akan ter-nullify otomatis karena nullOnDelete() di migration
        $jamaah->delete();

        return redirect()
            ->route('admin.jamaah.index')
            ->with('success', 'Data jamaah berhasil dihapus.');
    }
}
