@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="container">
<div class="row justify-content-center">
    <div class="col-md-12 mt-5">
        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    Edit Ownershiptype
                </div>
                <div class="float-end">
                    <a href="{{ route('ownershiptypes.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">
            <form action="{{ route('ownershiptypes.update', $ownershiptype->id) }}" method="post">
                @csrf
                @method('PUT')
                <!-- For each field, label directly above the input -->

                <div class="mb-3 row">
                    <div class="col-md-6">
                        <input type="text" placeholder="Enter ownershiptype" class="form-control @error('name') is-invalid @enderror" id="title" name="name" value="{{ $ownershiptype->name }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-12 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary saveBtn">Update</button>
                    </div>
                </div>

            </form>
            </div>
        </div>
    </div>
</div>    
</div>
</div>  
@endsection
