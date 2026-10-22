@extends('admin.layouts.main')

@section('style')
<style>
/* Modern Patient Case File Styles */
.patient-hero-card {
  background: #ffffff;
  border-radius: 20px;
  border: 1.5px solid #e2e8f0;
  box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
  position: relative;
  overflow: hidden;
}
.patient-hero-card::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 5px;
  background: var(--theme-primary-gradient, linear-gradient(135deg, #059669, #10b981));
}
.patient-avatar-large {
  width: 72px;
  height: 72px;
  border-radius: 18px;
  background: var(--theme-primary-gradient, linear-gradient(135deg, #059669, #10b981));
  color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 28px;
  font-weight: 800;
  letter-spacing: -0.5px;
  box-shadow: 0 8px 18px var(--theme-primary-glow, rgba(5, 150, 105, 0.25));
  flex-shrink: 0;
}
.clinical-card {
  background: #ffffff;
  border-radius: 18px;
  border: 1.5px solid #e2e8f0;
  box-shadow: 0 2px 12px rgba(15, 23, 42, 0.03);
  transition: all 0.2s ease;
}
.clinical-card:hover {
  border-color: #cbd5e1;
}
.clinical-card-header {
  padding: 18px 22px;
  border-bottom: 1px solid #f1f5f9;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.clinical-card-body {
  padding: 22px;
}
.attribute-tile {
  background: #f8fafc;
  border: 1px solid #edf2f7;
  border-radius: 12px;
  padding: 14px 16px;
  height: 100%;
}
.attribute-label {
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.6px;
  color: #64748b;
  margin-bottom: 4px;
}
.attribute-value {
  font-size: 14.5px;
  font-weight: 700;
  color: #0f172a;
  word-break: break-word;
}
.chief-complaint-box {
  background: var(--theme-primary-subtle, #ecfdf5);
  border: 1.5px solid var(--theme-primary-border, #a7f3d0);
  border-radius: 14px;
  padding: 18px 20px;
  position: relative;
}
.status-option-label {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 14px 16px;
  border: 1.5px solid #e2e8f0;
  border-radius: 12px;
  cursor: pointer;
  background: #ffffff;
  transition: all 0.2s ease;
  margin-bottom: 10px;
}
.status-option-label:hover {
  background: #f8fafc;
  border-color: #cbd5e1;
}
.status-option-radio:checked + .status-option-label.status-opt-confirmed {
  border-color: #059669;
  background: #ecfdf5;
  box-shadow: 0 0 0 2px rgba(5, 150, 105, 0.2);
}
.status-option-radio:checked + .status-option-label.status-opt-completed {
  border-color: #0284c7;
  background: #f0f9ff;
  box-shadow: 0 0 0 2px rgba(2, 132, 199, 0.2);
}
.status-option-radio:checked + .status-option-label.status-opt-pending {
  border-color: #f59e0b;
  background: #fffbeb;
  box-shadow: 0 0 0 2px rgba(245, 158, 11, 0.2);
}
.status-option-radio:checked + .status-option-label.status-opt-cancelled {
  border-color: #ef4444;
  background: #fef2f2;
  box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.2);
}

/* Print Specific Styles */
@media print {
  body {
    background: #ffffff !important;
    color: #000000 !important;
  }
  .no-print,
  .sidebar,
  .header,
  .footer,
  .navbar,
  .btn,
  .main-panel-header,
  #theme-settings {
    display: none !important;
  }
  .content-wrapper, .container-fluid, .container-xxl {
    padding: 0 !important;
    margin: 0 !important;
  }
  .patient-hero-card, .clinical-card {
    box-shadow: none !important;
    border: 1px solid #ccc !important;
    page-break-inside: avoid;
  }
  .print-header-banner {
    display: block !important;
    border-bottom: 2px solid #000;
    padding-bottom: 15px;
    margin-bottom: 20px;
  }
}
@media screen {
  .print-header-banner {
    display: none;
  }
}
</style>
@endsection

@section('content')
<div class="content-wrapper p-3 p-md-4">
  @php
    $bookingDate = $order->booking_date ? \Carbon\Carbon::parse($order->booking_date) : null;
    $refCode = 'ENO-' . ($bookingDate ? $bookingDate->format('Ymd') : date('Ymd', strtotime($order->created_at))) . '-' . strtoupper(substr(md5($order->id), 0, 4));
    $initials = strtoupper(substr($order->first_name ?? 'P', 0, 1) . substr($order->last_name ?? 'T', 0, 1));
    $cleanPhone = preg_replace('/[^0-9]/', '', $order->mobile_no ?? '');
  @endphp

  <!-- Alert Messages -->
  @if(session('success'))
  <div class="alert alert-success alert-dismissible fade show rounded-4 p-3 mb-4 shadow-sm border-0 d-flex align-items-center justify-content-between" role="alert" style="background: #ecfdf5; border-left: 4px solid #059669 !important; color: #065f46;">
    <div class="d-flex align-items-center gap-2">
      <i class="mdi mdi-check-circle font-20 text-success"></i>
      <strong>{{ session('success') }}</strong>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  @if(session('error'))
  <div class="alert alert-danger alert-dismissible fade show rounded-4 p-3 mb-4 shadow-sm border-0 d-flex align-items-center justify-content-between" role="alert" style="background: #fef2f2; border-left: 4px solid #ef4444 !important; color: #991b1b;">
    <div class="d-flex align-items-center gap-2">
      <i class="mdi mdi-alert-circle font-20 text-danger"></i>
      <strong>{{ session('error') }}</strong>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  <!-- Top Navigation & Action Header (no-print) -->
  <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4 no-print">
    <div class="d-flex align-items-center gap-3">
      <a href="{{ url('admin/patient') }}" class="btn btn-light border d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 42px; height: 42px; border-radius: 12px; background: #ffffff; color: #475569;" title="Back to Patient Bookings">
        <i class="mdi mdi-arrow-left font-20"></i>
      </a>
      <div>
        <div class="text-muted font-12 mb-0">
          <a href="{{ route('clinic.dashboard') }}" class="text-muted text-decoration-none">Dashboard</a>
          <span class="mx-1">/</span>
          <a href="{{ url('admin/booking_history') }}" class="text-muted text-decoration-none">Booking History</a>
          <span class="mx-1">/</span>
          <span class="text-dark font-weight-bold">{{ $refCode }}</span>
        </div>
        <h2 class="font-weight-bold text-dark mb-0" style="font-size: 22px; letter-spacing: -0.5px;">Patient Consultation File</h2>
      </div>
    </div>

    <div class="d-flex align-items-center gap-2 flex-wrap">
      @if($cleanPhone)
      <a href="https://wa.me/{{ $cleanPhone }}?text=Hello%20{{ urlencode($order->first_name) }},%20this%20is%20regarding%20your%20appointment%20with%20our%20clinic." target="_blank" class="btn btn-sm font-weight-bold px-3 py-2 d-inline-flex align-items-center gap-1" style="background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; border-radius: 10px;">
        <i class="mdi mdi-whatsapp font-18"></i> WhatsApp Patient
      </a>
      <a href="tel:{{ $order->mobile_no }}" class="btn btn-sm font-weight-bold px-3 py-2 d-inline-flex align-items-center gap-1" style="background: #f1f5f9; color: #334155; border: 1px solid #cbd5e1; border-radius: 10px;">
        <i class="mdi mdi-phone font-16"></i> Call
      </a>
      @endif

      <button class="btn btn-primary btn-sm font-weight-bold px-3 py-2 d-inline-flex align-items-center gap-1 shadow-sm" onclick="window.print()" style="border-radius: 10px;">
        <i class="mdi mdi-printer font-16"></i> Print Case Slip
      </button>
    </div>
  </div>

  <!-- Print Letterhead Banner (Visible only when printed) -->
  <div class="print-header-banner">
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <h2 style="margin: 0; font-size: 24px; font-weight: 800; color: #0f172a;">{{ $clinic->name ?? 'DrClinic Health Portal' }}</h2>
        <div style="font-size: 13px; color: #475569;">{{ $clinic->specialization ?? 'Medical & Clinical Care' }} • Storefront Consultation Slip</div>
      </div>
      <div style="text-align: right;">
        <div style="font-weight: 700; font-size: 13px;">Ref: {{ $refCode }}</div>
        <div style="font-size: 12px; color: #64748b;">Date: {{ date('d M Y, h:i A') }}</div>
      </div>
    </div>
  </div>

  <div id="printablePatientArea">
    <!-- Hero Patient Identity Banner -->
    <div class="patient-hero-card p-4 mb-4">
      <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
        <div class="d-flex align-items-center gap-3">
          <div class="patient-avatar-large">
            {{ $initials }}
          </div>
          <div>
            <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
              <h3 class="font-weight-bold text-dark mb-0" style="font-size: 22px;">
                {{ $order->first_name }} {{ $order->last_name }}
              </h3>
              <span class="badge" style="background: var(--theme-primary-subtle, #ecfdf5); color: var(--theme-primary, #059669); border: 1px solid var(--theme-primary-border, #a7f3d0); font-size: 11.5px; font-weight: 700; padding: 4px 10px; border-radius: 20px;">
                <span style="display: inline-block; width: 6px; height: 6px; border-radius: 50%; background: var(--theme-primary, #059669); margin-right: 5px;"></span>
                {{ $refCode }}
              </span>
            </div>
            <div class="text-muted font-13 d-flex align-items-center flex-wrap gap-2">
              <span><i class="mdi mdi-gender-male-female mr-1"></i> {{ ucfirst($order->sex ?? 'Unspecified') }}</span>
              <span>•</span>
              <span><i class="mdi mdi-calendar-heart mr-1"></i> {{ $order->age ?? 'N/A' }} Years Old</span>
              @if($order->dob)
              <span>•</span>
              <span><i class="mdi mdi-cake-variant mr-1"></i> DOB: {{ date('d M Y', strtotime($order->dob)) }}</span>
              @endif
              <span>•</span>
              <span class="font-weight-bold text-dark"><i class="mdi mdi-phone mr-1"></i> {{ $order->mobile_no }}</span>
            </div>
          </div>
        </div>

        <div class="text-md-end">
          <div class="mb-2">
            @if($order->status === 'confirmed')
              <span class="badge" style="background: #ecfdf5; color: #059669; border: 1.5px solid #a7f3d0; font-size: 13px; font-weight: 700; padding: 7px 16px; border-radius: 30px;">
                <i class="mdi mdi-check-circle mr-1"></i> Confirmed Booking
              </span>
            @elseif($order->status === 'completed')
              <span class="badge" style="background: #f0f9ff; color: #0284c7; border: 1.5px solid #bae6fd; font-size: 13px; font-weight: 700; padding: 7px 16px; border-radius: 30px;">
                <i class="mdi mdi-check-all mr-1"></i> Completed Consultation
              </span>
            @elseif($order->status === 'cancelled')
              <span class="badge" style="background: #fef2f2; color: #dc2626; border: 1.5px solid #fecdd3; font-size: 13px; font-weight: 700; padding: 7px 16px; border-radius: 30px;">
                <i class="mdi mdi-close-circle mr-1"></i> Cancelled
              </span>
            @else
              <span class="badge" style="background: #fffbeb; color: #d97706; border: 1.5px solid #fde68a; font-size: 13px; font-weight: 700; padding: 7px 16px; border-radius: 30px;">
                <i class="mdi mdi-clock-outline mr-1"></i> Pending Confirmation
              </span>
            @endif
          </div>
          <div>
            <span class="text-muted font-11 text-uppercase font-weight-bold d-block">Consultation Fee</span>
            <span class="font-weight-bold" style="color: var(--theme-primary, #059669); font-size: 22px;">₹{{ number_format($order->total_amount, 2) }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content Layout (7 Cols Left / 5 Cols Right) -->
    <div class="row g-4">
      <!-- Left Column: Medical & Patient Details -->
      <div class="col-lg-7">
        
        <!-- Card 1: Chief Complaint & Symptoms -->
        <div class="clinical-card mb-4">
          <div class="clinical-card-header">
            <h5 class="fw-bold text-dark mb-0 d-flex align-items-center font-15">
              <span class="d-inline-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; border-radius: 8px; background: var(--theme-primary-subtle, #ecfdf5); color: var(--theme-primary, #059669);">
                <i class="mdi mdi-stethoscope font-18"></i>
              </span>
              Chief Medical Complaint &amp; Clinical Symptoms
            </h5>
            <span class="badge bg-light text-muted font-11">Patient Intake Note</span>
          </div>
          <div class="clinical-card-body">
            <div class="chief-complaint-box">
              <div class="d-flex align-items-start gap-2">
                <i class="mdi mdi-format-quote-open font-22" style="color: var(--theme-primary, #059669); opacity: 0.8; line-height: 1;"></i>
                <div class="font-15 text-dark" style="font-weight: 600; line-height: 1.6;">
                  {{ $order->patient_problem ?: 'No preliminary symptoms recorded during appointment creation.' }}
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Card 2: Patient Demographics & Contact Information -->
        <div class="clinical-card mb-4">
          <div class="clinical-card-header">
            <h5 class="fw-bold text-dark mb-0 d-flex align-items-center font-15">
              <span class="d-inline-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; border-radius: 8px; background: #e0f2fe; color: #0284c7;">
                <i class="mdi mdi-account-box-outline font-18"></i>
              </span>
              Patient Demographics &amp; Contact Records
            </h5>
          </div>
          <div class="clinical-card-body">
            <div class="row g-3">
              <div class="col-sm-6">
                <div class="attribute-tile">
                  <div class="attribute-label">First Name</div>
                  <div class="attribute-value">{{ $order->first_name ?? '-' }}</div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="attribute-tile">
                  <div class="attribute-label">Last Name</div>
                  <div class="attribute-value">{{ $order->last_name ?? '-' }}</div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="attribute-tile">
                  <div class="attribute-label">Date of Birth</div>
                  <div class="attribute-value">
                    {{ $order->dob ? date('d F Y', strtotime($order->dob)) : 'Not Specified' }}
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="attribute-tile">
                  <div class="attribute-label">Age &amp; Gender</div>
                  <div class="attribute-value">
                    {{ $order->age ?? 'N/A' }} Years • {{ ucfirst($order->sex ?? 'N/A') }}
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="attribute-tile">
                  <div class="attribute-label">Primary Mobile No</div>
                  <div class="attribute-value text-primary d-flex align-items-center justify-content-between">
                    <span>{{ $order->mobile_no ?? 'N/A' }}</span>
                    @if($cleanPhone)
                    <a href="tel:{{ $order->mobile_no }}" class="btn btn-xs btn-outline-primary" style="padding: 2px 8px; font-size: 11px; border-radius: 6px;">Call</a>
                    @endif
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="attribute-tile">
                  <div class="attribute-label">Alternate Mobile No</div>
                  <div class="attribute-value">{{ $order->alternate_mobile_no ?: 'None Provided' }}</div>
                </div>
              </div>
              <div class="col-12">
                <div class="attribute-tile">
                  <div class="attribute-label">Residential Address</div>
                  <div class="attribute-value d-flex align-items-center gap-2">
                    <i class="mdi mdi-map-marker-outline text-muted"></i>
                    <span>{{ $order->address ?: 'No physical address recorded' }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Card 3: Appointment Schedule & Financial Details -->
        <div class="clinical-card mb-4">
          <div class="clinical-card-header">
            <h5 class="fw-bold text-dark mb-0 d-flex align-items-center font-15">
              <span class="d-inline-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; border-radius: 8px; background: #fef3c7; color: #d97706;">
                <i class="mdi mdi-calendar-clock font-18"></i>
              </span>
              Appointment Schedule &amp; Financials
            </h5>
          </div>
          <div class="clinical-card-body">
            <div class="row g-3">
              <div class="col-sm-6">
                <div class="attribute-tile">
                  <div class="attribute-label">Consultation Date</div>
                  <div class="attribute-value d-flex align-items-center gap-2">
                    <i class="mdi mdi-calendar-check text-success"></i>
                    <span>{{ $order->booking_date ? date('l, d M Y', strtotime($order->booking_date)) : '-' }}</span>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="attribute-tile">
                  <div class="attribute-label">Allocated Time Slot</div>
                  <div class="attribute-value d-flex align-items-center gap-2">
                    <i class="mdi mdi-clock-time-four-outline text-primary"></i>
                    <span class="badge" style="background: var(--theme-primary-subtle, #ecfdf5); color: var(--theme-primary, #059669); font-size: 13px; font-weight: 700;">
                      {{ date('h:i A', strtotime($order->from_time)) }} - {{ date('h:i A', strtotime($order->to_time)) }}
                    </span>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="attribute-tile">
                  <div class="attribute-label">Payment Amount</div>
                  <div class="attribute-value font-weight-bold" style="color: var(--theme-primary, #059669);">
                    ₹{{ number_format($order->total_amount, 2) }}
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="attribute-tile">
                  <div class="attribute-label">Transaction Reference</div>
                  <div class="attribute-value text-muted font-monospace font-13">
                    #{{ $order->transaction_id ?: 'MANUAL-ENTRY' }}
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="attribute-tile">
                  <div class="attribute-label">Payment Status</div>
                  <div class="attribute-value">
                    <span class="badge" style="background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; font-size: 12px; font-weight: 700;">
                      <i class="mdi mdi-check-circle me-1"></i> Paid (Online / Direct)
                    </span>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="attribute-tile">
                  <div class="attribute-label">Record Created At</div>
                  <div class="attribute-value text-muted font-13">
                    {{ $order->created_at ? date('d M Y, h:i A', strtotime($order->created_at)) : date('d M Y', strtotime($order->booking_date)) }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- Right Column: Lifecycle Control & Doctor Notes -->
      <div class="col-lg-5">
        
        <!-- Status Lifecycle Update Form (no-print) -->
        <div class="clinical-card mb-4 no-print" style="border: 2px solid var(--theme-primary-border, #a7f3d0);">
          <div class="clinical-card-header bg-white">
            <h5 class="fw-bold text-dark mb-0 d-flex align-items-center font-15">
              <span class="d-inline-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; border-radius: 8px; background: var(--theme-primary-subtle, #ecfdf5); color: var(--theme-primary, #059669);">
                <i class="mdi mdi-progress-check font-18"></i>
              </span>
              Update Consultation Status
            </h5>
          </div>
          <div class="clinical-card-body">
            <p class="text-muted font-13 mb-3">Transition this appointment through the clinic consultation workflow:</p>
            
            <form action="{{ url('admin/patient-history/update-status/'.$order->id) }}" method="POST">
              @csrf

              <!-- Option 1: Confirmed -->
              <input type="radio" class="d-none status-option-radio" name="status" id="opt_confirmed" value="confirmed" {{ $order->status === 'confirmed' ? 'checked' : '' }}>
              <label for="opt_confirmed" class="status-option-label status-opt-confirmed">
                <div class="d-flex align-items-center gap-3">
                  <span class="d-flex align-items-center justify-content-center rounded-circle" style="width: 32px; height: 32px; background: #ecfdf5; color: #059669;">
                    <i class="mdi mdi-check-circle font-18"></i>
                  </span>
                  <div>
                    <div class="font-weight-bold text-dark font-14">Confirmed</div>
                    <div class="text-muted font-11">Slot confirmed, patient expected at clinic</div>
                  </div>
                </div>
                <i class="mdi mdi-radiobox-marked font-20 text-success"></i>
              </label>

              <!-- Option 2: Completed -->
              <input type="radio" class="d-none status-option-radio" name="status" id="opt_completed" value="completed" {{ $order->status === 'completed' ? 'checked' : '' }}>
              <label for="opt_completed" class="status-option-label status-opt-completed">
                <div class="d-flex align-items-center gap-3">
                  <span class="d-flex align-items-center justify-content-center rounded-circle" style="width: 32px; height: 32px; background: #f0f9ff; color: #0284c7;">
                    <i class="mdi mdi-check-all font-18"></i>
                  </span>
                  <div>
                    <div class="font-weight-bold text-dark font-14">Completed</div>
                    <div class="text-muted font-11">Doctor consultation &amp; diagnosis finished</div>
                  </div>
                </div>
                <i class="mdi mdi-radiobox-marked font-20 text-info"></i>
              </label>

              <!-- Option 3: Pending -->
              <input type="radio" class="d-none status-option-radio" name="status" id="opt_pending" value="pending" {{ $order->status === 'pending' ? 'checked' : '' }}>
              <label for="opt_pending" class="status-option-label status-opt-pending">
                <div class="d-flex align-items-center gap-3">
                  <span class="d-flex align-items-center justify-content-center rounded-circle" style="width: 32px; height: 32px; background: #fffbeb; color: #d97706;">
                    <i class="mdi mdi-clock-outline font-18"></i>
                  </span>
                  <div>
                    <div class="font-weight-bold text-dark font-14">Pending</div>
                    <div class="text-muted font-11">Awaiting clinic confirmation or time review</div>
                  </div>
                </div>
                <i class="mdi mdi-radiobox-marked font-20 text-warning"></i>
              </label>

              <!-- Option 4: Cancelled -->
              <input type="radio" class="d-none status-option-radio" name="status" id="opt_cancelled" value="cancelled" {{ $order->status === 'cancelled' ? 'checked' : '' }}>
              <label for="opt_cancelled" class="status-option-label status-opt-cancelled">
                <div class="d-flex align-items-center gap-3">
                  <span class="d-flex align-items-center justify-content-center rounded-circle" style="width: 32px; height: 32px; background: #fef2f2; color: #dc2626;">
                    <i class="mdi mdi-close-circle font-18"></i>
                  </span>
                  <div>
                    <div class="font-weight-bold text-dark font-14">Cancelled</div>
                    <div class="text-muted font-11">Patient cancelled or no-show recorded</div>
                  </div>
                </div>
                <i class="mdi mdi-radiobox-marked font-20 text-danger"></i>
              </label>

              <div class="form-actions-end mt-4">
                <a href="{{ url('admin/booking_history') }}" class="btn btn-light px-3 py-2 font-weight-bold" style="border: 1px solid #cbd5e1; border-radius: 8px;">Back</a>
                <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold" style="border-radius: 8px;">
                  <i class="mdi mdi-content-save-check-outline me-1"></i> Update Status
                </button>
              </div>
            </form>
          </div>
        </div>

        <!-- Card: Clinical Doctor Notes Pad (For Physical Print or Doctor Memo) -->
        <div class="clinical-card mb-4">
          <div class="clinical-card-header">
            <h5 class="fw-bold text-dark mb-0 d-flex align-items-center font-15">
              <span class="d-inline-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; border-radius: 8px; background: #f1f5f9; color: #475569;">
                <i class="mdi mdi-clipboard-text-outline font-18"></i>
              </span>
              Clinical Assessment &amp; Doctor Notes
            </h5>
          </div>
          <div class="clinical-card-body">
            <div style="min-height: 120px; border: 1.5px dashed #cbd5e1; border-radius: 12px; padding: 16px; background: #fafafa;">
              <div class="text-muted font-12 font-italic mb-2">Physician's Consultation Findings / Rx Recommendations:</div>
              <div style="border-bottom: 1px solid #e2e8f0; height: 26px;"></div>
              <div style="border-bottom: 1px solid #e2e8f0; height: 26px;"></div>
              <div style="border-bottom: 1px solid #e2e8f0; height: 26px;"></div>
              <div style="border-bottom: 1px solid #e2e8f0; height: 26px;"></div>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3 pt-2 text-muted font-12">
              <span>Physician In-Charge: <strong>Dr. Clinic Specialist</strong></span>
              <span>Signature: __________________</span>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- Patient's Complete History: All Visits & All Payments -->
    @if(isset($patient_orders) && count($patient_orders) > 0)
    <div class="clinical-card mb-4 mt-2">
      <div class="clinical-card-header d-flex align-items-center justify-content-between">
        <h5 class="fw-bold text-dark mb-0 d-flex align-items-center font-15">
          <span class="d-inline-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; border-radius: 8px; background: #ecfdf5; color: #059669;">
            <i class="mdi mdi-history font-18"></i>
          </span>
          Patient's Past Visit &amp; Payment History
        </h5>
        <span class="badge" style="background: var(--theme-primary-subtle, #ecfdf5); color: var(--theme-primary, #059669); font-weight: 700; border: 1px solid var(--theme-primary-border, #a7f3d0);">
          {{ count($patient_orders) }} Records On File
        </span>
      </div>
      <div class="clinical-card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead style="background: #f8fafc; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b;">
              <tr>
                <th class="py-3 px-3">Appointment Date</th>
                <th class="py-3 px-3">Slot</th>
                <th class="py-3 px-3">Amount</th>
                <th class="py-3 px-3">Payment Mode</th>
                <th class="py-3 px-3">Transaction / Ref</th>
                <th class="py-3 px-3">Status</th>
                <th class="py-3 px-3 text-end no-print">Action</th>
              </tr>
            </thead>
            <tbody style="font-size: 13.5px;">
              @foreach($patient_orders as $pOrder)
              @php
                $isCurrent = ($pOrder->id == $order->id);
                $isCash = ($pOrder->razorpay_payment_id === 'CASH_PAYMENT' || $pOrder->razorpay_payment_id === 'CASH_AT_CLINIC' || str_contains($pOrder->transaction_id ?? '', 'CASH'));
              @endphp
              <tr style="border-bottom: 1px solid #f1f5f9; {{ $isCurrent ? 'background: #f0fdf4;' : '' }}">
                <td class="py-3 px-3">
                  <div class="fw-bold text-dark font-14">
                    {{ $pOrder->booking_date ? date('d M Y', strtotime($pOrder->booking_date)) : '-' }}
                    @if($isCurrent)
                      <span class="badge bg-primary ms-1 font-11 text-white">Current Case</span>
                    @endif
                  </div>
                  <small class="text-muted font-11">Booked {{ date('d M Y', strtotime($pOrder->created_at)) }}</small>
                </td>
                <td class="py-3 px-3">
                  @if($pOrder->from_time && $pOrder->to_time)
                    <span class="badge" style="background: var(--theme-primary-subtle, #ecfdf5); color: var(--theme-primary, #059669); font-weight: 700;">
                      {{ date('h:i A', strtotime($pOrder->from_time)) }} - {{ date('h:i A', strtotime($pOrder->to_time)) }}
                    </span>
                  @else
                    <span class="text-muted font-12">-</span>
                  @endif
                </td>
                <td class="py-3 px-3 font-weight-bold" style="color: var(--theme-primary, #059669);">
                  ₹{{ number_format($pOrder->total_amount, 2) }}
                </td>
                <td class="py-3 px-3">
                  @if($isCash)
                    <span class="badge" style="background: #fef3c7; color: #92400e; font-weight: 600;">Cash at Clinic</span>
                  @else
                    <span class="badge" style="background: #e0f2fe; color: #0369a1; font-weight: 600;">Razorpay Online</span>
                  @endif
                </td>
                <td class="py-3 px-3 font-monospace font-11 text-muted">
                  {{ $pOrder->razorpay_payment_id ?: ($pOrder->transaction_id ?: 'MANUAL') }}
                </td>
                <td class="py-3 px-3">
                  @if($pOrder->status === 'confirmed')
                    <span class="badge" style="background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">Confirmed</span>
                  @elseif($pOrder->status === 'completed')
                    <span class="badge" style="background: #f0f9ff; color: #0284c7; border: 1px solid #bae6fd;">Completed</span>
                  @elseif($pOrder->status === 'cancelled')
                    <span class="badge" style="background: #fef2f2; color: #dc2626; border: 1px solid #fecdd3;">Cancelled</span>
                  @else
                    <span class="badge" style="background: #fffbeb; color: #d97706; border: 1px solid #fde68a;">Pending</span>
                  @endif
                </td>
                <td class="py-3 px-3 text-end no-print">
                  @if(!$isCurrent)
                    <a href="{{ url('admin/booking-history/view/'.$pOrder->id) }}" class="btn btn-sm btn-outline-primary font-weight-bold px-2 py-1" style="border-radius: 6px; font-size: 11.5px;">
                      View Record
                    </a>
                  @else
                    <span class="text-muted font-12 font-italic">Viewing</span>
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    @endif
  </div>
</div>
@endsection