@extends('layouts.app')
@section('title', 'Tambah Maskapai')
@section('page-title', 'Tambah Maskapai')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.maskapai.index') }}">Data Maskapai</a></div>
    <div class="breadcrumb-item active">Tambah</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Form Tambah Maskapai</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.maskapai.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Nama Maskapai <span class="text-danger">*</span></label>
                            <input type="text" name="nama_maskapai"
                                class="form-control @error('nama_maskapai') is-invalid @enderror"
                                value="{{ old('nama_maskapai') }}" placeholder="Contoh: Garuda Indonesia">
                            @error('nama_maskapai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kode IATA</label>
                                    <input type="text" name="kode_iata" class="form-control"
                                        value="{{ old('kode_iata') }}" placeholder="Contoh: GA" maxlength="5">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>No. Telepon</label>
                                    <input type="text" name="no_telepon" class="form-control"
                                        value="{{ old('no_telepon') }}" placeholder="08xxxxxxxxxx">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" placeholder="email@maskapai.com">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Website</label>
                                    <input type="url" name="website"
                                        class="form-control @error('website') is-invalid @enderror"
                                        value="{{ old('website') }}" placeholder="https://maskapai.com">
                                    @error('website')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="aktif">Aktif</option>
                                        <option value="nonaktif">Nonaktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
                            <a href="{{ route('admin.maskapai.index') }}" class="btn btn-secondary ml-2"><i
                                    class="fas fa-arrow-left mr-1"></i> Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
