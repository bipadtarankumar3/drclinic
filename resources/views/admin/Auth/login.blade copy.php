<!DOCTYPE html>

<html class="light-style layout-menu-fixed" data-theme="theme-default" data-assets-path="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template-free/demo/assets/" data-base-url="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template-free/demo" data-framework="laravel" data-template="vertical-menu-laravel-template-free">


<!-- Mirrored from demos.themeselection.com/materio-bootstrap-html-laravel-admin-template-free/demo/auth/login-basic by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Mar 2024 18:59:54 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title> Admin Login</title>
  <meta name="description" content="Most Powerful &amp; Comprehensive Bootstrap 5 HTML Admin Dashboard Template built for developers!" />
  <meta name="keywords" content="dashboard, bootstrap 5 dashboard, bootstrap 5 design, bootstrap 5, bootstrap 5 free, free admin template">
  <!-- laravel CRUD token -->
  <meta name="csrf-token" content="Fh5jYGDPizn8OZeM3AxJp8ecY405k7hbJCFpTG8Y">
  <!-- Canonical SEO -->
  <link rel="canonical" href="https://themeselection.com/item/materio-free-bootstrap-html-laravel-admin-template/">
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{URL::to('public/assets/admin/img/favicon/favicon.ico')}}" />


  <!-- Include Styles -->
  <!-- BEGIN: Theme CSS-->
<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com/">
<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;ampdisplay=swap" rel="stylesheet">

<link rel="stylesheet" href="{{URL::to('public/assets/admin/vendor/fonts/materialdesigniconsf861.css?id=9a16ed1a5c9f397c4fb730e76fd36384')}}" />
<link rel="stylesheet" href="{{URL::to('public/assets/admin/vendor/libs/node-waves/node-wavesd178.css?id=aa72fb97dfa8e932ba88c8a3c04641bc')}}" />
<!-- Core CSS -->
<link rel="stylesheet" href="{{URL::to('public/assets/admin/vendor/css/core39e0.css?id=fdb5cd3f802d37d094730acf8fdcb33a')}}" />
<link rel="stylesheet" href="{{URL::to('public/assets/admin/vendor/css/theme-default5761.css?id=da9b9645b9e4f480d38ea81168db36b7')}}" />
<link rel="stylesheet" href="{{URL::to('public/assets/admin/css/demo2b5e.css?id=0f3ae65b84f44dbd4971231c5d97ac3b')}}" />
<!-- Vendors CSS -->
<link rel="stylesheet" href="{{URL::to('public/assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbarda97.css?id=e542d5fe23051cba0a5aedb27dadd732')}}" />

<!-- Vendor Styles -->


<!-- Page Styles -->
<!-- Page -->
<link rel="stylesheet" href="{{URL::to('public/assets/admin/vendor/css/pages/page-auth.css')}}">

  <!-- Include Scripts for customizer, helper, analytics, config -->
  <!-- laravel style -->
<script src="{{URL::to('public/assets/admin/vendor/js/helpers.js')}}"></script>

<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="{{URL::to('public/assets/admin/js/config.js')}}"></script>

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="../../../../buttons.github.io/buttons.js"></script>
</head>

<body>
  
      <!-- Google Tag Manager (noscript) (Default ThemeSelection: GTM-5DDHKGP, PixInvent: GTM-5J3LMKC) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5DDHKGP" height="0" width="0" style="display: none; visibility: hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
    

  <!-- Layout Content -->
  
<!-- Content -->
<div class="position-relative">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner py-4">

      <!-- Login -->
      <div class="card p-2">
        <!-- Logo -->
        <div class="app-brand justify-content-center mt-5">
          <a href="https://demos.themeselection.com/materio-bootstrap-html-laravel-admin-template-free/demo" class="app-brand-link gap-2">
           
            <span class="app-brand-text demo text-heading fw-semibold"><img src="{{URL::to('public/assets/admin/img/logo/logo.jpg')}}" alt="" height="50px" width="170px"></span>
          </a>
        </div>
        <!-- /Logo -->

        <div class="card-body mt-2">
          <h4 class="mb-2 text-center">Admin Login</h4>
          {{-- <p class="mb-4">Please sign-in to your account and start the adventure</p> --}}

          <form id="formAuthentication" class="mb-3" action="{{URL::To('admin-login-action')}}" method="post">
            @csrf
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email " autofocus>
              <label for="email">Email</label>
            </div>
            <div class="mb-3">
              <div class="form-password-toggle">
                <div class="input-group input-group-merge">
                  <div class="form-floating form-floating-outline">
                    <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                    <label for="password">Password</label>
                  </div>
                  <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-off-outline"></i></span>
                </div>
              </div>
            </div>
            <div class="mb-3 d-flex justify-content-between">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember-me">
                <label class="form-check-label" for="remember-me">
                  Remember Me
                </label>
              </div>
              <a href="forgot-password-basic.html" class="float-end mb-1">
                <span>Forgot Password?</span>
              </a>
            </div>
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
            </div>
          </form>

          
        </div>
      </div>
      <!-- /Login -->
    
    </div>
  </div>
</div>
<!--/ Content -->

  <!--/ Layout Content -->

  

  <!-- Include Scripts -->
  <!-- BEGIN: Vendor JS-->
<script src="{{URL::to('public/assets/admin/vendor/libs/jquery/jquery6eb7.js?id=fbe6a96815d9e8795a3b5ea1d0f39782')}}"></script>
<script src="{{URL::to('public/assets/admin/vendor/libs/popper/poppere728.js?id=bd2c3acedf00f48d6ee99997ba90f1d8')}}"></script>
<script src="{{URL::to('public/assets/admin/vendor/js/bootstrap05f9.js?id=0a1f83aa0a6a7fd382c37453e3f11128')}}"></script>
<script src="{{URL::to('public/assets/admin/vendor/libs/node-waves/node-wavesa75b.js?id=0ca80150f23789eaa9840778ce45fc5c')}}"></script>
<script src="{{URL::to('public/assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbard295.js?id=f4192eb35ed7bdba94dcb820a77d9e47')}}"></script>
<script src="{{URL::to('public/assets/admin/vendor/js/menuadfb.js?id=201bb3c555bc0ff219dec4dfd098c916')}}"></script>
<!-- END: Page Vendor JS-->
<!-- BEGIN: Theme JS-->
<script src="{{URL::to('public/assets/admin/js/main270c.js?id=4f816bbbc912e9a5bcff6119bc265966')}}"></script>

<!-- END: Theme JS-->
<!-- Pricing Modal JS-->
<!-- END: Pricing Modal JS-->
<!-- BEGIN: Page JS-->
<!-- END: Page JS-->

</body>


<!-- Mirrored from demos.themeselection.com/materio-bootstrap-html-laravel-admin-template-free/demo/auth/login-basic by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Mar 2024 18:59:55 GMT -->
</html>
