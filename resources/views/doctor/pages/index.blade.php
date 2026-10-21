@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  <div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center flex-wrap">
      <div>
        <h2 class="font-weight-bold mb-1"><i class="mdi mdi-file-document-edit-outline text-primary mr-1"></i> Clinic Custom Pages</h2>
        <p class="text-muted mb-0">Create and publish custom pages for your website (e.g. About Doctor, Treatments, Facilities, FAQ).</p>
      </div>
      <a href="{{ route('doctor.pages.create') }}" class="btn btn-primary font-weight-bold mt-2 mt-sm-0">
        <i class="mdi mdi-plus-circle mr-1"></i> Add New Page
      </a>
    </div>
  </div>

  @if(session('success'))
  <div class="alert alert-success alert-dismissible fade show rounded-3 p-3 mb-4" role="alert">
    <strong><i class="mdi mdi-check-circle mr-1"></i></strong> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  <div class="row">
    <div class="col-12">
      <div class="card border-0 shadow-sm rounded-4" style="border-radius: 16px;">
        <div class="card-body p-4">
          <div class="table-responsive">
            <table class="table table-hover">
              <thead class="bg-light">
                <tr>
                  <th>Page Title</th>
                  <th>Page Slug / URL</th>
                  <th>Status</th>
                  <th>Order</th>
                  <th>Last Updated</th>
                  <th class="text-end">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse($pages as $page)
                <tr>
                  <td class="font-weight-bold text-dark">{{ $page->title }}</td>
                  <td>
                    <code class="text-primary font-weight-bold">/page/{{ $page->slug }}</code>
                  </td>
                  <td>
                    @if($page->is_published)
                      <span class="badge bg-success text-white">Published</span>
                    @else
                      <span class="badge bg-secondary text-white">Draft</span>
                    @endif
                  </td>
                  <td>{{ $page->sort_order }}</td>
                  <td>{{ $page->updated_at->format('d M, Y') }}</td>
                  <td class="text-end">
                    <a href="{{ url('/page/' . $page->slug) }}" target="_blank" class="btn btn-sm btn-outline-info me-1" title="View Page">
                      <i class="mdi mdi-eye"></i>
                    </a>
                    <a href="{{ route('doctor.pages.edit', $page->id) }}" class="btn btn-sm btn-outline-primary me-1" title="Edit">
                      <i class="mdi mdi-pencil"></i>
                    </a>
                    <form action="{{ route('doctor.pages.destroy', $page->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this page permanently?');">
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
                    <i class="mdi mdi-file-outline" style="font-size: 38px;"></i>
                    <p class="mt-2 mb-3">No custom pages added yet for this clinic.</p>
                    <a href="{{ route('doctor.pages.create') }}" class="btn btn-primary btn-sm font-weight-bold">
                      <i class="mdi mdi-plus"></i> Create Your First Page
                    </a>
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
