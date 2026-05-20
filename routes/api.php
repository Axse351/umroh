<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\JamaahApiController;
use App\Http\Controllers\Api\KeberangkatanApiController;
use App\Http\Controllers\Api\PembayaranApiController;
use App\Http\Controllers\Api\PendaftaranApiController;
use App\Http\Controllers\Api\SavingAccountApiController;
use App\Http\Controllers\Api\KolektorApiController;

Route::prefix('v1')->group(function () {

    // ── Public ────────────────────────────────────────────────
    Route::post('/login', [AuthApiController::class, 'login']);

    Route::get('/keberangkatan',                 [KeberangkatanApiController::class, 'index']);
    Route::get('/keberangkatan/{keberangkatan}', [KeberangkatanApiController::class, 'show']);

    // ── User ──────────────────────────────────────────────────
    Route::middleware(['auth:sanctum', 'api.role:user'])->group(function () {

        Route::post('/logout',  [AuthApiController::class, 'logout']);
        Route::get('/profile',  [AuthApiController::class, 'profile']);

        Route::get('/saving-account', [SavingAccountApiController::class, 'show']);

        Route::get('/jamaah',          [JamaahApiController::class, 'index']);
        Route::get('/jamaah/{jamaah}', [JamaahApiController::class, 'show']);
        Route::put('/jamaah/{jamaah}', [JamaahApiController::class, 'update']);

        Route::get('/pendaftaran',               [PendaftaranApiController::class, 'index']);
        Route::get('/pendaftaran/{pendaftaran}', [PendaftaranApiController::class, 'show']);

        // PENTING: route spesifik (recent, summary) harus SEBELUM /{pembayaran}
        Route::get('/pembayaran/recent',          [PembayaranApiController::class, 'recent']);
        Route::get('/pembayaran/summary',         [PembayaranApiController::class, 'summary']);
        Route::get('/pembayaran',                 [PembayaranApiController::class, 'index']);
        Route::get('/pembayaran/{pembayaran}',    [PembayaranApiController::class, 'show']);
        Route::post('/pembayaran',                [PembayaranApiController::class, 'store']);
    });

    // ── Kolektor ──────────────────────────────────────────────
    // Gunakan auth:sanctum saja dulu, cek role manual di controller
    // supaya bisa debug apakah masalah di middleware atau di logic
    Route::middleware(['auth:sanctum'])
        ->prefix('kolektor')
        ->group(function () {

            Route::post('/logout',  [AuthApiController::class, 'logout']);
            Route::get('/profile',  [AuthApiController::class, 'profile']);

            // Jamaah
            Route::get('/jamaah',              [KolektorApiController::class, 'jamaahIndex']);
            Route::get('/jamaah/{jamaah}',     [KolektorApiController::class, 'jamaahShow']);
            Route::post('/jamaah',             [KolektorApiController::class, 'jamaahStore']);

            // Keberangkatan
            Route::get('/keberangkatan',       [KolektorApiController::class, 'keberangkatanList']);

            // Pendaftaran
            Route::get('/pendaftaran',         [KolektorApiController::class, 'pendaftaranIndex']);
            Route::post('/pendaftaran',        [KolektorApiController::class, 'pendaftaranStore']);

            // Pembayaran
            Route::get('/pembayaran',          [KolektorApiController::class, 'pembayaranIndex']);
            Route::post('/pembayaran',         [KolektorApiController::class, 'pembayaranStore']);

            // Tabungan — URUTAN WAJIB: static route SEBELUM wildcard {tabungan}
            Route::get('/tabungan',                   [KolektorApiController::class, 'tabunganIndex']);
            Route::post('/tabungan',                  [KolektorApiController::class, 'tabunganStore']);
            Route::get('/tabungan/setoran-saya',      [KolektorApiController::class, 'setoranSaya']);   // ← HARUS sebelum {tabungan}
            Route::get('/tabungan/{tabungan}',        [KolektorApiController::class, 'tabunganShow']);
            Route::post('/tabungan/{tabungan}/setor', [KolektorApiController::class, 'tabunganSetor']);
        });
});
