@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  <!-- Page Header -->
  <div class="d-flex align-items-center justify-content-between flex-wrap mb-4" style="gap: 12px;">
    <div>
      <a href="{{ route('clinic.inquiries.index') }}" class="btn btn-outline-secondary btn-sm mb-2 rounded-3">
        <i class="mdi mdi-arrow-left me-1"></i> Back to Inquiries
      </a>
      <h3 class="font-weight-bold text-dark mb-0">
        Inquiry Details #INQ-{{ str_pad($inquiry->id, 5, '0', STR_PAD_LEFT) }}
      </h3>
    </div>
    <div class="d-flex gap-2">
      <a href="mailto:{{ $inquiry->email }}?subject={{ urlencode('Re: ' . $inquiry->subject) }}" class="btn btn-primary font-weight-bold rounded-3">
        <i class="mdi mdi-reply me-1"></i> Reply via Email
      </a>
      @if($inquiry->phone)
        <a href="tel:{{ $inquiry->phone }}" class="btn btn-success font-weight-bold rounded-3 text-white">
          <i class="mdi mdi-phone me-1"></i> Call Patient
        </a>
      @endif
      <form action="{{ route('clinic.inquiries.destroy', $inquiry->id) }}" method="POST" onsubmit="return confirm('Delete this inquiry?')" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-outline-danger font-weight-bold rounded-3">
          <i class="mdi mdi-trash-can-outline me-1"></i> Delete
        </button>
      </form>
    </div>
  </div>

  <div class="row g-4">
    <!-- Message Content Box -->
    <div class="col-lg-8">
      <div class="card border-0 shadow-sm rounded-4 mb-4" style="border-radius: 16px;">
        <div class="card-body p-4 p-md-5">
          <div class="d-flex align-items-center justify-content-between pb-3 mb-4 border-bottom">
            <div>
              <span class="badge bg-light text-primary border rounded-pill px-3 py-1 font-weight-bold mb-2">
                {{ $inquiry->subject ?: 'General Consultation Inquiry' }}
              </span>
              <h4 class="font-weight-bold text-dark mb-1">{{ $inquiry->subject ?: 'General Clinic Inquiry' }}</h4>
              <div class="text-muted font-13">Received on {{ $inquiry->created_at->format('l, d F Y \a\t h:i A') }}</div>
            </div>
            <div>
              <span class="badge bg-success text-white px-3 py-2 rounded-pill font-weight-bold">
                <i class="mdi mdi-check-all me-1"></i> Read
              </span>
            </div>
          </div>

          <h6 class="font-weight-bold text-muted text-uppercase font-12 mb-2">Patient Message:</h6>
          <div class="p-4 rounded-3 mb-4" style="background: #f8fafc; border: 1.5px solid #e2e8f0; font-size: 15px; line-height: 1.7; color: #1e293b; white-space: pre-wrap;">{{ $inquiry->message }}</div>

          <div class="pt-3 border-top d-flex align-items-center justify-content-between flex-wrap gap-2 text-muted font-13">
            <div>
              <i class="mdi mdi-ip-network me-1"></i> Sender IP: {{ $inquiry->ip_address ?: 'Unknown' }}
            </div>
            <div>
              <i class="mdi mdi-clock-outline me-1"></i> Received {{ $inquiry->created_at->diffForHumans() }}
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Patient Info Card -->
    <div class="col-lg-4">
      <div class="card border-0 shadow-sm rounded-4" style="border-radius: 16px;">
        <div class="card-body p-4">
          <h5 class="font-weight-bold text-dark mb-3">Sender Information</h5>

          <div class="d-flex align-items-center gap-3 pb-3 mb-3 border-bottom">
            <div style="width: 50px; height: 50px; border-radius: 50%; background: rgba(13, 148, 136, 0.15); color: #0d9488; font-size: 20px; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
              {{ strtoupper(substr($inquiry->name, 0, 1)) }}
            </div>
            <div>
              <div class="font-weight-bold text-dark font-16">{{ $inquiry->name }}</div>
              <small class="text-muted">Website Visitor / Patient</small>
            </div>
          </div>

          <div class="mb-3">
            <label class="text-muted font-12 text-uppercase font-weight-bold d-block mb-1">Email Address</label>
            <div class="d-flex align-items-center justify-content-between">
              <span class="text-dark font-14 font-weight-bold">{{ $inquiry->email }}</span>
              <a href="mailto:{{ $inquiry->email }}" class="btn btn-sm btn-outline-primary py-1 px-2 rounded-2">
                <i class="mdi mdi-email-fast-outline"></i>
              </a>
            </div>
          </div>

          <div class="mb-3">
            <label class="text-muted font-12 text-uppercase font-weight-bold d-block mb-1">Phone Number</label>
            <div class="d-flex align-items-center justify-content-between">
              <span class="text-dark font-14 font-weight-bold">{{ $inquiry->phone ?: 'Not provided' }}</span>
              @if($inquiry->phone)
                <a href="tel:{{ $inquiry->phone }}" class="btn btn-sm btn-outline-success py-1 px-2 rounded-2">
                  <i class="mdi mdi-phone"></i>
                </a>
              @endif
            </div>
          </div>

          <div class="p-3 rounded-3 mt-4" style="background: rgba(13, 148, 136, 0.08); border: 1px solid rgba(13, 148, 136, 0.2);">
            <div class="font-weight-bold text-dark font-13 mb-1">
              <i class="mdi mdi-information-outline text-primary me-1"></i> Clinic-Wise Delivery
            </div>
            <p class="text-muted font-12 mb-0">
              This message was sent to your clinic's registered email (<strong>{{ $clinic->email }}</strong>) and recorded in your portal for patient follow-up.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
