<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Models\ClinicSubscription;
use App\Models\ActivityLog;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Auth;

class DoctorSubscriptionController extends Controller
{
    public function index()
    {
        $clinic = Auth::user()->getActiveClinic();
        if (!$clinic) {
            return redirect()->route('doctor.onboarding');
        }

        $plans = SubscriptionPlan::where('is_active', true)->orderBy('sort_order', 'asc')->get();
        $subscriptions = ClinicSubscription::where('clinic_id', $clinic->id)->with('plan')->latest()->get();
        $features = \App\Http\Controllers\Admin\SaaSAdminController::getAvailableFeatures();

        return view('doctor.subscription', compact('clinic', 'plans', 'subscriptions', 'activeSub', 'features'));
    }

    /**
     * Create Razorpay Order for Plan Subscription
     */
    public function createOrder(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id',
        ]);

        $clinic = Auth::user()->getActiveClinic();
        $plan = SubscriptionPlan::findOrFail($request->plan_id);

        $platformKey = config('services.razorpay.key', env('RAZORPAY_KEY'));
        $platformSecret = config('services.razorpay.secret', env('RAZORPAY_SECRET'));

        if (!$platformKey || !$platformSecret) {
            return response()->json([
                'success' => false,
                'message' => 'Platform payment gateway is currently being configured by Admin. Please contact support.'
            ], 400);
        }

        try {
            $api = new Api($platformKey, $platformSecret);

            $orderData = [
                'receipt' => 'sub_' . $clinic->id . '_' . time(),
                'amount' => (int) round($plan->price * 100), // amount in paise
                'currency' => 'INR',
                'payment_capture' => 1
            ];

            $razorpayOrder = $api->order->create($orderData);

            return response()->json([
                'success' => true,
                'order_id' => $razorpayOrder['id'],
                'amount' => $plan->price,
                'amount_paise' => $orderData['amount'],
                'currency' => 'INR',
                'plan_name' => $plan->name,
                'key' => $platformKey,
                'clinic_name' => $clinic->name,
                'doctor_email' => Auth::user()->email,
                'doctor_phone' => $clinic->phone ?? Auth::user()->phone
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error initializing payment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verify Payment and Activate Subscription
     */
    public function verifyPayment(Request $request)
    {
        $request->validate([
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
            'razorpay_signature' => 'required|string',
            'plan_id' => 'required|exists:subscription_plans,id',
        ]);

        $clinic = Auth::user()->getActiveClinic();
        $plan = SubscriptionPlan::findOrFail($request->plan_id);

        $platformKey = config('services.razorpay.key', env('RAZORPAY_KEY'));
        $platformSecret = config('services.razorpay.secret', env('RAZORPAY_SECRET'));

        try {
            $api = new Api($platformKey, $platformSecret);
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ];

            $api->utility->verifyPaymentSignature($attributes);

            // Compute subscription dates
            $startsAt = now();
            // If already active, extend from previous ends_at
            $previousActive = $clinic->activeSubscription;
            if ($previousActive && $previousActive->ends_at && $previousActive->ends_at->isFuture()) {
                $startsAt = $previousActive->ends_at;
            }

            $endsAt = (clone $startsAt)->addDays($plan->duration_days);

            // Create subscription record
            $sub = ClinicSubscription::create([
                'clinic_id' => $clinic->id,
                'plan_id' => $plan->id,
                'status' => 'active',
                'starts_at' => $startsAt,
                'ends_at' => $endsAt,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_order_id' => $request->razorpay_order_id,
                'amount' => $plan->price,
            ]);

            // Update Clinic status
            $clinic->update([
                'status' => 'active',
                'trial_ends_at' => $endsAt,
            ]);

            ActivityLog::log(
                'subscription_purchased',
                "Subscribed to {$plan->name} (₹{$plan->price}) - Valid until " . $endsAt->format('d M, Y'),
                $clinic->id
            );

            return response()->json([
                'success' => true,
                'message' => 'Subscription activated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed: ' . $e->getMessage()
            ], 400);
        }
    }
}
