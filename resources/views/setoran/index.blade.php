@extends('layouts.app')
@section('title', 'Data Setoran')
@section('page-title', 'Data Setoran')
@section('breadcrumb')
    <div class="breadcrumb-item active">Data Setoran</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">

            {{-- ── Rekap Per Kolektor ── --}}
            @if ($kolektors->count())
                <div class="row mb-3">
                    @foreach ($kolektors as $kol)
                        @php
                            $totalKol = \App\Models\Setoran::where('karyawan_id', $kol->id)
                                ->where('status', 'diterima')
                                ->where('jenis', 'setor')
                                ->sum('jumlah_setor');
                            $jmlKol = \App\Models\Setoran::where('karyawan_id', $kol->id)->count();
                        @endphp
                        <div class="col-md-3 col-6">
                            <div class="card card-statistic-2">
                                <div class="card-icon bg-blue">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>{{ $kol->nama_lengkap }}</h4>
                                    </div>
                                    <div class="card-body">
                                        Rp {{ number_format($totalKol, 0, ',', '.') }}
                                        <small class="text-muted d-block">{{ $jmlKol }} transaksi</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Daftar Setoran</h4>
                    <div class="d-flex">
                        <form class="form-inline mr-2" method="GET">
                            <select name="jenis" class="form-control form-control-sm mr-2">
                                <option value="">Semua Jenis</option>
                                <option value="umroh" {{ request('jenis') == 'umroh' ? 'selected' : '' }}>Umroh</option>
                                <option value="haji" {{ request('jenis') == 'haji' ? 'selected' : '' }}>Haji</option>
                            </select>
                            <select name="kolektor_id" class="form-control form-control-sm mr-2">
                                <option value="">Semua Kolektor</option>
                                @foreach ($kolektors as $kol)
                                    <option value="{{ $kol->id }}"
                                        {{ request('kolektor_id') == $kol->id ? 'selected' : '' }}>
                                        {{ $kol->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>
                            <button class="btn btn-sm btn-secondary"><i class="fas fa-search"></i></button>
                        </form>
                        <a href="{{ route('admin.setoran.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus mr-1"></i> Tambah
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
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
                                    <tr>
                                        <td>{{ $setorans->firstItem() + $i }}</td>
                                        <td><small class="text-muted">{{ $s->no_setoran }}</small></td>
                                        <td>{{ $s->tabungan->jamaah->nama_lengkap ?? '-' }}</td>
                                        <td><small>{{ $s->tabungan->no_rekening_tabungan ?? '-' }}</small></td>
                                        <td>
                                            <span class="badge badge-{{ $s->jenis == 'setor' ? 'success' : 'danger' }}">
                                                {{ ucfirst($s->jenis) }}
                                            </span>
                                        </td>
                                        <td>{{ ucfirst($s->metode) }}</td>
                                        <td>
                                            <strong class="{{ $s->jenis == 'setor' ? 'text-success' : 'text-danger' }}">
                                                {{ $s->jenis == 'tarik' ? '-' : '+' }} Rp
                                                {{ number_format($s->jumlah_setor, 0, ',', '.') }}
                                            </strong>
                                        </td>
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
                                        <td>{{ \Carbon\Carbon::parse($s->tanggal_setor)->format('d/m/Y') }}</td>
                                        <td>
                                            @php
                                                $sc =
                                                    [
                                                        'diterima' => 'success',
                                                        'pending' => 'warning',
                                                        'ditolak' => 'danger',
                                                    ][$s->status] ?? 'secondary';
                                            @endphp
                                            <span class="badge badge-{{ $sc }}">{{ ucfirst($s->status) }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.setoran.show', $s) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('admin.setoran.destroy', $s) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin hapus? Saldo akan di-rollback.')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center text-muted">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        {{ $setorans->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
