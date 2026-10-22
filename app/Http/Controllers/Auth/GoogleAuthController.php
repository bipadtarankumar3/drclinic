<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\Clinic;
use App\Models\Setting;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    /**
     * Redirect to Google OAuth
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback from Google
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('admin.login')->with('error', 'Google login failed: ' . $e->getMessage());
        }

        // Find or create user
        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        if (!$user) {
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'user_type' => 'doctor',
                'password' => Hash::make(Str::random(24)),
                'status' => 'approved',
                'email_verified_at' => now(),
            ]);

            ActivityLog::log('doctor_registered', 'Doctor registered via Google OAuth', null, $user->id);
        } else {
            // Update Google ID and Avatar if not set
            $user->update([
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar() ?? $user->avatar,
            ]);
        }

        Auth::login($user, true);

        // Check if user has a clinic
        $clinic = $user->clinic;
        if (!$clinic) {
            session(['show_onboarding_modal' => true]);
            return redirect()->route('clinic.onboarding');
        }

        ActivityLog::log('doctor_logged_in', 'Logged in via Google', $clinic->id, $user->id);

        if ($user->isSuperAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('clinic.dashboard');
    }

    /**
     * Show Onboarding Page / Modal
     */
    public function showOnboarding()
    {
        $user = Auth::user();
        if ($user->clinic) {
            return redirect()->route('clinic.dashboard');
        }

        return view('doctor.onboarding', compact('user'));
    }

    /**
     * Complete Doctor & Clinic Onboarding (7-Day Trial Setup)
     */
    public function completeOnboarding(Request $request)
    {
        $user = Auth::user();

        if ($user->clinic) {
            return redirect()->route('clinic.dashboard')->with('info', 'Your clinic is already configured.');
        }

        $request->validate([
            'clinic_name' => 'required|string|max:255',
            'subdomain' => 'required|alpha_dash|min:3|max:50|unique:clinics,subdomain|unique:clinics,slug',
            'specialization' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:500',
            'consultation_fee' => 'nullable|numeric|min:0',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $subdomain = strtolower($request->subdomain);
        $slug = Str::slug($request->clinic_name) . '-' . Str::random(4);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $ext = strtolower($file->getClientOriginalExtension()) ?: 'webp';
            $filename = time() . '_' . Str::slug($request->clinic_name) . '.' . $ext;
            $file->move(public_path('upload/clinic_logos'), $filename);
            $logoPath = 'upload/clinic_logos/' . $filename;
        }

        // Create Clinic with 7-Day Free Trial
        $clinic = Clinic::create([
            'user_id' => $user->id,
            'name' => $request->clinic_name,
            'slug' => $slug,
            'subdomain' => $subdomain,
            'custom_domain' => null,
            'logo' => $logoPath,
            'phone' => $request->phone ?? $user->phone,
            'email' => $user->email,
            'address' => $request->address,
            'specialization' => $request->specialization,
            'bio' => $request->bio,
            'consultation_fee' => $request->consultation_fee ?? 500.00,
            'theme_color' => '#0d6efd',
            'secondary_color' => '#20c997',
            'razorpay_enabled' => false,
            'allow_cash_booking' => true,
            'status' => 'trialing',
            'trial_ends_at' => now()->addDays(7),
        ]);

        // Create Default Setting for this clinic
        Setting::create([
            'clinic_id' => $clinic->id,
            'system_name' => $clinic->name,
            'email' => $clinic->email,
            'phone' => $clinic->phone,
            'address' => $clinic->address,
            'payment_currency' => 'INR',
            'payment_symbol' => '₹',
            'payment_terms_and_condition' => '1. Consultation fees are non-refundable.\n2. Please arrive 15 minutes before your scheduled appointment.',
        ]);

        ActivityLog::log(
            'clinic_created',
            "Created clinic {$clinic->name} with 7-day trial (Subdomain: {$subdomain})",
            $clinic->id,
            $user->id
        );

        session()->forget('show_onboarding_modal');

        return redirect()->route('clinic.dashboard')->with('success', '🎉 Welcome to Dr Clinic! Your 7-day free trial has been activated.');
    }
}
