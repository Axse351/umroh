@extends('layouts.app')

@section('title', 'Detail Mitra')
@section('page-title', 'Detail Mitra')

@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.mitra.index') }}">Data Mitra</a></div>
    <div class="breadcrumb-item active">Detail</div>
@endsection

@section('content')
    <div class="section-body">
        <div class="row">

            {{-- Kolom Kiri --}}
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center pt-4">
                        @php
                            $jenisColor =
                                [
                                    'bank' => 'primary',
                                    'asuransi' => 'success',
                                    'supplier' => 'warning',
                                    'partner' => 'info',
                                    'lainnya' => 'secondary',
                                ][$mitra->jenis] ?? 'secondary';
                            $jenisIcon =
                                [
                                    'bank' => 'university',
                                    'asuransi' => 'shield-alt',
                                    'supplier' => 'truck',
                                    'partner' => 'handshake',
                                    'lainnya' => 'tag',
                                ][$mitra->jenis] ?? 'tag';
                        @endphp
                        <div class="rounded-circle bg-{{ $jenisColor }} d-inline-flex align-items-center justify-content-center mb-3"
                            style="width:100px;height:100px;">
                            <i class="fas fa-{{ $jenisIcon }} text-white" style="font-size:2rem;"></i>
                        </div>
                        <h5 class="font-weight-bold mb-1">{{ $mitra->nama_mitra }}</h5>
                        <p class="text-muted mb-1">{{ $mitra->kode_mitra }}</p>
                        <span class="badge badge-{{ $jenisColor }}">{{ ucfirst($mitra->jenis) }}</span>
                        <br><br>
                        <span
                            class="badge badge-{{ $mitra->status === 'aktif' ? 'success' : 'danger' }} badge-lg px-3 py-2">
                            <i class="fas fa-circle fa-xs mr-1"></i>{{ ucfirst($mitra->status) }}
                        </span>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('admin.mitra.edit', $mitra) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.mitra.index') }}" class="btn btn-secondary btn-sm">
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
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Nama PIC</small>
                                <span>{{ $mitra->nama_pic ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-info rounded p-2 mr-3">
                                <i class="fas fa-phone text-white"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">No. Telepon</small>
                                <span>{{ $mitra->no_telepon ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-warning rounded p-2 mr-3">
                                <i class="fas fa-envelope text-white"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Email</small>
                                <span>{{ $mitra->email ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="bg-success rounded p-2 mr-3">
                                <i class="fas fa-map-marker-alt text-white"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Alamat</small>
                                <span>{{ $mitra->alamat ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan --}}
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-handshake mr-2"></i>Informasi Mitra</h4>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <th width="35%" class="bg-light">Kode Mitra</th>
                                    <td><code>{{ $mitra->kode_mitra }}</code></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Nama Mitra</th>
                                    <td>{{ $mitra->nama_mitra }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Jenis</th>
                                    <td><span class="badge badge-{{ $jenisColor }}">{{ ucfirst($mitra->jenis) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Nama PIC</th>
                                    <td>{{ $mitra->nama_pic ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">No. Telepon</th>
                                    <td>{{ $mitra->no_telepon ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Email</th>
                                    <td>{{ $mitra->email ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Alamat</th>
                                    <td>{{ $mitra->alamat ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Status</th>
                                    <td>
                                        <span class="badge badge-{{ $mitra->status === 'aktif' ? 'success' : 'danger' }}">
                                            {{ ucfirst($mitra->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @if ($mitra->keterangan)
                                    <tr>
                                        <th class="bg-light">Keterangan</th>
                                        <td>{{ $mitra->keterangan }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
