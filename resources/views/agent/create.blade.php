@extends('layouts.app')

@section('title', 'Tambah Agent')
@section('page-title', 'Tambah Agent')

@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.agent.index') }}">Data Agent</a></div>
    <div class="breadcrumb-item active">Tambah</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Form Tambah Agent</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.agent.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Agent <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_agent"
                                        class="form-control @error('nama_agent') is-invalid @enderror"
                                        value="{{ old('nama_agent') }}" placeholder="Nama agen travel">
                                    @error('nama_agent')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama PIC <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_pic"
                                        class="form-control @error('nama_pic') is-invalid @enderror"
                                        value="{{ old('nama_pic') }}" placeholder="Person in charge">
                                    @error('nama_pic')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Jenis <span class="text-danger">*</span></label>
                                    <select name="jenis" class="form-control @error('jenis') is-invalid @enderror">
                                        <option value="">-- Pilih --</option>
                                        <option value="umroh" {{ old('jenis') == 'umroh' ? 'selected' : '' }}>Umroh
                                        </option>
                                        <option value="haji" {{ old('jenis') == 'haji' ? 'selected' : '' }}>Haji</option>
                                        <option value="keduanya" {{ old('jenis') == 'keduanya' ? 'selected' : '' }}>Keduanya
                                        </option>
                                    </select>
                                    @error('jenis')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>No. Telepon <span class="text-danger">*</span></label>
                                    <input type="text" name="no_telepon"
                                        class="form-control @error('no_telepon') is-invalid @enderror"
                                        value="{{ old('no_telepon') }}" placeholder="08xxxxxxxxxx">
                                    @error('no_telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" placeholder="email@contoh.com">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Kota</label>
                                    <input type="text" name="kota" class="form-control" value="{{ old('kota') }}"
                                        placeholder="Kota">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Provinsi</label>
                                    <input type="text" name="provinsi" class="form-control"
                                        value="{{ old('provinsi') }}" placeholder="Provinsi">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Komisi (%)</label>
                                    <div class="input-group">
                                        <input type="number" name="komisi_persen" class="form-control"
                                            value="{{ old('komisi_persen', 0) }}" min="0" max="100"
                                            step="0.01">
                                        <div class="input-group-append"><span class="input-group-text">%</span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat lengkap">{{ old('alamat') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>
                                            Nonaktif
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
                            <a href="{{ route('admin.agent.index') }}" class="btn btn-secondary ml-2"><i
                                    class="fas fa-arrow-left mr-1"></i> Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
