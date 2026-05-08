@extends('layouts.app')

@section('title', 'Detail Maskapai')

@section('content')
    <div class="section-header">
        <h1>Detail Maskapai</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.maskapai.index') }}">Maskapai</a></div>
            <div class="breadcrumb-item">Detail</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">

            {{-- Kolom Kiri --}}
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center pt-4">
                        <div class="rounded bg-info d-inline-flex align-items-center justify-content-center mb-3"
                            style="width:90px;height:90px;">
                            <i class="fas fa-plane fa-2x text-white"></i>
                        </div>
                        <h5 class="font-weight-bold mb-1">{{ $maskapai->nama_maskapai }}</h5>
                        <code class="d-block mb-2">{{ $maskapai->kode_maskapai }}</code>
                        @if ($maskapai->kode_iata)
                            <span class="badge badge-dark px-3 py-2 mr-1">IATA: {{ $maskapai->kode_iata }}</span>
                        @endif
                        <span class="badge badge-{{ $maskapai->status === 'aktif' ? 'success' : 'danger' }} px-3 py-2">
                            {{ ucfirst($maskapai->status) }}
                        </span>
                        <hr>
                        <div class="text-left">
                            <p class="mb-2">
                                <i class="fas fa-phone text-muted mr-2"></i>
                                {{ $maskapai->no_telepon ?? '-' }}
                            </p>
                            <p class="mb-2">
                                <i class="fas fa-envelope text-muted mr-2"></i>
                                {{ $maskapai->email ?? '-' }}
                            </p>
                            <p class="mb-0">
                                <i class="fas fa-globe text-muted mr-2"></i>
                                @if ($maskapai->website)
                                    <a href="{{ $maskapai->website }}" target="_blank">{{ $maskapai->website }}</a>
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('admin.maskapai.edit', $maskapai) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.maskapai.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                {{-- Statistik --}}
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Paket</h4>
                        </div>
                        <div class="card-body">{{ $maskapai->pakets->count() }}</div>
                    </div>
                </div>
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Paket Aktif</h4>
                        </div>
                        <div class="card-body">{{ $maskapai->pakets->where('status', 'aktif')->count() }}</div>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Daftar Paket --}}
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-box mr-2"></i>Paket yang Menggunakan Maskapai Ini</h4>
                        <div class="card-header-action">
                            <span class="badge badge-info">{{ $maskapai->pakets->count() }} paket</span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Kode</th>
                                        <th>Nama Paket</th>
                                        <th>Jenis</th>
                                        <th>Kategori</th>
                                        <th>Durasi</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($maskapai->pakets as $i => $paket)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td><code>{{ $paket->kode_paket }}</code></td>
                                            <td>{{ $paket->nama_paket }}</td>
                                            <td>
                                                @php
                                                    $jc = match ($paket->jenis) {
                                                        'umroh' => 'info',
                                                        'haji' => 'warning',
                                                        'haji_plus' => 'primary',
                                                        default => 'secondary',
                                                    };
                                                @endphp
                                                <span
                                                    class="badge badge-{{ $jc }}">{{ ucfirst(str_replace('_', ' ', $paket->jenis)) }}</span>
                                            </td>
                                            <td><span
                                                    class="badge badge-light border">{{ ucfirst($paket->kategori) }}</span>
                                            </td>
                                            <td>{{ $paket->durasi_hari }} hari</td>
                                            <td>
                                                <span
                                                    class="badge badge-{{ $paket->status === 'aktif' ? 'success' : 'danger' }}">
                                                    {{ ucfirst($paket->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.paket.show', $paket) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">
                                                <i class="fas fa-box-open fa-2x mb-2 d-block text-light"></i>
                                                Belum ada paket menggunakan maskapai ini
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
