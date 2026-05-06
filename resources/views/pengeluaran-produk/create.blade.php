@extends('layouts.app')
@section('title', 'Catat Pengeluaran Produk')
@section('page-title', 'Catat Pengeluaran Produk')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.pengeluaran-produk.index') }}">Data Pengeluaran Produk</a></div>
    <div class="breadcrumb-item active">Catat Baru</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-plus-circle mr-1"></i> Catat Pengeluaran Produk</h4>
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

                    <form action="{{ route('admin.pengeluaran-produk.store') }}" method="POST">
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
                                        (Stok: {{ $produk->stok }} {{ $produk->satuan ?? '' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('produk_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small id="infoStok" class="form-text text-muted"></small>
                        </div>

                        {{-- Keperluan --}}
                        <div class="form-group">
                            <label for="keperluan">Keperluan <span class="text-danger">*</span></label>
                            <select name="keperluan" id="keperluan"
                                class="form-control @error('keperluan') is-invalid @enderror" required>
                                <option value="">-- Pilih Keperluan --</option>
                                <option value="distribusi_jamaah"
                                    {{ old('keperluan') == 'distribusi_jamaah' ? 'selected' : '' }}>Distribusi Jamaah
                                </option>
                                <option value="internal" {{ old('keperluan') == 'internal' ? 'selected' : '' }}>
                                    Internal</option>
                                <option value="rusak" {{ old('keperluan') == 'rusak' ? 'selected' : '' }}>
                                    Rusak</option>
                                <option value="lainnya" {{ old('keperluan') == 'lainnya' ? 'selected' : '' }}>
                                    Lainnya</option>
                            </select>
                            @error('keperluan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Pendaftaran (kondisional) --}}
                        <div class="form-group" id="wrapPendaftaran" style="display: none;">
                            <label for="pendaftaran_id">Pendaftaran / Jamaah</label>
                            <select name="pendaftaran_id" id="pendaftaran_id"
                                class="form-control select2 @error('pendaftaran_id') is-invalid @enderror">
                                <option value="">-- Pilih Pendaftaran --</option>
                                @foreach ($pendaftarans as $daftar)
                                    <option value="{{ $daftar->id }}"
                                        {{ old('pendaftaran_id', $pendaftaran_id) == $daftar->id ? 'selected' : '' }}>
                                        {{ $daftar->jamaah->nama_lengkap ?? '-' }} — {{ $daftar->no_pendaftaran }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pendaftaran_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            {{-- Qty --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="qty">Jumlah (Qty) <span class="text-danger">*</span></label>
                                    <input type="number" name="qty" id="qty"
                                        class="form-control @error('qty') is-invalid @enderror" value="{{ old('qty', 1) }}"
                                        min="1" required>
                                    @error('qty')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- Tanggal Keluar --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_keluar">Tanggal Keluar <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_keluar" id="tanggal_keluar"
                                        class="form-control @error('tanggal_keluar') is-invalid @enderror"
                                        value="{{ old('tanggal_keluar', date('Y-m-d')) }}" required>
                                    @error('tanggal_keluar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Keterangan --}}
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" rows="3"
                                class="form-control @error('keterangan') is-invalid @enderror" placeholder="Keterangan tambahan (opsional)">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i> Simpan
                            </button>
                            <a href="{{ route('admin.pengeluaran-produk.index') }}" class="btn btn-secondary ml-2">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Info Card --}}
        <div class="col-12 col-md-4">
            <div class="card bg-light border-0">
                <div class="card-body">
                    <h6 class="font-weight-bold"><i class="fas fa-info-circle mr-1 text-primary"></i> Informasi</h6>
                    <ul class="mb-0 pl-3 small text-muted">
                        <li>Hanya produk dengan status <strong>aktif</strong> dan <strong>stok > 0</strong> yang dapat
                            dipilih.</li>
                        <li>Kolom <strong>Pendaftaran / Jamaah</strong> hanya muncul jika keperluan adalah <em>Distribusi
                                Jamaah</em>.</li>
                        <li>Stok produk akan otomatis <strong>berkurang</strong> sesuai qty yang diinput.</li>
                        <li>Nomor pengeluaran akan digenerate otomatis oleh sistem.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Tampilkan info stok saat produk dipilih
        document.getElementById('produk_id').addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            const stok = selected.dataset.stok;
            const infoStok = document.getElementById('infoStok');
            if (stok !== undefined && this.value) {
                infoStok.textContent = 'Stok tersedia: ' + stok;
                infoStok.className = parseInt(stok) > 0 ? 'form-text text-success' : 'form-text text-danger';
            } else {
                infoStok.textContent = '';
            }
        });

        // Tampilkan / sembunyikan field pendaftaran
        document.getElementById('keperluan').addEventListener('change', function() {
            const wrap = document.getElementById('wrapPendaftaran');
            wrap.style.display = this.value === 'distribusi_jamaah' ? 'block' : 'none';
            document.getElementById('pendaftaran_id').required = this.value === 'distribusi_jamaah';
        });

        // Trigger saat halaman load jika ada old value
        (function() {
            const keperluan = document.getElementById('keperluan');
            const event = new Event('change');
            keperluan.dispatchEvent(event);
        })();
    </script>
@endpush
