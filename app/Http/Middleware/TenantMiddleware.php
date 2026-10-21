<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Clinic;
use App\Models\Setting;
use Illuminate\Support\Facades\View;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $clinic = $this->resolveClinic($request);

        if ($clinic) {
            app()->instance('currentClinic', $clinic);
            View::share('currentClinic', $clinic);

            // Fetch clinic setting or fallback
            $setting = Setting::where('clinic_id', $clinic->id)->first() ?? Setting::first();
            View::share('setting', $setting);

            // Plan expiration enforcement on public clinic pages
            if (!$clinic->isPlanActive() && $this->isPublicClinicRoute($request)) {
                return response()->view('web.pages.plan_expired', [
                    'clinic' => $clinic
                ], 402);
            }
        }

        return $next($request);
    }

    /**
     * Resolve clinic from Route slug, Custom Domain, Subdomain, Auth User, or Default
     */
    protected function resolveClinic(Request $request): ?Clinic
    {
        // 1. Check path slug /c/{slug} or route param
        if ($request->route('clinic_slug')) {
            $slug = $request->route('clinic_slug');
            $clinic = Clinic::where('slug', $slug)->orWhere('subdomain', $slug)->first();
            if ($clinic) return $clinic;
        }

        $pathSegments = $request->segments();
        if (isset($pathSegments[0]) && $pathSegments[0] === 'c' && isset($pathSegments[1])) {
            $clinic = Clinic::where('slug', $pathSegments[1])->orWhere('subdomain', $pathSegments[1])->first();
            if ($clinic) return $clinic;
        }

        // 2. Check Host for Custom Domain or Subdomain
        $host = strtolower($request->getHost());

        // Custom domain lookup
        $clinicByDomain = Clinic::where('custom_domain', $host)->first();
        if ($clinicByDomain) return $clinicByDomain;

        // Subdomain lookup
        $hostParts = explode('.', $host);
        if (count($hostParts) >= 2) {
            $subdomain = $hostParts[0];
            $reserved = ['www', 'admin', 'app', 'mail', 'api', 'localhost', '127'];
            if (!in_array($subdomain, $reserved)) {
                $clinicBySub = Clinic::where('subdomain', $subdomain)->first();
                if ($clinicBySub) return $clinicBySub;
            }
        }

        // 3. Authenticated Doctor's Clinic
        if (auth()->check() && auth()->user()->clinic) {
            return auth()->user()->clinic;
        }

        // 4. Default / Fallback Clinic
        return Clinic::first();
    }

    /**
     * Check if current request is a public patient route (that should be disabled if plan expired)
     */
    protected function isPublicClinicRoute(Request $request): bool
    {
        $path = $request->path();

        // Never block admin, doctor dashboard, auth, or webhook routes
        $bypassPrefixes = [
            'admin',
            'doctor',
            'login',
            'logout',
            'register',
            'auth',
            'api',
            'plans',
            'subscribe',
            'razorpay/webhook'
        ];

        foreach ($bypassPrefixes as $prefix) {
            if ($path === $prefix || str_starts_with($path, $prefix . '/')) {
                return false;
            }
        }

        return true;
    }
}
