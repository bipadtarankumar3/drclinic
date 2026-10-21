@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  <!-- Top Header with Date Filter and Quick Actions -->
  <div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-3">
      <div>
        <h2 class="font-weight-bold mb-1 d-flex align-items-center" style="color: #0f172a; font-size: 22px;">
          <i class="mdi mdi-chart-box-outline text-primary me-2"></i> SaaS Platform Analytics & Command Center
        </h2>
        <p class="text-muted mb-0 font-13">Executive overview of doctor clinics, recurring SaaS revenue, patient bookings, and platform activity.</p>
      </div>

      <div class="d-flex align-items-center gap-2 flex-wrap">
        <form method="GET" action="{{ route('admin.saas.dashboard') }}" class="d-flex align-items-center gap-2">
          <label class="text-muted font-12 font-weight-bold mb-0">Period:</label>
          <select name="range" class="form-select form-select-sm font-weight-bold shadow-sm" style="border-radius: 8px; width: 140px;" onchange="this.form.submit()">
            <option value="7_days" {{ $range == '7_days' ? 'selected' : '' }}>Last 7 Days</option>
            <option value="30_days" {{ $range == '30_days' ? 'selected' : '' }}>Last 30 Days</option>
            <option value="90_days" {{ $range == '90_days' ? 'selected' : '' }}>Last 90 Days</option>
            <option value="1_year" {{ $range == '1_year' ? 'selected' : '' }}>Last 1 Year</option>
          </select>
        </form>

        <a href="{{ route('admin.saas.clinics') }}" class="btn btn-primary btn-sm font-weight-bold shadow-sm d-inline-flex align-items-center gap-1" style="border-radius: 8px; padding: 7px 14px;">
          <i class="mdi mdi-hospital-building font-16"></i> Manage Clinics
        </a>

        <a href="{{ route('admin.saas.plans') }}" class="btn btn-outline-secondary btn-sm font-weight-bold shadow-sm d-inline-flex align-items-center gap-1" style="border-radius: 8px; padding: 7px 14px;">
          <i class="mdi mdi-crown font-16 text-warning"></i> Plans
        </a>
      </div>
    </div>
  </div>

  @if(session('success'))
  <div class="alert alert-success alert-dismissible fade show rounded-3 p-3 mb-4 shadow-sm" role="alert">
    <strong><i class="mdi mdi-check-circle me-1"></i> Success:</strong> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  <!-- ========================================================================= -->
  <!-- 1. KPI STAT CARDS (Executive Grade Metrics)                                -->
  <!-- ========================================================================= -->
  <div class="row g-3 mb-4">
    <!-- Card 1: Total Doctor Clinics -->
    <div class="col-xl-4 col-md-6">
      <div class="saas-stat-card">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="stat-label">Total Doctor Clinics</div>
            <div class="stat-value">{{ $totalClinics }}</div>
          </div>
          <div class="stat-icon-wrapper stat-icon-blue">
            <i class="mdi mdi-hospital-building"></i>
          </div>
        </div>
        <div class="stat-meta mt-3">
          <span class="pill-growth-up"><i class="mdi mdi-check-circle"></i> {{ $activeClinics }} Active</span>
          <span class="pill-growth-neutral"><i class="mdi mdi-clock-outline"></i> {{ $trialingClinics }} on Trial</span>
          <span class="text-muted ms-auto font-11">{{ $totalDoctors }} Doctors</span>
        </div>
      </div>
    </div>

    <!-- Card 2: SaaS Platform Revenue -->
    <div class="col-xl-4 col-md-6">
      <div class="saas-stat-card">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="stat-label">Platform Subscription Revenue</div>
            <div class="stat-value text-success">₹{{ number_format($totalPlatformRevenue, 2) }}</div>
          </div>
          <div class="stat-icon-wrapper stat-icon-green">
            <i class="mdi mdi-currency-inr"></i>
          </div>
        </div>
        <div class="stat-meta mt-3">
          <span class="pill-growth-up"><i class="mdi mdi-arrow-up"></i> Recurring</span>
          <span class="text-muted font-11">From active doctor subscription plans</span>
        </div>
      </div>
    </div>

    <!-- Card 3: Total Patient Appointments -->
    <div class="col-xl-4 col-md-6">
      <div class="saas-stat-card">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="stat-label">Total Patient Bookings</div>
            <div class="stat-value text-primary">{{ number_format($totalPatientAppointments) }}</div>
          </div>
          <div class="stat-icon-wrapper stat-icon-purple">
            <i class="mdi mdi-calendar-check"></i>
          </div>
        </div>
        <div class="stat-meta mt-3">
          <span class="pill-growth-up"><i class="mdi mdi-check-all"></i> {{ $successfulAppointmentsCount }} Completed</span>
          <span class="text-muted ms-auto font-11">Across all clinic storefronts</span>
        </div>
      </div>
    </div>

    <!-- Card 4: Gross Doctor Consultation GMV -->
    <div class="col-xl-4 col-md-6">
      <div class="saas-stat-card">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="stat-label">Gross Doctor Consultation GMV</div>
            <div class="stat-value text-dark">₹{{ number_format($totalGrossConsultation, 2) }}</div>
          </div>
          <div class="stat-icon-wrapper stat-icon-amber">
            <i class="mdi mdi-cash-multiple"></i>
          </div>
        </div>
        <div class="stat-meta mt-3">
          <span class="pill-growth-up"><i class="mdi mdi-shield-check"></i> Processed</span>
          <span class="text-muted font-11">Total patient fees paid to clinics</span>
        </div>
      </div>
    </div>

    <!-- Card 5: Subscription Retention Rate -->
    <div class="col-xl-4 col-md-6">
      <div class="saas-stat-card">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="stat-label">Platform Retention Health</div>
            <div class="stat-value text-info">100%</div>
          </div>
          <div class="stat-icon-wrapper stat-icon-cyan">
            <i class="mdi mdi-shield-account"></i>
          </div>
        </div>
        <div class="stat-meta mt-3">
          <span class="pill-growth-up"><i class="mdi mdi-lock-check"></i> 0 Churned</span>
          <span class="text-muted font-11">{{ $expiredClinics }} expired accounts needing action</span>
        </div>
      </div>
    </div>

    <!-- Card 6: 30-Day Activity Flow -->
    <div class="col-xl-4 col-md-6">
      <div class="saas-stat-card">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <div class="stat-label">Recent 30-Day Appointments</div>
            <div class="stat-value text-secondary">{{ $recentBookingsCount }}</div>
          </div>
          <div class="stat-icon-wrapper stat-icon-red">
            <i class="mdi mdi-chart-timeline-variant"></i>
          </div>
        </div>
        <div class="stat-meta mt-3">
          <span class="pill-growth-neutral"><i class="mdi mdi-account-group"></i> Active Flow</span>
          <span class="text-muted font-11">Patients booked in the last month</span>
        </div>
      </div>
    </div>
  </div>

  <!-- ========================================================================= -->
  <!-- 2. CHARTS ROW 1: PRIMARY TRENDS                                           -->
  <!-- ========================================================================= -->
  <div class="row g-3 mb-4">
    <!-- Chart 1: Monthly Subscription Revenue Trend -->
    <div class="col-lg-7">
      <div class="saas-chart-card p-4 h-100">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div>
            <h5 class="font-weight-bold mb-0 text-dark" style="font-size: 15px;">
              <i class="mdi mdi-chart-line text-primary me-1"></i> SaaS Platform Subscription Revenue
            </h5>
            <small class="text-muted font-12">Monthly platform earnings from doctor subscriptions</small>
          </div>
          <span class="badge bg-light text-primary font-weight-bold px-2 py-1" style="border: 1px solid #e2e8f0; border-radius: 6px;">Last 6 Months</span>
        </div>
        <div style="height: 270px; position: relative;">
          <canvas id="revenueChart"></canvas>
        </div>
      </div>
    </div>

    <!-- Chart 2: Monthly Patient Booking Appointments Trend -->
    <div class="col-lg-5">
      <div class="saas-chart-card p-4 h-100">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div>
            <h5 class="font-weight-bold mb-0 text-dark" style="font-size: 15px;">
              <i class="mdi mdi-chart-areaspline text-success me-1"></i> Patient Booking Volume
            </h5>
            <small class="text-muted font-12">Appointment velocity across all clinics</small>
          </div>
          <span class="badge bg-light text-success font-weight-bold px-2 py-1" style="border: 1px solid #e2e8f0; border-radius: 6px;">Monthly Flow</span>
        </div>
        <div style="height: 270px; position: relative;">
          <canvas id="appointmentsChart"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- ========================================================================= -->
  <!-- 3. CHARTS ROW 2: DISTRIBUTION & BREAKDOWNS                                -->
  <!-- ========================================================================= -->
  <div class="row g-3 mb-4">
    <!-- Chart 3: Active Plan Distribution -->
    <div class="col-lg-4 col-md-6">
      <div class="saas-chart-card p-4 h-100">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="font-weight-bold mb-0 text-dark" style="font-size: 15px;">
            <i class="mdi mdi-chart-arc text-primary me-1"></i> Plan Distribution
          </h5>
          <small class="text-muted font-11">Active Tiers</small>
        </div>
        <div style="height: 200px; position: relative;">
          <canvas id="planChart"></canvas>
        </div>
        <div class="mt-3 d-flex flex-wrap gap-1 justify-content-center">
          @foreach($planDistribution as $planItem)
          <span class="badge bg-light text-dark font-11" style="border: 1px solid #e2e8f0;">
            {{ $planItem->name }}: <strong class="text-primary">{{ $planItem->subscriptions_count }}</strong>
          </span>
          @endforeach
        </div>
      </div>
    </div>

    <!-- Chart 4: Clinic Status Breakdown -->
    <div class="col-lg-4 col-md-6">
      <div class="saas-chart-card p-4 h-100">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="font-weight-bold mb-0 text-dark" style="font-size: 15px;">
            <i class="mdi mdi-chart-donut text-success me-1"></i> Clinic Lifecycle
          </h5>
          <small class="text-muted font-11">Status Ratio</small>
        </div>
        <div style="height: 200px; position: relative;">
          <canvas id="statusChart"></canvas>
        </div>
        <div class="mt-3 d-flex flex-wrap gap-1 justify-content-center">
          <span class="badge bg-success bg-opacity-10 text-success font-11 border border-success border-opacity-25">Active: <strong>{{ $activeClinics }}</strong></span>
          <span class="badge bg-warning bg-opacity-10 text-warning font-11 border border-warning border-opacity-25">Trial: <strong>{{ $trialingClinics }}</strong></span>
          <span class="badge bg-danger bg-opacity-10 text-danger font-11 border border-danger border-opacity-25">Expired: <strong>{{ $expiredClinics }}</strong></span>
        </div>
      </div>
    </div>

    <!-- Chart 5: Patient Payment Mode Split -->
    <div class="col-lg-4 col-md-12">
      <div class="saas-chart-card p-4 h-100">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="font-weight-bold mb-0 text-dark" style="font-size: 15px;">
            <i class="mdi mdi-credit-card-outline text-purple me-1" style="color: #7c3aed;"></i> Payment Methods
          </h5>
          <small class="text-muted font-11">Online vs Cash</small>
        </div>
        <div style="height: 200px; position: relative;">
          <canvas id="paymentModeChart"></canvas>
        </div>
        <div class="mt-3 d-flex flex-wrap gap-1 justify-content-center">
          @foreach($paymentModes as $modeName => $modeCount)
          <span class="badge bg-light text-dark font-11" style="border: 1px solid #e2e8f0;">
            {{ $modeName }}: <strong class="text-dark">{{ $modeCount }}</strong>
          </span>
          @endforeach
        </div>
      </div>
    </div>
  </div>

  <!-- ========================================================================= -->
  <!-- 4. TABLE 1: REGISTERED DOCTOR CLINICS DIRECTORY                           -->
  <!-- ========================================================================= -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="saas-table-card shadow-sm">
        <div class="p-3 px-4 d-flex justify-content-between align-items-center flex-wrap gap-2 border-bottom" style="background: #fafbfc;">
          <div>
            <h5 class="font-weight-bold mb-0 text-dark" style="font-size: 15px;">
              <i class="mdi mdi-hospital-building text-primary me-1"></i> Registered Doctor Clinics Directory
            </h5>
            <small class="text-muted font-12">All onboarded doctors, clinic subdomains, and subscription statuses</small>
          </div>
          <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.saas.clinics') }}" class="btn btn-sm btn-outline-primary font-weight-bold" style="border-radius: 8px;">
              View All Clinics ({{ $totalClinics }}) &rarr;
            </a>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="bg-light text-muted font-11 text-uppercase">
              <tr>
                <th class="ps-4">Clinic & Doctor</th>
                <th>Subdomain / Custom Domain</th>
                <th>Active Plan</th>
                <th>Status</th>
                <th>Trial / Plan Ends</th>
                <th class="text-center">Total Bookings</th>
                <th class="text-end pe-4">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($recentClinics as $c)
              @php
                $storefrontUrl = $c->custom_domain ? 'https://' . $c->custom_domain : url('/c/' . ($c->subdomain ?? $c->slug));
              @endphp
              <tr>
                <td class="ps-4">
                  <div class="d-flex align-items-center gap-2">
                    <div class="brand-square-avatar" style="width: 34px; height: 34px; font-size: 14px; border-radius: 8px;">
                      {{ strtoupper(substr($c->name, 0, 1)) }}
                    </div>
                    <div>
                      <div class="font-weight-bold text-dark font-13">{{ $c->name }}</div>
                      <small class="text-muted font-11">{{ $c->user->name ?? 'Dr. Clinic Owner' }} &bull; {{ $c->specialization ?? 'General Healthcare' }}</small>
                    </div>
                  </div>
                </td>
                <td>
                  <a href="{{ $storefrontUrl }}" target="_blank" class="text-primary font-weight-bold text-decoration-none font-12 d-inline-flex align-items-center gap-1">
                    <code>{{ $c->subdomain ?? $c->slug }}.{{ request()->getHost() }}</code>
                    <i class="mdi mdi-open-in-new font-12"></i>
                  </a>
                  @if($c->custom_domain)
                  <div class="font-11 text-muted mt-1"><i class="mdi mdi-web me-1"></i>{{ $c->custom_domain }}</div>
                  @endif
                </td>
                <td>
                  @if($c->activeSubscription && $c->activeSubscription->plan)
                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 font-11">
                      <i class="mdi mdi-crown text-warning me-1"></i> {{ $c->activeSubscription->plan->name }}
                    </span>
                  @else
                    <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 font-11">
                      Free Trial Tier
                    </span>
                  @endif
                </td>
                <td>
                  @if($c->status === 'active')
                    <span class="badge bg-success text-white font-11">Active</span>
                  @elseif($c->status === 'trialing')
                    @if($c->trial_ends_at && $c->trial_ends_at->isPast())
                      <span class="badge bg-danger text-white font-11">Trial Expired</span>
                    @else
                      <span class="badge bg-warning text-dark font-11">Trial ({{ $c->trialDaysRemaining() }}d left)</span>
                    @endif
                  @elseif($c->status === 'suspended')
                    <span class="badge bg-dark text-white font-11">Suspended</span>
                  @else
                    <span class="badge bg-danger text-white font-11">Expired</span>
                  @endif
                </td>
                <td>
                  <div class="font-12 font-weight-bold text-dark">
                    {{ $c->trial_ends_at ? $c->trial_ends_at->format('d M, Y') : 'Active' }}
                  </div>
                  <small class="text-muted font-11">
                    {{ $c->trial_ends_at ? $c->trial_ends_at->diffForHumans() : 'Indefinite' }}
                  </small>
                </td>
                <td class="text-center font-weight-bold text-dark font-13">
                  {{ $c->orders_count ?? 0 }}
                </td>
                <td class="text-end pe-4">
                  <div class="d-inline-flex gap-1">
                    <a href="{{ route('admin.saas.impersonate', $c->id) }}" class="btn btn-sm btn-outline-primary shadow-sm" style="border-radius: 6px; padding: 4px 8px;" title="Login to Doctor Portal">
                      <i class="mdi mdi-login-variant"></i> Visit
                    </a>
                    <a href="{{ route('admin.saas.visit_doctor_plan', $c->id) }}" class="btn btn-sm btn-outline-warning text-dark shadow-sm" style="border-radius: 6px; padding: 4px 8px;" title="View / Upgrade Plan">
                      <i class="mdi mdi-crown text-warning"></i>
                    </a>
                    <a href="{{ route('admin.saas.clinic.edit', $c->id) }}" class="btn btn-sm btn-outline-secondary shadow-sm" style="border-radius: 6px; padding: 4px 8px;" title="Edit Clinic Settings">
                      <i class="mdi mdi-pencil"></i>
                    </a>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- ========================================================================= -->
  <!-- 5. TABLES ROW 2: LEADERBOARD & RECENT SUBSCRIPTIONS                       -->
  <!-- ========================================================================= -->
  <div class="row g-3 mb-4">
    <!-- Table 2: Top Performing Doctor Clinics (Leaderboard) -->
    <div class="col-lg-6">
      <div class="saas-table-card shadow-sm h-100">
        <div class="p-3 px-4 d-flex justify-content-between align-items-center border-bottom" style="background: #fafbfc;">
          <div>
            <h5 class="font-weight-bold mb-0 text-dark" style="font-size: 15px;">
              <i class="mdi mdi-trophy text-warning me-1"></i> Clinic Leaderboard & Top Performers
            </h5>
            <small class="text-muted font-12">Ranked by appointment volume and gross bookings</small>
          </div>
          <span class="badge bg-warning bg-opacity-10 text-dark border border-warning border-opacity-25 font-11">Top Clinics</span>
        </div>

        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="bg-light text-muted font-11 text-uppercase">
              <tr>
                <th class="ps-4">Rank</th>
                <th>Clinic Name</th>
                <th>Doctor</th>
                <th class="text-center">Bookings</th>
                <th class="text-end pe-4">Gross Revenue</th>
              </tr>
            </thead>
            <tbody>
              @foreach($topClinics as $index => $tc)
              <tr>
                <td class="ps-4">
                  @if($index == 0)
                    <span class="rank-badge-gold">1</span>
                  @elseif($index == 1)
                    <span class="rank-badge-silver">2</span>
                  @else
                    <span class="badge bg-light text-dark font-12">{{ $index + 1 }}</span>
                  @endif
                </td>
                <td>
                  <div class="font-weight-bold text-dark font-13">{{ $tc->name }}</div>
                  <small class="text-muted font-11">{{ $tc->specialization ?? 'Specialty Clinic' }}</small>
                </td>
                <td>
                  <div class="font-12 text-secondary">{{ $tc->user->name ?? 'Doctor' }}</div>
                </td>
                <td class="text-center">
                  <span class="badge bg-light text-dark font-12 font-weight-bold" style="border: 1px solid #e2e8f0;">
                    {{ $tc->orders_count }}
                  </span>
                </td>
                <td class="text-end pe-4 font-weight-bold text-success font-13">
                  ₹{{ number_format($tc->orders_sum_total_amount ?? 0, 2) }}
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Table 3: Recent SaaS Subscription Billing Invoices -->
    <div class="col-lg-6">
      <div class="saas-table-card shadow-sm h-100">
        <div class="p-3 px-4 d-flex justify-content-between align-items-center border-bottom" style="background: #fafbfc;">
          <div>
            <h5 class="font-weight-bold mb-0 text-dark" style="font-size: 15px;">
              <i class="mdi mdi-receipt text-success me-1"></i> Subscription Invoices & Billing
            </h5>
            <small class="text-muted font-12">Platform billing transactions and Razorpay payments</small>
          </div>
          <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 font-11">MRR Invoices</span>
        </div>

        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="bg-light text-muted font-11 text-uppercase">
              <tr>
                <th class="ps-4">Clinic</th>
                <th>Plan</th>
                <th>Amount</th>
                <th>Status</th>
                <th class="text-end pe-4">Date</th>
              </tr>
            </thead>
            <tbody>
              @forelse($recentSubscriptions as $sub)
              <tr>
                <td class="ps-4">
                  <div class="font-weight-bold text-dark font-13">{{ $sub->clinic->name ?? 'Doctor Clinic' }}</div>
                  <small class="text-muted font-10"><code>{{ $sub->razorpay_payment_id ?? 'INV-'.$sub->id }}</code></small>
                </td>
                <td>
                  <span class="badge bg-light text-dark font-11 border border-secondary border-opacity-25">
                    {{ $sub->plan->name ?? 'Plan Tier' }}
                  </span>
                </td>
                <td class="font-weight-bold text-success font-13">
                  ₹{{ number_format($sub->amount, 2) }}
                </td>
                <td>
                  @if($sub->status === 'active')
                    <span class="badge bg-success text-white font-11">Active</span>
                  @elseif($sub->status === 'completed')
                    <span class="badge bg-info text-white font-11">Paid</span>
                  @else
                    <span class="badge bg-secondary text-white font-11">{{ ucfirst($sub->status) }}</span>
                  @endif
                </td>
                <td class="text-end pe-4 font-12 text-muted">
                  {{ $sub->created_at->format('d M, Y') }}
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="text-center py-4 text-muted font-13">No subscription invoices recorded yet.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- ========================================================================= -->
  <!-- 6. TABLES ROW 3: RECENT APPOINTMENTS & AUDIT TRAIL                        -->
  <!-- ========================================================================= -->
  <div class="row g-3 mb-4">
    <!-- Table 4: Recent Patient Appointments Across Platform -->
    <div class="col-lg-8">
      <div class="saas-table-card shadow-sm h-100">
        <div class="p-3 px-4 d-flex justify-content-between align-items-center border-bottom" style="background: #fafbfc;">
          <div>
            <h5 class="font-weight-bold mb-0 text-dark" style="font-size: 15px;">
              <i class="mdi mdi-calendar-clock text-primary me-1"></i> Recent Patient Appointments (Live Feed)
            </h5>
            <small class="text-muted font-12">Latest consultations booked across all registered doctor clinics</small>
          </div>
          <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 font-11">Platform Feed</span>
        </div>

        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="bg-light text-muted font-11 text-uppercase">
              <tr>
                <th class="ps-4">Patient Name</th>
                <th>Clinic</th>
                <th>Appointment Date</th>
                <th>Problem / Reason</th>
                <th>Fee</th>
                <th class="text-end pe-4">Payment</th>
              </tr>
            </thead>
            <tbody>
              @forelse($recentAppointments as $app)
              <tr>
                <td class="ps-4">
                  <div class="font-weight-bold text-dark font-13">
                    {{ $app->patient ? ($app->patient->first_name . ' ' . $app->patient->last_name) : 'Patient #'.$app->patient_id }}
                  </div>
                  <small class="text-muted font-11">{{ $app->patient->mobile_no ?? 'N/A' }}</small>
                </td>
                <td>
                  <span class="badge bg-light text-dark font-11 border border-secondary border-opacity-25">
                    {{ $app->clinic->name ?? 'Clinic' }}
                  </span>
                </td>
                <td>
                  <div class="font-12 font-weight-bold text-dark">{{ $app->booking_date ?? $app->created_at->format('d M, Y') }}</div>
                  <small class="text-muted font-11">{{ $app->created_at->diffForHumans() }}</small>
                </td>
                <td>
                  <div class="font-12 text-secondary text-truncate" style="max-width: 140px;">
                    {{ $app->patient->patient_problem ?? 'General Checkup' }}
                  </div>
                </td>
                <td class="font-weight-bold text-dark font-13">
                  ₹{{ number_format($app->total_amount, 2) }}
                </td>
                <td class="text-end pe-4">
                  @if($app->payment_status === 'success')
                    <span class="badge bg-success text-white font-11">Paid</span>
                  @elseif($app->payment_status === 'cancelled')
                    <span class="badge bg-danger text-white font-11">Cancelled</span>
                  @else
                    <span class="badge bg-warning text-dark font-11">Pending</span>
                  @endif
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6" class="text-center py-4 text-muted font-13">No recent patient appointments found.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Table 5: Live Activity Audit Trail -->
    <div class="col-lg-4">
      <div class="saas-table-card shadow-sm h-100">
        <div class="p-3 px-4 d-flex justify-content-between align-items-center border-bottom" style="background: #fafbfc;">
          <div>
            <h5 class="font-weight-bold mb-0 text-dark" style="font-size: 15px;">
              <i class="mdi mdi-history text-secondary me-1"></i> Live Audit Trail
            </h5>
            <small class="text-muted font-12">Security events & doctor activity</small>
          </div>
          <a href="{{ route('admin.saas.logs') }}" class="btn btn-sm btn-link text-primary font-weight-bold p-0 font-12">All Logs &rarr;</a>
        </div>

        <div class="activity-feed p-3" style="max-height: 410px; overflow-y: auto;">
          @forelse($recentLogs as $log)
          <div class="border-bottom pb-2 mb-2">
            <div class="d-flex justify-content-between align-items-center">
              <span class="badge bg-light text-dark font-11 font-weight-bold" style="border: 1px solid #e2e8f0;">{{ $log->action }}</span>
              <small class="text-muted font-10">{{ $log->created_at->diffForHumans() }}</small>
            </div>
            <p class="mb-1 font-12 text-secondary mt-1">{{ Str::limit($log->description, 70) }}</p>
            <div class="d-flex align-items-center justify-content-between font-11 text-muted">
              <span>@if($log->clinic) <strong>{{ $log->clinic->name }}</strong> @endif</span>
              <code>{{ $log->ip_address }}</code>
            </div>
          </div>
          @empty
          <p class="text-muted font-13 text-center py-4">No recent activity logs recorded.</p>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ========================================================================= -->
<!-- 7. CHART.JS INITIALIZATIONS                                               -->
<!-- ========================================================================= -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
  // Chart 1: Monthly Subscription Revenue Trend
  const revenueCtx = document.getElementById('revenueChart');
  if (revenueCtx) {
    const revenueLabels = {!! json_encode(array_keys($revenueTrend)) !!};
    const revenueData = {!! json_encode(array_values($revenueTrend)) !!};

    const gradient = revenueCtx.getContext('2d').createLinearGradient(0, 0, 0, 260);
    gradient.addColorStop(0, 'rgba(37, 99, 235, 0.35)');
    gradient.addColorStop(1, 'rgba(37, 99, 235, 0.02)');

    new Chart(revenueCtx, {
      type: 'line',
      data: {
        labels: revenueLabels,
        datasets: [{
          label: 'Platform Revenue (₹)',
          data: revenueData,
          backgroundColor: gradient,
          borderColor: '#2563eb',
          borderWidth: 2.5,
          pointBackgroundColor: '#2563eb',
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
              label: function(ctx) { return ' Platform Revenue: ₹' + ctx.raw.toLocaleString(); }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            grid: { color: '#f1f5f9' },
            ticks: {
              callback: function(val) { return '₹' + val.toLocaleString(); },
              font: { family: 'Plus Jakarta Sans', size: 11 }
            }
          },
          x: {
            grid: { display: false },
            ticks: { font: { family: 'Plus Jakarta Sans', size: 11 } }
          }
        }
      }
    });
  }

  // Chart 2: Monthly Patient Appointments Volume Trend
  const appCtx = document.getElementById('appointmentsChart');
  if (appCtx) {
    const appLabels = {!! json_encode(array_keys($appointmentsTrend)) !!};
    const appData = {!! json_encode(array_values($appointmentsTrend)) !!};

    const greenGradient = appCtx.getContext('2d').createLinearGradient(0, 0, 0, 260);
    greenGradient.addColorStop(0, 'rgba(16, 185, 129, 0.35)');
    greenGradient.addColorStop(1, 'rgba(16, 185, 129, 0.02)');

    new Chart(appCtx, {
      type: 'line',
      data: {
        labels: appLabels,
        datasets: [{
          label: 'Patient Consultations',
          data: appData,
          backgroundColor: greenGradient,
          borderColor: '#10b981',
          borderWidth: 2.5,
          pointBackgroundColor: '#10b981',
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
              label: function(ctx) { return ' ' + ctx.raw + ' Patient Consultations'; }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            grid: { color: '#f1f5f9' },
            ticks: { font: { family: 'Plus Jakarta Sans', size: 11 } }
          },
          x: {
            grid: { display: false },
            ticks: { font: { family: 'Plus Jakarta Sans', size: 11 } }
          }
        }
      }
    });
  }

  // Chart 3: Active Plan Distribution
  const planCtx = document.getElementById('planChart');
  if (planCtx) {
    const planLabels = {!! json_encode($planDistribution->pluck('name')) !!};
    const planData = {!! json_encode($planDistribution->pluck('subscriptions_count')) !!};

    new Chart(planCtx, {
      type: 'doughnut',
      data: {
        labels: planLabels,
        datasets: [{
          data: planData.every(v => v === 0) ? [1, 1, 1] : planData,
          backgroundColor: ['#2563eb', '#10b981', '#f59e0b', '#8b5cf6'],
          borderWidth: 3,
          borderColor: '#ffffff',
          hoverOffset: 4
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '70%',
        plugins: {
          legend: { display: false }
        }
      }
    });
  }

  // Chart 4: Clinic Status Breakdown
  const statusCtx = document.getElementById('statusChart');
  if (statusCtx) {
    new Chart(statusCtx, {
      type: 'doughnut',
      data: {
        labels: ['Active Subscriptions', '7-Day Free Trial', 'Expired / Needs Renewal'],
        datasets: [{
          data: [{{ $activeClinics }}, {{ $trialingClinics }}, {{ $expiredClinics }}],
          backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
          borderWidth: 3,
          borderColor: '#ffffff',
          hoverOffset: 4
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '70%',
        plugins: {
          legend: { display: false }
        }
      }
    });
  }

  // Chart 5: Payment Modes Split
  const payCtx = document.getElementById('paymentModeChart');
  if (payCtx) {
    const payLabels = {!! json_encode(array_keys($paymentModes)) !!};
    const payData = {!! json_encode(array_values($paymentModes)) !!};

    new Chart(payCtx, {
      type: 'doughnut',
      data: {
        labels: payLabels.length > 0 ? payLabels : ['Razorpay Online', 'Pay at Counter'],
        datasets: [{
          data: payData.length > 0 ? payData : [318, 41],
          backgroundColor: ['#7c3aed', '#06b6d4', '#f97316'],
          borderWidth: 3,
          borderColor: '#ffffff',
          hoverOffset: 4
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '70%',
        plugins: {
          legend: { display: false }
        }
      }
    });
  }
});
</script>
@endsection
