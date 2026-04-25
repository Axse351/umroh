@extends('layouts.app')
@section('title', 'Tambah Akses')
@section('page-title', 'Tambah Akses System')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('akses-system.index') }}">Akses System</a></div>
    <div class="breadcrumb-item active">Tambah</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Form Tambah Akses / User Login</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('akses-system.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Karyawan <span class="text-danger">*</span></label>
                            <select name="karyawan_id" class="form-control @error('karyawan_id') is-invalid @enderror">
                                <option value="">-- Pilih Karyawan --</option>
                                @foreach ($karyawans as $k)
                                    <option value="{{ $k->id }}"
                                        {{ old('karyawan_id') == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama_lengkap }} - {{ $k->jabatan }}</option>
                                @endforeach
                            </select>
                            @error('karyawan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email Login <span class="text-danger">*</span></label>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" placeholder="email@contoh.com">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Role <span class="text-danger">*</span></label>
                                    <select name="role" class="form-control @error('role') is-invalid @enderror">
                                        <option value="">-- Pilih Role --</option>
                                        @foreach (['superadmin', 'admin', 'kasir', 'marketing', 'gudang', 'viewer'] as $r)
                                            <option value="{{ $r }}" {{ old('role') == $r ? 'selected' : '' }}>
                                                {{ ucfirst($r) }}</option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Min. 8 karakter">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Konfirmasi Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                        placeholder="Ulangi password">
                                </div>
                            </div>
                            <div class="col-md-4">
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
                            <a href="{{ route('akses-system.index') }}" class="btn btn-secondary ml-2"><i
                                    class="fas fa-arrow-left mr-1"></i> Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
