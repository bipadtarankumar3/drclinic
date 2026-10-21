<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    {{-- Impersonation Mode Banner in Sidebar (When Admin is visiting a Doctor Clinic) --}}
    @if(session('impersonating_admin_id'))
    <li class="nav-item mb-2">
      <div class="impersonation-sidebar-widget">
        <div class="d-flex align-items-center mb-1">
          <span class="pulse-dot"></span>
          <span style="font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.6px; color: #c2410c;">
            Visiting Clinic
          </span>
        </div>
        <div class="font-weight-bold text-dark font-14 text-truncate mb-1" title="{{ Auth::user()->clinic->name ?? '' }}">
          {{ Auth::user()->clinic->name ?? 'Doctor Clinic' }}
        </div>
        <div class="text-muted font-12 text-truncate mb-2" title="{{ Auth::user()->name }}">
          Dr. {{ Auth::user()->name }}
        </div>
        <a class="btn btn-danger btn-sm text-white font-weight-bold w-100 py-2 shadow-sm d-flex align-items-center justify-content-center" href="{{ route('admin.saas.stop_impersonate') }}" style="border-radius: 8px; font-size: 12px; gap: 6px;">
          <i class="mdi mdi-arrow-left-bold"></i> Exit Back to Admin
        </a>
      </div>
    </li>
    @endif

    {{-- ========================================================================= --}}
    {{-- CASE 1: SUPER ADMIN (When NOT visiting a clinic)                          --}}
    {{-- Super Admin sees ONLY his Platform Admin menu, NOT the clinic menu        --}}
    {{-- ========================================================================= --}}
    @if(Auth::check() && Auth::user()->isSuperAdmin() && !session('impersonating_admin_id'))
    <li class="nav-item nav-category">SaaS Platform Admin</li>

    <li class="nav-item {{ request()->routeIs('admin.saas.dashboard') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.saas.dashboard') }}">
        <div class="nav-icon-box icon-box-indigo">
          <i class="mdi mdi-chart-box-outline"></i>
        </div>
        <span class="menu-title">Platform Analytics</span>
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('admin.saas.clinics*') || request()->routeIs('admin.saas.clinic.*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.saas.clinics') }}">
        <div class="nav-icon-box icon-box-emerald">
          <i class="mdi mdi-hospital-building"></i>
        </div>
        <span class="menu-title">All Doctor Clinics</span>
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('admin.saas.plans*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.saas.plans') }}">
        <div class="nav-icon-box icon-box-amber">
          <i class="mdi mdi-package-variant-closed"></i>
        </div>
        <span class="menu-title">Subscription Plans</span>
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('admin.saas.logs') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.saas.logs') }}">
        <div class="nav-icon-box icon-box-purple">
          <i class="mdi mdi-history"></i>
        </div>
        <span class="menu-title">Activity Audit Logs</span>
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('admin.saas.payment_settings') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.saas.payment_settings') }}">
        <div class="nav-icon-box icon-box-cyan">
          <i class="mdi mdi-credit-card-outline"></i>
        </div>
        <span class="menu-title">Platform Razorpay</span>
      </a>
    </li>

    <li class="nav-item {{ request()->is('admin/setting*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ URL::To('admin/setting') }}">
        <div class="nav-icon-box icon-box-slate">
          <i class="mdi mdi-cog-outline"></i>
        </div>
        <span class="menu-title">Platform Settings</span>
      </a>
    </li>
    @endif

    {{-- ========================================================================= --}}
    {{-- CASE 2: DOCTOR CLINIC (Visible to Doctors OR Admin VISITING a clinic)     --}}
    {{-- Admin can see ALL clinic menu items ONLY when visiting a clinic!          --}}
    {{-- ========================================================================= --}}
    @if(Auth::check() && (Auth::user()->isDoctor() || session('impersonating_admin_id')))
    <li class="nav-item nav-category">Doctor Portal</li>

    <li class="nav-item {{ request()->routeIs('doctor.dashboard') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('doctor.dashboard') }}">
        <div class="nav-icon-box icon-box-blue">
          <i class="mdi mdi-view-dashboard-outline"></i>
        </div>
        <span class="menu-title">Doctor Dashboard</span>
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('doctor.subscription.*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('doctor.subscription.index') }}">
        <div class="nav-icon-box icon-box-amber">
          <i class="mdi mdi-crown text-warning"></i>
        </div>
        <span class="menu-title font-weight-bold">Plan & Billing</span>
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('doctor.pages.*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('doctor.pages.index') }}">
        <div class="nav-icon-box icon-box-purple">
          <i class="mdi mdi-file-document-edit-outline"></i>
        </div>
        <span class="menu-title">Custom Pages</span>
      </a>
    </li>

    <li class="nav-item {{ request()->routeIs('doctor.settings') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('doctor.settings') }}">
        <div class="nav-icon-box icon-box-teal">
          <i class="mdi mdi-tune"></i>
        </div>
        <span class="menu-title">Clinic & Razorpay</span>
      </a>
    </li>

    <li class="nav-item nav-category">Patient & Bookings</li>

    <li class="nav-item {{ request()->is('admin/patient*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ URL::To('admin/patient') }}">
        <div class="nav-icon-box icon-box-emerald">
          <i class="mdi mdi-calendar-plus"></i>
        </div>
        <span class="menu-title">Patient booking</span>
      </a>
    </li>

    <li class="nav-item {{ request()->is('admin/booking_history*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ URL::To('admin/booking_history') }}">
        <div class="nav-icon-box icon-box-indigo">
          <i class="mdi mdi-clipboard-text-clock-outline"></i>
        </div>
        <span class="menu-title">Booking history</span>
      </a>
    </li>

    <li class="nav-item {{ request()->is('admin/history_of_customer*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ URL::To('admin/history_of_customer') }}">
        <div class="nav-icon-box icon-box-rose">
          <i class="mdi mdi-folder-account-outline"></i>
        </div>
        <span class="menu-title">Patient history</span>
      </a>
    </li>

    <li class="nav-item {{ request()->is('admin/time_slot*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ URL::To('admin/time_slot') }}">
        <div class="nav-icon-box icon-box-cyan">
          <i class="mdi mdi-clock-time-four-outline"></i>
        </div>
        <span class="menu-title">Time Slot</span>
      </a>
    </li>

    <li class="nav-item {{ request()->is('admin/availability*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ URL::To('admin/availability') }}">
        <div class="nav-icon-box icon-box-amber">
          <i class="mdi mdi-calendar-remove-outline"></i>
        </div>
        <span class="menu-title">Unavailability</span>
      </a>
    </li>

    <li class="nav-item {{ request()->is('admin/payments*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ URL::To('admin/payments') }}">
        <div class="nav-icon-box icon-box-teal">
          <i class="mdi mdi-credit-card-check-outline"></i>
        </div>
        <span class="menu-title">Payment Logs</span>
      </a>
    </li>

    @if(session('impersonating_admin_id'))
    <li class="nav-item mt-4 pt-2 border-top">
      <a class="nav-link text-danger font-weight-bold d-flex align-items-center" href="{{ route('admin.saas.stop_impersonate') }}" style="background: rgba(239, 68, 68, 0.06); border-radius: 10px;">
        <div class="nav-icon-box" style="background: #fee2e2; color: #dc2626;">
          <i class="mdi mdi-arrow-left-bold"></i>
        </div>
        <span class="menu-title">Exit Back to Admin</span>
      </a>
    </li>
    @endif
    @endif

    {{-- ========================================================================= --}}
    {{-- CASE 3: CLINIC STAFF / EMPLOYEE                                           --}}
    {{-- Staff members who are neither Super Admin nor Doctor                      --}}
    {{-- ========================================================================= --}}
    @if(Auth::check() && Auth::user()->isStaff())
    <li class="nav-item nav-category">Appointments & Patients</li>

    <li class="nav-item {{ request()->is('admin/patient*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ URL::To('admin/patient') }}">
        <div class="nav-icon-box icon-box-emerald">
          <i class="mdi mdi-calendar-plus"></i>
        </div>
        <span class="menu-title">Patient booking</span>
      </a>
    </li>

    <li class="nav-item {{ request()->is('admin/booking_history*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ URL::To('admin/booking_history') }}">
        <div class="nav-icon-box icon-box-indigo">
          <i class="mdi mdi-clipboard-text-clock-outline"></i>
        </div>
        <span class="menu-title">Booking history</span>
      </a>
    </li>

    <li class="nav-item {{ request()->is('admin/history_of_customer*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ URL::To('admin/history_of_customer') }}">
        <div class="nav-icon-box icon-box-rose">
          <i class="mdi mdi-folder-account-outline"></i>
        </div>
        <span class="menu-title">Patient history</span>
      </a>
    </li>

    <li class="nav-item {{ request()->is('admin/time_slot*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ URL::To('admin/time_slot') }}">
        <div class="nav-icon-box icon-box-cyan">
          <i class="mdi mdi-clock-time-four-outline"></i>
        </div>
        <span class="menu-title">Time Slot</span>
      </a>
    </li>

    <li class="nav-item {{ request()->is('admin/availability*') ? 'active' : '' }}">
      <a class="nav-link" href="{{ URL::To('admin/availability') }}">
        <div class="nav-icon-box icon-box-amber">
          <i class="mdi mdi-calendar-remove-outline"></i>
        </div>
        <span class="menu-title">Unavailability</span>
      </a>
    </li>
    @endif
  </ul>
</nav>