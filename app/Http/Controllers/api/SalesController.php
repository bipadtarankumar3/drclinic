<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\VisitorDetails;
use App\Models\CheckInCheckout;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SalesController extends Controller
{
    public function sales_create(Request $request){
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'user_id' => 'required|integer|exists:users,id',
                'visit_date' => 'nullable|date'
            ]);
    
            // Handle visit card upload if provided
            $visitCardUrl = null;
            if ($request->hasFile('visit_card')) {
                $visitCard = $request->file('visit_card');
                $milisecond = round(microtime(true) * 1000);
                $name = $visitCard->getClientOriginalName();
                $actual_name = str_replace(" ", "_", $name);
                $uploadName = $milisecond . "_" . $actual_name;
                $visitCard->move(public_path('upload/visitors/visit_cards'), $uploadName);
                $visitCardUrl = url('public/upload/visitors/visit_cards/' . $uploadName);
            }
    
            // Insert the data into the database
            $visitorDetail = new VisitorDetails();
            $visitorDetail->date_of_visit = $request->visit_date ?? now();
            $visitorDetail->client_company_name = $request->client_company_name ?? null;
            $visitorDetail->address = $request->address ?? null;
            $visitorDetail->contact_person_name = $request->contact_person_name ?? null;
            $visitorDetail->designation = $request->designation ?? null;
            $visitorDetail->phone_number = $request->phone_number;
            $visitorDetail->office_phone_number = $request->office_phone_number;
            $visitorDetail->zone_area = $request->zone_area ?? null;
            $visitorDetail->visit_card = $visitCardUrl;
            $visitorDetail->lat = $request->lat ?? null;
            $visitorDetail->long = $request->long ?? null;
            $visitorDetail->place = $request->place ?? null;
            $visitorDetail->comments = $request->comments ?? null;
            $visitorDetail->status = $request->status ?? 'arrived';  // Default to 'arrived' if not provided
            $visitorDetail->created_by = $request->user_id;
            $visitorDetail->save();
    
            // Return a success response
            return response()->json([
                'message' => 'Visitor data saved successfully.',
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
