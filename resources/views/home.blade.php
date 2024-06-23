@extends('admin.layouts.app')
@section('content')

      <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row">
              <div class="row g-4 mb-4">
                    <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                            <span>Total Releases</span>
                            <div class="d-flex align-items-end mt-2">
                                <h4 class="mb-0 me-2" >{{$totalRelease}}</h4>
                            </div>
                            </div>
                            <span class="badge bg-label-primary rounded p-2">
                            <i class="bx bxs-playlist bx-sm"></i>
                            </span>
                        </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                            <span>Approved</span>
                            <div class="d-flex align-items-end mt-2" >
                                <h4 class="mb-0 me-2" >{{$totalApproved}}</h4>
                            </div>
                            </div>
                            <span class="badge bg-label-success rounded p-2">
                            <i class="bx bxs-playlist bx-sm"></i>
                            </span>
                        </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                <span>Pending</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2" >{{$totalPending}}</h4>
                                </div>
                                </div>
                                <span class="badge bg-label-warning rounded p-2">
                                <i class="bx bxs-playlist bx-sm"></i>
                                </span>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="card">
                                <div class="card-body">
                                        <div class="d-flex align-items-start justify-content-between">
                                            <div class="content-left">
                                                <span>Rejected</span>
                                                <div class="d-flex align-items-end mt-2">
                                                    <h4 class="mb-0 me-2">{{$totalRejected}}</h4>
                                                </div>
                                            </div>
                                            <span class="badge bg-label-danger rounded p-2">
                                            <i class="bx bxs-playlist bx-sm"></i>
                                            </span>
                                        </div>
                                </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="card">
                                <div class="card-body">
                                        <div class="d-flex align-items-start justify-content-between">
                                            <div class="content-left">
                                                <span>Complete forms</span>
                                                <div class="d-flex align-items-end mt-2">
                                                    <h4 class="mb-0 me-2">{{$totalComplete}}</h4>
                                                </div>
                                            </div>
                                            <span class="badge bg-label-success rounded p-2">
                                            <i class="bx bx-detail bx-sm"></i>
                                            </span>
                                        </div>
                                </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="card">
                                <div class="card-body">
                                        <div class="d-flex align-items-start justify-content-between">
                                            <div class="content-left">
                                                <span>Incomplete forms</span>
                                                <div class="d-flex align-items-end mt-2">
                                                    <h4 class="mb-0 me-2" >{{$totalIncomplete}}</h4>
                                                </div>
                                            </div>
                                            <span class="badge bg-label-danger rounded p-2">
                                            <i class="bx bx-detail bx-sm"></i>
                                            </span>
                                        </div>
                                </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                <span>Total Tracks</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2" >{{$totalTracks}}</h4>
                                </div>
                                </div>
                                <span class="badge bg-label-primary rounded p-2">
                                <i class=" bx bx-play-circle bx-sm"></i>
                                </span>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <div class="card">
                            <div class="card-body">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                <span> Approved Tracks</span>
                                <div class="d-flex align-items-end mt-2">
                                    <h4 class="mb-0 me-2">{{$totalTracksApproved}}</h4>
                                </div>
                                </div>
                                <span class="badge bg-label-success rounded p-2">
                                <i class=" bx bx-play-circle bx-sm"></i>
                                </span>
                            </div>
                            </div>
                        </div>
                    </div>

                </div>
              </div>
              <div class="row">
                <div class="col-lg-8 mb-4 order-0">
                  <div class="card">
                    <div class="d-flex align-items-end row">
                      <div class="col-sm-7">
                        <div class="card-body">
                          <h5 class="card-title text-primary">Hello {{Auth::user()->name}}! 🎉</h5>
                          <p class="mb-2"><i class="bx bx-envelope"></i>{{Auth::user()->email}} </p>
                          <p class="mb-2"><i class="bx bx-user"></i> Client id: {{Auth::user()->client_id}} </p>

                          <a href="{{route('profile')}}" class="btn btn-sm btn-label-primary">View profile</a>
                        </div>
                      </div>
                      <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                          <img
                            src="../../assets/img/illustrations/man-with-laptop-light.png"
                            height="140"
                            alt="View Badge User"
                            data-app-dark-img="illustrations/man-with-laptop-dark.png"
                            data-app-light-img="illustrations/man-with-laptop-light.png"
                          />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4 col-md-4 order-1">
                  <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                      <div class="card">
                        <div class="card-body pb-0">
                          <span class="d-block fw-semibold mb-1">Order</span>
                          <h3 class="card-title mb-1">276k</h3>
                        </div>
                        <div id="orderChart" class="mb-3"></div>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                              <img
                                src="../../assets/img/icons/unicons/wallet-info.png"
                                alt="Credit Card"
                                class="rounded"
                              />
                            </div>
                            <div class="dropdown">
                              <button
                                class="btn p-0"
                                type="button"
                                id="cardOpt6"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                              >
                                <i class="bx bx-dots-vertical-rounded"></i>
                              </button>
                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                              </div>
                            </div>
                          </div>
                          <span>Sales</span>
                          <h3 class="card-title text-nowrap mb-1">$4,679</h3>
                          <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +28.42%</small>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Total Revenue -->
                <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
                  <div class="card">
                    <div class="row row-bordered g-0">
                      <div class="col-md-8">
                        <h5 class="card-header m-0 me-2 pb-3">Total Revenue</h5>
                        <div id="totalRevenueChart" class="px-2"></div>
                      </div>
                      <div class="col-md-4">
                        <div class="card-body">
                          <div class="text-center">
                            <div class="dropdown">
                              <button
                                class="btn btn-sm btn-label-primary dropdown-toggle"
                                type="button"
                                id="growthReportId"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                              >
                                2022
                              </button>
                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="growthReportId">
                                <a class="dropdown-item" href="javascript:void(0);">2021</a>
                                <a class="dropdown-item" href="javascript:void(0);">2020</a>
                                <a class="dropdown-item" href="javascript:void(0);">2019</a>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div id="growthChart"></div>
                        <div class="text-center fw-semibold pt-3 mb-2">62% Company Growth</div>

                        <div class="d-flex px-xxl-4 px-lg-2 p-4 gap-xxl-3 gap-lg-1 gap-3 justify-content-between">
                          <div class="d-flex">
                            <div class="me-2">
                              <span class="badge bg-label-primary p-2"><i class="bx bx-dollar text-primary"></i></span>
                            </div>
                            <div class="d-flex flex-column">
                              <small>2022</small>
                              <h6 class="mb-0">$32.5k</h6>
                            </div>
                          </div>
                          <div class="d-flex">
                            <div class="me-2">
                              <span class="badge bg-label-info p-2"><i class="bx bx-wallet text-info"></i></span>
                            </div>
                            <div class="d-flex flex-column">
                              <small>2021</small>
                              <h6 class="mb-0">$41.2k</h6>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--/ Total Revenue -->
                <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
                  <div class="row">
                    <div class="col-6 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                              <img src="../../assets/img/icons/unicons/paypal.png" alt="Credit Card" class="rounded" />
                            </div>
                            <div class="dropdown">
                              <button
                                class="btn p-0"
                                type="button"
                                id="cardOpt4"
                                data-bs-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                              >
                                <i class="bx bx-dots-vertical-rounded"></i>
                              </button>
                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                              </div>
                            </div>
                          </div>
                          <span class="d-block mb-1">Payments</span>
                          <h3 class="card-title text-nowrap mb-2">$2,456</h3>
                          <small class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i> -14.82%</small>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-4">
                      <div class="card">
                        <div class="card-body pb-2">
                          <span class="d-block fw-semibold mb-1">Revenue</span>
                          <h3 class="card-title mb-1">425k</h3>
                          <div id="revenueChart"></div>
                        </div>
                      </div>
                    </div>
                    <!-- </div>
                  <div class="row"> -->
                    <div class="col-12 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                            <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                              <div class="card-title">
                                <h5 class="text-nowrap mb-2">Profile Report</h5>
                                <span class="badge bg-label-warning rounded-pill">Year 2021</span>
                              </div>
                              <div class="mt-sm-auto">
                                <small class="text-success text-nowrap fw-semibold"
                                  ><i class="bx bx-chevron-up"></i> 68.2%</small
                                >
                                <h3 class="mb-0">$84,686k</h3>
                              </div>
                            </div>
                            <div id="profileReportChart"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
      </div>
@endsection
