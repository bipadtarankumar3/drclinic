@extends('admin.layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h6 class="py-3 mb-4"><span class="text-muted fw-light">Admin/</span>
            {{ Request::segment(2) . '/' . Request::segment(3) }}
        </h6>
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm rounded-4" style="border-radius: 16px;">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-2">
                        <h5 class="fw-bold text-dark mb-0 d-flex align-items-center">
                            <i class="mdi mdi-account-edit-outline text-primary me-2 font-20"></i> Update Profile
                        </h5>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <form action="{{ route('admin.profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label font-weight-bold text-muted text-uppercase font-11">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" style="border-radius: 8px;">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label font-weight-bold text-muted text-uppercase font-11">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" style="border-radius: 8px;">
                            </div>
                            <div class="form-actions-end mt-4">
                                <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold" style="border-radius: 8px;">
                                    <i class="mdi mdi-check-circle-outline me-1"></i> Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm rounded-4" style="border-radius: 16px;">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-2">
                        <h5 class="fw-bold text-dark mb-0 d-flex align-items-center">
                            <i class="mdi mdi-lock-reset text-primary me-2 font-20"></i> Change Password
                        </h5>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <form action="{{ route('admin.password.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="current_password" class="form-label font-weight-bold text-muted text-uppercase font-11">Current Password</label>
                                <input type="password" class="form-control" id="current_password" name="current_password" style="border-radius: 8px;">
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label font-weight-bold text-muted text-uppercase font-11">New Password</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" style="border-radius: 8px;">
                            </div>
                            <div class="mb-3">
                                <label for="new_password_confirmation" class="form-label font-weight-bold text-muted text-uppercase font-11">Confirm New Password</label>
                                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" style="border-radius: 8px;">
                            </div>
                            <div class="form-actions-end mt-4">
                                <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold" style="border-radius: 8px;">
                                    <i class="mdi mdi-lock-check-outline me-1"></i> Change Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
