@extends('admin.layouts.main')

@section('style')
<style>
  .dashboard-banner {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    border-radius: 16px;
    color: #ffffff;
    padding: 24px 28px;
    margin-bottom: 24px;
    box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.25);
    position: relative;
    overflow: hidden;
  }
  .dashboard-banner::after {
    content: '';
    position: absolute;
    right: -40px;
    top: -40px;
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 70%);
    border-radius: 50%;
    pointer-events: none;
  }
  .stat-card {
    border-radius: 16px;
    border: 1px solid rgba(226, 232, 240, 0.8);
    background: #ffffff;
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    height: 100%;
    position: relative;
    overflow: hidden;
  }
  .stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 28px -4px rgba(0, 0, 0, 0.1);
  }
  .stat-icon-wrapper {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    flex-shrink: 0;
  }
  .icon-blue { background: #eff6ff; color: #2563eb; }
  .icon-green { background: #ecfdf5; color: #059669; }
  .icon-purple { background: #f5f3ff; color: #7c3aed; }
  .icon-amber { background: #fffbeb; color: #d97706; }
  .icon-rose { background: #fff1f2; color: #e11d48; }

  .stat-badge {
    font-size: 12px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
  }
  .badge-soft-success { background: #d1fae5; color: #065f46; }
  .badge-soft-primary { background: #dbeafe; color: #1e40af; }
  .badge-soft-warning { background: #fef3c7; color: #92400e; }
  .badge-soft-danger { background: #fee2e2; color: #991b1b; }
  .badge-soft-info { background: #e0f2fe; color: #0369a1; }

  .quick-action-card {
    border-radius: 14px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    padding: 16px;
    display: flex;
    align-items: center;
    gap: 14px;
    transition: all 0.25s ease;
    text-decoration: none !important;
    color: inherit;
  }
  .quick-action-card:hover {
    border-color: #3b82f6;
    background: #f8fafc;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.12);
  }
  .quick-action-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
  }

  .table-custom {
    vertical-align: middle;
  }
  .table-custom th {
    background-color: #f8fafc;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #64748b;
    font-weight: 700;
    border-top: none;
    border-bottom: 2px solid #e2e8f0;
    padding: 12px 16px;
  }
  .table-custom td {
    padding: 14px 16px;
    font-size: 14px;
    border-bottom: 1px solid #f1f5f9;
  }
  .avatar-initials {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: #e0e7ff;
    color: #4338ca;
    font-weight: 700;
    font-size: 14px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }
  .card-header-clean {
    background: transparent;
    border-bottom: 1px solid #f1f5f9;
    padding: 18px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .banner-btn-primary {
    background: #ffffff !important;
    color: #1e40af !important;
    font-weight: 700 !important;
    border-radius: 50px !important;
    padding: 10px 22px !important;
    border: 1px solid rgba(255, 255, 255, 0.9) !important;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12) !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 8px !important;
    transition: all 0.25s ease-in-out !important;
    text-decoration: none !important;
    font-size: 14px !important;
  }
  .banner-btn-primary:hover {
    background: #f8fafc !important;
    color: #1d4ed8 !important;
    transform: translateY(-2px) scale(1.02) !important;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.18) !important;
  }
  .banner-btn-secondary {
    background: rgba(255, 255, 255, 0.18) !important;
    color: #ffffff !important;
    font-weight: 600 !important;
    border-radius: 50px !important;
    padding: 10px 22px !important;
    border: 1.5px solid rgba(255, 255, 255, 0.6) !important;
    backdrop-filter: blur(8px) !important;
    -webkit-backdrop-filter: blur(8px) !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 8px !important;
    transition: all 0.25s ease-in-out !important;
    text-decoration: none !important;
    font-size: 14px !important;
  }
  .banner-btn-secondary:hover {
    background: rgba(255, 255, 255, 0.32) !important;
    color: #ffffff !important;
    border-color: #ffffff !important;
    transform: translateY(-2px) scale(1.02) !important;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15) !important;
  }
  .banner-btn-secondary i,
  .banner-btn-primary i {
    font-size: 18px !important;
    display: inline-flex !important;
    align-items: center !important;
  }
</style>
@endsection

@section('content')
<div class="main-panel">
  <div class="content-wrapper p-3 p-md-4">
    
    <!-- Hero Welcome Banner -->
    <div class="dashboard-banner">
      <div class="row align-items-center">
        <div class="col-lg-8 mb-3 mb-lg-0">
          <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
            <span class="badge {{ ($setting->payment_permission_status ?? 'no') == 'yes' ? 'bg-success' : 'bg-danger' }} px-3 py-2 rounded-pill fw-semibold">
              <i class="mdi mdi-hospital-building me-1"></i> Clinic {{ ($setting->payment_permission_status ?? 'no') == 'yes' ? 'Online (Accepting Appointments)' : 'Offline (Booking Paused)' }}
            </span>
            <span class="badge bg-white text-dark px-3 py-2 rounded-pill fw-semibold shadow-sm">
              <i class="mdi mdi-cash me-1 text-primary"></i> Consultation Fee: ₹{{ number_format($setting->pay_amount ?? 500, 2) }}
            </span>
          </div>
          <h2 class="fw-bold mb-1 text-white">Welcome back, {{ Auth::user()->name ?? 'Administrator' }} 👋</h2>
          <p class="mb-0 text-white-50 fs-6">
            <i class="mdi mdi-calendar-range me-1"></i> {{ \Carbon\Carbon::now()->format('l, d F Y') }} &bull; Roy Neuro Care Hospital Management System
          </p>
        </div>
        <div class="col-lg-4 text-lg-end">
          <div class="d-flex gap-3 justify-content-lg-end flex-wrap align-items-center">
            <a href="{{ url('admin/patient') }}" class="banner-btn-primary">
              <i class="mdi mdi-account-plus"></i> New Booking
            </a>
            <a href="{{ url('admin/availability') }}" class="banner-btn-secondary">
              <i class="mdi mdi-calendar-clock"></i> Schedule
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Top Key Metrics Cards -->
    <div class="row g-3 mb-4">
      <!-- Total Patients -->
      <div class="col-sm-6 col-xl-3">
        <div class="stat-card p-3 p-md-4">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
              <p class="text-muted fw-semibold mb-1 text-uppercase" style="font-size: 12px; letter-spacing: 0.05em;">Total Patients</p>
              <h2 class="fw-bold mb-0 text-dark">{{ number_format($patient) }}</h2>
            </div>
            <div class="stat-icon-wrapper icon-blue">
              <i class="mdi mdi-account-group-outline"></i>
            </div>
          </div>
          <div class="d-flex align-items-center justify-content-between pt-2 border-top">
            <span class="stat-badge badge-soft-success">
              <i class="mdi mdi-arrow-up-bold"></i> +{{ $today_patient }} Today
            </span>
            <a href="{{ url('admin/history_of_customer') }}" class="text-muted text-decoration-none small fw-medium">View all <i class="mdi mdi-chevron-right"></i></a>
          </div>
        </div>
      </div>

      <!-- Total Bookings -->
      <div class="col-sm-6 col-xl-3">
        <div class="stat-card p-3 p-md-4">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
              <p class="text-muted fw-semibold mb-1 text-uppercase" style="font-size: 12px; letter-spacing: 0.05em;">Total Bookings</p>
              <h2 class="fw-bold mb-0 text-dark">{{ number_format($booking) }}</h2>
            </div>
            <div class="stat-icon-wrapper icon-green">
              <i class="mdi mdi-calendar-check-outline"></i>
            </div>
          </div>
          <div class="d-flex align-items-center justify-content-between pt-2 border-top">
            <span class="stat-badge badge-soft-primary">
              <i class="mdi mdi-clock-outline"></i> {{ $today_booking }} Today &bull; {{ $tomorrow_booking }} Tmrw
            </span>
            <a href="{{ url('admin/booking_history') }}" class="text-muted text-decoration-none small fw-medium">History <i class="mdi mdi-chevron-right"></i></a>
          </div>
        </div>
      </div>

      <!-- Total Payments & Revenue -->
      <div class="col-sm-6 col-xl-3">
        <div class="stat-card p-3 p-md-4">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
              <p class="text-muted fw-semibold mb-1 text-uppercase" style="font-size: 12px; letter-spacing: 0.05em;">Revenue Collected</p>
              <h2 class="fw-bold mb-0 text-dark">₹{{ number_format($total_payments, 2) }}</h2>
            </div>
            <div class="stat-icon-wrapper icon-purple">
              <i class="mdi mdi-cash-multiple"></i>
            </div>
          </div>
          <div class="d-flex align-items-center justify-content-between pt-2 border-top">
            <span class="stat-badge badge-soft-success">
              <i class="mdi mdi-arrow-up-bold"></i> ₹{{ number_format($today_total_payments, 2) }} Today
            </span>
            <a href="{{ url('admin/payments') }}" class="text-muted text-decoration-none small fw-medium">Logs <i class="mdi mdi-chevron-right"></i></a>
          </div>
        </div>
      </div>

      <!-- Cancelled & Pending -->
      <div class="col-sm-6 col-xl-3">
        <div class="stat-card p-3 p-md-4">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
              <p class="text-muted fw-semibold mb-1 text-uppercase" style="font-size: 12px; letter-spacing: 0.05em;">Cancellations</p>
              <h2 class="fw-bold mb-0 text-dark">{{ number_format($cancelled_booking) }}</h2>
            </div>
            <div class="stat-icon-wrapper icon-rose">
              <i class="mdi mdi-calendar-remove-outline"></i>
            </div>
          </div>
          <div class="d-flex align-items-center justify-content-between pt-2 border-top">
            <span class="stat-badge {{ $today_cancelled_booking > 0 ? 'badge-soft-danger' : 'badge-soft-info' }}">
              {{ $today_cancelled_booking }} Today &bull; {{ $pending_booking }} Pending
            </span>
            <span class="text-muted small fw-medium">{{ $booking > 0 ? round(($cancelled_booking / $booking) * 100, 1) : 0 }}% rate</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Management Action Shortcuts -->
    <div class="row g-3 mb-4">
      <div class="col-6 col-md-4 col-xl-2">
        <a href="{{ url('admin/patient') }}" class="quick-action-card">
          <div class="quick-action-icon icon-blue">
            <i class="mdi mdi-calendar-plus"></i>
          </div>
          <div>
            <h6 class="fw-bold mb-0 text-dark" style="font-size: 13px;">Book Patient</h6>
            <span class="text-muted" style="font-size: 11px;">Appointment</span>
          </div>
        </a>
      </div>
      <div class="col-6 col-md-4 col-xl-2">
        <a href="{{ url('admin/booking_history') }}" class="quick-action-card">
          <div class="quick-action-icon icon-green">
            <i class="mdi mdi-history"></i>
          </div>
          <div>
            <h6 class="fw-bold mb-0 text-dark" style="font-size: 13px;">Booking Log</h6>
            <span class="text-muted" style="font-size: 11px;">Full History</span>
          </div>
        </a>
      </div>
      <div class="col-6 col-md-4 col-xl-2">
        <a href="{{ url('admin/time_slot') }}" class="quick-action-card">
          <div class="quick-action-icon icon-purple">
            <i class="mdi mdi-clock-fast"></i>
          </div>
          <div>
            <h6 class="fw-bold mb-0 text-dark" style="font-size: 13px;">Time Slots</h6>
            <span class="text-muted" style="font-size: 11px;">Consultation</span>
          </div>
        </a>
      </div>
      <div class="col-6 col-md-4 col-xl-2">
        <a href="{{ url('admin/availability') }}" class="quick-action-card">
          <div class="quick-action-icon icon-amber">
            <i class="mdi mdi-calendar-alert"></i>
          </div>
          <div>
            <h6 class="fw-bold mb-0 text-dark" style="font-size: 13px;">Unavailability</h6>
            <span class="text-muted" style="font-size: 11px;">Block Dates</span>
          </div>
        </a>
      </div>
      <div class="col-6 col-md-4 col-xl-2">
        <a href="{{ url('admin/payments') }}" class="quick-action-card">
          <div class="quick-action-icon icon-rose">
            <i class="mdi mdi-credit-card-check"></i>
          </div>
          <div>
            <h6 class="fw-bold mb-0 text-dark" style="font-size: 13px;">Payments</h6>
            <span class="text-muted" style="font-size: 11px;">Razorpay Logs</span>
          </div>
        </a>
      </div>
      <div class="col-6 col-md-4 col-xl-2">
        <a href="{{ url('admin/setting') }}" class="quick-action-card">
          <div class="quick-action-icon icon-blue">
            <i class="mdi mdi-cog-outline"></i>
          </div>
          <div>
            <h6 class="fw-bold mb-0 text-dark" style="font-size: 13px;">Settings</h6>
            <span class="text-muted" style="font-size: 11px;">Clinic & Fees</span>
          </div>
        </a>
      </div>
    </div>

    <!-- Analytics Charts Row -->
    <div class="row g-3 mb-4">
      <!-- 7-Day Performance & Trends -->
      <div class="col-lg-8">
        <div class="card card-rounded shadow-sm border-0 h-100" style="border-radius: 16px;">
          <div class="card-header-clean">
            <div>
              <h5 class="card-title fw-bold mb-1 text-dark">Weekly Analytics (Last 7 Days)</h5>
              <p class="text-muted small mb-0">Daily confirmed appointment volume & revenue stream</p>
            </div>
            <div class="d-flex align-items-center gap-2">
              <span class="badge badge-soft-primary px-2 py-1"><i class="mdi mdi-chart-line"></i> Daily Trend</span>
            </div>
          </div>
          <div class="card-body p-4">
            <div style="position: relative; height: 300px; width: 100%;">
              <canvas id="weeklyTrendsChart"></canvas>
            </div>
          </div>
        </div>
      </div>

      <!-- Booking Status Breakdown (Donut Chart) -->
      <div class="col-lg-4">
        <div class="card card-rounded shadow-sm border-0 h-100" style="border-radius: 16px;">
          <div class="card-header-clean">
            <div>
              <h5 class="card-title fw-bold mb-1 text-dark">Status Breakdown</h5>
              <p class="text-muted small mb-0">All-time booking status distribution</p>
            </div>
          </div>
          <div class="card-body p-4 d-flex flex-column justify-content-between">
            <div style="position: relative; height: 210px; width: 100%;">
              <canvas id="statusBreakdownChart"></canvas>
            </div>
            <div class="mt-3 pt-3 border-top">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="small text-muted"><i class="mdi mdi-circle text-success me-1"></i> Confirmed</span>
                <span class="fw-bold small">{{ $confirmed_booking }} ({{ $booking > 0 ? round(($confirmed_booking / $booking) * 100) : 0 }}%)</span>
              </div>
              <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="small text-muted"><i class="mdi mdi-circle text-warning me-1"></i> Pending</span>
                <span class="fw-bold small">{{ $pending_booking }} ({{ $booking > 0 ? round(($pending_booking / $booking) * 100) : 0 }}%)</span>
              </div>
              <div class="d-flex align-items-center justify-content-between">
                <span class="small text-muted"><i class="mdi mdi-circle text-danger me-1"></i> Cancelled</span>
                <span class="fw-bold small">{{ $cancelled_booking }} ({{ $booking > 0 ? round(($cancelled_booking / $booking) * 100) : 0 }}%)</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Today's Appointment Schedule Table -->
    <div class="row mb-4">
      <div class="col-12">
        <div class="card card-rounded shadow-sm border-0" style="border-radius: 16px;">
          <div class="card-header-clean">
            <div>
              <h5 class="card-title fw-bold mb-1 text-dark">
                <i class="mdi mdi-calendar-today text-primary me-2"></i>Today's Appointment Schedule
              </h5>
              <p class="text-muted small mb-0">Appointments scheduled for {{ \Carbon\Carbon::today()->format('d M Y') }}</p>
            </div>
            <div>
              <span class="badge badge-soft-primary fs-6 px-3 py-2 rounded-pill">
                {{ count($today_orders) }} Scheduled Today
              </span>
            </div>
          </div>
          <div class="card-body p-0">
            @if(count($today_orders) > 0)
              <div class="table-responsive">
                <table class="table table-custom table-hover mb-0">
                  <thead>
                    <tr>
                      <th>Patient Name</th>
                      <th>Time Slot</th>
                      <th>Contact Info</th>
                      <th>Problem / Reason</th>
                      <th>Amount</th>
                      <th>Status</th>
                      <th class="text-end">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($today_orders as $order)
                    <tr>
                      <td>
                        <div class="d-flex align-items-center gap-3">
                          <div class="avatar-initials">
                            {{ strtoupper(substr($order->first_name ?? 'P', 0, 1)) }}
                          </div>
                          <div>
                            <h6 class="fw-bold mb-0 text-dark">{{ $order->first_name }} {{ $order->last_name }}</h6>
                            <span class="text-muted small">{{ $order->age ? $order->age . ' Yrs' : '' }} {{ $order->sex ? '&bull; ' . ucfirst($order->sex) : '' }}</span>
                          </div>
                        </div>
                      </td>
                      <td>
                        <span class="badge badge-soft-info py-2 px-3 fw-semibold">
                          <i class="mdi mdi-clock-outline me-1"></i> {{ $order->from_time ?? 'N/A' }} - {{ $order->to_time ?? '' }}
                        </span>
                      </td>
                      <td>
                        <div class="text-dark fw-medium">{{ $order->mobile_no ?? 'N/A' }}</div>
                        <small class="text-muted">{{ $order->customer_email ?? '' }}</small>
                      </td>
                      <td>
                        <span class="text-muted text-truncate d-inline-block" style="max-width: 180px;" title="{{ $order->patient_problem }}">
                          {{ $order->patient_problem ?? 'Routine consultation' }}
                        </span>
                      </td>
                      <td>
                        <span class="fw-bold text-dark">₹{{ number_format($order->total_amount, 2) }}</span>
                      </td>
                      <td>
                        @if($order->status == 'confirmed')
                          <span class="badge badge-soft-success px-3 py-1">Confirmed</span>
                        @elseif($order->status == 'cancelled')
                          <span class="badge badge-soft-danger px-3 py-1">Cancelled</span>
                        @else
                          <span class="badge badge-soft-warning px-3 py-1">{{ ucfirst($order->status) }}</span>
                        @endif
                      </td>
                      <td class="text-end">
                        <div class="dropdown">
                          <button class="btn btn-sm btn-outline-secondary dropdown-toggle py-1 px-2" type="button" data-bs-toggle="dropdown">
                            Actions
                          </button>
                          <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li>
                              <a class="dropdown-item" href="{{ url('admin/booking-history/view/'.$order->id) }}">
                                <i class="mdi mdi-eye text-primary me-2"></i> View Details
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item" href="{{ url('invoice/'.$order->id) }}?from=admin" target="_blank">
                                <i class="mdi mdi-file-document-outline text-info me-2"></i> View Invoice
                              </a>
                            </li>
                            <li>
                              <a class="dropdown-item" href="{{ url('admin/patient-history/status-change/'.$order->id) }}">
                                <i class="mdi mdi-square-edit-outline text-warning me-2"></i> Update Status
                              </a>
                            </li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @else
              <div class="empty-state-box">
                <div class="mb-3">
                  <i class="mdi mdi-calendar-blank-outline text-muted" style="font-size: 54px;"></i>
                </div>
                <h5 class="fw-bold text-dark mb-1">No Appointments Scheduled for Today</h5>
                <p class="text-muted small mb-3">There are currently no patient appointments booked for today.</p>
                <a href="{{ url('admin/patient') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                  <i class="mdi mdi-plus-circle me-1"></i> Book New Patient
                </a>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Bookings and Cancelled Attention Section -->
    <div class="row g-3">
      <!-- Recent Bookings -->
      <div class="col-lg-8">
        <div class="card card-rounded shadow-sm border-0 h-100" style="border-radius: 16px;">
          <div class="card-header-clean">
            <div>
              <h5 class="card-title fw-bold mb-1 text-dark">Recent Bookings</h5>
              <p class="text-muted small mb-0">Latest bookings received across all dates</p>
            </div>
            <a href="{{ url('admin/booking_history') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
              View All <i class="mdi mdi-arrow-right ms-1"></i>
            </a>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-custom table-hover mb-0">
                <thead>
                  <tr>
                    <th>Patient</th>
                    <th>Booking Date & Slot</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th class="text-end">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($recent_orders as $order)
                  <tr>
                    <td>
                      <div class="d-flex align-items-center gap-2">
                        <div class="avatar-initials" style="width: 32px; height: 32px; font-size: 12px;">
                          {{ strtoupper(substr($order->first_name ?? 'P', 0, 1)) }}
                        </div>
                        <div>
                          <span class="fw-bold text-dark d-block">{{ $order->first_name }} {{ $order->last_name }}</span>
                          <small class="text-muted">{{ $order->mobile_no }}</small>
                        </div>
                      </div>
                    </td>
                    <td>
                      <div class="text-dark fw-medium">{{ \Carbon\Carbon::parse($order->booking_date)->format('d M, Y') }}</div>
                      <small class="text-muted">{{ $order->from_time ?? '' }} - {{ $order->to_time ?? '' }}</small>
                    </td>
                    <td>
                      <span class="fw-bold text-dark">₹{{ number_format($order->total_amount, 2) }}</span>
                    </td>
                    <td>
                      @if($order->status == 'confirmed')
                        <span class="badge badge-soft-success px-2 py-1">Confirmed</span>
                      @elseif($order->status == 'cancelled')
                        <span class="badge badge-soft-danger px-2 py-1">Cancelled</span>
                      @else
                        <span class="badge badge-soft-warning px-2 py-1">{{ ucfirst($order->status) }}</span>
                      @endif
                    </td>
                    <td class="text-end">
                      <a href="{{ url('admin/booking-history/view/'.$order->id) }}" class="btn btn-sm btn-light text-primary py-1 px-2" title="View Details">
                        <i class="mdi mdi-eye"></i>
                      </a>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="5" class="text-center py-4 text-muted">No booking records found.</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- Cancelled / Attention Feed -->
      <div class="col-lg-4">
        <div class="card card-rounded shadow-sm border-0 h-100" style="border-radius: 16px;">
          <div class="card-header-clean">
            <div>
              <h5 class="card-title fw-bold mb-1 text-dark">Cancelled Bookings</h5>
              <p class="text-muted small mb-0">Recent cancellations needing review</p>
            </div>
            <span class="badge badge-soft-danger">{{ count($cancelled_booking_lists) }} Recent</span>
          </div>
          <div class="card-body p-3">
            @forelse($cancelled_booking_lists as $order)
            <div class="p-3 mb-2 rounded-3 border bg-light">
              <div class="d-flex justify-content-between align-items-start mb-1">
                <h6 class="fw-bold mb-0 text-dark">{{ $order->first_name }} {{ $order->last_name }}</h6>
                <span class="badge badge-soft-danger" style="font-size: 10px;">Cancelled</span>
              </div>
              <p class="text-muted small mb-2">
                <i class="mdi mdi-calendar me-1"></i> {{ \Carbon\Carbon::parse($order->booking_date)->format('d M Y') }} &bull; {{ $order->from_time }} - {{ $order->to_time }}
              </p>
              <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted"><i class="mdi mdi-phone me-1"></i> {{ $order->mobile_no ?? 'N/A' }}</small>
                <a href="{{ url('admin/booking-history/view/'.$order->id) }}" class="small fw-bold text-primary text-decoration-none">
                  Review <i class="mdi mdi-chevron-right"></i>
                </a>
              </div>
            </div>
            @empty
            <div class="text-center py-4 text-muted">
              <i class="mdi mdi-check-circle-outline text-success" style="font-size: 38px;"></i>
              <p class="small mt-2 mb-0">No recent cancellations.</p>
            </div>
            @endforelse
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection

@section('js')
<script>
  $(document).ready(function() {
    // 1. Weekly Performance Chart (Bookings & Revenue)
    const labels = {!! $chart_labels !!};
    const bookingsData = {!! $chart_bookings !!};
    const revenueData = {!! $chart_revenue !!};

    const ctxTrend = document.getElementById('weeklyTrendsChart');
    if (ctxTrend) {
      new Chart(ctxTrend, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [
            {
              label: 'Confirmed Appointments',
              data: bookingsData,
              backgroundColor: 'rgba(59, 130, 246, 0.85)',
              borderRadius: 8,
              yAxisID: 'y',
              barPercentage: 0.5,
            },
            {
              type: 'line',
              label: 'Revenue (₹)',
              data: revenueData,
              borderColor: '#10b981',
              backgroundColor: 'rgba(16, 185, 129, 0.15)',
              borderWidth: 3,
              fill: true,
              tension: 0.35,
              pointBackgroundColor: '#10b981',
              pointRadius: 4,
              yAxisID: 'y1',
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          interaction: {
            mode: 'index',
            intersect: false,
          },
          scales: {
            x: {
              grid: { display: false }
            },
            y: {
              type: 'linear',
              display: true,
              position: 'left',
              title: { display: true, text: 'Appointments' },
              ticks: { stepSize: 1, precision: 0 },
              grid: { color: '#f1f5f9' }
            },
            y1: {
              type: 'linear',
              display: true,
              position: 'right',
              title: { display: true, text: 'Revenue (₹)' },
              grid: { drawOnChartArea: false },
              ticks: {
                callback: function(value) { return '₹' + value; }
              }
            }
          },
          plugins: {
            legend: {
              position: 'top',
              labels: { usePointStyle: true, boxWidth: 8 }
            },
            tooltip: {
              callbacks: {
                label: function(context) {
                  if (context.dataset.yAxisID === 'y1') {
                    return 'Revenue: ₹' + context.parsed.y.toLocaleString('en-IN');
                  }
                  return 'Appointments: ' + context.parsed.y;
                }
              }
            }
          }
        }
      });
    }

    // 2. Status Breakdown Donut Chart
    const statusData = {!! $chart_status_data !!};
    const ctxStatus = document.getElementById('statusBreakdownChart');
    if (ctxStatus) {
      new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
          labels: ['Confirmed', 'Pending', 'Cancelled'],
          datasets: [{
            data: statusData,
            backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
            hoverOffset: 6,
            borderWidth: 2,
            borderColor: '#ffffff'
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          cutout: '72%',
          plugins: {
            legend: { display: false },
            tooltip: {
              callbacks: {
                label: function(context) {
                  const val = context.parsed;
                  const total = statusData.reduce((a, b) => a + b, 0);
                  const pct = total > 0 ? Math.round((val / total) * 100) : 0;
                  return ` ${context.label}: ${val} (${pct}%)`;
                }
              }
            }
          }
        }
      });
    }
  });
</script>
@endsection
