@extends('web.layouts.main')

@section('style')
<style>
  :root {
    --contact-primary: {{ $currentClinic->theme_color ?? '#0d9488' }};
    --contact-secondary: {{ $currentClinic->secondary_color ?? '#14b8a6' }};
  }

  .vital-contact-hero {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    padding: 60px 0 50px;
    color: #ffffff;
    position: relative;
    overflow: hidden;
  }
  .vital-contact-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(var(--clinic-primary-rgb, 13, 148, 136), 0.18) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
  }
  .vital-breadcrumb {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 13.5px;
    color: #94a3b8;
    margin-bottom: 14px;
  }
  .vital-breadcrumb a {
    color: #38bdf8;
    text-decoration: none;
    transition: color 0.2s;
  }
  .vital-breadcrumb a:hover {
    color: #7dd3fc;
  }

  /* Contact Cards Grid */
  .contact-info-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 18px;
    padding: 26px 24px;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.04), 0 2px 4px -2px rgba(0, 0, 0, 0.04);
  }
  .contact-info-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 30px -6px rgba(0, 0, 0, 0.08);
    border-color: rgba(var(--clinic-primary-rgb, 13, 148, 136), 0.4);
  }
  .contact-icon-box {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    background: rgba(var(--clinic-primary-rgb, 13, 148, 136), 0.1);
    color: var(--clinic-primary, #0d9488);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    margin-bottom: 16px;
    flex-shrink: 0;
  }

  /* Modern Form Box */
  .contact-form-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    padding: 36px 32px;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
  }
  .contact-form-card .form-label {
    font-size: 13.5px;
    font-weight: 700;
    color: #334155;
    margin-bottom: 6px;
  }
  .contact-form-card .form-control,
  .contact-form-card .form-select {
    border: 1.5px solid #cbd5e1;
    border-radius: 10px;
    padding: 12px 14px;
    font-size: 14.5px;
    color: #0f172a;
    transition: all 0.2s;
  }
  .contact-form-card .form-control:focus,
  .contact-form-card .form-select:focus {
    border-color: var(--clinic-primary, #0d9488);
    box-shadow: 0 0 0 4px rgba(var(--clinic-primary-rgb, 13, 148, 136), 0.15);
    outline: none;
  }
  .btn-contact-submit {
    background: var(--clinic-primary, #0d9488);
    color: #ffffff;
    border: none;
    border-radius: 12px;
    padding: 14px 28px;
    font-weight: 700;
    font-size: 15px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    transition: all 0.25s ease;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(var(--clinic-primary-rgb, 13, 148, 136), 0.35);
  }
  .btn-contact-submit:hover {
    background: var(--clinic-secondary, #0f766e);
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(var(--clinic-primary-rgb, 13, 148, 136), 0.45);
  }

  /* Right Sidebar Doctor Info Card */
  .clinic-sidebar-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    padding: 28px;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
  }

  .map-wrapper {
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid #e2e8f0;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
    background: #e2e8f0;
  }
</style>
@endsection

@section('content')
@php
  $clinic = $currentClinic ?? \App\Models\Clinic::first();
  $clinicUrl = $clinic ? url('/c/' . ($clinic->subdomain ?? $clinic->slug)) : url('/');
  $submitUrl = $clinic ? url('/c/' . ($clinic->subdomain ?? $clinic->slug) . '/contact') : url('/contact');
  $bookingUrl = $clinicUrl . '#booking-section';
@endphp

<!-- Hero Banner -->
<section class="vital-contact-hero">
  <div class="container-fluid" style="max-width: 1320px; padding-left: clamp(16px, 3.5vw, 48px); padding-right: clamp(16px, 3.5vw, 48px);">
    <div class="vital-breadcrumb">
      <a href="{{ $clinicUrl }}"><i class="fa-solid fa-house"></i> Home</a>
      <span>/</span>
      <span>Contact Us</span>
    </div>
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
      <div>
        <span class="badge px-3 py-2 rounded-pill mb-2" style="background: rgba(var(--clinic-primary-rgb, 13, 148, 136), 0.25); color: #5eead4; font-size: 13px; font-weight: 600;">
          <i class="fa-solid fa-circle-dot mr-1" style="font-size: 9px; vertical-align: middle;"></i> Direct Clinic Communication
        </span>
        <h1 class="font-weight-bold text-white mb-2" style="font-size: clamp(28px, 4vw, 40px); letter-spacing: -0.5px;">
          Contact {{ $clinic->name ?? 'Our Clinic' }}
        </h1>
        <p class="text-slate-300 mb-0" style="color: #cbd5e1; max-width: 650px; font-size: 15.5px; line-height: 1.6;">
          Have questions regarding consultations, specialized therapies, or appointments? Connect directly with our medical reception and care team.
        </p>
      </div>
      <div>
        <a href="{{ $bookingUrl }}" class="btn text-white px-4 py-3 font-weight-bold d-inline-flex align-items-center" style="background: var(--clinic-primary); border-radius: 14px; gap: 8px; box-shadow: 0 4px 14px rgba(var(--clinic-primary-rgb, 13, 148, 136), 0.4); text-decoration: none;">
          <i class="fa-regular fa-calendar-check"></i> Book An Appointment
        </a>
      </div>
    </div>
  </div>
</section>

<!-- Main Container -->
<section class="py-5" style="background: #f8fafc;">
  <div class="container-fluid" style="max-width: 1320px; padding-left: clamp(16px, 3.5vw, 48px); padding-right: clamp(16px, 3.5vw, 48px);">

    <!-- Flash Notifications -->
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show rounded-3 p-4 mb-4 shadow-sm" role="alert" style="background: #ecfdf5; border-color: #a7f3d0; color: #065f46;">
        <div class="d-flex align-items-center">
          <i class="fa-solid fa-circle-check fs-4 me-3" style="color: #059669;"></i>
          <div>
            <h6 class="font-weight-bold mb-1">Inquiry Sent Successfully!</h6>
            <p class="mb-0" style="font-size: 14px;">{{ session('success') }}</p>
          </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show rounded-3 p-4 mb-4 shadow-sm" role="alert">
        <div class="d-flex align-items-center">
          <i class="fa-solid fa-circle-exclamation fs-4 me-3"></i>
          <div>
            <h6 class="font-weight-bold mb-1">Submission Notice</h6>
            <p class="mb-0" style="font-size: 14px;">{{ session('error') }}</p>
          </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger rounded-3 p-3 mb-4 shadow-sm">
        <ul class="mb-0 ps-3">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <!-- 4 Information Cards (Managed from Clinic Profile / Settings) -->
    <div class="row g-4 mb-5">
      <!-- 1. Address Card -->
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="contact-info-card">
          <div>
            <div class="contact-icon-box">
              <i class="fa-solid fa-location-dot"></i>
            </div>
            <h6 class="font-weight-bold mb-2" style="color: #0f172a; font-size: 16.5px;">Clinic Address</h6>
            <p class="text-muted mb-3" style="font-size: 14px; line-height: 1.55;">
              @if(!empty($clinic->address))
                {{ $clinic->address }}
              @else
                Main Medical Center, Health Street
              @endif
            </p>
          </div>
          <div>
            @if(!empty($clinic->address))
              <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($clinic->address . ' ' . $clinic->name) }}" target="_blank" class="font-weight-bold d-inline-flex align-items-center" style="color: var(--clinic-primary); font-size: 13.5px; text-decoration: none;">
                Get Directions <i class="fa-solid fa-arrow-up-right-from-square ms-1" style="font-size: 11px;"></i>
              </a>
            @else
              <span class="text-muted small">Managed via Clinic Settings</span>
            @endif
          </div>
        </div>
      </div>

      <!-- 2. Phone Helpline Card -->
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="contact-info-card">
          <div>
            <div class="contact-icon-box">
              <i class="fa-solid fa-phone-volume"></i>
            </div>
            <h6 class="font-weight-bold mb-2" style="color: #0f172a; font-size: 16.5px;">Helpline &amp; Appointments</h6>
            <p class="text-muted mb-1" style="font-size: 14px;">Direct call to reception:</p>
            <div class="font-weight-bold mb-3" style="color: #0f172a; font-size: 17px;">
              {{ $clinic->phone ?? '+91 9876543210' }}
            </div>
          </div>
          <div>
            @if(!empty($clinic->phone))
              <a href="tel:{{ $clinic->phone }}" class="font-weight-bold d-inline-flex align-items-center" style="color: var(--clinic-primary); font-size: 13.5px; text-decoration: none;">
                Call Clinic Now <i class="fa-solid fa-phone ms-1" style="font-size: 11px;"></i>
              </a>
            @else
              <span class="text-muted small">Managed via Clinic Settings</span>
            @endif
          </div>
        </div>
      </div>

      <!-- 3. Clinic Email Card (Clinic-Wise Email) -->
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="contact-info-card">
          <div>
            <div class="contact-icon-box">
              <i class="fa-solid fa-envelope-open-text"></i>
            </div>
            <h6 class="font-weight-bold mb-2" style="color: #0f172a; font-size: 16.5px;">Official Clinic Email</h6>
            <p class="text-muted mb-1" style="font-size: 14px;">Clinic-wise recipient email:</p>
            <div class="font-weight-bold mb-3 text-truncate" style="color: #0f172a; font-size: 15px;" title="{{ $clinic->email ?? 'doctor@clinic.com' }}">
              {{ $clinic->email ?? 'doctor@clinic.com' }}
            </div>
          </div>
          <div>
            @if(!empty($clinic->email))
              <a href="mailto:{{ $clinic->email }}" class="font-weight-bold d-inline-flex align-items-center" style="color: var(--clinic-primary); font-size: 13.5px; text-decoration: none;">
                Send Direct Email <i class="fa-solid fa-envelope ms-1" style="font-size: 11px;"></i>
              </a>
            @else
              <span class="text-muted small">Managed via Clinic Settings</span>
            @endif
          </div>
        </div>
      </div>

      <!-- 4. Hours & Working Days -->
      <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="contact-info-card">
          <div>
            <div class="contact-icon-box">
              <i class="fa-solid fa-clock"></i>
            </div>
            <h6 class="font-weight-bold mb-2" style="color: #0f172a; font-size: 16.5px;">Consultation Hours</h6>
            <p class="text-muted mb-1" style="font-size: 14px;">Operating schedule:</p>
            <div class="font-weight-bold mb-3" style="color: #0f172a; font-size: 15px;">
              {{ $clinic->topbar_hours ?? 'Open 7 Days a Week' }}
            </div>
          </div>
          <div>
            <span class="badge py-1 px-2 rounded-2" style="background: rgba(var(--clinic-primary-rgb, 13, 148, 136), 0.1); color: var(--clinic-primary); font-size: 12px; font-weight: 600;">
              <i class="fa-solid fa-circle-check me-1"></i> {{ $clinic->topbar_tagline ?? 'Your Health, Our Priority' }}
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Contact Form & Clinic Sidebar -->
    <div class="row g-4 align-items-start mb-5">
      <!-- Left Column: Form -->
      <div class="col-lg-7 col-md-12">
        <div class="contact-form-card">
          <div class="d-flex align-items-center gap-2 mb-2">
            <span class="badge px-3 py-1 rounded-pill" style="background: rgba(var(--clinic-primary-rgb, 13, 148, 136), 0.1); color: var(--clinic-primary); font-size: 12.5px; font-weight: 700;">
              Online Patient Message
            </span>
          </div>
          <h3 class="font-weight-bold mb-2" style="color: #0f172a; font-size: 24px;">Send a Message to {{ $clinic->name ?? 'Our Clinic' }}</h3>
          <p class="text-muted mb-4" style="font-size: 14.5px;">
            Inquiries submitted below are delivered directly to <strong>{{ $clinic->name }}</strong>'s designated email (<span class="text-dark font-weight-bold">{{ $clinic->email ?? 'Clinic Inbox' }}</span>), and a confirmation receipt will be emailed to your address.
          </p>

          <form action="{{ $submitUrl }}" method="POST">
            @csrf
            <input type="hidden" name="clinic_id" value="{{ $clinic->id ?? '' }}">

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text bg-white text-muted border-end-0"><i class="fa-regular fa-user"></i></span>
                  <input type="text" name="name" class="form-control border-start-0 ps-0" placeholder="e.g. John Doe" value="{{ old('name') }}" required>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Email Address <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text bg-white text-muted border-end-0"><i class="fa-regular fa-envelope"></i></span>
                  <input type="email" name="email" class="form-control border-start-0 ps-0" placeholder="e.g. patient@gmail.com" value="{{ old('email') }}" required>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Phone Number</label>
                <div class="input-group">
                  <span class="input-group-text bg-white text-muted border-end-0"><i class="fa-solid fa-phone"></i></span>
                  <input type="tel" name="phone" class="form-control border-start-0 ps-0" placeholder="e.g. +91 9876543210" value="{{ old('phone') }}">
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label">Subject / Purpose</label>
                <select name="subject" class="form-select">
                  <option value="General Consultation Inquiry" {{ old('subject') == 'General Consultation Inquiry' ? 'selected' : '' }}>General Consultation Inquiry</option>
                  <option value="Appointment Follow-up" {{ old('subject') == 'Appointment Follow-up' ? 'selected' : '' }}>Appointment Follow-up</option>
                  <option value="Treatment & Diagnostic Services" {{ old('subject') == 'Treatment & Diagnostic Services' ? 'selected' : '' }}>Treatment & Diagnostic Services</option>
                  <option value="Reports & Prescription Query" {{ old('subject') == 'Reports & Prescription Query' ? 'selected' : '' }}>Reports & Prescription Query</option>
                  <option value="Other Feedback" {{ old('subject') == 'Other Feedback' ? 'selected' : '' }}>Other Feedback</option>
                </select>
              </div>

              <div class="col-12">
                <label class="form-label">Your Message <span class="text-danger">*</span></label>
                <textarea name="message" rows="5" class="form-control" placeholder="Please describe your health query or question in detail..." required>{{ old('message') }}</textarea>
              </div>

              <div class="col-12 pt-2">
                <button type="submit" class="btn-contact-submit">
                  <span>Send Message Directly to Clinic</span>
                  <i class="fa-solid fa-paper-plane"></i>
                </button>
                <div class="d-flex align-items-center justify-content-center gap-2 mt-3 text-muted" style="font-size: 13px;">
                  <i class="fa-solid fa-lock text-success"></i>
                  <span>Patient confidentiality and data security are strictly preserved.</span>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Right Column: Clinic Identity & Quick Booking -->
      <div class="col-lg-5 col-md-12">
        <div class="clinic-sidebar-card mb-4">
          <div class="d-flex align-items-center gap-3 pb-3 mb-3 border-bottom">
            @if($clinic && $clinic->logo)
              <img src="{{ $clinic->logo_url ?? URL::to('public/' . $clinic->logo) }}" alt="{{ $clinic->name }}" style="width: 60px; height: 60px; object-fit: contain; border-radius: 12px; border: 1px solid #e2e8f0; padding: 4px; background: #fff;">
            @else
              <div style="width: 60px; height: 60px; border-radius: 12px; background: rgba(var(--clinic-primary-rgb, 13, 148, 136), 0.1); color: var(--clinic-primary); display: flex; align-items: center; justify-content: center; font-size: 26px;">
                <i class="fa-solid fa-hospital"></i>
              </div>
            @endif
            <div>
              <h5 class="font-weight-bold mb-1" style="color: #0f172a; font-size: 18px;">{{ $clinic->name ?? 'Healthcare Clinic' }}</h5>
              <div style="color: var(--clinic-primary); font-size: 13.5px; font-weight: 600;">
                <i class="fa-solid fa-stethoscope me-1"></i> {{ $clinic->specialization ?? 'Specialized Medical Consultations' }}
              </div>
            </div>
          </div>

          @if(!empty($clinic->bio))
            <p class="text-muted mb-4" style="font-size: 14px; line-height: 1.6;">
              {{ Str::limit($clinic->bio, 260) }}
            </p>
          @endif

          <!-- Quick Consultation Card -->
          <div class="p-3 rounded-3 mb-4" style="background: linear-gradient(135deg, rgba(var(--clinic-primary-rgb, 13, 148, 136), 0.08) 0%, rgba(var(--clinic-primary-rgb, 13, 148, 136), 0.02) 100%); border: 1.5px solid rgba(var(--clinic-primary-rgb, 13, 148, 136), 0.2);">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <span class="font-weight-bold text-dark" style="font-size: 14px;">Consultation Fee</span>
              <span class="font-weight-bold" style="color: var(--clinic-primary); font-size: 20px;">
                ₹{{ number_format($clinic->consultation_fee ?? 500, 0) }}
              </span>
            </div>
            <p class="text-muted mb-3" style="font-size: 13px;">Skip the phone queue and reserve your consultation slot online with real-time confirmation.</p>
            <a href="{{ $bookingUrl }}" class="btn w-100 font-weight-bold text-white py-2" style="background: var(--clinic-primary); border-radius: 10px; font-size: 14px; text-decoration: none;">
              <i class="fa-regular fa-calendar-check me-1"></i> Book Appointment Online
            </a>
          </div>

          <!-- Emergency Alert Notice -->
          <div class="p-3 rounded-3 d-flex align-items-start gap-3" style="background: #fff1f2; border: 1px solid #fecdd3; color: #991b1b; font-size: 13px;">
            <i class="fa-solid fa-triangle-exclamation mt-1" style="font-size: 18px; color: #dc2626; flex-shrink: 0;"></i>
            <div>
              <strong>Emergency Notice:</strong>
              <div class="mt-1" style="color: #7f1d1d;">For acute critical emergencies, trauma, or severe symptoms, please visit the emergency wing or dial emergency helpline immediately.</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Dynamic Google Map Section (Centered around clinic address) -->
    <div class="mt-4">
      <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
          <h4 class="font-weight-bold mb-1" style="color: #0f172a; font-size: 20px;">
            <i class="fa-solid fa-map-location-dot me-2" style="color: var(--clinic-primary);"></i> Find Us on the Map
          </h4>
          <p class="text-muted mb-0" style="font-size: 13.5px;">Location of {{ $clinic->name }}</p>
        </div>
        @if(!empty($clinic->address))
          <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($clinic->address . ' ' . $clinic->name) }}" target="_blank" class="btn btn-outline-secondary btn-sm px-3 rounded-pill" style="font-size: 13px;">
            <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Open Google Maps
          </a>
        @endif
      </div>

      <div class="map-wrapper">
        @php
          $mapQuery = !empty($clinic->address) ? $clinic->address : ($clinic->name . ' Kolkata');
        @endphp
        <iframe
          src="https://maps.google.com/maps?q={{ urlencode($mapQuery) }}&t=&z=15&ie=UTF8&iwloc=&output=embed"
          width="100%"
          height="420"
          style="border: 0; display: block;"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>
    </div>

  </div>
</section>
@endsection