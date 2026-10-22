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
        $clinic = Auth::user()->getActiveClinic();
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
        $clinic = Auth::user()->getActiveClinic();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'specialization' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'consultation_fee' => 'nullable|numeric|min:0',
            'platform_fee' => 'nullable|numeric|min:0',
            'bio' => 'nullable|string',
            'logo' => 'nullable|file|mimes:jpeg,png,jpg,webp,svg,gif,bmp|max:5120',
            'brand_display_mode' => 'nullable|in:both,logo_only,text_only',
        ]);

        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'specialization' => $request->specialization,
            'address' => $request->address,
            'consultation_fee' => $request->consultation_fee ?? 0,
            'platform_fee' => $request->filled('platform_fee') ? $request->platform_fee : 0.00,
            'bio' => $request->bio,
            'brand_display_mode' => $request->brand_display_mode ?? 'both',
        ];

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $ext = strtolower($logo->getClientOriginalExtension()) ?: 'webp';
            $logoName = 'logo_' . $clinic->id . '_' . time() . '.' . $ext;
            $logo->move(public_path('upload/clinic_logos'), $logoName);
            $data['logo'] = 'upload/clinic_logos/' . $logoName;
        }

        $clinic->update($data);

        ActivityLog::log('clinic_profile_updated', 'Updated general clinic profile, pricing, and logo', $clinic->id);

        return back()->with('success', 'Clinic details, pricing, and logo updated successfully.');
    }

    /**
     * Update Doctor's Razorpay Payment Gateway Settings
     */
    public function updateRazorpay(Request $request)
    {
        $clinic = Auth::user()->getActiveClinic();

        $request->validate([
            'razorpay_key' => 'nullable|string|max:255',
            'razorpay_secret' => 'nullable|string|max:255',
            'razorpay_enabled' => 'nullable|boolean',
            'allow_cash_booking' => 'nullable|boolean',
            'platform_fee' => 'nullable|numeric|min:0',
        ]);

        $updateData = [
            'razorpay_key' => $request->razorpay_key,
            'razorpay_secret' => $request->razorpay_secret,
            'razorpay_enabled' => $request->has('razorpay_enabled'),
            'allow_cash_booking' => $request->has('allow_cash_booking'),
        ];

        if ($request->has('platform_fee')) {
            $updateData['platform_fee'] = $request->filled('platform_fee') ? $request->platform_fee : 0.00;
        }

        $clinic->update($updateData);

        ActivityLog::log('clinic_razorpay_updated', 'Updated Razorpay payment credentials', $clinic->id);

        return back()->with('success', 'Razorpay credentials saved. Online patient booking fees will now go directly to your Razorpay account.');
    }

    /**
     * Update Branding & Website Colors
     */
    public function updateBranding(Request $request)
    {
        $clinic = Auth::user()->getActiveClinic();

        $request->validate([
            'theme_color' => 'nullable|string|max:30',
            'secondary_color' => 'nullable|string|max:30',
            'logo' => 'nullable|file|mimes:jpeg,png,jpg,webp,svg,gif,bmp|max:5120',
            'banner' => 'nullable|file|mimes:jpeg,png,jpg,webp,gif,bmp|max:5120',
            'topbar_tagline' => 'nullable|string|max:255',
            'topbar_hours' => 'nullable|string|max:255',
            'currency_text' => 'nullable|string|max:50',
        ]);

        $data = [
            'theme_color' => $request->theme_color ?? '#059669',
            'secondary_color' => $request->secondary_color ?? '#10b981',
            'topbar_tagline' => $request->filled('topbar_tagline') ? $request->topbar_tagline : 'Your Health, Our Priority',
            'topbar_hours' => $request->filled('topbar_hours') ? $request->topbar_hours : 'Open 7 Days a Week',
            'show_topbar' => $request->has('show_topbar'),
            'show_doctor_portal_link' => $request->has('show_doctor_portal_link'),
            'currency_text' => $request->filled('currency_text') ? $request->currency_text : 'INR (₹)',
        ];

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $ext = strtolower($logo->getClientOriginalExtension()) ?: 'webp';
            $logoName = 'logo_' . $clinic->id . '_' . time() . '.' . $ext;
            $logo->move(public_path('upload/clinic_logos'), $logoName);
            $data['logo'] = 'upload/clinic_logos/' . $logoName;
        }

        if ($request->hasFile('banner')) {
            $banner = $request->file('banner');
            $ext = strtolower($banner->getClientOriginalExtension()) ?: 'jpg';
            $bannerName = 'banner_' . $clinic->id . '_' . time() . '.' . $ext;
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
        $clinic = Auth::user()->getActiveClinic();

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
