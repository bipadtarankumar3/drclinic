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
    public function patient_list()
    {
        $data['title'] = 'Patient List';

        // Get today's, tomorrow's, and yesterday's dates
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();
        $yesterday = Carbon::yesterday();

        // Fetch orders for each date with full patient details
        $data['today_orders'] = Order::join('patients', 'patients.id', '=', 'orders.patient_id')
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
        )
        ->whereDate('booking_date', $today)->get();

        $data['tomorrow_orders'] = Order::join('patients', 'patients.id', '=', 'orders.patient_id')
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
        )
        ->whereDate('booking_date', $tomorrow)->get();

        $data['yesterday_orders'] = Order::join('patients', 'patients.id', '=', 'orders.patient_id')
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
        )
        ->whereDate('booking_date', $yesterday)->get();


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
    
        // Get results
        $data['orders'] = $query->get();
        $data['patients'] = Patient::get();
    
        // Return the view
        return view('admin.pages.patient.booking_history', $data);
    }

    public function history_of_customer(Request $request)
    {
        $data['title'] = 'Patient History List';
    
        // Query Builder
        $query = DB::table('patients')
            ->select('patients.*');
    
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
    
        // Get results
        $data['patients_lists'] = $query->get();
        $data['patients'] = Patient::get();
    
        // Return the view
        return view('admin.pages.patient.patient_history_list', $data);
    }

    public function view_booking_history($id)
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

        return view('admin.pages.patient.view_booking_history', compact('order'));
    }

    public function booking_details($id)
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

        return view('admin.pages.patient.view_booking_history', compact('order'));
    }

    public function view_patient_history($id)
    {
        $patient = Patient::where('id', $id)->first();
        if (!$patient) {
            return redirect()->back()->with('error', 'Patient not found!');
        }

        $orders = Order::
            join('time_slots', 'time_slots.id', '=', 'orders.time_slot_id')
            ->where('orders.patient_id', $id)
            ->select('orders.*', 
            'time_slots.from_time', 
            'time_slots.to_time')
            ->get();

        if (!$orders) {
            return redirect()->back()->with('error', 'Patient history not found!');
        }

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
