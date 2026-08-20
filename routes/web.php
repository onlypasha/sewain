<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Superadmin\VendorManagementController;
use App\Http\Controllers\Vendor\VendorDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::get('/superadmin/dashboard', [VendorManagementController::class, 'index'])->name('superadmin.dashboard');

    Route::post('/create-vendor', [VendorManagementController::class, 'store'])->name('vendor.create');
});

Route::middleware(['auth', 'role:vendor'])->group(function () {
    Route::get('/vendor/dashboard', [VendorDashboardController::class, 'index'])->name('vendor.dashboard');
});
