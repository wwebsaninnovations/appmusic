@extends('admin.layouts.app')

@section('content')
<!-- Content wrapper -->
<div class="content-wrapper">
<div class="container-xxl flex-grow-1 container-p-y" >
<div class="card">
    @if ($message = Session::get('success'))
        <div class="alert alert-success text-center" role="alert">
             {{ $message }}
        </div>
    @endif
    <div class="card-body">
        <a href="{{ route('platforms.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Add New Platform</a>

        <table class="table table-striped table-bordered mb-3">
            <thead>
                <tr>
                    <th scope="col">S#</th>
                    <th scope="col">Name</th>
                    <th scope="col" style="width: 250px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($platforms as $platform)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $platform->name }}</td>
                    <td>
                        <form action="{{ route('platforms.destroy', $platform->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <!-- <a href="{{ route('platforms.show', $platform->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Show</a> -->
                            <a href="{{ route('platforms.edit', $platform->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this book?');"><i class="bi bi-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <span class="text-danger">
                            <strong>Not Found!</strong>
                        </span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $platforms->links() }}
    </div>
</div>
</div>
</div>
@endsection
