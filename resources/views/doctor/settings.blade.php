@extends('admin.layouts.main')

@section('style')
<style>
  /* Modern Doctor Settings Custom Styles */
  .brand-option-card {
    border-radius: 14px !important;
    position: relative;
    user-select: none;
    border: 1.5px solid #e2e8f0 !important;
    background: #ffffff;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
  }
  .brand-option-card:hover {
    border-color: #cbd5e1 !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
  }
  .brand-option-card.active-brand-card {
    border-color: #0d9488 !important;
    background: #f0fdfa !important;
    box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.12);
  }
  .brand-radio-indicator {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 2px solid #cbd5e1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    flex-shrink: 0;
  }
  .active-brand-card .brand-radio-indicator {
    border-color: #0d9488;
    background: #0d9488;
  }
  .active-brand-card .brand-radio-indicator::after {
    content: '';
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #ffffff;
  }

  /* Custom Toggle Switch Cards */
  .doctor-switch-card {
    background: #ffffff;
    border: 1.5px solid #e2e8f0;
    border-radius: 14px;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 14px;
    transition: all 0.2s ease;
  }
  .doctor-switch-card:hover {
    border-color: #cbd5e1;
  }
  .doctor-switch-card.is-active {
    background: #f0fdfa;
    border-color: #0d9488;
    box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.08);
  }
  .doctor-switch-title {
    font-weight: 700;
    font-size: 14.5px;
    color: #0f172a;
    cursor: pointer;
  }
  .doctor-switch-desc {
    font-size: 12.5px;
    line-height: 1.45;
    color: #64748b;
  }
  .doctor-toggle-pill {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 28px;
    flex-shrink: 0;
    margin: 0;
    cursor: pointer;
  }
  .doctor-toggle-pill input {
    opacity: 0;
    width: 0;
    height: 0;
    position: absolute;
  }
  .doctor-toggle-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #cbd5e1;
    transition: .25s ease;
    border-radius: 34px;
  }
  .doctor-toggle-slider:before {
    position: absolute;
    content: "";
    height: 22px;
    width: 22px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: .25s ease;
    border-radius: 50%;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
  }
  .doctor-toggle-pill input:checked + .doctor-toggle-slider {
    background-color: #0d9488;
  }
  .doctor-toggle-pill input:checked + .doctor-toggle-slider:before {
    transform: translateX(22px);
  }

  .doctor-settings-input {
    border: 1.5px solid #e2e8f0 !important;
    border-radius: 10px !important;
    background-color: #ffffff !important;
    padding: 10px 14px !important;
    font-size: 14px !important;
    color: #1e293b !important;
    transition: border-color 0.2s, box-shadow 0.2s;
  }
  .doctor-settings-input:focus {
    border-color: #0d9488 !important;
    box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.15) !important;
    background-color: #ffffff !important;
  }
  .btn-doctor-save {
    background: linear-gradient(135deg, #0d9488 0%, #14b8a6 100%) !important;
    color: #ffffff !important;
    border: none !important;
    border-radius: 10px !important;
    padding: 11px 26px !important;
    font-weight: 700 !important;
    font-size: 14px !important;
    box-shadow: 0 4px 12px rgba(13, 148, 136, 0.25) !important;
    transition: all 0.2s;
  }
  .btn-doctor-save:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(13, 148, 136, 0.35) !important;
  }
</style>
@endsection

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

              <form action="{{ route('doctor.settings.profile') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                  <!-- Clinic Logo Upload Section -->
                  <div class="col-12 mb-3">
                    <label class="form-label font-weight-bold d-block">Clinic Logo</label>
                    <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background: #f8fafc; border: 1.5px dashed #cbd5e1;">
                      <div id="profile-logo-preview-wrap" style="width: 70px; height: 70px; border-radius: 14px; background: #ffffff; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0;">
                        @if($clinic->logo)
                          <img id="profile-logo-preview" src="{{ $clinic->logo_url ?? URL::to('public/' . $clinic->logo) }}" alt="Logo" style="max-height: 56px; max-width: 64px; object-fit: contain;">
                        @else
                          <img id="profile-logo-preview" src="" alt="Preview" style="max-height: 56px; max-width: 64px; object-fit: contain; display: none;">
                          <div id="profile-logo-placeholder" style="color: #0d9488; font-size: 28px;">
                            <i class="mdi mdi-hospital-building"></i>
                          </div>
                        @endif
                      </div>
                      <div class="flex-grow-1">
                        <input type="file" class="form-control" name="logo" id="profile-logo-input" accept="image/*" onchange="previewClinicLogo(this, 'profile-logo-preview', 'profile-logo-placeholder')">
                        <small class="text-muted d-block mt-1">
                          <i class="mdi mdi-information-outline text-primary"></i> Recommended: PNG, SVG, or WEBP with transparent background (Max: 3MB). This logo will appear on your clinic storefront, booking header, and receipts.
                        </small>
                      </div>
                    </div>
                  </div>

                  <!-- Header Branding Display Option -->
                  <div class="col-12 mb-3">
                    <label class="form-label font-weight-bold d-block text-dark">Header &amp; Storefront Brand Display</label>
                    <p class="text-muted small mb-2">Choose what identity elements are shown in your clinic's top navigation bar and footer.</p>
                    
                    <div class="row g-2">
                      <div class="col-md-4">
                        <label class="d-flex flex-column p-3 rounded-3 brand-option-card {{ ($clinic->brand_display_mode ?? 'both') === 'both' ? 'active-brand-card' : '' }}" style="cursor: pointer;" onclick="selectBrandCard(this, 'both')">
                          <input type="radio" name="brand_display_mode" value="both" {{ ($clinic->brand_display_mode ?? 'both') === 'both' ? 'checked' : '' }} class="d-none">
                          <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="font-weight-bold text-dark d-flex align-items-center" style="font-size: 13.5px;">
                              <span style="width: 28px; height: 28px; border-radius: 8px; background: rgba(13, 148, 136, 0.1); color: #0d9488; display: inline-flex; align-items: center; justify-content: center; margin-right: 8px;">
                                <i class="mdi mdi-view-headline font-16"></i>
                              </span>
                              Both (Logo + Name)
                            </span>
                            <span class="brand-radio-indicator"></span>
                          </div>
                          <small class="text-muted" style="font-size: 12px; line-height: 1.4;">Shows your logo image side-by-side with your clinic name and department.</small>
                        </label>
                      </div>

                      <div class="col-md-4">
                        <label class="d-flex flex-column p-3 rounded-3 brand-option-card {{ ($clinic->brand_display_mode ?? 'both') === 'logo_only' ? 'active-brand-card' : '' }}" style="cursor: pointer;" onclick="selectBrandCard(this, 'logo_only')">
                          <input type="radio" name="brand_display_mode" value="logo_only" {{ ($clinic->brand_display_mode ?? 'both') === 'logo_only' ? 'checked' : '' }} class="d-none">
                          <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="font-weight-bold text-dark d-flex align-items-center" style="font-size: 13.5px;">
                              <span style="width: 28px; height: 28px; border-radius: 8px; background: rgba(13, 148, 136, 0.1); color: #0d9488; display: inline-flex; align-items: center; justify-content: center; margin-right: 8px;">
                                <i class="mdi mdi-image-outline font-16"></i>
                              </span>
                              Only Logo
                            </span>
                            <span class="brand-radio-indicator"></span>
                          </div>
                          <small class="text-muted" style="font-size: 12px; line-height: 1.4;">Displays only your graphic logo in the navbar. Ideal for horizontal logos that already have text.</small>
                        </label>
                      </div>

                      <div class="col-md-4">
                        <label class="d-flex flex-column p-3 rounded-3 brand-option-card {{ ($clinic->brand_display_mode ?? 'both') === 'text_only' ? 'active-brand-card' : '' }}" style="cursor: pointer;" onclick="selectBrandCard(this, 'text_only')">
                          <input type="radio" name="brand_display_mode" value="text_only" {{ ($clinic->brand_display_mode ?? 'both') === 'text_only' ? 'checked' : '' }} class="d-none">
                          <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="font-weight-bold text-dark d-flex align-items-center" style="font-size: 13.5px;">
                              <span style="width: 28px; height: 28px; border-radius: 8px; background: rgba(13, 148, 136, 0.1); color: #0d9488; display: inline-flex; align-items: center; justify-content: center; margin-right: 8px;">
                                <i class="mdi mdi-format-text font-16"></i>
                              </span>
                              Only Text
                            </span>
                            <span class="brand-radio-indicator"></span>
                          </div>
                          <small class="text-muted" style="font-size: 12px; line-height: 1.4;">Displays clean typography of your clinic name and department without any logo graphic.</small>
                        </label>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Clinic / Practice Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control doctor-settings-input" name="name" value="{{ old('name', $clinic->name) }}" required>
                  </div>

                  <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Medical Specialization</label>
                    <input type="text" class="form-control doctor-settings-input" name="specialization" value="{{ old('specialization', $clinic->specialization) }}" placeholder="e.g. Neurologist, Cardiologist">
                  </div>

                  <!-- Consultation & Platform Pricing Section -->
                  <div class="col-12 mb-3">
                    <div class="p-3 rounded-3" style="background: #f8fafc; border: 1.5px solid #e2e8f0;">
                      <h6 class="font-weight-bold text-dark mb-1 d-flex align-items-center">
                        <i class="mdi mdi-cash-multiple text-primary mr-2" style="font-size: 18px;"></i> Consultation &amp; Platform Pricing
                      </h6>
                      <p class="text-muted small mb-3">Configure standard consultation charges and platform / convenience fees charged to patients during checkout.</p>

                      <div class="row g-3">
                        <div class="col-md-6">
                          <label class="form-label font-weight-bold text-dark" style="font-size: 13.5px;">Standard Consultation Fee (₹) <span class="text-danger">*</span></label>
                          <div class="input-group">
                            <span class="input-group-text bg-white font-weight-bold text-muted border-end-0">₹</span>
                            <input type="number" step="0.01" min="0" class="form-control doctor-settings-input border-start-0" name="consultation_fee" id="pricing-consultation-fee" value="{{ old('consultation_fee', $clinic->consultation_fee ?? 500) }}" required oninput="calculateTotalPreview()">
                          </div>
                          <small class="text-muted font-12">Consultation amount received by doctor for the appointment.</small>
                        </div>

                        <div class="col-md-6">
                          <label class="form-label font-weight-bold text-dark" style="font-size: 13.5px;">Platform / Convenience Charge (₹)</label>
                          <div class="input-group">
                            <span class="input-group-text bg-white font-weight-bold text-muted border-end-0">₹</span>
                            <input type="number" step="0.01" min="0" class="form-control doctor-settings-input border-start-0" name="platform_fee" id="pricing-platform-fee" value="{{ old('platform_fee', $clinic->platform_fee ?? 0) }}" placeholder="0.00" oninput="calculateTotalPreview()">
                          </div>
                          <small class="text-muted font-12">Optional booking convenience charge added at checkout (e.g. ₹40 or ₹0 for free).</small>
                        </div>

                        <div class="col-12 pt-1">
                          <div class="d-flex align-items-center justify-content-between p-2 px-3 rounded-2" style="background: #ffffff; border: 1px dashed #cbd5e1; font-size: 13.5px;">
                            <span class="text-muted"><i class="mdi mdi-calculator text-primary mr-1"></i> Patient Checkout Total Preview:</span>
                            <strong id="pricing-total-preview" style="color: #0d9488; font-size: 16px;">
                              ₹ {{ number_format(($clinic->consultation_fee ?? 500) + ($clinic->platform_fee ?? 0), 2) }}
                            </strong>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Helpline Phone Number</label>
                    <input type="text" class="form-control doctor-settings-input" name="phone" value="{{ old('phone', $clinic->phone) }}">
                  </div>

                  <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Clinic Contact Email</label>
                    <input type="email" class="form-control doctor-settings-input" name="email" value="{{ old('email', $clinic->email) }}">
                  </div>

                  <div class="col-12 mb-3">
                    <label class="form-label font-weight-bold">Clinic Physical Address</label>
                    <textarea class="form-control doctor-settings-input" name="address" rows="2">{{ old('address', $clinic->address) }}</textarea>
                  </div>

                  <div class="col-12 mb-4">
                    <label class="form-label font-weight-bold">Doctor Bio / Clinic About</label>
                    <textarea class="form-control doctor-settings-input" name="bio" rows="4" placeholder="Brief background about doctor qualifications, experience, and facilities.">{{ old('bio', $clinic->bio) }}</textarea>
                  </div>

                  <div class="col-12">
                    <button type="submit" class="btn btn-doctor-save">
                      <i class="mdi mdi-content-save-outline mr-1"></i> Save Profile Details &amp; Pricing
                    </button>
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

              <div class="alert alert-info rounded-3 p-3 mb-4 d-flex align-items-center" style="background: #f0fdfa; border: 1.5px solid #ccfbf1; color: #0f766e;">
                <i class="mdi mdi-information font-22 mr-2" style="color: #0d9488;"></i>
                <div>
                  You can obtain your <strong>Key ID</strong> and <strong>Key Secret</strong> from your 
                  <a href="https://dashboard.razorpay.com/#/access/api-keys" target="_blank" class="font-weight-bold" style="color: #0d9488; text-decoration: underline;">Razorpay Dashboard &rarr; Settings &rarr; API Keys</a>.
                </div>
              </div>

              <form action="{{ route('doctor.settings.razorpay') }}" method="POST">
                @csrf
                <div class="row g-3">
                  <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Razorpay Key ID</label>
                    <input type="text" class="form-control doctor-settings-input font-monospace" name="razorpay_key" value="{{ old('razorpay_key', $clinic->razorpay_key) }}" placeholder="rzp_live_...">
                  </div>

                  <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Razorpay Key Secret</label>
                    <input type="password" class="form-control doctor-settings-input font-monospace" name="razorpay_secret" value="{{ old('razorpay_secret', $clinic->razorpay_secret) }}" placeholder="••••••••••••">
                  </div>

                  <!-- Platform Charge Field Inside Payment Tab -->
                  <div class="col-12 mb-2">
                    <div class="p-3 rounded-3" style="background: #f8fafc; border: 1.5px solid #e2e8f0;">
                      <div class="row align-items-center g-3">
                        <div class="col-md-8">
                          <h6 class="font-weight-bold text-dark mb-1 d-flex align-items-center">
                            <i class="mdi mdi-tag-outline text-success mr-2 font-18"></i> Platform / Convenience Charge on Bookings
                          </h6>
                          <p class="text-muted font-13 mb-0">
                            This charge is added directly to your consultation fee at patient checkout. Set to <strong>₹0.00</strong> to offer free platform booking to your patients.
                          </p>
                        </div>
                        <div class="col-md-4">
                          <div class="input-group">
                            <span class="input-group-text bg-white font-weight-bold text-muted border-end-0">₹</span>
                            <input type="number" step="0.01" min="0" class="form-control doctor-settings-input border-start-0 font-weight-bold" name="platform_fee" value="{{ old('platform_fee', $clinic->platform_fee ?? 0) }}" placeholder="40.00">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Online Payments Toggle Card -->
                  <div class="col-12 mb-1">
                    <div class="doctor-switch-card {{ $clinic->razorpay_enabled ? 'is-active' : '' }}" onclick="if(event.target.tagName !== 'INPUT') { var cb = this.querySelector('input[type=checkbox]'); cb.checked = !cb.checked; toggleSwitchCardStyle(cb); }">
                      <div>
                        <div class="d-flex align-items-center mb-1">
                          <span style="width: 30px; height: 30px; border-radius: 8px; background: rgba(13, 148, 136, 0.1); color: #0d9488; display: inline-flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-credit-card-check-outline font-18"></i>
                          </span>
                          <span class="doctor-switch-title">Enable Online Payments (Razorpay Checkout)</span>
                        </div>
                        <div class="doctor-switch-desc" style="padding-left: 40px;">
                          Allow patients to pay online instantly via UPI (GPay, PhonePe, Paytm), Credit/Debit cards, Net Banking, and Wallets.
                        </div>
                      </div>
                      <label class="doctor-toggle-pill" onclick="event.stopPropagation();">
                        <input type="checkbox" id="razorpay_enabled" name="razorpay_enabled" value="1" {{ $clinic->razorpay_enabled ? 'checked' : '' }} onchange="toggleSwitchCardStyle(this)">
                        <span class="doctor-toggle-slider"></span>
                      </label>
                    </div>
                  </div>

                  <!-- Cash Payment Toggle Card -->
                  <div class="col-12 mb-3">
                    <div class="doctor-switch-card {{ $clinic->allow_cash_booking ? 'is-active' : '' }}" onclick="if(event.target.tagName !== 'INPUT') { var cb = this.querySelector('input[type=checkbox]'); cb.checked = !cb.checked; toggleSwitchCardStyle(cb); }">
                      <div>
                        <div class="d-flex align-items-center mb-1">
                          <span style="width: 30px; height: 30px; border-radius: 8px; background: rgba(37, 99, 235, 0.1); color: #2563eb; display: inline-flex; align-items: center; justify-content: center; margin-right: 10px;">
                            <i class="mdi mdi-cash-register font-18"></i>
                          </span>
                          <span class="doctor-switch-title">Allow "Pay at Clinic" (Cash Payment)</span>
                        </div>
                        <div class="doctor-switch-desc" style="padding-left: 40px;">
                          Patients can book their slot online and pay the consultation fee in cash upon arrival at your clinic reception.
                        </div>
                      </div>
                      <label class="doctor-toggle-pill" onclick="event.stopPropagation();">
                        <input type="checkbox" id="allow_cash_booking" name="allow_cash_booking" value="1" {{ $clinic->allow_cash_booking ? 'checked' : '' }} onchange="toggleSwitchCardStyle(this)">
                        <span class="doctor-toggle-slider"></span>
                      </label>
                    </div>
                  </div>

                  <div class="col-12">
                    <button type="submit" class="btn btn-doctor-save">
                      <i class="mdi mdi-content-save-outline mr-1"></i> Save Payment Gateway Settings
                    </button>
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
                  <!-- Quick Color Palette Presets -->
                  <div class="col-12 mb-3">
                    <label class="form-label font-weight-bold d-block">Recommended Healthcare Color Palettes</label>
                    <div class="d-flex flex-wrap gap-2">
                      <button type="button" class="btn btn-sm btn-light border d-flex align-items-center gap-2" onclick="applyColorPreset('#0d9488', '#14b8a6')">
                        <span style="width: 16px; height: 16px; border-radius: 50%; background: #0d9488; display: inline-block;"></span> Medical Teal
                      </button>
                      <button type="button" class="btn btn-sm btn-light border d-flex align-items-center gap-2" onclick="applyColorPreset('#2563eb', '#3b82f6')">
                        <span style="width: 16px; height: 16px; border-radius: 50%; background: #2563eb; display: inline-block;"></span> Royal Blue
                      </button>
                      <button type="button" class="btn btn-sm btn-light border d-flex align-items-center gap-2" onclick="applyColorPreset('#059669', '#10b981')">
                        <span style="width: 16px; height: 16px; border-radius: 50%; background: #059669; display: inline-block;"></span> Emerald Health
                      </button>
                      <button type="button" class="btn btn-sm btn-light border d-flex align-items-center gap-2" onclick="applyColorPreset('#6366f1', '#8b5cf6')">
                        <span style="width: 16px; height: 16px; border-radius: 50%; background: #6366f1; display: inline-block;"></span> Indigo Violet
                      </button>
                      <button type="button" class="btn btn-sm btn-light border d-flex align-items-center gap-2" onclick="applyColorPreset('#e11d48', '#f43f5e')">
                        <span style="width: 16px; height: 16px; border-radius: 50%; background: #e11d48; display: inline-block;"></span> Crimson Rose
                      </button>
                      <button type="button" class="btn btn-sm btn-light border d-flex align-items-center gap-2" onclick="applyColorPreset('#0f172a', '#334155')">
                        <span style="width: 16px; height: 16px; border-radius: 50%; background: #0f172a; display: inline-block;"></span> Midnight Slate
                      </button>
                      <button type="button" class="btn btn-sm btn-light border d-flex align-items-center gap-2" onclick="applyColorPreset('#d97706', '#f59e0b')">
                        <span style="width: 16px; height: 16px; border-radius: 50%; background: #d97706; display: inline-block;"></span> Amber Warm
                      </button>
                    </div>
                  </div>

                  <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Primary Brand Color</label>
                    <div class="d-flex align-items-center gap-2">
                      <input type="color" class="form-control form-control-color" id="theme_color_picker" name="theme_color" value="{{ old('theme_color', $clinic->theme_color ?? '#0d9488') }}" style="width: 50px; height: 42px; cursor: pointer;" oninput="syncColorInput('theme_color_picker', 'theme_color_text')">
                      <input type="text" class="form-control doctor-settings-input" id="theme_color_text" value="{{ old('theme_color', $clinic->theme_color ?? '#0d9488') }}" style="font-family: monospace; font-weight: 700;" oninput="syncColorPicker('theme_color_text', 'theme_color_picker')">
                    </div>
                    <small class="text-muted font-11">Applies to buttons, headers, booking slots, and active highlights across all clinic pages.</small>
                  </div>

                  <div class="col-md-6 mb-3">
                    <label class="form-label font-weight-bold">Secondary Accent Color</label>
                    <div class="d-flex align-items-center gap-2">
                      <input type="color" class="form-control form-control-color" id="secondary_color_picker" name="secondary_color" value="{{ old('secondary_color', $clinic->secondary_color ?? '#14b8a6') }}" style="width: 50px; height: 42px; cursor: pointer;" oninput="syncColorInput('secondary_color_picker', 'secondary_color_text')">
                      <input type="text" class="form-control doctor-settings-input" id="secondary_color_text" value="{{ old('secondary_color', $clinic->secondary_color ?? '#14b8a6') }}" style="font-family: monospace; font-weight: 700;" oninput="syncColorPicker('secondary_color_text', 'secondary_color_picker')">
                    </div>
                    <small class="text-muted font-11">Used for secondary gradients, badges, and accents.</small>
                  </div>

                  <!-- Live Preview Demo -->
                  <div class="col-12 mb-3">
                    <div class="p-3 rounded-3" style="background: #f8fafc; border: 1.5px dashed #cbd5e1;">
                      <span class="text-uppercase text-muted font-weight-bold" style="font-size: 11px; letter-spacing: 0.5px;">Live Storefront Component Preview</span>
                      <div class="d-flex align-items-center flex-wrap gap-3 mt-2">
                        <button type="button" id="preview-primary-btn" class="btn text-white px-3 py-2 font-weight-bold" style="background: {{ $clinic->theme_color ?? '#0d9488' }}; border-radius: 20px; font-size: 13px;">
                          <i class="mdi mdi-calendar-check mr-1"></i> Book Appointment
                        </button>
                        <span id="preview-badge" class="badge px-3 py-2" style="background: {{ $clinic->secondary_color ?? '#14b8a6' }}; color: #fff; border-radius: 12px; font-size: 12px;">
                          Instant Confirmation
                        </span>
                        <div id="preview-icon-box" style="width: 36px; height: 36px; border-radius: 10px; background: rgba(13, 148, 136, 0.15); color: {{ $clinic->theme_color ?? '#0d9488' }}; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                          <i class="mdi mdi-stethoscope"></i>
                        </div>
                        <span id="preview-text-link" style="color: {{ $clinic->theme_color ?? '#0d9488' }}; font-weight: 700; font-size: 13.5px; text-decoration: underline;">
                          Learn More &rarr;
                        </span>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6 mb-4">
                    <label class="form-label font-weight-bold">Clinic Logo</label>
                    @if($clinic->logo)
                      <div class="mb-2">
                        <img src="{{ $clinic->logo_url ?? URL::to('public/' . $clinic->logo) }}" alt="Logo" class="img-thumbnail" style="max-height: 60px;">
                      </div>
                    @endif
                    <input type="file" class="form-control doctor-settings-input" name="logo" accept="image/*">
                    <small class="text-muted">Recommended: PNG, SVG, or WEBP with transparent background.</small>
                  </div>

                  <div class="col-md-6 mb-4">
                    <label class="form-label font-weight-bold">Header Banner Image</label>
                    @if($clinic->banner)
                      <div class="mb-2">
                        <img src="{{ $clinic->banner_url ?? URL::to('public/' . $clinic->banner) }}" alt="Banner" class="img-thumbnail" style="max-height: 60px;">
                      </div>
                    @endif
                    <input type="file" class="form-control doctor-settings-input" name="banner" accept="image/*">
                    <small class="text-muted">High-res clinic facade or medical facility banner.</small>
                  </div>

                  <div class="col-12">
                    <button type="submit" class="btn btn-doctor-save">
                      <i class="mdi mdi-palette-outline mr-1"></i> Save Branding & Colors
                    </button>
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

@section('js')
<script>
function previewClinicLogo(input, imgId, placeholderId) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      var img = document.getElementById(imgId);
      var placeholder = document.getElementById(placeholderId);
      if (img) {
        img.src = e.target.result;
        img.style.display = 'block';
      }
      if (placeholder) {
        placeholder.style.display = 'none';
      }
    };
    reader.readAsDataURL(input.files[0]);
  }
}

function selectBrandCard(label, mode) {
  document.querySelectorAll('.brand-option-card').forEach(function(c) {
    c.classList.remove('active-brand-card');
    c.style.background = '#ffffff';
    c.style.setProperty('border-color', '#e2e8f0', 'important');
  });
  label.classList.add('active-brand-card');
  label.style.background = '#f0fdfa';
  label.style.setProperty('border-color', '#0d9488', 'important');
  var radio = label.querySelector('input[type="radio"]');
  if (radio) {
    radio.checked = true;
  }
}

function toggleSwitchCardStyle(input) {
  var card = input.closest('.doctor-switch-card');
  if (card) {
    if (input.checked) {
      card.classList.add('is-active');
    } else {
      card.classList.remove('is-active');
    }
  }
}

function calculateTotalPreview() {
  var feeInput = document.getElementById('pricing-consultation-fee');
  var platInput = document.getElementById('pricing-platform-fee');
  var totalElem = document.getElementById('pricing-total-preview');
  if (!totalElem) return;

  var fee = parseFloat(feeInput ? feeInput.value : 0) || 0;
  var plat = parseFloat(platInput ? platInput.value : 0) || 0;
  var total = fee + plat;
  totalElem.innerText = '₹ ' + total.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

function syncColorInput(pickerId, textId) {
  var picker = document.getElementById(pickerId);
  var text = document.getElementById(textId);
  if (picker && text) {
    text.value = picker.value;
    updateLiveBrandingPreview();
  }
}

function syncColorPicker(textId, pickerId) {
  var text = document.getElementById(textId);
  var picker = document.getElementById(pickerId);
  if (text && picker && /^#[0-9A-F]{6}$/i.test(text.value)) {
    picker.value = text.value;
    updateLiveBrandingPreview();
  }
}

function applyColorPreset(primary, secondary) {
  var tp = document.getElementById('theme_color_picker');
  var tt = document.getElementById('theme_color_text');
  var sp = document.getElementById('secondary_color_picker');
  var st = document.getElementById('secondary_color_text');

  if (tp) tp.value = primary;
  if (tt) tt.value = primary;
  if (sp) sp.value = secondary;
  if (st) st.value = secondary;

  updateLiveBrandingPreview();
}

function updateLiveBrandingPreview() {
  var primary = document.getElementById('theme_color_picker')?.value || '#0d9488';
  var secondary = document.getElementById('secondary_color_picker')?.value || '#14b8a6';

  var btn = document.getElementById('preview-primary-btn');
  if (btn) btn.style.background = primary;

  var badge = document.getElementById('preview-badge');
  if (badge) badge.style.background = secondary;

  var iconBox = document.getElementById('preview-icon-box');
  if (iconBox) {
    iconBox.style.color = primary;
    iconBox.style.background = primary + '20';
  }

  var link = document.getElementById('preview-text-link');
  if (link) link.style.color = primary;
}

document.addEventListener('DOMContentLoaded', function() {
  calculateTotalPreview();
  updateLiveBrandingPreview();
});
</script>
@endsection
