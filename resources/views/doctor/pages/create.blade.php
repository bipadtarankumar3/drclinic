@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  @php
    $clinicSlug = $clinic->subdomain ?? $clinic->slug;
  @endphp

  <div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
      <div>
        <h2 class="font-weight-bold mb-1"><i class="mdi mdi-file-plus-outline text-primary mr-1"></i> Create Custom Page</h2>
        <p class="text-muted mb-0">Publish custom content for <strong>{{ $clinic->name }}</strong> such as Doctor Bio, Facilities, Treatments, or Guidelines.</p>
      </div>
      <a href="{{ route('doctor.pages.index') }}" class="btn btn-outline-secondary btn-sm font-weight-bold">
        &larr; Back to Custom Pages
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
              <div class="col-md-7 mb-3">
                <label class="form-label font-weight-bold">Page Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="page-title" name="title" value="{{ old('title') }}" placeholder="e.g. About Our Medical Specialists & Treatments" required>
              </div>

              <div class="col-md-5 mb-3">
                <label class="form-label font-weight-bold">URL Slug</label>
                <input type="text" class="form-control" id="page-slug" name="slug" value="{{ old('slug') }}" placeholder="e.g. about-specialists">
                <small class="text-muted d-block mt-1">
                  Live URL: <code id="slug-preview" style="color: #0d9488;">{{ url('/c/' . $clinicSlug . '/page') }}/<span id="preview-text">...</span></code>
                </small>
              </div>

              <!-- Page Content with Quick Formatting Toolbar -->
              <div class="col-12 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
                  <label class="form-label font-weight-bold mb-0">Page Content <span class="text-danger">*</span></label>
                  <div class="btn-group btn-group-sm" role="group">
                    <button type="button" class="btn btn-outline-secondary" onclick="insertFormat('h2')"><i class="mdi mdi-format-header-2"></i> Heading</button>
                    <button type="button" class="btn btn-outline-secondary" onclick="insertFormat('bold')"><i class="mdi mdi-format-bold"></i> Bold</button>
                    <button type="button" class="btn btn-outline-secondary" onclick="insertFormat('bullet')"><i class="mdi mdi-format-list-bulleted"></i> Bullet</button>
                    <button type="button" class="btn btn-outline-secondary" onclick="insertFormat('quote')"><i class="mdi mdi-format-quote-close"></i> Note</button>
                    <button type="button" class="btn btn-outline-secondary" onclick="insertFormat('table')"><i class="mdi mdi-table"></i> Timings Table</button>
                  </div>
                </div>
                <textarea class="form-control font-monospace" id="page-content" name="content" rows="14" placeholder="Write your page details, clinic timings, treatments, qualifications, or guidelines..." required style="font-size: 14.5px; line-height: 1.6;">{{ old('content') }}</textarea>
                <small class="text-muted mt-1 d-block">Supports plain text, bullet points (•), numbered lists, and HTML formatting.</small>
              </div>

              <div class="col-md-8 mb-4">
                <label class="form-label font-weight-bold">Meta Description (SEO)</label>
                <input type="text" class="form-control" name="meta_description" value="{{ old('meta_description') }}" placeholder="Brief summary of this page for Google search results and link previews">
              </div>

              <div class="col-md-4 mb-4">
                <label class="form-label font-weight-bold">Display Order</label>
                <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', 1) }}" min="0">
                <small class="text-muted">Lower numbers appear first in the website navigation.</small>
              </div>

              <div class="col-12 mb-4">
                <div class="form-check form-switch p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                  <input class="form-check-input ms-0 me-3" type="checkbox" id="is_published" name="is_published" value="1" checked style="width: 44px; height: 22px;">
                  <label class="form-check-label font-weight-bold" for="is_published" style="cursor: pointer;">
                    Publish page immediately on clinic website
                    <span class="d-block text-muted small fw-normal">When enabled, this page will appear in your website menu and footer.</span>
                  </label>
                </div>
              </div>

              <div class="col-12">
                <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold">
                  <i class="mdi mdi-check mr-1"></i> Save and Publish Page
                </button>
                <a href="{{ route('doctor.pages.index') }}" class="btn btn-outline-secondary ms-2 px-4 py-2 font-weight-bold">Cancel</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let titleInput = document.getElementById("page-title");
    let slugInput = document.getElementById("page-slug");
    let previewText = document.getElementById("preview-text");

    function updateSlug() {
        let slug = slugInput.value.trim();
        if (!slug && titleInput.value.trim()) {
            slug = titleInput.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
        }
        previewText.textContent = slug || '...';
    }

    titleInput.addEventListener("input", function() {
        if (!slugInput.value) {
            updateSlug();
        }
    });
    slugInput.addEventListener("input", updateSlug);
    updateSlug();
});

function insertFormat(type) {
    let textarea = document.getElementById("page-content");
    let start = textarea.selectionStart;
    let end = textarea.selectionEnd;
    let selectedText = textarea.value.substring(start, end);
    let replacement = "";

    switch(type) {
        case 'h2':
            replacement = "\n\n## " + (selectedText || "Section Heading") + "\n";
            break;
        case 'bold':
            replacement = "**" + (selectedText || "Important Note") + "**";
            break;
        case 'bullet':
            replacement = "\n• " + (selectedText || "Service point / feature detail");
            break;
        case 'quote':
            replacement = "\n> " + (selectedText || "Special advisory or patient preparation note.") + "\n";
            break;
        case 'table':
            replacement = "\nConsultation Hours:\n• Monday – Friday: 09:00 AM – 06:00 PM\n• Saturday: 10:00 AM – 02:00 PM\n• Sunday: Closed / Emergency On-Call\n";
            break;
    }

    textarea.value = textarea.value.substring(0, start) + replacement + textarea.value.substring(end);
    textarea.focus();
}
</script>
@endsection
