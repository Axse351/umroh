<?php

namespace App\Http\Controllers;

use App\Models\Jamaah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JamaahController extends Controller
{
    public function index(Request $request)
    {
        $jenis = $request->jenis; // umroh / haji (filter via pendaftaran)
        $search = $request->search;

        $jamaah = Jamaah::when($search, function ($q) use ($search) {
            $q->where('nama_lengkap', 'like', "%$search%")
                ->orWhere('nik', 'like', "%$search%")
                ->orWhere('no_passport', 'like', "%$search%");
        })
            ->when($jenis, function ($q) use ($jenis) {
                $q->whereHas('pendaftarans', fn($p) => $p->where('jenis', $jenis));
            })
            ->latest()->paginate(10);

        return view('jamaah.index', compact('jamaah', 'jenis', 'search'));
    }

    public function create()
    {
        return view('jamaah.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap'   => 'required|string|max:255',
            'nik'            => 'required|string|size:16|unique:jamaah',
            'no_passport'    => 'nullable|string|unique:jamaah',
            'exp_passport'   => 'nullable|date',
            'jenis_kelamin'  => 'required|in:laki-laki,perempuan',
            'tempat_lahir'   => 'required|string|max:100',
            'tanggal_lahir'  => 'required|date',
            'alamat'         => 'required|string',
            'kota'           => 'required|string|max:100',
            'provinsi'       => 'required|string|max:100',
            'no_telepon'     => 'required|string|max:20',
            'email'          => 'nullable|email',
            'foto'           => 'nullable|image|max:2048',
            'foto_passport'  => 'nullable|image|max:2048',
            'foto_ktp'       => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['foto', 'foto_passport', 'foto_ktp']);
        $data['kode_jamaah'] = 'JMH-' . strtoupper(uniqid());

        foreach (['foto', 'foto_passport', 'foto_ktp'] as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('jamaah', 'public');
            }
        }

        Jamaah::create($data);
        return redirect()->route('jamaah.index')->with('success', 'Data jamaah berhasil ditambahkan.');
    }

    public function show(Jamaah $jamaah)
    {
        $jamaah->load('pendaftarans.keberangkatan.paket', 'tabungans', 'dokumens');
        return view('jamaah.show', compact('jamaah'));
    }

    public function edit(Jamaah $jamaah)
    {
        return view('jamaah.edit', compact('jamaah'));
    }

    public function update(Request $request, Jamaah $jamaah)
    {
        $request->validate([
            'nama_lengkap'   => 'required|string|max:255',
            'nik'            => 'required|string|size:16|unique:jamaah,nik,' . $jamaah->id,
            'no_passport'    => 'nullable|string|unique:jamaah,no_passport,' . $jamaah->id,
            'exp_passport'   => 'nullable|date',
            'jenis_kelamin'  => 'required|in:laki-laki,perempuan',
            'tempat_lahir'   => 'required|string|max:100',
            'tanggal_lahir'  => 'required|date',
            'alamat'         => 'required|string',
            'kota'           => 'required|string|max:100',
            'provinsi'       => 'required|string|max:100',
            'no_telepon'     => 'required|string|max:20',
            'email'          => 'nullable|email',
            'foto'           => 'nullable|image|max:2048',
            'foto_passport'  => 'nullable|image|max:2048',
            'foto_ktp'       => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['foto', 'foto_passport', 'foto_ktp']);

        foreach (['foto', 'foto_passport', 'foto_ktp'] as $field) {
            if ($request->hasFile($field)) {
                if ($jamaah->$field) Storage::disk('public')->delete($jamaah->$field);
                $data[$field] = $request->file($field)->store('jamaah', 'public');
            }
        }

        $jamaah->update($data);
        return redirect()->route('jamaah.index')->with('success', 'Data jamaah berhasil diperbarui.');
    }

    public function destroy(Jamaah $jamaah)
    {
        foreach (['foto', 'foto_passport', 'foto_ktp'] as $field) {
            if ($jamaah->$field) Storage::disk('public')->delete($jamaah->$field);
        }
        $jamaah->delete();
        return redirect()->route('jamaah.index')->with('success', 'Data jamaah berhasil dihapus.');
    }
}
