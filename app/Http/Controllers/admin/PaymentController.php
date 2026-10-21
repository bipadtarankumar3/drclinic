<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
use App\Models\Order;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;
use Session;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function payments_list(Request $request)
    {
        $data['title'] = 'Payment & Transaction Logs';

        // Query orders with patient and time slot details
        $query = Order::leftJoin('patients', 'patients.id', '=', 'orders.patient_id')
            ->leftJoin('time_slots', 'time_slots.id', '=', 'orders.time_slot_id')
            ->select(
                'orders.*',
                'patients.first_name',
                'patients.last_name',
                'patients.mobile_no',
                'patients.alternate_mobile_no',
                'patients.customer_email',
                'patients.address',
                'patients.patient_problem',
                'patients.age',
                'patients.sex',
                'time_slots.from_time',
                'time_slots.to_time'
            );

        // Filter by Status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('orders.payment_status', $request->status);
        }

        // Filter by Date Range (created_at)
        if ($request->filled('from_date')) {
            $query->whereDate('orders.created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('orders.created_at', '<=', $request->to_date);
        }

        // Search by keyword
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('patients.first_name', 'LIKE', "%{$search}%")
                  ->orWhere('patients.last_name', 'LIKE', "%{$search}%")
                  ->orWhere('patients.mobile_no', 'LIKE', "%{$search}%")
                  ->orWhere('orders.razorpay_payment_id', 'LIKE', "%{$search}%")
                  ->orWhere('orders.transaction_id', 'LIKE', "%{$search}%");
            });
        }

        // Calculate KPI Statistics
        $data['total_count'] = Order::count();
        $data['success_count'] = Order::where('payment_status', 'success')->count();
        $data['failed_count'] = Order::whereIn('payment_status', ['cancelled', 'failed'])->count();
        $data['total_revenue'] = Order::where('payment_status', 'success')->sum('total_amount');

        // Fetch all matching orders for DataTable
        $data['orders'] = $query->orderBy('orders.id', 'DESC')->get();

        // Pass filter values
        $data['selected_status'] = $request->status ?? 'all';
        $data['from_date'] = $request->from_date ?? '';
        $data['to_date'] = $request->to_date ?? '';
        $data['search'] = $request->search ?? '';

        return view('admin.pages.payments.payments_list', $data);
    }

    public function payments_add()
    {
        $data['title'] = 'Add Payment';
        return view('admin.pages.payments.payments_add', $data);
    }
}

