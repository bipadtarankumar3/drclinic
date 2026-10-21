@extends('web.layouts.main')

@section('style')
<link rel="stylesheet" href="{{ URL::to('public/assets/web/css/appointment/appoint-style.css')}}">
<link rel="stylesheet" href="{{ URL::to('public/assets/web/css/appointment/appoint-responsive.css')}}">
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<style>
  :root {
    --vital-primary: #0d9488;
    --vital-primary-dark: #0f766e;
    --vital-primary-light: #ccfbf1;
    --vital-secondary: #14b8a6;
  }

  /* ========================================================
     1. VITALCARE HERO SECTION
     ======================================================== */
  .vital-hero-section {
    background: linear-gradient(180deg, #f0fdfa 0%, #ffffff 100%);
    padding: 40px 0 60px 0;
    position: relative;
    overflow: hidden;
  }
  .vital-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #ccfbf1;
    color: #0f766e;
    font-size: 13.5px;
    font-weight: 700;
    padding: 7px 18px;
    border-radius: 30px;
    border: 1px solid #99f6e4;
  }
  .vital-pulse-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #0d9488;
    box-shadow: 0 0 0 0 rgba(13, 148, 136, 0.7);
    animation: vitalPulse 1.8s infinite;
  }
  @keyframes vitalPulse {
    0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(13, 148, 136, 0.7); }
    70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(13, 148, 136, 0); }
    100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(13, 148, 136, 0); }
  }
  .vital-hero-title {
    font-size: 54px;
    font-weight: 800;
    color: #0f172a;
    line-height: 1.15;
    letter-spacing: -1.2px;
  }
  .vital-highlight {
    color: #0d9488;
  }
  .vital-hero-subtitle {
    font-size: 16.5px;
    color: #64748b;
    line-height: 1.6;
    max-width: 520px;
  }
  .vital-hero-cta {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 14px;
  }
  .btn-vital-primary {
    background: #0d9488;
    color: #ffffff !important;
    font-weight: 700;
    font-size: 15px;
    padding: 14px 28px;
    border-radius: 30px;
    text-decoration: none;
    box-shadow: 0 6px 20px rgba(13, 148, 136, 0.35);
    display: inline-flex;
    align-items: center;
    transition: all 0.2s ease;
  }
  .btn-vital-primary:hover {
    background: #0f766e;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(13, 148, 136, 0.45);
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
    border-color: #0d9488;
    color: #0d9488 !important;
    background: #f0fdfa;
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
    background: #0d9488;
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
    display: inline-block;
    max-width: 100%;
  }
  .vital-hero-backdrop {
    width: 420px;
    height: 420px;
    border-radius: 50%;
    background: linear-gradient(135deg, #0d9488 0%, #14b8a6 100%);
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1;
    opacity: 0.92;
  }
  .vital-doctor-img {
    position: relative;
    z-index: 2;
    max-width: 380px;
    width: 100%;
    border-radius: 28px;
    box-shadow: 0 20px 40px rgba(13, 148, 136, 0.2);
    object-fit: cover;
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
    background: #0d9488;
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
    box-shadow: 0 14px 30px rgba(13, 148, 136, 0.12);
    border-color: #99f6e4;
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
    color: #0d9488;
    font-weight: 700;
    font-size: 14px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: gap 0.2s;
  }
  .service-link:hover {
    color: #0f766e;
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
    border: 1.5px solid #0d9488;
    color: #0d9488 !important;
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
    background: #0d9488;
    color: #ffffff !important;
  }
  .btn-teal-solid {
    background: #0d9488;
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
    background: #0f766e;
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
    color: #0d9488 !important;
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
    background-color: #0d9488 !important;
    border-color: #0d9488 !important;
    border-radius: 8px !important;
    font-weight: 600 !important;
    font-size: 13px !important;
    padding: 6px 14px !important;
  }
  .fc .fc-button-primary:hover {
    background-color: #0f766e !important;
    border-color: #0f766e !important;
  }
  .fc .fc-daygrid-day-number {
    font-weight: 600;
    color: #334155;
    padding: 8px !important;
  }
  .fc .fc-day-today {
    background-color: #f0fdfa !important;
  }
  .fc .fc-day-today .fc-daygrid-day-number {
    color: #0d9488 !important;
    font-weight: 800 !important;
  }
  .fc .fc-daygrid-day.fc-daygrid-day-selected,
  .fc-daygrid-day-selected,
  .fc .fc-day-today.fc-daygrid-day-selected {
    background-color: #0d9488 !important;
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
    border-color: #0d9488;
    color: #0d9488;
    background: #f0fdfa;
  }
  .time-slot-badge.selected {
    background-color: #0d9488 !important;
    color: #ffffff !important;
    border-color: #0d9488 !important;
    box-shadow: 0 4px 12px rgba(13, 148, 136, 0.35);
  }
  #SubmitForBooking {
    background: #0d9488;
    border: none;
    color: #ffffff;
    font-weight: 700;
    font-size: 15px;
    padding: 12px 28px;
    border-radius: 30px;
    box-shadow: 0 4px 16px rgba(13, 148, 136, 0.35);
    transition: all 0.2s;
  }
  #SubmitForBooking:hover {
    background: #0f766e;
    transform: translateY(-2px);
  }

  @media (max-width: 991px) {
    .vital-hero-title { font-size: 38px; }
    .vital-hero-backdrop { width: 320px; height: 320px; }
    .vital-doctor-img { max-width: 300px; }
    .vital-emergency-card { right: 0; bottom: 0; padding: 12px 16px; }
    .vital-booking-card { padding: 20px; }
  }
</style>
@endsection

@section('banner')
<!-- ========================================================
     HERO SECTION (Matching Reference Design)
     ======================================================== -->
<section class="vital-hero-section">
  <div class="container" style="max-width: 1240px;">
    <div class="row align-items-center">
      <!-- Left Column: Copy & CTAs -->
      <div class="col-lg-6 col-md-12 py-3 py-lg-5">
        <div class="vital-hero-badge mb-3">
          <span class="vital-pulse-dot"></span>
          <i class="fa-regular fa-circle-check mr-1"></i> Trusted Care. Better Health.
        </div>

        <h1 class="vital-hero-title mb-3">
          Your Health<br>
          <span class="vital-highlight">Our Priority</span>
        </h1>

        <p class="vital-hero-subtitle mb-4">
          {{ $currentClinic->bio ?? 'Compassionate care, advanced technology, and experienced specialists — all for a healthier you.' }}
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
            <div class="stat-text"><strong>15+</strong><span>Expert Doctors</span></div>
          </div>
          <div class="vital-stat-chip">
            <div class="stat-icon"><i class="fa-regular fa-face-smile"></i></div>
            <div class="stat-text"><strong>10k+</strong><span>Happy Patients</span></div>
          </div>
          <div class="vital-stat-chip">
            <div class="stat-icon"><i class="fa-solid fa-stethoscope"></i></div>
            <div class="stat-text"><strong>25+</strong><span>Specialties</span></div>
          </div>
        </div>
      </div>

      <!-- Right Column: Doctor Portrait & Emergency Badge -->
      <div class="col-lg-6 col-md-12 text-center position-relative py-4">
        <div class="vital-hero-img-wrap">
          <div class="vital-hero-backdrop"></div>
          <img src="{{ asset('public/assets/web/modern/hero-doctor.jpg') }}" alt="{{ $currentClinic->name ?? 'Doctor' }}" class="vital-doctor-img">
          
          <div class="vital-emergency-card">
            <div class="emerg-icon">
              <i class="fa-solid fa-headset"></i>
            </div>
            <div class="emerg-text">
              <span class="emerg-title">24/7</span>
              <span class="emerg-sub">Emergency Support</span>
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
     SECTION 2: OUR SERVICES
     ======================================================== -->
<section id="services-section" class="vital-services-section py-5">
  <div class="container" style="max-width: 1240px;">
    <div class="text-center mb-5">
      <h2 class="vital-section-heading">Our Services</h2>
      <div class="vital-heading-bar"></div>
      <p class="text-muted mt-2" style="font-size: 15px;">Compassionate and specialized healthcare solutions tailored for you and your family.</p>
    </div>

    <div class="row g-4">
      <!-- Service 1: Cardiology -->
      <div class="col-lg-3 col-md-6">
        <div class="vital-service-card">
          <div class="service-icon-box" style="background: rgba(13, 148, 136, 0.1); color: #0d9488;">
            <i class="fa-solid fa-heart-pulse"></i>
          </div>
          <h4 class="service-title">Cardiology</h4>
          <p class="service-desc">Comprehensive heart care with advanced diagnostics, ECG monitoring, and personalized treatment.</p>
          <a href="#booking-section" class="service-link">Learn More <i class="fa-solid fa-arrow-right"></i></a>
        </div>
      </div>

      <!-- Service 2: General Medicine -->
      <div class="col-lg-3 col-md-6">
        <div class="vital-service-card">
          <div class="service-icon-box" style="background: rgba(13, 148, 136, 0.1); color: #0d9488;">
            <i class="fa-solid fa-stethoscope"></i>
          </div>
          <h4 class="service-title">General Medicine</h4>
          <p class="service-desc">Expert care for everyday health concerns, fevers, seasonal illness, and ongoing chronic conditions.</p>
          <a href="#booking-section" class="service-link">Learn More <i class="fa-solid fa-arrow-right"></i></a>
        </div>
      </div>

      <!-- Service 3: Dental Care -->
      <div class="col-lg-3 col-md-6">
        <div class="vital-service-card">
          <div class="service-icon-box" style="background: rgba(13, 148, 136, 0.1); color: #0d9488;">
            <i class="fa-solid fa-tooth"></i>
          </div>
          <h4 class="service-title">Dental Care</h4>
          <p class="service-desc">Complete dental solutions for a healthy, vibrant, and confident smile for patients of all ages.</p>
          <a href="#booking-section" class="service-link">Learn More <i class="fa-solid fa-arrow-right"></i></a>
        </div>
      </div>

      <!-- Service 4: Women's Health -->
      <div class="col-lg-3 col-md-6">
        <div class="vital-service-card">
          <div class="service-icon-box" style="background: rgba(13, 148, 136, 0.1); color: #0d9488;">
            <i class="fa-solid fa-venus"></i>
          </div>
          <h4 class="service-title">Women's Health</h4>
          <p class="service-desc">Compassionate care for women at every stage of life, routine wellness, and maternal consultation.</p>
          <a href="#booking-section" class="service-link">Learn More <i class="fa-solid fa-arrow-right"></i></a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ========================================================
     SECTION 3: 4-COLUMN PROMO & ACTION GRID
     ======================================================== -->
<section id="packages-section" class="vital-features-grid py-4 mb-5">
  <div class="container" style="max-width: 1240px;">
    <div class="row g-4">
      <!-- Card 1: Health Checkup Packages -->
      <div class="col-lg-3 col-md-6">
        <div class="vital-feature-card h-100 d-flex flex-column justify-content-between">
          <div>
            <h5 class="feature-card-title mb-1">Health Checkup Packages</h5>
            <div class="package-price mb-3">
              <span class="text-muted" style="font-size: 13px;">Starting From</span>
              <div class="price-value" style="color: #f59e0b; font-size: 26px; font-weight: 800;">
                ₹{{ number_format($currentClinic->consultation_fee ?? 499, 0) }}
              </div>
            </div>
            <div class="feature-img-box mb-3">
              <img src="{{ asset('public/assets/web/modern/family-checkup.jpg') }}" alt="Family Health Checkup" class="w-100 rounded-3" style="height: 140px; object-fit: cover;">
            </div>
          </div>
          <a href="#booking-section" class="btn-outline-teal">View Packages</a>
        </div>
      </div>

      <!-- Card 2: Why Choose Us? -->
      <div class="col-lg-3 col-md-6">
        <div class="vital-feature-card h-100 d-flex flex-column justify-content-between">
          <div>
            <h5 class="feature-card-title mb-3">Why Choose Us?</h5>
            <ul class="why-choose-list list-unstyled mb-4">
              <li><i class="fa-solid fa-circle-check text-teal mr-2" style="margin-right: 8px;"></i> Experienced Doctors</li>
              <li><i class="fa-solid fa-circle-check text-teal mr-2" style="margin-right: 8px;"></i> Modern Facilities</li>
              <li><i class="fa-solid fa-circle-check text-teal mr-2" style="margin-right: 8px;"></i> Patient First Approach</li>
              <li><i class="fa-solid fa-circle-check text-teal mr-2" style="margin-right: 8px;"></i> Affordable Pricing</li>
            </ul>
          </div>
          <a href="#about-section" class="btn-outline-teal">Learn More</a>
        </div>
      </div>

      <!-- Card 3: Take Care of Yourself Today -->
      <div class="col-lg-3 col-md-6">
        <div class="vital-feature-card h-100 d-flex flex-column justify-content-between">
          <div>
            <h5 class="feature-card-title mb-1">Take Care of Yourself Today</h5>
            <p class="text-muted mb-3" style="font-size: 13px; line-height: 1.5;">Early diagnosis, better treatment, healthier life.</p>
            <div class="feature-img-box mb-3">
              <img src="{{ asset('public/assets/web/modern/patient-care.jpg') }}" alt="Take Care of Yourself" class="w-100 rounded-3" style="height: 140px; object-fit: cover;">
            </div>
          </div>
          <a href="#booking-section" class="btn-teal-solid">Book Now</a>
        </div>
      </div>

      <!-- Card 4: We're Here for You -->
      <div class="col-lg-3 col-md-6">
        <div class="vital-feature-card h-100 d-flex flex-column justify-content-between">
          <div>
            <h5 class="feature-card-title mb-1">We're Here for You</h5>
            <div class="emerg-highlight mb-1" style="color: #f59e0b; font-size: 24px; font-weight: 800;">24/7</div>
            <p class="text-muted mb-2" style="font-size: 13px;">Emergency Care You Can Trust.</p>
            <div class="feature-img-box mb-3">
              <img src="{{ asset('public/assets/web/modern/ambulance.jpg') }}" alt="Emergency Ambulance" class="w-100 rounded-3" style="height: 140px; object-fit: cover;">
            </div>
          </div>
          <a href="tel:{{ $currentClinic->phone ?? '+919830012345' }}" class="btn-outline-teal">Get Help Now</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ========================================================
     SECTION 4: INTERACTIVE APPOINTMENT CALENDAR
     ======================================================== -->
<section id="booking-section" class="py-5" style="background: #f8fafc;">
  <div class="container" style="max-width: 1240px;">
    
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
                  <i class="fa-regular fa-calendar mr-2" style="color: #0d9488; margin-right: 6px;"></i> 1. Select Date
                </h5>
                <span class="text-muted" style="font-size: 13px;">Dates marked blue have open slots</span>
              </div>
              <div id="calendar"></div>
              <input type="hidden" id="selected-date" name="booking_date">
            </div>

            <!-- Time Slots Column -->
            <div class="col-lg-5 col-md-12">
              <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="mb-0 font-weight-bold" style="color: #0f172a; font-size: 18px;">
                  <i class="fa-regular fa-clock mr-2" style="color: #0d9488; margin-right: 6px;"></i> 2. Available Slots
                </h5>
              </div>

              <!-- Time Slot Picker Wrapper -->
              <div id="step-2" style="display: none; background: #f8fafc; border-radius: 16px; padding: 20px; border: 1px solid #e2e8f0;">
                <p class="text-muted mb-3" style="font-size: 13.5px;">Click on your preferred appointment time:</p>
                <div id="time-slot-container" class="d-flex flex-wrap mb-3"></div>

                <input type="hidden" id="selected-time-slot" name="time_slot_id">

                <div class="p-3 rounded-3 mb-3" style="background: #e6fffa; border: 1px solid #b2f5ea; font-size: 13px; color: #234e52;">
                  <i class="fa fa-info-circle mr-1" style="color: #0d9488;"></i> 
                  <span>Consultation Fee: <strong>₹{{ number_format($currentClinic->consultation_fee ?? 499, 2) }}</strong></span>
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

            let encodedDate = btoa(bookingDate);
            let encodedTimeSlot = btoa(timeSlotId);

            let actionUrl = `{{ url('book_appointment') }}?booking_date=${encodedDate}&time_slot_id=${encodedTimeSlot}`;
            window.location.href = actionUrl;
        });
    });
</script>
@endsection
