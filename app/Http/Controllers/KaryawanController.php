<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::latest()->paginate(10);
        return view('karyawan.index', compact('karyawans'));
    }

    public function create()
    {
        return view('karyawan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap'   => 'required|string|max:255',
            'nik'            => 'required|string|size:16|unique:karyawans',
            'jabatan'        => 'required|string|max:100',
            'no_telepon'     => 'nullable|string|max:20',
            'email'          => 'nullable|email|unique:karyawans',
            'alamat'         => 'nullable|string',
            'tanggal_masuk'  => 'required|date',
            'status'         => 'required|in:aktif,nonaktif',
            'foto'           => 'nullable|image|max:2048',
        ]);

        $data = $request->except('foto');
        $data['kode_karyawan'] = 'KRY-' . strtoupper(uniqid());

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('karyawan', 'public');
        }

        Karyawan::create($data);
        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    public function show(Karyawan $karyawan)
    {
        return view('karyawan.show', compact('karyawan'));
    }

    public function edit(Karyawan $karyawan)
    {
        return view('karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $request->validate([
            'nama_lengkap'   => 'required|string|max:255',
            'nik'            => 'required|string|size:16|unique:karyawans,nik,' . $karyawan->id,
            'jabatan'        => 'required|string|max:100',
            'no_telepon'     => 'nullable|string|max:20',
            'email'          => 'nullable|email|unique:karyawans,email,' . $karyawan->id,
            'alamat'         => 'nullable|string',
            'tanggal_masuk'  => 'required|date',
            'status'         => 'required|in:aktif,nonaktif',
            'foto'           => 'nullable|image|max:2048',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            if ($karyawan->foto) Storage::disk('public')->delete($karyawan->foto);
            $data['foto'] = $request->file('foto')->store('karyawan', 'public');
        }

        $karyawan->update($data);
        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy(Karyawan $karyawan)
    {
        if ($karyawan->foto) Storage::disk('public')->delete($karyawan->foto);
        $karyawan->delete();
        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil dihapus.');
    }
}
