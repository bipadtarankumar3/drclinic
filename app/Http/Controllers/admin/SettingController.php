<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Setting;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function setting_list()
    {
        $data['title'] = 'Platform Master Settings';

        // Find or create Platform Settings (where clinic_id is null)
        $setting = Setting::whereNull('clinic_id')->first();
        if (!$setting) {
            $setting = Setting::create([
                'clinic_id' => null,
                'platform_name' => 'DrClinic SaaS Platform',
                'platform_email' => 'support@drclinic.com',
                'clinic_phone_number' => '+91 9631775097',
                'pay_additional_amount' => 40,
                'default_trial_days' => 14,
                'currency_symbol' => '₹',
                'currency_code' => 'INR',
                'pay_key' => env('RAZORPAY_KEY', 'rzp_live_o68IIKjnecrKMN'),
                'pay_secret_key' => env('RAZORPAY_SECRET', 'uXUH7TSOwjoWszgq23Ec6GLF'),
                'payment_terms_and_condition' => "By using this medical clinic management SaaS platform, doctors and clinics agree to standard SaaS platform terms of service and compliance guidelines.",
                'frontend_notice' => "Welcome to DrClinic Cloud SaaS Platform.",
            ]);
        }

        $data['setting'] = $setting;
        return view('admin.pages.setting.setting_list', $data);
    }

    public function store(Request $request, $id = null)
    {
        $request->validate([
            'platform_name' => 'required|string|max:255',
            'platform_email' => 'nullable|email|max:255',
            'clinic_phone_number' => 'nullable|string|max:50',
            'pay_additional_amount' => 'nullable|numeric|min:0',
            'default_trial_days' => 'nullable|integer|min:0',
            'pay_key' => 'nullable|string|max:255',
            'pay_secret_key' => 'nullable|string|max:255',
        ]);

        $data = [
            'platform_name' => $request->platform_name,
            'platform_email' => $request->platform_email,
            'clinic_phone_number' => $request->clinic_phone_number,
            'pay_additional_amount' => $request->pay_additional_amount ?? 40,
            'default_trial_days' => $request->default_trial_days ?? 14,
            'currency_symbol' => $request->currency_symbol ?? '₹',
            'currency_code' => $request->currency_code ?? 'INR',
            'payment_terms_and_condition' => $request->payment_terms_and_condition,
            'frontend_notice' => $request->frontend_notice,
            'pay_key' => $request->pay_key,
            'pay_secret_key' => $request->pay_secret_key,
        ];

        // Find platform setting or create
        $setting = $id ? Setting::find($id) : Setting::whereNull('clinic_id')->first();
        if ($setting) {
            $setting->update($data);
        } else {
            $setting = Setting::create(array_merge($data, ['clinic_id' => null]));
        }

        // Sync to .env if Razorpay keys changed
        if ($request->filled('pay_key') && $request->filled('pay_secret_key')) {
            $this->updateEnv([
                'RAZORPAY_KEY' => $request->pay_key,
                'RAZORPAY_SECRET' => $request->pay_secret_key,
            ]);
        }

        if (class_exists(ActivityLog::class)) {
            ActivityLog::log('platform_settings_updated', 'Super Admin updated Platform Master Settings');
        }

        return redirect()->to('admin/setting')->with('success', 'Platform Master Settings updated successfully.');
    }

    protected function updateEnv(array $values)
    {
        $envPath = base_path('.env');
        if (file_exists($envPath)) {
            $content = file_get_contents($envPath);
            foreach ($values as $key => $val) {
                if (preg_match("/^{$key}=/m", $content)) {
                    $content = preg_replace("/^{$key}=.*/m", "{$key}={$val}", $content);
                } else {
                    $content .= "\n{$key}={$val}";
                }
            }
            file_put_contents($envPath, $content);
        }
    }

    public function edit($id)
    {
        $setting = Setting::findOrFail($id);
        $settings = Setting::all();

        return view('admin.pages.setting.setting_list', compact('setting', 'settings'));
    }

    public function destroy($id)
    {
        $Setting = Setting::findOrFail($id);
        $Setting->delete();

        return redirect()->back()->with('success', 'Setting deleted successfully!');
    }

    public function updatePaymentPermission(Request $request)
    {
        $status = $request->has('payment_permission_status') ? 'yes' : 'no';
    
        $setting = Setting::whereNull('clinic_id')->first() ?? Setting::first();
    
        if ($setting) {
            $setting->update(['payment_permission_status' => $status]);
        } else {
            Setting::create(['clinic_id' => null, 'payment_permission_status' => $status]);
        }
    
        return back()->with('success', 'Payment permission updated successfully.');
    }
}
