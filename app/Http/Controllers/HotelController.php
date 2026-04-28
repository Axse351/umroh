<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index(Request $request)
    {
        $lokasi = $request->lokasi;
        $hotels = Hotel::when($lokasi, fn($q) => $q->where('lokasi', $lokasi))
            ->latest()->paginate(10);
        return view('hotel.index', compact('hotels', 'lokasi'));
    }

    public function create()
    {
        return view('hotel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_hotel'            => 'required|string|max:255',
            'lokasi'                => 'required|in:mekkah,madinah,jeddah',
            'bintang'               => 'required|integer|min:1|max:5',
            'jarak_ke_masjid_meter' => 'nullable|numeric|min:0',
            'no_telepon'            => 'nullable|string|max:20',
            'alamat'                => 'nullable|string',
            'fasilitas'             => 'nullable|string',
            'status'                => 'required|in:aktif,nonaktif',
        ]);

        $data = $request->all();
        $data['kode_hotel'] = 'HTL-' . strtoupper(uniqid());

        Hotel::create($data);
        return redirect()->route('hotel.index')->with('success', 'Data hotel berhasil ditambahkan.');
    }

    public function show(Hotel $hotel)
    {
        $hotel->load('paketSebagaiMekkah', 'paketSebagaiMadinah');
        return view('hotel.show', compact('hotel'));
    }

    public function edit(Hotel $hotel)
    {
        return view('hotel.edit', compact('hotel'));
    }

    public function update(Request $request, Hotel $hotel)
    {
        $request->validate([
            'nama_hotel'            => 'required|string|max:255',
            'lokasi'                => 'required|in:mekkah,madinah,jeddah',
            'bintang'               => 'required|integer|min:1|max:5',
            'jarak_ke_masjid_meter' => 'nullable|numeric|min:0',
            'no_telepon'            => 'nullable|string|max:20',
            'alamat'                => 'nullable|string',
            'fasilitas'             => 'nullable|string',
            'status'                => 'required|in:aktif,nonaktif',
        ]);

        $hotel->update($request->all());
        return redirect()->route('hotel.index')->with('success', 'Data hotel berhasil diperbarui.');
    }

    public function destroy(Hotel $hotel)
    {
        $hotel->delete();
        return redirect()->route('hotel.index')->with('success', 'Data hotel berhasil dihapus.');
    }
}
