<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    {{-- ========================================================================= --}}
    {{-- CASE 1: SUPER ADMIN (When NOT visiting a clinic)                          --}}
    {{-- Super Admin sees ONLY his Platform Admin menu                             --}}
    {{-- ========================================================================= --}}
    @if(Auth::check() && Auth::user()->isSuperAdmin() && !session('impersonating_admin_id'))
    <li class="nav-item nav-category">
      <span>MAIN</span>
    </li>

    <li class="nav-item {{ request()->routeIs('admin.saas.dashboard') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.saas.dashboard') }}">
        <i class="mdi mdi-chart-box-outline nav-icon"></i>
        <span class="menu-title">Platform Analytics</span>
        @if(request()->routeIs('admin.saas.dashboard'))
        <i class="mdi mdi-chevron-right nav-chevron"></i>
        @endif
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('admin.saas.clinics*') || request()->routeIs('admin.saas.clinic.*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.saas.clinics') }}">
        <i class="mdi mdi-hospital-building nav-icon"></i>
        <span class="menu-title">All Doctor Clinics</span>
        @if(request()->routeIs('admin.saas.clinics*') || request()->routeIs('admin.saas.clinic.*'))
        <i class="mdi mdi-chevron-right nav-chevron"></i>
        @endif
      </a>
    </li>

    <li class="nav-item nav-category">
      <span>OPERATIONS</span>
      <span class="category-action">+</span>
    </li>

    <li class="nav-item {{ request()->routeIs('admin.saas.plan*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.saas.plans') }}">
        <i class="mdi mdi-package-variant-closed nav-icon"></i>
        <span class="menu-title">Subscription Plans</span>
        @if(request()->routeIs('admin.saas.plan*'))
        <i class="mdi mdi-chevron-right nav-chevron"></i>
        @endif
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('admin.saas.logs') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.saas.logs') }}">
        <i class="mdi mdi-history nav-icon"></i>
        <span class="menu-title">Activity Audit Logs</span>
        @if(request()->routeIs('admin.saas.logs'))
        <i class="mdi mdi-chevron-right nav-chevron"></i>
        @endif
      </a>
    </li>



    <li class="nav-item nav-category mt-3">
      <span>SETTINGS</span>
    </li>

    <li class="nav-item {{ request()->is('admin/setting*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ URL::To('admin/setting') }}">
        <i class="mdi mdi-cog-outline nav-icon"></i>
        <span class="menu-title">Platform Settings</span>
        @if(request()->is('admin/setting*'))
        <i class="mdi mdi-chevron-right nav-chevron"></i>
        @endif
      </a>
    </li>
    @endif

    {{-- ========================================================================= --}}
    {{-- CASE 2: DOCTOR CLINIC (Visible to Doctors OR Admin VISITING a clinic)     --}}
    {{-- Order: 1. Dashboard, 2. Daily Patient Activity, 3. Clinic Setup & Plans   --}}
    {{-- ========================================================================= --}}
    @if(Auth::check() && (session('impersonating_admin_id') || (!Auth::user()->isSuperAdmin() && (Auth::user()->isDoctor() || Auth::user()->clinic))))
    
    <li class="nav-item nav-category">
      <span>MAIN</span>
    </li>

    {{-- 1. Overview / Dashboard --}}
    <li class="nav-item {{ request()->routeIs('clinic.dashboard') || request()->routeIs('doctor.dashboard') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('clinic.dashboard') }}">
        <i class="mdi mdi-view-dashboard-outline nav-icon"></i>
        <span class="menu-title">Clinic Dashboard</span>
        @if(request()->routeIs('clinic.dashboard') || request()->routeIs('doctor.dashboard'))
        <i class="mdi mdi-chevron-right nav-chevron"></i>
        @endif
      </a>
    </li>

    {{-- 2. Daily Patient & Appointments Activity --}}
    <li class="nav-item {{ request()->is('admin/patient') || request()->is('admin/patient/*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ URL::To('admin/patient') }}">
        <i class="mdi mdi-calendar-plus nav-icon"></i>
        <span class="menu-title">Patient booking</span>
        @if(request()->is('admin/patient') || request()->is('admin/patient/*'))
        <i class="mdi mdi-chevron-right nav-chevron"></i>
        @endif
      </a>
    </li>

    <li class="nav-item {{ request()->is('admin/booking_history*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ URL::To('admin/booking_history') }}">
        <i class="mdi mdi-clipboard-text-clock-outline nav-icon"></i>
        <span class="menu-title">Booking history</span>
        @if(request()->is('admin/booking_history*'))
        <i class="mdi mdi-chevron-right nav-chevron"></i>
        @endif
      </a>
    </li>

    <li class="nav-item {{ request()->is('admin/history_of_customer*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ URL::To('admin/history_of_customer') }}">
        <i class="mdi mdi-folder-account-outline nav-icon"></i>
        <span class="menu-title">Patient history</span>
        @if(request()->is('admin/history_of_customer*'))
        <i class="mdi mdi-chevron-right nav-chevron"></i>
        @endif
      </a>
    </li>

    <li class="nav-item {{ request()->is('admin/time_slot*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ URL::To('admin/time_slot') }}">
        <i class="mdi mdi-clock-time-four-outline nav-icon"></i>
        <span class="menu-title">Time Slot</span>
        @if(request()->is('admin/time_slot*'))
        <i class="mdi mdi-chevron-right nav-chevron"></i>
        @endif
      </a>
    </li>

    <li class="nav-item {{ request()->is('admin/availability*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ URL::To('admin/availability') }}">
        <i class="mdi mdi-calendar-remove-outline nav-icon"></i>
        <span class="menu-title">Unavailability</span>
        @if(request()->is('admin/availability*'))
        <i class="mdi mdi-chevron-right nav-chevron"></i>
        @endif
      </a>
    </li>

    <li class="nav-item {{ request()->is('admin/payments*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ URL::To('admin/payments') }}">
        <i class="mdi mdi-credit-card-check-outline nav-icon"></i>
        <span class="menu-title">Payment Logs</span>
        @if(request()->is('admin/payments*'))
        <i class="mdi mdi-chevron-right nav-chevron"></i>
        @endif
      </a>
    </li>

    {{-- 3. Operations / Clinic Setup & Plans (AT THE LAST) --}}
    <li class="nav-item nav-category">
      <span>OPERATIONS</span>
      <span class="category-action">+</span>
    </li>

    <li class="nav-item {{ request()->routeIs('clinic.subscription.*') || request()->routeIs('doctor.subscription.*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('clinic.subscription.index') }}">
        <i class="mdi mdi-crown-outline nav-icon"></i>
        <span class="menu-title">Plan & Billing</span>
        @if(request()->routeIs('clinic.subscription.*') || request()->routeIs('doctor.subscription.*'))
        <i class="mdi mdi-chevron-right nav-chevron"></i>
        @endif
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('clinic.services.*') || request()->routeIs('doctor.services.*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('clinic.services.index') }}">
        <i class="mdi mdi-medical-bag nav-icon"></i>
        <span class="menu-title">Clinic Services</span>
        @if(request()->routeIs('clinic.services.*') || request()->routeIs('doctor.services.*'))
        <i class="mdi mdi-chevron-right nav-chevron"></i>
        @endif
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('clinic.pages.*') || request()->routeIs('doctor.pages.*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('clinic.pages.index') }}">
        <i class="mdi mdi-file-document-edit-outline nav-icon"></i>
        <span class="menu-title">Custom Pages</span>
        @if(request()->routeIs('clinic.pages.*') || request()->routeIs('doctor.pages.*'))
        <i class="mdi mdi-chevron-right nav-chevron"></i>
        @endif
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('clinic.inquiries.*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('clinic.inquiries.index') }}">
        <i class="mdi mdi-email-open-multiple-outline nav-icon"></i>
        <span class="menu-title">Patient Inquiries</span>
        @if(request()->routeIs('clinic.inquiries.*'))
        <i class="mdi mdi-chevron-right nav-chevron"></i>
        @endif
      </a>
    </li>

    @if(Auth::check() && Auth::user()->clinic)
      @php
        $clinicStorefront = Auth::user()->clinic->custom_domain 
          ? 'https://' . Auth::user()->clinic->custom_domain 
          : url('/c/' . (Auth::user()->clinic->subdomain ?? Auth::user()->clinic->slug));
      @endphp
      <li class="nav-item">
        <a class="nav-link" href="{{ $clinicStorefront }}" target="_blank">
          <i class="mdi mdi-open-in-new nav-icon"></i>
          <span class="menu-title">View Storefront</span>
        </a>
      </li>
    @endif

    {{-- Exit to Admin if Impersonating --}}
    @if(session('impersonating_admin_id'))
    <li class="nav-item mt-2">
      <a class="nav-link text-danger" href="{{ route('admin.saas.stop_impersonate') }}" style="background: rgba(239, 68, 68, 0.06); font-weight: 600;">
        <i class="mdi mdi-arrow-left-bold nav-icon text-danger"></i>
        <span class="menu-title text-danger">Exit Back to Admin</span>
      </a>
    </li>
    @endif

    <li class="nav-item nav-category mt-2">
      <span>SETTINGS</span>
    </li>

    <li class="nav-item {{ request()->routeIs('clinic.settings') || request()->routeIs('doctor.settings') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('clinic.settings') }}">
        <i class="mdi mdi-cog-outline nav-icon"></i>
        <span class="menu-title">Settings</span>
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('clinic.support') || request()->routeIs('doctor.support') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('clinic.support') }}">
        <i class="mdi mdi-help-circle-outline nav-icon"></i>
        <span class="menu-title">Support</span>
      </a>
    </li>
    @endif

    {{-- ========================================================================= --}}
    {{-- CASE 3: CLINIC STAFF / EMPLOYEE                                           --}}
    {{-- ========================================================================= --}}
    @if(Auth::check() && Auth::user()->isStaff())
    <li class="nav-item nav-category">
      <span>MAIN</span>
    </li>

    <li class="nav-item {{ request()->is('admin/patient*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ URL::To('admin/patient') }}">
        <i class="mdi mdi-calendar-plus nav-icon"></i>
        <span class="menu-title">Patient booking</span>
      </a>
    </li>

    <li class="nav-item {{ request()->is('admin/booking_history*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ URL::To('admin/booking_history') }}">
        <i class="mdi mdi-clipboard-text-clock-outline nav-icon"></i>
        <span class="menu-title">Booking history</span>
      </a>
    </li>

    <li class="nav-item {{ request()->is('admin/history_of_customer*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ URL::To('admin/history_of_customer') }}">
        <i class="mdi mdi-folder-account-outline nav-icon"></i>
        <span class="menu-title">Patient history</span>
      </a>
    </li>

    <li class="nav-item {{ request()->is('admin/time_slot*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ URL::To('admin/time_slot') }}">
        <i class="mdi mdi-clock-time-four-outline nav-icon"></i>
        <span class="menu-title">Time Slot</span>
      </a>
    </li>

    <li class="nav-item {{ request()->is('admin/availability*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ URL::To('admin/availability') }}">
        <i class="mdi mdi-calendar-remove-outline nav-icon"></i>
        <span class="menu-title">Unavailability</span>
      </a>
    </li>
    @endif
  </ul>

  <!-- Bottom User Profile Card (Fixed at the bottom of sidebar) -->
  <div class="sidebar-footer-section">
    <a href="{{ Auth::check() && Auth::user()->isSuperAdmin() ? URL::To('admin/setting') : route('clinic.settings') }}" class="sidebar-user-card">
      <div class="d-flex align-items-center text-truncate" style="gap: 10px;">
        <div class="sidebar-user-avatar">
          {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
        </div>
        <div class="text-truncate">
          <div class="sidebar-user-name d-flex align-items-center" style="gap: 4px;">
            <span class="text-truncate">{{ Auth::user()->name ?? 'Admin User' }}</span>
            <i class="mdi mdi-check-decagram text-primary font-12" title="Verified"></i>
          </div>
          <div class="sidebar-user-email text-truncate">{{ Auth::user()->email ?? 'admin@gmail.com' }}</div>
        </div>
      </div>
      <i class="mdi mdi-chevron-right text-muted font-16 ms-2"></i>
    </a>
  </div>
</nav>