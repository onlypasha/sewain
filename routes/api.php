<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BookingApiController;
use App\Http\Controllers\Api\V1\CatalogApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API v1 — untuk konsumsi aplikasi Android
|--------------------------------------------------------------------------
| Autentikasi: Laravel Sanctum (Bearer token).
| Login -> dapat token -> kirim "Authorization: Bearer <token>".
*/

Route::prefix('v1')->group(function () {

    // --- Publik (tanpa login) ---
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);

    Route::get('/vendors', [CatalogApiController::class, 'vendors']);
    Route::get('/vendors/{slug}', [CatalogApiController::class, 'vendorDetail']);
    Route::get('/items', [CatalogApiController::class, 'items']);
    Route::get('/items/{id}', [CatalogApiController::class, 'itemDetail']);
    Route::get('/categories', [CatalogApiController::class, 'categories']);

    // --- Butuh login (Bearer token) ---
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::get('/auth/me', [AuthController::class, 'me']);

        // Booking sebagai customer
        Route::get('/bookings', [BookingApiController::class, 'index']);
        Route::post('/items/{id}/booking', [BookingApiController::class, 'store']);
        Route::get('/bookings/{id}', [BookingApiController::class, 'show']);
        Route::post('/bookings/{id}/payment', [BookingApiController::class, 'uploadPayment']);
    });
});
