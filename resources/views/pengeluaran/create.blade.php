@extends('layouts.app')
@section('title', 'Tambah Pengeluaran')
@section('page-title', 'Pengeluaran')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('pengeluaran.index') }}">Data Pengeluaran</a></div>
    <div class="breadcrumb-item active">Tambah</div>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h4>Form Tambah Pengeluaran</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('pengeluaran.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Keperluan <span class="text-danger">*</span></label>
                            <input type="text" name="keperluan"
                                class="form-control @error('keperluan') is-invalid @enderror" value="{{ old('keperluan') }}"
                                placeholder="contoh: Pembayaran hotel Madinah">
                            @error('keperluan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kategori <span class="text-danger">*</span></label>
                                    <select name="kategori" class="form-control @error('kategori') is-invalid @enderror">
                                        @foreach (['operasional', 'gaji', 'visa', 'tiket', 'hotel', 'transportasi', 'perlengkapan', 'marketing', 'lainnya'] as $k)
                                            <option value="{{ $k }}"
                                                {{ old('kategori') == $k ? 'selected' : '' }}>{{ ucfirst($k) }}</option>
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jumlah (Rp) <span class="text-danger">*</span></label>
                                    <input type="number" name="jumlah"
                                        class="form-control @error('jumlah') is-invalid @enderror"
                                        value="{{ old('jumlah') }}" min="1">
                                    @error('jumlah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Penerima</label>
                                    <input type="text" name="penerima" class="form-control"
                                        value="{{ old('penerima') }}" placeholder="Nama penerima dana">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Bukti Pengeluaran</label>
                            <div class="custom-file">
                                <input type="file" name="bukti" class="custom-file-input" id="bukti"
                                    accept="image/*" onchange="previewImage(this,'prev-bukti')">
                                <label class="custom-file-label" for="bukti">Pilih file...</label>
                            </div>
                            <img id="prev-bukti" src="#" class="img-thumbnail d-none mt-2" style="max-height:150px">
                        </div>
                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan') }}</textarea>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
                            <a href="{{ route('pengeluaran.index') }}" class="btn btn-secondary ml-2"><i
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
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    const img = document.getElementById(previewId);
                    img.src = e.target.result;
                    img.classList.remove('d-none');
                };
                reader.readAsDataURL(input.files[0]);
                input.nextElementSibling.textContent = input.files[0].name;
            }
        }
    </script>
@endpush
