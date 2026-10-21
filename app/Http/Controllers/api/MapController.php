<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\CheckInCheckout;
use App\Models\MapLiveTracking;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MapController extends Controller
{
    
    public function live_tracking_submit(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'user_id' => 'required|integer|exists:users,id',
                'lat' => 'required',
                'long' => 'required',
            ]);

            MapLiveTracking::create([  
                'user_id' => $validatedData['user_id'],
                'lat' => $validatedData['lat'],
                'long' => $validatedData['long'],
                'date' => date('Y-m-d')
            ]);
            
            

            // Return a success response
            return response()->json([
                'message' => 'Data saved successfully.',
                'status' =>1
            ], 200);
    
        } catch (ValidationException $e) {
            // Return a custom JSON response for validation errors
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
                'status' => 0,
            ], 200);
        }
    }
    
}
