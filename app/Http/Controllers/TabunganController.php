<?php

namespace App\Http\Controllers;

use App\Models\Jamaah;
use App\Models\Tabungan;
use Illuminate\Http\Request;

class TabunganController extends Controller
{
    public function index(Request $request)
    {
        $jenis = $request->jenis;
        $tabungans = Tabungan::with('jamaah')
            ->when($jenis, fn($q) => $q->where('jenis', $jenis))
            ->latest()->paginate(10);
        return view('tabungan.index', compact('tabungans', 'jenis'));
    }

    public function create(Request $request)
    {
        $jamaah = Jamaah::where('status', 'aktif')->get();
        $jenis  = $request->jenis ?? 'umroh';
        return view('tabungan.create', compact('jamaah', 'jenis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jamaah_id'       => 'required|exists:jamaah,id',
            'jenis'           => 'required|in:umroh,haji',
            'target_tabungan' => 'required|numeric|min:1',
            'tanggal_buka'    => 'required|date',
            'tanggal_target'  => 'nullable|date|after:tanggal_buka',
            'catatan'         => 'nullable|string',
        ]);

        $data = $request->all();
        $data['no_rekening_tabungan'] = 'TAB-' . strtoupper(uniqid());
        $data['saldo']  = 0;
        $data['status'] = 'aktif';

        Tabungan::create($data);
        return redirect()->route('tabungan.index')->with('success', 'Rekening tabungan berhasil dibuat.');
    }

    public function show(Tabungan $tabungan)
    {
        $tabungan->load('jamaah', 'setorans');
        return view('tabungan.show', compact('tabungan'));
    }

    public function edit(Tabungan $tabungan)
    {
        $jamaah = Jamaah::where('status', 'aktif')->get();
        return view('tabungan.edit', compact('tabungan', 'jamaah'));
    }

    public function update(Request $request, Tabungan $tabungan)
    {
        $request->validate([
            'target_tabungan' => 'required|numeric|min:1',
            'tanggal_target'  => 'nullable|date',
            'status'          => 'required|in:aktif,selesai,batal',
            'catatan'         => 'nullable|string',
        ]);

        $tabungan->update($request->all());
        return redirect()->route('tabungan.index')->with('success', 'Data tabungan berhasil diperbarui.');
    }

    public function destroy(Tabungan $tabungan)
    {
        $tabungan->delete();
        return redirect()->route('tabungan.index')->with('success', 'Data tabungan berhasil dihapus.');
    }
}
