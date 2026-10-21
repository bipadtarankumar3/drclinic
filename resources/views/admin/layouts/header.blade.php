<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row shadow-sm" style="border-bottom: 1px solid #e2e8f0; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(14px);">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start ps-3">
    <div class="me-3">
      <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize" style="border: none; background: transparent; color: #475569;">
        <span class="mdi mdi-menu font-22"></span>
      </button>
    </div>
    <div>
      @php
        $isImpersonating = session()->has('impersonating_admin_id');
        $isSuperAdmin = Auth::check() && Auth::user()->isSuperAdmin() && !$isImpersonating;
        $brandRoute = $isSuperAdmin ? route('admin.saas.dashboard') : (Auth::check() && Auth::user()->clinic ? route('doctor.dashboard') : URL::to('admin/dashboard'));
        $brandTitle = $isSuperAdmin ? 'Dr Clinic' : (Auth::check() && Auth::user()->clinic ? Auth::user()->clinic->name : 'Dr Clinic');
      @endphp
      <a class="brand-badge" href="{{ $brandRoute }}">
        <div class="brand-badge-icon">
          <i class="mdi {{ $isSuperAdmin ? 'mdi-hospital-building' : 'mdi-stethoscope' }}"></i>
        </div>
        <span class="d-none d-sm-inline">{{ \Illuminate\Support\Str::limit($brandTitle, 20) }}</span>
      </a>
    </div>
  </div>

  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between px-3 px-md-4">
    <ul class="navbar-nav d-flex align-items-center flex-row">
      {{-- If Admin is Impersonating a Doctor / Visiting a Clinic --}}
      @if($isImpersonating)
      <li class="nav-item d-flex align-items-center">
        <div class="d-flex align-items-center bg-warning bg-opacity-25 px-3 py-1 rounded-pill border border-warning" style="gap: 8px;">
          <span class="pulse-dot"></span>
          <span class="font-weight-bold text-dark font-13">
            <span class="text-uppercase text-danger font-11 font-weight-bold me-1">Visiting:</span>
            {{ Auth::user()->clinic->name ?? 'Clinic' }} (Dr. {{ Auth::user()->name }})
          </span>
          <a href="{{ route('admin.saas.stop_impersonate') }}" class="btn btn-danger btn-xs font-weight-bold py-1 px-3 shadow-sm text-white ms-2" style="border-radius: 20px;">
            <i class="mdi mdi-arrow-left font-weight-bold me-1"></i> Exit to Admin
          </a>
        </div>
      </li>
      @elseif($isSuperAdmin)
      {{-- Super Admin Top Platform Status --}}
      <li class="nav-item d-none d-md-flex align-items-center" style="gap: 10px;">
        <span class="badge px-3 py-2 rounded-pill font-weight-bold d-flex align-items-center shadow-sm" style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color: #fff; font-size: 12px; gap: 6px;">
          <i class="mdi mdi-shield-crown"></i> Super Admin Panel
        </span>
        <a href="{{ route('admin.saas.clinics') }}" class="btn btn-light btn-sm text-dark font-weight-bold py-1 px-3 border shadow-sm" style="border-radius: 8px; font-size: 12px;">
          <i class="mdi mdi-hospital-building text-success me-1"></i> Clinics Directory
        </a>
        <a href="{{ route('admin.saas.plans') }}" class="btn btn-light btn-sm text-dark font-weight-bold py-1 px-3 border shadow-sm" style="border-radius: 8px; font-size: 12px;">
          <i class="mdi mdi-crown text-warning me-1"></i> SaaS Plans
        </a>
      </li>
      @elseif(Auth::check() && Auth::user()->clinic)
      {{-- Doctor Active Plan Badge --}}
      <li class="nav-item d-none d-md-flex align-items-center">
        @php $clinic = Auth::user()->clinic; @endphp
        <span class="badge {{ $clinic->isPlanActive() ? 'bg-success' : 'bg-danger' }} px-3 py-2 rounded-pill font-weight-bold text-uppercase shadow-sm" style="font-size: 11px; letter-spacing: 0.5px;">
          <i class="mdi {{ $clinic->isPlanActive() ? 'mdi-check-decagram' : 'mdi-alert-circle' }} me-1"></i>
          {{ $clinic->status === 'trialing' ? '7-Day Free Trial ('.$clinic->trialDaysRemaining().'d left)' : ($clinic->isPlanActive() ? 'Plan Active' : 'Plan Expired') }}
        </span>
        <a href="{{ route('doctor.subscription.index') }}" class="btn btn-outline-primary btn-sm ms-2 py-1 px-3 font-weight-bold" style="border-radius: 8px; font-size: 12px;">
          <i class="mdi mdi-crown me-1"></i> Upgrade Plan
        </a>
      </li>
      @endif
    </ul>

    <ul class="navbar-nav ms-auto d-flex align-items-center flex-row">
      <!-- User Profile Dropdown -->
      <li class="nav-item dropdown user-dropdown ms-3">
        <a class="nav-link d-flex align-items-center p-0" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none;">
          <div class="rounded-circle d-flex align-items-center justify-content-center text-white font-weight-bold shadow-sm" style="width: 38px; height: 38px; background: linear-gradient(135deg, #4f46e5, #7c3aed); font-size: 15px;">
            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
          </div>
          <div class="ms-2 d-none d-lg-block text-start">
            <div class="font-weight-bold text-dark font-13" style="line-height: 1.2;">{{ Auth::user()->name ?? 'User' }}</div>
            <div class="text-muted font-11 text-capitalize">{{ $isImpersonating ? 'Doctor View' : (Auth::user()->user_type ?? 'User') }}</div>
          </div>
          <i class="mdi mdi-chevron-down ms-1 text-muted d-none d-lg-inline"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-end navbar-dropdown shadow-lg border-0 rounded-4 mt-2 p-2" aria-labelledby="UserDropdown" style="min-width: 230px; border-radius: 14px;">
          <div class="dropdown-header text-start pb-3 border-bottom mb-2">
            <p class="mb-0 font-weight-bold text-dark font-14">{{ Auth::user()->name }}</p>
            <p class="text-muted font-12 mb-0 text-truncate">{{ Auth::user()->email }}</p>
            <span class="badge bg-light text-primary font-11 font-weight-bold text-uppercase mt-1 px-2 py-1">
              {{ $isImpersonating ? 'Admin Impersonation' : Auth::user()->user_type }}
            </span>
          </div>

          @if($isImpersonating)
          <a class="dropdown-item py-2 px-3 rounded-3 text-danger font-weight-bold" href="{{ route('admin.saas.stop_impersonate') }}">
            <i class="mdi mdi-arrow-left-bold text-danger me-2"></i> Exit Back to Admin
          </a>
          @endif

          @if($isSuperAdmin)
          <a class="dropdown-item py-2 px-3 rounded-3" href="{{ route('admin.saas.dashboard') }}">
            <i class="mdi mdi-chart-box-outline text-primary me-2"></i> Platform Dashboard
          </a>
          <a class="dropdown-item py-2 px-3 rounded-3" href="{{ route('admin.saas.clinics') }}">
            <i class="mdi mdi-hospital-building text-success me-2"></i> Manage All Clinics
          </a>
          <a class="dropdown-item py-2 px-3 rounded-3" href="{{ URL::To('admin/setting') }}">
            <i class="mdi mdi-cog-outline text-secondary me-2"></i> Platform Settings
          </a>
          @endif

          @if(Auth::check() && Auth::user()->clinic)
          <a class="dropdown-item py-2 px-3 rounded-3" href="{{ route('doctor.dashboard') }}">
            <i class="mdi mdi-view-dashboard-outline text-primary me-2"></i> Doctor Dashboard
          </a>
          <a class="dropdown-item py-2 px-3 rounded-3" href="{{ route('doctor.subscription.index') }}">
            <i class="mdi mdi-crown text-warning me-2"></i> Plan & Billing
          </a>
          <a class="dropdown-item py-2 px-3 rounded-3" href="{{ route('doctor.settings') }}">
            <i class="mdi mdi-tune text-info me-2"></i> Clinic Settings
          </a>
          @endif

          <div class="dropdown-divider my-2"></div>
          <a class="dropdown-item py-2 px-3 rounded-3 text-danger" href="{{ URL::To('admin/logout') }}">
            <i class="mdi mdi-power text-danger me-2"></i> Sign Out
          </a>
        </div>
      </li>
    </ul>

    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center ms-2" type="button" data-bs-toggle="offcanvas" style="border: none; background: transparent;">
      <span class="mdi mdi-menu font-22"></span>
    </button>
  </div>
</nav>
