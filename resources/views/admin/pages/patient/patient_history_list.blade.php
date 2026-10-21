@extends('admin.layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h6 class="py-3 mb-4"><span class="text-muted fw-light">Admin /</span> Patient History</h6>

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
