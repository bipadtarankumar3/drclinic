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
    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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


@php
  $isImpersonating = session()->has('impersonating_admin_id');
  $isSuperAdmin = Auth::check() && Auth::user()->isSuperAdmin() && !$isImpersonating;
  $activeClinic = Auth::check() ? Auth::user()->getActiveClinic() : null;

  if ($isSuperAdmin) {
      // Signature Master Admin Luxury Emerald Green Default - Locked, NEVER changes for Admin
      $themePrimary = '#059669';
      $themeSecondary = '#10b981';
  } else {
      // Clients Panel (Doctor / Clinic) gets their customized clinic color (or emerald green default)
      $themePrimary = ($activeClinic && !empty($activeClinic->theme_color) && $activeClinic->theme_color !== '#0d6efd')
          ? $activeClinic->theme_color
          : '#059669';
      $themeSecondary = ($activeClinic && !empty($activeClinic->secondary_color) && $activeClinic->secondary_color !== '#20c997')
          ? $activeClinic->secondary_color
          : '#10b981';
  }

  $cleanHex = ltrim($themePrimary, '#');
  if (strlen($cleanHex) == 3) {
      $cleanHex = $cleanHex[0].$cleanHex[0].$cleanHex[1].$cleanHex[1].$cleanHex[2].$cleanHex[2];
  }
  if (strlen($cleanHex) == 6) {
      $r = hexdec(substr($cleanHex, 0, 2));
      $g = hexdec(substr($cleanHex, 2, 2));
      $b = hexdec(substr($cleanHex, 4, 2));
      $themePrimaryRgb = "{$r}, {$g}, {$b}";
  } else {
      $themePrimaryRgb = "5, 150, 105";
  }
@endphp

<style id="portal-dynamic-theme-style">
  :root {
    --theme-primary: {{ $themePrimary }};
    --theme-secondary: {{ $themeSecondary }};
    --theme-primary-rgb: {{ $themePrimaryRgb }};
    --theme-primary-subtle: rgba({{ $themePrimaryRgb }}, 0.08);
    --theme-primary-border: rgba({{ $themePrimaryRgb }}, 0.22);
    --theme-primary-glow: rgba({{ $themePrimaryRgb }}, 0.28);
    --theme-primary-focus: rgba({{ $themePrimaryRgb }}, 0.16);
    --theme-primary-gradient: linear-gradient(135deg, {{ $themePrimary }} 0%, {{ $themeSecondary }} 100%);
    --primary-gradient: linear-gradient(135deg, {{ $themePrimary }} 0%, {{ $themeSecondary }} 100%);
    --clinic-gradient: linear-gradient(135deg, {{ $themePrimary }} 0%, {{ $themeSecondary }} 100%);
  }

  /* Avatars & Brand Icon Accents */
  .brand-square-avatar,
  .sidebar-user-avatar,
  .header-user-avatar {
    background: var(--theme-primary-gradient) !important;
    color: #ffffff !important;
    box-shadow: 0 4px 12px var(--theme-primary-glow) !important;
  }

  /* Sidebar Active Navigation Item */
  .sidebar .nav .nav-item.active > .nav-link {
    background: var(--theme-primary-subtle) !important;
    color: var(--theme-primary) !important;
    border: 1px solid var(--theme-primary-border) !important;
    font-weight: 700 !important;
    box-shadow: 0 2px 8px var(--theme-primary-glow) !important;
  }
  .sidebar .nav .nav-item.active > .nav-link .menu-title,
  .sidebar .nav .nav-item.active > .nav-link .nav-icon,
  .sidebar .nav .nav-item.active > .nav-link .nav-chevron {
    color: var(--theme-primary) !important;
    font-weight: 700 !important;
  }
  .sidebar .nav .nav-item .nav-link:hover {
    background: var(--theme-primary-subtle) !important;
    color: var(--theme-primary) !important;
  }
  .sidebar .nav .nav-item .nav-link:hover .nav-icon {
    color: var(--theme-primary) !important;
  }

  /* Primary Buttons */
  .btn-primary {
    background: var(--theme-primary-gradient) !important;
    border: none !important;
    color: #ffffff !important;
    font-weight: 700 !important;
    border-radius: 10px !important;
    box-shadow: 0 4px 14px var(--theme-primary-glow) !important;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1) !important;
  }
  .btn-primary:hover,
  .btn-primary:focus,
  .btn-primary:active {
    background: var(--theme-primary) !important;
    color: #ffffff !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 20px var(--theme-primary-glow) !important;
  }

  /* Success Buttons */
  .btn-success {
    background: var(--theme-primary-gradient) !important;
    border: none !important;
    color: #ffffff !important;
    font-weight: 700 !important;
    box-shadow: 0 4px 14px var(--theme-primary-glow) !important;
  }

  /* Outline Primary Buttons */
  .btn-outline-primary {
    color: var(--theme-primary) !important;
    border: 1.5px solid var(--theme-primary) !important;
    background: transparent !important;
    font-weight: 600 !important;
  }
  .btn-outline-primary:hover {
    background: var(--theme-primary) !important;
    color: #ffffff !important;
    box-shadow: 0 4px 12px var(--theme-primary-glow) !important;
  }

  /* Inputs & Selects Focus States */
  .form-control:focus,
  .form-select:focus,
  .doctor-settings-input:focus,
  .select2-container--default.select2-container--focus .select2-selection--single {
    border-color: var(--theme-primary) !important;
    box-shadow: 0 0 0 3.5px var(--theme-primary-focus) !important;
    outline: none !important;
  }

  /* Toggles & Checkboxes */
  .form-check-input:checked {
    background-color: var(--theme-primary) !important;
    border-color: var(--theme-primary) !important;
  }

  /* Active Tabs & Nav Pills */
  .custom-nav-tabs .nav-link.active {
    color: var(--theme-primary) !important;
    box-shadow: 0 4px 12px rgba(0,0,0,0.06) !important;
    font-weight: 700 !important;
  }
  .nav-pills .nav-link {
    color: #475569 !important;
    background: #ffffff;
    border: 1.5px solid #e2e8f0;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1) !important;
  }
  .nav-pills .nav-link:hover {
    background: var(--theme-primary-subtle) !important;
    color: var(--theme-primary) !important;
    border-color: var(--theme-primary-border) !important;
  }
  .nav-pills .nav-link.active,
  .nav-pills .show > .nav-link {
    background: var(--theme-primary-gradient) !important;
    color: #ffffff !important;
    border-color: transparent !important;
    box-shadow: 0 4px 14px var(--theme-primary-glow) !important;
  }
  .nav-pills .nav-link.active i,
  .nav-pills .nav-link.active span {
    color: #ffffff !important;
  }

  /* Pagination */
  .pagination .page-item.active .page-link,
  .server-pagination .page-item.active .page-link {
    background-color: var(--theme-primary) !important;
    border-color: var(--theme-primary) !important;
    color: #ffffff !important;
    box-shadow: 0 2px 8px var(--theme-primary-glow) !important;
  }

  /* Theme Badges */
  .badge-theme-primary {
    background: var(--theme-primary-subtle) !important;
    color: var(--theme-primary) !important;
    border: 1px solid var(--theme-primary-border) !important;
    font-weight: 700 !important;
  }

  /* Theme Utilities */
  .text-primary {
    color: var(--theme-primary) !important;
  }
  .bg-primary {
    background-color: var(--theme-primary) !important;
  }
  .border-primary {
    border-color: var(--theme-primary) !important;
  }

  /* Form actions placed at the end */
  .form-actions-end,
  .action-buttons-end {
    display: flex !important;
    align-items: center !important;
    justify-content: flex-end !important;
    gap: 12px !important;
    margin-top: 24px !important;
  }
</style>

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
        


        <!-- main-panel begins -->
        <div class="main-panel">
          @yield('content')
        </div>
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