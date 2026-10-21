@extends('web.layouts.main')

@section('content')
<div class="container py-5 my-4" style="max-width: 960px;">
  <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5" style="border-radius: 20px; background: #ffffff;">
    <div class="mb-4 pb-3 border-bottom">
      <span class="badge bg-light text-primary font-weight-bold px-3 py-2 mb-2" style="font-size: 13px;">
        {{ $clinic->name }}
      </span>
      <h1 class="font-weight-bold text-dark display-6 mb-2">{{ $page->title }}</h1>
      <small class="text-muted"><i class="fa-regular fa-clock"></i> Last updated: {{ $page->updated_at->format('d M, Y') }}</small>
    </div>

    <div class="custom-page-content" style="font-size: 16px; line-height: 1.8; color: #334155;">
      {!! nl2br($page->content) !!}
    </div>

    <div class="mt-5 pt-4 border-top text-center">
      <h4 class="font-weight-bold mb-3">Ready to schedule your consultation?</h4>
      <a href="{{ url('/') }}" class="btn btn-primary btn-lg font-weight-bold px-4 py-3" style="background: {{ $clinic->theme_color ?? '#0d6efd' }}; border: none; border-radius: 12px;">
        <i class="fa-solid fa-calendar-check mr-2"></i> Book Appointment with {{ $clinic->name }}
      </a>
    </div>
  </div>
</div>
@endsection
