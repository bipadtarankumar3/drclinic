@extends('admin.layouts.main')

@section('style')
<style>
.service-mgmt-card {
  border: 1.5px solid #e2e8f0;
  border-radius: 14px;
  background: #ffffff;
  transition: all 0.2s ease;
}
.service-mgmt-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 24px rgba(0,0,0,0.06);
  border-color: #cbd5e1;
}
.service-icon-preview {
  width: 48px;
  height: 48px;
  border-radius: 12px;
  background: rgba(13, 148, 136, 0.1);
  color: #0d9488;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 22px;
  flex-shrink: 0;
}
.icon-option-btn {
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  padding: 8px 12px;
  background: #fff;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 13px;
  transition: all 0.15s ease;
}
.icon-option-btn:hover, .icon-option-btn.selected {
  background: #f0fdfa;
  border-color: #0d9488;
  color: #0d9488;
}
</style>
@endsection

@section('content')
<div class="content-wrapper">
  <!-- Top Header Banner -->
  <div class="d-flex align-items-center justify-content-between flex-wrap mb-4" style="gap: 16px;">
    <div>
      <h2 class="font-weight-bold mb-1" style="color: #0f172a;">
        <i class="mdi mdi-medical-bag text-primary mr-1"></i> Clinic Services
      </h2>
      <p class="text-muted mb-0 font-14">
        Manage the medical services and treatments displayed on your clinic's public website.
      </p>
    </div>

    <div class="d-flex align-items-center gap-2">
      <form action="{{ route('doctor.services.seed_defaults') }}" method="POST" class="d-inline" onsubmit="return confirm('Restore standard services adapted to your specialization ({{ $clinic->specialization ?? 'General Healthcare' }})? Existing services will be reset.');">
        @csrf
        <button type="submit" class="btn btn-outline-secondary btn-sm font-weight-bold px-3 py-2" style="border-radius: 8px;">
          <i class="mdi mdi-refresh mr-1"></i> Auto-Generate for My Specialty
        </button>
      </form>

      <button type="button" class="btn btn-primary btn-sm font-weight-bold px-3 py-2" data-bs-toggle="modal" data-bs-target="#addServiceModal" style="border-radius: 8px;">
        <i class="mdi mdi-plus mr-1"></i> Add New Service
      </button>

      <a href="{{ $clinic->custom_domain ? 'https://'.$clinic->custom_domain : url('/c/'.($clinic->subdomain ?? $clinic->slug)) }}#services-section" target="_blank" class="btn btn-outline-primary btn-sm font-weight-bold px-3 py-2" style="border-radius: 8px;">
        <i class="mdi mdi-open-in-new mr-1"></i> View on Website
      </a>
    </div>
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
      <i class="mdi mdi-check-circle mr-1"></i> {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <!-- Services Grid -->
  <div class="row g-3">
    @forelse($services as $service)
      <div class="col-lg-6 col-12 mb-3">
        <div class="service-mgmt-card p-3 h-100 d-flex flex-column justify-content-between">
          <div>
            <div class="d-flex align-items-start justify-content-between mb-2" style="gap: 12px;">
              <div class="d-flex align-items-center" style="gap: 12px;">
                <div class="service-icon-preview">
                  <i class="{{ $service->icon_class }}"></i>
                </div>
                <div>
                  <h5 class="font-weight-bold mb-1" style="color: #0f172a; font-size: 17px;">
                    {{ $service->title }}
                  </h5>
                  <div class="d-flex align-items-center gap-2">
                    @if($service->status)
                      <span class="badge bg-success" style="font-size: 11px; font-weight: 600;">Active on Website</span>
                    @else
                      <span class="badge bg-secondary" style="font-size: 11px; font-weight: 600;">Hidden</span>
                    @endif

                    @if($service->price > 0)
                      <span class="badge bg-light text-dark border" style="font-size: 11px; font-weight: 600;">
                        ₹{{ number_format($service->price, 2) }}
                      </span>
                    @endif

                    <span class="text-muted font-11">Order: #{{ $service->sort_order }}</span>
                  </div>
                </div>
              </div>

              <!-- Action Buttons -->
              <div class="d-flex align-items-center gap-1">
                <button type="button" class="btn btn-light btn-sm p-2 text-primary rounded-2" title="Edit Service" data-bs-toggle="modal" data-bs-target="#editModal{{ $service->id }}">
                  <i class="mdi mdi-pencil font-16"></i>
                </button>
                <form action="{{ route('doctor.services.destroy', $service->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this service permanently?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-light btn-sm p-2 text-danger rounded-2" title="Delete Service">
                    <i class="mdi mdi-delete-outline font-16"></i>
                  </button>
                </form>
              </div>
            </div>

            <p class="text-muted font-13 mb-3" style="line-height: 1.6;">
              {{ $service->description ?: 'No detailed description provided.' }}
            </p>
          </div>

          <div class="d-flex align-items-center justify-content-between pt-2 border-top">
            <small class="text-muted">Icon: <code>{{ $service->icon }}</code></small>
            <button type="button" class="btn btn-link btn-sm text-decoration-none p-0" data-bs-toggle="modal" data-bs-target="#editModal{{ $service->id }}">
              Edit Details &rarr;
            </button>
          </div>
        </div>
      </div>

      <!-- Edit Modal for this Service -->
      <div class="modal fade" id="editModal{{ $service->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $service->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header bg-light">
              <h5 class="modal-title font-weight-bold" id="editModalLabel{{ $service->id }}">
                <i class="mdi mdi-pencil mr-1 text-primary"></i> Edit Service
              </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('doctor.services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="modal-body p-4">
                <div class="mb-3">
                  <label class="form-label font-weight-bold">Service Title <span class="text-danger">*</span></label>
                  <input type="text" name="title" class="form-control" value="{{ old('title', $service->title) }}" required>
                </div>

                <div class="mb-3">
                  <label class="form-label font-weight-bold">Short Description</label>
                  <textarea name="description" class="form-control" rows="3" placeholder="Brief summary shown on your homepage service card...">{{ old('description', $service->description) }}</textarea>
                </div>

                <div class="mb-3">
                  <label class="form-label font-weight-bold">Icon (FontAwesome)</label>
                  <div class="input-group mb-2">
                    <span class="input-group-text bg-light"><i class="{{ $service->icon_class }}"></i></span>
                    <input type="text" name="icon" class="form-control" value="{{ old('icon', $service->icon) }}" placeholder="e.g. fa-stethoscope or fa-heart-pulse">
                  </div>
                  <small class="text-muted font-11">
                    Quick suggestions: <code>fa-stethoscope</code>, <code>fa-user-doctor</code>, <code>fa-heart-pulse</code>, <code>fa-tooth</code>, <code>fa-eye</code>, <code>fa-brain</code>, <code>fa-bone</code>, <code>fa-syringe</code>, <code>fa-hospital-user</code>
                  </small>
                </div>

                <div class="row g-2 mb-3">
                  <div class="col-6">
                    <label class="form-label font-weight-bold">Starting Price (₹) <small class="text-muted font-weight-normal">(Optional)</small></label>
                    <input type="number" step="0.01" min="0" name="price" class="form-control" value="{{ old('price', $service->price) }}" placeholder="e.g. 500">
                  </div>
                  <div class="col-6">
                    <label class="form-label font-weight-bold">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $service->sort_order) }}">
                  </div>
                </div>

                <div class="form-check form-switch mb-2">
                  <input class="form-check-input" type="checkbox" name="status" value="1" id="status{{ $service->id }}" {{ $service->status ? 'checked' : '' }}>
                  <label class="form-check-label font-weight-bold" for="status{{ $service->id }}">Show on Public Website</label>
                </div>
              </div>
              <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary font-weight-bold" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary font-weight-bold">Save Changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    @empty
      <div class="col-12">
        <div class="card p-5 text-center border-0 shadow-sm rounded-4" style="background: #ffffff;">
          <div style="width: 64px; height: 64px; border-radius: 50%; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 28px;">
            <i class="mdi mdi-medical-bag"></i>
          </div>
          <h4 class="font-weight-bold mb-1">No Custom Services Added Yet</h4>
          <p class="text-muted font-14 mb-4">Add your clinic's specialized services or auto-generate defaults tailored to your medical specialty.</p>
          <div class="d-flex justify-content-center gap-2">
            <form action="{{ route('doctor.services.seed_defaults') }}" method="POST">
              @csrf
              <button type="submit" class="btn btn-primary font-weight-bold px-4 py-2" style="border-radius: 8px;">
                <i class="mdi mdi-auto-fix mr-1"></i> Auto-Generate Services for {{ $clinic->specialization ?? 'My Clinic' }}
              </button>
            </form>
          </div>
        </div>
      </div>
    @endforelse
  </div>
</div>

<!-- Modal: Add New Service -->
<div class="modal fade" id="addServiceModal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
      <div class="modal-header bg-light">
        <h5 class="modal-title font-weight-bold" id="addServiceModalLabel">
          <i class="mdi mdi-plus-circle text-primary mr-1"></i> Add New Clinic Service
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('doctor.services.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body p-4">
          <div class="mb-3">
            <label class="form-label font-weight-bold">Service Title <span class="text-danger">*</span></label>
            <input type="text" name="title" class="form-control" placeholder="e.g. Cardiology Consultation, Dental Implants, Hair Therapy" required>
          </div>

          <div class="mb-3">
            <label class="form-label font-weight-bold">Short Description</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Brief summary of what this treatment includes and how it helps patients..."></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label font-weight-bold">FontAwesome Icon</label>
            <input type="text" name="icon" class="form-control" value="fa-stethoscope" placeholder="e.g. fa-stethoscope, fa-tooth, fa-heart-pulse">
            <small class="text-muted font-11">
              Popular icons: <code>fa-stethoscope</code>, <code>fa-user-doctor</code>, <code>fa-heart-pulse</code>, <code>fa-tooth</code>, <code>fa-eye</code>, <code>fa-brain</code>, <code>fa-bone</code>, <code>fa-syringe</code>, <code>fa-shield-heart</code>
            </small>
          </div>

          <div class="row g-2 mb-3">
            <div class="col-6">
              <label class="form-label font-weight-bold">Starting Price (₹) <small class="text-muted font-weight-normal">(Optional)</small></label>
              <input type="number" step="0.01" min="0" name="price" class="form-control" placeholder="e.g. 500.00">
            </div>
            <div class="col-6">
              <label class="form-label font-weight-bold">Sort Order</label>
              <input type="number" name="sort_order" class="form-control" value="{{ count($services) + 1 }}">
            </div>
          </div>

          <div class="form-check form-switch mb-2">
            <input class="form-check-input" type="checkbox" name="status" value="1" id="newStatus" checked>
            <label class="form-check-label font-weight-bold" for="newStatus">Show on Public Website Immediately</label>
          </div>
        </div>
        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-secondary font-weight-bold" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary font-weight-bold">Create Service</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
