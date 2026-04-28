@extends('layouts.app')
@section('title', 'Edit Hotel')
@section('page-title', 'Edit Hotel')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.hotel.index') }}">Data Hotel</a></div>
    <div class="breadcrumb-item active">Edit</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Form Edit Hotel</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.hotel.update', $hotel) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Nama Hotel <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_hotel" class="form-control"
                                        value="{{ old('nama_hotel', $hotel->nama_hotel) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Lokasi <span class="text-danger">*</span></label>
                                    <select name="lokasi" class="form-control">
                                        <option value="mekkah"
                                            {{ old('lokasi', $hotel->lokasi) == 'mekkah' ? 'selected' : '' }}>
                                            Mekkah</option>
                                        <option value="madinah"
                                            {{ old('lokasi', $hotel->lokasi) == 'madinah' ? 'selected' : '' }}>Madinah
                                        </option>
                                        <option value="jeddah"
                                            {{ old('lokasi', $hotel->lokasi) == 'jeddah' ? 'selected' : '' }}>
                                            Jeddah</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Bintang</label>
                                    <select name="bintang" class="form-control">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}"
                                                {{ old('bintang', $hotel->bintang) == $i ? 'selected' : '' }}>
                                                {{ $i }}
                                                Bintang</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Jarak ke Masjid (meter)</label>
                                    <input type="number" name="jarak_ke_masjid_meter" class="form-control"
                                        value="{{ old('jarak_ke_masjid_meter', $hotel->jarak_ke_masjid_meter) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>No. Telepon</label>
                                    <input type="text" name="no_telepon" class="form-control"
                                        value="{{ old('no_telepon', $hotel->no_telepon) }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $hotel->alamat) }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Fasilitas</label>
                                    <textarea name="fasilitas" class="form-control" rows="3">{{ old('fasilitas', $hotel->fasilitas) }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="aktif"
                                            {{ old('status', $hotel->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="nonaktif"
                                            {{ old('status', $hotel->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <button type="submit" class="btn btn-warning"><i class="fas fa-save mr-1"></i> Update</button>
                            <a href="{{ route('hotel.index') }}" class="btn btn-secondary ml-2"><i
                                    class="fas fa-arrow-left mr-1"></i> Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
