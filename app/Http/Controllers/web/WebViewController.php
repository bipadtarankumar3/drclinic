<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\Availability;
use App\Models\Setting;
use App\Models\TimeSlot;
use App\Models\Order;
use App\Models\Patient;
use App\Models\Clinic;
use App\Models\ClinicPage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class WebViewController extends Controller
{
    protected function getClinic($clinic_slug = null)
    {
        if ($clinic_slug) {
            $c = Clinic::where('slug', $clinic_slug)->orWhere('subdomain', $clinic_slug)->first();
            if ($c) return $c;
        }
        return app()->bound('currentClinic') ? app('currentClinic') : Clinic::first();
    }

    public function index(){
        $data['title'] = 'Home';
        return view('web.pages.index',$data);
    }
    public function contact(){
        $data['title'] = 'contact';
        return view('web.pages.contact',$data);
    }
    public function about(){
        $data['title'] = 'about';
        return view('web.pages.about',$data);
    }
    public function facilities(){
        $data['title'] = 'facilities';
        return view('web.pages.facilities',$data);
    }
    public function testimonials(){
        $data['title'] = 'testimonials';
        return view('web.pages.testimonials',$data);
    }
    public function gallery(){
        $data['title'] = 'gallery';
        return view('web.pages.gallery',$data);
    }
    public function faq(){
        $data['title'] = 'faq';
        return view('web.pages.faq',$data);
    }
    public function career(){
        $data['title'] = 'career';
        return view('web.pages.carrer',$data);
    }
    public function paralysis_stroke(){
        $data['title'] = 'paralysis_stroke';
        return view('web.pages.paralysis_stroke',$data);
    }
    public function migraine(){
        $data['title'] = 'migraine';
        return view('web.pages.migraine',$data);
    }
    public function fits_treatment(){
        $data['title'] = 'fits_treatment';
        return view('web.pages.fits_treatment',$data);
    }
    public function parkinson_disease(){
        $data['title'] = 'parkinson_disease';
        return view('web.pages.parkinson_disease',$data);
    }
    public function neck_back_pain(){
        $data['title'] = 'neck_back_pain';
        return view('web.pages.neck_back_pain',$data);
    }
    public function brain_fever(){
        $data['title'] = 'brain_fever';
        return view('web.pages.brain_fever',$data);
    }
    public function dizziness_vertigo(){
        $data['title'] = 'dizziness_vertigo';
        return view('web.pages.dizziness_vertigo',$data);
    }
    public function muscle_disorders(){
        $data['title'] = 'muscle_disorders';
        return view('web.pages.muscle_disorders',$data);
    }
    public function memory(){
        $data['title'] = 'memory';
        return view('web.pages.memory',$data);
    }
    public function pediatric(){
        $data['title'] = 'pediatric';
        return view('web.pages.pediatric',$data);
    }



    public function appoinment($clinic_slug = null){
        $clinic = $this->getClinic($clinic_slug);
        $data['clinic'] = $clinic;
        $data['currentClinic'] = $clinic;
        view()->share('currentClinic', $clinic);
        $data['title'] = $clinic ? $clinic->name . ' - Health Clinic & Appointments' : 'Health Clinic & Appointments';
        $data['availabilities'] = Availability::get();
        $data['setting'] = Setting::where('clinic_id', $clinic->id ?? null)->first() ?? Setting::first();
        $data['TimeSlot'] = TimeSlot::all();
        $data['clinicServices'] = $clinic ? $clinic->activeServices : collect();

        return view('web.pages.appoinment', $data);
    }
    public function checkAvailability(Request $request)
    {
        // Validate request input
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid date format'], 400);
        }
    
        $date = $request->input('date');
        $dayOfWeek = Carbon::parse($date)->dayOfWeek; // 0 = Sunday, 1 = Monday, ..., 6 = Saturday
        $dbDayOfWeek = ($dayOfWeek == 0) ? 7 : $dayOfWeek; // Convert Sunday(0) to 7 (Database format)
    
        // Get all unavailable time slot IDs for the selected date
        $time_slot_ids = Availability::whereDate('from_date', $date)->pluck('time_slot_id')->toArray();
        
    
        // Get available time slots for the selected weekday, excluding unavailable slots
        $availableSlots = TimeSlot::select('id', 'from_time', 'to_time')
            ->where('day_of_week', $dbDayOfWeek)
            ->when(!empty($time_slot_ids), function ($query) use ($time_slot_ids) {
                $query->whereNotIn('id', $time_slot_ids);
            })
            ->get();
    
        return response()->json($availableSlots);
    }
    


    public function book_appointment(Request $request, $clinic_slug = null) {
        // Validate that both fields exist and are Base64-encoded
        $validatedData = $request->validate([
            'booking_date' => ['required', function ($attribute, $value, $fail) {
                if (!preg_match('/^[A-Za-z0-9+\/=]+$/', $value) || base64_decode($value, true) === false) {
                    $fail("The {$attribute} must be a valid Base64-encoded string.");
                }
            }],
            'time_slot_id' => ['required', function ($attribute, $value, $fail) {
                if (!preg_match('/^[A-Za-z0-9+\/=]+$/', $value) || base64_decode($value, true) === false) {
                    $fail("The {$attribute} must be a valid Base64-encoded string.");
                }
            }],
        ]);

        $decodedDate = base64_decode($request->booking_date);
        $decodedTimeSlotId = base64_decode($request->time_slot_id);

        $Order = Order::whereDate('booking_date', $decodedDate)->where('time_slot_id', $decodedTimeSlotId)->count();
   
        if ($Order >= 2) {
            return redirect()->back()->with('error', 'Already made a booking for this date and time slot. Please choose another date or time slot.');
        }

        // Pass decoded values to the view
        $clinic = $this->getClinic($clinic_slug);
        view()->share('currentClinic', $clinic);
        $setting = Setting::where('clinic_id', $clinic->id ?? null)->first() ?? Setting::first();
        $selectedSlot = TimeSlot::find($decodedTimeSlotId);

        $data = [
            'title' => 'Patient Registration & Booking - ' . ($clinic->name ?? 'Dr Clinic'),
            'clinic' => $clinic,
            'currentClinic' => $clinic,
            'availabilities' => Availability::get(),
            'setting' => $setting,
            'TimeSlot' => TimeSlot::all(),
            'booking_date' => $request->booking_date,
            'time_slot_id' => $request->time_slot_id,
            'decoded_date' => $decodedDate,
            'selected_slot' => $selectedSlot,
        ];
    
        return view('web.pages.payment_page', $data);
    }
    

    public function getTimeSlots()
    {
        // Fetch all slots without filtering by date
        $slots = TimeSlot::all(['id', 'from_time', 'to_time']);

        return response()->json($slots);
    }

    // Handle Razorpay payment order creation
    public function generateOrder(Request $request, $clinic_slug = null)
    {
        try {
            $clinic = $this->getClinic($clinic_slug ?: $request->clinic_slug);

            // 1. Prefer Doctor's Personal Razorpay Gateway if configured
            if ($clinic && $clinic->razorpay_enabled && !empty($clinic->razorpay_key) && !empty($clinic->razorpay_secret)) {
                $key = $clinic->razorpay_key;
                $secret = $clinic->razorpay_secret;
            } else {
                // Fallback to setting or environment
                $Setting = Setting::where('clinic_id', $clinic?->id)->first() ?? Setting::first();
                $key = $Setting && !empty($Setting->pay_key) ? $Setting->pay_key : env('RAZORPAY_KEY');
                $secret = $Setting && !empty($Setting->pay_secret_key) ? $Setting->pay_secret_key : env('RAZORPAY_SECRET');
            }

            if (empty($key) || empty($secret)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment gateway keys are not configured for this clinic.'
                ], 400);
            }

            $api = new Api($key, $secret);
            
            $order = $api->order->create([
                'receipt' => 'order_' . uniqid(),
                'amount' => round($request->amount * 100), // Convert to paise
                'currency' => 'INR',
                'payment_capture' => 1
            ]);

            return response()->json([
                'success' => true,
                'order_id' => $order['id'],
                'amount' => $order['amount'],
                'key' => $key
            ]);
        } catch (\Exception $e) {
            \Log::error('Razorpay generateOrder error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to initialize payment gateway: ' . $e->getMessage()
            ], 500);
        }
    }

    public function lookupPatient(Request $request, $clinic_slug = null)
    {
        $phone = trim($request->get('phone', ''));
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);

        if (strlen($cleanPhone) < 4) {
            return response()->json([
                'success' => false,
                'message' => 'Please enter at least 4 digits to search.',
                'patients' => []
            ]);
        }

        $clinic = $this->getClinic($clinic_slug ?: $request->clinic_slug);

        $query = Patient::query();
        if ($clinic) {
            $query->where(function($q) use ($clinic) {
                $q->where('clinic_id', $clinic->id)
                  ->orWhereNull('clinic_id');
            });
        }

        $query->where(function($q) use ($cleanPhone) {
            $q->where('mobile_no', 'LIKE', "%{$cleanPhone}%")
              ->orWhere('alternate_mobile_no', 'LIKE', "%{$cleanPhone}%");
        });

        $patients = $query->latest('id')->take(10)->get([
            'id',
            'first_name',
            'last_name',
            'dob',
            'sex',
            'age',
            'mobile_no',
            'alternate_mobile_no',
            'customer_email',
            'address',
            'patient_problem',
            'created_at'
        ]);

        // Fallback: If no patients found within scoped clinic, check all records by phone
        if ($patients->isEmpty()) {
            $patients = Patient::where(function($q) use ($cleanPhone) {
                $q->where('mobile_no', 'LIKE', "%{$cleanPhone}%")
                  ->orWhere('alternate_mobile_no', 'LIKE', "%{$cleanPhone}%");
            })->latest('id')->take(10)->get([
                'id',
                'first_name',
                'last_name',
                'dob',
                'sex',
                'age',
                'mobile_no',
                'alternate_mobile_no',
                'customer_email',
                'address',
                'patient_problem',
                'created_at'
            ]);
        }

        return response()->json([
            'success' => true,
            'count' => $patients->count(),
            'patients' => $patients
        ]);
    }

    public function paymentSuccess(Request $request, $clinic_slug = null)
    {
        try {
            DB::beginTransaction();

            $clinic = $this->getClinic($clinic_slug ?: $request->clinic_slug);
            $clinicId = $clinic?->id;

            $patient = null;
            if ($request->filled('patient_id')) {
                $patient = Patient::find($request->patient_id);
                if ($patient) {
                    $updates = [];
                    if ($request->filled('patient_problem')) {
                        $updates['patient_problem'] = $request->patient_problem;
                    }
                    if ($request->filled('address')) {
                        $updates['address'] = $request->address;
                    }
                    if ($request->filled('age')) {
                        $updates['age'] = $request->age;
                    }
                    if ($request->filled('alternate_mobile_no')) {
                        $updates['alternate_mobile_no'] = $request->alternate_mobile_no;
                    }
                    if (!empty($updates)) {
                        $patient->update($updates);
                    }
                }
            }

            if (!$patient) {
                $patient = Patient::create([
                    'clinic_id' => $clinicId,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'dob' => $request->dob,
                    'sex' => $request->sex,
                    'age' => $request->age,
                    'mobile_no' => $request->mobile_no,
                    'alternate_mobile_no' => $request->alternate_mobile_no,
                    'customer_email' => $request->customer_email ?? null,
                    'address' => $request->address,
                    'patient_problem' => $request->patient_problem,
                ]);
            }

            $isCash = ($request->payment_method === 'cash' || $request->razorpay_payment_id === 'CASH_PAYMENT' || empty($request->razorpay_payment_id));
            $transactionId = !empty($request->razorpay_order_id) ? $request->razorpay_order_id : ('CASH_' . strtoupper(uniqid()));

            $order = Order::create([
                'clinic_id' => $clinicId,
                'patient_id' => $patient->id,
                'actual_amount' => $request->actual_amount,
                'total_amount' => $request->amount,
                'razorpay_payment_id' => !empty($request->razorpay_payment_id) ? $request->razorpay_payment_id : 'CASH_AT_CLINIC',
                'transaction_id' => $transactionId,
                'payment_status' => $isCash ? 'pending' : 'success',
                'status' => 'confirmed',
                'booking_date' => $request->booking_date,
                'time_slot_id' => $request->time_slot_id
            ]);

            DB::commit();

            $Setting = Setting::where('clinic_id', $clinicId)->first() ?? Setting::first();
            $timeSlot = TimeSlot::find($order->time_slot_id);

            // Send Booking Notification Email to Clinic (wrapped in try-catch so mail issues never block booking response)
            try {
                $adminUser = \App\Models\User::first();
                $recipients = array_filter(array_unique([
                    'info@royneurocare.com',
                    $adminUser ? $adminUser->email : null,
                    env('MAIL_FROM_ADDRESS')
                ]), function($email) {
                    return !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL);
                });

                if (!empty($recipients)) {
                    $mailable = new \App\Mail\BookingConfirmationMail($order, $patient, $timeSlot, $Setting);
                    \Illuminate\Support\Facades\Mail::to($recipients)->send($mailable);
                }

                // If patient provided email address, send them a confirmation copy too
                if (!empty($patient->customer_email) && filter_var($patient->customer_email, FILTER_VALIDATE_EMAIL)) {
                    \Illuminate\Support\Facades\Mail::to($patient->customer_email)->send(new \App\Mail\BookingConfirmationMail($order, $patient, $timeSlot, $Setting));
                }
            } catch (\Exception $mailEx) {
                \Log::warning('Booking confirmation email error: ' . $mailEx->getMessage());
            }

            // Send WhatsApp alerts (wrapped in try-catch so network issues never block booking)
            try {
                $patient_mobile = $request->mobile_no;
                $admin_mobile = $Setting ? $Setting->clinic_phone_number : null;

                $clinicSlug = $clinic ? ($clinic->subdomain ?? $clinic->slug) : null;
                $invoiceUrl = $clinicSlug ? url("/c/{$clinicSlug}/invoice/{$order->id}") : url("/invoice/{$order->id}");
                $baseUrl = "https://app.digitalvyapari.online/api/WhatsApp";
                $authKey = "RGdQK296NTcyQ2Jyd0NEbEJlbWNiUT09";

                if ($patient_mobile) {
                    Http::timeout(5)->get($baseUrl, [
                        'authkey' => $authKey,
                        'template_name' => 'booking_alert',
                        'wa_number' => '919341284362',
                        'mobile' => '91' . $patient_mobile,
                        'web_url_1' => $invoiceUrl
                    ]);
                }

                if ($admin_mobile) {
                    Http::timeout(5)->get($baseUrl, [
                        'authkey' => $authKey,
                        'template_name' => 'booking_alert',
                        'wa_number' => '919341284362',
                        'mobile' => '91' . $admin_mobile,
                        'web_url_1' => $invoiceUrl
                    ]);
                }
            } catch (\Exception $waEx) {
                \Log::warning('WhatsApp booking alert error: ' . $waEx->getMessage());
            }

            return response()->json([
                'success' => true,
                'order_id' => $order->id
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Payment success handling error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to record booking: ' . $e->getMessage()
            ], 500);
        }
    }

    public function paymentFailed(Request $request, $clinic_slug = null)
    {
        try {
            $clinic = $this->getClinic($clinic_slug ?: $request->clinic_slug);
            $clinicId = $clinic?->id;

            $patient = null;
            if ($request->filled('patient_id')) {
                $patient = Patient::find($request->patient_id);
            }
            if (!$patient && ($request->first_name || $request->mobile_no)) {
                $patient = Patient::create([
                    'clinic_id' => $clinicId,
                    'first_name' => $request->first_name ?? 'Guest',
                    'last_name' => $request->last_name,
                    'dob' => $request->dob,
                    'sex' => $request->sex,
                    'age' => $request->age,
                    'mobile_no' => $request->mobile_no,
                    'alternate_mobile_no' => $request->alternate_mobile_no,
                    'customer_email' => $request->customer_email ?? null,
                    'address' => $request->address,
                    'patient_problem' => $request->patient_problem,
                ]);
            }

            $order = Order::create([
                'clinic_id' => $clinicId,
                'patient_id' => $patient ? $patient->id : null,
                'actual_amount' => $request->actual_amount,
                'total_amount' => $request->amount,
                'transaction_id' => $request->razorpay_order_id,
                'payment_status' => 'cancelled',
                'status' => 'cancelled',
                'booking_date' => $request->booking_date,
                'time_slot_id' => $request->time_slot_id
            ]);

            return response()->json([
                'success' => true,
                'order_id' => $request->razorpay_order_id ?? $order->id
            ]);
        } catch (\Exception $e) {
            \Log::error('Payment failed handling error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function bookingSuccess($param1, $param2 = null)
    {
        if ($param2 !== null) {
            $clinic_slug = $param1;
            $order_id = $param2;
        } else {
            $clinic_slug = null;
            $order_id = $param1;
        }

        $clinic = $this->getClinic($clinic_slug);
        view()->share('currentClinic', $clinic);

        $order = Order::leftJoin('patients', 'orders.patient_id', '=', 'patients.id')
            ->leftJoin('time_slots', 'orders.time_slot_id', '=', 'time_slots.id')
            ->select(
                'orders.*',
                'patients.first_name',
                'patients.last_name',
                'patients.mobile_no',
                'patients.alternate_mobile_no',
                'patients.address',
                'patients.patient_problem',
                'patients.age',
                'patients.sex',
                'time_slots.from_time',
                'time_slots.to_time'
            )
            ->where(function ($q) use ($order_id) {
                $q->where('orders.transaction_id', $order_id)
                  ->orWhere('orders.id', $order_id)
                  ->orWhere('orders.razorpay_payment_id', $order_id);
            })
            ->latest('orders.id')
            ->first();

        $data['title'] = 'Booking Receipt - ' . ($clinic->name ?? 'Roy Neuro Care');
        $data['order_id'] = $order_id;
        $data['order'] = $order;
        $data['clinic'] = $clinic;
        $data['currentClinic'] = $clinic;
        $data['setting'] = Setting::where('clinic_id', $clinic->id ?? null)->first() ?? Setting::first();

        return view('web.pages.bookingSuccess', $data);
    }

    public function bookingFailed($param1, $param2 = null)
    {
        if ($param2 !== null) {
            $clinic_slug = $param1;
            $order_id = $param2;
        } else {
            $clinic_slug = null;
            $order_id = $param1;
        }

        $clinic = $this->getClinic($clinic_slug);
        view()->share('currentClinic', $clinic);

        $order = Order::leftJoin('patients', 'orders.patient_id', '=', 'patients.id')
            ->leftJoin('time_slots', 'orders.time_slot_id', '=', 'time_slots.id')
            ->select(
                'orders.*',
                'patients.first_name',
                'patients.last_name',
                'patients.mobile_no',
                'patients.alternate_mobile_no',
                'patients.address',
                'patients.patient_problem',
                'patients.age',
                'patients.sex',
                'time_slots.from_time',
                'time_slots.to_time'
            )
            ->where(function ($q) use ($order_id) {
                $q->where('orders.transaction_id', $order_id)
                  ->orWhere('orders.id', $order_id)
                  ->orWhere('orders.razorpay_payment_id', $order_id);
            })
            ->latest('orders.id')
            ->first();

        $data['title'] = 'Payment Status - ' . ($clinic->name ?? 'Roy Neuro Care');
        $data['order_id'] = $order_id;
        $data['order'] = $order;
        $data['clinic'] = $clinic;
        $data['currentClinic'] = $clinic;
        $data['setting'] = Setting::where('clinic_id', $clinic->id ?? null)->first() ?? Setting::first();

        return view('web.pages.bookingFailed', $data);
    }

    public function show($param1, $param2 = null)
    {
        if ($param2 !== null) {
            $clinic_slug = $param1;
            $id = $param2;
        } else {
            $clinic_slug = null;
            $id = $param1;
        }

        $clinic = $this->getClinic($clinic_slug);
        view()->share('currentClinic', $clinic);

        $order = DB::table('orders')
            ->leftJoin('patients', 'orders.patient_id', '=', 'patients.id')
            ->leftJoin('time_slots', 'orders.time_slot_id', '=', 'time_slots.id')
            ->select(
                'orders.*',
                'patients.first_name',
                'patients.last_name',
                'patients.mobile_no',
                'patients.alternate_mobile_no',
                'patients.address',
                'patients.patient_problem',
                'patients.age',
                'patients.sex',
                'time_slots.from_time',
                'time_slots.to_time'
            )
            ->where(function ($q) use ($id) {
                $q->where('orders.id', $id)
                  ->orWhere('orders.transaction_id', $id)
                  ->orWhere('orders.razorpay_payment_id', $id);
            })
            ->first();

        if (!$order) {
            abort(404);
        }

        if (!empty($order->clinic_id)) {
            $clinic = Clinic::find($order->clinic_id) ?? $clinic;
        }

        view()->share('currentClinic', $clinic);
        $doctor = ($clinic && $clinic->user_id) ? \App\Models\User::find($clinic->user_id) : null;
        $setting = Setting::where('clinic_id', $clinic->id ?? null)->first() ?? Setting::first();

        return view('web.pages.invoice.show', compact('order', 'setting', 'clinic', 'doctor'));
    }

    public function viewCustomPage($param1, $param2 = null)
    {
        if ($param2 !== null) {
            $clinic_slug = $param1;
            $slug = $param2;
        } else {
            $clinic_slug = null;
            $slug = $param1;
        }

        $clinic = $this->getClinic($clinic_slug);
        if (!$clinic) {
            abort(404, 'Clinic not found.');
        }

        $page = ClinicPage::where('clinic_id', $clinic->id)
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('web.pages.custom_page', [
            'title' => $page->title . ' - ' . $clinic->name,
            'page' => $page,
            'clinic' => $clinic,
            'currentClinic' => $clinic,
        ]);
    }
}
