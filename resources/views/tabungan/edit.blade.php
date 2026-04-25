@extends('layouts.app')
@section('title', 'Edit Tabungan')
@section('page-title', 'Tabungan')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.tabungan.index') }}">Data Tabungan</a></div>
    <div class="breadcrumb-item active">Edit</div>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Tabungan &mdash; <small class="text-muted">{{ $tabungan->no_rekening_tabungan }}</small></h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.tabungan.update', $tabungan) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="form-group">
                            <label>Jamaah</label>
                            <input type="text" class="form-control" value="{{ $tabungan->jamaah->nama_lengkap ?? '-' }}"
                                disabled>
                        </div>
                        <div class="form-group">
                            <label>Jenis Tabungan</label>
                            <input type="text" class="form-control" value="{{ ucfirst($tabungan->jenis) }}" disabled>
                        </div>
                        <div class="form-group">
                            <label>Saldo Saat Ini</label>
                            <input type="text" class="form-control"
                                value="Rp {{ number_format($tabungan->saldo, 0, ',', '.') }}" disabled>
                        </div>
                        <div class="form-group">
                            <label>Target Tabungan (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="target_tabungan"
                                class="form-control @error('target_tabungan') is-invalid @enderror"
                                value="{{ old('target_tabungan', $tabungan->target_tabungan) }}" min="1">
                            @error('target_tabungan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Tanggal Target</label>
                            <input type="date" name="tanggal_target" class="form-control"
                                value="{{ old('tanggal_target', $tabungan->tanggal_target?->format('Y-m-d')) }}">
                        </div>
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="aktif" {{ old('status', $tabungan->status) == 'aktif' ? 'selected' : '' }}>
                                    Aktif</option>
                                <option value="selesai"
                                    {{ old('status', $tabungan->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="batal" {{ old('status', $tabungan->status) == 'batal' ? 'selected' : '' }}>
                                    Batal</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Catatan</label>
                            <textarea name="catatan" class="form-control" rows="3">{{ old('catatan', $tabungan->catatan) }}</textarea>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-warning"><i class="fas fa-save mr-1"></i> Update</button>
                            <a href="{{ route('admin.tabungan.index') }}" class="btn btn-secondary ml-2"><i
                                    class="fas fa-arrow-left mr-1"></i> Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
