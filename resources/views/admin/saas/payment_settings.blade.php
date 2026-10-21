@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  <div class="row mb-4">
    <div class="col-12">
      <h2 class="font-weight-bold mb-1"><i class="mdi mdi-credit-card-outline text-primary mr-1"></i> Platform Razorpay Settings</h2>
      <p class="text-muted mb-0">Configure the master Razorpay payment credentials used to charge doctors for SaaS subscription plans.</p>
    </div>
  </div>

  @if(session('success'))
  <div class="alert alert-success alert-dismissible fade show rounded-3 p-3 mb-4" role="alert">
    <strong><i class="mdi mdi-check-circle mr-1"></i> Success!</strong> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  @if($errors->any())
  <div class="alert alert-danger rounded-3 p-3 mb-4">
    <ul class="mb-0">
      @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <div class="row">
    <div class="col-md-8">
      <div class="card border-0 shadow-sm rounded-4" style="border-radius: 16px;">
        <div class="card-body p-4 p-md-5">
          <div class="alert alert-info rounded-3 p-3 mb-4">
            <h6 class="font-weight-bold mb-1"><i class="mdi mdi-shield-key-outline mr-1"></i> Master Payment Gateway for Platform Subscriptions</h6>
            <p class="mb-0 font-13">These credentials are used exclusively to process doctor plan subscriptions (Starter, Professional, Annual Pro). Doctor consultation fees from patients are handled separately through each doctor's individual Razorpay account.</p>
          </div>

          <form action="{{ route('admin.saas.payment_settings.update') }}" method="POST">
            @csrf

            <div class="mb-4">
              <label class="form-label font-weight-bold">Platform Razorpay Key ID</label>
              <input type="text" class="form-control font-monospace" name="platform_razorpay_key" value="{{ old('platform_razorpay_key', env('RAZORPAY_KEY')) }}" required placeholder="rzp_live_...">
            </div>

            <div class="mb-4">
              <label class="form-label font-weight-bold">Platform Razorpay Key Secret</label>
              <input type="password" class="form-control font-monospace" name="platform_razorpay_secret" value="{{ old('platform_razorpay_secret', env('RAZORPAY_SECRET')) }}" required placeholder="••••••••••••••••">
            </div>

            <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold">
              <i class="mdi mdi-content-save mr-1"></i> Save Platform Credentials
            </button>
          </form>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card border-0 shadow-sm rounded-4" style="border-radius: 16px;">
        <div class="card-body p-4">
          <h5 class="font-weight-bold mb-3">Gateway Architecture</h5>
          <div class="mb-3">
            <span class="badge bg-primary text-white mb-2">Platform Gateway</span>
            <p class="font-13 text-muted mb-0">Collects SaaS recurring subscription payments from registered doctors directly into platform owner's account.</p>
          </div>
          <hr>
          <div>
            <span class="badge bg-success text-white mb-2">Doctor Gateways</span>
            <p class="font-13 text-muted mb-0">Each doctor sets their own credentials in their clinic dashboard so appointment consultation fees go straight to them without intermediary holds.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
