@extends('layouts.app')

@section('title', 'Detail Pemasukan')

@section('content')
    <div class="section-header">
        <h1>Detail Pemasukan</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.pemasukan.index') }}">Pemasukan</a></div>
            <div class="breadcrumb-item">Detail</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                {{-- Card Utama --}}
                @php
                    $kategoriColor = match ($pemasukan->kategori) {
                        'pembayaran_jamaah' => 'primary',
                        'setoran_tabungan' => 'info',
                        'transaksi_layanan' => 'warning',
                        'komisi' => 'success',
                        default => 'secondary',
                    };
                    $kategoriIcon = match ($pemasukan->kategori) {
                        'pembayaran_jamaah' => 'fa-users',
                        'setoran_tabungan' => 'fa-piggy-bank',
                        'transaksi_layanan' => 'fa-exchange-alt',
                        'komisi' => 'fa-percent',
                        default => 'fa-money-bill-wave',
                    };
                @endphp

                <div class="card">
                    <div class="card-body">
                        {{-- Header berwarna --}}
                        <div class="bg-{{ $kategoriColor }} rounded p-4 text-white text-center mb-4">
                            <div class="mb-2">
                                <i class="fas {{ $kategoriIcon }} fa-3x"></i>
                            </div>
                            <h2 class="text-white font-weight-bold mb-1">
                                Rp {{ number_format($pemasukan->jumlah, 0, ',', '.') }}
                            </h2>
                            <p class="mb-0 opacity-75">
                                {{ ucwords(str_replace('_', ' ', $pemasukan->kategori)) }}
                            </p>
                        </div>

                        {{-- Detail --}}
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th width="35%" class="bg-light">No. Pemasukan</th>
                                    <td><code>{{ $pemasukan->no_pemasukan }}</code></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Sumber</th>
                                    <td><strong>{{ $pemasukan->sumber }}</strong></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Kategori</th>
                                    <td>
                                        <span class="badge badge-{{ $kategoriColor }} px-3 py-2">
                                            <i class="fas {{ $kategoriIcon }} mr-1"></i>
                                            {{ ucwords(str_replace('_', ' ', $pemasukan->kategori)) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Jumlah</th>
                                    <td>
                                        <h4 class="text-{{ $kategoriColor }} font-weight-bold mb-0">
                                            Rp {{ number_format($pemasukan->jumlah, 0, ',', '.') }}
                                        </h4>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Tanggal</th>
                                    <td>
                                        <i class="fas fa-calendar text-muted mr-2"></i>
                                        {{ \Carbon\Carbon::parse($pemasukan->tanggal)->format('d F Y') }}
                                        <span class="text-muted small ml-2">
                                            ({{ \Carbon\Carbon::parse($pemasukan->tanggal)->diffForHumans() }})
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Dicatat oleh</th>
                                    <td>
                                        @if ($pemasukan->karyawan)
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mr-2"
                                                    style="width:32px;height:32px;min-width:32px;">
                                                    <small class="text-white font-weight-bold">
                                                        {{ strtoupper(substr($pemasukan->karyawan->nama_lengkap, 0, 1)) }}
                                                    </small>
                                                </div>
                                                <div>
                                                    <span
                                                        class="font-weight-bold">{{ $pemasukan->karyawan->nama_lengkap }}</span>
                                                    <br>
                                                    <small class="text-muted">{{ $pemasukan->karyawan->jabatan }}</small>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">Sistem</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Keterangan</th>
                                    <td>{{ $pemasukan->keterangan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Dibuat pada</th>
                                    <td>
                                        <small class="text-muted">
                                            {{ $pemasukan->created_at->format('d M Y H:i') }}
                                        </small>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Diperbarui pada</th>
                                    <td>
                                        <small class="text-muted">
                                            {{ $pemasukan->updated_at->format('d M Y H:i') }}
                                        </small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('admin.pemasukan.edit', $pemasukan) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.pemasukan.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button class="btn btn-danger"
                            onclick="if(confirm('Hapus data ini?')) document.getElementById('del-form').submit()">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                        <form id="del-form" action="{{ route('admin.pemasukan.destroy', $pemasukan) }}" method="POST"
                            class="d-none">
                            @csrf @method('DELETE')
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
