<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Panel</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{URL::to('public/assets/admin/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{URL::to('public/assets/admin/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{URL::to('public/assets/admin/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{URL::to('public/assets/admin/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{URL::to('public/assets/admin/vendors/typicons/typicons.css') }}">
    <link rel="stylesheet" href="{{URL::to('public/assets/admin/vendors/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{URL::to('public/assets/admin/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{URL::to('public/assets/admin/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{URL::to('public/assets/admin/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" type="text/css" href="{{URL::to('public/assets/admin/js/select.dataTables.min.css') }}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{URL::to('public/assets/admin/css/style.css') }}">
    <link rel="stylesheet" href="{{URL::to('public/assets/admin/css/my_style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{URL::to('public/assets/admin/images/favicon.png') }}" />

    <!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- DataTables Buttons CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">


@yield('style')
  </head>
  <body class="with-welcome-text">
    <div class="container-scroller">

      <!-- partial:partials/_navbar.html -->
      
      @include('admin.layouts.header')
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->

        @include('admin.layouts.sidebar')
        @include('admin.layouts.validation')
        


        <!-- partial -->
        
        @yield('content')
        <!-- main-panel ends -->

      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- plugins:js -->
    <script src="{{URL::to('public/assets/admin/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{URL::to('public/assets/admin/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{URL::to('public/assets/admin/vendors/chart.js/chart.umd.js') }}"></script>
    <script src="{{URL::to('public/assets/admin/vendors/progressbar.js/progressbar.min.js') }}"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{URL::to('public/assets/admin/js/off-canvas.js') }}"></script>
    <script src="{{URL::to('public/assets/admin/js/template.js') }}"></script>
    <script src="{{URL::to('public/assets/admin/js/settings.js') }}"></script>
    <script src="{{URL::to('public/assets/admin/js/hoverable-collapse.js') }}"></script>
    <script src="{{URL::to('public/assets/admin/js/todolist.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="{{URL::to('public/assets/admin/js/jquery.cookie.js') }}" type="text/javascript"></script>
    <script src="{{URL::to('public/assets/admin/js/dashboard.js') }}"></script>
    <!-- <script src="{{URL::to('public/assets/admin/js/Chart.roundedBarCharts.js') }}"></script> -->

    <!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- DataTables and Buttons JS -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    
    <!-- End custom js for this page-->


    @yield('js')

  </body>
</html>