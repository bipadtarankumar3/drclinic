<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;

class SettingController extends Controller
{
    public function setting_list(){
        $data['title']='setting List';
        $data['setting'] = Setting::first();
        return view('admin.pages.setting.setting_list',$data);
    }

    
    public function store(Request $request, $id = null)
    {
        $request->validate([
            'pay_amount' => 'required',
        ]);

            
        $data = [
            'pay_amount' => $request->pay_amount,
            'pay_additional_amount' => $request->pay_additional_amount,
            'payment_terms_and_condition' => $request->payment_terms_and_condition,
            'frontend_notice' => $request->frontend_notice,
            'pay_key' => $request->pay_key,
            'pay_secret_key' => $request->pay_secret_key,
            'clinic_phone_number' => $request->clinic_phone_number,
        ];
    

        if ($id) {
            // Update existing record
            $Setting = Setting::find($id);
            if (!$Setting) {
                return redirect()->back()->with('error', 'Setting not found.');
            }
            $Setting->update($data);
            return redirect()->to('admin/setting')->with('success', 'Setting updated successfully.');
        } else {
            // Insert new record
            Setting::create($data);
            return redirect()->to('admin/setting')->with('success', 'Setting added successfully.');
        }
    }

    public function edit($id)
    {
        $setting = Setting::findOrFail($id);
        $settings = Setting::all();

        return view('admin.pages.setting.setting_list', compact('setting', 'settings'));
    }



    public function destroy($id)
    {
        $Setting = Setting::findOrFail($id);
        $Setting->delete();

        return redirect()->back()->with('success', 'Setting deleted successfully!');
    }

    public function updatePaymentPermission(Request $request)
    {
        $status = $request->has('payment_permission_status') ? 'yes' : 'no';
    
        $setting = DB::table('settings')->first();
    
        if ($setting) {
            DB::table('settings')->where('id', $setting->id)->update(['payment_permission_status' => $status]);
        } else {
            DB::table('settings')->insert(['payment_permission_status' => $status]);
        }
    
        return back()->with('success', 'Payment permission updated successfully.');
    }
    

}
