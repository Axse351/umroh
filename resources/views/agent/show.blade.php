@extends('layouts.app')

@section('title', 'Detail Agent')

@section('content')
    <div class="section-header">
        <h1>Detail Agent</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.agent.index') }}">Agent</a></div>
            <div class="breadcrumb-item">Detail</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">

            {{-- Kolom Kiri: Info Agent --}}
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center pt-4">
                        <div class="rounded-circle bg-success d-inline-flex align-items-center justify-content-center mb-3"
                            style="width:100px;height:100px;">
                            <i class="fas fa-handshake fa-2x text-white"></i>
                        </div>
                        <h5 class="font-weight-bold mb-1">{{ $agent->nama_agent }}</h5>
                        <span class="badge badge-primary">{{ $agent->kode_agent }}</span>
                        <br><br>
                        <span class="badge badge-{{ $agent->status === 'aktif' ? 'success' : 'danger' }} badge-lg">
                            {{ ucfirst($agent->status) }}
                        </span>
                        <hr>
                        <div class="text-left">
                            <p class="mb-2"><i class="fas fa-user text-muted mr-2"></i> <strong>PIC:</strong>
                                {{ $agent->nama_pic }}</p>
                            <p class="mb-2"><i class="fas fa-phone text-muted mr-2"></i> {{ $agent->no_telepon }}</p>
                            <p class="mb-2"><i class="fas fa-envelope text-muted mr-2"></i> {{ $agent->email ?? '-' }}</p>
                            <p class="mb-2"><i class="fas fa-map-marker-alt text-muted mr-2"></i>
                                {{ $agent->kota ?? '-' }}, {{ $agent->provinsi ?? '-' }}</p>
                            <p class="mb-2">
                                <i class="fas fa-tags text-muted mr-2"></i>
                                <strong>Jenis:</strong>
                                @php
                                    $jenisColor = match ($agent->jenis) {
                                        'umroh' => 'info',
                                        'haji' => 'warning',
                                        default => 'primary',
                                    };
                                @endphp
                                <span class="badge badge-{{ $jenisColor }}">{{ ucfirst($agent->jenis) }}</span>
                            </p>
                            <p class="mb-0">
                                <i class="fas fa-percent text-muted mr-2"></i>
                                <strong>Komisi:</strong>
                                <span class="text-success font-weight-bold">{{ $agent->komisi_persen ?? 0 }}%</span>
                            </p>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('admin.agent.edit', $agent) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.agent.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                {{-- Alamat Lengkap --}}
                @if ($agent->alamat)
                    <div class="card">
                        <div class="card-header">
                            <h4>Alamat</h4>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">{{ $agent->alamat }}</p>
                            <p class="mb-0 text-muted">{{ $agent->kota }}, {{ $agent->provinsi }}</p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Kolom Kanan: Ringkasan & Daftar Jamaah --}}
            <div class="col-lg-8">

                {{-- Statistik --}}
                <div class="row">
                    <div class="col-md-6 col-6">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Pendaftaran</h4>
                                </div>
                                <div class="card-body">{{ $agent->pendaftarans->count() }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-6">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-success">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Jamaah Lunas</h4>
                                </div>
                                <div class="card-body">{{ $agent->pendaftarans->where('status', 'lunas')->count() }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Daftar Jamaah via Agent --}}
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-users mr-2"></i>Daftar Jamaah</h4>
                        <div class="card-header-action">
                            <span class="badge badge-primary">{{ $agent->pendaftarans->count() }} jamaah</span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Jamaah</th>
                                        <th>NIK</th>
                                        <th>No. Telepon</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($agent->pendaftarans as $i => $daftar)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center mr-2"
                                                        style="width:32px;height:32px;min-width:32px;">
                                                        <small class="text-white font-weight-bold">
                                                            {{ strtoupper(substr($daftar->jamaah->nama_lengkap ?? 'J', 0, 1)) }}
                                                        </small>
                                                    </div>
                                                    {{ $daftar->jamaah->nama_lengkap ?? '-' }}
                                                </div>
                                            </td>
                                            <td>{{ $daftar->jamaah->nik ?? '-' }}</td>
                                            <td>{{ $daftar->jamaah->no_telepon ?? '-' }}</td>
                                            <td>
                                                @php
                                                    $c = match ($daftar->status ?? '') {
                                                        'lunas' => 'success',
                                                        'dp' => 'warning',
                                                        'batal' => 'danger',
                                                        default => 'secondary',
                                                    };
                                                @endphp
                                                <span
                                                    class="badge badge-{{ $c }}">{{ ucfirst($daftar->status ?? '-') }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.jamaah.show', $daftar->jamaah_id) }}"
                                                    class="btn btn-sm btn-info" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-3">Belum ada jamaah
                                                terdaftar</td>
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
