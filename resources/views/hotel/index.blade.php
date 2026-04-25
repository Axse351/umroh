@extends('layouts.app')
@section('title', 'Edit Maskapai')
@section('page-title', 'Edit Maskapai')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.maskapai.index') }}">Data Maskapai</a></div>
    <div class="breadcrumb-item active">Edit</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Form Edit Maskapai</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.maskapai.update', $maskapai) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="form-group">
                            <label>Nama Maskapai <span class="text-danger">*</span></label>
                            <input type="text" name="nama_maskapai"
                                class="form-control @error('nama_maskapai') is-invalid @enderror"
                                value="{{ old('nama_maskapai', $maskapai->nama_maskapai) }}">
                            @error('nama_maskapai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kode IATA</label>
                                    <input type="text" name="kode_iata" class="form-control"
                                        value="{{ old('kode_iata', $maskapai->kode_iata) }}" maxlength="5">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>No. Telepon</label>
                                    <input type="text" name="no_telepon" class="form-control"
                                        value="{{ old('no_telepon', $maskapai->no_telepon) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ old('email', $maskapai->email) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Website</label>
                                    <input type="url" name="website" class="form-control"
                                        value="{{ old('website', $maskapai->website) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="aktif"
                                            {{ old('status', $maskapai->status) == 'aktif' ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="nonaktif"
                                            {{ old('status', $maskapai->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <button type="submit" class="btn btn-warning"><i class="fas fa-save mr-1"></i> Update</button>
                            <a href="{{ route('admin.maskapai.index') }}" class="btn btn-secondary ml-2"><i
                                    class="fas fa-arrow-left mr-1"></i> Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
