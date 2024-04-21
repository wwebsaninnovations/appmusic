<!doctype html>
<!-- Drk
layout-navbar-fixed dark-style layout-menu-fixed layout-menu-collapsed
 -->

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
  class=""
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
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <!-- <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet"> -->


<!-- THEME INT START-->

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
<!-- Icons -->
<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />

<!-- <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" /> -->
<!-- Core CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}" />

<link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
<!-- Vendors CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />


<!-- <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" /> -->

<!-- Page CSS -->
<!-- <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" /> -->
<!-- Helpers -->



<!-- Template Customizer & Theme Config -->
<script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
<script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
<script src="{{ asset('assets/js/config.js') }}"></script>


<!-- Drk
layout-navbar-fixed dark-style layout-menu-fixed layout-menu-collapsed
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/css/rtl/core-dark.css') }}" class="template-customizer-core-css">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/css/rtl/theme-default-dark.css') }}" class="template-customizer-theme-css">
 -->

<!-- THEME INT END -->  

    <!-- Scripts -->

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }} ssdsd
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('admin.login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.login') }}">{{ __('Admin Login') }}</a>
                                </li>
                            @endif
                        @else
                            @canany(['create-role', 'edit-role', 'delete-role'])
                                <li><a class="nav-link" href="{{ route('roles.index') }}">Manage Roles</a></li>
                            @endcanany
                            @canany(['create-user', 'edit-user', 'delete-user','view-user'])
                                <li><a class="nav-link" href="{{ route('users.index') }}">Manage Users</a></li>
                            @endcanany

                            @canany(['create-book', 'edit-book', 'delete-book', 'view-book'])
                                <li><a class="nav-link" href="{{ route('books.index') }}">Manage Books</a></li>
                            @endcanany
                        
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
          <div class="site-container">
                <div class="row justify-content-center mt-3">
                    <div class="col-md-12">
                       @if ($message = Session::get('success'))
                            <div class="alert alert-success text-center" role="alert">
                                {{ $message }}
                            </div>
                        @endif

                        <div class="layout-wrapper layout-content-navbar">
                            <div class="layout-container">
                            @include('admin.layouts.aside')
                            
                            <div class="layout-page">
                            @include('admin.layouts.nav')
                        @yield('content')
                    </div>
               </div>
          </div>

        </main>
    </div>


<div class="layout-overlay layout-menu-toggle"></div>
    <div class="drag-target"></div>
</div>
<!-- jQuery and other libraries -->


<!-- SCRIPT START -->
<!-- Core libraries and utilities built into a single file -->
<script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>


<script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>


<script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<!-- <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script> -->
<script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>
<!-- <script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script> -->
<!-- <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script> -->
<script src="{{ asset('assets/vendor/js/menu.js') }}"></script>


<!-- FormValidation Plugin and its dependencies -->
<!-- <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script> -->
<!-- Main JavaScript file -->


<script src="{{ asset('assets/js/main.js') }}"></script>
<!-- Page specific JavaScript file -->
<!-- <script src="{{ asset('assets/js/pages-auth.js') }}"></script> -->
<!-- SCRIPT END -->

</body>
</html>
