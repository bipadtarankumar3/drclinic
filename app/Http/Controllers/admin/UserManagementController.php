<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Employee;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;

class UserManagementController extends Controller
{

    public function userList(){
        $data['title']='User Lists';
        $data['users']=User::where('user_type','user')->get();
        $data['customer']=Customer::get();
        return view('admin.pages.user.list',$data);
    }

    
    public function userAdd(){
        $data['title']='User Add';
        $data['users']=User::where('user_type','user')->get();
        
        return view('admin.pages.user.add',$data);
    }

    public function edit($id)
    {
        $data['user'] = User::findOrFail($id);
        
        return view('admin.pages.user.add',  $data);
    }

    public function save_user(Request $request, $id = null)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        // Check if the user exists, update if so, otherwise create a new user
        if ($id) {
            $user = User::findOrFail($id);
            $message = 'User updated successfully.';
        } else {
            $user = new User();
            $user->password = Hash::make('12345678');
            $user->user_type = 'customer';
            $message = 'User created successfully.';
        }

        // Assign the request data to the user model
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->status = $request->status;
        $user->user_type = 'client';

        // Save the user
        $user->save();

        // Redirect back to the user list with a success message
        return back()->with('success', $message);
    }

    public function destroyUser($id)
    {
        $Product = User::findOrFail($id);
        $Product->delete();
        return redirect('admin/user/list')->with('success', 'User deleted successfully.');
    }


    public function statusChange(Request $request){
        $user = User::findOrFail($request->id);
        $user->status = $request->status;
        $user->save();
        return redirect()->back()->with('success','Status updated successfully');
    }

    public function approved_user($id){
        $data['title']='Approve User';
        $data['user']=User::where('id',$id)->first();
        
        return view('admin.pages.user_management.approved_user',$data);
    }


    public function approved_user_edit($id){
        $data['title']='Approve User';
        $data['user']=User::where('id',$id)->first();
        $data['Employee']=Employee::where('user_id',$id)->first();
        // dd($data['Employee']);
        return view('admin.pages.user_management.approved_user_edit',$data);
    }

    public function approved_user_update(Request $request)
    {

        // dd($request->all());

        // Validate required fields for both User and Employee
        $validatedData = $request->validate([
            'company_id' => 'required',
            'email' => 'required|email'
        ]);

        // Begin database transaction
        DB::beginTransaction();

        try {
            

            // Upload files if provided
            $uploadedFiles = $this->uploadFiles($request, [
                'selfie' => 'upload/selfie',
                'aadhar' => 'upload/aadhar',
                'pan' => 'upload/pan',
                'photo' => 'upload/photo',
            ]);

            // dd($uploadedFiles);

            // Update the user
            $userData = [
                'company_id' => $request->company_id,
                'email' => $request->email,
                'name' => $request->name ?? null,
                'phone' => $request->phone ?? null,
                'status' => $request->status ?? null,
            ];

            // Add file fields if they exist
            if (!empty($request->password)) {
                $userData['password'] = bcrypt($request->password);
            }

            if (!empty($uploadedFiles['selfie'])) {
                $userData['selfie'] = $uploadedFiles['selfie'];
            }

            User::where('id', $request->user_id ?? null)->update($userData);

            // Update the employee
            $employeeData = [
                'user_id' => $request->user_id ?? null,
                'emp_company_id' => $request->company_id ?? null,
                'emp_type' => $request->user_type ?? null,
                'emp_name' => $request->name ?? null,
                'emp_location' => $request->emp_location ?? null,
                'emp_branch' => $request->emp_branch ?? null,
                'emp_function' => $request->emp_function ?? null,
                'emp_phone' => $request->phone ?? null,
                'emp_email' => $request->email ?? null,
                'emp_fm_vehicle_no' => $request->emp_fm_vehicle_no ?? null,
                'emp_dl_date' => $request->emp_dl_date ?? null,
                'emp_status' => $request->status ?? null,
            ];

            // Add file fields if they exist
            if (!empty($uploadedFiles['selfie'])) {
                $employeeData['emp_selfie'] = $uploadedFiles['selfie'];
            }
            if (!empty($uploadedFiles['aadhar'])) {
                $employeeData['emp_aadhar'] = $uploadedFiles['aadhar'];
            }
            if (!empty($uploadedFiles['pan'])) {
                $employeeData['emp_pan'] = $uploadedFiles['pan'];
            }
            if (!empty($uploadedFiles['photo'])) {
                $employeeData['emp_photo'] = $uploadedFiles['photo'];
            }

            Employee::where('user_id', $request->user_id ?? null)->update($employeeData);

            // Commit the transaction
            DB::commit();

            return redirect()->back()->with('success', 'User updated successfully');
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


    public function newOfficeEmployee(){
        $data['title']='New Office Employee';
        $data['users']=User::where('user_type','office_employee')->where('otp_verified','yes')->where('status','=','pending')->orderBy('id','desc')->get();
        return view('admin.pages.user_management.newOfficeEmployee',$data);
    }

    public function newFieldDriver(){
        $data['title']='New Field Employee';
        $data['users']=User::with('employee')->where('user_type','field_employee')->where('otp_verified','yes')->where('status','=','pending')->orderBy('id','desc')->get();
        return view('admin.pages.user_management.newFieldDriver',$data);
    }

    public function newSalesEmployee(){
        $data['title']='new Sales Employee';
        $data['users']=User::with('employee')->where('user_type','sales_employee')->where('otp_verified','yes')->where('status','=','pending')->orderBy('id','desc')->get();
        return view('admin.pages.user_management.newSalesEmployee',$data);
    }

    public function newTransportEmployee(){
        $data['title']='new Transport Employee';
        $data['users']=User::with('employee')->where('user_type','transport_employee')->where('otp_verified','yes')->where('status','=','pending')->orderBy('id','desc')->get();
        return view('admin.pages.user_management.newTransportEmployee',$data);
    }

    public function approvedOfficeEmployee(){
        $data['title']='approved Office Employee';
        $data['users']=User::with('employee')->where('user_type','office_employee')->where('status','!=','pending')->orderBy('id','desc')->get();
        return view('admin.pages.user_management.approvedOfficeEmployee',$data);
    }

    public function approvedFieldDriver(){
        $data['title']='approved Field Emplyeer';
        $data['users']=User::where('user_type','field_employee')->where('status','!=','pending')->orderBy('id','desc')->get();
        return view('admin.pages.user_management.approvedFieldDriver',$data);
    }

    public function approvedSalesEmployee(){
        $data['title']='approved Sales Employee';
        $data['users']=User::where('user_type','sales_employee')->where('status','!=','pending')->orderBy('id','desc')->get();
        return view('admin.pages.user_management.approvedSalesEmployee',$data);
    }

    public function approvedTransportEmployee(){
        $data['title']='approved Transport Employee';
        $data['users']=User::where('user_type','transport_employee')->where('status','!=','pending')->orderBy('id','desc')->get();
        return view('admin.pages.user_management.approvedTransportEmployee',$data);
    }



    
}
