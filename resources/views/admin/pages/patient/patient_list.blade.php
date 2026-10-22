@extends('admin.layouts.main')

@section('content')
<div class="content-wrapper p-3 p-md-4">
    <!-- Breadcrumb & Header Title Row -->
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
        <div>
            <div class="text-muted font-12 mb-1">
                <a href="{{ route('clinic.dashboard') }}" class="text-muted text-decoration-none">Dashboard</a>
                <span class="mx-1">/</span>
                <span class="text-dark font-weight-bold">Patient Bookings</span>
            </div>
            <h2 class="font-weight-bold text-dark mb-1" style="font-size: 24px;">Patient Bookings & Appointments</h2>
            <p class="text-muted font-13 mb-0">Manage clinic patient appointments, daily time slots, lead conversions, and doctor schedule.</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary btn-sm font-weight-bold px-3 py-2 d-flex align-items-center" onclick="window.print()" style="border-radius: 8px; border-color: #e2e8f0; background: #ffffff; color: #475569;">
                <i class="mdi mdi-download me-1 font-16"></i> Export Leads
            </button>
        </div>
    </div>

    <!-- Quick Filter Tabs Bar (Horizontal Pills with Count Badges Matching Screenshot) -->
    <div class="d-flex align-items-center flex-wrap gap-2 mb-3">
        <!-- All Leads -->
        <a href="{{ url('admin/patient') }}" class="quick-filter-pill {{ !request('timeframe') && !request('status') ? 'active-pill' : 'default-pill' }}">
            <span>All Bookings</span>
            <span class="pill-count">{{ $totalInquiries ?? 0 }}</span>
        </a>

        <!-- Today's Bookings -->
        <a href="{{ url('admin/patient?timeframe=today') }}" class="quick-filter-pill green-pill {{ request('timeframe') == 'today' ? 'active-pill' : '' }}">
            <span class="dot dot-green"></span>
            <span>Today's Bookings</span>
            <span class="pill-count count-green">{{ $todayBookings ?? 0 }}</span>
        </a>

        <!-- Tomorrow's Bookings -->
        <a href="{{ url('admin/patient?timeframe=tomorrow') }}" class="quick-filter-pill amber-pill {{ request('timeframe') == 'tomorrow' ? 'active-pill' : '' }}">
            <span class="dot dot-amber"></span>
            <span>Tomorrow's Bookings</span>
            <span class="pill-count count-amber">{{ $tomorrowBookings ?? 0 }}</span>
        </a>

        <!-- This Week -->
        <a href="{{ url('admin/patient?timeframe=week') }}" class="quick-filter-pill blue-pill {{ request('timeframe') == 'week' ? 'active-pill' : '' }}">
            <span>This Week</span>
            <span class="pill-count count-blue">{{ $weekBookings ?? 0 }}</span>
        </a>

        <!-- New Leads / Pending -->
        <a href="{{ url('admin/patient?status=pending') }}" class="quick-filter-pill cyan-pill {{ request('status') == 'pending' ? 'active-pill' : '' }}">
            <span>Pending Confirmation</span>
            <span class="pill-count count-cyan">{{ $newLeads ?? 0 }}</span>
        </a>

        <!-- Scheduled Ahead -->
        <a href="{{ url('admin/patient') }}" class="quick-filter-pill purple-pill">
            <span>Scheduled Ahead</span>
            <span class="pill-count count-purple">{{ $testRidesScheduled ?? 0 }}</span>
        </a>

        <!-- Booked & Confirmed -->
        <a href="{{ url('admin/patient?status=confirmed') }}" class="quick-filter-pill emerald-pill {{ request('status') == 'confirmed' ? 'active-pill' : '' }}">
            <span>Confirmed & Paid</span>
            <span class="pill-count count-emerald">{{ $bookedDelivered ?? 0 }}</span>
        </a>
    </div>

    <!-- Metrics Row (5 Minimalist Stat Cards Matching Reference Screenshot) -->
    <div class="row g-3 mb-4">
        <!-- Card 1: Total Inquiries -->
        <div class="col-xl col-md-4 col-sm-6">
            <div class="card border h-100 shadow-sm" style="background: #ffffff; border-radius: 14px; border-color: #f1f5f9 !important;">
                <div class="card-body p-3">
                    <span class="text-uppercase font-weight-bold font-11 text-muted" style="letter-spacing: 0.5px;">TOTAL INQUIRIES</span>
                    <h2 class="font-weight-bold text-dark my-1" style="font-size: 28px;">{{ $totalInquiries ?? 0 }}</h2>
                    <span class="text-muted font-11">Lifetime bookings</span>
                </div>
            </div>
        </div>

        <!-- Card 2: Today's Bookings -->
        <div class="col-xl col-md-4 col-sm-6">
            <div class="card border h-100 shadow-sm" style="background: #ffffff; border-radius: 14px; border-color: #f1f5f9 !important;">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="text-uppercase font-weight-bold font-11 text-muted" style="letter-spacing: 0.5px;">TODAY'S BOOKINGS</span>
                        <span class="dot dot-green"></span>
                    </div>
                    <h2 class="font-weight-bold text-dark my-1" style="font-size: 28px;">{{ $todayBookings ?? 0 }}</h2>
                    <span class="text-muted font-11">Consultations today</span>
                </div>
            </div>
        </div>

        <!-- Card 3: Tomorrow's Bookings -->
        <div class="col-xl col-md-4 col-sm-6">
            <div class="card border h-100 shadow-sm" style="background: #ffffff; border-radius: 14px; border-color: #f1f5f9 !important;">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="text-uppercase font-weight-bold font-11 text-muted" style="letter-spacing: 0.5px;">TOMORROW'S BOOKINGS</span>
                        <span class="dot dot-amber"></span>
                    </div>
                    <h2 class="font-weight-bold text-dark my-1" style="font-size: 28px;">{{ $tomorrowBookings ?? 0 }}</h2>
                    <span class="text-muted font-11">Scheduled tomorrow</span>
                </div>
            </div>
        </div>

        <!-- Card 4: Pending Leads -->
        <div class="col-xl col-md-4 col-sm-6">
            <div class="card border h-100 shadow-sm" style="background: #ffffff; border-radius: 14px; border-color: #f1f5f9 !important;">
                <div class="card-body p-3">
                    <span class="text-uppercase font-weight-bold font-11 text-primary" style="letter-spacing: 0.5px;">NEW LEADS</span>
                    <h2 class="font-weight-bold text-dark my-1" style="font-size: 28px;">{{ $newLeads ?? 0 }}</h2>
                    <span class="text-muted font-11">Awaiting confirmation</span>
                </div>
            </div>
        </div>

        <!-- Card 5: Confirmed Appointments -->
        <div class="col-xl col-md-4 col-sm-6">
            <div class="card border h-100 shadow-sm" style="background: #ffffff; border-radius: 14px; border-color: #f1f5f9 !important;">
                <div class="card-body p-3">
                    <span class="text-uppercase font-weight-bold font-11" style="letter-spacing: 0.5px; color: #7e22ce;">CONFIRMED VISITS</span>
                    <h2 class="font-weight-bold text-dark my-1" style="font-size: 28px;">{{ $bookedDelivered ?? 0 }}</h2>
                    <span class="text-muted font-11">Confirmed appointments</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Toolbar Box (Inputs & Dropdowns Matching Reference Screenshot) -->
    <div class="card border mb-4 shadow-sm" style="background: #ffffff; border-radius: 14px; border-color: #f1f5f9 !important;">
        <div class="card-body p-3">
            <form method="GET" action="{{ url('admin/patient') }}" id="filterForm">
                <div class="row g-2 align-items-center mb-3">
                    <!-- Search Input -->
                    <div class="col-lg-4 col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted" style="border-radius: 8px 0 0 8px; border-color: #e2e8f0;">
                                <i class="mdi mdi-magnify font-16"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0" placeholder="Search patient, phone, ref #, problem..." value="{{ request('search') }}" style="border-radius: 0 8px 8px 0; border-color: #e2e8f0; font-size: 13.5px;">
                        </div>
                    </div>

                    <!-- Timeframe Dropdown -->
                    <div class="col-lg-2 col-md-3">
                        <select name="timeframe" class="form-select" style="border-radius: 8px; border-color: #e2e8f0; font-size: 13px;">
                            <option value="">All Timeframes</option>
                            <option value="today" {{ request('timeframe') == 'today' ? 'selected' : '' }}>Today</option>
                            <option value="tomorrow" {{ request('timeframe') == 'tomorrow' ? 'selected' : '' }}>Tomorrow</option>
                            <option value="week" {{ request('timeframe') == 'week' ? 'selected' : '' }}>This Week</option>
                            <option value="month" {{ request('timeframe') == 'month' ? 'selected' : '' }}>This Month</option>
                        </select>
                    </div>

                    <!-- Consultation Type Dropdown -->
                    <div class="col-lg-2 col-md-3">
                        <select name="type" class="form-select" style="border-radius: 8px; border-color: #e2e8f0; font-size: 13px;">
                            <option value="">All Enquiry Types</option>
                            <option value="routine">Routine Consultation</option>
                            <option value="specialist">Specialist Consultation</option>
                            <option value="followup">Follow-up Visit</option>
                        </select>
                    </div>

                    <!-- Status Dropdown -->
                    <div class="col-lg-2 col-md-6">
                        <select name="status" class="form-select" style="border-radius: 8px; border-color: #e2e8f0; font-size: 13px;">
                            <option value="">All Lead Statuses</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed & Paid</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Booking Pending</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <!-- Staff / Doctor Dropdown -->
                    <div class="col-lg-2 col-md-6">
                        <select name="staff" class="form-select" style="border-radius: 8px; border-color: #e2e8f0; font-size: 13px;">
                            <option value="">All Staff</option>
                            <option value="doctor">Lead Doctor</option>
                            <option value="unassigned">Unassigned</option>
                        </select>
                    </div>
                </div>

                <!-- Row 2: Specific Date & Action Buttons -->
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 pt-2 border-top">
                    <div class="d-flex align-items-center gap-2">
                        <span class="text-muted font-13 font-weight-bold">Specific Date:</span>
                        <input type="date" name="specific_date" class="form-control form-control-sm" value="{{ request('specific_date') }}" style="width: 170px; border-radius: 8px; border-color: #e2e8f0; font-size: 13px;">
                        @if(request()->anyFilled(['search', 'timeframe', 'status', 'specific_date', 'type', 'staff']))
                        <a href="{{ url('admin/patient') }}" class="btn btn-sm btn-link text-danger font-12 text-decoration-none ms-1">
                            <i class="mdi mdi-close"></i> Reset
                        </a>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-dark btn-sm font-weight-bold px-4 py-2" style="background: #0f172a; border-radius: 8px; font-size: 13px;">
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table Card Matching Screenshot Table Styling -->
    <div class="card border shadow-sm mb-4" style="background: #ffffff; border-radius: 16px; border-color: #f1f5f9 !important;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="patientTable">
                    <thead style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                        <tr>
                            <th style="width: 40px;" class="ps-4">
                                <input type="checkbox" class="form-check-input" id="selectAllCheckbox" style="cursor: pointer;">
                            </th>
                            <th style="font-size: 11px; font-weight: 700; color: #64748b; letter-spacing: 0.5px;">REF #</th>
                            <th style="font-size: 11px; font-weight: 700; color: #64748b; letter-spacing: 0.5px;">CUSTOMER DETAILS</th>
                            <th style="font-size: 11px; font-weight: 700; color: #64748b; letter-spacing: 0.5px;">TYPE</th>
                            <th style="font-size: 11px; font-weight: 700; color: #64748b; letter-spacing: 0.5px;">PROBLEM / COMPLAINT</th>
                            <th style="font-size: 11px; font-weight: 700; color: #64748b; letter-spacing: 0.5px;">BOOKING / SLOT DATE</th>
                            <th style="font-size: 11px; font-weight: 700; color: #64748b; letter-spacing: 0.5px;">STATUS</th>
                            <th style="font-size: 11px; font-weight: 700; color: #64748b; letter-spacing: 0.5px;">ASSIGNED STAFF</th>
                            <th style="font-size: 11px; font-weight: 700; color: #64748b; letter-spacing: 0.5px;" class="text-end pe-4">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        @php
                            $bookingDate = $order->booking_date ? \Carbon\Carbon::parse($order->booking_date) : null;
                            $isToday = $bookingDate && $bookingDate->isToday();
                            $isTomorrow = $bookingDate && $bookingDate->isTomorrow();
                            $cleanPhone = preg_replace('/[^0-9]/', '', $order->mobile_no ?? '');
                            $refCode = 'ENO-' . ($bookingDate ? $bookingDate->format('Ymd') : date('Ymd', strtotime($order->created_at))) . '-' . strtoupper(substr(md5($order->id), 0, 4));
                        @endphp
                        <tr>
                            <td class="ps-4">
                                <input type="checkbox" class="form-check-input row-checkbox" value="{{ $order->id }}" style="cursor: pointer;">
                            </td>

                            <!-- REF # -->
                            <td>
                                <div class="font-weight-bold" style="color: var(--theme-primary, #059669); font-size: 12.5px;">
                                    {{ $refCode }}
                                </div>
                                <div class="text-muted" style="font-size: 10.5px;">
                                    {{ date('M d, Y h:i A', strtotime($order->created_at)) }}
                                </div>
                            </td>

                            <!-- CUSTOMER DETAILS -->
                            <td>
                                <div class="font-weight-bold text-dark font-13">
                                    {{ $order->first_name }} {{ $order->last_name }}
                                </div>
                                <div class="font-12 text-muted d-flex align-items-center gap-1 mt-1">
                                    <span>{{ $order->mobile_no }}</span>
                                    @if($cleanPhone)
                                    <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" class="badge bg-success bg-opacity-10 text-success rounded-pill font-10 px-2 py-0 text-decoration-none">
                                        <i class="mdi mdi-whatsapp"></i> WA
                                    </a>
                                    @endif
                                </div>
                                @if($order->customer_email)
                                <div class="text-muted font-11 text-truncate" style="max-width: 180px;">
                                    &bull; {{ $order->customer_email }}
                                </div>
                                @endif
                            </td>

                            <!-- TYPE -->
                            <td>
                                <span class="badge px-3 py-1 font-weight-bold rounded-pill" style="background: #ecfdf5; color: #065f46; font-size: 11px; border: 1px solid #a7f3d0;">
                                    Consultation
                                </span>
                            </td>

                            <!-- PROBLEM / COMPLAINT -->
                            <td>
                                <div class="d-flex align-items-center" style="gap: 8px;">
                                    <div style="width: 28px; height: 28px; border-radius: 8px; background: #f1f5f9; color: #475569; display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0;">
                                        <i class="mdi mdi-stethoscope"></i>
                                    </div>
                                    <div class="text-truncate font-12 text-dark font-weight-500" style="max-width: 220px;" title="{{ $order->patient_problem }}">
                                        {{ $order->patient_problem ?? 'General Health Consultation' }}
                                    </div>
                                </div>
                            </td>

                            <!-- BOOKING / SLOT DATE -->
                            <td>
                                @if($isTomorrow)
                                <span class="badge px-2 py-1 font-weight-bold rounded-pill" style="background: #fffbeb; color: #b45309; border: 1px solid #fde68a; font-size: 11px;">
                                    &bull; TOMORROW - {{ $order->from_time ?? 'All Day' }}
                                </span>
                                @elseif($isToday)
                                <span class="badge px-2 py-1 font-weight-bold rounded-pill" style="background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; font-size: 11px;">
                                    &bull; TODAY - {{ $order->from_time ?? 'All Day' }}
                                </span>
                                @else
                                <div class="text-dark font-12 font-weight-500">
                                    {{ $bookingDate ? $bookingDate->format('M d, Y') : date('M d, Y', strtotime($order->created_at)) }}
                                </div>
                                <div class="text-muted font-11">
                                    {{ $order->from_time ? date('h:i A', strtotime($order->from_time)) : 'Scheduled' }}
                                </div>
                                @endif
                            </td>

                            <!-- STATUS -->
                            <td>
                                @if($order->payment_status === 'paid' || $order->payment_status === 'success' || $order->payment_status === 'captured')
                                <span class="badge px-2 py-1 font-weight-bold rounded-pill" style="background: #d1fae5; color: #047857; font-size: 11px;">
                                    Confirmed & Paid
                                </span>
                                @elseif($order->payment_status === 'cancelled')
                                <span class="badge px-2 py-1 font-weight-bold rounded-pill" style="background: #fee2e2; color: #b91c1c; font-size: 11px;">
                                    Cancelled
                                </span>
                                @else
                                <span class="badge px-2 py-1 font-weight-bold rounded-pill" style="background: #fef3c7; color: #b45309; font-size: 11px;">
                                    Booking Pending
                                </span>
                                @endif
                            </td>

                            <!-- ASSIGNED STAFF -->
                            <td>
                                <span class="fst-italic text-muted font-12">
                                    Dr. {{ Auth::user()->name ?? 'Doctor' }}
                                </span>
                            </td>

                            <!-- ACTIONS -->
                            <td class="text-end pe-4">
                                <div class="d-inline-flex align-items-center gap-1">
                                    <a href="{{ url('admin/booking-history/view/'.$order->id) }}" class="btn btn-outline-secondary btn-sm font-weight-bold" style="border-radius: 6px; padding: 4px 10px; font-size: 11.5px; border-color: #e2e8f0; color: #334155;">
                                        <i class="mdi mdi-eye-outline me-1"></i> Details
                                    </a>
                                    <a href="{{ url('admin/patient-history/status-change/'.$order->id) }}" class="btn btn-dark btn-sm font-weight-bold" style="background: #0f172a; border-radius: 6px; padding: 4px 12px; font-size: 11.5px; color: #ffffff;">
                                        Manage <i class="mdi mdi-chevron-down ms-1"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <div class="py-4">
                                    <i class="mdi mdi-clipboard-text-search-outline font-48 d-block mb-2 text-muted"></i>
                                    <h6 class="font-weight-bold text-dark">No Patient Bookings Found</h6>
                                    <p class="font-13 text-muted mb-3">No appointments match your search criteria or filter range.</p>
                                    <a href="{{ url('admin/patient') }}" class="btn btn-outline-secondary btn-sm font-weight-bold px-3">
                                        Clear All Filters
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Server-Side Pagination Bar -->
        <div class="card-footer bg-white border-top d-flex align-items-center justify-content-between flex-wrap gap-3 py-3 px-4" style="border-radius: 0 0 16px 16px;">
            <div class="d-flex align-items-center gap-2 text-muted font-13">
                <span>Showing <strong>{{ $orders->firstItem() ?? 0 }}</strong> to <strong>{{ $orders->lastItem() ?? 0 }}</strong> of <strong>{{ $orders->total() }}</strong> entries</span>
                <span class="mx-1">&bull;</span>
                <div class="d-flex align-items-center gap-1">
                    <span>Show</span>
                    <select class="form-select form-select-sm d-inline-block w-auto" onchange="window.location.href = updatePerPage(this.value)" style="border-radius: 6px; font-size: 12px; padding: 2px 24px 2px 8px; border-color: #cbd5e1;">
                        <option value="10" {{ ($perPage ?? 10) == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ ($perPage ?? 10) == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ ($perPage ?? 10) == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ ($perPage ?? 10) == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    <span>per page</span>
                </div>
            </div>

            <div class="server-pagination">
                {{ $orders->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<script>
function updatePerPage(val) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', val);
    url.searchParams.set('page', 1);
    return url.href;
}

document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('selectAllCheckbox');
    const checkboxes = document.querySelectorAll('.row-checkbox');
    
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            checkboxes.forEach(cb => cb.checked = selectAll.checked);
        });
    }
});
</script>
@endsection
