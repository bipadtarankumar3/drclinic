@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper">
  <!-- Page Header -->
  <div class="d-flex align-items-center justify-content-between flex-wrap mb-4" style="gap: 12px;">
    <div>
      <h3 class="font-weight-bold text-dark mb-1">
        <i class="mdi mdi-email-open-multiple-outline text-primary mr-2"></i> Patient Contact Inquiries
      </h3>
      <p class="text-muted font-14 mb-0">Messages and queries submitted by patients via your clinic's Contact Us page.</p>
    </div>
    <div>
      <span class="badge bg-primary px-3 py-2 rounded-pill font-weight-bold" style="font-size: 13px;">
        {{ $unreadCount }} Unread {{ Str::plural('Inquiry', $unreadCount) }}
      </span>
    </div>
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3 p-3 mb-4 shadow-sm" role="alert">
      <i class="mdi mdi-check-circle me-2"></i> {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <!-- Filters & Search -->
  <div class="card border-0 shadow-sm rounded-4 mb-4" style="border-radius: 14px;">
    <div class="card-body p-3">
      <form action="{{ route('clinic.inquiries.index') }}" method="GET" class="row g-2 align-items-center">
        <div class="col-md-5">
          <div class="input-group">
            <span class="input-group-text bg-white border-end-0 text-muted"><i class="mdi mdi-magnify"></i></span>
            <input type="text" name="search" class="form-control border-start-0" placeholder="Search by patient name, email, phone, or subject..." value="{{ request('search') }}">
          </div>
        </div>
        <div class="col-md-3">
          <select name="status" class="form-select">
            <option value="">All Statuses</option>
            <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Unread</option>
            <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Read</option>
          </select>
        </div>
        <div class="col-md-4 d-flex gap-2">
          <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold rounded-3">
            <i class="mdi mdi-filter mr-1"></i> Filter
          </button>
          @if(request('search') || request('status'))
            <a href="{{ route('clinic.inquiries.index') }}" class="btn btn-outline-secondary px-3 py-2 rounded-3">
              Reset
            </a>
          @endif
        </div>
      </form>
    </div>
  </div>

  <!-- Inquiries Table Card -->
  <div class="card border-0 shadow-sm rounded-4" style="border-radius: 16px;">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
            <tr>
              <th class="ps-4 py-3 text-uppercase font-weight-bold" style="font-size: 12px; color: #64748b;">Status</th>
              <th class="py-3 text-uppercase font-weight-bold" style="font-size: 12px; color: #64748b;">Patient Name</th>
              <th class="py-3 text-uppercase font-weight-bold" style="font-size: 12px; color: #64748b;">Email & Phone</th>
              <th class="py-3 text-uppercase font-weight-bold" style="font-size: 12px; color: #64748b;">Subject</th>
              <th class="py-3 text-uppercase font-weight-bold" style="font-size: 12px; color: #64748b;">Date Received</th>
              <th class="pe-4 py-3 text-uppercase font-weight-bold text-end" style="font-size: 12px; color: #64748b;">Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($inquiries as $inq)
              <tr class="{{ $inq->status === 'unread' ? 'fw-bold' : '' }}" style="{{ $inq->status === 'unread' ? 'background: rgba(13, 148, 136, 0.04);' : '' }}">
                <td class="ps-4">
                  @if($inq->status === 'unread')
                    <span class="badge bg-danger text-white rounded-pill px-2 py-1" style="font-size: 11px;">
                      <i class="mdi mdi-email-alert-outline me-1"></i> New
                    </span>
                  @else
                    <span class="badge bg-light text-muted border rounded-pill px-2 py-1" style="font-size: 11px;">
                      <i class="mdi mdi-email-check-outline me-1"></i> Read
                    </span>
                  @endif
                </td>
                <td>
                  <div class="font-weight-bold text-dark" style="font-size: 14.5px;">{{ $inq->name }}</div>
                  <small class="text-muted font-12">#INQ-{{ str_pad($inq->id, 5, '0', STR_PAD_LEFT) }}</small>
                </td>
                <td>
                  <div><a href="mailto:{{ $inq->email }}" class="text-primary text-decoration-none" style="font-size: 13.5px;"><i class="mdi mdi-email-outline me-1"></i>{{ $inq->email }}</a></div>
                  @if($inq->phone)
                    <div><a href="tel:{{ $inq->phone }}" class="text-muted text-decoration-none font-12"><i class="mdi mdi-phone-outline me-1"></i>{{ $inq->phone }}</a></div>
                  @endif
                </td>
                <td>
                  <div class="text-dark" style="font-size: 14px; max-width: 260px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    {{ $inq->subject ?: 'General Inquiry' }}
                  </div>
                  <small class="text-muted font-12" style="max-width: 260px; display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                    {{ Str::limit($inq->message, 45) }}
                  </small>
                </td>
                <td>
                  <span class="text-muted" style="font-size: 13px;">{{ $inq->created_at->format('d M Y, h:i A') }}</span>
                  <div class="text-muted small font-11">({{ $inq->created_at->diffForHumans() }})</div>
                </td>
                <td class="pe-4 text-end">
                  <div class="d-inline-flex gap-2">
                    <a href="{{ route('clinic.inquiries.show', $inq->id) }}" class="btn btn-sm btn-outline-primary rounded-3 px-3">
                      <i class="mdi mdi-eye-outline me-1"></i> View
                    </a>
                    <form action="{{ route('clinic.inquiries.destroy', $inq->id) }}" method="POST" onsubmit="return confirm('Delete this inquiry?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 px-2" title="Delete">
                        <i class="mdi mdi-trash-can-outline"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center py-5">
                  <div class="text-muted">
                    <i class="mdi mdi-email-outline mb-3" style="font-size: 48px; color: #cbd5e1; display: block;"></i>
                    <h5 class="font-weight-bold text-dark mb-1">No Inquiries Found</h5>
                    <p class="font-14 mb-0">Messages submitted by patients from your clinic's Contact Us page will appear here.</p>
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      @if($inquiries->hasPages())
        <div class="p-3 border-top">
          {{ $inquiries->links() }}
        </div>
      @endif
    </div>
  </div>
</div>
@endsection
