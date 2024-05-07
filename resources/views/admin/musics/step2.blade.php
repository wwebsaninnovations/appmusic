
@extends('admin.layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Upload Music Track - Step 2</div>

                    <div class="card-body">
                    <form action="{{ route('musics.step2.save') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Display validation errors -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Step 2: Thumbnail image, Title, Artist, Track code, Release date, Genre -->
                        <div class="mb-3">
                            <label for="thumbnail" class="form-label">Thumbnail Image (1000x1000)</label>
                            <input type="file" class="form-control" id="thumbnail" name="thumbnail">
                            <input type="hidden" name="music_id" value="{{$music_id}}" />
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Title of Track</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
                        </div>

                        <div class="mb-3">
                            <label for="artist" class="form-label">Artist</label>
                            <input type="text" class="form-control" id="artist" name="artist" value="{{ old('artist') }}">
                        </div>

                        <div class="mb-3">
                            <label for="trackCode" class="form-label">Track Code</label>
                            <input type="text" class="form-control" id="trackCode" name="trackCode" value="{{ old('trackCode') }}">

                            <a class="text-warning" onclick="generateTrackCode()"> Generate Track Code</a>
                        </div>

                        <div class="mb-3">
                            <label for="releaseDate" class="form-label">Release Date</label>
                            <input type="date" class="form-control" id="releaseDate" name="releaseDate" value="{{ old('releaseDate') }}">
                        </div>

                        <div class="mb-3">
                            <label for="genre" class="form-label">Genre</label>
                            <input type="text" class="form-control" id="genre" name="genre" value="{{ old('genre') }}">
                        </div>

                        <a href="{{ route('musics.step1') }}" class="btn btn-secondary">Previous</a>
                        <button type="submit" class="btn btn-primary">Next</button>
                    </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
            function generateTrackCode() {
                    $.ajax({   
                        url: "{{route('musics.trackCode')}}",  
                        success : function(data) {   
                          $('#trackCode').val(data.trackCode);
                        }, 
                        error : function(data) {   
                           // console.log(data);
                        } 
                    });
            }
    </script>
    
@endsection