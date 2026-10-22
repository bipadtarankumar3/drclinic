<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Up Your Clinic - Dr Clinic SaaS</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #059669;
            --primary-hover: #047857;
            --accent: #10b981;
            --dark: #0f172a;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-400: #94a3b8;
            --gray-600: #475569;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f0fdf4 0%, #eff6ff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 20px;
        }

        .modal-container {
            background: #ffffff;
            border-radius: 28px;
            box-shadow: 0 25px 60px -15px rgba(15, 23, 42, 0.12);
            border: 1px solid rgba(226, 232, 240, 0.8);
            max-width: 720px;
            width: 100%;
            padding: 44px 48px;
            position: relative;
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .badge-trial {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #ecfdf5;
            color: #059669;
            border: 1px solid #a7f3d0;
            padding: 6px 16px;
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.3px;
            margin-bottom: 16px;
        }

        .header-title {
            font-size: 28px;
            font-weight: 800;
            color: var(--dark);
            letter-spacing: -0.5px;
            margin-bottom: 8px;
        }

        .header-desc {
            color: var(--gray-600);
            font-size: 15px;
            line-height: 1.5;
            margin-bottom: 32px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .col-full {
            grid-column: span 2;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        label {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
        }

        .required {
            color: #ef4444;
        }

        .input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrap i {
            position: absolute;
            left: 16px;
            color: var(--gray-400);
            font-size: 16px;
        }

        input[type="text"],
        input[type="number"],
        input[type="tel"],
        textarea,
        select {
            width: 100%;
            padding: 13px 16px 13px 44px;
            border: 1.5px solid var(--gray-200);
            border-radius: 12px;
            font-size: 14px;
            outline: none;
            transition: all 0.2s ease;
            background: #ffffff;
            color: var(--dark);
        }

        input:focus,
        textarea:focus,
        select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .subdomain-wrap {
            display: flex;
            align-items: center;
            border: 1.5px solid var(--gray-200);
            border-radius: 12px;
            overflow: hidden;
            background: #ffffff;
            transition: all 0.2s ease;
        }

        .subdomain-wrap:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .subdomain-wrap input {
            border: none;
            padding: 13px 12px 13px 44px;
            border-radius: 0;
            box-shadow: none;
        }

        .subdomain-suffix {
            background: var(--gray-100);
            padding: 13px 16px;
            font-size: 13px;
            font-weight: 600;
            color: var(--gray-600);
            border-left: 1px solid var(--gray-200);
            white-space: nowrap;
        }

        .live-preview-box {
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 12px;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            color: #475569;
            margin-top: 4px;
        }

        .live-preview-url {
            color: var(--primary);
            font-weight: 700;
        }

        .btn-submit {
            background: linear-gradient(135deg, #059669, #10b981);
            color: #ffffff;
            border: none;
            border-radius: 14px;
            padding: 16px 32px;
            font-size: 16px;
            font-weight: 700;
            width: 100%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 10px 25px -5px rgba(5, 150, 105, 0.35);
            transition: all 0.2s ease;
            margin-top: 10px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px -5px rgba(37, 99, 235, 0.45);
        }

        .error-message {
            color: #ef4444;
            font-size: 12px;
            margin-top: 4px;
        }

        @media (max-width: 640px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            .col-full {
                grid-column: span 1;
            }
            .modal-container {
                padding: 32px 24px;
            }
        }
    </style>
</head>
<body>
    <div class="modal-container">
        <div class="badge-trial">
            <i class="fa-solid fa-gift"></i>
            7-Day Free Trial Included
        </div>

        <h1 class="header-title">Welcome, Dr. {{ $user->name }}!</h1>
        <p class="header-desc">
            Complete your clinic profile in seconds to activate your 7-day free trial. Your patients can immediately begin booking appointments on your personal clinic page.
        </p>

        @if ($errors->any())
        <div style="background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; border-radius: 12px; padding: 14px 18px; margin-bottom: 24px; font-size: 14px;">
            <ul style="margin-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('doctor.onboarding.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-grid">
                <!-- Clinic Name -->
                <div class="form-group col-full">
                    <label for="clinic_name">Clinic / Hospital Name <span class="required">*</span></label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-hospital"></i>
                        <input type="text" id="clinic_name" name="clinic_name" value="{{ old('clinic_name') }}" placeholder="e.g. Apex Neuro & Spine Care" required oninput="generateSubdomain(this.value)">
                    </div>
                </div>

                <!-- Subdomain -->
                <div class="form-group col-full">
                    <label for="subdomain">Choose Your Clinic Subdomain <span class="required">*</span></label>
                    <div class="subdomain-wrap">
                        <div class="input-wrap" style="width: 100%;">
                            <i class="fa-solid fa-globe"></i>
                            <input type="text" id="subdomain" name="subdomain" value="{{ old('subdomain') }}" placeholder="apexneuro" required oninput="updatePreview(this.value)">
                        </div>
                        <span class="subdomain-suffix">.{{ request()->getHost() }}</span>
                    </div>
                    <div class="live-preview-box">
                        <i class="fa-solid fa-link"></i>
                        <span>Your public booking page will be: <span class="live-preview-url" id="previewUrl">https://apexneuro.{{ request()->getHost() }}</span></span>
                    </div>
                </div>

                <!-- Specialization -->
                <div class="form-group">
                    <label for="specialization">Medical Specialization</label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-stethoscope"></i>
                        <input type="text" id="specialization" name="specialization" value="{{ old('specialization') }}" placeholder="e.g. Neurologist, Cardiologist">
                    </div>
                </div>

                <!-- Consultation Fee -->
                <div class="form-group">
                    <label for="consultation_fee">Standard Consultation Fee (₹)</label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-indian-rupee-sign"></i>
                        <input type="number" id="consultation_fee" name="consultation_fee" value="{{ old('consultation_fee', '500') }}" min="0" placeholder="500">
                    </div>
                </div>

                <!-- Phone -->
                <div class="form-group">
                    <label for="phone">Clinic Helpline Phone</label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-phone"></i>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" placeholder="+91 9876543210">
                    </div>
                </div>

                <!-- Logo -->
                <div class="form-group">
                    <label for="logo">Clinic Logo (Optional)</label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-image"></i>
                        <input type="file" id="logo" name="logo" accept="image/*" style="padding-top: 10px;">
                    </div>
                </div>

                <!-- Address -->
                <div class="form-group col-full">
                    <label for="address">Clinic Address / Location</label>
                    <div class="input-wrap">
                        <i class="fa-solid fa-location-dot" style="top: 16px;"></i>
                        <textarea id="address" name="address" rows="2" style="padding-left: 44px;" placeholder="Full street address, city, state, pincode">{{ old('address') }}</textarea>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <span>Start My 7-Day Free Trial</span>
                <i class="fa-solid fa-arrow-right"></i>
            </button>
        </form>
    </div>

    <script>
        function generateSubdomain(clinicName) {
            const subdomainInput = document.getElementById('subdomain');
            if (!subdomainInput.dataset.manual) {
                const cleaned = clinicName.toLowerCase().replace(/[^a-z0-9]/g, '');
                subdomainInput.value = cleaned;
                updatePreview(cleaned);
            }
        }

        function updatePreview(val) {
            const clean = val.toLowerCase().replace(/[^a-z0-9]/g, '') || 'yourclinic';
            const host = "{{ request()->getHost() }}";
            document.getElementById('previewUrl').innerText = `https://${clean}.${host}`;
        }

        document.getElementById('subdomain').addEventListener('input', function() {
            this.dataset.manual = "true";
        });
    </script>
</body>
</html>
