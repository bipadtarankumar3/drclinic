@extends('admin.layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h6 class="py-3 mb-4"><span class="text-muted fw-light">Admin /</span> Time Slots</h6>

        <div class="mb-2">
            <div class="row">
                <div class="col-md-10">
                    <h5 class="mb-0">{{ $title }}</h5>
                </div>
                <div class="col-md-2">
                    <a href="{{ URL::to('admin/time_slot/time_slot_add') }}">
                        <button class="btn btn-primary btn-sm text-white mb-0 me-0" type="button">
                            <i class="mdi mdi-account-plus"></i> Add Time Slot
                        </button>
                    </a>
                </div>
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
