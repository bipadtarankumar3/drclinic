@extends('web.layouts.main')

@section('style')
<link rel="stylesheet" href="{{ URL::to('public/assets/web/css/appointment/appoint-style.css')}}">
<link rel="stylesheet" href="{{ URL::to('public/assets/web/css/appointment/appoint-responsive.css')}}">

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<style>

/* Big Calander */
  .fc .fc-daygrid-day.fc-daygrid-day-selected,
  .fc-daygrid-day-selected,
  .fc .fc-day-today.fc-daygrid-day-selected {
    background-color: #b22d32 !important;
    color: #ffffff !important;
  }

  .fc .fc-daygrid-day.fc-daygrid-day-selected a,
  .fc-daygrid-day-selected a,
  .fc .fc-day-today.fc-daygrid-day-selected a,
  .fc .fc-daygrid-day.fc-daygrid-day-selected .fc-daygrid-day-number,
  .fc-daygrid-day-selected .fc-daygrid-day-number {
    color: #ffffff !important;
    font-weight: 600;
  }

  .fc .fc-day-today {
    background-color: #f7b2b6 !important;
    color: #8b1e22 !important;
  }

  .fc .fc-day-today a,
  .fc .fc-day-today .fc-daygrid-day-number {
    color: #8b1e22 !important;
    font-weight: 700;
  }

  .fc-day-past {
    cursor: not-allowed;
    opacity: 0.6; /* Optional: make it look more "disabled" */
  }

/* Big Calander */



    .time-slot-badge {
        display: inline-block;
        padding: 8px 12px;
        margin: 5px;
        border-radius: 20px;
        font-size: 14px;
        cursor: pointer;
        transition: 0.3s;
    }

    .time-slot-badge:hover {
        opacity: 0.8;
    }

    .selected {
        background-color: #3f894a !important;
        color: #fff !important;
        font-weight: bold;
    }

    .blue { background-color: #38bdf8; color: #fff; }
    .marun {
    background-color: #294461 !important;
    color: #fff !important;
    border: 3px solid #b22d32 !important;
}



    .clinic-closed-message {
    background-color: #fff3f3;
    border: 1px solid #f5c6cb;
    border-left: 6px solid #d9534f;
    padding: 20px;
    border-radius: 8px;
    color: #a94442;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    max-width: 600px;
    margin: 0 auto;
}

.clinic-closed-message .closed-icon {
    font-size: 40px;
    color: #d9534f;
}

/* Modern Announcement Marquee */
.modern-notice-marquee {
    display: flex;
    align-items: center;
    background: linear-gradient(135deg, #fff7f7 0%, #fff1f2 100%);
    border: 1px solid #fecdd3;
    border-left: 5px solid #b22d32;
    border-radius: 10px;
    padding: 7px 14px;
    box-shadow: 0 4px 14px rgba(178, 45, 50, 0.07);
    overflow: hidden;
    position: relative;
}

.notice-badge {
    display: inline-flex;
    align-items: center;
    background: linear-gradient(135deg, #b22d32 0%, #8f1e22 100%);
    color: #ffffff;
    font-size: 12.5px;
    font-weight: 700;
    padding: 6px 14px;
    border-radius: 6px;
    white-space: nowrap;
    z-index: 2;
    box-shadow: 0 2px 8px rgba(178, 45, 50, 0.25);
    letter-spacing: 0.4px;
    text-transform: uppercase;
}

.notice-pulse {
    width: 8px;
    height: 8px;
    background-color: #4ade80;
    border-radius: 50%;
    margin-right: 8px;
    display: inline-block;
    box-shadow: 0 0 0 0 rgba(74, 222, 128, 0.7);
    animation: noticePulse 1.8s infinite;
}

@keyframes noticePulse {
    0% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(74, 222, 128, 0.7);
    }
    70% {
        transform: scale(1);
        box-shadow: 0 0 0 6px rgba(74, 222, 128, 0);
    }
    100% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(74, 222, 128, 0);
    }
}

.notice-track {
    flex: 1;
    overflow: hidden;
    white-space: nowrap;
    position: relative;
    padding-left: 15px;
    mask-image: linear-gradient(to right, transparent, black 15px, black 95%, transparent);
    -webkit-mask-image: linear-gradient(to right, transparent, black 15px, black 95%, transparent);
}

.notice-scroll {
    display: inline-block;
    white-space: nowrap;
    font-size: 14.5px;
    font-weight: 600;
    color: #1e293b;
    padding-left: 100%;
    animation: noticeMarqueeScroll 28s linear infinite;
}

.notice-track:hover .notice-scroll {
    animation-play-state: paused;
}

@keyframes noticeMarqueeScroll {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-100%);
    }
}

.notice-divider {
    margin: 0 16px;
    color: #b22d32;
    font-size: 16px;
    vertical-align: middle;
}

.notice-link {
    color: #b22d32;
    font-weight: 700;
    text-decoration: underline;
    text-underline-offset: 2px;
    transition: color 0.2s ease;
}

.notice-link:hover {
    color: #183e66;
    text-decoration: underline;
}

@media (max-width: 768px) {
    .modern-notice-marquee {
        flex-direction: column;
        align-items: flex-start;
        padding: 8px 10px;
    }
    .notice-badge {
        margin-bottom: 6px;
        font-size: 11px;
        padding: 4px 10px;
    }
    .notice-track {
        width: 100%;
        padding-left: 0;
    }
    .notice-scroll {
        font-size: 13px;
        animation-duration: 22s;
    }
}

</style>

@endsection

@section('banner')
<div class="banner-2">
    <div class="banner-2-img">
        <img src="{{ URL::to('public/assets/web/appointment/Banner.png')}}" alt="">
    </div>
    <div class="ban-2-text">
        <h1>Book An Appointment</h1>
    </div>
</div>
@endsection

@section('content')
<div class="container">

    <!-- Modern Notice Marquee -->
    <div class="modern-notice-marquee mt-4 mb-3">
        <div class="notice-badge">
            <span class="notice-pulse"></span>
            <i class="fa-solid fa-bullhorn me-1"></i> Important Notice
        </div>
        <div class="notice-track" title="Hover to pause">
            <div class="notice-scroll">
                @if(isset($setting) && !empty($setting->frontend_notice))
                    <span>{{ $setting->frontend_notice }}</span>
                    <span class="notice-divider">&bull;</span>
                @endif
                <span>For any payment-related issues, please contact our helpline at <a href="tel:+919631775097" class="notice-link"><i class="fa-solid fa-phone me-1"></i>+91-9631775097</a> / <a href="tel:+919341284362" class="notice-link"><i class="fa-solid fa-phone me-1"></i>+91-9341284362</a> or email us at <a href="mailto:royneurocare@gmail.com" class="notice-link"><i class="fa-solid fa-envelope me-1"></i>royneurocare@gmail.com</a></span>
                <span class="notice-divider">&bull;</span>
                <span>Roy Neuro Care &bull; Complete Brain & Spine Centre, Bariatu, Ranchi</span>
                <span class="notice-divider">&bull;</span>
                <span>For any payment-related issues, please contact our helpline at <a href="tel:+919631775097" class="notice-link"><i class="fa-solid fa-phone me-1"></i>+91-9631775097</a> / <a href="tel:+919341284362" class="notice-link"><i class="fa-solid fa-phone me-1"></i>+91-9341284362</a> or email us at <a href="mailto:royneurocare@gmail.com" class="notice-link"><i class="fa-solid fa-envelope me-1"></i>royneurocare@gmail.com</a></span>
            </div>
        </div>
    </div>

    <div id="step-1">

        @if (isset($setting) && $setting->payment_permission_status == 'yes') 

        @if (session('error'))
    <div id="error-alert" style="position: relative; background-color: #f8d7da; color: #721c24; padding: 12px 40px 12px 12px; border-radius: 5px; margin-top: 10px;">
        {{ session('error') }}
        <button onclick="document.getElementById('error-alert').style.display='none'"
                style="position: absolute; top: 8px; right: 10px; background: none; border: none; font-size: 20px; line-height: 20px; color: #721c24; cursor: pointer;">
            &times;
        </button>
    </div>
@endif



        <form action="{{ url('book_appointment') }}" method="get" id="booking-form">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row my-4">
                <div class="col-md-6">
                    <div id="calendar"></div>
                    <input type="hidden" id="selected-date" name="booking_date">
                </div>
                <div class="col-md-6">
                    <div id="step-2" style="display: none;">
                        <h2>Select Time Slot</h2>
                        <hr>
                        <div id="time-slot-container" class="d-flex flex-wrap"></div>
    
                        <input type="hidden" id="selected-time-slot" name="time_slot_id">
    
                        <div class="row text-right mt-4" >
                            <div class="col-md-12">
                                <p>
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                    <span class="text-danger">Note:</span>  You can only book an appointment for a maximum of 2 in a single time slot.
                                </p>
                            </div>
                        </div>
                        <div class="row text-right mt-4" >
                            <div class="col-md-12">
                                
                                <button id="SubmitForBooking"  class="btn btn-warning my-4 d-none" type="submit">Submit For Booking</button>
                            </div>
                        </div>
                    </div>
                    <div class="doctor-unavailable " style="display: none;">
                        <h2 class="text-danger text-center my-4" >Doctor is not available</h2>
                    </div>

                </div>
            </div>
        </form>
        @else
        <div class="clinic-closed-message text-center my-5">
            <div class="closed-icon mb-3">
                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
            </div>
            <h2>Clinic is Currently Closed</h2>
            <p>Please check back later or contact the clinic for more information.</p>
        </div>
        
        @endif

       
        
    </div>  
</div>
@endsection

@section('js')

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let selectedTimeSlot = null;
        let selectedDate = null;
        let calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
    initialView: 'dayGridMonth',
    selectable: true,
    headerToolbar: {
        left: 'myTodayButton',
        center: 'title',
        right: 'prev,next'
    },
    customButtons: {
        myTodayButton: {
            text: 'Today', // Capital "T"
            click: function () {
                calendar.today();
            }
        }
    },
    validRange: {
        end: new Date(new Date().setMonth(new Date().getMonth() + 3)) // Allow all past dates but restrict selection to 3 months ahead
    },
    dateClick: function(info) {
        if (info.date < new Date().setHours(0, 0, 0, 0)) {
         
            return;
        }

        document.querySelectorAll(".fc-daygrid-day").forEach(day => day.classList.remove("fc-daygrid-day-selected"));
        info.dayEl.classList.add("fc-daygrid-day-selected");

        document.getElementById("step-2").style.display = "block";
        selectedDate = info.dateStr;
        document.getElementById("selected-date").value = selectedDate;
        checkAvailability(selectedDate);
    }
});


calendar.render();


        // function loadTimeSlots(selectedDate) {
        //     let url = "{{ url('get-timeslots') }}";
        //     fetch(url)
        //         .then(response => response.json())
        //         .then(data => populateTimeSlots(data));
        // }

        function checkAvailability(selectedDate) {
            $.ajax({
                url: "{{ url('check_availability') }}",
                type: "POST",
                data: {
                    date: selectedDate,
                    _token: "{{ csrf_token() }}" // Include CSRF token for Laravel
                },
                success: function(response) {
                    console.log(response);
                    if (response.length === 0) {
                        $("#step-2").hide(); // Show doctor not available message
                        $(".doctor-unavailable").show(); // Show doctor not available message
                        $("#timeSlotsContainer").html(""); // Clear previous slots
                    } else {
                        $("#step-2").show();
                        $(".doctor-unavailable").hide(); // Hide the message if slots are available
                        populateTimeSlots(response); // Function to populate slots
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        }

        function formatTimeTo12Hour(time) {
    let [hours, minutes] = time.split(":").map(Number);
    let period = hours >= 12 ? "PM" : "AM";
    hours = hours % 12 || 12; // Convert 0 to 12 for AM
    return `${hours}:${minutes.toString().padStart(2, "0")} ${period}`;
}

function populateTimeSlots(data) {
    let timeSlotContainer = document.getElementById("time-slot-container");
    timeSlotContainer.innerHTML = "";

    data.forEach((slot, index) => {
        let span = document.createElement("span");
        span.classList.add("time-slot-badge", "marun");

        // Convert from_time and to_time to 12-hour format
        let formattedFromTime = formatTimeTo12Hour(slot.from_time);
        let formattedToTime = formatTimeTo12Hour(slot.to_time);

        span.textContent = `${formattedFromTime} - ${formattedToTime}`;
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
            event.preventDefault(); // Prevent default form submission

            // Get form values
            let bookingDate = $("#selected-date").val();
            let timeSlotId = $("#selected-time-slot").val();

            // Encode values in Base64
            let encodedDate = btoa(bookingDate);
            let encodedTimeSlot = btoa(timeSlotId);

            // Modify the action URL with encoded values
            let actionUrl = `{{ url('book_appointment') }}?booking_date=${encodedDate}&time_slot_id=${encodedTimeSlot}`;

            // Redirect to the new URL (GET request)
            window.location.href = actionUrl;
        });
    });

</script>

@endsection
