@extends('admin.layouts.app')

@section('content')

  <!-- Content wrapper -->
  <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
                <div class="row g-4 mb-4">
                    <div class="col-sm-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                            <span>Total Releases</span>
                            <div class="d-flex align-items-end mt-2">
                                <h4 class="mb-0 me-2" id="recordsTotal"></h4>
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
                                <h4 class="mb-0 me-2" id="totalApproved"></h4>
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
                                <h4 class="mb-0 me-2" id="totalPending"></h4>
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
                                                    <h4 class="mb-0 me-2" id="totalRejected"></h4>
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
                                                    <h4 class="mb-0 me-2" id="totalComplete"></h4>
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
                                                    <h4 class="mb-0 me-2" id="totalIncomplete"></h4>
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
                                    <h4 class="mb-0 me-2" id="totalTracks" ></h4>
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
                                    <h4 class="mb-0 me-2" id="totalTracksApproved"></h4>
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
              <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Manage Release/</span>All</h4>

              <!-- DataTable with Buttons -->
              <a class="btn btn-primary mb-3" href="{{ route('releases.step1') }}">Add New Release</a>
              <div class="card p-2">
             
              <table id="example" class="display" style="width:100%">
                        <thead>
                            <tr>
                               <th>Select</th>
                                <th>id</th>
                                <th>Thumbnail</th>
                                <th>Release Name</th>
                                <th>Format</th>
                                <th>Code</th>
                                <th>Upc</th>
                                <th>Status</th>
                                <th>Form Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                       
                    </table>



                </div>
              </div>
       
          
              <!--/ DataTable with Buttons -->     
 </div>
@endsection