@php
  $clinic = $currentClinic ?? \App\Models\Clinic::first();
  $themeColor = $clinic->theme_color ?? '#0d9488'; // Modern medical teal default
  $secondaryColor = $clinic->secondary_color ?? '#14b8a6';
  $clinicUrl = $clinic ? url('/c/' . ($clinic->subdomain ?? $clinic->slug)) : url('/');
@endphp

<style>
  :root {
    --clinic-primary: {{ $themeColor }};
    --clinic-secondary: {{ $secondaryColor }};
  }

  /* Top Announcement Sub-Header */
  .vital-top-bar {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    font-size: 13px;
    color: #64748b;
    padding: 8px 0;
  }
  .vital-top-main {
    width: 100%;
    padding: 0 36px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
  }
  .vital-top-left {
    display: flex;
    align-items: center;
    gap: 16px;
    font-weight: 500;
  }
  .vital-top-left .divider {
    color: #cbd5e1;
  }
  .vital-top-right {
    display: flex;
    align-items: center;
    gap: 18px;
    font-weight: 500;
  }
  .vital-top-right a {
    color: #64748b;
    text-decoration: none;
    transition: color 0.2s;
  }
  .vital-top-right a:hover {
    color: var(--clinic-primary);
  }

  /* Main Modern Navbar */
  .vital-nav-bar {
    width: 100%;
    background: #ffffff;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    position: sticky;
    top: 0;
    z-index: 999;
    padding: 14px 0;
  }
  .vital-nav-main {
    width: 100%;
    padding: 0 36px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
  }
  .vital-brand {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
  }
  .vital-logo-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: linear-gradient(135deg, #0d9488 0%, #14b8a6 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    font-size: 22px;
    box-shadow: 0 4px 14px rgba(13, 148, 136, 0.25);
  }
  .vital-brand-info {
    line-height: 1.2;
  }
  .vital-brand-name {
    font-size: 20px;
    font-weight: 800;
    color: #0f172a;
    letter-spacing: -0.3px;
    display: block;
  }
  .vital-brand-sub {
    font-size: 12px;
    color: #64748b;
    font-weight: 600;
    text-transform: capitalize;
  }
  .vital-nav-links {
    display: flex;
    align-items: center;
    gap: 26px;
    list-style: none;
    margin: 0;
    padding: 0;
  }
  .vital-nav-links a {
    color: #334155;
    text-decoration: none;
    font-weight: 600;
    font-size: 14.5px;
    position: relative;
    padding: 6px 0;
    transition: color 0.2s;
  }
  .vital-nav-links a:hover,
  .vital-nav-links a.active {
    color: #0d9488;
  }
  .vital-nav-links a.active::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 100%;
    height: 3px;
    background: #0d9488;
    border-radius: 3px;
  }
  .vital-nav-actions {
    display: flex;
    align-items: center;
    gap: 14px;
  }
  .btn-vital-book {
    background: #0d9488;
    color: #ffffff !important;
    font-weight: 700;
    font-size: 14px;
    padding: 10px 22px;
    border-radius: 30px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 14px rgba(13, 148, 136, 0.3);
    transition: all 0.2s ease;
  }
  .btn-vital-book:hover {
    background: #0f766e;
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(13, 148, 136, 0.4);
    color: #ffffff;
  }
  .vital-search-btn {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    border: 1px solid #e2e8f0;
    background: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #64748b;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
  }
  .vital-search-btn:hover {
    background: #f1f5f9;
    color: #0f172a;
  }

  .vital-menu-toggle {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    border: 1.5px solid #e2e8f0;
    background: #ffffff;
    display: none;
    align-items: center;
    justify-content: center;
    color: #0f172a;
    font-size: 17px;
    cursor: pointer;
    transition: all 0.2s;
  }
  .vital-menu-toggle:hover {
    background: #f1f5f9;
    color: #0d9488;
  }
  .vital-mobile-menu {
    display: none;
    background: #ffffff;
    border-top: 1px solid #e2e8f0;
    box-shadow: 0 12px 30px rgba(0,0,0,0.08);
    padding: 18px 24px;
  }
  .vital-mobile-menu.open {
    display: block;
    animation: vitalMenuSlide 0.22s ease-out;
  }
  @keyframes vitalMenuSlide {
    from { opacity: 0; transform: translateY(-6px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .vital-mobile-links {
    list-style: none;
    padding: 0;
    margin: 0 0 16px 0;
  }
  .vital-mobile-links li {
    border-bottom: 1px solid #f1f5f9;
  }
  .vital-mobile-links a {
    display: block;
    padding: 11px 4px;
    color: #1e293b;
    text-decoration: none;
    font-weight: 600;
    font-size: 14.5px;
  }
  .vital-mobile-links a:hover,
  .vital-mobile-links a.active {
    color: #0d9488;
  }

  @media (max-width: 991px) {
    .vital-top-main,
    .vital-nav-main {
      padding: 0 16px;
    }
    .vital-nav-links {
      display: none;
    }
    .vital-top-bar {
      display: none;
    }
    .vital-menu-toggle {
      display: flex;
    }
    .btn-vital-book {
      padding: 8px 16px;
      font-size: 13px;
    }
  }

  @media (max-width: 576px) {
    .vital-brand-name {
      font-size: 16.5px;
    }
    .vital-brand-sub {
      font-size: 11px;
    }
    .btn-vital-book span {
      display: none;
    }
  }
</style>

<header>
  <!-- 1. Top Sub-Header Bar -->
  <div class="vital-top-bar">
    <div class="vital-top-main">
      <div class="vital-top-left">
        <span><i class="fa-regular fa-circle-check text-success mr-1"></i> Your Health, Our Priority</span>
        <span class="divider">|</span>
        <span><i class="fa-regular fa-clock mr-1" style="color: #0d9488;"></i> Open 7 Days a Week</span>
      </div>
      <div class="vital-top-right">
        <span><i class="fa-solid fa-globe mr-1" style="color: #94a3b8;"></i> INR (₹)</span>
        <a href="#booking-section"><i class="fa-regular fa-calendar-check mr-1" style="color: #0d9488;"></i> Book Appointment</a>
        <a href="{{ $clinic->phone ? 'tel:'.$clinic->phone : '#' }}"><i class="fa-solid fa-phone mr-1" style="color: #0d9488;"></i> {{ $clinic->phone ?? '+91 9830012345' }}</a>
        <a href="{{ url('/admin/login') }}"><i class="fa-solid fa-user-doctor mr-1"></i> Doctor Portal</a>
      </div>
    </div>
  </div>

  <!-- 2. Main Sticky Modern Navbar -->
  <div class="vital-nav-bar">
    <div class="vital-nav-main">
      <a href="{{ $clinicUrl }}" class="vital-brand">
        @if($clinic && $clinic->logo)
          <img src="{{ URL::to($clinic->logo) }}" alt="{{ $clinic->name }}" style="max-height: 44px; object-fit: contain;">
        @else
          <div class="vital-logo-icon">
            <i class="fa-solid fa-plus-large fa-hospital"></i>
          </div>
        @endif
        <div class="vital-brand-info">
          <span class="vital-brand-name">{{ $clinic->name ?? 'VitalCare Health Clinic' }}</span>
          <span class="vital-brand-sub">{{ $clinic->specialization ?? 'Health Clinic & Consultation' }}</span>
        </div>
      </a>

      <!-- Desktop Navigation Links -->
      <ul class="vital-nav-links">
        <li><a href="{{ $clinicUrl }}" class="{{ !request()->is('*/page/*') && !request()->is('*/book_appointment*') ? 'active' : '' }}">Home</a></li>

        @php
          $publishedPages = ($clinic && $clinic->pages) ? $clinic->pages->where('is_published', true) : collect();
          $aboutPage = $publishedPages->first(function($p) { return in_array($p->slug, ['about-us', 'about', 'about-doctor']); });
          $servicesPage = $publishedPages->first(function($p) { return in_array($p->slug, ['our-services', 'services', 'treatments']); });
          $doctorsPage = $publishedPages->first(function($p) { return in_array($p->slug, ['doctors', 'medical-team', 'specialists']); });
          
          $featuredSlugs = array_filter([$aboutPage?->slug, $servicesPage?->slug, $doctorsPage?->slug]);
          $otherPages = $publishedPages->reject(function($p) use ($featuredSlugs) {
              return in_array($p->slug, $featuredSlugs);
          });
        @endphp

        <!-- About Us (Custom Page or Section) -->
        @if($aboutPage)
          <li><a href="{{ url('/c/' . ($clinic->subdomain ?? $clinic->slug) . '/page/' . $aboutPage->slug) }}" class="{{ request()->is('*/page/' . $aboutPage->slug) ? 'active' : '' }}">{{ $aboutPage->title }}</a></li>
        @else
          <li><a href="{{ $clinicUrl }}#about-section">About Us</a></li>
        @endif

        <!-- Our Services (Custom Page or Section) -->
        @if($servicesPage)
          <li><a href="{{ url('/c/' . ($clinic->subdomain ?? $clinic->slug) . '/page/' . $servicesPage->slug) }}" class="{{ request()->is('*/page/' . $servicesPage->slug) ? 'active' : '' }}">{{ $servicesPage->title }}</a></li>
        @else
          <li><a href="{{ $clinicUrl }}#services-section">Our Services</a></li>
        @endif

        <!-- Doctors (Custom Page or Section) -->
        @if($doctorsPage)
          <li><a href="{{ url('/c/' . ($clinic->subdomain ?? $clinic->slug) . '/page/' . $doctorsPage->slug) }}" class="{{ request()->is('*/page/' . $doctorsPage->slug) ? 'active' : '' }}">{{ $doctorsPage->title }}</a></li>
        @else
          <li><a href="{{ $clinicUrl }}#doctors-section">Doctors</a></li>
        @endif

        <!-- Health Packages -->
        <li><a href="{{ $clinicUrl }}#packages-section">Health Packages</a></li>

        <!-- Other Dynamic Clinic Custom Pages -->
        @if($otherPages->count() > 0)
          @foreach($otherPages as $cp)
            <li><a href="{{ url('/c/' . ($clinic->subdomain ?? $clinic->slug) . '/page/' . $cp->slug) }}" class="{{ request()->is('*/page/' . $cp->slug) ? 'active' : '' }}">{{ $cp->title }}</a></li>
          @endforeach
        @endif

        <li><a href="{{ $clinicUrl }}#contact-section">Contact</a></li>
      </ul>

      <!-- Action Buttons -->
      <div class="vital-nav-actions">
        <a href="#booking-section" class="btn-vital-book">
          <i class="fa-regular fa-calendar-check"></i> <span>Book Appointment</span>
        </a>
        <a href="{{ $clinic->phone ? 'tel:'.$clinic->phone : '#contact-section' }}" class="vital-search-btn" title="Call Clinic">
          <i class="fa-solid fa-phone"></i>
        </a>
        <!-- Mobile Toggle Button -->
        <button type="button" class="vital-menu-toggle" id="vitalMenuBtn" onclick="toggleMobileNav()" aria-label="Toggle Navigation Menu">
          <i class="fa-solid fa-bars" id="menuToggleIcon"></i>
        </button>
      </div>
    </div>

    <!-- 3. Mobile Navigation Collapsible Drawer -->
    <div class="vital-mobile-menu" id="vitalMobileNav">
      <ul class="vital-mobile-links">
        <li><a href="{{ $clinicUrl }}" class="{{ !request()->is('*/page/*') && !request()->is('*/book_appointment*') ? 'active' : '' }}"><i class="fa-solid fa-house me-2 text-teal"></i> Home</a></li>

        @if($aboutPage)
          <li><a href="{{ url('/c/' . ($clinic->subdomain ?? $clinic->slug) . '/page/' . $aboutPage->slug) }}" class="{{ request()->is('*/page/' . $aboutPage->slug) ? 'active' : '' }}"><i class="fa-solid fa-circle-info me-2 text-teal"></i> {{ $aboutPage->title }}</a></li>
        @else
          <li><a href="{{ $clinicUrl }}#about-section"><i class="fa-solid fa-circle-info me-2 text-teal"></i> About Us</a></li>
        @endif

        @if($servicesPage)
          <li><a href="{{ url('/c/' . ($clinic->subdomain ?? $clinic->slug) . '/page/' . $servicesPage->slug) }}" class="{{ request()->is('*/page/' . $servicesPage->slug) ? 'active' : '' }}"><i class="fa-solid fa-stethoscope me-2 text-teal"></i> {{ $servicesPage->title }}</a></li>
        @else
          <li><a href="{{ $clinicUrl }}#services-section"><i class="fa-solid fa-stethoscope me-2 text-teal"></i> Our Services</a></li>
        @endif

        @if($doctorsPage)
          <li><a href="{{ url('/c/' . ($clinic->subdomain ?? $clinic->slug) . '/page/' . $doctorsPage->slug) }}" class="{{ request()->is('*/page/' . $doctorsPage->slug) ? 'active' : '' }}"><i class="fa-solid fa-user-doctor me-2 text-teal"></i> {{ $doctorsPage->title }}</a></li>
        @else
          <li><a href="{{ $clinicUrl }}#doctors-section"><i class="fa-solid fa-user-doctor me-2 text-teal"></i> Doctors</a></li>
        @endif

        <li><a href="{{ $clinicUrl }}#packages-section"><i class="fa-solid fa-box-open me-2 text-teal"></i> Health Packages</a></li>

        @if($otherPages->count() > 0)
          @foreach($otherPages as $cp)
            <li><a href="{{ url('/c/' . ($clinic->subdomain ?? $clinic->slug) . '/page/' . $cp->slug) }}" class="{{ request()->is('*/page/' . $cp->slug) ? 'active' : '' }}"><i class="fa-solid fa-file-lines me-2 text-teal"></i> {{ $cp->title }}</a></li>
          @endforeach
        @endif

        <li><a href="{{ $clinicUrl }}#contact-section"><i class="fa-solid fa-location-dot me-2 text-teal"></i> Contact</a></li>
        <li><a href="{{ url('/admin/login') }}"><i class="fa-solid fa-lock me-2 text-teal"></i> Doctor Portal</a></li>
      </ul>

      <div class="d-flex flex-column gap-2 pt-2">
        <a href="#booking-section" class="btn btn-vital-primary w-100 text-center py-2 text-white" style="background: #0d9488; border-radius: 30px; text-decoration: none;" onclick="toggleMobileNav()">
          <i class="fa-regular fa-calendar-check me-2"></i> Book Appointment Now
        </a>
        @if($clinic->phone)
        <a href="tel:{{ $clinic->phone }}" class="btn btn-outline-secondary w-100 text-center py-2" style="border-radius: 30px;">
          <i class="fa-solid fa-phone me-2 text-teal"></i> Call {{ $clinic->phone }}
        </a>
        @endif
      </div>
    </div>
  </div>
</header>

<script>
function toggleMobileNav() {
  var menu = document.getElementById('vitalMobileNav');
  var icon = document.getElementById('menuToggleIcon');
  if (!menu) return;
  menu.classList.toggle('open');
  if (menu.classList.contains('open')) {
    icon.classList.remove('fa-bars');
    icon.classList.add('fa-xmark');
  } else {
    icon.classList.remove('fa-xmark');
    icon.classList.add('fa-bars');
  }
}
</script>