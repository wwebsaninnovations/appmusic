@extends('admin.layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10 mt-5 ">
        <div class="card">
            <div class="card-body">
                <a href="{{ route('releases.step1') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i>New Release</a>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                        <th scope="col">S#</th>
                        <th scope="col">thumbnail</th>
                        <th scope="col">Format</th>
                        <th scope="col">Audio,Mp3</th>
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
                </table>
                     <!-- Pagination links -->
                     {{ $releases->links() }}
            </div>
        </div>
     </div>
</div>

@endsection