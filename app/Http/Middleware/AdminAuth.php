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
            return redirect()->route('login');
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
