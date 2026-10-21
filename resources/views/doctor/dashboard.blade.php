@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  <!-- Super Admin Impersonation Notice Bar -->
  @if(session('impersonating_admin_id'))
  <div class="alert border-0 shadow-sm rounded-4 mb-4 p-3 d-flex align-items-center justify-content-between flex-wrap gap-2" style="background: #fff7ed; border-left: 5px solid #f97316 !important; border-radius: 14px;">
    <div class="d-flex align-items-center">
      <div class="rounded-circle p-2 bg-warning bg-opacity-25 text-warning font-22 me-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
        <i class="mdi mdi-shield-account"></i>
      </div>
      <div>
        <h6 class="font-weight-bold text-dark mb-0">Super Admin Visiting Doctor Portal</h6>
        <p class="text-muted mb-0 font-13">You are currently logged in as Dr. {{ Auth::user()->name }} ({{ $clinic->name }}).</p>
      </div>
    </div>
    <div class="d-flex align-items-center gap-2">
      <a href="{{ route('doctor.subscription.index') }}" class="btn btn-outline-warning font-weight-bold btn-sm text-dark px-3 py-2 shadow-sm" style="border-radius: 8px;">
        <i class="mdi mdi-crown text-warning me-1"></i> Visit Doctor Plan
      </a>
      <a href="{{ route('admin.saas.stop_impersonate') }}" class="btn btn-warning font-weight-bold btn-sm text-dark px-3 py-2 shadow-sm" style="border-radius: 8px;">
        <i class="mdi mdi-arrow-left-bold me-1"></i> Back to Super Admin
      </a>
    </div>
  </div>
  @endif

  <!-- Plan / Free Trial Alert Banner -->
  @if(!$clinic->isPlanActive())
  <div class="alert alert-danger d-flex align-items-center justify-content-between p-3 rounded-3 shadow-sm mb-4" role="alert">
    <div class="d-flex align-items-center">
      <i class="mdi mdi-alert-circle font-weight-bold" style="font-size: 28px; margin-right: 14px;"></i>
      <div>
        <h5 class="mb-1 font-weight-bold">Your Subscription Plan Has Expired!</h5>
        <p class="mb-0 text-muted">Your public patient booking page is currently disabled. Upgrade your plan to restore online bookings immediately.</p>
      </div>
    </div>
    <a href="{{ route('doctor.subscription.index') }}" class="btn btn-danger btn-sm font-weight-bold px-3 py-2">
      <i class="mdi mdi-crown"></i> Upgrade Now
    </a>
  </div>
  @elseif($clinic->status === 'trialing')
  <div class="alert alert-warning d-flex align-items-center justify-content-between p-3 rounded-3 shadow-sm mb-4" style="background-color: #fffbeb; border-color: #fde68a;" role="alert">
    <div class="d-flex align-items-center">
      <i class="mdi mdi-clock-fast text-warning" style="font-size: 28px; margin-right: 14px;"></i>
      <div>
        <h5 class="mb-1 font-weight-bold text-dark">7-Day Free Trial Active &mdash; {{ $clinic->trialDaysRemaining() }} Days Remaining</h5>
        <p class="mb-0 text-muted">Enjoy full access to all features. Upgrade to a paid plan before your trial ends to ensure zero downtime for your patients.</p>
      </div>
    </div>
    <a href="{{ route('doctor.subscription.index') }}" class="btn btn-primary btn-sm font-weight-bold px-3 py-2">
      <i class="mdi mdi-star"></i> View Plans & Upgrade
    </a>
  </div>
  @endif

  <!-- Top Hero Header -->
  <div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center flex-wrap">
      <div>
        <h2 class="font-weight-bold mb-1">{{ $clinic->name }}</h2>
        <p class="text-muted mb-0">
          <i class="mdi mdi-doctor text-primary"></i> Dr. {{ Auth::user()->name }} 
          @if($clinic->specialization) &bull; <span class="badge badge-light-primary">{{ $clinic->specialization }}</span> @endif
        </p>
      </div>
      <div class="mt-2 mt-sm-0 d-flex gap-2">
        @php
          $clinicUrl = $clinic->custom_domain 
            ? 'https://' . $clinic->custom_domain 
            : url('/c/' . ($clinic->subdomain ?? $clinic->slug));
        @endphp
        <a href="{{ $clinicUrl }}" target="_blank" class="btn btn-outline-primary btn-sm d-flex align-items-center gap-1 font-weight-bold">
          <i class="mdi mdi-open-in-new"></i> Visit Clinic Website
        </a>
        <a href="{{ route('doctor.settings') }}" class="btn btn-primary btn-sm d-flex align-items-center gap-1 font-weight-bold">
          <i class="mdi mdi-tune"></i> Clinic Settings
        </a>
      </div>
    </div>
  </div>

  <!-- KPI Cards -->
  <div class="row">
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
      <div class="card card-tale border-0 shadow-sm" style="background: linear-gradient(135deg, #2563eb, #1d4ed8); border-radius: 16px;">
        <div class="card-body text-white p-4">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <p class="mb-2 text-white-50 text-uppercase font-weight-bold" style="font-size: 12px; letter-spacing: 0.5px;">Today's Bookings</p>
              <h2 class="mb-0 font-weight-bold">{{ $todayPatients }}</h2>
            </div>
            <div style="background: rgba(255,255,255,0.2); width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
              <i class="mdi mdi-calendar-today" style="font-size: 24px;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
      <div class="card card-dark-blue border-0 shadow-sm" style="background: linear-gradient(135deg, #0284c7, #0369a1); border-radius: 16px;">
        <div class="card-body text-white p-4">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <p class="mb-2 text-white-50 text-uppercase font-weight-bold" style="font-size: 12px; letter-spacing: 0.5px;">Total Patients</p>
              <h2 class="mb-0 font-weight-bold">{{ $totalPatients }}</h2>
            </div>
            <div style="background: rgba(255,255,255,0.2); width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
              <i class="mdi mdi-account-multiple" style="font-size: 24px;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
      <div class="card card-light-blue border-0 shadow-sm" style="background: linear-gradient(135deg, #059669, #047857); border-radius: 16px;">
        <div class="card-body text-white p-4">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <p class="mb-2 text-white-50 text-uppercase font-weight-bold" style="font-size: 12px; letter-spacing: 0.5px;">Consultation Fees Collected</p>
              <h2 class="mb-0 font-weight-bold">₹{{ number_format($totalEarnings, 2) }}</h2>
            </div>
            <div style="background: rgba(255,255,255,0.2); width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
              <i class="mdi mdi-currency-inr" style="font-size: 24px;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
      <div class="card card-light-danger border-0 shadow-sm" style="background: linear-gradient(135deg, #7c3aed, #6d28d9); border-radius: 16px;">
        <div class="card-body text-white p-4">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <p class="mb-2 text-white-50 text-uppercase font-weight-bold" style="font-size: 12px; letter-spacing: 0.5px;">Active Plan Status</p>
              <h4 class="mb-0 font-weight-bold text-uppercase">{{ $clinic->status }}</h4>
            </div>
            <div style="background: rgba(255,255,255,0.2); width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
              <i class="mdi mdi-shield-check" style="font-size: 24px;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Clinic Share Links Box -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="card border-0 shadow-sm rounded-4" style="border-radius: 16px;">
        <div class="card-body p-4">
          <h5 class="card-title font-weight-bold mb-3"><i class="mdi mdi-share-variant text-primary mr-1"></i> Patient Booking Link</h5>
          <p class="text-muted font-14 mb-3">Share this URL on WhatsApp, business cards, prescription pads, and social media so patients can schedule appointments directly:</p>
          <div class="input-group">
            <input type="text" class="form-control" id="clinicBookingUrl" value="{{ $clinicUrl }}" readonly style="background: #f8fafc; font-weight: 600; font-size: 15px;">
            <button class="btn btn-primary font-weight-bold px-4" type="button" onclick="copyClinicUrl()">
              <i class="mdi mdi-content-copy mr-1"></i> Copy Link
            </button>
            <a href="{{ $clinicUrl }}" target="_blank" class="btn btn-outline-secondary px-3">
              <i class="mdi mdi-open-in-new"></i>
            </a>
          </div>
          <small id="copySuccessMsg" class="text-success mt-2 font-weight-bold" style="display: none;">
            <i class="mdi mdi-check-circle"></i> Link copied to clipboard!
          </small>
        </div>
      </div>
    </div>
  </div>

  <!-- Recent Bookings Table -->
  <div class="row">
    <div class="col-12 grid-margin stretch-card">
      <div class="card border-0 shadow-sm rounded-4" style="border-radius: 16px;">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title font-weight-bold mb-0"><i class="mdi mdi-clipboard-text-clock mr-1 text-primary"></i> Recent Patient Bookings</h5>
            <a href="{{ url('admin/patient') }}" class="btn btn-sm btn-link text-primary font-weight-bold">View All &rarr;</a>
          </div>

          <div class="table-responsive">
            <table class="table table-hover">
              <thead class="bg-light">
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
                  <td>{{ Str::limit($booking->patient_problem ?? 'Routine Checkup', 30) }}</td>
                  <td>{{ $booking->created_at ? $booking->created_at->format('d M, Y') : 'N/A' }}</td>
                  <td>
                    @if($booking->status == 1 || strtolower($booking->status) == 'completed')
                      <span class="badge badge-success">Confirmed</span>
                    @else
                      <span class="badge badge-primary">Pending</span>
                    @endif
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="6" class="text-center py-4 text-muted">
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
