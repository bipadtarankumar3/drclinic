<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Area;
use App\Models\Logistic;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


class MasterController extends Controller
{
    public function area(Request $request)
    {
        $user = User::where('id', $request->user_id)
            ->first();

        if (!$user) {
            return response()->json([
                'message' => 'User not found.',
                'status' => 0,
                'data' => [],
            ], 404);
        }

        $area = Area::where('area_company_id', $user->company_id)->get();

        if (!$area) {
            return response()->json([
                'message' => 'area not found.',
                'status' => 0,
                'data' => [],
            ], 404);
        }

        return response()->json([
            'message' => 'area retrieved successfully.',
            'data' => $area,
            'status' => 1
        ]);
    } 

    public function logistic(Request $request)
    {


        $logistic =Logistic::get();

        if (!$logistic) {
            return response()->json([
                'message' => 'area not found.',
                'status' => 0,
                'data' => [],
            ], 404);
        }

        return response()->json([
            'message' => 'logistic retrieved successfully.',
            'data' => $logistic,
            'status' => 1
        ]);
    } 
    public function clients(Request $request)
    {


        $User =User::select('id','name','email','phone')->where('user_type','client')->get();

        if (!$User) {
            return response()->json([
                'message' => 'area not found.',
                'status' => 0,
                'data' => [],
            ], 404);
        }

        return response()->json([
            'message' => 'Clients retrieved successfully.',
            'data' => $User,
            'status' => 1
        ]);
    } 

    public function employee(Request $request)
    {


        $User =User::select('id','name','email','phone','user_type')->where('user_type','!=','client')->where('user_type','!=','admin')->where('status','active')->get();

        if (!$User) {
            return response()->json([
                'message' => 'area not found.',
                'status' => 0,
                'data' => [],
            ], 404);
        }

        return response()->json([
            'message' => 'Employee retrieved successfully.',
            'data' => $User,
            'status' => 1
        ]);
    } 

    public function vehicle_type(Request $request)
    {


        $User =Vehicle::select('id','vehicle_number','vehicle_type','vehicle_weight')->where('vehicle_status','Publish')->get();

        if (!$User) {
            return response()->json([
                'message' => 'area not found.',
                'status' => 0,
                'data' => [],
            ], 404);
        }

        return response()->json([
            'message' => 'vehicle type retrieved successfully.',
            'data' => $User,
            'status' => 1
        ]);
    } 

    public function vehicle(Request $request)
    {


        $User =Vehicle::select('id','vehicle_number','vehicle_type')->where('vehicle_type',$request->vehicle_type)->where('vehicle_status','Publish')->get();

        if (!$User) {
            return response()->json([
                'message' => 'area not found.',
                'status' => 0,
                'data' => [],
            ], 404);
        }

        return response()->json([
            'message' => 'vehicle retrieved successfully.',
            'data' => $User,
            'status' => 1
        ]);
    } 

}
