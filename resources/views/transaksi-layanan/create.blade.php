@extends('layouts.app')
@section('title', 'Tambah Transaksi Layanan')
@section('page-title', 'Transaksi Layanan')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.transaksi-layanan.index') }}">Transaksi Layanan</a></div>
    <div class="breadcrumb-item active">Tambah</div>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">
                    <h4>Form Tambah Transaksi Layanan</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.transaksi-layanan.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Pendaftaran / Jamaah <span class="text-danger">*</span></label>
                                    <select name="pendaftaran_id"
                                        class="form-control @error('pendaftaran_id') is-invalid @enderror">
                                        <option value="">-- Pilih Pendaftaran --</option>
                                        @foreach ($pendaftarans as $p)
                                            <option value="{{ $p->id }}"
                                                {{ old('pendaftaran_id', $pendaftaran_id) == $p->id ? 'selected' : '' }}>
                                                {{ $p->jamaah->nama_lengkap ?? '-' }} - {{ $p->no_pendaftaran ?? $p->id }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('pendaftaran_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Layanan <span class="text-danger">*</span></label>
                                    <select name="layanan_id" id="layanan_id"
                                        class="form-control @error('layanan_id') is-invalid @enderror"
                                        onchange="setHarga(this)">
                                        <option value="">-- Pilih Layanan --</option>
                                        @foreach ($layanans as $l)
                                            <option value="{{ $l->id }}" data-harga="{{ $l->harga }}"
                                                {{ old('layanan_id') == $l->id ? 'selected' : '' }}>
                                                {{ $l->nama_layanan }} (Rp {{ number_format($l->harga, 0, ',', '.') }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('layanan_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Qty <span class="text-danger">*</span></label>
                                    <input type="number" name="qty" id="qty"
                                        class="form-control @error('qty') is-invalid @enderror" value="{{ old('qty', 1) }}"
                                        min="1" oninput="hitungTotal()">
                                    @error('qty')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Harga Satuan (Rp) <span class="text-danger">*</span></label>
                                    <input type="number" name="harga_satuan" id="harga_satuan"
                                        class="form-control @error('harga_satuan') is-invalid @enderror"
                                        value="{{ old('harga_satuan', 0) }}" min="0" oninput="hitungTotal()">
                                    @error('harga_satuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Total Harga</label>
                                    <input type="text" id="total_display" class="form-control" disabled value="Rp 0">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Transaksi <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_transaksi"
                                        class="form-control @error('tanggal_transaksi') is-invalid @enderror"
                                        value="{{ old('tanggal_transaksi', date('Y-m-d')) }}">
                                    @error('tanggal_transaksi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="pending"
                                            {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="proses" {{ old('status') == 'proses' ? 'selected' : '' }}>Proses
                                        </option>
                                        <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai
                                        </option>
                                        <option value="batal" {{ old('status') == 'batal' ? 'selected' : '' }}>Batal
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Catatan</label>
                            <textarea name="catatan" class="form-control" rows="2">{{ old('catatan') }}</textarea>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
                            <a href="{{ route('admin.transaksi-layanan.index') }}" class="btn btn-secondary ml-2"><i
                                    class="fas fa-arrow-left mr-1"></i> Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function setHarga(sel) {
            const opt = sel.options[sel.selectedIndex];
            document.getElementById('harga_satuan').value = opt.dataset.harga || 0;
            hitungTotal();
        }

        function hitungTotal() {
            const qty = parseFloat(document.getElementById('qty').value) || 0;
            const harga = parseFloat(document.getElementById('harga_satuan').value) || 0;
            document.getElementById('total_display').value = 'Rp ' + (qty * harga).toLocaleString('id-ID');
        }
        hitungTotal();
    </script>
@endpush
