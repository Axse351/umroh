<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function index(Request $request)
    {
        $jenis = $request->jenis;
        $layanans = Layanan::when($jenis, fn($q) => $q->where('jenis', $jenis))
            ->latest()->paginate(10);
        return view('layanan.index', compact('layanans', 'jenis'));
    }

    public function create()
    {
        return view('layanan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'jenis'        => 'required|in:umroh,haji,keduanya',
            'kategori'     => 'required|in:visa,asuransi,vaksin,manasik,perlengkapan,transportasi,lainnya',
            'harga'        => 'required|numeric|min:0',
            'deskripsi'    => 'nullable|string',
            'status'       => 'required|in:aktif,nonaktif',
        ]);

        $data = $request->all();
        $data['kode_layanan'] = 'LAY-' . strtoupper(uniqid());

        Layanan::create($data);
        return redirect()->route('layanan.index')->with('success', 'Data layanan berhasil ditambahkan.');
    }

    public function show(Layanan $layanan)
    {
        $layanan->load('transaksiLayanans.pendaftaran.jamaah');
        return view('layanan.show', compact('layanan'));
    }

    public function edit(Layanan $layanan)
    {
        return view('layanan.edit', compact('layanan'));
    }

    public function update(Request $request, Layanan $layanan)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'jenis'        => 'required|in:umroh,haji,keduanya',
            'kategori'     => 'required|in:visa,asuransi,vaksin,manasik,perlengkapan,transportasi,lainnya',
            'harga'        => 'required|numeric|min:0',
            'deskripsi'    => 'nullable|string',
            'status'       => 'required|in:aktif,nonaktif',
        ]);

        $layanan->update($request->all());
        return redirect()->route('layanan.index')->with('success', 'Data layanan berhasil diperbarui.');
    }

    public function destroy(Layanan $layanan)
    {
        $layanan->delete();
        return redirect()->route('layanan.index')->with('success', 'Data layanan berhasil dihapus.');
    }
}
