@extends('layouts.app')
@section('title', 'Buka Rekening Tabungan')
@section('page-title', 'Tabungan')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.tabungan.index') }}">Data Tabungan</a></div>
    <div class="breadcrumb-item active">Buka Rekening</div>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Form Buka Rekening Tabungan</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.tabungan.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Jamaah <span class="text-danger">*</span></label>
                            <select name="jamaah_id" class="form-control @error('jamaah_id') is-invalid @enderror">
                                <option value="">-- Pilih Jamaah --</option>
                                @foreach ($jamaah as $j)
                                    <option value="{{ $j->id }}" {{ old('jamaah_id') == $j->id ? 'selected' : '' }}>
                                        {{ $j->nama_lengkap }} - {{ $j->nik }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jamaah_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Jenis Tabungan <span class="text-danger">*</span></label>
                            <select name="jenis" class="form-control @error('jenis') is-invalid @enderror">
                                <option value="umroh" {{ old('jenis', $jenis) == 'umroh' ? 'selected' : '' }}>Umroh
                                </option>
                                <option value="haji" {{ old('jenis', $jenis) == 'haji' ? 'selected' : '' }}>Haji</option>
                            </select>
                            @error('jenis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Target Tabungan (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="target_tabungan"
                                class="form-control @error('target_tabungan') is-invalid @enderror"
                                value="{{ old('target_tabungan') }}" min="1">
                            @error('target_tabungan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Buka <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_buka"
                                        class="form-control @error('tanggal_buka') is-invalid @enderror"
                                        value="{{ old('tanggal_buka', date('Y-m-d')) }}">
                                    @error('tanggal_buka')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Target</label>
                                    <input type="date" name="tanggal_target" class="form-control"
                                        value="{{ old('tanggal_target') }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Catatan</label>
                            <textarea name="catatan" class="form-control" rows="3">{{ old('catatan') }}</textarea>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
                            <a href="{{ route('admin.tabungan.index') }}" class="btn btn-secondary ml-2"><i
                                    class="fas fa-arrow-left mr-1"></i> Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
