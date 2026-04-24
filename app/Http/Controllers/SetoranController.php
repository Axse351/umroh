<?php

namespace App\Http\Controllers;

use App\Models\Setoran;
use App\Models\Tabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SetoranController extends Controller
{
    public function index(Request $request)
    {
        $jenis = $request->jenis;
        $setorans = Setoran::with('tabungan.jamaah')
            ->when($jenis, fn($q) => $q->whereHas('tabungan', fn($t) => $t->where('jenis', $jenis)))
            ->latest()->paginate(10);
        return view('setoran.index', compact('setorans', 'jenis'));
    }

    public function create(Request $request)
    {
        $tabungans  = Tabungan::with('jamaah')->where('status', 'aktif')->get();
        $tabungan_id = $request->tabungan_id;
        return view('setoran.create', compact('tabungans', 'tabungan_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tabungan_id'   => 'required|exists:tabungans,id',
            'jumlah_setor'  => 'required|numeric|min:1',
            'tanggal_setor' => 'required|date',
            'jenis'         => 'required|in:setor,tarik',
            'metode'        => 'required|in:tunai,transfer,debit,qris',
            'bukti_setor'   => 'nullable|image|max:2048',
            'catatan'       => 'nullable|string',
        ]);

        $data = $request->except('bukti_setor');
        $data['no_setoran']  = 'SET-' . strtoupper(uniqid());
        $data['karyawan_id'] = auth()->user()->karyawan->id ?? null;
        $data['status']      = 'diterima';

        if ($request->hasFile('bukti_setor')) {
            $data['bukti_setor'] = $request->file('bukti_setor')->store('setoran', 'public');
        }

        $setoran  = Setoran::create($data);
        $tabungan = $setoran->tabungan;

        // Update saldo tabungan
        if ($data['jenis'] === 'setor') {
            $tabungan->increment('saldo', $data['jumlah_setor']);
        } else {
            $tabungan->decrement('saldo', $data['jumlah_setor']);
        }

        // Tandai selesai jika target terpenuhi
        if ($tabungan->fresh()->saldo >= $tabungan->target_tabungan) {
            $tabungan->update(['status' => 'selesai']);
        }

        return redirect()->route('setoran.index')->with('success', 'Data setoran berhasil ditambahkan.');
    }

    public function show(Setoran $setoran)
    {
        $setoran->load('tabungan.jamaah', 'karyawan');
        return view('setoran.show', compact('setoran'));
    }

    public function destroy(Setoran $setoran)
    {
        // Rollback saldo
        $tabungan = $setoran->tabungan;
        if ($setoran->jenis === 'setor') {
            $tabungan->decrement('saldo', $setoran->jumlah_setor);
        } else {
            $tabungan->increment('saldo', $setoran->jumlah_setor);
        }

        if ($setoran->bukti_setor) Storage::disk('public')->delete($setoran->bukti_setor);
        $setoran->delete();
        return redirect()->route('setoran.index')->with('success', 'Data setoran berhasil dihapus.');
    }
}
