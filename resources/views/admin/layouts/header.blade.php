
<style>
  .blink-text {
    animation: blink 1s infinite;
}

@keyframes blink {
    0% { opacity: 1; }
    50% { opacity: 0; }
    100% { opacity: 1; }
}
</style>

<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
    <div class="me-3">
      <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
        <span class="icon-menu"></span>
      </button>
    </div>
    <div>
      <a class="navbar-brand brand-logo" href="{{URL::To('admin/dashboard')}}">
        {{-- <img src="{{URL::to('public/assets/admin/images/logo.svg') }}" alt="logo" /> --}}
        Roy neuro 
      </a>
      <a class="navbar-brand brand-logo-mini" href="{{URL::To('admin/dashboard')}}">
        {{-- <img src="{{URL::to('public/assets/admin/images/logo-mini.svg') }}" alt="logo" /> --}}
        Roy neuro 
      </a>
    </div>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-top">
    {{-- <ul class="navbar-nav">
      <li class="nav-item fw-semibold d-none d-lg-block ms-0">
        <h1 class="welcome-text">Good Morning, <span class="text-black fw-bold">{{Auth::user()->name}}</span></h1>
      </li>
      
    </ul> --}}
    <ul  class="navbar-nav">
      

      <li  class="nav-item fw-semibold d-none d-lg-block ms-0">
        <form id="paymentPermissionForm" method="POST" action="{{ url('/admin/setting/update-payment-permission') }}">
            @csrf
            <div class="form-check form-switch">
              @php
                  $setting = DB::table('settings')->first();
                  $paymentStatus = $setting->payment_permission_status ?? 'no'; // Default to 'no' if null
              @endphp
             <input class="form-check-input" type="checkbox" id="payment_permission_status" name="payment_permission_status" value="yes"
             {{ $paymentStatus == 'yes' ? 'checked' : '' }} 
             style="font-size: 23px;">
         
              
              <label class="form-check-label mb-0" for="payment_permission_status">
                  @if ($paymentStatus == 'yes')
                      <h3 class="text-success">Clinic On</h3>
                  @else
                      <h3 class="text-danger blink-text">Clinic Off</h3>
                  @endif
              </label>
          </div>
          
        </form>
    </li>
     
    
      
    </ul>
    <ul class="navbar-nav ms-auto">
      
      
      <li class="nav-item dropdown d-none d-lg-block user-dropdown">
        <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
          <img class="img-xs rounded-circle" src="{{URL::to('public/assets/web/homeimage/logo.png') }}" alt="Profile image"> </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
          <div class="dropdown-header text-center">
            {{-- <img class="img-md rounded-circle" src="{{URL::to('public/assets/web/homeimage/logo.png') }}" alt="Profile image"> --}}
            <p class="mb-1 mt-3 fw-semibold">{{ Auth::user()->name ?? 'Administrator' }}</p>
            <p class="fw-light text-muted mb-0">{{ Auth::user()->email ?? '' }}</p>
          </div>
          {{-- <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> My Profile <span class="badge badge-pill badge-danger">1</span></a> --}}
         
          <a class="dropdown-item" href="{{URL::To('admin/logout')}}"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Sign Out</a>
        </div>
      </li>
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>
  </div>
</nav>


<script>
  document.getElementById('payment_permission_status').addEventListener('change', function (e) {
      e.preventDefault(); // Stop immediate submission
  
      let form = document.getElementById('paymentPermissionForm');
      let isChecked = this.checked;
  
      Swal.fire({
          title: isChecked ? 'Turn ON Clinic?' : 'Turn OFF Clinic?',
          text: "Are you sure you want to " + (isChecked ? "enable" : "disable") + " payment permissions?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, do it!'
      }).then((result) => {
          if (result.isConfirmed) {
              form.submit();
          } else {
              // If canceled, revert checkbox to previous state
              this.checked = !isChecked;
          }
      });
  });
  </script>
