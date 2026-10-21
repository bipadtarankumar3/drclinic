@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  <!-- Top Navigation & Header -->
  <div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-2">
      <div>
        <div class="mb-1">
          <a href="{{ route('admin.saas.clinics') }}" class="text-muted font-13 font-weight-bold text-decoration-none">
            <i class="mdi mdi-arrow-left me-1"></i> Back to Clinics Directory
          </a>
        </div>
        <h2 class="font-weight-bold mb-0 text-dark d-flex align-items-center" style="font-size: 22px;">
          <i class="mdi mdi-hospital-building text-primary me-2"></i> Create New Doctor Clinic & Assign User
        </h2>
        <p class="text-muted mb-0 font-13">Create a clinic, configure custom subdomains, and register or link a user with type = user/doctor.</p>
      </div>

      <div>
        <a href="{{ route('admin.saas.clinics') }}" class="btn btn-outline-secondary btn-sm font-weight-bold px-3 py-2 shadow-sm" style="border-radius: 8px;">
          Cancel
        </a>
      </div>
    </div>
  </div>

  @if($errors->any())
  <div class="alert alert-danger alert-dismissible fade show rounded-3 p-3 mb-4 shadow-sm" role="alert">
    <strong><i class="mdi mdi-alert-circle me-1"></i> Please check the following errors:</strong>
    <ul class="mb-0 mt-2 ps-3">
      @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
      @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  @if(session('error'))
  <div class="alert alert-danger alert-dismissible fade show rounded-3 p-3 mb-4 shadow-sm" role="alert">
    <strong><i class="mdi mdi-alert-circle me-1"></i> Error:</strong> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  <form method="POST" action="{{ route('admin.saas.clinic.store') }}" id="createClinicForm">
    @csrf

    <div class="row g-4">
      <!-- Left Column: Clinic Information -->
      <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 h-100" style="border-radius: 16px;">
          <div class="card-body p-4">
            <h5 class="font-weight-bold mb-3 text-dark border-bottom pb-2 d-flex align-items-center" style="font-size: 16px;">
              <span class="badge bg-primary bg-opacity-10 text-primary me-2 px-2 py-1" style="border-radius: 6px;">1</span>
              Clinic Profile & Storefront Details
            </h5>

            <div class="row g-3">
              <div class="col-md-12">
                <label class="form-label font-weight-bold font-13 text-dark">Clinic Name <span class="text-danger">*</span></label>
                <input type="text" name="clinic_name" class="form-control" placeholder="e.g. Metro Care Multispecialty Clinic" value="{{ old('clinic_name') }}" required onkeyup="syncSubdomain(this.value)">
                <small class="text-muted font-11">The public-facing name of the doctor's clinic.</small>
              </div>

              <div class="col-md-6">
                <label class="form-label font-weight-bold font-13 text-dark">Subdomain <span class="text-danger">*</span></label>
                <div class="input-group">
                  <input type="text" name="subdomain" id="subdomainInput" class="form-control" placeholder="metrocare" value="{{ old('subdomain') }}" required>
                  <span class="input-group-text bg-light font-12 text-muted">.{{ request()->getHost() }}</span>
                </div>
                <small class="text-muted font-11">Unique URL for online bookings.</small>
              </div>

              <div class="col-md-6">
                <label class="form-label font-weight-bold font-13 text-dark">Specialization / Department</label>
                <input type="text" name="specialization" class="form-control" placeholder="e.g. Cardiology, Neurology, General Medicine" value="{{ old('specialization') }}">
              </div>

              <div class="col-md-6">
                <label class="form-label font-weight-bold font-13 text-dark">Consultation Fee (₹)</label>
                <div class="input-group">
                  <span class="input-group-text bg-light">₹</span>
                  <input type="number" step="0.01" name="consultation_fee" class="form-control" placeholder="500.00" value="{{ old('consultation_fee', '500.00') }}">
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label font-weight-bold font-13 text-dark">Clinic Phone Number</label>
                <input type="text" name="clinic_phone" class="form-control" placeholder="+91 9876543210" value="{{ old('clinic_phone') }}">
              </div>

              <div class="col-md-12">
                <label class="form-label font-weight-bold font-13 text-dark">Clinic Email Address</label>
                <input type="email" name="clinic_email" class="form-control" placeholder="clinic@example.com" value="{{ old('clinic_email') }}">
              </div>

              <div class="col-md-12">
                <label class="form-label font-weight-bold font-13 text-dark">Clinic Address / Location</label>
                <textarea name="address" class="form-control" rows="2" placeholder="Full physical address, city, state, pin code...">{{ old('address') }}</textarea>
              </div>

              <div class="col-md-12">
                <label class="form-label font-weight-bold font-13 text-dark">Custom Domain (Optional)</label>
                <input type="text" name="custom_domain" class="form-control" placeholder="e.g. clinic.mydomain.com" value="{{ old('custom_domain') }}">
                <small class="text-muted font-11">Leave blank if the clinic uses standard subdomain access.</small>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Column: User Assignment & Subscription -->
      <div class="col-lg-5">
        <!-- 2. User Assignment Section -->
        <div class="card border-0 shadow-sm rounded-4 mb-4" style="border-radius: 16px;">
          <div class="card-body p-4">
            <h5 class="font-weight-bold mb-3 text-dark border-bottom pb-2 d-flex align-items-center" style="font-size: 16px;">
              <span class="badge bg-success bg-opacity-10 text-success me-2 px-2 py-1" style="border-radius: 6px;">2</span>
              User & Doctor Assignment
            </h5>

            <!-- User Mode Selector -->
            <div class="btn-group w-100 mb-3" role="group">
              <input type="radio" class="btn-check" name="user_mode" id="mode_new" value="new" {{ old('user_mode', 'new') === 'new' ? 'checked' : '' }} onchange="toggleUserMode('new')">
              <label class="btn btn-outline-primary font-weight-bold btn-sm py-2" for="mode_new">
                <i class="mdi mdi-account-plus me-1"></i> Create New User
              </label>

              <input type="radio" class="btn-check" name="user_mode" id="mode_existing" value="existing" {{ old('user_mode') === 'existing' ? 'checked' : '' }} onchange="toggleUserMode('existing')">
              <label class="btn btn-outline-primary font-weight-bold btn-sm py-2" for="mode_existing">
                <i class="mdi mdi-account-check me-1"></i> Link Existing User
              </label>
            </div>

            <!-- Fields for New User -->
            <div id="newUserSection" style="{{ old('user_mode', 'new') === 'new' ? '' : 'display: none;' }}">
              <div class="mb-3">
                <label class="form-label font-weight-bold font-13 text-dark">User / Doctor Name <span class="text-danger">*</span></label>
                <input type="text" name="user_name" class="form-control" placeholder="e.g. Dr. Rajesh Kumar" value="{{ old('user_name') }}">
              </div>

              <div class="mb-3">
                <label class="form-label font-weight-bold font-13 text-dark">User Login Email <span class="text-danger">*</span></label>
                <input type="email" name="user_email" class="form-control" placeholder="doctor@example.com" value="{{ old('user_email') }}">
                <small class="text-muted font-11">This email will be used to log into the doctor portal.</small>
              </div>

              <div class="mb-3">
                <label class="form-label font-weight-bold font-13 text-dark">Login Password <span class="text-danger">*</span></label>
                <input type="password" name="user_password" class="form-control" placeholder="Minimum 6 characters" value="{{ old('user_password', 'Password@123') }}">
                <small class="text-muted font-11">Default: <code>Password@123</code></small>
              </div>

              <div class="mb-3">
                <label class="form-label font-weight-bold font-13 text-dark">Contact Phone</label>
                <input type="text" name="user_phone" class="form-control" placeholder="+91 9876543210" value="{{ old('user_phone') }}">
              </div>

              <div class="mb-3">
                <label class="form-label font-weight-bold font-13 text-dark">User Type <span class="text-danger">*</span></label>
                <select name="user_type" class="form-select font-weight-bold">
                  <option value="user" {{ old('user_type', 'user') === 'user' ? 'selected' : '' }}>User (type = user)</option>
                  <option value="doctor" {{ old('user_type') === 'doctor' ? 'selected' : '' }}>Doctor (type = doctor)</option>
                </select>
                <small class="text-muted font-11">Assigned role in users table. Both can manage the clinic portal.</small>
              </div>
            </div>

            <!-- Fields for Existing User -->
            <div id="existingUserSection" style="{{ old('user_mode') === 'existing' ? '' : 'display: none;' }}">
              <div class="mb-3">
                <label class="form-label font-weight-bold font-13 text-dark">Select Registered User <span class="text-danger">*</span></label>
                <select name="user_id" class="form-select font-weight-bold">
                  <option value="">-- Choose User to Assign --</option>
                  @foreach($availableUsers as $u)
                    <option value="{{ $u->id }}" {{ old('user_id') == $u->id ? 'selected' : '' }}>
                      {{ $u->name }} ({{ $u->email }}) - [type: {{ $u->user_type }}]
                    </option>
                  @endforeach
                </select>
                <small class="text-muted font-11">Selected user will become the owner of this clinic.</small>
              </div>
            </div>
          </div>
        </div>

        <!-- 3. Subscription & Lifecycle Settings -->
        <div class="card border-0 shadow-sm rounded-4" style="border-radius: 16px;">
          <div class="card-body p-4">
            <h5 class="font-weight-bold mb-3 text-dark border-bottom pb-2 d-flex align-items-center" style="font-size: 16px;">
              <span class="badge bg-warning bg-opacity-10 text-warning me-2 px-2 py-1" style="border-radius: 6px;">3</span>
              Subscription & Status
            </h5>

            <div class="mb-3">
              <label class="form-label font-weight-bold font-13 text-dark">Initial Status <span class="text-danger">*</span></label>
              <select name="status" class="form-select font-weight-bold" onchange="toggleStatusFields(this.value)">
                <option value="trialing" {{ old('status', 'trialing') === 'trialing' ? 'selected' : '' }}>7-Day Free Trial (Trialing)</option>
                <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active Paid Account</option>
                <option value="suspended" {{ old('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
              </select>
            </div>

            <div class="mb-3" id="trialDaysGroup">
              <label class="form-label font-weight-bold font-13 text-dark">Trial Period (Days)</label>
              <input type="number" name="trial_days" class="form-control" value="{{ old('trial_days', 7) }}" min="1" max="365">
              <small class="text-muted font-11">Number of free trial days before subscription plan is required.</small>
            </div>

            <div class="mb-3">
              <label class="form-label font-weight-bold font-13 text-dark">Assign Subscription Plan</label>
              <select name="plan_id" class="form-select font-weight-bold">
                <option value="">-- No Plan / Default Trial --</option>
                @foreach($plans as $p)
                  <option value="{{ $p->id }}" {{ old('plan_id') == $p->id ? 'selected' : '' }}>
                    {{ $p->name }} - ₹{{ number_format($p->price, 0) }} / {{ $p->billing_cycle }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="mt-4 pt-2 border-top">
              <button type="submit" class="btn btn-primary btn-lg w-100 font-weight-bold shadow-sm d-flex align-items-center justify-content-center gap-2" style="border-radius: 10px;">
                <i class="mdi mdi-check-circle font-18"></i> Create Clinic & Assign User
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<script>
function syncSubdomain(name) {
  const input = document.getElementById('subdomainInput');
  if (input && !input.dataset.userEdited) {
    input.value = name.toLowerCase()
      .replace(/[^a-z0-9]/g, '-')
      .replace(/-+/g, '-')
      .replace(/^-|-$/g, '');
  }
}

document.getElementById('subdomainInput').addEventListener('input', function() {
  this.dataset.userEdited = "true";
});

function toggleUserMode(mode) {
  const newSec = document.getElementById('newUserSection');
  const existSec = document.getElementById('existingUserSection');
  if (mode === 'new') {
    newSec.style.display = 'block';
    existSec.style.display = 'none';
  } else {
    newSec.style.display = 'none';
    existSec.style.display = 'block';
  }
}

function toggleStatusFields(status) {
  const trialGroup = document.getElementById('trialDaysGroup');
  if (status === 'trialing') {
    trialGroup.style.display = 'block';
  } else {
    trialGroup.style.display = 'none';
  }
}
</script>
@endsection
