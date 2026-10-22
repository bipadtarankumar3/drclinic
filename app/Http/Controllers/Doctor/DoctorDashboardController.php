<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Order;
use App\Models\TimeSlot;
use App\Models\ClinicService;
use App\Models\ActivityLog;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DoctorDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $clinic = $user ? $user->getActiveClinic() : null;

        if (!$clinic) {
            return redirect()->route('clinic.onboarding');
        }

        // Period filter for analytics (Default 30 days)
        $range = $request->get('range', '30_days');
        $days = match($range) {
            '7_days' => 7,
            '14_days' => 14,
            '30_days' => 30,
            '90_days' => 90,
            default => 30
        };

        $startDate = now()->subDays($days)->startOfDay();

        // 1. High-Level Clinic Metrics
        $totalPatients = Patient::where('clinic_id', $clinic->id)->count();
        $todayPatients = Patient::where('clinic_id', $clinic->id)->whereDate('created_at', today())->count();
        $thisMonthPatients = Patient::where('clinic_id', $clinic->id)->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();

        $totalOrders = Order::where('clinic_id', $clinic->id)->count();
        $completedConsultations = Order::where('clinic_id', $clinic->id)->whereIn('payment_status', ['paid', 'success', 'captured'])->count();
        $pendingConsultations = Order::where('clinic_id', $clinic->id)->where('payment_status', 'pending')->count();
        $cancelledConsultations = Order::where('clinic_id', $clinic->id)->where('payment_status', 'cancelled')->count();

        // Financials
        $totalEarnings = (float) Order::where('clinic_id', $clinic->id)
            ->whereIn('payment_status', ['paid', 'success', 'captured'])
            ->sum('total_amount');

        $onlineEarnings = (float) Order::where('clinic_id', $clinic->id)
            ->whereIn('payment_status', ['paid', 'success', 'captured'])
            ->where(function($q) {
                $q->where('razorpay_payment_id', 'not like', '%CASH%')
                  ->whereNotNull('razorpay_payment_id')
                  ->where('razorpay_payment_id', '!=', '');
            })
            ->sum('total_amount');

        $cashEarnings = (float) Order::where('clinic_id', $clinic->id)
            ->whereIn('payment_status', ['paid', 'success', 'captured'])
            ->where(function($q) {
                $q->where('razorpay_payment_id', 'like', '%CASH%')
                  ->orWhereNull('razorpay_payment_id')
                  ->orWhere('razorpay_payment_id', '');
            })
            ->sum('total_amount');

        $avgConsultationFee = $completedConsultations > 0 ? round($totalEarnings / $completedConsultations, 2) : 0;

        // 2. Trend Series: Last 14 Days (Daily Bookings & Daily Revenue)
        $trendDays = min($days, 14);
        $trendLabels = [];
        $trendBookings = [];
        $trendRevenue = [];

        for ($i = $trendDays - 1; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dateStr = $date->format('Y-m-d');
            $label = $date->format('d M');
            $trendLabels[] = $label;

            $bookingsCount = Order::where('clinic_id', $clinic->id)
                ->where(function($q) use ($dateStr) {
                    $q->whereDate('booking_date', $dateStr)
                      ->orWhereDate('created_at', $dateStr);
                })
                ->count();

            $revenueSum = (float) Order::where('clinic_id', $clinic->id)
                ->whereIn('payment_status', ['paid', 'success', 'captured'])
                ->where(function($q) use ($dateStr) {
                    $q->whereDate('booking_date', $dateStr)
                      ->orWhereDate('created_at', $dateStr);
                })
                ->sum('total_amount');

            $trendBookings[] = $bookingsCount;
            $trendRevenue[] = $revenueSum;
        }

        // If clinic is new and has no trend points in the last 14 days, populate total distribution
        if (array_sum($trendBookings) == 0 && $totalOrders > 0) {
            $trendBookings[count($trendBookings) - 1] = $totalOrders;
            $trendRevenue[count($trendRevenue) - 1] = $totalEarnings;
        }

        // 3. Status Breakdown
        $statusLabels = ['Completed', 'Pending', 'Cancelled'];
        $statusData = [$completedConsultations ?: ($totalOrders ?: 0), $pendingConsultations, $cancelledConsultations];

        // 4. Payment Mode Breakdown
        $paymentLabels = ['Razorpay Online', 'Cash at Desk'];
        $paymentData = [
            $onlineEarnings ?: ($totalEarnings > 0 ? $totalEarnings : 0),
            $cashEarnings
        ];

        // 5. Patient Gender Demographics
        $maleCount = Patient::where('clinic_id', $clinic->id)->where(function($q) {
            $q->where('sex', 'like', 'm%')->orWhere('sex', 'like', 'M%');
        })->count();

        $femaleCount = Patient::where('clinic_id', $clinic->id)->where(function($q) {
            $q->where('sex', 'like', 'f%')->orWhere('sex', 'like', 'F%');
        })->count();

        $otherCount = max(0, $totalPatients - ($maleCount + $femaleCount));
        $genderLabels = ['Male Patients', 'Female Patients', 'Other / Pediatric'];
        $genderData = [$maleCount, $femaleCount, $otherCount];

        // 6. Patient Age Demographics
        $agePediatric = Patient::where('clinic_id', $clinic->id)->where('age', '<', 18)->count();
        $ageYoung = Patient::where('clinic_id', $clinic->id)->whereBetween('age', [18, 35])->count();
        $ageMiddle = Patient::where('clinic_id', $clinic->id)->whereBetween('age', [36, 55])->count();
        $ageSenior = Patient::where('clinic_id', $clinic->id)->where('age', '>', 55)->count();
        $ageLabels = ['Under 18', '18 - 35 Yrs', '36 - 55 Yrs', '55+ Senior'];
        $ageData = [$agePediatric, $ageYoung, $ageMiddle, $ageSenior];

        // 7. Top Medical Complaints & Symptoms
        $topComplaintsQuery = Patient::where('clinic_id', $clinic->id)
            ->whereNotNull('patient_problem')
            ->where('patient_problem', '!=', '')
            ->select('patient_problem', DB::raw('count(*) as total'))
            ->groupBy('patient_problem')
            ->orderByDesc('total')
            ->take(6)
            ->get();

        $complaintLabels = [];
        $complaintData = [];
        foreach ($topComplaintsQuery as $item) {
            $complaintLabels[] = \Illuminate\Support\Str::limit($item->patient_problem, 22);
            $complaintData[] = (int) $item->total;
        }

        if (empty($complaintLabels)) {
            $complaintLabels = ['General Clinical Checkup', 'Hypertension & Heart', 'Migraine & Tension', 'Joint & Orthopedics', 'Diabetes Care'];
            $complaintData = [max(1, (int)$totalPatients), 0, 0, 0, 0];
        }

        // 8. Time Slots & Schedule Utilization
        $totalSlots = TimeSlot::where('clinic_id', $clinic->id)->count();
        $allSlots = TimeSlot::where('clinic_id', $clinic->id)->get();
        $slotLabels = [];
        $slotData = [];
        foreach ($allSlots as $slot) {
            $timeLabel = \Carbon\Carbon::parse($slot->from_time)->format('h:i A') . ' - ' . \Carbon\Carbon::parse($slot->to_time)->format('h:i A');
            $slotLabels[] = $timeLabel;
            $slotData[] = Order::where('clinic_id', $clinic->id)->where('time_slot_id', $slot->id)->count();
        }

        // 9. Tables Data
        // Table 1: Today's Active Schedule / OPD Queue
        $todayAppointments = Order::where('clinic_id', $clinic->id)
            ->where(function($q) {
                $q->whereDate('booking_date', today())
                  ->orWhereDate('created_at', today());
            })
            ->with('patient')
            ->latest()
            ->get();

        if ($todayAppointments->isEmpty()) {
            $todayAppointments = Order::where('clinic_id', $clinic->id)
                ->with('patient')
                ->latest()
                ->take(6)
                ->get();
        }

        // Table 2: Recent Patient Directory (10 records)
        $recentBookings = Patient::where('clinic_id', $clinic->id)
            ->latest()
            ->take(10)
            ->get();

        // Table 3: Financial Receipts & Settlement Transaction Ledger (10 records)
        $recentOrders = Order::where('clinic_id', $clinic->id)
            ->with('patient')
            ->latest()
            ->take(10)
            ->get();

        // Table 4: Clinic Services & Tariff Portfolio
        $clinicServices = ClinicService::where('clinic_id', $clinic->id)
            ->orderBy('price', 'desc')
            ->get();

        // Table 5: Activity Logs
        $activityLogs = ActivityLog::where('clinic_id', $clinic->id)
            ->latest()
            ->take(8)
            ->get();

        // Plans for subscription upgrade
        $plans = SubscriptionPlan::where('is_active', true)->orderBy('sort_order', 'asc')->get();
        $totalStaff = 1;

        return view('doctor.dashboard', compact(
            'clinic',
            'range',
            'totalPatients',
            'todayPatients',
            'thisMonthPatients',
            'totalOrders',
            'completedConsultations',
            'pendingConsultations',
            'cancelledConsultations',
            'totalEarnings',
            'onlineEarnings',
            'cashEarnings',
            'avgConsultationFee',
            'trendLabels',
            'trendBookings',
            'trendRevenue',
            'statusLabels',
            'statusData',
            'paymentLabels',
            'paymentData',
            'genderLabels',
            'genderData',
            'ageLabels',
            'ageData',
            'complaintLabels',
            'complaintData',
            'slotLabels',
            'slotData',
            'totalSlots',
            'totalStaff',
            'todayAppointments',
            'recentBookings',
            'recentOrders',
            'clinicServices',
            'activityLogs',
            'plans'
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
            return redirect()->route('clinic.onboarding');
        }

        $setting = \App\Models\Setting::where('clinic_id', $clinic->id)->first() ?? \App\Models\Setting::first();

        return view('doctor.support', compact('clinic', 'setting', 'user'));
    }
}
