@extends('admin.layouts.main')

@section('content')
    <div class="container-fluid p-3 p-md-4">
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
            <div>
                <h3 class="fw-bold text-dark mb-1 d-flex align-items-center">
                    <span class="rounded-3 p-2 bg-primary bg-opacity-10 text-primary me-2 d-inline-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                        <i class="mdi mdi-clock-time-four font-20"></i>
                    </span>
                    Clinic Consultation Time Slots
                </h3>
                <p class="text-muted mb-0 font-13">Configure morning, afternoon, and evening booking slots for patient appointments.</p>
            </div>
            <div>
                <a href="{{ URL::to('admin/time_slot/time_slot_add') }}" class="btn btn-primary btn-sm font-weight-bold px-3 py-2 shadow-sm text-white">
                    <i class="mdi mdi-plus-circle me-1"></i> Add New Slot
                </a>
            </div>
        </div>

        <div class="card p-4">
            <div class="table-responsive text-nowrap">
                <table class="table" id="patient_history">
                    <thead>
                        <tr>
                            <th>Sl</th>
                          
                            <th>Day of week</th>
                            <th>Open From</th>
                            <th>Close From</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($timeSlots as $key => $slot)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                
                                <td>
                                    @switch($slot->day_of_week)
                                        @case(1)
                                            Monday
                                            @break
                                        @case(2)
                                            Tuesday
                                            @break
                                        @case(3)
                                            Wednesday
                                            @break
                                        @case(4)
                                            Thursday
                                            @break
                                        @case(5)
                                            Friday
                                            @break
                                        @case(6)
                                            Saturday
                                            @break
                                        @case(7)
                                            Sunday
                                            @break
                                    @endswitch
                                </td>
                                
                                <td>{{ date('h:i A', strtotime($slot->from_time)) }}</td>
                                <td>{{ date('h:i A', strtotime($slot->to_time)) }}</td>
                                <td>
                                    <label class="badge {{ $slot->status == 'active' ? 'badge-success' : 'badge-danger' }}">
                                        {{ ucfirst($slot->status) }}
                                    </label>
                                </td>
                                <td>
                                    <a href="{{ url('admin/time_slot/edit/' . $slot->id) }}" class="text-primary">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <a href="{{ url('admin/time_slot/delete/' . $slot->id) }}" 
                                       onclick="return deleteConfirmation(event, '{{ $slot->id }}')" 
                                       class="text-danger ms-2">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>

$(document).ready(function () {
        $('#patient_history').DataTable(  {
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'csvHtml5',
                text: 'Export CSV',
                className: 'btn btn-sm btn-primary',
                title: 'Time Slot Lists',
                exportOptions: {
                    columns: ':visible'
                }
            }
        ]
    });
    });
    function deleteConfirmation(event, slotId) {
        event.preventDefault();
        if (confirm('Are you sure you want to delete this time slot?')) {
            window.location.href = '{{ url('admin/time_slot/delete') }}/' + slotId;
        }
    }
</script>
@endsection
