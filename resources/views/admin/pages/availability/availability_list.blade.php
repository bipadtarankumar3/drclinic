@extends('admin.layouts.main')

@section('style')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

<style>
/* FullCalendar Modern Redesign */
#calendar {
  min-height: 600px;
}
.fc {
  font-family: inherit;
}
.fc .fc-toolbar.fc-header-toolbar {
  margin-bottom: 1.25rem;
  flex-wrap: wrap;
  gap: 10px;
}
.fc .fc-toolbar-title {
  font-size: 1.3rem !important;
  font-weight: 800 !important;
  color: #0f172a;
  letter-spacing: -0.3px;
}
.fc .fc-button {
  background: #ffffff !important;
  border: 1.5px solid #cbd5e1 !important;
  color: #334155 !important;
  font-weight: 700 !important;
  font-size: 12.5px !important;
  padding: 6px 14px !important;
  border-radius: 8px !important;
  box-shadow: none !important;
  text-transform: capitalize;
  transition: all 0.15s ease;
}
.fc .fc-button:hover {
  background: #f1f5f9 !important;
  border-color: #94a3b8 !important;
  color: #0f172a !important;
}
.fc .fc-button-primary.fc-button-active,
.fc .fc-button-primary:active {
  background: var(--theme-primary, #059669) !important;
  border-color: var(--theme-primary, #059669) !important;
  color: #ffffff !important;
  box-shadow: 0 2px 8px var(--theme-primary-glow, rgba(5, 150, 105, 0.3)) !important;
}
.fc-theme-standard th {
  background: #f8fafc;
  padding: 10px 0 !important;
  font-size: 12.5px;
  font-weight: 700;
  color: #475569;
  border-color: #e2e8f0 !important;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}
.fc-col-header-cell a {
  color: #475569 !important;
  text-decoration: none !important;
  font-weight: 700;
}
.fc-theme-standard td, 
.fc-theme-standard .fc-scrollgrid {
  border-color: #e2e8f0 !important;
}
.fc-daygrid-day-number {
  font-size: 13px;
  font-weight: 700;
  color: #475569;
  padding: 6px 8px !important;
  text-decoration: none !important;
}
.fc-day-today {
  background: var(--theme-primary-subtle, rgba(5, 150, 105, 0.05)) !important;
}
.fc-day-today .fc-daygrid-day-number {
  color: var(--theme-primary, #059669) !important;
  font-weight: 800 !important;
}
.fc-event {
  border-radius: 6px !important;
  padding: 3px 6px !important;
  font-size: 11.5px !important;
  font-weight: 700 !important;
  cursor: pointer;
  border: none !important;
  background: linear-gradient(135deg, #ef4444, #dc2626) !important;
  box-shadow: 0 2px 4px rgba(239, 68, 68, 0.25) !important;
  transition: transform 0.15s ease;
}
.fc-event:hover {
  transform: translateY(-1px);
  filter: brightness(1.05);
}
.fc-event-title {
  color: #ffffff !important;
  font-weight: 600 !important;
}

/* Select2 Container */
.select2-container .select2-selection--multiple {
  min-height: 42px;
  border: 1.5px solid #cbd5e1 !important;
  border-radius: 8px !important;
  padding: 3px 8px;
}
.select2-container--default.select2-container--focus .select2-selection--multiple {
  border-color: var(--theme-primary, #059669) !important;
  box-shadow: 0 0 0 3px var(--theme-primary-focus, rgba(5, 150, 105, 0.15)) !important;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice {
  background: var(--theme-primary-subtle, #ecfdf5) !important;
  border: 1px solid var(--theme-primary-border, #a7f3d0) !important;
  color: var(--theme-primary, #059669) !important;
  font-weight: 700;
  font-size: 12px;
  border-radius: 6px;
  padding: 2px 8px;
}
</style>
@endsection

@section('content')
<div class="content-wrapper">
  <!-- Page Header -->
  <div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="gap: 12px;">
    <div class="d-flex align-items-center" style="gap: 12px;">
      <div class="d-flex align-items-center justify-content-center shadow-sm" style="width: 44px; height: 44px; border-radius: 12px; background: var(--theme-primary-gradient, linear-gradient(135deg, #059669, #10b981)); color: #ffffff; font-size: 22px; box-shadow: 0 4px 12px var(--theme-primary-glow, rgba(5, 150, 105, 0.25));">
        <i class="mdi mdi-calendar-remove-outline"></i>
      </div>
      <div>
        <h3 class="font-weight-bold text-dark mb-0" style="letter-spacing: -0.4px;">
          Doctor Unavailability &amp; Leaves
        </h3>
        <p class="text-muted font-13 mb-0">Block dates or specific time slots when the doctor or clinic is unavailable for patient bookings.</p>
      </div>
    </div>

    <div>
      <span class="badge" style="background: var(--theme-primary-subtle, #ecfdf5); color: var(--theme-primary, #059669); border: 1px solid var(--theme-primary-border, #a7f3d0); font-size: 12px; font-weight: 700; padding: 6px 14px; border-radius: 20px;">
        <span style="display: inline-block; width: 7px; height: 7px; border-radius: 50%; background: var(--theme-primary, #059669); margin-right: 6px;"></span>
        <i class="mdi mdi-shield-check-outline mr-1"></i> Patient Booking Guard
      </span>
    </div>
  </div>

  @if(session('success'))
  <div class="alert alert-success alert-dismissible fade show rounded-4 p-3 mb-4 shadow-sm" role="alert" style="border: 1px solid #a7f3d0; background: #ecfdf5; color: #065f46;">
    <div class="d-flex align-items-center">
      <i class="mdi mdi-check-circle-outline font-22 mr-2" style="margin-right: 8px;"></i>
      <strong>{{ session('success') }}</strong>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  <div class="row g-4">
    <!-- Left Column: Calendar (8 Columns) -->
    <div class="col-lg-8 col-xl-8 mb-4">
      <div class="card border-0 shadow-sm rounded-4 h-100" style="border-radius: 16px; border: 1.5px solid #e2e8f0; background: #ffffff;">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center flex-wrap mb-3 pb-2 border-bottom" style="border-color: #f1f5f9 !important; gap: 10px;">
            <div class="d-flex align-items-center">
              <i class="mdi mdi-calendar-month text-primary mr-2" style="font-size: 20px; margin-right: 8px;"></i>
              <h5 class="font-weight-bold text-dark mb-0 font-16">Availability Calendar</h5>
            </div>

            <div class="d-flex align-items-center" style="gap: 14px;">
              <span class="d-inline-flex align-items-center font-12 text-muted">
                <span style="width: 10px; height: 10px; border-radius: 50%; background: #ef4444; margin-right: 6px; display: inline-block;"></span> Blocked / Leave
              </span>
              <span class="d-inline-flex align-items-center font-12 text-muted">
                <span style="width: 10px; height: 10px; border-radius: 50%; background: var(--theme-primary, #059669); margin-right: 6px; display: inline-block;"></span> Today
              </span>
            </div>
          </div>

          <div id="calendar"></div>
        </div>
      </div>
    </div>

    <!-- Right Column: Form & Active Leaves (4 Columns) -->
    <div class="col-lg-4 col-xl-4 mb-4">
      <!-- 1. Mark Unavailability Form -->
      <div class="card border-0 shadow-sm rounded-4 mb-4" style="border-radius: 16px; border: 1.5px solid #e2e8f0; background: #ffffff;">
        <div class="card-body p-4">
          <div class="d-flex align-items-center mb-3 pb-2 border-bottom" style="border-color: #f1f5f9 !important;">
            <div class="d-flex align-items-center justify-content-center shadow-sm" style="width: 34px; height: 34px; border-radius: 8px; background: var(--theme-primary-subtle, #ecfdf5); color: var(--theme-primary, #059669); font-size: 18px; margin-right: 10px;">
              <i class="mdi mdi-plus-circle-outline"></i>
            </div>
            <div>
              <h5 class="font-weight-bold text-dark mb-0 font-15">Mark Unavailability</h5>
              <small class="text-muted">Close slots to prevent patient bookings.</small>
            </div>
          </div>

          <form id="unavailabilityForm">
            @csrf
            <div class="mb-3">
              <label for="date" class="form-label font-weight-bold text-dark font-13">Select Date</label>
              <div class="input-group">
                <span class="input-group-text bg-light text-muted border-end-0"><i class="mdi mdi-calendar"></i></span>
                <input type="date" class="form-control" id="date" name="date" value="{{ date('Y-m-d') }}" onchange="getTimeSlots(this.value)" required style="border-radius: 8px; height: 42px;">
              </div>
            </div>

            <div class="mb-3">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <label class="form-label font-weight-bold text-dark font-13 mb-0">Select Time Slots</label>
                <div class="form-check mb-0">
                  <input class="form-check-input" type="checkbox" id="blockWholeDayCheck" onchange="toggleWholeDay(this)" style="cursor: pointer;">
                  <label class="form-check-label font-12 text-muted" for="blockWholeDayCheck" style="cursor: pointer; user-select: none;">
                    Entire Day
                  </label>
                </div>
              </div>

              <div id="timeSlotsContainer">
                <select name="start_time_end_time[]" class="form-control" id="time_slot" multiple style="width: 100%;">
                </select>
              </div>
              <small class="text-muted font-11 d-block mt-1" id="timeSlotsHelper">Leave empty or check "Entire Day" to close whole day.</small>
            </div>

            <div class="mb-4">
              <label for="remarks" class="form-label font-weight-bold text-dark font-13">Reason / Remarks (Optional)</label>
              <input type="text" class="form-control" id="remarks" name="remarks" placeholder="e.g. Personal Leave, Medical Conference" style="border-radius: 8px; height: 42px;">
            </div>

            <button type="submit" id="submitBtn" class="btn btn-primary w-100 font-weight-bold py-2 d-flex align-items-center justify-content-center" style="border-radius: 10px; font-size: 14px;">
              <i class="mdi mdi-lock-outline font-18 mr-2" style="margin-right: 6px;"></i> Block Selected Time
            </button>
          </form>
        </div>
      </div>

      <!-- 2. Recent Blocked Leaves List -->
      <div class="card border-0 shadow-sm rounded-4" style="border-radius: 16px; border: 1.5px solid #e2e8f0; background: #ffffff;">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom" style="border-color: #f1f5f9 !important;">
            <div class="d-flex align-items-center">
              <i class="mdi mdi-clock-alert-outline text-warning mr-2" style="font-size: 18px; margin-right: 8px;"></i>
              <h6 class="font-weight-bold text-dark mb-0 font-14">Active Leaves &amp; Blocked Slots</h6>
            </div>
            <span class="badge" style="background: #f1f5f9; color: #475569; font-weight: 700; border-radius: 10px; padding: 4px 10px;">{{ count($availabilities) }}</span>
          </div>

          <div style="max-height: 290px; overflow-y: auto;">
            @forelse($availabilities as $item)
            <div class="d-flex justify-content-between align-items-center p-2 mb-2 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
              <div>
                <div class="font-weight-bold text-dark font-13">
                  {{ \Carbon\Carbon::parse($item->from_date)->format('d M Y') }}
                </div>
                <div class="text-muted font-11">
                  @if($item->start_time && $item->end_time)
                    <span class="text-primary font-weight-bold">{{ \Carbon\Carbon::parse($item->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($item->end_time)->format('h:i A') }}</span>
                  @else
                    <span class="badge bg-danger bg-opacity-10 text-danger p-1" style="font-size: 10px; font-weight: 700;">Whole Day Closed</span>
                  @endif
                  @if($item->remarks)
                    <span class="ms-1 text-secondary">• {{ $item->remarks }}</span>
                  @endif
                </div>
              </div>
              <a href="{{ url('admin/availability/delete/' . $item->id) }}" onclick="return confirm('Remove this blocked date/slot and reopen bookings?')" class="btn btn-sm btn-outline-danger" style="border-radius: 6px; width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center; padding: 0;">
                <i class="mdi mdi-trash-can-outline font-14"></i>
              </a>
            </div>
            @empty
            <div class="text-center py-4 text-muted font-12">
              <i class="mdi mdi-calendar-check-outline font-28 d-block text-success mb-1" style="font-size: 32px;"></i>
              No leaves or blocked dates recorded.
            </div>
            @endforelse
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<script>
let calendar;

document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        selectable: true,
        editable: false,
        height: 640,
        aspectRatio: 1.5,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        dayHeaderFormat: { weekday: 'short' },
        events: '{{ url("admin/availability/get_unavailable_dates") }}',
        eventClick: function(info) {
            if (info.event.id) {
                if (confirm('Reopen bookings and delete unavailability for: "' + info.event.title + '"?')) {
                    window.location.href = '{{ url("admin/availability/delete") }}/' + info.event.id;
                }
            }
        },
        select: function(info) {
            document.getElementById('date').value = info.startStr;
            getTimeSlots(info.startStr);
        }
    });

    calendar.render();

    // Initialize Select2
    $('#time_slot').select2({
        placeholder: "Select Time Slots (Optional)",
        allowClear: true
    });

    // Initial load of time slots for default date
    getTimeSlots(document.getElementById('date').value);

    // Form Submission Handler
    document.getElementById('unavailabilityForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const btn = document.getElementById('submitBtn');
        const originalHtml = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true" style="margin-right: 6px;"></span> Saving...';

        let formData = new FormData(this);

        fetch('{{ url("admin/availability/mark_unavailable") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            window.location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to save unavailability. Please try again.');
            btn.disabled = false;
            btn.innerHTML = originalHtml;
        });
    });
});

function toggleWholeDay(checkbox) {
    const container = document.getElementById('timeSlotsContainer');
    const helper = document.getElementById('timeSlotsHelper');
    if (checkbox.checked) {
        $('#time_slot').val(null).trigger('change');
        container.style.opacity = '0.5';
        container.style.pointerEvents = 'none';
        helper.innerText = 'Whole day will be marked as completely closed.';
    } else {
        container.style.opacity = '1';
        container.style.pointerEvents = 'auto';
        helper.innerText = 'Select specific slots or leave empty for entire day.';
    }
}

function getTimeSlots(date) {
    $.ajax({
        url: '{{ url("admin/availability/get_time_slots") }}',
        type: 'GET',
        data: { date: date },
        success: function(response) {
            let timeSlotDropdown = $('#time_slot');
            timeSlotDropdown.empty();
            timeSlotDropdown.html(response);
            timeSlotDropdown.trigger('change');
        }
    });
}
</script>
@endsection