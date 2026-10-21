@extends('web.layouts.main')

@section('style')
<link rel="stylesheet" href="{{ URL::to('public/assets/web/css/appointment/appoint-style.css')}}">
<link rel="stylesheet" href="{{ URL::to('public/assets/web/css/appointment/appoint-responsive.css')}}">

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<style>

/* Big Calander */
.fc .fc-day-today {
    background-color: #000000 !important;
    color: #ffffff !important;
  }

  /* Optional: make sure any link inside also turns white */
  .fc .fc-day-today a {
    color: #ffffff !important;
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
    
    .fc-daygrid-day-selected {
        background-color: #8effc8  !important;
        color: white !important;
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
                <h2 class="text-danger text-center my-4" >Clinic is closed</h2>
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
    customButtons: {
        myTodayButton: {
            text: 'Today',
            click: function() {
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
