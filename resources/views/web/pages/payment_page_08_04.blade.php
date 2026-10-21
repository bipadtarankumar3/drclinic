@extends('web.layouts.main')

@section('style')
<link rel="stylesheet" href="{{ URL::to('public/assets/web/css/appointment/appoint-style.css')}}">
<link rel="stylesheet" href="{{ URL::to('public/assets/web/css/appointment/appoint-responsive.css')}}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<style>
    .term_and_condition_box {
        max-height: 130px;
        overflow-y: auto;
        padding: 10px;
        border: 1px solid #ccc;
        background-color: #fff;
        transition: background-color 0.3s ease;
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
                                            <div class="col-md-4">
                                                <label class="form-label">First Name <span style="color: red">*</span></label>
                                                <input type="text" name="first_name" placeholder="First Name" required class="form-control">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Last Name <span style="color: red">*</span></label>
                                                <input type="text" name="last_name" placeholder="Last Name" required class="form-control">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">D.O.B (Date of Birth)</label>
                                                <input type="date" name="dob"  class="form-control">
                                                <small id="dob-error" class="text-danger"></small>
                                            </div>
                                        </div>
                                        <div class="row">
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
                                                <input type="number" name="age" placeholder="Age" class="form-control" readonly>
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
                                            <p style="color: green">₹ {{ number_format(isset($setting) ? $setting->pay_additional_amount : 0, 2) }}</p>
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
                    <div class="modal fade" id="termsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog  modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="termsModalLabel">Terms & Conditions</h5>
                                    {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                                </div>
                                <div class="modal-body">
                                    <p>{{ isset($setting) ? $setting->payment_terms_and_condition : 'No terms available.' }}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Accept</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <script>
                        document.getElementById("terms").addEventListener("change", function() {
                            const payButton = document.getElementById("pay-button");
                            const termsError = document.getElementById("terms-error");
                            
                            if (this.checked) {
                                payButton.removeAttribute("disabled");
                                termsError.classList.add("d-none");
                                $('#termsModal').modal('show');
                            } else {
                                payButton.setAttribute("disabled", "true");
                                termsError.classList.remove("d-none");
                                $('#termsModal').modal('hide');
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

<script>
document.addEventListener("DOMContentLoaded", function () {
    const termsBox = document.querySelector(".term_and_condition_box");
    const payButtonContainer = document.querySelector(".pay-button-container");
    const payButton = document.getElementById("pay-button");
    const termsCheckbox = document.getElementById("terms");

    // if (!termsBox || !payButtonContainer  || !termsCheckbox) {
    //     console.error("Some required elements are missing from the page.");
    //     return;
    // }

    // Enable Pay button only when Terms checkbox is checked
    termsCheckbox.addEventListener("change", function () {
        if (this.checked) {
            payButton.disabled = false;
            payButtonContainer.style.display = "block";
        } else {
            payButton.disabled = true;
            payButtonContainer.style.display = "none";
        }
    });

 
});

$(document).ready(function () {

// Allow only numbers in mobile fields
$("input[name='mobile'], input[name='alternate_mobile']").on("input", function () {
    this.value = this.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
});

// Auto-calculate age when DOB is selected
$("input[name='dob']").on("change", function () {
    let dob = new Date($(this).val());
    let today = new Date();
    let age = today.getFullYear() - dob.getFullYear();

    // Adjust age if birthday hasn't occurred this year
    let monthDiff = today.getMonth() - dob.getMonth();
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
        age--;
    }

    if (age >= 0) {
        $("input[name='age']").val(age);
    } else {
        $("input[name='dob']").val(""); // Clear invalid DOB
        $("input[name='age']").val("");
        $("#dob-error").text("Please select a valid Date of Birth.");
    }
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
    let dob = $("input[name='dob']").val();
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

    $.ajax({
        url: "{{ url('generate-order') }}", // Backend route for order creation
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            amount: amount
        },
        success: function(response) {
            if (response.success) {
                let options = {
                    "key": "{{ isset($setting) ? $setting->pay_key : '' }}", // Razorpay Key from .env
                    "amount": response.amount, // Amount in paise
                    "currency": "INR",
                    "name": "Appointment Booking",
                    "description": "Payment for appointment booking",
                    "image": "{{ URL::to('public/assets/web/logo.png') }}",
                    "order_id": response.order_id, // Order ID from Razorpay
                    "handler": function(paymentResponse) {
                        // Payment Success
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
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Payment Successful! Booking confirmed.',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "{{ url('booking-success/') }}/" + response.order_id;
                                    }
                                });

                            }
                        }).fail(function() {
                            alert("Something went wrong. Please try again.");
                        });
                    },
                    "prefill": {
                        "name": name,
                        "email": email,
                        "contact": mobile_no
                    },
                    "theme": {
                        "color": "#3399cc"
                    },
                    "modal": {
                        "ondismiss": function() {
                            // Payment Cancelled
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
                                success: function(data) {
                                    alert("Payment was cancelled.");
                                }
                            });
                        }
                    }
                };

                let rzp1 = new Razorpay(options);
                rzp1.open();
            } else {
                alert("Something went wrong. Please try again.");
            }
        }
    });
}



</script>

@endsection
