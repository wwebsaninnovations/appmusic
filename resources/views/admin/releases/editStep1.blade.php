@extends('admin.layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Upload Music Track - Step 1</div>

                    <div class="card-body">
                        <form action="{{ route('musics.editStep1.update') }}" method="POST" enctype="multipart/form-data">
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

                            <!-- Step 1: Choose Single file, EP, ALBUM -->
                            <div class="mb-3">
                                <label for="musicType" class="form-label"> Music Type</label>
                                <input type="hidden" name="music_id" value="{{$music->id}}"/>
                                <select class="form-select" id="musicType" name="musicType">


                                    <option value="" >Select Music Type</option>
                                    <option value="single" {{ $music->type == 'single' ? 'selected' : '' }}>Single</option>
                                    <option value="ep" {{ $music->type == 'ep' ? 'selected' : '' }}>EP</option>
                                    <option value="album" {{$music->type == 'album' ? 'selected' : '' }}>Album</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Next</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection