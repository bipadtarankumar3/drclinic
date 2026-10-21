@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  <div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center flex-wrap">
      <div>
        <h2 class="font-weight-bold mb-1"><i class="mdi mdi-hospital-building text-primary mr-1"></i> All Doctor Clinics Directory</h2>
        <p class="text-muted mb-0">Browse, manage, impersonate, and adjust trial/subscription settings for all registered clinics.</p>
      </div>
    </div>
  </div>

  @if(session('success'))
  <div class="alert alert-success alert-dismissible fade show rounded-3 p-3 mb-4" role="alert">
    <strong><i class="mdi mdi-check-circle mr-1"></i></strong> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  <!-- Filters & Search -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="card border-0 shadow-sm rounded-4" style="border-radius: 16px;">
        <div class="card-body p-3">
          <form method="GET" action="{{ route('admin.saas.clinics') }}" class="row g-2 align-items-center">
            <div class="col-md-5">
              <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="mdi mdi-magnify"></i></span>
                <input type="text" name="search" class="form-control border-start-0" placeholder="Search clinic name, doctor, subdomain, email..." value="{{ request('search') }}">
              </div>
            </div>

            <div class="col-md-3">
              <select name="status" class="form-select font-weight-bold">
                <option value="">All Statuses</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="trialing" {{ request('status') == 'trialing' ? 'selected' : '' }}>Trialing</option>
                <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
              </select>
            </div>

            <div class="col-md-4 d-flex gap-2">
              <button type="submit" class="btn btn-primary font-weight-bold px-4">Filter</button>
              <a href="{{ route('admin.saas.clinics') }}" class="btn btn-outline-secondary font-weight-bold">Reset</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Clinics Table -->
  <div class="row">
    <div class="col-12">
      <div class="card border-0 shadow-sm rounded-4" style="border-radius: 16px;">
        <div class="card-body p-4">
          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead class="bg-light">
                <tr>
                  <th>Clinic Info</th>
                  <th>Doctor / Owner</th>
                  <th>Domain / Subdomain</th>
                  <th>Status</th>
                  <th>Plan & Expiry</th>
                  <th class="text-end">Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse($clinics as $c)
                <tr>
                  <td>
                    <div class="font-weight-bold text-dark font-15">{{ $c->name }}</div>
                    <small class="text-muted">{{ $c->specialization ?? 'General Medical' }} &bull; {{ $c->phone }}</small>
                  </td>
                  <td>
                    <div class="font-weight-bold">{{ $c->user->name ?? 'Admin' }}</div>
                    <small class="text-muted">{{ $c->user->email ?? $c->email }}</small>
                  </td>
                  <td>
                    <div><code class="text-primary font-weight-bold">{{ $c->subdomain }}.{{ request()->getHost() }}</code></div>
                    @if($c->custom_domain)
                      <small class="text-success"><i class="mdi mdi-check-decagram"></i> {{ $c->custom_domain }}</small>
                    @endif
                  </td>
                  <td>
                    @if($c->status === 'active')
                      <span class="badge bg-success text-white">Active</span>
                    @elseif($c->status === 'trialing')
                      @if($c->trial_ends_at && $c->trial_ends_at->isPast())
                        <span class="badge bg-danger text-white">Trial Expired</span>
                      @else
                        <span class="badge bg-warning text-dark">Trial ({{ $c->trialDaysRemaining() }}d)</span>
                      @endif
                    @elseif($c->status === 'suspended')
                      <span class="badge bg-dark text-white">Suspended</span>
                    @else
                      <span class="badge bg-danger text-white">Expired</span>
                    @endif
                  </td>
                  <td>
                    <div class="font-weight-bold font-13">{{ $c->activeSubscription->plan->name ?? ($c->status === 'trialing' ? '7-Day Trial' : 'No Active Plan') }}</div>
                    <small class="text-muted">
                      @if($c->trial_ends_at)
                        Ends: {{ $c->trial_ends_at->format('d M, Y') }}
                      @else
                        No Expiry
                      @endif
                    </small>
                  </td>
                  <td class="text-end text-nowrap">
                    <a href="{{ route('admin.saas.visit_doctor_plan', $c->id) }}" class="btn btn-sm btn-outline-warning me-1 font-weight-bold" title="Visit & Manage Doctor's Plan & Billing">
                      <i class="mdi mdi-crown text-warning me-1"></i> Visit Plan
                    </a>
                    <a href="{{ route('admin.saas.impersonate', $c->id) }}" class="btn btn-sm btn-outline-primary me-1 font-weight-bold" title="Login as Doctor / Clinic Admin">
                      <i class="mdi mdi-login-variant me-1"></i> Enter Clinic
                    </a>
                    <a href="{{ route('admin.saas.clinic.edit', $c->id) }}" class="btn btn-sm btn-outline-secondary font-weight-bold" title="Edit Settings">
                      <i class="mdi mdi-tune"></i> Manage
                    </a>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="6" class="text-center py-5 text-muted">
                    No doctor clinics match your search criteria.
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <div class="mt-4">
            {{ $clinics->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
