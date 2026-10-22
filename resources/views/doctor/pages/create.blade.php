@extends('admin.layouts.main')

@section('style')
<!-- Summernote Lite CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
<style>
  .note-editor.note-frame {
    border: 1.5px solid #cbd5e1 !important;
    border-radius: 12px !important;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    transition: border-color 0.2s;
  }
  .note-editor.note-frame.focus {
    border-color: var(--theme-primary, #059669) !important;
    box-shadow: 0 0 0 3px var(--theme-primary-focus, rgba(5, 150, 105, 0.15)) !important;
  }
  .note-toolbar {
    background: #f8fafc !important;
    border-bottom: 1px solid #e2e8f0 !important;
    padding: 8px 10px !important;
  }
  .note-btn {
    border: 1px solid #e2e8f0 !important;
    background: #ffffff !important;
    border-radius: 6px !important;
    color: #334155 !important;
    font-size: 13px !important;
    padding: 5px 10px !important;
  }
  .note-btn:hover {
    background: #f1f5f9 !important;
    color: #0f172a !important;
    border-color: #cbd5e1 !important;
  }
  .note-btn.active {
    background: var(--theme-primary-subtle, #ecfdf5) !important;
    color: var(--theme-primary, #059669) !important;
    border-color: var(--theme-primary-border, #a7f3d0) !important;
  }
  .note-editable {
    min-height: 380px !important;
    font-size: 15px !important;
    line-height: 1.8 !important;
    color: #1e293b !important;
    background: #ffffff !important;
    padding: 20px 24px !important;
  }
  .template-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    background: #f0fdfa;
    border: 1px solid #99f6e4;
    color: #0f766e;
    font-size: 12.5px;
    font-weight: 600;
    border-radius: 20px;
    cursor: pointer;
    transition: all 0.2s ease;
  }
  .template-chip:hover {
    background: #ccfbf1;
    color: #0d9488;
    transform: translateY(-1px);
  }
</style>
@endsection

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
          <form action="{{ route('doctor.pages.store') }}" method="POST" id="custom-page-form">
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

              <!-- Page Content with Summernote Rich Text Editor -->
              <div class="col-12 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
                  <label class="form-label font-weight-bold mb-0">Page Content <span class="text-danger">*</span></label>
                  <div class="d-flex align-items-center flex-wrap gap-1">
                    <span class="text-muted small me-1">Insert Block:</span>
                    <button type="button" class="template-chip" onclick="insertTemplate('timings')">
                      <i class="mdi mdi-clock-outline"></i> Consultation Hours
                    </button>
                    <button type="button" class="template-chip" onclick="insertTemplate('doctor')">
                      <i class="mdi mdi-account-star"></i> Doctor Bio
                    </button>
                    <button type="button" class="template-chip" onclick="insertTemplate('highlights')">
                      <i class="mdi mdi-check-decagram"></i> Key Highlights
                    </button>
                    <button type="button" class="template-chip" onclick="insertTemplate('faq')">
                      <i class="mdi mdi-help-circle-outline"></i> FAQ Item
                    </button>
                  </div>
                </div>

                <textarea class="form-control" id="page-content" name="content" placeholder="Write your page details, clinic timings, treatments, qualifications, or guidelines..." required>{{ old('content') }}</textarea>
                <small class="text-muted mt-2 d-block">
                  <i class="mdi mdi-information-outline text-primary"></i> 
                  Use the visual editor toolbar above to format headings, bold/italic text, bullet lists, color highlights, tables, and embed images or links.
                </small>
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
                <div class="form-actions-end mt-3">
                  <a href="{{ route('doctor.pages.index') }}" class="btn btn-light border px-4 py-2 font-weight-bold" style="border-radius: 8px;">Cancel</a>
                  <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold" style="border-radius: 8px;">
                    <i class="mdi mdi-check mr-1"></i> Save and Publish Page
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<!-- Summernote Lite JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize Summernote WYSIWYG Text Editor
    $('#page-content').summernote({
        placeholder: 'Write your page details, clinic timings, treatments, qualifications, or guidelines...',
        tabsize: 2,
        height: 380,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video', 'hr']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ],
        styleTags: ['p', 'h2', 'h3', 'h4', 'h5', 'h6', 'blockquote', 'pre']
    });

    // Ensure editor content syncs on form submit
    $('#custom-page-form').on('submit', function() {
        let code = $('#page-content').summernote('code');
        $('#page-content').val(code);
    });

    // Slug generation
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

function insertTemplate(type) {
    let html = "";
    switch(type) {
        case 'timings':
            html = `<div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; margin: 16px 0;">
  <h4 style="color: #0d9488; font-weight: 700; margin-bottom: 12px;">Consultation Hours</h4>
  <table style="width: 100%; border-collapse: collapse;">
    <tr style="border-bottom: 1px solid #e2e8f0;">
      <td style="padding: 8px 12px; font-weight: 600;">Monday – Friday</td>
      <td style="padding: 8px 12px; color: #0f172a;">09:00 AM – 01:00 PM & 05:00 PM – 08:30 PM</td>
    </tr>
    <tr style="border-bottom: 1px solid #e2e8f0;">
      <td style="padding: 8px 12px; font-weight: 600;">Saturday</td>
      <td style="padding: 8px 12px; color: #0f172a;">10:00 AM – 03:00 PM</td>
    </tr>
    <tr>
      <td style="padding: 8px 12px; font-weight: 600;">Sunday</td>
      <td style="padding: 8px 12px; color: #dc2626;">Emergency On-Call Only</td>
    </tr>
  </table>
</div><p></p>`;
            break;

        case 'doctor':
            html = `<div style="border-left: 4px solid #0d9488; background: #f0fdfa; padding: 18px 24px; border-radius: 0 12px 12px 0; margin: 18px 0;">
  <h3 style="color: #0f172a; margin-top: 0; margin-bottom: 6px;">Doctor Profile & Credentials</h3>
  <p style="color: #0f766e; font-weight: 600; margin-bottom: 10px;">MBBS, MD, Fellowship in Clinical Healthcare</p>
  <p style="color: #334155; line-height: 1.7; margin-bottom: 0;">With over 12+ years of clinical excellence, specializing in comprehensive patient diagnostics, preventive wellness, and advanced treatments.</p>
</div><p></p>`;
            break;

        case 'highlights':
            html = `<div style="margin: 18px 0;">
  <h4 style="color: #0f172a; font-weight: 700; margin-bottom: 12px;">Key Services & Facilities</h4>
  <ul>
    <li><strong>Advanced Diagnostic Care:</strong> Digital ECG, rapid blood sugar testing, and digital vital monitoring.</li>
    <li><strong>Dedicated Patient Care:</strong> Personalized treatment plans and 1-on-1 confidential consultations.</li>
    <li><strong>Clean & Modern Clinic:</strong> Strict sanitization protocols and digital paperless prescriptions.</li>
  </ul>
</div><p></p>`;
            break;

        case 'faq':
            html = `<div style="border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px 20px; margin: 12px 0; background: #ffffff;">
  <h5 style="color: #0d9488; font-weight: 700; margin-bottom: 6px;">Q: Do I need to book an appointment in advance?</h5>
  <p style="color: #475569; margin-bottom: 0; line-height: 1.6;">Yes, booking your slot online through our website ensures zero wait time and guaranteed doctor availability.</p>
</div><p></p>`;
            break;
    }

    if (html) {
        $('#page-content').summernote('pasteHTML', html);
    }
}
</script>
@endsection
