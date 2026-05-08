@extends('layouts.app')

@section('title', 'Detail Dokumen')
@section('page-title', 'Detail Dokumen')

@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.dokumen.index') }}">Data Dokumen</a></div>
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
                            $ext = pathinfo($dokumen->file_path, PATHINFO_EXTENSION);
                            $isPdf = strtolower($ext) === 'pdf';
                            $statusColor =
                                [
                                    'pending' => 'secondary',
                                    'valid' => 'success',
                                    'expired' => 'warning',
                                    'ditolak' => 'danger',
                                ][$dokumen->status] ?? 'secondary';
                        @endphp
                        <div class="rounded-circle bg-{{ $statusColor }} d-inline-flex align-items-center justify-content-center mb-3"
                            style="width:100px;height:100px;">
                            <i class="fas fa-{{ $isPdf ? 'file-pdf' : 'file-image' }} text-white"
                                style="font-size:2rem;"></i>
                        </div>
                        <h5 class="font-weight-bold mb-1">{{ ucwords(str_replace('_', ' ', $dokumen->jenis_dokumen)) }}</h5>
                        <p class="text-muted mb-2">{{ $dokumen->jamaah->nama_lengkap ?? '-' }}</p>
                        <span class="badge badge-{{ $statusColor }} badge-lg px-3 py-2">
                            <i class="fas fa-circle fa-xs mr-1"></i>{{ ucfirst($dokumen->status) }}
                        </span>
                    </div>
                    <div class="card-footer text-center">
                        @if ($dokumen->status === 'pending')
                            <form action="{{ route('admin.dokumen.validasi', $dokumen) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Validasi dokumen ini?')">
                                @csrf
                                <button class="btn btn-success btn-sm">
                                    <i class="fas fa-check mr-1"></i> Validasi
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('admin.dokumen.edit', $dokumen) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.dokumen.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                {{-- Preview File --}}
                <div class="card">
                    <div class="card-header">
                        <h4>Preview Dokumen</h4>
                    </div>
                    <div class="card-body text-center">
                        @if ($isPdf)
                            <div class="p-4 bg-light rounded">
                                <i class="fas fa-file-pdf text-danger" style="font-size:4rem;"></i>
                                <p class="text-muted mt-2 mb-0 small">File PDF</p>
                            </div>
                        @else
                            <img src="{{ asset('storage/' . $dokumen->file_path) }}" class="img-fluid rounded"
                                style="max-height:220px;">
                        @endif
                        <div class="mt-3">
                            <a href="{{ asset('storage/' . $dokumen->file_path) }}" target="_blank"
                                class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-external-link-alt mr-1"></i> Buka File
                            </a>
                            <a href="{{ asset('storage/' . $dokumen->file_path) }}" download
                                class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-download mr-1"></i> Unduh
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan --}}
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-folder-open mr-2"></i>Informasi Dokumen</h4>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <th width="35%" class="bg-light">Jenis Dokumen</th>
                                    <td>{{ ucwords(str_replace('_', ' ', $dokumen->jenis_dokumen)) }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Jamaah</th>
                                    <td>{{ $dokumen->jamaah->nama_lengkap ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">No. Pendaftaran</th>
                                    <td><code>{{ $dokumen->pendaftaran->no_pendaftaran ?? '-' }}</code></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Nama File</th>
                                    <td><small class="text-muted">{{ $dokumen->nama_file }}</small></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Tanggal Upload</th>
                                    <td>{{ \Carbon\Carbon::parse($dokumen->tanggal_upload)->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Tanggal Expired</th>
                                    <td>
                                        @if ($dokumen->tanggal_expired)
                                            @php $exp = \Carbon\Carbon::parse($dokumen->tanggal_expired); @endphp
                                            <span class="{{ $exp->isPast() ? 'text-danger font-weight-bold' : '' }}">
                                                {{ $exp->format('d F Y') }}
                                            </span>
                                            @if ($exp->isPast())
                                                <span class="badge badge-danger ml-1">Expired</span>
                                            @elseif ($exp->diffInDays() <= 30)
                                                <span class="badge badge-warning ml-1">Segera Expired</span>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Status</th>
                                    <td>
                                        <span
                                            class="badge badge-{{ $statusColor }}">{{ ucfirst($dokumen->status) }}</span>
                                    </td>
                                </tr>
                                @if ($dokumen->catatan)
                                    <tr>
                                        <th class="bg-light">Catatan</th>
                                        <td>{{ $dokumen->catatan }}</td>
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
