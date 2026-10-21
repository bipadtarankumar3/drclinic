<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    public function companyList()
    {
        // Fetch all company records
        $companies = Company::all(); 
    
        // Return data as a JSON response
        return response()->json([
            'status' => '1',
            'message' => 'Company List',
            'data' => $companies
        ], 200); // You can adjust the HTTP status code as needed
    }
    
}
