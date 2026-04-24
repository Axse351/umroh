<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\StokOpname;
use Illuminate\Http\Request;

class StokOpnameController extends Controller
{
    public function index()
    {
        $stokOpnames = StokOpname::with('produk', 'karyawan')
            ->latest()->paginate(10);
        return view('stok-opname.index', compact('stokOpnames'));
    }

    public function create()
    {
        $produks = Produk::where('status', 'aktif')->get();
        return view('stok-opname.create', compact('produks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk_id'      => 'required|exists:produks,id',
            'stok_fisik'     => 'required|integer|min:0',
            'tanggal_opname' => 'required|date',
            'keterangan'     => 'nullable|string',
        ]);

        $produk     = Produk::findOrFail($request->produk_id);
        $stok_sistem = $produk->stok;
        $stok_fisik  = $request->stok_fisik;
        $selisih     = $stok_fisik - $stok_sistem;

        StokOpname::create([
            'no_opname'      => 'OPN-' . strtoupper(uniqid()),
            'produk_id'      => $request->produk_id,
            'karyawan_id'    => auth()->user()->karyawan->id ?? null,
            'stok_sistem'    => $stok_sistem,
            'stok_fisik'     => $stok_fisik,
            'selisih'        => $selisih,
            'tanggal_opname' => $request->tanggal_opname,
            'keterangan'     => $request->keterangan,
        ]);

        // Sesuaikan stok produk dengan hasil fisik
        $produk->update(['stok' => $stok_fisik]);

        return redirect()->route('stok-opname.index')->with('success', 'Stok opname berhasil dicatat dan stok diperbarui.');
    }

    public function show(StokOpname $stokOpname)
    {
        $stokOpname->load('produk', 'karyawan');
        return view('stok-opname.show', compact('stokOpname'));
    }

    public function destroy(StokOpname $stokOpname)
    {
        $stokOpname->delete();
        return redirect()->route('stok-opname.index')->with('success', 'Data stok opname berhasil dihapus.');
    }
}
