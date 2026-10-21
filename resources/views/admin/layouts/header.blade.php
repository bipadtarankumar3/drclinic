<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row shadow-sm">
  @php
    $isImpersonating = session()->has('impersonating_admin_id');
    $isSuperAdmin = Auth::check() && Auth::user()->isSuperAdmin() && !$isImpersonating;
    $activeClinic = Auth::check() ? Auth::user()->getActiveClinic() : null;
    $brandRoute = $isSuperAdmin ? route('admin.saas.dashboard') : ($activeClinic ? route('doctor.dashboard') : URL::to('admin/dashboard'));
    $brandTitle = $isSuperAdmin ? 'Dr Clinic' : ($activeClinic ? $activeClinic->name : 'Dr Clinic');
    $brandSubtitle = $isSuperAdmin ? 'Master Administration' : ($activeClinic ? ($activeClinic->city ? $activeClinic->city . ' Clinic' : 'Doctor Clinic Portal') : 'Clinic Portal');
    $brandInitial = strtoupper(substr($brandTitle, 0, 1));
    $clinic = $activeClinic;
  @endphp

  <!-- Sidebar Top Brand Header Widget -->
  <div class="navbar-brand-wrapper d-flex align-items-center justify-content-start">
    <a class="sidebar-brand-card" href="{{ $brandRoute }}">
      <div class="brand-square-avatar me-2">
        {{ $brandInitial }}
      </div>
      <div class="text-truncate flex-grow-1 text-start">
        <div class="brand-title text-truncate">{{ $brandTitle }}</div>
        <div class="brand-subtitle text-truncate">{{ $brandSubtitle }}</div>
      </div>
      <i class="mdi mdi-unfold-more-horizontal text-muted ms-1 font-16"></i>
    </a>
  </div>

  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between px-3 px-md-4">
    <!-- Left: Hide Panel Toggle Button + Impersonation Visiting Pill -->
    <div class="d-flex align-items-center">
      <button class="navbar-toggler navbar-toggler align-self-center btn-hide-panel" type="button" data-bs-toggle="minimize">
        <i class="mdi mdi-menu font-18"></i>
        <span class="d-none d-sm-inline">Hide Panel</span>
      </button>

      {{-- Impersonation Alert Badge in Header --}}
      @if($isImpersonating)
      <div class="header-visiting-pill">
        <span class="visiting-pulse-dot"></span>
        <span class="visiting-tag">VISITING CLINIC</span>
        <span class="visiting-name" title="{{ $clinic->name ?? 'Clinic' }}">{{ $clinic->name ?? 'Clinic' }}</span>
        <a href="{{ route('admin.saas.stop_impersonate') }}" class="visiting-exit-btn">
          <span>Exit to Admin</span>
          <i class="mdi mdi-close font-12 ms-1"></i>
        </a>
      </div>
      @endif
    </div>

    <!-- Right: Validity Pill, Storefront & User Dropdown -->
    <ul class="navbar-nav ms-auto d-flex align-items-center flex-row" style="gap: 12px;">
      {{-- Validity / Plan Badge Pill --}}
      @if($clinic)
        @php
          $trialDays = $clinic->trialDaysRemaining();
          $isActive = $clinic->isPlanActive();
          $validityDate = $clinic->subscription_expires_at 
            ? \Carbon\Carbon::parse($clinic->subscription_expires_at)->format('d M Y')
            : ($clinic->trial_ends_at ? \Carbon\Carbon::parse($clinic->trial_ends_at)->format('d M Y') : 'Active');
        @endphp
        <li class="nav-item d-none d-md-flex align-items-center">
          <a href="{{ route('doctor.subscription.index') }}" class="header-validity-pill">
            <span class="header-validity-dot"></span>
            <i class="mdi mdi-shield-check-outline font-15 text-success"></i>
            <span>
              @if($clinic->status === 'trialing')
                VALID UNTIL &bull; {{ $validityDate }} ({{ $trialDays }}d left)
              @elseif($isActive)
                VALID UNTIL &bull; {{ $validityDate }}
              @else
                PLAN EXPIRED &bull; Renew Now
              @endif
            </span>
            <i class="mdi mdi-chevron-right font-14"></i>
          </a>
        </li>

        {{-- Storefront Link Button --}}
        @php
          $storefrontUrl = $clinic->custom_domain 
            ? 'https://' . $clinic->custom_domain 
            : url('/c/' . ($clinic->subdomain ?? $clinic->slug));
        @endphp
        <li class="nav-item d-none d-sm-flex align-items-center">
          <a href="{{ $storefrontUrl }}" target="_blank" class="header-storefront-btn">
            <i class="mdi mdi-open-in-new font-15"></i>
            <span>Storefront</span>
          </a>
        </li>
      @elseif($isSuperAdmin)
        <li class="nav-item d-none d-md-flex align-items-center">
          <a href="{{ route('admin.saas.plans') }}" class="header-validity-pill">
            <span class="header-validity-dot"></span>
            <i class="mdi mdi-shield-crown-outline font-15 text-primary"></i>
            <span>SUPER ADMIN &bull; SaaS Platform Active</span>
            <i class="mdi mdi-chevron-right font-14"></i>
          </a>
        </li>
      @endif

      <!-- User Profile Dropdown Pill -->
      <li class="nav-item dropdown user-dropdown ms-1">
        <a class="header-user-btn" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
          <div class="header-user-avatar">
            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
          </div>
          <div class="d-none d-lg-block text-start">
            <div class="header-user-name">{{ Auth::user()->name ?? 'Admin User' }}</div>
            <div class="header-user-role">
              {{ $isImpersonating ? 'VISITING CLINIC' : ($isSuperAdmin ? 'PLATFORM ADMIN' : 'DOCTOR PORTAL') }}
            </div>
          </div>
          <i class="mdi mdi-chevron-down text-muted ms-1 d-none d-lg-inline font-16"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-end header-user-dropdown-menu shadow-lg" aria-labelledby="UserDropdown">
          {{-- Dropdown Header Info --}}
          <div class="dropdown-header text-start">
            <div class="font-weight-bold text-dark font-13">{{ Auth::user()->name }}</div>
            <div class="text-muted font-11 text-truncate mb-2">{{ Auth::user()->email }}</div>
            @if($isImpersonating)
              <span class="user-role-badge badge-visiting">VISITING: {{ $clinic->name ?? 'Clinic' }}</span>
            @elseif($isSuperAdmin)
              <span class="user-role-badge badge-super-admin">PLATFORM SUPER ADMIN</span>
            @else
              <span class="user-role-badge badge-clinic">{{ $clinic->name ?? 'DOCTOR CLINIC' }}</span>
            @endif
          </div>

          {{-- Case A: Super Admin (when NOT visiting) --}}
          @if($isSuperAdmin && !$isImpersonating)
            <a class="dropdown-item" href="{{ route('admin.saas.dashboard') }}">
              <i class="mdi mdi-chart-box-outline"></i>
              <span>Platform Analytics</span>
            </a>
            <a class="dropdown-item" href="{{ route('admin.saas.clinics') }}">
              <i class="mdi mdi-hospital-building"></i>
              <span>Doctor Clinics</span>
            </a>
            <a class="dropdown-item" href="{{ route('admin.saas.plans') }}">
              <i class="mdi mdi-package-variant-closed"></i>
              <span>Subscription Plans</span>
            </a>
            <a class="dropdown-item" href="{{ route('admin.saas.logs') }}">
              <i class="mdi mdi-history"></i>
              <span>Activity Audit Logs</span>
            </a>
            <a class="dropdown-item" href="{{ URL::To('admin/setting') }}">
              <i class="mdi mdi-cog-outline"></i>
              <span>Platform Settings</span>
            </a>

          {{-- Case B: Super Admin VISITING a clinic --}}
          @elseif($isImpersonating)
            <a class="dropdown-item" href="{{ route('doctor.dashboard') }}">
              <i class="mdi mdi-view-dashboard-outline"></i>
              <span>Doctor Dashboard</span>
            </a>
            <a class="dropdown-item" href="{{ URL::To('admin/patient') }}">
              <i class="mdi mdi-calendar-check-outline"></i>
              <span>Patient Bookings</span>
            </a>
            <a class="dropdown-item" href="{{ route('doctor.settings') }}">
              <i class="mdi mdi-tune"></i>
              <span>Clinic Settings</span>
            </a>
            @if($clinic)
            <a class="dropdown-item" target="_blank" href="{{ $storefrontUrl }}">
              <i class="mdi mdi-open-in-new"></i>
              <span>Public Storefront</span>
            </a>
            @endif
            <div class="dropdown-divider"></div>
            <a class="dropdown-item text-danger dropdown-exit-btn" href="{{ route('admin.saas.stop_impersonate') }}">
              <i class="mdi mdi-arrow-left-bold text-danger"></i>
              <span class="font-weight-bold">Exit to Super Admin</span>
            </a>

          {{-- Case C: Doctor / Clinic Owner (Normal clinic login) --}}
          @else
            <a class="dropdown-item" href="{{ route('doctor.dashboard') }}">
              <i class="mdi mdi-view-dashboard-outline"></i>
              <span>Doctor Dashboard</span>
            </a>
            <a class="dropdown-item" href="{{ URL::To('admin/patient') }}">
              <i class="mdi mdi-calendar-check-outline"></i>
              <span>Patient Bookings</span>
            </a>
            <a class="dropdown-item" href="{{ route('doctor.subscription.index') }}">
              <i class="mdi mdi-crown-outline"></i>
              <span>Plan & Billing</span>
            </a>
            <a class="dropdown-item" href="{{ route('doctor.settings') }}">
              <i class="mdi mdi-tune"></i>
              <span>Clinic Settings</span>
            </a>
            @if($clinic)
            <a class="dropdown-item" target="_blank" href="{{ $storefrontUrl }}">
              <i class="mdi mdi-open-in-new"></i>
              <span>Public Storefront</span>
            </a>
            @endif
          @endif

          <div class="dropdown-divider"></div>

          <!-- Sign Out -->
          <a class="dropdown-item text-danger" href="{{ URL::To('admin/logout') }}">
            <i class="mdi mdi-logout-variant text-danger"></i>
            <span>Sign Out</span>
          </a>
        </div>
      </li>
    </ul>

    <!-- Mobile Toggler -->
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center ms-2" type="button" data-bs-toggle="offcanvas" style="border: none; background: transparent;">
      <span class="mdi mdi-menu font-22"></span>
    </button>
  </div>
</nav>
