@extends('layouts.app')
@section('title', 'Edit Paket')
@section('page-title', 'Edit Paket')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.paket.index') }}">Data Paket</a></div>
    <div class="breadcrumb-item active">Edit</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Form Edit Paket &mdash; <small class="text-muted">{{ $paket->kode_paket }}</small></h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.paket.update', $paket) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Paket <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_paket" class="form-control"
                                        value="{{ old('nama_paket', $paket->nama_paket) }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Jenis</label>
                                    <select name="jenis" class="form-control">
                                        <option value="umroh"
                                            {{ old('jenis', $paket->jenis) == 'umroh' ? 'selected' : '' }}>Umroh</option>
                                        <option value="haji"
                                            {{ old('jenis', $paket->jenis) == 'haji' ? 'selected' : '' }}>Haji Regular
                                        </option>
                                        <option value="haji_plus"
                                            {{ old('jenis', $paket->jenis) == 'haji_plus' ? 'selected' : '' }}>Haji Plus
                                        </option>
                                        <option value="haji_furoda"
                                            {{ old('jenis', $paket->jenis) == 'haji_furoda' ? 'selected' : '' }}>Haji Furoda
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select name="kategori" class="form-control">
                                        <option value="regular"
                                            {{ old('kategori', $paket->kategori) == 'regular' ? 'selected' : '' }}>Regular
                                        </option>
                                        <option value="plus"
                                            {{ old('kategori', $paket->kategori) == 'plus' ? 'selected' : '' }}>Plus
                                        </option>
                                        <option value="vip"
                                            {{ old('kategori', $paket->kategori) == 'vip' ? 'selected' : '' }}>VIP</option>
                                        <option value="furoda"
                                            {{ old('kategori', $paket->kategori) == 'furoda' ? 'selected' : '' }}>Furoda
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Durasi (hari)</label>
                                    <input type="number" name="durasi_hari" class="form-control"
                                        value="{{ old('durasi_hari', $paket->durasi_hari) }}" min="1">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Kapasitas</label>
                                    <input type="number" name="kapasitas" class="form-control"
                                        value="{{ old('kapasitas', $paket->kapasitas) }}" min="1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Maskapai</label>
                                    <select name="maskapai_id" class="form-control">
                                        @foreach ($maskapais as $m)
                                            <option value="{{ $m->id }}"
                                                {{ old('maskapai_id', $paket->maskapai_id) == $m->id ? 'selected' : '' }}>
                                                {{ $m->nama_maskapai }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Hotel Mekkah</label>
                                    <select name="hotel_mekkah_id" class="form-control">
                                        @foreach ($hotels->where('lokasi', 'mekkah') as $h)
                                            <option value="{{ $h->id }}"
                                                {{ old('hotel_mekkah_id', $paket->hotel_mekkah_id) == $h->id ? 'selected' : '' }}>
                                                {{ $h->nama_hotel }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Hotel Madinah</label>
                                    <select name="hotel_madinah_id" class="form-control">
                                        @foreach ($hotels->where('lokasi', 'madinah') as $h)
                                            <option value="{{ $h->id }}"
                                                {{ old('hotel_madinah_id', $paket->hotel_madinah_id) == $h->id ? 'selected' : '' }}>
                                                {{ $h->nama_hotel }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h6 class="text-muted">Harga Per Kamar</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Harga Double</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                        <input type="number" name="harga_double" class="form-control"
                                            value="{{ old('harga_double', $paket->harga_double) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Harga Triple</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                        <input type="number" name="harga_triple" class="form-control"
                                            value="{{ old('harga_triple', $paket->harga_triple) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Harga Quad</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                        <input type="number" name="harga_quad" class="form-control"
                                            value="{{ old('harga_quad', $paket->harga_quad) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Include</label>
                                    <textarea name="include" class="form-control" rows="4">{{ old('include', $paket->include) }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Exclude</label>
                                    <textarea name="exclude" class="form-control" rows="4">{{ old('exclude', $paket->exclude) }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Itinerary</label>
                                    <textarea name="itinerary" class="form-control" rows="5">{{ old('itinerary', $paket->itinerary) }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="aktif"
                                            {{ old('status', $paket->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="nonaktif"
                                            {{ old('status', $paket->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <button type="submit" class="btn btn-warning"><i class="fas fa-save mr-1"></i>
                                Update</button>
                            <a href="{{ route('admin.paket.index') }}" class="btn btn-secondary ml-2"><i
                                    class="fas fa-arrow-left mr-1"></i> Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
