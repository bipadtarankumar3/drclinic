@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  <div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
      <div>
        <h2 class="font-weight-bold mb-1">Manage Clinic: {{ $clinic->name }}</h2>
        <p class="text-muted mb-0">Doctor: {{ $clinic->user->name ?? 'Admin' }} ({{ $clinic->user->email ?? $clinic->email }})</p>
      </div>
      <div>
        <a href="{{ route('admin.saas.visit_doctor_plan', $clinic->id) }}" class="btn btn-outline-warning btn-sm font-weight-bold me-2">
          <i class="mdi mdi-crown text-warning mr-1"></i> Visit Doctor Plan
        </a>
        <a href="{{ route('admin.saas.impersonate', $clinic->id) }}" class="btn btn-outline-primary btn-sm font-weight-bold me-2">
          <i class="mdi mdi-login-variant mr-1"></i> Log in as Doctor
        </a>
        <a href="{{ route('admin.saas.clinics') }}" class="btn btn-outline-secondary btn-sm font-weight-bold">
          &larr; Back to Clinics
        </a>
      </div>
    </div>
  </div>

  @if($errors->any())
  <div class="alert alert-danger rounded-3 p-3 mb-4">
    <ul class="mb-0">
      @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <div class="row">
    <div class="col-md-8">
      <div class="card border-0 shadow-sm rounded-4 mb-4" style="border-radius: 16px;">
        <div class="card-body p-4 p-md-5">
          <h4 class="font-weight-bold mb-4">Clinic & Subscription Controls</h4>

          <form action="{{ route('admin.saas.clinic.update', $clinic->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3">
              <div class="col-12 mb-3">
                <label class="form-label font-weight-bold">Clinic Logo</label>
                <div class="d-flex align-items-center gap-3">
                  <div id="edit-logo-preview-wrap" style="width: 64px; height: 64px; border-radius: 12px; background: #f8fafc; border: 1.5px dashed #cbd5e1; display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0;">
                    @if($clinic->logo)
                      <img id="edit-logo-preview" src="{{ asset($clinic->logo) }}" alt="Logo" style="max-height: 52px; max-width: 52px; object-fit: contain;">
                      <i id="edit-logo-icon" class="mdi mdi-hospital-building text-muted font-24" style="display: none;"></i>
                    @else
                      <img id="edit-logo-preview" src="" alt="Preview" style="max-height: 52px; max-width: 52px; object-fit: contain; display: none;">
                      <i id="edit-logo-icon" class="mdi mdi-image-plus text-muted font-24"></i>
                    @endif
                  </div>
                  <div class="flex-grow-1">
                    <input type="file" name="logo" class="form-control" accept="image/*" onchange="previewEditLogo(this)">
                    <small class="text-muted font-12">Recommended: PNG, JPG, WebP, or SVG (Max 3MB). Visible on public storefront header, custom pages &amp; invoices.</small>
                  </div>
                </div>
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label font-weight-bold">Clinic Name</label>
                <input type="text" class="form-control" name="name" value="{{ old('name', $clinic->name) }}" required>
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label font-weight-bold">Clinic Status</label>
                <select name="status" class="form-select font-weight-bold">
                  <option value="active" {{ $clinic->status == 'active' ? 'selected' : '' }}>Active (Full Access)</option>
                  <option value="trialing" {{ $clinic->status == 'trialing' ? 'selected' : '' }}>Trialing</option>
                  <option value="expired" {{ $clinic->status == 'expired' ? 'selected' : '' }}>Expired (Public Booking Disabled)</option>
                  <option value="suspended" {{ $clinic->status == 'suspended' ? 'selected' : '' }}>Suspended (Access Blocked)</option>
                </select>
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label font-weight-bold">Subdomain</label>
                <div class="input-group">
                  <input type="text" class="form-control" name="subdomain" value="{{ old('subdomain', $clinic->subdomain) }}" required>
                  <span class="input-group-text bg-light">.{{ request()->getHost() }}</span>
                </div>
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label font-weight-bold">Custom Domain</label>
                <input type="text" class="form-control" name="custom_domain" value="{{ old('custom_domain', $clinic->custom_domain) }}" placeholder="e.g. drsmithclinic.com">
              </div>

              <!-- Trial / Plan Extension -->
              <div class="col-12 mb-4">
                <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                  <h6 class="font-weight-bold text-dark mb-1"><i class="mdi mdi-calendar-clock text-primary mr-1"></i> Current Plan / Trial Validity</h6>
                  <p class="font-13 text-muted mb-3">
                    Valid until: <strong>{{ $clinic->trial_ends_at ? $clinic->trial_ends_at->format('d M, Y (h:i A)') : 'No Expiry' }}</strong>
                  </p>

                  <label class="form-label font-weight-bold font-13">Grant Extra Free Trial Days</label>
                  <div class="d-flex align-items-center gap-2">
                    <input type="number" class="form-control" name="trial_extend_days" placeholder="e.g. 7, 14, 30" style="max-width: 200px;">
                    <span class="text-muted font-13">days (added to current expiration date)</span>
                  </div>
                </div>
              </div>

              <div class="col-12">
                <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold">
                  <i class="mdi mdi-check mr-1"></i> Save Changes
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Clinic Summary & History -->
    <div class="col-md-4">
      <div class="card border-0 shadow-sm rounded-4 mb-4" style="border-radius: 16px;">
        <div class="card-body p-4">
          <h5 class="font-weight-bold mb-3">Clinic Overview</h5>
          <ul class="list-unstyled mb-0" style="line-height: 2.2;">
            <li><strong>Specialization:</strong> {{ $clinic->specialization ?? 'N/A' }}</li>
            <li><strong>Phone:</strong> {{ $clinic->phone ?? 'N/A' }}</li>
            <li><strong>Consultation Fee:</strong> ₹{{ number_format($clinic->consultation_fee, 2) }}</li>
            <li><strong>Doctor Razorpay:</strong> 
              @if($clinic->razorpay_enabled)
                <span class="badge bg-success text-white">Configured</span>
              @else
                <span class="badge bg-secondary text-white">Not Set</span>
              @endif
            </li>
            <li><strong>Total Bookings:</strong> {{ $clinic->patients()->count() }}</li>
            <li><strong>Created On:</strong> {{ $clinic->created_at->format('d M, Y') }}</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
function previewEditLogo(input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      const img = document.getElementById('edit-logo-preview');
      const icon = document.getElementById('edit-logo-icon');
      if (img) {
        img.src = e.target.result;
        img.style.display = 'block';
      }
      if (icon) {
        icon.style.display = 'none';
      }
    };
    reader.readAsDataURL(input.files[0]);
  }
}
</script>
@endsection
