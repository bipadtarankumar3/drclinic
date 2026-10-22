@extends('admin.layouts.main')

@section('style')
<style>
.patient-filter-card {
  border-radius: 16px;
  border: 1.5px solid #e2e8f0;
  background: #ffffff;
  box-shadow: 0 2px 10px rgba(15, 23, 42, 0.03);
}
.patient-table-card {
  border-radius: 16px;
  border: 1.5px solid #e2e8f0;
  background: #ffffff;
  box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
  overflow: hidden;
}
.filter-label {
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: #64748b;
  margin-bottom: 6px;
  display: block;
}
.patient-avatar-sm {
  width: 36px;
  height: 36px;
  border-radius: 10px;
  background: var(--theme-primary-gradient, linear-gradient(135deg, #059669, #10b981));
  color: #ffffff;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 13px;
  flex-shrink: 0;
  box-shadow: 0 2px 6px var(--theme-primary-glow, rgba(5, 150, 105, 0.25));
}
.gender-badge-male {
  background: #eff6ff;
  color: #1e40af;
  border: 1px solid #bfdbfe;
  font-weight: 600;
  font-size: 11px;
  padding: 3px 8px;
  border-radius: 6px;
}
.gender-badge-female {
  background: #fdf2f8;
  color: #9d174d;
  border: 1px solid #fbcfe8;
  font-weight: 600;
  font-size: 11px;
  padding: 3px 8px;
  border-radius: 6px;
}
.gender-badge-other {
  background: #f1f5f9;
  color: #475569;
  border: 1px solid #cbd5e1;
  font-weight: 600;
  font-size: 11px;
  padding: 3px 8px;
  border-radius: 6px;
}
</style>
@endsection

@section('content')
<div class="container-fluid p-3 p-md-4">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center shadow-sm" style="width: 44px; height: 44px; border-radius: 12px; background: var(--theme-primary-gradient, linear-gradient(135deg, #059669, #10b981)); color: #ffffff; font-size: 22px;">
                <i class="mdi mdi-folder-account-outline"></i>
            </div>
            <div>
                <h3 class="fw-bold text-dark mb-0 font-20">Patient Master Records</h3>
                <p class="text-muted mb-0 font-13">View registered patient accounts, previous consultations, and patient history.</p>
            </div>
        </div>
        <div>
            <a href="{{ url('admin/patient') }}" class="btn btn-outline-primary btn-sm font-weight-bold px-3 py-2 shadow-sm d-inline-flex align-items-center gap-1" style="border-radius: 8px;">
                <i class="mdi mdi-calendar-today font-16"></i> Today's Appointments
            </a>
        </div>
    </div>

    <!-- Multi-Type Filter Card -->
    <div class="patient-filter-card p-4 mb-4">
        <div class="d-flex align-items-center justify-content-between pb-3 mb-3 border-bottom" style="border-color: #f1f5f9 !important;">
            <div class="d-flex align-items-center gap-2">
                <i class="mdi mdi-filter-variant font-18" style="color: var(--theme-primary, #059669);"></i>
                <h5 class="fw-bold text-dark mb-0 font-14">Filter Patient Records</h5>
            </div>
            @if(request()->anyFilled(['patient_id', 'search', 'mobile_no', 'gender', 'from_date', 'to_date']))
            <a href="{{ url('admin/history_of_customer') }}" class="btn btn-xs btn-outline-danger font-weight-bold px-2 py-1 rounded-pill" style="font-size: 11.5px;">
                <i class="mdi mdi-close-circle-outline mr-1"></i> Clear Filters
            </a>
            @endif
        </div>

        <form action="{{ url('admin/history_of_customer') }}" method="GET">
            <div class="row g-3">
                <!-- 1. Patient Dropdown Filter -->
                <div class="col-md-3 col-sm-6">
                    <label class="filter-label">Patient</label>
                    <select name="patient_id" class="form-select form-control" style="border-radius: 8px; font-size: 13.5px; height: 42px;">
                        <option value="">All Patients ({{ count($patients) }})</option>
                        @foreach ($patients as $patient)
                            @php
                                $pFullName = trim(($patient->first_name ?? '') . ' ' . ($patient->last_name ?? ''));
                            @endphp
                            <option value="{{ $patient->id }}" {{ request('patient_id') == $patient->id ? 'selected' : '' }}>
                                {{ $pFullName ?: 'Patient #'.$patient->id }} {{ $patient->mobile_no ? '('.$patient->mobile_no.')' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- 2. Search by Name / Problem -->
                <div class="col-md-3 col-sm-6">
                    <label class="filter-label">Search Name / Problem</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0" style="border-radius: 8px 0 0 8px;">
                            <i class="mdi mdi-magnify text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" name="search" placeholder="e.g. Rajesh, Headache..." value="{{ request('search') }}" style="border-radius: 0 8px 8px 0; font-size: 13.5px; height: 42px;">
                    </div>
                </div>

                <!-- 3. Filter by Mobile Number -->
                <div class="col-md-2 col-sm-6">
                    <label class="filter-label">Mobile Number</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0" style="border-radius: 8px 0 0 8px;">
                            <i class="mdi mdi-phone-outline text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" name="mobile_no" placeholder="e.g. 983344..." value="{{ request('mobile_no') }}" style="border-radius: 0 8px 8px 0; font-size: 13.5px; height: 42px;">
                    </div>
                </div>

                <!-- 4. Filter by Gender -->
                <div class="col-md-2 col-sm-6">
                    <label class="filter-label">Gender</label>
                    <select name="gender" class="form-select form-control" style="border-radius: 8px; font-size: 13.5px; height: 42px;">
                        <option value="">All Genders</option>
                        <option value="male" {{ strtolower(request('gender')) === 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ strtolower(request('gender')) === 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ strtolower(request('gender')) === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <!-- 5. From Date -->
                <div class="col-md-2 col-sm-6">
                    <label class="filter-label">From Date</label>
                    <input type="date" class="form-control" name="from_date" value="{{ request('from_date') }}" style="border-radius: 8px; font-size: 13px; height: 42px;">
                </div>

                <!-- 6. To Date & Actions -->
                <div class="col-md-2 col-sm-6">
                    <label class="filter-label">To Date</label>
                    <input type="date" class="form-control" name="to_date" value="{{ request('to_date') }}" style="border-radius: 8px; font-size: 13px; height: 42px;">
                </div>

                <div class="col-md-10 col-12 d-flex align-items-end justify-content-end">
                    <div class="form-actions-end mt-0" style="margin-top: 0;">
                        <a href="{{ url('admin/history_of_customer') }}" class="btn btn-light px-3 py-2 font-weight-bold" style="border: 1px solid #cbd5e1; border-radius: 8px; height: 42px; display: inline-flex; align-items: center;">
                            Reset
                        </a>
                        <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold" style="border-radius: 8px; height: 42px; display: inline-flex; align-items: center;">
                            <i class="mdi mdi-filter-check-outline me-1"></i> Apply Filters
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Data Table Card -->
    <div class="patient-table-card">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover align-middle mb-0" id="patient_history">
                <thead style="background: #f8fafc; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; border-bottom: 1px solid #e2e8f0;">
                    <tr>
                        <th class="py-3 px-3">SL</th>
                        <th class="py-3 px-3">CREATED AT</th>
                        <th class="py-3 px-3">PATIENT</th>
                        <th class="py-3 px-3">DOB</th>
                        <th class="py-3 px-3">GENDER</th>
                        <th class="py-3 px-3">AGE</th>
                        <th class="py-3 px-3">MOBILE NO</th>
                        <th class="py-3 px-3">ALTERNATE NO</th>
                        <th class="py-3 px-3">PERMANENT ADDRESS</th>
                        <th class="py-3 px-3">PATIENT PROBLEM</th>
                        <th class="py-3 px-3 text-end">ACTION</th>
                    </tr>
                </thead>
                <tbody style="font-size: 13px;">
                    @forelse($patients_lists as $key => $order)
                    @php
                        $pName = trim(($order->first_name ?? '') . ' ' . ($order->last_name ?? ''));
                        $initials = strtoupper(substr($order->first_name ?? 'P', 0, 1) . substr($order->last_name ?? 'T', 0, 1));
                        $cleanMobile = preg_replace('/[^0-9]/', '', $order->mobile_no ?? '');
                        $genderLower = strtolower($order->sex ?? '');
                    @endphp
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td class="py-3 px-3 text-muted font-12">{{ $patients_lists->firstItem() + $key }}</td>
                        <td class="py-3 px-3 text-nowrap text-muted font-12">
                            {{ $order->created_at ? \Carbon\Carbon::parse($order->created_at)->format('d M Y, h:i A') : '-' }}
                        </td>

                        <!-- Patient Name with Initials Avatar -->
                        <td class="py-3 px-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="patient-avatar-sm">
                                    {{ $initials }}
                                </div>
                                <div>
                                    <a href="{{ url('admin/patient-history/view/'.$order->id) }}" class="fw-bold text-dark text-decoration-none d-block">
                                        {{ $pName ?: 'Patient #'.$order->id }}
                                    </a>
                                    <span class="text-muted font-11">#PID-{{ $order->id }}</span>
                                </div>
                            </div>
                        </td>

                        <!-- DOB -->
                        <td class="py-3 px-3 text-nowrap">
                            {{ $order->dob ? \Carbon\Carbon::parse($order->dob)->format('d/m/Y') : '-' }}
                        </td>

                        <!-- Gender Badge -->
                        <td class="py-3 px-3">
                            @if($genderLower === 'male')
                                <span class="gender-badge-male"><i class="mdi mdi-gender-male mr-1"></i> Male</span>
                            @elseif($genderLower === 'female')
                                <span class="gender-badge-female"><i class="mdi mdi-gender-female mr-1"></i> Female</span>
                            @else
                                <span class="gender-badge-other">{{ ucfirst($order->sex ?? 'N/A') }}</span>
                            @endif
                        </td>

                        <!-- Age -->
                        <td class="py-3 px-3 font-weight-bold text-dark">
                            {{ $order->age ? $order->age.' Yrs' : '-' }}
                        </td>

                        <!-- Mobile No with Quick Link -->
                        <td class="py-3 px-3">
                            <div class="d-flex align-items-center gap-1">
                                <span class="font-weight-bold text-dark font-monospace">{{ $order->mobile_no ?? '-' }}</span>
                                @if($cleanMobile)
                                <a href="https://wa.me/{{ $cleanMobile }}" target="_blank" class="text-success ms-1" title="Chat on WhatsApp">
                                    <i class="mdi mdi-whatsapp font-16"></i>
                                </a>
                                @endif
                            </div>
                        </td>

                        <!-- Alternate Mobile -->
                        <td class="py-3 px-3 text-muted">
                            {{ $order->alternate_mobile_no ?: '-' }}
                        </td>

                        <!-- Address -->
                        <td class="py-3 px-3 text-wrap" style="max-width: 220px;">
                            <span class="text-muted font-12">{{ $order->address ?: '-' }}</span>
                        </td>

                        <!-- Patient Problem -->
                        <td class="py-3 px-3 text-wrap" style="max-width: 240px;">
                            <span class="badge" style="background: var(--theme-primary-subtle, #ecfdf5); color: var(--theme-primary, #059669); font-weight: 600; font-size: 11.5px; border: 1px solid var(--theme-primary-border, #a7f3d0); white-space: normal; text-align: left; line-height: 1.4;">
                                {{ $order->patient_problem ?: 'Standard Visit' }}
                            </span>
                        </td>

                        <!-- Action -->
                        <td class="py-3 px-3 text-end">
                            <a href="{{ url('admin/patient-history/view/'.$order->id) }}" class="btn btn-sm btn-outline-primary font-weight-bold px-2 py-1" style="border-radius: 6px; font-size: 11.5px;">
                                View History
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="text-center py-5">
                            <div class="text-muted">
                                <i class="mdi mdi-account-search-outline mb-2" style="font-size: 42px; color: #cbd5e1; display: block;"></i>
                                <h5 class="fw-bold text-dark mb-1">No Patient Records Matched Your Filters</h5>
                                <p class="font-13 mb-3 text-muted">Try clearing or broadening your search criteria.</p>
                                <a href="{{ url('admin/history_of_customer') }}" class="btn btn-sm btn-outline-secondary font-weight-bold px-3 py-1" style="border-radius: 8px;">
                                    Reset Filters
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Server-Side Pagination Bar -->
        <div class="card-footer bg-white border-top d-flex align-items-center justify-content-between flex-wrap gap-3 py-3 px-4" style="border-radius: 0 0 16px 16px;">
            <div class="d-flex align-items-center gap-2 text-muted font-13">
                <span>Showing <strong>{{ $patients_lists->firstItem() ?? 0 }}</strong> to <strong>{{ $patients_lists->lastItem() ?? 0 }}</strong> of <strong>{{ $patients_lists->total() }}</strong> entries</span>
            </div>
            <div class="server-pagination">
                {{ $patients_lists->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        $('#patient_history').DataTable({
            paging: false,
            info: false,
            searching: false,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'csvHtml5',
                    text: '<i class="mdi mdi-download mr-1"></i> Export CSV',
                    className: 'btn btn-sm btn-primary font-weight-bold px-3 py-2',
                    title: 'Patient Master Records',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                    }
                }
            ]
        });
    });
</script>
@endsection
