@extends('admin.layouts.main')

@section('content')
    <div class="container-fluid p-3 p-md-4">
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
            <div>
                <h3 class="fw-bold text-dark mb-1 d-flex align-items-center">
                    <span class="rounded-3 p-2 bg-primary bg-opacity-10 text-primary me-2 d-inline-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                        <i class="mdi mdi-clipboard-text-clock font-20"></i>
                    </span>
                    Patient Booking History & Records
                </h3>
                <p class="text-muted mb-0 font-13">Filter and review past and upcoming patient consultation bookings.</p>
            </div>
            <div>
                <a href="{{ url('admin/patient') }}" class="btn btn-outline-primary btn-sm font-weight-bold px-3 py-2 shadow-sm">
                    <i class="mdi mdi-calendar-today me-1"></i> Today's Schedule
                </a>
            </div>
        </div>

        <form action="{{ url('admin/booking_history') }}" method="GET">
            <div class="card my-4 border-0 shadow-sm rounded-4" style="border-radius: 16px; border: 1.5px solid #e2e8f0;">
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-3 col-sm-6">
                            <label class="font-11 font-weight-bold text-uppercase text-muted">Patient</label>
                            <select name="patient_id" class="form-select form-control" style="border-radius: 8px; height: 42px; font-size: 13.5px;">
                                <option value="">All Patients ({{ count($patients) }})</option>
                                @foreach ($patients as $patient)
                                    @php
                                        $pName = trim(($patient->first_name ?? '') . ' ' . ($patient->last_name ?? ''));
                                    @endphp
                                    <option value="{{ $patient->id }}" {{ request('patient_id') == $patient->id ? 'selected' : '' }}>
                                        {{ $pName ?: 'Patient #'.$patient->id }} {{ $patient->mobile_no ? '('.$patient->mobile_no.')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2 col-sm-6">
                            <label class="font-11 font-weight-bold text-uppercase text-muted">Mobile Number</label>
                            <input type="text" class="form-control" name="mobile_no" placeholder="e.g. 9833..." value="{{ request('mobile_no') }}" style="border-radius: 8px; height: 42px; font-size: 13.5px;">
                        </div>

                        <div class="col-md-2 col-sm-6">
                            <label class="font-11 font-weight-bold text-uppercase text-muted">Gender</label>
                            <select name="gender" class="form-select form-control" style="border-radius: 8px; height: 42px; font-size: 13.5px;">
                                <option value="">All Genders</option>
                                <option value="male" {{ strtolower(request('gender')) === 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ strtolower(request('gender')) === 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ strtolower(request('gender')) === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
        
                        <div class="col-md-2 col-sm-6">
                            <label class="font-11 font-weight-bold text-uppercase text-muted">From Date</label>
                            <input type="date" class="form-control" name="from_date" value="{{ request('from_date') }}" style="border-radius: 8px; height: 42px; font-size: 13px;">
                        </div>
        
                        <div class="col-md-3 col-sm-6 d-flex align-items-end justify-content-between gap-2">
                            <div class="flex-grow-1">
                                <label class="font-11 font-weight-bold text-uppercase text-muted">To Date</label>
                                <input type="date" class="form-control" name="to_date" value="{{ request('to_date') }}" style="border-radius: 8px; height: 42px; font-size: 13px;">
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary font-weight-bold px-3" style="border-radius: 8px; height: 42px;">
                                    <i class="mdi mdi-magnify me-1"></i> Filter
                                </button>
                            </div>
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

            <!-- Server-Side Pagination Bar -->
            <div class="card-footer bg-white border-top d-flex align-items-center justify-content-between flex-wrap gap-3 py-3 px-4" style="border-radius: 0 0 16px 16px;">
                <div class="d-flex align-items-center gap-2 text-muted font-13">
                    <span>Showing <strong>{{ $orders->firstItem() ?? 0 }}</strong> to <strong>{{ $orders->lastItem() ?? 0 }}</strong> of <strong>{{ $orders->total() }}</strong> entries</span>
                </div>
                <div class="server-pagination">
                    {{ $orders->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
        
</div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        $('#patient_history').DataTable({
            paging: false,
            info: false,
            searching: false,
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
        });
    });

    function deleteConfirmation(event, id) {
        event.preventDefault();
        if (confirm('Are you sure you want to delete this record?')) {
            window.location.href = '{{ url('admin/patient_history/delete') }}/' + id;
        }
    }
</script>
@endsection
