<?php

namespace App\Http\Controllers;

use App\Models\PengeluaranProduk;
use App\Models\Pendaftaran;
use App\Models\Produk;
use Illuminate\Http\Request;

class PengeluaranProdukController extends Controller
{
    public function index(Request $request)
    {
        $keperluan        = $request->keperluan;
        $pengeluaranProduks = PengeluaranProduk::with('produk', 'pendaftaran.jamaah', 'karyawan')
            ->when($keperluan, fn($q) => $q->where('keperluan', $keperluan))
            ->latest()->paginate(10);
        return view('pengeluaran-produk.index', compact('pengeluaranProduks', 'keperluan'));
    }

    public function create(Request $request)
    {
        $produks      = Produk::where('status', 'aktif')->where('stok', '>', 0)->get();
        $pendaftarans = Pendaftaran::with('jamaah')->whereNotIn('status', ['batal', 'refund'])->get();
        $pendaftaran_id = $request->pendaftaran_id;
        return view('pengeluaran-produk.create', compact('produks', 'pendaftarans', 'pendaftaran_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk_id'      => 'required|exists:produks,id',
            'pendaftaran_id' => 'nullable|exists:pendaftarans,id',
            'qty'            => 'required|integer|min:1',
            'tanggal_keluar' => 'required|date',
            'keperluan'      => 'required|in:distribusi_jamaah,internal,rusak,lainnya',
            'keterangan'     => 'nullable|string',
        ]);

        $produk = Produk::findOrFail($request->produk_id);

        if ($produk->stok < $request->qty) {
            return back()->withErrors(['qty' => 'Stok tidak mencukupi. Stok saat ini: ' . $produk->stok]);
        }

        $data = $request->all();
        $data['no_pengeluaran_produk'] = 'PPK-' . strtoupper(uniqid());
        $data['karyawan_id'] = auth()->user()->karyawan->id ?? null;

        PengeluaranProduk::create($data);
        $produk->decrement('stok', $request->qty);

        return redirect()->route('pengeluaran-produk.index')->with('success', 'Pengeluaran produk berhasil dicatat.');
    }

    public function show(PengeluaranProduk $pengeluaranProduk)
    {
        $pengeluaranProduk->load('produk', 'pendaftaran.jamaah', 'karyawan');
        return view('pengeluaran-produk.show', compact('pengeluaranProduk'));
    }

    public function edit(PengeluaranProduk $pengeluaranProduk)
    {
        $produks      = Produk::where('status', 'aktif')->get();
        $pendaftarans = Pendaftaran::with('jamaah')->get();
        return view('pengeluaran-produk.edit', compact('pengeluaranProduk', 'produks', 'pendaftarans'));
    }

    public function update(Request $request, PengeluaranProduk $pengeluaranProduk)
    {
        $request->validate([
            'keperluan'  => 'required|in:distribusi_jamaah,internal,rusak,lainnya',
            'keterangan' => 'nullable|string',
        ]);

        $pengeluaranProduk->update($request->only('keperluan', 'keterangan'));
        return redirect()->route('pengeluaran-produk.index')->with('success', 'Data pengeluaran produk berhasil diperbarui.');
    }

    public function destroy(PengeluaranProduk $pengeluaranProduk)
    {
        // Rollback stok
        $pengeluaranProduk->produk->increment('stok', $pengeluaranProduk->qty);
        $pengeluaranProduk->delete();
        return redirect()->route('pengeluaran-produk.index')->with('success', 'Data pengeluaran produk berhasil dihapus.');
    }
}
