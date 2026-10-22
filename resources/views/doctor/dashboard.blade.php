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
    $waShareText = urlencode("Book your doctor consultation online at {$clinic->name}: " . $clinicUrl);
  @endphp

  <!-- Top Hero Clinic Profile Card (Matching Reference Dashboard Design) -->
  <div class="card border mb-4 shadow-sm" style="background: #ffffff; border-radius: 16px; border-color: #f1f5f9 !important;">
    <div class="card-body p-4">
      <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap: 16px;">
        <!-- Left: Clinic Logo/Avatar & Clinic Details -->
        <div class="d-flex align-items-center flex-wrap" style="gap: 16px;">
          @if($clinic->logo)
            <img src="{{ $clinic->logo_url ?? URL::to('public/' . $clinic->logo) }}" alt="{{ $clinic->name }}" style="width: 58px; height: 58px; border-radius: 14px; object-fit: contain; background: #ffffff; border: 1px solid #e2e8f0; padding: 4px; box-shadow: 0 4px 14px rgba(0,0,0,0.06); flex-shrink: 0;">
          @else
            <div style="width: 58px; height: 58px; border-radius: 14px; background: var(--theme-primary-gradient, linear-gradient(135deg, #059669, #10b981)); color: #fff; font-size: 26px; font-weight: 800; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 14px var(--theme-primary-glow, rgba(5, 150, 105, 0.25)); flex-shrink: 0;">
              {{ strtoupper(substr($clinic->name, 0, 1)) }}
            </div>
          @endif
          <div>
            <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
              <h3 class="font-weight-bold text-dark mb-0" style="font-size: 22px;">{{ $clinic->name }}</h3>
              <span class="badge px-3 py-1 rounded-pill font-weight-bold" style="background: var(--theme-primary-subtle, #ecfdf5); color: var(--theme-primary, #059669); border: 1px solid var(--theme-primary-border, #a7f3d0); font-size: 11.5px;">
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

        <!-- Right: Action Buttons & Period Selector -->
        <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">
          <!-- Period Selector Form -->
          <form method="GET" action="{{ route('clinic.dashboard') }}" class="d-inline-flex align-items-center">
            <select name="range" class="form-select form-select-sm font-weight-bold shadow-sm" style="border-radius: 8px; font-size: 12.5px; border-color: #cbd5e1; height: 35px; width: 135px;" onchange="this.form.submit()">
              <option value="7_days" {{ $range == '7_days' ? 'selected' : '' }}>Last 7 Days</option>
              <option value="14_days" {{ $range == '14_days' ? 'selected' : '' }}>Last 14 Days</option>
              <option value="30_days" {{ $range == '30_days' ? 'selected' : '' }}>Last 30 Days</option>
              <option value="90_days" {{ $range == '90_days' ? 'selected' : '' }}>Last 90 Days</option>
            </select>
          </form>

          <a href="{{ route('clinic.settings') }}" class="btn btn-dark btn-sm font-weight-bold px-3 py-2 text-white" style="background: #0f172a; border-radius: 8px; font-size: 12.5px;">
            <i class="mdi mdi-pencil-outline me-1"></i> Edit Profile & Clinic
          </a>
          <a href="{{ URL::To('admin/patient') }}" class="btn btn-primary btn-sm font-weight-bold px-3 py-2 text-white" style="border-radius: 8px; font-size: 12.5px;">
            <i class="mdi mdi-plus me-1"></i> + New Booking
          </a>
          <a href="{{ route('clinic.services.index') }}" class="btn btn-outline-secondary btn-sm font-weight-bold px-3 py-2" style="border-radius: 8px; font-size: 12.5px; border-color: #e2e8f0; color: #475569; background: #ffffff;">
            <i class="mdi mdi-medical-bag me-1"></i> Manage Services
          </a>
          <a href="{{ route('clinic.pages.index') }}" class="btn btn-outline-secondary btn-sm font-weight-bold px-3 py-2" style="border-radius: 8px; font-size: 12.5px; border-color: #e2e8f0; color: #475569; background: #ffffff;">
            <i class="mdi mdi-file-document-edit-outline me-1"></i> Website Builder
          </a>
          <a href="{{ route('clinic.subscription.index') }}" class="btn btn-outline-secondary btn-sm font-weight-bold px-3 py-2" style="border-radius: 8px; font-size: 12.5px; border-color: #e2e8f0; color: #475569; background: #ffffff;">
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
            <div style="width: 30px; height: 30px; border-radius: 8px; background: #fee2e2; color: #dc2626; display: flex; align-items: center; justify-content: center; font-size: 15px;">
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
            <div style="width: 30px; height: 30px; border-radius: 8px; background: #e0e7ff; color: #4338ca; display: flex; align-items: center; justify-content: center; font-size: 15px;">
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
            <div style="width: 30px; height: 30px; border-radius: 8px; background: #ccfbf1; color: #0f766e; display: flex; align-items: center; justify-content: center; font-size: 15px;">
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
            <div style="width: 30px; height: 30px; border-radius: 8px; background: #fef3c7; color: #b45309; display: flex; align-items: center; justify-content: center; font-size: 15px;">
              <i class="mdi mdi-currency-inr"></i>
            </div>
          </div>
          <h2 class="font-weight-bold text-dark mb-1 text-truncate" style="font-size: 22px;">₹{{ number_format($totalEarnings, 2) }}</h2>
          <div class="d-flex align-items-center justify-content-between font-11 text-muted">
            <span>Online: ₹{{ number_format($onlineEarnings, 0) }}</span>
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
            <div style="width: 30px; height: 30px; border-radius: 8px; background: #f3e8ff; color: #7e22ce; display: flex; align-items: center; justify-content: center; font-size: 15px;">
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
            <div style="width: 30px; height: 30px; border-radius: 8px; background: #ffe4e6; color: #be123c; display: flex; align-items: center; justify-content: center; font-size: 15px;">
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
        <div class="d-flex align-items-center gap-2">
          <a href="https://wa.me/?text={{ $waShareText }}" target="_blank" class="btn btn-sm btn-success text-white font-weight-bold px-3 py-1" style="border-radius: 6px; font-size: 11.5px;">
            <i class="mdi mdi-whatsapp me-1"></i> Share via WhatsApp
          </a>
          <span class="badge bg-light text-muted font-11">Public Storefront</span>
        </div>
      </div>
      <p class="text-muted font-13 mb-3">Share this URL on WhatsApp, prescription slips, or social media so patients can schedule appointments directly:</p>
      <div class="input-group">
        <input type="text" class="form-control" id="clinicBookingUrl" value="{{ $clinicUrl }}" readonly style="background: #f8fafc; font-weight: 600; font-size: 13.5px; border-radius: 8px 0 0 8px;">
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

  <!-- ========================================================================= -->
  <!-- MULTI-CHART ANALYTICS SUITE                                               -->
  <!-- ========================================================================= -->

  <!-- Chart Row 1: Volume Trend & Revenue Velocity -->
  <div class="row g-3 mb-4">
    <!-- Chart 1: Daily Consultation Volume -->
    <div class="col-xl-6 col-lg-12">
      <div class="card border shadow-sm h-100" style="background: #ffffff; border-radius: 16px; border-color: #f1f5f9 !important;">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h5 class="card-title font-weight-bold mb-1 text-dark">
                <i class="mdi mdi-chart-timeline-variant me-2 text-primary"></i> Patient Consultations & Inflow Trend
              </h5>
              <p class="text-muted font-12 mb-0">Daily booking volume recorded across all outpatient slots.</p>
            </div>
            <span class="badge" style="background: #ecfdf5; color: #065f46; font-size: 11px; font-weight: 700;">
              Total: {{ $totalOrders }}
            </span>
          </div>
          <div style="height: 250px; position: relative;">
            <canvas id="consultationsVolumeChart"></canvas>
          </div>
        </div>
      </div>
    </div>

    <!-- Chart 2: Daily Settled Revenue -->
    <div class="col-xl-6 col-lg-12">
      <div class="card border shadow-sm h-100" style="background: #ffffff; border-radius: 16px; border-color: #f1f5f9 !important;">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h5 class="card-title font-weight-bold mb-1 text-dark">
                <i class="mdi mdi-cash-multiple me-2 text-success"></i> Settled Revenue Timeline (₹)
              </h5>
              <p class="text-muted font-12 mb-0">Daily consultation collections via online payment gateway and clinic desk.</p>
            </div>
            <span class="badge" style="background: #fef3c7; color: #b45309; font-size: 11px; font-weight: 700;">
              Avg: ₹{{ number_format($avgConsultationFee, 0) }}/visit
            </span>
          </div>
          <div style="height: 250px; position: relative;">
            <canvas id="revenueTrendChart"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Chart Row 2: Status, Payment Modes & Demographics Donut Suite -->
  <div class="row g-3 mb-4">
    <!-- Chart 3: Consultation Status -->
    <div class="col-xl-4 col-md-6">
      <div class="card border shadow-sm h-100" style="background: #ffffff; border-radius: 16px; border-color: #f1f5f9 !important;">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title font-weight-bold mb-0 text-dark" style="font-size: 15px;">
              <i class="mdi mdi-check-circle-outline text-primary me-2"></i> Booking Status Breakdown
            </h5>
            <span class="badge bg-light text-muted font-11">Status</span>
          </div>
          <div style="height: 210px; position: relative;">
            <canvas id="bookingStatusChart"></canvas>
          </div>
          <div class="d-flex justify-content-around text-center mt-3 pt-2 border-top">
            <div>
              <span class="d-block font-11 text-muted font-weight-bold">COMPLETED</span>
              <span class="font-weight-bold text-success font-14">{{ $completedConsultations }}</span>
            </div>
            <div>
              <span class="d-block font-11 text-muted font-weight-bold">PENDING</span>
              <span class="font-weight-bold text-warning font-14">{{ $pendingConsultations }}</span>
            </div>
            <div>
              <span class="d-block font-11 text-muted font-weight-bold">CANCELLED</span>
              <span class="font-weight-bold text-danger font-14">{{ $cancelledConsultations }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Chart 4: Payment Methods Breakdown -->
    <div class="col-xl-4 col-md-6">
      <div class="card border shadow-sm h-100" style="background: #ffffff; border-radius: 16px; border-color: #f1f5f9 !important;">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title font-weight-bold mb-0 text-dark" style="font-size: 15px;">
              <i class="mdi mdi-credit-card-check-outline text-success me-2"></i> Payment Mode Share
            </h5>
            <span class="badge bg-light text-muted font-11">Settlement</span>
          </div>
          <div style="height: 210px; position: relative;">
            <canvas id="paymentModeChart"></canvas>
          </div>
          <div class="d-flex justify-content-around text-center mt-3 pt-2 border-top">
            <div>
              <span class="d-block font-11 text-muted font-weight-bold">RAZORPAY ONLINE</span>
              <span class="font-weight-bold text-dark font-13">₹{{ number_format($onlineEarnings, 2) }}</span>
            </div>
            <div>
              <span class="d-block font-11 text-muted font-weight-bold">CASH AT CLINIC</span>
              <span class="font-weight-bold text-dark font-13">₹{{ number_format($cashEarnings, 2) }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Chart 5: Patient Gender Demographics -->
    <div class="col-xl-4 col-md-12">
      <div class="card border shadow-sm h-100" style="background: #ffffff; border-radius: 16px; border-color: #f1f5f9 !important;">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title font-weight-bold mb-0 text-dark" style="font-size: 15px;">
              <i class="mdi mdi-gender-male-female text-info me-2"></i> Patient Gender Ratio
            </h5>
            <span class="badge bg-light text-muted font-11">Demographics</span>
          </div>
          <div style="height: 210px; position: relative;">
            <canvas id="genderDemographicsChart"></canvas>
          </div>
          <div class="d-flex justify-content-around text-center mt-3 pt-2 border-top">
            <div>
              <span class="d-block font-11 text-muted font-weight-bold">MALE</span>
              <span class="font-weight-bold text-dark font-14">{{ $genderData[0] }}</span>
            </div>
            <div>
              <span class="d-block font-11 text-muted font-weight-bold">FEMALE</span>
              <span class="font-weight-bold text-dark font-14">{{ $genderData[1] }}</span>
            </div>
            <div>
              <span class="d-block font-11 text-muted font-weight-bold">OTHER</span>
              <span class="font-weight-bold text-dark font-14">{{ $genderData[2] }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Chart Row 3: Age Groups & Chief Complaints -->
  <div class="row g-3 mb-4">
    <!-- Chart 6: Age Groups -->
    <div class="col-xl-6 col-lg-12">
      <div class="card border shadow-sm h-100" style="background: #ffffff; border-radius: 16px; border-color: #f1f5f9 !important;">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h5 class="card-title font-weight-bold mb-1 text-dark">
                <i class="mdi mdi-human-male-female-child me-2 text-primary"></i> Patient Age Distribution
              </h5>
              <p class="text-muted font-12 mb-0">Demographic cohorts registered in clinic records.</p>
            </div>
            <span class="badge bg-light text-muted font-11">Cohorts</span>
          </div>
          <div style="height: 230px; position: relative;">
            <canvas id="ageDistributionChart"></canvas>
          </div>
        </div>
      </div>
    </div>

    <!-- Chart 7: Chief Medical Complaints -->
    <div class="col-xl-6 col-lg-12">
      <div class="card border shadow-sm h-100" style="background: #ffffff; border-radius: 16px; border-color: #f1f5f9 !important;">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h5 class="card-title font-weight-bold mb-1 text-dark">
                <i class="mdi mdi-stethoscope me-2 text-danger"></i> Top Reported Symptoms &amp; Diagnoses
              </h5>
              <p class="text-muted font-12 mb-0">Frequent patient complaints and symptoms submitted during booking.</p>
            </div>
            <span class="badge bg-light text-muted font-11">Clinical OPD</span>
          </div>
          <div style="height: 230px; position: relative;">
            <canvas id="complaintsChart"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- ========================================================================= -->
  <!-- MULTI-TABLE CLINIC ACTIVITY SECTION                                       -->
  <!-- ========================================================================= -->

  <!-- Tabbed Activity Suite -->
  <div class="card border shadow-sm mb-4" style="background: #ffffff; border-radius: 16px; border-color: #f1f5f9 !important;">
    <div class="card-header bg-white border-bottom p-3" style="border-radius: 16px 16px 0 0;">
      <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <ul class="nav nav-pills card-header-pills" id="activityTabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active font-weight-bold" id="opd-tab" data-bs-toggle="pill" href="#tab-opd" role="tab" style="border-radius: 8px; font-size: 13px;">
              <i class="mdi mdi-clipboard-text-clock me-1"></i> Today's OPD Schedule
              <span class="badge bg-primary text-white ms-1 rounded-pill">{{ count($todayAppointments) }}</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link font-weight-bold" id="patients-tab" data-bs-toggle="pill" href="#tab-patients" role="tab" style="border-radius: 8px; font-size: 13px;">
              <i class="mdi mdi-account-group me-1"></i> Patient Directory
              <span class="badge bg-secondary text-white ms-1 rounded-pill">{{ count($recentBookings) }}</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link font-weight-bold" id="billing-tab" data-bs-toggle="pill" href="#tab-billing" role="tab" style="border-radius: 8px; font-size: 13px;">
              <i class="mdi mdi-receipt-text-outline me-1"></i> Billing &amp; Receipts
              <span class="badge bg-success text-white ms-1 rounded-pill">{{ count($recentOrders) }}</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link font-weight-bold" id="services-tab" data-bs-toggle="pill" href="#tab-services" role="tab" style="border-radius: 8px; font-size: 13px;">
              <i class="mdi mdi-medical-bag me-1"></i> Clinic Tariff
              <span class="badge bg-info text-white ms-1 rounded-pill">{{ count($clinicServices) }}</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link font-weight-bold" id="logs-tab" data-bs-toggle="pill" href="#tab-logs" role="tab" style="border-radius: 8px; font-size: 13px;">
              <i class="mdi mdi-history me-1"></i> Activity Audit Trail
              <span class="badge bg-dark text-white ms-1 rounded-pill">{{ count($activityLogs) }}</span>
            </a>
          </li>
        </ul>

        <div class="d-flex align-items-center gap-2">
          <a href="{{ url('admin/patient') }}" class="btn btn-sm btn-outline-primary font-weight-bold" style="border-radius: 8px; font-size: 12px;">
            <i class="mdi mdi-open-in-new me-1"></i> All Patients
          </a>
        </div>
      </div>
    </div>

    <div class="card-body p-4">
      <div class="tab-content" id="activityTabContent">
        
        <!-- ========================================== -->
        <!-- TAB 1: Today's Active OPD Queue Table       -->
        <!-- ========================================== -->
        <div class="tab-pane fade show active" id="tab-opd" role="tabpanel">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h5 class="font-weight-bold mb-1 text-dark" style="font-size: 15px;">
                Scheduled OPD Consultations
              </h5>
              <p class="text-muted font-12 mb-0">Active queue of booked patients ready for doctor consultation.</p>
            </div>
            <a href="{{ url('admin/patient') }}" class="btn btn-sm btn-link text-primary font-weight-bold text-decoration-none">
              Manage Queue &rarr;
            </a>
          </div>

          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead class="table-light">
                <tr>
                  <th style="font-size: 11.5px; text-transform: uppercase;">Patient Name</th>
                  <th style="font-size: 11.5px; text-transform: uppercase;">Contact No</th>
                  <th style="font-size: 11.5px; text-transform: uppercase;">Consultation Slot</th>
                  <th style="font-size: 11.5px; text-transform: uppercase;">Chief Problem / Symptoms</th>
                  <th style="font-size: 11.5px; text-transform: uppercase;">Fee / Amount</th>
                  <th style="font-size: 11.5px; text-transform: uppercase;">Status</th>
                  <th class="text-end" style="font-size: 11.5px; text-transform: uppercase;">Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse($todayAppointments as $order)
                @php
                  $p = $order->patient;
                  $patientName = $p ? trim($p->first_name . ' ' . $p->last_name) : 'Patient #' . $order->patient_id;
                  $receiptUrl = url('/invoice/' . $order->id);
                @endphp
                <tr>
                  <td>
                    <div class="d-flex align-items-center gap-2">
                      <div style="width: 32px; height: 32px; border-radius: 8px; background: #e0f2fe; color: #0369a1; font-weight: 700; display: flex; align-items: center; justify-content: center; font-size: 13px;">
                        {{ strtoupper(substr($patientName, 0, 1)) }}
                      </div>
                      <div>
                        <strong class="text-dark d-block">{{ $patientName }}</strong>
                        <small class="text-muted font-11">#PID-{{ $order->patient_id }}</small>
                      </div>
                    </div>
                  </td>
                  <td>
                    <span class="font-weight-bold font-12">{{ $p->mobile_no ?? 'N/A' }}</span>
                  </td>
                  <td>
                    <span class="badge bg-light text-dark border font-11">
                      <i class="mdi mdi-clock-outline text-primary me-1"></i>
                      {{ $order->booking_date ? \Carbon\Carbon::parse($order->booking_date)->format('d M') : 'Today' }}
                    </span>
                  </td>
                  <td>
                    <span class="text-muted font-12 text-truncate d-inline-block" style="max-width: 220px;" title="{{ $p->patient_problem ?? '' }}">
                      {{ $p->patient_problem ?: 'General Outpatient Consultation' }}
                    </span>
                  </td>
                  <td>
                    <strong class="text-dark font-13">₹{{ number_format($order->total_amount, 2) }}</strong>
                  </td>
                  <td>
                    @if($order->payment_status === 'success' || $order->status === 'confirmed')
                      <span class="badge" style="background: #ecfdf5; color: #065f46; font-weight: 700; padding: 5px 10px; border-radius: 6px;">
                        <i class="mdi mdi-check-circle me-1"></i> Confirmed
                      </span>
                    @elseif($order->payment_status === 'cancelled')
                      <span class="badge" style="background: #fef2f2; color: #b91c1c; font-weight: 700; padding: 5px 10px; border-radius: 6px;">
                        Cancelled
                      </span>
                    @else
                      <span class="badge" style="background: #eff6ff; color: #1d4ed8; font-weight: 700; padding: 5px 10px; border-radius: 6px;">
                        Pending
                      </span>
                    @endif
                  </td>
                  <td class="text-end">
                    <a href="{{ $receiptUrl }}" class="btn btn-sm btn-outline-primary py-1 px-2 font-weight-bold" style="border-radius: 6px; font-size: 11px;" title="View Official Consultation Receipt">
                      <i class="mdi mdi-receipt me-1"></i> Receipt
                    </a>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="7" class="text-center py-4 text-muted font-13">
                    <i class="mdi mdi-calendar-blank-outline font-28 d-block mb-1"></i>
                    No consultations scheduled for today yet.
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

        <!-- ========================================== -->
        <!-- TAB 2: Recent Patients Directory Table     -->
        <!-- ========================================== -->
        <div class="tab-pane fade" id="tab-patients" role="tabpanel">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h5 class="font-weight-bold mb-1 text-dark" style="font-size: 15px;">
                Registered Patient Directory
              </h5>
              <p class="text-muted font-12 mb-0">Active patient database and medical consultation records.</p>
            </div>
            <a href="{{ url('admin/patient') }}" class="btn btn-sm btn-link text-primary font-weight-bold text-decoration-none">
              View Directory &rarr;
            </a>
          </div>

          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead class="table-light">
                <tr>
                  <th style="font-size: 11.5px; text-transform: uppercase;">Patient Name</th>
                  <th style="font-size: 11.5px; text-transform: uppercase;">Mobile Number</th>
                  <th style="font-size: 11.5px; text-transform: uppercase;">Gender / Age</th>
                  <th style="font-size: 11.5px; text-transform: uppercase;">Address</th>
                  <th style="font-size: 11.5px; text-transform: uppercase;">Clinical Complaint</th>
                  <th style="font-size: 11.5px; text-transform: uppercase;">Registered On</th>
                  <th style="font-size: 11.5px; text-transform: uppercase;">Status</th>
                </tr>
              </thead>
              <tbody>
                @forelse($recentBookings as $patient)
                <tr>
                  <td>
                    <strong class="text-dark d-block">{{ $patient->first_name }} {{ $patient->last_name }}</strong>
                    <small class="text-muted font-11">#PID-{{ $patient->id }}</small>
                  </td>
                  <td>{{ $patient->mobile_no }}</td>
                  <td>{{ ucfirst($patient->sex ?? 'N/A') }} / {{ $patient->age ? $patient->age . ' Yrs' : 'N/A' }}</td>
                  <td>
                    <span class="text-muted font-12 text-truncate d-inline-block" style="max-width: 180px;">
                      {{ $patient->address ?: 'Not specified' }}
                    </span>
                  </td>
                  <td>
                    <span class="text-muted font-12 text-truncate d-inline-block" style="max-width: 200px;">
                      {{ $patient->patient_problem ?: 'Routine Medical Consultation' }}
                    </span>
                  </td>
                  <td>{{ $patient->created_at ? $patient->created_at->format('d M, Y') : 'N/A' }}</td>
                  <td>
                    <span class="badge" style="background: #ecfdf5; color: #065f46; font-weight: 700; padding: 5px 10px; border-radius: 6px;">
                      Active
                    </span>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="7" class="text-center py-4 text-muted font-13">
                    No patient records found.
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

        <!-- ========================================== -->
        <!-- TAB 3: Financial Receipts & Settlement     -->
        <!-- ========================================== -->
        <div class="tab-pane fade" id="tab-billing" role="tabpanel">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h5 class="font-weight-bold mb-1 text-dark" style="font-size: 15px;">
                Consultation Billing &amp; Payment Receipts
              </h5>
              <p class="text-muted font-12 mb-0">Official payment vouchers and Razorpay settlement logs.</p>
            </div>
            <span class="badge bg-success text-white font-12 font-weight-bold px-3 py-1">
              Settled GMV: ₹{{ number_format($totalEarnings, 2) }}
            </span>
          </div>

          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead class="table-light">
                <tr>
                  <th style="font-size: 11.5px; text-transform: uppercase;">Receipt No</th>
                  <th style="font-size: 11.5px; text-transform: uppercase;">Patient Name</th>
                  <th style="font-size: 11.5px; text-transform: uppercase;">Date</th>
                  <th style="font-size: 11.5px; text-transform: uppercase;">Payment Mode</th>
                  <th style="font-size: 11.5px; text-transform: uppercase;">Gateway / Txn ID</th>
                  <th style="font-size: 11.5px; text-transform: uppercase;">Amount Paid</th>
                  <th style="font-size: 11.5px; text-transform: uppercase;">Status</th>
                  <th class="text-end" style="font-size: 11.5px; text-transform: uppercase;">Receipt</th>
                </tr>
              </thead>
              <tbody>
                @forelse($recentOrders as $order)
                @php
                  $p = $order->patient;
                  $patientName = $p ? trim($p->first_name . ' ' . $p->last_name) : 'Patient #' . $order->patient_id;
                  $receiptNo = 'REC-' . ($order->created_at ? $order->created_at->format('Y') : date('Y')) . '-' . str_pad($order->id, 5, '0', STR_PAD_LEFT);
                  $isCash = ($order->razorpay_payment_id === 'CASH_PAYMENT' || str_contains($order->transaction_id ?? '', 'CASH') || empty($order->razorpay_payment_id));
                @endphp
                <tr>
                  <td>
                    <span class="badge bg-light text-dark font-monospace border font-11">
                      #{{ $receiptNo }}
                    </span>
                  </td>
                  <td>
                    <strong class="text-dark">{{ $patientName }}</strong>
                  </td>
                  <td>{{ $order->created_at ? $order->created_at->format('d M Y, h:i A') : 'N/A' }}</td>
                  <td>
                    @if($isCash)
                      <span class="badge" style="background: #fef3c7; color: #b45309; font-weight: 700; font-size: 11px;">
                        <i class="mdi mdi-cash me-1"></i> Cash at Clinic
                      </span>
                    @else
                      <span class="badge" style="background: #ecfdf5; color: #065f46; font-weight: 700; font-size: 11px;">
                        <i class="mdi mdi-credit-card-outline me-1"></i> Razorpay Online
                      </span>
                    @endif
                  </td>
                  <td>
                    <code class="font-11 text-muted">{{ $order->razorpay_payment_id ?: ($order->transaction_id ?: 'CASH_DESK') }}</code>
                  </td>
                  <td>
                    <strong class="text-dark font-13">₹{{ number_format($order->total_amount, 2) }}</strong>
                  </td>
                  <td>
                    <span class="badge" style="background: #ecfdf5; color: #059669; font-weight: 700; font-size: 10.5px; padding: 4px 8px;">
                      SETTLED
                    </span>
                  </td>
                  <td class="text-end">
                    <a href="{{ url('/invoice/' . $order->id) }}" target="_blank" class="btn btn-sm btn-outline-primary py-1 px-2 font-weight-bold" style="border-radius: 6px; font-size: 11px;">
                      <i class="mdi mdi-printer me-1"></i> Print / PDF
                    </a>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="8" class="text-center py-4 text-muted font-13">
                    No billing transactions found.
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

        <!-- ========================================== -->
        <!-- TAB 4: Clinic Services & Tariff Portfolio  -->
        <!-- ========================================== -->
        <div class="tab-pane fade" id="tab-services" role="tabpanel">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h5 class="font-weight-bold mb-1 text-dark" style="font-size: 15px;">
                Clinic Services &amp; Consultation Tariff
              </h5>
              <p class="text-muted font-12 mb-0">Services and specialties available for patients on the clinic storefront.</p>
            </div>
            <a href="{{ route('clinic.services.index') }}" class="btn btn-sm btn-primary font-weight-bold" style="border-radius: 8px; font-size: 12px;">
              <i class="mdi mdi-plus me-1"></i> Add / Edit Services
            </a>
          </div>

          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead class="table-light">
                <tr>
                  <th style="font-size: 11.5px; text-transform: uppercase;">Service Name</th>
                  <th style="font-size: 11.5px; text-transform: uppercase;">Category / Department</th>
                  <th style="font-size: 11.5px; text-transform: uppercase;">Duration</th>
                  <th style="font-size: 11.5px; text-transform: uppercase;">Fee (₹)</th>
                  <th style="font-size: 11.5px; text-transform: uppercase;">Status</th>
                  <th class="text-end" style="font-size: 11.5px; text-transform: uppercase;">Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse($clinicServices as $service)
                <tr>
                  <td>
                    <strong class="text-dark d-block">{{ $service->title ?? $service->name }}</strong>
                    <small class="text-muted font-11">{{ Str::limit($service->description ?? 'Clinical Outpatient Service', 60) }}</small>
                  </td>
                  <td>
                    <span class="badge bg-light text-dark border font-11">
                      {{ $service->category ?? ($clinic->specialization ?? 'OPD') }}
                    </span>
                  </td>
                  <td>
                    <span class="text-muted font-12"><i class="mdi mdi-clock-outline me-1"></i> {{ $service->duration ?? '30' }} Mins</span>
                  </td>
                  <td>
                    <strong class="text-dark font-13">₹{{ number_format($service->price, 2) }}</strong>
                  </td>
                  <td>
                    @if($service->is_active ?? true)
                      <span class="badge" style="background: #ecfdf5; color: #065f46; font-weight: 700; padding: 4px 10px; border-radius: 6px;">
                        Active
                      </span>
                    @else
                      <span class="badge bg-light text-muted font-11">Inactive</span>
                    @endif
                  </td>
                  <td class="text-end">
                    <a href="{{ route('clinic.services.index') }}" class="btn btn-sm btn-outline-secondary py-1 px-2 font-weight-bold" style="border-radius: 6px; font-size: 11px;">
                      <i class="mdi mdi-pencil"></i> Edit
                    </a>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="6" class="text-center py-4 text-muted font-13">
                    <i class="mdi mdi-medical-bag font-28 d-block mb-1"></i>
                    No custom services added yet. Default consultation fee applies.
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

        <!-- ========================================== -->
        <!-- TAB 5: Activity Audit Trail Logs           -->
        <!-- ========================================== -->
        <div class="tab-pane fade" id="tab-logs" role="tabpanel">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h5 class="font-weight-bold mb-1 text-dark" style="font-size: 15px;">
                Recent Clinic Audit Trail &amp; Events
              </h5>
              <p class="text-muted font-12 mb-0">System audit trail of administrative modifications and security access logs.</p>
            </div>
            <span class="badge bg-light text-muted font-11">Security Audit</span>
          </div>

          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead class="table-light">
                <tr>
                  <th style="font-size: 11.5px; text-transform: uppercase;">Timestamp</th>
                  <th style="font-size: 11.5px; text-transform: uppercase;">Event Action</th>
                  <th style="font-size: 11.5px; text-transform: uppercase;">Description</th>
                  <th style="font-size: 11.5px; text-transform: uppercase;">Origin IP</th>
                  <th style="font-size: 11.5px; text-transform: uppercase;">Device / Agent</th>
                </tr>
              </thead>
              <tbody>
                @forelse($activityLogs as $log)
                <tr>
                  <td>
                    <span class="text-muted font-11 d-block">{{ $log->created_at ? $log->created_at->format('d M Y, h:i A') : 'N/A' }}</span>
                  </td>
                  <td>
                    <span class="badge bg-light text-primary border font-11 font-monospace">
                      {{ $log->action }}
                    </span>
                  </td>
                  <td>
                    <strong class="text-dark font-12">{{ $log->description }}</strong>
                  </td>
                  <td>
                    <code class="font-11 text-muted">{{ $log->ip_address ?: '127.0.0.1' }}</code>
                  </td>
                  <td>
                    <span class="text-muted font-11 text-truncate d-inline-block" style="max-width: 200px;" title="{{ $log->user_agent }}">
                      {{ Str::limit($log->user_agent ?: 'Web Browser', 30) }}
                    </span>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="5" class="text-center py-4 text-muted font-13">
                    No activity logs recorded yet.
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

<!-- ========================================================================= -->
<!-- JAVASCRIPT CHARTS INITIALIZATION (Chart.js Suite)                          -->
<!-- ========================================================================= -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
  // Chart 1: Daily Consultation Volume
  const volumeCtx = document.getElementById('consultationsVolumeChart');
  if (volumeCtx) {
    const labels = {!! json_encode($trendLabels) !!};
    const data = {!! json_encode($trendBookings) !!};

    const gradient = volumeCtx.getContext('2d').createLinearGradient(0, 0, 0, 240);
    gradient.addColorStop(0, 'rgba(13, 148, 136, 0.35)');
    gradient.addColorStop(1, 'rgba(13, 148, 136, 0.02)');

    new Chart(volumeCtx, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [{
          label: 'Consultation Bookings',
          data: data,
          backgroundColor: gradient,
          borderColor: '#0d9488',
          borderWidth: 2.5,
          pointBackgroundColor: '#0d9488',
          pointBorderColor: '#ffffff',
          pointBorderWidth: 2,
          pointRadius: 4,
          pointHoverRadius: 6,
          fill: true,
          tension: 0.35
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false },
          tooltip: {
            callbacks: {
              label: function(ctx) { return ' Consultations: ' + ctx.raw; }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: { precision: 0, font: { size: 11 } },
            grid: { color: '#f1f5f9' }
          },
          x: {
            grid: { display: false },
            ticks: { font: { size: 10 } }
          }
        }
      }
    });
  }

  // Chart 2: Revenue Trend
  const revenueCtx = document.getElementById('revenueTrendChart');
  if (revenueCtx) {
    const revLabels = {!! json_encode($trendLabels) !!};
    const revData = {!! json_encode($trendRevenue) !!};

    const revGrad = revenueCtx.getContext('2d').createLinearGradient(0, 0, 0, 240);
    revGrad.addColorStop(0, 'rgba(16, 185, 129, 0.35)');
    revGrad.addColorStop(1, 'rgba(16, 185, 129, 0.02)');

    new Chart(revenueCtx, {
      type: 'bar',
      data: {
        labels: revLabels,
        datasets: [{
          label: 'Settled Revenue (₹)',
          data: revData,
          backgroundColor: '#10b981',
          borderRadius: 6,
          maxBarThickness: 28
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false },
          tooltip: {
            callbacks: {
              label: function(ctx) { return ' Revenue: ₹' + ctx.raw.toLocaleString(); }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(val) { return '₹' + val.toLocaleString(); },
              font: { size: 11 }
            },
            grid: { color: '#f1f5f9' }
          },
          x: {
            grid: { display: false },
            ticks: { font: { size: 10 } }
          }
        }
      }
    });
  }

  // Chart 3: Booking Status Doughnut
  const statusCtx = document.getElementById('bookingStatusChart');
  if (statusCtx) {
    new Chart(statusCtx, {
      type: 'doughnut',
      data: {
        labels: {!! json_encode($statusLabels) !!},
        datasets: [{
          data: {!! json_encode($statusData) !!},
          backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
          borderWidth: 2,
          borderColor: '#ffffff'
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom',
            labels: { boxWidth: 12, font: { size: 11 } }
          }
        },
        cutout: '68%'
      }
    });
  }

  // Chart 4: Payment Mode Doughnut
  const paymentCtx = document.getElementById('paymentModeChart');
  if (paymentCtx) {
    new Chart(paymentCtx, {
      type: 'doughnut',
      data: {
        labels: {!! json_encode($paymentLabels) !!},
        datasets: [{
          data: {!! json_encode($paymentData) !!},
          backgroundColor: ['#0d9488', '#6366f1'],
          borderWidth: 2,
          borderColor: '#ffffff'
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom',
            labels: { boxWidth: 12, font: { size: 11 } }
          },
          tooltip: {
            callbacks: {
              label: function(ctx) { return ' ' + ctx.label + ': ₹' + ctx.raw.toLocaleString(); }
            }
          }
        },
        cutout: '68%'
      }
    });
  }

  // Chart 5: Gender Demographics Doughnut
  const genderCtx = document.getElementById('genderDemographicsChart');
  if (genderCtx) {
    new Chart(genderCtx, {
      type: 'doughnut',
      data: {
        labels: {!! json_encode($genderLabels) !!},
        datasets: [{
          data: {!! json_encode($genderData) !!},
          backgroundColor: ['#0284c7', '#ec4899', '#64748b'],
          borderWidth: 2,
          borderColor: '#ffffff'
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'bottom',
            labels: { boxWidth: 12, font: { size: 11 } }
          }
        },
        cutout: '68%'
      }
    });
  }

  // Chart 6: Age Cohorts Bar Chart
  const ageCtx = document.getElementById('ageDistributionChart');
  if (ageCtx) {
    new Chart(ageCtx, {
      type: 'bar',
      data: {
        labels: {!! json_encode($ageLabels) !!},
        datasets: [{
          label: 'Patients',
          data: {!! json_encode($ageData) !!},
          backgroundColor: ['#38bdf8', '#818cf8', '#a78bfa', '#fb7185'],
          borderRadius: 6
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
          y: {
            beginAtZero: true,
            ticks: { precision: 0, font: { size: 11 } },
            grid: { color: '#f1f5f9' }
          },
          x: {
            grid: { display: false },
            ticks: { font: { size: 11 } }
          }
        }
      }
    });
  }

  // Chart 7: Top Complaints Horizontal Bar
  const complaintCtx = document.getElementById('complaintsChart');
  if (complaintCtx) {
    new Chart(complaintCtx, {
      type: 'bar',
      data: {
        labels: {!! json_encode($complaintLabels) !!},
        datasets: [{
          label: 'Cases',
          data: {!! json_encode($complaintData) !!},
          backgroundColor: '#f43f5e',
          borderRadius: 6
        }]
      },
      options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
          x: {
            beginAtZero: true,
            ticks: { precision: 0, font: { size: 11 } },
            grid: { color: '#f1f5f9' }
          },
          y: {
            grid: { display: false },
            ticks: { font: { size: 11 } }
          }
        }
      }
    });
  }
});

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
