<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Setoran;
use App\Models\Tabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SetoranController extends Controller
{
    public function index(Request $request)
    {
        $jenis      = $request->jenis;
        $kolektorId = $request->kolektor_id;
        $status     = $request->status;

        $setorans = Setoran::with('tabungan.jamaah', 'karyawan')
            ->when($jenis,      fn($q) => $q->whereHas('tabungan', fn($t) => $t->where('jenis', $jenis)))
            ->when($kolektorId, fn($q) => $q->where('karyawan_id', $kolektorId))
            ->when($status,     fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate(10);

        // Kirim semua kolektor untuk kartu rekap & dropdown filter
        $kolektors = Karyawan::where('jabatan', 'kolektor')
            ->where('status', 'aktif')
            ->orderBy('nama_lengkap')
            ->get();

        return view('setoran.index', compact('setorans', 'jenis', 'kolektors', 'kolektorId', 'status'));
    }

    public function create(Request $request)
    {
        $tabungans = Tabungan::with('jamaah')
            ->where('status', 'aktif')
            ->get();

        $kolektors = Karyawan::where('jabatan', 'kolektor')
            ->where('status', 'aktif')
            ->orderBy('nama_lengkap')
            ->get();

        $tabunganId = $request->tabungan_id;

        return view('setoran.create', compact('tabungans', 'kolektors', 'tabunganId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tabungan_id'   => 'required|exists:tabungans,id',
            'karyawan_id'   => 'nullable|exists:karyawans,id',
            'jumlah_setor'  => 'required|numeric|min:1',
            'tanggal_setor' => 'required|date',
            'jenis'         => 'required|in:setor,tarik',
            'metode'        => 'required|in:tunai,transfer,debit,kredit,qris',
            'status'        => 'required|in:pending,diterima,ditolak',
            'bukti_setor'   => 'nullable|image|max:2048',
            'catatan'       => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            $data               = $request->except('bukti_setor');
            $data['no_setoran'] = 'SET-' . strtoupper(uniqid());

            if ($request->hasFile('bukti_setor')) {
                $data['bukti_setor'] = $request->file('bukti_setor')
                    ->store('setoran', 'public');
            }

            $setoran = Setoran::create($data);

            if ($setoran->status === 'diterima') {
                $this->syncSaldo($setoran->tabungan_id);
            }
        });

        return redirect()
            ->route('admin.tabungan.show', $request->tabungan_id)
            ->with('success', 'Setoran berhasil dicatat.');
    }

    public function show(Setoran $setoran)
    {
        $setoran->load('tabungan.jamaah', 'karyawan');
        return view('setoran.show', compact('setoran'));
    }

    public function konfirmasi(Setoran $setoran)
    {
        DB::transaction(function () use ($setoran) {
            $setoran->update(['status' => 'diterima']);
            $this->syncSaldo($setoran->tabungan_id);
        });

        return back()->with('success', 'Setoran dikonfirmasi.');
    }

    public function tolak(Setoran $setoran)
    {
        $setoran->update(['status' => 'ditolak']);
        return back()->with('success', 'Setoran ditolak.');
    }

    public function destroy(Setoran $setoran)
    {
        $tabunganId  = $setoran->tabungan_id;
        $wasDiterima = $setoran->status === 'diterima';

        DB::transaction(function () use ($setoran, $tabunganId, $wasDiterima) {
            $setoran->delete();
            if ($wasDiterima) {
                $this->syncSaldo($tabunganId);
            }
        });

        return back()->with('success', 'Setoran berhasil dihapus.');
    }

    // ── Private Helper ────────────────────────────────────────────────────────

    private function syncSaldo(int $tabunganId): void
    {
        $tabungan = Tabungan::findOrFail($tabunganId);

        $totalMasuk = Setoran::where('tabungan_id', $tabunganId)
            ->where('status', 'diterima')
            ->where('jenis', 'setor')
            ->sum('jumlah_setor');

        $totalKeluar = Setoran::where('tabungan_id', $tabunganId)
            ->where('status', 'diterima')
            ->where('jenis', 'tarik')
            ->sum('jumlah_setor');

        $saldoBaru = max(0, $totalMasuk - $totalKeluar);

        $statusBaru = $tabungan->status;
        if ($saldoBaru >= $tabungan->target_tabungan && $tabungan->status === 'aktif') {
            $statusBaru = 'selesai';
        } elseif ($saldoBaru < $tabungan->target_tabungan && $tabungan->status === 'selesai') {
            $statusBaru = 'aktif';
        }

        $tabungan->update([
            'saldo'  => $saldoBaru,
            'status' => $statusBaru,
        ]);
    }
}
