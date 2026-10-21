@extends('admin.layouts.main')

@section('content')
    <div class="container-fluid p-3 p-md-4">
        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
            <div>
                <h3 class="fw-bold text-dark mb-1 d-flex align-items-center">
                    <span class="rounded-3 p-2 bg-primary bg-opacity-10 text-primary me-2 d-inline-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                        <i class="mdi mdi-folder-account font-20"></i>
                    </span>
                    Patient Master Records
                </h3>
                <p class="text-muted mb-0 font-13">View registered patient accounts, previous consultations, and patient history.</p>
            </div>
            <div>
                <a href="{{ url('admin/patient') }}" class="btn btn-outline-primary btn-sm font-weight-bold px-3 py-2 shadow-sm">
                    <i class="mdi mdi-calendar-today me-1"></i> Today's Appointments
                </a>
            </div>
        </div>

        <form action="{{ url('admin/history_of_customer') }}" method="GET">
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
                                            {{ $patient->name }}
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
                            <th>Created At</th>
                            <th>Patient</th>
                            <th>DOB</th>
                            <th>Gender</th>
                            <th>Age</th>
                            <th>Mobile no</th>
                            <th>Alternate mobile/whatsapp no</th>
                            <th>Permanent Address</th>
                            <th>Patient problem</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($patients_lists as $key => $order)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, h:i A') }}</td>

                            <td>
                                <a  href="{{ url('admin/patient-history/view/'.$order->id) }}">
                                    {{ $order->first_name }} {{ $order->last_name }}
                                </a>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($order->dob)->format('d/m/Y') }}</td>
                            <td>{{ $order->sex }}</td>
                            <td>{{ $order->age }}</td>
                            <td>{{ $order->mobile_no }}</td>
                            <td>{{ $order->alternate_mobile_no }}</td>
                            <td>{{ $order->address }}</td>
                            <td>{{ $order->patient_problem }}</td>
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Server-Side Pagination Bar -->
            <div class="card-footer bg-white border-top d-flex align-items-center justify-content-between flex-wrap gap-3 py-3 px-4" style="border-radius: 0 0 16px 16px;">
                <div class="d-flex align-items-center gap-2 text-muted font-13">
                    <span>Showing <strong>{{ $patients_lists->firstItem() ?? 0 }}</strong> to <strong>{{ $patients_lists->lastItem() ?? 0 }}</strong> of <strong>{{ $patients_lists->total() }}</strong> entries</span>
                </div>
                <div class="server-pagination">
                    {{ $patients_lists->links('pagination::bootstrap-5') }}
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
                    title: 'Patient Lists',
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
