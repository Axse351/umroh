@extends('layouts.app')
@section('title', 'Data Setoran')
@section('page-title', 'Data Setoran')

@section('breadcrumb')
    <div class="breadcrumb-item active">Data Setoran</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">

            {{-- ── Alert Pending ─────────────────────────────────────────── --}}
            @php $pendingCount = \App\Models\Setoran::where('status','pending')->count(); @endphp
            @if ($pendingCount > 0)
                <div class="alert alert-warning alert-dismissible fade show mb-3" role="alert">
                    <i class="fas fa-hourglass-half mr-2"></i>
                    Ada <strong>{{ $pendingCount }} setoran</strong> menunggu konfirmasi admin.
                    <a href="{{ route('admin.setoran.index', ['status' => 'pending']) }}" class="font-weight-bold ml-2">Lihat
                        sekarang →</a>
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            @endif

            {{-- ── Rekap Kolektor ─────────────────────────────────────────── --}}
            @if ($kolektors->count())
                @php
                    $grandTotal = \App\Models\Setoran::where('status', 'diterima')
                        ->where('jenis', 'setor')
                        ->sum('jumlah_setor');
                    $grandTrx = \App\Models\Setoran::count();
                    $colors = [
                        ['bg' => '#fde8e8', 'color' => '#e74c3c'],
                        ['bg' => '#e8f4fd', 'color' => '#3498db'],
                        ['bg' => '#e8fdf0', 'color' => '#2ecc71'],
                        ['bg' => '#fdf6e8', 'color' => '#f39c12'],
                        ['bg' => '#f3e8fd', 'color' => '#9b59b6'],
                        ['bg' => '#e8fdfc', 'color' => '#1abc9c'],
                        ['bg' => '#fde8f8', 'color' => '#e91e8c'],
                        ['bg' => '#e8eafd', 'color' => '#5c6bc0'],
                        ['bg' => '#fdf0e8', 'color' => '#e67e22'],
                        ['bg' => '#e8fde8', 'color' => '#27ae60'],
                    ];
                @endphp
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center py-2">
                        <h6 class="mb-0 font-weight-bold">
                            <i class="fas fa-users text-primary mr-2"></i>Rekap Per Kolektor
                        </h6>
                        <small class="text-muted">{{ $kolektors->count() }} kolektor aktif &nbsp;· geser →</small>
                    </div>
                    <div class="card-body py-3">
                        <div style="display:flex;gap:10px;overflow-x:auto;padding-bottom:6px;">

                            {{-- Kartu Semua --}}
                            <a href="{{ route('admin.setoran.index', request()->except('kolektor_id', 'page')) }}"
                                style="flex:0 0 175px;text-decoration:none;background:linear-gradient(135deg,#3abaf4,#1d90d8);border-radius:12px;border:none;padding:12px 14px;display:flex;align-items:center;gap:10px;box-shadow:0 2px 8px rgba(29,144,216,.3);">
                                <div
                                    style="width:36px;height:36px;border-radius:50%;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;color:#fff;font-size:14px;">
                                    <i class="fas fa-layer-group"></i>
                                </div>
                                <div style="min-width:0;flex:1;">
                                    <div style="font-size:11px;font-weight:600;color:rgba(255,255,255,.85);">Semua Kolektor
                                    </div>
                                    <div style="font-size:13px;font-weight:700;color:#fff;line-height:1.3;">Rp
                                        {{ number_format($grandTotal, 0, ',', '.') }}</div>
                                    <div style="font-size:10px;color:rgba(255,255,255,.7);">{{ number_format($grandTrx) }}
                                        transaksi</div>
                                </div>
                            </a>

                            @foreach ($kolektors as $idx => $kol)
                                @php
                                    $tKol = \App\Models\Setoran::where('karyawan_id', $kol->id)
                                        ->where('status', 'diterima')
                                        ->where('jenis', 'setor')
                                        ->sum('jumlah_setor');
                                    $jKol = \App\Models\Setoran::where('karyawan_id', $kol->id)->count();
                                    $pKol = \App\Models\Setoran::where('karyawan_id', $kol->id)
                                        ->where('status', 'pending')
                                        ->count();
                                    $ini = collect(explode(' ', $kol->nama_lengkap))
                                        ->take(2)
                                        ->map(fn($w) => strtoupper(substr($w, 0, 1)))
                                        ->implode('');
                                    $c = $colors[$idx % 10];
                                    $act = (string) request('kolektor_id') === (string) $kol->id;
                                    $prm = array_merge(request()->except('kolektor_id', 'page'), [
                                        'kolektor_id' => $kol->id,
                                    ]);
                                @endphp
                                <a href="{{ route('admin.setoran.index', $prm) }}"
                                    style="flex:0 0 175px;text-decoration:none;background:{{ $act ? '#f0faff' : '#fff' }};border-radius:12px;border:{{ $act ? '2px solid #3abaf4' : '1.5px solid #e9ecef' }};padding:12px 14px;display:flex;align-items:center;gap:10px;"
                                    title="{{ $kol->nama_lengkap }}">
                                    <div
                                        style="width:36px;height:36px;border-radius:50%;background:{{ $c['bg'] }};color:{{ $c['color'] }};display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:12px;font-weight:700;">
                                        {{ $ini }}
                                    </div>
                                    <div style="min-width:0;flex:1;">
                                        <div
                                            style="font-size:11px;font-weight:600;color:#495057;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                            {{ $kol->nama_lengkap }}</div>
                                        <div style="font-size:13px;font-weight:700;color:#212529;line-height:1.3;">Rp
                                            {{ number_format($tKol, 0, ',', '.') }}</div>
                                        <div style="font-size:10px;color:#adb5bd;">
                                            {{ $jKol }} transaksi
                                            @if ($pKol > 0)
                                                &nbsp;·&nbsp;<span
                                                    style="color:#ffa426;font-weight:600;">{{ $pKol }}
                                                    pending</span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endforeach

                        </div>
                    </div>
                </div>
            @endif

            {{-- ── Tabel Setoran ─────────────────────────────────────────── --}}
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap:8px;">
                        <h4 class="mb-0">
                            <i class="fas fa-list-alt mr-2"></i>Daftar Setoran
                        </h4>
                        <div class="d-flex flex-wrap align-items-center" style="gap:6px;">
                            <form method="GET" class="d-flex flex-wrap align-items-center" style="gap:6px;">
                                @if (request('kolektor_id'))
                                    <input type="hidden" name="kolektor_id" value="{{ request('kolektor_id') }}">
                                @endif
                                <select name="jenis" class="form-control form-control-sm" style="width:120px;">
                                    <option value="">Semua Jenis</option>
                                    <option value="umroh" {{ request('jenis') == 'umroh' ? 'selected' : '' }}>Umroh</option>
                                    <option value="haji" {{ request('jenis') == 'haji' ? 'selected' : '' }}>Haji</option>
                                </select>
                                <select name="status" class="form-control form-control-sm" style="width:130px;">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima
                                    </option>
                                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak
                                    </option>
                                </select>
                                <select name="kolektor_id" class="form-control form-control-sm" style="width:140px;">
                                    <option value="">Semua Kolektor</option>
                                    @foreach ($kolektors as $kol)
                                        <option value="{{ $kol->id }}"
                                            {{ request('kolektor_id') == $kol->id ? 'selected' : '' }}>
                                            {{ $kol->nama_lengkap }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-search"></i>
                                </button>
                                @if (request()->hasAny(['jenis', 'status', 'kolektor_id']))
                                    <a href="{{ route('admin.setoran.index') }}" class="btn btn-outline-secondary btn-sm"
                                        title="Reset">
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif
                            </form>
                            <a href="{{ route('admin.setoran.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus mr-1"></i> Tambah Setoran
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0" style="font-size:13px;">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="40">No</th>
                                    <th>No. Setoran</th>
                                    <th>Jamaah</th>
                                    <th>No. Rekening</th>
                                    <th>Jenis</th>
                                    <th>Metode</th>
                                    <th>Jumlah</th>
                                    <th>Kolektor</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($setorans as $i => $s)
                                    @php
                                        $jamaahNama = $s->tabungan->jamaah->nama_lengkap ?? '-';
                                        $jumlahFmt = 'Rp ' . number_format($s->jumlah_setor, 0, ',', '.');
                                        $kolektorNama = $s->karyawan->nama_lengkap ?? 'Admin Langsung';
                                    @endphp
                                    <tr
                                        style="{{ $s->status === 'pending' ? 'background:#fffbf0;border-left:3px solid #ffa426;' : '' }}">
                                        <td>{{ $setorans->firstItem() + $i }}</td>
                                        <td>
                                            <small style="color:#6c757d;font-family:monospace;font-weight:600;">
                                                {{ $s->no_setoran }}
                                            </small>
                                        </td>
                                        <td><strong>{{ $jamaahNama }}</strong></td>
                                        <td><small
                                                class="text-muted">{{ $s->tabungan->no_rekening_tabungan ?? '-' }}</small>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $s->jenis == 'setor' ? 'success' : 'danger' }}">
                                                {{ $s->jenis == 'setor' ? 'Setoran' : 'Penarikan' }}
                                            </span>
                                        </td>
                                        <td>{{ ucfirst($s->metode) }}</td>
                                        <td>
                                            <strong class="{{ $s->jenis == 'setor' ? 'text-success' : 'text-danger' }}">
                                                {{ $s->jenis == 'tarik' ? '−' : '+' }} {{ $jumlahFmt }}
                                            </strong>
                                        </td>
                                        <td>
                                            @if ($s->karyawan)
                                                @php
                                                    $idx2 = $kolektors->search(fn($k) => $k->id === $s->karyawan->id);
                                                    $c2 = $colors[($idx2 !== false ? $idx2 : 0) % 10];
                                                    $kin = collect(explode(' ', $s->karyawan->nama_lengkap))
                                                        ->take(2)
                                                        ->map(fn($w) => strtoupper(substr($w, 0, 1)))
                                                        ->implode('');
                                                @endphp
                                                <span
                                                    style="display:inline-flex;align-items:center;gap:5px;background:#e8f4fd;color:#1d6fa4;border-radius:20px;padding:3px 10px;font-size:11px;font-weight:600;">
                                                    <span
                                                        style="width:17px;height:17px;border-radius:50%;background:{{ $c2['bg'] }};color:{{ $c2['color'] }};display:inline-flex;align-items:center;justify-content:center;font-size:8px;font-weight:700;">{{ $kin }}</span>
                                                    {{ $s->karyawan->nama_lengkap }}
                                                </span>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($s->tanggal_setor)->format('d/m/Y') }}</td>
                                        <td>
                                            @if ($s->status === 'pending')
                                                <span class="badge badge-warning">
                                                    <i class="fas fa-hourglass-half mr-1"></i>Pending
                                                </span>
                                            @elseif($s->status === 'diterima')
                                                <span class="badge badge-success">
                                                    <i class="fas fa-check-circle mr-1"></i>Diterima
                                                </span>
                                            @else
                                                <span class="badge badge-danger">
                                                    <i class="fas fa-times-circle mr-1"></i>Ditolak
                                                </span>
                                            @endif
                                        </td>
                                        <td style="white-space:nowrap;">
                                            @if ($s->status === 'pending')
                                                <button type="button" class="btn btn-success btn-sm btn-acc"
                                                    data-url="{{ route('admin.setoran.konfirmasi', $s) }}"
                                                    data-no="{{ $s->no_setoran }}" data-jamaah="{{ $jamaahNama }}"
                                                    data-jumlah="{{ $jumlahFmt }}"
                                                    data-kolektor="{{ $kolektorNama }}">
                                                    <i class="fas fa-check mr-1"></i>ACC
                                                </button>
                                                <button type="button" class="btn btn-warning btn-sm btn-tolak"
                                                    data-url="{{ route('admin.setoran.tolak', $s) }}"
                                                    data-no="{{ $s->no_setoran }}">
                                                    <i class="fas fa-times mr-1"></i>Tolak
                                                </button>
                                            @endif
                                            <a href="{{ route('admin.setoran.show', $s) }}" class="btn btn-info btn-sm"
                                                title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm btn-hapus"
                                                data-url="{{ route('admin.setoran.destroy', $s) }}"
                                                data-no="{{ $s->no_setoran }}" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center py-5 text-muted">
                                            <i class="fas fa-inbox fa-3x d-block mb-3" style="opacity:.2;"></i>
                                            Tidak ada data setoran
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($setorans->hasPages())
                    <div class="card-footer d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            Menampilkan {{ $setorans->firstItem() }}–{{ $setorans->lastItem() }}
                            dari {{ $setorans->total() }} data
                        </small>
                        {{ $setorans->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>

    {{-- Form aksi tersembunyi — diisi via JS --}}
    <form id="form-aksi" method="POST" style="display:none;">
        @csrf
        <input type="hidden" name="_method" id="form-method" value="PATCH">
    </form>

@endsection

{{-- ✅ @push('scripts') — jalan SETELAH jQuery dimuat oleh Stisla --}}
@push('scripts')
    <script>
        $(function() {

            // ── ACC ───────────────────────────────────────────────────────────────────
            $(document).on('click', '.btn-acc', function() {
                var d = $(this).data();
                var msg = 'ACC setoran ini?\n\n' +
                    'No Setoran : ' + d.no + '\n' +
                    'Jamaah     : ' + d.jamaah + '\n' +
                    'Jumlah     : ' + d.jumlah + '\n' +
                    'Kolektor   : ' + d.kolektor + '\n\n' +
                    'Saldo tabungan akan otomatis bertambah.';

                if (!confirm(msg)) return;

                $('#form-aksi').attr('action', d.url);
                $('#form-method').val('PATCH');
                $('#form-aksi').submit();
            });

            // ── Tolak ─────────────────────────────────────────────────────────────────
            $(document).on('click', '.btn-tolak', function() {
                var d = $(this).data();
                if (!confirm('Tolak setoran ' + d.no + '?\nSaldo tidak akan berubah.')) return;

                $('#form-aksi').attr('action', d.url);
                $('#form-method').val('PATCH');
                $('#form-aksi').submit();
            });

            // ── Hapus ──────────────────────────────────────────────────────────────────
            $(document).on('click', '.btn-hapus', function() {
                var d = $(this).data();
                if (!confirm('Hapus setoran ' + d.no +
                        '?\nJika statusnya Diterima, saldo akan di-rollback.')) return;

                $('#form-aksi').attr('action', d.url);
                $('#form-method').val('DELETE');
                $('#form-aksi').submit();
            });

        });
    </script>
@endpush
