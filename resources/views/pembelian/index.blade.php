@extends('layouts.app')
@section('title', 'Data Pembelian')
@section('page-title', 'Data Pembelian')
@section('breadcrumb')
    <div class="breadcrumb-item active">Pembelian Produk</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    <h4>Data Pembelian</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.pembelian.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah Pembelian
                        </a>
                    </div>
                </div>

                <div class="card-body">

                    {{-- ALERT --}}
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Supplier</th>
                                    <th>Total</th>
                                    <th>Catatan</th>
                                    <th width="150">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pembelians as $i => $p)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($p->tanggal_beli)->format('d/m/Y') }}</td>
                                        <td>{{ $p->supplier->nama_supplier ?? '-' }}</td>
                                        <td>
                                            <strong>
                                                Rp {{ number_format($p->total ?? 0, 0, ',', '.') }}
                                            </strong>
                                        </td>
                                        <td>{{ $p->catatan ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('admin.pembelian.show', $p) }}" class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <a href="{{ route('admin.pembelian.edit', $p) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('admin.pembelian.destroy', $p) }}" method="POST"
                                                style="display:inline-block">
                                                @csrf @method('DELETE')
                                                <button onclick="return confirm('Hapus data?')"
                                                    class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- PAGINATION --}}
                    <div class="mt-3">
                        {{ $pembelians->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
