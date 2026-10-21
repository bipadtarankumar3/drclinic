@extends('admin.layouts.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4 text-primary"><span class="text-muted fw-light">Admin /</span> Patient History Details</h4>

    <div class="card shadow-lg p-4 border-0 rounded">
        <div class="row">
            <!-- Patient Details -->
            <div class="col-md-6 mb-4">
                <h5 class="text-info">Patient Details</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Name:</strong> {{ $order->patient_name }}</li>
                    <li class="list-group-item"><strong>DOB:</strong> {{ $order->dob }}</li>
                    <li class="list-group-item"><strong>Age:</strong> {{ $order->age }}</li>
                    <li class="list-group-item"><strong>Gender:</strong> {{ ucfirst($order->sex) }}</li>
                    <li class="list-group-item"><strong>Mobile no:</strong> {{ $order->mobile_no }}</li>
                    <li class="list-group-item"><strong>Alternate mobile no:</strong> {{ $order->alternate_mobile_no }}</li>
                    <li class="list-group-item"><strong>Address:</strong> {{ ucfirst($order->address) }}</li>
                </ul>
            </div>
            
            <!-- Appointment Details -->
            <div class="col-md-6 mb-4">
                <h5 class="text-info">Appointment Details</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Booking Time:</strong> {{ $order->from_time }} - {{ $order->to_time }}</li>
                    <li class="list-group-item"><strong>Booking Date:</strong> {{ date('d/m/Y', strtotime($order->booking_date)) }}</li>
                    <li class="list-group-item"><strong>Amount:</strong> &#8377;{{ number_format($order->total_amount, 2) }}</li>
                    <li class="list-group-item"><strong>Transaction ID:</strong> #{{ $order->transaction_id }}</li>
                    <li class="list-group-item"><strong>Payment Date:</strong> {{ date('d/m/Y', strtotime($order->payment_date)) }}</li>
                    <li class="list-group-item"><strong>Status:</strong> <span class="badge bg-{{ $order->status == 'paid' ? 'success' : 'danger' }}">{{ ucfirst($order->status) }}</span></li>
                </ul>
            </div>
        </div>
    </div>

</div>
@endsection