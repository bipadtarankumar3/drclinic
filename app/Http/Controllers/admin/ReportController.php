<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Employee;
use App\Models\CheckInCheckout;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class ReportController extends Controller
{
    // public function attendance_master_report()
    // {
    //     $data['title'] = 'Attendance master';


    //     return view('admin.pages.report.attendance_master_report', $data);
    // }

    public function attendance_master_report(Request $request)
    {
        $data['title'] = 'Monthly Attendance Report';
        

        if ($request->has('user_id')) {
            $selectedUsers = is_array($request->user_id) ? $request->user_id : [$request->user_id];
            $data['users'] = User::whereIn('id', $selectedUsers)->get();
        } else {
            $data['users'] = User::where('user_type', '!=','admin')->where('user_type', '!=','client')->get();
        }


        $data['users_list'] = User::where('user_type', '!=','admin')->where('user_type', '!=','client')->get();

        $data['report'] = [];
    
        if ($request->to_date) {
            $selectedDate = Carbon::createFromFormat('Y-m', $request->to_date);
            $year = $selectedDate->year;
            $month = $selectedDate->month;
    
            $startDate = Carbon::create($year, $month, 1)->startOfMonth();
            $endDate = $startDate->copy()->endOfMonth();
    
            // Get the attendances for the selected month
            $query = CheckInCheckout::whereBetween('ckn_date', [$startDate, $endDate]);

            if ($request->has('user_id')) {
                $selectedUsers = is_array($request->user_id) ? $request->user_id : [$request->user_id];
                $query->whereIn('ckn_user_id', $selectedUsers);
            }

            $attendances = $query->orderBy('ckn_date')->get()->groupBy('ckn_date');
    
            // Iterate through each user
            foreach ($data['users'] as $user) {
                $userReport = [];
                $totalHours = 0;
                $totalPresent = 0;
                $totalAbsent = 0;
                $totalHalfDays = 0;
                $totalPaidLeaves = 0;
                $totalUnmarked = 0;
                $totalOvertimeHours = 0;
                $totalFineHours = 0;
    
                // Get attendance data for the current user
                foreach ($startDate->toPeriod($endDate) as $date) {
                    $dateStr = $date->format('Y-m-d');
                    $entries = $attendances[$dateStr] ?? collect();
                    
                    // Check for user's check-in and check-out data for the day
                    $checkIn = $entries->where('ckn_user_id', $user->id)->where('ckn_in_out_status', 'in')->first();
                    $checkOut = $entries->where('ckn_user_id', $user->id)->where('ckn_in_out_status', 'out')->last();
    
                    $workHours = 0;
                    $overtimeHours = 0;
                    $fineHours = 0;
    
                    if ($checkIn && $checkOut) {
                        $inTime = Carbon::parse($checkIn->ckn_time);
                        $outTime = Carbon::parse($checkOut->ckn_time);
                        $totalMinutes = $inTime->diffInMinutes($outTime);
    
                        $workHours = $totalMinutes;
                        $totalHours += $totalMinutes;
    
                        // Check Present or Half Day
                        if ($totalMinutes >= 480) { // Full day present
                            $totalPresent++;
                        } elseif ($totalMinutes >= 240) { // Half day
                            $totalHalfDays++;
                        } else {
                            $totalAbsent++;
                        }
    
                        // Calculate overtime if work hours > 8 hours (480 minutes)
                        if ($totalMinutes > 480) {
                            $overtimeMinutes = $totalMinutes - 480;
                            $overtimeHours = $overtimeMinutes;
                            $totalOvertimeHours += $overtimeMinutes;
                        }
    
                        // Fine hours if work hours < 8 hours but not absent
                        if ($totalMinutes < 480 && $totalMinutes > 0) {
                            $fineHours = 480 - $totalMinutes;
                            $totalFineHours += $fineHours;
                        }
                    } else {
                        $totalUnmarked++; // If no attendance data
                        $totalAbsent++;
                    }
    
                    // Add user's daily attendance data to the user's report
                    $userReport[$date->day] = [
                        'in_time' => $checkIn ? $checkIn->ckn_time : '-',
                        'out_time' => $checkOut ? $checkOut->ckn_time : '-',
                        'work_hours' => $workHours > 0 ? sprintf('%02d:%02d', intdiv($workHours, 60), $workHours % 60) : '-',
                        'overtime_hours' => $overtimeHours > 0 ? sprintf('%02d:%02d', intdiv($overtimeHours, 60), $overtimeHours % 60) : '-',
                    ];
                }
    
                // Assign total calculations
                $data['report'][$user->id] = $userReport + [
                    'total_hours' => sprintf('%02d:%02d', intdiv($totalHours, 60), $totalHours % 60),
                    'present_days' => $totalPresent,
                    'absent_days' => $totalAbsent,
                    'half_days' => $totalHalfDays,
                    'paid_leaves' => $totalPaidLeaves,
                    'unmarked_days' => $totalUnmarked,
                    'overtime_hours' => sprintf('%02d:%02d', intdiv($totalOvertimeHours, 60), $totalOvertimeHours % 60),
                    'fine_hours' => sprintf('%02d:%02d', intdiv($totalFineHours, 60), $totalFineHours % 60),
                ];
            }
        }
    
        return view('admin.pages.report.attendance_master_report', $data);
    }
    


    public function staff_master_report(Request $request)
{
    $data['title'] = 'Staff Master';
    $data['users'] = User::where('user_type', '!=','admin')->where('user_type', '!=','client')->get();
    $data['report'] = [];

    if ($request->user_id) {

        $data['users_details'] = User::where('id',$request->user_id)->first();

        $query = CheckInCheckout::where('ckn_user_id', $request->user_id);

        if ($request->form_date && $request->to_date) {
            $query->whereBetween('ckn_date', [$request->form_date, $request->to_date]);
        }

        $attendances = $query->orderBy('ckn_date')->get()->groupBy('ckn_date');

        foreach ($attendances as $date => $entries) {
            $checkIn = $entries->where('ckn_in_out_status', 'in')->first();
            $checkOut = $entries->where('ckn_in_out_status', 'out')->last();

            // Default values
            $workHours = '-';
            $overtimeHours = '-';

            if ($checkIn && $checkOut) {
                $inTime = Carbon::parse($checkIn->ckn_time);
                $outTime = Carbon::parse($checkOut->ckn_time);
                $totalMinutes = $inTime->diffInMinutes($outTime);

                // Convert total minutes to hours:minutes format
                $workHours = sprintf('%02d:%02d', intdiv($totalMinutes, 60), $totalMinutes % 60);

                // If work hours exceed 8 hours (480 minutes), calculate overtime
                if ($totalMinutes > 480) {
                    $overtimeMinutes = $totalMinutes - 480;
                    $overtimeHours = sprintf('%02d:%02d', intdiv($overtimeMinutes, 60), $overtimeMinutes % 60);
                }
            }

            $data['report'][] = [
                'date' => $date,
                'attendance_state' => $checkIn ? 'P' : 'WO',
                'in_time' => $checkIn ? $checkIn->ckn_time : '-',
                'out_time' => $checkOut ? $checkOut->ckn_time : '-',
                'work_hours' => $workHours,
                'overtime_hours' => $overtimeHours,
                'fine_hours' => '-', // Add logic for fine hours if needed
            ];
        }
    }

    return view('admin.pages.report.staff_master_report', $data);
}




public function user_report(){
    $data['title']='User Report';
        $data['users'] = User::where('user_type', '!=','admin')->where('user_type', '!=','client')->get();
        $data['report'] = [];
    return view('admin.pages.report.user_report',$data);
}
public function payment_report(){
    $data['title']='Payment report';
    $data['users'] = User::where('user_type', '!=','admin')->where('user_type', '!=','client')->get();
    $data['report'] = [];
    return view('admin.pages.report.payment_report',$data);
}


}
