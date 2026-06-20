<?php

namespace App\Http\Middleware;

use App\Models\SystemSetting;
use Closure;
use Illuminate\Http\Request;

class MaintenanceMode
{
    public function handle(Request $request, Closure $next)
    {
        if (SystemSetting::get('maintenance_mode', false)) {
            // Allow admins to bypass
            if (auth()->check() && auth()->user()->isAdmin()) {
                return $next($request);
            }

            // Allow specific routes
            if ($request->routeIs('login') || $request->routeIs('logout') || $request->is('admin/*')) {
                return $next($request);
            }

            $message = SystemSetting::get('maintenance_message', 'Under maintenance');

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => $message], 503);
            }

            return response()->view('errors.maintenance', ['message' => $message], 503);
        }

        return $next($request);
    }
}
