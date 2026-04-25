@extends('layouts.app')
@section('title', 'Tambah Pembayaran')
@section('page-title', 'Tambah Pembayaran')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.pembayaran.index') }}">Data Pembayaran</a></div>
    <div class="breadcrumb-item active">Tambah</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Form Tambah Pembayaran</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pembayaran.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Pendaftaran Jamaah <span class="text-danger">*</span></label>
                            <select name="pendaftaran_id" class="form-control @error('pendaftaran_id') is-invalid @enderror"
                                id="sel-pdf">
                                <option value="">-- Pilih Pendaftaran --</option>
                                @foreach ($pendaftarans as $pd)
                                    <option value="{{ $pd->id }}" data-sisa="{{ $pd->sisa_tagihan }}"
                                        {{ old('pendaftaran_id', $pendaftaran_id) == $pd->id ? 'selected' : '' }}>
                                        {{ $pd->jamaah->nama_lengkap }} | {{ $pd->no_pendaftaran }} | Sisa: Rp
                                        {{ number_format($pd->sisa_tagihan, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pendaftaran_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="alert alert-info d-none" id="info-sisa">
                            Sisa tagihan: <strong id="txt-sisa">Rp 0</strong>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jumlah Bayar <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                        <input type="number" name="jumlah_bayar"
                                            class="form-control @error('jumlah_bayar') is-invalid @enderror"
                                            value="{{ old('jumlah_bayar') }}" min="1">
                                    </div>
                                    @error('jumlah_bayar')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Bayar <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_bayar"
                                        class="form-control @error('tanggal_bayar') is-invalid @enderror"
                                        value="{{ old('tanggal_bayar', now()->format('Y-m-d')) }}">
                                    @error('tanggal_bayar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jenis Pembayaran <span class="text-danger">*</span></label>
                                    <select name="jenis" class="form-control">
                                        <option value="dp" {{ old('jenis') == 'dp' ? 'selected' : '' }}>DP / Uang
                                            Muka</option>
                                        <option value="cicilan"
                                            {{ old('jenis', 'cicilan') == 'cicilan' ? 'selected' : '' }}>
                                            Cicilan</option>
                                        <option value="pelunasan" {{ old('jenis') == 'pelunasan' ? 'selected' : '' }}>
                                            Pelunasan
                                        </option>
                                        <option value="lainnya" {{ old('jenis') == 'lainnya' ? 'selected' : '' }}>Lainnya
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Metode Bayar <span class="text-danger">*</span></label>
                                    <select name="metode_bayar" class="form-control" id="sel-metode">
                                        @foreach (['tunai', 'transfer', 'debit', 'kredit', 'qris'] as $m)
                                            <option value="{{ $m }}"
                                                {{ old('metode_bayar', $m == 'transfer' ? 'transfer' : '') == $m ? 'selected' : '' }}>
                                                {{ ucfirst($m) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 field-transfer">
                                <div class="form-group">
                                    <label>Bank Tujuan</label>
                                    <input type="text" name="bank_tujuan" class="form-control"
                                        value="{{ old('bank_tujuan') }}" placeholder="BCA / BRI / BNI / Mandiri">
                                </div>
                            </div>
                            <div class="col-md-6 field-transfer">
                                <div class="form-group">
                                    <label>Nama Pengirim</label>
                                    <input type="text" name="nama_pengirim" class="form-control"
                                        value="{{ old('nama_pengirim') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Bukti Bayar</label>
                                    <div class="custom-file">
                                        <input type="file" name="bukti_bayar" class="custom-file-input" id="bukti"
                                            accept="image/*" onchange="previewImage(this,'prev-bukti')">
                                        <label class="custom-file-label" for="bukti">Pilih file...</label>
                                    </div>
                                    <img id="prev-bukti" src="#" class="img-thumbnail d-none mt-2"
                                        style="max-height:120px">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Catatan</label>
                                    <textarea name="catatan" class="form-control" rows="2">{{ old('catatan') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
                            <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-secondary ml-2"><i
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
        function previewImage(input, id) {
            if (input.files && input.files[0]) {
                const r = new FileReader();
                r.onload = e => {
                    const img = document.getElementById(id);
                    img.src = e.target.result;
                    img.classList.remove('d-none');
                };
                r.readAsDataURL(input.files[0]);
                input.nextElementSibling.textContent = input.files[0].name;
            }
        }
        document.getElementById('sel-pdf').addEventListener('change', function() {
            const opt = this.options[this.selectedIndex];
            if (opt.value) {
                const sisa = parseInt(opt.dataset.sisa) || 0;
                document.getElementById('txt-sisa').textContent = 'Rp ' + sisa.toLocaleString('id-ID');
                document.getElementById('info-sisa').classList.remove('d-none');
            }
        });
    </script>
@endpush
