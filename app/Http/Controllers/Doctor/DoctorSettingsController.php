<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Clinic;
use App\Models\Setting;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DoctorSettingsController extends Controller
{
    public function index()
    {
        $clinic = Auth::user()->clinic;
        if (!$clinic) {
            return redirect()->route('doctor.onboarding');
        }

        $setting = Setting::where('clinic_id', $clinic->id)->first() ?? Setting::first();

        return view('doctor.settings', compact('clinic', 'setting'));
    }

    /**
     * Update General Clinic Details
     */
    public function updateProfile(Request $request)
    {
        $clinic = Auth::user()->clinic;

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'specialization' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'consultation_fee' => 'nullable|numeric|min:0',
            'bio' => 'nullable|string',
        ]);

        $clinic->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'specialization' => $request->specialization,
            'address' => $request->address,
            'consultation_fee' => $request->consultation_fee ?? 0,
            'bio' => $request->bio,
        ]);

        ActivityLog::log('clinic_profile_updated', 'Updated general clinic profile', $clinic->id);

        return back()->with('success', 'Clinic details updated successfully.');
    }

    /**
     * Update Doctor's Razorpay Payment Gateway Settings
     */
    public function updateRazorpay(Request $request)
    {
        $clinic = Auth::user()->clinic;

        $request->validate([
            'razorpay_key' => 'nullable|string|max:255',
            'razorpay_secret' => 'nullable|string|max:255',
            'razorpay_enabled' => 'nullable|boolean',
            'allow_cash_booking' => 'nullable|boolean',
        ]);

        $clinic->update([
            'razorpay_key' => $request->razorpay_key,
            'razorpay_secret' => $request->razorpay_secret,
            'razorpay_enabled' => $request->has('razorpay_enabled'),
            'allow_cash_booking' => $request->has('allow_cash_booking'),
        ]);

        ActivityLog::log('clinic_razorpay_updated', 'Updated Razorpay payment credentials', $clinic->id);

        return back()->with('success', 'Razorpay credentials saved. Online patient booking fees will now go directly to your Razorpay account.');
    }

    /**
     * Update Branding & Website Colors
     */
    public function updateBranding(Request $request)
    {
        $clinic = Auth::user()->clinic;

        $request->validate([
            'theme_color' => 'nullable|string|max:30',
            'secondary_color' => 'nullable|string|max:30',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:3072',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $data = [
            'theme_color' => $request->theme_color ?? '#0d6efd',
            'secondary_color' => $request->secondary_color ?? '#20c997',
        ];

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = 'logo_' . $clinic->id . '_' . time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('upload/clinic_logos'), $logoName);
            $data['logo'] = 'upload/clinic_logos/' . $logoName;
        }

        if ($request->hasFile('banner')) {
            $banner = $request->file('banner');
            $bannerName = 'banner_' . $clinic->id . '_' . time() . '.' . $banner->getClientOriginalExtension();
            $banner->move(public_path('upload/clinic_banners'), $bannerName);
            $data['banner'] = 'upload/clinic_banners/' . $bannerName;
        }

        $clinic->update($data);

        ActivityLog::log('clinic_branding_updated', 'Updated clinic theme colors and assets', $clinic->id);

        return back()->with('success', 'Branding and theme customization saved successfully.');
    }

    /**
     * Update Custom Domain & Subdomain
     */
    public function updateDomain(Request $request)
    {
        $clinic = Auth::user()->clinic;

        $request->validate([
            'subdomain' => 'required|alpha_dash|min:3|max:50|unique:clinics,subdomain,' . $clinic->id,
            'custom_domain' => 'nullable|string|max:190|unique:clinics,custom_domain,' . $clinic->id,
        ]);

        $customDomain = $request->custom_domain ? strtolower(trim(preg_replace('#^https?://#', '', $request->custom_domain), '/')) : null;

        $clinic->update([
            'subdomain' => strtolower($request->subdomain),
            'custom_domain' => $customDomain,
        ]);

        ActivityLog::log('clinic_domain_updated', "Updated domain settings (Subdomain: {$request->subdomain}, Custom: {$customDomain})", $clinic->id);

        return back()->with('success', 'Domain and subdomain settings updated.');
    }
}
