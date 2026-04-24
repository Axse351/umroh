<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;
        $pembayarans = Pembayaran::with('pendaftaran.jamaah')
            ->when($status, fn($q) => $q->where('status', $status))
            ->latest()->paginate(10);
        return view('pembayaran.index', compact('pembayarans', 'status'));
    }

    public function create(Request $request)
    {
        $pendaftarans = Pendaftaran::with('jamaah')
            ->whereNotIn('status', ['selesai', 'batal', 'refund'])
            ->get();
        $pendaftaran_id = $request->pendaftaran_id;
        return view('pembayaran.create', compact('pendaftarans', 'pendaftaran_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pendaftaran_id' => 'required|exists:pendaftarans,id',
            'jumlah_bayar'   => 'required|numeric|min:1',
            'tanggal_bayar'  => 'required|date',
            'metode_bayar'   => 'required|in:tunai,transfer,debit,kredit,qris',
            'bank_tujuan'    => 'nullable|string|max:100',
            'no_rekening'    => 'nullable|string|max:50',
            'nama_pengirim'  => 'nullable|string|max:255',
            'bukti_bayar'    => 'nullable|image|max:2048',
            'jenis'          => 'required|in:dp,cicilan,pelunasan,lainnya',
            'catatan'        => 'nullable|string',
        ]);

        $data = $request->except('bukti_bayar');
        $data['no_pembayaran'] = 'PAY-' . strtoupper(uniqid());
        $data['karyawan_id']   = auth()->user()->karyawan->id ?? null;
        $data['status']        = 'pending';

        if ($request->hasFile('bukti_bayar')) {
            $data['bukti_bayar'] = $request->file('bukti_bayar')->store('pembayaran', 'public');
        }

        Pembayaran::create($data);
        return redirect()->route('pembayaran.index')->with('success', 'Data pembayaran berhasil ditambahkan.');
    }

    public function show(Pembayaran $pembayaran)
    {
        $pembayaran->load('pendaftaran.jamaah', 'karyawan');
        return view('pembayaran.show', compact('pembayaran'));
    }

    public function edit(Pembayaran $pembayaran)
    {
        $pendaftarans = Pendaftaran::with('jamaah')->get();
        return view('pembayaran.edit', compact('pembayaran', 'pendaftarans'));
    }

    public function update(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'jumlah_bayar'  => 'required|numeric|min:1',
            'tanggal_bayar' => 'required|date',
            'metode_bayar'  => 'required|in:tunai,transfer,debit,kredit,qris',
            'jenis'         => 'required|in:dp,cicilan,pelunasan,lainnya',
            'status'        => 'required|in:pending,verifikasi,diterima,ditolak',
            'bukti_bayar'   => 'nullable|image|max:2048',
            'catatan'       => 'nullable|string',
        ]);

        $data = $request->except('bukti_bayar');

        if ($request->hasFile('bukti_bayar')) {
            if ($pembayaran->bukti_bayar) Storage::disk('public')->delete($pembayaran->bukti_bayar);
            $data['bukti_bayar'] = $request->file('bukti_bayar')->store('pembayaran', 'public');
        }

        $pembayaran->update($data);

        // Jika diterima & pelunasan, update status pendaftaran
        if ($data['status'] === 'diterima') {
            $pendaftaran = $pembayaran->pendaftaran;
            if ($pendaftaran->sisa_tagihan <= 0) {
                $pendaftaran->update(['status' => 'lunas']);
            } elseif ($pendaftaran->status === 'draft') {
                $pendaftaran->update(['status' => 'dp_terbayar']);
            }
        }

        return redirect()->route('pembayaran.index')->with('success', 'Data pembayaran berhasil diperbarui.');
    }

    public function destroy(Pembayaran $pembayaran)
    {
        if ($pembayaran->bukti_bayar) Storage::disk('public')->delete($pembayaran->bukti_bayar);
        $pembayaran->delete();
        return redirect()->route('pembayaran.index')->with('success', 'Data pembayaran berhasil dihapus.');
    }

    public function verifikasi(Pembayaran $pembayaran)
    {
        $pembayaran->update(['status' => 'diterima']);
        $pendaftaran = $pembayaran->pendaftaran;
        if ($pendaftaran->sisa_tagihan <= 0) {
            $pendaftaran->update(['status' => 'lunas']);
        } elseif ($pendaftaran->status === 'draft') {
            $pendaftaran->update(['status' => 'dp_terbayar']);
        }
        return back()->with('success', 'Pembayaran berhasil diverifikasi.');
    }

    public function tolak(Pembayaran $pembayaran)
    {
        $pembayaran->update(['status' => 'ditolak']);
        return back()->with('success', 'Pembayaran berhasil ditolak.');
    }
}
