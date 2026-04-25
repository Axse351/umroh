@extends('layouts.app')
@section('title', 'Edit Dokumen')
@section('page-title', 'Dokumen')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.dokumen.index') }}">Data Dokumen</a></div>
    <div class="breadcrumb-item active">Edit</div>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Dokumen</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.dokumen.update', $dokumen) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="form-group">
                            <label>Jamaah</label>
                            <input type="text" class="form-control" value="{{ $dokumen->jamaah->nama_lengkap ?? '-' }}"
                                disabled>
                        </div>
                        <div class="form-group">
                            <label>Jenis Dokumen <span class="text-danger">*</span></label>
                            <select name="jenis_dokumen" class="form-control @error('jenis_dokumen') is-invalid @enderror">
                                @foreach (['ktp', 'passport', 'foto', 'kartu_keluarga', 'akta_lahir', 'buku_nikah', 'surat_mahram', 'surat_kesehatan', 'visa', 'bukti_vaksin', 'lainnya'] as $j)
                                    <option value="{{ $j }}"
                                        {{ old('jenis_dokumen', $dokumen->jenis_dokumen) == $j ? 'selected' : '' }}>
                                        {{ ucwords(str_replace('_', ' ', $j)) }}</option>
                                @endforeach
                            </select>
                            @error('jenis_dokumen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>File Saat Ini</label><br>
                            <a href="{{ asset('storage/' . $dokumen->file_path) }}" target="_blank"
                                class="btn btn-sm btn-outline-info">
                                <i class="fas fa-file mr-1"></i> {{ $dokumen->nama_file }}
                            </a>
                        </div>
                        <div class="form-group">
                            <label>Ganti File (opsional)</label>
                            <div class="custom-file">
                                <input type="file" name="file" class="custom-file-input" id="file"
                                    accept=".jpg,.jpeg,.png,.pdf">
                                <label class="custom-file-label" for="file">Pilih file baru...</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Expired</label>
                            <input type="date" name="tanggal_expired" class="form-control"
                                value="{{ old('tanggal_expired', $dokumen->tanggal_expired?->format('Y-m-d')) }}">
                        </div>
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror">
                                @foreach (['pending', 'valid', 'expired', 'ditolak'] as $s)
                                    <option value="{{ $s }}"
                                        {{ old('status', $dokumen->status) == $s ? 'selected' : '' }}>{{ ucfirst($s) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Catatan</label>
                            <textarea name="catatan" class="form-control" rows="2">{{ old('catatan', $dokumen->catatan) }}</textarea>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-warning"><i class="fas fa-save mr-1"></i> Update</button>
                            <a href="{{ route('admin.dokumen.index') }}" class="btn btn-secondary ml-2"><i
                                    class="fas fa-arrow-left mr-1"></i> Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.getElementById('file').addEventListener('change', function() {
            this.nextElementSibling.textContent = this.files[0]?.name || 'Pilih file baru...';
        });
    </script>
@endpush
