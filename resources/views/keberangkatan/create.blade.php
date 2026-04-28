@extends('layouts.app')

@section('title', 'Tambah Keberangkatan')

@section('content')
    <div class="container-fluid px-4 py-4">

        {{-- Header --}}
        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="{{ route('admin.keberangkatan.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h4 class="fw-bold mb-0">Tambah Keberangkatan</h4>
                <small class="text-muted">Isi form berikut untuk menambah jadwal keberangkatan</small>
            </div>
        </div>

        <form action="{{ route('admin.keberangkatan.store') }}" method="POST">
            @csrf

            <div class="row g-4">

                {{-- Kolom Kiri --}}
                <div class="col-lg-8">

                    {{-- Informasi Utama --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-header fw-semibold bg-white border-bottom">
                            <i class="bi bi-info-circle me-2 text-primary"></i>Informasi Utama
                        </div>
                        <div class="card-body">
                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label class="form-label">Paket <span class="text-danger">*</span></label>
                                    <select name="paket_id" class="form-select @error('paket_id') is-invalid @enderror">
                                        <option value="">-- Pilih Paket --</option>
                                        @foreach ($pakets as $paket)
                                            <option value="{{ $paket->id }}"
                                                {{ old('paket_id') == $paket->id ? 'selected' : '' }}>
                                                {{ $paket->nama_paket }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('paket_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Pembimbing</label>
                                    <select name="pembimbing_id"
                                        class="form-select @error('pembimbing_id') is-invalid @enderror">
                                        <option value="">-- Tanpa Pembimbing --</option>
                                        @foreach ($karyawans as $karyawan)
                                            <option value="{{ $karyawan->id }}"
                                                {{ old('pembimbing_id') == $karyawan->id ? 'selected' : '' }}>
                                                {{ $karyawan->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('pembimbing_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Berangkat <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_berangkat" value="{{ old('tanggal_berangkat') }}"
                                        class="form-control @error('tanggal_berangkat') is-invalid @enderror">
                                    @error('tanggal_berangkat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Tanggal Pulang <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_pulang" value="{{ old('tanggal_pulang') }}"
                                        class="form-control @error('tanggal_pulang') is-invalid @enderror">
                                    @error('tanggal_pulang')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Bandara Keberangkatan <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="bandara_keberangkatan"
                                        value="{{ old('bandara_keberangkatan') }}" placeholder="CGK" maxlength="10"
                                        class="form-control text-uppercase @error('bandara_keberangkatan') is-invalid @enderror">
                                    @error('bandara_keberangkatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">No. Penerbangan Pergi</label>
                                    <input type="text" name="no_penerbangan_pergi"
                                        value="{{ old('no_penerbangan_pergi') }}" placeholder="GA-001"
                                        class="form-control @error('no_penerbangan_pergi') is-invalid @enderror">
                                    @error('no_penerbangan_pergi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">No. Penerbangan Pulang</label>
                                    <input type="text" name="no_penerbangan_pulang"
                                        value="{{ old('no_penerbangan_pulang') }}" placeholder="GA-002"
                                        class="form-control @error('no_penerbangan_pulang') is-invalid @enderror">
                                    @error('no_penerbangan_pulang')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Kuota <span class="text-danger">*</span></label>
                                    <input type="number" name="kuota" value="{{ old('kuota') }}" min="1"
                                        placeholder="45" class="form-control @error('kuota') is-invalid @enderror">
                                    @error('kuota')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Harga --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-header fw-semibold bg-white border-bottom">
                            <i class="bi bi-cash-coin me-2 text-success"></i>Harga Kamar
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Harga Double <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" name="harga_double" value="{{ old('harga_double') }}"
                                            min="0" step="1000" placeholder="25000000"
                                            class="form-control @error('harga_double') is-invalid @enderror">
                                        @error('harga_double')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Harga Triple <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" name="harga_triple" value="{{ old('harga_triple') }}"
                                            min="0" step="1000" placeholder="23000000"
                                            class="form-control @error('harga_triple') is-invalid @enderror">
                                        @error('harga_triple')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Harga Quad <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" name="harga_quad" value="{{ old('harga_quad') }}"
                                            min="0" step="1000" placeholder="21000000"
                                            class="form-control @error('harga_quad') is-invalid @enderror">
                                        @error('harga_quad')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Catatan --}}
                    <div class="card shadow-sm mb-4">
                        <div class="card-header fw-semibold bg-white border-bottom">
                            <i class="bi bi-journal-text me-2 text-secondary"></i>Catatan
                        </div>
                        <div class="card-body">
                            <textarea name="catatan" rows="4" placeholder="Catatan tambahan keberangkatan (opsional)..."
                                class="form-control @error('catatan') is-invalid @enderror">{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>

                {{-- Kolom Kanan --}}
                <div class="col-lg-4">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header fw-semibold bg-white border-bottom">
                            <i class="bi bi-toggle-on me-2 text-warning"></i>Status Keberangkatan
                        </div>
                        <div class="card-body">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                @foreach (['open', 'closed', 'berangkat', 'selesai', 'batal'] as $s)
                                    <option value="{{ $s }}"
                                        {{ old('status', 'open') === $s ? 'selected' : '' }}>
                                        {{ ucfirst($s) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <div class="mt-3">
                                <small class="text-muted">
                                    <ul class="ps-3 mb-0">
                                        <li><strong>Open</strong> – Pendaftaran dibuka</li>
                                        <li><strong>Closed</strong> – Pendaftaran ditutup</li>
                                        <li><strong>Berangkat</strong> – Sedang dalam perjalanan</li>
                                        <li><strong>Selesai</strong> – Sudah kembali</li>
                                        <li><strong>Batal</strong> – Keberangkatan dibatalkan</li>
                                    </ul>
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan Keberangkatan
                        </button>
                        <a href="{{ route('admin.keberangkatan.index') }}" class="btn btn-outline-secondary">
                            Batal
                        </a>
                    </div>
                </div>

            </div>
        </form>

    </div>
@endsection
