<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>DrClinic &mdash; Doctor & Clinic Portal Login</title>
  <meta name="description" content="Secure login for doctor clinics, medical staff, and administrators on DrClinic SaaS Platform." />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ URL::to('public/assets/admin/images/favicon.png') }}" />

  <!-- Google Fonts: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.2.96/css/materialdesignicons.min.css" />

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
    :root {
      --primary: #2563eb;
      --primary-dark: #1d4ed8;
      --primary-light: #eff6ff;
      --accent: #06b6d4;
      --dark-navy: #0f172a;
      --slate-800: #1e293b;
      --slate-600: #475569;
      --slate-400: #94a3b8;
      --border-color: #e2e8f0;
      --card-bg: #ffffff;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      background: #f8fafc;
      color: #1e293b;
      min-height: 100vh;
      overflow-x: hidden;
    }

    .auth-wrapper {
      min-height: 100vh;
      display: flex;
      flex-direction: row;
    }

    /* Left Branding Banner */
    .auth-banner {
      flex: 1.1;
      background: 
        linear-gradient(135deg, rgba(15, 23, 42, 0.82) 0%, rgba(15, 23, 42, 0.70) 45%, rgba(2, 32, 48, 0.86) 100%),
        url("{{ URL::to('public/assets/web/modern/family-checkup.jpg') }}");
      background-position: center center;
      background-size: cover;
      background-repeat: no-repeat;
      color: #ffffff;
      padding: 60px 70px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      position: relative;
      overflow: hidden;
    }

    .auth-banner::before {
      content: '';
      position: absolute;
      top: -120px;
      right: -120px;
      width: 450px;
      height: 450px;
      background: radial-gradient(circle, rgba(37, 99, 235, 0.25) 0%, rgba(6, 182, 212, 0.05) 70%, transparent 100%);
      border-radius: 50%;
      pointer-events: none;
    }

    .auth-banner::after {
      content: '';
      position: absolute;
      bottom: -150px;
      left: -100px;
      width: 500px;
      height: 500px;
      background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, transparent 70%);
      border-radius: 50%;
      pointer-events: none;
    }

    .brand-logo-wrap {
      display: inline-flex;
      align-items: center;
      gap: 12px;
      text-decoration: none;
      z-index: 2;
    }

    .brand-icon {
      width: 46px;
      height: 46px;
      background: linear-gradient(135deg, #2563eb, #06b6d4);
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #ffffff;
      font-size: 24px;
      box-shadow: 0 8px 20px rgba(37, 99, 235, 0.35);
    }

    .brand-text-title {
      font-size: 22px;
      font-weight: 800;
      letter-spacing: -0.5px;
      color: #ffffff;
    }

    .brand-text-badge {
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      background: rgba(255, 255, 255, 0.12);
      color: #38bdf8;
      padding: 3px 8px;
      border-radius: 6px;
      margin-left: 6px;
    }

    .banner-content {
      z-index: 2;
      max-width: 580px;
      margin: 40px 0;
    }

    .banner-headline {
      font-size: 38px;
      font-weight: 800;
      line-height: 1.25;
      letter-spacing: -1px;
      margin-bottom: 18px;
      color: #ffffff;
      text-shadow: 0 2px 14px rgba(0, 0, 0, 0.45);
    }

    .banner-headline span {
      background: linear-gradient(135deg, #38bdf8, #818cf8);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .banner-desc {
      font-size: 15.5px;
      line-height: 1.6;
      color: #e2e8f0;
      margin-bottom: 34px;
      text-shadow: 0 1px 6px rgba(0, 0, 0, 0.35);
    }

    .feature-points {
      display: flex;
      flex-direction: column;
      gap: 16px;
      margin-bottom: 40px;
    }

    .feature-item {
      display: flex;
      align-items: center;
      gap: 14px;
      background: rgba(15, 23, 42, 0.65);
      border: 1px solid rgba(255, 255, 255, 0.14);
      padding: 12px 18px;
      border-radius: 12px;
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      box-shadow: 0 4px 16px rgba(0, 0, 0, 0.18);
      transition: all 0.2s ease;
    }

    .feature-item:hover {
      background: rgba(15, 23, 42, 0.82);
      border-color: rgba(56, 189, 248, 0.35);
      transform: translateX(4px);
    }

    .feature-icon-circle {
      width: 36px;
      height: 36px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 17px;
      flex-shrink: 0;
    }

    .testimonial-card {
      background: rgba(15, 23, 42, 0.72);
      border: 1px solid rgba(255, 255, 255, 0.16);
      border-radius: 16px;
      padding: 18px 22px;
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.22);
      display: flex;
      align-items: center;
      gap: 16px;
      z-index: 2;
    }

    .doctor-avatar-wrap {
      position: relative;
    }

    .doctor-avatar {
      width: 48px;
      height: 48px;
      border-radius: 50%;
      background: linear-gradient(135deg, #0284c7, #0d9488);
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-weight: 700;
      font-size: 16px;
    }

    .online-indicator {
      position: absolute;
      bottom: 0;
      right: 0;
      width: 13px;
      height: 13px;
      background: #10b981;
      border: 2px solid #0f172a;
      border-radius: 50%;
    }

    /* Right Form Section */
    .auth-form-panel {
      flex: 0.9;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 30px;
      background: #ffffff;
      position: relative;
    }

    .form-container {
      width: 100%;
      max-width: 440px;
    }

    .form-header-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: #eff6ff;
      color: #2563eb;
      font-size: 11.5px;
      font-weight: 700;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      padding: 6px 12px;
      border-radius: 9999px;
      margin-bottom: 14px;
    }

    .form-title {
      font-size: 28px;
      font-weight: 800;
      color: #0f172a;
      letter-spacing: -0.6px;
      margin-bottom: 6px;
    }

    .form-subtitle {
      font-size: 14px;
      color: #64748b;
      margin-bottom: 26px;
    }

    .custom-input-group {
      position: relative;
      margin-bottom: 18px;
    }

    .custom-input-group label {
      display: block;
      font-size: 12.5px;
      font-weight: 700;
      color: #334155;
      margin-bottom: 7px;
      text-transform: uppercase;
      letter-spacing: 0.4px;
    }

    .input-field-wrap {
      position: relative;
    }

    .input-icon-left {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: #94a3b8;
      font-size: 17px;
      pointer-events: none;
      transition: color 0.15s ease;
    }

    .custom-form-control {
      width: 100%;
      height: 48px;
      padding: 10px 14px 10px 42px;
      border: 1.5px solid #e2e8f0;
      border-radius: 10px;
      font-size: 14px;
      font-family: inherit;
      color: #0f172a;
      background: #ffffff;
      transition: all 0.15s ease;
    }

    .custom-form-control:focus {
      outline: none;
      border-color: #2563eb;
      box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
      background: #ffffff;
    }

    .custom-form-control:focus + .input-icon-left {
      color: #2563eb;
    }

    .password-toggle-btn {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #94a3b8;
      cursor: pointer;
      padding: 4px 6px;
      font-size: 18px;
      display: flex;
      align-items: center;
      transition: color 0.15s ease;
    }

    .password-toggle-btn:hover {
      color: #2563eb;
    }

    .btn-submit-login {
      width: 100%;
      height: 48px;
      background: linear-gradient(135deg, #2563eb, #1d4ed8);
      color: #ffffff;
      border: none;
      border-radius: 10px;
      font-size: 15px;
      font-weight: 700;
      letter-spacing: -0.2px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      cursor: pointer;
      transition: all 0.2s ease;
      box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }

    .btn-submit-login:hover {
      background: linear-gradient(135deg, #1d4ed8, #1e40af);
      transform: translateY(-1px);
      box-shadow: 0 6px 18px rgba(37, 99, 235, 0.35);
      color: #ffffff;
    }

    .or-divider {
      display: flex;
      align-items: center;
      text-align: center;
      margin: 22px 0;
      color: #94a3b8;
      font-size: 11.5px;
      font-weight: 700;
      letter-spacing: 0.6px;
      text-transform: uppercase;
    }

    .or-divider::before,
    .or-divider::after {
      content: '';
      flex: 1;
      border-bottom: 1px solid #e2e8f0;
    }

    .or-divider span {
      padding: 0 12px;
    }

    .btn-google-sso {
      width: 100%;
      height: 48px;
      background: #ffffff;
      border: 1.5px solid #e2e8f0;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      font-size: 14px;
      font-weight: 600;
      color: #1e293b;
      text-decoration: none;
      transition: all 0.15s ease;
    }

    .btn-google-sso:hover {
      background: #f8fafc;
      border-color: #cbd5e1;
      color: #0f172a;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
    }

    /* Quick Fill Credential Badges */
    .quick-fill-box {
      background: #f8fafc;
      border: 1px dashed #cbd5e1;
      border-radius: 10px;
      padding: 10px 14px;
      margin-top: 22px;
      font-size: 12px;
      color: #64748b;
    }

    .quick-chip {
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 4px;
      padding: 3px 8px;
      border-radius: 6px;
      background: #ffffff;
      border: 1px solid #e2e8f0;
      font-weight: 600;
      color: #2563eb;
      margin: 2px 0;
      transition: all 0.15s ease;
    }

    .quick-chip:hover {
      background: #eff6ff;
      border-color: #bfdbfe;
    }

    .security-badge {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 6px;
      font-size: 11.5px;
      color: #94a3b8;
      margin-top: 20px;
    }

    @media (max-width: 991px) {
      .auth-banner {
        display: none;
      }
      .auth-form-panel {
        flex: 1;
        padding: 40px 20px;
        background: #f8fafc;
      }
      .form-container {
        background: #ffffff;
        padding: 34px 26px;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.04);
      }
    }
  </style>
</head>

<body>
  <div class="auth-wrapper">

    <!-- LEFT PANEL: Modern Healthcare SaaS Brand Showcase -->
    <div class="auth-banner">
      <!-- Top Brand -->
      <a href="{{ URL::to('/') }}" class="brand-logo-wrap">
        <div class="brand-icon">
          <i class="mdi mdi-hospital-building"></i>
        </div>
        <div>
          <span class="brand-text-title">DrClinic</span>
          <span class="brand-text-badge">SaaS Cloud</span>
        </div>
      </a>

      <!-- Middle Showcase -->
      <div class="banner-content">
        <h1 class="banner-headline">
          Intelligent Healthcare &amp; <span>Clinic Practice</span> Management.
        </h1>
        <p class="banner-desc">
          Powering solo doctors, multi-specialty practices, and diagnostic centers with automated OPD queues, digital EMR, and tele-consultation billing.
        </p>

        <div class="feature-points">
          <div class="feature-item">
            <div class="feature-icon-circle" style="background: rgba(37, 99, 235, 0.2); color: #60a5fa;">
              <i class="mdi mdi-calendar-clock"></i>
            </div>
            <div>
              <div class="text-white font-weight-bold" style="font-size: 14px; font-weight: 700;">Smart OPD &amp; Token Scheduling</div>
              <div style="font-size: 12.5px; color: #94a3b8;">Automated patient time slots, walk-ins, and WhatsApp reminders.</div>
            </div>
          </div>

          <div class="feature-item">
            <div class="feature-icon-circle" style="background: rgba(6, 182, 212, 0.2); color: #22d3ee;">
              <i class="mdi mdi-credit-card-fast-outline"></i>
            </div>
            <div>
              <div class="text-white font-weight-bold" style="font-size: 14px; font-weight: 700;">Instant Online Razorpay Collections</div>
              <div style="font-size: 12.5px; color: #94a3b8;">Direct UPI, Card, and NetBanking consultation fee settlements.</div>
            </div>
          </div>

          <div class="feature-item">
            <div class="feature-icon-circle" style="background: rgba(16, 185, 129, 0.2); color: #34d399;">
              <i class="mdi mdi-shield-check-outline"></i>
            </div>
            <div>
              <div class="text-white font-weight-bold" style="font-size: 14px; font-weight: 700;">HIPAA-Grade Security &amp; Custom Subdomains</div>
              <div style="font-size: 12.5px; color: #94a3b8;">Personalized clinic website and encrypted digital medical prescriptions.</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Bottom Doctor Testimonial -->
      <div class="testimonial-card">
        <div class="doctor-avatar-wrap">
          <div class="doctor-avatar">
            DR
          </div>
          <div class="online-indicator"></div>
        </div>
        <div style="font-size: 13px;">
          <div style="color: #e2e8f0; font-weight: 500; line-height: 1.45; margin-bottom: 4px;">
            &ldquo;DrClinic transformed our outpatient queue and online appointment booking seamlessly.&rdquo;
          </div>
          <div style="color: #38bdf8; font-weight: 700; font-size: 12px;">
            Dr. Rajesh Roy &bull; Roy Neuro Care Clinic
          </div>
        </div>
      </div>
    </div>

    <!-- RIGHT PANEL: Ultra-Clean Login Form -->
    <div class="auth-form-panel">
      <div class="form-container">

        <!-- Mobile Brand Logo -->
        <div class="d-lg-none text-center mb-4">
          <div class="brand-icon mx-auto mb-2" style="width: 48px; height: 48px;">
            <i class="mdi mdi-hospital-building"></i>
          </div>
          <h4 class="font-weight-bold text-dark mb-0">DrClinic Cloud</h4>
        </div>

        <div class="form-header-badge">
          <i class="mdi mdi-lock-outline"></i> Doctor &amp; Clinic Portal
        </div>

        <h2 class="form-title">Welcome Back</h2>
        <p class="form-subtitle">Enter your credentials or use Single Sign-On to access your clinic workspace.</p>

        <!-- Flash Alerts -->
        @if(session('session_expired'))
        <div class="alert d-flex align-items-center rounded-3 p-3 mb-3 shadow-sm" style="font-size: 13.5px; border-left: 4px solid #f59e0b; background: #fffbeb; color: #92400e; border: 1px solid #fef3c7;">
          <i class="mdi mdi-clock-alert-outline mr-2 font-20" style="margin-right: 12px; font-size: 24px; color: #d97706; flex-shrink: 0;"></i>
          <div>
            <strong class="d-block" style="font-size: 14px; color: #78350f; font-weight: 700;">Session Expired</strong>
            <span style="color: #92400e;">Your login session timed out due to inactivity. Please log in again to resume your work.</span>
          </div>
        </div>
        @elseif(session('error'))
        <div class="alert alert-danger d-flex align-items-center rounded-3 p-3 mb-3 shadow-sm" style="font-size: 13.5px; border-left: 4px solid #ef4444; background: #fef2f2; color: #991b1b;">
          <i class="mdi mdi-alert-circle mr-2 font-18" style="margin-right: 8px;"></i>
          <div>{{ session('error') }}</div>
        </div>
        @endif

        @if(session('success'))
        <div class="alert alert-success d-flex align-items-center rounded-3 p-3 mb-3 shadow-sm" style="font-size: 13.5px; border-left: 4px solid #10b981; background: #f0fdf4; color: #065f46;">
          <i class="mdi mdi-check-circle mr-2 font-18" style="margin-right: 8px;"></i>
          <div>{{ session('success') }}</div>
        </div>
        @endif

        @if(session('info'))
        <div class="alert alert-info d-flex align-items-center rounded-3 p-3 mb-3 shadow-sm" style="font-size: 13.5px; border-left: 4px solid #3b82f6; background: #eff6ff; color: #1e40af;">
          <i class="mdi mdi-information mr-2 font-18" style="margin-right: 8px;"></i>
          <div>{{ session('info') }}</div>
        </div>
        @endif

        <!-- Google 1-Click Login -->
        <a href="{{ route('auth.google') }}" class="btn-google-sso">
          <svg width="18" height="18" viewBox="0 0 24 24">
            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
          </svg>
          Continue with Google (7-Day Free Trial)
        </a>

        <div class="or-divider">
          <span>Or sign in with email</span>
        </div>

        <!-- Login Form -->
        <form id="formAuthentication" action="{{ URL::To('admin-login-action') }}" method="POST">
          @csrf

          <div class="custom-input-group">
            <label for="loginEmail">Email Address or Username</label>
            <div class="input-field-wrap">
              <input
                type="text"
                class="custom-form-control"
                id="loginEmail"
                name="email"
                value="{{ old('email', 'admin@gmail.com') }}"
                placeholder="doctor@example.com"
                required
                autofocus
              />
              <i class="mdi mdi-email-outline input-icon-left"></i>
            </div>
          </div>

          <div class="custom-input-group mb-2">
            <div class="d-flex justify-content-between align-items-center mb-1">
              <label for="loginPassword" class="mb-0">Password</label>
              <a href="{{ URL::To('forgot-password') }}" class="text-decoration-none" style="font-size: 12px; font-weight: 700; color: #2563eb;">
                Forgot Password?
              </a>
            </div>
            <div class="input-field-wrap">
              <input
                type="password"
                id="loginPassword"
                class="custom-form-control"
                name="password"
                value="123456"
                placeholder="Enter password"
                required
              />
              <i class="mdi mdi-lock-outline input-icon-left"></i>
              <button type="button" class="password-toggle-btn" id="togglePasswordBtn" title="Toggle password visibility">
                <i class="mdi mdi-eye-outline" id="togglePasswordIcon"></i>
              </button>
            </div>
          </div>

          <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="remember" id="rememberMeCheck" checked style="cursor: pointer;">
              <label class="form-check-label text-muted" for="rememberMeCheck" style="font-size: 13px; cursor: pointer;">
                Remember me for 30 days
              </label>
            </div>
          </div>

          <button type="submit" class="btn-submit-login">
            <span>Sign in to Clinic Workspace</span>
            <i class="mdi mdi-arrow-right font-16"></i>
          </button>
        </form>

        <!-- Quick Demo Fill Pills -->
        <div class="quick-fill-box">
          <div class="d-flex justify-content-between align-items-center mb-1">
            <span class="font-weight-bold text-dark"><i class="mdi mdi-key-outline mr-1"></i> Quick Test Credentials:</span>
            <span class="text-muted" style="font-size: 11px;">(Click to fill)</span>
          </div>
          <div class="d-flex flex-wrap gap-2 mt-1">
            <span class="quick-chip" onclick="fillCreds('admin@gmail.com', '123456')">
              <i class="mdi mdi-shield-account mr-1"></i> Super Admin
            </span>
            <span class="quick-chip" onclick="fillCreds('rajesh@apex.example', '123456')">
              <i class="mdi mdi-doctor mr-1"></i> Doctor Clinic
            </span>
          </div>
        </div>

        <!-- Security Seal -->
        <div class="security-badge">
          <i class="mdi mdi-shield-lock-outline text-success font-16"></i>
          <span>256-Bit SSL Encrypted &bull; HIPAA &amp; Telemedicine Compliant</span>
        </div>

      </div>
    </div>

  </div>

  <script>
    // Password visibility toggle
    const toggleBtn = document.getElementById('togglePasswordBtn');
    const passwordInput = document.getElementById('loginPassword');
    const toggleIcon = document.getElementById('togglePasswordIcon');

    if (toggleBtn && passwordInput && toggleIcon) {
      toggleBtn.addEventListener('click', function () {
        const isPassword = passwordInput.getAttribute('type') === 'password';
        passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
        toggleIcon.className = isPassword ? 'mdi mdi-eye-off-outline' : 'mdi mdi-eye-outline';
      });
    }

    // Quick fill helper
    function fillCreds(email, password) {
      document.getElementById('loginEmail').value = email;
      document.getElementById('loginPassword').value = password;
      document.getElementById('loginEmail').focus();
    }
  </script>
</body>
</html>
