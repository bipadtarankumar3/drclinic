<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row shadow-sm">
  @php
    $isImpersonating = session()->has('impersonating_admin_id');
    $isSuperAdmin = Auth::check() && Auth::user()->isSuperAdmin() && !$isImpersonating;
    $brandRoute = $isSuperAdmin ? route('admin.saas.dashboard') : (Auth::check() && Auth::user()->clinic ? route('doctor.dashboard') : URL::to('admin/dashboard'));
    $brandTitle = $isSuperAdmin ? 'Dr Clinic' : (Auth::check() && Auth::user()->clinic ? Auth::user()->clinic->name : 'Dr Clinic');
    $brandSubtitle = $isSuperAdmin ? 'Master Administration' : (Auth::check() && Auth::user()->clinic ? (Auth::user()->clinic->city ? Auth::user()->clinic->city . ' Clinic' : 'Doctor Clinic Portal') : 'Clinic Portal');
    $brandInitial = strtoupper(substr($brandTitle, 0, 1));
    $clinic = Auth::check() && Auth::user()->clinic ? Auth::user()->clinic : null;
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
    <!-- Left: Hide Panel Toggle Button -->
    <div class="d-flex align-items-center">
      <button class="navbar-toggler navbar-toggler align-self-center btn-hide-panel" type="button" data-bs-toggle="minimize">
        <i class="mdi mdi-menu font-18"></i>
        <span class="d-none d-sm-inline">Hide Panel</span>
      </button>

      {{-- Impersonation Alert Badge in Header --}}
      @if($isImpersonating)
      <div class="d-flex align-items-center bg-danger bg-opacity-10 text-danger px-3 py-1 rounded-pill ms-3 font-12 font-weight-bold border border-danger border-opacity-25" style="gap: 6px;">
        <span class="pulse-dot"></span>
        <span>Visiting: {{ Auth::user()->clinic->name ?? 'Clinic' }}</span>
        <a href="{{ route('admin.saas.stop_impersonate') }}" class="btn btn-xs btn-danger text-white py-0 px-2 ms-2 font-11 rounded-pill shadow-none" style="text-decoration: none;">Exit to Admin</a>
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

    <!-- Mobile Toggler -->
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center ms-2" type="button" data-bs-toggle="offcanvas" style="border: none; background: transparent;">
      <span class="mdi mdi-menu font-22"></span>
    </button>
  </div>
</nav>
