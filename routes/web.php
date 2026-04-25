<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    KaryawanController,
    AgentController,
    MaskapaiController,
    HotelController,
    PaketController,
    KeberangkatanController,
    JamaahController,
    PendaftaranController,
    PembayaranController,
    TabunganController,
    SetoranController,
    LayananController,
    TransaksiLayananController,
    DokumenController,
    MitraController,
    PengeluaranController,
    SupplierController,
    ProdukController,
    PembelianController,
    PengeluaranProdukController,
    StokOpnameController,
    AksesSystemController,
    SettingController,
    LaporanController,
    PemasukanController
};

// Dashboard per role
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Kasir\DashboardController as KasirDashboard;
use App\Http\Controllers\User\DashboardController as UserDashboard;


/*
|--------------------------------------------------------------------------
| AUTH (PAKAI YANG LAMA - ROLE BASED)
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => redirect()->route('login'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

        // Dashboard tambahan
        Route::get('/dashboard/transaksi-umroh', [AdminDashboard::class, 'transaksiUmroh']);
        Route::get('/dashboard/transaksi-haji', [AdminDashboard::class, 'transaksiHaji']);

        /*
        |--------------------------------------------------------------------------
        | SEMUA FITUR (DARI ROUTE BARU)
        |--------------------------------------------------------------------------
        */

        // CRUD
        Route::resource('karyawan', KaryawanController::class);
        Route::resource('agent', AgentController::class);
        Route::resource('maskapai', MaskapaiController::class);
        Route::resource('hotel', HotelController::class);
        Route::resource('paket', PaketController::class);
        Route::resource('keberangkatan', KeberangkatanController::class);
        Route::resource('jamaah', JamaahController::class);
        Route::resource('pendaftaran', PendaftaranController::class);
        Route::resource('pembayaran', PembayaranController::class);
        Route::resource('tabungan', TabunganController::class);
        Route::resource('setoran', SetoranController::class);
        Route::resource('layanan', LayananController::class);
        Route::resource('transaksi-layanan', TransaksiLayananController::class);
        Route::resource('dokumen', DokumenController::class);
        Route::resource('mitra', MitraController::class);
        Route::resource('pemasukan', PemasukanController::class);
        Route::resource('pengeluaran', PengeluaranController::class);
        Route::resource('supplier', SupplierController::class);
        Route::resource('produk', ProdukController::class);
        Route::resource('pembelian', PembelianController::class);
        Route::resource('pengeluaran-produk', PengeluaranProdukController::class);
        Route::resource('stok-opname', StokOpnameController::class);
        Route::resource('akses-system', AksesSystemController::class);

        // EXTRA ROUTES
        Route::post('pembayaran/{pembayaran}/verifikasi', [PembayaranController::class, 'verifikasi'])->name('pembayaran.verifikasi');
        Route::post('pembayaran/{pembayaran}/tolak',      [PembayaranController::class, 'tolak'])->name('pembayaran.tolak');
        Route::post('pendaftaran/{pendaftaran}/status',   [PendaftaranController::class, 'updateStatus'])->name('pendaftaran.updateStatus');
        Route::post('dokumen/{dokumen}/validasi',         [DokumenController::class, 'validasi'])->name('dokumen.validasi');

        // SETTING
        Route::get('setting', [SettingController::class, 'index'])->name('setting.index');
        Route::put('setting', [SettingController::class, 'update'])->name('setting.update');

        // LAPORAN
        Route::get('laporan',               [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('laporan/keuangan',      [LaporanController::class, 'keuangan'])->name('laporan.keuangan');
        Route::get('laporan/jamaah',        [LaporanController::class, 'jamaah'])->name('laporan.jamaah');
        Route::get('laporan/pembayaran',    [LaporanController::class, 'pembayaran'])->name('laporan.pembayaran');
        Route::get('laporan/tabungan',      [LaporanController::class, 'tabungan'])->name('laporan.tabungan');
        Route::get('laporan/stok',          [LaporanController::class, 'stok'])->name('laporan.stok');
        Route::get('laporan/keberangkatan', [LaporanController::class, 'keberangkatan'])->name('laporan.keberangkatan');
        Route::delete('laporan/{laporan}',  [LaporanController::class, 'destroy'])->name('laporan.destroy');
    });


/*
|--------------------------------------------------------------------------
| KASIR (AKSES TERBATAS)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:kasir'])
    ->prefix('kasir')
    ->name('kasir.')
    ->group(function () {

        Route::get('/dashboard', [KasirDashboard::class, 'index'])->name('dashboard');

        Route::resource('pembayaran', PembayaranController::class);
        Route::resource('jamaah', JamaahController::class);
    });


/*
|--------------------------------------------------------------------------
| USER (VIEW ONLY)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        Route::get('/dashboard', [UserDashboard::class, 'index'])->name('dashboard');

        Route::get('/riwayat', [UserDashboard::class, 'riwayat']);
        Route::get('/profil',  [UserDashboard::class, 'profil']);
    });
