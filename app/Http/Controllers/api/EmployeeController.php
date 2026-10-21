<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Consignment;
use App\Models\ConsignmentEmployee;
use App\Models\CheckInCheckout;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class EmployeeController extends Controller
{
    public function consignment_fm_create(Request $request)
    {

        try {
            // Validate the request data
            $validatedData = $request->validate([
                'user_id' => 'required',
                // Add any other validation rules as needed
            ]);

            $randomNumber = rand(1, 100);


            // Handle any file uploads if necessary
            $picture_url = null;
            if ($request->hasFile('picture')) {
                $visitCard = $request->file('picture');
                $milisecond = round(microtime(true) * 1000);
                $name = $visitCard->getClientOriginalName();
                $actual_name = str_replace(" ", "_", $name);
                $uploadName = $milisecond . "_" . $actual_name;
                $visitCard->move(public_path('upload/consignments'), $uploadName);
                $picture_url = url('public/upload/consignments/' . $uploadName);
            }
    
            // Insert the data into the database
            $consignment = new Consignment();
            $consignment->unique_id = $randomNumber ?? null;
            $consignment->consignment_type = $request->consignment_type ?? null;
            $consignment->appointment = $request->appointment ?? null;
            $consignment->logistic_name = $request->logistic_name ?? null;
            $consignment->client_name = $request->client_name;
            $consignment->no_of_cn = $request->no_of_cn ?? null;
            $consignment->total_package = $request->total_package ?? null;
            $consignment->package_type = $request->package_type ?? null;
            $consignment->total_weight = $request->total_weight ?? null;
            $consignment->vehicle_number = $request->vehicle_number ?? null;
            $consignment->vehicle_weight = $request->vehicle_weight ?? null;
            $consignment->condition = $request->condition ?? null;
            $consignment->handling_cost_amount = $request->handling_cost_amount ?? null;
            $consignment->review_condition = $request->review_condition ?? null;
            $consignment->comments = $request->comments ?? null;
            $consignment->status = $request->status ?? 'pending';  // Default to 'pending' if not provided
            $consignment->created_by = $request->user_id;
            $consignment->picture = $picture_url;  // Save the visit card URL if uploaded
            $consignment->lat = $request->lat;
            $consignment->long = $request->long;
            $consignment->fetch_address = $request->fetch_address;
            $consignment->save();
            
            $consignment_id = $consignment->id;
            $employee_id = $request->employee_id;
            if (!empty($employee_id)) {
                $emp_arr = explode(',', $employee_id);
                foreach ($emp_arr as $key => $value) {
                    $consignmentEmployee = new ConsignmentEmployee();
                    $consignmentEmployee->consignment_id = $consignment_id;
                    $consignmentEmployee->employee_id = $value;
                    $consignmentEmployee->save();
                }
            }
            
            
    
            // Return a success response
            return response()->json([
                'message' => 'Consignment created successfully.',
                // 'data' => $consignment,
                'status' => 1,
            ], 201);
    
        } catch (ValidationException $e) {
            // Return a custom JSON response for validation errors
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
                'status' => 0,
            ], 422);
        } catch (\Exception $e) {
            // Catch any general exception
            return response()->json([
                'message' => 'An error occurred.',
                'error' => $e->getMessage(),
                'status' => 0,
            ], 500);
        }

    }

    public function consignment_create(Request $request)
    {

        try {
            // Validate the request data
            $validatedData = $request->validate([
                'user_id' => 'required',
                // Add any other validation rules as needed
            ]);

            $randomNumber = rand(1000000000, 9999999999);


            if ($request->form_type == 'undeliverd') {

                // dd($request->dispatch_id);
                
                $dispatch_id = explode(',', $request->dispatch_id);
                $logistic_name = explode(',', $request->logistic_name);
                $client_name = explode(',', $request->client_name);
                $no_of_cn = explode(',', $request->no_of_cn);
                $total_package = explode(',', $request->total_package);
                $total_weight = explode(',', $request->total_weight);
                $vehicle_number = explode(',', $request->vehicle_number);
                $vehicle_weight = explode(',', $request->vehicle_weight);

                foreach ($dispatch_id as $key => $value) {

                    // Insert the data into the database
                    $consignment = new Consignment();
                    $consignment->unique_id = $randomNumber ?? null;
                    $consignment->consignment_type = $request->consignment_type ?? null;
                    $consignment->form_type = $request->form_type ?? null;
                    $consignment->dispatch_id = $dispatch_id[$key] ?? null;
                    // $consignment->appointment = $appointment[$key] ?? null;
                    $consignment->logistic_name = $logistic_name[$key] ?? null;
                    $consignment->client_name = $client_name[$key]??null;
                    $consignment->no_of_cn = $no_of_cn[$key] ?? null;
                    $consignment->total_package = $total_package[$key] ?? null;
                    $consignment->total_weight = $total_weight[$key] ?? null;
                    $consignment->vehicle_number = $vehicle_number[$key] ?? null;
                    $consignment->vehicle_weight = $vehicle_weight[$key] ?? null;
                    $consignment->comments = $request->comments ?? null;
                    $consignment->status = $request->status ?? 'pending';  // Default to 'pending' if not provided
                    $consignment->lat = $request->lat;
                    $consignment->long = $request->long;
                    $consignment->fetch_address = $request->fetch_address;
                    $consignment->created_by = $request->user_id;
                    $consignment->save();

                    $consignment_id = $consignment->id;
                    $employee_id = $request->employee_id;
                    if (!empty($employee_id)) {
                        $emp_arr = explode(',', $employee_id);
                        foreach ($emp_arr as $key => $value) {
                            $consignmentEmployee = new ConsignmentEmployee();
                            $consignmentEmployee->consignment_id = $consignment_id;
                            $consignmentEmployee->employee_id = $value;
                            $consignmentEmployee->save();
                        }
                    }
                }
        
                

            } else {
                // Handle any file uploads if necessary
                $picture_url = null;
                if ($request->hasFile('picture')) {
                    $visitCard = $request->file('picture');
                    $milisecond = round(microtime(true) * 1000);
                    $name = $visitCard->getClientOriginalName();
                    $actual_name = str_replace(" ", "_", $name);
                    $uploadName = $milisecond . "_" . $actual_name;
                    $visitCard->move(public_path('upload/consignments'), $uploadName);
                    $picture_url = url('public/upload/consignments/' . $uploadName);
                }
        
                // Insert the data into the database
                $consignment = new Consignment();
                $consignment->unique_id = $randomNumber ?? null;
                $consignment->consignment_type = $request->consignment_type ?? null;
                $consignment->form_type = $request->form_type ?? null;
                $consignment->dispatch_id = $request->dispatch_id ?? null;
                $consignment->appointment = $request->appointment ?? null;
                $consignment->logistic_name = $request->logistic_name ?? null;
                $consignment->client_name = $request->client_name;
                $consignment->no_of_cn = $request->no_of_cn ?? null;
                $consignment->total_package = $request->total_package ?? null;
                $consignment->package_type = $request->package_type ?? null;
                $consignment->total_weight = $request->total_weight ?? null;
                $consignment->vehicle_number = $request->vehicle_number ?? null;
                $consignment->condition = $request->condition ?? null;
                $consignment->handling_cost_amount = $request->handling_cost_amount ?? null;
                $consignment->other_employee = $request->other_employee ?? null;
                $consignment->review_condition = $request->review_condition ?? null;
                $consignment->comments = $request->comments ?? null;
                $consignment->status = $request->status ?? 'pending';  // Default to 'pending' if not provided
                $consignment->created_by = $request->user_id;
                $consignment->picture = $picture_url;  // Save the visit card URL if uploaded
                $consignment->lat = $request->lat;
                $consignment->long = $request->long;
                $consignment->fetch_address = $request->fetch_address?? null;
                $consignment->save();

                $consignment_id = $consignment->id;
                $employee_id = $request->employee_id;
                if (!empty($employee_id)) {
                    $emp_arr = explode(',', $employee_id);
                    foreach ($emp_arr as $key => $value) {
                        $consignmentEmployee = new ConsignmentEmployee();
                        $consignmentEmployee->consignment_id = $consignment_id;
                        $consignmentEmployee->employee_id = $value;
                        $consignmentEmployee->save();
                    }
                }
            }
            
    
            
    
            // Return a success response
            return response()->json([
                'message' => 'Consignment created successfully.',
                // 'data' => $consignment,
                'status' => 1,
            ], 201);
    
        } catch (ValidationException $e) {
            // Return a custom JSON response for validation errors
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
                'status' => 0,
            ], 422);
        } catch (\Exception $e) {
            // Catch any general exception
            return response()->json([
                'message' => 'An error occurred.',
                'error' => $e->getMessage(),
                'status' => 0,
            ], 500);
        }

    }
}
