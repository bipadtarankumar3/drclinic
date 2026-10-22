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
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="border-radius: 18px; border: 1.5px solid #e2e8f0; background: #ffffff;">
      <div class="card-body p-4">
        <!-- Header with Quick Actions & Dynamic Count -->
        <div class="d-flex justify-content-between align-items-center flex-wrap pb-3 mb-4" style="border-bottom: 1.5px solid #f1f5f9; gap: 12px;">
          <div class="d-flex align-items-center" style="gap: 14px;">
            <div class="d-flex align-items-center justify-content-center shadow-sm" style="width: 44px; height: 44px; border-radius: 12px; background: var(--theme-primary-gradient, linear-gradient(135deg, #059669, #10b981)); color: #ffffff; font-size: 22px;">
              <i class="mdi mdi-shield-star-outline"></i>
            </div>
            <div>
              <div class="d-flex align-items-center flex-wrap" style="gap: 10px;">
                <h5 class="font-weight-bold text-dark mb-0" style="font-size: 17px; letter-spacing: -0.3px;">
                  Entitled Feature Flags &amp; Capabilities
                </h5>
                <span class="feature-counter-badge">
                  <span id="featureCountNum">0</span> / {{ count($features) }} Enabled
                </span>
              </div>
              <p class="text-muted font-12 mb-0 mt-1">Toggle which medical capabilities, patient tools, and payment modules are unlocked for this plan.</p>
            </div>
          </div>

          <div class="d-flex align-items-center" style="gap: 8px;">
            <button type="button" class="btn btn-sm font-weight-bold" onclick="toggleAllFeatures(true)" style="background: #f8fafc; border: 1.5px solid #cbd5e1; color: #1e293b; font-size: 12px; border-radius: 8px; padding: 6px 14px;">
              <i class="mdi mdi-check-all text-primary mr-1" style="font-size: 15px;"></i> Select All
            </button>
            <button type="button" class="btn btn-sm font-weight-bold" onclick="toggleAllFeatures(false)" style="background: #f8fafc; border: 1.5px solid #cbd5e1; color: #64748b; font-size: 12px; border-radius: 8px; padding: 6px 14px;">
              <i class="mdi mdi-close-circle-outline mr-1" style="font-size: 15px;"></i> Deselect All
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
          <div class="col-md-6 mb-3">
            <div class="feature-tile {{ $isChecked ? 'tile-active' : '' }}" onclick="toggleFeatureTile(this)">
              <input type="checkbox" name="features[]" value="{{ $fKey }}" class="feature-checkbox d-none" {{ $isChecked ? 'checked' : '' }}>

              <div class="d-flex align-items-center" style="min-width: 0; flex: 1;">
                <!-- Icon Box -->
                <div class="tile-icon-box mr-3" style="margin-right: 14px; background: {{ $fData['gradient'] ?? 'linear-gradient(135deg, #2563eb, #1d4ed8)' }};">
                  <i class="mdi {{ $fData['icon'] ?? 'mdi-star' }}"></i>
                </div>

                <!-- Text & Metadata -->
                <div style="min-width: 0; padding-right: 14px;">
                  <div class="d-flex align-items-center flex-wrap mb-1" style="gap: 8px;">
                    <span class="tile-title">{{ $fData['name'] }}</span>
                    <span class="tile-badge" style="background: {{ $fData['badge_bg'] ?? '#eff6ff' }}; color: {{ $fData['badge_color'] ?? '#1d4ed8' }};">
                      {{ $fData['badge'] ?? 'MODULE' }}
                    </span>
                  </div>
                  <p class="tile-desc mb-0">{{ $fData['desc'] }}</p>
                </div>
              </div>

              <!-- Centered Circle Check Indicator -->
              <div class="tile-check-circle ml-auto">
                <i class="mdi mdi-check"></i>
              </div>
            </div>
          </div>
          @endforeach
        </div>

        <!-- Bottom Controls Toolbar -->
        <div class="p-3 d-flex justify-content-between align-items-center flex-wrap" style="background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%); border: 1.5px solid #e2e8f0; border-radius: 14px; gap: 16px;">
          <div class="d-flex align-items-center flex-wrap" style="gap: 14px;">
            <!-- Custom iOS Toggle -->
            <label class="ios-switch">
              <input type="checkbox" name="is_active" value="1" id="isActiveCheck" {{ $plan->is_active ? 'checked' : '' }} onchange="updateLiveStatusBadge(this.checked)">
              <span class="ios-slider"></span>
            </label>
            <label for="isActiveCheck" class="font-weight-bold text-dark font-13 mb-0 cursor-pointer" style="cursor: pointer;">
              Active for new subscriptions
            </label>

            <!-- Status Pill Badge -->
            <span id="tierStatusBadge" class="tier-status-pill {{ $plan->is_active ? 'status-live' : 'status-draft' }}">
              <span class="status-dot"></span>
              <span id="tierStatusText">{{ $plan->is_active ? 'Live Tier' : 'Draft Tier' }}</span>
            </span>
          </div>

          <div class="d-flex align-items-center" style="gap: 10px;">
            <label class="text-muted font-weight-bold font-12 text-uppercase mb-0" style="letter-spacing: 0.5px;">Display Order:</label>
            <input type="number" class="form-control text-center font-weight-bold" name="sort_order" value="{{ $plan->sort_order ?? 0 }}" style="width: 84px; height: 38px; border-radius: 8px; font-size: 14px; border: 1.5px solid #cbd5e1; background: #ffffff;">
          </div>
        </div>
      </div>
    </div>

    <!-- Form Action Buttons -->
    <div class="d-flex justify-content-end align-items-center mb-5" style="gap: 12px;">
      <a href="{{ route('admin.saas.plans') }}" class="btn font-weight-bold px-4 py-2" style="border-radius: 10px; font-size: 14px; background: #ffffff; border: 1.5px solid #cbd5e1; color: #475569;">
        Cancel
      </a>
      <button type="submit" class="btn font-weight-bold text-white px-4 py-2 d-flex align-items-center" style="background: linear-gradient(135deg, #e11d48, #be123c); border: none; border-radius: 10px; font-size: 14px; box-shadow: 0 4px 14px rgba(225,29,72,0.3);">
        <i class="mdi mdi-check-circle-outline font-18 mr-2" style="margin-right: 6px;"></i> Update Subscription Plan
      </button>
    </div>
  </form>
</div>

<style>
.feature-tile {
  border: 1.5px solid #e2e8f0;
  background: #ffffff;
  border-radius: 14px;
  padding: 16px 20px;
  cursor: pointer;
  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
  user-select: none;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 100%;
}
.feature-tile:hover {
  border-color: #94a3b8;
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
}
.feature-tile.tile-active {
  border-color: #2563eb !important;
  background: linear-gradient(135deg, #f8faff 0%, #ffffff 100%) !important;
  box-shadow: 0 4px 16px rgba(37, 99, 235, 0.12) !important;
}
.tile-icon-box {
  width: 46px;
  height: 46px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #ffffff;
  font-size: 22px;
  flex-shrink: 0;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
}
.tile-title {
  font-size: 14.5px;
  font-weight: 700;
  color: #0f172a;
  letter-spacing: -0.2px;
}
.tile-badge {
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 0.4px;
  padding: 2.5px 8px;
  border-radius: 6px;
  border: 1px solid rgba(0, 0, 0, 0.06);
  display: inline-block;
}
.tile-desc {
  font-size: 12.5px;
  color: #64748b;
  line-height: 1.4;
}
.tile-check-circle {
  width: 24px;
  height: 24px;
  border-radius: 50%;
  border: 2px solid #cbd5e1;
  display: flex;
  align-items: center;
  justify-content: center;
  color: transparent;
  font-size: 14px;
  font-weight: 700;
  transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
  background: #ffffff;
  flex-shrink: 0;
}
.tile-active .tile-check-circle {
  border-color: #2563eb;
  background: #2563eb;
  color: #ffffff;
  box-shadow: 0 2px 8px rgba(37, 99, 235, 0.4);
  transform: scale(1.06);
}

/* iOS Toggle Slider */
.ios-switch {
  position: relative;
  display: inline-block;
  width: 44px;
  height: 24px;
  margin-bottom: 0;
  vertical-align: middle;
  cursor: pointer;
}
.ios-switch input {
  opacity: 0;
  width: 0;
  height: 0;
  position: absolute;
}
.ios-slider {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #cbd5e1;
  transition: .25s ease;
  border-radius: 24px;
}
.ios-slider:before {
  position: absolute;
  content: "";
  height: 18px;
  width: 18px;
  left: 3px;
  bottom: 3px;
  background-color: white;
  transition: .25s cubic-bezier(0.4, 0, 0.2, 1);
  border-radius: 50%;
  box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}
.ios-switch input:checked + .ios-slider {
  background-color: var(--theme-primary, #059669);
}
.ios-switch input:checked + .ios-slider:before {
  transform: translateX(20px);
}

/* Status Pill */
.tier-status-pill {
  font-size: 11px;
  font-weight: 700;
  padding: 4px 12px;
  border-radius: 20px;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  transition: all 0.2s ease;
}
.tier-status-pill.status-live {
  background: #ecfdf5;
  color: #059669;
  border: 1px solid #a7f3d0;
}
.tier-status-pill.status-draft {
  background: #f1f5f9;
  color: #64748b;
  border: 1px solid #e2e8f0;
}
.tier-status-pill .status-dot {
  width: 6px;
  height: 6px;
  border-radius: 50%;
  display: inline-block;
}
.tier-status-pill.status-live .status-dot {
  background: #10b981;
  box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2);
}
.tier-status-pill.status-draft .status-dot {
  background: #94a3b8;
}

/* Feature Counter Pill */
.feature-counter-badge {
  background: #ecfdf5;
  color: #047857;
  border: 1px solid #a7f3d0;
  font-size: 11.5px;
  font-weight: 700;
  padding: 4px 12px;
  border-radius: 20px;
  display: inline-flex;
  align-items: center;
}
</style>

<script>
function updateFeatureCount() {
  const activeCount = document.querySelectorAll('.feature-tile.tile-active').length;
  const numElem = document.getElementById('featureCountNum');
  if (numElem) {
    numElem.innerText = activeCount;
  }
}

function toggleFeatureTile(tile) {
  const checkbox = tile.querySelector('.feature-checkbox');
  checkbox.checked = !checkbox.checked;
  if (checkbox.checked) {
    tile.classList.add('tile-active');
  } else {
    tile.classList.remove('tile-active');
  }
  updateFeatureCount();
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
  updateFeatureCount();
}

function updateLiveStatusBadge(isChecked) {
  const badge = document.getElementById('tierStatusBadge');
  const text = document.getElementById('tierStatusText');
  if (isChecked) {
    badge.className = 'tier-status-pill status-live';
    text.innerText = 'Live Tier';
  } else {
    badge.className = 'tier-status-pill status-draft';
    text.innerText = 'Draft Tier';
  }
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

// Initialize count on load
document.addEventListener('DOMContentLoaded', function() {
  updateFeatureCount();
});
</script>
@endsection
