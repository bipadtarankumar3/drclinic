@extends('admin.layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h6 class="py-3 mb-4"><span class="text-muted fw-light">Admin/</span>
            {{ Request::segment(2) . '/' . Request::segment(3) }}

        </h6>
        <form action="{{ URL::to('admin/user/statusChange') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ isset($user) ? $user->id : '' }}">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <h5 class="card-header">Details</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="code">User Code</label>
                                        <input type="text" class="form-control" id="code" name="code" placeholder="User Id" value="{{ isset($user) ? $user->code : '' }}" required>
                                    </div>
                                </div>
                                {{-- <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="user_name">Password</label>
                                        <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Password" value="{{ isset($user) ? $user->user_name : '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="user_name">Confirm Password</label>
                                        <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Confirm Password" value="{{ isset($user) ? $user->user_name : '' }}" required>
                                    </div>
                                </div> --}}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="user_name">Status</label>
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
                                    <a href="{{URL::to('admin/user/new-office-employee')}}">
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
