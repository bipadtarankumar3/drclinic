<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\TransportRoadways;
use App\Models\CheckInCheckout;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


class TransportRoadwaysController extends Controller
{
    


    /**
     * Creates a new transport roadways entry
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function transport_roadways_create(Request $request){
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'user_id' => 'required|integer|exists:users,id',
                'date' => 'nullable|date'
            ]);
    
            // Handle visit card upload if provided
            // $visitCardUrl = null;
            // if ($request->hasFile('visit_card')) {
            //     $visitCard = $request->file('visit_card');
            //     $milisecond = round(microtime(true) * 1000);
            //     $name = $visitCard->getClientOriginalName();
            //     $actual_name = str_replace(" ", "_", $name);
            //     $uploadName = $milisecond . "_" . $actual_name;
            //     $visitCard->move(public_path('upload/visitors/visit_cards'), $uploadName);
            //     $visitCardUrl = url('public/upload/visitors/visit_cards/' . $uploadName);
            // }
    
            // Insert the data into the database
            $visitorDetail = new TransportRoadways();
            $visitorDetail->date = $request->date ?? now();
            $visitorDetail->vehicle_no = $request->vehicle_no ?? null;
            $visitorDetail->vehicle_type = $request->vehicle_type ?? null;
            $visitorDetail->km = $request->km ?? null;
            $visitorDetail->fuel_amount = $request->fuel_amount ?? null;
            $visitorDetail->driver_name = $request->driver_name ?? null;
            $visitorDetail->remarks = $request->remarks ?? null;
            $visitorDetail->status = $request->status ?? null;
            $visitorDetail->blue_km = $request->blue_km ?? null;
            $visitorDetail->blue_amount = $request->blue_amount ?? null;
            $visitorDetail->created_by = $request->user_id;
            $visitorDetail->save();
    
            // Return a success response
            return response()->json([
                'message' => 'Transport Roadways data saved successfully.',
                'status' => 1,
                'data' => $visitorDetail,
            ], 201);
    
        } catch (ValidationException $e) {
            // Return a custom JSON response for validation errors
            return response()->json([
                'message' => 'Validation failed.',
                'status' => 0,
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Catch any general exception
            return response()->json([
                'message' => 'An error occurred.',
                'status' => 0,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}
