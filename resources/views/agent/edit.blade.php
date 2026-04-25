@extends('layouts.app')

@section('title', 'Edit Agent')
@section('page-title', 'Edit Agent')

@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('agent.index') }}">Data Agent</a></div>
    <div class="breadcrumb-item active">Edit</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Form Edit Agent</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('agent.update', $agent) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Agent <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_agent"
                                        class="form-control @error('nama_agent') is-invalid @enderror"
                                        value="{{ old('nama_agent', $agent->nama_agent) }}">
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
                                        value="{{ old('nama_pic', $agent->nama_pic) }}">
                                    @error('nama_pic')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Jenis <span class="text-danger">*</span></label>
                                    <select name="jenis" class="form-control">
                                        <option value="umroh" {{ old('jenis', $agent->jenis) == 'umroh' ? 'selected' : '' }}>
                                            Umroh</option>
                                        <option value="haji" {{ old('jenis', $agent->jenis) == 'haji' ? 'selected' : '' }}>
                                            Haji</option>
                                        <option value="keduanya"
                                            {{ old('jenis', $agent->jenis) == 'keduanya' ? 'selected' : '' }}>Keduanya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>No. Telepon <span class="text-danger">*</span></label>
                                    <input type="text" name="no_telepon" class="form-control"
                                        value="{{ old('no_telepon', $agent->no_telepon) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ old('email', $agent->email) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Kota</label>
                                    <input type="text" name="kota" class="form-control"
                                        value="{{ old('kota', $agent->kota) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Provinsi</label>
                                    <input type="text" name="provinsi" class="form-control"
                                        value="{{ old('provinsi', $agent->provinsi) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Komisi (%)</label>
                                    <div class="input-group">
                                        <input type="number" name="komisi_persen" class="form-control"
                                            value="{{ old('komisi_persen', $agent->komisi_persen) }}" min="0"
                                            max="100" step="0.01">
                                        <div class="input-group-append"><span class="input-group-text">%</span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea name="alamat" class="form-control" rows="3">{{ old('alamat', $agent->alamat) }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="aktif"
                                            {{ old('status', $agent->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="nonaktif"
                                            {{ old('status', $agent->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-warning"><i class="fas fa-save mr-1"></i> Update</button>
                            <a href="{{ route('agent.index') }}" class="btn btn-secondary ml-2"><i
                                    class="fas fa-arrow-left mr-1"></i> Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
