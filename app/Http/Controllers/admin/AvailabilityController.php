<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Availability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use Carbon\Carbon;
use App\Models\TimeSlot;

class AvailabilityController extends Controller
{
    public function availability_list(){
        $data['title']='Availability List';
        $user = auth()->user();
        $clinic = $user ? $user->getActiveClinic() : null;
        $query = Availability::query();
        if ($clinic) {
            $query->where('clinic_id', $clinic->id);
        }
        $data['availabilities'] = $query->where('from_date', '>=', date('Y-m-d'))
            ->orderBy('from_date', 'asc')
            ->get();
        return view('admin.pages.availability.availability_list',$data);
    }

    public function availability_calander_list(){
        $data['title']='Availability Calendar List';
        $user = auth()->user();
        $clinic = $user ? $user->getActiveClinic() : null;
        $query = Availability::query();
        if ($clinic) {
            $query->where('clinic_id', $clinic->id);
        }
        $data['availabilities'] = $query->get();
        return view('admin.pages.availability.availability_calander_list',$data);
    }


    public function store(Request $request, $id = null)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'remarks' => 'nullable|string',
        ]);

        $user = auth()->user();
        $clinic = $user ? $user->getActiveClinic() : null;
            
        $data = [
            'clinic_id' => $clinic ? $clinic->id : null,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'remarks' => $request->remarks,
        ];
    

        if ($id) {
            // Update existing record
            $Availability = Availability::find($id);
            if (!$Availability) {
                return redirect()->back()->with('error', 'availability not found.');
            }
            $Availability->update($data);
            return redirect()->to('admin/availability')->with('success', 'availability updated successfully.');
        } else {
            // Insert new record
            Availability::create($data);
            return redirect()->to('admin/availability')->with('success', 'availability added successfully.');
        }
    }

    public function edit($id)
    {
        $availability = Availability::findOrFail($id);
        $availabilities = Availability::all();

        return view('admin.pages.availability.availability_list', compact('availability', 'availabilities'));
    }


    public function destroy($id)
    {
        $availability = Availability::findOrFail($id);
        $availability->delete();

        return redirect()->back()->with('success', 'Availability deleted successfully!');
    }


    public function getUnavailableDates()
    {
        $user = auth()->user();
        $clinic = $user ? $user->getActiveClinic() : null;
        $query = Availability::query();
        if ($clinic) {
            $query->where('clinic_id', $clinic->id);
        }
        $unavailableDates = $query->get();
    
        if ($unavailableDates->isEmpty()) {
            return response()->json([]);
        }
    
        return response()->json($unavailableDates->map(function ($date) {
            $title = 'Blocked';
            if (!empty($date->start_time) && !empty($date->end_time)) {
                $startTimeFormatted = date('g:i A', strtotime($date->start_time));
                $endTimeFormatted = date('g:i A', strtotime($date->end_time));
                $title = "{$startTimeFormatted} - {$endTimeFormatted}";
            } elseif (!empty($date->remarks)) {
                $title = $date->remarks;
            } else {
                $title = 'Whole Day Closed';
            }
    
            return [
                'id' => $date->id,
                'title' => $title,
                'start' => !empty($date->start_time) ? ($date->from_date . 'T' . $date->start_time) : $date->from_date,
                'end' => !empty($date->end_time) ? ($date->from_date . 'T' . $date->end_time) : $date->from_date,
                'allDay' => empty($date->start_time),
                'backgroundColor' => '#ef4444',
                'borderColor' => '#dc2626',
                'textColor' => '#ffffff',
            ];
        }));
    }
    

    public function get_big_calander_unavailable_dates()
    {
        $user = auth()->user();
        $clinic = $user ? $user->getActiveClinic() : null;
        $query = Availability::query();
        if ($clinic) {
            $query->where('clinic_id', $clinic->id);
        }
        $unavailableDates = $query->get();

        if ($unavailableDates->isEmpty()) {
            return response()->json([]);
        }

        return response()->json($unavailableDates->map(function ($date) {
            return [
                'id' => $date->id,
                'title' => $date->remarks ?? 'Unavailable',
                'start' => $date->from_date,
                'end' => \Carbon\Carbon::parse($date->from_date)->addDay()->toDateString(),
                'allDay' => true,
                'backgroundColor' => '#ef4444',
                'borderColor' => '#dc2626',
                'textColor' => '#ffffff',
            ];
        }));
    }

    public function get_time_slots(Request $request)
    {
        $date = $request->input('date');
        $dayOfWeek = Carbon::parse($date)->dayOfWeek; // 0 = Sunday, 1 = Monday, ..., 6 = Saturday

        // Adjust for database format where 1 = Monday, 2 = Tuesday, 7 = Sunday
        $dbDayOfWeek = ($dayOfWeek == 0) ? 7 : $dayOfWeek;

        $user = auth()->user();
        $clinic = $user ? $user->getActiveClinic() : null;

        // Fetch available time slots for the selected day
        $query = TimeSlot::select('id', 'from_time', 'to_time')
            ->where('day_of_week', $dbDayOfWeek);

        if ($clinic) {
            $query->where('clinic_id', $clinic->id);
        }

        $timeSlots = $query->get();

        $select = "";
        foreach ($timeSlots as $slot) {
            $fromTime = Carbon::parse($slot->from_time)->format('h:i A');
            $toTime = Carbon::parse($slot->to_time)->format('h:i A');
            
            $select .= '<option value="' . $slot->id . '">' . $fromTime . ' - ' . $toTime . '</option>'; 
        }

        return response($select);
    }

    public function markUnavailable(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
        ], [
            'date.after_or_equal' => 'Cannot mark unavailability for past dates. Please pick today or a future date.',
        ]);

        $start_time_end_time = $request->start_time_end_time;
        $user = auth()->user();
        $clinic = $user ? $user->getActiveClinic() : null;
        $remarks = $request->remarks ?: 'Doctor Unavailable';

        if (!empty($start_time_end_time) && is_array($start_time_end_time)) {
            foreach ($start_time_end_time as $data) {
                if (empty($data)) continue;
                $timeSlot = TimeSlot::select('id', 'from_time', 'to_time')->where('id', $data)->first();
                Availability::create([
                    'clinic_id' => $clinic ? $clinic->id : null,
                    'from_date' => $request->date,
                    'to_date' => $request->date,
                    'time_slot_id' => $data,
                    'start_time' => $timeSlot ? $timeSlot->from_time : null,
                    'end_time' => $timeSlot ? $timeSlot->to_time : null,
                    'remarks' => $remarks,
                ]);
            }
        } else {
            // Whole Day blocked
            Availability::create([
                'clinic_id' => $clinic ? $clinic->id : null,
                'from_date' => $request->date,
                'to_date' => $request->date,
                'time_slot_id' => null,
                'start_time' => null,
                'end_time' => null,
                'remarks' => $remarks ?: 'Whole Day Leave',
            ]);
        }

        return response()->json(['message' => 'Unavailability recorded successfully.']);
    }
}
