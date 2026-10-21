@extends('admin.layouts.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y mb-5">
    <h4 class="py-3 mb-4 text-primary">
        <span class="text-muted fw-light">Admin /</span> Patient History Details
    </h4>

    <!-- Print Button -->
    <div class="mb-3 text-end">
        <button class="btn btn-primary" onclick="printHistory()">
            <i class="fas fa-print"></i> Print
        </button>
        <a href="{{URL::to('admin/history_of_customer')}}">
            <button class="btn btn-warning ">
                <i class="fas fa-arrow-left"></i> Back
            </button>
        </a>
    </div>
    

    <!-- Printable Section -->
    <div class="card shadow-lg p-4 border-0 rounded" id="printableArea">
        <!-- Patient Details -->
        <h5 class="text-info mb-3">Patient Details</h5>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th>First Name</th>
                    <td>{{ isset($patient->first_name) ? $patient->first_name : '-' }}</td>
                    <th>Last Name</th>
                    <td>{{ isset($patient->last_name) ? $patient->last_name : '-' }}</td>
                </tr>
                <tr>
                    <th>DOB</th>
                    <td>{{ isset($patient->dob) ? \Carbon\Carbon::parse($patient->dob)->format('d M Y') : '-' }}</td>
                    <th>Age</th>
                    <td>{{ isset($patient->age) ? $patient->age : '-' }}</td>
                </tr>
                <tr>
                    <th>Gender</th>
                    <td>{{ isset($patient->sex) ? ucfirst($patient->sex) : '-' }}</td>
                    <th>Mobile No</th>
                    <td>{{ isset($patient->mobile_no) ? $patient->mobile_no : '-' }}</td>
                </tr>
                <tr>
                    <th>Alternate Mobile No</th>
                    <td>{{ isset($patient->alternate_mobile_no) ? $patient->alternate_mobile_no : '-' }}</td>
                    <th>Address</th>
                    <td colspan="3">{{ isset($patient->address) ? ucfirst($patient->address) : '-' }}</td>
                </tr>
                <tr>
                    <th>Patient Problem</th>
                    <td colspan="3">{{ isset($patient->patient_problem) ? ucfirst($patient->patient_problem) : '-' }}</td>
                </tr>
            </tbody>
            
        </table>

        <!-- Appointment Details -->
        <h5 class="text-info mt-4 mb-3">Appointment Details</h5>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Booking Time</th>
                    <th>Booking Date</th>
                    <th>Amount</th>
                    <th>Transaction ID</th>
                    <th>Payment Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->from_time }} - {{ $order->to_time }}</td>
                    <td>{{ date('d/m/Y', strtotime($order->booking_date)) }}</td>
                    <td>&#8377;{{ number_format($order->total_amount, 2) }}</td>
                    <td>#{{ $order->transaction_id }}</td>
                    <td>{{ date('d/m/Y h:i A', strtotime($order->created_at)) }}</td>
                    <td>
                        <span class="badge bg-{{ $order->status == 'paid' ? 'success' : 'danger' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('js')
<!-- Print Script -->
<script>
    function printHistory() {
        var printContents = document.getElementById('printableArea').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;

        location.reload();
    }
</script>

<!-- Optional Print Styling -->
<style>
@media print {
    body * {
        visibility: hidden;
    }
    #printableArea, #printableArea * {
        visibility: visible;
    }
    #printableArea {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
}
</style>
@endsection
