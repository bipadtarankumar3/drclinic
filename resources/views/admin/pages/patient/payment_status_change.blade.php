@extends('admin.layouts.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4 text-primary">
        <span class="text-muted fw-light">Admin /</span> Change Status
    </h4>

    <!-- Print Button -->
    <div class="mb-3 text-end no-print">
        <button class="btn btn-primary" onclick="printHistory()">
            <i class="fas fa-print me-1"></i> Print
        </button>
    </div>

    <!-- Printable Area -->
    <div id="printable-area">
        <div class="card shadow-lg border-0 rounded p-4 mb-4">
            <h5 class="text-info mb-3">Patient Details</h5>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>First Name</th>
                        <td>{{ $order->first_name }}</td>
                        <th>Last Name</th>
                        <td>{{ $order->last_name }}</td>
                    </tr>
                    <tr>
                        <th>DOB</th>
                        <td>{{ $order->dob }}</td>
                        <th>Age</th>
                        <td>{{ $order->age }}</td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td>{{ ucfirst($order->sex) }}</td>
                        <th>Mobile No</th>
                        <td>{{ $order->mobile_no }}</td>
                    </tr>
                    <tr>
                        <th>Alternate Mobile No</th>
                        <td>{{ $order->alternate_mobile_no }}</td>
                        <th>Address</th>
                        <td>{{ ucfirst($order->address) }}</td>
                    </tr>
                    <tr>
                        <th>Patient Problem</th>
                        <td colspan="3">{{ ucfirst($order->patient_problem) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Booking Details -->
        <div class="card shadow-lg border-0 rounded p-4">
            <h5 class="text-info mb-3">Booking Details</h5>
            <table class="table table-bordered mb-0">
                <tbody>
                    <tr>
                        <th>Booking Date</th>
                        <td>{{ date('d/m/Y', strtotime($order->booking_date)) }}</td>
                        <th>Time</th>
                        <td><span class="badge bg-secondary">{{ $order->from_time }} - {{ $order->to_time }}</span></td>
                    </tr>
                    <tr>
                        <th>Amount</th>
                        <td>&#8377;{{ number_format($order->total_amount, 2) }}</td>
                        <th>Transaction ID</th>
                        <td>#{{ $order->transaction_id }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td colspan="3"><span class="badge bg-info">{{ ucfirst($order->status) }}</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        
    </div>

    <!-- Status Update Form -->
    <div class="card shadow-lg border-0 rounded p-4 my-4 no-print">
        <h5 class="text-info mb-3">Change Status</h5>
        <form action="{{ url('admin/patient-history/update-status/'.$order->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="status" class="form-label">Select New Status</label>
                <select class="form-select" name="status" id="status" required>
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Update Status</button>
        </form>
    </div>
</div>

<!-- Print Styles -->
<style>
    @media print {
        body {
            -webkit-print-color-adjust: exact !important;
            color-adjust: exact !important;
        }

        .no-print {
            display: none !important;
        }

        .card {
            box-shadow: none !important;
            border: none !important;
        }

        .badge {
            color: white !important;
            background-color: #6c757d !important;
        }
    }
</style>

<!-- Print Script -->
<script>
    function printHistory() {
        const printableContent = document.getElementById('printable-area').innerHTML;
        const originalContent = document.body.innerHTML;

        document.body.innerHTML = printableContent;
        window.print();
        document.body.innerHTML = originalContent;
        location.reload();
    }
</script>
@endsection
