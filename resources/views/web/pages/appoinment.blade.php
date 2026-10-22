@extends('web.layouts.main')

@php
  $clinic = $currentClinic ?? \App\Models\Clinic::first();
  $themeColor = $clinic->theme_color ?? '#0d9488';
  $secondaryColor = $clinic->secondary_color ?? '#14b8a6';

  $hex = ltrim($themeColor, '#');
  if (strlen($hex) == 3) {
      $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
      $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
      $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
  } elseif (strlen($hex) == 6) {
      $r = hexdec(substr($hex, 0, 2));
      $g = hexdec(substr($hex, 2, 2));
      $b = hexdec(substr($hex, 4, 2));
  } else {
      $r = 13; $g = 148; $b = 136;
  }
@endphp

@section('style')
<link rel="stylesheet" href="{{ URL::to('public/assets/web/css/appointment/appoint-style.css')}}">
<link rel="stylesheet" href="{{ URL::to('public/assets/web/css/appointment/appoint-responsive.css')}}">
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<style>
  :root {
    --vital-primary: {{ $themeColor }};
    --vital-primary-rgb: {{ $r }}, {{ $g }}, {{ $b }};
    --vital-primary-dark: {{ $themeColor }};
    --vital-primary-light: rgba({{ $r }}, {{ $g }}, {{ $b }}, 0.12);
    --vital-secondary: {{ $secondaryColor }};
    --clinic-primary: {{ $themeColor }};
    --clinic-secondary: {{ $secondaryColor }};
  }

  /* ========================================================
     1. VITALCARE HERO SECTION
     ======================================================== */
  .vital-hero-section {
    background: linear-gradient(180deg, rgba(var(--vital-primary-rgb), 0.05) 0%, #ffffff 100%);
    padding: 40px 0 60px 0;
    position: relative;
    overflow: hidden;
  }
  .vital-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(var(--vital-primary-rgb), 0.1);
    color: var(--vital-primary);
    font-size: 13.5px;
    font-weight: 700;
    padding: 7px 18px;
    border-radius: 30px;
    border: 1px solid rgba(var(--vital-primary-rgb), 0.25);
  }
  .vital-pulse-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--vital-primary);
    box-shadow: 0 0 0 0 rgba(var(--vital-primary-rgb), 0.7);
    animation: vitalPulse 1.8s infinite;
  }
  @keyframes vitalPulse {
    0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(var(--vital-primary-rgb), 0.7); }
    70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(var(--vital-primary-rgb), 0); }
    100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(var(--vital-primary-rgb), 0); }
  }
  .vital-hero-title {
    font-size: 54px;
    font-weight: 800;
    color: #0f172a;
    line-height: 1.15;
    letter-spacing: -1.2px;
  }
  .vital-highlight {
    color: var(--vital-primary);
  }
  .vital-hero-subtitle {
    font-size: 16.5px;
    color: #64748b;
    line-height: 1.6;
    max-width: 640px;
  }
  .vital-hero-cta {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 14px;
  }
  .btn-vital-primary {
    background: var(--vital-primary);
    color: #ffffff !important;
    font-weight: 700;
    font-size: 15px;
    padding: 14px 28px;
    border-radius: 30px;
    text-decoration: none;
    box-shadow: 0 6px 20px rgba(var(--vital-primary-rgb), 0.35);
    display: inline-flex;
    align-items: center;
    transition: all 0.2s ease;
  }
  .btn-vital-primary:hover {
    background: var(--vital-secondary);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(var(--vital-primary-rgb), 0.45);
    color: #ffffff;
  }
  .btn-vital-outline {
    background: #ffffff;
    color: #0f172a !important;
    font-weight: 600;
    font-size: 15px;
    padding: 14px 28px;
    border-radius: 30px;
    border: 1.5px solid #cbd5e1;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    transition: all 0.2s ease;
  }
  .btn-vital-outline:hover {
    border-color: var(--vital-primary);
    color: var(--vital-primary) !important;
    background: rgba(var(--vital-primary-rgb), 0.05);
  }
  .vital-stats-row {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
  }
  .vital-stat-chip {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #ffffff;
    padding: 8px 16px;
    border-radius: 30px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    border: 1px solid #e2e8f0;
  }
  .stat-icon {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: var(--vital-primary);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
  }
  .stat-text strong {
    font-size: 15px;
    font-weight: 800;
    color: #0f172a;
    display: block;
    line-height: 1.1;
  }
  .stat-text span {
    font-size: 11px;
    color: #64748b;
    font-weight: 600;
  }

  /* Right Doctor Visual */
  .vital-hero-img-wrap {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    max-width: 100%;
    min-height: 480px;
    padding: 20px 0;
  }
  .vital-hero-backdrop {
    width: 440px;
    height: 440px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--vital-primary) 0%, var(--vital-secondary) 100%);
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1;
    opacity: 0.95;
    box-shadow: 0 10px 30px rgba(var(--vital-primary-rgb), 0.2);
  }
  .vital-doctor-img {
    position: relative;
    z-index: 2;
    max-width: 380px;
    height: 460px;
    width: 100%;
    border-radius: 28px;
    box-shadow: 0 20px 40px rgba(var(--vital-primary-rgb), 0.25);
    object-fit: cover;
    object-position: top center;
    display: block;
  }
  .vital-emergency-card {
    position: absolute;
    bottom: 25px;
    right: -10px;
    z-index: 3;
    background: #ffffff;
    padding: 16px 22px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
    display: flex;
    align-items: center;
    gap: 14px;
    border: 1px solid #f1f5f9;
    text-align: left;
    animation: floatCard 3s ease-in-out infinite;
  }
  @keyframes floatCard {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-6px); }
  }
  .emerg-icon {
    width: 46px;
    height: 46px;
    border-radius: 50%;
    background: #f0fdf4;
    color: #16a34a;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    border: 1px solid #bbf7d0;
  }
  .emerg-title {
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
    display: block;
    line-height: 1;
  }
  .emerg-sub {
    font-size: 11.5px;
    color: #64748b;
    font-weight: 600;
  }

  /* ========================================================
     2. SERVICES SECTION
     ======================================================== */
  .vital-section-heading {
    font-size: 34px;
    font-weight: 800;
    color: #0f172a;
    letter-spacing: -0.5px;
    margin-bottom: 6px;
  }
  .vital-heading-bar {
    width: 48px;
    height: 4px;
    background: var(--vital-primary);
    border-radius: 4px;
    margin: 0 auto;
  }
  .vital-service-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 32px 24px;
    border: 1px solid #f1f5f9;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
  }
  .vital-service-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 14px 30px rgba(var(--vital-primary-rgb), 0.12);
    border-color: var(--vital-primary);
  }
  .service-icon-box {
    width: 56px;
    height: 56px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    margin-bottom: 20px;
  }
  .service-title {
    font-size: 19px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 10px;
  }
  .service-desc {
    font-size: 14px;
    color: #64748b;
    line-height: 1.6;
    margin-bottom: 20px;
    flex-grow: 1;
  }
  .service-link {
    color: var(--vital-primary);
    font-weight: 700;
    font-size: 14px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: gap 0.2s;
  }
  .service-link:hover {
    color: var(--vital-secondary);
    gap: 10px;
  }

  /* ========================================================
     3. FOUR-COLUMN PROMO GRID
     ======================================================== */
  .vital-feature-card {
    background: #ffffff;
    border-radius: 18px;
    padding: 22px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 16px rgba(0,0,0,0.04);
    transition: all 0.2s ease;
  }
  .vital-feature-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 24px rgba(0,0,0,0.08);
  }
  .feature-card-title {
    font-size: 17px;
    font-weight: 700;
    color: #0f172a;
  }
  .btn-outline-teal {
    border: 1.5px solid var(--vital-primary);
    color: var(--vital-primary) !important;
    background: transparent;
    border-radius: 10px;
    padding: 9px 16px;
    font-size: 13.5px;
    text-decoration: none;
    display: block;
    text-align: center;
    transition: all 0.2s;
  }
  .btn-outline-teal:hover {
    background: var(--vital-primary);
    color: #ffffff !important;
  }
  .btn-teal-solid {
    background: var(--vital-primary);
    color: #ffffff !important;
    border-radius: 10px;
    padding: 9px 16px;
    font-size: 13.5px;
    text-decoration: none;
    display: block;
    text-align: center;
    transition: all 0.2s;
    border: none;
  }
  .btn-teal-solid:hover {
    background: var(--vital-secondary);
    color: #ffffff !important;
  }
  .why-choose-list li {
    font-size: 13.5px;
    color: #334155;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    font-weight: 500;
  }
  .text-teal {
    color: var(--vital-primary) !important;
  }

  /* ========================================================
     4. CALENDAR & BOOKING ENGINE STYLING
     ======================================================== */
  .vital-booking-card {
    background: #ffffff;
    border-radius: 24px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    padding: 36px;
    margin-bottom: 50px;
  }
  .fc .fc-toolbar-title {
    font-size: 20px !important;
    font-weight: 800 !important;
    color: #0f172a !important;
  }
  .fc .fc-button-primary {
    background-color: var(--vital-primary) !important;
    border-color: var(--vital-primary) !important;
    border-radius: 8px !important;
    font-weight: 600 !important;
    font-size: 13px !important;
    padding: 6px 14px !important;
  }
  .fc .fc-button-primary:hover {
    background-color: var(--vital-secondary) !important;
    border-color: var(--vital-secondary) !important;
  }
  .fc .fc-daygrid-day-number {
    font-weight: 600;
    color: #334155;
    padding: 8px !important;
  }
  .fc .fc-day-today {
    background-color: rgba(var(--vital-primary-rgb), 0.08) !important;
  }
  .fc .fc-day-today .fc-daygrid-day-number {
    color: var(--vital-primary) !important;
    font-weight: 800 !important;
  }
  .fc .fc-daygrid-day.fc-daygrid-day-selected,
  .fc-daygrid-day-selected,
  .fc .fc-day-today.fc-daygrid-day-selected {
    background-color: var(--vital-primary) !important;
    color: #ffffff !important;
  }
  .fc .fc-daygrid-day.fc-daygrid-day-selected .fc-daygrid-day-number,
  .fc-daygrid-day-selected .fc-daygrid-day-number {
    color: #ffffff !important;
    font-weight: 800 !important;
  }
  .time-slot-badge {
    display: inline-flex;
    align-items: center;
    padding: 10px 16px;
    margin: 6px;
    border-radius: 25px;
    font-size: 13.5px;
    font-weight: 600;
    cursor: pointer;
    background: #f1f5f9;
    color: #1e293b;
    border: 1.5px solid #e2e8f0;
    transition: all 0.2s ease;
  }
  .time-slot-badge:hover {
    border-color: var(--vital-primary);
    color: var(--vital-primary);
    background: rgba(var(--vital-primary-rgb), 0.06);
  }
  .time-slot-badge.selected {
    background-color: var(--vital-primary) !important;
    color: #ffffff !important;
    border-color: var(--vital-primary) !important;
    box-shadow: 0 4px 12px rgba(var(--vital-primary-rgb), 0.35);
  }
  #SubmitForBooking {
    background: var(--vital-primary);
    border: none;
    color: #ffffff;
    font-weight: 700;
    font-size: 15px;
    padding: 12px 28px;
    border-radius: 30px;
    box-shadow: 0 4px 16px rgba(var(--vital-primary-rgb), 0.35);
    transition: all 0.2s;
  }
  #SubmitForBooking:hover {
    background: var(--vital-secondary);
    transform: translateY(-2px);
  }

  @media (max-width: 991px) {
    .vital-hero-section { padding: 30px 0 40px 0; }
    .vital-hero-title { font-size: clamp(32px, 5vw, 42px); }
    .vital-hero-backdrop { width: 300px; height: 300px; }
    .vital-doctor-img { max-width: 280px; }
    .vital-emergency-card { right: 10px; bottom: 0; padding: 10px 14px; }
    .vital-booking-card { padding: 24px; border-radius: 18px; }
  }

  @media (max-width: 576px) {
    .vital-hero-section { padding: 24px 0 32px 0; }
    .vital-hero-badge { font-size: 12px; padding: 6px 14px; }
    .vital-hero-title { font-size: 27px; line-height: 1.22; letter-spacing: -0.5px; }
    .vital-hero-subtitle { font-size: 13.5px; line-height: 1.6; margin-bottom: 20px; }
    .vital-hero-cta { flex-direction: column; width: 100%; gap: 10px; margin-bottom: 26px !important; }
    .btn-vital-primary, .btn-vital-outline { width: 100%; justify-content: center; text-align: center; padding: 12px 20px; font-size: 14px; border-radius: 26px; }
    
    /* 3-Column Mobile Stats Grid - All 3 Badges In One Clean Row */
    .vital-stats-row {
      display: grid !important;
      grid-template-columns: repeat(3, 1fr) !important;
      gap: 6px !important;
      width: 100% !important;
      margin-top: 6px;
    }
    .vital-stat-chip {
      padding: 10px 4px !important;
      border-radius: 14px !important;
      flex-direction: column !important;
      text-align: center !important;
      gap: 5px !important;
      justify-content: center !important;
      min-width: 0 !important;
      background: #ffffff !important;
    }
    .stat-icon {
      width: 28px !important;
      height: 28px !important;
      font-size: 12px !important;
      margin: 0 auto !important;
      flex-shrink: 0;
    }
    .stat-text {
      min-width: 0;
      width: 100%;
    }
    .stat-text strong {
      font-size: 13px !important;
      margin-bottom: 1px;
      line-height: 1.1;
    }
    .stat-text span {
      font-size: 9.5px !important;
      line-height: 1.15;
      display: block;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      color: #64748b;
    }

    /* Hero Doctor Visual & Emergency Badge Centered & Clean */
    .vital-hero-img-wrap {
      min-height: auto !important;
      padding: 16px 0 10px 0 !important;
      width: 100%;
      flex-direction: column;
      align-items: center;
    }
    .vital-hero-backdrop {
      width: 220px !important;
      height: 220px !important;
    }
    .vital-doctor-img {
      max-width: 210px !important;
      height: 270px !important;
      border-radius: 20px !important;
    }
    .vital-emergency-card {
      position: relative !important;
      bottom: auto !important;
      right: auto !important;
      margin: -18px auto 0 auto !important;
      display: inline-flex !important;
      width: auto !important;
      padding: 8px 16px !important;
      border-radius: 14px !important;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12) !important;
    }
    .emerg-icon {
      width: 36px !important;
      height: 36px !important;
      font-size: 15px !important;
    }
    .emerg-title {
      font-size: 18px !important;
    }
    .emerg-sub {
      font-size: 10px !important;
    }

    /* Services & Features */
    .vital-section-heading { font-size: 26px; }
    .vital-service-card { padding: 22px 18px; border-radius: 16px; }

    /* Calendar & Booking */
    .vital-booking-card { padding: 16px 12px; border-radius: 16px; }
    .fc .fc-toolbar { flex-direction: column; gap: 8px; align-items: center; }
    .fc .fc-toolbar-title { font-size: 15px !important; }
    .fc .fc-button { padding: 4px 8px !important; font-size: 11.5px !important; }
    .fc-daygrid-day-number { font-size: 11.5px !important; padding: 3px !important; }
    .fc-col-header-cell-cushion { font-size: 11px !important; padding: 3px !important; }
    .time-slot-badge { flex: 1 1 calc(50% - 10px); min-width: 85px; justify-content: center; margin: 4px; padding: 8px 8px; font-size: 12px; }
  }
</style>
@endsection

@section('banner')
<!-- ========================================================
     HERO SECTION (Matching Reference Design - 100% Full Width & Responsive)
     ======================================================== -->
<section class="vital-hero-section">
  <div class="container-fluid" style="max-width: 1440px; padding-left: clamp(16px, 3.5vw, 48px); padding-right: clamp(16px, 3.5vw, 48px);">
    <div class="row align-items-center">
      <!-- Left Column: Copy & CTAs -->
      <div class="col-lg-6 col-md-12 py-3 py-lg-5">
        <div class="vital-hero-badge mb-3">
          <span class="vital-pulse-dot"></span>
          <i class="fa-regular fa-circle-check mr-1"></i> Trusted Care. Better Health.
        </div>

        <h1 class="vital-hero-title mb-3">
          @if(isset($currentClinic) && $currentClinic->name)
            {{ $currentClinic->name }}<br>
            <span class="vital-highlight">{{ $currentClinic->specialization ?? 'Healthcare & Wellness' }}</span>
          @else
            Your Health<br>
            <span class="vital-highlight">Our Priority</span>
          @endif
        </h1>

        <p class="vital-hero-subtitle mb-4">
          {{ $currentClinic->bio ?? 'Compassionate care, experienced doctors, and modern healthcare facilities — dedicated to your health and well-being.' }}
        </p>

        <div class="vital-hero-cta mb-5">
          <a href="#booking-section" class="btn-vital-primary">
            <i class="fa-regular fa-calendar-check mr-2" style="margin-right: 8px;"></i> Book Appointment
          </a>
          <a href="#services-section" class="btn-vital-outline">
            Our Services <i class="fa-solid fa-arrow-right ml-2" style="margin-left: 8px;"></i>
          </a>
        </div>

        <!-- Trust Stats Badges -->
        <div class="vital-stats-row">
          <div class="vital-stat-chip">
            <div class="stat-icon"><i class="fa-solid fa-user-doctor"></i></div>
            <div class="stat-text"><strong>Certified</strong><span>Specialists</span></div>
          </div>
          <div class="vital-stat-chip">
            <div class="stat-icon"><i class="fa-regular fa-face-smile"></i></div>
            <div class="stat-text"><strong>100%</strong><span>Patient Focus</span></div>
          </div>
          <div class="vital-stat-chip">
            <div class="stat-icon"><i class="fa-solid fa-shield-heart"></i></div>
            <div class="stat-text"><strong>Safe &amp; Clean</strong><span>Environment</span></div>
          </div>
        </div>
      </div>

      <!-- Right Column: Doctor Portrait / Clinic Banner & Emergency Badge -->
      <div class="col-lg-6 col-md-12 text-center position-relative py-4">
        <div class="vital-hero-img-wrap">
          <div class="vital-hero-backdrop"></div>
          @if(isset($currentClinic) && $currentClinic->banner)
            <img src="{{ asset('storage/' . $currentClinic->banner) }}" alt="{{ $currentClinic->name ?? 'Clinic' }}" class="vital-doctor-img" style="object-fit: cover;">
          @else
            <img src="{{ URL::to('public/assets/web/modern/hero-doctor.jpg') }}" alt="{{ $currentClinic->name ?? 'Doctor' }}" class="vital-doctor-img">
          @endif
          
          <div class="vital-emergency-card">
            <div class="emerg-icon">
              <i class="fa-solid fa-headset"></i>
            </div>
            <div class="emerg-text">
              <span class="emerg-title">Direct</span>
              <span class="emerg-sub">Patient Support</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('content')
<!-- ========================================================
     SECTION 2: OUR SERVICES (Dynamic & Universal for Any Clinic)
     ======================================================== -->
<section id="services-section" class="vital-services-section py-5">
  <div class="container-fluid" style="max-width: 1440px; padding-left: clamp(16px, 3.5vw, 48px); padding-right: clamp(16px, 3.5vw, 48px);">
    <div class="text-center mb-5">
      <h2 class="vital-section-heading">Our Services</h2>
      <div class="vital-heading-bar"></div>
      <p class="text-muted mt-2" style="font-size: 15px;">Personalized medical and clinical care tailored for your specific health needs.</p>
    </div>

    <div class="row g-4">
      @forelse($clinicServices as $service)
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="vital-service-card h-100 d-flex flex-column justify-content-between">
          <div>
            <div class="service-icon-box" style="background: rgba(var(--clinic-primary-rgb), 0.1); color: var(--clinic-primary);">
              <i class="{{ $service->icon_class }}"></i>
            </div>
            <h4 class="service-title">{{ $service->title }}</h4>
            <p class="service-desc">{{ $service->description ?? 'Specialized clinical care and patient-first medical treatment.' }}</p>
          </div>
          <div class="mt-3 pt-3 d-flex align-items-center justify-content-between" style="border-top: 1px dashed #e2e8f0;">
            @if($service->price > 0)
              <span class="font-weight-bold" style="color: var(--clinic-primary); font-size: 15px;">₹{{ number_format($service->price, 0) }}</span>
            @else
              <span class="text-muted" style="font-size: 12.5px;"><i class="fa-solid fa-circle-check text-success mr-1"></i> Available</span>
            @endif
            <a href="#booking-section" class="service-link">Book Now <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>
      </div>
      @empty
      <!-- Universal Healthcare Services Fallback -->
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="vital-service-card h-100 d-flex flex-column justify-content-between">
          <div>
            <div class="service-icon-box" style="background: rgba(var(--clinic-primary-rgb), 0.1); color: var(--clinic-primary);">
              <i class="fa-solid fa-user-doctor"></i>
            </div>
            <h4 class="service-title">Clinical Consultation</h4>
            <p class="service-desc">Comprehensive patient assessment, expert medical diagnosis, and personalized therapy plans.</p>
          </div>
          <div class="mt-3 pt-3 d-flex align-items-center justify-content-between" style="border-top: 1px dashed #e2e8f0;">
            <span class="font-weight-bold" style="color: var(--clinic-primary); font-size: 15px;">From ₹{{ number_format($currentClinic->consultation_fee ?? 499, 0) }}</span>
            <a href="#booking-section" class="service-link">Book Now <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="vital-service-card h-100 d-flex flex-column justify-content-between">
          <div>
            <div class="service-icon-box" style="background: rgba(var(--clinic-primary-rgb), 0.1); color: var(--clinic-primary);">
              <i class="fa-solid fa-microscope"></i>
            </div>
            <h4 class="service-title">Diagnostics &amp; Screening</h4>
            <p class="service-desc">Accurate clinical screening, precise diagnostics, and health symptom evaluation with modern equipment.</p>
          </div>
          <div class="mt-3 pt-3 d-flex align-items-center justify-content-between" style="border-top: 1px dashed #e2e8f0;">
            <span class="text-muted" style="font-size: 12.5px;"><i class="fa-solid fa-circle-check text-success mr-1"></i> Available</span>
            <a href="#booking-section" class="service-link">Book Now <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="vital-service-card h-100 d-flex flex-column justify-content-between">
          <div>
            <div class="service-icon-box" style="background: rgba(var(--clinic-primary-rgb), 0.1); color: var(--clinic-primary);">
              <i class="fa-solid fa-kit-medical"></i>
            </div>
            <h4 class="service-title">Preventive Care</h4>
            <p class="service-desc">Proactive routine wellness checks, regular health tracking, and lifestyle health guidance.</p>
          </div>
          <div class="mt-3 pt-3 d-flex align-items-center justify-content-between" style="border-top: 1px dashed #e2e8f0;">
            <span class="text-muted" style="font-size: 12.5px;"><i class="fa-solid fa-circle-check text-success mr-1"></i> Available</span>
            <a href="#booking-section" class="service-link">Book Now <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="vital-service-card h-100 d-flex flex-column justify-content-between">
          <div>
            <div class="service-icon-box" style="background: rgba(var(--clinic-primary-rgb), 0.1); color: var(--clinic-primary);">
              <i class="fa-solid fa-notes-medical"></i>
            </div>
            <h4 class="service-title">Follow-up &amp; Monitoring</h4>
            <p class="service-desc">Continued recovery monitoring, prescription adjustments, and comprehensive follow-up care.</p>
          </div>
          <div class="mt-3 pt-3 d-flex align-items-center justify-content-between" style="border-top: 1px dashed #e2e8f0;">
            <span class="text-muted" style="font-size: 12.5px;"><i class="fa-solid fa-circle-check text-success mr-1"></i> Available</span>
            <a href="#booking-section" class="service-link">Book Now <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>
      </div>
      @endforelse
    </div>
  </div>
</section>

<!-- ========================================================
     SECTION 3: INTERACTIVE APPOINTMENT CALENDAR (Fluid Responsive)
     ======================================================== -->
<section id="booking-section" class="py-5" style="background: #f8fafc;">
  <div class="container-fluid" style="max-width: 1440px; padding-left: clamp(16px, 3.5vw, 48px); padding-right: clamp(16px, 3.5vw, 48px);">
    
    <div class="text-center mb-4">
      <div class="vital-hero-badge mb-2">
        <span class="vital-pulse-dot"></span>
        <span>Online Consultation</span>
      </div>
      <h2 class="vital-section-heading">Book An Appointment</h2>
      <div class="vital-heading-bar mb-3"></div>
      <p class="text-muted" style="max-width: 600px; margin: 0 auto; font-size: 15px;">
        Select your desired date on the calendar to view available consultation slots.
      </p>
    </div>

    <!-- Modern Notice Alert (If Set) -->
    @if((isset($setting) && !empty($setting->frontend_notice)) || (isset($currentClinic) && $currentClinic->phone))
    <div class="p-3 mb-4 rounded-3 d-flex align-items-center" style="background: #fff7ed; border: 1px solid #ffedd5; color: #9a3412; font-size: 14px;">
      <i class="fa-solid fa-bullhorn mr-2" style="margin-right: 10px; font-size: 16px;"></i>
      <div>
        <strong>Notice:</strong> {{ $setting->frontend_notice ?? 'Clinic consultations available Monday to Saturday.' }}
        @if(isset($currentClinic) && $currentClinic->phone)
          &bull; For phone support, call: <a href="tel:{{ $currentClinic->phone }}" style="color: #c2410c; font-weight: 700;">{{ $currentClinic->phone }}</a>
        @endif
      </div>
    </div>
    @endif

    <div class="vital-booking-card">
      <div id="step-1">
        @if (isset($setting) && $setting->payment_permission_status == 'yes') 

        @if (session('error'))
          <div id="error-alert" class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <form action="{{ url('book_appointment') }}" method="get" id="booking-form">
          @if (isset($errors) && $errors->any())
            <div class="alert alert-danger mb-4">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <div class="row g-4">
            <!-- Calendar Column -->
            <div class="col-lg-7 col-md-12">
              <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="mb-0 font-weight-bold" style="color: #0f172a; font-size: 18px;">
                  <i class="fa-regular fa-calendar mr-2" style="color: var(--clinic-primary); margin-right: 6px;"></i> 1. Select Date
                </h5>
                <span class="text-muted" style="font-size: 13px;">Dates marked with open slots</span>
              </div>
              <div id="calendar"></div>
              <input type="hidden" id="selected-date" name="booking_date">
            </div>

            <!-- Time Slots Column -->
            <div class="col-lg-5 col-md-12">
              <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="mb-0 font-weight-bold" style="color: #0f172a; font-size: 18px;">
                  <i class="fa-regular fa-clock mr-2" style="color: var(--clinic-primary); margin-right: 6px;"></i> 2. Available Slots
                </h5>
              </div>

              <!-- Time Slot Picker Wrapper -->
              <div id="step-2" style="display: none; background: #f8fafc; border-radius: 16px; padding: 20px; border: 1px solid #e2e8f0;">
                <p class="text-muted mb-3" style="font-size: 13.5px;">Click on your preferred appointment time:</p>
                <div id="time-slot-container" class="d-flex flex-wrap mb-3"></div>

                <input type="hidden" id="selected-time-slot" name="time_slot_id">

                <div class="p-3 rounded-3 mb-3" style="background: rgba(var(--clinic-primary-rgb), 0.08); border: 1px solid rgba(var(--clinic-primary-rgb), 0.2); font-size: 13px; color: #0f172a; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
                  <div>
                    <i class="fa fa-info-circle mr-1" style="color: var(--clinic-primary);"></i> 
                    <span>Consultation Fee: <strong>₹{{ number_format($currentClinic->consultation_fee ?? 499, 2) }}</strong></span>
                    @if(isset($currentClinic) && $currentClinic->platform_fee > 0)
                      <span class="text-muted" style="font-size: 12px; margin-left: 6px;">(+ ₹{{ number_format($currentClinic->platform_fee, 2) }} platform charge)</span>
                    @endif
                  </div>
                  @if(isset($currentClinic) && $currentClinic->platform_fee > 0)
                    <span class="badge" style="background: var(--clinic-primary); color: #fff; font-size: 11px; padding: 4px 8px; border-radius: 6px;">
                      Total: ₹{{ number_format(($currentClinic->consultation_fee ?? 499) + $currentClinic->platform_fee, 2) }}
                    </span>
                  @endif
                </div>

                <div class="text-end">
                  <button id="SubmitForBooking" class="btn d-none w-100" type="submit">
                    Proceed to Patient Details <i class="fa-solid fa-arrow-right ml-2" style="margin-left: 6px;"></i>
                  </button>
                </div>
              </div>

              <!-- When No Date Is Selected Yet -->
              <div id="prompt-select-date" class="text-center p-5 rounded-4" style="background: #f8fafc; border: 2px dashed #cbd5e1;">
                <div style="width: 56px; height: 56px; border-radius: 50%; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 24px;">
                  <i class="fa-regular fa-calendar-check"></i>
                </div>
                <h6 class="font-weight-bold mb-1" style="color: #334155;">No Date Selected</h6>
                <p class="text-muted mb-0" style="font-size: 13px;">Please select any available date on the calendar to see doctor time slots.</p>
              </div>

              <!-- When Doctor Is Unavailable -->
              <div class="doctor-unavailable text-center p-5 rounded-4" style="display: none; background: #fff1f2; border: 1px solid #fecdd3;">
                <div style="width: 50px; height: 50px; border-radius: 50%; background: #fee2e2; color: #dc2626; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px; font-size: 22px;">
                  <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <h6 class="font-weight-bold mb-1" style="color: #991b1b;">Doctor Not Available</h6>
                <p class="text-muted mb-0" style="font-size: 13px;">No consultation slots on this date. Please choose another date.</p>
              </div>
            </div>
          </div>
        </form>
        @else
        <div class="text-center my-5 p-5 rounded-4" style="background: #fff7ed; border: 1px solid #ffedd5;">
          <i class="fa-solid fa-clock mb-3" style="font-size: 40px; color: #ea580c;"></i>
          <h4 class="font-weight-bold mb-2" style="color: #9a3412;">Clinic Consultations Temporarily Closed</h4>
          <p class="text-muted mb-0">Online bookings are currently paused. Please check back later or contact clinic support.</p>
        </div>
        @endif
      </div>
    </div>
  </div>
</section>

<!-- ========================================================
     SECTION 4: SPECIALTIES & HEALTHCARE HIGHLIGHTS (After Booking Section)
     ======================================================== -->
<section id="specialties-section" class="vital-features-grid py-5" style="background: #ffffff; border-top: 1px solid #f1f5f9;">
  <div class="container-fluid" style="max-width: 1440px; padding-left: clamp(16px, 3.5vw, 48px); padding-right: clamp(16px, 3.5vw, 48px);">
    <div class="text-center mb-5">
      <div class="vital-hero-badge mb-2">
        <span class="vital-pulse-dot"></span>
        <span>Clinic Specialization</span>
      </div>
      <h2 class="vital-section-heading">Our Specialties</h2>
      <div class="vital-heading-bar mb-3"></div>
      <p class="text-muted" style="max-width: 650px; margin: 0 auto; font-size: 15px;">
        Comprehensive healthcare packages, experienced medical specialists, and dedicated patient care.
      </p>
    </div>

    <div class="row g-4">
      <!-- Card 1: Consultation Packages -->
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="vital-feature-card h-100 d-flex flex-column justify-content-between">
          <div>
            <h5 class="feature-card-title mb-1">Consultation Packages</h5>
            <div class="package-price mb-3">
              <span class="text-muted" style="font-size: 13px;">Starting From</span>
              <div class="price-value" style="color: var(--clinic-primary); font-size: 26px; font-weight: 800;">
                ₹{{ number_format($currentClinic->consultation_fee ?? 499, 0) }}
              </div>
            </div>
            <div class="feature-img-box mb-3">
              <img src="{{ URL::to('public/assets/web/modern/family-checkup.jpg') }}" alt="Consultation Packages" class="w-100 rounded-3" style="height: 140px; object-fit: cover;">
            </div>
          </div>
          <a href="#booking-section" class="btn-outline-teal">Book Consultation</a>
        </div>
      </div>

      <!-- Card 2: Why Choose Us? -->
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="vital-feature-card h-100 d-flex flex-column justify-content-between">
          <div>
            <h5 class="feature-card-title mb-3">Why Choose Us?</h5>
            <ul class="why-choose-list list-unstyled mb-4">
              <li><i class="fa-solid fa-circle-check mr-2" style="color: var(--clinic-primary); margin-right: 8px;"></i> Qualified Medical Team</li>
              <li><i class="fa-solid fa-circle-check mr-2" style="color: var(--clinic-primary); margin-right: 8px;"></i> Modern Clinical Equipment</li>
              <li><i class="fa-solid fa-circle-check mr-2" style="color: var(--clinic-primary); margin-right: 8px;"></i> Patient-Centered Approach</li>
              <li><i class="fa-solid fa-circle-check mr-2" style="color: var(--clinic-primary); margin-right: 8px;"></i> Transparent Pricing</li>
            </ul>
          </div>
          <a href="#booking-section" class="btn-outline-teal">Schedule Visit</a>
        </div>
      </div>

      <!-- Card 3: Quality Care Today -->
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="vital-feature-card h-100 d-flex flex-column justify-content-between">
          <div>
            <h5 class="feature-card-title mb-1">Quality Care Today</h5>
            <p class="text-muted mb-3" style="font-size: 13px; line-height: 1.5;">Prompt consultations, accurate diagnosis, healthier recovery.</p>
            <div class="feature-img-box mb-3">
              <img src="{{ URL::to('public/assets/web/modern/patient-care.jpg') }}" alt="Quality Care" class="w-100 rounded-3" style="height: 140px; object-fit: cover;">
            </div>
          </div>
          <a href="#booking-section" class="btn-teal-solid">Book Appointment</a>
        </div>
      </div>

      <!-- Card 4: Direct Clinic Line -->
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="vital-feature-card h-100 d-flex flex-column justify-content-between">
          <div>
            <h5 class="feature-card-title mb-1">Direct Clinic Line</h5>
            <div class="emerg-highlight mb-1" style="color: var(--clinic-secondary, #f59e0b); font-size: 24px; font-weight: 800;">
              @if(isset($currentClinic) && $currentClinic->phone)
                {{ $currentClinic->phone }}
              @else
                Patient Support
              @endif
            </div>
            <p class="text-muted mb-2" style="font-size: 13px;">Reach out for inquiries, scheduling, or support.</p>
            <div class="feature-img-box mb-3">
              <img src="{{ URL::to('public/assets/web/modern/ambulance.jpg') }}" alt="Clinic Care" class="w-100 rounded-3" style="height: 140px; object-fit: cover;">
            </div>
          </div>
          @if(isset($currentClinic) && $currentClinic->phone)
            <a href="tel:{{ $currentClinic->phone }}" class="btn-outline-teal">Call Clinic</a>
          @else
            <a href="#booking-section" class="btn-outline-teal">Book Online</a>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let selectedTimeSlot = null;
        let selectedDate = null;
        let calendarEl = document.getElementById('calendar');

        if (!calendarEl) return;

        let calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            selectable: true,
            headerToolbar: {
                left: 'myTodayButton',
                center: 'title',
                right: 'prev,next'
            },
            customButtons: {
                myTodayButton: {
                    text: 'Today',
                    click: function () {
                        calendar.today();
                    }
                }
            },
            validRange: {
                end: new Date(new Date().setMonth(new Date().getMonth() + 3))
            },
            dateClick: function(info) {
                if (info.date < new Date().setHours(0, 0, 0, 0)) {
                    return;
                }

                document.querySelectorAll(".fc-daygrid-day").forEach(day => day.classList.remove("fc-daygrid-day-selected"));
                info.dayEl.classList.add("fc-daygrid-day-selected");

                let promptEl = document.getElementById("prompt-select-date");
                if (promptEl) promptEl.style.display = "none";

                selectedDate = info.dateStr;
                document.getElementById("selected-date").value = selectedDate;
                checkAvailability(selectedDate);
            }
        });

        calendar.render();

        function checkAvailability(selectedDate) {
            $.ajax({
                url: "{{ url('check_availability') }}",
                type: "POST",
                data: {
                    date: selectedDate,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    let promptEl = document.getElementById("prompt-select-date");
                    if (promptEl) promptEl.style.display = "none";

                    if (!response || response.length === 0) {
                        $("#step-2").hide();
                        $(".doctor-unavailable").show();
                        $("#time-slot-container").html("");
                    } else {
                        $("#step-2").show();
                        $(".doctor-unavailable").hide();
                        populateTimeSlots(response);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Availability error:", error);
                }
            });
        }

        function formatTimeTo12Hour(time) {
            let [hours, minutes] = time.split(":").map(Number);
            let period = hours >= 12 ? "PM" : "AM";
            hours = hours % 12 || 12;
            return `${hours}:${minutes.toString().padStart(2, "0")} ${period}`;
        }

        function populateTimeSlots(data) {
            let timeSlotContainer = document.getElementById("time-slot-container");
            timeSlotContainer.innerHTML = "";

            data.forEach((slot, index) => {
                let span = document.createElement("span");
                span.classList.add("time-slot-badge");

                let formattedFromTime = formatTimeTo12Hour(slot.from_time);
                let formattedToTime = formatTimeTo12Hour(slot.to_time);

                span.innerHTML = `<i class="fa-regular fa-clock me-1" style="margin-right: 6px;"></i> ${formattedFromTime} - ${formattedToTime}`;
                span.dataset.id = slot.id;
                
                span.addEventListener("click", function() {
                    document.querySelectorAll(".time-slot-badge").forEach(badge => badge.classList.remove("selected"));
                    this.classList.add("selected");
                    selectedTimeSlot = this.dataset.id;
                    document.getElementById("selected-time-slot").value = selectedTimeSlot;
                    document.getElementById("SubmitForBooking").classList.remove("d-none");
                });

                timeSlotContainer.appendChild(span);
            });
        }
    });

    $(document).ready(function () {
        $("#booking-form").on("submit", function (event) {
            event.preventDefault();

            let bookingDate = $("#selected-date").val();
            let timeSlotId = $("#selected-time-slot").val();

            if (!bookingDate || !timeSlotId) {
                alert("Please select both an appointment date and time slot.");
                return;
            }

            let bookingBaseUrl = "{{ (isset($currentClinic) && ($currentClinic->subdomain || $currentClinic->slug)) ? url('/c/' . ($currentClinic->subdomain ?? $currentClinic->slug) . '/book_appointment') : url('book_appointment') }}";
            let encodedDate = btoa(bookingDate);
            let encodedTimeSlot = btoa(timeSlotId);
            let actionUrl = `${bookingBaseUrl}?booking_date=${encodedDate}&time_slot_id=${encodedTimeSlot}`;
            window.location.href = actionUrl;
        });
    });
</script>
@endsection
