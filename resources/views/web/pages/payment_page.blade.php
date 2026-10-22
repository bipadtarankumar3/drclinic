@extends('web.layouts.main')

@section('style')
<link rel="stylesheet" href="{{ URL::to('public/assets/web/css/appointment/appoint-style.css')}}">
<link rel="stylesheet" href="{{ URL::to('public/assets/web/css/appointment/appoint-responsive.css')}}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<style>
  :root {
    --vital-primary: {{ (isset($currentClinic) && $currentClinic->theme_color) ? $currentClinic->theme_color : '#0d9488' }};
    --vital-primary-dark: {{ (isset($currentClinic) && $currentClinic->theme_color) ? $currentClinic->theme_color : '#0f766e' }};
    --vital-primary-light: #ccfbf1;
  }

  .vital-page-header {
    background: linear-gradient(180deg, #f0fdfa 0%, #ffffff 100%);
    border-bottom: 1px solid #e2e8f0;
    padding: 30px 0;
  }
  .vital-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #ccfbf1;
    color: #0f766e;
    font-size: 13px;
    font-weight: 700;
    padding: 5px 14px;
    border-radius: 20px;
    border: 1px solid #99f6e4;
  }
  .vital-pulse-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #0d9488;
  }

  .vital-form-card {
    background: #ffffff;
    border-radius: 20px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
    padding: 32px;
  }
  .vital-form-card .form-label {
    font-size: 13.5px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 6px;
  }
  .vital-form-card .form-control {
    border: 1.5px solid #cbd5e1;
    border-radius: 10px;
    padding: 10px 14px;
    font-size: 14.5px;
    transition: all 0.2s;
  }
  .vital-form-card .form-control:focus {
    border-color: #0d9488;
    box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.15);
  }

  .vital-billing-card {
    background: #ffffff;
    border-radius: 20px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
    padding: 28px;
    position: sticky;
    top: 90px;
  }

  .term_and_condition_box {
    max-height: 280px;
    overflow-y: auto;
    padding: 16px;
    border: 1px solid #dee2e6;
    border-radius: 10px;
    background-color: #f8fafc;
    color: #334155;
    font-size: 13.5px;
    line-height: 1.8;
  }

  .terms-notice-banner {
    background-color: #f0fdfa;
    border: 1px solid #99f6e4;
    border-left: 5px solid #0d9488;
    padding: 12px 16px;
    border-radius: 8px;
    color: #0f766e;
    font-size: 13.5px;
    margin-bottom: 15px;
  }

  .terms-modal-header {
    background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);
    color: #ffffff;
    padding: 16px 20px;
    border-top-left-radius: calc(0.5rem - 1px);
    border-top-right-radius: calc(0.5rem - 1px);
  }

  .terms-acceptance-box {
    background-color: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 14px 16px;
    margin-top: 15px;
  }

  #pay-button {
    background: #0d9488;
    border: none;
    color: #ffffff;
    font-weight: 700;
    font-size: 15px;
    padding: 14px 20px;
    border-radius: 30px;
    box-shadow: 0 4px 16px rgba(13, 148, 136, 0.35);
    transition: all 0.2s ease;
  }
  #pay-button:hover:not(:disabled) {
    background: #0f766e;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(13, 148, 136, 0.45);
    color: #ffffff;
  }
  #pay-button:disabled {
    background: #94a3b8;
    opacity: 0.6;
    cursor: not-allowed;
    box-shadow: none;
  }
  /* Patient Type Switcher & Account Lookup */
  .patient-type-card {
    display: block;
    border: 2px solid #e2e8f0;
    border-radius: 14px;
    padding: 12px 16px;
    cursor: pointer;
    background: #ffffff;
    transition: all 0.2s ease;
    height: 100%;
    margin-bottom: 0;
  }
  .patient-type-card:hover {
    border-color: #cbd5e1;
    background: #f8fafc;
  }
  .patient-type-card.active {
    border-color: var(--vital-primary, #0d9488);
    background: #f0fdfa;
    box-shadow: 0 4px 14px rgba(13, 148, 136, 0.12);
  }
  .patient-type-card.active .type-title {
    color: var(--vital-primary-dark, #0f766e);
  }
  .patient-type-card.active .type-icon {
    background: var(--vital-primary, #0d9488);
    color: #ffffff;
  }
  .type-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: #f1f5f9;
    color: #64748b;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    transition: all 0.2s ease;
    flex-shrink: 0;
  }
  .patient-selection-item {
    border: 1.5px solid #e2e8f0;
    border-radius: 12px;
    padding: 12px 14px;
    background: #ffffff;
    cursor: pointer;
    transition: all 0.2s ease;
    margin-bottom: 8px;
  }
  .patient-selection-item:hover {
    border-color: var(--vital-primary, #0d9488);
    background: #f0fdfa;
  }
  .patient-selection-item.selected {
    border-color: var(--vital-primary, #0d9488);
    background: #f0fdfa;
    box-shadow: 0 0 0 2px rgba(13, 148, 136, 0.25);
  }
  .existing-selected-banner {
    background: #f0fdfa;
    border: 1.5px solid #99f6e4;
    border-radius: 12px;
    padding: 14px 16px;
  }
</style>
@endsection

@section('banner')
<!-- ========================================================
     MODERN PAGE HEADER (100% Full Width & Responsive)
     ======================================================== -->
<section class="vital-page-header">
  <div class="container-fluid" style="max-width: 1440px; padding-left: clamp(16px, 3.5vw, 48px); padding-right: clamp(16px, 3.5vw, 48px);">
    <div class="row align-items-center">
      <div class="col-md-7">
        <div class="vital-hero-badge mb-2">
          <span class="vital-pulse-dot"></span>
          <span>Step 2 of 2: Patient Registration</span>
        </div>
        <h1 class="font-weight-bold mb-1" style="font-size: clamp(24px, 4vw, 32px); color: #0f172a; letter-spacing: -0.5px;">
          Patient Details & Confirmation
        </h1>
        <p class="text-muted mb-0" style="font-size: 14.5px;">
          Complete patient information to confirm your consultation at <strong>{{ $currentClinic->name ?? 'our clinic' }}</strong>.
        </p>
      </div>

      <!-- Selected Slot Summary Pill -->
      <div class="col-md-5 text-md-end mt-3 mt-md-0">
        <div class="d-inline-flex flex-column text-start p-3 rounded-4" style="background: #ffffff; border: 1.5px solid #99f6e4; box-shadow: 0 4px 14px rgba(13,148,136,0.08); min-width: 260px;">
          <div class="d-flex align-items-center mb-1" style="gap: 8px;">
            <i class="fa-regular fa-calendar-check" style="color: #0d9488; font-size: 16px;"></i>
            <strong style="color: #0f172a; font-size: 14.5px;">
              {{ isset($decoded_date) ? \Carbon\Carbon::parse($decoded_date)->format('D, d M Y') : 'Selected Date' }}
            </strong>
          </div>
          <div class="d-flex align-items-center" style="gap: 8px; font-size: 13px; color: #64748b;">
            <i class="fa-regular fa-clock" style="color: #0d9488;"></i>
            <span>
              @if(isset($selected_slot))
                {{ \Carbon\Carbon::parse($selected_slot->from_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($selected_slot->to_time)->format('h:i A') }}
              @else
                Confirmed Slot
              @endif
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('content')
<div class="container-fluid py-4 my-2" style="max-width: 1440px; padding-left: clamp(16px, 3.5vw, 48px); padding-right: clamp(16px, 3.5vw, 48px);">
  <form id="payment-form" class="payment-form">
    @csrf
    <input type="hidden" name="booking_date" id="booking_date" @if (isset($booking_date)) value="{{ base64_decode($booking_date) }}" @endif>
    <input type="hidden" name="time_slot_id" id="time_slot_id" @if (isset($time_slot_id)) value="{{ base64_decode($time_slot_id) }}" @endif>
    <input type="hidden" name="patient_id" id="selected_patient_id" value="">

    <div class="row g-4">
      <!-- Left Column: Patient Details Form -->
      <div class="col-lg-8 col-md-12">
        <div class="vital-form-card">
          <div class="d-flex align-items-center mb-3" style="gap: 10px;">
            <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(13, 148, 136, 0.1); color: #0d9488; display: flex; align-items: center; justify-content: center; font-size: 17px;">
              <i class="fa-solid fa-user-pen"></i>
            </div>
            <div>
              <h4 class="font-weight-bold mb-0" style="color: #0f172a; font-size: 20px;">Patient Information</h4>
              <small class="text-muted">Enter details accurately as per Government ID / Medical Records</small>
            </div>
          </div>
          <hr class="mb-3" style="opacity: 0.1;">

          <!-- Patient Type Toggle: New Patient vs Already a Patient -->
          <div class="patient-type-selector mb-4">
            <div class="row g-2">
              <div class="col-sm-6">
                <label class="patient-type-card active" id="type-new-label">
                  <input type="radio" name="patient_type" value="new" checked class="d-none" id="type-new-radio">
                  <div class="d-flex align-items-center gap-3">
                    <div class="type-icon">
                      <i class="fa-solid fa-user-plus"></i>
                    </div>
                    <div>
                      <div class="fw-bold type-title font-15 text-dark">New Patient</div>
                      <small class="text-muted d-block font-12">First time visiting this clinic</small>
                    </div>
                  </div>
                </label>
              </div>
              <div class="col-sm-6">
                <label class="patient-type-card" id="type-existing-label">
                  <input type="radio" name="patient_type" value="existing" class="d-none" id="type-existing-radio">
                  <div class="d-flex align-items-center gap-3">
                    <div class="type-icon">
                      <i class="fa-solid fa-address-book"></i>
                    </div>
                    <div>
                      <div class="fw-bold type-title font-15 text-dark">Already a Patient</div>
                      <small class="text-muted d-block font-12">Find record with registered phone</small>
                    </div>
                  </div>
                </label>
              </div>
            </div>
          </div>

          <!-- Existing Patient Search Box (Hidden by default until "Already a Patient" is selected) -->
          <div id="existing-patient-search-box" class="p-3 rounded-4 mb-4 d-none" style="background: #f0fdfa; border: 1.5px solid #99f6e4;">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <label class="form-label fw-bold text-dark mb-0 font-14">
                <i class="fa-solid fa-phone-volume me-1 text-teal" style="color: #0d9488;"></i> Enter Registered Phone Number
              </label>
              <span class="badge" style="background: #ccfbf1; color: #0f766e; font-size: 11.5px;">Auto Search</span>
            </div>
            <div class="input-group">
              <input type="text" id="lookup_phone" class="form-control" placeholder="Enter 10-digit registered mobile number" maxlength="10" style="font-size: 14.5px; border-radius: 10px 0 0 10px;">
              <button type="button" class="btn btn-primary fw-bold px-3 d-inline-flex align-items-center gap-1" id="btn-lookup-patient" style="background: #0d9488; border-color: #0d9488; border-radius: 0 10px 10px 0;">
                <i class="fa-solid fa-magnifying-glass font-14"></i> Find Patient
              </button>
            </div>
            <small class="text-muted mt-1 d-block font-12">
              We will pull up past accounts linked to this phone number so you don't have to re-enter details.
            </small>

            <div id="lookup-spinner" class="d-none mt-2 text-teal font-13" style="color: #0d9488;">
              <span class="spinner-border spinner-border-sm me-1" role="status"></span> Searching patient medical records...
            </div>
            
            <div id="lookup-results" class="mt-3"></div>
          </div>

          <!-- Existing Patient Selected Confirmation Banner -->
          <div id="existing-patient-banner" class="existing-selected-banner mb-4 d-none">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
              <div class="d-flex align-items-center gap-3">
                <div style="width: 42px; height: 42px; border-radius: 12px; background: #0d9488; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: bold;" id="selected-avatar-initials">
                  P
                </div>
                <div>
                  <div class="d-flex align-items-center gap-2">
                    <strong class="font-15 text-dark" id="selected-patient-fullname">Rajesh Das</strong>
                    <span class="badge bg-success font-11 text-white">Verified Patient</span>
                  </div>
                  <div class="text-muted font-12" id="selected-patient-meta">
                    PID #363 • Male, 35 Yrs • 9833445566
                  </div>
                </div>
              </div>
              <div>
                <button type="button" class="btn btn-sm btn-outline-secondary font-12 fw-bold px-3 py-1" id="btn-change-patient" style="border-radius: 8px;">
                  <i class="fa-solid fa-arrows-rotate me-1"></i> Change / Reset
                </button>
              </div>
            </div>
          </div>

          <!-- First & Last Name -->
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">First Name <span class="text-danger">*</span></label>
              <input type="text" name="first_name" placeholder="First Name" required class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Last Name <span class="text-danger">*</span></label>
              <input type="text" name="last_name" placeholder="Last Name" required class="form-control">
            </div>
          </div>

          <!-- Sex & Age -->
          <div class="row g-3 mt-2">
            <div class="col-md-6">
              <label class="form-label">Sex (Gender) <span class="text-danger">*</span></label>
              <select name="sex" class="form-control">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Age (Years)</label>
              <input type="number" name="age" placeholder="Age" min="1" max="120" class="form-control">
            </div>
          </div>

          <!-- Mobile & Alternate Phone -->
          <div class="row g-3 mt-2">
            <div class="col-md-6">
              <label class="form-label">Permanent Mobile No. <span class="text-danger">*</span></label>
              <input type="text" name="mobile_no" placeholder="10-digit Mobile Number" required class="form-control">
              <small id="mobile-error" class="text-danger"></small>
            </div>
            <div class="col-md-6">
              <label class="form-label">Alternate Mobile / WhatsApp No.</label>
              <input type="text" name="alternate_mobile_no" placeholder="Optional Alternate Number" class="form-control">
              <small id="alt-mobile-error" class="text-danger"></small>
            </div>
          </div>

          <!-- Permanent Address -->
          <div class="row g-3 mt-2">
            <div class="col-md-12">
              <label class="form-label">Permanent Address <span class="text-danger">*</span></label>
              <textarea name="address" rows="2" placeholder="Full residential address with city & pin code" required class="form-control"></textarea>
            </div>
          </div>

          <!-- Patient Problem -->
          <div class="row g-3 mt-2">
            <div class="col-md-12">
              <label class="form-label">Chief Complaint / Symptoms</label>
              <textarea name="patient_problem" rows="3" placeholder="Briefly describe health concerns, symptoms, or reason for visit" class="form-control"></textarea>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Column: Billing Summary & Confirmation -->
      <div class="col-lg-4 col-md-12">
        <div class="vital-billing-card">
          <div class="d-flex align-items-center mb-3" style="gap: 10px;">
            <div style="width: 36px; height: 36px; border-radius: 10px; background: rgba(13, 148, 136, 0.1); color: #0d9488; display: flex; align-items: center; justify-content: center; font-size: 17px;">
              <i class="fa-solid fa-receipt"></i>
            </div>
            <div>
              <h4 class="font-weight-bold mb-0" style="color: #0f172a; font-size: 20px;">Billing Summary</h4>
              <small class="text-muted">Transparent clinic pricing</small>
            </div>
          </div>
          <hr class="mb-3" style="opacity: 0.1;">

          @php
            $payAmount = (isset($currentClinic) && $currentClinic->consultation_fee !== null) 
                ? (float)$currentClinic->consultation_fee 
                : (float)(isset($setting) && $setting->pay_amount !== null ? $setting->pay_amount : 500);
            $additionalAmount = (isset($currentClinic) && $currentClinic->platform_fee !== null) 
                ? (float)$currentClinic->platform_fee 
                : (float)(isset($setting) && $setting->pay_additional_amount !== null ? $setting->pay_additional_amount : 0);
            $totalAmount = $payAmount + $additionalAmount;

            $razorpayEnabled = !isset($currentClinic) || ($currentClinic->razorpay_enabled && (!empty($currentClinic->razorpay_key) || !empty($setting->pay_key) || env('RAZORPAY_KEY')));
            $cashEnabled = !isset($currentClinic) || $currentClinic->allow_cash_booking;
          @endphp

          <div class="d-flex justify-content-between mb-2" style="font-size: 14.5px;">
            <span class="text-muted">Doctor Consultation:</span>
            <strong style="color: #0f172a;">₹ {{ number_format($payAmount, 2) }}</strong>
          </div>

          <div class="d-flex justify-content-between mb-3" style="font-size: 14.5px;">
            <span class="text-muted">Platform & Processing:</span>
            @if($additionalAmount > 0)
              <strong style="color: #10b981;">+ ₹ {{ number_format($additionalAmount, 2) }}</strong>
            @else
              <span class="badge" style="background: #e2e8f0; color: #475569; font-weight: 600; font-size: 11px; padding: 3px 8px; border-radius: 6px;">FREE</span>
            @endif
          </div>

          <div class="p-3 rounded-3 mb-3" style="background: #f8fafc; border: 1.5px solid #e2e8f0;">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <span class="text-muted" style="font-size: 12px; font-weight: 700; text-transform: uppercase;">Total Payable</span>
                <div style="color: #0d9488; font-size: 24px; font-weight: 800;">₹ {{ number_format($totalAmount, 2) }}</div>
              </div>
              <span class="badge" style="background: #ccfbf1; color: #0f766e; font-size: 11px; padding: 5px 10px; border-radius: 12px;">Instant Confirmation</span>
            </div>
          </div>

          <input type="hidden" name="actual_amount" value="{{ $payAmount }}" readonly>
          <input type="hidden" name="amount" value="{{ $totalAmount }}" readonly>

          <!-- Terms & Conditions Checkbox -->
          <div class="p-3 rounded-3 mb-3" style="background: #f0fdfa; border: 1px solid #ccfbf1;">
            <div class="form-check d-flex align-items-center" style="gap: 8px;">
              <input class="form-check-input" type="checkbox" id="terms" style="transform: scale(1.15); cursor: pointer; accent-color: #0d9488;">
              <label class="form-check-label mb-0" for="terms" style="font-size: 13px; color: #334155; cursor: pointer;">
                I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal" style="color: #0d9488; font-weight: 700; text-decoration: underline;">Terms & Clinic Policies</a>
              </label>
            </div>
            <div id="terms-error" class="text-danger d-none mt-2" style="font-size: 12px;">
              <i class="fa-solid fa-circle-exclamation mr-1"></i> Please accept terms to proceed.
            </div>
          </div>

          <!-- Payment Action Buttons -->
          <div class="d-grid gap-2 mb-3">
            @if($razorpayEnabled)
              <button id="pay-button" class="btn w-100 py-2" disabled onclick="payWithRazorpay(event)" type="button" style="background: #0d9488; border-color: #0d9488; color: #ffffff; font-weight: 700; border-radius: 10px;">
                <i class="fa-solid fa-lock mr-2" style="margin-right: 8px;"></i> Pay Online (₹ {{ number_format($totalAmount, 2) }})
              </button>
            @endif

            @if($cashEnabled)
              <button id="cash-pay-button" class="btn w-100 py-2 {{ $razorpayEnabled ? 'btn-outline-secondary' : 'btn-primary' }}" disabled onclick="payWithCash(event)" type="button" style="border-radius: 10px; font-weight: 600; {{ !$razorpayEnabled ? 'background: #0d9488; border-color: #0d9488; color: #fff;' : '' }}">
                <i class="fa-solid fa-hospital-user mr-2" style="margin-right: 8px;"></i> Pay Cash at Clinic upon Arrival
              </button>
            @endif
          </div>

          <div class="text-center" style="font-size: 12px; color: #94a3b8;">
            <i class="fa-solid fa-shield-halved mr-1 text-success" style="margin-right: 4px;"></i> 256-Bit SSL Encrypted &bull; Verified Clinic Booking
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- Terms & Conditions Modal -->
  <div class="modal fade" id="termsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content shadow-lg border-0" style="border-radius: 16px; overflow: hidden;">
        <div class="modal-header terms-modal-header d-flex align-items-center">
          <h5 class="modal-title fw-bold text-white mb-0" id="termsModalLabel">
            <i class="fa-solid fa-file-shield text-warning me-2" style="margin-right: 8px;"></i> Clinic Terms & Consultation Guidelines
          </h5>
        </div>
        <div class="modal-body p-4">
          <div class="terms-notice-banner d-flex align-items-center">
            <i class="fa-solid fa-circle-info fs-4 me-3" style="margin-right: 12px; color: #0d9488;"></i>
            <div>
              <strong>Important Notice:</strong> Please read and accept clinic booking guidelines and policies before finalizing your appointment.
            </div>
          </div>

          <div class="term_and_condition_box">
            {!! nl2br(e(isset($setting) && !empty($setting->payment_terms_and_condition) ? $setting->payment_terms_and_condition : "1. Consultation fees must be paid in full to confirm the online appointment slot.\n2. Please arrive at the clinic 15 minutes prior to the booked time slot with any relevant previous prescriptions or lab test reports.\n3. Rescheduling is permitted up to 24 hours prior to the appointment date.\n4. Fees are non-refundable once the appointment booking is confirmed.\n5. In case of unexpected doctor emergency duty, our clinic team will reschedule you to your next preferred date.")) !!}
          </div>

          <div class="terms-acceptance-box">
            <div class="form-check d-flex align-items-center" style="gap: 10px;">
              <input class="form-check-input me-2" type="checkbox" id="modalTermsCheckbox" style="transform: scale(1.25); cursor: pointer; accent-color: #0d9488;">
              <label class="form-check-label fw-bold text-dark mb-0" for="modalTermsCheckbox" style="cursor: pointer; user-select: none; font-size: 13.5px;">
                I have read, understood, and accept all the Terms & Conditions and Clinic Policies stated above.
              </label>
            </div>
          </div>
        </div>
        <div class="modal-footer bg-light px-4 py-3 d-flex justify-content-between">
          <a href="{{ isset($currentClinic) ? url('/c/' . ($currentClinic->subdomain ?? $currentClinic->slug)) : url('/') }}" class="btn btn-outline-secondary" style="border-radius: 8px;">
            <i class="fa-solid fa-arrow-left me-1" style="margin-right: 6px;"></i> Decline & Go Back
          </a>
          <button type="button" class="btn text-white px-4" id="modalAcceptBtn" disabled style="background-color: #0d9488; border-color: #0d9488; border-radius: 8px; font-weight: 700;">
            <i class="fa-solid fa-check me-1" style="margin-right: 6px;"></i> Accept & Proceed to Form
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function () {
    const termsModalEl = document.getElementById('termsModal');
    let termsModal = null;
    if (termsModalEl) {
        termsModal = new bootstrap.Modal(termsModalEl, {
            backdrop: 'static',
            keyboard: false
        });
        termsModal.show();
    }

    const modalTermsCheckbox = document.getElementById("modalTermsCheckbox");
    const modalAcceptBtn = document.getElementById("modalAcceptBtn");
    const termsCheckbox = document.getElementById("terms");
    const payButton = document.getElementById("pay-button");
    const cashPayButton = document.getElementById("cash-pay-button");
    const termsError = document.getElementById("terms-error");

    if (modalTermsCheckbox && modalAcceptBtn) {
        modalTermsCheckbox.addEventListener("change", function () {
            modalAcceptBtn.disabled = !this.checked;
        });
    }

    if (modalAcceptBtn) {
        modalAcceptBtn.addEventListener("click", function () {
            if (modalTermsCheckbox && modalTermsCheckbox.checked) {
                if (termsCheckbox) termsCheckbox.checked = true;
                if (payButton) payButton.disabled = false;
                if (cashPayButton) cashPayButton.disabled = false;
                if (termsError) termsError.classList.add("d-none");
                if (termsModal) termsModal.hide();
                $("input[name='first_name']").focus();
            }
        });
    }

    if (termsCheckbox) {
        termsCheckbox.addEventListener("change", function () {
            if (this.checked) {
                if (payButton) payButton.disabled = false;
                if (cashPayButton) cashPayButton.disabled = false;
                if (termsError) termsError.classList.add("d-none");
                if (modalTermsCheckbox) modalTermsCheckbox.checked = true;
                if (modalAcceptBtn) modalAcceptBtn.disabled = false;
            } else {
                if (payButton) payButton.disabled = true;
                if (cashPayButton) cashPayButton.disabled = true;
                if (termsError) termsError.classList.remove("d-none");
                if (modalTermsCheckbox) modalTermsCheckbox.checked = false;
                if (modalAcceptBtn) modalAcceptBtn.disabled = true;
            }
        });
    }

    // ==========================================
    // Patient Type Switcher & Phone Lookup
    // ==========================================
    const lookupUrl = "{{ (isset($currentClinic) && ($currentClinic->subdomain || $currentClinic->slug)) ? url('/c/' . ($currentClinic->subdomain ?? $currentClinic->slug) . '/lookup-patient') : url('lookup-patient') }}";

    function setPatientType(type) {
        if (type === 'existing') {
            $("#type-existing-label").addClass("active");
            $("#type-new-label").removeClass("active");
            $("#type-existing-radio").prop("checked", true);
            $("#existing-patient-search-box").removeClass("d-none");
            $("#lookup_phone").focus();
        } else {
            $("#type-new-label").addClass("active");
            $("#type-existing-label").removeClass("active");
            $("#type-new-radio").prop("checked", true);
            $("#existing-patient-search-box").addClass("d-none");
            $("#existing-patient-banner").addClass("d-none");
            clearSelectedPatient();
        }
    }

    $("#type-new-label").on("click", function () {
        setPatientType('new');
    });

    $("#type-existing-label").on("click", function () {
        setPatientType('existing');
    });

    function clearSelectedPatient() {
        $("#selected_patient_id").val("");
        $("input[name='first_name']").val("").prop("readonly", false);
        $("input[name='last_name']").val("").prop("readonly", false);
        $("select[name='sex']").val("Male");
        $("input[name='age']").val("");
        $("input[name='mobile_no']").val("").prop("readonly", false);
        $("input[name='alternate_mobile_no']").val("");
        $("textarea[name='address']").val("");
        $("#lookup-results").empty();
    }

    function selectPatientRecord(p) {
        $("#selected_patient_id").val(p.id);
        $("input[name='first_name']").val(p.first_name || "");
        $("input[name='last_name']").val(p.last_name || "");
        if (p.sex) {
            $("select[name='sex']").val(p.sex);
        }
        if (p.age) {
            $("input[name='age']").val(p.age);
        }
        $("input[name='mobile_no']").val(p.mobile_no || "");
        $("input[name='alternate_mobile_no']").val(p.alternate_mobile_no || "");
        $("textarea[name='address']").val(p.address || "");
        
        let fullName = ((p.first_name || '') + ' ' + (p.last_name || '')).trim();
        let initials = (p.first_name ? p.first_name.charAt(0) : 'P') + (p.last_name ? p.last_name.charAt(0) : 'T');
        $("#selected-avatar-initials").text(initials.toUpperCase());
        $("#selected-patient-fullname").text(fullName || ('Patient #' + p.id));
        $("#selected-patient-meta").text('#PID-' + p.id + ' • ' + (p.sex || 'N/A') + (p.age ? (', ' + p.age + ' Yrs') : '') + ' • ' + (p.mobile_no || ''));

        $("#existing-patient-banner").removeClass("d-none");
        $("#existing-patient-search-box").addClass("d-none");
        $("#lookup-results").empty();
        $("textarea[name='patient_problem']").focus();
    }

    $("#btn-change-patient").on("click", function () {
        $("#existing-patient-banner").addClass("d-none");
        $("#existing-patient-search-box").removeClass("d-none");
        $("#lookup_phone").focus();
    });

    function performPatientLookup() {
        let phone = $("#lookup_phone").val().trim();
        if (phone.length < 5) {
            $("#lookup-results").html('<div class="alert alert-warning py-2 px-3 font-13 mb-0" style="border-radius: 8px;">Please enter at least 5 digits to search.</div>');
            return;
        }

        $("#lookup-spinner").removeClass("d-none");
        $("#lookup-results").empty();

        $.ajax({
            url: lookupUrl,
            type: "GET",
            data: { phone: phone },
            success: function (res) {
                $("#lookup-spinner").addClass("d-none");
                if (res.success && res.patients && res.patients.length > 0) {
                    if (res.patients.length === 1) {
                        selectPatientRecord(res.patients[0]);
                    } else {
                        let html = '<div class="alert alert-info py-2 px-3 font-12 mb-2" style="border-radius: 8px; background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd;">' +
                            '<strong>' + res.patients.length + ' matching patient records found.</strong> Please select who this consultation is for:</div>' +
                            '<div class="patient-selection-list">';
                        
                        res.patients.forEach(function (p) {
                            let name = ((p.first_name || '') + ' ' + (p.last_name || '')).trim() || ('Patient #' + p.id);
                            let init = (p.first_name ? p.first_name.charAt(0) : 'P') + (p.last_name ? p.last_name.charAt(0) : '');
                            let pDataJson = encodeURIComponent(JSON.stringify(p));
                            
                            html += '<div class="patient-selection-item d-flex align-items-center justify-content-between flex-wrap gap-2" data-patient="' + pDataJson + '">' +
                                '<div class="d-flex align-items-center gap-2">' +
                                    '<div style="width: 32px; height: 32px; border-radius: 8px; background: #0d9488; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: bold;">' + init.toUpperCase() + '</div>' +
                                    '<div>' +
                                        '<strong class="font-14 text-dark d-block">' + name + '</strong>' +
                                        '<small class="text-muted font-11">#PID-' + p.id + ' • ' + (p.sex || 'N/A') + (p.age ? (', ' + p.age + ' Yrs') : '') + ' • ' + (p.address ? (p.address.substring(0, 25) + '...') : 'No address') + '</small>' +
                                    '</div>' +
                                '</div>' +
                                '<button type="button" class="btn btn-sm btn-outline-primary font-12 fw-bold px-3 py-1" style="border-radius: 6px;">Select</button>' +
                            '</div>';
                        });

                        html += '<div class="mt-2 text-end">' +
                            '<button type="button" class="btn btn-sm btn-link text-muted font-12 text-decoration-none" id="btn-none-of-above">' +
                                '<i class="fa-solid fa-plus me-1"></i> Register as a new family member under this phone' +
                            '</button>' +
                        '</div></div>';

                        $("#lookup-results").html(html);

                        $(".patient-selection-item").on("click", function () {
                            let raw = $(this).attr("data-patient");
                            let patientObj = JSON.parse(decodeURIComponent(raw));
                            selectPatientRecord(patientObj);
                        });

                        $("#btn-none-of-above").on("click", function () {
                            $("#selected_patient_id").val("");
                            $("#existing-patient-search-box").addClass("d-none");
                            $("input[name='mobile_no']").val($("#lookup_phone").val());
                            $("input[name='first_name']").val("").focus();
                            $("input[name='last_name']").val("");
                            $("textarea[name='address']").val("");
                        });
                    }
                } else {
                    $("#lookup-results").html(
                        '<div class="alert alert-warning py-2 px-3 font-13 mb-0" style="border-radius: 8px; background: #fffbeb; color: #b45309; border: 1px solid #fde68a;">' +
                            '<i class="fa-solid fa-circle-exclamation me-1"></i> No patient record found for <strong>' + phone + '</strong>. You can proceed below to register as a new patient.' +
                        '</div>'
                    );
                    $("input[name='mobile_no']").val(phone);
                }
            },
            error: function () {
                $("#lookup-spinner").addClass("d-none");
                $("#lookup-results").html('<div class="alert alert-danger py-2 px-3 font-13 mb-0" style="border-radius: 8px;">Failed to lookup patient. Please verify your connection or register as a new patient.</div>');
            }
        });
    }

    $("#btn-lookup-patient").on("click", function () {
        performPatientLookup();
    });

    $("#lookup_phone").on("keyup", function (e) {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (e.key === "Enter") {
            performPatientLookup();
        } else if (this.value.length === 10) {
            performPatientLookup();
        }
    });

    $("input[name='mobile_no'], input[name='alternate_mobile_no']").on("input", function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function validateMobileNumber(mobile) {
        let mobilePattern = /^[6-9]\d{9}$/;
        return mobilePattern.test(mobile.trim());
    }

    $("input[name='mobile_no'], input[name='alternate_mobile_no']").on("change", function () {
        let mobile = $("input[name='mobile_no']").val();
        let alternateMobile = $("input[name='alternate_mobile_no']").val();

        if (mobile && !validateMobileNumber(mobile)) {
            $("input[name='mobile_no']").val("");
            $("#mobile-error").text("Invalid Mobile Number! Must be 10 digits and start with 6-9.");
        } else {
            $("#mobile-error").text("");
        }

        if (alternateMobile && !validateMobileNumber(alternateMobile)) {
            $("input[name='alternate_mobile_no']").val("");
            $("#alt-mobile-error").text("Invalid Alternate Mobile Number! Must be 10 digits and start with 6-9.");
        } else {
            $("#alt-mobile-error").text("");
        }
    });
});

function payWithRazorpay(e) {
    e.preventDefault();
    $(".error-message").remove();

    let isValid = true;
    let patient_id = $("#selected_patient_id").val();
    let first_name = $("input[name='first_name']").val();
    let last_name = $("input[name='last_name']").val();
    let dob = null;
    let sex = $("select[name='sex']").val();
    let age = $("input[name='age']").val();
    let mobile_no = $("input[name='mobile_no']").val();
    let alternate_mobile_no = $("input[name='alternate_mobile_no']").val();
    let address = $("textarea[name='address']").val();
    let patient_problem = $("textarea[name='patient_problem']").val();
    let actual_amount = $("input[name='actual_amount']").val();
    let amount = $("input[name='amount']").val();
    let bookingDate = $("#booking_date").val();
    let timeSlotId = $("#time_slot_id").val();

    if (!first_name) {
        $("input[name='first_name']").after("<span class='error-message text-danger d-block mt-1' style='font-size:12px;'>First name is required.</span>");
        isValid = false;
    }
    if (!last_name) {
        $("input[name='last_name']").after("<span class='error-message text-danger d-block mt-1' style='font-size:12px;'>Last name is required.</span>");
        isValid = false;
    }

    if (!mobile_no) {
        $("input[name='mobile_no']").after("<span class='error-message text-danger d-block mt-1' style='font-size:12px;'>Mobile number is required.</span>");
        isValid = false;
    } else if (!/^\d{10}$/.test(mobile_no)) {
        $("input[name='mobile_no']").after("<span class='error-message text-danger d-block mt-1' style='font-size:12px;'>Enter a valid 10-digit mobile number.</span>");
        isValid = false;
    }

    if (!amount) {
        $("input[name='amount']").after("<span class='error-message text-danger d-block mt-1' style='font-size:12px;'>Amount is required.</span>");
        isValid = false;
    }

    if (!address) {
        $("textarea[name='address']").after("<span class='error-message text-danger d-block mt-1' style='font-size:12px;'>Address is required.</span>");
        isValid = false;
    }

    if (!isValid) {
        return;
    }

    let payBtn = $("#pay-button");
    let originalBtnText = payBtn.html();
    payBtn.prop("disabled", true).html('<span class="spinner-border spinner-border-sm me-2" role="status" style="margin-right:8px;"></span>Processing Payment...');

    $.ajax({
        url: "{{ (isset($currentClinic) && ($currentClinic->subdomain || $currentClinic->slug)) ? url('/c/' . ($currentClinic->subdomain ?? $currentClinic->slug) . '/generate-order') : url('generate-order') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            amount: amount
        },
        success: function(response) {
            if (response.success) {
                let fullName = (first_name + " " + (last_name || "")).trim();
                let options = {
                    "key": response.key || "{{ (isset($currentClinic) && $currentClinic->razorpay_enabled && $currentClinic->razorpay_key) ? $currentClinic->razorpay_key : (isset($setting) && !empty($setting->pay_key) ? $setting->pay_key : env('RAZORPAY_KEY')) }}",
                    "amount": response.amount,
                    "currency": "INR",
                    "name": "{{ $currentClinic->name ?? 'Dr Clinic' }}",
                    "description": "Appointment Consultation Fee - {{ $currentClinic->name ?? 'Dr Clinic' }}",
                    "image": "{{ (isset($currentClinic) && $currentClinic->logo) ? asset($currentClinic->logo) : URL::to('public/assets/web/logo/favicon-32x32.png') }}",
                    "order_id": response.order_id,
                    "handler": function(paymentResponse) {
                        payBtn.html('<span class="spinner-border spinner-border-sm me-2" role="status" style="margin-right:8px;"></span>Finalizing Booking...');
                        $.ajax({
                            url: "{{ (isset($currentClinic) && ($currentClinic->subdomain || $currentClinic->slug)) ? url('/c/' . ($currentClinic->subdomain ?? $currentClinic->slug) . '/payment-success') : url('payment-success') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                razorpay_payment_id: paymentResponse.razorpay_payment_id,
                                razorpay_order_id: response.order_id,
                                razorpay_signature: paymentResponse.razorpay_signature,
                                patient_id: patient_id,
                                first_name: first_name,
                                last_name: last_name,
                                dob: dob,
                                sex: sex,
                                age: age,
                                mobile_no: mobile_no,
                                alternate_mobile_no: alternate_mobile_no,
                                address: address,
                                patient_problem: patient_problem,
                                actual_amount: actual_amount,
                                amount: amount,
                                booking_date: bookingDate,
                                time_slot_id: timeSlotId,
                                status: "success"
                            },
                            success: function(data) {
                                if (data.success) {
                                    window.location.href = "{{ (isset($currentClinic) && ($currentClinic->subdomain || $currentClinic->slug)) ? url('/c/' . ($currentClinic->subdomain ?? $currentClinic->slug) . '/booking-success/') : url('booking-success/') }}/" + response.order_id;
                                } else {
                                    payBtn.prop("disabled", false).html(originalBtnText);
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Booking Error',
                                        text: data.message || 'Payment was received but recording failed. Please contact clinic support.'
                                    });
                                }
                            }
                        }).fail(function(xhr) {
                            payBtn.prop("disabled", false).html(originalBtnText);
                            Swal.fire({
                                icon: 'warning',
                                title: 'Attention',
                                text: 'Your payment was processed. If your confirmation does not load, please contact the clinic with Order ID: ' + response.order_id
                            });
                        });
                    },
                    "prefill": {
                        "name": fullName,
                        "contact": mobile_no
                    },
                    "theme": {
                        "color": "{{ (isset($currentClinic) && $currentClinic->theme_color) ? $currentClinic->theme_color : '#0d9488' }}"
                    },
                    "modal": {
                        "ondismiss": function() {
                            payBtn.prop("disabled", false).html(originalBtnText);
                            $.ajax({
                                url: "{{ (isset($currentClinic) && ($currentClinic->subdomain || $currentClinic->slug)) ? url('/c/' . ($currentClinic->subdomain ?? $currentClinic->slug) . '/payment-failed') : url('payment-failed') }}",
                                type: "POST",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    order_id: response.order_id,
                                    patient_id: patient_id,
                                    first_name: first_name,
                                    last_name: last_name,
                                    dob: dob,
                                    sex: sex,
                                    age: age,
                                    mobile_no: mobile_no,
                                    alternate_mobile_no: alternate_mobile_no,
                                    address: address,
                                    patient_problem: patient_problem,
                                    actual_amount: actual_amount,
                                    amount: amount,
                                    booking_date: bookingDate,
                                    time_slot_id: timeSlotId,
                                    status: "cancelled"
                                },
                                success: function() {
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'Payment Cancelled',
                                        text: 'Your payment was not completed. Would you like to view/download the transaction receipt or try again?',
                                        showCancelButton: true,
                                        confirmButtonColor: '#0d9488',
                                        confirmButtonText: '<i class="fa-solid fa-receipt me-1"></i> View Receipt',
                                        cancelButtonText: 'Try Again'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = "{{ (isset($currentClinic) && ($currentClinic->subdomain || $currentClinic->slug)) ? url('/c/' . ($currentClinic->subdomain ?? $currentClinic->slug) . '/booking-failed/') : url('booking-failed/') }}/" + response.order_id;
                                        }
                                    });
                                }
                            });
                        }
                    }
                };

                let rzp1 = new Razorpay(options);
                rzp1.open();
            } else {
                payBtn.prop("disabled", false).html(originalBtnText);
                Swal.fire({
                    icon: 'error',
                    title: 'Payment Gateway Error',
                    text: response.message || 'Unable to connect to payment gateway. Please try again.'
                });
            }
        },
        error: function(xhr) {
            payBtn.prop("disabled", false).html(originalBtnText);
            let errMsg = 'Failed to initiate payment. Please check your internet connection or try again.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errMsg = xhr.responseJSON.message;
            }
            Swal.fire({
                icon: 'error',
                title: 'Gateway Error',
                text: errMsg
            });
        }
    });
}

function payWithCash(e) {
    if (e) e.preventDefault();
    $(".error-message").remove();

    let isValid = true;
    let patient_id = $("#selected_patient_id").val();
    let first_name = $("input[name='first_name']").val();
    let last_name = $("input[name='last_name']").val();
    let dob = null;
    let sex = $("select[name='sex']").val();
    let age = $("input[name='age']").val();
    let mobile_no = $("input[name='mobile_no']").val();
    let alternate_mobile_no = $("input[name='alternate_mobile_no']").val();
    let address = $("textarea[name='address']").val();
    let patient_problem = $("textarea[name='patient_problem']").val();
    let actual_amount = $("input[name='actual_amount']").val();
    let amount = $("input[name='amount']").val();
    let bookingDate = $("#booking_date").val();
    let timeSlotId = $("#time_slot_id").val();

    if (!first_name) {
        $("input[name='first_name']").after("<span class='error-message text-danger d-block mt-1' style='font-size:12px;'>First name is required.</span>");
        isValid = false;
    }
    if (!last_name) {
        $("input[name='last_name']").after("<span class='error-message text-danger d-block mt-1' style='font-size:12px;'>Last name is required.</span>");
        isValid = false;
    }
    if (!mobile_no) {
        $("input[name='mobile_no']").after("<span class='error-message text-danger d-block mt-1' style='font-size:12px;'>Mobile number is required.</span>");
        isValid = false;
    } else if (!/^\d{10}$/.test(mobile_no)) {
        $("input[name='mobile_no']").after("<span class='error-message text-danger d-block mt-1' style='font-size:12px;'>Enter a valid 10-digit mobile number.</span>");
        isValid = false;
    }
    if (!address) {
        $("textarea[name='address']").after("<span class='error-message text-danger d-block mt-1' style='font-size:12px;'>Address is required.</span>");
        isValid = false;
    }

    if (!isValid) return;

    let cashBtn = $("#cash-pay-button");
    let originalText = cashBtn.html();
    cashBtn.prop("disabled", true).html('<span class="spinner-border spinner-border-sm me-2" role="status" style="margin-right:8px;"></span>Confirming Appointment...');

    $.ajax({
        url: "{{ (isset($currentClinic) && ($currentClinic->subdomain || $currentClinic->slug)) ? url('/c/' . ($currentClinic->subdomain ?? $currentClinic->slug) . '/payment-success') : url('payment-success') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            payment_method: 'cash',
            razorpay_payment_id: 'CASH_PAYMENT',
            patient_id: patient_id,
            first_name: first_name,
            last_name: last_name,
            dob: dob,
            sex: sex,
            age: age,
            mobile_no: mobile_no,
            alternate_mobile_no: alternate_mobile_no,
            address: address,
            patient_problem: patient_problem,
            actual_amount: actual_amount,
            amount: amount,
            booking_date: bookingDate,
            time_slot_id: timeSlotId,
            status: "confirmed"
        },
        success: function(data) {
            if (data.success) {
                window.location.href = "{{ (isset($currentClinic) && ($currentClinic->subdomain || $currentClinic->slug)) ? url('/c/' . ($currentClinic->subdomain ?? $currentClinic->slug) . '/booking-success/') : url('booking-success/') }}/" + data.order_id;
            } else {
                cashBtn.prop("disabled", false).html(originalText);
                Swal.fire({
                    icon: 'error',
                    title: 'Booking Error',
                    text: data.message || 'Failed to book appointment. Please try again.'
                });
            }
        },
        error: function() {
            cashBtn.prop("disabled", false).html(originalText);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Something went wrong while confirming your booking. Please try again.'
            });
        }
    });
}
</script>
@endsection
