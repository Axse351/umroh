<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\JamaahApiController;
use App\Http\Controllers\Api\KeberangkatanApiController;
use App\Http\Controllers\Api\PembayaranApiController;
use App\Http\Controllers\Api\PendaftaranApiController;

/*
|--------------------------------------------------------------------------
| API Routes - Flutter App (Role: user)
|--------------------------------------------------------------------------
|
| Semua endpoint di sini untuk konsumsi aplikasi Flutter.
| Auth menggunakan Laravel Sanctum (token-based).
|
*/

// ─── Public (tanpa auth) ──────────────────────────────────────────────────────

Route::prefix('v1')->group(function () {

    // Login & logout
    Route::post('/login',  [AuthApiController::class, 'login']);

    // Keberangkatan tersedia (bisa dilihat tanpa login)
    Route::get('/keberangkatan',      [KeberangkatanApiController::class, 'index']);
    Route::get('/keberangkatan/{keberangkatan}', [KeberangkatanApiController::class, 'show']);

    // ─── Protected (butuh token Sanctum + role user) ──────────────────────────
    Route::middleware(['auth:sanctum', 'api.role:user'])->group(function () {

        // Auth
        Route::post('/logout',  [AuthApiController::class, 'logout']);
        Route::get('/profile',  [AuthApiController::class, 'profile']);

        // Jamaah
        Route::get('/jamaah',           [JamaahApiController::class, 'index']);
        Route::get('/jamaah/{jamaah}',  [JamaahApiController::class, 'show']);
        Route::put('/jamaah/{jamaah}',  [JamaahApiController::class, 'update']);

        // Pendaftaran (read only untuk user)
        Route::get('/pendaftaran',              [PendaftaranApiController::class, 'index']);
        Route::get('/pendaftaran/{pendaftaran}', [PendaftaranApiController::class, 'show']);

        // Pembayaran
        Route::get('/pembayaran',           [PembayaranApiController::class, 'index']);
        Route::get('/pembayaran/{pembayaran}', [PembayaranApiController::class, 'show']);
        Route::post('/pembayaran',          [PembayaranApiController::class, 'store']);
    });
});
