@extends('layouts.app')

@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('breadcrumb')
    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
    <div class="breadcrumb-item active"><a href="{{ route('admin.user.index') }}">Manajemen User</a></div>
    <div class="breadcrumb-item">Edit User</div>
@endsection

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row justify-content-center">
                <div class="col-md-8">

                    {{-- Avatar & nama ringkas --}}
                    <div class="card mb-0 border-0 shadow-none" style="background:transparent;">
                        <div class="card-body pb-0 pt-2 px-0 d-flex align-items-center gap-3">
                            <div
                                style="width:52px;height:52px;border-radius:50%;
                            background:{{ $user->role === 'admin' ? '#fc544b' : ($user->role === 'kasir' ? '#ffa426' : ($user->role === 'kolektor' ? '#3abaf4' : '#47c363')) }};
                            display:flex;align-items:center;justify-content:center;
                            color:#fff;font-weight:700;font-size:1.3rem;flex-shrink:0;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <h5 class="mb-0 font-weight-bold">{{ $user->name }}</h5>
                                <small class="text-muted">{{ $user->email }} &middot;
                                    <span
                                        class="badge badge-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'kasir' ? 'warning' : ($user->role === 'kolektor' ? 'info' : 'success')) }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h4><i class="fas fa-user-edit mr-2"></i>Edit User</h4>
                        </div>

                        <div class="card-body">

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <ul class="mb-0 pl-3">
                                        @foreach ($errors->all() as $e)
                                            <li>{{ $e }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('admin.user.update', $user) }}" method="POST">
                                @csrf
                                @method('PUT')

                                {{-- ── Nama ─────────────────────────────────── --}}
                                <div class="form-group">
                                    <label class="font-weight-600">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $user->name) }}" placeholder="Masukkan nama lengkap"
                                        required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- ── Email ────────────────────────────────── --}}
                                <div class="form-group">
                                    <label class="font-weight-600">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $user->email) }}" placeholder="contoh@email.com" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- ── Role ─────────────────────────────────── --}}
                                <div class="form-group">
                                    <label class="font-weight-600">Role <span class="text-danger">*</span></label>
                                    @if ($user->id === auth()->id())
                                        {{-- Tidak boleh ubah role sendiri --}}
                                        <input type="hidden" name="role" value="{{ $user->role }}">
                                        <input type="text" class="form-control" value="{{ ucfirst($user->role) }}"
                                            disabled>
                                        <small class="text-warning">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                            Anda tidak dapat mengubah role akun sendiri.
                                        </small>
                                    @else
                                        <select name="role" class="form-control @error('role') is-invalid @enderror"
                                            required>
                                            @foreach (['admin' => 'Admin', 'kasir' => 'Kasir', 'kolektor' => 'Kolektor', 'user' => 'User / Jamaah'] as $val => $label)
                                                <option value="{{ $val }}"
                                                    {{ old('role', $user->role) === $val ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('role')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @endif
                                </div>

                                {{-- ── Password (opsional) ──────────────────── --}}
                                <div class="card bg-light border mb-3">
                                    <div class="card-body py-3">
                                        <h6 class="font-weight-bold mb-1">
                                            <i class="fas fa-lock mr-1 text-muted"></i>Ganti Password
                                        </h6>
                                        <small class="text-muted d-block mb-3">
                                            Kosongkan jika tidak ingin mengganti password.
                                        </small>

                                        <div class="form-group mb-2">
                                            <label class="font-weight-600">Password Baru</label>
                                            <div class="input-group">
                                                <input type="password" id="password" name="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    placeholder="Min. 8 karakter" autocomplete="new-password">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-outline-secondary toggle-pw"
                                                        data-target="password">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group mb-0">
                                            <label class="font-weight-600">Konfirmasi Password Baru</label>
                                            <div class="input-group">
                                                <input type="password" id="password_confirmation"
                                                    name="password_confirmation" class="form-control"
                                                    placeholder="Ulangi password baru" autocomplete="new-password">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-outline-secondary toggle-pw"
                                                        data-target="password_confirmation">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- ── Tombol ───────────────────────────────── --}}
                                <div class="d-flex justify-content-between align-items-center mt-4">
                                    <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="fas fa-save mr-1"></i> Simpan Perubahan
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
        // Toggle show/hide password
        document.querySelectorAll('.toggle-pw').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var targetId = this.getAttribute('data-target');
                var input = document.getElementById(targetId);
                var icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.replace('fa-eye', 'fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.replace('fa-eye-slash', 'fa-eye');
                }
            });
        });
    </script>
@endpush
