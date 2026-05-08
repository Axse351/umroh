@extends('layouts.app')

@section('title', 'Detail Hotel')

@section('content')
    <div class="section-header">
        <h1>Detail Hotel</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.hotel.index') }}">Hotel</a></div>
            <div class="breadcrumb-item">Detail</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">

            {{-- Kolom Kiri --}}
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center pt-4">
                        <div class="rounded bg-warning d-inline-flex align-items-center justify-content-center mb-3"
                            style="width:90px;height:90px;">
                            <i class="fas fa-hotel fa-2x text-white"></i>
                        </div>
                        <h5 class="font-weight-bold mb-1">{{ $hotel->nama_hotel }}</h5>
                        <span class="badge badge-primary">{{ $hotel->kode_hotel }}</span>
                        <div class="my-2">
                            {{-- Bintang --}}
                            @for ($s = 1; $s <= 5; $s++)
                                <i class="fas fa-star {{ $s <= $hotel->bintang ? 'text-warning' : 'text-muted' }}"></i>
                            @endfor
                        </div>
                        <span class="badge badge-{{ $hotel->status === 'aktif' ? 'success' : 'danger' }} px-3 py-2">
                            {{ ucfirst($hotel->status) }}
                        </span>
                        <hr>
                        <div class="text-left">
                            <p class="mb-2">
                                <i class="fas fa-map-marker-alt text-danger mr-2"></i>
                                <strong>Lokasi:</strong>
                                @php
                                    $lokasiColor = match ($hotel->lokasi) {
                                        'mekkah' => 'success',
                                        'madinah' => 'primary',
                                        'jeddah' => 'warning',
                                        default => 'secondary',
                                    };
                                @endphp
                                <span class="badge badge-{{ $lokasiColor }}">{{ ucfirst($hotel->lokasi) }}</span>
                            </p>
                            <p class="mb-2">
                                <i class="fas fa-mosque text-muted mr-2"></i>
                                <strong>Jarak ke Masjid:</strong>
                                <span class="font-weight-bold text-primary">
                                    {{ $hotel->jarak_ke_masjid_meter ? number_format($hotel->jarak_ke_masjid_meter) . ' m' : '-' }}
                                </span>
                            </p>
                            <p class="mb-2">
                                <i class="fas fa-phone text-muted mr-2"></i> {{ $hotel->no_telepon ?? '-' }}
                            </p>
                            <p class="mb-0">
                                <i class="fas fa-map text-muted mr-2"></i> {{ $hotel->alamat ?? '-' }}
                            </p>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('admin.hotel.edit', $hotel) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.hotel.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                {{-- Fasilitas --}}
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-concierge-bell mr-2"></i>Fasilitas</h4>
                    </div>
                    <div class="card-body">
                        @if ($hotel->fasilitas)
                            @foreach (explode(',', $hotel->fasilitas) as $fas)
                                <span class="badge badge-light border mr-1 mb-1 px-2 py-1">
                                    <i class="fas fa-check text-success mr-1"></i>{{ trim($fas) }}
                                </span>
                            @endforeach
                        @else
                            <p class="text-muted mb-0">Belum ada fasilitas tercatat</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan --}}
            <div class="col-lg-8">

                {{-- Statistik Paket --}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-kaaba"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Paket Hotel Mekkah</h4>
                                </div>
                                <div class="card-body">{{ $hotel->paketSebagaiMekkah->count() }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-success">
                                <i class="fas fa-mosque"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Paket Hotel Madinah</h4>
                                </div>
                                <div class="card-body">{{ $hotel->paketSebagaiMadinah->count() }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Paket sebagai Hotel Mekkah --}}
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-kaaba mr-2"></i>Digunakan pada Paket (Hotel Mekkah)</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Paket</th>
                                        <th>Jenis</th>
                                        <th>Durasi</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($hotel->paketSebagaiMekkah as $i => $paket)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $paket->nama_paket }}</td>
                                            <td><span class="badge badge-info">{{ ucfirst($paket->jenis) }}</span></td>
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
                                            <td colspan="6" class="text-center text-muted py-3">Tidak ada paket</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Paket sebagai Hotel Madinah --}}
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-mosque mr-2"></i>Digunakan pada Paket (Hotel Madinah)</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Paket</th>
                                        <th>Jenis</th>
                                        <th>Durasi</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($hotel->paketSebagaiMadinah as $i => $paket)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $paket->nama_paket }}</td>
                                            <td><span class="badge badge-warning">{{ ucfirst($paket->jenis) }}</span></td>
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
                                            <td colspan="6" class="text-center text-muted py-3">Tidak ada paket</td>
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
