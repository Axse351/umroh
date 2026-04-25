@extends('layouts.app')

@section('title', 'Tambah Karyawan')
@section('page-title', 'Tambah Karyawan')

@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.karyawan.index') }}">Data Karyawan</a></div>
    <div class="breadcrumb-item active">Tambah</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Form Tambah Karyawan</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.karyawan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_lengkap"
                                        class="form-control @error('nama_lengkap') is-invalid @enderror"
                                        value="{{ old('nama_lengkap') }}" placeholder="Nama lengkap karyawan">
                                    @error('nama_lengkap')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>NIK <span class="text-danger">*</span></label>
                                    <input type="text" name="nik"
                                        class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik') }}"
                                        placeholder="16 digit NIK" maxlength="16">
                                    @error('nik')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jabatan <span class="text-danger">*</span></label>
                                    <input type="text" name="jabatan"
                                        class="form-control @error('jabatan') is-invalid @enderror"
                                        value="{{ old('jabatan') }}" placeholder="Jabatan">
                                    @error('jabatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Divisi</label>
                                    <input type="text" name="divisi"
                                        class="form-control @error('divisi') is-invalid @enderror"
                                        value="{{ old('divisi') }}" placeholder="Divisi">
                                    @error('divisi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>No. Telepon</label>
                                    <input type="text" name="no_telepon"
                                        class="form-control @error('no_telepon') is-invalid @enderror"
                                        value="{{ old('no_telepon') }}" placeholder="08xxxxxxxxxx">
                                    @error('no_telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" placeholder="email@contoh.com">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Masuk <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_masuk"
                                        class="form-control @error('tanggal_masuk') is-invalid @enderror"
                                        value="{{ old('tanggal_masuk') }}">
                                    @error('tanggal_masuk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>
                                            Nonaktif</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3"
                                        placeholder="Alamat lengkap">{{ old('alamat') }}</textarea>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Foto</label>
                                    <div class="custom-file">
                                        <input type="file" name="foto"
                                            class="custom-file-input @error('foto') is-invalid @enderror" id="foto"
                                            accept="image/*" onchange="previewImage(this,'preview-foto')">
                                        <label class="custom-file-label" for="foto">Pilih foto...</label>
                                    </div>
                                    @error('foto')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <div class="mt-2">
                                        <img id="preview-foto" src="#" alt="Preview"
                                            class="img-thumbnail d-none" style="max-height:120px">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i>
                                Simpan</button>
                            <a href="{{ route('admin.karyawan.index') }}" class="btn btn-secondary ml-2"><i
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
