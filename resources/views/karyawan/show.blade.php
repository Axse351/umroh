@extends('layouts.app')

@section('title', 'Detail Karyawan')

@section('content')
    <div class="section-header">
        <h1>Detail Karyawan</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.karyawan.index') }}">Karyawan</a></div>
            <div class="breadcrumb-item">Detail</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">

            {{-- Kolom Kiri: Profil --}}
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center pt-4">
                        @if ($karyawan->foto)
                            <img src="{{ asset('storage/' . $karyawan->foto) }}" class="rounded-circle img-fluid mb-3"
                                style="width:120px;height:120px;object-fit:cover;border:3px solid #6777ef;">
                        @else
                            <div class="rounded-circle bg-warning d-inline-flex align-items-center justify-content-center mb-3"
                                style="width:120px;height:120px;">
                                <span class="text-white font-weight-bold" style="font-size:2.5rem;">
                                    {{ strtoupper(substr($karyawan->nama_lengkap, 0, 1)) }}
                                </span>
                            </div>
                        @endif
                        <h5 class="font-weight-bold mb-1">{{ $karyawan->nama_lengkap }}</h5>
                        <p class="text-muted mb-1">{{ $karyawan->jabatan }}</p>
                        <span class="badge badge-primary">{{ $karyawan->kode_karyawan }}</span>
                        <br><br>
                        <span
                            class="badge badge-{{ $karyawan->status === 'aktif' ? 'success' : 'danger' }} badge-lg px-3 py-2">
                            <i class="fas fa-circle fa-xs mr-1"></i>{{ ucfirst($karyawan->status) }}
                        </span>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('admin.karyawan.edit', $karyawan) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.karyawan.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                {{-- Kontak --}}
                <div class="card">
                    <div class="card-header">
                        <h4>Kontak</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary rounded p-2 mr-3">
                                <i class="fas fa-phone text-white"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">No. Telepon</small>
                                <span>{{ $karyawan->no_telepon ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-info rounded p-2 mr-3">
                                <i class="fas fa-envelope text-white"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Email</small>
                                <span>{{ $karyawan->email ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="bg-success rounded p-2 mr-3">
                                <i class="fas fa-map-marker-alt text-white"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Alamat</small>
                                <span>{{ $karyawan->alamat ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Detail --}}
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-id-badge mr-2"></i>Informasi Karyawan</h4>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <th width="35%" class="bg-light">Kode Karyawan</th>
                                    <td><code>{{ $karyawan->kode_karyawan }}</code></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Nama Lengkap</th>
                                    <td>{{ $karyawan->nama_lengkap }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">NIK</th>
                                    <td>{{ $karyawan->nik }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Jabatan</th>
                                    <td>
                                        <span class="badge badge-info px-3 py-1">{{ $karyawan->jabatan }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Tanggal Masuk</th>
                                    <td>
                                        {{ \Carbon\Carbon::parse($karyawan->tanggal_masuk)->format('d F Y') }}
                                        <span class="text-muted small">
                                            ({{ \Carbon\Carbon::parse($karyawan->tanggal_masuk)->diffForHumans() }})
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Masa Kerja</th>
                                    <td>
                                        @php
                                            $masuk = \Carbon\Carbon::parse($karyawan->tanggal_masuk);
                                            $now = \Carbon\Carbon::now();
                                            $years = $masuk->diffInYears($now);
                                            $months = $masuk->copy()->addYears($years)->diffInMonths($now);
                                        @endphp
                                        <span class="font-weight-bold text-primary">{{ $years }} tahun
                                            {{ $months }} bulan</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Status</th>
                                    <td>
                                        <span
                                            class="badge badge-{{ $karyawan->status === 'aktif' ? 'success' : 'danger' }}">
                                            {{ ucfirst($karyawan->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Email</th>
                                    <td>{{ $karyawan->email ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">No. Telepon</th>
                                    <td>{{ $karyawan->no_telepon ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Alamat</th>
                                    <td>{{ $karyawan->alamat ?? '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Timeline / Aktivitas (placeholder) --}}
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-history mr-2"></i>Riwayat Keberangkatan sebagai Pembimbing</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Kode</th>
                                        <th>Paket</th>
                                        <th>Tgl Berangkat</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($karyawan->keberangkatanSebagaiPembimbing ?? [] as $i => $kbr)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td><code>{{ $kbr->kode_keberangkatan }}</code></td>
                                            <td>{{ $kbr->paket->nama_paket ?? '-' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($kbr->tanggal_berangkat)->format('d M Y') }}</td>
                                            <td>
                                                <span class="badge badge-info">{{ ucfirst($kbr->status) }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-3">Belum pernah menjadi
                                                pembimbing</td>
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
