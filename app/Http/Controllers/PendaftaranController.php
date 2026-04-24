<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Jamaah;
use App\Models\Keberangkatan;
use App\Models\Karyawan;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    public function index(Request $request)
    {
        $jenis  = $request->jenis;
        $status = $request->status;

        $pendaftarans = Pendaftaran::with('jamaah', 'keberangkatan.paket', 'agent')
            ->when($jenis,  fn($q) => $q->where('jenis', $jenis))
            ->when($status, fn($q) => $q->where('status', $status))
            ->latest()->paginate(10);

        return view('pendaftaran.index', compact('pendaftarans', 'jenis', 'status'));
    }

    public function create(Request $request)
    {
        $jamaah         = Jamaah::where('status', 'aktif')->get();
        $keberangkatans = Keberangkatan::with('paket')
            ->where('status', 'open')->get();
        $agents         = Agent::where('status', 'aktif')->get();
        $karyawans      = Karyawan::where('status', 'aktif')->get();
        $jenis          = $request->jenis ?? 'umroh';

        return view('pendaftaran.create', compact('jamaah', 'keberangkatans', 'agents', 'karyawans', 'jenis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jamaah_id'        => 'required|exists:jamaah,id',
            'keberangkatan_id' => 'required|exists:keberangkatans,id',
            'agent_id'         => 'nullable|exists:agents,id',
            'karyawan_id'      => 'nullable|exists:karyawans,id',
            'jenis'            => 'required|in:umroh,haji,haji_plus,haji_furoda',
            'tipe_kamar'       => 'required|in:double,triple,quad',
            'harga_jual'       => 'required|numeric|min:0',
            'dp_minimal'       => 'required|numeric|min:0',
            'tanggal_daftar'   => 'required|date',
            'batas_pelunasan'  => 'nullable|date',
            'catatan'          => 'nullable|string',
        ]);

        $data = $request->all();
        $data['no_pendaftaran'] = 'PDF-' . strtoupper(uniqid());
        $data['status'] = 'draft';

        $pendaftaran = Pendaftaran::create($data);

        // Update slot terisi di keberangkatan
        $pendaftaran->keberangkatan->increment('terisi');

        return redirect()->route('pendaftaran.show', $pendaftaran)
            ->with('success', 'Pendaftaran berhasil dibuat.');
    }

    public function show(Pendaftaran $pendaftaran)
    {
        $pendaftaran->load(
            'jamaah',
            'keberangkatan.paket',
            'agent',
            'karyawan',
            'pembayarans',
            'transaksiLayanans.layanan',
            'dokumens',
            'pengeluaranProduks.produk'
        );
        return view('pendaftaran.show', compact('pendaftaran'));
    }

    public function edit(Pendaftaran $pendaftaran)
    {
        $jamaah         = Jamaah::where('status', 'aktif')->get();
        $keberangkatans = Keberangkatan::with('paket')->where('status', 'open')->get();
        $agents         = Agent::where('status', 'aktif')->get();
        $karyawans      = Karyawan::where('status', 'aktif')->get();
        return view('pendaftaran.edit', compact('pendaftaran', 'jamaah', 'keberangkatans', 'agents', 'karyawans'));
    }

    public function update(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            'tipe_kamar'      => 'required|in:double,triple,quad',
            'harga_jual'      => 'required|numeric|min:0',
            'dp_minimal'      => 'required|numeric|min:0',
            'batas_pelunasan' => 'nullable|date',
            'status'          => 'required|in:draft,konfirmasi,dp_terbayar,lunas,berangkat,selesai,batal,refund',
            'catatan'         => 'nullable|string',
        ]);

        $pendaftaran->update($request->all());
        return redirect()->route('pendaftaran.show', $pendaftaran)
            ->with('success', 'Data pendaftaran berhasil diperbarui.');
    }

    public function destroy(Pendaftaran $pendaftaran)
    {
        $pendaftaran->keberangkatan->decrement('terisi');
        $pendaftaran->delete();
        return redirect()->route('pendaftaran.index')->with('success', 'Data pendaftaran berhasil dihapus.');
    }

    public function updateStatus(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            'status' => 'required|in:draft,konfirmasi,dp_terbayar,lunas,berangkat,selesai,batal,refund',
        ]);
        $pendaftaran->update(['status' => $request->status]);
        return back()->with('success', 'Status pendaftaran berhasil diperbarui.');
    }
}
