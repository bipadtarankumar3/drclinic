<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClinicService;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class DoctorServiceController extends Controller
{
    /**
     * Display all services for current clinic
     */
    public function index()
    {
        $clinic = Auth::user()->getActiveClinic();
        if (!$clinic) {
            return redirect()->route('doctor.onboarding');
        }

        $services = ClinicService::where('clinic_id', $clinic->id)->orderBy('sort_order', 'asc')->get();

        // If clinic has no services yet, seed standard tailored services
        if ($services->isEmpty()) {
            $this->seedDefaultServicesForClinic($clinic);
            $services = ClinicService::where('clinic_id', $clinic->id)->orderBy('sort_order', 'asc')->get();
        }

        return view('doctor.services.index', compact('clinic', 'services'));
    }

    /**
     * Show create service page
     */
    public function create()
    {
        $clinic = Auth::user()->getActiveClinic();
        if (!$clinic) {
            return redirect()->route('doctor.onboarding');
        }

        return view('doctor.services.create', compact('clinic'));
    }

    /**
     * Store new clinic service
     */
    public function store(Request $request)
    {
        $clinic = Auth::user()->getActiveClinic();
        if (!$clinic) {
            return redirect()->route('doctor.onboarding');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'icon' => 'nullable|string|max:100',
            'price' => 'nullable|numeric|min:0',
            'sort_order' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:3072',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = strtolower($file->getClientOriginalExtension()) ?: 'jpg';
            $fileName = 'service_' . $clinic->id . '_' . time() . '_' . rand(100, 999) . '.' . $ext;
            $file->move(public_path('upload/clinic_services'), $fileName);
            $imagePath = 'upload/clinic_services/' . $fileName;
        }

        ClinicService::create([
            'clinic_id' => $clinic->id,
            'title' => $request->title,
            'description' => $request->description,
            'icon' => $request->icon ?: 'fa-stethoscope',
            'price' => $request->filled('price') ? $request->price : null,
            'image' => $imagePath,
            'sort_order' => $request->filled('sort_order') ? (int)$request->sort_order : 0,
            'status' => $request->has('status') ? true : false,
        ]);

        ActivityLog::log('clinic_service_created', "Created service '{$request->title}'", $clinic->id);

        return redirect()->route('doctor.services.index')->with('success', "Service '{$request->title}' added successfully.");
    }

    /**
     * Show edit service page
     */
    public function edit($id)
    {
        $clinic = Auth::user()->getActiveClinic();
        if (!$clinic) {
            return redirect()->route('doctor.onboarding');
        }

        $service = ClinicService::where('clinic_id', $clinic->id)->findOrFail($id);

        return view('doctor.services.edit', compact('clinic', 'service'));
    }

    /**
     * Update existing clinic service
     */
    public function update(Request $request, $id)
    {
        $clinic = Auth::user()->getActiveClinic();
        if (!$clinic) {
            return redirect()->route('doctor.onboarding');
        }

        $service = ClinicService::where('clinic_id', $clinic->id)->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'icon' => 'nullable|string|max:100',
            'price' => 'nullable|numeric|min:0',
            'sort_order' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:3072',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'icon' => $request->icon ?: 'fa-stethoscope',
            'price' => $request->filled('price') ? $request->price : null,
            'sort_order' => $request->filled('sort_order') ? (int)$request->sort_order : 0,
            'status' => $request->has('status'),
        ];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = strtolower($file->getClientOriginalExtension()) ?: 'jpg';
            $fileName = 'service_' . $clinic->id . '_' . time() . '_' . rand(100, 999) . '.' . $ext;
            $file->move(public_path('upload/clinic_services'), $fileName);
            $data['image'] = 'upload/clinic_services/' . $fileName;
        }

        $service->update($data);

        ActivityLog::log('clinic_service_updated', "Updated service '{$service->title}'", $clinic->id);

        return redirect()->route('doctor.services.index')->with('success', "Service '{$service->title}' updated successfully.");
    }

    /**
     * Toggle service status
     */
    public function toggleStatus($id)
    {
        $clinic = Auth::user()->getActiveClinic();
        $service = ClinicService::where('clinic_id', $clinic->id)->findOrFail($id);
        $service->status = !$service->status;
        $service->save();

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'status' => $service->status,
                'message' => 'Service status updated.'
            ]);
        }

        return redirect()->back()->with('success', "Service '{$service->title}' status updated.");
    }

    /**
     * Delete service
     */
    public function destroy($id)
    {
        $clinic = Auth::user()->getActiveClinic();
        $service = ClinicService::where('clinic_id', $clinic->id)->findOrFail($id);
        $title = $service->title;
        $service->delete();

        ActivityLog::log('clinic_service_deleted', "Deleted service '{$title}'", $clinic->id);

        return redirect()->route('doctor.services.index')->with('success', "Service '{$title}' removed successfully.");
    }

    /**
     * Reset or seed default services tailored to clinic
     */
    public function seedDefaults()
    {
        $clinic = Auth::user()->getActiveClinic();
        if (!$clinic) {
            return redirect()->route('doctor.onboarding');
        }

        $this->seedDefaultServicesForClinic($clinic);
        ActivityLog::log('clinic_services_seeded', "Reset standard clinic services", $clinic->id);

        return redirect()->route('doctor.services.index')->with('success', "Standard clinic services loaded successfully!");
    }

    /**
     * Helper to seed standard services adapted to clinic specialization
     */
    public function seedDefaultServicesForClinic($clinic)
    {
        $spec = strtolower($clinic->specialization ?? '');

        // Determine smart default services based on clinic's specialization
        if (str_contains($spec, 'dent') || str_contains($spec, 'oral')) {
            $defaultServices = [
                ['title' => 'Dental Examination & Cleaning', 'icon' => 'fa-tooth', 'desc' => 'Comprehensive checkups, cavity detection, and deep ultrasonic teeth cleaning.'],
                ['title' => 'Root Canal & Restoration', 'icon' => 'fa-shield-halved', 'desc' => 'Pain-free modern endodontic therapy and tooth preservation techniques.'],
                ['title' => 'Teeth Whitening & Aesthetics', 'icon' => 'fa-wand-magic-sparkles', 'desc' => 'Cosmetic smile transformations, veneers, and advanced whitening.'],
                ['title' => 'Orthodontics & Aligners', 'icon' => 'fa-teeth-open', 'desc' => 'Clear aligners and corrective braces for healthy bite and alignment.'],
            ];
        } elseif (str_contains($spec, 'eye') || str_contains($spec, 'ophth')) {
            $defaultServices = [
                ['title' => 'Comprehensive Eye Examination', 'icon' => 'fa-eye', 'desc' => 'Visual acuity screening, digital retinal scans, and eye health exams.'],
                ['title' => 'Cataract & Refractive Care', 'icon' => 'fa-glasses', 'desc' => 'Modern lens evaluation, cataract guidance, and laser consultation.'],
                ['title' => 'Glaucoma & Pressure Screening', 'icon' => 'fa-microscope', 'desc' => 'Intraocular pressure checks and optic nerve diagnostics.'],
                ['title' => 'Pediatric & Family Vision', 'icon' => 'fa-users', 'desc' => 'Specialized vision testing for children and elderly patients.'],
            ];
        } elseif (str_contains($spec, 'derma') || str_contains($spec, 'skin')) {
            $defaultServices = [
                ['title' => 'Dermatology & Skin Consultation', 'icon' => 'fa-hand-dots', 'desc' => 'Diagnosis and treatment for acne, eczema, allergies, and skin conditions.'],
                ['title' => 'Clinical Laser & Aesthetics', 'icon' => 'fa-sparkles', 'desc' => 'Advanced non-invasive cosmetic skin rejuvenation and scar care.'],
                ['title' => 'Hair & Scalp Therapy', 'icon' => 'fa-feather', 'desc' => 'Targeted treatments for alopecia, thinning, and scalp health.'],
                ['title' => 'Minor Dermato-Surgery', 'icon' => 'fa-scissors', 'desc' => 'Safe mole removals, skin biopsy, and localized treatments.'],
            ];
        } elseif (str_contains($spec, 'cardio') || str_contains($spec, 'heart')) {
            $defaultServices = [
                ['title' => 'Cardiovascular Consultation', 'icon' => 'fa-heart-pulse', 'desc' => 'Complete heart assessments, hypertension monitoring, and care.'],
                ['title' => 'ECG & Holter Diagnostic', 'icon' => 'fa-chart-line', 'desc' => 'Precise 12-lead ECG, stress tests, and cardiac rhythm monitoring.'],
                ['title' => 'Echocardiogram & Doppler', 'icon' => 'fa-wave-square', 'desc' => 'High-resolution cardiac ultrasound and blood flow assessment.'],
                ['title' => 'Preventive Cardiac Care', 'icon' => 'fa-shield-heart', 'desc' => 'Cholesterol management, lifestyle coaching, and risk reduction.'],
            ];
        } else {
            // Universal medical / multi-specialty services that fit ANY healthcare clinic
            $defaultServices = [
                ['title' => 'Doctor Consultation & Diagnosis', 'icon' => 'fa-user-doctor', 'desc' => 'In-depth consultation, clinical history review, and personalized care plan.'],
                ['title' => 'Diagnostic & Lab Assessments', 'icon' => 'fa-stethoscope', 'desc' => 'Accurate vital checks, screenings, and diagnostic evaluation.'],
                ['title' => 'Preventive Wellness & Checkups', 'icon' => 'fa-heart-pulse', 'desc' => 'Routine health screenings, health risk audits, and lifestyle advice.'],
                ['title' => 'Ongoing Treatment & Care', 'icon' => 'fa-hand-holding-medical', 'desc' => 'Dedicated prescription management, recovery monitoring, and follow-ups.'],
            ];
        }

        // Delete existing and insert fresh defaults
        ClinicService::where('clinic_id', $clinic->id)->delete();

        foreach ($defaultServices as $idx => $s) {
            ClinicService::create([
                'clinic_id' => $clinic->id,
                'title' => $s['title'],
                'description' => $s['desc'],
                'icon' => $s['icon'],
                'price' => null,
                'sort_order' => $idx + 1,
                'status' => true,
            ]);
        }
    }
}
