<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use App\Models\CheckInCheckout;
use App\Models\Patient;
use App\Models\Order;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    public function login(){
        return view('admin.Auth.login');
    }
    public function backToAdmin(){
       $user=User::where('email',Session::get('email'))->first();
       Auth::login($user);
       return redirect('admin/dashboard'); 
    }
    public function adminLoginAction(Request $request){
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {

            if(Auth::user()->user_type=="admin"){
                return redirect('admin/dashboard'); 
            }else{
                 $request->session()->flash('success', 'Login Success');
                return redirect('vendor/dashboard');  
            }
               
           
        } else {
            $request->session()->flash('error', 'You have entered wrong Email or Password.');
            return redirect()->back();
        }
    }

    public function forgotPassword(){
        return view('admin.Auth.forgotPassword');
    }



    public function adminForgotAction(Request $request)
    {
        // Validate incoming email
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Email not found or invalid.'], 404);
        }

        // Find user
        $user = User::where('email', $request->email)->first();

        // Generate 6-digit OTP
        $otp = rand(100000, 999999);
        $otpExpiry = Carbon::now()->addMinutes(10);

        // Save OTP and expiry to user record
        $user->otp = $otp;
        $user->otp_expires_at = $otpExpiry;
        $user->save();

        // Send OTP via email
        // Mail::to($user->email)->send(new \App\Mail\UserForgotOtpMail($user, $otp));

        return response()->json(['message' => 'OTP sent to your email.']);
    }


    public function dashboard(){
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        $data['patient'] = Patient::count();
        $data['today_patient'] = Patient::whereDate('created_at', $today)->count();

        $data['booking'] = Order::count();
        $data['today_booking'] = Order::whereDate('booking_date', $today)->count();
        $data['tomorrow_booking'] = Order::whereDate('booking_date', $tomorrow)->count();

        $data['total_payments'] = Order::where('status', 'confirmed')->sum('total_amount');
        $data['today_total_payments'] = Order::whereDate('booking_date', $today)->where('status', 'confirmed')->sum('total_amount');

        $data['cancelled_booking'] = Order::where('status', 'cancelled')->count();
        $data['today_cancelled_booking'] = Order::whereDate('booking_date', $today)->where('status', 'cancelled')->count();

        $data['pending_booking'] = Order::where('status', 'pending')->count();
        $data['confirmed_booking'] = Order::where('status', 'confirmed')->count();

        // Fetch today's orders
        $data['today_orders'] = Order::join('patients', 'patients.id', '=', 'orders.patient_id')
            ->leftJoin('time_slots', 'time_slots.id', '=', 'orders.time_slot_id')
            ->select(
                'orders.*', 
                'patients.first_name', 
                'patients.last_name', 
                'patients.mobile_no', 
                'patients.customer_email', 
                'patients.patient_problem', 
                'patients.sex',
                'patients.age',
                'time_slots.from_time', 
                'time_slots.to_time'
            )
            ->whereDate('orders.booking_date', $today)
            ->orderBy('orders.id', 'desc')
            ->get();

        // Fetch recent orders
        $data['recent_orders'] = Order::join('patients', 'patients.id', '=', 'orders.patient_id')
            ->leftJoin('time_slots', 'time_slots.id', '=', 'orders.time_slot_id')
            ->select(
                'orders.*', 
                'patients.first_name', 
                'patients.last_name', 
                'patients.mobile_no', 
                'patients.customer_email', 
                'patients.patient_problem', 
                'patients.sex',
                'patients.age',
                'time_slots.from_time', 
                'time_slots.to_time'
            )
            ->orderBy('orders.id', 'desc')
            ->limit(8)
            ->get();

        // Fetch cancelled bookings
        $data['cancelled_booking_lists'] = Order::join('patients', 'patients.id', '=', 'orders.patient_id')
            ->leftJoin('time_slots', 'time_slots.id', '=', 'orders.time_slot_id')
            ->select(
                'orders.*', 
                'patients.first_name', 
                'patients.last_name', 
                'patients.mobile_no', 
                'patients.patient_problem', 
                'time_slots.from_time', 
                'time_slots.to_time'
            )
            ->where('orders.status', 'cancelled')
            ->orderBy('orders.id', 'desc')
            ->limit(6)
            ->get();

        // Weekly Chart Data (Last 7 Days)
        $chartLabels = [];
        $chartBookings = [];
        $chartRevenue = [];
        $chartCancelled = [];

        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i);
            $dayStr = $day->format('Y-m-d');
            $chartLabels[] = $day->format('D (d M)');

            $chartBookings[] = Order::whereDate('booking_date', $dayStr)->where('status', 'confirmed')->count();
            $chartRevenue[] = (float) Order::whereDate('booking_date', $dayStr)->where('status', 'confirmed')->sum('total_amount');
            $chartCancelled[] = Order::whereDate('booking_date', $dayStr)->where('status', 'cancelled')->count();
        }

        $data['chart_labels'] = json_encode($chartLabels);
        $data['chart_bookings'] = json_encode($chartBookings);
        $data['chart_revenue'] = json_encode($chartRevenue);
        $data['chart_cancelled'] = json_encode($chartCancelled);

        // Status breakdown data for donut chart
        $data['chart_status_data'] = json_encode([
            $data['confirmed_booking'],
            $data['pending_booking'],
            $data['cancelled_booking'],
        ]);

        $data['setting'] = \DB::table('settings')->first();

        return view('admin.pages.dashboard.dashboard', $data);
    }
    public function profile(){
        return view('admin.auth.profile');
    }
    public function logout(Request $request){
        Auth::logout();


     $request->session()->flash('error','loged out');
     return redirect('login');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password changed successfully.');
    }

 

}
