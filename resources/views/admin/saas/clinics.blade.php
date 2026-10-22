@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  <div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-2">
      <div>
        <h2 class="font-weight-bold mb-1"><i class="mdi mdi-hospital-building text-primary mr-1"></i> All Doctor Clinics Directory</h2>
        <p class="text-muted mb-0">Browse, manage, impersonate, and adjust trial/subscription settings for all registered clinics.</p>
      </div>
      <div class="d-flex align-items-center gap-2">
        <a href="{{ route('admin.saas.clinic.create') }}" class="btn btn-outline-primary btn-sm font-weight-bold shadow-sm d-inline-flex align-items-center gap-1" style="border-radius: 8px; padding: 7px 14px;">
          <i class="mdi mdi-arrow-top-right font-16"></i> Full Form
        </a>
        <button type="button" class="btn btn-primary btn-sm font-weight-bold shadow-sm d-inline-flex align-items-center gap-1" style="border-radius: 8px; padding: 7px 16px;" data-bs-toggle="modal" data-bs-target="#createClinicModal">
          <i class="mdi mdi-plus-circle font-16"></i> Create New Clinic
        </button>
      </div>
    </div>
  </div>

  @if(session('success'))
  <div class="alert alert-success alert-dismissible fade show rounded-3 p-3 mb-4 shadow-sm" role="alert">
    <strong><i class="mdi mdi-check-circle mr-1"></i> Success:</strong> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  @if(isset($errors) && $errors->any())
  <div class="alert alert-danger alert-dismissible fade show rounded-3 p-3 mb-4 shadow-sm" role="alert">
    <strong><i class="mdi mdi-alert-circle mr-1"></i> Please check the following errors:</strong>
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
    <strong><i class="mdi mdi-alert-circle mr-1"></i> Error:</strong> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  <!-- Filters & Search -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="card border-0 shadow-sm rounded-4" style="border-radius: 16px;">
        <div class="card-body p-3">
          <form method="GET" action="{{ route('admin.saas.clinics') }}" class="row g-2 align-items-center">
            <div class="col-md-5">
              <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="mdi mdi-magnify"></i></span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="Search clinic name, doctor, subdomain, email..." value="{{ request('search') }}">
              </div>
            </div>

            <div class="col-md-3">
              <select name="status" class="form-select font-weight-bold">
                <option value="">All Statuses</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="trialing" {{ request('status') == 'trialing' ? 'selected' : '' }}>Trialing</option>
                <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
              </select>
            </div>

            <div class="col-md-4 d-flex gap-2">
              <button type="submit" class="btn btn-primary font-weight-bold px-4">Filter</button>
              <a href="{{ route('admin.saas.clinics') }}" class="btn btn-outline-secondary font-weight-bold">Reset</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Clinics Table -->
  <div class="row">
    <div class="col-12">
      <div class="card border-0 shadow-sm rounded-4" style="border-radius: 16px;">
        <div class="card-body p-4">
          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead class="bg-light">
                <tr>
                  <th>Clinic Info</th>
                  <th>Doctor / Owner</th>
                  <th>Domain / Subdomain</th>
                  <th>Status</th>
                  <th>Plan & Expiry</th>
                  <th class="text-end">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse($clinics as $c)
                <tr>
                  <td>
                    <div class="font-weight-bold text-dark font-15">{{ $c->name }}</div>
                    <small class="text-muted">{{ $c->specialization ?? 'General Medical' }} &bull; {{ $c->phone }}</small>
                  </td>
                  <td>
                    <div class="font-weight-bold text-dark">{{ $c->user->name ?? 'Admin' }}</div>
                    <small class="text-muted">{{ $c->user->email ?? $c->email }} &bull; <span class="badge bg-light text-dark font-10">type: {{ $c->user->user_type ?? 'user' }}</span></small>
                  </td>
                  <td>
                    <div><code class="text-primary font-weight-bold">{{ $c->subdomain }}.{{ request()->getHost() }}</code></div>
                    @if($c->custom_domain)
                      <small class="text-success"><i class="mdi mdi-check-decagram"></i> {{ $c->custom_domain }}</small>
                    @endif
                  </td>
                  <td>
                    @if($c->status === 'active')
                      <span class="badge bg-success text-white">Active</span>
                    @elseif($c->status === 'trialing')
                      @if($c->trial_ends_at && $c->trial_ends_at->isPast())
                        <span class="badge bg-danger text-white">Trial Expired</span>
                      @else
                        <span class="badge bg-warning text-dark">Trial ({{ $c->trialDaysRemaining() }}d)</span>
                      @endif
                    @elseif($c->status === 'suspended')
                      <span class="badge bg-dark text-white">Suspended</span>
                    @else
                      <span class="badge bg-danger text-white">Expired</span>
                    @endif
                  </td>
                  <td>
                    <div class="font-weight-bold font-13">{{ $c->activeSubscription->plan->name ?? ($c->status === 'trialing' ? '7-Day Trial' : 'No Active Plan') }}</div>
                    <small class="text-muted">
                      @if($c->trial_ends_at)
                        Ends: {{ $c->trial_ends_at->format('d M, Y') }}
                      @else
                        No Expiry
                      @endif
                    </small>
                  </td>
                  <td class="text-end text-nowrap">
                    <a href="{{ route('admin.saas.visit_doctor_plan', $c->id) }}" class="btn btn-sm btn-outline-warning me-1 font-weight-bold" title="Visit & Manage Doctor's Plan & Billing">
                      <i class="mdi mdi-crown text-warning me-1"></i> Visit Plan
                    </a>
                    <a href="{{ route('admin.saas.impersonate', $c->id) }}" class="btn btn-sm btn-outline-primary me-1 font-weight-bold" title="Login as Doctor / Clinic Admin">
                      <i class="mdi mdi-login-variant me-1"></i> Enter Clinic
                    </a>
                    <a href="{{ route('admin.saas.clinic.edit', $c->id) }}" class="btn btn-sm btn-outline-secondary font-weight-bold" title="Edit Settings">
                      <i class="mdi mdi-tune"></i> Manage
                    </a>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="6" class="text-center py-5 text-muted">
                    No doctor clinics match your search criteria.
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <div class="mt-4">
            {{ $clinics->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ========================================================================= -->
<!-- CREATE CLINIC & ASSIGN USER MODAL                                         -->
<!-- ========================================================================= -->
<div class="modal fade" id="createClinicModal" tabindex="-1" aria-labelledby="createClinicModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
      <!-- Modal Header -->
      <div class="modal-header border-0 px-4 pt-4 pb-3" style="background: #ffffff;">
        <div class="d-flex align-items-center gap-3">
          <div class="d-flex align-items-center justify-content-center rounded-3 shadow-sm" style="width: 44px; height: 44px; background: linear-gradient(135deg, #2563eb, #1d4ed8); color: #ffffff; flex-shrink: 0;">
            <i class="mdi mdi-hospital-building font-22"></i>
          </div>
          <div>
            <h5 class="modal-title font-weight-bold text-dark mb-0" id="createClinicModalLabel" style="font-size: 19px; letter-spacing: -0.3px;">
              Create Doctor Clinic &amp; Assign User
            </h5>
            <p class="text-muted font-12 mb-0">Set up a new doctor clinic portal and assign an owner user (type = user or doctor).</p>
          </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form method="POST" action="{{ route('admin.saas.clinic.store') }}">
        @csrf
        <div class="modal-body px-4 py-2" style="background: #f8fafc;">

          <!-- Section 1: Clinic Profile & Storefront Details -->
          <div class="card border-0 shadow-sm rounded-4 mb-3" style="border: 1.5px solid #e2e8f0 !important; border-radius: 14px; background: #ffffff;">
            <div class="card-body p-3 p-md-4">
              <h6 class="font-weight-bold text-dark mb-3 d-flex align-items-center" style="font-size: 14px;">
                <span class="me-2" style="color: #2563eb; font-size: 16px;">●</span> Clinic Profile &amp; Storefront
              </h6>

              <div class="row g-3">
                <div class="col-md-7">
                  <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Clinic Name <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted" style="border-radius: 8px 0 0 8px;"><i class="mdi mdi-domain"></i></span>
                    <input type="text" name="clinic_name" class="form-control border-start-0" placeholder="e.g. Apex Multispecialty Clinic" required onkeyup="syncModalSubdomain(this.value)" style="border-radius: 0 8px 8px 0; font-size: 13.5px;">
                  </div>
                </div>

                <div class="col-md-5">
                  <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Subdomain <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <input type="text" name="subdomain" id="modalSubdomain" class="form-control" placeholder="apex" required style="border-radius: 8px 0 0 8px; font-size: 13.5px;">
                    <span class="input-group-text bg-light font-12 text-muted font-weight-bold" style="border-radius: 0 8px 8px 0;">.{{ request()->getHost() }}</span>
                  </div>
                </div>

                <div class="col-md-6">
                  <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Specialization</label>
                  <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted" style="border-radius: 8px 0 0 8px;"><i class="mdi mdi-stethoscope"></i></span>
                    <input type="text" name="specialization" class="form-control border-start-0" placeholder="e.g. Neurology, Pediatrics" style="border-radius: 0 8px 8px 0; font-size: 13.5px;">
                  </div>
                </div>

                <div class="col-md-3">
                  <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Consultation Fee (₹)</label>
                  <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted font-weight-bold" style="border-radius: 8px 0 0 8px;">₹</span>
                    <input type="number" step="0.01" min="0" name="consultation_fee" class="form-control border-start-0" value="500.00" style="border-radius: 0 8px 8px 0; font-size: 13.5px;">
                  </div>
                </div>

                <div class="col-md-3">
                  <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Platform Charge (₹)</label>
                  <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted font-weight-bold" style="border-radius: 8px 0 0 8px;">₹</span>
                    <input type="number" step="0.01" min="0" name="platform_fee" class="form-control border-start-0" value="0.00" style="border-radius: 0 8px 8px 0; font-size: 13.5px;">
                  </div>
                </div>

                <div class="col-md-6">
                  <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Clinic Phone</label>
                  <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted" style="border-radius: 8px 0 0 8px;"><i class="mdi mdi-phone-outline"></i></span>
                    <input type="text" name="clinic_phone" class="form-control border-start-0" placeholder="+91 9876543210" style="border-radius: 0 8px 8px 0; font-size: 13.5px;">
                  </div>
                </div>

                <div class="col-md-6">
                  <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Clinic Email</label>
                  <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted" style="border-radius: 8px 0 0 8px;"><i class="mdi mdi-email-outline"></i></span>
                    <input type="email" name="clinic_email" class="form-control border-start-0" placeholder="clinic@example.com" style="border-radius: 0 8px 8px 0; font-size: 13.5px;">
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Section 2: User & Doctor Assignment -->
          <div class="card border-0 shadow-sm rounded-4 mb-3" style="border: 1.5px solid #e2e8f0 !important; border-radius: 14px; background: #ffffff;">
            <div class="card-body p-3 p-md-4">
              <h6 class="font-weight-bold text-dark mb-3 d-flex align-items-center" style="font-size: 14px;">
                <span class="me-2" style="color: #10b981; font-size: 16px;">●</span> User &amp; Doctor Assignment
              </h6>

              <!-- Segmented Pill Selector -->
              <div class="p-1 mb-3 rounded-3 d-flex gap-1" style="background: #f1f5f9; width: 100%; max-width: 420px;">
                <button type="button" class="btn btn-sm flex-fill font-weight-bold py-2 user-mode-btn active-mode" id="btnModeNew" onclick="toggleModalUserMode('new')" style="border-radius: 8px; font-size: 12.5px; transition: all 0.15s ease;">
                  <i class="mdi mdi-account-plus me-1"></i> Create New User
                </button>
                <button type="button" class="btn btn-sm flex-fill font-weight-bold py-2 user-mode-btn text-muted" id="btnModeExisting" onclick="toggleModalUserMode('existing')" style="border-radius: 8px; font-size: 12.5px; transition: all 0.15s ease;">
                  <i class="mdi mdi-account-check me-1"></i> Link Existing User
                </button>
              </div>
              <input type="hidden" name="user_mode" id="modalUserModeInput" value="new">

              <!-- New User Form -->
              <div id="modalNewUserSection">
                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Full Name <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <span class="input-group-text bg-light border-end-0 text-muted" style="border-radius: 8px 0 0 8px;"><i class="mdi mdi-account-outline"></i></span>
                      <input type="text" name="user_name" class="form-control border-start-0" placeholder="Dr. Full Name" style="border-radius: 0 8px 8px 0; font-size: 13.5px;">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Login Email <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <span class="input-group-text bg-light border-end-0 text-muted" style="border-radius: 8px 0 0 8px;"><i class="mdi mdi-email-outline"></i></span>
                      <input type="email" name="user_email" class="form-control border-start-0" placeholder="doctor@example.com" style="border-radius: 0 8px 8px 0; font-size: 13.5px;">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Password <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <span class="input-group-text bg-light border-end-0 text-muted" style="border-radius: 8px 0 0 8px;"><i class="mdi mdi-lock-outline"></i></span>
                      <input type="password" id="modalUserPassword" name="user_password" class="form-control border-start-0 border-end-0" value="Password@123" style="font-size: 13.5px;">
                      <button type="button" class="btn btn-light border border-start-0 text-muted" onclick="toggleModalPassword()" style="border-radius: 0 8px 8px 0;">
                        <i class="mdi mdi-eye-outline" id="modalPasswordEye"></i>
                      </button>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">User Type <span class="text-danger">*</span></label>
                    <select name="user_type" class="form-select font-weight-bold" style="border-radius: 8px; font-size: 13.5px;">
                      <option value="user" selected>User (type = user)</option>
                      <option value="doctor">Doctor (type = doctor)</option>
                    </select>
                  </div>
                </div>
              </div>

              <!-- Existing User Selection -->
              <div id="modalExistingUserSection" style="display: none;">
                <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Select Registered User <span class="text-danger">*</span></label>
                <select name="user_id" class="form-select font-weight-bold" style="border-radius: 8px; font-size: 13.5px;">
                  <option value="">-- Choose User to Assign as Owner --</option>
                  @foreach($availableUsers as $u)
                    <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }}) &mdash; [role: {{ $u->user_type }}]</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>

          <!-- Section 3: Subscription Plan & Status -->
          <div class="card border-0 shadow-sm rounded-4 mb-2" style="border: 1.5px solid #e2e8f0 !important; border-radius: 14px; background: #ffffff;">
            <div class="card-body p-3 p-md-4">
              <h6 class="font-weight-bold text-dark mb-3 d-flex align-items-center" style="font-size: 14px;">
                <span class="me-2" style="color: #f59e0b; font-size: 16px;">●</span> Subscription Plan &amp; Status
              </h6>

              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Initial Status <span class="text-danger">*</span></label>
                  <select name="status" class="form-select font-weight-bold" style="border-radius: 8px; font-size: 13.5px;">
                    <option value="trialing" selected>7-Day Free Trial (Trialing)</option>
                    <option value="active">Active Paid Account</option>
                    <option value="suspended">Suspended</option>
                  </select>
                </div>

                <div class="col-md-6">
                  <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Assign Subscription Plan</label>
                  <select name="plan_id" class="form-select font-weight-bold" style="border-radius: 8px; font-size: 13.5px;">
                    <option value="">-- No Plan / Default Trial (Starter Tier) --</option>
                    @foreach($plans as $p)
                      <option value="{{ $p->id }}">{{ $p->name }} (₹{{ number_format($p->price, 0) }}/mo)</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
          </div>

        </div>

        <!-- Modal Footer -->
        <div class="modal-footer border-0 px-4 py-3 d-flex justify-content-between align-items-center" style="background: #ffffff; border-top: 1px solid #e2e8f0 !important;">
          <small class="text-muted font-12 d-none d-sm-inline">
            <i class="mdi mdi-shield-check-outline text-success me-1"></i> The user will be assigned as clinic owner automatically.
          </small>
          <div class="d-flex gap-2 ms-auto">
            <button type="button" class="btn btn-light border font-weight-bold px-3 py-2" data-bs-dismiss="modal" style="border-radius: 8px; font-size: 13px;">
              Cancel
            </button>
            <button type="submit" class="btn font-weight-bold text-white px-4 py-2" style="background: linear-gradient(135deg, #2563eb, #1d4ed8); border: none; border-radius: 8px; font-size: 13px; box-shadow: 0 4px 12px rgba(37,99,235,0.25);">
              <i class="mdi mdi-check-circle-outline me-1"></i> Create Clinic &amp; Assign User
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
.active-mode {
  background: #2563eb !important;
  color: #ffffff !important;
  box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25) !important;
}
</style>

<script>
function syncModalSubdomain(name) {
  const input = document.getElementById('modalSubdomain');
  if (input && !input.dataset.userEdited) {
    input.value = name.toLowerCase()
      .replace(/[^a-z0-9]/g, '-')
      .replace(/-+/g, '-')
      .replace(/^-|-$/g, '');
  }
}

document.getElementById('modalSubdomain').addEventListener('input', function() {
  this.dataset.userEdited = "true";
});

function toggleModalUserMode(mode) {
  const newSec = document.getElementById('modalNewUserSection');
  const existSec = document.getElementById('modalExistingUserSection');
  const btnNew = document.getElementById('btnModeNew');
  const btnExist = document.getElementById('btnModeExisting');
  const hiddenInput = document.getElementById('modalUserModeInput');

  hiddenInput.value = mode;

  if (mode === 'new') {
    newSec.style.display = 'block';
    existSec.style.display = 'none';
    btnNew.classList.add('active-mode');
    btnNew.classList.remove('text-muted');
    btnExist.classList.remove('active-mode');
    btnExist.classList.add('text-muted');
  } else {
    newSec.style.display = 'none';
    existSec.style.display = 'block';
    btnExist.classList.add('active-mode');
    btnExist.classList.remove('text-muted');
    btnNew.classList.remove('active-mode');
    btnNew.classList.add('text-muted');
  }
}

function toggleModalPassword() {
  const pwd = document.getElementById('modalUserPassword');
  const icon = document.getElementById('modalPasswordEye');
  if (pwd.type === 'password') {
    pwd.type = 'text';
    icon.className = 'mdi mdi-eye-off-outline';
  } else {
    pwd.type = 'password';
    icon.className = 'mdi mdi-eye-outline';
  }
}
</script>
@endsection

