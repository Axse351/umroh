@extends('layouts.app')
@section('title', 'Edit Pengeluaran Produk')
@section('page-title', 'Edit Pengeluaran Produk')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.pengeluaran-produk.index') }}">Data Pengeluaran Produk</a></div>
    <div class="breadcrumb-item active">Edit</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-edit mr-1"></i> Edit Pengeluaran Produk</h4>
                </div>
                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Info readonly --}}
                    <div class="alert alert-info d-flex align-items-center">
                        <i class="fas fa-lock mr-2"></i>
                        <span>Data produk, qty, dan tanggal <strong>tidak dapat diubah</strong>. Hanya keperluan dan
                            keterangan yang dapat diedit.</span>
                    </div>

                    {{-- Detail tidak dapat diubah --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-muted small">No. Pengeluaran</label>
                                <p class="form-control-static font-weight-bold">
                                    <code>{{ $pengeluaranProduk->no_pengeluaran_produk }}</code>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-muted small">Produk</label>
                                <p class="form-control-static">{{ $pengeluaranProduk->produk->nama_produk ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-muted small">Jumlah (Qty)</label>
                                <p class="form-control-static">{{ $pengeluaranProduk->qty }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-muted small">Tanggal Keluar</label>
                                <p class="form-control-static">
                                    {{ \Carbon\Carbon::parse($pengeluaranProduk->tanggal_keluar)->format('d M Y') }}
                                </p>
                            </div>
                        </div>
                        @if ($pengeluaranProduk->pendaftaran)
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="text-muted small">Jamaah / Pendaftaran</label>
                                    <p class="form-control-static">
                                        {{ $pengeluaranProduk->pendaftaran->jamaah->nama_lengkap ?? '-' }}
                                        <small
                                            class="text-muted ml-1">({{ $pengeluaranProduk->pendaftaran->no_pendaftaran }})</small>
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <hr>

                    <form action="{{ route('admin.pengeluaran-produk.update', $pengeluaranProduk) }}" method="POST">
                        @csrf @method('PUT')

                        {{-- Keperluan --}}
                        <div class="form-group">
                            <label for="keperluan">Keperluan <span class="text-danger">*</span></label>
                            <select name="keperluan" id="keperluan"
                                class="form-control @error('keperluan') is-invalid @enderror" required>
                                <option value="">-- Pilih Keperluan --</option>
                                <option value="distribusi_jamaah"
                                    {{ old('keperluan', $pengeluaranProduk->keperluan) == 'distribusi_jamaah' ? 'selected' : '' }}>
                                    Distribusi Jamaah</option>
                                <option value="internal"
                                    {{ old('keperluan', $pengeluaranProduk->keperluan) == 'internal' ? 'selected' : '' }}>
                                    Internal</option>
                                <option value="rusak"
                                    {{ old('keperluan', $pengeluaranProduk->keperluan) == 'rusak' ? 'selected' : '' }}>
                                    Rusak</option>
                                <option value="lainnya"
                                    {{ old('keperluan', $pengeluaranProduk->keperluan) == 'lainnya' ? 'selected' : '' }}>
                                    Lainnya</option>
                            </select>
                            @error('keperluan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Keterangan --}}
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" rows="3"
                                class="form-control @error('keterangan') is-invalid @enderror" placeholder="Keterangan tambahan (opsional)">{{ old('keterangan', $pengeluaranProduk->keterangan) }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save mr-1"></i> Perbarui
                            </button>
                            <a href="{{ route('admin.pengeluaran-produk.index') }}" class="btn btn-secondary ml-2">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
