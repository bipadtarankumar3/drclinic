@extends('admin.layouts.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 class="mb-0 fw-bold text-dark"><i class="mdi mdi-cog-outline me-1 text-primary"></i> Settings & Configurations</h5>
            <small class="text-muted">Manage appointment fees, Razorpay gateway credentials, clinic contacts, and public frontend notices.</small>
        </div>
    </div>

    <form action="{{ isset($setting) ? URL::to('admin/setting/setting_submit/' . $setting->id) : URL::to('admin/setting/setting_submit') }}" method="POST">
        @csrf
        <input type="hidden" class="form-control" id="id" name="id" value="{{ isset($setting) ? $setting->id : '' }}">
        
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-dark"><i class="mdi mdi-tune-vertical text-primary me-1"></i> General & Payment Settings</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="pay_amount" class="form-label fw-semibold">Consultation Amount (₹)</label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" class="form-control" id="pay_amount" name="pay_amount" value="{{ isset($setting) ? $setting->pay_amount : '' }}" placeholder="700" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="pay_additional_amount" class="form-label fw-semibold">Platform Charges (₹)</label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" class="form-control" id="pay_additional_amount" name="pay_additional_amount" value="{{ isset($setting) ? $setting->pay_additional_amount : '' }}" placeholder="40" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="clinic_phone_number" class="form-label fw-semibold">Clinic WhatsApp / Phone</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="mdi mdi-whatsapp text-success"></i></span>
                                <input type="text" class="form-control" id="clinic_phone_number" name="clinic_phone_number" value="{{ isset($setting) ? $setting->clinic_phone_number : '' }}" placeholder="e.g. 9631775097">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="payment_terms_and_condition" class="form-label fw-semibold"><i class="mdi mdi-file-document-outline text-primary me-1"></i> Terms & Conditions</label>
                            <textarea name="payment_terms_and_condition" id="payment_terms_and_condition" rows="8" class="form-control" style="min-height: 220px; resize: vertical;">{{ isset($setting) ? $setting->payment_terms_and_condition : '' }}</textarea>
                            <small class="text-muted">Displayed on the booking and terms acknowledgement popup.</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="frontend_notice" class="form-label fw-semibold text-danger"><i class="mdi mdi-bullhorn-outline me-1"></i> Frontend Notice / Announcement</label>
                            <textarea name="frontend_notice" id="frontend_notice" rows="8" class="form-control" placeholder="Type notice to display across frontend website (e.g., Clinic holiday, special advisory, timings update)..." style="min-height: 220px; resize: vertical;">{{ isset($setting) ? $setting->frontend_notice : '' }}</textarea>
                            <small class="text-muted">Exposed via Public API for external HTML pages. Leave empty to hide notice.</small>
                        </div>
                    </div>
                </div>

                <hr class="my-3">

                <h6 class="fw-bold text-dark mb-3"><i class="mdi mdi-shield-key-outline text-primary me-1"></i> Razorpay Payment Gateway Credentials</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="pay_key" class="form-label fw-semibold">Razorpay Key ID</label>
                            <input type="text" class="form-control" id="pay_key" name="pay_key" value="{{ isset($setting) ? $setting->pay_key : '' }}" placeholder="rzp_live_...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="pay_secret_key" class="form-label fw-semibold">Razorpay Secret Key</label>
                            <input type="text" class="form-control" id="pay_secret_key" name="pay_secret_key" value="{{ isset($setting) ? $setting->pay_secret_key : '' }}" placeholder="Enter Secret Key">
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="mdi mdi-content-save-outline me-1"></i> {{ isset($setting) ? 'Update Settings' : 'Save Settings' }}
                    </button>
                </div>
            </div>
        </div>
    </form>

    {{-- 
    <!-- Public Notice API Documentation Card (Temporarily Hidden) -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h6 class="mb-0 fw-bold text-primary"><i class="mdi mdi-api me-1"></i> Public Frontend Notice API Integration</h6>
        </div>
        <div class="card-body">
            <p class="text-muted mb-2">You can fetch the active frontend notice from any external HTML page using the public endpoint below:</p>
            
            <div class="mb-3">
                <label class="form-label fw-bold small text-uppercase">Public API Endpoint (GET):</label>
                <div class="input-group">
                    <span class="input-group-text bg-success text-white fw-bold">GET</span>
                    <input type="text" class="form-control bg-light font-monospace" id="apiEndpointUrl" value="{{ url('api/notice') }}" readonly>
                    <button class="btn btn-outline-secondary" type="button" onclick="copyApiUrl()"><i class="mdi mdi-content-copy"></i> Copy</button>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold small text-uppercase">HTML / JavaScript Integration Snippet:</label>
                    <pre class="bg-dark text-white p-3 rounded small mb-0" style="max-height: 220px; overflow-y: auto;"><code>&lt;!-- Notice Container in your HTML --&gt;
&lt;div id="clinic-notice-bar" style="display:none;"&gt;&lt;/div&gt;

&lt;script&gt;
fetch('{{ url('api/notice') }}')
  .then(res =&gt; res.json())
  .then(data =&gt; {
    if (data.status &amp;&amp; data.has_notice) {
      const el = document.getElementById('clinic-notice-bar');
      el.innerHTML = data.notice_html;
      el.style.display = 'block';
    }
  })
  .catch(err =&gt; console.error('Notice load error:', err));
&lt;/script&gt;</code></pre>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small text-uppercase">Sample JSON Response:</label>
                    <pre class="bg-dark text-white p-3 rounded small mb-0" style="max-height: 220px; overflow-y: auto;"><code>{
  "status": true,
  "message": "Notice fetched successfully.",
  "has_notice": true,
  "notice": "Clinic will remain closed on Sunday.",
  "notice_html": "Clinic will remain closed on Sunday.",
  "data": {
    "notice": "Clinic will remain closed on Sunday.",
    "clinic_phone_number": "9631775097",
    "pay_amount": 700,
    "updated_at": "2026-10-02T15:30:00+00:00"
  }
}</code></pre>
                </div>
            </div>
        </div>
    </div>
    --}}
</div>
@endsection

@section('js')
<script>
    function copyApiUrl() {
        var copyText = document.getElementById("apiEndpointUrl");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value);
        
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'success',
                title: 'Copied!',
                text: 'API URL copied to clipboard.',
                timer: 1500,
                showConfirmButton: false
            });
        } else {
            alert('API URL copied: ' + copyText.value);
        }
    }
</script>
@endsection

