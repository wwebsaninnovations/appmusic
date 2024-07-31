@extends('admin.layouts.app')
@section('content')

<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                        <div class="flex-shrink-0  mx-sm-0 mx-auto">
                            <img src="{{ asset('assets/img/avatars/companyImg.png') }}" alt class="d-block h-auto ms-0 ms-sm-4 rounded user-profile-img _user-profile-img">
                        </div>
                        <div class="flex-grow-1 mt-3 mt-sm-5">
                            <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                                <div class="user-profile-info">
                                    <h4>{{ Auth::user()->name }}</h4>
                                    <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                        <li class="list-inline-item fw-semibold"><i class="bx bx-user"></i>{{ Auth::user()->name }}</li>
                                        <li class="list-inline-item fw-semibold"><i class="bx bx-envelope"></i>{{ Auth::user()->email }}</li>
                                        <li class="list-inline-item fw-semibold"><i class="bx bx-user"></i> Client Id: {{ Auth::user()->client_id }}</li>
                                        <li class="list-inline-item fw-semibold">
                                            <i class="bx bx-calendar-alt"></i> Joined {{ Auth::user()->created_at->format('d F Y') }}
                                        </li>
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Profile Content -->
        <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-5">
                <!-- About User -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="_editprofile">
                            <small class="text-muted text-uppercase">About</small>
                            <a href="{{ route('profileEdit') }}"><i class="bx bx-edit"></i> Edit</a>
                        </div>
                        <ul class="list-unstyled mb-4 mt-3">
                            <li class="d-flex align-items-center mb-3">
                                <i class="bx bx-user"></i><span class="fw-semibold mx-2">Full Name:</span>
                                <span>{{ Auth::user()->name }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <i class="bx bx-check"></i><span class="fw-semibold mx-2">Status:</span> <span>Active</span>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <i class="bx bx-star"></i><span class="fw-semibold mx-2">Role:</span> <span>Admin</span>
                            </li>
                        </ul>
                        <small class="text-muted text-uppercase">Contacts</small>
                        <ul class="list-unstyled mb-4 mt-3">
                            <li class="d-flex align-items-center mb-3">
                                <i class="bx bx-phone"></i><span class="fw-semibold mx-2">Contact:</span>
                                <span>{{ Auth::user()->mobile }}</span>
                            </li>
                            <li class="d-flex align-items-center mb-3">
                                <i class="bx bx-envelope"></i><span class="fw-semibold mx-2">Email:</span>
                                <span>{{ Auth::user()->email }}</span>
                            </li>
                        </ul>

                        <!-- Social Links -->
                        <small class="text-muted text-uppercase">Social Links</small>
                        <ul class="list-unstyled mb-4 mt-3">
                            @php
                                $socialLinks = json_decode(Auth::user()->sociallinks, true);
                            @endphp
                            @if($socialLinks)
                                @foreach($socialLinks as $name => $url)
                                    <li class="d-flex align-items-center mb-3">
                                        <i class="bx bx-link"></i><span class="fw-semibold mx-2">{{ $name }}:</span>
                                        <a href="{{ $url }}" target="_blank">{{ $url }}</a>
                                    </li>
                                @endforeach
                            @else
                                <li>No social links available</li>
                            @endif
                        </ul>
                        <ul class="list-unstyled mb-4 mt-3">
                            <li class="d-flex align-items-center mb-3">
                                <a class="" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bx bx-power-off me-2"></i>
                                    <span class="align-middle">  {{ __('Log Out') }}</span>
                                </a>
                            </li>
                        </ul>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
                <!--/ About User -->
            </div>
        </div>
        <!--/ User Profile Content -->
    </div>
    <!-- / Content -->

    <div class="content-backdrop fade"></div>
</div>
</div>
<!-- / Layout page -->
</div>
@endsection
