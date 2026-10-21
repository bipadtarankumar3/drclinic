@extends('admin.layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h6 class="py-3 mb-4"><span class="text-muted fw-light">Admin/</span>
            {{ Request::segment(2) . '/' . Request::segment(3) }}

        </h6>
     

        <div class="mb-2">
            <div class="row">
                <div class="col-md-10">
                    <h5 class="mb-0">{{$title}}</h5>
                </div>
                <div class="col-md-2">
                    
                    <button type="button" class="btn btn-sm btn-success text-white" title="Export to Excel" data-toggle="tooltip" onclick="tableToExcel('staff_table', 'Staff Report')"><i class="fas fa-file-export"></i> Export</button>

                </div>
            </div>


        </div>
        <div class="card p-4 my-4">
            {{-- <h5 class="card-header">{{ $title }}</h5> --}}

            <form action="">
                <div class="row">
                    <div class="col-md-3">
                        <select name="user_id" id="user_id" class="form-control select2">
                            <option value="" >Select Staff</option>
                            @foreach ($users as $staff)
                                <option value="{{$staff->id}}" @if(isset($_GET['user_id']) && $_GET['user_id'] == $staff->id) selected @endif>{{$staff->name}} || {{$staff->user_type}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="date" class="form-control" name="form_date" value="{{ isset($_GET['form_date']) ? $_GET['form_date'] : '' }}">
                    </div>
                    <div class="col-md-4">
                        <input type="date" class="form-control" name="to_date" value="{{ isset($_GET['to_date']) ? $_GET['to_date'] : '' }}">
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
    
                </div>
            </form>
            

            <div class="table-responsive text-nowrap my-4">
                <table class="table" id="staff_table">
                    <thead>
                        <tr class="text-center">
                            <th colspan="8">
                                Staff Name: {{ isset($_GET['user_id']) ? $users_details->name : '' }}, Report Start Date : {{ isset($_GET['form_date']) ? $_GET['form_date'] : '' }},  Report End Date : {{ isset($_GET['to_date']) ? $_GET['to_date'] : '' }},  
                            </th>
                        </tr>
                        <tr>
                            <th>Sl</th>
                            <th>Date</th>
                            <th>Attendance State</th>
                            <th>In Time</th>
                            <th>Out Time</th>
                            <th>Work Hours</th>
                            <th>Overtime Hours</th>
                            <th>Fine Hours</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @if (!empty($report))
                            @foreach ($report as $key => $row)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $row['date'] }}</td>
                                    <td>{{ $row['attendance_state'] }}</td>
                                    <td>{{ $row['in_time'] }}</td>
                                    <td>{{ $row['out_time'] }}</td>
                                    <td>{{ $row['work_hours'] }}</td>
                                    <td>{{ $row['overtime_hours'] }}</td>
                                    <td>{{ $row['fine_hours'] }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td  class="text-center"></td>
                                <td  class="text-center"></td>
                                <td  class="text-center"></td>
                                <td  class="text-center"></td>
                                <td  class="text-center"></td>
                                <td  class="text-center"></td>
                                <td  class="text-center"></td>
                                <td  class="text-center"></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
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

    function deleteConfirmation(event, productId) {
        event.preventDefault();
        if (confirm('Are you sure you want to delete this product?')) {
            window.location.href = '{{ url('admin/product/stockDelete') }}/' + productId;
        }
    }
</script>
@endsection
