@extends('layouts.app')

@section('title', 'Detail Pengeluaran')
@section('page-title', 'Detail Pengeluaran')

@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.pengeluaran.index') }}">Data Pengeluaran</a></div>
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
                            $kategoriColor =
                                [
                                    'operasional' => 'primary',
                                    'gaji' => 'success',
                                    'visa' => 'info',
                                    'tiket' => 'warning',
                                    'hotel' => 'purple',
                                    'transportasi' => 'secondary',
                                    'perlengkapan' => 'dark',
                                    'marketing' => 'danger',
                                    'lainnya' => 'secondary',
                                ][$pengeluaran->kategori] ?? 'secondary';
                            $kategoriIcon =
                                [
                                    'operasional' => 'cogs',
                                    'gaji' => 'users',
                                    'visa' => 'passport',
                                    'tiket' => 'plane',
                                    'hotel' => 'hotel',
                                    'transportasi' => 'bus',
                                    'perlengkapan' => 'box',
                                    'marketing' => 'bullhorn',
                                    'lainnya' => 'tag',
                                ][$pengeluaran->kategori] ?? 'tag';
                        @endphp
                        <div class="rounded-circle bg-{{ $kategoriColor }} d-inline-flex align-items-center justify-content-center mb-3"
                            style="width:100px;height:100px;">
                            <i class="fas fa-{{ $kategoriIcon }} text-white" style="font-size:2rem;"></i>
                        </div>
                        <h5 class="font-weight-bold mb-1">{{ $pengeluaran->no_pengeluaran }}</h5>
                        <p class="text-muted mb-2">{{ $pengeluaran->keperluan }}</p>
                        <span class="badge badge-{{ $kategoriColor }} badge-lg px-3 py-2">
                            {{ ucfirst($pengeluaran->kategori) }}
                        </span>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('admin.pengeluaran.edit', $pengeluaran) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.pengeluaran.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                {{-- Bukti --}}
                @if ($pengeluaran->bukti)
                    <div class="card">
                        <div class="card-header">
                            <h4>Bukti Pengeluaran</h4>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ asset('storage/' . $pengeluaran->bukti) }}" target="_blank">
                                <img src="{{ asset('storage/' . $pengeluaran->bukti) }}" class="img-fluid rounded"
                                    style="max-height:220px;">
                            </a>
                            <div class="mt-2">
                                <a href="{{ asset('storage/' . $pengeluaran->bukti) }}" target="_blank"
                                    class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-external-link-alt mr-1"></i> Lihat Penuh
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Kolom Kanan --}}
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-file-invoice-dollar mr-2"></i>Informasi Pengeluaran</h4>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <th width="35%" class="bg-light">No. Pengeluaran</th>
                                    <td><code>{{ $pengeluaran->no_pengeluaran }}</code></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Keperluan</th>
                                    <td>{{ $pengeluaran->keperluan }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Kategori</th>
                                    <td>
                                        <span
                                            class="badge badge-{{ $kategoriColor }}">{{ ucfirst($pengeluaran->kategori) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Jumlah</th>
                                    <td><strong class="text-danger">Rp
                                            {{ number_format($pengeluaran->jumlah, 0, ',', '.') }}</strong></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Tanggal</th>
                                    <td>{{ \Carbon\Carbon::parse($pengeluaran->tanggal)->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Penerima</th>
                                    <td>{{ $pengeluaran->penerima ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Dicatat Oleh</th>
                                    <td>{{ $pengeluaran->karyawan->nama_lengkap ?? '-' }}</td>
                                </tr>
                                @if ($pengeluaran->keterangan)
                                    <tr>
                                        <th class="bg-light">Keterangan</th>
                                        <td>{{ $pengeluaran->keterangan }}</td>
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
