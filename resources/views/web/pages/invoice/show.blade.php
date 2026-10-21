<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice Receipt #{{ $order->id }} - Roy Neuro Care</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            padding: 2rem 1rem;
            font-family: 'Montserrat', sans-serif;
            color: #212529;
        }
        .invoice-box {
            background: #ffffff;
            padding: 3rem 2.5rem;
            border-radius: 12px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.06);
            max-width: 850px;
            margin: auto;
            border: 1px solid #e9ecef;
        }
        .invoice-header {
            border-bottom: 2px solid #dee2e6;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
        }
        .invoice-header img {
            max-height: 70px;
        }
        .invoice-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #183e66;
        }
        .section-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #183e66;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 4px;
        }
        .info-group p {
            margin: 0.35rem 0;
            font-size: 14px;
        }
        .amount-label {
            font-weight: 600;
            color: #6c757d;
        }
        .total-box {
            font-size: 1.4rem;
            font-weight: 700;
            margin-top: 2rem;
            border-top: 2px dashed #dee2e6;
            padding-top: 1rem;
            text-align: right;
        }
        .btn-download {
            max-width: 850px;
            margin: 0 auto 1.5rem auto;
        }
        .btn-brand {
            background-color: #b22d32;
            color: #ffffff;
            font-weight: 600;
            border: none;
        }
        .btn-brand:hover {
            background-color: #8f1e22;
            color: #ffffff;
        }
        @media print {
            body {
                background: #ffffff;
                padding: 0;
            }
            .btn-download {
                display: none !important;
            }
            .invoice-box {
                box-shadow: none;
                border: none;
                padding: 0;
            }
        }
    </style>
</head>
<body>

@php
    $referer = request()->headers->get('referer');
    $isAdmin = (auth()->check() && (auth()->user()->user_type == 'admin' || auth()->user()->role == 'admin')) 
                || request('from') === 'admin' 
                || request('ref') === 'admin'
                || ($referer && str_contains($referer, '/admin'));

    if ($isAdmin) {
        $backUrl = ($referer && str_contains($referer, '/admin')) ? $referer : url('admin/payments');
        $backText = 'Back to Admin';
    } else {
        $backUrl = 'https://royneurocare.com/appointment/';
        $backText = 'Back to Appointment';
    }
@endphp

<div class="container">
    <!-- Action Header -->
    <div class="d-flex justify-content-between align-items-center btn-download">
        <a href="{{ $backUrl }}" class="btn btn-outline-secondary btn-sm">
            <i class="fa-solid fa-arrow-left me-1"></i> {{ $backText }}
        </a>
        <button class="btn btn-brand btn-sm px-3" onclick="window.print()">
            <i class="fa-solid fa-download me-1"></i> Download / Print Invoice
        </button>
    </div>

    <!-- Invoice Container -->
    <div class="invoice-box">
        <!-- Header -->
        <div class="invoice-header d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <div class="d-flex align-items-center gap-3">
                    <img src="{{ URL::to('public/assets/web/logo.png') }}" alt="Roy Neuro Care Logo" onerror="this.src='{{ URL::to('public/assets/web/homeimage/logo.png') }}'">
                    <div>
                        <h4 class="fw-bold mb-0" style="color: #183e66; font-size: 1.4rem;">Roy Neuro Care</h4>
                        <div class="text-muted small" style="font-size: 0.82rem; font-weight: 500;">A Complete Brain & Spine Centre</div>
                    </div>
                </div>
                <div class="mt-2 small text-muted">
                    Ground Floor, Balaji Bhawan, Cheshire Home Road, Bariatu, Ranchi<br>
                    Phone: +91-96317 75097 | Email: royneurocare@gmail.com
                </div>
            </div>
            <div class="text-md-end">
                <div class="invoice-title">RECEIPT / INVOICE</div>
                <div class="text-muted fw-bold">Receipt #{{ $order->id }}</div>
                <div class="small text-muted">{{ ($order && $order->created_at) ? \Carbon\Carbon::parse($order->created_at)->format('d M Y') : \Carbon\Carbon::now()->format('d M Y') }}</div>
                <div class="mt-1">
                    @if($order->payment_status == 'success')
                        <span class="badge bg-success px-3 py-1">PAYMENT SUCCESS</span>
                    @else
                        <span class="badge bg-danger px-3 py-1">{{ strtoupper($order->payment_status ?? 'CANCELLED') }}</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Patient Info -->
        <div>
            <div class="section-title"><i class="fa-solid fa-user me-2"></i> Patient Information</div>
            <div class="row info-group">
                <div class="col-md-6">
                    <p><span class="amount-label">Patient Name:</span> {{ $order->first_name }} {{ $order->last_name }}</p>
                    <p><span class="amount-label">Mobile Number:</span> {{ $order->mobile_no ?? 'N/A' }}</p>
                    @if($order->alternate_mobile_no)
                        <p><span class="amount-label">Alternate Mobile:</span> {{ $order->alternate_mobile_no }}</p>
                    @endif
                    @if(!empty($order->sex) || !empty($order->age))
                        <p><span class="amount-label">Gender / Age:</span> {{ $order->sex ?? 'N/A' }} @if(!empty($order->age)) / {{ $order->age }} Years @endif</p>
                    @endif
                </div>
                <div class="col-md-6">
                    <p><span class="amount-label">Booking Date:</span>
                        {{ $order->booking_date ? \Carbon\Carbon::parse($order->booking_date)->format('l, d M Y') : 'N/A' }}
                    </p>
                    @if($order->address)
                        <p><span class="amount-label">Address:</span> {{ $order->address }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Payment Info -->
        <div>
            <div class="section-title"><i class="fa-solid fa-credit-card me-2"></i> Payment Details</div>
            <div class="row info-group">
                <div class="col-md-6">
                    <p><span class="amount-label">Consultation Fee:</span> ₹ {{ number_format($order->actual_amount, 2) }}</p>
                    @if($order->total_amount > $order->actual_amount)
                        <p><span class="amount-label">Platform Fee:</span> ₹ {{ number_format($order->total_amount - $order->actual_amount, 2) }}</p>
                    @endif
                </div>
                <div class="col-md-6">
                    <p><span class="amount-label">Payment ID:</span> {{ $order->razorpay_payment_id ?? 'N/A' }}</p>
                    <p><span class="amount-label">Transaction/Order ID:</span> {{ $order->transaction_id ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Total -->
        <div class="total-box {{ $order->payment_status == 'success' ? 'text-success' : 'text-danger' }}">
            Total Amount: ₹ {{ number_format($order->total_amount, 2) }}
        </div>
    </div>
</div>

</body>
</html>
