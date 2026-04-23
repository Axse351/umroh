<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Dashboard per role
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Kasir\DashboardController as KasirDashboard;
use App\Http\Controllers\User\DashboardController as UserDashboard;

// ==================== AUTH ====================
Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');


// ==================== ADMIN ====================
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

        // contoh dashboard tambahan
        Route::get('/dashboard/transaksi-umroh', [AdminDashboard::class, 'transaksiUmroh']);
        Route::get('/dashboard/transaksi-haji', [AdminDashboard::class, 'transaksiHaji']);

        // semua menu kamu pindahkan ke sini
        Route::resource('pendaftaran', \App\Http\Controllers\PendaftaranController::class);
        Route::resource('jamaah', \App\Http\Controllers\JamaahController::class);
        Route::resource('agent', \App\Http\Controllers\AgentController::class);
        Route::resource('karyawan', \App\Http\Controllers\KaryawanController::class);
        Route::resource('paket', \App\Http\Controllers\PaketController::class);
        Route::resource('keberangkatan', \App\Http\Controllers\KeberangkatanController::class);
        Route::resource('pembayaran', \App\Http\Controllers\PembayaranController::class);
        Route::resource('pengeluaran', \App\Http\Controllers\PengeluaranController::class);
        Route::resource('pemasukan', \App\Http\Controllers\PemasukanController::class);
        Route::resource('laporan', \App\Http\Controllers\LaporanController::class);
        Route::resource('dokumen', \App\Http\Controllers\DokumenController::class);
        Route::resource('maskapai', \App\Http\Controllers\MaskapaiController::class);
        Route::resource('hotel', \App\Http\Controllers\HotelController::class);

        // layanan
        Route::resource('mitra', \App\Http\Controllers\MitraController::class);
        Route::resource('layanan', \App\Http\Controllers\LayananController::class);
        Route::resource('transaksi-layanan', \App\Http\Controllers\TransaksiLayananController::class);
        Route::resource('tabungan', \App\Http\Controllers\TabunganController::class);
        Route::resource('setoran', \App\Http\Controllers\SetoranController::class);

        // gudang
        Route::resource('produk', \App\Http\Controllers\ProdukController::class);
        Route::resource('stok-opname', \App\Http\Controllers\StokOpnameController::class);
        Route::resource('pembelian', \App\Http\Controllers\PembelianController::class);
        Route::resource('pengeluaran-produk', \App\Http\Controllers\PengeluaranProdukController::class);
        Route::resource('supplier', \App\Http\Controllers\SupplierController::class);

        // setting
        Route::resource('akses-system', \App\Http\Controllers\AksesSystemController::class);
        Route::get('/setting', [\App\Http\Controllers\SettingController::class, 'index'])->name('setting.index');
        Route::put('/setting', [\App\Http\Controllers\SettingController::class, 'update'])->name('setting.update');
    });


// ==================== KASIR ====================
Route::middleware(['auth', 'role:kasir'])
    ->prefix('kasir')
    ->name('kasir.')
    ->group(function () {

        Route::get('/dashboard', [KasirDashboard::class, 'index'])->name('dashboard');

        // kasir biasanya akses terbatas
        Route::resource('pembayaran', \App\Http\Controllers\PembayaranController::class);
        Route::resource('jamaah', \App\Http\Controllers\JamaahController::class);
    });


// ==================== USER ====================
Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        Route::get('/dashboard', [UserDashboard::class, 'index'])->name('dashboard');

        // user hanya lihat data
        Route::get('/riwayat', [UserDashboard::class, 'riwayat']);
        Route::get('/profil', [UserDashboard::class, 'profil']);
    });
