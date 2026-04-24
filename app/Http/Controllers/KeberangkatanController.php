<?php

namespace App\Http\Controllers;

use App\Models\Keberangkatan;
use App\Models\Karyawan;
use App\Models\Paket;
use Illuminate\Http\Request;

class KeberangkatanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;
        $keberangkatans = Keberangkatan::with('paket', 'pembimbing')
            ->when($status, fn($q) => $q->where('status', $status))
            ->latest()->paginate(10);
        return view('keberangkatan.index', compact('keberangkatans', 'status'));
    }

    public function create()
    {
        $pakets     = Paket::where('status', 'aktif')->get();
        $karyawans  = Karyawan::where('status', 'aktif')->get();
        return view('keberangkatan.create', compact('pakets', 'karyawans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paket_id'                  => 'required|exists:pakets,id',
            'tanggal_berangkat'         => 'required|date',
            'tanggal_pulang'            => 'required|date|after:tanggal_berangkat',
            'bandara_keberangkatan'     => 'required|string|max:10',
            'no_penerbangan_pergi'      => 'nullable|string|max:20',
            'no_penerbangan_pulang'     => 'nullable|string|max:20',
            'kuota'                     => 'required|integer|min:1',
            'harga_double'              => 'required|numeric|min:0',
            'harga_triple'              => 'required|numeric|min:0',
            'harga_quad'                => 'required|numeric|min:0',
            'pembimbing_id'             => 'nullable|exists:karyawans,id',
            'status'                    => 'required|in:open,closed,berangkat,selesai,batal',
            'catatan'                   => 'nullable|string',
        ]);

        $data = $request->all();
        $data['kode_keberangkatan'] = 'KBR-' . strtoupper(uniqid());

        Keberangkatan::create($data);
        return redirect()->route('keberangkatan.index')->with('success', 'Data keberangkatan berhasil ditambahkan.');
    }

    public function show(Keberangkatan $keberangkatan)
    {
        $keberangkatan->load('paket', 'pembimbing', 'pendaftarans.jamaah');
        return view('keberangkatan.show', compact('keberangkatan'));
    }

    public function edit(Keberangkatan $keberangkatan)
    {
        $pakets    = Paket::where('status', 'aktif')->get();
        $karyawans = Karyawan::where('status', 'aktif')->get();
        return view('keberangkatan.edit', compact('keberangkatan', 'pakets', 'karyawans'));
    }

    public function update(Request $request, Keberangkatan $keberangkatan)
    {
        $request->validate([
            'paket_id'              => 'required|exists:pakets,id',
            'tanggal_berangkat'     => 'required|date',
            'tanggal_pulang'        => 'required|date|after:tanggal_berangkat',
            'bandara_keberangkatan' => 'required|string|max:10',
            'kuota'                 => 'required|integer|min:1',
            'harga_double'          => 'required|numeric|min:0',
            'harga_triple'          => 'required|numeric|min:0',
            'harga_quad'            => 'required|numeric|min:0',
            'pembimbing_id'         => 'nullable|exists:karyawans,id',
            'status'                => 'required|in:open,closed,berangkat,selesai,batal',
            'catatan'               => 'nullable|string',
        ]);

        $keberangkatan->update($request->all());
        return redirect()->route('keberangkatan.index')->with('success', 'Data keberangkatan berhasil diperbarui.');
    }

    public function destroy(Keberangkatan $keberangkatan)
    {
        $keberangkatan->delete();
        return redirect()->route('keberangkatan.index')->with('success', 'Data keberangkatan berhasil dihapus.');
    }
}
