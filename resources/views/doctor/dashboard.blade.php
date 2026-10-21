@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  @php
    $clinicUrl = $clinic->custom_domain 
      ? 'https://' . $clinic->custom_domain 
      : url('/c/' . ($clinic->subdomain ?? $clinic->slug));
    $expiryDate = $clinic->subscription_expires_at 
      ? \Carbon\Carbon::parse($clinic->subscription_expires_at)->format('d M Y')
      : ($clinic->trial_ends_at ? \Carbon\Carbon::parse($clinic->trial_ends_at)->format('d M Y') : 'Active');
  @endphp

  <!-- Top Hero Clinic Profile Card (Matching Reference Dashboard Design) -->
  <div class="card border mb-4 shadow-sm" style="background: #ffffff; border-radius: 16px; border-color: #f1f5f9 !important;">
    <div class="card-body p-4">
      <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap: 16px;">
        <!-- Left: Red Avatar & Clinic Details -->
        <div class="d-flex align-items-center flex-wrap" style="gap: 16px;">
          <div style="width: 56px; height: 56px; border-radius: 14px; background: #dc2626; color: #fff; font-size: 26px; font-weight: 800; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 14px rgba(220, 38, 38, 0.25); flex-shrink: 0;">
            {{ strtoupper(substr($clinic->name, 0, 1)) }}
          </div>
          <div>
            <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
              <h3 class="font-weight-bold text-dark mb-0" style="font-size: 22px;">{{ $clinic->name }}</h3>
              <span class="badge px-3 py-1 rounded-pill font-weight-bold" style="background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; font-size: 11.5px;">
                {{ $clinic->specialization ?? 'Healthcare Clinic' }} ({{ ucfirst($clinic->status) }})
              </span>
              <span class="badge px-3 py-1 rounded-pill font-weight-bold" style="background: #ecfeff; color: #0e7490; border: 1px solid #a5f3fc; font-size: 11.5px;">
                <span style="display: inline-block; width: 6px; height: 6px; border-radius: 50%; background: #06b6d4; margin-right: 4px;"></span>
                Live Clinic Portal
              </span>
            </div>
            <div class="text-muted font-12 mt-1 d-flex align-items-center flex-wrap" style="gap: 8px;">
              <span>City: <strong class="text-dark">{{ $clinic->city ?? 'Bangalore, India' }}</strong></span>
              <span>&bull;</span>
              <span>Doctor: <strong class="text-dark">Dr. {{ Auth::user()->name ?? ($clinic->user->name ?? 'Doctor') }}</strong></span>
              <span>&bull;</span>
              <span>Plan Status: <strong class="text-success">{{ $clinic->status === 'trialing' ? $clinic->trialDaysRemaining().' days remaining' : ($clinic->isPlanActive() ? 'Active' : 'Expired') }}</strong></span>
              <span>&bull;</span>
              <span>Expiry: <strong class="text-dark">{{ $expiryDate }}</strong></span>
            </div>
          </div>
        </div>

        <!-- Right: Action Buttons Matching Reference Screenshot -->
        <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
          <a href="{{ route('doctor.settings') }}" class="btn btn-dark btn-sm font-weight-bold px-3 py-2 text-white" style="background: #0f172a; border-radius: 8px; font-size: 12.5px;">
            <i class="mdi mdi-pencil-outline me-1"></i> Edit Profile & Clinic
          </a>
          <a href="{{ URL::To('admin/patient') }}" class="btn btn-danger btn-sm font-weight-bold px-3 py-2 text-white" style="background: #dc2626; border-radius: 8px; font-size: 12.5px;">
            <i class="mdi mdi-plus me-1"></i> + New Booking
          </a>
          <a href="{{ route('doctor.pages.index') }}" class="btn btn-outline-secondary btn-sm font-weight-bold px-3 py-2" style="border-radius: 8px; font-size: 12.5px; border-color: #e2e8f0; color: #475569; background: #ffffff;">
            <i class="mdi mdi-file-document-edit-outline me-1"></i> Website Builder
          </a>
          <a href="{{ route('doctor.subscription.index') }}" class="btn btn-outline-secondary btn-sm font-weight-bold px-3 py-2" style="border-radius: 8px; font-size: 12.5px; border-color: #e2e8f0; color: #475569; background: #ffffff;">
            <i class="mdi mdi-credit-card-outline me-1"></i> Subscription
          </a>
          <a href="{{ $clinicUrl }}" target="_blank" class="btn btn-outline-secondary btn-sm px-2 py-2" style="border-radius: 8px; border-color: #e2e8f0; color: #475569; background: #ffffff;" title="View Public Storefront">
            <i class="mdi mdi-open-in-new font-16"></i>
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- KPI Metrics Grid (6 Minimalist Modern Cards Matching Reference Screenshot) -->
  <div class="row g-3 mb-4">
    <!-- Card 1: Today's Bookings -->
    <div class="col-xl-2 col-lg-4 col-sm-6">
      <div class="card border h-100 shadow-sm" style="background: #ffffff; border-radius: 14px; border-color: #f1f5f9 !important;">
        <div class="card-body p-3 d-flex flex-column justify-content-between">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="text-uppercase font-weight-bold font-11 text-muted" style="letter-spacing: 0.5px;">TODAY BOOKINGS</span>
            <div style="width: 28px; height: 28px; border-radius: 8px; background: #fee2e2; color: #dc2626; display: flex; align-items: center; justify-content: center; font-size: 14px;">
              <i class="mdi mdi-calendar-today"></i>
            </div>
          </div>
          <h2 class="font-weight-bold text-dark mb-2" style="font-size: 28px;">{{ $todayPatients }}</h2>
          <div class="d-flex align-items-center justify-content-between font-11 text-muted">
            <span>Appointments</span>
            <span class="badge" style="background: #ecfdf5; color: #065f46; font-size: 10px; font-weight: 700;">Today</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Card 2: Total Patients -->
    <div class="col-xl-2 col-lg-4 col-sm-6">
      <div class="card border h-100 shadow-sm" style="background: #ffffff; border-radius: 14px; border-color: #f1f5f9 !important;">
        <div class="card-body p-3 d-flex flex-column justify-content-between">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="text-uppercase font-weight-bold font-11 text-muted" style="letter-spacing: 0.5px;">TOTAL PATIENTS</span>
            <div style="width: 28px; height: 28px; border-radius: 8px; background: #e0e7ff; color: #4338ca; display: flex; align-items: center; justify-content: center; font-size: 14px;">
              <i class="mdi mdi-account-group"></i>
            </div>
          </div>
          <h2 class="font-weight-bold text-dark mb-2" style="font-size: 28px;">{{ $totalPatients }}</h2>
          <div class="d-flex align-items-center justify-content-between font-11 text-muted">
            <span>Active records</span>
            <span class="badge" style="background: #eff6ff; color: #1d4ed8; font-size: 10px; font-weight: 700;">Directory</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Card 3: Total Orders / Appointments -->
    <div class="col-xl-2 col-lg-4 col-sm-6">
      <div class="card border h-100 shadow-sm" style="background: #ffffff; border-radius: 14px; border-color: #f1f5f9 !important;">
        <div class="card-body p-3 d-flex flex-column justify-content-between">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="text-uppercase font-weight-bold font-11 text-muted" style="letter-spacing: 0.5px;">ALL BOOKINGS</span>
            <div style="width: 28px; height: 28px; border-radius: 8px; background: #ccfbf1; color: #0f766e; display: flex; align-items: center; justify-content: center; font-size: 14px;">
              <i class="mdi mdi-clipboard-text-clock"></i>
            </div>
          </div>
          <h2 class="font-weight-bold text-dark mb-2" style="font-size: 28px;">{{ $totalOrders }}</h2>
          <div class="d-flex align-items-center justify-content-between font-11 text-muted">
            <span>Total consultations</span>
            <span class="badge" style="background: #f0fdfa; color: #0f766e; font-size: 10px; font-weight: 700;">All-Time</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Card 4: Settled Revenue (Razorpay) -->
    <div class="col-xl-2 col-lg-4 col-sm-6">
      <div class="card border h-100 shadow-sm" style="background: #ffffff; border-radius: 14px; border-color: #f1f5f9 !important;">
        <div class="card-body p-3 d-flex flex-column justify-content-between">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="text-uppercase font-weight-bold font-11 text-muted" style="letter-spacing: 0.5px;">SETTLED REVENUE</span>
            <div style="width: 28px; height: 28px; border-radius: 8px; background: #fef3c7; color: #b45309; display: flex; align-items: center; justify-content: center; font-size: 14px;">
              <i class="mdi mdi-currency-inr"></i>
            </div>
          </div>
          <h2 class="font-weight-bold text-dark mb-2 text-truncate" style="font-size: 22px;">₹{{ number_format($totalEarnings, 2) }}</h2>
          <div class="d-flex align-items-center justify-content-between font-11 text-muted">
            <span>Razorpay Ledger</span>
            <span class="badge" style="background: #fffbeb; color: #b45309; font-size: 10px; font-weight: 700;">Captured</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Card 5: Active Time Slots -->
    <div class="col-xl-2 col-lg-4 col-sm-6">
      <div class="card border h-100 shadow-sm" style="background: #ffffff; border-radius: 14px; border-color: #f1f5f9 !important;">
        <div class="card-body p-3 d-flex flex-column justify-content-between">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="text-uppercase font-weight-bold font-11 text-muted" style="letter-spacing: 0.5px;">ACTIVE SLOTS</span>
            <div style="width: 28px; height: 28px; border-radius: 8px; background: #f3e8ff; color: #7e22ce; display: flex; align-items: center; justify-content: center; font-size: 14px;">
              <i class="mdi mdi-clock-outline"></i>
            </div>
          </div>
          <h2 class="font-weight-bold text-dark mb-2" style="font-size: 28px;">{{ $totalSlots }}</h2>
          <div class="d-flex align-items-center justify-content-between font-11 text-muted">
            <span>Daily schedule</span>
            <span class="badge" style="background: #faf5ff; color: #7e22ce; font-size: 10px; font-weight: 700;">Slots</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Card 6: Authorized Staff -->
    <div class="col-xl-2 col-lg-4 col-sm-6">
      <div class="card border h-100 shadow-sm" style="background: #ffffff; border-radius: 14px; border-color: #f1f5f9 !important;">
        <div class="card-body p-3 d-flex flex-column justify-content-between">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <span class="text-uppercase font-weight-bold font-11 text-muted" style="letter-spacing: 0.5px;">CLINIC TEAM</span>
            <div style="width: 28px; height: 28px; border-radius: 8px; background: #ffe4e6; color: #be123c; display: flex; align-items: center; justify-content: center; font-size: 14px;">
              <i class="mdi mdi-doctor"></i>
            </div>
          </div>
          <h2 class="font-weight-bold text-dark mb-2" style="font-size: 28px;">{{ $totalStaff }}</h2>
          <div class="d-flex align-items-center justify-content-between font-11 text-muted">
            <span>Doctors & Staff</span>
            <span class="badge" style="background: #fff1f2; color: #be123c; font-size: 10px; font-weight: 700;">Team</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Clinic Share Link Card -->
  <div class="card border mb-4 shadow-sm" style="background: #ffffff; border-radius: 16px; border-color: #f1f5f9 !important;">
    <div class="card-body p-4">
      <div class="d-flex align-items-center justify-content-between mb-2">
        <h5 class="card-title font-weight-bold mb-0 text-dark">
          <i class="mdi mdi-share-variant text-primary me-2"></i> Patient Online Booking Link
        </h5>
        <span class="badge bg-light text-muted font-11">Public Storefront</span>
      </div>
      <p class="text-muted font-13 mb-3">Share this URL on WhatsApp, prescription slips, or social media so patients can schedule appointments directly:</p>
      <div class="input-group">
        <input type="text" class="form-control" id="clinicBookingUrl" value="{{ $clinicUrl }}" readonly style="background: #f8fafc; font-weight: 600; font-size: 14px; border-radius: 8px 0 0 8px;">
        <button class="btn btn-primary font-weight-bold px-4" type="button" onclick="copyClinicUrl()" style="border-radius: 0;">
          <i class="mdi mdi-content-copy me-1"></i> Copy Link
        </button>
        <a href="{{ $clinicUrl }}" target="_blank" class="btn btn-outline-secondary px-3 d-flex align-items-center" style="border-radius: 0 8px 8px 0; border-color: #e2e8f0;">
          <i class="mdi mdi-open-in-new"></i>
        </a>
      </div>
      <small id="copySuccessMsg" class="text-success mt-2 font-weight-bold" style="display: none;">
        <i class="mdi mdi-check-circle"></i> Link copied to clipboard!
      </small>
    </div>
  </div>

  <!-- Recent Bookings Table Card -->
  <div class="card border shadow-sm mb-4" style="background: #ffffff; border-radius: 16px; border-color: #f1f5f9 !important;">
    <div class="card-body p-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
          <h5 class="card-title font-weight-bold mb-1 text-dark">
            <i class="mdi mdi-clipboard-text-clock me-2 text-primary"></i> Recent Patient Bookings
          </h5>
          <p class="text-muted font-12 mb-0">Live service bay queue, maintenance logs, and visitor delivery schedule.</p>
        </div>
        <a href="{{ url('admin/patient') }}" class="btn btn-sm btn-link text-primary font-weight-bold text-decoration-none">
          View All &rarr;
        </a>
      </div>

      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Patient Name</th>
              <th>Phone Number</th>
              <th>Gender / Age</th>
              <th>Problem / Complaint</th>
              <th>Date Registered</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse($recentBookings as $booking)
            <tr>
              <td class="font-weight-bold text-dark">{{ $booking->first_name }} {{ $booking->last_name }}</td>
              <td>{{ $booking->mobile_no }}</td>
              <td>{{ $booking->sex ?? 'N/A' }} / {{ $booking->age ?? 'N/A' }}</td>
              <td>{{ Str::limit($booking->patient_problem ?? 'Routine Consultation', 30) }}</td>
              <td>{{ $booking->created_at ? $booking->created_at->format('d M, Y') : 'N/A' }}</td>
              <td>
                @if($booking->status == 1 || strtolower($booking->status) == 'completed')
                  <span class="badge" style="background: #ecfdf5; color: #065f46; font-weight: 700; padding: 6px 12px; border-radius: 6px;">Confirmed</span>
                @else
                  <span class="badge" style="background: #eff6ff; color: #1d4ed8; font-weight: 700; padding: 6px 12px; border-radius: 6px;">Pending</span>
                @endif
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="text-center py-5 text-muted">
                <i class="mdi mdi-calendar-blank-outline font-36 d-block mb-2 text-muted"></i>
                No bookings recorded yet for this clinic. Share your booking link to start receiving patient appointments!
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
function copyClinicUrl() {
  const copyText = document.getElementById("clinicBookingUrl");
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  navigator.clipboard.writeText(copyText.value);
  
  const msg = document.getElementById("copySuccessMsg");
  msg.style.display = "inline-block";
  setTimeout(() => {
    msg.style.display = "none";
  }, 3000);
}
</script>
@endsection
