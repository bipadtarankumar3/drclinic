@extends('admin.layouts.main')

@section('style')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

<style>
  
</style>

@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h6 class="py-3 mb-4"><span class="text-muted fw-light">Admin /</span> Unavailability Management</h6>

    
            <div class="mb-2">
                <div class="row">
                    <div class="col-md-10">
                        <h5 class="mb-0">{{ $title }}</h5>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ URL::to('admin/availability') }}">
                            <button class="btn btn-primary btn-sm text-white mb-0 me-0" type="button">
                                <i class="mdi mdi-eye me-1"></i> View Week Calendar
                            </button>
                            
                        </a>
                    </div>
                </div>
            </div>
        
    
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                     <div id="calendar"></div>
                    </div>
           
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
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
    
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth', // 👈 Big calendar view
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
                    click: function() {
                        calendar.today();
                    }
                }
            },
            headerToolbar: {
                left: 'prev,next myTodayButton',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay' // 👈 allow view switching
            },
            events: '{{ url("admin/availability/get_big_calander_unavailable_dates") }}'
        });
    
        calendar.render();
    });
    </script>
    
@endsection