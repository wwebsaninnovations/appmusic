
@extends('admin.layouts.app')

@section('content')

  <!-- Content wrapper -->
  <!-- <div class="content-wrapper"> -->
        <!-- Content -->
        <div class="container" >

            <div class="row">
                <div class="col-lg-12 my-3">
                   
                    <!-- <div class="float-end">
                        <div class="btn-group">
                            <button class="btn btn-info" id="list">
                                <i class="bx bx-list-ul bx-sm"></i> List
                            </button>
                            <button class="btn btn-danger" id="grid">
                                <i class="bx bx-grid-alt bx-sm"></i> Grid
                            </button>
                        </div>
                    </div> -->
                </div>
            </div>
        


            <!-- Display success message -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- <ul class="list-pills-tab">
                <li>
                    <a href="{{ route('releases.index') }}" 
                    class="{{ request()->query('status') === null ? 'active' : '' }}">
                        All ({{ $totalRelease }})
                    </a>
                </li>

            </ul> -->
                
        <div class="dropdown-filter">

            <div class="createCata-btn">
                <a class="btn btn-primary mb-3" href="{{ route('releases.step1') }}" style="margin: 0 !important;">Create Catalog</a>
            </div>
            <div class="searchRelease">
                <form method="GET" action="{{ route('releases.index') }}">
                    <!-- <div class="row"> -->
                        <div class="wrap-input">
                            <input type="text" name="search" class="form-control" placeholder="Search Releases" value="{{ request()->query('search') }}">
                            <button type="submit" class="btn btn-primary"><i class="menu-icon tf-icons bx bx-search"></i>
                            </button>
                        </div>
                    <!-- </div> -->
                </form>
            </div>

            <div class="right">
                <ul class="searchLabel">
                    <li><label class="dropdown-button-label">Filter by:</label></li>
                    <li class="dropdown-button">
                        {{ request()->query('status') === null ? 'All Releases' : ucfirst(request()->query('status')) }} <i class="bx bx-chevron-down"></i>
                    </li>
                </ul>
                <ul class="list-pills-tab dropdown-menu">
                    <li>
                        <a href="{{ route('releases.index') }}" 
                        data-status="all" 
                        class="{{ request()->query('status') === null ? 'active' : '' }}">
                            All ({{ $totalRelease }})
                        </a>
                    </li>
                    <li>
                         <a href="{{ route('releases.index', ['status' => 'draft']) }}" 
                        class="{{ request()->query('status') === 'draft' ? 'active' : '' }}">
                            Draft ({{ $totalDraft }} items)
                        </a>

                            </li>
                     
                            <li>
                                <a href="{{ route('releases.index', ['status' => 'pending']) }}" 
                                class="{{ request()->query('status') === 'pending' ? 'active' : '' }}">
                                    Pending ({{ $totalPending }} items)
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('releases.index', ['status' => 'rejected']) }}" 
                                class="{{ request()->query('status') === 'rejected' ? 'active' : '' }}">
                                    Rejected ({{ $totalRejected }} items)
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('releases.index', ['status' => 'approved']) }}" 
                                class="{{ request()->query('status') === 'approved' ? 'active' : '' }}">
                                    Approved ({{ $totalApproved }} items)
                                </a>
                            </li>
                     
                            <li>
                                <a href="{{ route('releases.index', ['status' => 'delivered']) }}" 
                                class="{{ request()->query('status') === 'delivered' ? 'active' : '' }}">
                                    Delivered ({{ $totalDelivered }} items)
                                </a>
                            </li>
                            
                            <li>
                                <a href="{{ route('releases.index', ['status' => 'takedown']) }}" 
                                class="{{ request()->query('status') === 'takedown' ? 'active' : '' }}">
                                    Take Down ({{ $totalTakedown }} items)
                                </a>
                            </li>
                    <!-- Add more list items as needed -->
                </ul>
            </div>
        </div>


        <div class="row">
            <ul class="list-pills-tab custom_inline_style">
                <li>
                    <a href="{{ route('releases.index') }}" 
                    data-status="all" 
                    class="{{ request()->query('status') === null ? 'active' : '' }}">
                        All ({{ $totalRelease }})
                    </a>
                </li>
                    <li>
                    <a href="{{ route('releases.index', ['status' => 'draft']) }}" 
                    class="{{ request()->query('status') === 'draft' ? 'active' : '' }}">
                        Draft ({{ $totalDraft }} items)
                    </a>
                </li>
               
                <li>
                    <a href="{{ route('releases.index', ['status' => 'pending']) }}" 
                    class="{{ request()->query('status') === 'pending' ? 'active' : '' }}">
                        Pending ({{ $totalPending }} items)
                    </a>
                </li>
                <li>
                    <a href="{{ route('releases.index', ['status' => 'rejected']) }}" 
                    class="{{ request()->query('status') === 'rejected' ? 'active' : '' }}">
                        Rejected ({{ $totalRejected }} items)
                    </a>
                </li>
                <li>
                    <a href="{{ route('releases.index', ['status' => 'approved']) }}" 
                    class="{{ request()->query('status') === 'approved' ? 'active' : '' }}">
                        Approved ({{ $totalApproved }} items)
                    </a>
                </li>
                <li>
                    <a href="{{ route('releases.index', ['status' => 'delivered']) }}" 
                    class="{{ request()->query('status') === 'delivered' ? 'active' : '' }}">
                        Delivered ({{ $totalDelivered }} items)
                    </a>
                </li>
                
                <li>
                    <a href="{{ route('releases.index', ['status' => 'takedown']) }}" 
                    class="{{ request()->query('status') === 'takedown' ? 'active' : '' }}">
                        Take Down ({{ $totalTakedown }} items)
                    </a>
                </li>
            </ul>
        </div>

        
        <div id="products" class="row view-group">
            @forelse($releases as $release)
                <div class="item  col-xs-3 col-lg-3">
                    <div class="card">
                        <div class="img-event">

                        @php 
                            $thumbsrc = "https://cms.karharimedia.com/dummy_image.jpg";
                            if($release->thumbnail_path) {
                                $thumbsrc = asset('storage/' . $release->thumbnail_path);
                            }
                        @endphp

                        <a  href="{{ route('releases.step2', ['release_id' => $release->id, 'level' => 'summary']) }}">
                        <img class="group list-group-image img-fluid" src="{{ $thumbsrc }}" alt="Product Image" /></a>

                        </div>
                        
                        <div class="card-body customBox">
                            <h4 class="card-title"> <a  href="{{ route('releases.step2', ['release_id' => $release->id, 'level' => 'summary']) }}">
                            {{ $release->release_name }}
                                </a></h4>
                            <span class="badge bg-primary sts">{{ $release->format }}</span>
                            @if($release->status == 0)
                                <span class="badge bg-warning sts">Draft</span>
                            @elseif($release->status == 1)
                                <span class="badge bg-info sts">Pending</span>
                            @elseif($release->status == 2)
                                <span class="badge bg-danger sts">Rejected</span>
                            @elseif($release->status == 3)  
                                <span class="badge bg-success sts">Approved</span>
                            @else
                            <span class="badge bg-info sts">Delivered</span>
                            @endif
                    


                            <div class="editAction">
                                @canany(['approve-release'])
                                    <a class="badge bg-label-primary sts" href="{{ route('releases.step2', ['release_id' => $release->id, 'level' => 'summary']) }}">
                                            <i class="bx bx-edit-alt"></i>
                                    </a>
                                @else
                                    @if($release->status == 0|| $release->status == 2)
                                        <a class="badge bg-label-primary sts" href="{{ route('releases.step2', ['release_id' => $release->id, 'level' => 'summary']) }}">
                                                <i class="bx bx-edit-alt"></i>
                                        </a>
                                    @else
                                        <a class="badge bg-label-primary sts" href="{{ route('releases.step2', ['release_id' => $release->id, 'level' => 'summary']) }}">
                                                <i class="bx bx-show"></i>
                                        </a>
                                    @endif
                                @endcanany

                                <a href="#" class="badge bg-label-danger sts" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $release->id }}').submit();">
                                        <i class="bx bx-trash"></i>
                                </a>
                            </div>
                            <form id="delete-form-{{ $release->id }}" action="{{ route('releases.delete') }}" method="POST" style="display: none;">
                                @csrf
                                <input type="hidden" name="id" value="{{ $release->id }}">
                            </form>
                        
                            
                            
                        </div>
                    </div>
                </div>
            @empty
            <div class="col-12 text-center">
                <p class="notfound">
                    <?php 
                    if(isset($_GET['search'])){
                        echo 'No matches found. Please try again.';
                    }else{
                        echo '<a class="btn btn-primary mb-3" href="'.route('releases.step1').'" style="margin: 0 !important;">Create First Catalog</a>';
                    }
                    ?>
                    
                </p>
            </div>

            @endforelse
        </div><!-- product div end-->

        {{ $releases->links() }}
    
   </div>  

@endsection