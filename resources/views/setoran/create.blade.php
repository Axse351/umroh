@extends('layouts.app')
@section('title', 'Tambah Setoran')
@section('page-title', 'Setoran')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.setoran.index') }}">Data Setoran</a></div>
    <div class="breadcrumb-item active">Tambah</div>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Form Tambah Setoran</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.setoran.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Rekening Tabungan <span class="text-danger">*</span></label>
                            <select name="tabungan_id" class="form-control @error('tabungan_id') is-invalid @enderror">
                                <option value="">-- Pilih Rekening --</option>
                                @foreach ($tabungans as $t)
                                    <option value="{{ $t->id }}"
                                        {{ old('tabungan_id', $tabungan_id) == $t->id ? 'selected' : '' }}>
                                        {{ $t->no_rekening_tabungan }} - {{ $t->jamaah->nama_lengkap ?? '-' }}
                                        ({{ ucfirst($t->jenis) }})
                                    </option>
                                @endforeach
                            </select>
                            @error('tabungan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jenis Transaksi <span class="text-danger">*</span></label>
                                    <select name="jenis" class="form-control @error('jenis') is-invalid @enderror">
                                        <option value="setor" {{ old('jenis') == 'setor' ? 'selected' : '' }}>Setor
                                        </option>
                                        <option value="tarik" {{ old('jenis') == 'tarik' ? 'selected' : '' }}>Tarik
                                        </option>
                                    </select>
                                    @error('jenis')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Metode Pembayaran <span class="text-danger">*</span></label>
                                    <select name="metode" class="form-control @error('metode') is-invalid @enderror">
                                        <option value="tunai" {{ old('metode') == 'tunai' ? 'selected' : '' }}>Tunai
                                        </option>
                                        <option value="transfer" {{ old('metode') == 'transfer' ? 'selected' : '' }}>
                                            Transfer</option>
                                        <option value="debit" {{ old('metode') == 'debit' ? 'selected' : '' }}>Debit
                                        </option>
                                        <option value="qris" {{ old('metode') == 'qris' ? 'selected' : '' }}>QRIS
                                        </option>
                                    </select>
                                    @error('metode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jumlah Setor (Rp) <span class="text-danger">*</span></label>
                                    <input type="number" name="jumlah_setor"
                                        class="form-control @error('jumlah_setor') is-invalid @enderror"
                                        value="{{ old('jumlah_setor') }}" min="1">
                                    @error('jumlah_setor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Setor <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_setor"
                                        class="form-control @error('tanggal_setor') is-invalid @enderror"
                                        value="{{ old('tanggal_setor', date('Y-m-d')) }}">
                                    @error('tanggal_setor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Bukti Setor</label>
                            <div class="custom-file">
                                <input type="file" name="bukti_setor" class="custom-file-input" id="bukti_setor"
                                    accept="image/*" onchange="previewImage(this,'prev-bukti')">
                                <label class="custom-file-label" for="bukti_setor">Pilih file...</label>
                            </div>
                            <img id="prev-bukti" src="#" class="img-thumbnail d-none mt-2" style="max-height:150px">
                        </div>
                        <div class="form-group">
                            <label>Catatan</label>
                            <textarea name="catatan" class="form-control" rows="2">{{ old('catatan') }}</textarea>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
                            <a href="{{ route('admin.setoran.index') }}" class="btn btn-secondary ml-2"><i
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
