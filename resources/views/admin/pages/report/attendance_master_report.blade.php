@extends('admin.layouts.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h6 class="py-3 mb-4"><span class="text-muted fw-light">Admin/</span>
        {{ Request::segment(2) . '/' . Request::segment(3) }}

    </h6>
    
    @php
                                
                                // Get the number of days in the selected month
                                $toDate = request('to_date', date('Y-m'));
                                $daysInMonth = \Carbon\Carbon::createFromFormat('Y-m', $toDate)->daysInMonth;
                            @endphp

    <div class="mb-2">
        <div class="row">
            <div class="col-md-10">
                <h5 class="mb-0">{{$title}}</h5>
            </div>
            <div class="col-md-2">
                
                <button type="button" class="btn btn-sm btn-success text-white" title="Export to Excel" data-toggle="tooltip" onclick="tableToExcel('staff_table', 'Attendance Muster Roll 01 - {{$daysInMonth}}')"><i class="fas fa-file-export"></i> Export</button>

            </div>
        </div>


    </div>
    <div class="card p-4 my-4">
        <h3 class="mb-4">Monthly Attendance Report</h3>



        <!-- Filter Form -->
        <form action="" method="GET">
            <div class="row mb-3">
                <div class="col-md-3">
                    <select name="user_id[]" id="user_id" class="form-control select2" multiple>
                        @foreach ($users_list as $staff)
                            <option value="{{ $staff->id }}" @if(isset($_GET['user_id']) && in_array($staff->id, (array)$_GET['user_id'])) selected @endif>
                                {{ $staff->name }} || {{ $staff->user_type }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="month" class="form-control" name="to_date" value="{{ request('to_date', '') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>

        <!-- Report Table -->
        @if(!empty($users))
            <div class="table-responsive">
                <table class="table table-bordered" id="staff_table">
                    <thead class="table">
                        <tr>
                            <th >S.N</th>
                            <th >Staff Name</th>
                            <th >Staff Type</th>
                            <th >Days</th>
                            
                            @for($day = 1; $day <= $daysInMonth; $day++)
                                @php
                                    // Format the date to show the day name (e.g., Mon, Tue, etc.)
                                    $date = \Carbon\Carbon::createFromFormat('Y-m-d', $toDate . '-' . str_pad($day, 2, '0', STR_PAD_LEFT));
                                @endphp
                                <th>{{ $date->format('d') }} <br> {{ $date->format('D') }}</th>
                            @endfor
                            <th>Total Hours</th>
                            <th>Total Present</th>
                            <th>Total Absent</th>
                            <th>Total Half Days</th>
                            <th>Total Paid Leaves</th>
                            <th>Total Unmarked</th>
                            <th>Total Overtime Hours</th>
                            <th>Total Fine Hours</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td rowspan="4">{{ $loop->iteration }}</td>
                                <td rowspan="4">{{ $user->name }}</td>
                                <td rowspan="4">Monthly Regular</td>
                                <td>IN</td>
                                @for ($day = 1; $day <= $daysInMonth; $day++)
                                    <td>{{ $report[$user->id][$day]['in_time'] ?? '-' }}</td>
                                @endfor
                                <td rowspan="4">{{ $report[$user->id]['total_hours'] ?? '0' }}</td>
                                <td rowspan="4">{{ $report[$user->id]['present_days'] ?? '0' }}</td>
                                <td rowspan="4">{{ $report[$user->id]['absent_days'] ?? '0' }}</td>
                                <td rowspan="4">{{ $report[$user->id]['half_days'] ?? '0' }}</td>
                                <td rowspan="4">{{ $report[$user->id]['paid_leaves'] ?? '0' }}</td>
                                <td rowspan="4">{{ $report[$user->id]['unmarked_days'] ?? '0' }}</td>
                                <td rowspan="4">{{ $report[$user->id]['overtime_hours'] ?? '0' }}</td>
                                <td rowspan="4">{{ $report[$user->id]['fine_hours'] ?? '0' }}</td>
                            </tr>
                            <tr>
                                <td>OUT</td>
                                @for ($day = 1; $day <= $daysInMonth; $day++)
                                    <td>{{ $report[$user->id][$day]['out_time'] ?? '-' }}</td>
                                @endfor
                            </tr>
                            <tr>
                                <td>WH</td>
                                @for ($day = 1; $day <= $daysInMonth; $day++)
                                    <td>{{ $report[$user->id][$day]['work_hours'] ?? '-' }}</td>
                                @endfor
                            </tr>
                            <tr>
                                <td>OT</td>
                                @for ($day = 1; $day <= $daysInMonth; $day++)
                                    <td>{{ $report[$user->id][$day]['overtime_hours'] ?? '-' }}</td>
                                @endfor
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-center text-muted">No records found for the selected month.</p>
        @endif
    </div>
</div>
@endsection



@section('js')
<script>
    $(document).ready(function() {
        $('#user_id').select2({
            placeholder: "Select Staff",
            allowClear: true
        });
    });
</script>
@endsection