@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  <div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
      <div>
        <h2 class="font-weight-bold mb-1">Create Custom Page</h2>
        <p class="text-muted mb-0">Publish custom content such as Doctor Qualifications, Clinic Facilities, or Guidelines.</p>
      </div>
      <a href="{{ route('doctor.pages.index') }}" class="btn btn-outline-secondary btn-sm font-weight-bold">
        &larr; Back to Pages
      </a>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card border-0 shadow-sm rounded-4" style="border-radius: 16px;">
        <div class="card-body p-4 p-md-5">
          <form action="{{ route('doctor.pages.store') }}" method="POST">
            @csrf

            <div class="row g-3">
              <div class="col-md-8 mb-3">
                <label class="form-label font-weight-bold">Page Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="e.g. About Dr. Smith & Specialties" required>
              </div>

              <div class="col-md-4 mb-3">
                <label class="form-label font-weight-bold">URL Slug (Optional)</label>
                <input type="text" class="form-control" name="slug" value="{{ old('slug') }}" placeholder="e.g. about-doctor">
                <small class="text-muted">Will be auto-generated from title if left blank.</small>
              </div>

              <div class="col-12 mb-4">
                <label class="form-label font-weight-bold">Page Content (HTML / Text) <span class="text-danger">*</span></label>
                <textarea class="form-control" name="content" rows="12" placeholder="Write page description, doctor bio, clinic timings, services, facilities, or FAQ..." required>{{ old('content') }}</textarea>
              </div>

              <div class="col-md-8 mb-4">
                <label class="form-label font-weight-bold">Meta Description (SEO)</label>
                <input type="text" class="form-control" name="meta_description" value="{{ old('meta_description') }}" placeholder="Brief summary for search engines and social sharing">
              </div>

              <div class="col-md-4 mb-4">
                <label class="form-label font-weight-bold">Display Order</label>
                <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', 0) }}">
              </div>

              <div class="col-12 mb-4">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="is_published" name="is_published" value="1" checked>
                  <label class="form-check-label font-weight-bold" for="is_published">Publish page immediately on clinic website</label>
                </div>
              </div>

              <div class="col-12">
                <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold">
                  <i class="mdi mdi-check mr-1"></i> Save and Publish Page
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
