@extends('admin.layouts.main')

@section('style')
<style>
.icon-option-btn {
  border: 1.5px solid #e2e8f0;
  border-radius: 10px;
  padding: 10px 14px;
  background: #ffffff;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-size: 13.5px;
  font-weight: 500;
  color: #334155;
  transition: all 0.15s ease;
}
.icon-option-btn:hover {
  background: #f8fafc;
  border-color: #cbd5e1;
}
.icon-option-btn.selected {
  background: #f0fdf4;
  border-color: #059669;
  color: #065f46;
  box-shadow: 0 0 0 2px rgba(5, 150, 105, 0.2);
}
.icon-preview-circle {
  width: 44px;
  height: 44px;
  border-radius: 12px;
  background: var(--theme-primary-subtle, rgba(5, 150, 105, 0.1));
  color: var(--theme-primary, #059669);
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
}
</style>
@endsection

@section('content')
<div class="content-wrapper">
  <!-- Page Header matching Plan Edit Design -->
  <div class="d-flex justify-content-between align-items-center flex-wrap mb-4 pb-2">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <a href="{{ route('clinic.services.index') }}" class="btn btn-sm btn-light border font-weight-bold text-muted mr-2" style="border-radius: 8px;">
          <i class="mdi mdi-arrow-left mr-1"></i> Back to Services
        </a>
        <h2 class="font-weight-bold mb-0 text-dark" style="font-size: 24px; letter-spacing: -0.5px;">Edit Clinic Service</h2>
        @if($service->status)
          <span class="badge" style="background: #059669; color: #fff; font-size: 10.5px; font-weight: 700; padding: 4px 10px; border-radius: 9999px;">ACTIVE TIER</span>
        @else
          <span class="badge" style="background: #94a3b8; color: #fff; font-size: 10.5px; font-weight: 700; padding: 4px 10px; border-radius: 9999px;">INACTIVE TIER</span>
        @endif
      </div>
      <p class="text-muted mb-0" style="font-size: 13.5px;">Update treatment details, pricing, icon, or storefront visibility for this service.</p>
    </div>

    <div>
      <form action="{{ route('clinic.services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this service?');" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-outline-danger btn-sm font-weight-bold px-3 py-2" style="border-radius: 8px;">
          <i class="mdi mdi-delete-outline mr-1"></i> Delete Service
        </button>
      </form>
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

  <form action="{{ route('clinic.services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- Section 1: Service Identity & Commercial Pricing -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="border-radius: 16px; border: 1.5px solid #e2e8f0; background: #ffffff;">
      <div class="card-body p-4">
        <h5 class="font-weight-bold text-dark mb-3 d-flex align-items-center" style="font-size: 16px;">
          <span class="mr-2" style="color: var(--theme-primary, #059669); font-size: 16px; margin-right: 8px;">●</span> Service Identity &amp; Pricing
        </h5>

        <div class="row g-3 mb-3">
          <div class="col-md-8">
            <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Service Name / Title *</label>
            <input type="text" class="form-control" name="title" value="{{ old('title', $service->title) }}" required style="border-radius: 8px; font-size: 14px;">
          </div>
          <div class="col-md-4">
            <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Clinic Specialization</label>
            <input type="text" class="form-control bg-light" value="{{ $clinic->specialization ?? 'General Care' }}" readonly style="border-radius: 8px; font-size: 14px;">
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Service Description</label>
          <textarea class="form-control" name="description" rows="3" style="border-radius: 8px; font-size: 14px;">{{ old('description', $service->description) }}</textarea>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Consultation Fee (Optional)</label>
            <div class="input-group">
              <span class="input-group-text bg-light font-weight-bold">₹</span>
              <input type="number" step="0.01" class="form-control" name="price" value="{{ old('price', $service->price) }}" placeholder="e.g. 500.00" style="font-size: 14px;">
            </div>
            <small class="text-muted" style="font-size: 11.5px;">If left blank, standard clinic consultation fee (₹{{ number_format($clinic->consultation_fee ?? 499, 0) }}) applies.</small>
          </div>
          <div class="col-md-6">
            <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Display Sort Order</label>
            <input type="number" class="form-control" name="sort_order" value="{{ old('sort_order', $service->sort_order) }}" required style="border-radius: 8px; font-size: 14px;">
            <small class="text-muted" style="font-size: 11.5px;">Lower numbers appear first on your storefront.</small>
          </div>
        </div>
      </div>
    </div>

    <!-- Section 2: Visual Icon & Branding -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="border-radius: 16px; border: 1.5px solid #e2e8f0; background: #ffffff;">
      <div class="card-body p-4">
        <h5 class="font-weight-bold text-dark mb-3 d-flex align-items-center" style="font-size: 16px;">
          <span class="mr-2" style="color: #f97316; font-size: 16px; margin-right: 8px;">●</span> Visual Icon &amp; Representation
        </h5>

        <div class="mb-3">
          <label class="form-label font-weight-bold text-uppercase text-muted mb-2" style="font-size: 11px; letter-spacing: 0.5px;">Select Preset Healthcare Icon</label>
          <div class="d-flex flex-wrap gap-2" id="iconPickerPreset">
            @php $currentIcon = $service->icon ?: 'fa-stethoscope'; @endphp
            <button type="button" class="icon-option-btn {{ $currentIcon == 'fa-stethoscope' ? 'selected' : '' }}" data-icon="fa-stethoscope"><i class="fa-solid fa-stethoscope"></i> Stethoscope</button>
            <button type="button" class="icon-option-btn {{ $currentIcon == 'fa-user-doctor' ? 'selected' : '' }}" data-icon="fa-user-doctor"><i class="fa-solid fa-user-doctor"></i> Doctor</button>
            <button type="button" class="icon-option-btn {{ $currentIcon == 'fa-heart-pulse' ? 'selected' : '' }}" data-icon="fa-heart-pulse"><i class="fa-solid fa-heart-pulse"></i> Cardiology</button>
            <button type="button" class="icon-option-btn {{ $currentIcon == 'fa-tooth' ? 'selected' : '' }}" data-icon="fa-tooth"><i class="fa-solid fa-tooth"></i> Dental</button>
            <button type="button" class="icon-option-btn {{ $currentIcon == 'fa-eye' ? 'selected' : '' }}" data-icon="fa-eye"><i class="fa-solid fa-eye"></i> Eye Care</button>
            <button type="button" class="icon-option-btn {{ $currentIcon == 'fa-brain' ? 'selected' : '' }}" data-icon="fa-brain"><i class="fa-solid fa-brain"></i> Neurology</button>
            <button type="button" class="icon-option-btn {{ $currentIcon == 'fa-bone' ? 'selected' : '' }}" data-icon="fa-bone"><i class="fa-solid fa-bone"></i> Orthopedic</button>
            <button type="button" class="icon-option-btn {{ $currentIcon == 'fa-baby' ? 'selected' : '' }}" data-icon="fa-baby"><i class="fa-solid fa-baby"></i> Pediatrics</button>
            <button type="button" class="icon-option-btn {{ $currentIcon == 'fa-notes-medical' ? 'selected' : '' }}" data-icon="fa-notes-medical"><i class="fa-solid fa-notes-medical"></i> Medical Notes</button>
            <button type="button" class="icon-option-btn {{ $currentIcon == 'fa-kit-medical' ? 'selected' : '' }}" data-icon="fa-kit-medical"><i class="fa-solid fa-kit-medical"></i> First Aid Kit</button>
            <button type="button" class="icon-option-btn {{ $currentIcon == 'fa-microscope' ? 'selected' : '' }}" data-icon="fa-microscope"><i class="fa-solid fa-microscope"></i> Diagnostic Lab</button>
            <button type="button" class="icon-option-btn {{ $currentIcon == 'fa-syringe' ? 'selected' : '' }}" data-icon="fa-syringe"><i class="fa-solid fa-syringe"></i> Vaccination</button>
            <button type="button" class="icon-option-btn {{ $currentIcon == 'fa-shield-heart' ? 'selected' : '' }}" data-icon="fa-shield-heart"><i class="fa-solid fa-shield-heart"></i> Preventive</button>
            <button type="button" class="icon-option-btn {{ $currentIcon == 'fa-hospital' ? 'selected' : '' }}" data-icon="fa-hospital"><i class="fa-solid fa-hospital"></i> Hospital Care</button>
          </div>
        </div>

        <div class="row g-3 align-items-center">
          <div class="col-md-8">
            <label class="form-label font-weight-bold text-uppercase text-muted" style="font-size: 11px; letter-spacing: 0.5px;">Custom FontAwesome Icon Class</label>
            <input type="text" class="form-control" name="icon" id="customIconInput" value="{{ old('icon', $service->icon ?: 'fa-stethoscope') }}" style="border-radius: 8px; font-size: 14px;">
            <small class="text-muted" style="font-size: 11.5px;">Supports any FontAwesome icon class (e.g. <code>fa-solid fa-lungs</code> or <code>fa-headset</code>).</small>
          </div>
          <div class="col-md-4 text-center">
            <label class="form-label font-weight-bold text-uppercase text-muted d-block" style="font-size: 11px; letter-spacing: 0.5px;">Live Preview</label>
            <div class="icon-preview-circle" id="iconLivePreview">
              <i class="{{ $service->icon_class }}"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Section 3: Storefront Visibility & Status -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="border-radius: 16px; border: 1.5px solid #e2e8f0; background: #ffffff;">
      <div class="card-body p-4">
        <h5 class="font-weight-bold text-dark mb-3 d-flex align-items-center" style="font-size: 16px;">
          <span class="mr-2" style="color: #10b981; font-size: 16px; margin-right: 8px;">●</span> Storefront Visibility &amp; Status
        </h5>

        <div class="form-check form-switch d-flex align-items-center gap-3 p-0">
          <input class="form-check-input ms-0 me-3" type="checkbox" name="status" value="1" id="serviceStatusSwitch" {{ $service->status ? 'checked' : '' }} style="width: 44px; height: 24px; cursor: pointer;">
          <div>
            <label class="form-check-label font-weight-bold text-dark mb-0" for="serviceStatusSwitch" style="font-size: 14px; cursor: pointer;">
              Active on Website Storefront
            </label>
            <p class="text-muted mb-0 font-12">When enabled, this service card is publicly visible on your clinic homepage.</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Bottom Action Bar -->
    <div class="form-actions-end mt-4 pt-2 mb-5">
      <a href="{{ route('clinic.services.index') }}" class="btn btn-light border font-weight-bold px-4 py-2" style="border-radius: 10px;">
        Cancel
      </a>
      <button type="submit" class="btn btn-primary font-weight-bold px-4 py-2 d-inline-flex align-items-center" style="border-radius: 10px;">
        <i class="mdi mdi-check mr-1" style="font-size: 18px;"></i> Update Service
      </button>
    </div>
  </form>
</div>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const customIconInput = document.getElementById('customIconInput');
  const iconPreview = document.getElementById('iconLivePreview');
  const presetButtons = document.querySelectorAll('.icon-option-btn');

  function updateIconPreview(iconClass) {
    let clean = iconClass.trim();
    if (!clean.includes('fa-')) {
      clean = 'fa-' + clean;
    }
    if (!clean.includes('fa-solid') && !clean.includes('fa-regular') && !clean.includes('mdi-')) {
      clean = 'fa-solid ' + clean;
    }
    iconPreview.innerHTML = '<i class="' + clean + '"></i>';
  }

  presetButtons.forEach(btn => {
    btn.addEventListener('click', function() {
      presetButtons.forEach(b => b.classList.remove('selected'));
      this.classList.add('selected');
      const icon = this.getAttribute('data-icon');
      customIconInput.value = icon;
      updateIconPreview(icon);
    });
  });

  if (customIconInput) {
    customIconInput.addEventListener('input', function() {
      updateIconPreview(this.value);
    });
  }
});
</script>
@endsection
