<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Booking Receipt - Roy Neuro Care</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f0f4f8;
            color: #2d3748;
            padding: 30px 15px;
            margin: 0;
        }

        .receipt-container {
            max-width: 780px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        .receipt-header {
            background: linear-gradient(135deg, #183e66 0%, #b22d32 100%);
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }

        .success-badge {
            display: inline-flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 12px;
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .receipt-body {
            padding: 35px 30px;
        }

        .receipt-section-title {
            font-size: 15px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #183e66;
            border-bottom: 2px solid #edf2f7;
            padding-bottom: 8px;
            margin-bottom: 16px;
        }

        .info-table td {
            padding: 8px 4px;
            font-size: 14px;
            border: none;
        }

        .info-label {
            color: #718096;
            width: 40%;
            font-weight: 500;
        }

        .info-value {
            color: #1a202c;
            font-weight: 600;
        }

        .amount-summary-box {
            background-color: #f7fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
        }

        .total-amount-highlight {
            font-size: 22px;
            font-weight: 700;
            color: #28a745;
        }

        .action-buttons {
            padding: 20px 30px 30px;
            background: #f8fafc;
            border-top: 1px solid #edf2f7;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .btn-brand {
            background-color: #b22d32;
            color: #ffffff;
            border: none;
            padding: 10px 22px;
            border-radius: 8px;
            font-weight: 600;
            transition: 0.2s;
        }

        .btn-brand:hover {
            background-color: #8f1e22;
            color: #ffffff;
        }

        .guideline-alert {
            background-color: #fff9db;
            border: 1px solid #ffe066;
            border-left: 4px solid #f59f00;
            border-radius: 8px;
            padding: 14px 18px;
            font-size: 13px;
            color: #664d03;
            margin-top: 20px;
        }

        @media print {
            body {
                background: #ffffff;
                padding: 0;
            }
            .receipt-container {
                box-shadow: none;
                border: none;
                max-width: 100%;
            }
            .action-buttons, .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

<div class="receipt-container">
    <!-- Receipt Header -->
    <div class="receipt-header">
        <div class="success-badge">
            <i class="fa-solid fa-circle-check text-warning me-2"></i> Payment Successful & Confirmed
        </div>
        <h2 class="fw-bold mb-1">Appointment Receipt</h2>
        <p class="mb-0 opacity-75 small">Roy Neuro Care - A Complete Brain & Spine Centre</p>
    </div>

    <!-- Receipt Body -->
    <div class="receipt-body">
        <div class="row g-4">
            <!-- Patient & Appointment Info -->
            <div class="col-md-6">
                <div class="receipt-section-title">
                    <i class="fa-solid fa-user-doctor me-2"></i> Appointment Details
                </div>
                <table class="table info-table mb-0">
                    <tr>
                        <td class="info-label">Patient Name:</td>
                        <td class="info-value">{{ ($order && $order->first_name) ? $order->first_name . ' ' . ($order->last_name ?? '') : 'Patient' }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Mobile Number:</td>
                        <td class="info-value">{{ ($order && $order->mobile_no) ? $order->mobile_no : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Appointment Date:</td>
                        <td class="info-value text-primary">
                            {{ ($order && $order->booking_date) ? \Carbon\Carbon::parse($order->booking_date)->format('l, d F Y') : 'N/A' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="info-label">Gender / Age:</td>
                        <td class="info-value">
                            {{ ($order && $order->sex) ? $order->sex : 'N/A' }} / {{ ($order && $order->age) ? $order->age . ' Years' : 'N/A' }}
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Transaction & Payment Info -->
            <div class="col-md-6">
                <div class="receipt-section-title">
                    <i class="fa-solid fa-receipt me-2"></i> Transaction Details
                </div>
                <table class="table info-table mb-0">
                    <tr>
                        <td class="info-label">Transaction Status:</td>
                        <td class="info-value text-success">
                            <span class="badge bg-success">PAID</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-label">Transaction ID:</td>
                        <td class="info-value text-break small">{{ ($order && $order->transaction_id) ? $order->transaction_id : $order_id }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Payment ID:</td>
                        <td class="info-value text-break small">{{ ($order && $order->razorpay_payment_id) ? $order->razorpay_payment_id : 'Online Payment' }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Payment Gateway:</td>
                        <td class="info-value">Razorpay Secure</td>
                    </tr>
                    <tr>
                        <td class="info-label">Payment Date:</td>
                        <td class="info-value">{{ ($order && $order->created_at) ? \Carbon\Carbon::parse($order->created_at)->format('d M Y') : \Carbon\Carbon::now()->format('d M Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Amount Breakdown Box -->
        <div class="amount-summary-box">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <div class="d-flex justify-content-between mb-1 small text-muted">
                        <span>Consultation Booking Fee:</span>
                        <span class="fw-semibold text-dark">₹ {{ number_format(($order && $order->actual_amount) ? $order->actual_amount : 700, 2) }}</span>
                    </div>
                    @if ($order && $order->total_amount > $order->actual_amount)
                    <div class="d-flex justify-content-between small text-muted">
                        <span>Platform & Processing Charge:</span>
                        <span class="fw-semibold text-dark">+ ₹ {{ number_format($order->total_amount - $order->actual_amount, 2) }}</span>
                    </div>
                    @endif
                </div>
                <div class="col-md-5 text-md-end mt-3 mt-md-0 border-top border-md-top-0 pt-2 pt-md-0">
                    <span class="d-block small text-muted text-uppercase fw-bold">Total Paid</span>
                    <span class="total-amount-highlight">₹ {{ number_format(($order && $order->total_amount) ? $order->total_amount : 740, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Patient Instructions -->
        <div class="guideline-alert">
            <i class="fa-solid fa-circle-info text-warning me-1"></i>
            <strong>Important Patient Guidelines:</strong>
            <ul class="mb-0 mt-1 ps-3">
                <li>Please arrive at the clinic on your scheduled appointment date.</li>
                <li>Carry this receipt (printed or digital copy on your phone) along with previous medical reports/prescriptions.</li>
                <li>Clinic Address: Ground Floor, Balaji Bhawan, Cheshire Home Road, Bariatu, Ranchi.</li>
            </ul>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <a href="{{ url('/') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-house me-1"></i> Back to Home
        </a>
        <div class="d-flex gap-2">
            @if ($order)
            <a href="{{ url('invoice/' . $order->id) }}" target="_blank" class="btn btn-outline-primary">
                <i class="fa-solid fa-file-invoice me-1"></i> Full Invoice
            </a>
            @endif
            <button onclick="window.print()" class="btn btn-brand">
                <i class="fa-solid fa-download me-1"></i> Download / Print Receipt
            </button>
        </div>
    </div>
</div>

</body>
</html>
