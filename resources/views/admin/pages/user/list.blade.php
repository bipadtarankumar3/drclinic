@extends('admin.layouts.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<h6 class="py-3 mb-4"><span class="text-muted fw-light">Admin/</span>
    {{ Request::segment(2) . '/' . Request::segment(3) }}

</h6>
<div class="card">
    <h5 class="card-header">Customer List</h5>
    <div class="card-body">
      <div class="table-responsive text-nowrap">
      <table class="table" id="zero_config">
        <thead>
          <tr class="text-nowrap">
            <th>#</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Action</th>
           
          </tr>
        </thead>
        <tbody class="table-border-bottom-0" >
          @foreach ($customer as $key=> $user)
              
          <tr>
            <th scope="row">{{$key+1}}</th>
            <td>{{$user->first_name}}</td>
            <td>{{$user->last_name}}</td>
            <td>{{$user->customer_email}}</td>
            <td>{{$user->phone_no}}</td>
            <td>
                <a href="#"><i class="fa-solid fa-pen"></i></a>
                <a href="#"  onclick="deleteConfirmation(event)"><i class="fa-solid fa-trash"></i></a>
               
            </td>
            
          </tr>
          @endforeach


        </tbody>
      </table>
    </div>
    </div>
    
  </div>
</div>
@endsection