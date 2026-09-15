<?php

namespace App\Http\Middleware;

use App\Models\Feature;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckFeatureMaintenance
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $featureKey): Response
    {
        $feature = Feature::where('key', $featureKey)->first();

        if ($feature && $feature->is_maintenance) {
            // Render custom static maintenance page with the custom message
            return response()->view('vendor.maintenance', [
                'featureName' => $feature->name,
                'message' => $feature->maintenance_message ?? 'Fitur ini sedang dalam perbaikan rutin. Silakan kembali lagi nanti.',
            ], 503);
        }

        return $next($request);
    }
}
