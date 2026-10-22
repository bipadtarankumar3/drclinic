@extends('admin.layouts.main')

@section('style')
<style>
.support-channel-card {
  border: 1.5px solid #e2e8f0;
  border-radius: 18px;
  background: #ffffff;
  padding: 28px 24px;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
  box-shadow: 0 2px 6px rgba(0,0,0,0.02);
}
.support-channel-card:hover {
  transform: translateY(-3px);
  border-color: #cbd5e1;
  box-shadow: 0 12px 28px rgba(0,0,0,0.06);
}
.support-channel-icon {
  width: 52px;
  height: 52px;
  border-radius: 14px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 26px;
  margin-bottom: 18px;
}
.support-whatsapp-icon {
  background: #dcfce7;
  color: #16a34a;
}
.support-phone-icon {
  background: #e0f2fe;
  color: #0284c7;
}
.support-email-icon {
  background: #ede9fe;
  color: #7c3aed;
}
.support-faq-card {
  border: 1px solid #e2e8f0;
  border-radius: 14px;
  margin-bottom: 12px;
  background: #ffffff;
  overflow: hidden;
  transition: border-color 0.2s;
}
.support-faq-card:hover {
  border-color: #cbd5e1;
}
.support-faq-btn {
  width: 100%;
  text-align: left;
  padding: 18px 22px;
  font-size: 15px;
  font-weight: 700;
  color: #0f172a;
  background: transparent;
  border: none;
  display: flex;
  align-items: center;
  justify-content: space-between;
  cursor: pointer;
}
.support-faq-btn:focus {
  outline: none;
}
.support-faq-btn i {
  transition: transform 0.2s ease;
  color: #64748b;
  font-size: 18px;
}
.support-faq-btn[aria-expanded="true"] i {
  transform: rotate(180deg);
  color: #0d9488;
}
.support-faq-body {
  padding: 0 22px 20px 22px;
  color: #475569;
  font-size: 14px;
  line-height: 1.7;
}
.diagnostics-box {
  background: #f8fafc;
  border: 1.5px dashed #cbd5e1;
  border-radius: 14px;
  padding: 20px;
}
</style>
@endsection

@section('content')
<div class="content-wrapper">
  <!-- Page Header -->
  <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 pb-2">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <h2 class="font-weight-bold mb-0 text-dark" style="font-size: 26px; letter-spacing: -0.5px;">Support &amp; Help Desk</h2>
        <span class="badge" style="background: #dcfce7; color: #15803d; font-weight: 700; font-size: 11px; padding: 5px 12px; border-radius: 9999px; letter-spacing: 0.5px;">
          <span style="display: inline-block; width: 7px; height: 7px; border-radius: 50%; background: #16a34a; margin-right: 6px;"></span> ACTIVE HELP DESK
        </span>
      </div>
      <p class="text-muted mb-0" style="font-size: 13.5px;">
        Direct support channels, onboarding assistance, domain setup guides, and troubleshooting for your clinic.
      </p>
    </div>

    <div class="d-flex align-items-center gap-2 mt-3 mt-md-0">
      <a href="{{ route('doctor.dashboard') }}" class="btn btn-outline-secondary btn-sm font-weight-bold px-3 py-2" style="border-radius: 8px;">
        <i class="mdi mdi-arrow-left mr-1"></i> Doctor Dashboard
      </a>
      <a href="{{ route('doctor.settings') }}" class="btn btn-primary btn-sm font-weight-bold px-3 py-2" style="border-radius: 8px;">
        <i class="mdi mdi-tune mr-1"></i> Clinic Settings
      </a>
    </div>
  </div>

  <!-- Row 1: Direct Support Channels (3 Cards - No message form) -->
  <div class="row g-4 mb-5">
    <!-- Channel 1: WhatsApp -->
    <div class="col-lg-4 col-md-6 mb-4">
      <div class="support-channel-card">
        <div>
          <div class="support-channel-icon support-whatsapp-icon">
            <i class="mdi mdi-whatsapp"></i>
          </div>
          <span class="badge mb-2" style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; font-size: 11px; font-weight: 700;">INSTANT RESPONSE</span>
          <h4 class="font-weight-bold text-dark mb-2" style="font-size: 19px;">WhatsApp Technical Support</h4>
          <p class="text-muted font-13 mb-4" style="line-height: 1.6;">
            Chat directly with our technical engineers for instant onboarding, Razorpay gateway verification, or domain mapping guidance.
          </p>
        </div>

        <div>
          <div class="d-flex align-items-center justify-content-between p-2 mb-3 rounded-3" style="background: #f8fafc; font-size: 12.5px;">
            <span class="text-muted">Available Hours:</span>
            <strong class="text-dark">9:00 AM – 9:00 PM IST</strong>
          </div>
          <a href="https://wa.me/919830012345?text={{ urlencode('Hello DrClinic Support, I need assistance with clinic: ' . ($clinic->name ?? 'My Clinic') . ' (ID: ' . ($clinic->id ?? 'N/A') . ')') }}" target="_blank" class="btn text-white font-weight-bold w-100 py-2" style="background: #16a34a; border-radius: 10px; font-size: 14px; box-shadow: 0 4px 12px rgba(22, 163, 74, 0.25);">
            <i class="mdi mdi-whatsapp mr-1"></i> Chat on WhatsApp
          </a>
        </div>
      </div>
    </div>

    <!-- Channel 2: Phone Helpline -->
    <div class="col-lg-4 col-md-6 mb-4">
      <div class="support-channel-card">
        <div>
          <div class="support-channel-icon support-phone-icon">
            <i class="mdi mdi-phone-in-talk"></i>
          </div>
          <span class="badge mb-2" style="background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; font-size: 11px; font-weight: 700;">VOICE DESK</span>
          <h4 class="font-weight-bold text-dark mb-2" style="font-size: 19px;">Doctor Helpline Desk</h4>
          <p class="text-muted font-13 mb-4" style="line-height: 1.6;">
            Need quick voice assistance? Speak directly with a healthcare support specialist for urgent queries, booking issues, or billing.
          </p>
        </div>

        <div>
          <div class="d-flex align-items-center justify-content-between p-2 mb-3 rounded-3" style="background: #f8fafc; font-size: 12.5px;">
            <span class="text-muted">Direct Line:</span>
            <strong class="text-dark">+91 98300 12345</strong>
          </div>
          <a href="tel:+919830012345" class="btn text-white font-weight-bold w-100 py-2" style="background: #0284c7; border-radius: 10px; font-size: 14px; box-shadow: 0 4px 12px rgba(2, 132, 199, 0.25);">
            <i class="mdi mdi-phone mr-1"></i> Call Support Helpline
          </a>
        </div>
      </div>
    </div>

    <!-- Channel 3: Official Email -->
    <div class="col-lg-4 col-md-12 mb-4">
      <div class="support-channel-card">
        <div>
          <div class="support-channel-icon support-email-icon">
            <i class="mdi mdi-email-check-outline"></i>
          </div>
          <span class="badge mb-2" style="background: #faf5ff; color: #6b21a8; border: 1px solid #e9d5ff; font-size: 11px; font-weight: 700;">EMAIL &amp; GST</span>
          <h4 class="font-weight-bold text-dark mb-2" style="font-size: 19px;">Official Support Desk</h4>
          <p class="text-muted font-13 mb-4" style="line-height: 1.6;">
            Send ticket inquiries for subscription billing, GST invoices, custom integrations, or data export requests.
          </p>
        </div>

        <div>
          <div class="d-flex align-items-center justify-content-between p-2 mb-3 rounded-3" style="background: #f8fafc; font-size: 12.5px;">
            <span class="text-muted">Avg Response:</span>
            <strong class="text-dark">Within 2 to 4 Hours</strong>
          </div>
          <a href="mailto:support@drclinic.in?subject={{ urlencode('Support Request: ' . ($clinic->name ?? 'Clinic')) }}&body={{ urlencode('Clinic ID: ' . ($clinic->id ?? '') . "\nSubdomain: " . ($clinic->subdomain ?? '') . "\n\nQuery details:") }}" class="btn text-white font-weight-bold w-100 py-2" style="background: #7c3aed; border-radius: 10px; font-size: 14px; box-shadow: 0 4px 12px rgba(124, 58, 237, 0.25);">
            <i class="mdi mdi-email-outline mr-1"></i> Send Support Email
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Row 2: Clinic Diagnostics & Helpful Quick Links -->
  <div class="row g-4 mb-5">
    <!-- Left: Clinic Account Diagnostics (For Support Referral) -->
    <div class="col-lg-7 col-md-12 mb-3">
      <div class="card border-0 shadow-sm rounded-4 h-100" style="border-radius: 18px; border: 1px solid #e2e8f0; background: #ffffff;">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h5 class="font-weight-bold text-dark mb-1" style="font-size: 17px;">
                <i class="mdi mdi-information-outline text-primary mr-1"></i> Clinic Account Diagnostics
              </h5>
              <p class="text-muted mb-0 font-13">When contacting support, having this information ready speeds up resolution.</p>
            </div>
            <button type="button" class="btn btn-outline-secondary btn-sm font-weight-bold" onclick="copyDiagnostics()" id="copyDiagBtn" style="border-radius: 8px;">
              <i class="mdi mdi-content-copy mr-1"></i> Copy Info
            </button>
          </div>

          <div class="diagnostics-box" id="diagnosticsContent">
            <div class="row g-3" style="font-size: 13.5px;">
              <div class="col-sm-6">
                <span class="text-muted d-block font-12">Clinic Name:</span>
                <strong class="text-dark">{{ $clinic->name }}</strong>
              </div>
              <div class="col-sm-6">
                <span class="text-muted d-block font-12">Clinic ID / Reference:</span>
                <strong class="text-dark">#{{ $clinic->id }} ({{ $clinic->slug }})</strong>
              </div>
              <div class="col-sm-6">
                <span class="text-muted d-block font-12">Subdomain URL:</span>
                <strong class="text-primary">{{ $clinic->subdomain }}.{{ request()->getHost() }}</strong>
              </div>
              <div class="col-sm-6">
                <span class="text-muted d-block font-12">Custom Domain:</span>
                <strong class="text-dark">{{ $clinic->custom_domain ?: 'None configured' }}</strong>
              </div>
              <div class="col-sm-6">
                <span class="text-muted d-block font-12">Razorpay Gateway:</span>
                <strong class="{{ $clinic->razorpay_enabled ? 'text-success' : 'text-warning' }}">
                  {{ $clinic->razorpay_enabled ? 'Active (Direct to Doctor)' : 'Pending Configuration' }}
                </strong>
              </div>
              <div class="col-sm-6">
                <span class="text-muted d-block font-12">Subscription Status:</span>
                <span class="badge" style="background: #dcfce7; color: #166534; font-weight: 700; font-size: 11px;">
                  {{ strtoupper($clinic->status ?? 'ACTIVE') }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right: Quick Settings Shortcuts -->
    <div class="col-lg-5 col-md-12 mb-3">
      <div class="card border-0 shadow-sm rounded-4 h-100" style="border-radius: 18px; border: 1px solid #e2e8f0; background: #ffffff;">
        <div class="card-body p-4">
          <h5 class="font-weight-bold text-dark mb-1" style="font-size: 17px;">
            <i class="mdi mdi-lightning-bolt-outline text-warning mr-1"></i> Quick Configuration
          </h5>
          <p class="text-muted mb-3 font-13">Common configuration settings you can manage yourself in seconds:</p>

          <div class="d-flex flex-column gap-2">
            <a href="{{ route('doctor.settings') }}#razorpay" class="d-flex align-items-center justify-content-between p-3 rounded-3 text-decoration-none border" style="background: #ffffff; transition: background 0.2s;">
              <div class="d-flex align-items-center gap-2">
                <i class="mdi mdi-credit-card-outline text-warning font-18" style="font-size: 20px;"></i>
                <div>
                  <strong class="text-dark d-block font-14">Setup Razorpay Payment Key</strong>
                  <small class="text-muted font-12">Direct online consultation fee to your bank</small>
                </div>
              </div>
              <i class="mdi mdi-chevron-right text-muted"></i>
            </a>

            <a href="{{ route('doctor.settings') }}#domain" class="d-flex align-items-center justify-content-between p-3 rounded-3 text-decoration-none border" style="background: #ffffff; transition: background 0.2s;">
              <div class="d-flex align-items-center gap-2">
                <i class="mdi mdi-web text-success font-18" style="font-size: 20px;"></i>
                <div>
                  <strong class="text-dark d-block font-14">Connect Custom Domain (CNAME)</strong>
                  <small class="text-muted font-12">Use your own domain like clinicname.com</small>
                </div>
              </div>
              <i class="mdi mdi-chevron-right text-muted"></i>
            </a>

            <a href="{{ route('doctor.services.index') }}" class="d-flex align-items-center justify-content-between p-3 rounded-3 text-decoration-none border" style="background: #ffffff; transition: background 0.2s;">
              <div class="d-flex align-items-center gap-2">
                <i class="mdi mdi-medical-bag text-primary font-18" style="font-size: 20px;"></i>
                <div>
                  <strong class="text-dark d-block font-14">Manage Clinic Services &amp; Fees</strong>
                  <small class="text-muted font-12">Add or update treatments shown on storefront</small>
                </div>
              </div>
              <i class="mdi mdi-chevron-right text-muted"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Row 3: Comprehensive Self-Service FAQ Accordion (No Form) -->
  <div class="card border-0 shadow-sm rounded-4 mb-5" style="border-radius: 18px; border: 1px solid #e2e8f0; background: #ffffff;">
    <div class="card-body p-4 p-md-5">
      <div class="text-center mb-4">
        <h4 class="font-weight-bold text-dark mb-1" style="font-size: 22px;">Frequently Asked Questions</h4>
        <p class="text-muted mb-0 font-14">Instant answers for common doctor and clinic management inquiries.</p>
      </div>

      <div class="accordion" id="supportFaqAccordion">
        <!-- FAQ 1 -->
        <div class="support-faq-card">
          <button class="support-faq-btn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="false" aria-controls="faq1">
            <span><i class="mdi mdi-help-circle-outline text-primary mr-2" style="margin-right: 8px;"></i> How do I receive online patient consultation fees?</span>
            <i class="mdi mdi-chevron-down"></i>
          </button>
          <div id="faq1" class="collapse" data-bs-parent="#supportFaqAccordion">
            <div class="support-faq-body border-top pt-3">
              Go to <strong>Settings &rarr; Doctor Razorpay</strong>. Enter your personal <strong>Razorpay Key ID</strong> and <strong>Key Secret</strong> from your Razorpay Dashboard. Once enabled, 100% of patient online consultation fees go directly to your personal bank account. DrClinic does not hold or delay your patient funds.
            </div>
          </div>
        </div>

        <!-- FAQ 2 -->
        <div class="support-faq-card">
          <button class="support-faq-btn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2">
            <span><i class="mdi mdi-help-circle-outline text-primary mr-2" style="margin-right: 8px;"></i> How do I connect my own custom domain (e.g. drsharma.com)?</span>
            <i class="mdi mdi-chevron-down"></i>
          </button>
          <div id="faq2" class="collapse" data-bs-parent="#supportFaqAccordion">
            <div class="support-faq-body border-top pt-3">
              Go to <strong>Settings &rarr; Domain &amp; Subdomain</strong>. Enter your custom domain name. Then, in your domain registrar DNS settings (GoDaddy, Namecheap, Cloudflare, etc.), add a <strong>CNAME</strong> record pointing to our server hostname. If you need any assistance, click the <em>WhatsApp Technical Support</em> button above and our engineers will set it up for you.
            </div>
          </div>
        </div>

        <!-- FAQ 3 -->
        <div class="support-faq-card">
          <button class="support-faq-btn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3" aria-expanded="false" aria-controls="faq3">
            <span><i class="mdi mdi-help-circle-outline text-primary mr-2" style="margin-right: 8px;"></i> How do I mark doctor leaves, emergencies, or unavailability?</span>
            <i class="mdi mdi-chevron-down"></i>
          </button>
          <div id="faq3" class="collapse" data-bs-parent="#supportFaqAccordion">
            <div class="support-faq-body border-top pt-3">
              Click <strong>Unavailability</strong> in the left sidebar menu. Select the specific date or date range and the time slot you are away. Those slots will be instantly removed from your public booking calendar so patients cannot book during your leave.
            </div>
          </div>
        </div>

        <!-- FAQ 4 -->
        <div class="support-faq-card">
          <button class="support-faq-btn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4" aria-expanded="false" aria-controls="faq4">
            <span><i class="mdi mdi-help-circle-outline text-primary mr-2" style="margin-right: 8px;"></i> Can I customize the website colors to match my clinic brand?</span>
            <i class="mdi mdi-chevron-down"></i>
          </button>
          <div id="faq4" class="collapse" data-bs-parent="#supportFaqAccordion">
            <div class="support-faq-body border-top pt-3">
              Yes! Visit <strong>Settings &rarr; Branding &amp; Colors</strong>. You can choose from one of our curated medical palettes (Medical Teal, Royal Blue, Emerald, Crimson, etc.) or pick your exact custom HEX color. All public pages, calendars, buttons, and custom pages immediately reflect your chosen theme.
            </div>
          </div>
        </div>

        <!-- FAQ 5 -->
        <div class="support-faq-card">
          <button class="support-faq-btn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5" aria-expanded="false" aria-controls="faq5">
            <span><i class="mdi mdi-help-circle-outline text-primary mr-2" style="margin-right: 8px;"></i> How do I create informative pages like About Us, Facilities, or FAQs?</span>
            <i class="mdi mdi-chevron-down"></i>
          </button>
          <div id="faq5" class="collapse" data-bs-parent="#supportFaqAccordion">
            <div class="support-faq-body border-top pt-3">
              Use <strong>Custom Pages</strong> in your sidebar. You can write rich text, embed clinic photos, patient guides, and hospital policies using the built-in rich text editor. All published pages automatically appear in your storefront navigation menu.
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
function copyDiagnostics() {
  const clinicName = "{{ $clinic->name }}";
  const clinicId = "{{ $clinic->id }}";
  const slug = "{{ $clinic->slug }}";
  const subdomain = "{{ $clinic->subdomain }}.{{ request()->getHost() }}";
  const customDomain = "{{ $clinic->custom_domain ?: 'None' }}";
  const razorpay = "{{ $clinic->razorpay_enabled ? 'Active' : 'Inactive' }}";

  const text = `DrClinic Support Diagnostics:\nClinic Name: ${clinicName}\nClinic ID: #${clinicId} (${slug})\nSubdomain: ${subdomain}\nCustom Domain: ${customDomain}\nRazorpay: ${razorpay}`;

  navigator.clipboard.writeText(text).then(function() {
    const btn = document.getElementById('copyDiagBtn');
    btn.innerHTML = '<i class="mdi mdi-check mr-1 text-success"></i> Copied!';
    setTimeout(() => {
      btn.innerHTML = '<i class="mdi mdi-content-copy mr-1"></i> Copy Info';
    }, 2500);
  });
}
</script>
@endsection
