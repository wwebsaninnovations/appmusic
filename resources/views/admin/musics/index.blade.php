@extends('admin.layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10 mt-5 ">
        <div class="card">
            <div class="card-body">
                <a href="{{ route('musics.step1') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i>New Release</a>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                        <th scope="col">S#</th>
                        <th scope="col">thumbnail</th>
                        <th scope="col">type</th>
                        <th scope="col">TrackCode</th>
                        <th scope="col">Audio,Mp3</th>
                        <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($musics as $music)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td><img src="{{ asset($music->thumbnail_path)}}" width="150px"></td>
                            <td>{{ $music->type }}</td>
            
                            <td>{{ $music->track_code }}</td>
                            <td>
                                @foreach(json_decode($music->track_paths) as $track)
                                    <audio controls>
                                        <source src="{{ asset($track) }}" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                    <p>{{ basename($track) }}</p>
                                @endforeach
                            </td>

                            <td>
                                <form action="{{ route('musics.destroy', $music->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')

                                    <a href="{{ route('musics.editStep1', $music->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>  
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

                {{ $musics->links() }}
            </div>
        </div>
     </div>
</div>
@endsection