@extends('layouts.app')
@section('title', 'Transaksi Layanan')
@section('page-title', 'Transaksi Layanan')
@section('breadcrumb')
    <div class="breadcrumb-item active">Transaksi Layanan</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Daftar Transaksi Layanan</h4>
                    <div class="d-flex">
                        <form class="form-inline mr-2" method="GET">
                            <select name="jenis" class="form-control form-control-sm mr-2">
                                <option value="">Semua Jenis</option>
                                <option value="umroh" {{ request('jenis') == 'umroh' ? 'selected' : '' }}>Umroh</option>
                                <option value="haji" {{ request('jenis') == 'haji' ? 'selected' : '' }}>Haji</option>
                                <option value="keduanya" {{ request('jenis') == 'keduanya' ? 'selected' : '' }}>Keduanya
                                </option>
                            </select>
                            <button class="btn btn-sm btn-secondary"><i class="fas fa-search"></i></button>
                        </form>
                        <a href="{{ route('admin.transaksi-layanan.create') }}" class="btn btn-primary btn-sm"><i
                                class="fas fa-plus mr-1"></i> Tambah</a>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button
                                type="button" class="close" data-dismiss="alert">&times;</button></div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>No. Transaksi</th>
                                    <th>Jamaah</th>
                                    <th>Layanan</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksis as $i => $tr)
                                    <tr>
                                        <td>{{ $transaksis->firstItem() + $i }}</td>
                                        <td><small class="text-muted">{{ $tr->no_transaksi }}</small></td>
                                        <td>{{ $tr->pendaftaran->jamaah->nama_lengkap ?? '-' }}</td>
                                        <td>{{ $tr->layanan->nama_layanan ?? '-' }}</td>
                                        <td>{{ $tr->qty }}</td>
                                        <td>Rp {{ number_format($tr->total_harga, 0, ',', '.') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($tr->tanggal_transaksi)->format('d/m/Y') }}</td>
                                        <td>
                                            @php $color = ['pending'=>'secondary','proses'=>'info','selesai'=>'success','batal'=>'danger'][$tr->status] ?? 'secondary'; @endphp
                                            <span
                                                class="badge badge-{{ $color }}">{{ ucfirst($tr->status) }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.transaksi-layanan.show', $tr) }}"
                                                class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('admin.transaksi-layanan.edit', $tr) }}"
                                                class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('admin.transaksi-layanan.destroy', $tr) }}"
                                                method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">{{ $transaksis->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
