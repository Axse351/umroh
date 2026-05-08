@extends('layouts.app')

@section('title', 'Edit Keberangkatan')
@section('page-title', 'Edit Keberangkatan')

@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.keberangkatan.index') }}">Data Keberangkatan</a></div>
    <div class="breadcrumb-item active">Edit</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>
                        Edit Keberangkatan
                        <span class="badge badge-light ml-2" style="font-size: 0.75rem;">
                            {{ $keberangkatan->kode_keberangkatan }}
                        </span>
                    </h4>
                    <a href="{{ route('admin.keberangkatan.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body">

                    <form action="{{ route('admin.keberangkatan.update', $keberangkatan) }}" method="POST">
                        @csrf @method('PUT')

                        {{-- Informasi Utama --}}
                        <h6 class="text-muted text-uppercase font-weight-bold mb-3">
                            <i class="fas fa-info-circle mr-1"></i> Informasi Utama
                        </h6>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Paket <span class="text-danger">*</span></label>
                                    <select name="paket_id" class="form-control @error('paket_id') is-invalid @enderror">
                                        <option value="">-- Pilih Paket --</option>
                                        @foreach ($pakets as $paket)
                                            <option value="{{ $paket->id }}"
                                                {{ old('paket_id', $keberangkatan->paket_id) == $paket->id ? 'selected' : '' }}>
                                                {{ $paket->nama_paket }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('paket_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Pembimbing</label>
                                    <select name="pembimbing_id"
                                        class="form-control @error('pembimbing_id') is-invalid @enderror">
                                        <option value="">-- Tanpa Pembimbing --</option>
                                        @foreach ($karyawans as $karyawan)
                                            <option value="{{ $karyawan->id }}"
                                                {{ old('pembimbing_id', $keberangkatan->pembimbing_id) == $karyawan->id ? 'selected' : '' }}>
                                                {{ $karyawan->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('pembimbing_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Tanggal Berangkat <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_berangkat"
                                        value="{{ old('tanggal_berangkat', \Carbon\Carbon::parse($keberangkatan->tanggal_berangkat)->format('Y-m-d')) }}"
                                        class="form-control @error('tanggal_berangkat') is-invalid @enderror">
                                    @error('tanggal_berangkat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Tanggal Pulang <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_pulang"
                                        value="{{ old('tanggal_pulang', \Carbon\Carbon::parse($keberangkatan->tanggal_pulang)->format('Y-m-d')) }}"
                                        class="form-control @error('tanggal_pulang') is-invalid @enderror">
                                    @error('tanggal_pulang')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Bandara Keberangkatan <span class="text-danger">*</span></label>
                                    <input type="text" name="bandara_keberangkatan"
                                        value="{{ old('bandara_keberangkatan', $keberangkatan->bandara_keberangkatan) }}"
                                        placeholder="CGK" maxlength="10"
                                        class="form-control text-uppercase @error('bandara_keberangkatan') is-invalid @enderror">
                                    @error('bandara_keberangkatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Kuota <span class="text-danger">*</span></label>
                                    <input type="number" name="kuota" value="{{ old('kuota', $keberangkatan->kuota) }}"
                                        min="1" class="form-control @error('kuota') is-invalid @enderror">
                                    @error('kuota')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>No. Penerbangan Pergi</label>
                                    <input type="text" name="no_penerbangan_pergi"
                                        value="{{ old('no_penerbangan_pergi', $keberangkatan->no_penerbangan_pergi) }}"
                                        placeholder="GA-001"
                                        class="form-control @error('no_penerbangan_pergi') is-invalid @enderror">
                                    @error('no_penerbangan_pergi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>No. Penerbangan Pulang</label>
                                    <input type="text" name="no_penerbangan_pulang"
                                        value="{{ old('no_penerbangan_pulang', $keberangkatan->no_penerbangan_pulang) }}"
                                        placeholder="GA-002"
                                        class="form-control @error('no_penerbangan_pulang') is-invalid @enderror">
                                    @error('no_penerbangan_pulang')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                                        @foreach (['open', 'closed', 'berangkat', 'selesai', 'batal'] as $s)
                                            <option value="{{ $s }}"
                                                {{ old('status', $keberangkatan->status) === $s ? 'selected' : '' }}>
                                                {{ ucfirst($s) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- Harga Kamar --}}
                        <h6 class="text-muted text-uppercase font-weight-bold mb-3">
                            <i class="fas fa-money-bill-wave mr-1"></i> Harga Kamar
                        </h6>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Harga Double <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="number" name="harga_double"
                                            value="{{ old('harga_double', $keberangkatan->harga_double) }}"
                                            min="0" step="1000"
                                            class="form-control @error('harga_double') is-invalid @enderror">
                                        @error('harga_double')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Harga Triple <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="number" name="harga_triple"
                                            value="{{ old('harga_triple', $keberangkatan->harga_triple) }}"
                                            min="0" step="1000"
                                            class="form-control @error('harga_triple') is-invalid @enderror">
                                        @error('harga_triple')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Harga Quad <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="number" name="harga_quad"
                                            value="{{ old('harga_quad', $keberangkatan->harga_quad) }}" min="0"
                                            step="1000"
                                            class="form-control @error('harga_quad') is-invalid @enderror">
                                        @error('harga_quad')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- Catatan --}}
                        <h6 class="text-muted text-uppercase font-weight-bold mb-3">
                            <i class="fas fa-sticky-note mr-1"></i> Catatan
                        </h6>

                        <div class="form-group">
                            <textarea name="catatan" rows="4" placeholder="Catatan tambahan keberangkatan (opsional)..."
                                class="form-control @error('catatan') is-invalid @enderror">{{ old('catatan', $keberangkatan->catatan) }}</textarea>
                            @error('catatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="fas fa-save mr-1"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('admin.keberangkatan.index') }}" class="btn btn-secondary">
                                Batal
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection
