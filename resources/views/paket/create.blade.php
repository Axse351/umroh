@extends('layouts.app')
@section('title', 'Tambah Paket')
@section('page-title', 'Tambah Paket')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.paket.index') }}">Data Paket</a></div>
    <div class="breadcrumb-item active">Tambah</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Form Tambah Paket</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.paket.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Paket <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_paket"
                                        class="form-control @error('nama_paket') is-invalid @enderror"
                                        value="{{ old('nama_paket') }}" placeholder="Nama paket perjalanan">
                                    @error('nama_paket')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Jenis <span class="text-danger">*</span></label>
                                    <select name="jenis" class="form-control @error('jenis') is-invalid @enderror">
                                        <option value="">-- Pilih --</option>
                                        <option value="umroh" {{ old('jenis') == 'umroh' ? 'selected' : '' }}>Umroh
                                        </option>
                                        <option value="haji" {{ old('jenis') == 'haji' ? 'selected' : '' }}>Haji Regular
                                        </option>
                                        <option value="haji_plus" {{ old('jenis') == 'haji_plus' ? 'selected' : '' }}>Haji
                                            Plus
                                        </option>
                                        <option value="haji_furoda" {{ old('jenis') == 'haji_furoda' ? 'selected' : '' }}>
                                            Haji
                                            Furoda</option>
                                    </select>
                                    @error('jenis')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Kategori <span class="text-danger">*</span></label>
                                    <select name="kategori" class="form-control @error('kategori') is-invalid @enderror">
                                        <option value="regular" {{ old('kategori') == 'regular' ? 'selected' : '' }}>Regular
                                        </option>
                                        <option value="plus" {{ old('kategori') == 'plus' ? 'selected' : '' }}>Plus
                                        </option>
                                        <option value="vip" {{ old('kategori') == 'vip' ? 'selected' : '' }}>VIP
                                        </option>
                                        <option value="furoda" {{ old('kategori') == 'furoda' ? 'selected' : '' }}>Furoda
                                        </option>
                                    </select>
                                    @error('kategori')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Durasi (hari) <span class="text-danger">*</span></label>
                                    <input type="number" name="durasi_hari"
                                        class="form-control @error('durasi_hari') is-invalid @enderror"
                                        value="{{ old('durasi_hari') }}" min="1" placeholder="9">
                                    @error('durasi_hari')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Kapasitas <span class="text-danger">*</span></label>
                                    <input type="number" name="kapasitas"
                                        class="form-control @error('kapasitas') is-invalid @enderror"
                                        value="{{ old('kapasitas') }}" min="1" placeholder="40">
                                    @error('kapasitas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Maskapai <span class="text-danger">*</span></label>
                                    <select name="maskapai_id"
                                        class="form-control @error('maskapai_id') is-invalid @enderror">
                                        <option value="">-- Pilih Maskapai --</option>
                                        @foreach ($maskapais as $m)
                                            <option value="{{ $m->id }}"
                                                {{ old('maskapai_id') == $m->id ? 'selected' : '' }}>
                                                {{ $m->nama_maskapai }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('maskapai_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Hotel Mekkah <span class="text-danger">*</span></label>
                                    <select name="hotel_mekkah_id"
                                        class="form-control @error('hotel_mekkah_id') is-invalid @enderror">
                                        <option value="">-- Pilih Hotel --</option>
                                        @foreach ($hotels->where('lokasi', 'mekkah') as $h)
                                            <option value="{{ $h->id }}"
                                                {{ old('hotel_mekkah_id') == $h->id ? 'selected' : '' }}>
                                                {{ $h->nama_hotel }}
                                                ({{ $h->bintang }}★)
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('hotel_mekkah_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Hotel Madinah <span class="text-danger">*</span></label>
                                    <select name="hotel_madinah_id"
                                        class="form-control @error('hotel_madinah_id') is-invalid @enderror">
                                        <option value="">-- Pilih Hotel --</option>
                                        @foreach ($hotels->where('lokasi', 'madinah') as $h)
                                            <option value="{{ $h->id }}"
                                                {{ old('hotel_madinah_id') == $h->id ? 'selected' : '' }}>
                                                {{ $h->nama_hotel }}
                                                ({{ $h->bintang }}★)
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('hotel_madinah_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h6 class="text-muted mb-3">Harga Per Kamar</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Harga Double <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                        <input type="number" name="harga_double"
                                            class="form-control @error('harga_double') is-invalid @enderror"
                                            value="{{ old('harga_double') }}" placeholder="0">
                                    </div>
                                    @error('harga_double')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Harga Triple <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                        <input type="number" name="harga_triple"
                                            class="form-control @error('harga_triple') is-invalid @enderror"
                                            value="{{ old('harga_triple') }}" placeholder="0">
                                    </div>
                                    @error('harga_triple')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Harga Quad <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                        <input type="number" name="harga_quad"
                                            class="form-control @error('harga_quad') is-invalid @enderror"
                                            value="{{ old('harga_quad') }}" placeholder="0">
                                    </div>
                                    @error('harga_quad')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Include (Fasilitas Termasuk)</label>
                                    <textarea name="include" class="form-control" rows="4"
                                        placeholder="- Tiket pesawat PP&#10;- Visa Umroh&#10;- Hotel bintang 5&#10;- Makan 3x sehari">{{ old('include') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Exclude (Tidak Termasuk)</label>
                                    <textarea name="exclude" class="form-control" rows="4"
                                        placeholder="- Airport tax&#10;- Pengeluaran pribadi&#10;- Tips guide">{{ old('exclude') }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Itinerary</label>
                                    <textarea name="itinerary" class="form-control" rows="5" placeholder="Hari 1: Berangkat dari Jakarta...">{{ old('itinerary') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="aktif">Aktif</option>
                                        <option value="nonaktif">Nonaktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i>
                                Simpan</button>
                            <a href="{{ route('admin.paket.index') }}" class="btn btn-secondary ml-2"><i
                                    class="fas fa-arrow-left mr-1"></i> Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
