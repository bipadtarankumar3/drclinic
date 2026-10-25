<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank you for contacting {{ $clinic->name ?? 'our clinic' }}</title>
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
        .badge-ack {
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
        .greeting-title {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 10px;
        }
        .intro-text {
            font-size: 14.5px;
            line-height: 1.6;
            color: #475569;
            margin: 0 0 24px;
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
            margin-bottom: 20px;
            font-size: 14px;
        }
        .info-table td {
            padding: 9px 12px;
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
        .message-summary {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 14px 16px;
            font-size: 14px;
            line-height: 1.6;
            color: #334155;
            margin-bottom: 24px;
            white-space: pre-wrap;
        }
        .clinic-contact-box {
            background: linear-gradient(135deg, rgba(13, 148, 136, 0.06) 0%, rgba(13, 148, 136, 0.02) 100%);
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 18px 20px;
            margin-bottom: 24px;
            font-size: 13.5px;
            line-height: 1.6;
        }
        .clinic-contact-box h4 {
            margin: 0 0 8px;
            color: #0f172a;
            font-size: 15px;
            font-weight: 700;
        }
        .btn-booking {
            display: inline-block;
            background-color: {{ $clinic->theme_color ?? '#0d9488' }};
            color: #ffffff !important;
            text-decoration: none;
            padding: 13px 26px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 14.5px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        }
        .btn-wrapper {
            text-align: center;
            margin: 26px 0 16px;
        }
        .emergency-note {
            background-color: #fff1f2;
            border: 1px solid #fecdd3;
            border-radius: 8px;
            padding: 12px 14px;
            font-size: 12.5px;
            color: #991b1b;
            line-height: 1.5;
            margin-top: 20px;
        }
        .email-footer {
            background-color: #f8fafc;
            padding: 22px 24px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>{{ $clinic->name ?? 'Healthcare Clinic' }}</h1>
            <p>{{ $clinic->specialization ?? 'Medical Consultation & Patient Care' }}</p>
            <div class="badge-ack">Message Confirmation</div>
        </div>

        <!-- Body -->
        <div class="email-body">
            <h2 class="greeting-title">Dear {{ $inquiry->name }},</h2>
            <p class="intro-text">
                Thank you for reaching out to <strong>{{ $clinic->name }}</strong>. We have successfully received your inquiry. Our clinical care team has been notified and will review your message and follow up with you as quickly as possible.
            </p>

            <!-- Submission Summary -->
            <div class="section-title">Inquiry Summary</div>
            <table class="info-table">
                <tr>
                    <td class="label">Reference ID</td>
                    <td class="value"><code>#INQ-{{ str_pad($inquiry->id, 5, '0', STR_PAD_LEFT) }}</code></td>
                </tr>
                <tr>
                    <td class="label">Subject</td>
                    <td class="value">{{ $inquiry->subject ?: 'General Consultation Inquiry' }}</td>
                </tr>
                <tr>
                    <td class="label">Date Submitted</td>
                    <td class="value">{{ $inquiry->created_at->format('d M Y, h:i A') }}</td>
                </tr>
            </table>

            <div class="section-title">Your Submitted Message</div>
            <div class="message-summary">{{ $inquiry->message }}</div>

            <!-- Clinic Contact Box -->
            <div class="clinic-contact-box">
                <h4>{{ $clinic->name }} Direct Contact</h4>
                @if(!empty($clinic->phone))
                    <div><strong>Helpline:</strong> <a href="tel:{{ $clinic->phone }}" style="color: {{ $clinic->theme_color ?? '#0d9488' }}; text-decoration: none;">{{ $clinic->phone }}</a></div>
                @endif
                @if(!empty($clinic->email))
                    <div><strong>Email:</strong> <a href="mailto:{{ $clinic->email }}" style="color: {{ $clinic->theme_color ?? '#0d9488' }}; text-decoration: none;">{{ $clinic->email }}</a></div>
                @endif
                @if(!empty($clinic->address))
                    <div><strong>Location:</strong> {{ $clinic->address }}</div>
                @endif
                @if(!empty($clinic->topbar_hours))
                    <div><strong>Visiting Hours:</strong> {{ $clinic->topbar_hours }}</div>
                @endif
            </div>

            <!-- Call to Action -->
            <div class="btn-wrapper">
                @php
                    $clinicUrl = $clinic ? url('/c/' . ($clinic->subdomain ?? $clinic->slug)) : url('/');
                    $bookingUrl = $clinicUrl . '#booking-section';
                @endphp
                <a href="{{ $bookingUrl }}" class="btn-booking">
                    Book An Appointment Online
                </a>
            </div>

            <!-- Emergency Alert -->
            <div class="emergency-note">
                <strong>Emergency Note:</strong> If you are experiencing a severe or acute medical emergency, please visit our nearest emergency ward immediately or call emergency helpline services.
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p style="margin: 0 0 6px;">
                Warm regards,<br>
                <strong>Patient Support Team &bull; {{ $clinic->name }}</strong>
            </p>
            <p style="margin: 0;">
                &copy; {{ date('Y') }} {{ $clinic->name }}. All patient communications are strictly confidential.
            </p>
        </div>
    </div>
</body>
</html>
