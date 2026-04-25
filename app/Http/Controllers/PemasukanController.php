<?php

namespace App\Http\Controllers;

use App\Models\Pemasukan;
use Illuminate\Http\Request;

class PemasukanController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->kategori;
        $bulan    = $request->bulan;
        $tahun    = $request->tahun ?? now()->year;

        $pemasukans = Pemasukan::with('karyawan')
            ->when($kategori, fn($q) => $q->where('kategori', $kategori))
            ->when($bulan,    fn($q) => $q->whereMonth('tanggal', $bulan))
            ->whereYear('tanggal', $tahun)
            ->latest()->paginate(10);

        $total = $pemasukans->sum('jumlah');

        return view('pemasukan.index', compact('pemasukans', 'total', 'kategori', 'bulan', 'tahun'));
    }


    public function create()
    {
        return view('pemasukan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'sumber'     => 'required|string|max:255',
            'kategori'   => 'required|in:pembayaran_jamaah,setoran_tabungan,transaksi_layanan,komisi,lainnya',
            'jumlah'     => 'required|numeric|min:1',
            'tanggal'    => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['no_pemasukan'] = 'PMS-' . strtoupper(uniqid());
        $data['karyawan_id']  = auth()->user()->karyawan->id ?? null;

        Pemasukan::create($data);
        return redirect()->route('pemasukan.index')->with('success', 'Data pemasukan berhasil ditambahkan.');
    }

    public function show(Pemasukan $pemasukan)
    {
        return view('pemasukan.show', compact('pemasukan'));
    }

    public function edit(Pemasukan $pemasukan)
    {
        return view('pemasukan.edit', compact('pemasukan'));
    }

    public function update(Request $request, Pemasukan $pemasukan)
    {
        $request->validate([
            'sumber'     => 'required|string|max:255',
            'kategori'   => 'required|in:pembayaran_jamaah,setoran_tabungan,transaksi_layanan,komisi,lainnya',
            'jumlah'     => 'required|numeric|min:1',
            'tanggal'    => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $pemasukan->update($request->all());
        return redirect()->route('pemasukan.index')->with('success', 'Data pemasukan berhasil diperbarui.');
    }

    public function destroy(Pemasukan $pemasukan)
    {
        $pemasukan->delete();
        return redirect()->route('pemasukan.index')->with('success', 'Data pemasukan berhasil dihapus.');
    }
}
