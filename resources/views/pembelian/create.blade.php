@extends('layouts.app')
@section('title', 'Tambah Pembelian')
@section('page-title', 'Tambah Pembelian')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.pembelian.index') }}">Pembelian Produk</a></div>
    <div class="breadcrumb-item active">Tambah</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Form Tambah Pembelian</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pembelian.store') }}" method="POST" id="form-pembelian">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Supplier <span class="text-danger">*</span></label>
                                    <select name="supplier_id"
                                        class="form-control @error('supplier_id') is-invalid @enderror">
                                        <option value="">-- Pilih Supplier --</option>
                                        @foreach ($suppliers as $s)
                                            <option value="{{ $s->id }}"
                                                {{ old('supplier_id') == $s->id ? 'selected' : '' }}>{{ $s->nama_supplier }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('supplier_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tanggal Beli <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_beli" class="form-control"
                                        value="{{ old('tanggal_beli', now()->format('Y-m-d')) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Catatan</label>
                                    <input type="text" name="catatan" class="form-control" value="{{ old('catatan') }}"
                                        placeholder="Opsional">
                                </div>
                            </div>
                        </div>

                        <h6 class="text-primary mb-2">Detail Produk</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tbl-detail">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width:40%">Produk</th>
                                        <th style="width:15%">Qty</th>
                                        <th style="width:25%">Harga Satuan</th>
                                        <th style="width:15%">Subtotal</th>
                                        <th style="width:5%"></th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-detail">
                                    <tr class="row-item">
                                        <td>
                                            <select name="produk_id[]" class="form-control sel-produk">
                                                <option value="">-- Pilih Produk --</option>
                                                @foreach ($produks as $pr)
                                                    <option value="{{ $pr->id }}" data-harga="{{ $pr->harga_beli }}">
                                                        {{ $pr->nama_produk }} (Stok: {{ $pr->stok }})</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="number" name="qty[]" class="form-control inp-qty" value="1"
                                                min="1"></td>
                                        <td>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text">Rp</span>
                                                </div>
                                                <input type="number" name="harga_satuan[]" class="form-control inp-harga"
                                                    value="0" min="0">
                                            </div>
                                        </td>
                                        <td><span class="txt-subtotal font-weight-bold">Rp 0</span></td>
                                        <td><button type="button" class="btn btn-danger btn-sm btn-hapus-row"><i
                                                    class="fas fa-minus"></i></button></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-right font-weight-bold">Total</td>
                                        <td><span id="txt-total" class="font-weight-bold text-primary">Rp 0</span></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm mb-3" id="btn-tambah-row">
                            <i class="fas fa-plus mr-1"></i> Tambah Produk
                        </button>

                        <div class="form-group mt-2">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
                            <a href="{{ route('admin.pembelian.index') }}" class="btn btn-secondary ml-2"><i
                                    class="fas fa-arrow-left mr-1"></i> Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        const produks = @json($produks->mapWithKeys(fn($p) => [$p->id => $p->harga_beli]));

        function formatRupiah(n) {
            return 'Rp ' + parseInt(n).toLocaleString('id-ID');
        }

        function hitungRow(row) {
            const qty = parseInt(row.querySelector('.inp-qty').value) || 0;
            const harga = parseInt(row.querySelector('.inp-harga').value) || 0;
            row.querySelector('.txt-subtotal').textContent = formatRupiah(qty * harga);
            hitungTotal();
        }

        function hitungTotal() {
            let total = 0;
            document.querySelectorAll('.txt-subtotal').forEach(el => {
                total += parseInt(el.textContent.replace(/[^0-9]/g, '')) || 0;
            });
            document.getElementById('txt-total').textContent = formatRupiah(total);
        }

        function bindRow(row) {
            row.querySelector('.sel-produk').addEventListener('change', function() {
                const harga = produks[this.value] || 0;
                row.querySelector('.inp-harga').value = harga;
                hitungRow(row);
            });
            row.querySelector('.inp-qty').addEventListener('input', () => hitungRow(row));
            row.querySelector('.inp-harga').addEventListener('input', () => hitungRow(row));
            row.querySelector('.btn-hapus-row').addEventListener('click', function() {
                if (document.querySelectorAll('#tbody-detail .row-item').length > 1) {
                    row.remove();
                    hitungTotal();
                }
            });
        }

        document.querySelectorAll('.row-item').forEach(bindRow);

        document.getElementById('btn-tambah-row').addEventListener('click', function() {
            const template = document.querySelector('.row-item').cloneNode(true);
            template.querySelector('.sel-produk').value = '';
            template.querySelector('.inp-qty').value = 1;
            template.querySelector('.inp-harga').value = 0;
            template.querySelector('.txt-subtotal').textContent = 'Rp 0';
            document.getElementById('tbody-detail').appendChild(template);
            bindRow(template);
        });
    </script>
@endpush
