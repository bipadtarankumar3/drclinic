@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  <!-- Page Header matching Plans Design -->
  <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 pb-2">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <h2 class="font-weight-bold mb-0 text-dark" style="font-size: 26px; letter-spacing: -0.5px;">Clinic Services</h2>
        <span class="badge" style="background: #e0f2fe; color: #0284c7; font-weight: 700; font-size: 11px; padding: 5px 11px; border-radius: 9999px; letter-spacing: 0.5px;">MEDICAL &amp; CLINICAL SERVICES</span>
      </div>
      <p class="text-muted mb-0" style="font-size: 13.5px;">Configure treatments, consultation pricing, and display order for your public clinic storefront.</p>
    </div>
    <div class="d-flex align-items-center gap-2 mt-3 mt-md-0">
      <form action="{{ route('doctor.services.seed_defaults') }}" method="POST" class="d-inline" onsubmit="return confirm('Restore standard services adapted to your clinic specialization ({{ $clinic->specialization ?? 'Healthcare' }})?');">
        @csrf
        <button type="submit" class="btn font-weight-bold d-inline-flex align-items-center" style="background: #ffffff; border: 1.5px solid #cbd5e1; color: #475569; padding: 9px 18px; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
          <i class="mdi mdi-refresh mr-1" style="font-size: 18px; color: #0284c7;"></i> Auto-Generate for My Specialty
        </button>
      </form>

      <a href="{{ route('doctor.services.create') }}" class="btn font-weight-bold d-inline-flex align-items-center" style="background: #e11d48; border: none; color: #ffffff; padding: 10px 20px; border-radius: 10px; box-shadow: 0 2px 6px rgba(225,29,72,0.3);">
        <i class="mdi mdi-plus mr-1" style="font-size: 18px;"></i> Add New Service
      </a>

      <a href="{{ $clinic->custom_domain ? 'https://'.$clinic->custom_domain : url('/c/'.($clinic->subdomain ?? $clinic->slug)) }}#services-section" target="_blank" class="btn btn-outline-secondary font-weight-bold d-inline-flex align-items-center" style="border: 1.5px solid #cbd5e1; padding: 9px 18px; border-radius: 10px;">
        <i class="mdi mdi-open-in-new mr-1"></i> View on Website
      </a>
    </div>
  </div>

  @if(session('success'))
  <div class="alert alert-success alert-dismissible fade show rounded-3 p-3 mb-4 shadow-sm" role="alert" style="border-left: 4px solid #10b981; background: #f0fdf4; color: #065f46;">
    <strong><i class="mdi mdi-check-circle mr-1"></i></strong> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  @if(isset($errors) && $errors->any())
  <div class="alert alert-danger rounded-3 p-3 mb-4 shadow-sm" style="border-left: 4px solid #ef4444; background: #fef2f2; color: #991b1b;">
    <ul class="mb-0">
      @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <!-- Commercial Style Services Grid -->
  <div class="row g-4 mb-5">
    @forelse($services as $service)
    <div class="col-lg-4 col-md-6 mb-4">
      <div class="card h-100 border-0 shadow-sm rounded-4" style="border: 1px solid #e2e8f0; border-radius: 18px; background: #ffffff; transition: transform 0.2s ease, box-shadow 0.2s ease;">
        <div class="card-body p-4 d-flex flex-column justify-content-between">
          <div>
            <!-- Header: Title & Active Badge -->
            <div class="d-flex justify-content-between align-items-start mb-2">
              <div style="flex: 1; padding-right: 8px;">
                <h4 class="font-weight-bold text-dark mb-1" style="font-size: 19px;">{{ $service->title }}</h4>
                <p class="text-muted mb-0 font-13" style="min-height: 38px; line-height: 1.4;">
                  {{ $service->description ?? 'Specialized clinical care and patient-first medical treatment.' }}
                </p>
              </div>
              @if($service->status)
                <span class="badge" style="background: #059669; color: #fff; font-size: 10.5px; font-weight: 700; letter-spacing: 0.5px; padding: 5px 10px; border-radius: 9999px; white-space: nowrap;">ACTIVE TIER</span>
              @else
                <span class="badge" style="background: #94a3b8; color: #fff; font-size: 10.5px; font-weight: 700; letter-spacing: 0.5px; padding: 5px 10px; border-radius: 9999px; white-space: nowrap;">INACTIVE TIER</span>
              @endif
            </div>

            <!-- Pricing Box -->
            <div class="rounded-3 p-3 my-3 d-flex justify-content-between align-items-baseline" style="background: #f8fafc; border: 1px solid #edf2f7; border-radius: 12px;">
              <div>
                @if($service->price > 0)
                  <span class="h3 font-weight-bold text-dark mb-0">₹{{ number_format($service->price, 2) }}</span>
                  <span class="text-muted font-12">/consultation</span>
                @else
                  <span class="h3 font-weight-bold text-dark mb-0">Included</span>
                  <span class="text-muted font-12">in standard visit</span>
                @endif
              </div>
              <div class="text-end">
                <div class="font-weight-bold text-dark font-13">Display Order</div>
                <div class="text-muted" style="font-size: 11px;">#{{ $service->sort_order }} on website</div>
              </div>
            </div>

            <!-- Service Details & Specifications List -->
            <div class="py-2 mb-3" style="font-size: 13px; line-height: 2.1;">
              <div class="d-flex justify-content-between text-muted border-bottom py-1" style="border-color: #f1f5f9 !important;">
                <span>Display Icon:</span>
                <strong class="text-dark d-inline-flex align-items-center">
                  <i class="{{ $service->icon_class }} mr-1" style="color: #0284c7; margin-right: 5px; font-size: 15px;"></i>
                  {{ $service->icon ?: 'fa-stethoscope' }}
                </strong>
              </div>
              <div class="d-flex justify-content-between text-muted border-bottom py-1" style="border-color: #f1f5f9 !important;">
                <span>Storefront Visibility:</span>
                <strong class="text-dark">{{ $service->status ? 'Visible on Storefront' : 'Hidden from Patients' }}</strong>
              </div>
              <div class="d-flex justify-content-between text-muted border-bottom py-1" style="border-color: #f1f5f9 !important;">
                <span>Booking Integration:</span>
                <strong class="text-dark">Online Calendar Active</strong>
              </div>
              <div class="d-flex justify-content-between text-muted py-1">
                <span>Clinic Specialty:</span>
                <strong class="text-dark">{{ $clinic->specialization ?? 'General Care' }}</strong>
              </div>
            </div>

            <!-- Entitled Features / Highlights Badges -->
            <div class="mb-4">
              <div class="text-muted font-weight-bold text-uppercase mb-2" style="font-size: 10.5px; letter-spacing: 0.6px;">ENTITLED FEATURES:</div>
              <div class="d-flex flex-wrap gap-1">
                <span class="badge" style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; font-size: 10.5px; font-weight: 600; padding: 4px 8px; border-radius: 6px;">
                  Doctor Consultation
                </span>
                <span class="badge" style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; font-size: 10.5px; font-weight: 600; padding: 4px 8px; border-radius: 6px;">
                  Public Storefront
                </span>
                <span class="badge" style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; font-size: 10.5px; font-weight: 600; padding: 4px 8px; border-radius: 6px;">
                  Appointment History
                </span>
                @if($service->price > 0)
                <span class="badge" style="background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; font-size: 10.5px; font-weight: 600; padding: 4px 8px; border-radius: 6px;">
                  Razorpay Direct
                </span>
                @endif
              </div>
            </div>
          </div>

          <!-- Bottom Actions -->
          <div class="d-flex justify-content-between align-items-center pt-3 border-top" style="border-color: #f1f5f9 !important;">
            <div class="font-weight-bold text-dark font-13">
              Sort Order: #{{ $service->sort_order }}
            </div>
            <div class="d-flex gap-2">
              <form action="{{ route('doctor.services.toggle_status', $service->id) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-secondary font-weight-bold px-3" style="border-radius: 8px;">
                  {{ $service->status ? 'Deactivate' : 'Activate' }}
                </button>
              </form>
              <a href="{{ route('doctor.services.edit', $service->id) }}" class="btn btn-sm text-white font-weight-bold px-3" style="background: #e11d48; border-radius: 8px;">
                Edit
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    @empty
    <div class="col-12">
      <div class="card border-0 shadow-sm rounded-4 p-5 text-center" style="border-radius: 18px; border: 1px dashed #cbd5e1; background: #ffffff;">
        <i class="mdi mdi-medical-bag mb-3" style="font-size: 48px; color: #94a3b8;"></i>
        <h4 class="font-weight-bold text-dark mb-2">No Services Added Yet</h4>
        <p class="text-muted mb-4" style="max-width: 500px; margin: 0 auto;">Click "Auto-Generate for My Specialty" to automatically create relevant services for your clinic, or add custom services manually.</p>
        <div>
          <form action="{{ route('doctor.services.seed_defaults') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-primary font-weight-bold px-4 py-2 me-2" style="border-radius: 8px;">
              <i class="mdi mdi-refresh mr-1"></i> Auto-Generate for My Specialty
            </button>
          </form>
          <a href="{{ route('doctor.services.create') }}" class="btn text-white font-weight-bold px-4 py-2" style="background: #e11d48; border-radius: 8px;">
            <i class="mdi mdi-plus mr-1"></i> Add Custom Service
          </a>
        </div>
      </div>
    </div>
    @endforelse
  </div>
</div>
@endsection
