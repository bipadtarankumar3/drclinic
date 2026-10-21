@extends('admin.layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h6 class="py-3 mb-4"><span class="text-muted fw-light">Admin/</span>
            {{ Request::segment(2) . '/' . Request::segment(3) }}

        </h6>
        <form action="{{ isset($user) ? URL::to('admin/client/save_client/' . $user->id) : URL::to('admin/client/save_client') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <h5 class="card-header">Details</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name"> Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder=" Name" value="{{ isset($user) ? $user->name : '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email"> Email</label>
                                        <input type="text" class="form-control" id="email" name="email" placeholder=" Email" value="{{ isset($user) ? $user->email : '' }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">Contact Number</label>
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Contact Number" value="{{ isset($user) ? $user->phone : '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">Whatsapp Number</label>
                                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Whatsapp Number" value="{{ isset($user) ? $user->phone : '' }}" required>
                                    </div>
                                </div>
                                
                            </div>

                            
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">{{ isset($user) ? 'Update' : 'Submit' }}</button>
                                    <a href="{{URL::to('admin/client')}}">
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
