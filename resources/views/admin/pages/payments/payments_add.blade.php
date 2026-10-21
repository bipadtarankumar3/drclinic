@extends('admin.layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h6 class="py-3 mb-4"><span class="text-muted fw-light">Admin/</span> Add Payment</h6>
        
        <form action="{{ isset($payment) ? URL::to('admin/payments/store/' . $payment->id) : URL::to('admin/payments/store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <h5 class="card-header">Payment Form</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="payment_date">Payment Date</label>
                                        <input type="date" class="form-control" id="payment_date" name="payment_date" value="{{ isset($payment) ? $payment->payment_date : '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="user_id">User Name</label>
                                        <select class="form-control" id="user_id" name="user_id" required>
                                            <option value="">Select User</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="amount">Amount</label>
                                        <input type="number" class="form-control" id="amount" name="amount" value="{{ isset($payment) ? $payment->amount : '' }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="payment_mode">Payment Mode</label>
                                        <select class="form-control" id="payment_mode" name="payment_mode" required>
                                            <option value="cash">Cash</option>
                                            <option value="upi">UPI</option>
                                            <option value="online_transfer">Online Transfer</option>
                                            <option value="cheque">Cheque</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div id="cash_fields" class="payment-fields">
                                <div class="form-group">
                                    <label for="cash_amount">Cash Amount</label>
                                    <input type="number" class="form-control" id="cash_amount" name="cash_amount">
                                </div>
                                <div class="form-group">
                                    <label for="cash_date">Date</label>
                                    <input type="date" class="form-control" id="cash_date" name="cash_date">
                                </div>
                            </div>

                            <div id="upi_fields" class="payment-fields" style="display: none;">
                                <div class="form-group">
                                    <label for="upi_amount">Amount</label>
                                    <input type="number" class="form-control" id="upi_amount" name="upi_amount">
                                </div>
                                <div class="form-group">
                                    <label for="upi_date">Date</label>
                                    <input type="date" class="form-control" id="upi_date" name="upi_date">
                                </div>
                                <div class="form-group">
                                    <label for="upi_id">UPI ID</label>
                                    <input type="text" class="form-control" id="upi_id" name="upi_id">
                                </div>
                            </div>

                            <div id="online_transfer_fields" class="payment-fields" style="display: none;">
                                <div class="form-group">
                                    <label for="online_amount">Amount</label>
                                    <input type="number" class="form-control" id="online_amount" name="online_amount">
                                </div>
                                <div class="form-group">
                                    <label for="online_date">Date</label>
                                    <input type="date" class="form-control" id="online_date" name="online_date">
                                </div>
                                <div class="form-group">
                                    <label for="transaction_id">Transaction ID</label>
                                    <input type="text" class="form-control" id="transaction_id" name="transaction_id">
                                </div>
                                <div class="form-group">
                                    <label for="bank_name">Bank Name</label>
                                    <input type="text" class="form-control" id="bank_name" name="bank_name">
                                </div>
                            </div>

                            <div id="cheque_fields" class="payment-fields" style="display: none;">
                                <div class="form-group">
                                    <label for="cheque_amount">Amount</label>
                                    <input type="number" class="form-control" id="cheque_amount" name="cheque_amount">
                                </div>
                                <div class="form-group">
                                    <label for="cheque_date">Cheque Date</label>
                                    <input type="date" class="form-control" id="cheque_date" name="cheque_date">
                                </div>
                                <div class="form-group">
                                    <label for="cheque_number">Cheque Number</label>
                                    <input type="text" class="form-control" id="cheque_number" name="cheque_number">
                                </div>
                                <div class="form-group">
                                    <label for="cheque_bank_name">Bank Name</label>
                                    <input type="text" class="form-control" id="cheque_bank_name" name="cheque_bank_name">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">{{ isset($payment) ? 'Update' : 'Submit' }}</button>
                                    <a href="{{ URL::to('admin/payments') }}" class="btn btn-warning">Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @endsection
    
@section('js')
    <script>
        $(document).ready(function() {
            function toggleFields() {
                let paymentMode = $('#payment_mode').val();
                $('.payment-fields').hide();
                if (paymentMode === 'cash') {
                    $('#cash_fields').show();
                } else if (paymentMode === 'upi') {
                    $('#upi_fields').show();
                } else if (paymentMode === 'online_transfer') {
                    $('#online_transfer_fields').show();
                } else if (paymentMode === 'cheque') {
                    $('#cheque_fields').show();
                }
            }
            
            $('#payment_mode').change(toggleFields);
            toggleFields();
        });
    </script>
@endsection
