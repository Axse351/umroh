@extends('layouts.app')
@section('title', 'Edit Transaksi Layanan')
@section('page-title', 'Transaksi Layanan')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.transaksi-layanan.index') }}">Transaksi Layanan</a></div>
    <div class="breadcrumb-item active">Edit</div>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Transaksi &mdash; <small class="text-muted">{{ $transaksiLayanan->no_transaksi }}</small></h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.transaksi-layanan.update', $transaksiLayanan) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jamaah</label>
                                    <input type="text" class="form-control"
                                        value="{{ $transaksiLayanan->pendaftaran->jamaah->nama_lengkap ?? '-' }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Layanan</label>
                                    <input type="text" class="form-control"
                                        value="{{ $transaksiLayanan->layanan->nama_layanan ?? '-' }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Qty <span class="text-danger">*</span></label>
                                    <input type="number" name="qty" id="qty"
                                        class="form-control @error('qty') is-invalid @enderror"
                                        value="{{ old('qty', $transaksiLayanan->qty) }}" min="1"
                                        oninput="hitungTotal()">
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
                                        value="{{ old('harga_satuan', $transaksiLayanan->harga_satuan) }}" min="0"
                                        oninput="hitungTotal()">
                                    @error('harga_satuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Total Harga</label>
                                    <input type="text" id="total_display" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Transaksi <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_transaksi"
                                        class="form-control @error('tanggal_transaksi') is-invalid @enderror"
                                        value="{{ old('tanggal_transaksi', $transaksiLayanan->tanggal_transaksi?->format('Y-m-d')) }}">
                                    @error('tanggal_transaksi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                                        @foreach (['pending', 'proses', 'selesai', 'batal'] as $s)
                                            <option value="{{ $s }}"
                                                {{ old('status', $transaksiLayanan->status) == $s ? 'selected' : '' }}>
                                                {{ ucfirst($s) }}</option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Catatan</label>
                            <textarea name="catatan" class="form-control" rows="2">{{ old('catatan', $transaksiLayanan->catatan) }}</textarea>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-warning"><i class="fas fa-save mr-1"></i> Update</button>
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
        function hitungTotal() {
            const qty = parseFloat(document.getElementById('qty').value) || 0;
            const harga = parseFloat(document.getElementById('harga_satuan').value) || 0;
            document.getElementById('total_display').value = 'Rp ' + (qty * harga).toLocaleString('id-ID');
        }
        hitungTotal();
    </script>
@endpush
