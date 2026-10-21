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
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Razorpay\Api\Api;

use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\DB;


class WebViewController extends Controller
{
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



    public function appoinment(){
        $data['title'] = 'appoinment';
        $data['availabilities'] = Availability::get();
        $data['setting'] = Setting::first();
        $data['TimeSlot'] = TimeSlot::all();

        //dd($data['availabilities']);
        return view('web.pages.appoinment',$data);
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
    


    public function book_appointment(Request $request) {
        // Validate that both fields exist and are Base64-encoded
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
        $data = [
            'title' => 'Book Appointment',
            'availabilities' => Availability::get(),
            'setting' => Setting::first(),
            'TimeSlot' => TimeSlot::all(),
            'booking_date' => $request->booking_date,
            'time_slot_id' => $request->time_slot_id
        ];
    
        return view('web.pages.payment_page', $data);
    }
    

    public function getTimeSlots()
    {
        // Fetch all slots without filtering by date
        $slots = TimeSlot::all(['id', 'from_time', 'to_time']);

        return response()->json($slots);
    }

    // Handle Razorpay payment
    public function generateOrder(Request $request)
    {

        $Setting = Setting::first();
        if ($Setting) {
             $api = new Api($Setting->pay_key, $Setting->pay_secret_key);
        } else {
             $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        }
        

       
        
        $order = $api->order->create([
            'receipt' => 'order_' . uniqid(),
            'amount' => $request->amount * 100, // Convert to paise
            'currency' => 'INR',
            'payment_capture' => 1
        ]);

        return response()->json([
            'success' => true,
            'order_id' => $order['id'],
            'amount' => $order['amount']
        ]);
    }

    public function paymentSuccess(Request $request)
    {

        $patient = Patient::where('mobile_no', $request->mobile_no)->first();

        $Setting = Setting::first();

        $patient_mobile = $request->mobile_no;
        $admin_mobile = $Setting->clinic_phone_number;

        $patient_id = '';
        if ($patient) {
            $patient_id = $patient->id;
        }else{
            $patient = Patient::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'dob' => $request->dob,
                'sex' => $request->sex,
                'age' => $request->age,
                'mobile_no' => $request->mobile_no,
                'alternate_mobile_no' => $request->alternate_mobile_no,
                'address' => $request->address,
                'patient_problem' => $request->patient_problem,
            ]);
            $patient_id = $patient->id;
        }

        $order = Order::create([
            'patient_id' => $patient_id,
            'actual_amount' => $request->actual_amount,
            'total_amount' => $request->amount,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'transaction_id' => $request->razorpay_order_id,
            'payment_status' => 'success',
            'status' => 'pending',
            'booking_date' => $request->booking_date,
            'time_slot_id' => $request->time_slot_id
        ]);

               // Construct invoice URL (adjust domain/path as per your app's structure)
               $invoiceUrl = url("/invoice/{$order->id}");

               // Base WhatsApp URL
               $baseUrl = "https://app.digitalvyapari.online/api/WhatsApp";
               $authKey = "RGdQK296NTcyQ2Jyd0NEbEJlbWNiUT09";
       
               // Send message to patient
               Http::get($baseUrl, [
                   'authkey' => $authKey,
                   'template_name' => 'booking_alert',
                   'wa_number' => '919341284362',
                   'mobile' => '91' . $patient_mobile,
                   'web_url_1' => $invoiceUrl
               ]);
       
               // Send message to clinic/admin
               Http::get($baseUrl, [
                   'authkey' => $authKey,
                   'template_name' => 'booking_alert',
                   'wa_number' => '919341284362',
                   'mobile' => '91' . $admin_mobile,
                   'web_url_1' => $invoiceUrl
               ]);

        return response()->json(['success' => true]);
    }

    public function paymentFailed(Request $request)
    {

        $patient = Patient::where('mobile_no', $request->mobile_no)->first();
        $patient_id = '';
        if ($patient) {
            $patient_id = $patient->id;
        }else{
            $patient = Patient::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'dob' => $request->dob,
                'sex' => $request->sex,
                'age' => $request->age,
                'mobile_no' => $request->mobile_no,
                'alternate_mobile_no' => $request->alternate_mobile_no,
                'address' => $request->address,
                'patient_problem' => $request->patient_problem,
            ]);
            $patient_id = $patient->id;
        }

        Order::create([
            'patient_id' => $patient_id,
            'actual_amount' => $request->actual_amount,
            'total_amount' => $request->amount,
            'transaction_id' => $request->razorpay_order_id,
            'payment_status' => 'cancelled',
            'status' => 'cancelled',
            'booking_date' => $request->booking_date,
            'time_slot_id' => $request->time_slot_id
        ]);


        return response()->json(['success' => true]);
    }

    public function bookingSuccess($order_id){
        $data['title'] = 'pediatric';
        $data['order_id'] = $order_id;
        return view('web.pages.bookingSuccess',$data);
    }



    public function show($id)
    {
        $order = DB::table('orders')
            ->join('patients', 'orders.patient_id', '=', 'patients.id')
            ->leftJoin('time_slots', 'orders.time_slot_id', '=', 'time_slots.id')
            ->select(
                'orders.*',
                'patients.first_name',
                'patients.last_name',
                'patients.mobile_no',
                'time_slots.from_time',
                'time_slots.to_time',
            )
            ->where('orders.id', $id)
            ->first();

        if (!$order) {
            abort(404);
        }

        return view('web.pages.invoice.show', compact('order'));
    }

}
