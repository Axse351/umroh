@extends('layouts.app')
@section('title', 'Tambah Layanan')
@section('page-title', 'Layanan')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.layanan.index') }}">Data Layanan</a></div>
    <div class="breadcrumb-item active">Tambah</div>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Form Tambah Layanan</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.layanan.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Nama Layanan <span class="text-danger">*</span></label>
                            <input type="text" name="nama_layanan"
                                class="form-control @error('nama_layanan') is-invalid @enderror"
                                value="{{ old('nama_layanan') }}">
                            @error('nama_layanan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jenis <span class="text-danger">*</span></label>
                                    <select name="jenis" class="form-control @error('jenis') is-invalid @enderror">
                                        <option value="umroh" {{ old('jenis') == 'umroh' ? 'selected' : '' }}>Umroh
                                        </option>
                                        <option value="haji" {{ old('jenis') == 'haji' ? 'selected' : '' }}>Haji
                                        </option>
                                        <option value="keduanya" {{ old('jenis') == 'keduanya' ? 'selected' : '' }}>Keduanya
                                        </option>
                                    </select>
                                    @error('jenis')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kategori <span class="text-danger">*</span></label>
                                    <select name="kategori" class="form-control @error('kategori') is-invalid @enderror">
                                        @foreach (['visa', 'asuransi', 'vaksin', 'manasik', 'perlengkapan', 'transportasi', 'lainnya'] as $k)
                                            <option value="{{ $k }}"
                                                {{ old('kategori') == $k ? 'selected' : '' }}>{{ ucfirst($k) }}</option>
                                        @endforeach
                                    </select>
                                    @error('kategori')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Harga (Rp) <span class="text-danger">*</span></label>
                                    <input type="number" name="harga"
                                        class="form-control @error('harga') is-invalid @enderror"
                                        value="{{ old('harga') }}" min="0">
                                    @error('harga')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>
                                            Aktif</option>
                                        <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>
                                            Nonaktif</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi') }}</textarea>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
                            <a href="{{ route('admin.layanan.index') }}" class="btn btn-secondary ml-2"><i
                                    class="fas fa-arrow-left mr-1"></i> Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
