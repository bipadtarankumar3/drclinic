@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  <!-- Page Header -->
  <div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="gap: 12px;">
    <div>
      <div class="d-flex align-items-center" style="gap: 12px;">
        <div class="d-flex align-items-center justify-content-center shadow-sm" style="width: 44px; height: 44px; border-radius: 12px; background: linear-gradient(135deg, #2563eb, #06b6d4); color: #ffffff; font-size: 22px;">
          <i class="mdi mdi-tune-vertical"></i>
        </div>
        <div>
          <h3 class="font-weight-bold text-dark mb-0" style="letter-spacing: -0.4px;">
            Platform Master Settings
          </h3>
          <p class="text-muted font-13 mb-0">Configure global SaaS parameters, master Razorpay subscription gateway, fees, and system announcements.</p>
        </div>
      </div>
    </div>

    <div>
      <span class="badge" style="background: #eff6ff; color: #2563eb; border: 1.5px solid #bfdbfe; font-size: 12px; font-weight: 700; padding: 6px 14px; border-radius: 20px;">
        <i class="mdi mdi-shield-crown-outline mr-1"></i> Super Admin Master Scope
      </span>
    </div>
  </div>

  @if(session('success'))
  <div class="alert alert-success alert-dismissible fade show rounded-4 p-3 mb-4 shadow-sm" role="alert" style="border: 1px solid #a7f3d0; background: #ecfdf5; color: #065f46;">
    <div class="d-flex align-items-center">
      <i class="mdi mdi-check-circle-outline font-22 mr-2" style="margin-right: 8px;"></i>
      <strong>{{ session('success') }}</strong>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  @if(isset($errors) && $errors->any())
  <div class="alert alert-danger rounded-4 p-3 mb-4 shadow-sm" style="border: 1px solid #fecaca; background: #fef2f2; color: #991b1b;">
    <div class="d-flex align-items-center mb-1 font-weight-bold">
      <i class="mdi mdi-alert-circle-outline font-20 mr-2" style="margin-right: 8px;"></i> Please check the form errors below:
    </div>
    <ul class="mb-0 pl-4 font-13">
      @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <form action="{{ isset($setting) ? URL::to('admin/setting/setting_submit/' . $setting->id) : URL::to('admin/setting/setting_submit') }}" method="POST">
    @csrf
    <input type="hidden" name="id" value="{{ isset($setting) ? $setting->id : '' }}">

    <!-- 1. Platform Identity & Support Helpline -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="border-radius: 16px; border: 1.5px solid #e2e8f0; background: #ffffff;">
      <div class="card-body p-4">
        <div class="d-flex align-items-center mb-3 pb-2 border-bottom" style="border-color: #f1f5f9 !important;">
          <div class="d-flex align-items-center justify-content-center mr-3 shadow-sm" style="width: 36px; height: 36px; border-radius: 10px; background: #eff6ff; color: #2563eb; font-size: 18px; margin-right: 12px;">
            <i class="mdi mdi-domain"></i>
          </div>
          <div>
            <h5 class="font-weight-bold text-dark mb-0 font-16">Platform Identity &amp; Support Helpline</h5>
            <small class="text-muted">General identity displayed across administrative emails, reports, and tenant onboarding.</small>
          </div>
        </div>

        <div class="row g-3">
          <div class="col-md-4 mb-3">
            <label class="form-label font-weight-bold text-dark font-13">Platform Name</label>
            <div class="input-group">
              <span class="input-group-text bg-light text-muted border-end-0"><i class="mdi mdi-hospital-building"></i></span>
              <input type="text" class="form-control" name="platform_name" value="{{ old('platform_name', $setting->platform_name ?? 'DrClinic SaaS') }}" required placeholder="e.g. DrClinic SaaS">
            </div>
          </div>

          <div class="col-md-4 mb-3">
            <label class="form-label font-weight-bold text-dark font-13">Platform Support Email</label>
            <div class="input-group">
              <span class="input-group-text bg-light text-muted border-end-0"><i class="mdi mdi-email-outline"></i></span>
              <input type="email" class="form-control" name="platform_email" value="{{ old('platform_email', $setting->platform_email ?? 'support@drclinic.com') }}" placeholder="support@drclinic.com">
            </div>
          </div>

          <div class="col-md-4 mb-3">
            <label class="form-label font-weight-bold text-dark font-13">Platform Helpline / WhatsApp</label>
            <div class="input-group">
              <span class="input-group-text bg-light text-success border-end-0"><i class="mdi mdi-whatsapp"></i></span>
              <input type="text" class="form-control" name="clinic_phone_number" value="{{ old('clinic_phone_number', $setting->clinic_phone_number ?? '+91 9631775097') }}" placeholder="+91 9631775097">
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- 2. SaaS Defaults & Financial Parameters -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="border-radius: 16px; border: 1.5px solid #e2e8f0; background: #ffffff;">
      <div class="card-body p-4">
        <div class="d-flex align-items-center mb-3 pb-2 border-bottom" style="border-color: #f1f5f9 !important;">
          <div class="d-flex align-items-center justify-content-center mr-3 shadow-sm" style="width: 36px; height: 36px; border-radius: 10px; background: #ecfdf5; color: #059669; font-size: 18px; margin-right: 12px;">
            <i class="mdi mdi-cash-multiple"></i>
          </div>
          <div>
            <h5 class="font-weight-bold text-dark mb-0 font-16">SaaS Defaults &amp; Convenience Charges</h5>
            <small class="text-muted">Master platform fees added to patient bookings and default trial period for new clinics.</small>
          </div>
        </div>

        <div class="row g-3">
          <div class="col-md-4 mb-3">
            <label class="form-label font-weight-bold text-dark font-13">Platform Convenience Fee (₹)</label>
            <div class="input-group">
              <span class="input-group-text bg-light text-muted font-weight-bold">₹</span>
              <input type="number" step="0.01" class="form-control" name="pay_additional_amount" value="{{ old('pay_additional_amount', $setting->pay_additional_amount ?? 40) }}" required placeholder="40">
            </div>
            <small class="text-muted font-11">Default platform service charge added per patient booking transaction.</small>
          </div>

          <div class="col-md-4 mb-3">
            <label class="form-label font-weight-bold text-dark font-13">Default Free Trial Duration (Days)</label>
            <div class="input-group">
              <span class="input-group-text bg-light text-muted"><i class="mdi mdi-calendar-clock"></i></span>
              <input type="number" class="form-control" name="default_trial_days" value="{{ old('default_trial_days', $setting->default_trial_days ?? 14) }}" min="0" placeholder="14">
            </div>
            <small class="text-muted font-11">Number of trial days newly registered clinics receive before needing a plan.</small>
          </div>

          <div class="col-md-4 mb-3">
            <label class="form-label font-weight-bold text-dark font-13">Platform Currency</label>
            <div class="d-flex gap-2" style="gap: 8px;">
              <input type="text" class="form-control text-center font-weight-bold" name="currency_symbol" value="{{ old('currency_symbol', $setting->currency_symbol ?? '₹') }}" style="max-width: 70px;" placeholder="₹">
              <input type="text" class="form-control font-weight-bold" name="currency_code" value="{{ old('currency_code', $setting->currency_code ?? 'INR') }}" placeholder="INR">
            </div>
            <small class="text-muted font-11">Default currency used across billing invoices and plans.</small>
          </div>
        </div>
      </div>
    </div>

    <!-- 3. Master Platform Razorpay Gateway Credentials -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="border-radius: 16px; border: 1.5px solid #e2e8f0; background: #ffffff;">
      <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3 pb-2 border-bottom" style="border-color: #f1f5f9 !important; gap: 10px;">
          <div class="d-flex align-items-center">
            <div class="d-flex align-items-center justify-content-center mr-3 shadow-sm" style="width: 36px; height: 36px; border-radius: 10px; background: #eff6ff; color: #2563eb; font-size: 18px; margin-right: 12px;">
              <i class="mdi mdi-credit-card-fast-outline"></i>
            </div>
            <div>
              <h5 class="font-weight-bold text-dark mb-0 font-16">Master Platform Razorpay Gateway</h5>
              <small class="text-muted">Collects recurring SaaS subscription payments when clinics buy or upgrade plans.</small>
            </div>
          </div>

          <div>
            <span class="badge" style="background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 20px;">
              <i class="mdi mdi-lock-check-outline mr-1"></i> Subscriptions Gateway
            </span>
          </div>
        </div>

        <div class="alert alert-info rounded-3 p-3 mb-4" style="background: #f0f7ff; border: 1px solid #bae6fd; color: #0369a1;">
          <div class="d-flex align-items-start" style="gap: 10px;">
            <i class="mdi mdi-information-outline font-20 flex-shrink-0 mt-1"></i>
            <div class="font-12" style="line-height: 1.5;">
              <strong>Platform Gateway vs Doctor Gateways:</strong>
              These master credentials collect payments when clinics upgrade to paid subscription tiers (Starter, Professional, Enterprise). Doctor consultation fees from patients are routed directly to each doctor's individual Razorpay account configured inside their clinic portal.
            </div>
          </div>
        </div>

        <div class="row g-3">
          <div class="col-md-6 mb-3">
            <label class="form-label font-weight-bold text-dark font-13">Platform Razorpay Key ID</label>
            <div class="input-group">
              <span class="input-group-text bg-light text-muted border-end-0"><i class="mdi mdi-key-variant"></i></span>
              <input type="text" class="form-control font-monospace font-13" name="pay_key" value="{{ old('pay_key', $setting->pay_key ?? env('RAZORPAY_KEY')) }}" placeholder="rzp_live_..." required>
            </div>
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label font-weight-bold text-dark font-13">Platform Razorpay Secret Key</label>
            <div class="input-group">
              <span class="input-group-text bg-light text-muted border-end-0"><i class="mdi mdi-lock-outline"></i></span>
              <input type="password" class="form-control font-monospace font-13" id="paySecretKeyInput" name="pay_secret_key" value="{{ old('pay_secret_key', $setting->pay_secret_key ?? env('RAZORPAY_SECRET')) }}" placeholder="••••••••••••••••" required>
              <button class="btn btn-outline-secondary border-start-0" type="button" onclick="toggleSecretVisibility()">
                <i class="mdi mdi-eye-outline" id="toggleSecretIcon"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- 4. Global Broadcast & SaaS Platform Policies -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="border-radius: 16px; border: 1.5px solid #e2e8f0; background: #ffffff;">
      <div class="card-body p-4">
        <div class="d-flex align-items-center mb-3 pb-2 border-bottom" style="border-color: #f1f5f9 !important;">
          <div class="d-flex align-items-center justify-content-center mr-3 shadow-sm" style="width: 36px; height: 36px; border-radius: 10px; background: #fff1f2; color: #be123c; font-size: 18px; margin-right: 12px;">
            <i class="mdi mdi-bullhorn-outline"></i>
          </div>
          <div>
            <h5 class="font-weight-bold text-dark mb-0 font-16">Global Broadcast &amp; SaaS Policies</h5>
            <small class="text-muted">System-wide advisory banners and platform master terms of service.</small>
          </div>
        </div>

        <div class="row g-3">
          <div class="col-md-6 mb-3">
            <label class="form-label font-weight-bold text-dark font-13">
              <i class="mdi mdi-bullhorn text-danger mr-1"></i> Global Announcement / System Notice
            </label>
            <textarea name="frontend_notice" rows="7" class="form-control font-13" placeholder="Broadcast notification visible across all portals (e.g., Scheduled maintenance, system upgrade advisory, holiday announcement)..." style="resize: vertical;">{{ old('frontend_notice', $setting->frontend_notice) }}</textarea>
            <small class="text-muted font-11">Broadcast alert displayed globally. Leave empty if no announcement is needed.</small>
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label font-weight-bold text-dark font-13">
              <i class="mdi mdi-file-document-outline text-primary mr-1"></i> Platform SaaS Terms &amp; Conditions
            </label>
            <textarea name="payment_terms_and_condition" rows="7" class="form-control font-13" placeholder="Master terms and conditions governing clinic subscriptions, data privacy, and usage policies..." style="resize: vertical;">{{ old('payment_terms_and_condition', $setting->payment_terms_and_condition) }}</textarea>
            <small class="text-muted font-11">The overarching SaaS platform agreement for clinics and practitioners.</small>
          </div>
        </div>
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="d-flex justify-content-end align-items-center mb-5" style="gap: 12px;">
      <a href="{{ route('admin.saas.dashboard') }}" class="btn font-weight-bold px-4 py-2" style="border-radius: 10px; font-size: 14px; background: #ffffff; border: 1.5px solid #cbd5e1; color: #475569;">
        Cancel
      </a>
      <button type="submit" class="btn font-weight-bold text-white px-4 py-2 d-flex align-items-center" style="background: linear-gradient(135deg, #2563eb, #1d4ed8); border: none; border-radius: 10px; font-size: 14px; box-shadow: 0 4px 14px rgba(37,99,235,0.3);">
        <i class="mdi mdi-content-save-outline font-18 mr-2" style="margin-right: 6px;"></i> Save Platform Settings
      </button>
    </div>
  </form>
</div>

<script>
function toggleSecretVisibility() {
  const input = document.getElementById('paySecretKeyInput');
  const icon = document.getElementById('toggleSecretIcon');
  if (input.type === 'password') {
    input.type = 'text';
    icon.className = 'mdi mdi-eye-off-outline';
  } else {
    input.type = 'password';
    icon.className = 'mdi mdi-eye-outline';
  }
}
</script>
@endsection
