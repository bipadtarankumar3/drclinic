@php
  $clinic = $currentClinic ?? \App\Models\Clinic::first();
  $clinicUrl = $clinic ? url('/c/' . ($clinic->subdomain ?? $clinic->slug)) : url('/');
@endphp

<footer class="vital-footer" style="background: #0f172a; color: #94a3b8; padding-top: 60px; margin-top: 60px; border-top: 1px solid #1e293b;">
  <div class="container-fluid" style="padding-left: 36px; padding-right: 36px;">
    <div class="row g-4 pb-5">
      <!-- Col 1: Brand & Bio -->
      <div class="col-lg-4 col-md-6">
        <div class="d-flex align-items-center mb-3" style="gap: 12px;">
          @if($clinic && $clinic->logo)
            <img src="{{ asset($clinic->logo) }}" alt="{{ $clinic->name }}" style="max-height: 44px; max-width: 150px; object-fit: contain;">
          @else
            <div style="width: 42px; height: 42px; border-radius: 12px; background: linear-gradient(135deg, #0d9488 0%, #14b8a6 100%); display: flex; align-items: center; justify-content: center; color: #ffffff; font-size: 20px;">
              <i class="fa-solid fa-hospital"></i>
            </div>
          @endif
          <div>
            <h5 class="mb-0 text-white font-weight-bold" style="font-size: 20px;">{{ $clinic->name ?? 'VitalCare Clinic' }}</h5>
            <small class="text-muted" style="color: #64748b !important;">{{ $clinic->specialization ?? 'Comprehensive Healthcare' }}</small>
          </div>
        </div>
        <p style="font-size: 14px; line-height: 1.6; color: #94a3b8;">
          {{ $clinic->bio ?? 'Dedicated to delivering patient-centric medical excellence with state-of-the-art facilities, certified doctors, and modern healthcare solutions.' }}
        </p>
        <div class="d-flex mt-3" style="gap: 12px;">
          <a href="#" style="width: 36px; height: 36px; border-radius: 50%; background: #1e293b; color: #38bdf8; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fa-brands fa-facebook-f"></i></a>
          <a href="#" style="width: 36px; height: 36px; border-radius: 50%; background: #1e293b; color: #f43f5e; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fa-brands fa-instagram"></i></a>
          <a href="#" style="width: 36px; height: 36px; border-radius: 50%; background: #1e293b; color: #0d9488; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fa-brands fa-whatsapp"></i></a>
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
          <li><a href="{{ $clinicUrl }}#booking-section" style="color: #0d9488; font-weight: 600; text-decoration: none; transition: color 0.2s;">Book Appointment</a></li>
        </ul>
      </div>

      <!-- Col 3: Specialties -->
      <div class="col-lg-3 col-md-6">
        <h6 class="text-white font-weight-bold mb-3" style="text-transform: uppercase; font-size: 13px; letter-spacing: 0.5px;">Specialties</h6>
        <ul class="list-unstyled" style="font-size: 14px; line-height: 2;">
          <li><span style="color: #cbd5e1;">Cardiology & Heart Care</span></li>
          <li><span style="color: #cbd5e1;">General Medicine & Diagnosis</span></li>
          <li><span style="color: #cbd5e1;">Dental Solutions & Surgery</span></li>
          <li><span style="color: #cbd5e1;">Women's & Maternal Health</span></li>
          <li><span style="color: #cbd5e1;">Neurology & Spine Care</span></li>
          <li><span style="color: #cbd5e1;">Preventive Health Checkups</span></li>
        </ul>
      </div>

      <!-- Col 4: Contact & Emergency -->
      <div class="col-lg-3 col-md-6">
        <h6 class="text-white font-weight-bold mb-3" style="text-transform: uppercase; font-size: 13px; letter-spacing: 0.5px;">Emergency & Visit</h6>
        <div class="mb-3 d-flex" style="gap: 12px; font-size: 14px;">
          <i class="fa-solid fa-location-dot mt-1" style="color: #0d9488;"></i>
          <span>{{ $clinic->address ?? 'Main Medical Street, Health District' }}</span>
        </div>
        <div class="mb-3 d-flex" style="gap: 12px; font-size: 14px;">
          <i class="fa-solid fa-phone mt-1" style="color: #0d9488;"></i>
          <a href="tel:{{ $clinic->phone ?? '+919830012345' }}" style="color: #ffffff; font-weight: 700; text-decoration: none;">
            {{ $clinic->phone ?? '+91 9830012345' }}
          </a>
        </div>
        <div class="mb-3 d-flex" style="gap: 12px; font-size: 14px;">
          <i class="fa-solid fa-envelope mt-1" style="color: #0d9488;"></i>
          <a href="mailto:{{ $clinic->email ?? 'doctor@drclinic.com' }}" style="color: #94a3b8; text-decoration: none;">
            {{ $clinic->email ?? 'doctor@drclinic.com' }}
          </a>
        </div>
        <div class="p-3 rounded-3 mt-3 d-flex align-items-center" style="background: rgba(13, 148, 136, 0.12); border: 1px solid rgba(13, 148, 136, 0.3); gap: 12px;">
          <div style="width: 38px; height: 38px; border-radius: 50%; background: #0d9488; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0;">
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
        <a href="#booking-section" style="color: #0d9488; text-decoration: none; margin-left: 15px;">Book Consultation</a>
      </div>
    </div>
  </div>
</footer>