@extends('layouts.app')
@section('title', 'Edit Mitra')
@section('page-title', 'Mitra')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.mitra.index') }}">Data Mitra</a></div>
    <div class="breadcrumb-item active">Edit</div>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Mitra &mdash; <small class="text-muted">{{ $mitra->kode_mitra }}</small></h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.mitra.update', $mitra) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Nama Mitra <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_mitra"
                                        class="form-control @error('nama_mitra') is-invalid @enderror"
                                        value="{{ old('nama_mitra', $mitra->nama_mitra) }}">
                                    @error('nama_mitra')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Jenis <span class="text-danger">*</span></label>
                                    <select name="jenis" class="form-control @error('jenis') is-invalid @enderror">
                                        @foreach (['bank', 'asuransi', 'supplier', 'partner', 'lainnya'] as $j)
                                            <option value="{{ $j }}"
                                                {{ old('jenis', $mitra->jenis) == $j ? 'selected' : '' }}>
                                                {{ ucfirst($j) }}</option>
                                        @endforeach
                                    </select>
                                    @error('jenis')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama PIC</label>
                                    <input type="text" name="nama_pic" class="form-control"
                                        value="{{ old('nama_pic', $mitra->nama_pic) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>No. Telepon</label>
                                    <input type="text" name="no_telepon" class="form-control"
                                        value="{{ old('no_telepon', $mitra->no_telepon) }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ old('email', $mitra->email) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control">
                                        <option value="aktif"
                                            {{ old('status', $mitra->status) == 'aktif' ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="nonaktif"
                                            {{ old('status', $mitra->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $mitra->alamat) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan', $mitra->keterangan) }}</textarea>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-warning"><i class="fas fa-save mr-1"></i> Update</button>
                            <a href="{{ route('admin.mitra.index') }}" class="btn btn-secondary ml-2"><i
                                    class="fas fa-arrow-left mr-1"></i> Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
