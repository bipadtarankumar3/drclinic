<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClinicInquiry;
use Illuminate\Support\Facades\Auth;

class DoctorInquiryController extends Controller
{
    public function index(Request $request)
    {
        $clinic = Auth::user()->getActiveClinic();
        if (!$clinic) {
            return redirect()->route('clinic.onboarding');
        }

        $query = ClinicInquiry::where('clinic_id', $clinic->id)->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        $inquiries = $query->paginate(15);
        $unreadCount = ClinicInquiry::where('clinic_id', $clinic->id)->where('status', 'unread')->count();

        return view('doctor.inquiries.index', compact('clinic', 'inquiries', 'unreadCount'));
    }

    public function show($id)
    {
        $clinic = Auth::user()->getActiveClinic();
        if (!$clinic) {
            return redirect()->route('clinic.onboarding');
        }

        $inquiry = ClinicInquiry::where('clinic_id', $clinic->id)->findOrFail($id);

        if ($inquiry->status === 'unread') {
            $inquiry->update(['status' => 'read']);
        }

        return view('doctor.inquiries.show', compact('clinic', 'inquiry'));
    }

    public function destroy($id)
    {
        $clinic = Auth::user()->getActiveClinic();
        if (!$clinic) {
            return redirect()->route('clinic.onboarding');
        }

        $inquiry = ClinicInquiry::where('clinic_id', $clinic->id)->findOrFail($id);
        $inquiry->delete();

        return redirect()->route('clinic.inquiries.index')->with('success', 'Inquiry deleted successfully.');
    }
}
