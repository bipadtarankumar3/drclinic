@extends('admin.layouts.main')

@section('style')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

<style>
  
</style>

@endsection

@section('content')
<div class="container-fluid p-3 p-md-4">
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <div>
            <h3 class="fw-bold text-dark mb-1 d-flex align-items-center">
                <span class="rounded-3 p-2 bg-primary bg-opacity-10 text-primary me-2 d-inline-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                    <i class="mdi mdi-calendar-remove font-20"></i>
                </span>
                Doctor Unavailability & Leaves
            </h3>
            <p class="text-muted mb-0 font-13">Block dates or times when the doctor or clinic is unavailable for patient bookings.</p>
        </div>
    </div>
                    <div class="col-md-2">
                        {{-- <a href="{{ URL::to('admin/availability/availability_calander_list') }}">
                            <button class="btn btn-primary btn-sm text-white mb-0 me-0" type="button">
                                <i class="mdi mdi-eye me-1"></i> View Big Calendar
                            </button>
                            
                        </a> --}}
                    </div>
                </div>
            </div>
        
    
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                     <div id="calendar"></div>
                    </div>
           
                </div> 
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                    <h3>
                        Add Unavailability
                    </h3>
                    <form id="unavailabilityForm">
                        @csrf
                        <div class="mb-3">
                            <label for="date" class="form-label">Select Date</label>
                            <input type="date" class="form-control" id="date" name="date" onchange="getTimeSlots(this.value)" required>
                        </div>
                        <div id="timeSlots">
                            <select name="start_time_end_time[]" class="form-control time_slot" id="time_slot" multiple>
                                <option value="">Select Time</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary mt-3">Save</button>
                    </form>
                </div>
           
            </div> 
                </div>
             
    </div>  
</div>


@endsection

@section('js')

<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    selectable: true,
    editable: true,
    eventTimeFormat: {
        hour: '2-digit',
        minute: '2-digit',
        meridiem: true
    },
    customButtons: {
        myTodayButton: {
            text: 'Today',
            click: function () {
                calendar.today();
            }
        }
    },
    headerToolbar: {
        left: 'prev,next myTodayButton',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
    },
    dayHeaderFormat: { weekday: 'long' },

    eventContent: function(arg) {
        return {
            html: `<div style="font-size: 11px; color: white;">${arg.event.title}</div>`
        };
    },

    events: '{{ url("admin/availability/get_unavailable_dates") }}',

    // Store loaded events and apply red background
    datesSet: function () {
        setTimeout(() => {
            highlightCellsWithEvents();
        }, 700); // Delay a little to ensure events are attached
    }
});

calendar.render();

// 🔴 Function to highlight the full cell
function highlightCellsWithEvents() {
    const events = calendar.getEvents();

    document.querySelectorAll('.fc-daygrid-day').forEach(dayCell => {
        const dateStr = dayCell.getAttribute('data-date'); // format: 'YYYY-MM-DD'

        const hasEvent = events.some(event => {
            return event.startStr.startsWith(dateStr);
        });

        if (hasEvent) {
            dayCell.style.backgroundColor = 'red';
            dayCell.style.color = 'white';
        }
    });
}




    // Remove time slot
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-time-slot')) {
            event.target.parentElement.remove();
        }
    });

    // Handle form submission
    document.getElementById('unavailabilityForm').addEventListener('submit', function(event) {
        event.preventDefault();

        let formData = new FormData(this);

        fetch('{{ url("admin/availability/mark_unavailable") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(response => response.json())
          .then(data => {
            alert(data.message);
            location.reload();
          }).catch(error => console.error('Error:', error));
    });
});


function getTimeSlots(date) {
    $.ajax({
        url: '{{ url("admin/availability/get_time_slots") }}',
        type: 'GET',
        data: { date: date },
        success: function(response) {
            let timeSlotDropdown = $('#time_slot');
            timeSlotDropdown.empty(); // Clear existing options

            timeSlotDropdown.html(response);

            // Reinitialize Select2 after updating options
            timeSlotDropdown.select2({
                placeholder: "Select Time Slots",
                allowClear: true
            });
        }
    });
}

</script>
@endsection