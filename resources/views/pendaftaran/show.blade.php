@extends('layouts.app')
@section('title', 'Detail Pendaftaran - ' . $pendaftaran->no_pendaftaran)
@section('page-title', 'Detail Pendaftaran')

@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.pendaftaran.index') }}">Data Pendaftaran</a></div>
    <div class="breadcrumb-item active">{{ $pendaftaran->no_pendaftaran }}</div>
@endsection

@section('content')
    @php
        $colors = [
            'draft' => 'secondary',
            'konfirmasi' => 'info',
            'dp_terbayar' => 'primary',
            'lunas' => 'success',
            'berangkat' => 'dark',
            'selesai' => 'success',
            'batal' => 'danger',
            'refund' => 'warning',
        ];
        $statusColor = $colors[$pendaftaran->status] ?? 'secondary';
        $persen =
            $pendaftaran->harga_jual > 0
                ? min(100, round(($pendaftaran->total_bayar / $pendaftaran->harga_jual) * 100))
                : 0;

        // Cek tabungan aktif milik jamaah ini
        $adaTabungan = \App\Models\Tabungan::where('jamaah_id', $pendaftaran->jamaah_id)
            ->where('status', 'aktif')
            ->where('saldo', '>', 0)
            ->exists();

        $bolehGunakanTabungan =
            !$pendaftaran->is_lunas && !in_array($pendaftaran->status, ['batal', 'refund', 'selesai']);
    @endphp

    {{-- ===== HEADER ACTION BAR ===== --}}
    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <a href="{{ route('admin.pendaftaran.index') }}" class="btn btn-sm btn-light mr-1">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
                <a href="{{ route('admin.pendaftaran.edit', $pendaftaran) }}" class="btn btn-sm btn-warning mr-1">
                    <i class="fas fa-edit mr-1"></i> Edit
                </a>

                {{-- ── TOMBOL GUNAKAN TABUNGAN ─────────────────────────── --}}
                @if ($bolehGunakanTabungan)
                    @if ($adaTabungan)
                        <a href="{{ route('admin.pendaftaran.gunakan-tabungan', $pendaftaran) }}"
                            class="btn btn-sm btn-success mr-1"
                            title="Gunakan saldo tabungan jamaah untuk membayar pendaftaran ini">
                            <i class="fas fa-piggy-bank mr-1"></i> Gunakan Tabungan
                        </a>
                    @else
                        <button type="button" class="btn btn-sm btn-outline-secondary mr-1" disabled
                            title="Jamaah belum memiliki tabungan aktif dengan saldo">
                            <i class="fas fa-piggy-bank mr-1"></i> Gunakan Tabungan
                        </button>
                    @endif
                @endif
                {{-- ── END TOMBOL GUNAKAN TABUNGAN ─────────────────────── --}}

                <a href="{{ route('admin.pembayaran.create', ['pendaftaran_id' => $pendaftaran->id]) }}"
                    class="btn btn-sm btn-primary mr-1">
                    <i class="fas fa-plus mr-1"></i> Tambah Pembayaran
                </a>

                <a href="{{ route('admin.pendaftaran.cetak-mutasi', $pendaftaran) }}"
                    class="btn btn-sm btn-light border mr-1" target="_blank">
                    <i class="fas fa-print mr-1"></i> Cetak Mutasi
                </a>

                <form action="{{ route('admin.pendaftaran.destroy', $pendaftaran) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Yakin ingin menghapus pendaftaran ini?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash mr-1"></i> Hapus</button>
                </form>
            </div>

            {{-- Ubah Status Cepat --}}
            <form action="{{ route('admin.pendaftaran.update-status', $pendaftaran) }}" method="POST" class="form-inline">
                @csrf @method('PATCH')
                <select name="status" class="form-control form-control-sm mr-1">
                    @foreach (['draft', 'konfirmasi', 'dp_terbayar', 'lunas', 'berangkat', 'selesai', 'batal', 'refund'] as $s)
                        <option value="{{ $s }}" {{ $pendaftaran->status == $s ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $s)) }}
                        </option>
                    @endforeach
                </select>
                <button class="btn btn-sm btn-primary"><i class="fas fa-sync-alt mr-1"></i> Update Status</button>
            </form>
        </div>
    </div>

    {{-- ===== BARIS ATAS: INFO UTAMA + RINGKASAN KEUANGAN ===== --}}
    <div class="row">

        {{-- Kartu Info Pendaftaran --}}
        <div class="col-lg-8 col-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-file-alt mr-2 text-primary"></i>
                        Informasi Pendaftaran
                    </h5>
                    <span class="badge badge-{{ $statusColor }} px-3 py-2" style="font-size:.85rem;">
                        {{ ucfirst(str_replace('_', ' ', $pendaftaran->status)) }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless mb-0">
                                <tr>
                                    <td class="text-muted" style="width:45%">No. Pendaftaran</td>
                                    <td><strong>{{ $pendaftaran->no_pendaftaran }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Jenis</td>
                                    <td>
                                        <span
                                            class="badge badge-{{ $pendaftaran->jenis == 'umroh' ? 'primary' : 'success' }}">
                                            {{ ucfirst(str_replace('_', ' ', $pendaftaran->jenis)) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Tipe Kamar</td>
                                    <td><span
                                            class="badge badge-light text-dark border">{{ ucfirst($pendaftaran->tipe_kamar) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Tgl. Daftar</td>
                                    <td>{{ \Carbon\Carbon::parse($pendaftaran->tanggal_daftar)->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Batas Lunas</td>
                                    <td>
                                        @if ($pendaftaran->batas_pelunasan)
                                            {{ \Carbon\Carbon::parse($pendaftaran->batas_pelunasan)->format('d M Y') }}
                                            @if (
                                                \Carbon\Carbon::parse($pendaftaran->batas_pelunasan)->isPast() &&
                                                    !in_array($pendaftaran->status, ['lunas', 'berangkat', 'selesai']))
                                                <span class="badge badge-danger ml-1">Lewat</span>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless mb-0">
                                <tr>
                                    <td class="text-muted" style="width:45%">Paket</td>
                                    <td><strong>{{ $pendaftaran->keberangkatan->paket->nama_paket ?? '-' }}</strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Tgl. Berangkat</td>
                                    <td>{{ $pendaftaran->keberangkatan->tanggal_berangkat?->format('d M Y') ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Agent</td>
                                    <td>{{ $pendaftaran->agent->nama_agent ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Marketing</td>
                                    <td>{{ $pendaftaran->karyawan->nama_lengkap ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if ($pendaftaran->catatan)
                        <hr>
                        <div class="alert alert-light border mb-0">
                            <small class="text-muted d-block mb-1"><i class="fas fa-sticky-note mr-1"></i> Catatan</small>
                            {{ $pendaftaran->catatan }}
                        </div>
                    @endif
                </div>
            </div>

            {{-- Data Jamaah --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-user mr-2 text-success"></i> Data Jamaah</h5>
                    {{-- Info tabungan jamaah --}}
                    @php
                        $totalTabungan = \App\Models\Tabungan::where('jamaah_id', $pendaftaran->jamaah_id)
                            ->where('status', 'aktif')
                            ->sum('saldo');
                    @endphp
                    @if ($totalTabungan > 0)
                        <span class="badge badge-success px-2 py-1" title="Total saldo tabungan aktif jamaah ini">
                            <i class="fas fa-piggy-bank mr-1"></i>
                            Tabungan: Rp {{ number_format($totalTabungan, 0, ',', '.') }}
                        </span>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center mb-3 mb-md-0">
                            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center mx-auto"
                                style="width:64px;height:64px;font-size:1.6rem;">
                                {{ strtoupper(substr($pendaftaran->jamaah->nama_lengkap, 0, 1)) }}
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-sm table-borderless mb-0">
                                        <tr>
                                            <td class="text-muted" style="width:45%">Nama Lengkap</td>
                                            <td><strong>{{ $pendaftaran->jamaah->nama_lengkap }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">NIK</td>
                                            <td>{{ $pendaftaran->jamaah->nik ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Tgl. Lahir</td>
                                            <td>{{ $pendaftaran->jamaah->tanggal_lahir?->format('d M Y') ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Jenis Kelamin</td>
                                            <td>{{ $pendaftaran->jamaah->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-sm table-borderless mb-0">
                                        <tr>
                                            <td class="text-muted" style="width:45%">No. Telepon</td>
                                            <td>{{ $pendaftaran->jamaah->no_telepon ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Email</td>
                                            <td>{{ $pendaftaran->jamaah->email ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">No. Passport</td>
                                            <td>{{ $pendaftaran->jamaah->no_passport ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted">Alamat</td>
                                            <td>{{ $pendaftaran->jamaah->alamat ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Ringkasan Keuangan --}}
        <div class="col-lg-4 col-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-wallet mr-2 text-warning"></i> Ringkasan Keuangan</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Harga Jual</span>
                        <strong>Rp {{ number_format($pendaftaran->harga_jual, 0, ',', '.') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">DP Minimal</span>
                        <span>Rp {{ number_format($pendaftaran->dp_minimal, 0, ',', '.') }}</span>
                    </div>
                    <hr class="my-2">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Total Terbayar</span>
                        <span class="text-success font-weight-bold">Rp
                            {{ number_format($pendaftaran->total_bayar, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Sisa Tagihan</span>
                        <span
                            class="{{ $pendaftaran->sisa_tagihan > 0 ? 'text-danger' : 'text-success' }} font-weight-bold">
                            Rp {{ number_format($pendaftaran->sisa_tagihan, 0, ',', '.') }}
                        </span>
                    </div>

                    {{-- Progress Bar --}}
                    <div class="progress mb-1" style="height:12px;border-radius:6px;">
                        <div class="progress-bar bg-{{ $persen >= 100 ? 'success' : ($persen >= 50 ? 'primary' : 'warning') }}"
                            style="width:{{ $persen }}%;border-radius:6px;" role="progressbar">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <small class="text-muted">Pelunasan</small>
                        <small class="font-weight-bold">{{ $persen }}%</small>
                    </div>

                    {{-- ── TOMBOL GUNAKAN TABUNGAN (di dalam kartu keuangan) ── --}}
                    @if ($bolehGunakanTabungan)
                        <div class="mt-2">
                            @if ($adaTabungan)
                                <a href="{{ route('admin.pendaftaran.gunakan-tabungan', $pendaftaran) }}"
                                    class="btn btn-success btn-block">
                                    <i class="fas fa-piggy-bank mr-1"></i>
                                    Gunakan Tabungan
                                    @if ($totalTabungan > 0)
                                        <span class="d-block" style="font-size:.75rem;opacity:.85">
                                            Saldo: Rp {{ number_format($totalTabungan, 0, ',', '.') }}
                                        </span>
                                    @endif
                                </a>
                            @else
                                <div class="alert alert-light border text-center py-2 mb-0" style="font-size:.85rem;">
                                    <i class="fas fa-piggy-bank text-muted mr-1"></i>
                                    Belum ada tabungan aktif
                                    <a href="{{ route('admin.tabungan.create') }}?jamaah_id={{ $pendaftaran->jamaah_id }}"
                                        class="d-block mt-1">
                                        <small>+ Buat Tabungan Baru</small>
                                    </a>
                                </div>
                            @endif
                        </div>
                    @elseif ($pendaftaran->is_lunas)
                        <div class="alert alert-success text-center py-2 mb-0" style="font-size:.85rem;">
                            <i class="fas fa-check-circle mr-1"></i> Sudah Lunas
                        </div>
                    @endif
                    {{-- ── END TOMBOL GUNAKAN TABUNGAN ── --}}
                </div>
            </div>

            {{-- Dokumen --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-folder-open mr-2 text-info"></i> Dokumen</h5>
                    <span class="badge badge-info">{{ $pendaftaran->dokumens->count() }}</span>
                </div>
                <div class="card-body p-0">
                    @forelse($pendaftaran->dokumens as $dok)
                        <div class="d-flex align-items-center px-3 py-2 border-bottom">
                            <i class="fas fa-file-alt text-muted mr-2"></i>
                            <div class="flex-grow-1">
                                <div class="font-weight-bold" style="font-size:.875rem;">{{ $dok->nama_dokumen }}</div>
                                <small class="text-muted">{{ ucfirst($dok->jenis_dokumen) }}</small>
                            </div>
                            <div>
                                @if ($dok->status == 'lengkap')
                                    <span class="badge badge-success"><i class="fas fa-check"></i></span>
                                @elseif($dok->status == 'kurang')
                                    <span class="badge badge-warning">Kurang</span>
                                @else
                                    <span class="badge badge-secondary">Belum</span>
                                @endif
                                @if ($dok->file_path)
                                    <a href="{{ asset('storage/' . $dok->file_path) }}" target="_blank"
                                        class="btn btn-xs btn-light border ml-1">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-3"><small>Belum ada dokumen</small></div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- ===== PEMBAYARAN ===== --}}
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-money-bill-wave mr-2 text-success"></i>
                        Riwayat Pembayaran
                    </h5>
                    <div>
                        {{-- Tombol tambah pembayaran manual --}}
                        <a href="{{ route('admin.pembayaran.create', ['pendaftaran_id' => $pendaftaran->id]) }}"
                            class="btn btn-sm btn-success mr-1">
                            <i class="fas fa-plus mr-1"></i> Tambah Pembayaran
                        </a>
                        {{-- Tombol gunakan tabungan (shortcut di header tabel) --}}
                        @if ($bolehGunakanTabungan && $adaTabungan)
                            <a href="{{ route('admin.pendaftaran.gunakan-tabungan', $pendaftaran) }}"
                                class="btn btn-sm btn-outline-success">
                                <i class="fas fa-piggy-bank mr-1"></i> Dari Tabungan
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width:40px">#</th>
                                    <th>No. Pembayaran</th>
                                    <th>Tanggal</th>
                                    <th>Jenis</th>
                                    <th>Metode</th>
                                    <th class="text-right">Jumlah</th>
                                    <th>Status</th>
                                    <th>Bukti</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendaftaran->pembayarans->sortByDesc('tanggal_bayar') as $i => $bayar)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td style="font-size:.8rem">
                                            <strong>{{ $bayar->no_pembayaran }}</strong>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($bayar->tanggal_bayar)->format('d M Y') }}</td>
                                        <td>
                                            <span
                                                class="badge badge-{{ $bayar->jenis == 'dp' ? 'warning' : ($bayar->jenis == 'pelunasan' ? 'success' : 'info') }}">
                                                {{ strtoupper($bayar->jenis) }}
                                            </span>
                                            {{-- Badge jika dari tabungan --}}
                                            @if ($bayar->tabungan_id)
                                                <span class="badge badge-success ml-1"
                                                    title="Pembayaran dari tabungan {{ $bayar->tabungan->no_rekening_tabungan ?? '' }}">
                                                    <i class="fas fa-piggy-bank"></i>
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ ucfirst($bayar->metode_bayar ?? '-') }}</td>
                                        <td class="text-right text-success font-weight-bold">
                                            Rp {{ number_format($bayar->jumlah_bayar, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            @php
                                                $badgeBayar = [
                                                    'pending' => 'warning',
                                                    'verifikasi' => 'info',
                                                    'diterima' => 'success',
                                                    'ditolak' => 'danger',
                                                ];
                                            @endphp
                                            <span class="badge badge-{{ $badgeBayar[$bayar->status] ?? 'secondary' }}">
                                                {{ ucfirst($bayar->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($bayar->bukti_bayar)
                                                <a href="{{ asset('storage/' . $bayar->bukti_bayar) }}" target="_blank"
                                                    class="btn btn-xs btn-info">
                                                    <i class="fas fa-image"></i>
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($bayar->status === 'pending')
                                                <form action="{{ route('admin.pembayaran.verifikasi', $bayar) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf @method('PATCH')
                                                    <button class="btn btn-xs btn-success" title="Verifikasi"
                                                        onclick="return confirm('Verifikasi pembayaran ini?')">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.pembayaran.tolak', $bayar) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf @method('PATCH')
                                                    <button class="btn btn-xs btn-danger" title="Tolak"
                                                        onclick="return confirm('Tolak pembayaran ini?')">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted py-4">
                                            <i class="fas fa-inbox fa-2x d-block mb-2 text-muted"></i>
                                            Belum ada pembayaran
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            @if ($pendaftaran->pembayarans->count())
                                <tfoot>
                                    <tr class="table-light">
                                        <td colspan="5" class="text-right font-weight-bold">
                                            Total Diterima
                                        </td>
                                        <td class="text-right text-success font-weight-bold">
                                            Rp
                                            {{ number_format($pendaftaran->pembayarans->where('status', 'diterima')->sum('jumlah_bayar'), 0, ',', '.') }}
                                        </td>
                                        <td colspan="3"></td>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== LAYANAN TAMBAHAN + PENGELUARAN PRODUK ===== --}}
    <div class="row">

        {{-- Transaksi Layanan --}}
        <div class="col-lg-6 col-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-concierge-bell mr-2" style="color:#6f42c1"></i>
                        Layanan Tambahan
                    </h5>
                    <span class="badge badge-secondary">{{ $pendaftaran->transaksiLayanans->count() }} item</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Layanan</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-right">Harga</th>
                                    <th class="text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendaftaran->transaksiLayanans as $i => $tl)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $tl->layanan->nama_layanan ?? '-' }}</td>
                                        <td class="text-center">{{ $tl->qty ?? 1 }}</td>
                                        <td class="text-right">Rp {{ number_format($tl->harga, 0, ',', '.') }}</td>
                                        <td class="text-right font-weight-bold">
                                            Rp {{ number_format(($tl->qty ?? 1) * $tl->harga, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-3">
                                            <small>Tidak ada layanan tambahan</small>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            @if ($pendaftaran->transaksiLayanans->count())
                                <tfoot>
                                    <tr class="table-light">
                                        <td colspan="4" class="text-right font-weight-bold">Total</td>
                                        <td class="text-right font-weight-bold text-primary">
                                            Rp
                                            {{ number_format($pendaftaran->transaksiLayanans->sum(fn($tl) => ($tl->qty ?? 1) * $tl->harga), 0, ',', '.') }}
                                        </td>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pengeluaran Produk --}}
        <div class="col-lg-6 col-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-box mr-2 text-warning"></i> Pengeluaran Produk</h5>
                    <span class="badge badge-secondary">{{ $pendaftaran->pengeluaranProduks->count() }} item</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Produk</th>
                                    <th class="text-center">Qty</th>
                                    <th>Satuan</th>
                                    <th>Tgl. Keluar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendaftaran->pengeluaranProduks as $i => $pp)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $pp->produk->nama_produk ?? '-' }}</td>
                                        <td class="text-center">{{ $pp->qty }}</td>
                                        <td>{{ $pp->produk->satuan ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($pp->tanggal_keluar)->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-3">
                                            <small>Belum ada pengeluaran produk</small>
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

@endsection

@push('scripts')
    <script>
        // Auto-dismiss flash message setelah 4 detik
        setTimeout(() => {
            document.querySelectorAll('.alert-dismissible').forEach(el => {
                el.style.transition = 'opacity .5s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500);
            });
        }, 4000);
    </script>
@endpush
