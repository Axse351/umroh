@extends('layouts.app')
@section('title', 'Tambah Hotel')
@section('page-title', 'Tambah Hotel')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.hotel.index') }}">Data Hotel</a></div>
    <div class="breadcrumb-item active">Tambah</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Form Tambah Hotel</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.hotel.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Nama Hotel <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_hotel"
                                        class="form-control @error('nama_hotel') is-invalid @enderror"
                                        value="{{ old('nama_hotel') }}" placeholder="Nama hotel">
                                    @error('nama_hotel')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Lokasi <span class="text-danger">*</span></label>
                                    <select name="lokasi" class="form-control @error('lokasi') is-invalid @enderror">
                                        <option value="">-- Pilih --</option>
                                        <option value="mekkah" {{ old('lokasi') == 'mekkah' ? 'selected' : '' }}>Mekkah</option>
                                        <option value="madinah" {{ old('lokasi') == 'madinah' ? 'selected' : '' }}>Madinah
                                        </option>
                                        <option value="jeddah" {{ old('lokasi') == 'jeddah' ? 'selected' : '' }}>Jeddah</option>
                                    </select>
                                    @error('lokasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Bintang <span class="text-danger">*</span></label>
                                    <select name="bintang" class="form-control">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}" {{ old('bintang', 3) == $i ? 'selected' : '' }}>
                                                {{ $i }} Bintang</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Jarak ke Masjid (meter)</label>
                                    <input type="number" name="jarak_ke_masjid_meter" class="form-control"
                                        value="{{ old('jarak_ke_masjid_meter') }}" placeholder="Contoh: 500">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>No. Telepon</label>
                                    <input type="text" name="no_telepon" class="form-control"
                                        value="{{ old('no_telepon') }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea name="alamat" class="form-control" rows="2" placeholder="Alamat hotel">{{ old('alamat') }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Fasilitas</label>
                                    <textarea name="fasilitas" class="form-control" rows="3" placeholder="Contoh: Kolam renang, Gym, Restoran, ...">{{ old('fasilitas') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
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
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
                            <a href="{{ route('hotel.index') }}" class="btn btn-secondary ml-2"><i
                                    class="fas fa-arrow-left mr-1"></i> Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
