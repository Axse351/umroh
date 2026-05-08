@extends('layouts.app')

@section('title', 'Detail Setoran')
@section('page-title', 'Detail Setoran')

@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.setoran.index') }}">Data Setoran</a></div>
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
                            $isSetor = $setoran->jenis === 'setor';
                        @endphp
                        <div class="rounded-circle bg-{{ $isSetor ? 'success' : 'danger' }} d-inline-flex align-items-center justify-content-center mb-3"
                            style="width:100px;height:100px;">
                            <i class="fas fa-{{ $isSetor ? 'arrow-down' : 'arrow-up' }} text-white"
                                style="font-size:2rem;"></i>
                        </div>
                        <h5 class="font-weight-bold mb-1">{{ $setoran->no_setoran }}</h5>
                        <p class="text-muted mb-2">{{ $setoran->tabungan->jamaah->nama_lengkap ?? '-' }}</p>
                        <span class="badge badge-{{ $isSetor ? 'success' : 'danger' }} badge-lg px-3 py-2">
                            {{ $isSetor ? 'Setoran Masuk' : 'Penarikan' }}
                        </span>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('admin.setoran.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                {{-- Bukti Setor --}}
                @if ($setoran->bukti_setor)
                    <div class="card">
                        <div class="card-header">
                            <h4>Bukti Setoran</h4>
                        </div>
                        <div class="card-body text-center">
                            <a href="{{ asset('storage/' . $setoran->bukti_setor) }}" target="_blank">
                                <img src="{{ asset('storage/' . $setoran->bukti_setor) }}" class="img-fluid rounded"
                                    style="max-height:220px;">
                            </a>
                            <div class="mt-2">
                                <a href="{{ asset('storage/' . $setoran->bukti_setor) }}" target="_blank"
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
                        <h4><i class="fas fa-coins mr-2"></i>Informasi Setoran</h4>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <th width="35%" class="bg-light">No. Setoran</th>
                                    <td><code>{{ $setoran->no_setoran }}</code></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Jamaah</th>
                                    <td>{{ $setoran->tabungan->jamaah->nama_lengkap ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">No. Rekening</th>
                                    <td><code>{{ $setoran->tabungan->no_rekening_tabungan ?? '-' }}</code></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Jenis</th>
                                    <td>
                                        <span class="badge badge-{{ $isSetor ? 'success' : 'danger' }}">
                                            {{ $isSetor ? 'Setoran Masuk' : 'Penarikan' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Jumlah</th>
                                    <td>
                                        <strong class="{{ $isSetor ? 'text-success' : 'text-danger' }}">
                                            {{ $isSetor ? '+' : '-' }}Rp
                                            {{ number_format($setoran->jumlah_setor, 0, ',', '.') }}
                                        </strong>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Metode</th>
                                    <td>{{ ucfirst($setoran->metode) }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Tanggal Setor</th>
                                    <td>{{ \Carbon\Carbon::parse($setoran->tanggal_setor)->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Dicatat Oleh</th>
                                    <td>{{ $setoran->karyawan->nama_lengkap ?? '-' }}</td>
                                </tr>
                                @if ($setoran->catatan)
                                    <tr>
                                        <th class="bg-light">Catatan</th>
                                        <td>{{ $setoran->catatan }}</td>
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
