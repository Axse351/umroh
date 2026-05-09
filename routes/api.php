<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\JamaahApiController;
use App\Http\Controllers\Api\KeberangkatanApiController;
use App\Http\Controllers\Api\PembayaranApiController;
use App\Http\Controllers\Api\PendaftaranApiController;
use App\Http\Controllers\Api\SavingAccountApiController;

Route::prefix('v1')->group(function () {

    Route::post('/login', [AuthApiController::class, 'login']);

    Route::get('/keberangkatan',                 [KeberangkatanApiController::class, 'index']);
    Route::get('/keberangkatan/{keberangkatan}', [KeberangkatanApiController::class, 'show']);

    Route::middleware(['auth:sanctum', 'api.role:user'])->group(function () {

        Route::post('/logout', [AuthApiController::class, 'logout']);
        Route::get('/profile', [AuthApiController::class, 'profile']);

        Route::get('/saving-account', [SavingAccountApiController::class, 'show']);

        Route::get('/jamaah',          [JamaahApiController::class, 'index']);
        Route::get('/jamaah/{jamaah}', [JamaahApiController::class, 'show']);
        Route::put('/jamaah/{jamaah}', [JamaahApiController::class, 'update']);

        Route::get('/pendaftaran',              [PendaftaranApiController::class, 'index']);
        Route::get('/pendaftaran/{pendaftaran}', [PendaftaranApiController::class, 'show']);

        Route::get('pembayaran/recent',  [PembayaranApiController::class, 'recent']);
        Route::get('/pembayaran/summary',      [PembayaranApiController::class, 'summary']);
        Route::get('/pembayaran',              [PembayaranApiController::class, 'index']);
        Route::get('/pembayaran/{pembayaran}', [PembayaranApiController::class, 'show']);
        Route::post('/pembayaran',             [PembayaranApiController::class, 'store']);
    });
});
