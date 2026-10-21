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
        <div class="dropdown-menu dropdown-menu-end navbar-dropdown shadow-lg border-0 rounded-4 mt-2 p-2" aria-labelledby="UserDropdown" style="min-width: 260px; border-radius: 16px; border: 1px solid #f1f5f9 !important; box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08) !important;">
          <div class="dropdown-header text-start pb-3 border-bottom mb-2">
            <p class="mb-0 font-weight-bold text-dark font-14">{{ Auth::user()->name }}</p>
            <p class="text-muted font-12 mb-2 text-truncate">{{ Auth::user()->email }}</p>
            <span class="badge border border-danger text-danger bg-danger bg-opacity-10 rounded-pill font-11 px-2 py-1 text-uppercase font-weight-bold">
              {{ Auth::check() && Auth::user()->clinic ? Auth::user()->clinic->name : ($isSuperAdmin ? 'PLATFORM ADMIN' : 'DR CLINIC') }}
            </span>
          </div>

          <!-- Owner Profile & Details -->
          <a class="dropdown-item py-2 px-3 rounded-3 d-flex align-items-center" href="{{ Auth::check() && Auth::user()->clinic ? route('doctor.settings') : URL::To('admin/profile') }}" style="font-size: 13px; font-weight: 500; color: #334155;">
            <i class="mdi mdi-account-circle-outline me-2 font-17 text-muted"></i>
            <span>Owner Profile & Details</span>
          </a>

          <!-- Hide Side Panel Toggle -->
          <a class="dropdown-item py-2 px-3 rounded-3 d-flex align-items-center justify-content-between" href="javascript:void(0)" onclick="$('[data-bs-toggle=\'minimize\']').first().click();" style="font-size: 13px; font-weight: 500; color: #334155;">
            <span class="d-flex align-items-center">
              <i class="mdi mdi-menu me-2 font-17 text-muted"></i>
              <span>Hide Side Panel</span>
            </span>
            <span class="badge bg-light text-muted font-10 px-2 py-1 border" style="font-size: 10px; font-weight: 600;">Toggle</span>
          </a>

          <!-- Help & Support Hub -->
          <a class="dropdown-item py-2 px-3 rounded-3 d-flex align-items-center" href="{{ URL::To('admin/contact') }}" style="font-size: 13px; font-weight: 500; color: #334155;">
            <i class="mdi mdi-headphones me-2 font-17 text-muted"></i>
            <span>Help & Support Hub</span>
          </a>

          <!-- Public Storefront -->
          @if($clinic)
          <a class="dropdown-item py-2 px-3 rounded-3 d-flex align-items-center" target="_blank" href="{{ $storefrontUrl }}" style="font-size: 13px; font-weight: 500; color: #334155;">
            <i class="mdi mdi-open-in-new me-2 font-17 text-muted"></i>
            <span>Public Storefront</span>
          </a>
          @endif

          <!-- Super Admin Console -->
          @if($isSuperAdmin || $isImpersonating)
          <a class="dropdown-item py-2 px-3 rounded-3 d-flex align-items-center text-danger font-weight-bold" href="{{ $isImpersonating ? route('admin.saas.stop_impersonate') : route('admin.saas.dashboard') }}" style="font-size: 13px; color: #ea580c !important;">
            <i class="mdi mdi-lightning-bolt me-2 font-17 text-warning"></i>
            <span>{{ $isImpersonating ? 'Exit to Super Admin' : 'Super Admin Console' }}</span>
          </a>
          @endif

          <div class="dropdown-divider my-2"></div>

          <!-- Sign Out -->
          <a class="dropdown-item py-2 px-3 rounded-3 text-danger font-weight-bold d-flex align-items-center" href="{{ URL::To('admin/logout') }}" style="font-size: 13px;">
            <i class="mdi mdi-logout-variant text-danger me-2 font-17"></i>
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
