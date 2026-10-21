<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
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
    {{-- Order: 1. Dashboard, 2. Daily Activity (Bookings), 3. Setup, Pages & Plan --}}
    {{-- ========================================================================= --}}
    @if(Auth::check() && (Auth::user()->isDoctor() || session('impersonating_admin_id')))
    
    <li class="nav-item nav-category">Daily Activity</li>

    {{-- 1. Dashboard --}}
    <li class="nav-item {{ request()->routeIs('doctor.dashboard') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('doctor.dashboard') }}">
        <div class="nav-icon-box icon-box-blue">
          <i class="mdi mdi-view-dashboard-outline"></i>
        </div>
        <span class="menu-title">Doctor Dashboard</span>
      </a>
    </li>

    {{-- 2. Daily Patient & Appointments Activity --}}
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

    {{-- 3. Configuration & Plans (AT THE LAST: Plan, Custom, Clinic & Razorpay) --}}
    <li class="nav-item nav-category">Clinic Setup & Plan</li>

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