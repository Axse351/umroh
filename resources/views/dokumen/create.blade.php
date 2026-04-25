@extends('layouts.app')
@section('title', 'Upload Dokumen')
@section('page-title', 'Dokumen')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.dokumen.index') }}">Data Dokumen</a></div>
    <div class="breadcrumb-item active">Upload</div>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Form Upload Dokumen</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.dokumen.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Pendaftaran / Jamaah <span class="text-danger">*</span></label>
                            <select name="pendaftaran_id" class="form-control @error('pendaftaran_id') is-invalid @enderror"
                                onchange="setJamaah(this)">
                                <option value="">-- Pilih Pendaftaran --</option>
                                @foreach ($pendaftarans as $p)
                                    <option value="{{ $p->id }}" data-jamaah="{{ $p->jamaah_id }}"
                                        {{ old('pendaftaran_id', $pendaftaran_id) == $p->id ? 'selected' : '' }}>
                                        {{ $p->jamaah->nama_lengkap ?? '-' }} - {{ $p->no_pendaftaran ?? $p->id }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pendaftaran_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Jamaah <span class="text-danger">*</span></label>
                            <select name="jamaah_id" id="jamaah_id"
                                class="form-control @error('jamaah_id') is-invalid @enderror">
                                <option value="">-- Pilih Jamaah --</option>
                                @foreach ($jamaah as $j)
                                    <option value="{{ $j->id }}"
                                        {{ old('jamaah_id', $jamaah_id) == $j->id ? 'selected' : '' }}>
                                        {{ $j->nama_lengkap }} - {{ $j->nik }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jamaah_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Jenis Dokumen <span class="text-danger">*</span></label>
                            <select name="jenis_dokumen" class="form-control @error('jenis_dokumen') is-invalid @enderror">
                                <option value="">-- Pilih Jenis --</option>
                                @foreach (['ktp', 'passport', 'foto', 'kartu_keluarga', 'akta_lahir', 'buku_nikah', 'surat_mahram', 'surat_kesehatan', 'visa', 'bukti_vaksin', 'lainnya'] as $j)
                                    <option value="{{ $j }}"
                                        {{ old('jenis_dokumen') == $j ? 'selected' : '' }}>
                                        {{ ucwords(str_replace('_', ' ', $j)) }}</option>
                                @endforeach
                            </select>
                            @error('jenis_dokumen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>File Dokumen <span class="text-danger">*</span></label>
                            <div class="custom-file">
                                <input type="file" name="file"
                                    class="custom-file-input @error('file') is-invalid @enderror" id="file"
                                    accept=".jpg,.jpeg,.png,.pdf">
                                <label class="custom-file-label" for="file">Pilih file (jpg/png/pdf, max 5MB)...</label>
                            </div>
                            @error('file')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Upload <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_upload"
                                        class="form-control @error('tanggal_upload') is-invalid @enderror"
                                        value="{{ old('tanggal_upload', date('Y-m-d')) }}">
                                    @error('tanggal_upload')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Expired</label>
                                    <input type="date" name="tanggal_expired" class="form-control"
                                        value="{{ old('tanggal_expired') }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Catatan</label>
                            <textarea name="catatan" class="form-control" rows="2">{{ old('catatan') }}</textarea>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-upload mr-1"></i>
                                Upload</button>
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
            this.nextElementSibling.textContent = this.files[0]?.name || 'Pilih file...';
        });

        function setJamaah(sel) {
            const jamaahId = sel.options[sel.selectedIndex].dataset.jamaah;
            if (jamaahId) document.getElementById('jamaah_id').value = jamaahId;
        }
    </script>
@endpush
