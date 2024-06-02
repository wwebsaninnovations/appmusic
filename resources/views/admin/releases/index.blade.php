@extends('admin.layouts.app')

@section('content')
<div class="row justify-content-center release-card-intermediate">
    <div class="col-md-12 mt-1">
        <div class="card">

             <div class="form-search">
                <div class="search-container">
                    <input type="text" id="searchInput" placeholder="Search an artist or title">
                    <div class="icons">
                         <i class="fa-solid fa-magnifying-glass" id="searchIcon"></i>
                      
                        <i class="fas fa-times" id="clearIcon"></i>
                        <i class="fas fa-spinner fa-spin" id="loadingIcon"></i>
                    </div>
                </div>
             </div>
             
            <div class="card-header">All Releases</div>
            <div class="card-body">
                <!-- <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                        <th scope="col">S#</th>
                        <th scope="col">thumbnail</th>
                        <th scope="col">Format</th>
                        <th scope="col">Audio,Mp3</th>
                        <th scope="col">Form Status</th>
                        <th scope="col">Release Status</th>
                        <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($releases as $release)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td><img src="{{ asset('storage/'.$release->thumbnail_path)}}" width="150px"></td>
                            <td>{{ $release->format }}</td>
                            <td>
                                @foreach(($release->tracks) as $track)
                                    <p>{{ basename($track->track_path) }}</p>
                                @endforeach
                            </td>
                            <td>
                                @if($release->form_status == 0)
                                    <span class="badge bg-warning">Incomplete</span>
                                @else
                                    <span class="badge bg-success">Completed</span>
                                @endif
                            </td>

                            <td>
                                @php
                                    $status = $release->status;
                                    $statusText = '';
                                    $badgeClass = '';
                                    switch($status) {
                                        case 0:
                                            $statusText = 'Pending';
                                            $badgeClass = 'badge bg-warning';
                                            break;
                                        case 1:
                                            $statusText = 'Processing';
                                            $badgeClass = 'badge bg-primary';
                                            break;
                                        case 2:
                                            $statusText = 'Rejected';
                                            $badgeClass = 'badge bg-danger';
                                            break;
                                        case 3:
                                            $statusText = 'Approved';
                                            $badgeClass = 'badge bg-success';
                                            break;
                                        default:
                                            $statusText = 'Unknown';
                                            $badgeClass = 'badge bg-dark';
                                            break;
                                    }
                                @endphp

                                <span class="{{ $badgeClass }}">{{ $statusText }}</span>
                            </td>

                            <td>
                                <form action="{{ route('releases.destroy', $release->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{route('releases.step2', ['release_id'=>$release->id, 'level'=>'basic'])}}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>  
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this user?');"><i class="bi bi-trash"></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                            <td colspan="6">
                                <span class="text-danger">
                                    <strong>No  Found!</strong>
                                </span>
                            </td>
                        @endforelse
                     
                    </tbody>
                </table> -->
                <!-- Pagination links -->
                <div class="container">
                  
                    <div class="row" id="searchResults">

                   
                        @forelse ($releases as $release)
                        <div class="col-md-4">
                            <div class="release-card">
                                <div class="wrap-image">
                                     <img src="{{ $release->thumbnail_path ? asset('storage/'.$release->thumbnail_path) : 'https://via.placeholder.com/150' }}" alt="Thumbnail">
                                </div>
                                <div class="release-card-body">
                                    <div class="releast_heading">
                                        <div class="release-card-title">{{ $release->format }}</div>
                                        <span class="release-card-status {{ $release->form_status == 0 ? 'bg-warning' : 'bg-success' }}">
                                            {{ $release->form_status == 0 ? 'Incomplete' : 'Completed' }}
                                        </span>
                                    </div>
                                    <div class="release-card-date">Created on: {{ $release->created_at->format('M d, Y') }}</div>  
                                    @php
                                        $status = $release->status;
                                        $statusText = '';
                                        $badgeClass = '';
                                        switch($status) {
                                            case 0:
                                                $statusText = 'Pending';
                                                $badgeClass = 'badge bg-warning';
                                                break;
                                            case 1:
                                                $statusText = 'Processing';
                                                $badgeClass = 'badge bg-primary';
                                                break;
                                            case 2:
                                                $statusText = 'Rejected';
                                                $badgeClass = 'badge bg-danger';
                                                break;
                                            case 3:
                                                $statusText = 'Approved';
                                                $badgeClass = 'badge bg-success';
                                                break;
                                            default:
                                                $statusText = 'Unknown';
                                                $badgeClass = 'badge bg-dark';
                                                break;
                                        }
                                    @endphp
                                    <span class="{{ $badgeClass }}">{{ $statusText }}</span>
                                    <div class="actions">
                                        <form action="{{ route('releases.destroy', $release->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('releases.step2', ['release_id' => $release->id, 'level' => 'basic']) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this user?');"><i class="bi bi-trash"></i> Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @empty
                        <div class="col-12">
                            <span class="text-danger">
                                <strong>No Releases Found!</strong>
                            </span>
                        </div>
                        @endforelse


                    
                    </div>
                </div>



                     {{ $releases->links() }}
            </div>
        </div>
     </div>
</div>

@endsection