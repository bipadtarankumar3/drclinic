<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClinicPage;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DoctorPageController extends Controller
{
    public function index()
    {
        $clinic = Auth::user()->getActiveClinic();
        if (!$clinic) {
            return redirect()->route('doctor.onboarding');
        }

        $pages = ClinicPage::where('clinic_id', $clinic->id)->orderBy('sort_order', 'asc')->get();
        if ($pages->isEmpty()) {
            $this->seedDefaultPagesForClinic($clinic);
            $pages = ClinicPage::where('clinic_id', $clinic->id)->orderBy('sort_order', 'asc')->get();
        }

        return view('doctor.pages.index', compact('clinic', 'pages'));
    }

    public function seedDefaults()
    {
        $clinic = Auth::user()->getActiveClinic();
        if (!$clinic) {
            return redirect()->route('doctor.onboarding');
        }

        $this->seedDefaultPagesForClinic($clinic);
        ActivityLog::log('custom_pages_seeded', "Initialized standard clinic pages", $clinic->id);

        return redirect()->route('doctor.pages.index')->with('success', 'Standard clinic pages initialized successfully! You can now customize them.');
    }

    public function seedDefaultPagesForClinic($clinic)
    {
        $defaultPages = [
            [
                'title' => 'About Us & Medical Team',
                'slug' => 'about-us',
                'meta_description' => "Learn more about {$clinic->name}, our certified medical specialists, healthcare mission, and patient-first approach.",
                'sort_order' => 1,
                'is_published' => true,
                'content' => "Welcome to {$clinic->name}.\n\nWe are committed to delivering the highest standards of clinical excellence, compassionate patient care, and modern healthcare solutions.\n\nOur Medical Philosophy\nOur experienced team of certified doctors and clinical specialists specialize in {$clinic->specialization}. Every patient receives individualized attention, state-of-the-art diagnostic evaluations, and evidence-based treatment plans tailored to their unique health requirements.\n\nWhy Patients Trust Us\n• Qualified and empathetic medical practitioners\n• Advanced diagnostic technology and accurate reporting\n• Transparent pricing with zero hidden fees\n• Friendly nursing and support staff dedicated to patient comfort\n\nVisit us or book an appointment online to experience world-class healthcare."
            ],
            [
                'title' => 'Our Clinical Services',
                'slug' => 'our-services',
                'meta_description' => "Explore comprehensive medical treatments and diagnostic services offered at {$clinic->name}.",
                'sort_order' => 2,
                'is_published' => true,
                'content' => "Comprehensive Healthcare Services at {$clinic->name}\n\nWe provide an extensive range of medical consultations, preventative checkups, and specialized therapies:\n\n1. Specialist Doctor Consultations\nOne-on-one expert clinical consultations for routine health concerns, chronic disease management, and specialized second opinions.\n\n2. Advanced Diagnostics & Health Screenings\nComprehensive diagnostic testing including ECG, vital monitoring, lab sample collections, and preventative health screening packages.\n\n3. Preventive Health Packages\nTailored checkup packages for families, working professionals, and seniors to detect health issues early and maintain peak wellness.\n\n4. Follow-up & Continuous Care\nStructured post-consultation follow-up, digital prescriptions, and continuous monitoring to support your complete recovery."
            ],
            [
                'title' => 'Doctors & Specialists',
                'slug' => 'doctors',
                'meta_description' => "Meet our team of experienced doctors and medical specialists at {$clinic->name}.",
                'sort_order' => 3,
                'is_published' => true,
                'content' => "Our Team of Specialists\n\nAt {$clinic->name}, our medical professionals bring years of clinical experience, advanced qualifications, and a deep dedication to patient well-being.\n\nSpecialized Expertise:\n• Primary Care & Family Medicine\n• Specialized Diagnostic & Treatment Consultations\n• Chronic Condition Management & Lifestyle Counseling\n• Preventive Healthcare Guidance\n\nEach doctor at our clinic is committed to listening to your symptoms attentively, explaining diagnoses clearly, and collaborating with you on the best path to recovery."
            ],
            [
                'title' => 'Clinic Facilities & Amenities',
                'slug' => 'facilities',
                'meta_description' => "Modern medical facilities, sanitized consultation chambers, and comfortable amenities at {$clinic->name}.",
                'sort_order' => 4,
                'is_published' => true,
                'content' => "Modern Infrastructure Designed for Patient Safety & Comfort\n\nAt {$clinic->name}, patient health and safety are our foremost priorities. Our clinical premises are designed according to international medical hygiene standards.\n\nKey Facilities Include:\n• Sanitized & Ergonomic Consultation Rooms: Private and comfortable consultation chambers.\n• Digital Patient Records: Secure electronic medical recordkeeping for seamless continuity of care.\n• Wheelchair & Elderly Friendly: Easy ground-level access and dedicated assistance for seniors.\n• Pharmacy & First-Aid Support: Essential medication support and immediate clinical triage.\n• Comfortable Waiting Lounge: Air-conditioned waiting lounge with complimentary drinking water and Wi-Fi."
            ],
            [
                'title' => 'Patient Guidelines & FAQ',
                'slug' => 'faq',
                'meta_description' => "Frequently asked questions regarding appointment booking, consultation timings, payment, and clinic guidelines.",
                'sort_order' => 5,
                'is_published' => true,
                'content' => "Frequently Asked Questions (FAQ)\n\nQ1: How do I book an appointment?\nA: Simply select your preferred date on our interactive calendar, choose an available time slot, fill in your patient details, and complete payment to receive immediate confirmation.\n\nQ2: What should I bring for my consultation?\nA: Please bring any previous medical reports, prescriptions, test results, and a valid photo identification.\n\nQ3: Can I reschedule or cancel my appointment?\nA: Yes. Please contact our clinic reception at least 4 hours prior to your scheduled time slot to reschedule.\n\nQ4: Are digital payment modes accepted?\nA: Yes, we accept UPI (Google Pay, PhonePe, Paytm), Credit/Debit Cards, Net Banking, and Cash at the clinic counter."
            ]
        ];

        foreach ($defaultPages as $p) {
            ClinicPage::firstOrCreate(
                ['clinic_id' => $clinic->id, 'slug' => $p['slug']],
                [
                    'title' => $p['title'],
                    'meta_description' => $p['meta_description'],
                    'content' => $p['content'],
                    'sort_order' => $p['sort_order'],
                    'is_published' => $p['is_published']
                ]
            );
        }
    }

    public function create()
    {
        $clinic = Auth::user()->getActiveClinic();
        return view('doctor.pages.create', compact('clinic'));
    }

    public function store(Request $request)
    {
        $clinic = Auth::user()->getActiveClinic();

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:100',
            'content' => 'required|string',
            'meta_description' => 'nullable|string|max:300',
            'sort_order' => 'nullable|integer',
        ]);

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);

        // Ensure unique slug per clinic
        $count = ClinicPage::where('clinic_id', $clinic->id)->where('slug', $slug)->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        $page = ClinicPage::create([
            'clinic_id' => $clinic->id,
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'meta_description' => $request->meta_description,
            'is_published' => $request->has('is_published'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        ActivityLog::log('custom_page_created', "Created page: {$page->title}", $clinic->id);

        return redirect()->route('doctor.pages.index')->with('success', 'Page published successfully.');
    }

    public function edit($id)
    {
        $clinic = Auth::user()->getActiveClinic();
        $page = ClinicPage::where('clinic_id', $clinic->id)->findOrFail($id);

        return view('doctor.pages.edit', compact('clinic', 'page'));
    }

    public function update(Request $request, $id)
    {
        $clinic = Auth::user()->getActiveClinic();
        $page = ClinicPage::where('clinic_id', $clinic->id)->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:100',
            'content' => 'required|string',
            'meta_description' => 'nullable|string|max:300',
            'sort_order' => 'nullable|integer',
        ]);

        $slug = Str::slug($request->slug);

        $page->update([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'meta_description' => $request->meta_description,
            'is_published' => $request->has('is_published'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        ActivityLog::log('custom_page_updated', "Updated page: {$page->title}", $clinic->id);

        return redirect()->route('doctor.pages.index')->with('success', 'Page updated successfully.');
    }

    public function destroy($id)
    {
        $clinic = Auth::user()->getActiveClinic();
        $page = ClinicPage::where('clinic_id', $clinic->id)->findOrFail($id);
        $title = $page->title;
        $page->delete();

        ActivityLog::log('custom_page_deleted', "Deleted page: {$title}", $clinic->id);

        return redirect()->route('doctor.pages.index')->with('success', 'Page removed successfully.');
    }
}
