<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    {{-- Impersonation Mode Banner in Sidebar --}}
    @if(session('impersonating_admin_id'))
    <li class="nav-item mb-2" style="background: rgba(220, 38, 38, 0.08); border-radius: 12px; margin: 8px 12px; padding: 12px; border: 1.5px dashed #ef4444;">
      <div class="text-danger font-11 font-weight-bold text-uppercase mb-1 d-flex align-items-center">
        <i class="mdi mdi-account-switch me-1 font-14"></i> Impersonating Doctor
      </div>
      <div class="font-weight-bold text-dark font-13 mb-1 text-truncate" title="{{ Auth::user()->name }}">
        Dr. {{ Auth::user()->name }}
      </div>
      <div class="text-muted font-11 text-truncate mb-2" title="{{ Auth::user()->clinic->name ?? '' }}">
        {{ Auth::user()->clinic->name ?? 'Clinic' }}
      </div>
      <a class="btn btn-danger btn-sm text-white font-weight-bold w-100 py-1" href="{{ route('admin.saas.stop_impersonate') }}" style="border-radius: 6px; font-size: 12px;">
        <i class="mdi mdi-arrow-left-bold me-1"></i> Exit & Back to Admin
      </a>
    </li>
    @endif

    {{-- 1. SaaS Platform Admin (Visible to Super Admin when NOT impersonating) --}}
    @if(Auth::check() && Auth::user()->isSuperAdmin() && !session('impersonating_admin_id'))
    <li class="nav-item nav-category">SaaS Platform Admin</li>
    <li class="nav-item {{ request()->routeIs('admin.saas.dashboard') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.saas.dashboard') }}">
        <i class="menu-icon mdi mdi-chart-box-outline"></i>
        <span class="menu-title">Platform Analytics</span>
      </a>
    </li>
    <li class="nav-item {{ request()->routeIs('admin.saas.clinics*') || request()->routeIs('admin.saas.clinic.*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.saas.clinics') }}">
        <i class="menu-icon mdi mdi-hospital-building"></i>
        <span class="menu-title">All Doctor Clinics</span>
      </a>
    </li>
    <li class="nav-item {{ request()->routeIs('admin.saas.plans*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.saas.plans') }}">
        <i class="menu-icon mdi mdi-package-variant-closed"></i>
        <span class="menu-title">Subscription Plans</span>
      </a>
    </li>
    <li class="nav-item {{ request()->routeIs('admin.saas.logs') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.saas.logs') }}">
        <i class="menu-icon mdi mdi-history"></i>
        <span class="menu-title">Activity Audit Logs</span>
      </a>
    </li>
    <li class="nav-item {{ request()->routeIs('admin.saas.payment_settings') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.saas.payment_settings') }}">
        <i class="menu-icon mdi mdi-credit-card-outline"></i>
        <span class="menu-title">Platform Razorpay</span>
      </a>
    </li>
    @endif

    {{-- 2. Doctor Portal (Visible to Doctors OR Admin Impersonating a Doctor) --}}
    @if(Auth::check() && (Auth::user()->isDoctor() || session('impersonating_admin_id')))
    <li class="nav-item nav-category">Doctor Portal</li>
    <li class="nav-item {{ request()->routeIs('doctor.dashboard') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('doctor.dashboard') }}">
        <i class="menu-icon mdi mdi-view-dashboard-outline"></i>
        <span class="menu-title">Doctor Dashboard</span>
      </a>
    </li>
    <li class="nav-item {{ request()->routeIs('doctor.subscription.*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('doctor.subscription.index') }}">
        <i class="menu-icon mdi mdi-crown-outline text-warning"></i>
        <span class="menu-title font-weight-bold">Plan & Billing</span>
      </a>
    </li>
    <li class="nav-item {{ request()->routeIs('doctor.pages.*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('doctor.pages.index') }}">
        <i class="menu-icon mdi mdi-file-document-edit-outline"></i>
        <span class="menu-title">Custom Pages</span>
      </a>
    </li>
    <li class="nav-item {{ request()->routeIs('doctor.settings') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('doctor.settings') }}">
        <i class="menu-icon mdi mdi-tune"></i>
        <span class="menu-title">Clinic & Razorpay</span>
      </a>
    </li>
    @endif

    {{-- 3. Operations & Patient Management --}}
    <li class="nav-item nav-category">
      @if(Auth::check() && (Auth::user()->isDoctor() || session('impersonating_admin_id')))
        Patient & Bookings
      @else
        Clinic Management
      @endif
    </li>

    @if(Auth::check() && Auth::user()->isSuperAdmin() && !session('impersonating_admin_id'))
    <li class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
      <a class="nav-link" href="{{ URL::To('admin/dashboard') }}">
        <i class="menu-icon mdi mdi-grid-large"></i>
        <span class="menu-title">Clinic Operations</span>
      </a>
    </li>
    @endif

    <li class="nav-item {{ request()->is('admin/patient*') ? 'active' : '' }}">
      <a class="nav-link" href="{{URL::To('admin/patient')}}">
        <i class="menu-icon mdi mdi-calendar-plus"></i>
        <span class="menu-title">Patient booking</span>
      </a>
    </li>
    <li class="nav-item {{ request()->is('admin/booking_history*') ? 'active' : '' }}">
      <a class="nav-link" href="{{URL::To('admin/booking_history')}}">
        <i class="menu-icon mdi mdi-clipboard-text-clock-outline"></i>
        <span class="menu-title">Booking history</span>
      </a>
    </li>
    <li class="nav-item {{ request()->is('admin/history_of_customer*') ? 'active' : '' }}">
      <a class="nav-link" href="{{URL::To('admin/history_of_customer')}}">
        <i class="menu-icon mdi mdi-folder-account-outline"></i>
        <span class="menu-title">Patient history</span>
      </a>
    </li>
    <li class="nav-item {{ request()->is('admin/time_slot*') ? 'active' : '' }}">
      <a class="nav-link" href="{{URL::To('admin/time_slot')}}">
        <i class="menu-icon mdi mdi-clock-time-four-outline"></i>
        <span class="menu-title">Time Slot</span>
      </a>
    </li>
    <li class="nav-item {{ request()->is('admin/availability*') ? 'active' : '' }}">
      <a class="nav-link" href="{{URL::To('admin/availability')}}">
        <i class="menu-icon mdi mdi-calendar-remove-outline"></i>
        <span class="menu-title">Unavailability</span>
      </a>
    </li>
    <li class="nav-item {{ request()->is('admin/payments*') ? 'active' : '' }}">
      <a class="nav-link" href="{{URL::To('admin/payments')}}">
        <i class="menu-icon mdi mdi-credit-card-check-outline"></i>
        <span class="menu-title">Payment Logs</span>
      </a>
    </li>

    {{-- Platform Settings (Visible ONLY to Super Admin) --}}
    @if(Auth::check() && Auth::user()->isSuperAdmin() && !session('impersonating_admin_id'))
    <li class="nav-item {{ request()->is('admin/setting*') ? 'active' : '' }}">
      <a class="nav-link" href="{{URL::To('admin/setting')}}">
        <i class="menu-icon mdi mdi-cog-outline"></i>
        <span class="menu-title">General Settings</span>
      </a>
    </li>
    @endif

    {{-- Bottom Exit Link if Impersonating --}}
    @if(session('impersonating_admin_id'))
    <li class="nav-item mt-3">
      <a class="nav-link bg-light text-danger font-weight-bold" href="{{ route('admin.saas.stop_impersonate') }}">
        <i class="menu-icon mdi mdi-arrow-left-bold text-danger"></i>
        <span class="menu-title">Exit Back to Admin</span>
      </a>
    </li>
    @endif
  </ul>
</nav>