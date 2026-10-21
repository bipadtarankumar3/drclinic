@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  <div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center flex-wrap">
      <div>
        <h2 class="font-weight-bold mb-1"><i class="mdi mdi-package-variant-closed text-primary mr-1"></i> Subscription Plans & Pricing</h2>
        <p class="text-muted mb-0">Create, price, and manage the SaaS subscription tiers offered to doctors.</p>
      </div>
      <button class="btn btn-primary font-weight-bold mt-2 mt-sm-0" data-bs-toggle="modal" data-bs-target="#createPlanModal">
        <i class="mdi mdi-plus-circle mr-1"></i> Add New Plan
      </button>
    </div>
  </div>

  @if(session('success'))
  <div class="alert alert-success alert-dismissible fade show rounded-3 p-3 mb-4" role="alert">
    <strong><i class="mdi mdi-check-circle mr-1"></i></strong> {{ session('success') }}
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

  <!-- Plans Grid -->
  <div class="row">
    @foreach($plans as $plan)
    <div class="col-lg-4 col-md-6 mb-4">
      <div class="card border-0 shadow-sm rounded-4 h-100" style="border-radius: 20px;">
        <div class="card-body p-4 d-flex flex-column justify-content-between">
          <div>
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h4 class="font-weight-bold mb-0">{{ $plan->name }}</h4>
              @if($plan->is_active)
                <span class="badge bg-success text-white">Active</span>
              @else
                <span class="badge bg-secondary text-white">Inactive</span>
              @endif
            </div>

            <p class="text-muted font-13 mb-3">{{ $plan->description }}</p>

            <div class="mb-3">
              <span class="h2 font-weight-bold text-dark">₹{{ number_format($plan->price) }}</span>
              <span class="text-muted font-14">/ {{ $plan->billing_cycle }} ({{ $plan->duration_days }} days)</span>
            </div>

            <div class="mb-3 font-13 text-primary font-weight-bold">
              <i class="mdi mdi-account-group mr-1"></i> {{ $plan->subscriptions_count }} Active Subscriptions
            </div>

            <hr>

            <ul class="list-unstyled mb-4" style="line-height: 2;">
              @if(is_array($plan->features))
                @foreach($plan->features as $feature)
                <li class="font-13 text-secondary">
                  <i class="mdi mdi-check-circle text-success mr-1"></i> {{ $feature }}
                </li>
                @endforeach
              @endif
            </ul>
          </div>

          <div>
            <button class="btn btn-outline-primary btn-sm w-100 font-weight-bold" data-bs-toggle="modal" data-bs-target="#editPlanModal{{ $plan->id }}">
              <i class="mdi mdi-pencil mr-1"></i> Edit Plan
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Plan Modal -->
    <div class="modal fade" id="editPlanModal{{ $plan->id }}" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
          <form action="{{ route('admin.saas.plan.update', $plan->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-header border-0 pb-0">
              <h5 class="modal-title font-weight-bold">Edit Plan: {{ $plan->name }}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
              <div class="mb-3">
                <label class="form-label font-weight-bold">Plan Name</label>
                <input type="text" class="form-control" name="name" value="{{ $plan->name }}" required>
              </div>
              <div class="row g-2 mb-3">
                <div class="col-6">
                  <label class="form-label font-weight-bold">Price (₹)</label>
                  <input type="number" step="0.01" class="form-control" name="price" value="{{ $plan->price }}" required>
                </div>
                <div class="col-6">
                  <label class="form-label font-weight-bold">Duration (Days)</label>
                  <input type="number" class="form-control" name="duration_days" value="{{ $plan->duration_days }}" required>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label font-weight-bold">Billing Cycle</label>
                <select name="billing_cycle" class="form-select font-weight-bold">
                  <option value="monthly" {{ $plan->billing_cycle == 'monthly' ? 'selected' : '' }}>Monthly</option>
                  <option value="yearly" {{ $plan->billing_cycle == 'yearly' ? 'selected' : '' }}>Yearly</option>
                  <option value="lifetime" {{ $plan->billing_cycle == 'lifetime' ? 'selected' : '' }}>Lifetime</option>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label font-weight-bold">Description</label>
                <textarea class="form-control" name="description" rows="2">{{ $plan->description }}</textarea>
              </div>
              <div class="mb-3">
                <label class="form-label font-weight-bold">Features (One per line)</label>
                <textarea class="form-control" name="features" rows="5">{{ is_array($plan->features) ? implode("\n", $plan->features) : '' }}</textarea>
              </div>
              <div class="form-check form-switch mb-2">
                <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $plan->is_active ? 'checked' : '' }} id="active{{ $plan->id }}">
                <label class="form-check-label font-weight-bold" for="active{{ $plan->id }}">Active for Doctors</label>
              </div>
            </div>
            <div class="modal-footer border-0 pt-0">
              <button type="button" class="btn btn-secondary font-weight-bold" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary font-weight-bold">Update Plan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>

<!-- Create Plan Modal -->
<div class="modal fade" id="createPlanModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 border-0 shadow">
      <form action="{{ route('admin.saas.plan.store') }}" method="POST">
        @csrf
        <div class="modal-header border-0 pb-0">
          <h5 class="modal-title font-weight-bold">Add New Subscription Plan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4">
          <div class="mb-3">
            <label class="form-label font-weight-bold">Plan Name</label>
            <input type="text" class="form-control" name="name" placeholder="e.g. Starter Plan" required>
          </div>
          <div class="row g-2 mb-3">
            <div class="col-6">
              <label class="form-label font-weight-bold">Price (₹)</label>
              <input type="number" step="0.01" class="form-control" name="price" placeholder="999" required>
            </div>
            <div class="col-6">
              <label class="form-label font-weight-bold">Duration (Days)</label>
              <input type="number" class="form-control" name="duration_days" value="30" required>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label font-weight-bold">Billing Cycle</label>
            <select name="billing_cycle" class="form-select font-weight-bold">
              <option value="monthly">Monthly</option>
              <option value="yearly">Yearly</option>
              <option value="lifetime">Lifetime</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label font-weight-bold">Description</label>
            <textarea class="form-control" name="description" rows="2" placeholder="Short summary of this tier"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label font-weight-bold">Features (One per line)</label>
            <textarea class="form-control" name="features" rows="5" placeholder="Up to 500 Appointments&#10;Subdomain Support&#10;Doctor Razorpay Gateway"></textarea>
          </div>
          <div class="form-check form-switch mb-2">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" checked id="activeNew">
            <label class="form-check-label font-weight-bold" for="activeNew">Active for Doctors</label>
          </div>
        </div>
        <div class="modal-footer border-0 pt-0">
          <button type="button" class="btn btn-secondary font-weight-bold" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary font-weight-bold">Create Plan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
