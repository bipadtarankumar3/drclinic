<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    @if(session('impersonating_admin_id'))
    <li class="nav-item">
      <a class="nav-link bg-warning text-dark font-weight-bold" href="{{ route('admin.saas.stop_impersonate') }}">
        <i class="menu-icon mdi mdi-arrow-left-bold-circle"></i>
        <span class="menu-title">Exit Doctor View</span>
      </a>
    </li>
    @endif

    @if(Auth::check() && Auth::user()->isSuperAdmin())
    <li class="nav-item nav-category">SaaS Platform Admin</li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('admin.saas.dashboard') }}">
        <i class="menu-icon mdi mdi-chart-box-outline"></i>
        <span class="menu-title">Platform Analytics</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('admin.saas.clinics') }}">
        <i class="menu-icon mdi mdi-hospital-building"></i>
        <span class="menu-title">All Doctor Clinics</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('admin.saas.plans') }}">
        <i class="menu-icon mdi mdi-package-variant-closed"></i>
        <span class="menu-title">Subscription Plans</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('admin.saas.logs') }}">
        <i class="menu-icon mdi mdi-history"></i>
        <span class="menu-title">Activity Audit Logs</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('admin.saas.payment_settings') }}">
        <i class="menu-icon mdi mdi-credit-card-outline"></i>
        <span class="menu-title">Platform Razorpay</span>
      </a>
    </li>
    @endif

    <li class="nav-item nav-category">Clinic Management</li>
    @if(Auth::check() && Auth::user()->clinic)
    <li class="nav-item">
      <a class="nav-link" href="{{ route('doctor.dashboard') }}">
        <i class="menu-icon mdi mdi-view-dashboard-outline"></i>
        <span class="menu-title">Doctor Dashboard</span>
      </a>
    </li>
    @endif
    <li class="nav-item">
      <a class="nav-link" href="{{URL::To('admin/patient')}}">
        <i class="menu-icon mdi mdi-calendar-plus"></i>
        <span class="menu-title">Patient booking</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{URL::To('admin/booking_history')}}">
        <i class="menu-icon mdi mdi-clipboard-text-clock-outline"></i>
        <span class="menu-title">Booking history</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{URL::To('admin/history_of_customer')}}">
        <i class="menu-icon mdi mdi-folder-account-outline"></i>
        <span class="menu-title">Patient history</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{URL::To('admin/time_slot')}}">
        <i class="menu-icon mdi mdi-clock-time-four-outline"></i>
        <span class="menu-title">Time Slot</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{URL::To('admin/availability')}}">
        <i class="menu-icon mdi mdi-calendar-remove-outline"></i>
        <span class="menu-title">Unavailability</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{URL::To('admin/payments')}}">
        <i class="menu-icon mdi mdi-credit-card-check-outline"></i>
        <span class="menu-title">Payment Logs</span>
      </a>
    </li>
    @if(Auth::check() && Auth::user()->clinic)
    <li class="nav-item">
      <a class="nav-link" href="{{ route('doctor.pages.index') }}">
        <i class="menu-icon mdi mdi-file-document-edit-outline"></i>
        <span class="menu-title">Custom Pages</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('doctor.settings') }}">
        <i class="menu-icon mdi mdi-tune"></i>
        <span class="menu-title">Clinic & Razorpay</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('doctor.subscription.index') }}">
        <i class="menu-icon mdi mdi-crown-outline"></i>
        <span class="menu-title">Plan & Billing</span>
      </a>
    </li>
    @else
    <li class="nav-item">
      <a class="nav-link" href="{{URL::To('admin/setting')}}">
        <i class="menu-icon mdi mdi-cog-outline"></i>
        <span class="menu-title">Settings</span>
      </a>
    </li>
    @endif
  </ul>
</nav>