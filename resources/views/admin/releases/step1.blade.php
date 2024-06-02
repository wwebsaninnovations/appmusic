@extends('admin.layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
 
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">New Release</div>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success text-center" role="alert">
                        {{ $message }}
                    </div>
                @endif
                <div class="card-body">
                    <form action="{{route('releases.step1.save')}}" method="POST">
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

                        <!-- Step 1: Choose Format -->
                        <div class="mb-3">
                            <label for="format" class="form-label">Format</label>
                            <select class="form-select" id="format" name="format">
                                <option value="">Select Format</option>
                                <option value="single" {{ old('format') == 'single' ? 'selected' : '' }}>Single</option>
                                <option value="ep" {{ old('format') == 'ep' ? 'selected' : '' }}>EP</option>
                                <option value="album" {{ old('format') == 'album' ? 'selected' : '' }}>Album</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="release_name" class="form-label">Release Name</label>
                            <input type="text" class="form-control" id="release_name" name="release_name" value="{{ old('release_name') }}">
                        </div>

                        <div class="mb-3">
                            <label for="release_version" class="form-label">Release Version</label>
                            <input type="text" class="form-control" id="release_version" name="release_version" value="{{ old('release_version') }}">
                        </div>

                        <div class="mb-3">
                            <label for="release_code" class="form-label">Release Code</label>
                            <input type="text" class="form-control" id="release_code" name="release_code" value="{{ old('release_code') }}">
                        </div>

                        <div class="mb-3">
                            <label for="upc" class="form-label">UPC</label>
                            <input type="text" class="form-control" id="upc" name="upc" value="{{ old('upc') }}">
                        </div>

                        <button type="submit" class="btn btn-primary">Create New Release</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
