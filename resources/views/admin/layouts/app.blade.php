<!doctype html>

@php $html_class="light-style layout-navbar-fixed layout-menu-fixed"; @endphp
@auth
    @if(Auth::user()->theme_mode =='dark')
    @php $html_class="layout-navbar-fixed dark-style layout-menu-fixed "; @endphp
    @endif
@endauth    
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
  
  class="{{$html_class}}"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ asset('/') }}"
  data-template="vertical-menu-template-starter"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Karhari Media Industry') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <!-- <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet"> -->


<!-- THEME INT START-->

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
<!-- Icons -->
<link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<!-- Icons -->
<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />

<!-- Core CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

<!-- Vendors CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/dropzone/dropzone.css') }}" />

<!-- Page CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/pages/page-auth.css')}}" />
<!-- Helpers -->
<script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>

<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
<script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="{{ asset('assets/js/config.js') }}"></script>

<!-- Core CSS -->
@php $classDark =""; @endphp
@auth
    @if(Auth::user()->theme_mode =='dark')
    @php  $classDark = "dark-mode"; @endphp
     
        <link rel="stylesheet"  type="text/css" href="{{ asset('assets/vendor/css/rtl/core-dark.css') }}"  />
        <link rel="stylesheet"  type="text/css" href="{{ asset('assets/vendor/css/rtl/theme-default-dark.css') }}" />
    @else
    @php  $classDark = "white-mode"; @endphp
    
        <link rel="stylesheet"  type="text/css" href="{{ asset('assets/vendor/css/rtl/core.css') }}"  />
        <link rel="stylesheet"  type="text/css" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}" />
    @endif

    @else
       <link rel="stylesheet"  type="text/css" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
       <link rel="stylesheet"  type="text/css" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css" />
@endauth

      <link rel="stylesheet"  type="text/css" href="{{ asset('assets/custom/css/custom.css') }}"/>

</head>
<body class="{{$classDark}}">
    <div id="app">
        <main class="py-0">
          <div class="site-container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                       @if ($message = Session::get('success'))
                            <div class="alert alert-success text-center" role="alert">
                                {{ $message }}
                            </div>
                        @endif

                        <div class="layout-wrapper layout-content-navbar">
                            <div class="layout-container">
                            @auth 
                                @include('admin.layouts.aside') 
                                <div class="layout-page">
                                    @include('admin.layouts.nav')
                                    @yield('content')
                                </div>
                            @else
                                 @yield('content') 
                            @endauth
                    </div>
               </div>
          </div>

        </main>
    </div>


<div class="layout-overlay layout-menu-toggle"></div>
    <div class="drag-target"></div>
</div>
<!-- jQuery and other libraries -->


    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
<script src="{{ asset('js/app.js') }}"></script>    
<script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

<script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>

<script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
<!-- endbuild -->

<!-- FormValidation Plugin and its dependencies -->
<script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>

<!-- Vendors JS -->
<script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

<!-- Main JS -->
<script src="{{ asset('assets/vendor/libs/dropzone/dropzone.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/js/forms-file-upload.js') }}"></script>

<!-- Page JS -->
<script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
<script src="{{ asset('assets/js/pages-auth.js') }}"></script>
<script src="{{ asset('assets/custom/js/custom.js') }}"></script>

</body>
</html>
