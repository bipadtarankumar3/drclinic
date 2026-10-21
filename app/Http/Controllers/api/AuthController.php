<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Employee;
use App\Models\CheckInCheckout;
use App\Models\MapLiveTracking;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Login Method


    public function employee_register(Request $request)
    {
        // Validate required fields for both User and Employee
        $validatedData = $request->validate([
            'company_id' => 'required',
            'user_type' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        // Begin database transaction
        DB::beginTransaction();
    
        try {
            // Upload files if provided

            // dd($request->all());die;

            $user = User::where('email', $request->email)->first();
            if ($user) {
                return response()->json([
                    'data' => [],
                    'status' =>0,
                    'message' => 'The email id is already registered.',
                ],200);
            }

            $uploadedFiles = $this->uploadFiles($request, [
                'selfie' => 'upload/selfie',
                'aadhar' => 'upload/aadhar',
                'pan' => 'upload/pan',
                'photo' => 'upload/photo',
            ]);

            $otp = $validatedData['otp'] ?? random_int(100000, 999999);
            $emp_code = random_int(100000, 999999);
            //$otp = 123456;
    
            // Create the user
            $user = User::create([
                'code' => $emp_code,
                'company_id' => $request->company_id,
                'user_type' => $request->user_type,
                'email' => $request->email,
                'name' => $request->name ?? null, 
                'password' => bcrypt($request->password),
                'phone' => $request->phone ?? null,
                'otp' => $otp ?? null,
                'otp_verified' => 'no',
                'selfie' => $uploadedFiles['selfie'] ?? null,
                'status' => 'pending',
            ]);
    
            // Create the employee
            Employee::create([
                'user_id' => $user->id,
                'emp_company_id' => $request->company_id?? null,
                'emp_type' => $request->user_type?? null,
                'emp_code' => $emp_code ?? null,
                'emp_name' => $request->name?? null,
                'emp_location' => $request->emp_location ?? null,
                'emp_branch' => $request->emp_branch ?? null,
                'emp_function' => $request->emp_function ?? null,
                'emp_phone' => $request->phone?? null,
                'emp_email' => $request->email?? null,
                'emp_fm_vehicle_no' => $request->emp_fm_vehicle_no ?? null,
                'emp_dl_date' => $request->emp_dl_date ?? null,
                'emp_selfie' => $uploadedFiles['selfie'] ?? null,
                'emp_aadhar' => $uploadedFiles['aadhar'] ?? null,
                'emp_pan' => $uploadedFiles['pan'] ?? null,
                'emp_photo' => $uploadedFiles['photo'] ?? null,
                'emp_status' => 'pending',
            ]);
    
            // Commit the transaction
            DB::commit();

            // Generate access token
            // $token = $user->createToken('API Token')->accessToken;

            // Convert user object to array and replace null values with empty strings
            $userArray = array(
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'otp' => $user->otp
            );

            return response()->json([
                'data' =>[$userArray],
                'status' => 1,
                'message' => 'Employee registered successfully!',
            ]);
    
            // return response()->json([
            //     'user' => $user,
            //     'status' => 1,
            //     'message' => 'Employee registered successfully!',
            // ], 201);
        } catch (\Exception $e) {
            // Rollback the transaction on failure
            DB::rollBack();
    
            return response()->json([
                'error' => 'Failed to register employee.',
                'status' => 0,
                'details' => $e->getMessage(),
            ], 200);
        }
    }


    public function reg_verify_otp(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'user_id' => 'required|integer',
                'otp' => 'required|integer|digits:6',
            ]);

            // Check if the OTP exists and matches the user
            $user = User::where('id', $validatedData['user_id'])
                ->where('otp', $validatedData['otp'])
                ->where('otp_verified', 'no')
                ->first();

            if (!$user) {
                // OTP does not match
                return response()->json([
                    'message' => 'Invalid OTP.',
                    'status' => 0,
                    'data' => [],

                ], 400);
            }

            // Mark the OTP as verified (optional, depending on your use case)
            $user->otp_verified = 'yes';
            $user->save();


            $userArray = array(
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'otp' => $user->otp
            );


            // Return a success response
            return response()->json([
                'message' => 'OTP verified successfully.',
                'data' => $userArray,
                'status' => 1
            ], 200);

        } catch (ValidationException $e) {
            // Return a custom JSON response for validation errors
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
                'status' => 0,
                'data' => []
            ], 200);
        }
    }
    
/**
 * Handle file uploads for multiple input fields (optional).
 *
 * @param Request $request
 * @param array $fields
 * @return array
 */
private function uploadFiles(Request $request, array $fields)
{
    $uploadedFiles = [];
    foreach ($fields as $field => $path) {
        if ($request->hasFile($field)) {
            $file = $request->file($field);
            // dd($file);
            $filename = uniqid() . '_' . $file->getClientOriginalName(); // Use PHP's uniqid
            $file->move(public_path($path), $filename);
            $uploadedFiles[$field] = url("public/"."$path/$filename");
        }
    }
    return $uploadedFiles;
}



public function login(Request $request)
{
    // Validate input
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Attempt login
    if (!Auth::attempt($credentials)) {
        return response()->json([
            'message' => 'Invalid credentials',
            'status' => 0,
            'token' => '',
            'data' => [
                'id' => '',
                'company_id' => '',
                'name' =>'',
                'user_type' =>'',
                'email' => '',
                'phone' => '',
                'otp' => ''
            ],
        ], 200);
    }

    $user = Auth::user();

    // Check if the user's status is inactive
    if ( $user->otp_verified !== 'yes') {
        return response()->json([
            'message' => 'OTP is not verified. Please verify your OTP.',
            'status' => 0,
            'token' => '',
            'data' => [
                'id' => '',
                'company_id' => '',
                'name' =>'',
                 'user_type' =>'',
                'email' => '',
                'phone' => '',
                'otp' => ''
            ],
        ], 200); // 403: Forbidden
    }
    // Check if the user's status is inactive
    if ($user->status !== 'active') {
        return response()->json([
            'message' => 'Account is inactive. Please contact support.',
            'status' => 0,
            'token' => '',
            'data' => [
                'id' => '',
                'company_id' => '',
                'name' =>'',
                 'user_type' =>'',
                'email' => '',
                'phone' => '',
                'otp' => ''
            ],
        ], 200); // 403: Forbidden
    }

    // Generate access token
    $token = $user->createToken('API Token')->accessToken;

    $CheckInCheckout = CheckInCheckout::where('ckn_user_id', $user->id)->orderBy('id', 'desc')->first();

    // Convert user object to array and replace null values with empty strings
    $userArray = array(
        'id' => $user->id,
        'company_id' => $user->company_id,
        'name' => $user->name,
        'user_type' => $user->user_type,
        'email' => $user->email,
        'phone' => $user->phone,
        'otp' => $user->otp,
        'check_in_checkout' => $CheckInCheckout?$CheckInCheckout->ckn_in_out_status:'',
    );
    
    return response()->json([
        'message' => 'Successfully logged in',
        'status' => 1,
        'token' => $token,
        'user' => $userArray,
    ]);
}



    public function userDetails(Request $request)
    {
        $user = User::select('id', 'company_id', 'name', 'user_type', 'email', 'phone', 'otp', 'otp_verified', 'status')->where('id', $request->user_id)
                ->first();

        if (!$user) {
            return response()->json([
                'message' => 'User not found.',
                'status' => 0,
                'data' => [],
            ], 200);
        }

        return response()->json([
            'message' => 'User details retrieved successfully.',
            'data' => $user,
            'status' => 1
        ]);
    }   

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out',
            'status' => 1
        ]);
    }   


  
    public function check_in_checkouts(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'user_id' => 'required|integer|exists:users,id',
                'phone_no' => 'required|string|regex:/^[0-9]{10}$/',
                'selfie' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'lat' => 'nullable',
                'long' => 'nullable',
                'place' => 'nullable|string|max:255',
                'in_out_status' => 'nullable|string',
            ]);

            $user = User::where('id', $validatedData['user_id'])
                ->where('phone', $validatedData['phone_no'])
                ->first();

                if (!$user) {
                    return response()->json([
                        'message' => 'Please use register mobile number.',
                        'status' => 0,
                        'data' => [],
                    ], 200); 
                }

    
            $url = null;
    
            // Handle selfie upload if provided
            if ($request->hasFile('selfie')) {
                $screenshot = $request->file('selfie');
                $milisecond = round(microtime(true) * 1000);
                $name = $screenshot->getClientOriginalName();
                $actual_name = str_replace(" ", "_", $name);
                $uploadName = $milisecond . "_" . $actual_name;
                $screenshot->move(public_path('upload/check_in_checkout'), $uploadName);
                $url = url('public/upload/check_in_checkout/' . $uploadName);
            }
    
            // Generate a 6-digit OTP if not provided in the request
            $otp = $validatedData['otp'] ?? random_int(100000, 999999);
            // $otp = 123456;
    
            date_default_timezone_set('Asia/Kolkata');
            // Insert the data into the database
            $checkInCheckout = new CheckInCheckout();
            $checkInCheckout->ckn_user_id = $validatedData['user_id'];
            $checkInCheckout->ckn_phone_no = $validatedData['phone_no'];
            $checkInCheckout->ckn_selfie = $url;
            $checkInCheckout->ckn_otp = $otp;
            $checkInCheckout->ckn_lat = $validatedData['lat'] ?? '';
            $checkInCheckout->ckn_long = $validatedData['long'] ?? '';
            $checkInCheckout->ckn_place = $validatedData['place'] ?? '';
            $checkInCheckout->ckn_time = $request->time ?? null;
            $checkInCheckout->ckn_date = $request->date ?? null;
            $checkInCheckout->ckn_in_out_status = $validatedData['in_out_status'] ?? '';
            $checkInCheckout->save();

            MapLiveTracking::create([  
                'user_id' => $validatedData['user_id'],
                'lat' => $validatedData['lat'],
                'long' => $validatedData['long'],
                'date' => date('Y-m-d'),
                'status' => $validatedData['in_out_status'],
            ]);
            

            // Return a success response
            return response()->json([
                'message' => 'Data saved successfully.',
                'otp' => $otp,
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
    

public function verify_otp(Request $request)
{
    try {
        // Validate the request data
        $validatedData = $request->validate([
            'user_id' => 'required|integer|exists:check_in_checkouts,ckn_user_id',
            'otp' => 'required|integer|digits:6',
        ]);

        // Check if the OTP exists and matches the user
        $checkInCheckout = CheckInCheckout::where('ckn_user_id', $validatedData['user_id'])
            ->where('ckn_otp', $validatedData['otp'])
            ->first();

        if (!$checkInCheckout) {
            // OTP does not match
            return response()->json([
                'message' => 'Invalid OTP.',
                'status' => 0

            ], 200);
        }

        // Mark the OTP as verified (optional, depending on your use case)
        $checkInCheckout->ckn_status = 'verified';
        $checkInCheckout->save();

        // Return a success response
        return response()->json([
            'message' => 'OTP verified successfully.',
            'data' => $checkInCheckout,
            'status' => 1
        ], 200);

    } catch (ValidationException $e) {
        // Return a custom JSON response for validation errors
        return response()->json([
            'message' => 'Validation failed.',
            'errors' => $e->errors(),
            'status' => 0
        ], 200);
    }
}

public function profile(Request $request)
{
    try {
        // Validate the request data
        $validatedData = $request->validate([
            'user_id' => 'required'
        ]);

        // Check if the OTP exists and matches the user
        $Employee = Employee::where('user_id', $validatedData['user_id'])->first();
            
        return response()->json([
            'message' => 'Employee profile retrieved successfully.',
            'data' => $Employee,
            'status' => 1
        ], 200);

    } catch (ValidationException $e) {
        // Return a custom JSON response for validation errors
        return response()->json([
            'message' => 'Validation failed.',
            'errors' => $e->errors(),
            'status' => 0
        ], 200);
    }
}




}
