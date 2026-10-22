<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Order;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Auth;

class DoctorDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $clinic = $user ? $user->getActiveClinic() : null;

        if (!$clinic) {
            return redirect()->route('doctor.onboarding');
        }

        // Clinic Metrics
        $totalPatients = Patient::where('clinic_id', $clinic->id)->count();
        $todayPatients = Patient::where('clinic_id', $clinic->id)->whereDate('created_at', today())->count();
        $totalOrders = Order::where('clinic_id', $clinic->id)->count();
        $totalEarnings = Order::where('clinic_id', $clinic->id)
            ->whereIn('payment_status', ['paid', 'success', 'captured'])
            ->sum('total_amount');

        // Recent bookings
        $recentBookings = Patient::where('clinic_id', $clinic->id)
            ->latest()
            ->take(8)
            ->get();

        // Available subscription plans for upgrade
        $plans = SubscriptionPlan::where('is_active', true)->orderBy('sort_order', 'asc')->get();

        $totalSlots = \App\Models\TimeSlot::where('clinic_id', $clinic->id)->count();
        $totalStaff = 1;

        return view('doctor.dashboard', compact(
            'clinic',
            'totalPatients',
            'todayPatients',
            'totalOrders',
            'totalEarnings',
            'recentBookings',
            'plans',
            'totalSlots',
            'totalStaff'
        ));
    }

    /**
     * Show Doctor Support & Help Center
     */
    public function support(Request $request)
    {
        $user = Auth::user();
        $clinic = $user ? $user->getActiveClinic() : null;

        if (!$clinic) {
            return redirect()->route('doctor.onboarding');
        }

        $setting = \App\Models\Setting::where('clinic_id', $clinic->id)->first() ?? \App\Models\Setting::first();

        return view('doctor.support', compact('clinic', 'setting', 'user'));
    }
}
