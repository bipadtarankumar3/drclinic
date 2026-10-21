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
                    
                    {{-- <a href="{{URL::To('admin/client/add')}}">
                        <button class="btn btn-primary btn-sm text-white mb-0 me-0" type="button"><i class="mdi mdi-account-plus"></i>Add Category</button>
                    </a> --}}
                </div>
            </div>


        </div>
        
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">

                       
                    <form action="{{ isset($area) ? URL::to('admin/area/save_area/' . $area->id) : URL::to('admin/area/save_area') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="area_name">Sports category name</label>
                                    <input type="text" class="form-control" id="area_name" name="area_name" placeholder="Enter the name here" value="{{ isset($area) ? $area->area_name : '' }}" required>
                                </div>
                                
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="area_name">Thumbnail </label>
                                    <input type="file" class="form-control" id="area_name" name="area_name" placeholder="Category Name" value="{{ isset($area) ? $area->area_name : '' }}" required>
                                </div>
                                
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="area_name">Status</label>
                                    <select name="status" id="" class="form-control">
                                        <option value="Active" {{ isset($area) && $area->area_status == 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="Inactive" {{ isset($area) && $area->area_status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                                
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">{{ isset($area) ? 'Update' : 'Submit' }}</button>
                            </div>
                            
                        </div>
                    </form>
                </div>
                </div>
                </div>
                <div class="col-md-8">

                    <div class="card">
                        <div class="card-body">

                       
                        <div class="table-responsive text-nowrap">
                            <table class="table" id="zero_config">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Actions</th>
                                        <th>Name</th>
                                        <th>Thumbnail </th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">

                                    <tr>
                                        <td scope="row">1</td>
                                        <td>
                                            <a href="{{ url('admin/category/edit/' ) }}" class="jsgrid-button jsgrid-delete-button">Edit</a>
                                            <a href="{{URL::to('admin/category/delete/')}}" class="jsgrid-button jsgrid-delete-button"  onclick="deleteConfirmationGet(event)"></a>
                                        
                                        </td>
                                        <td>Cat 1</td>
                                        <td>
                                            <img src="{{URL::to('public/assets/admin/images/thumbnail2.jpg')}}" class="img-fluid" alt="Responsive image">
                                        </td>
                                        <td><label class="badge badge-success">Active</label></td>
                            
                                        
                                        
                                    </tr>
                            
                                    {{-- @foreach ($users as $key=> $user)
                        
                                    <tr>
                                    <td scope="row">{{$key+1}}</td>
                                        <td>
                                            <a href="{{ url('admin/client/edit/' . $user->id) }}"><i class="fa-solid fa-pen"></i></a>
                                            <a href="{{URL::to('admin/client/delete/'.$user->id)}}"  onclick="deleteConfirmationGet(event)"><i class="fa-solid fa-trash"></i></a>
                                        
                                        </td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->phone}}</td>
                                    <td>{{ $user->address ?? 'N/A' }}</td>
                                    <td>{{ $user->status}}</td>
                        
                                    
                                    
                                    </tr>
                                    @endforeach --}}
            
                                </tbody>
                            </table>
                        </div>
                    </div>
                    </div>

                    
                </div>
            </div>

            
        </div>
    </div>
@endsection



@section('js')
<script>
    function deleteConfirmation(event, productId) {
        event.preventDefault();
        if (confirm('Are you sure you want to delete this product?')) {
            window.location.href = '{{ url('admin/product/stockDelete') }}/' + productId;
        }
    }
</script>
@endsection
