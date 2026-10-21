@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  <div class="row mb-4">
    <div class="col-12">
      <h2 class="font-weight-bold mb-1"><i class="mdi mdi-tune text-primary mr-1"></i> Clinic & Gateway Settings</h2>
      <p class="text-muted mb-0">Manage clinic profile, your personal Razorpay credentials, branding colors, and domain settings.</p>
    </div>
  </div>

  @if(session('success'))
  <div class="alert alert-success alert-dismissible fade show rounded-3 p-3 mb-4" role="alert">
    <strong><i class="mdi mdi-check-circle mr-1"></i> Success!</strong> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  @if($errors->any())
  <div class="alert alert-danger rounded-3 p-3 mb-4" role="alert">
    <ul class="mb-0">
      @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <div class="row">
    <!-- Left Navigation Tabs -->
    <div class="col-md-3 grid-margin stretch-card">
      <div class="card border-0 shadow-sm rounded-4" style="border-radius: 16px;">
        <div class="card-body p-3">
          <div class="nav flex-column nav-pills" id="settingsTab" role="tablist">
            <button class="nav-link active text-start py-3 px-3 mb-2 rounded-3 font-weight-bold" id="profile-tab" data-bs-toggle="pill" data-bs-target="#profile" type="button" role="tab">
              <i class="mdi mdi-hospital-building mr-2"></i> Clinic Profile
            </button>
            <button class="nav-link text-start py-3 px-3 mb-2 rounded-3 font-weight-bold" id="razorpay-tab" data-bs-toggle="pill" data-bs-target="#razorpay" type="button" role="tab">
              <i class="mdi mdi-credit-card-outline mr-2 text-warning"></i> Doctor Razorpay
            </button>
            <button class="nav-link text-start py-3 px-3 mb-2 rounded-3 font-weight-bold" id="branding-tab" data-bs-toggle="pill" data-bs-target="#branding" type="button" role="tab">
              <i class="mdi mdi-palette-outline mr-2 text-info"></i> Branding & Colors
            </button>
            <button class="nav-link text-start py-3 px-3 mb-2 rounded-3 font-weight-bold" id="domain-tab" data-bs-toggle="pill" data-bs-target="#domain" type="button" role="tab">
              <i class="mdi mdi-web mr-2 text-success"></i> Domain & Subdomain
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Tab Contents -->
    <div class="col-md-9 grid-margin stretch-card">
      <div class="card border-0 shadow-sm rounded-4" style="border-radius: 16px;">
        <div class="card-body p-4 p-md-5">
          <div class="tab-content" id="settingsTabContent">

            <!-- 1. Clinic Profile Tab -->
            <div class="tab-pane fade show active" id="profile" role="tabpanel">
              <h4 class="font-weight-bold mb-3">Clinic Profile Details</h4>
              <p class="text-muted font-14 mb-4">This information is shown to your patients on your public booking page and appointment receipts.</p>

              <form action="{{ route('doctor.settings.profile') }}" method="POST">
                @csrf
                <div class="row g-3">
                  <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Clinic / Practice Name</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name', $clinic->name) }}" required>
                  </div>

                  <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Medical Specialization</label>
                    <input type="text" class="form-control" name="specialization" value="{{ old('specialization', $clinic->specialization) }}" placeholder="e.g. Neurologist, Cardiologist">
                  </div>

                  <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Consultation Fee (₹)</label>
                    <input type="number" step="0.01" class="form-control" name="consultation_fee" value="{{ old('consultation_fee', $clinic->consultation_fee) }}">
                    <small class="text-muted">Standard fee charged to patients for booking an appointment.</small>
                  </div>

                  <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Helpline Phone Number</label>
                    <input type="text" class="form-control" name="phone" value="{{ old('phone', $clinic->phone) }}">
                  </div>

                  <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Clinic Contact Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email', $clinic->email) }}">
                  </div>

                  <div class="col-12 mb-3">
                    <label class="form-label font-weight-bold">Clinic Physical Address</label>
                    <textarea class="form-control" name="address" rows="2">{{ old('address', $clinic->address) }}</textarea>
                  </div>

                  <div class="col-12 mb-4">
                    <label class="form-label font-weight-bold">Doctor Bio / Clinic About</label>
                    <textarea class="form-control" name="bio" rows="4" placeholder="Brief background about doctor qualifications, experience, and facilities.">{{ old('bio', $clinic->bio) }}</textarea>
                  </div>

                  <div class="col-12">
                    <button type="submit" class="btn btn-primary px-4 font-weight-bold">Save Profile Details</button>
                  </div>
                </div>
              </form>
            </div>

            <!-- 2. Doctor Razorpay Gateway Tab -->
            <div class="tab-pane fade" id="razorpay" role="tabpanel">
              <h4 class="font-weight-bold mb-2">Doctor's Razorpay Payment Gateway</h4>
              <p class="text-muted font-14 mb-4">
                Enter your personal Razorpay API credentials. When patients pay the consultation fee for booking an appointment, 
                <strong>100% of the funds go directly into your personal Razorpay account</strong>.
              </p>

              <div class="alert alert-info rounded-3 p-3 mb-4">
                <i class="mdi mdi-information mr-1"></i> You can obtain your <strong>Key ID</strong> and <strong>Key Secret</strong> from your <a href="https://dashboard.razorpay.com/#/access/api-keys" target="_blank" class="font-weight-bold text-primary">Razorpay Dashboard &rarr; Settings &rarr; API Keys</a>.
              </div>

              <form action="{{ route('doctor.settings.razorpay') }}" method="POST">
                @csrf
                <div class="row g-3">
                  <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Razorpay Key ID</label>
                    <input type="text" class="form-control font-monospace" name="razorpay_key" value="{{ old('razorpay_key', $clinic->razorpay_key) }}" placeholder="rzp_live_...">
                  </div>

                  <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Razorpay Key Secret</label>
                    <input type="password" class="form-control font-monospace" name="razorpay_secret" value="{{ old('razorpay_secret', $clinic->razorpay_secret) }}" placeholder="••••••••••••">
                  </div>

                  <div class="col-12 mb-3">
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="razorpay_enabled" name="razorpay_enabled" value="1" {{ $clinic->razorpay_enabled ? 'checked' : '' }}>
                      <label class="form-check-label font-weight-bold" for="razorpay_enabled">Enable Online Payments (Razorpay Checkout)</label>
                      <div class="text-muted font-13">Allow patients to pay online via UPI, Credit/Debit cards, Net Banking, and Wallets.</div>
                    </div>
                  </div>

                  <div class="col-12 mb-4">
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="allow_cash_booking" name="allow_cash_booking" value="1" {{ $clinic->allow_cash_booking ? 'checked' : '' }}>
                      <label class="form-check-label font-weight-bold" for="allow_cash_booking">Allow "Pay at Clinic" (Cash Payment)</label>
                      <div class="text-muted font-13">Patients can confirm their appointment and pay the consultation fee in cash upon arrival.</div>
                    </div>
                  </div>

                  <div class="col-12">
                    <button type="submit" class="btn btn-primary px-4 font-weight-bold">Save Payment Gateway Settings</button>
                  </div>
                </div>
              </form>
            </div>

            <!-- 3. Branding & Colors Tab -->
            <div class="tab-pane fade" id="branding" role="tabpanel">
              <h4 class="font-weight-bold mb-2">Clinic Theme & Website Branding</h4>
              <p class="text-muted font-14 mb-4">Customize colors, logo, and header banner for your public booking website to match your clinic brand.</p>

              <form action="{{ route('doctor.settings.branding') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                  <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Primary Brand Color</label>
                    <div class="d-flex align-items-center gap-2">
                      <input type="color" class="form-control form-control-color" name="theme_color" value="{{ old('theme_color', $clinic->theme_color ?? '#0d6efd') }}" style="width: 50px; height: 42px;">
                      <input type="text" class="form-control" value="{{ $clinic->theme_color ?? '#0d6efd' }}" readonly style="font-family: monospace;">
                    </div>
                  </div>

                  <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Secondary Accent Color</label>
                    <div class="d-flex align-items-center gap-2">
                      <input type="color" class="form-control form-control-color" name="secondary_color" value="{{ old('secondary_color', $clinic->secondary_color ?? '#20c997') }}" style="width: 50px; height: 42px;">
                      <input type="text" class="form-control" value="{{ $clinic->secondary_color ?? '#20c997' }}" readonly style="font-family: monospace;">
                    </div>
                  </div>

                  <div class="col-md-6 mb-4">
                    <label class="form-label font-weight-bold">Clinic Logo</label>
                    @if($clinic->logo)
                      <div class="mb-2">
                        <img src="{{ asset($clinic->logo) }}" alt="Logo" class="img-thumbnail" style="max-height: 60px;">
                      </div>
                    @endif
                    <input type="file" class="form-control" name="logo" accept="image/*">
                    <small class="text-muted">Recommended: PNG or SVG with transparent background.</small>
                  </div>

                  <div class="col-md-6 mb-4">
                    <label class="form-label font-weight-bold">Header Banner Image</label>
                    @if($clinic->banner)
                      <div class="mb-2">
                        <img src="{{ asset($clinic->banner) }}" alt="Banner" class="img-thumbnail" style="max-height: 60px;">
                      </div>
                    @endif
                    <input type="file" class="form-control" name="banner" accept="image/*">
                    <small class="text-muted">High-res clinic facade or medical facility banner.</small>
                  </div>

                  <div class="col-12">
                    <button type="submit" class="btn btn-primary px-4 font-weight-bold">Save Branding</button>
                  </div>
                </div>
              </form>
            </div>

            <!-- 4. Domain & Subdomain Tab -->
            <div class="tab-pane fade" id="domain" role="tabpanel">
              <h4 class="font-weight-bold mb-2">Domain & Subdomain Setup</h4>
              <p class="text-muted font-14 mb-4">Configure your unique clinic subdomain or connect your own custom domain.</p>

              <form action="{{ route('doctor.settings.domain') }}" method="POST">
                @csrf
                <div class="row g-3">
                  <div class="col-12 mb-4">
                    <label class="form-label font-weight-bold">Your Clinic Subdomain</label>
                    <div class="input-group">
                      <input type="text" class="form-control" name="subdomain" value="{{ old('subdomain', $clinic->subdomain) }}" required>
                      <span class="input-group-text bg-light font-weight-bold">.{{ request()->getHost() }}</span>
                    </div>
                    <small class="text-muted">Your clinic is accessible via <strong>https://{{ $clinic->subdomain }}.{{ request()->getHost() }}</strong> or fallback <strong>{{ url('/c/' . $clinic->subdomain) }}</strong></small>
                  </div>

                  <div class="col-12 mb-4">
                    <label class="form-label font-weight-bold">Custom Domain (e.g. www.drsmithclinic.com)</label>
                    <input type="text" class="form-control" name="custom_domain" value="{{ old('custom_domain', $clinic->custom_domain) }}" placeholder="e.g. clinic.drroy.com or drsmithcare.com">
                    <small class="text-muted">Point a CNAME or A Record from your domain DNS provider to this server's IP address.</small>
                  </div>

                  <div class="col-12">
                    <button type="submit" class="btn btn-primary px-4 font-weight-bold">Save Domain Settings</button>
                  </div>
                </div>
              </form>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
