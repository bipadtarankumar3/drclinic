<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Confirmation - Roy Neuro Care</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 20px;
            color: #333333;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            border: 1px solid #e9ecef;
        }
        .email-header {
            background: linear-gradient(135deg, #183e66 0%, #b22d32 100%);
            color: #ffffff;
            padding: 28px 24px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .email-header p {
            margin: 6px 0 0;
            font-size: 14px;
            opacity: 0.9;
        }
        .badge-success {
            display: inline-block;
            background-color: #28a745;
            color: #ffffff;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 12px;
        }
        .email-body {
            padding: 24px;
        }
        .section-title {
            font-size: 15px;
            font-weight: 700;
            color: #183e66;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #f1f3f5;
            padding-bottom: 8px;
            margin: 24px 0 14px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }
        .info-table td {
            padding: 8px 6px;
            font-size: 14px;
            vertical-align: top;
        }
        .info-table td.label {
            color: #6c757d;
            width: 40%;
            font-weight: 500;
        }
        .info-table td.value {
            color: #212529;
            font-weight: 600;
        }
        .highlight-card {
            background-color: #f8f9fa;
            border-left: 4px solid #b22d32;
            padding: 14px 16px;
            border-radius: 4px;
            margin: 16px 0;
        }
        .highlight-card p {
            margin: 4px 0;
            font-size: 13px;
            color: #495057;
        }
        .btn-invoice {
            display: block;
            text-align: center;
            background-color: #b22d32;
            color: #ffffff !important;
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            margin: 24px 0;
        }
        .email-footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #6c757d;
            border-top: 1px solid #e9ecef;
        }
        .email-footer p {
            margin: 4px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>Roy Neuro Care</h1>
            <p>Advanced Neurology & Neuro-Psychiatry Center</p>
            <div class="badge-success">&#10004; New Booking Confirmed & Paid</div>
        </div>

        <!-- Body -->
        <div class="email-body">
            <p style="font-size: 15px; margin-top: 0;">
                Hello <strong>Admin / Clinic Team</strong>,
            </p>
            <p style="font-size: 14px; color: #495057; line-height: 1.6;">
                A new online appointment has been successfully booked and paid for on <strong>Roy Neuro Care</strong>. Below are the complete patient, appointment, and payment details:
            </p>

            <!-- Appointment Details -->
            <div class="section-title">&#128197; Appointment Schedule</div>
            <table class="info-table">
                <tr>
                    <td class="label">Appointment Date:</td>
                    <td class="value" style="color: #b22d32; font-size: 15px;">
                        {{ $order->booking_date ? \Carbon\Carbon::parse($order->booking_date)->format('l, d F Y') : 'N/A' }}
                    </td>
                </tr>
                <tr>
                    <td class="label">Booking / Order ID:</td>
                    <td class="value">#{{ $order->id }}</td>
                </tr>
                <tr>
                    <td class="label">Booking Status:</td>
                    <td class="value" style="color: #28a745;">Confirmed & Paid</td>
                </tr>
            </table>

            <!-- Patient Details -->
            <div class="section-title">&#128100; Patient Details</div>
            <table class="info-table">
                <tr>
                    <td class="label">Patient Name:</td>
                    <td class="value">{{ $patient->first_name ?? 'N/A' }} {{ $patient->last_name ?? '' }}</td>
                </tr>
                <tr>
                    <td class="label">Mobile Number:</td>
                    <td class="value">{{ $patient->mobile_no ?? 'N/A' }}</td>
                </tr>
                @if(!empty($patient->alternate_mobile_no))
                <tr>
                    <td class="label">Alt / WhatsApp:</td>
                    <td class="value">{{ $patient->alternate_mobile_no }}</td>
                </tr>
                @endif
                <tr>
                    <td class="label">Gender / Age:</td>
                    <td class="value">{{ $patient->sex ?? 'N/A' }} @if(!empty($patient->age)) / {{ $patient->age }} Years @endif</td>
                </tr>
                @if(!empty($patient->address))
                <tr>
                    <td class="label">Address:</td>
                    <td class="value">{{ $patient->address }}</td>
                </tr>
                @endif
                @if(!empty($patient->patient_problem))
                <tr>
                    <td class="label">Chief Complaint:</td>
                    <td class="value">{{ $patient->patient_problem }}</td>
                </tr>
                @endif
            </table>

            <!-- Payment Breakdown -->
            <div class="section-title">&#128179; Payment Summary</div>
            <table class="info-table">
                <tr>
                    <td class="label">Total Amount Paid:</td>
                    <td class="value" style="color: #28a745; font-size: 16px;">₹ {{ number_format($order->total_amount, 2) }}</td>
                </tr>
                @if($order->actual_amount && $order->actual_amount != $order->total_amount)
                <tr>
                    <td class="label">Consultation Fee:</td>
                    <td class="value">₹ {{ number_format($order->actual_amount, 2) }}</td>
                </tr>
                @endif
                @if(!empty($order->razorpay_payment_id))
                <tr>
                    <td class="label">Razorpay Payment ID:</td>
                    <td class="value" style="font-family: monospace; font-size: 13px;">{{ $order->razorpay_payment_id }}</td>
                </tr>
                @endif
                @if(!empty($order->transaction_id))
                <tr>
                    <td class="label">Transaction Order ID:</td>
                    <td class="value" style="font-family: monospace; font-size: 13px;">{{ $order->transaction_id }}</td>
                </tr>
                @endif
                <tr>
                    <td class="label">Payment Date:</td>
                    <td class="value">{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</td>
                </tr>
            </table>

            <!-- Call to Action: Download Receipt / Invoice -->
            <a href="{{ url('/invoice/' . $order->id) }}" target="_blank" class="btn-invoice">
                &#128196; Download / Print Official Tax Invoice & Receipt
            </a>

            <!-- Important Instructions -->
            <div class="highlight-card">
                <p><strong>&#9888; Important Patient Instructions:</strong></p>
                <p>&bull; Please arrive at the clinic on your scheduled appointment date.</p>
                <p>&bull; Bring any previous medical records, prescriptions, MRI/CT scans, and blood test reports.</p>
                @if($setting && !empty($setting->clinic_phone_number))
                <p>&bull; For any queries or rescheduling assistance, contact our clinic at <strong>{{ $setting->clinic_phone_number }}</strong>.</p>
                @endif
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p><strong>Roy Neuro Care</strong></p>
            <p>This is an automated confirmation email. Please keep this email for your records.</p>
            <p>&copy; {{ date('Y') }} Roy Neuro Care. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
