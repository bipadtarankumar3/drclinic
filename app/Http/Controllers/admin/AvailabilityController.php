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
        $data['title']='availability List';
        $data['availabilities'] = Availability::all();
        return view('admin.pages.availability.availability_list',$data);
    }

    public function availability_calander_list(){
        $data['title']='availability calander List';
        $data['availabilities'] = Availability::all();
        return view('admin.pages.availability.availability_calander_list',$data);
    }


    public function store(Request $request, $id = null)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'remarks' => 'nullable|string',
        ]);

            
        $data = [
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
        $unavailableDates = Availability::all();
    
        if ($unavailableDates->isEmpty()) {
            return response()->json([]);
        }
    
        return response()->json($unavailableDates->map(function ($date) {
            // Format time range for title
            $startTimeFormatted = date('g:i A', strtotime($date->start_time));
            $endTimeFormatted = date('g:i A', strtotime($date->end_time));
            $timeRange = "{$startTimeFormatted} to {$endTimeFormatted}";
    
            return [
                'title' => "{$timeRange}",
                'start' => $date->from_date . 'T' . $date->start_time,
                'end' => $date->from_date . 'T' . $date->end_time,
                'backgroundColor' => 'red',
                'borderColor' => '#FF0000',
            ];
        }));
    }
    

    public function get_big_calander_unavailable_dates()
{
    $unavailableDates = Availability::all();

    // Check if there are no unavailable dates
    if ($unavailableDates->isEmpty()) {
        return response()->json([]);
    }

    return response()->json($unavailableDates->map(function ($date) {
        return [
            'title' => 'Unavailable',
            'start' => $date->from_date,
            'end' => \Carbon\Carbon::parse($date->from_date)->addDay()->toDateString(), // dayGridMonth expects exclusive 'end'
            'allDay' => true, // key change for big calendar view
            'backgroundColor' => 'red',
            'borderColor' => '#FF0000',
            'display' => 'background'
        ];
    }));
}



public function get_time_slots(Request $request)
{
    $date = $request->input('date');
    $dayOfWeek = Carbon::parse($date)->dayOfWeek; // 0 = Sunday, 1 = Monday, ..., 6 = Saturday

    // Adjust for your database format where 1 = Monday, 2 = Tuesday
    $dbDayOfWeek = ($dayOfWeek == 0) ? 7 : $dayOfWeek; // Convert Sunday(0) to 7

    // Fetch available time slots for the selected day
    $timeSlots = TimeSlot::select('id', 'from_time', 'to_time')
        ->where('day_of_week', $dbDayOfWeek)
        ->get();

    $select = "<option value=''>--select--</option>";

    foreach ($timeSlots as $slot) {
        $fromTime = Carbon::parse($slot->from_time)->format('h:i A'); // Convert to AM/PM format
        $toTime = Carbon::parse($slot->to_time)->format('h:i A'); // Convert to AM/PM format
        
        $select .= '<option value="' . $slot->id . '">' . $fromTime . ' - ' . $toTime . '</option>'; 
    }

    echo $select;
}

    
    public function markUnavailable(Request $request)
    {
        $start_time_end_time =  $request->start_time_end_time;
    
        foreach ($start_time_end_time as $index => $data) {
            // Create a new availability record
            $timeSlot = TimeSlot::select('id', 'from_time', 'to_time')->where('id',  $data)->first();
            Availability::create([
                'from_date' => $request->date,
                'time_slot_id' => $data,
                'start_time' => $timeSlot->from_time,
                'end_time' => $timeSlot->to_time,
            ]);
        }
    
        return response()->json(['message' => 'Date marked as unavailable']);
    }
    

}
