@extends('web.layouts.main')

@section('style')
<link rel="stylesheet" href="{{ URL::to('public/assets/web/css/appointment/appoint-style.css')}}">
<link rel="stylesheet" href="{{ URL::to('public/assets/web/css/appointment/appoint-responsive.css')}}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<style>
    .term_and_condition_box {
        max-height: 280px;
        overflow-y: auto;
        padding: 16px;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        background-color: #fcfcfc;
        color: #333333;
        font-size: 14px;
        line-height: 1.8;
    }

    .terms-notice-banner {
        background-color: #fff4f4;
        border: 1px solid #f5c2c7;
        border-left: 5px solid #b22d32;
        padding: 12px 16px;
        border-radius: 6px;
        color: #842029;
        font-size: 14px;
        margin-bottom: 15px;
    }

    .terms-modal-header {
        background: linear-gradient(135deg, #183e66 0%, #b22d32 100%);
        color: #ffffff;
        padding: 16px 20px;
        border-top-left-radius: calc(0.3rem - 1px);
        border-top-right-radius: calc(0.3rem - 1px);
    }

    .terms-acceptance-box {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 12px 16px;
        margin-top: 15px;
    }

    .pay-button-container {
        display: none;
        text-align: right;
    }

    .btn-disabled {
        opacity: 0.5;
        pointer-events: none;
    }
</style>
@endsection

@section('banner')
<div class="banner-2">
    <div class="banner-2-img">
        <img src="{{ URL::to('public/assets/web/appointment/Banner.png')}}" alt="">
    </div>
    <div class="ban-2-text">
        <h1>Patient Details</h1>
    </div>
</div>
@endsection

@section('content')
<div class="container">
    <div id="step-1">
        <div class="row my-4">
            <div class="col-md-12">
                <div id="step-2">
                    
                    <div class="container mt-4">
                        <form id="payment-form" class="payment-form">
                            @csrf
                            <input type="hidden" name="booking_date" id="booking_date" @if (isset($booking_date)) value="{{ base64_decode($booking_date) }}" @endif>

                            <input type="hidden" name="time_slot_id" id="time_slot_id" @if (isset($time_slot_id)) value="{{ base64_decode($time_slot_id) }}" @endif>

                            
                            <div class="row">
                                <!-- Patient Details -->
                                <div class="col-md-8">
                                    <div class="card shadow-lg p-4">
                                        <h2>Patient Details</h2>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">First Name <span style="color: red">*</span></label>
                                                <input type="text" name="first_name" placeholder="First Name" required class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Last Name <span style="color: red">*</span></label>
                                                <input type="text" name="last_name" placeholder="Last Name" required class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Sex (Gender)</label>
                                                <select name="sex" class="form-control">
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Age</label>
                                                <input type="number" name="age" placeholder="Age" min="1" max="120" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Permanent Mobile No.  <span style="color: red">*</span></label>
                                                <input type="text" name="mobile_no" placeholder="Mobile Number" required class="form-control">
                                                <small id="mobile-error" class="text-danger"></small>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Alternate Mobile/Whatsapp No.</label>
                                                <input type="text" name="alternate_mobile_no" placeholder="Alternate Mobile Number" class="form-control">
                                                <small id="alt-mobile-error" class="text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <label class="form-label">Permanent Address  <span style="color: red">*</span></label>
                                                <textarea name="address" placeholder="Address" required class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <label class="form-label">Patient Problem </label>
                                                <textarea name="patient_problem" placeholder="Patient Problem" required class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="card shadow-lg p-4">
                                        <h2>Billing Details</h2>
                                        <hr>
                                        <div class="billing-info d-flex justify-content-between">
                                            <p><strong>Payment Amount:</strong></p> 
                                            <p>₹ {{ number_format(isset($setting) ? $setting->pay_amount : 0, 2) }}</p>
                                        </div>
                                        <div class="billing-info d-flex justify-content-between">
                                            <p><strong>Platform Charge:</strong></p> 
                                            <p style="color: green">+ ₹  {{ number_format(isset($setting) ? $setting->pay_additional_amount : 0, 2) }}</p>
                                        </div>
                                        <hr>
                                        <div class="billing-info d-flex justify-content-between">
                                            <p><strong>Total Payment Amount:</strong></p> 
                                            <p>₹ {{ number_format(isset($setting) ? $setting->pay_amount + $setting->pay_additional_amount : 0, 2) }}</p>
                                        </div>
                                        <input type="hidden" name="actual_amount" value="{{ isset($setting) ? $setting->pay_amount : 0 }}" readonly>
                                        <input type="hidden" name="amount" value="{{ isset($setting) ? $setting->pay_amount + $setting->pay_additional_amount : 0 }}" readonly>
                                        
                                        <div class="terms-container mt-3">
                                            <input type="checkbox" id="terms"> 
                                            <label for="terms">I accept the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms & Conditions</a></label>
                                            <div id="terms-error" class="text-danger d-none"><small>Please accept the Terms & Conditions to proceed.</small></div>
                                        </div>
                                        
                                        <div class="mt-3">
                                            <button id="pay-button" class="btn btn-warning w-100" disabled onclick="payWithRazorpay(event)" type="button">Pay Now</button>
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </form>
                    </div>
                    
                    <!-- Terms & Conditions Modal -->
                    <div class="modal fade" id="termsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content shadow-lg border-0">
                                <div class="modal-header terms-modal-header d-flex align-items-center">
                                    <h5 class="modal-title fw-bold text-white mb-0" id="termsModalLabel">
                                        <i class="fa-solid fa-triangle-exclamation text-warning me-2"></i> Terms & Conditions
                                    </h5>
                                </div>
                                <div class="modal-body p-4">
                                    <div class="terms-notice-banner d-flex align-items-center">
                                        <i class="fa-solid fa-circle-exclamation text-danger fs-4 me-3"></i>
                                        <div>
                                            <strong>Important Notice:</strong> You must read, understand, and accept all clinic guidelines and terms before you can fill up the patient details and book an appointment.
                                        </div>
                                    </div>
                                    
                                    <div class="term_and_condition_box">
                                        {!! nl2br(e(isset($setting) && !empty($setting->payment_terms_and_condition) ? $setting->payment_terms_and_condition : "1. Consultation fees are non-refundable once the appointment booking is confirmed.\n2. Patients are requested to arrive at the clinic 15 minutes before the allocated time slot.\n3. Please bring previous prescriptions, lab reports, MRI/CT scans, and relevant medical history documents.\n4. Providing accurate patient contact and identification details is mandatory for medical record compliance.")) !!}
                                    </div>

                                    <div class="terms-acceptance-box">
                                        <div class="form-check d-flex align-items-center">
                                            <input class="form-check-input me-2" type="checkbox" id="modalTermsCheckbox" style="transform: scale(1.25); cursor: pointer;">
                                            <label class="form-check-label fw-bold text-dark" for="modalTermsCheckbox" style="cursor: pointer; user-select: none;">
                                                I have read, understood, and solemnly agree to all the Terms & Conditions and Clinic Policies stated above.
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer bg-light px-4 py-3 d-flex justify-content-between">
                                    <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                                        <i class="fa-solid fa-arrow-left me-1"></i> Decline & Go Back
                                    </a>
                                    <button type="button" class="btn btn-danger px-4" id="modalAcceptBtn" disabled style="background-color: #b22d32; border-color: #b22d32;">
                                        <i class="fa-solid fa-check me-1"></i> Accept & Proceed to Form
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

<script>
$(document).ready(function () {
    // Show Terms & Conditions modal immediately on page load
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

    // Modal checkbox toggle enables/disables accept button
    if (modalTermsCheckbox && modalAcceptBtn) {
        modalTermsCheckbox.addEventListener("change", function () {
            modalAcceptBtn.disabled = !this.checked;
        });
    }

    // Modal Accept Button click - accepts terms, enables form, checks billing checkbox
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

    // Billing card terms checkbox toggle
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

    // Allow only numbers in mobile fields
    $("input[name='mobile_no'], input[name='alternate_mobile_no']").on("input", function () {
        this.value = this.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
    });

    // Mobile number validation
    function validateMobileNumber(mobile) {
        let mobilePattern = /^[6-9]\d{9}$/; // 10-digit number starting with 6-9
        return mobilePattern.test(mobile.trim());
    }

    $("input[name='mobile'], input[name='alternate_mobile']").on("change", function () {
        let mobile = $("input[name='mobile']").val();
        let alternateMobile = $("input[name='alternate_mobile']").val();

        if (mobile && !validateMobileNumber(mobile)) {
            $("input[name='mobile']").val("");
            $("#mobile-error").text("Invalid Mobile Number! Must be 10 digits and start with 6-9.");
        } else {
            $("#mobile-error").text("");
        }

        if (alternateMobile && !validateMobileNumber(alternateMobile)) {
            $("input[name='alternate_mobile']").val("");
            $("#alt-mobile-error").text("Invalid Alternate Mobile Number! Must be 10 digits and start with 6-9.");
        } else {
            $("#alt-mobile-error").text("");
        }
    });
});

function payWithRazorpay(e) {

    e.preventDefault();

    $(".error-message").remove(); // Remove previous error messages

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
    let actual_amount = $("input[name='actual_amount']").val(); // actual_amount from hidden input
    let amount = $("input[name='amount']").val(); // Amount from hidden input
    let email = "user@example.com"; // Use logged-in user email or input field
    let bookingDate = $("#booking_date").val();
    let timeSlotId = $("#time_slot_id").val();
    
    
    // Validation
    if (!first_name) {
        $("input[name='first_name']").after("<span class='error-message text-danger'>Name is required.</span>");
        isValid = false;
    }
    if (!last_name) {
        $("input[name='last_name']").after("<span class='error-message text-danger'>Name is required.</span>");
        isValid = false;
    }

    if (!mobile_no) {
        $("input[name='mobile_no']").after("<span class='error-message text-danger'>Mobile number is required.</span>");
        isValid = false;
    } else if (!/^\d{10}$/.test(mobile_no)) {
        $("input[name='mobile_no']").after("<span class='error-message text-danger'>Enter a valid 10-digit mobile number.</span>");
        isValid = false;
    }

    if (!amount) {
        $("input[name='amount']").after("<span class='error-message text-danger'>Amount is required.</span>");
        isValid = false;
    }

    if (!address) {
        $("textarea[name='address']").after("<span class='error-message text-danger'>Address is required.</span>");
        isValid = false;
    }

    // if (!patient_problem) {
    //     $("textarea[name='patient_problem']").after("<span class='error-message text-danger'>Patient problem is required.</span>");
    //     isValid = false;
    // }

    if (!isValid) {
        return;
    }

    let payBtn = $("#pay-button");
    let originalBtnText = payBtn.html();
    payBtn.prop("disabled", true).html('<span class="spinner-border spinner-border-sm me-2" role="status"></span>Processing...');

    $.ajax({
        url: "{{ url('generate-order') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            amount: amount
        },
        success: function(response) {
            if (response.success) {
                let fullName = (first_name + " " + (last_name || "")).trim();
                let options = {
                    "key": "{{ isset($setting) && !empty($setting->pay_key) ? $setting->pay_key : env('RAZORPAY_KEY') }}",
                    "amount": response.amount,
                    "currency": "INR",
                    "name": "Roy Neuro Care",
                    "description": "Appointment Booking Consultation Fee",
                    "image": "{{ URL::to('public/assets/web/logo/favicon-32x32.png') }}",
                    "order_id": response.order_id,
                    "handler": function(paymentResponse) {
                        payBtn.html('<span class="spinner-border spinner-border-sm me-2" role="status"></span>Finalizing Booking...');
                        $.ajax({
                            url: "{{ url('payment-success') }}",
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
                                    window.location.href = "{{ url('booking-success/') }}/" + response.order_id;
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
                        "color": "#b22d32"
                    },
                    "modal": {
                        "ondismiss": function() {
                            payBtn.prop("disabled", false).html(originalBtnText);
                            $.ajax({
                                url: "{{ url('payment-failed') }}",
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
                                        confirmButtonColor: '#b22d32',
                                        confirmButtonText: '<i class="fa-solid fa-receipt me-1"></i> View/Download Receipt',
                                        cancelButtonText: 'Try Again'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = "{{ url('booking-failed/') }}/" + response.order_id;
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
