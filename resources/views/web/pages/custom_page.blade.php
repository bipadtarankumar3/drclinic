@extends('web.layouts.main')

@php
  $clinicSlug = $clinic->subdomain ?? $clinic->slug;
  $clinicUrl = $clinicSlug ? url('/c/' . $clinicSlug) : url('/');
  $bookingUrl = $clinicUrl . '#booking-section';
  $themeColor = $clinic->theme_color ?? '#0d9488';
@endphp

@section('style')
<style>
  .custom-page-body {
    font-size: 15.5px;
    line-height: 1.85;
    color: #334155;
    word-break: break-word;
    overflow-wrap: break-word;
  }
  .custom-page-body h1,
  .custom-page-body h2,
  .custom-page-body h3,
  .custom-page-body h4,
  .custom-page-body h5,
  .custom-page-body h6 {
    color: #0f172a;
    font-weight: 700;
    margin-top: 1.8rem;
    margin-bottom: 0.8rem;
    line-height: 1.3;
  }
  .custom-page-body h1 { font-size: clamp(24px, 4vw, 32px); }
  .custom-page-body h2 { font-size: clamp(20px, 3.2vw, 26px); border-bottom: 2px solid #f1f5f9; padding-bottom: 8px; }
  .custom-page-body h3 { font-size: clamp(18px, 2.5vw, 22px); }
  .custom-page-body h4 { font-size: 18px; }
  .custom-page-body p { margin-bottom: 1.2rem; }
  .custom-page-body ul,
  .custom-page-body ol {
    padding-left: 1.5rem;
    margin-bottom: 1.4rem;
  }
  .custom-page-body li {
    margin-bottom: 0.5rem;
  }
  .custom-page-body blockquote {
    border-left: 4px solid #0d9488;
    background: #f0fdfa;
    padding: 16px 22px;
    border-radius: 0 12px 12px 0;
    margin: 1.6rem 0;
    color: #0f766e;
    font-weight: 500;
  }
  .custom-page-body img {
    max-width: 100% !important;
    height: auto !important;
    border-radius: 12px;
    margin: 1.2rem 0;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
  }
  .custom-page-body iframe,
  .custom-page-body video {
    max-width: 100% !important;
    border-radius: 12px;
  }
  .custom-page-body table {
    width: 100% !important;
    max-width: 100% !important;
    border-collapse: collapse;
    margin: 1.5rem 0;
  }
  .custom-page-body table th,
  .custom-page-body table td {
    padding: 10px 14px;
    border: 1px solid #e2e8f0;
    font-size: 14.5px;
  }
  .custom-page-body table th {
    background: #f8fafc;
    font-weight: 700;
    color: #0f172a;
  }

  @media (max-width: 768px) {
    .custom-page-body table {
      display: block;
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
      white-space: nowrap;
    }
  }
</style>
@endsection

@section('banner')
<!-- ========================================================
     MODERN CUSTOM PAGE HERO HEADER (100% Responsive)
     ======================================================== -->
<section class="vital-page-header py-4" style="background: linear-gradient(180deg, #f0fdfa 0%, #ffffff 100%); border-bottom: 1px solid #e2e8f0;">
  <div class="container-fluid" style="max-width: 1440px; padding-left: clamp(16px, 3.5vw, 48px); padding-right: clamp(16px, 3.5vw, 48px);">
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
        <h1 class="fw-bold mb-2" style="font-size: clamp(24px, 4vw, 36px); color: #0f172a; letter-spacing: -0.5px; line-height: 1.2;">
          {{ $page->title }}
        </h1>
        <div class="d-flex align-items-center text-muted flex-wrap gap-2 gap-md-3" style="font-size: 13.5px;">
          <span><i class="fa-regular fa-clock me-1 text-teal"></i> Updated: {{ $page->updated_at->format('d M, Y') }}</span>
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
<div class="container-fluid py-4 py-md-5 my-2" style="max-width: 1440px; padding-left: clamp(16px, 3.5vw, 48px); padding-right: clamp(16px, 3.5vw, 48px);">
  <div class="row g-4">
    <!-- Main Content Column -->
    <div class="col-lg-8 col-md-12">
      <div class="card border-0 shadow-sm rounded-4 p-3 p-sm-4 p-md-5" style="border-radius: 20px; background: #ffffff; border: 1px solid #eef2f6;">
        <div class="custom-page-body">
          @php
            $rawContent = $page->content ?? '';
            $hasHtml = strip_tags($rawContent) !== $rawContent;
          @endphp

          @if($hasHtml)
            {{-- Render Rich HTML generated by Summernote WYSIWYG editor --}}
            <div class="vital-rich-content">
              {!! $rawContent !!}
            </div>
          @else
            {{-- Fallback parser for plain text / markdown content --}}
            @php
              $lines = explode("\n", str_replace(["\r\n", "\r"], "\n", $rawContent));
              $parsedLines = [];
              foreach ($lines as $line) {
                  $trimmed = trim($line);
                  if (str_starts_with($trimmed, '### ')) {
                      $parsedLines[] = '<h5 class="fw-bold mt-4 mb-2" style="color: #0f172a;">' . e(substr($trimmed, 4)) . '</h5>';
                  } elseif (str_starts_with($trimmed, '## ')) {
                      $parsedLines[] = '<h4 class="fw-bold mt-4 mb-3" style="color: #0f172a; font-size: 20px; border-left: 3px solid #0d9488; padding-left: 12px;">' . e(substr($trimmed, 3)) . '</h4>';
                  } elseif (str_starts_with($trimmed, '# ')) {
                      $parsedLines[] = '<h3 class="fw-bold mt-4 mb-3" style="color: #0f172a; font-size: 24px;">' . e(substr($trimmed, 2)) . '</h3>';
                  } elseif (preg_match('/^[•\-\*]\s*(.+)$/u', $trimmed, $m)) {
                      $bulletText = e($m[1]);
                      $bulletText = preg_replace('/\*\*(.*?)\*\*/', '<strong style="color: #0f172a;">$1</strong>', $bulletText);
                      $parsedLines[] = '<div class="d-flex align-items-start mb-2" style="gap: 10px;"><i class="fa-solid fa-circle-check mt-1" style="color: #0d9488; font-size: 14px; flex-shrink: 0;"></i><span>' . $bulletText . '</span></div>';
                  } elseif (str_starts_with($trimmed, '> ')) {
                      $parsedLines[] = '<div class="p-3 my-3 rounded-3" style="background: #f0fdfa; border-left: 4px solid #0d9488; color: #0f766e; font-weight: 500;">' . e(substr($trimmed, 2)) . '</div>';
                  } elseif ($trimmed === '') {
                      $parsedLines[] = '<div class="my-2"></div>';
                  } else {
                      $lineText = e($line);
                      $lineText = preg_replace('/\*\*(.*?)\*\*/', '<strong style="color: #0f172a;">$1</strong>', $lineText);
                      $parsedLines[] = '<p class="mb-3">' . $lineText . '</p>';
                  }
              }
            @endphp
            {!! implode("\n", $parsedLines) !!}
          @endif
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
    <div class="col-lg-4 col-md-12">
      <div class="d-flex flex-column gap-4" style="position: sticky; top: 90px;">
        
        <!-- Clinic Consultation Card -->
        <div class="card border-0 shadow-sm rounded-4 p-4" style="border-radius: 18px; background: #ffffff; border: 1px solid #eef2f6;">
          <div class="d-flex align-items-center mb-3" style="gap: 12px;">
            @if($clinic->logo)
              <img src="{{ $clinic->logo_url ?? URL::to('public/' . $clinic->logo) }}" alt="{{ $clinic->name }}" style="max-height: 48px; max-width: 140px; object-fit: contain;">
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

