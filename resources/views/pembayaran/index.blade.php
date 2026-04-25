@extends('layouts.app')
@section('title', 'Edit Pendaftaran')
@section('page-title', 'Edit Pendaftaran')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.pendaftaran.index') }}">Data Pendaftaran</a></div>
    <div class="breadcrumb-item active">Edit</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Form Edit Pendaftaran &mdash; <small class="text-muted">{{ $pendaftaran->no_pendaftaran }}</small>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pendaftaran.update', $pendaftaran) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jamaah</label>
                                    <input type="text" class="form-control"
                                        value="{{ $pendaftaran->jamaah->nama_lengkap }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Keberangkatan</label>
                                    <input type="text" class="form-control"
                                        value="{{ $pendaftaran->keberangkatan->paket->nama_paket ?? '-' }} - {{ $pendaftaran->keberangkatan->tanggal_berangkat?->format('d/m/Y') }}"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tipe Kamar</label>
                                    <select name="tipe_kamar" class="form-control">
                                        <option value="double"
                                            {{ old('tipe_kamar', $pendaftaran->tipe_kamar) == 'double' ? 'selected' : '' }}>
                                            Double
                                        </option>
                                        <option value="triple"
                                            {{ old('tipe_kamar', $pendaftaran->tipe_kamar) == 'triple' ? 'selected' : '' }}>
                                            Triple
                                        </option>
                                        <option value="quad"
                                            {{ old('tipe_kamar', $pendaftaran->tipe_kamar) == 'quad' ? 'selected' : '' }}>
                                            Quad
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Harga Jual</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                        <input type="number" name="harga_jual" class="form-control"
                                            value="{{ old('harga_jual', $pendaftaran->harga_jual) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>DP Minimal</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                        <input type="number" name="dp_minimal" class="form-control"
                                            value="{{ old('dp_minimal', $pendaftaran->dp_minimal) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Batas Pelunasan</label>
                                    <input type="date" name="batas_pelunasan" class="form-control"
                                        value="{{ old('batas_pelunasan', $pendaftaran->batas_pelunasan?->format('Y-m-d')) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        @foreach (['draft', 'konfirmasi', 'dp_terbayar', 'lunas', 'berangkat', 'selesai', 'batal', 'refund'] as $s)
                                            <option value="{{ $s }}"
                                                {{ old('status', $pendaftaran->status) == $s ? 'selected' : '' }}>
                                                {{ ucfirst(str_replace('_', ' ', $s)) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Catatan</label>
                                    <textarea name="catatan" class="form-control" rows="2">{{ old('catatan', $pendaftaran->catatan) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <button type="submit" class="btn btn-warning"><i class="fas fa-save mr-1"></i> Update</button>
                            <a href="{{ route('admin.pendaftaran.index') }}" class="btn btn-secondary ml-2"><i
                                    class="fas fa-arrow-left mr-1"></i> Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
