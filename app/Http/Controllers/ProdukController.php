<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->kategori;
        $produks  = Produk::with('supplier')
            ->when($kategori, fn($q) => $q->where('kategori', $kategori))
            ->latest()->paginate(10);
        return view('produk.index', compact('produks', 'kategori'));
    }

    public function create()
    {
        $suppliers = Supplier::where('status', 'aktif')->get();
        return view('produk.create', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk'   => 'required|string|max:255',
            'kategori'      => 'required|in:koper,tas,seragam,buku_manasik,perlengkapan_sholat,souvenir,obat,lainnya',
            'supplier_id'   => 'nullable|exists:suppliers,id',
            'stok'          => 'required|integer|min:0',
            'stok_minimum'  => 'required|integer|min:0',
            'satuan'        => 'required|string|max:20',
            'harga_beli'    => 'required|numeric|min:0',
            'harga_jual'    => 'required|numeric|min:0',
            'deskripsi'     => 'nullable|string',
            'foto'          => 'nullable|image|max:2048',
            'status'        => 'required|in:aktif,nonaktif',
        ]);

        $data = $request->except('foto');
        $data['kode_produk'] = 'PRD-' . strtoupper(uniqid());

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('produk', 'public');
        }

        Produk::create($data);
        return redirect()->route('produk.index')->with('success', 'Data produk berhasil ditambahkan.');
    }

    public function show(Produk $produk)
    {
        $produk->load('supplier', 'pembelianDetails.pembelian', 'pengeluaranProduks', 'stokOpnames');
        return view('produk.show', compact('produk'));
    }

    public function edit(Produk $produk)
    {
        $suppliers = Supplier::where('status', 'aktif')->get();
        return view('produk.edit', compact('produk', 'suppliers'));
    }

    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama_produk'   => 'required|string|max:255',
            'kategori'      => 'required|in:koper,tas,seragam,buku_manasik,perlengkapan_sholat,souvenir,obat,lainnya',
            'supplier_id'   => 'nullable|exists:suppliers,id',
            'stok_minimum'  => 'required|integer|min:0',
            'satuan'        => 'required|string|max:20',
            'harga_beli'    => 'required|numeric|min:0',
            'harga_jual'    => 'required|numeric|min:0',
            'deskripsi'     => 'nullable|string',
            'foto'          => 'nullable|image|max:2048',
            'status'        => 'required|in:aktif,nonaktif',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            if ($produk->foto) Storage::disk('public')->delete($produk->foto);
            $data['foto'] = $request->file('foto')->store('produk', 'public');
        }

        $produk->update($data);
        return redirect()->route('produk.index')->with('success', 'Data produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        if ($produk->foto) Storage::disk('public')->delete($produk->foto);
        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Data produk berhasil dihapus.');
    }
}
