@extends('layouts.app')
@section('title', 'Tambah Supplier')
@section('page-title', 'Supplier')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.supplier.index') }}">Data Supplier</a></div>
    <div class="breadcrumb-item active">Tambah</div>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">
                    <h4>Form Tambah Supplier</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.supplier.store') }}" method="POST">
                        @csrf
                        <h6 class="text-primary mb-3"><i class="fas fa-building mr-1"></i> Informasi Supplier</h6>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Nama Supplier <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_supplier"
                                        class="form-control @error('nama_supplier') is-invalid @enderror"
                                        value="{{ old('nama_supplier') }}">
                                    @error('nama_supplier')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Kategori <span class="text-danger">*</span></label>
                                    <select name="kategori" class="form-control @error('kategori') is-invalid @enderror">
                                        @foreach (['perlengkapan', 'makanan', 'souvenir', 'percetakan', 'lainnya'] as $k)
                                            <option value="{{ $k }}"
                                                {{ old('kategori') == $k ? 'selected' : '' }}>{{ ucfirst($k) }}</option>
                                        @endforeach
                                    </select>
                                    @error('kategori')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama PIC</label>
                                    <input type="text" name="nama_pic" class="form-control" value="{{ old('nama_pic') }}"
                                        placeholder="Person in Charge">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>No. Telepon <span class="text-danger">*</span></label>
                                    <input type="text" name="no_telepon"
                                        class="form-control @error('no_telepon') is-invalid @enderror"
                                        value="{{ old('no_telepon') }}">
                                    @error('no_telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control">
                                        <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>
                                            Aktif</option>
                                        <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>
                                            Nonaktif</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea name="alamat" class="form-control" rows="2">{{ old('alamat') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h6 class="text-primary mb-3"><i class="fas fa-university mr-1"></i> Informasi Rekening</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Bank</label>
                                    <input type="text" name="nama_bank" class="form-control"
                                        value="{{ old('nama_bank') }}" placeholder="BCA, BRI, Mandiri, dll">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>No. Rekening</label>
                                    <input type="text" name="no_rekening" class="form-control"
                                        value="{{ old('no_rekening') }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
                            <a href="{{ route('admin.supplier.index') }}" class="btn btn-secondary ml-2"><i
                                    class="fas fa-arrow-left mr-1"></i> Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
