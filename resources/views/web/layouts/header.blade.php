@php
  $clinic = $currentClinic ?? \App\Models\Clinic::first();
  $themeColor = $clinic->theme_color ?? '#0d6efd';
@endphp
<style>
  :root {
    --primary-color: {{ $themeColor }};
  }
  .desk-nav {
    background: #ffffff;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    padding: 12px 0;
  }
  .desk-main {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .clinic-brand {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
    color: #0f172a;
  }
  .clinic-brand img {
    max-height: 50px;
    object-fit: contain;
  }
  .clinic-brand-text {
    font-size: 20px;
    font-weight: 800;
    color: #0f172a;
    letter-spacing: -0.3px;
  }
  .clinic-tagline {
    font-size: 12px;
    color: #64748b;
    font-weight: 600;
  }
  .nav-custom-links {
    display: flex;
    align-items: center;
    gap: 24px;
    list-style: none;
    margin: 0;
    padding: 0;
  }
  .nav-custom-links a {
    color: #334155;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    transition: color 0.2s;
  }
  .nav-custom-links a:hover {
    color: var(--primary-color);
  }
  .header-actions {
    display: flex;
    align-items: center;
    gap: 14px;
  }
  .btn-header-login {
    color: #475569;
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    padding: 8px 16px;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
  }
  .btn-header-login:hover {
    background: #f8fafc;
    color: #0f172a;
  }
  .btn-header-book {
    background: var(--primary-color);
    color: #ffffff;
    font-weight: 700;
    font-size: 14px;
    text-decoration: none;
    padding: 10px 20px;
    border-radius: 10px;
    transition: opacity 0.2s;
  }
  .btn-header-book:hover {
    opacity: 0.9;
    color: #ffffff;
  }
</style>

<header>
  <div class="desk-nav">
    <div class="desk-main">
      <a href="{{ url('/') }}" class="clinic-brand">
        @if($clinic && $clinic->logo)
          <img src="{{ asset($clinic->logo) }}" alt="{{ $clinic->name }}">
        @else
          <div style="width: 44px; height: 44px; border-radius: 10px; background: {{ $themeColor }}; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 22px;">
            <i class="fa-solid fa-hospital"></i>
          </div>
        @endif
        <div>
          <div class="clinic-brand-text">{{ $clinic->name ?? 'Dr Clinic' }}</div>
          <div class="clinic-tagline">{{ $clinic->specialization ?? 'Certified Healthcare Services' }}</div>
        </div>
      </a>

      <!-- Dynamic Custom Pages Navigation -->
      @if($clinic && $clinic->pages && $clinic->pages->where('is_published', true)->count() > 0)
      <ul class="nav-custom-links d-none d-lg-flex">
        <a href="{{ url('/') }}">Appointment</a>
        @foreach($clinic->pages->where('is_published', true) as $cp)
          <a href="{{ url('/page/' . $cp->slug) }}">{{ $cp->title }}</a>
        @endforeach
      </ul>
      @endif

      <div class="header-actions">
        @if(auth()->check())
          @if(auth()->user()->isSuperAdmin())
            <a href="{{ route('admin.saas.dashboard') }}" class="btn-header-login">
              <i class="fa-solid fa-shield-halved"></i> Super Admin
            </a>
          @else
            <a href="{{ route('doctor.dashboard') }}" class="btn-header-login">
              <i class="fa-solid fa-user-doctor"></i> Doctor Portal
            </a>
          @endif
        @else
          <a href="{{ url('/admin/login') }}" class="btn-header-login">
            <i class="fa-solid fa-arrow-right-to-bracket"></i> Doctor Login
          </a>
        @endif

        <a href="{{ url('/') }}" class="btn-header-book">
          <i class="fa-regular fa-calendar-check"></i> Book Now
        </a>
      </div>
    </div>
  </div>
</header>