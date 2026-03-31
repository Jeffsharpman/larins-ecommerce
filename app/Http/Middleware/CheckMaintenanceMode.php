<?php

namespace App\Http\Middleware;

use App\Settings\GeneralSettings;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $settings = app(GeneralSettings::class);

        if ($settings->maintenance_mode) {
            if (! Str::startsWith($request->path(), ['admin', 'filament', 'livewire', 'login'])) {
                return response()->view('errors.maintenance', [], 503);
            }
        }

        return $next($request);
    }
}
