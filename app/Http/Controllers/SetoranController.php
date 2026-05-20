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
        $jenis = $request->jenis;
        $setorans = Setoran::with('tabungan.jamaah')
            ->when($jenis, fn($q) => $q->whereHas('tabungan', fn($t) => $t->where('jenis', $jenis)))
            ->latest()->paginate(10);
        return view('setoran.index', compact('setorans', 'jenis'));
    }

    public function create(Request $request)
    {
        $tabungans  = Tabungan::with('jamaah')
            ->where('status', 'aktif')
            ->get();

        // Karyawan yang punya role kolektor
        $kolektors = Karyawan::where('jabatan', 'kolektor')
            ->where('status', 'aktif')
            ->orderBy('nama_lengkap')
            ->get();

        $tabunganId = $request->tabungan_id;

        return view('setoran.create', compact('tabungans', 'kolektors', 'tabunganId'));
    }

    /**
     * Simpan setoran baru & update saldo tabungan.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tabungan_id'  => 'required|exists:tabungans,id',
            'karyawan_id'  => 'nullable|exists:karyawans,id',
            'jumlah_setor' => 'required|numeric|min:1',
            'tanggal_setor' => 'required|date',
            'jenis'        => 'required|in:setor,tarik',
            'metode'       => 'required|in:tunai,transfer,debit,kredit,qris',
            'status'       => 'required|in:pending,diterima,ditolak',
            'bukti_setor'  => 'nullable|image|max:2048',
            'catatan'      => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            $data                = $request->except('bukti_setor');
            $data['no_setoran']  = 'SET-' . strtoupper(uniqid());

            if ($request->hasFile('bukti_setor')) {
                $data['bukti_setor'] = $request->file('bukti_setor')
                    ->store('setoran', 'public');
            }

            $setoran = Setoran::create($data);

            // Hanya ubah saldo jika langsung diterima
            if ($setoran->status === 'diterima') {
                $this->syncSaldo($setoran->tabungan_id);
            }
        });

        return redirect()
            ->route('admin.tabungan.show', $request->tabungan_id)
            ->with('success', 'Setoran berhasil dicatat.');
    }

    /**
     * Konfirmasi setoran pending → ubah ke diterima & update saldo.
     */
    public function konfirmasi(Setoran $setoran)
    {
        DB::transaction(function () use ($setoran) {
            $setoran->update(['status' => 'diterima']);
            $this->syncSaldo($setoran->tabungan_id);
        });

        return back()->with('success', 'Setoran dikonfirmasi.');
    }

    /**
     * Tolak setoran pending → ubah ke ditolak (saldo tidak berubah).
     */
    public function tolak(Setoran $setoran)
    {
        $setoran->update(['status' => 'ditolak']);

        return back()->with('success', 'Setoran ditolak.');
    }

    /**
     * Hapus setoran & sesuaikan saldo.
     */
    public function destroy(Setoran $setoran)
    {
        $tabunganId = $setoran->tabungan_id;
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

    /**
     * Hitung ulang saldo dari semua setoran diterima.
     * Lebih aman daripada increment/decrement manual.
     */
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

        // Otomatis tandai selesai bila target terpenuhi
        $statusBaru = $tabungan->status;
        if ($saldoBaru >= $tabungan->target_tabungan && $tabungan->status === 'aktif') {
            $statusBaru = 'selesai';
        } elseif ($saldoBaru < $tabungan->target_tabungan && $tabungan->status === 'selesai') {
            $statusBaru = 'aktif'; // rollback jika setoran dihapus
        }

        $tabungan->update([
            'saldo'  => $saldoBaru,
            'status' => $statusBaru,
        ]);
    }
}
