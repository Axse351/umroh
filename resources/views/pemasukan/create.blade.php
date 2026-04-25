@extends('layouts.app')
@section('title', 'Tambah Pemasukan')
@section('page-title', 'Pemasukan')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.pemasukan.index') }}">Data Pemasukan</a></div>
    <div class="breadcrumb-item active">Tambah</div>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h4>Form Tambah Pemasukan</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pemasukan.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Sumber Pemasukan <span class="text-danger">*</span></label>
                            <input type="text" name="sumber" class="form-control @error('sumber') is-invalid @enderror"
                                value="{{ old('sumber') }}" placeholder="contoh: Pembayaran Bpk. Ahmad">
                            @error('sumber')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kategori <span class="text-danger">*</span></label>
                                    <select name="kategori" class="form-control @error('kategori') is-invalid @enderror">
                                        @foreach (['pembayaran_jamaah', 'setoran_tabungan', 'transaksi_layanan', 'komisi', 'lainnya'] as $k)
                                            <option value="{{ $k }}"
                                                {{ old('kategori') == $k ? 'selected' : '' }}>
                                                {{ ucwords(str_replace('_', ' ', $k)) }}</option>
                                        @endforeach
                                    </select>
                                    @error('kategori')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal"
                                        class="form-control @error('tanggal') is-invalid @enderror"
                                        value="{{ old('tanggal', date('Y-m-d')) }}">
                                    @error('tanggal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Jumlah (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror"
                                value="{{ old('jumlah') }}" min="1">
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan') }}</textarea>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
                            <a href="{{ route('admin.pemasukan.index') }}" class="btn btn-secondary ml-2"><i
                                    class="fas fa-arrow-left mr-1"></i> Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
