@extends('layouts.app')
@section('title', 'Edit Jamaah')
@section('page-title', 'Edit Jamaah')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.jamaah.index') }}">Data Jamaah</a></div>
    <div class="breadcrumb-item active">Edit</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Form Edit Jamaah &mdash; <small class="text-muted">{{ $jamaah->kode_jamaah }}</small></h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.jamaah.update', $jamaah) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <h6 class="text-primary mb-3"><i class="fas fa-user mr-1"></i> Data Pribadi</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_lengkap"
                                        class="form-control @error('nama_lengkap') is-invalid @enderror"
                                        value="{{ old('nama_lengkap', $jamaah->nama_lengkap) }}">
                                    @error('nama_lengkap')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Arab</label>
                                    <input type="text" name="nama_arab" class="form-control"
                                        value="{{ old('nama_arab', $jamaah->nama_arab) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>NIK <span class="text-danger">*</span></label>
                                    <input type="text" name="nik"
                                        class="form-control @error('nik') is-invalid @enderror"
                                        value="{{ old('nik', $jamaah->nik) }}" maxlength="16">
                                    @error('nik')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-control">
                                        <option value="laki-laki"
                                            {{ old('jenis_kelamin', $jamaah->jenis_kelamin) == 'laki-laki' ? 'selected' : '' }}>
                                            Laki-laki</option>
                                        <option value="perempuan"
                                            {{ old('jenis_kelamin', $jamaah->jenis_kelamin) == 'perempuan' ? 'selected' : '' }}>
                                            Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Golongan Darah</label>
                                    <select name="golongan_darah" class="form-control">
                                        <option value="">-- Pilih --</option>
                                        @foreach (['A', 'B', 'AB', 'O', 'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $gb)
                                            <option value="{{ $gb }}"
                                                {{ old('golongan_darah', $jamaah->golongan_darah) == $gb ? 'selected' : '' }}>
                                                {{ $gb }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control"
                                        value="{{ old('tempat_lahir', $jamaah->tempat_lahir) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" class="form-control"
                                        value="{{ old('tanggal_lahir', $jamaah->tanggal_lahir?->format('Y-m-d')) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Pekerjaan</label>
                                    <input type="text" name="pekerjaan" class="form-control"
                                        value="{{ old('pekerjaan', $jamaah->pekerjaan) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>No. Passport</label>
                                    <input type="text" name="no_passport" class="form-control"
                                        value="{{ old('no_passport', $jamaah->no_passport) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Expired Passport</label>
                                    <input type="date" name="exp_passport" class="form-control"
                                        value="{{ old('exp_passport', $jamaah->exp_passport?->format('Y-m-d')) }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $jamaah->alamat) }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Kota</label>
                                    <input type="text" name="kota" class="form-control"
                                        value="{{ old('kota', $jamaah->kota) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Provinsi</label>
                                    <input type="text" name="provinsi" class="form-control"
                                        value="{{ old('provinsi', $jamaah->provinsi) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>No. Telepon</label>
                                    <input type="text" name="no_telepon" class="form-control"
                                        value="{{ old('no_telepon', $jamaah->no_telepon) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ old('email', $jamaah->email) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nama Mahram</label>
                                    <input type="text" name="nama_mahram" class="form-control"
                                        value="{{ old('nama_mahram', $jamaah->nama_mahram) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Hubungan Mahram</label>
                                    <input type="text" name="hubungan_mahram" class="form-control"
                                        value="{{ old('hubungan_mahram', $jamaah->hubungan_mahram) }}">
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
                                        @if ($jamaah->$field)
                                            <div class="mb-1">
                                                <img src="{{ asset('storage/' . $jamaah->$field) }}"
                                                    class="img-thumbnail" style="max-height:80px">
                                                <small class="d-block text-muted">Saat ini</small>
                                            </div>
                                        @endif
                                        <div class="custom-file">
                                            <input type="file" name="{{ $field }}" class="custom-file-input"
                                                id="{{ $field }}" accept="image/*"
                                                onchange="previewImage(this,'prev-{{ $field }}')">
                                            <label class="custom-file-label" for="{{ $field }}">Ganti
                                                file...</label>
                                        </div>
                                        <img id="prev-{{ $field }}" src="#"
                                            class="img-thumbnail d-none mt-2" style="max-height:80px">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-warning"><i class="fas fa-save mr-1"></i>
                                Update</button>
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
