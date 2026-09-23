<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageProxyController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Superadmin\DashboardController;
use App\Http\Controllers\Superadmin\FeatureController;
use App\Http\Controllers\Superadmin\PaymentsController;
use App\Http\Controllers\Superadmin\SubscriptionController;
use App\Http\Controllers\Superadmin\SubscriptionPlanController;
use App\Http\Controllers\Superadmin\VendorManagementController;
use App\Http\Controllers\Vendor\BookingsController;
use App\Http\Controllers\Vendor\CalendarController;
use App\Http\Controllers\Vendor\DangerZoneController;
use App\Http\Controllers\Vendor\ForcePasswordController;
use App\Http\Controllers\Vendor\ItemsCategoryController;
use App\Http\Controllers\Vendor\ItemsController;
use App\Http\Controllers\Vendor\SettingsController;
use App\Http\Controllers\Vendor\SubscriptionController as VendorSubscriptionController;
use App\Http\Controllers\Vendor\SubscriptionPurchaseController;
use App\Http\Controllers\Vendor\VendorDashboardController;
use App\Http\Controllers\Vendor\VerificationsController;

// Route::get('/', function () {
//     return view('landing');
// });

Route::get('/', [LandingPageController::class, 'index'])->name('landing');
Route::get('/image/{path}', [ImageProxyController::class, 'show'])->where('path', '.*')->name('image.proxy');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login')->name('login.store');
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
    Route::post('/superadmin/vendor/{id}/reset-password', [VendorManagementController::class, 'resetPassword'])->name('superadmin-vendor-management.reset-password');

    Route::get('/superadmin/payments', [PaymentsController::class, 'index'])->name('superadmin.payments');
    Route::post('/superadmin/payments/{id}/approve', [PaymentsController::class, 'approve'])->name('superadmin.payments.approve');
    Route::post('/superadmin/payments/{id}/reject', [PaymentsController::class, 'reject'])->name('superadmin.payments.reject');

    Route::get('/superadmin/features', [FeatureController::class, 'index'])->name('superadmin.features.index');
    Route::post('/superadmin/features', [FeatureController::class, 'store'])->name('superadmin.features.store');
    Route::put('/superadmin/features/{id}', [FeatureController::class, 'update'])->name('superadmin.features.update');
    Route::put('/superadmin/features/{id}/maintenance', [FeatureController::class, 'toggleMaintenance'])->name('superadmin.features.maintenance');
    Route::delete('/superadmin/features/{id}', [FeatureController::class, 'destroy'])->name('superadmin.features.destroy');
});

Route::middleware(['auth', 'role:vendor'])->group(function () {
    Route::get('/vendor/force-password', [ForcePasswordController::class, 'edit'])->name('vendor.force-password');
    Route::post('/vendor/force-password', [ForcePasswordController::class, 'update'])->name('vendor.force-password.update');

    Route::middleware('password.changed')->group(function () {
        Route::get('/vendor/dashboard', [VendorDashboardController::class, 'index'])->name('vendor.dashboard');
        Route::post('/vendor/subscription-purchases', [SubscriptionPurchaseController::class, 'store'])->name('vendor.subscription-purchases.store');

        Route::middleware(['subscription.active'])->group(function () {
            Route::get('/vendor/settings', [SettingsController::class, 'index'])->name('vendor.settings');
            Route::post('/vendor/settings', [SettingsController::class, 'update'])->name('vendor.settings.update');

            Route::get('/vendor/bookings/', [BookingsController::class, 'index'])
                ->middleware(['feature.access:booking_system', 'feature.maintenance:booking_system'])
                ->name('vendor.bookings');

            Route::get('/vendor/calendar', [CalendarController::class, 'index'])
                ->middleware(['feature.access:booking_system', 'feature.maintenance:booking_system'])
                ->name('vendor.calendar');

            Route::get('/vendor/verifications', [VerificationsController::class, 'index'])
                ->middleware(['feature.access:verifikasi_ktp', 'feature.maintenance:verifikasi_ktp'])
                ->name('vendor.verifications');

            Route::middleware(['feature.access:asset_management', 'feature.maintenance:asset_management'])->group(function () {
                Route::get('/vendor/items', [ItemsController::class, 'index'])->name('vendor.items');
                Route::post('/vendor/items', [ItemsController::class, 'store'])->name('vendor.items.store');
                Route::put('/vendor/items/{id}', [ItemsController::class, 'update'])->name('vendor.items.update');
                Route::delete('/vendor/items/{id}', [ItemsController::class, 'destroy'])->name('vendor.items.destroy');
            });

            Route::middleware(['feature.access:category_management', 'feature.maintenance:category_management'])->group(function () {
                Route::get('/vendor/category', [ItemsCategoryController::class, 'index'])->name('vendor.category');
                Route::post('/vendor/category', [ItemsCategoryController::class, 'store'])->name('vendor.category.store');
                Route::put('/vendor/category/{id}', [ItemsCategoryController::class, 'update'])->name('vendor.category.update');
                Route::delete('/vendor/category/{id}', [ItemsCategoryController::class, 'destroy'])->name('vendor.category.destroy');
            });

            Route::get('/vendor/subscription/', [VendorSubscriptionController::class, 'index'])->name('vendor.subscription');

            Route::get('/vendor/dangerzone', [DangerZoneController::class, 'index'])->name('vendor.dangerzone');
            Route::post('/vendor/dangerzone/password', [DangerZoneController::class, 'updatePassword'])->name('vendor.dangerzone.password');
            Route::post('/vendor/dangerzone/cancel-subscription', [DangerZoneController::class, 'cancelSubscription'])->name('vendor.dangerzone.cancel-subscription');
        });
    });
});
