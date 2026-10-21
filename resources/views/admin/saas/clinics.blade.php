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

  @if($errors->any())
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
    <div class="modal-content border-0 shadow-lg" style="border-radius: 18px;">
      <div class="modal-header border-bottom p-4" style="background: #fafbfc; border-radius: 18px 18px 0 0;">
        <div>
          <h5 class="modal-title font-weight-bold text-dark mb-0 d-flex align-items-center" id="createClinicModalLabel">
            <i class="mdi mdi-hospital-building text-primary me-2 font-22"></i> Create Doctor Clinic & Assign User
          </h5>
          <small class="text-muted">Set up a new doctor clinic portal and assign an owner user (type = user).</small>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form method="POST" action="{{ route('admin.saas.clinic.store') }}">
        @csrf
        <div class="modal-body p-4">
          <!-- Step 1: Clinic Information -->
          <div class="mb-4">
            <h6 class="font-weight-bold text-dark border-bottom pb-2 mb-3 d-flex align-items-center">
              <span class="badge bg-primary bg-opacity-10 text-primary me-2">1</span> Clinic Details
            </h6>
            <div class="row g-3">
              <div class="col-md-7">
                <label class="form-label font-weight-bold font-12 text-dark">Clinic Name <span class="text-danger">*</span></label>
                <input type="text" name="clinic_name" class="form-control" placeholder="e.g. Apex Multispecialty Clinic" required onkeyup="syncModalSubdomain(this.value)">
              </div>

              <div class="col-md-5">
                <label class="form-label font-weight-bold font-12 text-dark">Subdomain <span class="text-danger">*</span></label>
                <div class="input-group">
                  <input type="text" name="subdomain" id="modalSubdomain" class="form-control" placeholder="apex" required>
                  <span class="input-group-text bg-light font-11 text-muted">.{{ request()->getHost() }}</span>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label font-weight-bold font-12 text-dark">Specialization</label>
                <input type="text" name="specialization" class="form-control" placeholder="e.g. Neurology, Pediatrics">
              </div>

              <div class="col-md-6">
                <label class="form-label font-weight-bold font-12 text-dark">Consultation Fee (₹)</label>
                <input type="number" step="0.01" name="consultation_fee" class="form-control" value="500.00">
              </div>

              <div class="col-md-6">
                <label class="form-label font-weight-bold font-12 text-dark">Clinic Phone</label>
                <input type="text" name="clinic_phone" class="form-control" placeholder="+91 9876543210">
              </div>

              <div class="col-md-6">
                <label class="form-label font-weight-bold font-12 text-dark">Clinic Email</label>
                <input type="email" name="clinic_email" class="form-control" placeholder="clinic@example.com">
              </div>
            </div>
          </div>

          <!-- Step 2: User Assignment -->
          <div class="mb-4">
            <h6 class="font-weight-bold text-dark border-bottom pb-2 mb-3 d-flex align-items-center">
              <span class="badge bg-success bg-opacity-10 text-success me-2">2</span> User Assignment (type = user)
            </h6>

            <div class="btn-group w-100 mb-3" role="group">
              <input type="radio" class="btn-check" name="user_mode" id="modal_mode_new" value="new" checked onchange="toggleModalUserMode('new')">
              <label class="btn btn-outline-primary font-weight-bold btn-sm py-2" for="modal_mode_new">
                <i class="mdi mdi-account-plus me-1"></i> Create New User
              </label>

              <input type="radio" class="btn-check" name="user_mode" id="modal_mode_existing" value="existing" onchange="toggleModalUserMode('existing')">
              <label class="btn btn-outline-primary font-weight-bold btn-sm py-2" for="modal_mode_existing">
                <i class="mdi mdi-account-check me-1"></i> Link Existing User
              </label>
            </div>

            <!-- New User Section -->
            <div id="modalNewUserSection">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label font-weight-bold font-12 text-dark">Full Name <span class="text-danger">*</span></label>
                  <input type="text" name="user_name" class="form-control" placeholder="Dr. Full Name">
                </div>

                <div class="col-md-6">
                  <label class="form-label font-weight-bold font-12 text-dark">Login Email <span class="text-danger">*</span></label>
                  <input type="email" name="user_email" class="form-control" placeholder="doctor@example.com">
                </div>

                <div class="col-md-6">
                  <label class="form-label font-weight-bold font-12 text-dark">Password <span class="text-danger">*</span></label>
                  <input type="password" name="user_password" class="form-control" value="Password@123">
                </div>

                <div class="col-md-6">
                  <label class="form-label font-weight-bold font-12 text-dark">User Type <span class="text-danger">*</span></label>
                  <select name="user_type" class="form-select font-weight-bold">
                    <option value="user" selected>User (type = user)</option>
                    <option value="doctor">Doctor (type = doctor)</option>
                  </select>
                </div>
              </div>
            </div>

            <!-- Existing User Section -->
            <div id="modalExistingUserSection" style="display: none;">
              <label class="form-label font-weight-bold font-12 text-dark">Select Registered User <span class="text-danger">*</span></label>
              <select name="user_id" class="form-select font-weight-bold">
                <option value="">-- Choose User to Assign --</option>
                @foreach($availableUsers as $u)
                  <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }}) - [type: {{ $u->user_type }}]</option>
                @endforeach
              </select>
            </div>
          </div>

          <!-- Step 3: Subscription & Status -->
          <div>
            <h6 class="font-weight-bold text-dark border-bottom pb-2 mb-3 d-flex align-items-center">
              <span class="badge bg-warning bg-opacity-10 text-warning me-2">3</span> Subscription Plan & Status
            </h6>

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label font-weight-bold font-12 text-dark">Initial Status <span class="text-danger">*</span></label>
                <select name="status" class="form-select font-weight-bold">
                  <option value="trialing" selected>7-Day Free Trial (Trialing)</option>
                  <option value="active">Active Paid Account</option>
                  <option value="suspended">Suspended</option>
                </select>
              </div>

              <div class="col-md-6">
                <label class="form-label font-weight-bold font-12 text-dark">Assign Subscription Plan</label>
                <select name="plan_id" class="form-select font-weight-bold">
                  <option value="">-- No Plan / Default Trial --</option>
                  @foreach($plans as $p)
                    <option value="{{ $p->id }}">{{ $p->name }} (₹{{ number_format($p->price, 0) }})</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer border-top p-3 px-4" style="background: #fafbfc; border-radius: 0 0 18px 18px;">
          <button type="button" class="btn btn-outline-secondary font-weight-bold" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary font-weight-bold px-4 shadow-sm">
            <i class="mdi mdi-check-circle me-1"></i> Create Clinic & Assign User
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

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
  if (mode === 'new') {
    newSec.style.display = 'block';
    existSec.style.display = 'none';
  } else {
    newSec.style.display = 'none';
    existSec.style.display = 'block';
  }
}
</script>
@endsection

