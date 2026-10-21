@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  <!-- Page Header -->
  <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 pb-2">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <a href="{{ route('admin.saas.plans') }}" class="btn btn-sm btn-light border font-weight-bold text-muted mr-2" style="border-radius: 8px;">
          <i class="mdi mdi-arrow-left mr-1"></i> Back to Plans
        </a>
        <h2 class="font-weight-bold mb-0 text-dark" style="font-size: 24px; letter-spacing: -0.5px;">Create Subscription Plan</h2>
      </div>
      <p class="text-muted mb-0" style="font-size: 13.5px;">Define commercial pricing, operational quotas, and entitled feature flags for this plan tier.</p>
    </div>
  </div>

  @if(isset($errors) && $errors->any())
  <div class="alert alert-danger rounded-3 p-3 mb-4 shadow-sm" style="border-left: 4px solid #ef4444; background: #fef2f2; color: #991b1b;">
    <ul class="mb-0">
      @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <form action="{{ route('admin.saas.plan.store') }}" method="POST">
    @csrf

    <!-- Section 1: Plan Identity & Commercial Pricing -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="border-radius: 16px; border: 1px solid #e2e8f0; background: #ffffff;">
      <div class="card-body p-4">
        <h5 class="font-weight-bold text-dark mb-3 d-flex align-items-center" style="font-size: 16px;">
          <span class="mr-2" style="color: #e11d48; font-size: 16px;">●</span> Plan Identity & Commercial Pricing
        </h5>

        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Plan Name *</label>
            <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="e.g. Professional Clinic" required style="border-radius: 8px; font-size: 14px;">
          </div>
          <div class="col-md-6">
            <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Slug (Optional)</label>
            <input type="text" class="form-control" name="slug" value="{{ old('slug') }}" placeholder="professional-clinic" style="border-radius: 8px; font-size: 14px;">
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Plan Description</label>
          <textarea class="form-control" name="description" rows="2" placeholder="Full-featured solution for established doctor clinics and growing multi-specialty practices." style="border-radius: 8px; font-size: 14px;">{{ old('description') }}</textarea>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Monthly Price *</label>
            <input type="number" step="0.01" class="form-control" name="price" value="{{ old('price', '2999.00') }}" required style="border-radius: 8px; font-size: 14px;">
          </div>
          <div class="col-md-6">
            <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Annual Price *</label>
            <input type="number" step="0.01" class="form-control" name="annual_price" value="{{ old('annual_price', '29990.00') }}" required style="border-radius: 8px; font-size: 14px;">
          </div>
        </div>

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Currency (ISO) *</label>
            <input type="text" class="form-control" name="currency" value="{{ old('currency', 'INR') }}" required style="border-radius: 8px; font-size: 14px;">
          </div>
          <div class="col-md-6">
            <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Trial Days Duration *</label>
            <input type="number" class="form-control" name="trial_days" value="{{ old('trial_days', '14') }}" required style="border-radius: 8px; font-size: 14px;">
          </div>
        </div>
      </div>
    </div>

    <!-- Section 2: Resource Allocations & Quotas -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="border-radius: 16px; border: 1px solid #e2e8f0; background: #ffffff;">
      <div class="card-body p-4">
        <h5 class="font-weight-bold text-dark mb-3 d-flex align-items-center" style="font-size: 16px;">
          <span class="mr-2" style="color: #f97316; font-size: 16px;">●</span> Resource Allocations & Quotas
        </h5>

        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Max Staff Accounts *</label>
            <input type="number" class="form-control" name="max_staff" value="{{ old('max_staff', '10') }}" required style="border-radius: 8px; font-size: 14px;">
          </div>
          <div class="col-md-6">
            <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Max Active Doctor / OPD Slots *</label>
            <input type="number" class="form-control" name="max_slots" value="{{ old('max_slots', '50') }}" style="border-radius: 8px; font-size: 14px;">
          </div>
        </div>

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Max Monthly Service / Bookings *</label>
            <input type="number" class="form-control" name="max_bookings" value="{{ old('max_bookings', '250') }}" required style="border-radius: 8px; font-size: 14px;">
          </div>
          <div class="col-md-6">
            <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Cloud Storage Quota (MB) *</label>
            <input type="number" class="form-control" id="storageQuotaInput" name="storage_quota_mb" value="{{ old('storage_quota_mb', '5120') }}" oninput="updateStorageHelper(this.value)" required style="border-radius: 8px; font-size: 14px;">
            <div id="storageHelperText" class="text-muted font-11 mt-1">5120 MB = 5 GB</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Section 3: Entitled Feature Flags -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="border-radius: 16px; border: 1px solid #e2e8f0; background: #ffffff;">
      <div class="card-body p-4">
        <h5 class="font-weight-bold text-dark mb-3 d-flex align-items-center" style="font-size: 16px;">
          <span class="mr-2" style="color: #2563eb; font-size: 16px;">●</span> Entitled Feature Flags
        </h5>

        <div class="row g-3 mb-4">
          @foreach($features as $fKey => $fData)
          <div class="col-md-6">
            <label class="d-flex align-items-start p-3 rounded-3 h-100 cursor-pointer feature-card" style="border: 1.5px solid #e2e8f0; background: #f8fafc; border-radius: 12px; transition: all 0.15s ease;">
              <input type="checkbox" name="features[]" value="{{ $fKey }}" class="form-check-input mt-1 mr-2" style="width: 18px; height: 18px;" {{ in_array($fKey, ['custom_domain', 'custom_pages', 'razorpay_gateway', 'sms_reminders']) ? 'checked' : '' }}>
              <div class="ml-2">
                <div class="font-weight-bold text-dark font-14 mb-1">{{ $fData['name'] }}</div>
                <div class="text-muted font-12" style="line-height: 1.35;">{{ $fData['desc'] }}</div>
              </div>
            </label>
          </div>
          @endforeach
        </div>

        <div class="d-flex align-items-center gap-4 pt-2 border-top" style="border-color: #f1f5f9 !important;">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActiveCheck" checked>
            <label class="form-check-label font-weight-bold text-dark font-13" for="isActiveCheck">
              Active for new subscriptions
            </label>
          </div>
          <div class="d-flex align-items-center gap-2">
            <label class="text-muted font-weight-bold font-13 mb-0">Display Order:</label>
            <input type="number" class="form-control text-center" name="sort_order" value="0" style="width: 80px; border-radius: 8px;">
          </div>
        </div>
      </div>
    </div>

    <!-- Form Action Buttons -->
    <div class="d-flex justify-content-end gap-2 mb-5">
      <a href="{{ route('admin.saas.plans') }}" class="btn btn-light border font-weight-bold px-4 py-2" style="border-radius: 10px;">
        Cancel
      </a>
      <button type="submit" class="btn font-weight-bold text-white px-4 py-2" style="background: #e11d48; border: none; border-radius: 10px; box-shadow: 0 2px 6px rgba(225,29,72,0.3);">
        <i class="mdi mdi-check mr-1"></i> Create Subscription Plan
      </button>
    </div>
  </form>
</div>

<script>
function updateStorageHelper(val) {
  const helper = document.getElementById('storageHelperText');
  const mb = parseInt(val) || 0;
  if (mb >= 1024) {
    helper.innerText = mb + ' MB = ' + (mb / 1024).toFixed(1) + ' GB';
  } else {
    helper.innerText = mb + ' MB';
  }
}
</script>
@endsection
