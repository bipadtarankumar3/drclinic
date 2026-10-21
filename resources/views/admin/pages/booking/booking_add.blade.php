@extends('admin.layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h6 class="py-3 mb-4"><span class="text-muted fw-light">Admin/</span>
            {{ Request::segment(2) . '/' . Request::segment(3) }}

        </h6>
        <form action="{{ isset($booking) ? URL::to('admin/booking/save/' . $booking->id) : URL::to('admin/booking/save') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <h5 class="card-header">Booking Form</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="booking_date">Booking Date</label>
                                        <input type="date" class="form-control" id="booking_date" name="booking_date" value="{{ isset($booking) ? $booking->booking_date : '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="user_id">User Name</label>
                                        <select class="form-control" id="user_id" name="user_id" required>
                                            <option value="">Select User</option>
                                            {{-- @foreach ($users as $user)
                                                <option value="{{ $user->id }}" {{ isset($booking) && $booking->user_id == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">Contact Number</label>
                                        <input type="text" class="form-control" id="phone" name="phone" value="{{ isset($booking) ? $booking->user->phone : '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="turf_name">Turf Name</label>
                                        <select class="form-control" id="user_id" name="user_id" required>
                                            <option value="">Select Turf</option>
                                            {{-- @foreach ($users as $user)
                                                <option value="{{ $user->id }}" {{ isset($booking) && $booking->user_id == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="timeslot">Timeslot Form</label>
                                        <input type="time" class="form-control" id="timeslot" name="timeslot" value="{{ isset($booking) ? $booking->timeslot : '10:00' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="timeslot">Timeslot To</label>
                                        <input type="time" class="form-control" id="timeslot" name="timeslot" value="{{ isset($booking) ? $booking->timeslot : '12:30' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date">Date</label>
                                        <input type="date" class="form-control" id="date" name="date" value="{{ isset($booking) ? $booking->date : '' }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="amount">Amount</label>
                                        <input type="number" class="form-control" id="amount" name="amount" value="{{ isset($booking) ? $booking->amount : '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="payment_mode">Payment Mode</label>
                                        <select class="form-control" id="payment_mode" name="payment_mode" required>
                                            <option value="cash" {{ isset($booking) && $booking->payment_mode == 'cash' ? 'selected' : '' }}>Cash</option>
                                            <option value="card" {{ isset($booking) && $booking->payment_mode == 'card' ? 'selected' : '' }}>Card</option>
                                            <option value="online" {{ isset($booking) && $booking->payment_mode == 'online' ? 'selected' : '' }}>Online</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="pending" {{ isset($booking) && $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="confirmed" {{ isset($booking) && $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                            <option value="cancelled" {{ isset($booking) && $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">{{ isset($booking) ? 'Update' : 'Submit' }}</button>
                                    <a href="{{ URL::to('admin/booking') }}" class="btn btn-warning">Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
