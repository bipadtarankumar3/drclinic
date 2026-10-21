@extends('admin.layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h6 class="py-3 mb-4"><span class="text-muted fw-light">Admin/</span>
            {{ Request::segment(2) . '/' . Request::segment(3) }}
        </h6>
        <form action="{{ URL::to('admin/user/approved_user_update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="user_id" id="user_id" value="{{ isset($user) ? $user->id : '' }}">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <h5 class="card-header">Details</h5>
                        <div class="card-body">
                            <div class="row">
                                {{-- <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="code">User Code</label>
                                        <input type="text" class="form-control" readonly id="code" name="code" placeholder="User Id" value="{{ isset($user) ? $user->code : '' }}" required>
                                    </div>
                                </div> --}}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="User Id" value="{{ isset($user) ? $user->name : '' }}" required>
                                    </div>
                                </div>
                                
                               
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="company_id">Company ID</label>
                                        <input type="text" class="form-control" id="company_id" name="company_id" placeholder="Company ID" value="{{ $user->company_id }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" value="{{ $user->phone  }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ $user->email  }}">
                                    </div>
                                </div>
                                
                            </div>

                            <div class="row">
                                
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="emp_location">Location</label>
                                        <input type="text" class="form-control" id="emp_location" name="emp_location" placeholder="Location" value="{{ $Employee->emp_location  }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="emp_branch">Branch</label>
                                        <input type="text" class="form-control" id="emp_branch" name="emp_branch" placeholder="Branch" value="{{ $Employee->emp_branch  }}">
                                    </div>
                                </div>
                            
                               
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="emp_function">Function</label>
                                        <input type="text" class="form-control" id="emp_function" name="emp_function" placeholder="Function" value="{{ $Employee->emp_function  }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="emp_fm_vehicle_no">FM Vehicle No</label>
                                        <input type="text" class="form-control" id="emp_fm_vehicle_no" name="emp_fm_vehicle_no" placeholder="FM Vehicle No" value="{{ $Employee->emp_fm_vehicle_no  }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="emp_dl_date">DL Expiry Date</label>
                                        <input type="date" class="form-control" id="emp_dl_date" name="emp_dl_date" value="{{ $Employee->emp_dl_date  }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="selfie">Selfie</label>
                                        <input type="file" class="form-control" id="selfie" name="selfie">
                                        @if (isset($Employee))
                                            <img src="{{ $Employee->emp_selfie }}" alt="Selfie" style="max-width: 100px; max-height: 100px;">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="aadhar">Aadhar</label>
                                        <input type="file" class="form-control" id="aadhar" name="aadhar">
                                        @if (isset($Employee))
                                            <img src="{{ $Employee->emp_aadhar }}" alt="aadhar" style="max-width: 100px; max-height: 100px;">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="pan">PAN</label>
                                        <input type="file" class="form-control" id="pan" name="pan">
                                        @if (isset($Employee))
                                            <img src="{{ $Employee->emp_pan }}" alt="pan" style="max-width: 100px; max-height: 100px;">
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="photo">Photo</label>
                                        <input type="file" class="form-control" id="photo" name="photo">
                                        @if (isset($Employee))
                                            <img src="{{ URL::to('upload/photo/' . $user->emp_photo) }}" alt="photo" style="max-width: 100px; max-height: 100px;">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="user_name">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" >
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="">Select Status</option>
                                            <option value="pending" @if (isset($user) && $user->status == 'pending') selected @endif>Pending</option>
                                            <option value="active" @if (isset($user) && $user->status == 'active') selected @endif>Active</option>
                                            <option value="inactive" @if (isset($user) && $user->status == 'inactive') selected @endif>Inactive</option>
                                        </select>
                                    </div>
                                </div>


                            </div>
                            

                            <div class="row my-2">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">{{ isset($user) ? 'Update' : 'Submit' }}</button>
                                    {{-- <a href="{{ URL::to('admin/user/new-office-employee') }}">
                                        <button type="button" class="btn btn-warning waves-effect waves-light">Back</button>
                                    </a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
