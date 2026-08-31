<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Superadmin\DashboardController;
use App\Http\Controllers\Superadmin\SubscriptionController;
use App\Http\Controllers\Superadmin\SubscriptionPlanController;
use App\Http\Controllers\Superadmin\VendorManagementController;
use App\Http\Controllers\Vendor\VendorDashboardController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('landing');
// });

Route::get('/', [LandingPageController::class, 'index'])->name('landing');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::get('/superadmin/dashboard', [DashboardController::class, 'index'])->name('superadmin.dashboard');

    Route::get('/superadmin/subscription', [SubscriptionController::class, 'index'])->name('superadmin.subscription');
    Route::post('/superadmin/subscription', [SubscriptionController::class, 'store'])->name('superadmin.subscription.store');

    Route::get('/superadmin/subscription-plan', [SubscriptionPlanController::class, 'index'])->name('superadmin.subscription-plan');
    Route::post('/superadmin/subscription-plan', [SubscriptionPlanController::class, 'store'])->name('superadmin.subscription-plan.store');
    Route::put('/superadmin/subscription-plan/{id}', [SubscriptionPlanController::class, 'update'])->name('superadmin.subscription-plan.update');
    Route::delete('/superadmin/subscription-plan/{id}', [SubscriptionPlanController::class, 'destroy'])->name('superadmin.subscription-plan.destroy');
    Route::get('/superadmin/subscription-plan/{id}/features/', [SubscriptionPlanController::class, 'index_features'])->name('superadmin.subscription.features');
    Route::post('/superadmin/subscription-plan/{id}/features/', [SubscriptionPlanController::class, 'store_features'])->name('superadmin.subscription.features.store');

    Route::get('/superadmin/vendor', [VendorManagementController::class, 'index'])->name('superadmin-vendor-management.index');
    Route::post('/superadmin/vendor', [VendorManagementController::class, 'store'])->name('superadmin-vendor-management.create');
});

Route::middleware(['auth', 'role:vendor'])->group(function () {
    Route::get('/vendor/dashboard', [VendorDashboardController::class, 'index'])->name('vendor.dashboard');
});
