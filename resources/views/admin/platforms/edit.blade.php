@extends('admin.layouts.app')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    Edit Platform
                </div>
                <div class="float-end">
                    <a href="{{ route('platforms.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">
            <form action="{{ route('platforms.update', $platform->id) }}" method="post">
                @csrf
                @method('PUT')
                <!-- For each field, label directly above the input -->

                <div class="mb-3 row">
                    <div class="col-md-8">
                        <input type="text" placeholder="Enter platform" class="form-control @error('name') is-invalid @enderror" id="title" name="name" value="{{ $platform->name }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>

            </form>
            </div>
        </div>
    </div>
</div>    
@endsection
