@extends('admin.layouts.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 class="mb-0 fw-bold text-dark"><i class="mdi mdi-credit-card-outline me-1 text-primary"></i> {{ $title }}</h5>
            <small class="text-muted">Real-time logs of all online appointment payments, Razorpay transactions, and booking statuses.</small>
        </div>
    </div>

    <!-- KPI Statistic Cards -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm" style="border-left: 4px solid #28a745 !important;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted d-block small text-uppercase fw-bold">Total Revenue</span>
                            <h4 class="mb-0 fw-bold text-success">₹ {{ number_format($total_revenue, 2) }}</h4>
                        </div>
                        <div class="p-2 bg-light rounded text-success">
                            <i class="mdi mdi-currency-inr mdi-24px"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm" style="border-left: 4px solid #198754 !important;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted d-block small text-uppercase fw-bold">Success Payments</span>
                            <h4 class="mb-0 fw-bold text-success">{{ $success_count }}</h4>
                        </div>
                        <div class="p-2 bg-light rounded text-success">
                            <i class="mdi mdi-check-circle-outline mdi-24px"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm" style="border-left: 4px solid #dc3545 !important;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted d-block small text-uppercase fw-bold">Failed / Cancelled</span>
                            <h4 class="mb-0 fw-bold text-danger">{{ $failed_count }}</h4>
                        </div>
                        <div class="p-2 bg-light rounded text-danger">
                            <i class="mdi mdi-close-circle-outline mdi-24px"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="card border-0 shadow-sm" style="border-left: 4px solid #0d6efd !important;">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted d-block small text-uppercase fw-bold">Total Transactions</span>
                            <h4 class="mb-0 fw-bold text-primary">{{ $total_count }}</h4>
                        </div>
                        <div class="p-2 bg-light rounded text-primary">
                            <i class="mdi mdi-swap-horizontal-bold mdi-24px"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <form action="{{ url('admin/payments') }}" method="GET" class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small fw-bold mb-1">Payment Status</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="all" {{ $selected_status == 'all' ? 'selected' : '' }}>All Statuses</option>
                        <option value="success" {{ $selected_status == 'success' ? 'selected' : '' }}>Success</option>
                        <option value="cancelled" {{ $selected_status == 'cancelled' ? 'selected' : '' }}>Payment Cancelled</option>
                        <option value="failed" {{ $selected_status == 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="pending" {{ $selected_status == 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold mb-1">From Date</label>
                    <input type="date" name="from_date" class="form-control form-control-sm" value="{{ $from_date }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold mb-1">To Date</label>
                    <input type="date" name="to_date" class="form-control form-control-sm" value="{{ $to_date }}">
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm flex-grow-1"><i class="mdi mdi-filter-variant me-1"></i> Filter</button>
                    <a href="{{ url('admin/payments') }}" class="btn btn-outline-secondary btn-sm" title="Reset Filters"><i class="mdi mdi-refresh"></i></a>
                </div>
            </form>
        </div>
    </div>

    <!-- Payments Data Table -->
    <div class="card border-0 shadow-sm p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 w-100" id="payments_table">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">Sl</th>
                        <th>Transaction Date</th>
                        <th>Patient Info</th>
                        <th>Booking Slot</th>
                        <th>Amount</th>
                        <th>Razorpay Details</th>
                        <th>Status</th>
                        <th class="text-center" style="width: 150px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $key => $item)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</div>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($item->created_at)->format('h:i A') }}</small>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $item->first_name ? $item->first_name . ' ' . $item->last_name : 'N/A' }}</div>
                                <small class="text-muted d-block"><i class="mdi mdi-phone me-1"></i>{{ $item->mobile_no ?? 'N/A' }}</small>
                            </td>
                            <td>
                                <div><i class="mdi mdi-calendar-clock text-primary me-1"></i>{{ $item->booking_date ? \Carbon\Carbon::parse($item->booking_date)->format('d M Y') : 'N/A' }}</div>
                                <small class="text-muted">
                                    @if ($item->from_time && $item->to_time)
                                        {{ \Carbon\Carbon::parse($item->from_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($item->to_time)->format('h:i A') }}
                                    @else
                                        Slot #{{ $item->time_slot_id }}
                                    @endif
                                </small>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">₹ {{ number_format($item->total_amount, 2) }}</div>
                                @if($item->actual_amount && $item->actual_amount != $item->total_amount)
                                    <small class="text-muted">(Fee: ₹{{ $item->actual_amount }})</small>
                                @endif
                            </td>
                            <td>
                                @if ($item->razorpay_payment_id)
                                    <div class="small fw-semibold text-primary"><i class="mdi mdi-check-decagram me-1"></i>{{ $item->razorpay_payment_id }}</div>
                                @endif
                                @if ($item->transaction_id)
                                    <small class="text-muted d-block">Order: {{ $item->transaction_id }}</small>
                                @else
                                    <small class="text-muted">N/A</small>
                                @endif
                            </td>
                            <td>
                                @if ($item->payment_status == 'success')
                                    <span class="badge bg-success px-2 py-1"><i class="mdi mdi-check me-1"></i>Success</span>
                                @elseif ($item->payment_status == 'cancelled')
                                    <span class="badge bg-warning text-dark px-2 py-1"><i class="mdi mdi-cancel me-1"></i>Payment Cancelled</span>
                                @elseif ($item->payment_status == 'failed')
                                    <span class="badge bg-danger px-2 py-1"><i class="mdi mdi-alert-circle me-1"></i>Failed</span>
                                @else
                                    <span class="badge bg-secondary px-2 py-1">{{ ucfirst($item->payment_status ?? 'Pending') }}</span>
                                @endif
                            </td>
                            <td class="text-center text-nowrap">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-primary btn-sm" onclick="showLogDetails({{ json_encode($item) }})" title="View Log Details">
                                        <i class="mdi mdi-eye me-1"></i> View
                                    </button>
                                    @if($item->payment_status == 'success')
                                        <a href="{{ url('invoice/' . $item->id) }}?from=admin" target="_blank" class="btn btn-outline-success btn-sm" title="View Invoice">
                                            <i class="mdi mdi-file-document-outline me-1"></i> Invoice
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Detailed Payment Log Modal -->
<div class="modal fade" id="paymentDetailsModal" tabindex="-1" aria-labelledby="paymentDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white fw-bold" id="paymentDetailsModalLabel">
                    <i class="mdi mdi-file-document-outline me-1"></i> Payment Transaction Log Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="paymentDetailsContent">
                <!-- Injected via JavaScript -->
            </div>
            <div class="modal-footer bg-light" id="paymentDetailsModalFooter">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#payments_table').DataTable({
            "pageLength": 10,
            "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
            "order": [[0, "asc"]],
            "responsive": true,
            "language": {
                "search": "_INPUT_",
                "searchPlaceholder": "Search logs...",
                "lengthMenu": "Show _MENU_ entries per page",
                "paginate": {
                    "previous": "<i class='mdi mdi-chevron-left'></i>",
                    "next": "<i class='mdi mdi-chevron-right'></i>"
                }
            }
        });
    });

    function showLogDetails(order) {
        let statusBadge = '';
        if (order.payment_status === 'success') {
            statusBadge = '<span class="badge bg-success px-3 py-1"><i class="mdi mdi-check me-1"></i>Success</span>';
        } else if (order.payment_status === 'cancelled') {
            statusBadge = '<span class="badge bg-warning text-dark px-3 py-1"><i class="mdi mdi-cancel me-1"></i>Payment Cancelled</span>';
        } else if (order.payment_status === 'failed') {
            statusBadge = '<span class="badge bg-danger px-3 py-1"><i class="mdi mdi-alert-circle me-1"></i>Failed</span>';
        } else {
            statusBadge = '<span class="badge bg-secondary px-3 py-1">' + (order.payment_status || 'Pending') + '</span>';
        }

        let slotInfo = 'N/A';
        if (order.from_time && order.to_time) {
            slotInfo = order.from_time + ' - ' + order.to_time;
        } else if (order.time_slot_id) {
            slotInfo = 'Time Slot #' + order.time_slot_id;
        }

        let patientName = (order.first_name ? order.first_name + ' ' + (order.last_name || '') : 'N/A');

        let html = `
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <h6 class="fw-bold text-primary mb-3"><i class="mdi mdi-cash-multiple me-1"></i> Payment Summary</h6>
                        <table class="table table-sm table-borderless mb-0">
                            <tr><td class="text-muted" style="width: 45%;">Payment Status:</td><td>${statusBadge}</td></tr>
                            <tr><td class="text-muted">Total Amount:</td><td class="fw-bold text-success fs-6">₹ ${parseFloat(order.total_amount || 0).toFixed(2)}</td></tr>
                            <tr><td class="text-muted">Consultation Fee:</td><td>₹ ${parseFloat(order.actual_amount || 0).toFixed(2)}</td></tr>
                            <tr><td class="text-muted">Razorpay Payment ID:</td><td class="text-break fw-semibold">${order.razorpay_payment_id || '<span class="text-muted">N/A</span>'}</td></tr>
                            <tr><td class="text-muted">Razorpay Order ID:</td><td class="text-break">${order.transaction_id || '<span class="text-muted">N/A</span>'}</td></tr>
                            <tr><td class="text-muted">Created At:</td><td>${order.created_at || 'N/A'}</td></tr>
                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <h6 class="fw-bold text-primary mb-3"><i class="mdi mdi-account me-1"></i> Patient & Slot Info</h6>
                        <table class="table table-sm table-borderless mb-0">
                            <tr><td class="text-muted" style="width: 45%;">Patient Name:</td><td class="fw-bold">${patientName}</td></tr>
                            <tr><td class="text-muted">Mobile Number:</td><td>${order.mobile_no || 'N/A'}</td></tr>
                            <tr><td class="text-muted">Alternate Mobile:</td><td>${order.alternate_mobile_no || 'N/A'}</td></tr>
                            <tr><td class="text-muted">Gender / Age:</td><td>${(order.sex || 'N/A')} / ${(order.age ? order.age + ' yrs' : 'N/A')}</td></tr>
                            <tr><td class="text-muted">Booking Date:</td><td class="fw-semibold text-primary">${order.booking_date || 'N/A'}</td></tr>
                            <tr><td class="text-muted">Time Slot:</td><td>${slotInfo}</td></tr>
                        </table>
                    </div>
                </div>
                <div class="col-12">
                    <div class="p-3 bg-light rounded">
                        <h6 class="fw-bold text-primary mb-2"><i class="mdi mdi-map-marker me-1"></i> Address & Medical Complaint</h6>
                        <p class="mb-1"><strong>Address:</strong> ${order.address || 'N/A'}</p>
                        <p class="mb-0"><strong>Patient Problem / Symptoms:</strong> ${order.patient_problem || 'N/A'}</p>
                    </div>
                </div>
            </div>
        `;

        document.getElementById('paymentDetailsContent').innerHTML = html;

        let footerHtml = '';
        if (order.payment_status === 'success') {
            footerHtml += `<a href="{{ url('invoice') }}/${order.id}?from=admin" target="_blank" class="btn btn-success btn-sm me-auto"><i class="mdi mdi-file-document-outline me-1"></i> View Invoice</a>`;
        }
        footerHtml += `<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>`;
        document.getElementById('paymentDetailsModalFooter').innerHTML = footerHtml;

        let modal = new bootstrap.Modal(document.getElementById('paymentDetailsModal'));
        modal.show();
    }
</script>
@endsection

