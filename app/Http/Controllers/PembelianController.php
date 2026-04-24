<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Produk;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    public function index(Request $request)
    {
        $status    = $request->status;
        $pembelians = Pembelian::with('supplier', 'karyawan')
            ->when($status, fn($q) => $q->where('status', $status))
            ->latest()->paginate(10);
        return view('pembelian.index', compact('pembelians', 'status'));
    }

    public function create()
    {
        $suppliers = Supplier::where('status', 'aktif')->get();
        $produks   = Produk::where('status', 'aktif')->get();
        return view('pembelian.create', compact('suppliers', 'produks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id'          => 'required|exists:suppliers,id',
            'tanggal_beli'         => 'required|date',
            'catatan'              => 'nullable|string',
            'produk_id'            => 'required|array|min:1',
            'produk_id.*'          => 'required|exists:produks,id',
            'qty.*'                => 'required|integer|min:1',
            'harga_satuan.*'       => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $total = 0;
            $items = [];

            foreach ($request->produk_id as $i => $produk_id) {
                $qty          = $request->qty[$i];
                $harga_satuan = $request->harga_satuan[$i];
                $subtotal     = $qty * $harga_satuan;
                $total       += $subtotal;

                $items[] = [
                    'produk_id'    => $produk_id,
                    'qty'          => $qty,
                    'harga_satuan' => $harga_satuan,
                    'subtotal'     => $subtotal,
                ];
            }

            $pembelian = Pembelian::create([
                'no_pembelian' => 'PBL-' . strtoupper(uniqid()),
                'supplier_id'  => $request->supplier_id,
                'karyawan_id'  => auth()->user()->karyawan->id ?? null,
                'tanggal_beli' => $request->tanggal_beli,
                'total'        => $total,
                'status'       => 'pending',
                'catatan'      => $request->catatan,
            ]);

            foreach ($items as $item) {
                $item['pembelian_id'] = $pembelian->id;
                PembelianDetail::create($item);
            }
        });

        return redirect()->route('pembelian.index')->with('success', 'Data pembelian berhasil ditambahkan.');
    }

    public function show(Pembelian $pembelian)
    {
        $pembelian->load('supplier', 'karyawan', 'details.produk');
        return view('pembelian.show', compact('pembelian'));
    }

    public function edit(Pembelian $pembelian)
    {
        $suppliers = Supplier::where('status', 'aktif')->get();
        $produks   = Produk::where('status', 'aktif')->get();
        $pembelian->load('details.produk');
        return view('pembelian.edit', compact('pembelian', 'suppliers', 'produks'));
    }

    public function update(Request $request, Pembelian $pembelian)
    {
        $request->validate([
            'status'  => 'required|in:pending,diterima,sebagian,batal',
            'catatan' => 'nullable|string',
        ]);

        $pembelian->update($request->only('status', 'catatan'));

        // Jika diterima, update stok produk
        if ($request->status === 'diterima' && $pembelian->getOriginal('status') !== 'diterima') {
            foreach ($pembelian->details as $detail) {
                $detail->produk->increment('stok', $detail->qty);
            }
        }

        return redirect()->route('pembelian.index')->with('success', 'Data pembelian berhasil diperbarui.');
    }

    public function destroy(Pembelian $pembelian)
    {
        $pembelian->delete();
        return redirect()->route('pembelian.index')->with('success', 'Data pembelian berhasil dihapus.');
    }
}
