@extends('layouts.app')
@section('title', 'Tambah Jamaah')
@section('page-title', 'Tambah Jamaah')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.jamaah.index') }}">Data Jamaah</a></div>
    <div class="breadcrumb-item active">Tambah</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Form Tambah Jamaah</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.jamaah.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <h6 class="text-primary mb-3"><i class="fas fa-user mr-1"></i> Data Pribadi</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_lengkap"
                                        class="form-control @error('nama_lengkap') is-invalid @enderror"
                                        value="{{ old('nama_lengkap') }}">
                                    @error('nama_lengkap')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Arab</label>
                                    <input type="text" name="nama_arab" class="form-control"
                                        value="{{ old('nama_arab') }}" placeholder="Nama sesuai passport internasional">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>NIK <span class="text-danger">*</span></label>
                                    <input type="text" name="nik"
                                        class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik') }}"
                                        maxlength="16">
                                    @error('nik')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select name="jenis_kelamin"
                                        class="form-control @error('jenis_kelamin') is-invalid @enderror">
                                        <option value="">-- Pilih --</option>
                                        <option value="laki-laki"
                                            {{ old('jenis_kelamin') == 'laki-laki' ? 'selected' : '' }}>
                                            Laki-laki</option>
                                        <option value="perempuan"
                                            {{ old('jenis_kelamin') == 'perempuan' ? 'selected' : '' }}>
                                            Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Golongan Darah</label>
                                    <select name="golongan_darah" class="form-control">
                                        <option value="">-- Pilih --</option>
                                        @foreach (['A', 'B', 'AB', 'O', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $gb)
                                            <option value="{{ $gb }}"
                                                {{ old('golongan_darah') == $gb ? 'selected' : '' }}>{{ $gb }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tempat Lahir <span class="text-danger">*</span></label>
                                    <input type="text" name="tempat_lahir"
                                        class="form-control @error('tempat_lahir') is-invalid @enderror"
                                        value="{{ old('tempat_lahir') }}">
                                    @error('tempat_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_lahir"
                                        class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                        value="{{ old('tanggal_lahir') }}">
                                    @error('tanggal_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Pekerjaan</label>
                                    <input type="text" name="pekerjaan" class="form-control"
                                        value="{{ old('pekerjaan') }}">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h6 class="text-primary mb-3"><i class="fas fa-passport mr-1"></i> Data Passport</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>No. Passport</label>
                                    <input type="text" name="no_passport"
                                        class="form-control @error('no_passport') is-invalid @enderror"
                                        value="{{ old('no_passport') }}">
                                    @error('no_passport')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Expired Passport</label>
                                    <input type="date" name="exp_passport" class="form-control"
                                        value="{{ old('exp_passport') }}">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h6 class="text-primary mb-3"><i class="fas fa-map-marker-alt mr-1"></i> Alamat & Kontak</h6>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Alamat <span class="text-danger">*</span></label>
                                    <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="2">{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Kota <span class="text-danger">*</span></label>
                                    <input type="text" name="kota"
                                        class="form-control @error('kota') is-invalid @enderror"
                                        value="{{ old('kota') }}">
                                    @error('kota')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Provinsi <span class="text-danger">*</span></label>
                                    <input type="text" name="provinsi"
                                        class="form-control @error('provinsi') is-invalid @enderror"
                                        value="{{ old('provinsi') }}">
                                    @error('provinsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>No. Telepon <span class="text-danger">*</span></label>
                                    <input type="text" name="no_telepon"
                                        class="form-control @error('no_telepon') is-invalid @enderror"
                                        value="{{ old('no_telepon') }}">
                                    @error('no_telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ old('email') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nama Mahram/Wali</label>
                                    <input type="text" name="nama_mahram" class="form-control"
                                        value="{{ old('nama_mahram') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Hubungan Mahram</label>
                                    <input type="text" name="hubungan_mahram" class="form-control"
                                        value="{{ old('hubungan_mahram') }}" placeholder="Suami / Ayah / Kakak">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h6 class="text-primary mb-3"><i class="fas fa-images mr-1"></i> Foto & Dokumen</h6>
                        <div class="row">
                            @foreach ([['foto', 'Foto Wajah'], ['foto_ktp', 'Foto KTP'], ['foto_passport', 'Foto Passport']] as [$field, $label])
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{ $label }}</label>
                                        <div class="custom-file">
                                            <input type="file" name="{{ $field }}" class="custom-file-input"
                                                id="{{ $field }}" accept="image/*"
                                                onchange="previewImage(this,'prev-{{ $field }}')">
                                            <label class="custom-file-label" for="{{ $field }}">Pilih
                                                file...</label>
                                        </div>
                                        <img id="prev-{{ $field }}" src="#"
                                            class="img-thumbnail d-none mt-2" style="max-height:100px">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i>
                                Simpan</button>
                            <a href="{{ route('admin.jamaah.index') }}" class="btn btn-secondary ml-2"><i
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
