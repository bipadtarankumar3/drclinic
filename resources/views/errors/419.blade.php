<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
  <title>Page / Session Expired &bull; DrClinic</title>
  <link rel="icon" type="image/x-icon" href="{{ URL::to('public/assets/admin/images/favicon.png') }}" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
    body {
      font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
      background: radial-gradient(circle at 10% 20%, #f0fdfa 0%, #ffffff 50%, #f8fafc 100%);
      color: #0f172a;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 24px;
      margin: 0;
    }
    .expired-card {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 24px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
      padding: 48px 40px;
      max-width: 500px;
      width: 100%;
      text-align: center;
    }
    .icon-badge {
      width: 72px;
      height: 72px;
      border-radius: 50%;
      background: #eff6ff;
      border: 2px solid #bfdbfe;
      color: #2563eb;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 32px;
      margin: 0 auto 24px;
    }
    .badge-status {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 5px 14px;
      background: #dbeafe;
      color: #1e40af;
      font-size: 12px;
      font-weight: 700;
      border-radius: 20px;
      margin-bottom: 16px;
    }
    .btn-relogin {
      background: #0d9488;
      color: #ffffff;
      font-weight: 700;
      font-size: 15px;
      padding: 13px 28px;
      border-radius: 30px;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      box-shadow: 0 4px 14px rgba(13, 148, 136, 0.35);
      transition: all 0.2s ease;
      width: 100%;
    }
    .btn-relogin:hover {
      background: #0f766e;
      color: #ffffff;
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(13, 148, 136, 0.45);
    }
    .btn-home {
      background: transparent;
      color: #64748b;
      font-weight: 600;
      font-size: 14px;
      padding: 10px;
      text-decoration: none;
      display: inline-block;
      margin-top: 12px;
      transition: color 0.2s;
    }
    .btn-home:hover {
      color: #0f172a;
    }
  </style>
</head>
<body>
  <div class="expired-card">
    <div class="icon-badge">
      <i class="fa-solid fa-arrows-rotate"></i>
    </div>
    
    <div class="badge-status">
      <i class="fa-solid fa-shield-halved"></i> 419 Page Expired
    </div>

    <h2 class="fw-bold mb-2" style="font-size: 26px; color: #0f172a;">Page Has Expired</h2>
    
    <p class="text-muted mb-4" style="font-size: 14.5px; line-height: 1.6;">
      Your security token has expired due to inactivity. Please refresh the page or sign in again to continue safely.
    </p>

    <a href="{{ route('login') }}" class="btn-relogin mb-2">
      <i class="fa-solid fa-arrow-right-to-bracket"></i> Sign In to Continue
    </a>

    <div>
      <a href="{{ url('/') }}" class="btn-home">
        &larr; Return to Homepage
      </a>
    </div>
  </div>
</body>
</html>
