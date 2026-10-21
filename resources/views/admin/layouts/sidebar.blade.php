<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link" href="{{URL::To('admin/dashboard')}}">
        <i class="mdi mdi-grid-large menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <li class="nav-item nav-category">Clinic Management</li>
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
    {{-- <li class="nav-item">
      <a class="nav-link" href="{{URL::To('admin/user')}}">
        <i class="menu-icon mdi mdi-account-circle-outline"></i>
        <span class="menu-title">Customers</span>
      </a>
    </li> --}}
    <li class="nav-item">
      <a class="nav-link" href="{{URL::To('admin/setting')}}">
        <i class="menu-icon mdi mdi-cog-outline"></i>
        <span class="menu-title">Settings</span>
      </a>
    </li>

   

    {{-- <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#report" aria-expanded="false" aria-controls="report">
        <i class="menu-icon mdi mdi-layers-outline"></i>
        <span class="menu-title">Report</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="report">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="{{URL::To('admin/report/user')}}">User reports </a></li>
          <li class="nav-item"> <a class="nav-link" href="{{URL::To('admin/report/payment')}}">Payment reports </a></li>
        </ul>
      </div>
    </li> --}}
  </ul>
</nav>