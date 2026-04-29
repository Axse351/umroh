<?php

namespace App\Http\Controllers;

use App\Models\Maskapai;
use Illuminate\Http\Request;

class MaskapaiController extends Controller
{
    public function index()
    {
        $maskapais = Maskapai::latest()->paginate(10);
        return view('maskapai.index', compact('maskapais'));
    }

    public function create()
    {
        return view('maskapai.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_maskapai' => 'required|string|max:255',
            'kode_iata'     => 'nullable|string|max:5',
            'no_telepon'    => 'nullable|string|max:20',
            'email'         => 'nullable|email',
            'website'       => 'nullable|url',
            'status'        => 'required|in:aktif,nonaktif',
        ]);

        $data = $request->all();
        $data['kode_maskapai'] = 'MSK-' . strtoupper(uniqid());

        Maskapai::create($data);
        return redirect()->route('admin.maskapai.index')->with('success', 'Data maskapai berhasil ditambahkan.');
    }

    public function show(Maskapai $maskapai)
    {
        $maskapai->load('pakets');
        return view('maskapai.show', compact('maskapai'));
    }

    public function edit(Maskapai $maskapai)
    {
        return view('maskapai.edit', compact('maskapai'));
    }

    public function update(Request $request, Maskapai $maskapai)
    {
        $request->validate([
            'nama_maskapai' => 'required|string|max:255',
            'kode_iata'     => 'nullable|string|max:5',
            'no_telepon'    => 'nullable|string|max:20',
            'email'         => 'nullable|email',
            'website'       => 'nullable|url',
            'status'        => 'required|in:aktif,nonaktif',
        ]);

        $maskapai->update($request->all());
        return redirect()->route('admin.maskapai.index')->with('success', 'Data maskapai berhasil diperbarui.');
    }

    public function destroy(Maskapai $maskapai)
    {
        $maskapai->delete();
        return redirect()->route('admin.maskapai.index')->with('success', 'Data maskapai berhasil dihapus.');
    }
}
