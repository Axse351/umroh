@extends('layouts.app')
@section('title', 'Edit Akses')
@section('page-title', 'Edit Akses System')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('akses-system.index') }}">Akses System</a></div>
    <div class="breadcrumb-item active">Edit</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Form Edit Akses</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('akses-system.update', $aksesSystem) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="form-group">
                            <label>Karyawan</label>
                            <input type="text" class="form-control"
                                value="{{ $aksesSystem->karyawan->nama_lengkap ?? '-' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label>Email Login</label>
                            <input type="text" class="form-control" value="{{ $aksesSystem->user->email ?? '-' }}"
                                readonly>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Role <span class="text-danger">*</span></label>
                                    <select name="role" class="form-control">
                                        @foreach (['superadmin', 'admin', 'kasir', 'marketing', 'gudang', 'viewer'] as $r)
                                            <option value="{{ $r }}"
                                                {{ old('role', $aksesSystem->role) == $r ? 'selected' : '' }}>{{ ucfirst($r) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="aktif"
                                            {{ old('status', $aksesSystem->status) == 'aktif' ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="nonaktif"
                                            {{ old('status', $aksesSystem->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Password Baru <small class="text-muted">(kosongkan jika tidak
                                            diubah)</small></label>
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
                                    <label>Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                        placeholder="Ulangi password baru">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <button type="submit" class="btn btn-warning"><i class="fas fa-save mr-1"></i> Update</button>
                            <a href="{{ route('akses-system.index') }}" class="btn btn-secondary ml-2"><i
                                    class="fas fa-arrow-left mr-1"></i> Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
