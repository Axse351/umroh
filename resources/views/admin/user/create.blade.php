@extends('layouts.app')

@section('title', 'Tambah User')
@section('page-title', 'Tambah User Baru')

@section('breadcrumb')
    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
    <div class="breadcrumb-item active"><a href="{{ route('admin.user.index') }}">Manajemen User</a></div>
    <div class="breadcrumb-item">Tambah User</div>
@endsection

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row justify-content-center">
                <div class="col-md-8">

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible show fade">
                            <div class="alert-body">
                                <button class="close" data-dismiss="alert"><span>&times;</span></button>
                                <ul class="mb-0 pl-3">
                                    @foreach ($errors->all() as $e)
                                        <li>{{ $e }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-user-plus mr-2"></i>Form Tambah User</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.user.store') }}" method="POST">
                                @csrf

                                {{-- INFO AKUN --}}
                                <h6 class="text-muted font-weight-bold mb-3 border-bottom pb-2">
                                    <i class="fas fa-id-card mr-1"></i> Informasi Akun
                                </h6>

                                <div class="form-group">
                                    <label class="font-weight-bold">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                        placeholder="Nama lengkap user" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" placeholder="email@contoh.com" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="font-weight-bold">Role <span class="text-danger">*</span></label>
                                    <select name="role" id="roleSelect"
                                        class="form-control @error('role') is-invalid @enderror"
                                        onchange="toggleJamaahField()" required>
                                        <option value="">-- Pilih Role --</option>
                                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>
                                            🛡️ Admin — Akses penuh sistem
                                        </option>
                                        <option value="kasir" {{ old('role') === 'kasir' ? 'selected' : '' }}>
                                            💰 Kasir — Kelola pembayaran & jamaah
                                        </option>
                                        <option value="kolektor" {{ old('role') === 'kolektor' ? 'selected' : '' }}>
                                            📋 Kolektor — Kelola setoran tabungan
                                        </option>
                                        <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>
                                            👤 User — Akun jamaah (view only)
                                        </option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Field jamaah — hanya muncul jika role = user --}}
                                <div class="form-group" id="jamaahField"
                                    style="{{ old('role') === 'user' ? '' : 'display:none' }}">
                                    <label class="font-weight-bold">Tautkan ke Jamaah</label>
                                    <select name="jamaah_id" class="form-control @error('jamaah_id') is-invalid @enderror">
                                        <option value="">-- Tidak ditautkan (opsional) --</option>
                                        @foreach ($jamaahs as $j)
                                            <option value="{{ $j->id }}"
                                                {{ old('jamaah_id') == $j->id ? 'selected' : '' }}>
                                                {{ $j->nama_lengkap }} — {{ $j->nik }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">
                                        Hanya jamaah yang belum memiliki akun yang ditampilkan.
                                        Jika dikosongkan, akun user tidak terhubung ke data jamaah.
                                    </small>
                                    @error('jamaah_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- PASSWORD --}}
                                <h6 class="text-muted font-weight-bold mb-3 border-bottom pb-2 mt-4">
                                    <i class="fas fa-lock mr-1"></i> Password
                                </h6>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Password <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="password" name="password" id="passwordInput"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    placeholder="Min. 6 karakter" required>
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-outline-secondary"
                                                        onclick="togglePassword('passwordInput', this)">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            @error('password')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Konfirmasi Password <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="password" name="password_confirmation" id="passwordConfirm"
                                                    class="form-control" placeholder="Ulangi password" required>
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-outline-secondary"
                                                        onclick="togglePassword('passwordConfirm', this)">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-info py-2 px-3">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    <small>Untuk akun jamaah, password default biasanya adalah NIK jamaah agar mudah
                                        diingat.</small>
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save mr-1"></i> Simpan User
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function toggleJamaahField() {
            const role = document.getElementById('roleSelect').value;
            const field = document.getElementById('jamaahField');
            field.style.display = role === 'user' ? 'block' : 'none';
        }

        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
@endpush
