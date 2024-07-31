@extends('admin.layouts.app')

@section('content')

  <!-- Content wrapper -->
  <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y" >
              <!-- <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Catalog/</span>All</h4> -->
              <!-- DataTable with Buttons -->
                <?php
                    // if(isset($_GET['userid']) && $_GET['userid']){
                    //     $userID = $_GET['userid'];
                    // }
                    // echo '<input type="hidden" id="userID" value="'.$userID.'">';
                ?>
              <a class="btn btn-primary mb-3" href="{{ route('releases.step1') }}">Create New Release</a>
              <div class="card p-2">
                    <table id="releaseTable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th class="no-order"></th> 
                                <th>Id</th>                      
                                <th>Release Id</th>
                                <th class="no-order">Artwork</th>
                                <th>Release Name</th>
                                <th class="no-order">Format</th>
                                <th>Code</th>
                                <th>Upc</th>
                                <th class="no-order">Status</th>
                                <th class="no-order">Form Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                       
                    </table>



                </div>
              </div>
       
          
              <!--/ DataTable with Buttons -->     
 </div>
@endsection