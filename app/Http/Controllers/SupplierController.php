<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $kategori  = $request->kategori;
        $suppliers = Supplier::when($kategori, fn($q) => $q->where('kategori', $kategori))
            ->latest()->paginate(10);
        return view('supplier.index', compact('suppliers', 'kategori'));
    }

    public function create()
    {
        return view('supplier.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'kategori'      => 'required|in:perlengkapan,makanan,souvenir,percetakan,lainnya',
            'nama_pic'      => 'nullable|string|max:255',
            'no_telepon'    => 'required|string|max:20',
            'email'         => 'nullable|email',
            'alamat'        => 'nullable|string',
            'no_rekening'   => 'nullable|string|max:30',
            'nama_bank'     => 'nullable|string|max:50',
            'status'        => 'required|in:aktif,nonaktif',
        ]);

        $data = $request->all();
        $data['kode_supplier'] = 'SUP-' . strtoupper(uniqid());

        Supplier::create($data);
        return redirect()->route('supplier.index')->with('success', 'Data supplier berhasil ditambahkan.');
    }

    public function show(Supplier $supplier)
    {
        $supplier->load('produks', 'pembelians');
        return view('supplier.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'kategori'      => 'required|in:perlengkapan,makanan,souvenir,percetakan,lainnya',
            'nama_pic'      => 'nullable|string|max:255',
            'no_telepon'    => 'required|string|max:20',
            'email'         => 'nullable|email',
            'alamat'        => 'nullable|string',
            'no_rekening'   => 'nullable|string|max:30',
            'nama_bank'     => 'nullable|string|max:50',
            'status'        => 'required|in:aktif,nonaktif',
        ]);

        $supplier->update($request->all());
        return redirect()->route('supplier.index')->with('success', 'Data supplier berhasil diperbarui.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('supplier.index')->with('success', 'Data supplier berhasil dihapus.');
    }
}
