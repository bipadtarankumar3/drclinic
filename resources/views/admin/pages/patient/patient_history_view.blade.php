@extends('admin.layouts.main')

@section('style')
<style>
/* Modern Patient History Styles */
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
  box-shadow: 0 8px 18px var(--theme-primary-glow, rgba(5, 150, 105, 0.25));
  flex-shrink: 0;
}
.clinical-card {
  background: #ffffff;
  border-radius: 18px;
  border: 1.5px solid #e2e8f0;
  box-shadow: 0 2px 12px rgba(15, 23, 42, 0.03);
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
}
.chief-complaint-box {
  background: var(--theme-primary-subtle, #ecfdf5);
  border: 1.5px solid var(--theme-primary-border, #a7f3d0);
  border-radius: 14px;
  padding: 18px 20px;
}
@media print {
  .no-print, .sidebar, .header, .footer, .navbar, .btn {
    display: none !important;
  }
}
</style>
@endsection

@section('content')
<div class="content-wrapper p-3 p-md-4">
  @php
    $initials = strtoupper(substr($patient->first_name ?? 'P', 0, 1) . substr($patient->last_name ?? 'T', 0, 1));
    $cleanPhone = preg_replace('/[^0-9]/', '', $patient->mobile_no ?? '');
  @endphp

  <!-- Top Navigation & Action Header (no-print) -->
  <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4 no-print">
    <div class="d-flex align-items-center gap-3">
      <a href="{{ url('admin/history_of_customer') }}" class="btn btn-light border d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 42px; height: 42px; border-radius: 12px; background: #ffffff; color: #475569;" title="Back to Patient History">
        <i class="mdi mdi-arrow-left font-20"></i>
      </a>
      <div>
        <div class="text-muted font-12 mb-0">
          <a href="{{ route('doctor.dashboard') }}" class="text-muted text-decoration-none">Dashboard</a>
          <span class="mx-1">/</span>
          <a href="{{ url('admin/history_of_customer') }}" class="text-muted text-decoration-none">Patient Master</a>
          <span class="mx-1">/</span>
          <span class="text-dark font-weight-bold">#PID-{{ $patient->id }}</span>
        </div>
        <h2 class="font-weight-bold text-dark mb-0" style="font-size: 22px; letter-spacing: -0.5px;">Patient Medical Record</h2>
      </div>
    </div>

    <div class="d-flex align-items-center gap-2 flex-wrap">
      @if($cleanPhone)
      <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" class="btn btn-sm font-weight-bold px-3 py-2 d-inline-flex align-items-center gap-1" style="background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; border-radius: 10px;">
        <i class="mdi mdi-whatsapp font-18"></i> WhatsApp
      </a>
      <a href="tel:{{ $patient->mobile_no }}" class="btn btn-sm font-weight-bold px-3 py-2 d-inline-flex align-items-center gap-1" style="background: #f1f5f9; color: #334155; border: 1px solid #cbd5e1; border-radius: 10px;">
        <i class="mdi mdi-phone font-16"></i> Call
      </a>
      @endif

      <button class="btn btn-primary btn-sm font-weight-bold px-3 py-2 d-inline-flex align-items-center gap-1 shadow-sm" onclick="window.print()" style="border-radius: 10px;">
        <i class="mdi mdi-printer font-16"></i> Print Record
      </button>
    </div>
  </div>

  <div id="printableArea">
    <!-- Hero Patient Banner -->
    <div class="patient-hero-card p-4 mb-4">
      <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
        <div class="d-flex align-items-center gap-3">
          <div class="patient-avatar-large">
            {{ $initials }}
          </div>
          <div>
            <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
              <h3 class="font-weight-bold text-dark mb-0" style="font-size: 22px;">
                {{ $patient->first_name }} {{ $patient->last_name }}
              </h3>
              <span class="badge" style="background: var(--theme-primary-subtle, #ecfdf5); color: var(--theme-primary, #059669); border: 1px solid var(--theme-primary-border, #a7f3d0); font-size: 11.5px; font-weight: 700; padding: 4px 10px; border-radius: 20px;">
                #PID-{{ $patient->id }}
              </span>
            </div>
            <div class="text-muted font-13 d-flex align-items-center flex-wrap gap-2">
              <span><i class="mdi mdi-gender-male-female mr-1"></i> {{ ucfirst($patient->sex ?? 'Unspecified') }}</span>
              <span>•</span>
              <span><i class="mdi mdi-calendar-heart mr-1"></i> {{ $patient->age ?? 'N/A' }} Years Old</span>
              @if($patient->dob)
              <span>•</span>
              <span><i class="mdi mdi-cake-variant mr-1"></i> DOB: {{ date('d M Y', strtotime($patient->dob)) }}</span>
              @endif
              <span>•</span>
              <span class="font-weight-bold text-dark"><i class="mdi mdi-phone mr-1"></i> {{ $patient->mobile_no }}</span>
            </div>
          </div>
        </div>
        <div>
          <span class="badge bg-light text-muted border px-3 py-2 rounded-pill font-12">
            Total Consultations: <strong>{{ count($orders) }}</strong>
          </span>
        </div>
      </div>
    </div>

    <!-- Quick KPI Summary Stats -->
    @php
      $totalSpent = $orders->where('payment_status', '!=', 'cancelled')->sum('total_amount');
      $completedCount = $orders->where('status', 'completed')->count();
      $lastBooking = $orders->first();
    @endphp
    <div class="row g-3 mb-4">
      <div class="col-sm-6 col-lg-3">
        <div class="clinical-card p-3 d-flex align-items-center gap-3">
          <div style="width: 46px; height: 46px; border-radius: 12px; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 22px;">
            <i class="mdi mdi-calendar-check-outline"></i>
          </div>
          <div>
            <div class="attribute-label mb-0">Total Consultations</div>
            <div class="font-weight-bold text-dark font-20">{{ count($orders) }} Visits</div>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-lg-3">
        <div class="clinical-card p-3 d-flex align-items-center gap-3">
          <div style="width: 46px; height: 46px; border-radius: 12px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center; font-size: 22px;">
            <i class="mdi mdi-currency-inr"></i>
          </div>
          <div>
            <div class="attribute-label mb-0">Total Payments Paid</div>
            <div class="font-weight-bold text-dark font-20">₹{{ number_format($totalSpent, 2) }}</div>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-lg-3">
        <div class="clinical-card p-3 d-flex align-items-center gap-3">
          <div style="width: 46px; height: 46px; border-radius: 12px; background: #f0fdf4; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 22px;">
            <i class="mdi mdi-check-all"></i>
          </div>
          <div>
            <div class="attribute-label mb-0">Completed Visits</div>
            <div class="font-weight-bold text-dark font-20">{{ $completedCount }} Consults</div>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-lg-3">
        <div class="clinical-card p-3 d-flex align-items-center gap-3">
          <div style="width: 46px; height: 46px; border-radius: 12px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 22px;">
            <i class="mdi mdi-clock-outline"></i>
          </div>
          <div>
            <div class="attribute-label mb-0">Last Consultation</div>
            <div class="font-weight-bold text-dark font-15">
              {{ $lastBooking && $lastBooking->booking_date ? date('d M Y', strtotime($lastBooking->booking_date)) : 'None' }}
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Patient Demographics Card -->
    <div class="clinical-card mb-4">
      <div class="clinical-card-header">
        <h5 class="fw-bold text-dark mb-0 d-flex align-items-center font-15">
          <span class="d-inline-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; border-radius: 8px; background: var(--theme-primary-subtle, #ecfdf5); color: var(--theme-primary, #059669);">
            <i class="mdi mdi-account-box-outline font-18"></i>
          </span>
          Patient Personal &amp; Medical Details
        </h5>
      </div>
      <div class="clinical-card-body">
        <div class="row g-3 mb-3">
          <div class="col-sm-6">
            <div class="attribute-tile">
              <div class="attribute-label">First Name</div>
              <div class="attribute-value">{{ $patient->first_name ?? '-' }}</div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="attribute-tile">
              <div class="attribute-label">Last Name</div>
              <div class="attribute-value">{{ $patient->last_name ?? '-' }}</div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="attribute-tile">
              <div class="attribute-label">Date of Birth &amp; Age</div>
              <div class="attribute-value">
                {{ $patient->dob ? date('d M Y', strtotime($patient->dob)) : 'N/A' }} ({{ $patient->age ?? 'N/A' }} Yrs)
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="attribute-tile">
              <div class="attribute-label">Gender</div>
              <div class="attribute-value">{{ ucfirst($patient->sex ?? 'N/A') }}</div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="attribute-tile">
              <div class="attribute-label">Primary Mobile No</div>
              <div class="attribute-value text-primary font-weight-bold">{{ $patient->mobile_no ?? '-' }}</div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="attribute-tile">
              <div class="attribute-label">Alternate Mobile No</div>
              <div class="attribute-value">{{ $patient->alternate_mobile_no ?: 'None' }}</div>
            </div>
          </div>
          <div class="col-12">
            <div class="attribute-tile">
              <div class="attribute-label">Residential Address</div>
              <div class="attribute-value d-flex align-items-center gap-2">
                <i class="mdi mdi-map-marker-outline text-muted"></i>
                <span>{{ $patient->address ?: 'No physical address recorded' }}</span>
              </div>
            </div>
          </div>
        </div>

        @if($patient->patient_problem)
        <div class="chief-complaint-box">
          <div class="attribute-label text-muted mb-1">Chief Medical Complaint / Known Diagnosis:</div>
          <div class="font-14 text-dark font-weight-bold">{{ $patient->patient_problem }}</div>
        </div>
        @endif
      </div>
    </div>

    <!-- Appointment & Visit History Table -->
    <div class="clinical-card mb-4">
      <div class="clinical-card-header">
        <h5 class="fw-bold text-dark mb-0 d-flex align-items-center font-15">
          <span class="d-inline-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; border-radius: 8px; background: #e0f2fe; color: #0284c7;">
            <i class="mdi mdi-history font-18"></i>
          </span>
          All Consultation &amp; Visit History
        </h5>
        <span class="badge bg-light text-muted font-11">{{ count($orders) }} Total Consultations</span>
      </div>
      <div class="clinical-card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead style="background: #f8fafc; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b;">
              <tr>
                <th class="py-3 px-3">Visit Date</th>
                <th class="py-3 px-3">Slot</th>
                <th class="py-3 px-3">Reason / Complaint</th>
                <th class="py-3 px-3">Payment</th>
                <th class="py-3 px-3">Visit Status</th>
                <th class="py-3 px-3 text-end no-print">Action</th>
              </tr>
            </thead>
            <tbody style="font-size: 13.5px;">
              @forelse($orders as $ord)
              <tr style="border-bottom: 1px solid #f1f5f9;">
                <td class="py-3 px-3">
                  <div class="fw-bold text-dark font-14">
                    {{ $ord->booking_date ? date('D, d M Y', strtotime($ord->booking_date)) : '-' }}
                  </div>
                  <small class="text-muted font-11">Booked on {{ date('d M Y, h:i A', strtotime($ord->created_at)) }}</small>
                </td>
                <td class="py-3 px-3">
                  @if($ord->from_time && $ord->to_time)
                    <span class="badge" style="background: var(--theme-primary-subtle, #ecfdf5); color: var(--theme-primary, #059669); font-weight: 700;">
                      {{ date('h:i A', strtotime($ord->from_time)) }} - {{ date('h:i A', strtotime($ord->to_time)) }}
                    </span>
                  @else
                    <span class="text-muted font-12">Standard Slot</span>
                  @endif
                </td>
                <td class="py-3 px-3 text-wrap" style="max-width: 260px;">
                  <span class="font-12 text-dark">{{ $patient->patient_problem ?: 'General Consultation' }}</span>
                </td>
                <td class="py-3 px-3">
                  <span class="fw-bold text-dark d-block">₹{{ number_format($ord->total_amount, 2) }}</span>
                  @if($ord->payment_status === 'success')
                    <span class="badge bg-success font-11" style="font-size: 10px;">Paid</span>
                  @elseif($ord->payment_status === 'pending')
                    <span class="badge bg-warning font-11 text-dark" style="font-size: 10px;">Cash at Clinic</span>
                  @else
                    <span class="badge bg-secondary font-11" style="font-size: 10px;">{{ ucfirst($ord->payment_status ?? 'Pending') }}</span>
                  @endif
                </td>
                <td class="py-3 px-3">
                  @if($ord->status === 'confirmed')
                    <span class="badge" style="background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; font-weight: 600;">Confirmed</span>
                  @elseif($ord->status === 'completed')
                    <span class="badge" style="background: #f0f9ff; color: #0284c7; border: 1px solid #bae6fd; font-weight: 600;">Completed</span>
                  @elseif($ord->status === 'cancelled')
                    <span class="badge" style="background: #fef2f2; color: #dc2626; border: 1px solid #fecdd3; font-weight: 600;">Cancelled</span>
                  @else
                    <span class="badge" style="background: #fffbeb; color: #d97706; border: 1px solid #fde68a; font-weight: 600;">Pending</span>
                  @endif
                </td>
                <td class="py-3 px-3 text-end no-print">
                  <a href="{{ url('admin/patient-history/status-change/'.$ord->id) }}" class="btn btn-sm btn-outline-primary font-weight-bold px-2 py-1" style="border-radius: 6px; font-size: 12px;">
                    View Case
                  </a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6" class="text-center py-4 text-muted">No visits recorded for this patient.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Complete Payment & Billing Transaction History -->
    <div class="clinical-card mb-4">
      <div class="clinical-card-header">
        <h5 class="fw-bold text-dark mb-0 d-flex align-items-center font-15">
          <span class="d-inline-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; border-radius: 8px; background: #ecfdf5; color: #059669;">
            <i class="mdi mdi-cash-multiple font-18"></i>
          </span>
          All Payment &amp; Billing History
        </h5>
        <span class="badge font-12" style="background: #ecfdf5; color: #059669; font-weight: 700; border: 1px solid #a7f3d0;">
          Total Paid: ₹{{ number_format($totalSpent, 2) }}
        </span>
      </div>
      <div class="clinical-card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead style="background: #f8fafc; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b;">
              <tr>
                <th class="py-3 px-3">Date</th>
                <th class="py-3 px-3">Order / Receipt #</th>
                <th class="py-3 px-3">Payment Mode</th>
                <th class="py-3 px-3">Transaction Ref</th>
                <th class="py-3 px-3">Consultation Fee</th>
                <th class="py-3 px-3">Total Paid</th>
                <th class="py-3 px-3">Status</th>
                <th class="py-3 px-3 text-end no-print">Invoice</th>
              </tr>
            </thead>
            <tbody style="font-size: 13.5px;">
              @forelse($orders as $ord)
              @php
                $isCash = ($ord->razorpay_payment_id === 'CASH_PAYMENT' || $ord->razorpay_payment_id === 'CASH_AT_CLINIC' || str_contains($ord->transaction_id ?? '', 'CASH'));
              @endphp
              <tr style="border-bottom: 1px solid #f1f5f9;">
                <td class="py-3 px-3 font-weight-bold text-dark text-nowrap">
                  {{ date('d M Y, h:i A', strtotime($ord->created_at)) }}
                </td>
                <td class="py-3 px-3 font-monospace font-12">
                  <strong>#ORD-{{ $ord->id }}</strong>
                </td>
                <td class="py-3 px-3">
                  @if($isCash)
                    <span class="badge" style="background: #fef3c7; color: #92400e; font-weight: 600; border: 1px solid #fde68a;">
                      <i class="mdi mdi-cash me-1"></i> Cash at Clinic
                    </span>
                  @else
                    <span class="badge" style="background: #e0f2fe; color: #0369a1; font-weight: 600; border: 1px solid #bae6fd;">
                      <i class="mdi mdi-credit-card-outline me-1"></i> Razorpay Online
                    </span>
                  @endif
                </td>
                <td class="py-3 px-3 font-monospace font-11 text-muted text-break" style="max-width: 170px;">
                  {{ $ord->razorpay_payment_id ?: ($ord->transaction_id ?: '-') }}
                </td>
                <td class="py-3 px-3 text-muted">
                  ₹{{ number_format($ord->actual_amount ?: $ord->total_amount, 2) }}
                </td>
                <td class="py-3 px-3 font-weight-bold" style="color: var(--theme-primary, #059669); font-size: 14.5px;">
                  ₹{{ number_format($ord->total_amount, 2) }}
                </td>
                <td class="py-3 px-3">
                  @if($ord->payment_status === 'success')
                    <span class="badge" style="background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; font-weight: 600;">Paid</span>
                  @elseif($ord->payment_status === 'pending')
                    <span class="badge" style="background: #fffbeb; color: #d97706; border: 1px solid #fde68a; font-weight: 600;">Pending</span>
                  @elseif($ord->payment_status === 'cancelled')
                    <span class="badge" style="background: #fef2f2; color: #dc2626; border: 1px solid #fecdd3; font-weight: 600;">Cancelled</span>
                  @else
                    <span class="badge bg-light text-dark font-weight-bold">{{ ucfirst($ord->payment_status ?? 'Pending') }}</span>
                  @endif
                </td>
                <td class="py-3 px-3 text-end no-print">
                  <a href="{{ url('invoice/'.$ord->id) }}" target="_blank" class="btn btn-sm btn-outline-success font-weight-bold px-2 py-1 d-inline-flex align-items-center gap-1" style="border-radius: 6px; font-size: 11.5px;">
                    <i class="mdi mdi-receipt"></i> Invoice
                  </a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="8" class="text-center py-4 text-muted">No payment transactions found.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
