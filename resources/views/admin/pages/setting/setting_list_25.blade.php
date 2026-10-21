@extends('admin.layouts.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h6 class="py-3 mb-4"><span class="text-muted fw-light">Admin /</span> setting Management</h6>

    <form action="{{ isset($setting) ? URL::to('admin/setting/setting_submit/' . $setting->id) : URL::to('admin/setting/setting_submit') }}" method="POST">
        @csrf
        <input type="hidden" class="form-control" id="id" name="id" value="{{ isset($setting) ? $setting->id : '' }}">
        <div class="card">
            <div class="card-body">
            
        <div class="row">
            <div class="col-md-3">
               
                <div class="form-group">
                    <label for="pay_amount">Amount</label>
                    <input type="number" class="form-control" id="pay_amount" name="pay_amount" value="{{ isset($setting) ? $setting->pay_amount : '' }}" required>
                </div>
            </div>
            <div class="col-md-3">
               
                <div class="form-group">
                    <label for="pay_additional_amount">Platform Charges</label>
                    <input type="number" class="form-control" id="pay_additional_amount" name="pay_additional_amount" value="{{ isset($setting) ? $setting->pay_additional_amount : '' }}" required>
                </div>
            </div>
            <div class="col-md-6">
               
            <div class="form-group">
                <label for="payment_terms_and_condition">Terms &  Conditions</label>
                <textarea name="payment_terms_and_condition" id="payment_terms_and_condition" class="form-control" style="resize: auto;">{{ isset($setting) ? $setting->payment_terms_and_condition : '' }}</textarea>
                </div>

                   
            </div>
           
        </div>
        <div class="row">
            <div class="col-md-6">
               
                <div class="form-group">
                    <label for="pay_key">Key</label>
                    <input type="text" class="form-control" id="pay_key" name="pay_key" value="{{ isset($setting) ? $setting->pay_key : '' }}" >
                </div>
            </div>
            <div class="col-md-6">
               
            <div class="form-group">
                <label for="pay_secret_key">Secret Key</label>
                <input type="text" class="form-control" id="pay_secret_key" name="pay_secret_key" value="{{ isset($setting) ? $setting->pay_secret_key : '' }}" placeholder="Enter Secret Key" >
            </div>

                   
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">{{ isset($setting) ? 'Update' : 'Submit' }}</button>

    </div>
</div>
    </form>

</div>

@section('js')
<script>
    function deleteConfirmation(event, slotId) {
        event.preventDefault();
        if (confirm('Are you sure you want to delete this time slot?')) {
            window.location.href = '{{ url('admin/setting/delete') }}/' + slotId;
        }
    }
</script>
@endsection
@endsection
