<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('admin.login')->with('error', 'Please log in to continue.');
        }

        // Allow impersonated user to exit impersonation and return to Super Admin
        if (session()->has('impersonating_admin_id') && $request->routeIs('admin.saas.stop_impersonate')) {
            return $next($request);
        }

        if (!auth()->user()->isSuperAdmin()) {
            // If they are a doctor, redirect them to their clinic dashboard
            if (auth()->user()->isDoctor() || auth()->user()->clinic) {
                return redirect()->route('doctor.dashboard')->with('error', 'Access restricted to Super Admin.');
            }
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
