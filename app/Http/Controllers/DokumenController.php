<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Jamaah;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;
        $jenis  = $request->jenis_dokumen;

        $dokumens = Dokumen::with('jamaah', 'pendaftaran')
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($jenis,  fn($q) => $q->where('jenis_dokumen', $jenis))
            ->latest()->paginate(10);

        return view('dokumen.index', compact('dokumens', 'status', 'jenis'));
    }

    public function create(Request $request)
    {
        $jamaah         = Jamaah::where('status', 'aktif')->get();
        $pendaftarans   = Pendaftaran::with('jamaah')->get();
        $jamaah_id      = $request->jamaah_id;
        $pendaftaran_id = $request->pendaftaran_id;
        return view('dokumen.create', compact('jamaah', 'pendaftarans', 'jamaah_id', 'pendaftaran_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pendaftaran_id'  => 'required|exists:pendaftarans,id',
            'jamaah_id'       => 'required|exists:jamaah,id',
            'jenis_dokumen'   => 'required|in:ktp,passport,foto,kartu_keluarga,akta_lahir,buku_nikah,surat_mahram,surat_kesehatan,visa,bukti_vaksin,lainnya',
            'file'            => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'tanggal_upload'  => 'required|date',
            'tanggal_expired' => 'nullable|date',
            'catatan'         => 'nullable|string',
        ]);

        $file      = $request->file('file');
        $nama_file = time() . '_' . $file->getClientOriginalName();
        $file_path = $file->storeAs('dokumen', $nama_file, 'public');

        Dokumen::create([
            'pendaftaran_id'  => $request->pendaftaran_id,
            'jamaah_id'       => $request->jamaah_id,
            'jenis_dokumen'   => $request->jenis_dokumen,
            'file_path'       => $file_path,
            'nama_file'       => $nama_file,
            'tanggal_upload'  => $request->tanggal_upload,
            'tanggal_expired' => $request->tanggal_expired,
            'status'          => 'pending',
            'catatan'         => $request->catatan,
        ]);

        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil diunggah.');
    }

    public function show(Dokumen $dokumen)
    {
        $dokumen->load('jamaah', 'pendaftaran');
        return view('dokumen.show', compact('dokumen'));
    }

    public function edit(Dokumen $dokumen)
    {
        $jamaah       = Jamaah::where('status', 'aktif')->get();
        $pendaftarans = Pendaftaran::with('jamaah')->get();
        return view('dokumen.edit', compact('dokumen', 'jamaah', 'pendaftarans'));
    }

    public function update(Request $request, Dokumen $dokumen)
    {
        $request->validate([
            'jenis_dokumen'   => 'required|in:ktp,passport,foto,kartu_keluarga,akta_lahir,buku_nikah,surat_mahram,surat_kesehatan,visa,bukti_vaksin,lainnya',
            'file'            => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'tanggal_expired' => 'nullable|date',
            'status'          => 'required|in:pending,valid,expired,ditolak',
            'catatan'         => 'nullable|string',
        ]);

        $data = $request->except('file');

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($dokumen->file_path);
            $file           = $request->file('file');
            $nama_file      = time() . '_' . $file->getClientOriginalName();
            $data['file_path'] = $file->storeAs('dokumen', $nama_file, 'public');
            $data['nama_file'] = $nama_file;
        }

        $dokumen->update($data);
        return redirect()->route('dokumen.index')->with('success', 'Data dokumen berhasil diperbarui.');
    }

    public function destroy(Dokumen $dokumen)
    {
        Storage::disk('public')->delete($dokumen->file_path);
        $dokumen->delete();
        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil dihapus.');
    }

    public function validasi(Dokumen $dokumen)
    {
        $dokumen->update(['status' => 'valid']);
        return back()->with('success', 'Dokumen berhasil divalidasi.');
    }
}
