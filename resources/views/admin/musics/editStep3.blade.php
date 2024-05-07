
@extends('admin.layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Upload Music Track - Step 3</div>

                    <div class="card-body">
                        <form action="{{route('musics.update',$music->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method("PUT")

                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                           @endif

                            <!-- Step 3: Upload track -->
                            <div class="mb-3">
                                <label for="trackFile" class="form-label">Upload Track</label>
                                <input type="file" class="form-control" id="trackFile" name="trackFile[]" multiple>
                                <input type="hidden" name="music_id" value="{{$music->id}}" />
                                @foreach(json_decode($music->track_paths) as $track)
                                    <audio controls>
                                        <source src="{{ asset($track) }}" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                    <p>{{ basename($track) }}</p>
                                @endforeach

                                <div id="trackFileHelp" class="form-text">Choose single file for single, max 5 files for EP, and max 30 files for Album.</div>

                            </div>

                            <a href="{{route('musics.editStep2', $music->id)}}" class="btn btn-secondary">Previous</a>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection