@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  <!-- Top Header with Date Filter -->
  <div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center flex-wrap">
      <div>
        <h2 class="font-weight-bold mb-1"><i class="mdi mdi-chart-box-outline text-primary mr-1"></i> SaaS Platform Analytics</h2>
        <p class="text-muted mb-0">Overview of doctor clinics, SaaS subscription revenue, growth metrics, and activity.</p>
      </div>
      <div class="mt-2 mt-sm-0">
        <form method="GET" action="{{ route('admin.saas.dashboard') }}" class="d-flex align-items-center gap-2">
          <label class="text-muted font-13 font-weight-bold mb-0">Filter:</label>
          <select name="range" class="form-select form-select-sm font-weight-bold" onchange="this.form.submit()">
            <option value="7_days" {{ $range == '7_days' ? 'selected' : '' }}>Last 7 Days</option>
            <option value="30_days" {{ $range == '30_days' ? 'selected' : '' }}>Last 30 Days</option>
            <option value="90_days" {{ $range == '90_days' ? 'selected' : '' }}>Last 90 Days</option>
            <option value="1_year" {{ $range == '1_year' ? 'selected' : '' }}>Last 1 Year</option>
          </select>
        </form>
      </div>
    </div>
  </div>

  @if(session('success'))
  <div class="alert alert-success alert-dismissible fade show rounded-3 p-3 mb-4" role="alert">
    <strong><i class="mdi mdi-check-circle mr-1"></i></strong> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  <!-- KPI Cards -->
  <div class="row">
    <!-- Total Clinics -->
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
      <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #2563eb, #1d4ed8); border-radius: 18px; color: #ffffff;">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <p class="text-white-50 text-uppercase font-weight-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Total Doctor Clinics</p>
              <h2 class="font-weight-bold mb-0">{{ $totalClinics }}</h2>
              <small class="text-white-50 mt-1 d-block">{{ $totalDoctors }} registered doctors</small>
            </div>
            <div style="background: rgba(255,255,255,0.2); width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center;">
              <i class="mdi mdi-hospital-building" style="font-size: 26px;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Active Paid Subscriptions -->
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
      <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #059669, #047857); border-radius: 18px; color: #ffffff;">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <p class="text-white-50 text-uppercase font-weight-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Active Subscriptions</p>
              <h2 class="font-weight-bold mb-0">{{ $activeClinics }}</h2>
              <small class="text-white-50 mt-1 d-block">{{ $trialingClinics }} on free trial</small>
            </div>
            <div style="background: rgba(255,255,255,0.2); width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center;">
              <i class="mdi mdi-shield-check" style="font-size: 26px;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Platform Revenue -->
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
      <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #7c3aed, #6d28d9); border-radius: 18px; color: #ffffff;">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <p class="text-white-50 text-uppercase font-weight-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">SaaS Platform Revenue</p>
              <h2 class="font-weight-bold mb-0">₹{{ number_format($totalPlatformRevenue, 2) }}</h2>
              <small class="text-white-50 mt-1 d-block">From doctor plan subscriptions</small>
            </div>
            <div style="background: rgba(255,255,255,0.2); width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center;">
              <i class="mdi mdi-currency-inr" style="font-size: 26px;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Expired Clinics -->
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
      <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #dc2626, #b91c1c); border-radius: 18px; color: #ffffff;">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <p class="text-white-50 text-uppercase font-weight-bold mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Expired / Inactive</p>
              <h2 class="font-weight-bold mb-0">{{ $expiredClinics }}</h2>
              <small class="text-white-50 mt-1 d-block">Booking page disabled</small>
            </div>
            <div style="background: rgba(255,255,255,0.2); width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center;">
              <i class="mdi mdi-alert-octagon" style="font-size: 26px;"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Charts Row -->
  <div class="row">
    <!-- Revenue Trend Chart -->
    <div class="col-lg-8 grid-margin stretch-card">
      <div class="card border-0 shadow-sm rounded-4" style="border-radius: 16px;">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="card-title font-weight-bold mb-0">Subscription Revenue Trend</h5>
            <span class="badge bg-light text-primary font-weight-bold">Last 6 Months</span>
          </div>
          <div style="height: 280px; position: relative;">
            <canvas id="revenueChart"></canvas>
          </div>
        </div>
      </div>
    </div>

    <!-- Plan Distribution Doughnut -->
    <div class="col-lg-4 grid-margin stretch-card">
      <div class="card border-0 shadow-sm rounded-4" style="border-radius: 16px;">
        <div class="card-body p-4">
          <h5 class="card-title font-weight-bold mb-4">Active Plan Distribution</h5>
          <div style="height: 230px; position: relative;">
            <canvas id="planChart"></canvas>
          </div>
          <div class="mt-3 text-center">
            @foreach($planDistribution as $planItem)
            <span class="badge bg-light text-dark me-1 mb-1">
              {{ $planItem->name }}: <strong>{{ $planItem->subscriptions_count }}</strong>
            </span>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Recent Doctor Clinics Table & Activity Logs -->
  <div class="row">
    <!-- Recent Clinics -->
    <div class="col-lg-8 grid-margin stretch-card">
      <div class="card border-0 shadow-sm rounded-4" style="border-radius: 16px;">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title font-weight-bold mb-0"><i class="mdi mdi-hospital-building text-primary mr-1"></i> Registered Doctor Clinics</h5>
            <a href="{{ route('admin.saas.clinics') }}" class="btn btn-sm btn-link text-primary font-weight-bold">View All Clinics &rarr;</a>
          </div>

          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead class="bg-light">
                <tr>
                  <th>Clinic Name</th>
                  <th>Doctor / Owner</th>
                  <th>Subdomain / URL</th>
                  <th>Status</th>
                  <th>Trial / Plan Ends</th>
                  <th class="text-end">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($recentClinics as $c)
                <tr>
                  <td class="font-weight-bold text-dark">{{ $c->name }}</td>
                  <td>{{ $c->user->name ?? 'Dr. Admin' }}</td>
                  <td>
                    <code class="text-primary font-weight-bold">{{ $c->subdomain }}.{{ request()->getHost() }}</code>
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
                    {{ $c->trial_ends_at ? $c->trial_ends_at->format('d M, Y') : 'Active' }}
                  </td>
                  <td class="text-end">
                    <a href="{{ route('admin.saas.impersonate', $c->id) }}" class="btn btn-xs btn-outline-primary" title="Login as Doctor">
                      <i class="mdi mdi-login-variant"></i>
                    </a>
                    <a href="{{ route('admin.saas.clinic.edit', $c->id) }}" class="btn btn-xs btn-outline-secondary" title="Manage Clinic">
                      <i class="mdi mdi-pencil"></i>
                    </a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Activity Logs -->
    <div class="col-lg-4 grid-margin stretch-card">
      <div class="card border-0 shadow-sm rounded-4" style="border-radius: 16px;">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title font-weight-bold mb-0"><i class="mdi mdi-history text-primary mr-1"></i> Live Audit Trail</h5>
            <a href="{{ route('admin.saas.logs') }}" class="btn btn-sm btn-link text-primary font-weight-bold">All Logs &rarr;</a>
          </div>

          <div class="activity-feed" style="max-height: 380px; overflow-y: auto;">
            @forelse($recentLogs as $log)
            <div class="border-bottom py-2">
              <div class="d-flex justify-content-between align-items-center">
                <span class="badge bg-light text-dark font-11 font-weight-bold">{{ $log->action }}</span>
                <small class="text-muted font-11">{{ $log->created_at->diffForHumans() }}</small>
              </div>
              <p class="mb-0 font-13 text-secondary mt-1">{{ Str::limit($log->description, 60) }}</p>
              <small class="text-muted font-11">
                @if($log->clinic) Clinic: <strong>{{ $log->clinic->name }}</strong> &bull; @endif
                IP: {{ $log->ip_address }}
              </small>
            </div>
            @empty
            <p class="text-muted font-13 text-center py-4">No recent activity logs.</p>
            @endforelse
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
  // 1. Revenue Trend Chart
  const revenueCtx = document.getElementById('revenueChart').getContext('2d');
  const revenueLabels = {!! json_encode(array_keys($revenueTrend)) !!};
  const revenueData = {!! json_encode(array_values($revenueTrend)) !!};

  new Chart(revenueCtx, {
    type: 'bar',
    data: {
      labels: revenueLabels.length > 0 ? revenueLabels : ['This Month'],
      datasets: [{
        label: 'Platform Revenue (₹)',
        data: revenueData.length > 0 ? revenueData : [0],
        backgroundColor: 'rgba(37, 99, 235, 0.85)',
        borderColor: '#2563eb',
        borderRadius: 8,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            callback: function(val) { return '₹' + val; }
          }
        }
      }
    }
  });

  // 2. Plan Distribution Chart
  const planCtx = document.getElementById('planChart').getContext('2d');
  const planLabels = {!! json_encode($planDistribution->pluck('name')) !!};
  const planData = {!! json_encode($planDistribution->pluck('subscriptions_count')) !!};

  new Chart(planCtx, {
    type: 'doughnut',
    data: {
      labels: planLabels,
      datasets: [{
        data: planData.every(v => v === 0) ? [1] : planData,
        backgroundColor: ['#2563eb', '#10b981', '#f59e0b', '#8b5cf6'],
        borderWidth: 0
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'bottom'
        }
      }
    }
  });
});
</script>
@endsection
