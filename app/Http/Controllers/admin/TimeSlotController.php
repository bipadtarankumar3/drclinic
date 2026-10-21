<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;

class TimeSlotController extends Controller
{
    public function time_slot_list(){
        $data['title']='time slot List';
        $data['timeSlots'] = TimeSlot::all();
        return view('admin.pages.time_slot.time_slot_list',$data);
    }

    public function time_slot_add(){
        $data['title']='time slot add';
        return view('admin.pages.time_slot.time_slot_add',$data);
    }

    public function edit_time_slot($id)
    {
        $timeSlot = TimeSlot::find($id);

        if (!$timeSlot) {
            return redirect()->back()->with('error', 'Time Slot not found!');
        }

        return view('admin.pages.time_slot.time_slot_add', compact('timeSlot'));
    }

    public function time_slot_submit(Request $request, $id = null)
    {
        $request->validate([
            'day_of_week' => 'required',
            'from_time' => 'required',
            'to_time' => 'required',
            'status' => 'required|in:active,inactive',
        ]);
    
        $data = [
            'day_of_week' => $request->day_of_week,
            'from_time' => $request->from_time,
            'to_time' => $request->to_time,
            'status' => $request->status,
        ];
    
        if ($id) {
            // Update existing record
            $timeSlot = TimeSlot::find($id);
            if (!$timeSlot) {
                return redirect()->back()->with('error', 'Time slot not found.');
            }
            $timeSlot->update($data);
            return redirect()->to('admin/time_slot')->with('success', 'Time slot updated successfully.');
        } else {
            // Insert new record
            TimeSlot::create($data);
            return redirect()->to('admin/time_slot')->with('success', 'Time slot added successfully.');
        }
    }


    public function delete_time_slot($id)
    {
        $timeSlot = TimeSlot::find($id);
        
        if (!$timeSlot) {
            return redirect()->back()->with('error', 'Time Slot not found!');
        }

        $timeSlot->delete();
        return redirect()->back()->with('success', 'Time Slot deleted successfully!');
    }

    
}
