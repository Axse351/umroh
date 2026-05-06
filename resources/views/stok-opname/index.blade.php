@extends('layouts.app')
@section('title', 'Data Stok Opname')
@section('page-title', 'Data Stok Opname')
@section('breadcrumb')
    <div class="breadcrumb-item active">Data Stok Opname</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-clipboard-check mr-1"></i> Data Stok Opname</h4>
                    <div class="card-header-action">
                        <a href="{{ route('stok-opname.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus mr-1"></i> Catat Opname
                        </a>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>No. Opname</th>
                                    <th>Produk</th>
                                    <th class="text-center">Stok Sistem</th>
                                    <th class="text-center">Stok Fisik</th>
                                    <th class="text-center">Selisih</th>
                                    <th>Tanggal Opname</th>
                                    <th>Dicatat Oleh</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($stokOpnames as $i => $item)
                                    <tr>
                                        <td>{{ $stokOpnames->firstItem() + $i }}</td>
                                        <td><code>{{ $item->no_opname }}</code></td>
                                        <td class="font-weight-bold">{{ $item->produk->nama_produk ?? '-' }}</td>
                                        <td class="text-center">{{ $item->stok_sistem }}</td>
                                        <td class="text-center">{{ $item->stok_fisik }}</td>
                                        <td class="text-center">
                                            @php $selisih = $item->selisih; @endphp
                                            @if ($selisih > 0)
                                                <span class="badge badge-success">+{{ $selisih }}</span>
                                            @elseif ($selisih < 0)
                                                <span class="badge badge-danger">{{ $selisih }}</span>
                                            @else
                                                <span class="badge badge-secondary">0</span>
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_opname)->format('d M Y') }}</td>
                                        <td>{{ $item->karyawan->nama_karyawan ?? '-' }}</td>
                                        <td>
                                            <span class="text-truncate d-inline-block" style="max-width: 150px;"
                                                title="{{ $item->keterangan }}">
                                                {{ $item->keterangan ?? '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('stok-opname.show', $item) }}"
                                                class="btn btn-sm btn-info btn-icon" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('stok-opname.destroy', $item) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin hapus data stok opname ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger btn-icon"
                                                    title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center py-5 text-muted">
                                            <i class="fas fa-inbox fa-2x d-block mb-2"></i> Tidak ada data stok opname.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($stokOpnames->hasPages())
                    <div class="card-footer">
                        {{ $stokOpnames->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
