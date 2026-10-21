@extends('admin.layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h6 class="py-3 mb-4"><span class="text-muted fw-light">Admin /</span> Patient History</h6>

        <form action="{{ url('admin/booking_history') }}" method="GET">
            <div class="card my-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="patient_id">Patient</label>
                                <select name="patient_id" class="form-control">
                                    <option value="">Select Patient</option>
                                    @foreach ($patients as $patient)
                                        <option value="{{ $patient->id }}" {{ request('patient_id') == $patient->id ? 'selected' : '' }}>
                                            {{ $patient->first_name }}   {{ $patient->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="from_date">From Date</label>
                                <input type="date" class="form-control" name="from_date" value="{{ request('from_date') }}">
                            </div>
                        </div>
        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="to_date">To Date</label>
                                <input type="date" class="form-control" name="to_date" value="{{ request('to_date') }}">
                            </div>
                        </div>
        
                        <div class="col-md-2">
                            <br>
                            <button type="submit" class="btn btn-primary mt-3">Search</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        

        <div class="card p-4">
            <div class="table-responsive text-nowrap">
                <table class="table" id="patient_history">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Name</th>
                            <th>DOB</th>
                            <th>Gender</th>
                            <th>Age</th>
                            <th>Mobile No</th>
                            <th>Alt Mobile</th>
                            <th>Address</th>
                            <th>Problem</th>
                           
                            <th>Amount</th>
                            <th>Transaction Id</th>
                            <th>Payment Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($orders as $key => $order)
                        @php
                                // Convert from_time to hour for color logic
                                $hour = date('H', strtotime($order->from_time));
                                if ($hour < 12) {
                                    $timeClass = 'bg-warning'; // Morning
                                } elseif ($hour < 17) {
                                    $timeClass = 'bg-success'; // Afternoon
                                } else {
                                    $timeClass = 'bg-primary'; // Evening
                                }
                            @endphp
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($order->booking_date)->format('d/m/Y') }} </td>
                            <td><span class="badge {{ $timeClass }}">{{ $order->from_time }} - {{ $order->to_time }}</span></td>
                            <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                          
                            <td>{{ $order->dob }}</td>
                            <td>{{ $order->sex }}</td>
                            <td>{{ $order->age }}</td>
                            <td>{{ $order->mobile_no }}</td>
                            <td>{{ $order->alternate_mobile_no }}</td>
                            <td>{{ $order->address }}</td>
                            <td>{{ $order->patient_problem }}</td>
                            
                            <td>{{ $order->total_amount }}</td>
                            <td>#{{ $order->transaction_id }}</td>
                            <td>{{ \Carbon\Carbon::parse($order->payment_date)->format('d/m/Y') }}</td>
                            <td>
                                @php
                                    $statusClass = match(strtolower($order->status)) {
                                        'pending' => 'badge bg-warning text-dark',
                                        'completed' => 'badge bg-success',
                                        'cancelled', 'canceled' => 'badge bg-danger',
                                        'processing' => 'badge bg-info text-dark',
                                        default => 'badge bg-secondary'
                                    };
                                @endphp
                                <span class="{{ $statusClass }}">{{ ucfirst($order->status) }}</span>
                            </td>
                            
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            &#x22EE;
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="{{ url('admin/booking_details/'.$order->id) }}">Payments Details</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ url('admin/patient-history/status-change/'.$order->id) }}">Confirm booking</a>
                                            </li>
                                            <li><a class="dropdown-item text-danger" href="javascript:void(0);" onclick="deleteConfirmation(event, {{ $order->id }});">Delete</a></li>
                                        
                                        </ul>
                                    </div>
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
        $('#patient_history').DataTable(
            {
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'csvHtml5',
                text: 'Export CSV',
                className: 'btn btn-sm btn-primary',
                title: 'Appointment Data',
                exportOptions: {
                    columns: ':visible'
                }
            }
        ]
    }
        );
    });

    function deleteConfirmation(event, id) {
        event.preventDefault();
        if (confirm('Are you sure you want to delete this record?')) {
            window.location.href = '{{ url('admin/patient_history/delete') }}/' + id;
        }
    }
</script>
@endsection
