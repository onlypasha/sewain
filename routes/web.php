<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Superadmin\DashboardController;
use App\Http\Controllers\Superadmin\PaymentsController;
use App\Http\Controllers\Superadmin\SubscriptionController;
use App\Http\Controllers\Superadmin\SubscriptionPlanController;
use App\Http\Controllers\Superadmin\VendorManagementController;
use App\Http\Controllers\Vendor\DangerZoneController;
use App\Http\Controllers\Vendor\SettingsController;
use App\Http\Controllers\Vendor\SubscriptionController as VendorSubscriptionController;
use App\Http\Controllers\Vendor\SubscriptionPurchaseController;
use App\Http\Controllers\Vendor\VendorDashboardController;

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
    Route::put('/superadmin/subscription/{id}', [SubscriptionController::class, 'update'])->name('superadmin.subscription.update');
    Route::delete('/superadmin/subscription/{id}', [SubscriptionController::class, 'destroy'])->name('superadmin.subscription.destroy');

    Route::get('/superadmin/subscription-plan', [SubscriptionPlanController::class, 'index'])->name('superadmin.subscription-plan');
    Route::post('/superadmin/subscription-plan', [SubscriptionPlanController::class, 'store'])->name('superadmin.subscription-plan.store');
    Route::put('/superadmin/subscription-plan/{id}', [SubscriptionPlanController::class, 'update'])->name('superadmin.subscription-plan.update');
    Route::delete('/superadmin/subscription-plan/{id}', [SubscriptionPlanController::class, 'destroy'])->name('superadmin.subscription-plan.destroy');
    Route::get('/superadmin/subscription-plan/{id}/features/', [SubscriptionPlanController::class, 'index_features'])->name('superadmin.subscription.features');
    Route::post('/superadmin/subscription-plan/{id}/features/', [SubscriptionPlanController::class, 'store_features'])->name('superadmin.subscription.features.store');

    Route::get('/superadmin/vendor', [VendorManagementController::class, 'index'])->name('superadmin-vendor-management.index');
    Route::post('/superadmin/vendor', [VendorManagementController::class, 'store'])->name('superadmin-vendor-management.create');
    Route::put('/superadmin/vendor/{id}', [VendorManagementController::class, 'update'])->name('superadmin-vendor-management.update');
    Route::delete('/superadmin/vendor/{id}', [VendorManagementController::class, 'destroy'])->name('superadmin-vendor-management.destroy');

    Route::get('/superadmin/payments', [PaymentsController::class, 'index'])->name('superadmin.payments');
    Route::post('/superadmin/payments/{id}/approve', [PaymentsController::class, 'approve'])->name('superadmin.payments.approve');
    Route::post('/superadmin/payments/{id}/reject', [PaymentsController::class, 'reject'])->name('superadmin.payments.reject');
});

Route::middleware(['auth', 'role:vendor'])->group(function () {
    Route::get('/vendor/dashboard', [VendorDashboardController::class, 'index'])->name('vendor.dashboard');
    Route::post('/vendor/subscription-purchases', [SubscriptionPurchaseController::class, 'store'])->name('vendor.subscription-purchases.store');

    Route::middleware(['subscription.active'])->group(function () {
        Route::get('/vendor/settings', [SettingsController::class, 'index'])->name('vendor.settings');
        Route::post('/vendor/settings', [SettingsController::class, 'update'])->name('vendor.settings.update');

        Route::get('/vendor/subscription/', [VendorSubscriptionController::class, 'index'])->name('vendor.subscription');

        Route::get('/vendor/dangerzone', [DangerZoneController::class, 'index'])->name('vendor.dangerzone');
        Route::post('/vendor/dangerzone/password', [DangerZoneController::class, 'updatePassword'])->name('vendor.dangerzone.password');
        Route::post('/vendor/dangerzone/cancel-subscription', [DangerZoneController::class, 'cancelSubscription'])->name('vendor.dangerzone.cancel-subscription');
    });
});
