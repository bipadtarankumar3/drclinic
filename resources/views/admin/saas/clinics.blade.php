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

  <!-- 1. Clinic Summary Count KPI Cards -->
  <div class="row g-3 mb-4">
    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
      <a href="{{ route('admin.saas.clinics') }}" class="card border-0 shadow-sm rounded-4 text-decoration-none h-100 {{ !request()->hasAny(['status', 'date_preset', 'plan_id']) ? 'border-primary' : '' }}" style="border-radius: 16px; background: #ffffff; border: 1.5px solid #e2e8f0; transition: transform 0.15s ease, box-shadow 0.15s ease;">
        <div class="card-body p-3">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="text-muted font-11 font-weight-bold text-uppercase" style="letter-spacing: 0.5px;">Total Clinics</span>
            <div style="width: 32px; height: 32px; border-radius: 8px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center; font-size: 16px;">
              <i class="mdi mdi-hospital-building"></i>
            </div>
          </div>
          <h3 class="font-weight-bold text-dark mb-0 font-22">{{ number_format($counts['total']) }}</h3>
          <small class="text-muted font-11">All-time database</small>
        </div>
      </a>
    </div>

    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
      <a href="{{ route('admin.saas.clinics', ['status' => 'active']) }}" class="card border-0 shadow-sm rounded-4 text-decoration-none h-100" style="border-radius: 16px; background: #ffffff; border: 1.5px solid {{ request('status') == 'active' ? '#10b981' : '#e2e8f0' }}; transition: transform 0.15s ease, box-shadow 0.15s ease;">
        <div class="card-body p-3">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="text-muted font-11 font-weight-bold text-uppercase" style="letter-spacing: 0.5px;">Active</span>
            <div style="width: 32px; height: 32px; border-radius: 8px; background: #f0fdf4; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 16px;">
              <i class="mdi mdi-check-decagram"></i>
            </div>
          </div>
          <h3 class="font-weight-bold text-success mb-0 font-22">{{ number_format($counts['active']) }}</h3>
          <small class="text-muted font-11">Live practices</small>
        </div>
      </a>
    </div>

    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6">
      <a href="{{ route('admin.saas.clinics', ['status' => 'trialing']) }}" class="card border-0 shadow-sm rounded-4 text-decoration-none h-100" style="border-radius: 16px; background: #ffffff; border: 1.5px solid {{ request('status') == 'trialing' ? '#f59e0b' : '#e2e8f0' }}; transition: transform 0.15s ease, box-shadow 0.15s ease;">
        <div class="card-body p-3">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="text-muted font-11 font-weight-bold text-uppercase" style="letter-spacing: 0.5px;">Free Trials</span>
            <div style="width: 32px; height: 32px; border-radius: 8px; background: #fffbeb; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 16px;">
              <i class="mdi mdi-clock-fast"></i>
            </div>
          </div>
          <h3 class="font-weight-bold text-warning mb-0 font-22">{{ number_format($counts['trialing']) }}</h3>
          <small class="text-muted font-11">Trial evaluation</small>
        </div>
      </a>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
      <a href="{{ route('admin.saas.clinics', ['date_preset' => 'last_7_days']) }}" class="card border-0 shadow-sm rounded-4 text-decoration-none h-100" style="border-radius: 16px; background: #ffffff; border: 1.5px solid {{ request('date_preset') == 'last_7_days' ? '#06b6d4' : '#e2e8f0' }}; transition: transform 0.15s ease, box-shadow 0.15s ease;">
        <div class="card-body p-3">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="text-muted font-11 font-weight-bold text-uppercase" style="letter-spacing: 0.5px;">New This Week</span>
            <div style="width: 32px; height: 32px; border-radius: 8px; background: #ecfeff; color: #0891b2; display: flex; align-items: center; justify-content: center; font-size: 16px;">
              <i class="mdi mdi-calendar-plus"></i>
            </div>
          </div>
          <div class="d-flex align-items-baseline gap-2">
            <h3 class="font-weight-bold text-dark mb-0 font-22">{{ number_format($counts['this_week']) }}</h3>
            <span class="badge" style="background: #e0f2fe; color: #0284c7; font-size: 11px; font-weight: 700;">{{ $counts['today'] }} Today</span>
          </div>
          <small class="text-muted font-11">Recent 7-day signups</small>
        </div>
      </a>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
      <a href="{{ route('admin.saas.clinics', ['status' => 'expired']) }}" class="card border-0 shadow-sm rounded-4 text-decoration-none h-100" style="border-radius: 16px; background: #ffffff; border: 1.5px solid {{ request('status') == 'expired' ? '#ef4444' : '#e2e8f0' }}; transition: transform 0.15s ease, box-shadow 0.15s ease;">
        <div class="card-body p-3">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="text-muted font-11 font-weight-bold text-uppercase" style="letter-spacing: 0.5px;">Expired / Suspended</span>
            <div style="width: 32px; height: 32px; border-radius: 8px; background: #fef2f2; color: #dc2626; display: flex; align-items: center; justify-content: center; font-size: 16px;">
              <i class="mdi mdi-alert-circle-outline"></i>
            </div>
          </div>
          <h3 class="font-weight-bold text-danger mb-0 font-22">{{ number_format($counts['expired']) }}</h3>
          <small class="text-muted font-11">Inactive accounts</small>
        </div>
      </a>
    </div>
  </div>

  <!-- 2. Filters & Day-Wise Search Form -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="card border-0 shadow-sm rounded-4" style="border-radius: 16px; background: #ffffff; border: 1.5px solid #e2e8f0;">
        <div class="card-body p-4">
          <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom" style="border-color: #f1f5f9 !important;">
            <div class="d-flex align-items-center gap-2">
              <i class="mdi mdi-filter-variant text-primary font-18"></i>
              <h6 class="font-weight-bold text-dark mb-0 font-14">Search &amp; Day-Wise Date Filters</h6>
            </div>
            @if(request()->hasAny(['search', 'status', 'plan_id', 'date_preset', 'from_date', 'to_date']))
              <a href="{{ route('admin.saas.clinics') }}" class="text-danger font-12 font-weight-bold text-decoration-none d-flex align-items-center gap-1">
                <i class="mdi mdi-close-circle-outline"></i> Clear All Filters
              </a>
            @endif
          </div>

          <form method="GET" action="{{ route('admin.saas.clinics') }}">
            <div class="row g-3 align-items-end">
              <!-- Search Query Input -->
              <div class="col-lg-4 col-md-6">
                <label class="form-label font-weight-bold text-muted font-11 text-uppercase mb-1" style="letter-spacing: 0.4px;">Keyword Search</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0 text-muted"><i class="mdi mdi-magnify font-16"></i></span>
                  <input type="text" name="search" class="form-control border-start-0 font-13" placeholder="Clinic name, doctor, subdomain, phone, email..." value="{{ request('search') }}" style="height: 42px; border-radius: 0 8px 8px 0;">
                </div>
              </div>

              <!-- Status Dropdown -->
              <div class="col-lg-2 col-md-3 col-sm-6">
                <label class="form-label font-weight-bold text-muted font-11 text-uppercase mb-1" style="letter-spacing: 0.4px;">Clinic Status</label>
                <select name="status" class="form-select font-13" style="height: 42px; border-radius: 8px;">
                  <option value="">All Statuses ({{ $counts['total'] }})</option>
                  <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active ({{ $counts['active'] }})</option>
                  <option value="trialing" {{ request('status') == 'trialing' ? 'selected' : '' }}>Trialing ({{ $counts['trialing'] }})</option>
                  <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired ({{ $counts['expired'] }})</option>
                  <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
              </div>

              <!-- Subscription Plan Dropdown -->
              <div class="col-lg-2 col-md-3 col-sm-6">
                <label class="form-label font-weight-bold text-muted font-11 text-uppercase mb-1" style="letter-spacing: 0.4px;">Subscription Plan</label>
                <select name="plan_id" class="form-select font-13" style="height: 42px; border-radius: 8px;">
                  <option value="">All Plans</option>
                  @foreach($plans as $p)
                    <option value="{{ $p->id }}" {{ request('plan_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                  @endforeach
                </select>
              </div>

              <!-- Day-Wise Date Preset -->
              <div class="col-lg-2 col-md-4 col-sm-6">
                <label class="form-label font-weight-bold text-muted font-11 text-uppercase mb-1" style="letter-spacing: 0.4px;">Day-Wise Filter</label>
                <select name="date_preset" id="datePresetSelect" class="form-select font-13" style="height: 42px; border-radius: 8px;" onchange="toggleCustomDateInputs(this.value)">
                  <option value="">All Dates</option>
                  <option value="today" {{ request('date_preset') == 'today' ? 'selected' : '' }}>Today ({{ $counts['today'] }})</option>
                  <option value="yesterday" {{ request('date_preset') == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                  <option value="last_7_days" {{ request('date_preset') == 'last_7_days' ? 'selected' : '' }}>Last 7 Days ({{ $counts['this_week'] }})</option>
                  <option value="this_month" {{ request('date_preset') == 'this_month' ? 'selected' : '' }}>This Month ({{ $counts['this_month'] }})</option>
                  <option value="last_30_days" {{ request('date_preset') == 'last_30_days' ? 'selected' : '' }}>Last 30 Days</option>
                  <option value="custom" {{ request('date_preset') == 'custom' || request()->filled('from_date') || request()->filled('to_date') ? 'selected' : '' }}>Custom Date Range</option>
                </select>
              </div>

              <!-- Actions Buttons -->
              <div class="col-lg-2 col-md-4 col-sm-6 d-flex gap-2">
                <button type="submit" class="btn btn-primary font-weight-bold flex-grow-1 d-flex align-items-center justify-content-center gap-1" style="height: 42px; border-radius: 8px;">
                  <i class="mdi mdi-filter"></i> Apply
                </button>
                <a href="{{ route('admin.saas.clinics') }}" class="btn btn-outline-secondary font-weight-bold d-flex align-items-center justify-content-center" title="Reset All Filters" style="height: 42px; width: 44px; border-radius: 8px;">
                  <i class="mdi mdi-refresh font-18"></i>
                </a>
              </div>
            </div>

            <!-- Custom Date Range Expandable Inputs -->
            <div id="customDateRow" class="row g-3 mt-1 pt-3 border-top {{ request('date_preset') == 'custom' || request()->filled('from_date') || request()->filled('to_date') ? '' : 'd-none' }}" style="border-color: #f1f5f9 !important;">
              <div class="col-md-3">
                <label class="form-label font-weight-bold text-muted font-11 text-uppercase mb-1">Registered From Date</label>
                <input type="date" name="from_date" class="form-control font-13" value="{{ request('from_date') }}" style="height: 40px; border-radius: 8px;">
              </div>
              <div class="col-md-3">
                <label class="form-label font-weight-bold text-muted font-11 text-uppercase mb-1">Registered To Date</label>
                <input type="date" name="to_date" class="form-control font-13" value="{{ request('to_date') }}" style="height: 40px; border-radius: 8px;">
              </div>
              <div class="col-md-6 d-flex align-items-center pt-md-4">
                <small class="text-muted"><i class="mdi mdi-information-outline text-primary mr-1"></i> Filter clinic accounts registered between the specified dates.</small>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- 3. Results Header & Count Indicator -->
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3 px-1">
    <div class="d-flex align-items-center flex-wrap gap-2">
      <span class="font-weight-bold text-dark font-14">
        Showing <span class="text-primary">{{ $clinics->firstItem() ?? 0 }} - {{ $clinics->lastItem() ?? 0 }}</span> of <span class="text-primary">{{ $clinics->total() }}</span> clinics
      </span>

      @if(request()->hasAny(['search', 'status', 'plan_id', 'date_preset', 'from_date', 'to_date']))
        <span class="badge" style="background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; font-size: 11px; padding: 4px 8px; border-radius: 12px;">
          Filtered from {{ $counts['total'] }} total
        </span>

        @if(request('search'))
          <span class="badge bg-light text-dark font-11 border d-inline-flex align-items-center gap-1">
            Keyword: "{{ request('search') }}"
            <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="text-danger text-decoration-none">&times;</a>
          </span>
        @endif

        @if(request('status'))
          <span class="badge bg-light text-dark font-11 border d-inline-flex align-items-center gap-1">
            Status: {{ ucfirst(request('status')) }}
            <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}" class="text-danger text-decoration-none">&times;</a>
          </span>
        @endif

        @if(request('date_preset'))
          <span class="badge bg-light text-dark font-11 border d-inline-flex align-items-center gap-1">
            Date: {{ str_replace('_', ' ', ucfirst(request('date_preset'))) }}
            <a href="{{ request()->fullUrlWithQuery(['date_preset' => null]) }}" class="text-danger text-decoration-none">&times;</a>
          </span>
        @endif

        @if(request('from_date') || request('to_date'))
          <span class="badge bg-light text-dark font-11 border d-inline-flex align-items-center gap-1">
            Dates: {{ request('from_date') ?? 'Any' }} &rarr; {{ request('to_date') ?? 'Any' }}
            <a href="{{ request()->fullUrlWithQuery(['from_date' => null, 'to_date' => null]) }}" class="text-danger text-decoration-none">&times;</a>
          </span>
        @endif
      @endif
    </div>

    <div>
      <span class="text-muted font-12"><i class="mdi mdi-clock-outline mr-1"></i> Auto-sorted by newest registration</span>
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
                    <div class="font-11 text-muted mt-1">
                      <i class="mdi mdi-calendar-check text-success mr-1"></i> Registered: <strong class="text-dark">{{ $c->created_at ? $c->created_at->format('d M Y') : 'N/A' }}</strong> <span class="text-secondary font-10">({{ $c->created_at ? $c->created_at->diffForHumans() : '' }})</span>
                    </div>
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
          <div class="d-flex align-items-center justify-content-center rounded-3 shadow-sm" style="width: 44px; height: 44px; background: var(--theme-primary-gradient, linear-gradient(135deg, #059669, #10b981)); color: #ffffff; flex-shrink: 0;">
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
                <span class="me-2" style="color: var(--theme-primary, #059669); font-size: 16px;">●</span> Clinic Profile &amp; Storefront
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
            <button type="submit" class="btn btn-primary font-weight-bold text-white px-4 py-2" style="border: none; border-radius: 8px; font-size: 13px;">
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
  background: var(--theme-primary, #059669) !important;
  color: #ffffff !important;
  box-shadow: 0 2px 6px var(--theme-primary-glow, rgba(5,150,105,0.25)) !important;
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

function toggleCustomDateInputs(val) {
  const row = document.getElementById('customDateRow');
  if (!row) return;
  if (val === 'custom') {
    row.classList.remove('d-none');
  } else {
    row.classList.add('d-none');
  }
}
</script>
@endsection

