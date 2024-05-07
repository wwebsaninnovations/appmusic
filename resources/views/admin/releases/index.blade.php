@extends('admin.layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10 mt-5 ">
        <div class="card">
            <div class="card-body">
                <a href="{{ route('releases.step1') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i>New Release</a>
               
            </div>
        </div>
     </div>
</div>
@endsection