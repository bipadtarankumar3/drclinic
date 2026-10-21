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

        return view('doctor.pages.index', compact('clinic', 'pages'));
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
