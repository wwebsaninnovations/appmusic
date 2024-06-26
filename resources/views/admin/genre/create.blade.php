@extends('admin.layouts.app')

@section('content')
<div class="row justify-content-center mt-2">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
              
                <div class="float-start">
                   Add New Genre
                </div>
                <div class="float-end">
                    <a href="{{ route('genre.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">
            <form action="{{ route('genre.store') }}" method="post">
                @csrf
                <div class="mb-3 row">
                    <div class="col-md-8">
                        <input type="text" placeholder="Enter genre" class="form-control @error('name') is-invalid @enderror" id="title" name="name" value="{{ old('genre') }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>

            </form>
            </div>
        </div>
    </div>
</div>    
@endsection
