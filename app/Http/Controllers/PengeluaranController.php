<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->kategori;
        $bulan    = $request->bulan;
        $tahun    = $request->tahun ?? now()->year;

        $pengeluarans = Pengeluaran::with('karyawan')
            ->when($kategori, fn($q) => $q->where('kategori', $kategori))
            ->when($bulan,    fn($q) => $q->whereMonth('tanggal', $bulan))
            ->whereYear('tanggal', $tahun)
            ->latest()->paginate(10);

        $total = $pengeluarans->sum('jumlah');

        return view('pengeluaran.index', compact('pengeluarans', 'total', 'kategori', 'bulan', 'tahun'));
    }

    public function create()
    {
        return view('pengeluaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'keperluan'  => 'required|string|max:255',
            'kategori'   => 'required|in:operasional,gaji,visa,tiket,hotel,transportasi,perlengkapan,marketing,lainnya',
            'jumlah'     => 'required|numeric|min:1',
            'tanggal'    => 'required|date',
            'penerima'   => 'nullable|string|max:255',
            'bukti'      => 'nullable|image|max:2048',
            'keterangan' => 'nullable|string',
        ]);

        $data = $request->except('bukti');
        $data['no_pengeluaran'] = 'PNG-' . strtoupper(uniqid());
        $data['karyawan_id']    = auth()->user()->karyawan->id ?? null;

        if ($request->hasFile('bukti')) {
            $data['bukti'] = $request->file('bukti')->store('pengeluaran', 'public');
        }

        Pengeluaran::create($data);
        return redirect()->route('pengeluaran.index')->with('success', 'Data pengeluaran berhasil ditambahkan.');
    }

    public function show(Pengeluaran $pengeluaran)
    {
        return view('pengeluaran.show', compact('pengeluaran'));
    }

    public function edit(Pengeluaran $pengeluaran)
    {
        return view('pengeluaran.edit', compact('pengeluaran'));
    }

    public function update(Request $request, Pengeluaran $pengeluaran)
    {
        $request->validate([
            'keperluan'  => 'required|string|max:255',
            'kategori'   => 'required|in:operasional,gaji,visa,tiket,hotel,transportasi,perlengkapan,marketing,lainnya',
            'jumlah'     => 'required|numeric|min:1',
            'tanggal'    => 'required|date',
            'penerima'   => 'nullable|string|max:255',
            'bukti'      => 'nullable|image|max:2048',
            'keterangan' => 'nullable|string',
        ]);

        $data = $request->except('bukti');

        if ($request->hasFile('bukti')) {
            if ($pengeluaran->bukti) Storage::disk('public')->delete($pengeluaran->bukti);
            $data['bukti'] = $request->file('bukti')->store('pengeluaran', 'public');
        }

        $pengeluaran->update($data);
        return redirect()->route('pengeluaran.index')->with('success', 'Data pengeluaran berhasil diperbarui.');
    }

    public function destroy(Pengeluaran $pengeluaran)
    {
        if ($pengeluaran->bukti) Storage::disk('public')->delete($pengeluaran->bukti);
        $pengeluaran->delete();
        return redirect()->route('pengeluaran.index')->with('success', 'Data pengeluaran berhasil dihapus.');
    }
}
