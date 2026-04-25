@extends('layouts.app')
@section('title', 'Edit Pembayaran')
@section('page-title', 'Edit Pembayaran')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.pembayaran.index') }}">Data Pembayaran</a></div>
    <div class="breadcrumb-item active">Edit</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Form Edit Pembayaran &mdash; <small class="text-muted">{{ $pembayaran->no_pembayaran }}</small></h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pembayaran.update', $pembayaran) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jumlah Bayar</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                        <input type="number" name="jumlah_bayar" class="form-control"
                                            value="{{ old('jumlah_bayar', $pembayaran->jumlah_bayar) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Bayar</label>
                                    <input type="date" name="tanggal_bayar" class="form-control"
                                        value="{{ old('tanggal_bayar', $pembayaran->tanggal_bayar?->format('Y-m-d')) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Jenis</label>
                                    <select name="jenis" class="form-control">
                                        @foreach (['dp', 'cicilan', 'pelunasan', 'lainnya'] as $j)
                                            <option value="{{ $j }}"
                                                {{ old('jenis', $pembayaran->jenis) == $j ? 'selected' : '' }}>
                                                {{ ucfirst($j) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Metode Bayar</label>
                                    <select name="metode_bayar" class="form-control">
                                        @foreach (['tunai', 'transfer', 'debit', 'kredit', 'qris'] as $m)
                                            <option value="{{ $m }}"
                                                {{ old('metode_bayar', $pembayaran->metode_bayar) == $m ? 'selected' : '' }}>
                                                {{ ucfirst($m) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        @foreach (['pending', 'verifikasi', 'diterima', 'ditolak'] as $s)
                                            <option value="{{ $s }}"
                                                {{ old('status', $pembayaran->status) == $s ? 'selected' : '' }}>
                                                {{ ucfirst($s) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Bukti Bayar</label>
                                    @if ($pembayaran->bukti_bayar)
                                        <div class="mb-1">
                                            <img src="{{ asset('storage/' . $pembayaran->bukti_bayar) }}"
                                                class="img-thumbnail" style="max-height:80px">
                                        </div>
                                    @endif
                                    <div class="custom-file">
                                        <input type="file" name="bukti_bayar" class="custom-file-input" id="bukti"
                                            accept="image/*"
                                            onchange="this.nextElementSibling.textContent=this.files[0].name">
                                        <label class="custom-file-label" for="bukti">Ganti file...</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Catatan</label>
                                    <textarea name="catatan" class="form-control" rows="2">{{ old('catatan', $pembayaran->catatan) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <button type="submit" class="btn btn-warning"><i class="fas fa-save mr-1"></i> Update</button>
                            <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-secondary ml-2"><i
                                    class="fas fa-arrow-left mr-1"></i> Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
