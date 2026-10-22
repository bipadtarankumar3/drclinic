@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  <!-- Top Navigation & Header -->
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 pb-2">
    <div>
      <div class="mb-1">
        <a href="{{ route('admin.saas.clinics') }}" class="btn btn-sm btn-light border font-weight-bold text-muted mr-2" style="border-radius: 8px;">
          <i class="mdi mdi-arrow-left me-1"></i> Back to Clinics
        </a>
      </div>
      <h2 class="font-weight-bold mb-0 text-dark d-flex align-items-center" style="font-size: 24px; letter-spacing: -0.5px;">
        <i class="mdi mdi-hospital-building text-primary me-2"></i> Create Doctor Clinic &amp; Assign User
      </h2>
      <p class="text-muted mb-0 font-13">Create a clinic portal, configure custom subdomains, and register or link an owner user.</p>
    </div>

    <div>
      <a href="{{ route('admin.saas.clinics') }}" class="btn btn-light border font-weight-bold px-3 py-2" style="border-radius: 8px;">
        Cancel
      </a>
    </div>
  </div>

  @if(isset($errors) && $errors->any())
  <div class="alert alert-danger alert-dismissible fade show rounded-3 p-3 mb-4 shadow-sm" style="border-left: 4px solid #ef4444; background: #fef2f2; color: #991b1b;" role="alert">
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
  <div class="alert alert-danger alert-dismissible fade show rounded-3 p-3 mb-4 shadow-sm" style="border-left: 4px solid #ef4444; background: #fef2f2; color: #991b1b;" role="alert">
    <strong><i class="mdi mdi-alert-circle me-1"></i> Error:</strong> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  <form method="POST" action="{{ route('admin.saas.clinic.store') }}" id="createClinicForm" enctype="multipart/form-data">
    @csrf

    <div class="row g-4">
      <!-- Left Column: Clinic Information -->
      <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 h-100" style="border: 1.5px solid #e2e8f0 !important; border-radius: 16px; background: #ffffff;">
          <div class="card-body p-4">
            <h5 class="font-weight-bold text-dark mb-3 d-flex align-items-center" style="font-size: 16px;">
              <span class="me-2" style="color: #2563eb; font-size: 16px;">●</span> Clinic Profile &amp; Storefront Details
            </h5>

            <div class="row g-3">
              <div class="col-md-12">
                <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Clinic Logo</label>
                <div class="d-flex align-items-center gap-3">
                  <div id="saas-logo-preview-wrap" style="width: 58px; height: 58px; border-radius: 12px; background: #f8fafc; border: 1.5px dashed #cbd5e1; display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0;">
                    <img id="saas-logo-preview" src="" alt="Preview" style="max-height: 48px; max-width: 48px; object-fit: contain; display: none;">
                    <i id="saas-logo-icon" class="mdi mdi-image-plus text-muted font-20"></i>
                  </div>
                  <div class="flex-grow-1">
                    <input type="file" name="logo" class="form-control" accept="image/*" onchange="previewAdminLogo(this)" style="border-radius: 8px; font-size: 13px;">
                    <small class="text-muted font-11">Recommended: PNG, JPG, WebP, or SVG (Max 3MB). Appears on storefront &amp; booking receipts.</small>
                  </div>
                </div>
              </div>

              <div class="col-md-12">
                <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Clinic Name <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0 text-muted" style="border-radius: 8px 0 0 8px;"><i class="mdi mdi-domain font-16"></i></span>
                  <input type="text" name="clinic_name" class="form-control border-start-0" placeholder="e.g. Metro Care Multispecialty Clinic" value="{{ old('clinic_name') }}" required onkeyup="syncSubdomain(this.value)" style="border-radius: 0 8px 8px 0; font-size: 14px;">
                </div>
                <small class="text-muted font-11">The public-facing business name of the doctor clinic.</small>
              </div>

              <div class="col-md-6">
                <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Subdomain <span class="text-danger">*</span></label>
                <div class="input-group">
                  <input type="text" name="subdomain" id="subdomainInput" class="form-control" placeholder="metrocare" value="{{ old('subdomain') }}" required style="border-radius: 8px 0 0 8px; font-size: 14px;">
                  <span class="input-group-text bg-light font-12 text-muted font-weight-bold" style="border-radius: 0 8px 8px 0;">.{{ request()->getHost() }}</span>
                </div>
                <small class="text-muted font-11">Unique URL for online bookings.</small>
              </div>

              <div class="col-md-6">
                <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Specialization / Department</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0 text-muted" style="border-radius: 8px 0 0 8px;"><i class="mdi mdi-stethoscope font-16"></i></span>
                  <input type="text" name="specialization" class="form-control border-start-0" placeholder="e.g. Cardiology, Neurology, Pediatrics" value="{{ old('specialization') }}" style="border-radius: 0 8px 8px 0; font-size: 14px;">
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Consultation Fee (₹)</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0 text-muted font-weight-bold" style="border-radius: 8px 0 0 8px;">₹</span>
                  <input type="number" step="0.01" name="consultation_fee" class="form-control border-start-0" placeholder="500.00" value="{{ old('consultation_fee', '500.00') }}" style="border-radius: 0 8px 8px 0; font-size: 14px;">
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Clinic Phone Number</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0 text-muted" style="border-radius: 8px 0 0 8px;"><i class="mdi mdi-phone-outline font-16"></i></span>
                  <input type="text" name="clinic_phone" class="form-control border-start-0" placeholder="+91 9876543210" value="{{ old('clinic_phone') }}" style="border-radius: 0 8px 8px 0; font-size: 14px;">
                </div>
              </div>

              <div class="col-md-12">
                <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Clinic Email Address</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0 text-muted" style="border-radius: 8px 0 0 8px;"><i class="mdi mdi-email-outline font-16"></i></span>
                  <input type="email" name="clinic_email" class="form-control border-start-0" placeholder="clinic@example.com" value="{{ old('clinic_email') }}" style="border-radius: 0 8px 8px 0; font-size: 14px;">
                </div>
              </div>

              <div class="col-md-12">
                <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Clinic Address / Physical Location</label>
                <textarea name="address" class="form-control" rows="2" placeholder="Full physical address, street, city, state, pin code..." style="border-radius: 8px; font-size: 14px;">{{ old('address') }}</textarea>
              </div>

              <div class="col-md-12">
                <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Custom Domain (Optional)</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0 text-muted" style="border-radius: 8px 0 0 8px;"><i class="mdi mdi-earth font-16"></i></span>
                  <input type="text" name="custom_domain" class="form-control border-start-0" placeholder="e.g. clinic.mydomain.com" value="{{ old('custom_domain') }}" style="border-radius: 0 8px 8px 0; font-size: 14px;">
                </div>
                <small class="text-muted font-11">Leave blank if the clinic uses standard subdomain access.</small>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Column: User Assignment & Subscription -->
      <div class="col-lg-5">
        <!-- 2. User Assignment Section -->
        <div class="card border-0 shadow-sm rounded-4 mb-4" style="border: 1.5px solid #e2e8f0 !important; border-radius: 16px; background: #ffffff;">
          <div class="card-body p-4">
            <h5 class="font-weight-bold text-dark mb-3 d-flex align-items-center" style="font-size: 16px;">
              <span class="me-2" style="color: #10b981; font-size: 16px;">●</span> User &amp; Doctor Assignment
            </h5>

            <!-- Segmented Pill Selector -->
            <div class="p-1 mb-3 rounded-3 d-flex gap-1" style="background: #f1f5f9; width: 100%;">
              <button type="button" class="btn btn-sm flex-fill font-weight-bold py-2 page-user-mode active-page-mode" id="btnPageModeNew" onclick="toggleUserMode('new')" style="border-radius: 8px; font-size: 12.5px; transition: all 0.15s ease;">
                <i class="mdi mdi-account-plus me-1"></i> Create New User
              </button>
              <button type="button" class="btn btn-sm flex-fill font-weight-bold py-2 page-user-mode text-muted" id="btnPageModeExisting" onclick="toggleUserMode('existing')" style="border-radius: 8px; font-size: 12.5px; transition: all 0.15s ease;">
                <i class="mdi mdi-account-check me-1"></i> Link Existing User
              </button>
            </div>
            <input type="hidden" name="user_mode" id="userModeInput" value="new">

            <!-- Fields for New User -->
            <div id="newUserSection">
              <div class="mb-3">
                <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Full Name <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0 text-muted" style="border-radius: 8px 0 0 8px;"><i class="mdi mdi-account-outline"></i></span>
                  <input type="text" name="user_name" class="form-control border-start-0" placeholder="e.g. Dr. Rajesh Kumar" value="{{ old('user_name') }}" style="border-radius: 0 8px 8px 0; font-size: 13.5px;">
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">User Login Email <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0 text-muted" style="border-radius: 8px 0 0 8px;"><i class="mdi mdi-email-outline"></i></span>
                  <input type="email" name="user_email" class="form-control border-start-0" placeholder="doctor@example.com" value="{{ old('user_email') }}" style="border-radius: 0 8px 8px 0; font-size: 13.5px;">
                </div>
                <small class="text-muted font-11">This email will be used to log into the clinic portal.</small>
              </div>

              <div class="mb-3">
                <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Login Password <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0 text-muted" style="border-radius: 8px 0 0 8px;"><i class="mdi mdi-lock-outline"></i></span>
                  <input type="password" id="userPassword" name="user_password" class="form-control border-start-0 border-end-0" placeholder="Minimum 6 characters" value="{{ old('user_password', 'Password@123') }}" style="font-size: 13.5px;">
                  <button type="button" class="btn btn-light border border-start-0 text-muted" onclick="togglePasswordVisibility()" style="border-radius: 0 8px 8px 0;">
                    <i class="mdi mdi-eye-outline" id="passwordEyeIcon"></i>
                  </button>
                </div>
                <small class="text-muted font-11">Default password: <code>Password@123</code></small>
              </div>

              <div class="mb-3">
                <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Contact Phone</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0 text-muted" style="border-radius: 8px 0 0 8px;"><i class="mdi mdi-phone-outline"></i></span>
                  <input type="text" name="user_phone" class="form-control border-start-0" placeholder="+91 9876543210" value="{{ old('user_phone') }}" style="border-radius: 0 8px 8px 0; font-size: 13.5px;">
                </div>
              </div>

              <div class="mb-3">
                <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">User Type / Role <span class="text-danger">*</span></label>
                <select name="user_type" class="form-select font-weight-bold" style="border-radius: 8px; font-size: 13.5px;">
                  <option value="user" {{ old('user_type', 'user') === 'user' ? 'selected' : '' }}>User (type = user)</option>
                  <option value="doctor" {{ old('user_type') === 'doctor' ? 'selected' : '' }}>Doctor (type = doctor)</option>
                </select>
                <small class="text-muted font-11">Assigned role in users table. Both can manage the clinic portal.</small>
              </div>
            </div>

            <!-- Fields for Existing User -->
            <div id="existingUserSection" style="display: none;">
              <div class="mb-3">
                <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Select Registered User <span class="text-danger">*</span></label>
                <select name="user_id" class="form-select font-weight-bold" style="border-radius: 8px; font-size: 13.5px;">
                  <option value="">-- Choose User to Assign as Owner --</option>
                  @foreach($availableUsers as $u)
                    <option value="{{ $u->id }}" {{ old('user_id') == $u->id ? 'selected' : '' }}>
                      {{ $u->name }} ({{ $u->email }}) &mdash; [role: {{ $u->user_type }}]
                    </option>
                  @endforeach
                </select>
                <small class="text-muted font-11">Selected user will become the owner of this clinic.</small>
              </div>
            </div>
          </div>
        </div>

        <!-- 3. Subscription & Lifecycle Settings -->
        <div class="card border-0 shadow-sm rounded-4" style="border: 1.5px solid #e2e8f0 !important; border-radius: 16px; background: #ffffff;">
          <div class="card-body p-4">
            <h5 class="font-weight-bold text-dark mb-3 d-flex align-items-center" style="font-size: 16px;">
              <span class="me-2" style="color: #f59e0b; font-size: 16px;">●</span> Subscription Plan &amp; Status
            </h5>

            <div class="mb-3">
              <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Initial Status <span class="text-danger">*</span></label>
              <select name="status" class="form-select font-weight-bold" onchange="toggleStatusFields(this.value)" style="border-radius: 8px; font-size: 13.5px;">
                <option value="trialing" {{ old('status', 'trialing') === 'trialing' ? 'selected' : '' }}>7-Day Free Trial (Trialing)</option>
                <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active Paid Account</option>
                <option value="suspended" {{ old('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
              </select>
            </div>

            <div class="mb-3" id="trialDaysGroup">
              <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Trial Period (Days)</label>
              <input type="number" name="trial_days" class="form-control" value="{{ old('trial_days', 7) }}" min="1" max="365" style="border-radius: 8px; font-size: 13.5px;">
              <small class="text-muted font-11">Number of free trial days before a paid subscription is required.</small>
            </div>

            <div class="mb-3">
              <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Assign Subscription Plan</label>
              <select name="plan_id" class="form-select font-weight-bold" style="border-radius: 8px; font-size: 13.5px;">
                <option value="">-- No Plan / Default Trial (Starter Tier) --</option>
                @foreach($plans as $p)
                  <option value="{{ $p->id }}" {{ old('plan_id') == $p->id ? 'selected' : '' }}>
                    {{ $p->name }} &mdash; ₹{{ number_format($p->price, 0) }} / {{ $p->billing_cycle }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="mt-4 pt-3 border-top" style="border-color: #f1f5f9 !important;">
              <button type="submit" class="btn font-weight-bold text-white btn-lg w-100 shadow-sm d-flex align-items-center justify-content-center gap-2 py-3" style="background: linear-gradient(135deg, #2563eb, #1d4ed8); border: none; border-radius: 10px; font-size: 15px; box-shadow: 0 4px 14px rgba(37,99,235,0.3);">
                <i class="mdi mdi-check-circle-outline font-18"></i> Create Clinic &amp; Assign User
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<style>
.active-page-mode {
  background: #2563eb !important;
  color: #ffffff !important;
  box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25) !important;
}
</style>

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
  const btnNew = document.getElementById('btnPageModeNew');
  const btnExist = document.getElementById('btnPageModeExisting');
  const hiddenInput = document.getElementById('userModeInput');

  hiddenInput.value = mode;

  if (mode === 'new') {
    newSec.style.display = 'block';
    existSec.style.display = 'none';
    btnNew.classList.add('active-page-mode');
    btnNew.classList.remove('text-muted');
    btnExist.classList.remove('active-page-mode');
    btnExist.classList.add('text-muted');
  } else {
    newSec.style.display = 'none';
    existSec.style.display = 'block';
    btnExist.classList.add('active-page-mode');
    btnExist.classList.remove('text-muted');
    btnNew.classList.remove('active-page-mode');
    btnNew.classList.add('text-muted');
  }
}

function togglePasswordVisibility() {
  const pwd = document.getElementById('userPassword');
  const icon = document.getElementById('passwordEyeIcon');
  if (pwd.type === 'password') {
    pwd.type = 'text';
    icon.className = 'mdi mdi-eye-off-outline';
  } else {
    pwd.type = 'password';
    icon.className = 'mdi mdi-eye-outline';
  }
}

function toggleStatusFields(status) {
  const group = document.getElementById('trialDaysGroup');
  if (group) {
    group.style.display = (status === 'trialing') ? 'block' : 'none';
  }
}

function previewAdminLogo(input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      const img = document.getElementById('saas-logo-preview');
      const icon = document.getElementById('saas-logo-icon');
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
