@php
  $clinic = $currentClinic ?? \App\Models\Clinic::first();
  $clinicUrl = $clinic ? url('/c/' . ($clinic->subdomain ?? $clinic->slug)) : url('/');
  $contactUrl = $clinic ? url('/c/' . ($clinic->subdomain ?? $clinic->slug) . '/contact') : url('/contact');
@endphp

<footer class="vital-footer" style="background: #0f172a; color: #94a3b8; padding-top: 60px; margin-top: 60px; border-top: 1px solid #1e293b;">
  <div class="container-fluid" style="padding-left: 36px; padding-right: 36px;">
    <div class="row g-4 pb-5">
      <!-- Col 1: Brand & Bio -->
      <div class="col-lg-4 col-md-6">
        @php
          $footerBrandMode = $clinic->brand_display_mode ?? 'both';
          $footerShowLogo = (!$clinic || $clinic->showBrandLogo());
          $footerShowText = (!$clinic || $clinic->showBrandText());
          if ($footerBrandMode === 'logo_only' && (!$clinic || empty($clinic->logo))) {
              $footerShowText = true;
          }
        @endphp
        <div class="d-flex align-items-center mb-3" style="gap: 12px;">
          @if($footerShowLogo)
            @if($clinic && $clinic->logo)
              <img src="{{ $clinic->logo_url ?? URL::to('public/' . $clinic->logo) }}" alt="{{ $clinic->name }}" style="max-height: {{ $footerBrandMode === 'logo_only' ? '54px' : '44px' }}; max-width: {{ $footerBrandMode === 'logo_only' ? '220px' : '150px' }}; object-fit: contain;">
            @else
              <div style="width: 42px; height: 42px; border-radius: 12px; background: linear-gradient(135deg, var(--clinic-primary) 0%, var(--clinic-secondary) 100%); display: flex; align-items: center; justify-content: center; color: #ffffff; font-size: 20px;">
                <i class="fa-solid fa-hospital"></i>
              </div>
            @endif
          @endif

          @if($footerShowText)
            <div>
              <h5 class="mb-0 text-white font-weight-bold" style="font-size: 20px;">{{ $clinic->name ?? 'VitalCare Clinic' }}</h5>
              <small class="text-muted" style="color: #64748b !important;">{{ $clinic->specialization ?? 'Comprehensive Healthcare' }}</small>
            </div>
          @endif
        </div>
        <p style="font-size: 14px; line-height: 1.6; color: #94a3b8;">
          {{ $clinic->bio ?? 'Dedicated to delivering patient-centric medical excellence with state-of-the-art facilities, certified doctors, and modern healthcare solutions.' }}
        </p>
        <div class="d-flex mt-3" style="gap: 12px;">
          <a href="#" style="width: 36px; height: 36px; border-radius: 50%; background: #1e293b; color: #38bdf8; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fa-brands fa-facebook-f"></i></a>
          <a href="#" style="width: 36px; height: 36px; border-radius: 50%; background: #1e293b; color: #f43f5e; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fa-brands fa-instagram"></i></a>
          <a href="#" style="width: 36px; height: 36px; border-radius: 50%; background: #1e293b; color: var(--clinic-primary); display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fa-brands fa-whatsapp"></i></a>
        </div>
      </div>

      <!-- Col 2: Quick Links -->
      <div class="col-lg-2 col-md-6">
        <h6 class="text-white font-weight-bold mb-3" style="text-transform: uppercase; font-size: 13px; letter-spacing: 0.5px;">Navigation</h6>
        <ul class="list-unstyled" style="font-size: 14px; line-height: 2;">
          <li><a href="{{ $clinicUrl }}" style="color: #94a3b8; text-decoration: none; transition: color 0.2s;">Home</a></li>
          @if($clinic && $clinic->pages && $clinic->pages->where('is_published', true)->count() > 0)
            @foreach($clinic->pages->where('is_published', true)->take(4) as $fp)
              <li><a href="{{ url('/c/' . ($clinic->subdomain ?? $clinic->slug) . '/page/' . $fp->slug) }}" style="color: #94a3b8; text-decoration: none; transition: color 0.2s;">{{ $fp->title }}</a></li>
            @endforeach
          @else
            <li><a href="{{ $clinicUrl }}#about-section" style="color: #94a3b8; text-decoration: none; transition: color 0.2s;">About Us</a></li>
            <li><a href="{{ $clinicUrl }}#services-section" style="color: #94a3b8; text-decoration: none; transition: color 0.2s;">Our Services</a></li>
          @endif
          <li><a href="{{ $contactUrl }}" style="color: #94a3b8; text-decoration: none; transition: color 0.2s;">Contact &amp; Location</a></li>
          <li><a href="{{ $clinicUrl }}#booking-section" style="color: var(--clinic-primary); font-weight: 600; text-decoration: none; transition: color 0.2s;">Book Appointment</a></li>
        </ul>
      </div>

      <!-- Col 3: Services & Treatments Offered -->
      <div class="col-lg-3 col-md-6">
        <h6 class="text-white font-weight-bold mb-3" style="text-transform: uppercase; font-size: 13px; letter-spacing: 0.5px;">Clinical Services</h6>
        <ul class="list-unstyled" style="font-size: 14px; line-height: 2;">
          @if($clinic && $clinic->activeServices && $clinic->activeServices->count() > 0)
            @foreach($clinic->activeServices->take(6) as $cs)
              <li><a href="{{ $clinicUrl }}#services-section" style="color: #cbd5e1; text-decoration: none;"><i class="{{ $cs->icon_class }} me-1" style="color: var(--clinic-primary); font-size: 12px; margin-right: 6px;"></i> {{ $cs->title }}</a></li>
            @endforeach
          @else
            <li><span style="color: #cbd5e1;"><i class="fa-solid fa-user-doctor me-1" style="color: var(--clinic-primary); font-size: 12px; margin-right: 6px;"></i> Specialist Consultation</span></li>
            <li><span style="color: #cbd5e1;"><i class="fa-solid fa-stethoscope me-1" style="color: var(--clinic-primary); font-size: 12px; margin-right: 6px;"></i> Diagnostics & Health Audits</span></li>
            <li><span style="color: #cbd5e1;"><i class="fa-solid fa-heart-pulse me-1" style="color: var(--clinic-primary); font-size: 12px; margin-right: 6px;"></i> Preventive Health Screenings</span></li>
            <li><span style="color: #cbd5e1;"><i class="fa-solid fa-hand-holding-medical me-1" style="color: var(--clinic-primary); font-size: 12px; margin-right: 6px;"></i> Follow-up & Treatment Care</span></li>
          @endif
        </ul>
      </div>

      <!-- Col 4: Contact & Emergency -->
      <div class="col-lg-3 col-md-6">
        <h6 class="text-white font-weight-bold mb-3" style="text-transform: uppercase; font-size: 13px; letter-spacing: 0.5px;">Emergency & Visit</h6>
        <div class="mb-3 d-flex" style="gap: 12px; font-size: 14px;">
          <i class="fa-solid fa-location-dot mt-1" style="color: var(--clinic-primary);"></i>
          <span>{{ $clinic->address ?? 'Main Medical Street, Health District' }}</span>
        </div>
        <div class="mb-3 d-flex" style="gap: 12px; font-size: 14px;">
          <i class="fa-solid fa-phone mt-1" style="color: var(--clinic-primary);"></i>
          <a href="tel:{{ $clinic->phone ?? '+919830012345' }}" style="color: #ffffff; font-weight: 700; text-decoration: none;">
            {{ $clinic->phone ?? '+91 9830012345' }}
          </a>
        </div>
        <div class="mb-3 d-flex" style="gap: 12px; font-size: 14px;">
          <i class="fa-solid fa-envelope mt-1" style="color: var(--clinic-primary);"></i>
          <a href="mailto:{{ $clinic->email ?? 'doctor@drclinic.com' }}" style="color: #94a3b8; text-decoration: none;">
            {{ $clinic->email ?? 'doctor@drclinic.com' }}
          </a>
        </div>
        <div class="p-3 rounded-3 mt-3 d-flex align-items-center" style="background: rgba(var(--clinic-primary-rgb, 13, 148, 136), 0.12); border: 1px solid rgba(var(--clinic-primary-rgb, 13, 148, 136), 0.3); gap: 12px;">
          <div style="width: 38px; height: 38px; border-radius: 50%; background: var(--clinic-primary); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0;">
            <i class="fa-solid fa-headset"></i>
          </div>
          <div>
            <div style="color: #ffffff; font-size: 13.5px; font-weight: 700;">24/7 Patient Helpline</div>
            <div style="color: #94a3b8; font-size: 12px;">Immediate Emergency Support</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bottom Copyright -->
    <div class="py-4 border-top border-secondary d-flex flex-wrap justify-content-between align-items-center" style="border-color: #1e293b !important; font-size: 13px;">
      <div>
        &copy; {{ date('Y') }} <strong>{{ $clinic->name ?? 'VitalCare Clinic' }}</strong>. All rights reserved.
      </div>
      <div>
        <a href="{{ url('/admin/login') }}" style="color: #64748b; text-decoration: none; margin-left: 15px;"><i class="fa-solid fa-lock mr-1"></i> Doctor Portal</a>
        <a href="#booking-section" style="color: var(--clinic-primary); text-decoration: none; margin-left: 15px;">Book Consultation</a>
      </div>
    </div>
  </div>
</footer>