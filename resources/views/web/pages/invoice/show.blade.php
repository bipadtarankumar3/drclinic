<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Medical Consultation Receipt #REC-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }} - {{ $clinic->name ?? 'Dr Clinic' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- Google Fonts: Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">

    @php
        $primaryColor = ($clinic && $clinic->theme_color) ? $clinic->theme_color : '#0d9488';
        $secondaryColor = ($clinic && $clinic->secondary_color) ? $clinic->secondary_color : '#0f766e';
        $cleanPhone = preg_replace('/[^0-9]/', '', $order->mobile_no ?? '');
        $logoPath = null;
        if ($clinic && $clinic->logo) {
            $logoPath = $clinic->logo_url ?? URL::to('public/' . $clinic->logo);
        }

        // Amount in words helper
        function numberToWords($number) {
            $decimal = round($number - ($no = floor($number)), 2) * 100;
            $hundred = null;
            $digits_length = strlen($no);
            $i = 0;
            $str = array();
            $words = array(
                0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four', 5 => 'Five',
                6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine', 10 => 'Ten',
                11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
                16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen', 19 => 'Nineteen', 20 => 'Twenty',
                30 => 'Thirty', 40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty', 70 => 'Seventy',
                80 => 'Eighty', 90 => 'Ninety'
            );
            $digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
            while( $i < $digits_length ) {
                $divider = ($i == 2) ? 10 : 100;
                $number = floor($no % $divider);
                $no = floor($no / $divider);
                $i += $divider == 10 ? 1 : 2;
                if ($number) {
                    $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                    $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                    $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
                } else $str[] = null;
            }
            $Rupees = implode('', array_reverse($str));
            $paise = ($decimal > 0) ? " and " . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
            return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise . "Only";
        }

        $isCash = ($order->razorpay_payment_id === 'CASH_PAYMENT' || $order->razorpay_payment_id === 'CASH_AT_CLINIC' || str_contains($order->transaction_id ?? '', 'CASH'));
        $consultFee = (float)($order->actual_amount ?: $order->total_amount);
        $totalPaid = (float)$order->total_amount;
        $platformFee = $totalPaid > $consultFee ? ($totalPaid - $consultFee) : 0;
    @endphp

    <style>
        :root {
            --rx-primary: {{ $primaryColor }};
            --rx-primary-dark: {{ $secondaryColor }};
            --rx-primary-light: #f0fdfa;
            --rx-border: #e2e8f0;
            --rx-text-dark: #0f172a;
            --rx-text-muted: #64748b;
        }

        body {
            background-color: #f1f5f9;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--rx-text-dark);
            padding: 2.5rem 1rem;
            margin: 0;
            -webkit-font-smoothing: antialiased;
        }

        /* Top Floating Toolbar (No Print) */
        .receipt-toolbar {
            max-width: 880px;
            margin: 0 auto 1.5rem auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }
        .btn-toolbar-back {
            background: #ffffff;
            color: #475569;
            border: 1.5px solid #cbd5e1;
            font-weight: 600;
            font-size: 13.5px;
            padding: 8px 16px;
            border-radius: 10px;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-toolbar-back:hover {
            background: #f8fafc;
            color: #0f172a;
            border-color: #94a3b8;
        }
        .btn-toolbar-print {
            background: var(--rx-primary);
            color: #ffffff;
            border: none;
            font-weight: 700;
            font-size: 13.5px;
            padding: 8px 18px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(13, 148, 136, 0.25);
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }
        .btn-toolbar-print:hover {
            background: var(--rx-primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(13, 148, 136, 0.35);
            color: #ffffff;
        }
        .btn-toolbar-wa {
            background: #25d366;
            color: #ffffff;
            border: none;
            font-weight: 600;
            font-size: 13.5px;
            padding: 8px 16px;
            border-radius: 10px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-toolbar-wa:hover {
            background: #1eb956;
            color: #ffffff;
        }

        /* Main Official Receipt Sheet */
        .receipt-card {
            background: #ffffff;
            max-width: 880px;
            margin: 0 auto;
            border-radius: 20px;
            border: 1.5px solid #e2e8f0;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
            overflow: hidden;
            position: relative;
        }

        /* Top Colored Clinic Header Bar */
        .receipt-top-stripe {
            height: 6px;
            background: linear-gradient(90deg, var(--rx-primary) 0%, var(--rx-primary-dark) 100%);
        }

        .receipt-inner {
            padding: 2.75rem 3rem;
        }

        /* Clinic Brand Header */
        .clinic-brand-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 20px;
            padding-bottom: 1.75rem;
            border-bottom: 2px solid #f1f5f9;
        }
        .clinic-logo-wrapper {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .clinic-logo-img {
            max-height: 62px;
            max-width: 170px;
            object-fit: contain;
            border-radius: 10px;
        }
        .clinic-fallback-avatar {
            width: 58px;
            height: 58px;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--rx-primary), var(--rx-primary-dark));
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: 800;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(13, 148, 136, 0.2);
        }
        .clinic-title {
            font-family: 'Outfit', sans-serif;
            font-size: 1.45rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 2px;
            letter-spacing: -0.3px;
        }
        .clinic-specialty {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--rx-primary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .clinic-contact-line {
            font-size: 0.8rem;
            color: #64748b;
            line-height: 1.5;
        }

        /* Document Title & Meta Box */
        .document-title-meta {
            text-align: right;
            min-width: 240px;
        }
        .receipt-badge-title {
            font-family: 'Outfit', sans-serif;
            font-size: 1.35rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.2px;
            margin-bottom: 4px;
        }
        .receipt-number-pill {
            font-family: monospace;
            font-size: 13.5px;
            font-weight: 700;
            color: #0f172a;
            background: #f1f5f9;
            padding: 3px 10px;
            border-radius: 6px;
            display: inline-block;
            margin-bottom: 6px;
        }
        .receipt-date-text {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 8px;
        }
        .status-seal-success {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #ecfdf5;
            color: #059669;
            border: 1.5px solid #a7f3d0;
            font-weight: 700;
            font-size: 11.5px;
            padding: 4px 12px;
            border-radius: 20px;
            letter-spacing: 0.3px;
        }
        .status-seal-pending {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fffbeb;
            color: #d97706;
            border: 1.5px solid #fde68a;
            font-weight: 700;
            font-size: 11.5px;
            padding: 4px 12px;
            border-radius: 20px;
        }
        .status-seal-cancelled {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fef2f2;
            color: #dc2626;
            border: 1.5px solid #fecdd3;
            font-weight: 700;
            font-size: 11.5px;
            padding: 4px 12px;
            border-radius: 20px;
        }

        /* Section Headings */
        .receipt-section-header {
            font-family: 'Outfit', sans-serif;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #64748b;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .receipt-section-header i {
            color: var(--rx-primary);
            font-size: 14px;
        }

        /* Patient & Schedule Grid Card */
        .patient-schedule-box {
            background: #f8fafc;
            border: 1.5px solid #edf2f7;
            border-radius: 14px;
            padding: 1.25rem 1.5rem;
            margin-top: 1.5rem;
            margin-bottom: 2rem;
        }
        .info-cell-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            margin-bottom: 2px;
        }
        .info-cell-value {
            font-size: 13.5px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 10px;
            word-break: break-word;
        }
        .info-cell-value-highlight {
            color: var(--rx-primary);
            font-weight: 700;
        }

        /* Table Styles */
        .receipt-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 1.5rem;
            border: 1.5px solid #edf2f7;
            border-radius: 12px;
            overflow: hidden;
        }
        .receipt-table thead th {
            background: #f8fafc;
            color: #475569;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            padding: 12px 16px;
            border-bottom: 1.5px solid #edf2f7;
        }
        .receipt-table tbody td {
            padding: 14px 16px;
            font-size: 13.5px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }
        .receipt-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Totals Breakdown */
        .receipt-totals-panel {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 2rem;
        }
        .words-panel {
            flex: 1;
            min-width: 260px;
            background: #f8fafc;
            border: 1px solid #edf2f7;
            border-radius: 12px;
            padding: 14px 18px;
        }
        .words-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #64748b;
            margin-bottom: 4px;
        }
        .words-value {
            font-size: 13px;
            font-weight: 600;
            color: #0f172a;
            font-style: italic;
        }
        .calculation-card {
            width: 320px;
            background: #ffffff;
            border: 1.5px solid #edf2f7;
            border-radius: 12px;
            padding: 14px 18px;
        }
        .calc-row {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            margin-bottom: 8px;
            color: #475569;
        }
        .calc-row.grand-total {
            border-top: 2px dashed #cbd5e1;
            padding-top: 10px;
            margin-top: 6px;
            margin-bottom: 0;
            font-size: 16px;
            font-weight: 800;
            color: #0f172a;
        }
        .calc-row.grand-total .total-price {
            color: var(--rx-primary);
            font-size: 18px;
        }

        /* Payment Settlement Meta Tile */
        .payment-meta-card {
            background: #f0fdfa;
            border: 1px solid #ccfbf1;
            border-radius: 12px;
            padding: 12px 18px;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }
        .meta-field-label {
            font-size: 11px;
            font-weight: 700;
            color: #0f766e;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .meta-field-val {
            font-size: 12.5px;
            font-weight: 600;
            color: #0f172a;
            font-family: monospace;
        }

        /* Bottom Signoff & Policy */
        .receipt-footer-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            border-top: 1.5px solid #f1f5f9;
            padding-top: 1.75rem;
            flex-wrap: wrap;
            gap: 24px;
        }
        .instructions-list {
            font-size: 11.5px;
            color: #64748b;
            line-height: 1.7;
            max-width: 480px;
        }
        .signature-box {
            text-align: center;
            min-width: 220px;
        }
        .clinic-stamp-badge {
            width: 72px;
            height: 72px;
            border: 2px dashed var(--rx-primary);
            border-radius: 50%;
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--rx-primary);
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
            line-height: 1.2;
            margin-bottom: 8px;
            opacity: 0.85;
        }
        .signature-line {
            width: 180px;
            height: 1px;
            background: #94a3b8;
            margin: 0 auto 6px auto;
        }
        .signatory-title {
            font-size: 11.5px;
            font-weight: 700;
            color: #0f172a;
        }
        .signatory-subtitle {
            font-size: 10px;
            color: #64748b;
        }

        /* Thank you banner */
        .thankyou-bar {
            background: #f8fafc;
            border-top: 1px solid #edf2f7;
            text-align: center;
            padding: 12px;
            font-size: 11.5px;
            color: #64748b;
            font-weight: 500;
        }

        /* PRINT STYLES - Crisp A4 Clean Output */
        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
                color: #000000 !important;
            }
            .receipt-toolbar, .no-print {
                display: none !important;
            }
            .receipt-card {
                box-shadow: none !important;
                border: 1px solid #cbd5e1 !important;
                max-width: 100% !important;
                margin: 0 !important;
                border-radius: 0 !important;
            }
            .receipt-inner {
                padding: 1.5rem 2rem !important;
            }
            @page {
                size: A4 portrait;
                margin: 12mm;
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
        $backText = 'Back to Admin Portal';
    } else {
        $backUrl = ($clinic && ($clinic->subdomain || $clinic->slug)) 
            ? url('/c/' . ($clinic->subdomain ?? $clinic->slug)) 
            : url('/');
        $backText = 'Back to Clinic Home';
    }

    $receiptNo = 'REC-' . ($order->created_at ? \Carbon\Carbon::parse($order->created_at)->format('Y') : date('Y')) . '-' . str_pad($order->id, 5, '0', STR_PAD_LEFT);
    $waText = urlencode("Hello, here is my official consultation receipt #{$receiptNo} from {$clinic->name} for my appointment on " . ($order->booking_date ? date('d M Y', strtotime($order->booking_date)) : ''));
@endphp

<div class="container-fluid px-0">
    <!-- Top Action Toolbar (Hidden in Print) -->
    <div class="receipt-toolbar">
        <div>
            <a href="{{ $backUrl }}" class="btn-toolbar-back">
                <i class="fa-solid fa-arrow-left"></i> {{ $backText }}
            </a>
        </div>
        <div class="d-flex align-items-center gap-2">
            @if($cleanPhone)
            <a href="https://wa.me/91{{ $cleanPhone }}?text={{ $waText }}" target="_blank" class="btn-toolbar-wa" title="Share via WhatsApp">
                <i class="fa-brands fa-whatsapp font-15"></i> WhatsApp
            </a>
            @endif
            <button class="btn-toolbar-print" onclick="window.print()">
                <i class="fa-solid fa-print font-15"></i> Print / Download PDF
            </button>
        </div>
    </div>

    <!-- Official Patient Receipt Card -->
    <div class="receipt-card">
        <div class="receipt-top-stripe"></div>

        <div class="receipt-inner">
            <!-- Clinic Letterhead Header -->
            <div class="clinic-brand-header">
                <div>
                    <div class="clinic-logo-wrapper mb-2">
                        @if($logoPath)
                            <img src="{{ $logoPath }}" alt="{{ $clinic->name }}" class="clinic-logo-img" onerror="this.style.display='none'; document.getElementById('fallback-logo-crest').style.display='flex';">
                            <div class="clinic-fallback-avatar" id="fallback-logo-crest" style="display: none;">
                                <i class="fa-solid fa-staff-snake"></i>
                            </div>
                        @else
                            <div class="clinic-fallback-avatar">
                                <i class="fa-solid fa-staff-snake"></i>
                            </div>
                        @endif
                        <div>
                            <div class="clinic-title">{{ $clinic->name ?? 'Dr Clinic Medical Center' }}</div>
                            <div class="clinic-specialty">{{ $clinic->specialization ?? 'Specialized Outpatient Consultation Clinic' }}</div>
                        </div>
                    </div>
                    <div class="clinic-contact-line">
                        <i class="fa-solid fa-location-dot me-1 text-muted"></i>
                        {{ $setting->clinic_address ?? ($clinic->address ?? 'Main Clinic Avenue, Healthcare District') }}<br>
                        <i class="fa-solid fa-phone me-1 text-muted"></i> Phone: <strong>{{ $setting->clinic_phone_number ?? ($clinic->phone ?? '+91 9830012345') }}</strong>
                        &bull; <i class="fa-solid fa-envelope me-1 text-muted"></i> Email: <strong>{{ $setting->clinic_email ?? ($clinic->email ?? 'doctor@drclinic.com') }}</strong>
                    </div>
                </div>

                <!-- Right: Document Receipt Metadata -->
                <div class="document-title-meta">
                    <div class="receipt-badge-title">CONSULTATION RECEIPT</div>
                    <div class="receipt-number-pill">#{{ $receiptNo }}</div>
                    <div class="receipt-date-text">
                        Issued: <strong>{{ ($order && $order->created_at) ? \Carbon\Carbon::parse($order->created_at)->format('d M Y, h:i A') : date('d M Y') }}</strong>
                    </div>
                    <div>
                        @if($order->payment_status === 'success')
                            <span class="status-seal-success">
                                <i class="fa-solid fa-circle-check"></i> PAYMENT SETTLED
                            </span>
                        @elseif($order->payment_status === 'pending' || $isCash)
                            <span class="status-seal-pending">
                                <i class="fa-solid fa-hourglass-half"></i> CASH AT CLINIC / PENDING
                            </span>
                        @elseif($order->payment_status === 'cancelled')
                            <span class="status-seal-cancelled">
                                <i class="fa-solid fa-circle-xmark"></i> CANCELLED
                            </span>
                        @else
                            <span class="status-seal-pending">{{ strtoupper($order->payment_status ?? 'PENDING') }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Patient & Appointment Particulars Grid -->
            <div class="patient-schedule-box">
                <div class="row g-3">
                    <!-- Patient Column -->
                    <div class="col-md-6 pe-md-3 border-end-md">
                        <div class="receipt-section-header">
                            <i class="fa-solid fa-id-card-clip"></i> Patient Particulars
                        </div>
                        <div class="row g-2">
                            <div class="col-sm-6">
                                <div class="info-cell-label">Patient Name</div>
                                <div class="info-cell-value">
                                    {{ trim(($order->first_name ?? '') . ' ' . ($order->last_name ?? '')) ?: 'Patient #' . $order->patient_id }}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="info-cell-label">Patient Record ID</div>
                                <div class="info-cell-value info-cell-value-highlight">
                                    #PID-{{ $order->patient_id ?: $order->id }}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="info-cell-label">Age &amp; Gender</div>
                                <div class="info-cell-value">
                                    {{ $order->age ? $order->age . ' Yrs' : 'N/A' }} / {{ ucfirst($order->sex ?? 'Unspecified') }}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="info-cell-label">Contact Mobile</div>
                                <div class="info-cell-value">
                                    {{ $order->mobile_no ?? 'N/A' }}
                                    @if(!empty($order->alternate_mobile_no))
                                        <small class="text-muted d-block font-11">Alt: {{ $order->alternate_mobile_no }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="info-cell-label">Residential Address</div>
                                <div class="info-cell-value mb-0 text-muted" style="font-size: 13px;">
                                    {{ $order->address ?: 'Residential address not specified' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Consultation Schedule Column -->
                    <div class="col-md-6 ps-md-3">
                        <div class="receipt-section-header">
                            <i class="fa-solid fa-calendar-check"></i> Consultation Particulars
                        </div>
                        <div class="row g-2">
                            <div class="col-sm-6">
                                <div class="info-cell-label">Consultation Date</div>
                                <div class="info-cell-value">
                                    {{ $order->booking_date ? \Carbon\Carbon::parse($order->booking_date)->format('D, d M Y') : 'Confirmed' }}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="info-cell-label">Allocated Slot</div>
                                <div class="info-cell-value">
                                    @if(!empty($order->from_time) && !empty($order->to_time))
                                        {{ \Carbon\Carbon::parse($order->from_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($order->to_time)->format('h:i A') }}
                                    @else
                                        Standard OPD Slot
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="info-cell-label">Attending Doctor</div>
                                <div class="info-cell-value">
                                    {{ $doctor->name ?? 'Dr. Specialist' }}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="info-cell-label">Department</div>
                                <div class="info-cell-value">
                                    {{ $clinic->specialization ?? 'Outpatient Medicine' }}
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="info-cell-label">Chief Complaint / Symptoms</div>
                                <div class="info-cell-value mb-0" style="color: var(--rx-primary-dark); font-size: 13px;">
                                    {{ $order->patient_problem ?: 'General Medical Consultation & Clinical Evaluation' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Itemized Billing Table -->
            <div class="receipt-section-header">
                <i class="fa-solid fa-receipt"></i> Itemized Fee &amp; Services Summary
            </div>
            <table class="receipt-table">
                <thead>
                    <tr>
                        <th style="width: 45%;">Service / Item Description</th>
                        <th style="width: 20%;">Department</th>
                        <th class="text-center" style="width: 10%;">Qty</th>
                        <th class="text-end" style="width: 12%;">Rate</th>
                        <th class="text-end" style="width: 13%;">Amount (₹)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong class="text-dark d-block">Specialist Doctor Consultation &amp; Clinical Checkup</strong>
                            <small class="text-muted font-12">Comprehensive in-clinic medical assessment by {{ $doctor->name ?? 'Attending Consultant' }}</small>
                        </td>
                        <td class="text-muted">Clinical OPD</td>
                        <td class="text-center font-weight-bold">1</td>
                        <td class="text-end">₹ {{ number_format($consultFee, 2) }}</td>
                        <td class="text-end font-weight-bold text-dark">₹ {{ number_format($consultFee, 2) }}</td>
                    </tr>
                    @if($platformFee > 0)
                    <tr>
                        <td>
                            <strong class="text-dark d-block">Digital Health Record &amp; Clinic Administration</strong>
                            <small class="text-muted font-12">Online booking confirmation, notification dispatch, and digital EHR maintenance</small>
                        </td>
                        <td class="text-muted">Administration</td>
                        <td class="text-center font-weight-bold">1</td>
                        <td class="text-end">₹ {{ number_format($platformFee, 2) }}</td>
                        <td class="text-end font-weight-bold text-dark">₹ {{ number_format($platformFee, 2) }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>

            <!-- Totals & Amount in Words Panel -->
            <div class="receipt-totals-panel">
                <div class="words-panel">
                    <div class="words-title">Total Amount in Words</div>
                    <div class="words-value">{{ numberToWords($totalPaid) }}</div>
                    <div class="text-muted font-11 mt-2">
                        <i class="fa-solid fa-shield-halved text-success me-1"></i> GST Notification Exempt: Healthcare diagnosis and outpatient care services are exempt from Goods &amp; Services Tax.
                    </div>
                </div>

                <div class="calculation-card">
                    <div class="calc-row">
                        <span>Consultation Fee:</span>
                        <strong>₹ {{ number_format($consultFee, 2) }}</strong>
                    </div>
                    @if($platformFee > 0)
                    <div class="calc-row">
                        <span>Platform &amp; Processing:</span>
                        <strong>₹ {{ number_format($platformFee, 2) }}</strong>
                    </div>
                    @endif
                    <div class="calc-row">
                        <span>Applicable Taxes (GST):</span>
                        <span class="badge bg-light text-muted border font-11">0.00 (Exempt)</span>
                    </div>
                    <div class="calc-row grand-total">
                        <span>Grand Total Paid:</span>
                        <span class="total-price">₹ {{ number_format($totalPaid, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Settlement Transaction Strip -->
            <div class="payment-meta-card">
                <div>
                    <div class="meta-field-label">Payment Mode</div>
                    <div class="meta-field-val">
                        @if($isCash)
                            <i class="fa-solid fa-money-bill-wave text-warning me-1"></i> Cash at Clinic Desk
                        @else
                            <i class="fa-solid fa-credit-card text-success me-1"></i> Razorpay Online Gateway
                        @endif
                    </div>
                </div>
                <div>
                    <div class="meta-field-label">Gateway Payment ID</div>
                    <div class="meta-field-val">{{ $order->razorpay_payment_id ?: 'CASH_PAYMENT_DESK' }}</div>
                </div>
                <div>
                    <div class="meta-field-label">Transaction / Order Ref</div>
                    <div class="meta-field-val">#{{ $order->transaction_id ?: ('TXN_' . $order->id) }}</div>
                </div>
                <div>
                    <div class="meta-field-label">Settlement Status</div>
                    <div class="meta-field-val text-success">
                        <i class="fa-solid fa-circle-check me-1"></i> {{ strtoupper($order->payment_status ?: 'CONFIRMED') }}
                    </div>
                </div>
            </div>

            <!-- Footer: Instructions & Signature Seal -->
            <div class="receipt-footer-row">
                <div class="instructions-list">
                    <div class="fw-bold text-dark mb-1 font-12">
                        <i class="fa-solid fa-circle-info text-teal me-1" style="color: var(--rx-primary);"></i> Patient Consultation Guidelines:
                    </div>
                    <div>1. Please report to the reception counter 15 minutes before your booked time slot.</div>
                    <div>2. Bring all previous prescriptions, lab reports, MRI/CT scans, and current medicines.</div>
                    <div>3. This receipt is computer-generated and serves as an official clinical payment voucher for medical reimbursement and insurance purposes.</div>
                </div>

                <div class="signature-box">
                    <div class="clinic-stamp-badge">
                        <span>{{ strtoupper(substr($clinic->name ?? 'CLINIC', 0, 8)) }}</span>
                        <i class="fa-solid fa-award" style="font-size: 14px; margin: 2px 0;"></i>
                        <span>VERIFIED</span>
                    </div>
                    <div class="signature-line"></div>
                    <div class="signatory-title">Authorized Signatory</div>
                    <div class="signatory-subtitle">{{ $clinic->name ?? 'Clinical Administration' }}</div>
                </div>
            </div>
        </div>

        <div class="thankyou-bar">
            Thank you for choosing <strong>{{ $clinic->name ?? 'our clinic' }}</strong>. Wishing you good health and a speedy recovery.
        </div>
    </div>
</div>

</body>
</html>
