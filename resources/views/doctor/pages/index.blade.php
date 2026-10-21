@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  @php
    $clinicSlug = $clinic->subdomain ?? $clinic->slug;
    $storefrontUrl = $clinicSlug ? url('/c/' . $clinicSlug) : url('/');
  @endphp

  <div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-2">
      <div>
        <h2 class="font-weight-bold mb-1"><i class="mdi mdi-file-document-edit-outline text-primary mr-1"></i> Clinic Custom Pages</h2>
        <p class="text-muted mb-0">Create, customize, and publish dedicated web pages for <strong>{{ $clinic->name }}</strong> (e.g. About Doctor, Services, Facilities, FAQ).</p>
      </div>
      <div class="d-flex align-items-center gap-2 mt-2 mt-sm-0">
        <form action="{{ route('doctor.pages.seed_defaults') }}" method="POST" class="d-inline" onsubmit="return confirm('Generate or restore standard clinic pages (About Us, Services, Doctors, Facilities, FAQ)? Existing custom pages will be preserved.');">
          @csrf
          <button type="submit" class="btn btn-outline-secondary btn-sm font-weight-bold" title="Generate standard clinic pages">
            <i class="mdi mdi-auto-fix mr-1"></i> Generate Standard Pages
          </button>
        </form>
        <a href="{{ route('doctor.pages.create') }}" class="btn btn-primary font-weight-bold">
          <i class="mdi mdi-plus-circle mr-1"></i> Add New Page
        </a>
      </div>
    </div>
  </div>

  @if(session('success'))
  <div class="alert alert-success alert-dismissible fade show rounded-3 p-3 mb-4" role="alert">
    <strong><i class="mdi mdi-check-circle mr-1"></i></strong> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  <!-- Notice Info Card -->
  <div class="alert alert-info border-0 rounded-4 p-3 mb-4 d-flex align-items-center justify-content-between flex-wrap gap-2" style="background: rgba(13, 148, 136, 0.08); border-left: 4px solid #0d9488 !important;">
    <div class="d-flex align-items-center gap-2">
      <i class="mdi mdi-information-outline" style="font-size: 24px; color: #0d9488;"></i>
      <span style="color: #0f172a; font-size: 13.5px;">
        Published pages automatically appear in your clinic website's navigation bar and footer. Patients can browse them and book consultations directly.
      </span>
    </div>
    <a href="{{ $storefrontUrl }}" target="_blank" class="btn btn-sm text-white font-weight-bold px-3 py-1 rounded-pill" style="background: #0d9488; text-decoration: none;">
      <i class="mdi mdi-open-in-new mr-1"></i> View Live Website
    </a>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card border-0 shadow-sm rounded-4" style="border-radius: 16px;">
        <div class="card-body p-4">
          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead class="bg-light">
                <tr>
                  <th style="width: 50px;">Order</th>
                  <th>Page Title</th>
                  <th>Clinic URL Path</th>
                  <th>Status</th>
                  <th>Last Updated</th>
                  <th class="text-end">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse($pages as $page)
                @php
                  $pageUrl = $clinicSlug ? url('/c/' . $clinicSlug . '/page/' . $page->slug) : url('/page/' . $page->slug);
                @endphp
                <tr>
                  <td>
                    <span class="badge bg-light text-dark font-weight-bold">{{ $page->sort_order }}</span>
                  </td>
                  <td>
                    <div class="font-weight-bold text-dark" style="font-size: 14.5px;">{{ $page->title }}</div>
                    @if($page->meta_description)
                      <small class="text-muted d-block" style="max-width: 380px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $page->meta_description }}</small>
                    @endif
                  </td>
                  <td>
                    <a href="{{ $pageUrl }}" target="_blank" class="text-primary font-weight-bold text-decoration-none" title="Open live page in new tab">
                      <code style="font-size: 13px; color: #0d9488; background: rgba(13, 148, 136, 0.08); padding: 4px 8px; border-radius: 6px;">
                        /c/{{ $clinicSlug }}/page/{{ $page->slug }}
                      </code>
                      <i class="mdi mdi-open-in-new ms-1 small"></i>
                    </a>
                  </td>
                  <td>
                    @if($page->is_published)
                      <span class="badge bg-success text-white px-2 py-1"><i class="mdi mdi-check-circle-outline mr-1"></i> Published</span>
                    @else
                      <span class="badge bg-secondary text-white px-2 py-1"><i class="mdi mdi-eye-off-outline mr-1"></i> Draft</span>
                    @endif
                  </td>
                  <td class="text-muted small">{{ $page->updated_at->format('d M, Y') }}</td>
                  <td class="text-end">
                    <a href="{{ $pageUrl }}" target="_blank" class="btn btn-sm btn-outline-info me-1" title="View Live Page">
                      <i class="mdi mdi-eye"></i>
                    </a>
                    <a href="{{ route('doctor.pages.edit', $page->id) }}" class="btn btn-sm btn-outline-primary me-1" title="Edit Page Content">
                      <i class="mdi mdi-pencil"></i>
                    </a>
                    <form action="{{ route('doctor.pages.destroy', $page->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Permanently delete this page from your clinic website?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                        <i class="mdi mdi-trash-can"></i>
                      </button>
                    </form>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="6" class="text-center py-5 text-muted">
                    <i class="mdi mdi-file-outline" style="font-size: 42px; color: #94a3b8;"></i>
                    <p class="mt-2 mb-3">No custom pages found for this clinic.</p>
                    <div class="d-flex justify-content-center gap-2">
                      <form action="{{ route('doctor.pages.seed_defaults') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm font-weight-bold">
                          <i class="mdi mdi-auto-fix mr-1"></i> Generate Standard Pages (About, Services, FAQ)
                        </button>
                      </form>
                      <a href="{{ route('doctor.pages.create') }}" class="btn btn-outline-secondary btn-sm font-weight-bold">
                        <i class="mdi mdi-plus"></i> Blank Page
                      </a>
                    </div>
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
