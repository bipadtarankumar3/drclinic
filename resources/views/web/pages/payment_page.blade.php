@extends('web.layouts.main')

@section('style')
<link rel="stylesheet" href="{{ URL::to('public/assets/web/css/appointment/appoint-style.css')}}">
<link rel="stylesheet" href="{{ URL::to('public/assets/web/css/appointment/appoint-responsive.css')}}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<style>
  :root {
    --vital-primary: #0d9488;
    --vital-primary-dark: #0f766e;
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
</style>
@endsection

@section('banner')
<!-- ========================================================
     MODERN PAGE HEADER (Replaces Old Stretched Banner)
     ======================================================== -->
<section class="vital-page-header">
  <div class="container-fluid" style="padding-left: 36px; padding-right: 36px;">
    <div class="row align-items-center">
      <div class="col-md-7">
        <div class="vital-hero-badge mb-2">
          <span class="vital-pulse-dot"></span>
          <span>Step 2 of 2: Patient Registration</span>
        </div>
        <h1 class="font-weight-bold mb-1" style="font-size: 32px; color: #0f172a; letter-spacing: -0.5px;">
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
<div class="container py-4 my-2" style="max-width: 1240px;">
  <form id="payment-form" class="payment-form">
    @csrf
    <input type="hidden" name="booking_date" id="booking_date" @if (isset($booking_date)) value="{{ base64_decode($booking_date) }}" @endif>
    <input type="hidden" name="time_slot_id" id="time_slot_id" @if (isset($time_slot_id)) value="{{ base64_decode($time_slot_id) }}" @endif>

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
          <hr class="mb-4" style="opacity: 0.1;">

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
            $payAmount = (isset($currentClinic) && $currentClinic->consultation_fee) ? (float)$currentClinic->consultation_fee : (float)(isset($setting) ? $setting->pay_amount : 500);
            $additionalAmount = (float)(isset($setting) ? $setting->pay_additional_amount : 0);
            $totalAmount = $payAmount + $additionalAmount;
          @endphp

          <div class="d-flex justify-content-between mb-2" style="font-size: 14.5px;">
            <span class="text-muted">Doctor Consultation:</span>
            <strong style="color: #0f172a;">₹ {{ number_format($payAmount, 2) }}</strong>
          </div>

          <div class="d-flex justify-content-between mb-3" style="font-size: 14.5px;">
            <span class="text-muted">Platform & Processing:</span>
            <strong style="color: #10b981;">+ ₹ {{ number_format($additionalAmount, 2) }}</strong>
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

          <!-- Pay Button -->
          <div class="mb-3">
            <button id="pay-button" class="btn w-100" disabled onclick="payWithRazorpay(event)" type="button">
              <i class="fa-solid fa-lock mr-2" style="margin-right: 8px;"></i> Pay Now & Confirm Booking
            </button>
          </div>

          <div class="text-center" style="font-size: 12px; color: #94a3b8;">
            <i class="fa-solid fa-shield-halved mr-1 text-success" style="margin-right: 4px;"></i> 256-Bit SSL Encrypted &bull; Razorpay Verified
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
                if (termsError) termsError.classList.add("d-none");
                if (modalTermsCheckbox) modalTermsCheckbox.checked = true;
                if (modalAcceptBtn) modalAcceptBtn.disabled = false;
            } else {
                if (payButton) payButton.disabled = true;
                if (termsError) termsError.classList.remove("d-none");
                if (modalTermsCheckbox) modalTermsCheckbox.checked = false;
                if (modalAcceptBtn) modalAcceptBtn.disabled = true;
            }
        });
    }

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
                        "color": "#0d9488"
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
</script>
@endsection
