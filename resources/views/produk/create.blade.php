@extends('layouts.app')
@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.produk.index') }}">Data Produk</a></div>
    <div class="breadcrumb-item active">Tambah Produk</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-plus-circle mr-1"></i> Tambah Produk</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </div>

                <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
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

                        <div class="row">
                            {{-- Kolom Kiri --}}
                            <div class="col-md-8">

                                <div class="section-title mb-3">
                                    <h6 class="text-primary font-weight-bold">
                                        <i class="fas fa-info-circle mr-1"></i> Informasi Produk
                                    </h6>
                                    <hr class="mt-1">
                                </div>

                                {{-- Nama Produk --}}
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Nama Produk <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="nama_produk"
                                            class="form-control @error('nama_produk') is-invalid @enderror"
                                            value="{{ old('nama_produk') }}" placeholder="Masukkan nama produk">
                                        @error('nama_produk')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Kategori --}}
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Kategori <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <select name="kategori"
                                            class="form-control @error('kategori') is-invalid @enderror">
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach ([
            'koper' => 'Koper',
            'tas' => 'Tas',
            'seragam' => 'Seragam',
            'buku_manasik' => 'Buku Manasik',
            'perlengkapan_sholat' => 'Perlengkapan Sholat',
            'souvenir' => 'Souvenir',
            'obat' => 'Obat',
            'lainnya' => 'Lainnya',
        ] as $value => $label)
                                                <option value="{{ $value }}"
                                                    {{ old('kategori') == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('kategori')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Supplier --}}
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Supplier</label>
                                    <div class="col-sm-9">
                                        <select name="supplier_id"
                                            class="form-control @error('supplier_id') is-invalid @enderror">
                                            <option value="">-- Tanpa Supplier --</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}"
                                                    {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                                    {{ $supplier->nama_supplier }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('supplier_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Satuan --}}
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Satuan <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="satuan"
                                            class="form-control @error('satuan') is-invalid @enderror"
                                            value="{{ old('satuan') }}" placeholder="pcs / lusin / kg / dll">
                                        @error('satuan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Deskripsi --}}
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Deskripsi</label>
                                    <div class="col-sm-9">
                                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3"
                                            placeholder="Keterangan tambahan produk (opsional)">{{ old('deskripsi') }}</textarea>
                                        @error('deskripsi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="section-title mb-3 mt-4">
                                    <h6 class="text-primary font-weight-bold">
                                        <i class="fas fa-boxes mr-1"></i> Stok & Harga
                                    </h6>
                                    <hr class="mt-1">
                                </div>

                                {{-- Stok & Stok Minimum --}}
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Stok Awal <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-4">
                                        <input type="number" name="stok"
                                            class="form-control @error('stok') is-invalid @enderror"
                                            value="{{ old('stok', 0) }}" min="0">
                                        @error('stok')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <label class="col-sm-2 col-form-label">Stok Min. <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-3">
                                        <input type="number" name="stok_minimum"
                                            class="form-control @error('stok_minimum') is-invalid @enderror"
                                            value="{{ old('stok_minimum', 0) }}" min="0">
                                        @error('stok_minimum')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Harga Beli --}}
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Harga Beli <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input type="number" name="harga_beli"
                                                class="form-control @error('harga_beli') is-invalid @enderror"
                                                value="{{ old('harga_beli', 0) }}" min="0">
                                            @error('harga_beli')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Harga Jual --}}
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Harga Jual <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input type="number" name="harga_jual"
                                                class="form-control @error('harga_jual') is-invalid @enderror"
                                                value="{{ old('harga_jual', 0) }}" min="0">
                                            @error('harga_jual')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Status --}}
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Status <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                                            <option value="aktif"
                                                {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                            <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>
                                                Nonaktif</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            {{-- Kolom Kanan - Foto --}}
                            <div class="col-md-4">
                                <div class="section-title mb-3">
                                    <h6 class="text-primary font-weight-bold">
                                        <i class="fas fa-image mr-1"></i> Foto Produk
                                    </h6>
                                    <hr class="mt-1">
                                </div>

                                <div class="form-group">
                                    <div class="text-center mb-2">
                                        <img id="preview-foto" src="{{ asset('img/no-image.png') }}" alt="Preview Foto"
                                            class="img-fluid rounded border"
                                            style="max-height: 200px; object-fit: cover; width: 100%;">
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" name="foto" id="foto"
                                            class="custom-file-input @error('foto') is-invalid @enderror"
                                            accept="image/*" onchange="previewImage(this, 'preview-foto')">
                                        <label class="custom-file-label" for="foto">Pilih foto...</label>
                                    </div>
                                    @error('foto')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted d-block mt-1">
                                        <i class="fas fa-info-circle"></i> Format: JPG, PNG. Maks. 2MB.
                                    </small>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary mr-2">
                            <i class="fas fa-times mr-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Simpan Produk
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function previewImage(input, targetId) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => document.getElementById(targetId).src = e.target.result;
                reader.readAsDataURL(file);

                // Update label custom-file
                input.nextElementSibling.textContent = file.name;
            }
        }
    </script>
@endpush
