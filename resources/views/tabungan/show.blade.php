@extends('layouts.app')

@section('title', 'Detail Tabungan')
@section('page-title', 'Detail Tabungan')

@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.tabungan.index') }}">Data Tabungan</a></div>
    <div class="breadcrumb-item active">Detail</div>
@endsection

@section('content')
    <div class="section-body">
        <div class="row">

            {{-- ── Kolom Kiri ── --}}
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body text-center pt-4">
                        @php
                            $statusColor =
                                ['aktif' => 'success', 'selesai' => 'primary', 'batal' => 'danger'][
                                    $tabungan->status
                                ] ?? 'secondary';
                            $jenisColor = ['umroh' => 'warning', 'haji' => 'success'][$tabungan->jenis] ?? 'secondary';
                            $persen =
                                $tabungan->target_tabungan > 0
                                    ? min(100, round(($tabungan->saldo / $tabungan->target_tabungan) * 100))
                                    : 0;
                        @endphp
                        <div class="rounded-circle bg-{{ $jenisColor }} d-inline-flex align-items-center justify-content-center mb-3"
                            style="width:100px;height:100px;">
                            <i class="fas fa-piggy-bank text-white" style="font-size:2rem;"></i>
                        </div>
                        <h5 class="font-weight-bold mb-1">{{ $tabungan->jamaah->nama_lengkap ?? '-' }}</h5>
                        <p class="text-muted mb-1"><code>{{ $tabungan->no_rekening_tabungan }}</code></p>
                        <span class="badge badge-{{ $jenisColor }}">{{ ucfirst($tabungan->jenis) }}</span>
                        <br><br>
                        <span class="badge badge-{{ $statusColor }} badge-lg px-3 py-2">
                            <i class="fas fa-circle fa-xs mr-1"></i>{{ ucfirst($tabungan->status) }}
                        </span>
                        <div class="mt-3 px-3">
                            <small class="text-muted d-block mb-1">Progress: {{ $persen }}%</small>
                            <div class="progress" style="height:10px;">
                                <div class="progress-bar bg-{{ $jenisColor }}" style="width:{{ $persen }}%"></div>
                            </div>
                            <small class="text-muted">
                                Rp {{ number_format($tabungan->saldo, 0, ',', '.') }}
                                / Rp {{ number_format($tabungan->target_tabungan, 0, ',', '.') }}
                            </small>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('admin.tabungan.edit', $tabungan) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.setoran.create', ['tabungan_id' => $tabungan->id]) }}"
                            class="btn btn-success btn-sm">
                            <i class="fas fa-plus mr-1"></i> Setor
                        </a>
                        <a href="{{ route('admin.tabungan.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <a href="{{ route('admin.tabungan.cetak-mutasi', $tabungan) }}" target="_blank"
                            class="btn btn-primary btn-sm">
                            <i class="fas fa-print mr-1"></i> Cetak Mutasi
                        </a>
                    </div>
                </div>

                {{-- ── Ringkasan Setoran ── --}}
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-chart-pie mr-2"></i>Ringkasan</h4>
                    </div>
                    <div class="card-body p-0">
                        @php
                            $totalSetor = $tabungan->setorans
                                ->where('jenis', 'setor')
                                ->where('status', 'diterima')
                                ->sum('jumlah_setor');
                            $totalTarik = $tabungan->setorans
                                ->where('jenis', 'tarik')
                                ->where('status', 'diterima')
                                ->sum('jumlah_setor');
                            $totalPending = $tabungan->setorans->where('status', 'pending')->sum('jumlah_setor');
                        @endphp
                        <table class="table table-sm mb-0">
                            <tr>
                                <td class="pl-3 text-muted">Total Setoran Masuk</td>
                                <td class="text-right pr-3 text-success font-weight-bold">
                                    Rp {{ number_format($totalSetor, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pl-3 text-muted">Total Penarikan</td>
                                <td class="text-right pr-3 text-danger font-weight-bold">
                                    Rp {{ number_format($totalTarik, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="pl-3 text-muted">Menunggu Konfirmasi</td>
                                <td class="text-right pr-3 text-warning font-weight-bold">
                                    Rp {{ number_format($totalPending, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr class="table-light">
                                <td class="pl-3 font-weight-bold">Saldo Aktif</td>
                                <td class="text-right pr-3 text-primary font-weight-bold">
                                    Rp {{ number_format($tabungan->saldo, 0, ',', '.') }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ── Kolom Kanan ── --}}
            <div class="col-lg-8">

                {{-- Info Tabungan --}}
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-piggy-bank mr-2"></i>Informasi Tabungan</h4>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <th width="35%" class="bg-light">No. Rekening</th>
                                    <td><code>{{ $tabungan->no_rekening_tabungan }}</code></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Jamaah</th>
                                    <td>{{ $tabungan->jamaah->nama_lengkap ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Jenis</th>
                                    <td><span
                                            class="badge badge-{{ $jenisColor }}">{{ ucfirst($tabungan->jenis) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Saldo</th>
                                    <td><strong class="text-success">Rp
                                            {{ number_format($tabungan->saldo, 0, ',', '.') }}</strong></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Target Tabungan</th>
                                    <td><strong class="text-primary">Rp
                                            {{ number_format($tabungan->target_tabungan, 0, ',', '.') }}</strong></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Kekurangan</th>
                                    <td>
                                        @php $sisa = $tabungan->target_tabungan - $tabungan->saldo; @endphp
                                        <span class="{{ $sisa > 0 ? 'text-danger' : 'text-success' }} font-weight-bold">
                                            {{ $sisa > 0 ? 'Rp ' . number_format($sisa, 0, ',', '.') : 'Target Terpenuhi ✓' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Tanggal Buka</th>
                                    <td>{{ \Carbon\Carbon::parse($tabungan->tanggal_buka)->translatedFormat('d F Y') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Tanggal Target</th>
                                    <td>{{ $tabungan->tanggal_target ? \Carbon\Carbon::parse($tabungan->tanggal_target)->translatedFormat('d F Y') : '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Status</th>
                                    <td><span
                                            class="badge badge-{{ $statusColor }}">{{ ucfirst($tabungan->status) }}</span>
                                    </td>
                                </tr>
                                @if ($tabungan->catatan)
                                    <tr>
                                        <th class="bg-light">Catatan</th>
                                        <td>{{ $tabungan->catatan }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ── Riwayat Setoran (dengan kolom Kolektor & Tanggal Input) ── --}}
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="fas fa-history mr-2"></i>Riwayat Setoran</h4>
                        <a href="{{ route('admin.setoran.create', ['tabungan_id' => $tabungan->id]) }}"
                            class="btn btn-success btn-sm">
                            <i class="fas fa-plus mr-1"></i> Tambah Setoran
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>No. Setoran</th>
                                        <th>Jenis</th>
                                        <th>Jumlah</th>
                                        <th>Metode</th>
                                        <th>Kolektor</th>
                                        <th>Tanggal Setor</th>
                                        <th>Tgl. Input</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($tabungan->setorans->sortByDesc('tanggal_setor') as $i => $s)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td><code style="font-size:11px;">{{ $s->no_setoran }}</code></td>
                                            <td>
                                                <span
                                                    class="badge badge-{{ $s->jenis === 'setor' ? 'success' : 'danger' }}">
                                                    {{ $s->jenis === 'setor' ? 'Setoran' : 'Penarikan' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="{{ $s->jenis === 'setor' ? 'text-success' : 'text-danger' }} font-weight-bold">
                                                    {{ $s->jenis === 'tarik' ? '-' : '+' }}Rp
                                                    {{ number_format($s->jumlah_setor, 0, ',', '.') }}
                                                </span>
                                            </td>
                                            <td>{{ ucfirst($s->metode) }}</td>
                                            {{-- ── KOLOM KOLEKTOR ── --}}
                                            <td>
                                                @if ($s->karyawan)
                                                    <span class="badge badge-info">
                                                        <i class="fas fa-user mr-1"></i>{{ $s->karyawan->nama_lengkap }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            {{-- ── TANGGAL SETOR (dicatat kolektor) ── --}}
                                            <td>{{ \Carbon\Carbon::parse($s->tanggal_setor)->format('d/m/Y') }}</td>
                                            {{-- ── TANGGAL INPUT (dicatat sistem) ── --}}
                                            <td>
                                                <small class="text-muted">
                                                    {{ $s->created_at->format('d/m/Y H:i') }}
                                                </small>
                                            </td>
                                            <td>
                                                @php
                                                    $sc =
                                                        [
                                                            'diterima' => 'success',
                                                            'pending' => 'warning',
                                                            'ditolak' => 'danger',
                                                        ][$s->status] ?? 'secondary';
                                                @endphp
                                                <span
                                                    class="badge badge-{{ $sc }}">{{ ucfirst($s->status) }}</span>
                                            </td>
                                            <td>
                                                {{-- Konfirmasi setoran pending --}}
                                                @if ($s->status === 'pending')
                                                    <form action="{{ route('admin.setoran.konfirmasi', $s) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf @method('PATCH')
                                                        <button class="btn btn-xs btn-success" title="Konfirmasi">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.setoran.tolak', $s) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf @method('PATCH')
                                                        <button class="btn btn-xs btn-danger" title="Tolak">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                @if ($s->bukti_setor)
                                                    <a href="{{ asset('storage/' . $s->bukti_setor) }}" target="_blank"
                                                        class="btn btn-xs btn-info" title="Lihat Bukti">
                                                        <i class="fas fa-image"></i>
                                                    </a>
                                                @endif
                                                <form action="{{ route('admin.setoran.destroy', $s) }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Yakin hapus setoran ini? Saldo akan disesuaikan.')">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-xs btn-danger" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center text-muted py-4">
                                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                                Belum ada riwayat setoran
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                @if ($tabungan->setorans->count() > 0)
                                    <tfoot class="table-light">
                                        <tr>
                                            <td colspan="3" class="text-right font-weight-bold">Total Setoran Diterima:
                                            </td>
                                            <td class="text-success font-weight-bold">
                                                Rp {{ number_format($totalSetor, 0, ',', '.') }}
                                            </td>
                                            <td colspan="6"></td>
                                        </tr>
                                    </tfoot>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
