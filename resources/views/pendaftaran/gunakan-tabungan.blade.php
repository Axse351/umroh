@extends('layouts.app')
@section('title', 'Gunakan Tabungan – ' . $pendaftaran->no_pendaftaran)
@section('page-title', 'Gunakan Tabungan')

@section('breadcrumb')
    <div class="breadcrumb-item">
        <a href="{{ route('admin.pendaftaran.index') }}">Data Pendaftaran</a>
    </div>
    <div class="breadcrumb-item">
        <a href="{{ route('admin.pendaftaran.show', $pendaftaran) }}">{{ $pendaftaran->no_pendaftaran }}</a>
    </div>
    <div class="breadcrumb-item active">Gunakan Tabungan</div>
@endsection

@section('content')
    <div class="row">

        {{-- ── Ringkasan Pendaftaran ─────────────────────────────── --}}
        <div class="col-lg-5 col-12">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-file-alt mr-2"></i>Ringkasan Pendaftaran</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted" width="45%">No. Pendaftaran</td>
                            <td><strong>{{ $pendaftaran->no_pendaftaran }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Jamaah</td>
                            <td><strong>{{ $pendaftaran->jamaah->nama_lengkap }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Paket</td>
                            <td>{{ $pendaftaran->keberangkatan->paket->nama_paket ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Jenis</td>
                            <td>
                                <span
                                    class="badge badge-info">{{ strtoupper(str_replace('_', ' ', $pendaftaran->jenis)) }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Tipe Kamar</td>
                            <td>{{ ucfirst($pendaftaran->tipe_kamar) }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Harga Jual</td>
                            <td><strong>Rp {{ number_format($pendaftaran->harga_jual, 0, ',', '.') }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Total Terbayar</td>
                            <td class="text-success font-weight-bold">
                                Rp {{ number_format($pendaftaran->total_bayar, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr class="table-danger">
                            <td class="font-weight-bold">Sisa Tagihan</td>
                            <td class="font-weight-bold text-danger" id="sisa-tagihan-display">
                                Rp {{ number_format($pendaftaran->sisa_tagihan, 0, ',', '.') }}
                            </td>
                        </tr>
                    </table>

                    {{-- Progress pelunasan --}}
                    @php
                        $persen =
                            $pendaftaran->harga_jual > 0
                                ? min(100, round(($pendaftaran->total_bayar / $pendaftaran->harga_jual) * 100))
                                : 0;
                    @endphp
                    <div class="mt-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small class="text-muted">Progress Pelunasan</small>
                            <small class="font-weight-bold">{{ $persen }}%</small>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar {{ $persen >= 100 ? 'bg-success' : 'bg-warning' }}"
                                style="width: {{ $persen }}%"></div>
                        </div>
                    </div>

                    {{-- Status badge --}}
                    <div class="mt-3 text-center">
                        @php
                            $statusColor =
                                [
                                    'draft' => 'secondary',
                                    'konfirmasi' => 'info',
                                    'dp_terbayar' => 'warning',
                                    'lunas' => 'success',
                                    'berangkat' => 'primary',
                                    'selesai' => 'dark',
                                    'batal' => 'danger',
                                    'refund' => 'danger',
                                ][$pendaftaran->status] ?? 'secondary';
                        @endphp
                        <span class="badge badge-{{ $statusColor }} badge-pill px-3 py-2">
                            Status: {{ strtoupper(str_replace('_', ' ', $pendaftaran->status)) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Daftar tabungan milik jamaah --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-piggy-bank mr-2 text-success"></i>
                        Tabungan Aktif Jamaah
                    </h6>
                </div>
                <div class="card-body p-0">
                    @forelse ($tabungans as $tab)
                        <div class="d-flex align-items-center p-3 border-bottom tab-item-card"
                            data-id="{{ $tab->id }}" data-saldo="{{ $tab->saldo }}"
                            data-no="{{ $tab->no_rekening_tabungan }}" style="cursor:pointer;">
                            <div class="mr-3">
                                <div class="rounded-circle bg-success-light d-flex align-items-center justify-content-center"
                                    style="width:42px;height:42px;background:rgba(40,167,69,.12)">
                                    <i class="fas fa-wallet text-success"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="font-weight-bold text-sm">{{ $tab->no_rekening_tabungan }}</div>
                                <div class="text-muted" style="font-size:.8rem">
                                    {{ ucfirst($tab->jenis) }}
                                    &bull; {{ $tab->persen_tercapai }}% dari target
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-weight-bold text-success">
                                    Rp {{ number_format($tab->saldo, 0, ',', '.') }}
                                </div>
                                <small class="text-muted">saldo</small>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 text-center text-muted">
                            <i class="fas fa-exclamation-circle fa-2x mb-2 d-block"></i>
                            Tidak ada tabungan aktif dengan saldo > 0
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ── Form Gunakan Tabungan ──────────────────────────────── --}}
        <div class="col-lg-7 col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-hand-holding-usd mr-2"></i>Gunakan Saldo Tabungan</h5>
                </div>
                <div class="card-body">

                    @if ($tabungans->isEmpty())
                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle mr-2"></i>
                            Jamaah <strong>{{ $pendaftaran->jamaah->nama_lengkap }}</strong>
                            belum memiliki tabungan aktif yang bisa digunakan.
                            <a href="{{ route('admin.tabungan.create', ['jamaah_id' => $pendaftaran->jamaah_id]) }}"
                                class="alert-link">Buat tabungan baru</a>.
                        </div>
                    @else
                        <form action="{{ route('admin.pendaftaran.gunakan-tabungan.store', $pendaftaran) }}" method="POST"
                            id="form-gunakan-tabungan">
                            @csrf

                            {{-- Alert saldo info --}}
                            <div id="alert-saldo" class="alert alert-info d-none mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-piggy-bank fa-2x mr-3"></i>
                                    <div>
                                        <strong id="info-no-rek">-</strong><br>
                                        Saldo tersedia: <strong id="info-saldo" class="text-success">Rp 0</strong>
                                    </div>
                                </div>
                            </div>

                            {{-- Pilih Tabungan --}}
                            <div class="form-group">
                                <label>Pilih Tabungan <span class="text-danger">*</span></label>
                                <select name="tabungan_id" id="sel-tabungan"
                                    class="form-control @error('tabungan_id') is-invalid @enderror">
                                    <option value="">-- Pilih Rekening Tabungan --</option>
                                    @foreach ($tabungans as $tab)
                                        <option value="{{ $tab->id }}" data-saldo="{{ $tab->saldo }}"
                                            data-no="{{ $tab->no_rekening_tabungan }}"
                                            {{ old('tabungan_id') == $tab->id ? 'selected' : '' }}>
                                            {{ $tab->no_rekening_tabungan }}
                                            ({{ ucfirst($tab->jenis) }})
                                            – Saldo: Rp {{ number_format($tab->saldo, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tabungan_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Jumlah yang dipakai --}}
                            <div class="form-group">
                                <label>Jumlah Digunakan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="number" name="jumlah_pakai" id="inp-jumlah"
                                        class="form-control @error('jumlah_pakai') is-invalid @enderror"
                                        value="{{ old('jumlah_pakai', $pendaftaran->sisa_tagihan) }}" min="1"
                                        step="1000">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary" id="btn-pakai-semua"
                                            title="Gunakan seluruh saldo atau sisa tagihan">
                                            Maks
                                        </button>
                                    </div>
                                </div>
                                @error('jumlah_pakai')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="text-muted" id="hint-jumlah">
                                    Sisa tagihan: <strong>Rp
                                        {{ number_format($pendaftaran->sisa_tagihan, 0, ',', '.') }}</strong>
                                </small>
                            </div>

                            {{-- Jenis Pembayaran --}}
                            <div class="form-group">
                                <label>Jenis Pembayaran <span class="text-danger">*</span></label>
                                <select name="jenis" class="form-control @error('jenis') is-invalid @enderror">
                                    <option value="dp" {{ old('jenis') == 'dp' ? 'selected' : '' }}>DP</option>
                                    <option value="cicilan" {{ old('jenis') == 'cicilan' ? 'selected' : '' }}>Cicilan
                                    </option>
                                    <option value="pelunasan"
                                        {{ old('jenis', 'pelunasan') == 'pelunasan' ? 'selected' : '' }}>Pelunasan</option>
                                    <option value="lainnya" {{ old('jenis') == 'lainnya' ? 'selected' : '' }}>Lainnya
                                    </option>
                                </select>
                                @error('jenis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Catatan --}}
                            <div class="form-group">
                                <label>Catatan <small class="text-muted">(opsional)</small></label>
                                <textarea name="catatan" class="form-control" rows="2" placeholder="Keterangan tambahan...">{{ old('catatan') }}</textarea>
                            </div>

                            {{-- Preview ringkasan --}}
                            <div id="preview-box" class="alert alert-secondary d-none mb-3">
                                <h6 class="font-weight-bold mb-2"><i class="fas fa-receipt mr-1"></i> Ringkasan Transaksi
                                </h6>
                                <table class="table table-sm table-borderless mb-0" style="font-size:.9rem">
                                    <tr>
                                        <td class="text-muted">Sumber Dana</td>
                                        <td id="prev-sumber">-</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Jumlah Digunakan</td>
                                        <td id="prev-jumlah" class="font-weight-bold text-success">-</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Saldo Setelah</td>
                                        <td id="prev-saldo-after">-</td>
                                    </tr>
                                    <tr class="table-light">
                                        <td class="text-muted">Sisa Tagihan Setelah</td>
                                        <td id="prev-sisa" class="font-weight-bold">-</td>
                                    </tr>
                                </table>
                            </div>

                            <div class="form-group mt-3 d-flex align-items-center">
                                <button type="submit" class="btn btn-success btn-lg mr-3" id="btn-submit">
                                    <i class="fas fa-check-circle mr-1"></i> Gunakan Tabungan
                                </button>
                                <a href="{{ route('admin.pendaftaran.show', $pendaftaran) }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                                </a>
                            </div>
                        </form>

                    @endif {{-- end if tabungans not empty --}}
                </div>
            </div>

            {{-- Riwayat pembayaran yang sudah ada --}}
            @if ($pendaftaran->pembayarans->count())
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-history mr-2"></i>Riwayat Pembayaran</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>No. Bayar</th>
                                    <th>Tanggal</th>
                                    <th>Jenis</th>
                                    <th>Metode</th>
                                    <th class="text-right">Jumlah</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendaftaran->pembayarans->sortByDesc('tanggal_bayar') as $pay)
                                    <tr>
                                        <td class="font-weight-bold" style="font-size:.8rem">{{ $pay->no_pembayaran }}
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($pay->tanggal_bayar)->format('d/m/Y') }}</td>
                                        <td>
                                            {{ ucfirst($pay->jenis) }}
                                            @if ($pay->dari_tabungan)
                                                <span class="badge badge-success" title="Dari tabungan">
                                                    <i class="fas fa-piggy-bank"></i>
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ ucfirst($pay->metode_bayar) }}</td>
                                        <td class="text-right font-weight-bold">
                                            Rp {{ number_format($pay->jumlah_bayar, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            @php
                                                $c =
                                                    [
                                                        'diterima' => 'success',
                                                        'pending' => 'warning',
                                                        'ditolak' => 'danger',
                                                        'verifikasi' => 'info',
                                                    ][$pay->status] ?? 'secondary';
                                            @endphp
                                            <span
                                                class="badge badge-{{ $c }}">{{ ucfirst($pay->status) }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function() {
            const sisaTagihan = {{ $pendaftaran->sisa_tagihan }};
            const selTabungan = document.getElementById('sel-tabungan');
            const inpJumlah = document.getElementById('inp-jumlah');
            const btnMaks = document.getElementById('btn-pakai-semua');
            const alertSaldo = document.getElementById('alert-saldo');
            const infoNoRek = document.getElementById('info-no-rek');
            const infoSaldo = document.getElementById('info-saldo');
            const previewBox = document.getElementById('preview-box');

            // Format rupiah sederhana
            const rp = n => 'Rp ' + Number(n).toLocaleString('id-ID');

            function getSelectedSaldo() {
                const opt = selTabungan.options[selTabungan.selectedIndex];
                return opt && opt.value ? parseFloat(opt.dataset.saldo) : 0;
            }

            function updatePreview() {
                const saldo = getSelectedSaldo();
                const jumlah = parseFloat(inpJumlah.value) || 0;
                const opt = selTabungan.options[selTabungan.selectedIndex];

                if (!opt || !opt.value || jumlah <= 0) {
                    previewBox.classList.add('d-none');
                    return;
                }

                const saldoSetelah = Math.max(0, saldo - jumlah);
                const sisaSetelah = Math.max(0, sisaTagihan - jumlah);

                document.getElementById('prev-sumber').textContent = opt.dataset.no;
                document.getElementById('prev-jumlah').textContent = rp(jumlah);
                document.getElementById('prev-saldo-after').textContent = rp(saldoSetelah);
                document.getElementById('prev-sisa').textContent = rp(sisaSetelah);

                const prevSisa = document.getElementById('prev-sisa');
                prevSisa.className = 'font-weight-bold ' + (sisaSetelah <= 0 ? 'text-success' : 'text-danger');

                previewBox.classList.remove('d-none');
            }

            function onTabunganChange() {
                const opt = selTabungan.options[selTabungan.selectedIndex];
                const saldo = getSelectedSaldo();

                if (opt && opt.value) {
                    infoNoRek.textContent = opt.dataset.no;
                    infoSaldo.textContent = rp(saldo);
                    alertSaldo.classList.remove('d-none');

                    // Set nilai default = min(saldo, sisaTagihan)
                    inpJumlah.value = Math.min(saldo, sisaTagihan);
                    inpJumlah.max = Math.min(saldo, sisaTagihan);
                } else {
                    alertSaldo.classList.add('d-none');
                }

                updatePreview();
            }

            // Tombol Maks
            if (btnMaks) {
                btnMaks.addEventListener('click', function() {
                    const saldo = getSelectedSaldo();
                    inpJumlah.value = Math.min(saldo, sisaTagihan);
                    updatePreview();
                });
            }

            selTabungan.addEventListener('change', onTabunganChange);
            inpJumlah.addEventListener('input', updatePreview);

            // Klik kartu tabungan di sisi kiri
            document.querySelectorAll('.tab-item-card').forEach(function(card) {
                card.addEventListener('click', function() {
                    const id = this.dataset.id;
                    selTabungan.value = id;
                    selTabungan.dispatchEvent(new Event('change'));
                    // scroll ke form di mobile
                    document.getElementById('sel-tabungan').scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });

            // Trigger saat halaman load jika ada nilai lama (old input)
            if (selTabungan.value) {
                onTabunganChange();
            }

            // Konfirmasi submit
            document.getElementById('form-gunakan-tabungan')?.addEventListener('submit', function(e) {
                const jumlah = parseFloat(inpJumlah.value) || 0;
                if (jumlah <= 0) {
                    e.preventDefault();
                    alert('Masukkan jumlah yang valid.');
                    return;
                }
                const saldo = getSelectedSaldo();
                if (jumlah > saldo) {
                    e.preventDefault();
                    alert('Jumlah melebihi saldo tabungan (' + rp(saldo) + ').');
                    return;
                }
                return confirm('Konfirmasi: gunakan ' + rp(jumlah) + ' dari tabungan untuk pembayaran ini?');
            });
        })();
    </script>
@endpush
