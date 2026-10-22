@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  <!-- Page Header -->
  <div class="row mb-4">
    <div class="col-12">
      <h2 class="font-weight-bold mb-1"><i class="mdi mdi-crown text-warning mr-1"></i> Subscription Plans & Billing</h2>
      <p class="text-muted mb-0">Manage your clinic SaaS subscription, explore entitled features, and upgrade your tier.</p>
    </div>
  </div>

<style>
.plan-hero-card {
  background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%) !important;
  border-radius: 20px !important;
  color: #ffffff !important;
  position: relative;
  overflow: hidden;
}
.plan-hero-card .card-body {
  background: transparent !important;
  color: #ffffff !important;
}
.plan-hero-card h2, .plan-hero-card h3, .plan-hero-card strong {
  color: #ffffff !important;
}
.plan-hero-card p {
  color: #94a3b8 !important;
}
.quota-chip {
  background: rgba(255, 255, 255, 0.08) !important;
  border: 1px solid rgba(255, 255, 255, 0.15) !important;
  border-radius: 10px !important;
  padding: 8px 14px !important;
  font-size: 13px !important;
  display: inline-flex;
  align-items: center;
}
.quota-chip span {
  color: #94a3b8 !important;
}
.quota-chip strong {
  color: #ffffff !important;
  margin-left: 6px;
}
.subdomain-box {
  background: rgba(255, 255, 255, 0.07) !important;
  border: 1px solid rgba(255, 255, 255, 0.15) !important;
  border-radius: 14px !important;
  padding: 16px !important;
  display: inline-block;
  text-align: left;
  min-width: 250px;
}
</style>

  <!-- Current Plan Status Card -->
  <div class="card border-0 shadow-sm rounded-4 mb-4 plan-hero-card">
    <!-- Decorative background glow -->
    <div style="position: absolute; top: -60px; right: -60px; width: 220px; height: 220px; border-radius: 50%; background: radial-gradient(circle, rgba(37,99,235,0.25) 0%, transparent 70%); pointer-events: none;"></div>

    <div class="card-body p-4 p-md-5" style="background: transparent !important;">
      <div class="row align-items-center">
        <div class="col-md-8">
          <div class="mb-3">
            @if($clinic->status === 'trialing')
              <span class="badge" style="background: rgba(16, 185, 129, 0.2); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.4); font-size: 11px; font-weight: 700; padding: 5px 12px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px;">
                ● Free Trial Active
              </span>
            @elseif($clinic->status === 'active')
              <span class="badge" style="background: rgba(37, 99, 235, 0.2); color: #60a5fa; border: 1px solid rgba(37, 99, 235, 0.4); font-size: 11px; font-weight: 700; padding: 5px 12px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px;">
                ● Active Subscription
              </span>
            @else
              <span class="badge" style="background: rgba(239, 68, 68, 0.2); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.4); font-size: 11px; font-weight: 700; padding: 5px 12px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px;">
                ● Plan Expired
              </span>
            @endif
          </div>

          <h2 class="font-weight-bold mb-2" style="font-size: 26px; letter-spacing: -0.4px; color: #ffffff !important;">
            @if($activeSub)
              {{ $activeSub->plan->name ?? 'Active Plan' }}
            @elseif($clinic->status === 'trialing')
              Starter Tier &mdash; Free Trial
            @elseif($clinic->status === 'active')
              Active Plan
            @else
              Subscription Expired
            @endif
          </h2>

          <p class="mb-4" style="font-size: 14.5px; line-height: 1.6; max-width: 680px; color: #94a3b8 !important;">
            @if($clinic->isPlanActive())
              @if($clinic->status === 'trialing')
                Your clinic trial is active until <strong style="color: #ffffff !important;">{{ $clinic->trial_ends_at ? $clinic->trial_ends_at->format('d M, Y') : 'in 7 days' }}</strong> (<span style="color: #34d399; font-weight: 700;">{{ $clinic->trialDaysRemaining() }} days left</span>). Upgrade to a commercial tier anytime for uninterrupted bookings.
              @elseif($activeSub && $activeSub->ends_at)
                Your subscription plan is active and valid until <strong style="color: #ffffff !important;">{{ $activeSub->ends_at->format('d M, Y') }}</strong>.
              @elseif($clinic->trial_ends_at)
                Your active plan is valid until <strong style="color: #ffffff !important;">{{ $clinic->trial_ends_at->format('d M, Y') }}</strong>.
              @else
                Your clinic plan is active with full access.
              @endif
            @else
              Your clinic online appointment bookings are currently paused because your subscription plan has expired. Please choose a plan below to reactivate your clinic.
            @endif
          </p>

          <!-- Active Quotas Chips -->
          <div class="d-flex flex-wrap" style="gap: 10px;">
            <div class="quota-chip">
              <span><i class="mdi mdi-account-group-outline mr-1" style="color: #60a5fa;"></i> Staff Accounts:</span>
              <strong>{{ $clinic->getEffectiveQuota('max_staff', 3) }} Max</strong>
            </div>
            <div class="quota-chip">
              <span><i class="mdi mdi-calendar-check-outline mr-1" style="color: #34d399;"></i> Monthly Bookings:</span>
              <strong>{{ $clinic->getEffectiveQuota('max_bookings', 50) }} Pts</strong>
            </div>
            <div class="quota-chip">
              <span><i class="mdi mdi-cloud-outline mr-1" style="color: #a78bfa;"></i> Cloud Storage:</span>
              <strong>{{ round($clinic->getEffectiveQuota('storage_quota_mb', 1024)/1024, 1) }} GB</strong>
            </div>
          </div>
        </div>

        <!-- Right Side: Storefront Link Box -->
        <div class="col-md-4 text-md-end mt-4 mt-md-0">
          <div class="subdomain-box">
            <div class="d-flex align-items-center mb-1" style="gap: 6px;">
              <span style="width: 8px; height: 8px; border-radius: 50%; background: #10b981; display: inline-block;"></span>
              <span style="color: #94a3b8; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Clinic Storefront Live</span>
            </div>
            <div class="font-weight-bold font-14 mb-3" style="color: #ffffff !important; word-break: break-all;">
              {{ $clinic->subdomain }}.{{ request()->getHost() }}
            </div>
            <a href="{{ $clinic->custom_domain ? 'https://' . $clinic->custom_domain : url('/c/' . ($clinic->subdomain ?? $clinic->slug)) }}" target="_blank" class="btn btn-sm w-100 font-weight-bold text-dark d-flex align-items-center justify-content-center" style="background: #ffffff; border: none; border-radius: 8px; padding: 8px 16px; font-size: 13px; box-shadow: 0 4px 12px rgba(0,0,0,0.2);">
              <i class="mdi mdi-open-in-new mr-2" style="margin-right: 6px;"></i> View Storefront
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Super Admin VIP Privileges Banner (if granted) -->
  @if(!empty($clinic->extra_features) || !empty($clinic->custom_quotas))
  <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: linear-gradient(135deg, #fffbeb, #fef3c7); border: 1.5px solid #fde68a !important; border-radius: 18px;">
    <div class="card-body p-4">
      <div class="d-flex align-items-center gap-3">
        <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background: #f59e0b; color: #ffffff; font-size: 24px; flex-shrink: 0;">
          <i class="mdi mdi-star"></i>
        </div>
        <div class="flex-grow-1">
          <h5 class="font-weight-bold text-dark mb-1" style="font-size: 17px;">
            Platform VIP Privilege Granted by Super Admin
          </h5>
          <p class="mb-2 text-muted font-13">
            Your clinic has been awarded complimentary special feature unlocks and custom quotas beyond your base plan tier!
          </p>
          <div class="d-flex flex-wrap gap-2">
            @if(!empty($clinic->extra_features))
              @foreach($clinic->extra_features as $ef)
                @php
                  $efName = $features[$ef]['name'] ?? ucwords(str_replace('_', ' ', $ef));
                @endphp
                <span class="badge" style="background: #ffffff; color: #b45309; border: 1px solid #fcd34d; font-size: 12px; font-weight: 700; padding: 6px 12px; border-radius: 8px;">
                  ⭐ {{ $efName }} (VIP Unlocked)
                </span>
              @endforeach
            @endif
            @if(!empty($clinic->custom_quotas))
              @if(isset($clinic->custom_quotas['max_staff']))
                <span class="badge" style="background: #ffffff; color: #1e3a8a; border: 1px solid #bfdbfe; font-size: 12px; font-weight: 700; padding: 6px 12px; border-radius: 8px;">
                  👥 Staff Quota: {{ $clinic->custom_quotas['max_staff'] }} (Upgraded)
                </span>
              @endif
              @if(isset($clinic->custom_quotas['max_bookings']))
                <span class="badge" style="background: #ffffff; color: #1e3a8a; border: 1px solid #bfdbfe; font-size: 12px; font-weight: 700; padding: 6px 12px; border-radius: 8px;">
                  📅 Monthly Bookings: {{ $clinic->custom_quotas['max_bookings'] }} (Upgraded)
                </span>
              @endif
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif

  <!-- Section: Active Clinic Entitled Features -->
  <div class="card border-0 shadow-sm rounded-4 mb-5" style="border-radius: 18px; border: 1px solid #e2e8f0; background: #ffffff;">
    <div class="card-body p-4">
      <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 pb-2 border-bottom" style="border-color: #f1f5f9 !important;">
        <div>
          <h4 class="font-weight-bold text-dark mb-1" style="font-size: 19px;">
            <i class="mdi mdi-shield-check text-primary mr-1"></i> Your Entitled Features & Access Status
          </h4>
          <p class="text-muted mb-0 font-13">
            Here is the live status of all clinic platform features based on your current plan and active VIP grants.
          </p>
        </div>
        <a href="#plansPricingSection" class="btn btn-sm btn-outline-primary font-weight-bold mt-2 mt-md-0" style="border-radius: 8px;">
          <i class="mdi mdi-arrow-up-bold-circle-outline mr-1"></i> Upgrade Tier
        </a>
      </div>

      <div class="row g-3">
        @foreach($features as $fKey => $fData)
          @php
            $hasAccess = $clinic->hasFeature($fKey);
            $isVip = $clinic->hasExtraFeature($fKey);
          @endphp
          <div class="col-md-6 col-lg-3 mb-3">
            <div class="p-3 rounded-4 h-100 d-flex flex-column justify-content-between" style="border: 1.5px solid {{ $hasAccess ? ($isVip ? '#fcd34d' : '#bbf7d0') : '#e2e8f0' }}; background: {{ $hasAccess ? ($isVip ? '#fffdf5' : '#f0fdf4') : '#f8fafc' }}; border-radius: 14px;">
              <div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 32px; height: 32px; background: {{ $hasAccess ? ($isVip ? '#f59e0b' : '#10b981') : '#cbd5e1' }}; color: #ffffff;">
                    @if($hasAccess)
                      <i class="mdi {{ $isVip ? 'mdi-star' : 'mdi-check' }}" style="font-size: 16px;"></i>
                    @else
                      <i class="mdi mdi-lock-outline" style="font-size: 16px;"></i>
                    @endif
                  </div>
                  @if($isVip)
                    <span class="badge" style="background: #fef3c7; color: #b45309; font-size: 10px; font-weight: 700;">VIP GRANT</span>
                  @elseif($hasAccess)
                    <span class="badge" style="background: #dcfce7; color: #15803d; font-size: 10px; font-weight: 700;">UNLOCKED</span>
                  @else
                    <span class="badge" style="background: #f1f5f9; color: #64748b; font-size: 10px; font-weight: 700;">LOCKED</span>
                  @endif
                </div>

                <div class="font-weight-bold text-dark font-14 mb-1">{{ $fData['name'] }}</div>
                <div class="text-muted font-12" style="line-height: 1.35;">{{ $fData['desc'] }}</div>
              </div>

              <div class="mt-3 pt-2 border-top" style="border-color: rgba(0,0,0,0.05) !important;">
                @if($hasAccess)
                  <span class="text-success font-weight-bold font-12"><i class="mdi mdi-check-circle mr-1"></i> Active for your clinic</span>
                @else
                  <a href="#plansPricingSection" class="text-primary font-weight-bold font-12 text-decoration-none">
                    <i class="mdi mdi-arrow-up-circle-outline mr-1"></i> Upgrade to unlock
                  </a>
                @endif
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>

  <!-- Subscription Pricing Tiers Grid -->
  <div id="plansPricingSection" class="row mb-5">
    <div class="col-12 text-center mb-4">
      <div class="d-inline-flex align-items-center gap-2 mb-1">
        <h3 class="font-weight-bold mb-0 text-dark">Commercial Subscription Tiers</h3>
        <span class="badge" style="background: #ffe4e6; color: #e11d48; font-weight: 700; font-size: 11px; padding: 4px 10px; border-radius: 9999px;">GROW YOUR CLINIC</span>
      </div>
      <p class="text-muted mb-0">Transparent pricing. Upgrade or renew securely via online payment.</p>
    </div>

    @foreach($plans as $plan)
    @php
      $isCurrent = ($activeSub && $activeSub->plan_id == $plan->id) || (!$activeSub && $plan->slug === 'starter');
    @endphp
    <div class="col-lg-4 col-md-6 mb-4">
      <div class="card h-100 border-0 shadow-sm rounded-4" style="border-radius: 20px; border: {{ $plan->slug === 'professional' ? '2px solid #2563eb' : '1px solid #e2e8f0' }} !important; background: #ffffff; transition: transform 0.2s ease;">
        @if($plan->slug === 'professional')
        <div class="position-absolute top-0 start-50 translate-middle">
          <span class="badge bg-primary text-white px-3 py-1 rounded-pill font-weight-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Most Popular</span>
        </div>
        @endif
        <div class="card-body p-4 p-xl-5 d-flex flex-column justify-content-between">
          <div>
            <div class="d-flex justify-content-between align-items-center mb-1">
              <h4 class="font-weight-bold mb-0 text-dark">{{ $plan->name }}</h4>
              @if($isCurrent)
                <span class="badge bg-success text-white font-11">Current Tier</span>
              @endif
            </div>
            <p class="text-muted font-13 mb-3">{{ $plan->description }}</p>

            <!-- Pricing Box -->
            <div class="rounded-3 p-3 my-3 d-flex justify-content-between align-items-baseline" style="background: #f8fafc; border: 1px solid #edf2f7; border-radius: 12px;">
              <div>
                <span class="h2 font-weight-bold text-dark mb-0">₹{{ number_format($plan->price) }}</span>
                <span class="text-muted font-12">/mo</span>
              </div>
              <div class="text-end">
                <div class="font-weight-bold text-dark font-13">₹{{ number_format($plan->annual_price ?: ($plan->price * 10)) }}</div>
                <div class="text-muted" style="font-size: 11px;">/yr billed annually</div>
              </div>
            </div>

            <!-- Resource Quotas -->
            <div class="py-2 mb-3" style="font-size: 13px; line-height: 2;">
              <div class="d-flex justify-content-between text-muted border-bottom py-1" style="border-color: #f1f5f9 !important;">
                <span>Trial Period:</span>
                <strong class="text-dark">{{ $plan->trial_days ?? 14 }} Days</strong>
              </div>
              <div class="d-flex justify-content-between text-muted border-bottom py-1" style="border-color: #f1f5f9 !important;">
                <span>Staff Team Accounts:</span>
                <strong class="text-dark">{{ $plan->max_staff ?? 3 }} Staff</strong>
              </div>
              <div class="d-flex justify-content-between text-muted border-bottom py-1" style="border-color: #f1f5f9 !important;">
                <span>Monthly Bookings:</span>
                <strong class="text-dark">{{ number_format($plan->max_bookings ?? 50) }} Appointments</strong>
              </div>
              <div class="d-flex justify-content-between text-muted py-1">
                <span>Cloud Media Storage:</span>
                <strong class="text-dark">{{ ($plan->storage_quota_mb ?? 1024) >= 1024 ? round(($plan->storage_quota_mb ?? 1024)/1024, 1).' GB' : ($plan->storage_quota_mb ?? 1024).' MB' }}</strong>
              </div>
            </div>

            <!-- Entitled Features list -->
            <div class="mb-4">
              <div class="text-muted font-weight-bold text-uppercase mb-2" style="font-size: 10.5px; letter-spacing: 0.6px;">Included Features:</div>
              <ul class="list-unstyled mb-0" style="line-height: 2;">
                @foreach($features as $fKey => $fData)
                  @php
                    $planHas = is_array($plan->features) && in_array($fKey, $plan->features);
                  @endphp
                  <li class="d-flex align-items-center font-13 {{ $planHas ? 'text-dark font-weight-bold' : 'text-muted' }}">
                    @if($planHas)
                      <i class="mdi mdi-check-circle text-success mr-2 font-16"></i> {{ $fData['name'] }}
                    @else
                      <i class="mdi mdi-close-circle-outline text-muted mr-2 font-16" style="opacity: 0.4;"></i> <span style="opacity: 0.5;">{{ $fData['name'] }}</span>
                    @endif
                  </li>
                @endforeach
              </ul>
            </div>
          </div>

          <button type="button" class="btn {{ $plan->slug === 'professional' ? 'btn-primary' : 'btn-outline-primary' }} btn-lg w-100 font-weight-bold rounded-3 py-3" onclick="subscribePlan({{ $plan->id }}, '{{ $plan->name }}', {{ $plan->price }})">
            <i class="mdi mdi-lightning-bolt mr-1"></i> {{ $isCurrent ? 'Renew Current Plan' : 'Subscribe / Upgrade' }}
          </button>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  <!-- Feature Comparison Matrix Table -->
  <div class="card border-0 shadow-sm rounded-4 mb-5" style="border-radius: 18px; border: 1px solid #e2e8f0; background: #ffffff;">
    <div class="card-body p-4">
      <h4 class="font-weight-bold text-dark mb-1" style="font-size: 18px;">
        <i class="mdi mdi-table text-primary mr-1"></i> Detailed Plan Feature Comparison Matrix
      </h4>
      <p class="text-muted mb-4 font-13">Compare all features and capacity quotas across our subscription tiers.</p>

      <div class="table-responsive">
        <table class="table table-bordered align-middle text-center mb-0" style="border-color: #f1f5f9;">
          <thead style="background: #f8fafc;">
            <tr>
              <th class="text-start py-3 px-3 font-weight-bold text-dark" style="width: 35%;">Feature / Quota</th>
              @foreach($plans as $p)
                <th class="py-3 px-3 font-weight-bold {{ $p->slug === 'professional' ? 'text-primary' : 'text-dark' }}">
                  {{ $p->name }}
                  <div class="font-12 font-weight-normal text-muted">₹{{ number_format($p->price) }}/mo</div>
                </th>
              @endforeach
            </tr>
          </thead>
          <tbody>
            <tr class="bg-light">
              <td colspan="{{ count($plans) + 1 }}" class="text-start font-weight-bold text-uppercase font-11 text-muted py-2 px-3">
                Resource Allocations & Quotas
              </td>
            </tr>
            <tr>
              <td class="text-start px-3 font-13 font-weight-bold">Staff Team Accounts</td>
              @foreach($plans as $p)
                <td class="font-13 font-weight-bold">{{ $p->max_staff ?? 3 }} Staff</td>
              @endforeach
            </tr>
            <tr>
              <td class="text-start px-3 font-13 font-weight-bold">Monthly Appointments / Bookings</td>
              @foreach($plans as $p)
                <td class="font-13 font-weight-bold">{{ number_format($p->max_bookings ?? 50) }}</td>
              @endforeach
            </tr>
            <tr>
              <td class="text-start px-3 font-13 font-weight-bold">Cloud Media Storage</td>
              @foreach($plans as $p)
                <td class="font-13 font-weight-bold">{{ ($p->storage_quota_mb ?? 1024) >= 1024 ? round(($p->storage_quota_mb ?? 1024)/1024, 1).' GB' : ($p->storage_quota_mb ?? 1024).' MB' }}</td>
              @endforeach
            </tr>

            <tr class="bg-light">
              <td colspan="{{ count($plans) + 1 }}" class="text-start font-weight-bold text-uppercase font-11 text-muted py-2 px-3">
                Entitled Platform Features
              </td>
            </tr>
            @foreach($features as $fKey => $fData)
            <tr>
              <td class="text-start px-3">
                <div class="font-13 font-weight-bold text-dark">{{ $fData['name'] }}</div>
                <div class="text-muted font-11">{{ $fData['desc'] }}</div>
              </td>
              @foreach($plans as $p)
                @php
                  $hasF = is_array($p->features) && in_array($fKey, $p->features);
                @endphp
                <td>
                  @if($hasF)
                    <i class="mdi mdi-check-circle text-success font-20"></i>
                  @else
                    <i class="mdi mdi-close-circle-outline text-muted font-20" style="opacity: 0.3;"></i>
                  @endif
                </td>
              @endforeach
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Billing History Table -->
  <div class="row">
    <div class="col-12">
      <div class="card border-0 shadow-sm rounded-4" style="border-radius: 18px; border: 1px solid #e2e8f0; background: #ffffff;">
        <div class="card-body p-4">
          <h5 class="card-title font-weight-bold mb-3 text-dark"><i class="mdi mdi-receipt text-primary mr-1"></i> Payment & Billing History</h5>

          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead style="background: #f8fafc; font-size: 11px; text-transform: uppercase; color: #64748b;">
                <tr>
                  <th class="py-3 px-3">Plan Name</th>
                  <th class="py-3 px-3">Amount Paid</th>
                  <th class="py-3 px-3">Subscription Period</th>
                  <th class="py-3 px-3">Razorpay Payment ID</th>
                  <th class="py-3 px-3">Status</th>
                </tr>
              </thead>
              <tbody style="font-size: 13.5px;">
                @forelse($subscriptions ?? [] as $sub)
                <tr>
                  <td class="py-3 px-3 font-weight-bold text-dark">{{ $sub->plan->name ?? 'Standard Plan' }}</td>
                  <td class="py-3 px-3 font-weight-bold text-success">₹{{ number_format($sub->amount, 2) }}</td>
                  <td class="py-3 px-3">{{ $sub->starts_at ? $sub->starts_at->format('d M, Y') : 'N/A' }} &mdash; {{ $sub->ends_at ? $sub->ends_at->format('d M, Y') : 'N/A' }}</td>
                  <td class="py-3 px-3"><code class="text-muted">{{ $sub->razorpay_payment_id ?? 'N/A' }}</code></td>
                  <td class="py-3 px-3">
                    <span class="badge bg-success text-white">Paid</span>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="5" class="text-center py-4 text-muted">
                    No paid subscription invoices yet. Free trial is currently recorded.
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Razorpay Script -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
function subscribePlan(planId, planName, planPrice) {
  const btn = event.currentTarget;
  const originalText = btn.innerHTML;
  btn.disabled = true;
  btn.innerHTML = '<span class="spinner-border spinner-border-sm mr-1"></span> Preparing Checkout...';

  fetch("{{ route('clinic.subscription.order') }}", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-TOKEN": "{{ csrf_token() }}"
    },
    body: JSON.stringify({ plan_id: planId })
  })
  .then(res => res.json())
  .then(data => {
    btn.disabled = false;
    btn.innerHTML = originalText;

    if (!data.success) {
      alert(data.message || 'Error initiating order.');
      return;
    }

    const options = {
      key: data.razorpay_key,
      amount: data.amount,
      currency: data.currency,
      name: "DrClinic SaaS Platform",
      description: "Subscription Plan: " + planName,
      order_id: data.order_id,
      handler: function(response) {
        // Send payment signature to backend verification
        fetch("{{ route('clinic.subscription.verify') }}", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
          },
          body: JSON.stringify({
            razorpay_payment_id: response.razorpay_payment_id,
            razorpay_order_id: response.razorpay_order_id,
            razorpay_signature: response.razorpay_signature,
            plan_id: planId
          })
        })
        .then(r => r.json())
        .then(verification => {
          if (verification.success) {
            window.location.reload();
          } else {
            alert(verification.message || 'Payment verification failed.');
          }
        });
      },
      prefill: {
        name: "{{ Auth::user()?->name ?? '' }}",
        email: "{{ Auth::user()?->email ?? '' }}",
        contact: "{{ Auth::user()?->phone ?? '' }}"
      },
      theme: {
        color: "#2563eb"
      }
    };

    const rzp = new Razorpay(options);
    rzp.open();
  })
  .catch(err => {
    btn.disabled = false;
    btn.innerHTML = originalText;
    alert('Failed to connect to checkout gateway. Please try again.');
  });
}
</script>
@endsection
