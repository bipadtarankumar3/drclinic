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
                    <a href="{{URL::To('admin/booking/add')}}">
                        <button class="btn btn-primary btn-sm text-white mb-0 me-0" type="button"><i class="mdi mdi-account-plus"></i>Add booking</button>
                    </a>
                </div>
            </div>


        </div>
        <div class="card p-4">
            {{-- <h5 class="card-header">{{ $title }}</h5> --}}
            <div class="table-responsive text-nowrap">
                <table class="table" id="zero_config">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Actions</th>
                            <th>Booking date</th>
                            <th>Name of the user</th>
                            <th>Contact Number</th>
                            <th>Turf Name</th>
                            <th>Date</th>
                            <th>Timeslot</th>
                            <th>Amount</th>
                            <th>Payment mode</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                        <tr>
                            <th scope="row">1</th>
                            <td>
                                <a href="{{ url('admin/booking/edit/') }}">Edit</a>
                             
                            </td>
                            <td>16/04/2023</td>
                            <td>John Doe</td>
                            <td>1234567890</td>
                            <td>John Doe</td>
                            <td>16/04/2023</td>
                            <td>10:00 AM</td>
                            <td>100</td>
                            <td>Online</td>
                            <td>
                                <label class="badge badge-success">Active</label>
                            </td>
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
