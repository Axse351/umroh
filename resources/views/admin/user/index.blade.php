@extends('layouts.app')

@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')

@section('breadcrumb')
    <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
    <div class="breadcrumb-item">Manajemen User</div>
@endsection

@section('content')
    <section class="section">
        <div class="section-body">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert"><span>&times;</span></button>
                        <i class="fas fa-check-circle mr-1"></i> {!! session('success') !!}
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert"><span>&times;</span></button>
                        <i class="fas fa-exclamation-circle mr-1"></i> {!! session('error') !!}
                    </div>
                </div>
            @endif

            {{-- STAT CARDS --}}
            <div class="row mb-3">
                <div class="col-6 col-md-3">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary"><i class="fas fa-users"></i></div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total User</h4>
                            </div>
                            <div class="card-body">{{ $counts['all'] }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger"><i class="fas fa-shield-alt"></i></div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Admin</h4>
                            </div>
                            <div class="card-body">{{ $counts['admin'] }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning"><i class="fas fa-cash-register"></i></div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Kasir</h4>
                            </div>
                            <div class="card-body">{{ $counts['kasir'] }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success"><i class="fas fa-user-friends"></i></div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Jamaah / User</h4>
                            </div>
                            <div class="card-body">{{ $counts['user'] + $counts['kolektor'] }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-users-cog mr-2"></i>Daftar User</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.user.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus mr-1"></i> Tambah User Baru
                        </a>
                    </div>
                </div>
                <div class="card-body">

                    {{-- FILTER --}}
                    <form method="GET" action="{{ route('admin.user.index') }}" class="mb-3">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Cari nama atau email..." value="{{ $search }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select name="role" class="form-control" onchange="this.form.submit()">
                                    <option value="">-- Semua Role --</option>
                                    <option value="admin" {{ $role === 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="kasir" {{ $role === 'kasir' ? 'selected' : '' }}>Kasir</option>
                                    <option value="kolektor" {{ $role === 'kolektor' ? 'selected' : '' }}>Kolektor</option>
                                    <option value="user" {{ $role === 'user' ? 'selected' : '' }}>User / Jamaah
                                    </option>
                                </select>
                            </div>
                            @if ($search || $role)
                                <div class="col-md-2">
                                    <a href="{{ route('admin.user.index') }}" class="btn btn-secondary btn-block">
                                        <i class="fas fa-times mr-1"></i> Reset
                                    </a>
                                </div>
                            @endif
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th width="50">#</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Terhubung Jamaah</th>
                                    <th>Dibuat</th>
                                    <th width="130" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td class="align-middle">
                                            {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm mr-2"
                                                    style="width:36px;height:36px;border-radius:50%;background:{{ $user->role === 'admin' ? '#fc544b' : ($user->role === 'kasir' ? '#ffa426' : '#47c363') }};display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.85rem;flex-shrink:0;">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <strong>{{ $user->name }}</strong>
                                                    @if ($user->id === auth()->id())
                                                        <span class="badge badge-info ml-1">Anda</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-muted">{{ $user->email }}</td>
                                        <td class="align-middle">
                                            @php
                                                $roleBadge = [
                                                    'admin' => 'danger',
                                                    'kasir' => 'warning',
                                                    'kolektor' => 'info',
                                                    'user' => 'success',
                                                ];
                                            @endphp
                                            <span class="badge badge-{{ $roleBadge[$user->role] ?? 'secondary' }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            @if ($user->jamaah)
                                                <a href="{{ route('admin.jamaah.show', $user->jamaah) }}"
                                                    class="text-primary">
                                                    <i class="fas fa-user mr-1"></i>{{ $user->jamaah->nama_lengkap }}
                                                </a>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <small class="text-muted">{{ $user->created_at->format('d M Y') }}</small>
                                        </td>
                                        <td class="text-center align-middle">
                                            <a href="{{ route('admin.user.show', $user) }}" class="btn btn-sm btn-info"
                                                title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.user.edit', $user) }}"
                                                class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if ($user->id !== auth()->id())
                                                <form action="{{ route('admin.user.destroy', $user) }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Hapus user {{ $user->name }}?')">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            <i class="fas fa-users fa-2x mb-2 d-block"></i>
                                            Tidak ada user ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <small class="text-muted">
                            Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }}
                            dari {{ $users->total() }} user
                        </small>
                        {{ $users->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
