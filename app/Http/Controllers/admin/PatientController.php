<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;

use Razorpay\Api\Api;
use Session;
use Carbon\Carbon;

class PatientController extends Controller
{
    public function patient_list(Request $request)
    {
        $data['title'] = 'Patient Bookings & Appointments';

        // Get today's, tomorrow's, and yesterday's dates
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();
        $yesterday = Carbon::yesterday();

        $user = auth()->user();
        $clinic = $user ? $user->getActiveClinic() : null;
        $clinicId = $clinic ? $clinic->id : null;

        // Base Query
        $baseQuery = Order::join('patients', 'patients.id', '=', 'orders.patient_id')
            ->leftJoin('time_slots', 'time_slots.id', '=', 'orders.time_slot_id')
            ->select(
                'orders.*',
                'patients.first_name',
                'patients.last_name',
                'patients.dob',
                'patients.sex',
                'patients.age',
                'patients.mobile_no',
                'patients.alternate_mobile_no',
                'patients.customer_email',
                'patients.address',
                'patients.patient_problem',
                'patients.status as patient_status',
                'time_slots.from_time',
                'time_slots.to_time'
            );

        if ($clinicId) {
            $baseQuery->where('orders.clinic_id', $clinicId);
        }

        // Metrics for Stat Cards & Pill Counts
        $data['totalInquiries'] = (clone $baseQuery)->count();
        $data['todayBookings'] = (clone $baseQuery)->whereDate('orders.booking_date', $today)->count();
        $data['tomorrowBookings'] = (clone $baseQuery)->whereDate('orders.booking_date', $tomorrow)->count();
        $data['weekBookings'] = (clone $baseQuery)->whereBetween('orders.booking_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $data['newLeads'] = (clone $baseQuery)->where('orders.payment_status', 'pending')->count();
        $data['testRidesScheduled'] = (clone $baseQuery)->whereDate('orders.booking_date', '>=', $today)->count();
        $data['bookedDelivered'] = (clone $baseQuery)->whereIn('orders.payment_status', ['paid', 'success', 'captured'])->count();

        // Apply Filters
        $filterQuery = clone $baseQuery;

        if ($request->filled('search')) {
            $search = $request->search;
            $filterQuery->where(function ($q) use ($search) {
                $q->where('patients.first_name', 'like', "%{$search}%")
                  ->orWhere('patients.last_name', 'like', "%{$search}%")
                  ->orWhere('patients.mobile_no', 'like', "%{$search}%")
                  ->orWhere('orders.id', 'like', "%{$search}%")
                  ->orWhere('orders.razorpay_payment_id', 'like', "%{$search}%")
                  ->orWhere('patients.patient_problem', 'like', "%{$search}%");
            });
        }

        if ($request->filled('timeframe')) {
            if ($request->timeframe === 'today') {
                $filterQuery->whereDate('orders.booking_date', $today);
            } elseif ($request->timeframe === 'tomorrow') {
                $filterQuery->whereDate('orders.booking_date', $tomorrow);
            } elseif ($request->timeframe === 'week') {
                $filterQuery->whereBetween('orders.booking_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            } elseif ($request->timeframe === 'month') {
                $filterQuery->whereMonth('orders.booking_date', Carbon::now()->month);
            }
        }

        if ($request->filled('status')) {
            if ($request->status === 'confirmed' || $request->status === 'paid') {
                $filterQuery->whereIn('orders.payment_status', ['paid', 'success', 'captured']);
            } elseif ($request->status === 'pending') {
                $filterQuery->where('orders.payment_status', 'pending');
            } elseif ($request->status === 'cancelled') {
                $filterQuery->where('orders.payment_status', 'cancelled');
            }
        }

        if ($request->filled('specific_date')) {
            $filterQuery->whereDate('orders.booking_date', $request->specific_date);
        }

        // Server-Side Paginated Orders (default 10 per page, supports per_page)
        $perPage = (int) $request->input('per_page', 10);
        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }

        $data['orders'] = $filterQuery->latest('orders.id')->paginate($perPage)->withQueryString();
        $data['perPage'] = $perPage;

        // Backward compatibility for tab views
        $data['today_orders'] = (clone $baseQuery)->whereDate('orders.booking_date', $today)->get();
        $data['tomorrow_orders'] = (clone $baseQuery)->whereDate('orders.booking_date', $tomorrow)->get();
        $data['yesterday_orders'] = (clone $baseQuery)->whereDate('orders.booking_date', $yesterday)->get();
        $data['clinic'] = $clinic;

        return view('admin.pages.patient.patient_list', $data);
    }


    public function booking_history(Request $request)
    {
        $data['title'] = 'Patient History List';
    
        // Query Builder
        $query = Order::join('patients', 'patients.id', '=', 'orders.patient_id')
            ->join('time_slots', 'time_slots.id', '=', 'orders.time_slot_id')
            ->select(
                'orders.*',
                'patients.first_name',
                'patients.last_name',
                'patients.dob',
                'patients.sex',
                'patients.age',
                'patients.mobile_no',
                'patients.alternate_mobile_no',
                'patients.customer_email',
                'patients.address',
                'patients.patient_problem',
                'patients.status as patient_status',
                'time_slots.from_time',
                'time_slots.to_time'
            );
        $user = auth()->user();
        $clinic = $user ? $user->getActiveClinic() : null;
        if ($clinic) {
            $query->where('orders.clinic_id', $clinic->id);
        }
    
        // Apply Filters
        if ($request->has('patient_id') && !empty($request->patient_id)) {
            $query->where('orders.patient_id', $request->patient_id);
        }
    
        if ($request->has('from_date') && !empty($request->from_date)) {
            $query->whereDate('orders.created_at', '>=', $request->from_date);
        }
    
        if ($request->has('to_date') && !empty($request->to_date)) {
            $query->whereDate('orders.created_at', '<=', $request->to_date);
        }
    
        // Server-Side Paginated Orders
        $perPage = (int) $request->input('per_page', 15);
        $data['orders'] = $query->latest('orders.id')->paginate($perPage)->withQueryString();
        $data['patients'] = Patient::when($clinic, function($q) use ($clinic) {
            $q->where('clinic_id', $clinic->id);
        })->get();
    
        // Return the view
        return view('admin.pages.patient.booking_history', $data);
    }

    public function history_of_customer(Request $request)
    {
        $data['title'] = 'Patient History List';

        $user = auth()->user();
        $clinic = $user ? $user->getActiveClinic() : null;
    
        // Query Builder
        $query = DB::table('patients')
            ->select('patients.*');

        if ($clinic) {
            $query->where('patients.clinic_id', $clinic->id);
        }
    
        // Apply Filters
        if ($request->has('patient_id') && !empty($request->patient_id)) {
            $query->where('patients.id', $request->patient_id);
        }
    
        if ($request->has('from_date') && !empty($request->from_date)) {
            $query->whereDate('patients.created_at', '>=', $request->from_date);
        }
    
        if ($request->has('to_date') && !empty($request->to_date)) {
            $query->whereDate('patients.created_at', '<=', $request->to_date);
        }
    
        // Server-Side Paginated Patients
        $perPage = (int) $request->input('per_page', 15);
        $data['patients_lists'] = $query->latest('patients.id')->paginate($perPage)->withQueryString();
        $data['patients'] = Patient::when($clinic, function($q) use ($clinic) {
            $q->where('clinic_id', $clinic->id);
        })->get();
    
        // Return the view
        return view('admin.pages.patient.patient_history_list', $data);
    }

    public function view_booking_history($id)
    {
        $user = auth()->user();
        $clinic = $user ? $user->getActiveClinic() : null;

        $orderQuery = Order::join('patients', 'patients.id', '=', 'orders.patient_id')
            ->join('time_slots', 'time_slots.id', '=', 'orders.time_slot_id')
            ->where('orders.id', $id)
            ->select('orders.*', 
            'patients.first_name as first_name', 
            'patients.last_name as last_name', 
            'patients.dob', 
            'patients.age', 
            'patients.sex', 
            'patients.mobile_no', 
            'patients.alternate_mobile_no', 
            'patients.address', 
            'patients.patient_problem', 
            'time_slots.from_time', 
            'time_slots.to_time');

        if ($clinic) {
            $orderQuery->where('orders.clinic_id', $clinic->id);
        }

        $order = $orderQuery->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Patient history not found!');
        }

        return view('admin.pages.patient.view_booking_history', compact('order'));
    }

    public function booking_details($id)
    {
        $user = auth()->user();
        $clinic = $user ? $user->getActiveClinic() : null;

        $orderQuery = Order::join('patients', 'patients.id', '=', 'orders.patient_id')
            ->join('time_slots', 'time_slots.id', '=', 'orders.time_slot_id')
            ->where('orders.id', $id)
            ->select('orders.*', 
            'patients.first_name as first_name', 
            'patients.last_name as last_name', 
            'patients.dob', 
            'patients.age', 
            'patients.sex', 
            'patients.mobile_no', 
            'patients.alternate_mobile_no', 
            'patients.address', 
            'patients.patient_problem', 
            'time_slots.from_time', 
            'time_slots.to_time');

        if ($clinic) {
            $orderQuery->where('orders.clinic_id', $clinic->id);
        }

        $order = $orderQuery->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Patient history not found!');
        }

        return view('admin.pages.patient.view_booking_history', compact('order'));
    }

    public function view_patient_history($id)
    {
        $user = auth()->user();
        $clinic = $user ? $user->getActiveClinic() : null;

        $patientQuery = Patient::where('id', $id);
        if ($clinic) {
            $patientQuery->where('clinic_id', $clinic->id);
        }
        $patient = $patientQuery->first();

        if (!$patient) {
            return redirect()->back()->with('error', 'Patient not found!');
        }

        $ordersQuery = Order::
            join('time_slots', 'time_slots.id', '=', 'orders.time_slot_id')
            ->where('orders.patient_id', $id)
            ->select('orders.*', 
            'time_slots.from_time', 
            'time_slots.to_time');

        if ($clinic) {
            $ordersQuery->where('orders.clinic_id', $clinic->id);
        }

        $orders = $ordersQuery->get();

        return view('admin.pages.patient.patient_history_view', compact('orders','patient'));
    }


    public function statusChangePage($id)
    {
        $order = Order::join('patients', 'patients.id', '=', 'orders.patient_id')
        ->join('time_slots', 'time_slots.id', '=', 'orders.time_slot_id')
        ->where('orders.id', $id)
        ->select('orders.*', 
        'patients.first_name as first_name', 
        'patients.last_name as last_name', 
        'patients.dob', 
        'patients.age', 
        'patients.sex', 
        'patients.mobile_no', 
        'patients.alternate_mobile_no', 
        'patients.address', 
        'patients.patient_problem', 
        'time_slots.from_time', 
        'time_slots.to_time')
        ->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Patient history not found!');
        }
        return view('admin.pages.patient.payment_status_change', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:pending,confirmed,cancelled,completed'
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->updated_at = Carbon::now();
        $order->save();
        return redirect()->to('admin/patient-history/view/' . $id)->with('success', 'Status updated successfully.');

    }


    public function delete($id)
    {
        // Find the order by ID
        $order = Order::find($id);

        // Check if order exists
        if (!$order) {
            return redirect()->back()->with('error', 'Record not found.');
        }

        // Delete the record
        $order->delete();

        return redirect()->back()->with('success', 'Record deleted successfully.');
    }


    
}
