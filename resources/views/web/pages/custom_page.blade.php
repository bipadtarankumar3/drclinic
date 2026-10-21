@extends('web.layouts.main')

@php
  $clinicSlug = $clinic->subdomain ?? $clinic->slug;
  $clinicUrl = $clinicSlug ? url('/c/' . $clinicSlug) : url('/');
  $bookingUrl = $clinicUrl . '#booking-section';
  $themeColor = $clinic->theme_color ?? '#0d9488';
@endphp

@section('banner')
<!-- ========================================================
     MODERN CUSTOM PAGE HERO HEADER
     ======================================================== -->
<section class="vital-page-header py-4" style="background: linear-gradient(180deg, #f0fdfa 0%, #ffffff 100%); border-bottom: 1px solid #e2e8f0;">
  <div class="container-fluid" style="padding-left: 36px; padding-right: 36px;">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-2">
      <ol class="breadcrumb mb-0" style="font-size: 13px; background: transparent; padding: 0;">
        <li class="breadcrumb-item"><a href="{{ $clinicUrl }}" style="color: #0d9488; text-decoration: none;"><i class="fa-solid fa-house me-1"></i> Home</a></li>
        <li class="breadcrumb-item text-muted">Clinic Pages</li>
        <li class="breadcrumb-item active text-dark fw-bold" aria-current="page">{{ $page->title }}</li>
      </ol>
    </nav>

    <div class="row align-items-center">
      <div class="col-lg-8">
        <div class="vital-hero-badge mb-2 d-inline-flex align-items-center" style="background: rgba(13, 148, 136, 0.1); color: #0d9488; padding: 4px 14px; border-radius: 50px; font-size: 12.5px; font-weight: 700;">
          <span class="vital-pulse-dot" style="width: 8px; height: 8px; border-radius: 50%; background: #0d9488; margin-right: 8px; display: inline-block;"></span>
          <span>{{ $clinic->name }}</span>
        </div>
        <h1 class="fw-bold mb-2" style="font-size: 32px; color: #0f172a; letter-spacing: -0.5px;">
          {{ $page->title }}
        </h1>
        <div class="d-flex align-items-center text-muted flex-wrap gap-3" style="font-size: 13.5px;">
          <span><i class="fa-regular fa-clock me-1 text-teal"></i> Last Updated: {{ $page->updated_at->format('d M, Y') }}</span>
          <span>•</span>
          <span><i class="fa-solid fa-user-doctor me-1 text-teal"></i> {{ $clinic->specialization ?? 'Medical Consultation' }}</span>
        </div>
      </div>

      <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
        <a href="{{ $bookingUrl }}" class="btn text-white fw-bold px-4 py-2 rounded-pill shadow-sm" style="background: #0d9488; border: none; font-size: 14.5px;">
          <i class="fa-regular fa-calendar-check me-1"></i> Book Appointment
        </a>
      </div>
    </div>
  </div>
</section>
@endsection

@section('content')
<div class="container py-5 my-2" style="max-width: 1240px;">
  <div class="row g-4">
    <!-- Main Content Column -->
    <div class="col-lg-8">
      <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5" style="border-radius: 20px; background: #ffffff; border: 1px solid #eef2f6;">
        <div class="custom-page-body" style="font-size: 15.5px; line-height: 1.85; color: #334155;">
          @php
            // Lightweight markdown formatting helper for headings, bold, bullet points, and quotes
            $content = e($page->content);
            // Convert ## Heading to <h4>
            $content = preg_replace('/##\s*(.*?)(?:\n|$)/', '<h4 class="fw-bold mt-4 mb-3" style="color: #0f172a; font-size: 20px; border-left: 3px solid #0d9488; padding-left: 12px;">$1</h4>', $content);
            // Convert **bold** to <strong>
            $content = preg_replace('/\*\*(.*?)\*\*/', '<strong style="color: #0f172a;">$1</strong>', $content);
            // Convert • item to styled bullet point
            $content = preg_replace('/•\s*(.*?)(?:\n|$)/', '<div class="d-flex align-items-start mb-2" style="gap: 10px;"><i class="fa-solid fa-circle-check mt-1" style="color: #0d9488; font-size: 14px; flex-shrink: 0;"></i><span>$1</span></div>', $content);
            // Convert > quote to blockquote
            $content = preg_replace('/>\s*(.*?)(?:\n|$)/', '<div class="p-3 my-3 rounded-3" style="background: #f0fdfa; border-left: 4px solid #0d9488; color: #0f766e; font-weight: 500;">$1</div>', $content);
            // Convert double linebreaks to paragraphs
            $paragraphs = array_filter(explode("\n", $content));
          @endphp

          {!! nl2br($content) !!}
        </div>

        <hr class="my-5" style="opacity: 0.1;">

        <!-- Consultation Banner Inside Card -->
        <div class="p-4 rounded-4 d-flex align-items-center justify-content-between flex-wrap gap-3" style="background: linear-gradient(135deg, #0d9488 0%, #14b8a6 100%); color: #ffffff;">
          <div>
            <h5 class="fw-bold mb-1" style="font-size: 18px;">Need personalized medical advice?</h5>
            <p class="mb-0 small opacity-90">Schedule an in-person consultation with our certified doctors today.</p>
          </div>
          <a href="{{ $bookingUrl }}" class="btn btn-light fw-bold px-4 py-2 rounded-pill" style="color: #0d9488; font-size: 14px;">
            <i class="fa-regular fa-calendar-check me-1"></i> Book Consultation
          </a>
        </div>
      </div>
    </div>

    <!-- Sidebar Column -->
    <div class="col-lg-4">
      <div class="d-flex flex-column gap-4" style="position: sticky; top: 90px;">
        
        <!-- Clinic Consultation Card -->
        <div class="card border-0 shadow-sm rounded-4 p-4" style="border-radius: 18px; background: #ffffff; border: 1px solid #eef2f6;">
          <div class="d-flex align-items-center mb-3" style="gap: 12px;">
            @if($clinic->logo)
              <img src="{{ URL::to($clinic->logo) }}" alt="{{ $clinic->name }}" style="max-height: 48px; object-fit: contain;">
            @else
              <div style="width: 44px; height: 44px; border-radius: 12px; background: linear-gradient(135deg, #0d9488 0%, #14b8a6 100%); display: flex; align-items: center; justify-content: center; color: #ffffff; font-size: 20px;">
                <i class="fa-solid fa-hospital"></i>
              </div>
            @endif
            <div>
              <h5 class="fw-bold mb-0" style="color: #0f172a; font-size: 17px;">{{ $clinic->name }}</h5>
              <small class="text-muted">{{ $clinic->specialization ?? 'Health Clinic' }}</small>
            </div>
          </div>

          <div class="p-3 rounded-3 mb-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
            <div class="d-flex justify-content-between mb-1 small text-muted">
              <span>Consultation Fee:</span>
              <strong class="text-dark">₹ {{ number_format($clinic->consultation_fee ?? 700, 2) }}</strong>
            </div>
            <div class="d-flex justify-content-between small text-muted">
              <span>Appointment Mode:</span>
              <span class="badge bg-success text-white">Instant Confirmation</span>
            </div>
          </div>

          <a href="{{ $bookingUrl }}" class="btn text-white fw-bold py-2 mb-2 w-100 rounded-3 shadow-sm" style="background: #0d9488; border: none; font-size: 14.5px;">
            <i class="fa-regular fa-calendar-check me-1"></i> Book Slot on Calendar
          </a>

          @if($clinic->phone)
          <a href="tel:{{ $clinic->phone }}" class="btn btn-outline-secondary fw-semibold py-2 w-100 rounded-3" style="font-size: 13.5px;">
            <i class="fa-solid fa-phone me-1 text-teal"></i> Call {{ $clinic->phone }}
          </a>
          @endif
        </div>

        <!-- Other Pages Navigation Card -->
        @php
          $otherPages = ($clinic->pages) ? $clinic->pages->where('is_published', true)->where('id', '!=', $page->id) : collect();
        @endphp
        @if($otherPages->count() > 0)
        <div class="card border-0 shadow-sm rounded-4 p-4" style="border-radius: 18px; background: #ffffff; border: 1px solid #eef2f6;">
          <h6 class="fw-bold mb-3" style="color: #0f172a; font-size: 15px; text-transform: uppercase; letter-spacing: 0.5px;">
            <i class="fa-regular fa-file-lines me-2 text-teal"></i> More from {{ $clinic->name }}
          </h6>
          <ul class="list-unstyled mb-0" style="font-size: 14px; line-height: 2;">
            <li>
              <a href="{{ $clinicUrl }}" class="text-decoration-none fw-semibold" style="color: #334155; transition: color 0.2s;">
                <i class="fa-solid fa-chevron-right me-2 text-teal" style="font-size: 11px;"></i> Home Storefront
              </a>
            </li>
            @foreach($otherPages as $op)
            <li>
              <a href="{{ url('/c/' . $clinicSlug . '/page/' . $op->slug) }}" class="text-decoration-none" style="color: #64748b; transition: color 0.2s;">
                <i class="fa-solid fa-chevron-right me-2 text-teal" style="font-size: 11px;"></i> {{ $op->title }}
              </a>
            </li>
            @endforeach
          </ul>
        </div>
        @endif

        <!-- Clinic Address Card -->
        <div class="card border-0 shadow-sm rounded-4 p-4" style="border-radius: 18px; background: #ffffff; border: 1px solid #eef2f6;">
          <h6 class="fw-bold mb-2" style="color: #0f172a; font-size: 14px;">
            <i class="fa-solid fa-location-dot me-2 text-teal"></i> Visit Location
          </h6>
          <p class="text-muted small mb-0" style="line-height: 1.6;">
            {{ $clinic->address ?? 'Main Medical Street, Health District' }}
          </p>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
