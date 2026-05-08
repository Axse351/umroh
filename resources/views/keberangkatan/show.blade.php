@extends('layouts.app')

@section('title', 'Detail Keberangkatan')

@section('content')
    <div class="section-header">
        <h1>Detail Keberangkatan</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.keberangkatan.index') }}">Keberangkatan</a></div>
            <div class="breadcrumb-item">Detail</div>
        </div>
    </div>

    <div class="section-body">

        {{-- Header Info --}}
        @php
            $statusColor = match ($keberangkatan->status) {
                'open' => 'success',
                'closed' => 'warning',
                'berangkat' => 'primary',
                'selesai' => 'info',
                'batal' => 'danger',
                default => 'secondary',
            };
            $tglBerangkat = \Carbon\Carbon::parse($keberangkatan->tanggal_berangkat);
            $tglPulang = \Carbon\Carbon::parse($keberangkatan->tanggal_pulang);
            $durasi = $tglBerangkat->diffInDays($tglPulang);
            $sisa = $keberangkatan->kuota - ($keberangkatan->pendaftarans->count() ?? 0);
        @endphp

        <div class="card bg-primary text-white mb-4">
            <div class="card-body py-4">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <div class="bg-white rounded p-3">
                            <i class="fas fa-plane fa-2x text-primary"></i>
                        </div>
                    </div>
                    <div class="col">
                        <h3 class="mb-1 text-white">{{ $keberangkatan->paket->nama_paket ?? 'N/A' }}</h3>
                        <p class="mb-0 opacity-75">
                            <code class="text-white">{{ $keberangkatan->kode_keberangkatan }}</code> &mdash;
                            {{ $tglBerangkat->format('d M Y') }} → {{ $tglPulang->format('d M Y') }}
                            <span class="badge badge-light ml-2">{{ $durasi }} hari</span>
                        </p>
                    </div>
                    <div class="col-auto text-right">
                        <span class="badge badge-{{ $statusColor }} badge-lg px-3 py-2" style="font-size:.9rem;">
                            {{ strtoupper($keberangkatan->status) }}
                        </span>
                        <div class="mt-2">
                            <a href="{{ route('admin.keberangkatan.edit', $keberangkatan) }}"
                                class="btn btn-light btn-sm mr-1">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="{{ route('admin.keberangkatan.index') }}" class="btn btn-outline-light btn-sm">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            {{-- Kolom Kiri --}}
            <div class="col-lg-4">

                {{-- Info Jadwal --}}
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-calendar-alt mr-2"></i>Jadwal & Penerbangan</h4>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <th class="bg-light">Tgl Berangkat</th>
                                    <td>{{ $tglBerangkat->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Tgl Pulang</th>
                                    <td>{{ $tglPulang->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Bandara</th>
                                    <td><span class="badge badge-dark">{{ $keberangkatan->bandara_keberangkatan }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">No. Penerbangan (P)</th>
                                    <td>{{ $keberangkatan->no_penerbangan_pergi ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">No. Penerbangan (K)</th>
                                    <td>{{ $keberangkatan->no_penerbangan_pulang ?? '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Harga Kamar --}}
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-bed mr-2"></i>Harga Kamar</h4>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="border rounded p-2">
                                    <small class="text-muted d-block">Double</small>
                                    <strong class="text-primary small">Rp
                                        {{ number_format($keberangkatan->harga_double, 0, ',', '.') }}</strong>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="border rounded p-2">
                                    <small class="text-muted d-block">Triple</small>
                                    <strong class="text-success small">Rp
                                        {{ number_format($keberangkatan->harga_triple, 0, ',', '.') }}</strong>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="border rounded p-2">
                                    <small class="text-muted d-block">Quad</small>
                                    <strong class="text-warning small">Rp
                                        {{ number_format($keberangkatan->harga_quad, 0, ',', '.') }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kuota --}}
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-users mr-2"></i>Kuota Jamaah</h4>
                    </div>
                    <div class="card-body">
                        @php
                            $terisi = $keberangkatan->pendaftarans->count();
                            $persen = $keberangkatan->kuota > 0 ? round(($terisi / $keberangkatan->kuota) * 100) : 0;
                            $barColor = $persen >= 90 ? 'danger' : ($persen >= 60 ? 'warning' : 'success');
                        @endphp
                        <div class="d-flex justify-content-between mb-2">
                            <span>Terisi: <strong>{{ $terisi }}</strong></span>
                            <span>Sisa: <strong
                                    class="text-{{ $barColor }}">{{ $keberangkatan->kuota - $terisi }}</strong></span>
                            <span>Total: <strong>{{ $keberangkatan->kuota }}</strong></span>
                        </div>
                        <div class="progress" style="height:10px;">
                            <div class="progress-bar bg-{{ $barColor }}" style="width:{{ $persen }}%"></div>
                        </div>
                        <small class="text-muted">{{ $persen }}% terisi</small>
                    </div>
                </div>

                {{-- Pembimbing --}}
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-user-tie mr-2"></i>Pembimbing</h4>
                    </div>
                    <div class="card-body">
                        @if ($keberangkatan->pembimbing)
                            <div class="d-flex align-items-center">
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mr-3"
                                    style="width:45px;height:45px;">
                                    <span class="text-white font-weight-bold">
                                        {{ strtoupper(substr($keberangkatan->pembimbing->nama_lengkap, 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="mb-0 font-weight-bold">{{ $keberangkatan->pembimbing->nama_lengkap }}</p>
                                    <small class="text-muted">{{ $keberangkatan->pembimbing->jabatan }}</small>
                                </div>
                            </div>
                        @else
                            <p class="text-muted mb-0 text-center">Belum ditentukan</p>
                        @endif
                    </div>
                </div>

                {{-- Catatan --}}
                @if ($keberangkatan->catatan)
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-sticky-note mr-2"></i>Catatan</h4>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">{{ $keberangkatan->catatan }}</p>
                        </div>
                    </div>
                @endif

            </div>

            {{-- Kolom Kanan --}}
            <div class="col-lg-8">

                {{-- Info Paket --}}
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-box mr-2"></i>Info Paket</h4>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <th width="35%" class="bg-light">Nama Paket</th>
                                    <td>{{ $keberangkatan->paket->nama_paket ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Jenis</th>
                                    <td><span
                                            class="badge badge-info">{{ ucfirst($keberangkatan->paket->jenis ?? '-') }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Kategori</th>
                                    <td><span
                                            class="badge badge-warning">{{ ucfirst($keberangkatan->paket->kategori ?? '-') }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Hotel Mekkah</th>
                                    <td>{{ $keberangkatan->paket->hotelMekkah->nama_hotel ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Hotel Madinah</th>
                                    <td>{{ $keberangkatan->paket->hotelMadinah->nama_hotel ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Maskapai</th>
                                    <td>{{ $keberangkatan->paket->maskapai->nama_maskapai ?? '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Daftar Jamaah --}}
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-users mr-2"></i>Daftar Jamaah Terdaftar</h4>
                        <div class="card-header-action">
                            <span class="badge badge-primary">{{ $keberangkatan->pendaftarans->count() }} orang</span>
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
                                        <th>Kamar</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($keberangkatan->pendaftarans as $i => $daftar)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>
                                                <a href="{{ route('admin.jamaah.show', $daftar->jamaah_id) }}"
                                                    class="font-weight-bold">
                                                    {{ $daftar->jamaah->nama_lengkap ?? '-' }}
                                                </a>
                                            </td>
                                            <td><small>{{ $daftar->jamaah->nik ?? '-' }}</small></td>
                                            <td><span
                                                    class="badge badge-light border">{{ ucfirst($daftar->tipe_kamar ?? '-') }}</span>
                                            </td>
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
                                                    class="btn btn-sm btn-info" title="Detail Jamaah">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                <i class="fas fa-users fa-2x mb-2 d-block text-light"></i>
                                                Belum ada jamaah terdaftar
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
