<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Unavailable - {{ $clinic->name ?? 'Dr Clinic' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: {{ $clinic->theme_color ?? '#2563eb' }};
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --bg-light: #f8fafc;
            --card-bg: #ffffff;
            --border: #e2e8f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg-light);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .expired-card {
            background: var(--card-bg);
            border: 1px solid var(--border);
            border-radius: 24px;
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.07);
            max-width: 600px;
            width: 100%;
            padding: 48px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .expired-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #f59e0b, #ef4444);
        }

        .icon-circle {
            width: 90px;
            height: 90px;
            background: #fffbeb;
            border: 2px dashed #f59e0b;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 38px;
            color: #d97706;
            margin-bottom: 24px;
            animation: pulse-warn 2s infinite ease-in-out;
        }

        @keyframes pulse-warn {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .clinic-name {
            font-size: 24px;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .expired-tag {
            display: inline-block;
            background: #fee2e2;
            color: #b91c1c;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 4px 14px;
            border-radius: 100px;
            margin-bottom: 20px;
        }

        .title {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 12px;
        }

        .description {
            font-size: 15px;
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 32px;
        }

        .clinic-contact-box {
            background: #f1f5f9;
            border-radius: 16px;
            padding: 16px 20px;
            margin-bottom: 32px;
            text-align: left;
            font-size: 14px;
        }

        .contact-row {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--text-dark);
            margin-bottom: 8px;
        }
        .contact-row:last-child {
            margin-bottom: 0;
        }
        .contact-row i {
            color: #64748b;
            width: 16px;
        }

        .btn-group {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-renew {
            background: #2563eb;
            color: #ffffff;
            font-weight: 700;
            font-size: 15px;
            padding: 14px 28px;
            border-radius: 12px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.3);
            transition: all 0.2s ease;
        }

        .btn-renew:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
        }

        .btn-home {
            background: #ffffff;
            color: var(--text-dark);
            font-weight: 600;
            font-size: 15px;
            padding: 14px 24px;
            border-radius: 12px;
            border: 1px solid var(--border);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }

        .btn-home:hover {
            background: #f8fafc;
        }

        .footer-note {
            margin-top: 32px;
            font-size: 13px;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="expired-card">
        <div class="icon-circle">
            <i class="fa-solid fa-hourglass-end"></i>
        </div>

        <div class="clinic-name">{{ $clinic->name }}</div>
        <div class="expired-tag">Subscription Plan Expired</div>

        <h2 class="title">Online Booking Service Temporarily Inactive</h2>
        <p class="description">
            This clinic's subscription plan has expired. Online appointment booking and digital services are currently paused until the clinic plan is renewed.
        </p>

        @if($clinic->phone || $clinic->email)
        <div class="clinic-contact-box">
            <div style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 10px;">Direct Clinic Inquiries:</div>
            @if($clinic->phone)
            <div class="contact-row">
                <i class="fa-solid fa-phone"></i>
                <span>{{ $clinic->phone }}</span>
            </div>
            @endif
            @if($clinic->email)
            <div class="contact-row">
                <i class="fa-solid fa-envelope"></i>
                <span>{{ $clinic->email }}</span>
            </div>
            @endif
        </div>
        @endif

        <div class="btn-group">
            <a href="{{ url('/admin/login') }}" class="btn-renew">
                <i class="fa-solid fa-arrow-rotate-right"></i> Clinic Owner? Renew Plan
            </a>
            <a href="{{ url('/') }}" class="btn-home">
                <i class="fa-solid fa-house"></i> Platform Home
            </a>
        </div>

        <div class="footer-note">
            Powered by <strong>Dr Clinic SaaS Platform</strong>
        </div>
    </div>
</body>
</html>
