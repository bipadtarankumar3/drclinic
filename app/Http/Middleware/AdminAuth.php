<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated',
                    'error' => 'Please login to access this page.',
                ], 401);
            }
            return redirect()->guest(route('login'))
                ->with('session_expired', true)
                ->with('error', 'Your session has expired due to inactivity. Please log in again to continue.');
        }

        $user = Auth::user();
        $isAllowed = in_array($user->user_type, ['admin', 'super_admin', 'doctor', 'clinic', 'user']) 
                     || $user->clinic 
                     || session()->has('impersonating_admin_id');

        if (!$isAllowed) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
