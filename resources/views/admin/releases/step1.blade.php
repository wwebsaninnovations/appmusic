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
                    <form action="{{ route('releases.step1.save') }}" method="POST">
                        @csrf
                        <!-- Step 1: Choose Format -->
                        <div class="mb-3">
                            <label for="format" class="form-label">Format</label>
                            <select class="form-select" id="format" name="format">
                                <option value="">Select Format</option>
                                <option value="single" {{ old('format') == 'single' ? 'selected' : '' }}>Single</option>
                                <option value="ep" {{ old('format') == 'ep' ? 'selected' : '' }}>EP</option>
                                <option value="album" {{ old('format') == 'album' ? 'selected' : '' }}>Album</option>
                            </select>
                            @if ($errors->has('format'))
                                <div class="text-danger">
                                    {{ $errors->first('format') }}
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="release_name" class="form-label">Release Name</label>
                            <input type="text" class="form-control" id="release_name" name="release_name" value="{{ old('release_name') }}">
                            @if ($errors->has('release_name'))
                                <div class="text-danger">
                                    {{ $errors->first('release_name') }}
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="release_version" class="form-label">Release Version</label>
                            <input type="text" class="form-control" id="release_version" name="release_version" value="{{ old('release_version') }}">
                            @if ($errors->has('release_version'))
                                <div class="text-danger">
                                    {{ $errors->first('release_version') }}
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="release_code" class="form-label">Release Code (Only Numeric)</label>
                            <input type="text" class="form-control" id="release_code" name="release_code" value="{{ old('release_code') }}">
                            @if ($errors->has('release_code'))
                                <div class="text-danger">
                                    {{ $errors->first('release_code') }}
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="upc" class="form-label">UPC (Only Numeric)</label>
                            <input type="text" class="form-control" id="upc" name="upc" value="{{ old('upc') }}">
                            @if ($errors->has('upc'))
                                <div class="text-danger">
                                    {{ $errors->first('upc') }}
                                </div>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">Create New Release</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
