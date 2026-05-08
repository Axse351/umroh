@extends('layouts.app')

@section('title', 'Detail Paket')

@section('content')
    <div class="section-header">
        <h1>Detail Paket</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('admin.paket.index') }}">Paket</a></div>
            <div class="breadcrumb-item">Detail</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">

            {{-- Kolom Kiri --}}
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center pt-4">
                        @php
                            $iconColor = match ($paket->jenis) {
                                'umroh' => 'bg-info',
                                'haji' => 'bg-warning',
                                'haji_plus' => 'bg-primary',
                                'haji_furoda' => 'bg-danger',
                                default => 'bg-secondary',
                            };
                        @endphp
                        <div class="rounded {{ $iconColor }} d-inline-flex align-items-center justify-content-center mb-3"
                            style="width:90px;height:90px;">
                            <i class="fas fa-kaaba fa-2x text-white"></i>
                        </div>
                        <h5 class="font-weight-bold mb-1">{{ $paket->nama_paket }}</h5>
                        <code class="d-block mb-2">{{ $paket->kode_paket }}</code>
                        <span class="badge badge-info mr-1">{{ ucfirst(str_replace('_', ' ', $paket->jenis)) }}</span>
                        <span class="badge badge-warning mr-1">{{ ucfirst($paket->kategori) }}</span>
                        <span class="badge badge-{{ $paket->status === 'aktif' ? 'success' : 'danger' }}">
                            {{ ucfirst($paket->status) }}
                        </span>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('admin.paket.edit', $paket) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.paket.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                {{-- Harga --}}
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-tag mr-2"></i>Harga Kamar</h4>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <td class="bg-light"><i class="fas fa-bed mr-1"></i> Double</td>
                                    <td class="text-primary font-weight-bold">Rp
                                        {{ number_format($paket->harga_double, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="bg-light"><i class="fas fa-bed mr-1"></i> Triple</td>
                                    <td class="text-success font-weight-bold">Rp
                                        {{ number_format($paket->harga_triple, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="bg-light"><i class="fas fa-bed mr-1"></i> Quad</td>
                                    <td class="text-warning font-weight-bold">Rp
                                        {{ number_format($paket->harga_quad, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Statistik Keberangkatan --}}
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-plane-departure"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Keberangkatan</h4>
                        </div>
                        <div class="card-body">{{ $paket->keberangkatans->count() }}</div>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan --}}
            <div class="col-lg-8">

                {{-- Info Utama --}}
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-info-circle mr-2"></i>Informasi Paket</h4>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <th width="35%" class="bg-light">Durasi</th>
                                    <td><span class="badge badge-dark px-3 py-2">{{ $paket->durasi_hari }} Hari</span></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Maskapai</th>
                                    <td>
                                        <i class="fas fa-plane text-info mr-2"></i>
                                        {{ $paket->maskapai->nama_maskapai ?? '-' }}
                                        @if ($paket->maskapai->kode_iata ?? false)
                                            <span
                                                class="badge badge-light border ml-1">{{ $paket->maskapai->kode_iata }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Hotel Mekkah</th>
                                    <td>
                                        <i class="fas fa-hotel text-success mr-2"></i>
                                        {{ $paket->hotelMekkah->nama_hotel ?? '-' }}
                                        @if ($paket->hotelMekkah ?? false)
                                            @for ($s = 1; $s <= $paket->hotelMekkah->bintang; $s++)
                                                <i class="fas fa-star text-warning fa-xs"></i>
                                            @endfor
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Hotel Madinah</th>
                                    <td>
                                        <i class="fas fa-hotel text-primary mr-2"></i>
                                        {{ $paket->hotelMadinah->nama_hotel ?? '-' }}
                                        @if ($paket->hotelMadinah ?? false)
                                            @for ($s = 1; $s <= $paket->hotelMadinah->bintang; $s++)
                                                <i class="fas fa-star text-warning fa-xs"></i>
                                            @endfor
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Kapasitas</th>
                                    <td>{{ $paket->kapasitas }} orang</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Include & Exclude --}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header bg-success text-white">
                                <h4 class="mb-0 text-white"><i class="fas fa-check-circle mr-2"></i>Include</h4>
                            </div>
                            <div class="card-body">
                                @if ($paket->include)
                                    @foreach (explode("\n", $paket->include) as $item)
                                        @if (trim($item))
                                            <div class="d-flex align-items-start mb-2">
                                                <i class="fas fa-check text-success mr-2 mt-1"></i>
                                                <span>{{ trim($item) }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <p class="text-muted mb-0">-</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card h-100">
                            <div class="card-header bg-danger text-white">
                                <h4 class="mb-0 text-white"><i class="fas fa-times-circle mr-2"></i>Exclude</h4>
                            </div>
                            <div class="card-body">
                                @if ($paket->exclude)
                                    @foreach (explode("\n", $paket->exclude) as $item)
                                        @if (trim($item))
                                            <div class="d-flex align-items-start mb-2">
                                                <i class="fas fa-times text-danger mr-2 mt-1"></i>
                                                <span>{{ trim($item) }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <p class="text-muted mb-0">-</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Itinerary --}}
                @if ($paket->itinerary)
                    <div class="card">
                        <div class="card-header">
                            <h4><i class="fas fa-route mr-2"></i>Itinerary</h4>
                        </div>
                        <div class="card-body">
                            <div style="white-space:pre-line">{{ $paket->itinerary }}</div>
                        </div>
                    </div>
                @endif

                {{-- Daftar Keberangkatan --}}
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-plane-departure mr-2"></i>Jadwal Keberangkatan</h4>
                        <div class="card-header-action">
                            <span class="badge badge-primary">{{ $paket->keberangkatans->count() }} jadwal</span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Kode</th>
                                        <th>Tgl Berangkat</th>
                                        <th>Tgl Pulang</th>
                                        <th>Kuota</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($paket->keberangkatans as $i => $kbr)
                                        @php
                                            $kc = match ($kbr->status) {
                                                'open' => 'success',
                                                'closed' => 'warning',
                                                'berangkat' => 'primary',
                                                'selesai' => 'info',
                                                'batal' => 'danger',
                                                default => 'secondary',
                                            };
                                        @endphp
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td><code>{{ $kbr->kode_keberangkatan }}</code></td>
                                            <td>{{ \Carbon\Carbon::parse($kbr->tanggal_berangkat)->format('d M Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($kbr->tanggal_pulang)->format('d M Y') }}</td>
                                            <td>{{ $kbr->kuota }} pax</td>
                                            <td><span
                                                    class="badge badge-{{ $kc }}">{{ ucfirst($kbr->status) }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.keberangkatan.show', $kbr) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-3">Belum ada jadwal
                                                keberangkatan</td>
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
