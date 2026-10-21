@extends('admin.layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h6 class="py-3 mb-4">
            <span class="text-muted fw-light">Admin/</span> 
            {{ Request::segment(2) . '/' . Request::segment(3) }}
        </h6>
        <div class="mb-2">
            <div class="row">
                <div class="col-md-10">
                    <h5 class="mb-0">{{$title}}</h5>
                </div>
                <div class="col-md-2">
                    {{-- Add New Button (If needed) --}}
                </div>
            </div>
        </div>

        <div class="card p-4">
            <div class="table-responsive text-nowrap">
               

                <table class="table" id="zero_config">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Actions</th>
                            <th>User Type</th>
                            <th>Selfie</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Location</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Vehicle Number</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($users as $key => $user)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ URL::to('admin/user/approved_user_edit/' . $user->id) }}">
                                                <i class="bx bx-edit-alt me-1"></i> Edit
                                            </a>
                                            <a href="javascript:void(0);" class="dropdown-item" 
                                               onclick="viewDetails(
                                                   '{{ $user->user_type }}', 
                                                   '{{ $user->name }}', 
                                                   'EMP{{ $user->code }}', 
                                                   '{{ $user->employee->emp_location }}', 
                                                   '{{ $user->employee->emp_branch }}', 
                                                   '{{ $user->employee->emp_function }}', 
                                                   '{{ $user->phone }}', 
                                                   '{{ $user->email }}', 
                                                   '{{ $user->employee->emp_fm_vehicle_no }}', 
                                                   '{{ $user->status }}', 
                                                   '{{ asset($user->selfie ?? 'public/assets/admin/img/logo/default.jpg') }}', 
                                                   '{{ asset($user->employee->emp_aadhar ?? 'public/assets/admin/img/logo/default.jpg') }}', 
                                                   '{{ asset($user->employee->emp_pan ?? 'public/assets/admin/img/logo/default.jpg') }}'
                                               )">View</a>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->user_type }}</td>
                                <td>
                                    <img src="{{ asset($user->selfie ?? 'public/assets/admin/img/logo/default.jpg') }}" 
                                         alt="Selfie" width="100px" class="img-thumbnail" 
                                         style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal" 
                                         onclick="showImage('{{ asset($user->selfie ?? 'public/assets/admin/img/logo/default.jpg') }}')">
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>EMP{{ $user->code }}</td>
                                <td>{{ $user->employee->emp_location }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->employee->emp_fm_vehicle_no }}</td>
                                <td>{{ $user->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal for displaying all user details --}}
    <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailsModalLabel">User Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        <li class="list-group-item"><strong>User Type:</strong> <span id="userType"></span></li>
                        <li class="list-group-item"><strong>Name:</strong> <span id="name"></span></li>
                        <li class="list-group-item"><strong>Employee Code:</strong> <span id="employeeCode"></span></li>
                        <li class="list-group-item"><strong>Location:</strong> <span id="location"></span></li>
                        <li class="list-group-item"><strong>Branch:</strong> <span id="branch"></span></li>
                        <li class="list-group-item"><strong>Function:</strong> <span id="function"></span></li>
                        <li class="list-group-item"><strong>Phone:</strong> <span id="phone"></span></li>
                        <li class="list-group-item"><strong>Email:</strong> <span id="email"></span></li>
                        <li class="list-group-item"><strong>Vehicle Number:</strong> <span id="vehicleNumber"></span></li>
                        <li class="list-group-item"><strong>Status:</strong> <span id="status"></span></li>
                    </ul>
                    <div class="d-flex justify-content-between mt-3">
                        <div>
                            <strong>Selfie:</strong><br>
                            <a href="" download="" id="selfie_download">
                                <img id="selfie" src="" alt="Selfie" width="150px">
                            </a>
                            
                        </div>
                        <div>
                            <strong>Aadhar:</strong><br>
                            <a href="" download="" id="aadhar_download">
                                <img id="aadhar" src="" alt="Aadhar Card" width="150px">
                            </a>
                            
                        </div>
                        <div>
                            <strong>PAN Card:</strong><br>
                            <a href="" download="" id="pan_download">
                                <img id="pan" src="" alt="PAN Card" width="150px">
                            </a>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal for displaying the image --}}
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="" id="modalImage" class="img-fluid" alt="User Image">
                </div>
            </div>
        </div>
    </div>

    <script>
        function showImage(src) {
            document.getElementById('modalImage').src = src;
        }

        function viewDetails(userType, name, employeeCode, location, branch, func, phone, email, vehicleNumber, status, selfie, aadhar, pan) {
            document.getElementById('userType').textContent = userType;
            document.getElementById('name').textContent = name;
            document.getElementById('employeeCode').textContent = employeeCode;
            document.getElementById('location').textContent = location;
            document.getElementById('branch').textContent = branch;
            document.getElementById('function').textContent = func;
            document.getElementById('phone').textContent = phone;
            document.getElementById('email').textContent = email;
            document.getElementById('vehicleNumber').textContent = vehicleNumber;
            document.getElementById('status').textContent = status;

            // Set images
            document.getElementById('selfie').src = selfie;
            document.getElementById('aadhar').src = aadhar;
            document.getElementById('pan').src = pan;

            // Show the modal
            document.getElementById('selfie_download').href = selfie;
            document.getElementById('aadhar_download').href = aadhar;
            document.getElementById('pan_download').href = pan;

            // Show the modal
            var detailsModal = new bootstrap.Modal(document.getElementById('detailsModal'), {});
            detailsModal.show();
        }
    </script>
@endsection
