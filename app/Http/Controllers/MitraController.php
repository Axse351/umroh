<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use Illuminate\Http\Request;

class MitraController extends Controller
{
    public function index(Request $request)
    {
        $jenis  = $request->jenis;
        $mitras = Mitra::when($jenis, fn($q) => $q->where('jenis', $jenis))
            ->latest()->paginate(10);
        return view('mitra.index', compact('mitras', 'jenis'));
    }

    public function create()
    {
        return view('mitra.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mitra'  => 'required|string|max:255',
            'jenis'       => 'required|in:bank,asuransi,supplier,partner,lainnya',
            'nama_pic'    => 'nullable|string|max:255',
            'no_telepon'  => 'nullable|string|max:20',
            'email'       => 'nullable|email',
            'alamat'      => 'nullable|string',
            'keterangan'  => 'nullable|string',
            'status'      => 'required|in:aktif,nonaktif',
        ]);

        $data = $request->all();
        $data['kode_mitra'] = 'MTR-' . strtoupper(uniqid());

        Mitra::create($data);
        return redirect()->route('mitra.index')->with('success', 'Data mitra berhasil ditambahkan.');
    }

    public function show(Mitra $mitra)
    {
        return view('mitra.show', compact('mitra'));
    }

    public function edit(Mitra $mitra)
    {
        return view('mitra.edit', compact('mitra'));
    }

    public function update(Request $request, Mitra $mitra)
    {
        $request->validate([
            'nama_mitra'  => 'required|string|max:255',
            'jenis'       => 'required|in:bank,asuransi,supplier,partner,lainnya',
            'nama_pic'    => 'nullable|string|max:255',
            'no_telepon'  => 'nullable|string|max:20',
            'email'       => 'nullable|email',
            'alamat'      => 'nullable|string',
            'keterangan'  => 'nullable|string',
            'status'      => 'required|in:aktif,nonaktif',
        ]);

        $mitra->update($request->all());
        return redirect()->route('mitra.index')->with('success', 'Data mitra berhasil diperbarui.');
    }

    public function destroy(Mitra $mitra)
    {
        $mitra->delete();
        return redirect()->route('mitra.index')->with('success', 'Data mitra berhasil dihapus.');
    }
}
