@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  <div class="row mb-4">
    <div class="col-12">
      <h2 class="font-weight-bold mb-1"><i class="mdi mdi-history text-primary mr-1"></i> System Activity & Audit Trail</h2>
      <p class="text-muted mb-0">Complete historical log of doctor registrations, clinic creations, plan upgrades, domain changes, and administrative actions.</p>
    </div>
  </div>

  <!-- Search & Action Filters -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="card border-0 shadow-sm rounded-4" style="border-radius: 16px;">
        <div class="card-body p-3">
          <form method="GET" action="{{ route('admin.saas.logs') }}" class="row g-2 align-items-center">
            <div class="col-md-5">
              <input type="text" name="search" class="form-control" placeholder="Search description, IP address..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
              <select name="action" class="form-select font-weight-bold">
                <option value="">All Actions</option>
                @foreach($actions as $act)
                  <option value="{{ $act }}" {{ request('action') == $act ? 'selected' : '' }}>{{ $act }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
              <button type="submit" class="btn btn-primary font-weight-bold px-3">Filter</button>
              <a href="{{ route('admin.saas.logs') }}" class="btn btn-outline-secondary font-weight-bold">Reset</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Logs Table -->
  <div class="row">
    <div class="col-12">
      <div class="card border-0 shadow-sm rounded-4" style="border-radius: 16px;">
        <div class="card-body p-4">
          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead class="bg-light">
                <tr>
                  <th>Timestamp</th>
                  <th>Action</th>
                  <th>Details / Description</th>
                  <th>User / Doctor</th>
                  <th>Clinic</th>
                  <th>IP Address</th>
                </tr>
              </thead>
              <tbody>
                @forelse($logs as $log)
                <tr>
                  <td class="text-nowrap font-13 font-monospace text-muted">
                    {{ $log->created_at->format('Y-m-d H:i:s') }}
                  </td>
                  <td>
                    <span class="badge bg-light text-dark font-weight-bold">{{ $log->action }}</span>
                  </td>
                  <td>{{ $log->description ?? 'N/A' }}</td>
                  <td>{{ $log->user->name ?? 'System' }}</td>
                  <td>
                    @if($log->clinic)
                      <span class="badge bg-light-primary text-primary font-weight-bold">{{ $log->clinic->name }}</span>
                    @else
                      <span class="text-muted">&mdash;</span>
                    @endif
                  </td>
                  <td><code class="text-muted font-12">{{ $log->ip_address ?? '127.0.0.1' }}</code></td>
                </tr>
                @empty
                <tr>
                  <td colspan="6" class="text-center py-5 text-muted">No activity logs recorded yet.</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <div class="mt-4">
            {{ $logs->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
