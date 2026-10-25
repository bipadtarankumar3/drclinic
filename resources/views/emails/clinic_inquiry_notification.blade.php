<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Patient Inquiry - {{ $clinic->name ?? 'Clinic' }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f1f5f9;
            margin: 0;
            padding: 24px 12px;
            color: #1e293b;
            -webkit-font-smoothing: antialiased;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
        }
        .email-header {
            background: linear-gradient(135deg, {{ $clinic->theme_color ?? '#0d9488' }} 0%, {{ $clinic->secondary_color ?? '#0f766e' }} 100%);
            color: #ffffff;
            padding: 32px 24px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 22px;
            font-weight: 700;
            letter-spacing: -0.3px;
        }
        .email-header p {
            margin: 6px 0 0;
            font-size: 14px;
            opacity: 0.92;
        }
        .badge-inquiry {
            display: inline-block;
            background-color: rgba(255, 255, 255, 0.22);
            border: 1px solid rgba(255, 255, 255, 0.4);
            color: #ffffff;
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 14px;
        }
        .email-body {
            padding: 30px 24px;
        }
        .section-title {
            font-size: 13px;
            font-weight: 700;
            color: {{ $clinic->theme_color ?? '#0d9488' }};
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin: 0 0 12px;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 6px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
            font-size: 14px;
        }
        .info-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #f1f5f9;
        }
        .info-table td.label {
            width: 32%;
            font-weight: 600;
            color: #64748b;
            background-color: #f8fafc;
        }
        .info-table td.value {
            color: #0f172a;
            font-weight: 500;
        }
        .message-card {
            background-color: #f8fafc;
            border-left: 4px solid {{ $clinic->theme_color ?? '#0d9488' }};
            border-radius: 0 10px 10px 0;
            padding: 18px 20px;
            margin: 16px 0 24px;
            font-size: 14.5px;
            line-height: 1.65;
            color: #1e293b;
            white-space: pre-wrap;
            border-top: 1px solid #e2e8f0;
            border-right: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
        }
        .btn-group {
            text-align: center;
            margin: 28px 0 16px;
        }
        .btn-primary {
            display: inline-block;
            background-color: {{ $clinic->theme_color ?? '#0d9488' }};
            color: #ffffff !important;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            margin: 4px 6px;
        }
        .btn-secondary {
            display: inline-block;
            background-color: #f1f5f9;
            color: #334155 !important;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            margin: 4px 6px;
            border: 1px solid #cbd5e1;
        }
        .email-footer {
            background-color: #f8fafc;
            padding: 20px 24px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>{{ $clinic->name ?? 'Healthcare Clinic' }}</h1>
            <p>{{ $clinic->specialization ?? 'Medical Consultation & Patient Care' }}</p>
            <div class="badge-inquiry">New Patient Contact Inquiry</div>
        </div>

        <!-- Body -->
        <div class="email-body">
            <p style="font-size: 15px; line-height: 1.5; margin-top: 0; color: #334155;">
                Hello, you have received a new contact message submitted through your clinic website.
            </p>

            <!-- Sender Information -->
            <div class="section-title">Patient / Sender Details</div>
            <table class="info-table">
                <tr>
                    <td class="label">Patient Name</td>
                    <td class="value"><strong>{{ $inquiry->name }}</strong></td>
                </tr>
                <tr>
                    <td class="label">Email Address</td>
                    <td class="value"><a href="mailto:{{ $inquiry->email }}" style="color: {{ $clinic->theme_color ?? '#0d9488' }}; text-decoration: none; font-weight: 600;">{{ $inquiry->email }}</a></td>
                </tr>
                <tr>
                    <td class="label">Phone Number</td>
                    <td class="value">
                        @if(!empty($inquiry->phone))
                            <a href="tel:{{ $inquiry->phone }}" style="color: #0f172a; text-decoration: none; font-weight: 600;">{{ $inquiry->phone }}</a>
                        @else
                            <span style="color: #94a3b8;">Not provided</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="label">Subject</td>
                    <td class="value">{{ $inquiry->subject ?: 'General Clinic Inquiry' }}</td>
                </tr>
                <tr>
                    <td class="label">Reference ID</td>
                    <td class="value"><code>#INQ-{{ str_pad($inquiry->id, 5, '0', STR_PAD_LEFT) }}</code></td>
                </tr>
                <tr>
                    <td class="label">Date Received</td>
                    <td class="value">{{ $inquiry->created_at->format('d M Y, h:i A') }}</td>
                </tr>
            </table>

            <!-- Message Content -->
            <div class="section-title">Inquiry Message</div>
            <div class="message-card">{{ $inquiry->message }}</div>

            <!-- Action Buttons -->
            <div class="btn-group">
                <a href="mailto:{{ $inquiry->email }}?subject={{ urlencode('Re: ' . ($inquiry->subject ?: 'Clinic Inquiry') . ' - ' . ($clinic->name ?? 'Clinic')) }}" class="btn-primary">
                    Reply to Patient
                </a>
                @if(!empty($inquiry->phone))
                    <a href="tel:{{ $inquiry->phone }}" class="btn-secondary">
                        Call {{ $inquiry->phone }}
                    </a>
                @endif
                <a href="{{ route('clinic.inquiries.show', $inquiry->id) }}" class="btn-secondary">
                    View in Doctor Portal
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p style="margin: 0 0 6px;">
                This inquiry was received from the <strong>{{ $clinic->name ?? 'Clinic' }}</strong> website contact page.
            </p>
            <p style="margin: 0;">
                &copy; {{ date('Y') }} {{ $clinic->name ?? 'Clinic' }}. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
