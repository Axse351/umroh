@extends('layouts.app')

@section('title', 'Detail Jamaah')

@section('content')
    <div class="section-header">
        <h1>Detail Jamaah</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.jamaah.index') }}">Jamaah</a></div>
            <div class="breadcrumb-item">Detail</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">

            {{-- Kolom Kiri: Foto & Info Singkat --}}
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center pt-4">
                        @if ($jamaah->foto)
                            <img src="{{ asset('storage/' . $jamaah->foto) }}" class="rounded-circle img-fluid mb-3"
                                style="width:120px;height:120px;object-fit:cover;">
                        @else
                            <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3"
                                style="width:120px;height:120px;">
                                <span class="text-white font-weight-bold" style="font-size:2.5rem;">
                                    {{ strtoupper(substr($jamaah->nama_lengkap, 0, 1)) }}
                                </span>
                            </div>
                        @endif
                        <h5 class="font-weight-bold mb-1">{{ $jamaah->nama_lengkap }}</h5>
                        <span class="badge badge-primary">{{ $jamaah->kode_jamaah }}</span>
                        <hr>
                        <div class="text-left">
                            <p class="mb-1"><i class="fas fa-id-card text-muted mr-2"></i> <strong>NIK:</strong>
                                {{ $jamaah->nik }}</p>
                            <p class="mb-1"><i class="fas fa-passport text-muted mr-2"></i> <strong>Passport:</strong>
                                {{ $jamaah->no_passport ?? '-' }}</p>
                            <p class="mb-1"><i class="fas fa-phone text-muted mr-2"></i> {{ $jamaah->no_telepon }}</p>
                            <p class="mb-1"><i class="fas fa-envelope text-muted mr-2"></i> {{ $jamaah->email ?? '-' }}
                            </p>
                            <p class="mb-1">
                                <i class="fas fa-venus-mars text-muted mr-2"></i>
                                <span
                                    class="badge {{ $jamaah->jenis_kelamin === 'laki-laki' ? 'badge-info' : 'badge-danger' }}">
                                    {{ ucfirst($jamaah->jenis_kelamin) }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('admin.jamaah.edit', $jamaah) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.jamaah.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                {{-- Foto Dokumen --}}
                <div class="card">
                    <div class="card-header">
                        <h4>Dokumen Foto</h4>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <p class="text-muted mb-1 small">Foto KTP</p>
                                @if ($jamaah->foto_ktp)
                                    <a href="{{ asset('storage/' . $jamaah->foto_ktp) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $jamaah->foto_ktp) }}"
                                            class="img-fluid rounded border" style="height:80px;object-fit:cover;">
                                    </a>
                                @else
                                    <span class="badge badge-light">Belum ada</span>
                                @endif
                            </div>
                            <div class="col-6 mb-3">
                                <p class="text-muted mb-1 small">Foto Passport</p>
                                @if ($jamaah->foto_passport)
                                    <a href="{{ asset('storage/' . $jamaah->foto_passport) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $jamaah->foto_passport) }}"
                                            class="img-fluid rounded border" style="height:80px;object-fit:cover;">
                                    </a>
                                @else
                                    <span class="badge badge-light">Belum ada</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Detail & Relasi --}}
            <div class="col-lg-8">

                {{-- Data Pribadi --}}
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-user mr-2"></i>Data Pribadi</h4>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <th width="35%" class="bg-light">Nama Lengkap</th>
                                    <td>{{ $jamaah->nama_lengkap }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Tempat / Tgl Lahir</th>
                                    <td>{{ $jamaah->tempat_lahir }},
                                        {{ \Carbon\Carbon::parse($jamaah->tanggal_lahir)->format('d M Y') }}
                                        <span
                                            class="text-muted small">({{ \Carbon\Carbon::parse($jamaah->tanggal_lahir)->age }}
                                            tahun)</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Alamat</th>
                                    <td>{{ $jamaah->alamat }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Kota / Provinsi</th>
                                    <td>{{ $jamaah->kota }}, {{ $jamaah->provinsi }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">No. Passport</th>
                                    <td>{{ $jamaah->no_passport ?? '-' }}
                                        @if ($jamaah->exp_passport)
                                            <span class="text-muted small">(Exp:
                                                {{ \Carbon\Carbon::parse($jamaah->exp_passport)->format('d M Y') }})</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Riwayat Pendaftaran --}}
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-clipboard-list mr-2"></i>Riwayat Pendaftaran</h4>
                        <div class="card-header-action">
                            <span class="badge badge-primary">{{ $jamaah->pendaftarans->count() }} paket</span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Paket</th>
                                        <th>Keberangkatan</th>
                                        <th>Kamar</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($jamaah->pendaftarans as $i => $daftar)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $daftar->keberangkatan->paket->nama_paket ?? '-' }}</td>
                                            <td>
                                                @if ($daftar->keberangkatan)
                                                    {{ \Carbon\Carbon::parse($daftar->keberangkatan->tanggal_berangkat)->format('d M Y') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ ucfirst($daftar->tipe_kamar ?? '-') }}</td>
                                            <td>
                                                @php
                                                    $statusColor = match ($daftar->status ?? '') {
                                                        'lunas' => 'success',
                                                        'dp' => 'warning',
                                                        'batal' => 'danger',
                                                        default => 'secondary',
                                                    };
                                                @endphp
                                                <span
                                                    class="badge badge-{{ $statusColor }}">{{ ucfirst($daftar->status ?? '-') }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Belum ada pendaftaran</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Tabungan --}}
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-piggy-bank mr-2"></i>Riwayat Tabungan</h4>
                        <div class="card-header-action">
                            <span class="badge badge-success">Total: Rp
                                {{ number_format($jamaah->tabungans->sum('jumlah'), 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Jumlah</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($jamaah->tabungans as $i => $tabungan)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ \Carbon\Carbon::parse($tabungan->tanggal)->format('d M Y') }}</td>
                                            <td class="text-success font-weight-bold">Rp
                                                {{ number_format($tabungan->jumlah, 0, ',', '.') }}</td>
                                            <td>{{ $tabungan->keterangan ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Belum ada tabungan</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Dokumen --}}
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-folder-open mr-2"></i>Dokumen Pendukung</h4>
                    </div>
                    <div class="card-body">
                        @forelse($jamaah->dokumens as $dok)
                            <div class="d-flex align-items-center mb-2 p-2 border rounded">
                                <i class="fas fa-file-alt fa-2x text-primary mr-3"></i>
                                <div>
                                    <p class="mb-0 font-weight-bold">{{ $dok->nama_dokumen ?? 'Dokumen' }}</p>
                                    <small class="text-muted">{{ $dok->jenis_dokumen ?? '' }}</small>
                                </div>
                                @if ($dok->file)
                                    <a href="{{ asset('storage/' . $dok->file) }}" target="_blank"
                                        class="btn btn-sm btn-outline-primary ml-auto">
                                        <i class="fas fa-download"></i> Lihat
                                    </a>
                                @endif
                            </div>
                        @empty
                            <p class="text-muted text-center mb-0">Belum ada dokumen</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
