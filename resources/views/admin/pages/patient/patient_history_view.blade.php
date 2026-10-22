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
              <div class="attribute-value text-primary">{{ $patient->mobile_no ?? '-' }}</div>
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
          <div class="attribute-label text-muted mb-1">Last Recorded Complaint / Condition:</div>
          <div class="font-14 text-dark font-weight-bold">{{ $patient->patient_problem }}</div>
        </div>
        @endif
      </div>
    </div>

    <!-- Appointment History Table -->
    <div class="clinical-card mb-4">
      <div class="clinical-card-header">
        <h5 class="fw-bold text-dark mb-0 d-flex align-items-center font-15">
          <span class="d-inline-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; border-radius: 8px; background: #e0f2fe; color: #0284c7;">
            <i class="mdi mdi-history font-18"></i>
          </span>
          Consultation &amp; Appointment History
        </h5>
        <span class="badge bg-light text-muted font-11">{{ count($orders) }} Total Visits</span>
      </div>
      <div class="clinical-card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead style="background: #f8fafc; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b;">
              <tr>
                <th class="py-3 px-3">Date</th>
                <th class="py-3 px-3">Time Slot</th>
                <th class="py-3 px-3">Amount</th>
                <th class="py-3 px-3">Transaction Ref</th>
                <th class="py-3 px-3">Status</th>
                <th class="py-3 px-3 text-end no-print">Action</th>
              </tr>
            </thead>
            <tbody style="font-size: 13.5px;">
              @forelse($orders as $ord)
              <tr style="border-bottom: 1px solid #f1f5f9;">
                <td class="py-3 px-3 font-weight-bold text-dark">
                  {{ $ord->booking_date ? date('d M Y', strtotime($ord->booking_date)) : '-' }}
                </td>
                <td class="py-3 px-3">
                  <span class="badge" style="background: var(--theme-primary-subtle, #ecfdf5); color: var(--theme-primary, #059669); font-weight: 700;">
                    {{ date('h:i A', strtotime($ord->from_time)) }} - {{ date('h:i A', strtotime($ord->to_time)) }}
                  </span>
                </td>
                <td class="py-3 px-3 font-weight-bold" style="color: var(--theme-primary, #059669);">
                  ₹{{ number_format($ord->total_amount, 2) }}
                </td>
                <td class="py-3 px-3 font-monospace font-12 text-muted">
                  #{{ $ord->transaction_id ?: 'MANUAL' }}
                </td>
                <td class="py-3 px-3">
                  @if($ord->status === 'confirmed')
                    <span class="badge" style="background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;">Confirmed</span>
                  @elseif($ord->status === 'completed')
                    <span class="badge" style="background: #f0f9ff; color: #0284c7; border: 1px solid #bae6fd;">Completed</span>
                  @elseif($ord->status === 'cancelled')
                    <span class="badge" style="background: #fef2f2; color: #dc2626; border: 1px solid #fecdd3;">Cancelled</span>
                  @else
                    <span class="badge" style="background: #fffbeb; color: #d97706; border: 1px solid #fde68a;">Pending</span>
                  @endif
                </td>
                <td class="py-3 px-3 text-end no-print">
                  <a href="{{ url('admin/patient-history/status-change/'.$ord->id) }}" class="btn btn-xs btn-outline-primary font-weight-bold px-2 py-1" style="border-radius: 6px;">
                    View Case
                  </a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6" class="text-center py-4 text-muted">No appointments found for this patient.</td>
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
