<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Pendaftaran;
use App\Models\TransaksiLayanan;
use Illuminate\Http\Request;

class TransaksiLayananController extends Controller
{
    public function index(Request $request)
    {
        $jenis = $request->jenis;
        $transaksis = TransaksiLayanan::with('pendaftaran.jamaah', 'layanan')
            ->when($jenis, fn($q) => $q->whereHas('layanan', fn($l) => $l->where('jenis', $jenis)))
            ->latest()->paginate(10);
        return view('transaksi-layanan.index', compact('transaksis', 'jenis'));
    }

    public function create(Request $request)
    {
        $pendaftarans = Pendaftaran::with('jamaah')
            ->whereNotIn('status', ['batal', 'refund'])->get();
        $layanans       = Layanan::where('status', 'aktif')->get();
        $pendaftaran_id = $request->pendaftaran_id;
        return view('transaksi-layanan.create', compact('pendaftarans', 'layanans', 'pendaftaran_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pendaftaran_id'     => 'required|exists:pendaftarans,id',
            'layanan_id'         => 'required|exists:layanans,id',
            'qty'                => 'required|integer|min:1',
            'harga_satuan'       => 'required|numeric|min:0',
            'tanggal_transaksi'  => 'required|date',
            'status'             => 'required|in:pending,proses,selesai,batal',
            'catatan'            => 'nullable|string',
        ]);

        $data = $request->all();
        $data['no_transaksi'] = 'TRL-' . strtoupper(uniqid());
        $data['total_harga']  = $data['qty'] * $data['harga_satuan'];

        TransaksiLayanan::create($data);
        return redirect()->route('transaksi-layanan.index')->with('success', 'Transaksi layanan berhasil ditambahkan.');
    }

    public function show(TransaksiLayanan $transaksiLayanan)
    {
        $transaksiLayanan->load('pendaftaran.jamaah', 'layanan');
        return view('transaksi-layanan.show', compact('transaksiLayanan'));
    }

    public function edit(TransaksiLayanan $transaksiLayanan)
    {
        $pendaftarans = Pendaftaran::with('jamaah')->get();
        $layanans     = Layanan::where('status', 'aktif')->get();
        return view('transaksi-layanan.edit', compact('transaksiLayanan', 'pendaftarans', 'layanans'));
    }

    public function update(Request $request, TransaksiLayanan $transaksiLayanan)
    {
        $request->validate([
            'qty'               => 'required|integer|min:1',
            'harga_satuan'      => 'required|numeric|min:0',
            'tanggal_transaksi' => 'required|date',
            'status'            => 'required|in:pending,proses,selesai,batal',
            'catatan'           => 'nullable|string',
        ]);

        $data = $request->all();
        $data['total_harga'] = $data['qty'] * $data['harga_satuan'];

        $transaksiLayanan->update($data);
        return redirect()->route('transaksi-layanan.index')->with('success', 'Transaksi layanan berhasil diperbarui.');
    }

    public function destroy(TransaksiLayanan $transaksiLayanan)
    {
        $transaksiLayanan->delete();
        return redirect()->route('transaksi-layanan.index')->with('success', 'Transaksi layanan berhasil dihapus.');
    }
}
