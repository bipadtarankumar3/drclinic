<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Clinic;
use App\Models\User;
use App\Models\SubscriptionPlan;
use App\Models\ClinicSubscription;
use App\Models\Patient;
use App\Models\Order;
use App\Models\ActivityLog;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SaaSAdminController extends Controller
{
    /**
     * Super Admin Analytics Dashboard with Charts & KPIs
     */
    public function dashboard(Request $request)
    {
        // Date filter
        $range = $request->get('range', '30_days');
        $startDate = match ($range) {
            '7_days' => now()->subDays(7),
            '30_days' => now()->subDays(30),
            '90_days' => now()->subDays(90),
            '1_year' => now()->subYear(),
            default => now()->subDays(30),
        };

        // KPI Counts
        $totalClinics = Clinic::count();
        $activeClinics = Clinic::where('status', 'active')->count();
        $trialingClinics = Clinic::where('status', 'trialing')->where('trial_ends_at', '>=', now())->count();
        $expiredClinics = Clinic::where(function ($q) {
            $q->where('status', 'expired')
              ->orWhere(function ($sub) {
                  $sub->where('status', 'trialing')->where('trial_ends_at', '<', now());
              });
        })->count();

        $totalDoctors = User::where('user_type', 'doctor')->count();
        $totalPlatformRevenue = ClinicSubscription::where('status', 'active')->sum('amount');
        if ($totalPlatformRevenue == 0) {
            $totalPlatformRevenue = ClinicSubscription::sum('amount');
        }
        $totalPatientAppointments = Patient::count();
        $totalGrossConsultation = Order::where('payment_status', 'success')->sum('total_amount');
        $successfulAppointmentsCount = Order::where('payment_status', 'success')->count();
        $recentBookingsCount = Order::where('created_at', '>=', now()->subDays(30))->count();

        // Chart 1: Monthly Subscription Revenue Trend (Last 6 Months)
        $rawRevenue = ClinicSubscription::whereNotNull('created_at')
            ->selectRaw('DATE_FORMAT(created_at, "%b %Y") as month_name, SUM(amount) as total')
            ->groupBy('month_name')
            ->pluck('total', 'month_name')
            ->toArray();

        // Fill last 6 months sequence for continuous display
        $revenueTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $m = now()->subMonths($i)->format('M Y');
            $revenueTrend[$m] = isset($rawRevenue[$m]) ? (float)$rawRevenue[$m] : 0;
        }
        if (array_sum($revenueTrend) == 0 && $totalPlatformRevenue > 0) {
            $revenueTrend[now()->format('M Y')] = (float)$totalPlatformRevenue;
        }

        // Chart 2: Monthly Patient Appointments Volume Trend (Last 8 Months)
        $rawBookings = Order::whereNotNull('created_at')
            ->where('created_at', '>=', now()->subMonths(7)->startOfMonth())
            ->selectRaw('DATE_FORMAT(created_at, "%b %Y") as month_name, COUNT(*) as count')
            ->groupBy('month_name')
            ->orderByRaw('MIN(created_at) ASC')
            ->pluck('count', 'month_name')
            ->toArray();

        $appointmentsTrend = [];
        for ($i = 7; $i >= 0; $i--) {
            $m = now()->subMonths($i)->format('M Y');
            $appointmentsTrend[$m] = isset($rawBookings[$m]) ? (int)$rawBookings[$m] : 0;
        }

        // Chart 3: Plan Distribution
        $planDistribution = SubscriptionPlan::withCount(['subscriptions' => function ($q) {
            $q->where('status', 'active');
        }])->get();

        // Chart 4: Clinic Status Breakdown
        $statusBreakdown = [
            'Active' => $activeClinics,
            '7-Day Trial' => $trialingClinics,
            'Expired' => $expiredClinics,
        ];

        // Chart 5: Patient Payment Mode Split (Razorpay vs Counter/Cash)
        $paymentModes = Order::selectRaw('COALESCE(NULLIF(transaction_mode, ""), "Razorpay Online") as mode, COUNT(*) as count')
            ->groupBy('mode')
            ->pluck('count', 'mode')
            ->toArray();

        // Table 1: Registered Doctor Clinics Directory
        $recentClinics = Clinic::with('user', 'activeSubscription.plan')
            ->withCount(['patients', 'orders'])
            ->latest()
            ->take(8)
            ->get();

        // Table 2: Recent SaaS Subscription Billing Invoices
        $recentSubscriptions = ClinicSubscription::with('clinic.user', 'plan')
            ->latest()
            ->take(8)
            ->get();

        // Table 3: Top Performing Doctor Clinics (Ranked by order volume & gross bookings)
        $topClinics = Clinic::with('user', 'activeSubscription.plan')
            ->withCount(['patients', 'orders'])
            ->withSum(['orders' => function ($q) {
                $q->where('payment_status', 'success');
            }], 'total_amount')
            ->orderBy('orders_count', 'desc')
            ->take(5)
            ->get();

        // Table 4: Recent Patient Appointments Across Platform
        $recentAppointments = Order::with('patient', 'clinic')
            ->latest()
            ->take(8)
            ->get();

        // Table 5: Recent Activity Logs
        $recentLogs = ActivityLog::with('user', 'clinic')->latest()->take(10)->get();

        return view('admin.saas.dashboard', compact(
            'totalClinics',
            'activeClinics',
            'trialingClinics',
            'expiredClinics',
            'totalDoctors',
            'totalPlatformRevenue',
            'totalPatientAppointments',
            'totalGrossConsultation',
            'successfulAppointmentsCount',
            'recentBookingsCount',
            'revenueTrend',
            'appointmentsTrend',
            'planDistribution',
            'statusBreakdown',
            'paymentModes',
            'recentClinics',
            'recentSubscriptions',
            'topClinics',
            'recentAppointments',
            'recentLogs',
            'range'
        ));
    }

    /**
     * All Clinics Directory with Search and Status Filter
     */
    public function clinics(Request $request)
    {
        $query = Clinic::with('user', 'activeSubscription.plan');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('subdomain', 'like', "%{$search}%")
                  ->orWhere('custom_domain', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $clinics = $query->latest()->paginate(15);

        return view('admin.saas.clinics', compact('clinics'));
    }

    /**
     * Edit / Manage Clinic (Extend trial, update status, change domain)
     */
    public function editClinic($id)
    {
        $clinic = Clinic::with('user', 'subscriptions.plan')->findOrFail($id);
        $plans = SubscriptionPlan::all();

        return view('admin.saas.clinic_edit', compact('clinic', 'plans'));
    }

    public function updateClinic(Request $request, $id)
    {
        $clinic = Clinic::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:active,trialing,expired,suspended',
            'subdomain' => 'required|alpha_dash|unique:clinics,subdomain,' . $clinic->id,
            'custom_domain' => 'nullable|string|unique:clinics,custom_domain,' . $clinic->id,
            'trial_extend_days' => 'nullable|integer|min:0',
        ]);

        $trialEndsAt = $clinic->trial_ends_at;
        if ($request->filled('trial_extend_days') && $request->trial_extend_days > 0) {
            $base = ($trialEndsAt && $trialEndsAt->isFuture()) ? $trialEndsAt : now();
            $trialEndsAt = $base->addDays((int) $request->trial_extend_days);
        }

        $clinic->update([
            'name' => $request->name,
            'status' => $request->status,
            'subdomain' => strtolower($request->subdomain),
            'custom_domain' => $request->custom_domain ? strtolower(trim($request->custom_domain)) : null,
            'trial_ends_at' => $trialEndsAt,
        ]);

        ActivityLog::log('super_admin_updated_clinic', "Super Admin updated clinic: {$clinic->name}", $clinic->id);

        return redirect()->route('admin.saas.clinics')->with('success', "Clinic {$clinic->name} updated successfully.");
    }

    /**
     * Impersonate / Login-As Doctor
     */
    public function impersonate($id)
    {
        $clinic = Clinic::findOrFail($id);
        if (!$clinic->user) {
            return back()->with('error', 'This clinic does not have an attached doctor account.');
        }

        session([
            'impersonating_admin_id' => Auth::id(),
            'active_clinic_id' => $clinic->id
        ]);
        Auth::login($clinic->user);

        return redirect()->route('doctor.dashboard')->with('info', "Logged in as Dr. {$clinic->user->name} ({$clinic->name})");
    }

    /**
     * Directly Visit / View a Doctor's Subscription Plan
     */
    public function visitDoctorPlan($id)
    {
        $clinic = Clinic::findOrFail($id);
        if (!$clinic->user) {
            return back()->with('error', 'This clinic does not have an attached doctor account.');
        }

        session([
            'impersonating_admin_id' => Auth::id(),
            'active_clinic_id' => $clinic->id
        ]);
        Auth::login($clinic->user);

        return redirect()->route('doctor.subscription.index')->with('info', "Viewing subscription & plan for Dr. {$clinic->user->name} ({$clinic->name})");
    }

    /**
     * Stop Impersonating and Return to Super Admin
     */
    public function stopImpersonate()
    {
        $adminId = session('impersonating_admin_id');
        if ($adminId) {
            $adminUser = User::find($adminId);
            if ($adminUser) {
                Auth::login($adminUser);
                session()->forget(['impersonating_admin_id', 'active_clinic_id']);
                return redirect()->route('admin.saas.clinics')->with('success', 'Returned to Super Admin Panel.');
            }
        }

        session()->forget(['impersonating_admin_id', 'active_clinic_id']);
        return redirect()->route('login');
    }

    /**
     * Platform Subscription Plans Management
     */
    public function plans()
    {
        $plans = SubscriptionPlan::withCount('subscriptions')->orderBy('sort_order', 'asc')->get();
        return view('admin.saas.plans', compact('plans'));
    }

    public function storePlan(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'billing_cycle' => 'required|in:monthly,yearly,lifetime',
            'description' => 'nullable|string',
            'features' => 'nullable|string', // newline separated
        ]);

        $features = array_filter(array_map('trim', explode("\n", $request->features ?? '')));

        SubscriptionPlan::create([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name),
            'price' => $request->price,
            'duration_days' => $request->duration_days,
            'billing_cycle' => $request->billing_cycle,
            'description' => $request->description,
            'features' => $features,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        ActivityLog::log('plan_created', "Super Admin created plan: {$request->name}");

        return back()->with('success', 'Subscription plan created.');
    }

    public function updatePlan(Request $request, $id)
    {
        $plan = SubscriptionPlan::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'billing_cycle' => 'required|in:monthly,yearly,lifetime',
            'description' => 'nullable|string',
            'features' => 'nullable|string',
        ]);

        $features = array_filter(array_map('trim', explode("\n", $request->features ?? '')));

        $plan->update([
            'name' => $request->name,
            'price' => $request->price,
            'duration_days' => $request->duration_days,
            'billing_cycle' => $request->billing_cycle,
            'description' => $request->description,
            'features' => $features,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        ActivityLog::log('plan_updated', "Super Admin updated plan: {$plan->name}");

        return back()->with('success', 'Plan updated.');
    }

    /**
     * Activity & Audit Logs
     */
    public function logs(Request $request)
    {
        $query = ActivityLog::with('user', 'clinic');

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        $logs = $query->latest()->paginate(25);
        $actions = ActivityLog::select('action')->distinct()->pluck('action');

        return view('admin.saas.logs', compact('logs', 'actions'));
    }

    /**
     * Platform Razorpay Gateway Settings
     */
    public function platformPaymentSettings()
    {
        $setting = Setting::whereNull('clinic_id')->first() ?? Setting::first();
        return view('admin.saas.payment_settings', compact('setting'));
    }

    public function updatePlatformPaymentSettings(Request $request)
    {
        $request->validate([
            'platform_razorpay_key' => 'required|string|max:255',
            'platform_razorpay_secret' => 'required|string|max:255',
        ]);

        // We can update .env or settings table
        $setting = Setting::whereNull('clinic_id')->first() ?? Setting::first();
        if ($setting) {
            $setting->update([
                'razorpay_key' => $request->platform_razorpay_key,
                'razorpay_secret' => $request->platform_razorpay_secret,
            ]);
        }

        // Also update .env file dynamically
        $this->updateEnv([
            'RAZORPAY_KEY' => $request->platform_razorpay_key,
            'RAZORPAY_SECRET' => $request->platform_razorpay_secret,
        ]);

        ActivityLog::log('platform_payment_settings_updated', 'Super Admin updated platform Razorpay credentials');

        return back()->with('success', 'Platform Razorpay settings saved. Doctors can now pay for subscription plans.');
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
}
