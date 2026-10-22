@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  <!-- Page Header -->
  <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 pb-2">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <h2 class="font-weight-bold mb-0 text-dark" style="font-size: 26px; letter-spacing: -0.5px;">Subscription Plans</h2>
        <span class="badge" style="background: var(--theme-primary-subtle, #ecfdf5); color: var(--theme-primary, #059669); border: 1px solid var(--theme-primary-border, #a7f3d0); font-weight: 700; font-size: 11px; padding: 5px 11px; border-radius: 9999px; letter-spacing: 0.5px;">COMMERCIAL TIERS</span>
      </div>
      <p class="text-muted mb-0" style="font-size: 13.5px;">Configure pricing, quotas, and feature flags. Grant extra special access to any clinic regardless of plan tier.</p>
    </div>
    <div class="d-flex align-items-center gap-2 mt-3 mt-md-0">
      <button class="btn font-weight-bold d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#grantVipModal" style="background: #ffffff; border: 1.5px solid #f59e0b; color: #d97706; padding: 9px 18px; border-radius: 10px; box-shadow: 0 1px 3px rgba(245,158,11,0.15);">
        <i class="mdi mdi-star mr-1" style="font-size: 18px; color: #f59e0b;"></i> Grant Extra Feature Access
      </button>
      <a href="{{ route('admin.saas.plan.create') }}" class="btn btn-primary font-weight-bold d-inline-flex align-items-center" style="padding: 10px 20px; border-radius: 10px;">
        <i class="mdi mdi-plus mr-1" style="font-size: 18px;"></i> Create New Plan
      </a>
    </div>
  </div>

  @if(session('success'))
  <div class="alert alert-success alert-dismissible fade show rounded-3 p-3 mb-4 shadow-sm" role="alert" style="border-left: 4px solid #10b981; background: #f0fdf4; color: #065f46;">
    <strong><i class="mdi mdi-check-circle mr-1"></i></strong> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  @if(isset($errors) && $errors->any())
  <div class="alert alert-danger rounded-3 p-3 mb-4 shadow-sm" style="border-left: 4px solid #ef4444; background: #fef2f2; color: #991b1b;">
    <ul class="mb-0">
      @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <!-- Commercial Plan Cards Grid -->
  <div class="row g-4 mb-5">
    @foreach($plans as $plan)
    <div class="col-lg-4 col-md-6 mb-4">
      <div class="card h-100 border-0 shadow-sm rounded-4" style="border: 1px solid #e2e8f0; border-radius: 18px; background: #ffffff; transition: transform 0.2s ease, box-shadow 0.2s ease;">
        <div class="card-body p-4 d-flex flex-column justify-content-between">
          <div>
            <!-- Header: Plan Name & Active Badge -->
            <div class="d-flex justify-content-between align-items-start mb-2">
              <div>
                <h4 class="font-weight-bold text-dark mb-1" style="font-size: 19px;">{{ $plan->name }}</h4>
                <p class="text-muted mb-0 font-13" style="min-height: 38px; line-height: 1.4;">{{ $plan->description ?? 'Subscription tier for practicing doctors and clinics.' }}</p>
              </div>
              @if($plan->is_active)
                <span class="badge" style="background: #059669; color: #fff; font-size: 10.5px; font-weight: 700; letter-spacing: 0.5px; padding: 5px 10px; border-radius: 9999px;">ACTIVE TIER</span>
              @else
                <span class="badge" style="background: #94a3b8; color: #fff; font-size: 10.5px; font-weight: 700; letter-spacing: 0.5px; padding: 5px 10px; border-radius: 9999px;">INACTIVE TIER</span>
              @endif
            </div>

            <!-- Pricing Box -->
            <div class="rounded-3 p-3 my-3 d-flex justify-content-between align-items-baseline" style="background: #f8fafc; border: 1px solid #edf2f7; border-radius: 12px;">
              <div>
                <span class="h3 font-weight-bold text-dark mb-0">₹{{ number_format($plan->price, 2) }}</span>
                <span class="text-muted font-12">/mo</span>
              </div>
              <div class="text-end">
                <div class="font-weight-bold text-dark font-13">₹{{ number_format($plan->annual_price ?: ($plan->price * 10), 2) }}</div>
                <div class="text-muted" style="font-size: 11px;">/yr billed annually</div>
              </div>
            </div>

            <!-- Resource Allocations & Quotas List -->
            <div class="py-2 mb-3" style="font-size: 13px; line-height: 2.1;">
              <div class="d-flex justify-content-between text-muted border-bottom py-1" style="border-color: #f1f5f9 !important;">
                <span>Trial Period:</span>
                <strong class="text-dark">{{ $plan->trial_days ?? 14 }} Days</strong>
              </div>
              <div class="d-flex justify-content-between text-muted border-bottom py-1" style="border-color: #f1f5f9 !important;">
                <span>Staff Team Accounts:</span>
                <strong class="text-dark">{{ $plan->max_staff ?? 3 }} Staff</strong>
              </div>
              <div class="d-flex justify-content-between text-muted border-bottom py-1" style="border-color: #f1f5f9 !important;">
                <span>Monthly Bookings:</span>
                <strong class="text-dark">{{ number_format($plan->max_bookings ?? 50) }} Appointments</strong>
              </div>
              <div class="d-flex justify-content-between text-muted py-1">
                <span>Cloud Media Storage:</span>
                <strong class="text-dark">{{ ($plan->storage_quota_mb ?? 1024) >= 1024 ? round(($plan->storage_quota_mb ?? 1024)/1024, 1).' GB' : ($plan->storage_quota_mb ?? 1024).' MB' }}</strong>
              </div>
            </div>

            <!-- Entitled Feature Badges -->
            <div class="mb-4">
              <div class="text-muted font-weight-bold text-uppercase mb-2" style="font-size: 10.5px; letter-spacing: 0.6px;">ENTITLED FEATURES:</div>
              <div class="d-flex flex-wrap gap-1">
                @php
                  $planFeatureKeys = is_array($plan->features) ? $plan->features : [];
                @endphp
                @forelse($planFeatureKeys as $fKey)
                  @php
                    $fMeta = $features[$fKey] ?? null;
                    $label = $fMeta['name'] ?? ucwords(str_replace('_', ' ', $fKey));
                  @endphp
                  <span class="badge" style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; font-size: 10.5px; font-weight: 600; padding: 4px 8px; border-radius: 6px;">
                    {{ $label }}
                  </span>
                @empty
                  <span class="text-muted font-12 fst-italic">No features enabled</span>
                @endforelse
              </div>
            </div>
          </div>

          <!-- Bottom Actions -->
          <div class="d-flex justify-content-between align-items-center pt-3 border-top" style="border-color: #f1f5f9 !important;">
            <div class="font-weight-bold text-dark font-13">
              {{ $plan->active_clinics_count ?? 0 }} Showrooms / Clinics
            </div>
            <div class="d-flex gap-2">
              <form action="{{ route('admin.saas.plan.toggle_status', $plan->id) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-secondary font-weight-bold px-3" style="border-radius: 8px;">
                  {{ $plan->is_active ? 'Deactivate' : 'Activate' }}
                </button>
              </form>
              <a href="{{ route('admin.saas.plan.edit', $plan->id) }}" class="btn btn-sm btn-primary font-weight-bold px-3" style="border-radius: 8px;">
                Edit
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  <!-- Lower Section: Clinic Special Feature Access & VIP Grants -->
  <div class="card border-0 shadow-sm rounded-4 mb-4" style="border-radius: 18px; border: 1px solid #e2e8f0; background: #ffffff;">
    <div class="card-body p-4">
      <div class="d-flex justify-content-between align-items-center flex-wrap mb-3 pb-2 border-bottom" style="border-color: #f1f5f9 !important;">
        <div>
          <h4 class="font-weight-bold text-dark mb-1 d-flex align-items-center" style="font-size: 18px;">
            <span class="mr-2" style="color: #f59e0b; font-size: 16px;">●</span> Clinic Special Feature Access & VIP Grants
          </h4>
          <p class="text-muted mb-0 font-13">
            Grant extra access of any feature (Advanced Analytics, Tele-Consultation, Custom Domains, etc.) to specific clinics regardless of their current subscription tier.
          </p>
        </div>
        <button class="btn font-weight-bold text-white mt-2 mt-md-0" data-bs-toggle="modal" data-bs-target="#grantVipModal" style="background: #f59e0b; border: none; padding: 8px 18px; border-radius: 9px; box-shadow: 0 2px 5px rgba(245,158,11,0.25);">
          <i class="mdi mdi-plus mr-1"></i> Grant Extra Access to a Clinic
        </button>
      </div>

      <!-- VIP Grants Table -->
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="border-collapse: separate; border-spacing: 0;">
          <thead style="background: #f8fafc; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b;">
            <tr>
              <th class="py-3 px-3 border-0">CLINIC & OWNER</th>
              <th class="py-3 px-3 border-0">SUBSCRIBED PLAN</th>
              <th class="py-3 px-3 border-0">SPECIAL GRANTED FEATURES</th>
              <th class="py-3 px-3 border-0">CUSTOM QUOTAS</th>
              <th class="py-3 px-3 border-0 text-end">ACTIONS</th>
            </tr>
          </thead>
          <tbody style="font-size: 13.5px;">
            @forelse($allClinics as $clinic)
              @php
                $hasVip = !empty($clinic->extra_features) || !empty($clinic->custom_quotas);
                $currPlan = $clinic->getCurrentPlan();
              @endphp
              @if($hasVip || $loop->iteration <= 4)
              <tr style="border-bottom: 1px solid #f1f5f9;">
                <td class="py-3 px-3">
                  <div class="font-weight-bold text-dark">{{ $clinic->name }}</div>
                  <div class="text-muted font-12">
                    Owner: {{ $clinic->user->name ?? 'Unassigned' }} ({{ $clinic->user->email ?? 'N/A' }})
                  </div>
                </td>
                <td class="py-3 px-3">
                  @if($clinic->activeSubscription && $clinic->activeSubscription->plan)
                    <span class="badge" style="background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; font-weight: 600; padding: 5px 10px; border-radius: 6px;">
                      {{ $clinic->activeSubscription->plan->name }}
                    </span>
                  @elseif($clinic->status === 'trialing')
                    <span class="badge" style="background: #fef3c7; color: #92400e; border: 1px solid #fde68a; font-weight: 600; padding: 5px 10px; border-radius: 6px;">
                      Starter Plan (Trial)
                    </span>
                  @else
                    <span class="badge" style="background: #f1f5f9; color: #475569; font-weight: 600; padding: 5px 10px; border-radius: 6px;">
                      {{ $currPlan->name ?? 'Standard Plan' }}
                    </span>
                  @endif
                </td>
                <td class="py-3 px-3">
                  @if(!empty($clinic->extra_features) && count($clinic->extra_features) > 0)
                    <div class="d-flex flex-wrap gap-1">
                      @foreach($clinic->extra_features as $ef)
                        @php
                          $efName = $features[$ef]['name'] ?? ucwords(str_replace('_', ' ', $ef));
                        @endphp
                        <span class="badge" style="background: #fefce8; color: #854d0e; border: 1px solid #fef08a; font-weight: 600; font-size: 11px; padding: 4px 8px; border-radius: 6px;">
                          ⭐ {{ $efName }} (VIP Grant)
                        </span>
                      @endforeach
                    </div>
                  @else
                    <span class="text-muted font-12">No VIP overrides</span>
                  @endif
                </td>
                <td class="py-3 px-3">
                  @if(!empty($clinic->custom_quotas))
                    <div class="font-12 text-dark font-weight-bold">
                      @if(isset($clinic->custom_quotas['max_staff'])) Staff: {{ $clinic->custom_quotas['max_staff'] }} | @endif
                      @if(isset($clinic->custom_quotas['max_bookings'])) Bookings: {{ $clinic->custom_quotas['max_bookings'] }} | @endif
                      @if(isset($clinic->custom_quotas['storage_quota_mb'])) Storage: {{ round($clinic->custom_quotas['storage_quota_mb']/1024, 1) }} GB @endif
                    </div>
                  @else
                    <span class="text-muted font-12">Default Plan Limits</span>
                  @endif
                </td>
                <td class="py-3 px-3 text-end">
                  <div class="d-inline-flex gap-1">
                    <button class="btn btn-sm btn-outline-secondary font-weight-bold" data-bs-toggle="modal" data-bs-target="#editVipModal{{ $clinic->id }}" style="border-radius: 7px; font-size: 12px; padding: 5px 11px;">
                      Edit Overrides
                    </button>
                    @if($hasVip)
                    <form action="{{ route('admin.saas.clinic.revoke_extra_access', $clinic->id) }}" method="POST" onsubmit="return confirm('Revoke all VIP extra access and custom quotas for {{ $clinic->name }}?');" style="display:inline;">
                      @csrf
                      <button type="submit" class="btn btn-sm btn-outline-danger font-weight-bold" style="border-radius: 7px; font-size: 12px; padding: 5px 10px;" title="Revoke VIP Overrides">
                        Revoke
                      </button>
                    </form>
                    @endif
                  </div>
                </td>
              </tr>

              <!-- Per-Clinic VIP Edit Modal -->
              <div class="modal fade" id="editVipModal{{ $clinic->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                  <div class="modal-content border-0 rounded-4 shadow">
                    <form action="{{ route('admin.saas.clinic.extra_access', $clinic->id) }}" method="POST">
                      @csrf
                      <div class="modal-header border-0 pb-0">
                        <div>
                          <h5 class="modal-title font-weight-bold text-dark">VIP Feature & Quota Overrides: {{ $clinic->name }}</h5>
                          <p class="text-muted font-13 mb-0">Grant permissions and quota limits beyond their current subscribed plan.</p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body p-4">
                        <!-- Current Subscribed Plan Info -->
                        <div class="p-3 mb-4 rounded-3 d-flex justify-content-between align-items-center" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                          <div>
                            <span class="text-muted font-12 font-weight-bold text-uppercase">Current Base Plan</span>
                            <div class="font-weight-bold text-dark">{{ $currPlan->name ?? 'Standard Plan' }}</div>
                          </div>
                          <div>
                            <span class="text-muted font-12 font-weight-bold text-uppercase">Clinic Subdomain</span>
                            <div class="font-weight-bold text-primary">{{ $clinic->subdomain }}.{{ request()->getHost() }}</div>
                          </div>
                        </div>

                        <!-- Checkbox Feature Grid -->
                        <label class="form-label font-weight-bold text-dark mb-2">⭐ Grant Extra Special Features (Unconditional Access)</label>
                        <div class="row g-2 mb-4">
                          @foreach($features as $fKey => $fData)
                            @php
                              $isGranted = !empty($clinic->extra_features) && in_array($fKey, $clinic->extra_features);
                              $isPlanDefault = $currPlan && is_array($currPlan->features) && in_array($fKey, $currPlan->features);
                            @endphp
                            <div class="col-md-6">
                              <label class="d-flex align-items-start p-3 rounded-3 h-100 cursor-pointer" style="border: 1px solid {{ $isGranted ? '#f59e0b' : '#e2e8f0' }}; background: {{ $isGranted ? '#fffbeb' : '#ffffff' }};">
                                <input type="checkbox" name="extra_features[]" value="{{ $fKey }}" class="form-check-input mt-1 mr-2" {{ $isGranted ? 'checked' : '' }}>
                                <div class="ml-2">
                                  <div class="font-weight-bold text-dark font-13">
                                    {{ $fData['name'] }}
                                    @if($isPlanDefault)
                                      <span class="badge bg-light text-muted font-10">Included in plan</span>
                                    @endif
                                  </div>
                                  <div class="text-muted font-12">{{ $fData['desc'] }}</div>
                                </div>
                              </label>
                            </div>
                          @endforeach
                        </div>

                        <!-- Custom Quotas -->
                        <label class="form-label font-weight-bold text-dark mb-2">Custom Quota Limits (Leave empty to use base plan defaults)</label>
                        <div class="row g-3">
                          <div class="col-md-4">
                            <label class="form-label font-12 text-muted">Max Staff Accounts</label>
                            <input type="number" class="form-control" name="custom_staff" value="{{ $clinic->custom_quotas['max_staff'] ?? '' }}" placeholder="Default: {{ $currPlan->max_staff ?? 3 }}">
                          </div>
                          <div class="col-md-4">
                            <label class="form-label font-12 text-muted">Monthly Bookings</label>
                            <input type="number" class="form-control" name="custom_bookings" value="{{ $clinic->custom_quotas['max_bookings'] ?? '' }}" placeholder="Default: {{ $currPlan->max_bookings ?? 50 }}">
                          </div>
                          <div class="col-md-4">
                            <label class="form-label font-12 text-muted">Storage Quota (MB)</label>
                            <input type="number" class="form-control" name="custom_storage" value="{{ $clinic->custom_quotas['storage_quota_mb'] ?? '' }}" placeholder="Default: {{ $currPlan->storage_quota_mb ?? 1024 }}">
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-secondary font-weight-bold" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn font-weight-bold text-white" style="background: #f59e0b; border: none; border-radius: 8px;">
                          Save VIP Overrides
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              @endif
            @empty
              <tr>
                <td colspan="5" class="text-center py-4 text-muted">No clinics registered yet.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal: Grant VIP Access To Any Clinic -->
<div class="modal fade" id="grantVipModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 rounded-4 shadow">
      <div class="modal-header border-0 pb-0">
        <div>
          <h5 class="modal-title font-weight-bold text-dark"><i class="mdi mdi-star text-warning mr-1"></i> Grant Special VIP Feature Access to Clinic</h5>
          <p class="text-muted font-13 mb-0">Select a clinic and grant any platform feature or higher resource quota directly.</p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <div class="mb-4">
          <label class="form-label font-weight-bold text-dark">Select Clinic *</label>
          <select id="vipClinicSelect" class="form-select font-weight-bold" onchange="switchVipClinic(this.value)">
            <option value="">-- Choose Clinic --</option>
            @foreach($allClinics as $c)
              <option value="{{ $c->id }}" data-action="{{ route('admin.saas.clinic.extra_access', $c->id) }}">
                {{ $c->name }} ({{ $c->user->name ?? 'User' }} - {{ $c->subdomain }})
              </option>
            @endforeach
          </select>
        </div>

        <form id="globalVipForm" method="POST" action="">
          @csrf
          <!-- Feature Checkbox Grid -->
          <label class="form-label font-weight-bold text-dark mb-2">⭐ Entitled VIP Feature Access</label>
          <div class="row g-2 mb-4">
            @foreach($features as $fKey => $fData)
              <div class="col-md-6">
                <label class="d-flex align-items-start p-3 rounded-3 h-100 cursor-pointer" style="border: 1px solid #e2e8f0; background: #ffffff;">
                  <input type="checkbox" name="extra_features[]" value="{{ $fKey }}" class="form-check-input mt-1 mr-2">
                  <div class="ml-2">
                    <div class="font-weight-bold text-dark font-13">{{ $fData['name'] }}</div>
                    <div class="text-muted font-12">{{ $fData['desc'] }}</div>
                  </div>
                </label>
              </div>
            @endforeach
          </div>

          <!-- Custom Quotas -->
          <label class="form-label font-weight-bold text-dark mb-2">Custom Quota Overrides (Optional)</label>
          <div class="row g-3 mb-3">
            <div class="col-md-4">
              <label class="form-label font-12 text-muted">Max Staff Accounts</label>
              <input type="number" class="form-control" name="custom_staff" placeholder="e.g. 15">
            </div>
            <div class="col-md-4">
              <label class="form-label font-12 text-muted">Monthly Bookings</label>
              <input type="number" class="form-control" name="custom_bookings" placeholder="e.g. 500">
            </div>
            <div class="col-md-4">
              <label class="form-label font-12 text-muted">Storage Quota (MB)</label>
              <input type="number" class="form-control" name="custom_storage" placeholder="e.g. 10240">
            </div>
          </div>

          <div class="modal-footer border-0 pt-3 px-0">
            <button type="button" class="btn btn-secondary font-weight-bold" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" id="saveVipBtn" class="btn font-weight-bold text-white" style="background: #f59e0b; border: none; border-radius: 8px;" disabled>
              Save VIP Extra Access
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
function switchVipClinic(clinicId) {
  const form = document.getElementById('globalVipForm');
  const btn = document.getElementById('saveVipBtn');
  const select = document.getElementById('vipClinicSelect');
  const selectedOpt = select.options[select.selectedIndex];

  if (clinicId && selectedOpt) {
    form.action = selectedOpt.getAttribute('data-action');
    btn.disabled = false;
  } else {
    form.action = '';
    btn.disabled = true;
  }
}
</script>
@endsection
