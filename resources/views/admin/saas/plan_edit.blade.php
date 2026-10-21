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
        <h2 class="font-weight-bold mb-0 text-dark" style="font-size: 24px; letter-spacing: -0.5px;">Edit Plan: {{ $plan->name }}</h2>
      </div>
      <p class="text-muted mb-0" style="font-size: 13.5px;">Update commercial pricing, resource quotas, and entitled feature flags for this plan tier.</p>
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

  <form action="{{ route('admin.saas.plan.update', $plan->id) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- Section 1: Plan Identity & Commercial Pricing -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="border-radius: 16px; border: 1px solid #e2e8f0; background: #ffffff;">
      <div class="card-body p-4">
        <h5 class="font-weight-bold text-dark mb-3 d-flex align-items-center" style="font-size: 16px;">
          <span class="mr-2" style="color: #e11d48; font-size: 16px;">●</span> Plan Identity & Commercial Pricing
        </h5>

        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Plan Name *</label>
            <input type="text" class="form-control" name="name" value="{{ old('name', $plan->name) }}" required style="border-radius: 8px; font-size: 14px;">
          </div>
          <div class="col-md-6">
            <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Slug (Optional)</label>
            <input type="text" class="form-control" name="slug" value="{{ old('slug', $plan->slug) }}" style="border-radius: 8px; font-size: 14px;">
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Plan Description</label>
          <textarea class="form-control" name="description" rows="2" style="border-radius: 8px; font-size: 14px;">{{ old('description', $plan->description) }}</textarea>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Monthly Price *</label>
            <input type="number" step="0.01" class="form-control" name="price" value="{{ old('price', $plan->price) }}" required style="border-radius: 8px; font-size: 14px;">
          </div>
          <div class="col-md-6">
            <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Annual Price *</label>
            <input type="number" step="0.01" class="form-control" name="annual_price" value="{{ old('annual_price', $plan->annual_price ?: ($plan->price * 10)) }}" required style="border-radius: 8px; font-size: 14px;">
          </div>
        </div>

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Currency (ISO) *</label>
            <input type="text" class="form-control" name="currency" value="{{ old('currency', $plan->currency ?? 'INR') }}" required style="border-radius: 8px; font-size: 14px;">
          </div>
          <div class="col-md-6">
            <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Trial Days Duration *</label>
            <input type="number" class="form-control" name="trial_days" value="{{ old('trial_days', $plan->trial_days ?? 14) }}" required style="border-radius: 8px; font-size: 14px;">
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
            <input type="number" class="form-control" name="max_staff" value="{{ old('max_staff', $plan->max_staff ?? 3) }}" required style="border-radius: 8px; font-size: 14px;">
          </div>
          <div class="col-md-6">
            <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Max Active Doctor / OPD Slots *</label>
            <input type="number" class="form-control" name="max_slots" value="{{ old('max_slots', 50) }}" style="border-radius: 8px; font-size: 14px;">
          </div>
        </div>

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Max Monthly Service / Bookings *</label>
            <input type="number" class="form-control" name="max_bookings" value="{{ old('max_bookings', $plan->max_bookings ?? 50) }}" required style="border-radius: 8px; font-size: 14px;">
          </div>
          <div class="col-md-6">
            <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Cloud Storage Quota (MB) *</label>
            <input type="number" class="form-control" id="storageQuotaInput" name="storage_quota_mb" value="{{ old('storage_quota_mb', $plan->storage_quota_mb ?? 1024) }}" oninput="updateStorageHelper(this.value)" required style="border-radius: 8px; font-size: 14px;">
            <div id="storageHelperText" class="text-muted font-11 mt-1">
              {{ ($plan->storage_quota_mb ?? 1024) >= 1024 ? ($plan->storage_quota_mb ?? 1024).' MB = '.round(($plan->storage_quota_mb ?? 1024)/1024, 1).' GB' : ($plan->storage_quota_mb ?? 1024).' MB' }}
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Section 3: Entitled Feature Flags -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="border-radius: 16px; border: 1px solid #e2e8f0; background: #ffffff;">
      <div class="card-body p-4">
        <!-- Header with Action Buttons -->
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 pb-2 border-bottom" style="border-color: #f1f5f9 !important;">
          <div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-3 shadow-sm" style="width: 42px; height: 42px; background: linear-gradient(135deg, #2563eb, #06b6d4); color: #ffffff; font-size: 20px;">
              <i class="mdi mdi-shield-star-outline"></i>
            </div>
            <div>
              <h5 class="font-weight-bold text-dark mb-0" style="font-size: 17px; letter-spacing: -0.3px;">
                Entitled Feature Flags &amp; Capabilities
              </h5>
              <p class="text-muted font-12 mb-0">Toggle which medical capabilities, patient tools, and payment modules are unlocked for this plan.</p>
            </div>
          </div>

          <div class="d-flex gap-2">
            <button type="button" class="btn btn-sm btn-outline-primary font-weight-bold px-3 py-1" onclick="toggleAllFeatures(true)" style="border-radius: 8px; font-size: 12px;">
              <i class="mdi mdi-check-all me-1"></i> Select All
            </button>
            <button type="button" class="btn btn-sm btn-outline-secondary font-weight-bold px-3 py-1" onclick="toggleAllFeatures(false)" style="border-radius: 8px; font-size: 12px;">
              <i class="mdi mdi-close-circle-outline me-1"></i> Deselect All
            </button>
          </div>
        </div>

        @php
          $currentFeatures = is_array($plan->features) ? $plan->features : [];
        @endphp

        <!-- Modern Interactive Feature Tiles Grid -->
        <div class="row g-3 mb-4">
          @foreach($features as $fKey => $fData)
          @php
            $isChecked = in_array($fKey, $currentFeatures);
          @endphp
          <div class="col-md-6">
            <div class="feature-tile p-3 rounded-4 h-100 position-relative {{ $isChecked ? 'tile-active' : '' }}" onclick="toggleFeatureTile(this)">
              <input type="checkbox" name="features[]" value="{{ $fKey }}" class="feature-checkbox d-none" {{ $isChecked ? 'checked' : '' }}>

              <div class="d-flex align-items-start gap-3">
                <!-- Icon Box -->
                <div class="tile-icon-box shadow-sm" style="background: {{ $fData['gradient'] ?? 'linear-gradient(135deg, #2563eb, #1d4ed8)' }};">
                  <i class="mdi {{ $fData['icon'] ?? 'mdi-star' }}"></i>
                </div>

                <!-- Text & Metadata -->
                <div class="flex-grow-1">
                  <div class="d-flex justify-content-between align-items-center mb-1">
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                      <span class="font-weight-bold text-dark font-14">{{ $fData['name'] }}</span>
                      <span class="badge" style="background: {{ $fData['badge_bg'] ?? '#eff6ff' }}; color: {{ $fData['badge_color'] ?? '#1d4ed8' }}; font-size: 10px; font-weight: 700; padding: 3px 8px; border-radius: 6px;">
                        {{ $fData['badge'] ?? 'MODULE' }}
                      </span>
                    </div>

                    <!-- Custom Circle Check Indicator -->
                    <div class="tile-check-circle">
                      <i class="mdi mdi-check"></i>
                    </div>
                  </div>

                  <p class="text-muted font-12 mb-0" style="line-height: 1.45;">{{ $fData['desc'] }}</p>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>

        <!-- Bottom Controls Toolbar -->
        <div class="p-3 rounded-3 d-flex justify-content-between align-items-center flex-wrap gap-3" style="background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 12px;">
          <div class="d-flex align-items-center gap-2">
            <div class="form-check form-switch mb-0">
              <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActiveCheck" {{ $plan->is_active ? 'checked' : '' }} style="cursor: pointer; width: 40px; height: 20px;">
              <label class="form-check-label font-weight-bold text-dark font-13 ms-2" for="isActiveCheck" style="cursor: pointer;">
                Active for new subscriptions
              </label>
            </div>
            <span class="badge {{ $plan->is_active ? 'bg-success bg-opacity-10 text-success' : 'bg-secondary bg-opacity-10 text-muted' }} font-11 px-2 py-1 ms-2" style="border-radius: 6px;">
              {{ $plan->is_active ? 'Live Tier' : 'Inactive / Draft' }}
            </span>
          </div>

          <div class="d-flex align-items-center gap-2">
            <label class="text-muted font-weight-bold font-12 text-uppercase mb-0" style="letter-spacing: 0.5px;">Display Order:</label>
            <input type="number" class="form-control text-center font-weight-bold" name="sort_order" value="{{ $plan->sort_order ?? 0 }}" style="width: 80px; height: 38px; border-radius: 8px; font-size: 14px;">
          </div>
        </div>
      </div>
    </div>

    <!-- Form Action Buttons -->
    <div class="d-flex justify-content-end gap-2 mb-5">
      <a href="{{ route('admin.saas.plans') }}" class="btn btn-light border font-weight-bold px-4 py-2" style="border-radius: 10px; font-size: 14px;">
        Cancel
      </a>
      <button type="submit" class="btn font-weight-bold text-white px-4 py-2 d-flex align-items-center gap-2" style="background: linear-gradient(135deg, #e11d48, #be123c); border: none; border-radius: 10px; font-size: 14px; box-shadow: 0 4px 14px rgba(225,29,72,0.3);">
        <i class="mdi mdi-check-circle-outline font-18"></i> Update Subscription Plan
      </button>
    </div>
  </form>
</div>

<style>
.feature-tile {
  border: 1.5px solid #e2e8f0;
  background: #ffffff;
  border-radius: 14px;
  cursor: pointer;
  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
  user-select: none;
}
.feature-tile:hover {
  border-color: #cbd5e1;
  transform: translateY(-2px);
  box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
}
.feature-tile.tile-active {
  border-color: #2563eb !important;
  background: linear-gradient(135deg, #f0f7ff 0%, #ffffff 100%) !important;
  box-shadow: 0 4px 16px rgba(37, 99, 235, 0.12) !important;
}
.tile-icon-box {
  width: 44px;
  height: 44px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #ffffff;
  font-size: 20px;
  flex-shrink: 0;
}
.tile-check-circle {
  width: 22px;
  height: 22px;
  border-radius: 50%;
  border: 2px solid #cbd5e1;
  display: flex;
  align-items: center;
  justify-content: center;
  color: transparent;
  font-size: 13px;
  transition: all 0.15s ease;
  background: #ffffff;
  flex-shrink: 0;
}
.tile-active .tile-check-circle {
  border-color: #2563eb;
  background: #2563eb;
  color: #ffffff;
  box-shadow: 0 2px 6px rgba(37, 99, 235, 0.35);
}
</style>

<script>
function toggleFeatureTile(tile) {
  const checkbox = tile.querySelector('.feature-checkbox');
  checkbox.checked = !checkbox.checked;
  if (checkbox.checked) {
    tile.classList.add('tile-active');
  } else {
    tile.classList.remove('tile-active');
  }
}

function toggleAllFeatures(checkAll) {
  document.querySelectorAll('.feature-tile').forEach(tile => {
    const cb = tile.querySelector('.feature-checkbox');
    cb.checked = checkAll;
    if (checkAll) {
      tile.classList.add('tile-active');
    } else {
      tile.classList.remove('tile-active');
    }
  });
}

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
