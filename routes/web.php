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
    MutasiController,
    PemasukanController,
    GunakanTabunganController,
    UserController,
    WelcomeController
};

// Dashboard per role
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\WelcomeSettingController;
use App\Http\Controllers\Kasir\DashboardController as KasirDashboard;
use App\Http\Controllers\User\DashboardController as UserDashboard;


/*
|--------------------------------------------------------------------------
| PUBLIC — Halaman landing page (welcome.blade.php)
|--------------------------------------------------------------------------
*/

Route::get('/', [WelcomeController::class, 'index'])->name('home');

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
        Route::get('/dashboard/transaksi-umroh', [AdminDashboard::class, 'transaksiUmroh']);
        Route::get('/dashboard/transaksi-haji', [AdminDashboard::class, 'transaksiHaji']);

        /*
        |--------------------------------------------------------------------------
        | CRUD RESOURCES
        |--------------------------------------------------------------------------
        */

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
        Route::prefix('setoran')->name('setoran.')->group(function () {
            Route::patch('{setoran}/konfirmasi', [SetoranController::class, 'konfirmasi'])->name('konfirmasi');
            Route::patch('{setoran}/tolak',      [SetoranController::class, 'tolak'])->name('tolak');
        });
        /*
        |--------------------------------------------------------------------------
        | EXTRA ROUTES
        |--------------------------------------------------------------------------
        */

        Route::post('pembayaran/{pembayaran}/verifikasi', [PembayaranController::class, 'verifikasi'])->name('pembayaran.verifikasi');
        Route::post('pembayaran/{pembayaran}/tolak',      [PembayaranController::class, 'tolak'])->name('pembayaran.tolak');
        Route::post('pendaftaran/{pendaftaran}/status',   [PendaftaranController::class, 'updateStatus'])->name('pendaftaran.updateStatus');
        Route::patch('pendaftaran/{pendaftaran}/status',  [PendaftaranController::class, 'updateStatus'])->name('pendaftaran.update-status');
        Route::post('dokumen/{dokumen}/validasi',         [DokumenController::class, 'validasi'])->name('dokumen.validasi');
        Route::patch('setoran/{setoran}/konfirmasi', [SetoranController::class, 'konfirmasi'])->name('setoran.konfirmasi');
        Route::patch('setoran/{setoran}/tolak', [SetoranController::class, 'tolak'])->name('setoran.tolak');

        /*
        |--------------------------------------------------------------------------
        | SETTING
        |--------------------------------------------------------------------------
        */

        Route::get('setting', [SettingController::class, 'index'])->name('setting.index');
        Route::put('setting', [SettingController::class, 'update'])->name('setting.update');

        /*
        |--------------------------------------------------------------------------
        | LAPORAN
        |--------------------------------------------------------------------------
        */

        Route::get('laporan',               [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('laporan/keuangan',      [LaporanController::class, 'keuangan'])->name('laporan.keuangan');
        Route::get('laporan/jamaah',        [LaporanController::class, 'jamaah'])->name('laporan.jamaah');
        Route::get('laporan/pembayaran',    [LaporanController::class, 'pembayaran'])->name('laporan.pembayaran');
        Route::get('laporan/tabungan',      [LaporanController::class, 'tabungan'])->name('laporan.tabungan');
        Route::get('laporan/stok',          [LaporanController::class, 'stok'])->name('laporan.stok');
        Route::get('laporan/keberangkatan', [LaporanController::class, 'keberangkatan'])->name('laporan.keberangkatan');
        Route::delete('laporan/{laporan}',  [LaporanController::class, 'destroy'])->name('laporan.destroy');

        /*
        |--------------------------------------------------------------------------
        | MUTASI
        |--------------------------------------------------------------------------
        */

        Route::get('mutasi',                [MutasiController::class, 'index'])->name('mutasi.index');
        Route::get('mutasi/{jamaah}',       [MutasiController::class, 'show'])->name('mutasi.show');
        Route::get('mutasi/{jamaah}/cetak', [MutasiController::class, 'cetak'])->name('mutasi.cetak');

        Route::get('tabungan/{tabungan}/cetak-mutasi', [TabunganController::class, 'cetakMutasi'])
            ->name('tabungan.cetak-mutasi');
        Route::get('tabungan/{tabungan}/info', [GunakanTabunganController::class, 'infoTabungan'])
            ->name('tabungan.info');

        Route::get('pendaftaran/{pendaftaran}/cetak-mutasi', [PendaftaranController::class, 'cetakMutasi'])
            ->name('pendaftaran.cetak-mutasi');
        Route::get('pendaftaran/{pendaftaran}/gunakan-tabungan', [GunakanTabunganController::class, 'show'])
            ->name('pendaftaran.gunakan-tabungan');
        Route::post('pendaftaran/{pendaftaran}/gunakan-tabungan', [GunakanTabunganController::class, 'store'])
            ->name('pendaftaran.gunakan-tabungan.store');

        /*
        |--------------------------------------------------------------------------
        | WELCOME SETTING — CMS Halaman Publik
        | Index → admin.welcome-setting.index (view: admin.welcome-setting.index)
        |--------------------------------------------------------------------------
        */

        Route::get('welcome-setting', [WelcomeSettingController::class, 'index'])
            ->name('welcome-setting.index');

        Route::put('welcome-setting/update-general', [WelcomeSettingController::class, 'updateGeneral'])
            ->name('welcome-setting.update-general');

        // Slides — reorder harus SEBELUM {slide} agar tidak bentrok
        Route::post('welcome-setting/slides/reorder', [WelcomeSettingController::class, 'reorderSlides'])
            ->name('welcome-setting.slides.reorder');
        Route::post('welcome-setting/slides', [WelcomeSettingController::class, 'storeSlide'])
            ->name('welcome-setting.slides.store');
        Route::put('welcome-setting/slides/{slide}', [WelcomeSettingController::class, 'updateSlide'])
            ->name('welcome-setting.slides.update');
        Route::delete('welcome-setting/slides/{slide}', [WelcomeSettingController::class, 'destroySlide'])
            ->name('welcome-setting.slides.destroy');

        // Packages
        Route::post('welcome-setting/packages', [WelcomeSettingController::class, 'storePackage'])
            ->name('welcome-setting.packages.store');
        Route::put('welcome-setting/packages/{package}', [WelcomeSettingController::class, 'updatePackage'])
            ->name('welcome-setting.packages.update');
        Route::delete('welcome-setting/packages/{package}', [WelcomeSettingController::class, 'destroyPackage'])
            ->name('welcome-setting.packages.destroy');

        // Hapus gambar (brand_logo / about_image)
        Route::delete('welcome-setting/delete-image', [WelcomeSettingController::class, 'deleteImage'])
            ->name('welcome-setting.delete-image');
        Route::resource('user', UserController::class);
        Route::post('user/{user}/reset-password', [UserController::class, 'resetPassword'])
            ->name('user.reset-password');
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
