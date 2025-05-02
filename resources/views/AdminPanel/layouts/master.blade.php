<?php
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

?>

<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
  lang="{{ app()->getLocale() }}"
  class="light-style layout-menu-fixed"
  dir="{{ app()->getLocale() == 'en' ? 'ltr' : 'rtl' }}"
  data-theme="theme-default"
  data-assets-path="{{ asset('assets') }}/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>{{ isset($title) ? $title : 'Diraya Co.' }}</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets') }}/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"> --}}
    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/css/extensions/toastr.min.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/plugins/extensions/ext-component-toastr.css" />

        @if (app()->isLocale('en'))
<link rel="stylesheet" href="{{ asset('assets') }}/vendor/css/core.css" class="template-customizer-core-css" />
            <link rel="stylesheet" href="{{ asset('assets') }}/vendor/css/theme-default.css" class="template-customizer-theme-css" />
            <link rel="stylesheet" href="{{ asset('assets') }}/css/demo.css" />
@else
<link rel="stylesheet" href="{{ asset('assets') }}/vendor/css/coreRTL.css" class="template-customizer-core-css" />
            <link rel="stylesheet" href="{{ asset('assets') }}/vendor/css/theme-defaultRTL.css" class="template-customizer-theme-css" />
            <link rel="stylesheet" href="{{ asset('assets') }}/css/demoRTL.css" />
@endif
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/apex-charts/apex-charts.css" />
    <link rel="stylesheet" href="{{ asset('assets/apex-charts/apex-charts.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Page CSS -->
  <script src="https://cdn.tiny.cloud/1/1fnhci9m77oppzg3o7z1wzip494uc5j0oxsbbqt91ezido5v/tinymce/6/tinymce.min.js"
      referrerpolicy="origin"></script>

    <!-- Helpers -->
    <script src="{{ asset('assets') }}/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets') }}/js/config.js"></script>
        @yield('css')
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">


        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center w-100" id="navbar-collapse">
              <!-- Search -->
              {{-- <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                  <i class="bx bx-search fs-4 lh-0"></i>
                  <input
                    type="text"
                    class="form-control border-0 shadow-none"
                    placeholder="Search..."
                    aria-label="Search..."
                  />
                </div>
              </div> --}}
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Place this tag where you want the button to render. -->
                <li class="nav-item lh-1 me-3">
                  {{-- <a
                    class="github-button"
                    href="https://github.com/themeselection/sneat-html-admin-template-free"
                    data-icon="octicon-star"
                    data-size="large"
                    data-show-count="true"
                    aria-label="Star themeselection/sneat-html-admin-template-free on GitHub"
                    >Star</a
                  > --}}
                </li>
                   @include('AdminPanel.layouts.topbar.lang')

                </li>
                <?php $admin = \Illuminate\Support\Facades\Auth::user(); ?>

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      @if ($admin->image != null)
<img src="{{ asset("images/profiles/$admin->image") }}" alt class="w-px-40 h-auto rounded-circle" />
@else
<img src="{{ asset('assets') }}/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
@endif
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="{{ route('admin.profile') }}">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">

                              @if ($admin->image != null)
<img src="{{ asset("images/profiles/$admin->image") }}" alt class="w-px-40 h-auto rounded-circle" />
@else
<img src="{{ asset('assets') }}/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
@endif
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block">{{ $admin->name }}</span>
                            <small class="text-muted">{{ trans('common.' . $admin->getRoleNames()[0]) }}</small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{ route('admin.profile') }}">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">My Profile</span>
                      </a>
                    </li>
                    {{-- <li>
                      <a class="dropdown-item" href="#">
                        <i class="bx bx-cog me-2"></i>
                        <span class="align-middle">Settings</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">
                        <span class="d-flex align-items-center align-middle">
                          <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                          <span class="flex-grow-1 align-middle">Billing</span>
                          <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
                        </span>
                      </a>
                    </li> --}}
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{ route('AdminLogout') }}">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>

           <!-- Menu -->

        @include('AdminPanel.layouts.adminMenue')
        <!-- / Menu -->



          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

      <!-- BEGIN: Content-->

      <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container mt-4">
            <div class="content-header row">
                <div class="content-header-left col-md-8 col-12 mb-2">
                    @include('AdminPanel.layouts.common.breadcrumbs')
                </div>

                <div class="content-header-right text-md-end col-md-4 col-12 d-md-block">
                    <div class="mb-1 breadcrumb-right">
                        @yield('page_buttons')
                    </div>
                </div>
            </div>
            <div class="content-body">
                @yield('content')

                </div>
         </div>
    </div>
    <!-- END: Content-->
            <!-- / Content -->

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                  ©
                  <script>
                      document.write(new Date().getFullYear());
                  </script>
                  , {{ trans('common.made_with') }} ❤️ {{ trans('common.by') }}
                  <a href="https://www.linkedin.com/in/mohamed-salama-491877200/" target="_blank" class="footer-link fw-bolder">{{ trans('common.team') }}</a>
                </div>
                <!-- <div>
                  <a href="https://themeselection.com/license/" class="footer-link me-4" target="_blank">License</a>
                  <a href="https://themeselection.com/" target="_blank" class="footer-link me-4">More Themes</a>

                  <a
                    href="https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation/"
                    target="_blank"
                    class="footer-link me-4"
                    >Documentation</a
                  >

                  <a
                    href="https://github.com/themeselection/sneat-html-admin-template-free/issues"
                    target="_blank"
                    class="footer-link me-4"
                    >Support</a
                  >
                </div> -->
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- <div class="buy-now">
      <a
        href="https://themeselection.com/products/sneat-bootstrap-html-admin-template/"
        target="_blank"
        class="btn btn-danger btn-buy-now"
        >Upgrade to Pro</a
      >
    </div> -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('assets') }}/vendor/libs/jquery/jquery.js"></script>
    <script src="{{ asset('assets') }}/vendor/libs/popper/popper.js"></script>
    <script src="{{ asset('assets') }}/vendor/js/bootstrap.js"></script>
    <script src="{{ asset('assets') }}/vendor/js/extensions/sweetalert2.all.min.js"></script>
    <script src="{{ asset('assets') }}/vendor/js/extensions/toastr.min.js"></script>

    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
    <script src="{{ asset('assets') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="{{ asset('assets') }}/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('assets') }}/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets') }}/js/main.js"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets') }}/js/dashboards-analytics.js"></script>
    <script src="{{ asset('assets/apex-charts/apexcharts.js') }}"></script>
    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @yield('js')
    @include('AdminPanel.layouts.common.deleteConfirm')
    {{-- @include('AdminPanel.layouts.common.tinymce') --}}

    @if (Session::get('success'))
<script>
    $(window).on('load', function() {
        setTimeout(function() {
            toastr['success'](
                '{{ Session::get('success') }}',
                '👋 {{ trans('common.successMessageTitle') }}', {
                    closeButton: true,
                    tapToDismiss: false,
                    rtl: '{{ trans('common.dir') }}'
                }
            );
        }, 100);
    })
</script>
@endif

    @if (Session::get('faild'))
<script>
    $(window).on('load', function() {
        setTimeout(function() {
            toastr['error'](
                '{{ Session::get('faild') }}',
                '👋 {{ trans('common.faildMessageTitle') }}', {
                    closeButton: true,
                    tapToDismiss: false,
                    rtl: '{{ trans('common.dir') }}'
                }
            );
        }, 100);
    })
</script>
        {{ Session::forget('faild') }}
@endif
  </body>
</html>
