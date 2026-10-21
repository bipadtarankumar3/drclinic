@extends('admin.layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h6 class="py-3 mb-4"><span class="text-muted fw-light">Admin/</span>
            {{ Request::segment(2) . '/' . Request::segment(3) }}

        </h6>
        <form action="{{ isset($timeSlot) ? URL::to('admin/time_slot/time_slot_submit/' . $timeSlot->id) : URL::to('admin/time_slot/time_slot_submit') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <h5 class="card-header">Details</h5>
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="from_time">Day of week</label>
                                        <select name="day_of_week" class="form-control" id="">
                                            <option value="1" {{ isset($timeSlot) && $timeSlot->day_of_week == '1' ? 'selected' : '' }}>Monday</option>
                                            <option value="2" {{ isset($timeSlot) && $timeSlot->day_of_week == '2' ? 'selected' : '' }}>Tuesday</option>
                                            <option value="3" {{ isset($timeSlot) && $timeSlot->day_of_week == '3' ? 'selected' : '' }}>Wednesday</option>
                                            <option value="4" {{ isset($timeSlot) && $timeSlot->day_of_week == '4' ? 'selected' : '' }}>Thursday</option>
                                            <option value="5" {{ isset($timeSlot) && $timeSlot->day_of_week == '5' ? 'selected' : '' }}>Friday</option>
                                            <option value="6" {{ isset($timeSlot) && $timeSlot->day_of_week == '6' ? 'selected' : '' }}>Saturday</option>
                                            <option value="7" {{ isset($timeSlot) && $timeSlot->day_of_week == '7' ? 'selected' : '' }}>Sunday</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="from_time">Open From</label>
                                        <input type="time" class="form-control" id="from_time" name="from_time" placeholder="Thumbnail" value="{{ isset($timeSlot) ? $timeSlot->from_time : '' }}" required>
                                    
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="to_time">Close From</label>
                                        <input type="time" class="form-control" id="to_time" name="to_time" placeholder="Thumbnail" value="{{ isset($timeSlot) ? $timeSlot->to_time : '' }}" required>
                                    </div>
                                </div>
                            
                               
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="area_name">Status</label>
                                        <select name="status" id="" class="form-control">
                                            <option value="active" {{ isset($timeSlot) && $timeSlot->status == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ isset($timeSlot) && $timeSlot->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">{{ isset($timeSlot) ? 'Update' : 'Submit' }}</button>
                                    <a href="{{URL::to('admin/time_slot')}}">
                                        <button type="button" class="btn btn-warning waves-effect waves-light">Back</button> 
                                     </a>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
               
            </div>
        </form>
    </div>
@endsection
