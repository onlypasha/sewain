<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Superadmin\DashboardController;
use App\Http\Controllers\Superadmin\SubscriptionController;
use App\Http\Controllers\Superadmin\SubscriptionPlanController;
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
    Route::get('/superadmin/dashboard', [DashboardController::class, 'index'])->name('superadmin.dashboard');
    Route::get('/superadmin/subscription', [SubscriptionController::class, 'index'])->name('superadmin.subscription');



    Route::get('/superadmin/subscription-plan', [SubscriptionPlanController::class, 'index'])->name('superadmin.subscription-plan');
    Route::post('/superadmin/subscription-plan', [SubscriptionPlanController::class, 'store'])->name('superadmin.subscription-plan.store');
    Route::put('/superadmin/subscription-plan/{id}', [SubscriptionPlanController::class, 'update'])->name('superadmin.subscription-plan.update');



    Route::get('/superadmin/vendor', [VendorManagementController::class, 'index'])->name('superadmin-vendor-management.index');
    Route::post('/superadmin/vendor', [VendorManagementController::class, 'store'])->name('superadmin-vendor-management.create');
});

Route::middleware(['auth', 'role:vendor'])->group(function () {
    Route::get('/vendor/dashboard', [VendorDashboardController::class, 'index'])->name('vendor.dashboard');
});
