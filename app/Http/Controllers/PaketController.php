<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Maskapai;
use App\Models\Paket;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    public function index(Request $request)
    {
        $jenis = $request->jenis;
        $pakets = Paket::with('maskapai', 'hotelMekkah', 'hotelMadinah')
            ->when($jenis, fn($q) => $q->where('jenis', $jenis))
            ->latest()->paginate(10);
        return view('paket.index', compact('pakets', 'jenis'));
    }

    public function create()
    {
        $maskapais = Maskapai::where('status', 'aktif')->get();
        $hotels    = Hotel::where('status', 'aktif')->get();
        return view('paket.create', compact('maskapais', 'hotels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_paket'       => 'required|string|max:255',
            'jenis'            => 'required|in:umroh,haji,haji_plus,haji_furoda',
            'kategori'         => 'required|in:regular,plus,vip,furoda',
            'durasi_hari'      => 'required|integer|min:1',
            'maskapai_id'      => 'required|exists:maskapais,id',
            'hotel_mekkah_id'  => 'required|exists:hotels,id',
            'hotel_madinah_id' => 'required|exists:hotels,id',
            'kapasitas'        => 'required|integer|min:1',
            'harga_double'     => 'required|numeric|min:0',
            'harga_triple'     => 'required|numeric|min:0',
            'harga_quad'       => 'required|numeric|min:0',
            'include'          => 'nullable|string',
            'exclude'          => 'nullable|string',
            'itinerary'        => 'nullable|string',
            'status'           => 'required|in:aktif,nonaktif',
        ]);

        $data = $request->all();
        $data['kode_paket'] = 'PKT-' . strtoupper(uniqid());

        Paket::create($data);
        return redirect()->route('paket.index')->with('success', 'Data paket berhasil ditambahkan.');
    }

    public function show(Paket $paket)
    {
        $paket->load('maskapai', 'hotelMekkah', 'hotelMadinah', 'keberangkatans');
        return view('paket.show', compact('paket'));
    }

    public function edit(Paket $paket)
    {
        $maskapais = Maskapai::where('status', 'aktif')->get();
        $hotels    = Hotel::where('status', 'aktif')->get();
        return view('paket.edit', compact('paket', 'maskapais', 'hotels'));
    }

    public function update(Request $request, Paket $paket)
    {
        $request->validate([
            'nama_paket'       => 'required|string|max:255',
            'jenis'            => 'required|in:umroh,haji,haji_plus,haji_furoda',
            'kategori'         => 'required|in:regular,plus,vip,furoda',
            'durasi_hari'      => 'required|integer|min:1',
            'maskapai_id'      => 'required|exists:maskapais,id',
            'hotel_mekkah_id'  => 'required|exists:hotels,id',
            'hotel_madinah_id' => 'required|exists:hotels,id',
            'kapasitas'        => 'required|integer|min:1',
            'harga_double'     => 'required|numeric|min:0',
            'harga_triple'     => 'required|numeric|min:0',
            'harga_quad'       => 'required|numeric|min:0',
            'include'          => 'nullable|string',
            'exclude'          => 'nullable|string',
            'itinerary'        => 'nullable|string',
            'status'           => 'required|in:aktif,nonaktif',
        ]);

        $paket->update($request->all());
        return redirect()->route('paket.index')->with('success', 'Data paket berhasil diperbarui.');
    }

    public function destroy(Paket $paket)
    {
        $paket->delete();
        return redirect()->route('paket.index')->with('success', 'Data paket berhasil dihapus.');
    }
}
