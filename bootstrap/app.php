<?php

use App\Http\Middleware\CheckFeatureAccess;
use App\Http\Middleware\CheckFeatureMaintenance;
use App\Http\Middleware\CheckRole;
use App\Http\Middleware\CheckStatus;
use App\Http\Middleware\EnsurePasswordChanged;
use App\Http\Middleware\EnsureSubscriptionActive;
use App\Http\Middleware\EnsureVendorActive;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        apiPrefix: 'api',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Wajib aktif agar Auth::logoutOtherDevices() benar-benar
        // memutus sesi perangkat lain setelah password diganti/direset.
        $middleware->authenticateSessions();

        $middleware->alias([
            'role' => CheckRole::class,
            'status' => CheckStatus::class,
            'vendor.active' => EnsureVendorActive::class,
            'subscription.active' => EnsureSubscriptionActive::class,
            'feature.maintenance' => CheckFeatureMaintenance::class,
            'feature.access' => CheckFeatureAccess::class,
            'password.changed' => EnsurePasswordChanged::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
