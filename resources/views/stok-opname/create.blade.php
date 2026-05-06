@extends('layouts.app')
@section('title', 'Catat Stok Opname')
@section('page-title', 'Catat Stok Opname')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('stok-opname.index') }}">Data Stok Opname</a></div>
    <div class="breadcrumb-item active">Catat Baru</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12 col-md-7">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-clipboard-list mr-1"></i> Catat Stok Opname</h4>
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

                    <form action="{{ route('stok-opname.store') }}" method="POST">
                        @csrf

                        {{-- Produk --}}
                        <div class="form-group">
                            <label for="produk_id">Produk <span class="text-danger">*</span></label>
                            <select name="produk_id" id="produk_id"
                                class="form-control select2 @error('produk_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Produk --</option>
                                @foreach ($produks as $produk)
                                    <option value="{{ $produk->id }}" data-stok="{{ $produk->stok }}"
                                        {{ old('produk_id') == $produk->id ? 'selected' : '' }}>
                                        {{ $produk->nama_produk }}
                                        (Stok Sistem: {{ $produk->stok }} {{ $produk->satuan ?? '' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('produk_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Info stok sistem --}}
                        <div id="infoStokSistem" class="alert alert-info py-2 px-3 small" style="display: none;">
                            <i class="fas fa-database mr-1"></i>
                            Stok sistem saat ini: <strong id="nilaiStokSistem">-</strong>
                        </div>

                        <div class="row">
                            {{-- Stok Fisik --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="stok_fisik">Stok Fisik (Hasil Hitung) <span
                                            class="text-danger">*</span></label>
                                    <input type="number" name="stok_fisik" id="stok_fisik"
                                        class="form-control @error('stok_fisik') is-invalid @enderror"
                                        value="{{ old('stok_fisik', 0) }}" min="0" required>
                                    @error('stok_fisik')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- Tanggal Opname --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_opname">Tanggal Opname <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_opname" id="tanggal_opname"
                                        class="form-control @error('tanggal_opname') is-invalid @enderror"
                                        value="{{ old('tanggal_opname', date('Y-m-d')) }}" required>
                                    @error('tanggal_opname')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Kalkulasi selisih realtime --}}
                        <div id="infoSelisih" class="alert py-2 px-3 small" style="display: none;">
                            <i class="fas fa-calculator mr-1"></i>
                            Estimasi selisih: <strong id="nilaiSelisih">-</strong>
                        </div>

                        {{-- Keterangan --}}
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" rows="3"
                                class="form-control @error('keterangan') is-invalid @enderror"
                                placeholder="Misalnya: opname bulanan, barang hilang, dll.">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i> Simpan & Perbarui Stok
                            </button>
                            <a href="{{ route('stok-opname.index') }}" class="btn btn-secondary ml-2">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Info Card --}}
        <div class="col-12 col-md-5">
            <div class="card bg-light border-0">
                <div class="card-body">
                    <h6 class="font-weight-bold"><i class="fas fa-info-circle mr-1 text-primary"></i> Informasi</h6>
                    <ul class="mb-0 pl-3 small text-muted">
                        <li>Pilih produk untuk melihat stok sistem saat ini.</li>
                        <li>Masukkan <strong>stok fisik</strong> hasil hitungan nyata di gudang.</li>
                        <li>Sistem akan menghitung <strong>selisih</strong> = Stok Fisik − Stok Sistem.</li>
                        <li class="text-danger font-weight-bold">Setelah disimpan, stok produk akan <u>langsung
                                diperbarui</u> mengikuti stok fisik.</li>
                        <li>Nomor opname akan digenerate otomatis oleh sistem.</li>
                    </ul>
                </div>
            </div>

            {{-- Preview card --}}
            <div class="card mt-3" id="previewCard" style="display: none;">
                <div class="card-header py-2">
                    <h6 class="mb-0"><i class="fas fa-chart-bar mr-1"></i> Preview Perubahan Stok</h6>
                </div>
                <div class="card-body py-3">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="text-muted small mb-1">Stok Sistem</div>
                            <div class="h4 font-weight-bold" id="previewSistem">-</div>
                        </div>
                        <div class="col-4">
                            <div class="text-muted small mb-1">Stok Fisik</div>
                            <div class="h4 font-weight-bold text-primary" id="previewFisik">-</div>
                        </div>
                        <div class="col-4">
                            <div class="text-muted small mb-1">Selisih</div>
                            <div class="h4 font-weight-bold" id="previewSelisih">-</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let stokSistem = null;

        document.getElementById('produk_id').addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            stokSistem = this.value ? parseInt(selected.dataset.stok) : null;

            const infoBox = document.getElementById('infoStokSistem');
            if (stokSistem !== null) {
                document.getElementById('nilaiStokSistem').textContent = stokSistem;
                infoBox.style.display = 'block';
            } else {
                infoBox.style.display = 'none';
            }

            hitungSelisih();
        });

        document.getElementById('stok_fisik').addEventListener('input', hitungSelisih);

        function hitungSelisih() {
            if (stokSistem === null) return;

            const fisik = parseInt(document.getElementById('stok_fisik').value) || 0;
            const selisih = fisik - stokSistem;

            const infoSelisih = document.getElementById('infoSelisih');
            const nilaiSelisih = document.getElementById('nilaiSelisih');
            const previewCard = document.getElementById('previewCard');

            infoSelisih.style.display = 'block';
            previewCard.style.display = 'block';

            if (selisih > 0) {
                infoSelisih.className = 'alert alert-success py-2 px-3 small';
                nilaiSelisih.textContent = '+' + selisih + ' (lebih)';
                document.getElementById('previewSelisih').className = 'h4 font-weight-bold text-success';
                document.getElementById('previewSelisih').textContent = '+' + selisih;
            } else if (selisih < 0) {
                infoSelisih.className = 'alert alert-danger py-2 px-3 small';
                nilaiSelisih.textContent = selisih + ' (kurang)';
                document.getElementById('previewSelisih').className = 'h4 font-weight-bold text-danger';
                document.getElementById('previewSelisih').textContent = selisih;
            } else {
                infoSelisih.className = 'alert alert-secondary py-2 px-3 small';
                nilaiSelisih.textContent = '0 (sesuai)';
                document.getElementById('previewSelisih').className = 'h4 font-weight-bold text-secondary';
                document.getElementById('previewSelisih').textContent = '0';
            }

            document.getElementById('previewSistem').textContent = stokSistem;
            document.getElementById('previewFisik').textContent = fisik;
        }
    </script>
@endpush
