@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  <div class="row mb-4">
    <div class="col-12">
      <h2 class="font-weight-bold mb-1"><i class="mdi mdi-crown text-warning mr-1"></i> Subscription Plans & Billing</h2>
      <p class="text-muted mb-0">Manage your clinic SaaS subscription, upgrade tiers, and view past payment invoices.</p>
    </div>
  </div>

  <!-- Current Plan Status Card -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="card border-0 shadow-sm rounded-4" style="background: linear-gradient(135deg, #1e293b, #0f172a); border-radius: 20px; color: #ffffff;">
        <div class="card-body p-4 p-md-5">
          <div class="row align-items-center">
            <div class="col-md-8">
              <span class="badge {{ $clinic->isPlanActive() ? 'bg-success' : 'bg-danger' }} px-3 py-2 font-weight-bold text-uppercase mb-3" style="font-size: 12px; letter-spacing: 0.5px;">
                {{ $clinic->status }}
              </span>
              <h3 class="font-weight-bold mb-2">
                @if($activeSub)
                  {{ $activeSub->plan->name ?? 'Active Plan' }}
                @elseif($clinic->status === 'trialing')
                  7-Day Free Trial
                @else
                  Plan Expired
                @endif
              </h3>
              <p class="text-white-50 mb-3" style="font-size: 15px;">
                @if($clinic->isPlanActive())
                  @if($clinic->status === 'trialing')
                    Your free trial expires on <strong>{{ $clinic->trial_ends_at ? $clinic->trial_ends_at->format('d M, Y') : 'in 7 days' }}</strong> ({{ $clinic->trialDaysRemaining() }} days left). Upgrade anytime to guarantee seamless service.
                  @else
                    Your active subscription is valid until <strong>{{ $activeSub->ends_at ? $activeSub->ends_at->format('d M, Y') : 'Active' }}</strong>.
                  @endif
                @else
                  Your clinic booking service is currently paused because your subscription plan has expired. Please select a plan below to reactivate your clinic.
                @endif
              </p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
              <div class="p-3 rounded-3" style="background: rgba(255,255,255,0.08); display: inline-block; text-align: left;">
                <div class="text-white-50 font-12 font-weight-bold text-uppercase">Clinic Identifier</div>
                <div class="font-weight-bold text-white font-15">{{ $clinic->subdomain }}.{{ request()->getHost() }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Subscription Pricing Tiers -->
  <div class="row mb-5">
    <div class="col-12 text-center mb-4">
      <h3 class="font-weight-bold">Choose the Perfect Plan for Your Clinic</h3>
      <p class="text-muted">Transparent pricing. Upgrade or renew securely via Razorpay.</p>
    </div>

    @foreach($plans as $plan)
    <div class="col-lg-4 col-md-6 mb-4">
      <div class="card border-0 shadow-sm rounded-4 h-100" style="border-radius: 20px; transition: transform 0.2s; @if($plan->slug === 'professional') border: 2px solid #2563eb !important; @endif">
        @if($plan->slug === 'professional')
        <div class="position-absolute top-0 start-50 translate-middle">
          <span class="badge bg-primary text-white px-3 py-1 rounded-pill font-weight-bold text-uppercase" style="font-size: 11px;">Most Popular</span>
        </div>
        @endif
        <div class="card-body p-4 p-xl-5 d-flex flex-column justify-content-between">
          <div>
            <h4 class="font-weight-bold mb-1">{{ $plan->name }}</h4>
            <p class="text-muted font-13 mb-4">{{ $plan->description }}</p>

            <div class="mb-4">
              <span class="h1 font-weight-bold text-dark">₹{{ number_format($plan->price) }}</span>
              <span class="text-muted font-14">/ {{ $plan->billing_cycle }}</span>
            </div>

            <ul class="list-unstyled mb-4" style="line-height: 2;">
              @if(is_array($plan->features))
                @foreach($plan->features as $feature)
                <li class="d-flex align-items-center font-14 text-secondary">
                  <i class="mdi mdi-check-circle text-success mr-2 font-16"></i> {{ $feature }}
                </li>
                @endforeach
              @endif
            </ul>
          </div>

          <button type="button" class="btn {{ $plan->slug === 'professional' ? 'btn-primary' : 'btn-outline-primary' }} btn-lg w-100 font-weight-bold rounded-3 py-3" onclick="subscribePlan({{ $plan->id }}, '{{ $plan->name }}', {{ $plan->price }})">
            <i class="mdi mdi-lightning-bolt mr-1"></i> Subscribe / Renew
          </button>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  <!-- Billing History Table -->
  <div class="row">
    <div class="col-12">
      <div class="card border-0 shadow-sm rounded-4" style="border-radius: 16px;">
        <div class="card-body p-4">
          <h5 class="card-title font-weight-bold mb-3"><i class="mdi mdi-receipt text-primary mr-1"></i> Payment & Billing History</h5>

          <div class="table-responsive">
            <table class="table table-hover">
              <thead class="bg-light">
                <tr>
                  <th>Plan Name</th>
                  <th>Amount Paid</th>
                  <th>Subscription Period</th>
                  <th>Razorpay Payment ID</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @forelse($subscriptions as $sub)
                <tr>
                  <td class="font-weight-bold text-dark">{{ $sub->plan->name ?? 'Standard Plan' }}</td>
                  <td class="font-weight-bold text-success">₹{{ number_format($sub->amount, 2) }}</td>
                  <td>{{ $sub->starts_at ? $sub->starts_at->format('d M, Y') : 'N/A' }} &mdash; {{ $sub->ends_at ? $sub->ends_at->format('d M, Y') : 'N/A' }}</td>
                  <td><code class="text-muted">{{ $sub->razorpay_payment_id ?? 'N/A' }}</code></td>
                  <td>
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

  fetch("{{ route('doctor.subscription.order') }}", {
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
      alert(data.message || "Could not initialize payment.");
      return;
    }

    const options = {
      key: data.key,
      amount: data.amount_paise,
      currency: "INR",
      name: "Dr Clinic SaaS Platform",
      description: "Subscription: " + data.plan_name,
      order_id: data.order_id,
      prefill: {
        name: data.clinic_name,
        email: data.doctor_email,
        contact: data.doctor_phone
      },
      theme: {
        color: "#2563eb"
      },
      handler: function(response) {
        // Send verification to backend
        fetch("{{ route('doctor.subscription.verify') }}", {
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
        .then(res => res.json())
        .then(verifyData => {
          if (verifyData.success) {
            alert("🎉 " + verifyData.message);
            window.location.reload();
          } else {
            alert("Payment verification issue: " + verifyData.message);
          }
        });
      }
    };

    const rzp = new Razorpay(options);
    rzp.open();
  })
  .catch(err => {
    btn.disabled = false;
    btn.innerHTML = originalText;
    alert("Connection error: " + err.message);
  });
}
</script>
@endsection
