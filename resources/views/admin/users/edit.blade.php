@extends('admin.layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10 mt-5">
        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    Edit User
                </div>
                <div class="float-end">
                    <a href="{{ route('users.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('users.update', $user->id) }}" method="post">
                    @csrf
                    @method("PUT")

                    <div class="mb-3 row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $user->name }}">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="email" class="col-md-4 col-form-label text-md-end text-start">Email Address</label>
                        <div class="col-md-6">
                          <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $user->email }}">
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="mobile" class="col-md-4 col-form-label text-md-end text-start">phone Number</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile" value="{{ $user->mobile }}">
                            @if ($errors->has('mobile'))
                                <span class="text-danger">{{ $errors->first('mobile') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="password" class="col-md-4 col-form-label text-md-end text-start">Password</label>
                        <div class="col-md-6">
                          <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="password_confirmation" class="col-md-4 col-form-label text-md-end text-start">Confirm Password</label>
                        <div class="col-md-6">
                          <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>
                    </div>
                      <!-- Full Address -->
                      <div class="mb-3 row">
                        <label for="full_address" class="col-md-4 col-form-label text-md-end text-start">Full Address</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control @error('full_address') is-invalid @enderror" id="full_address" name="full_address" value="{{ $user->full_address }}">
                            @error('full_address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Company Label -->
                    <div class="mb-3 row">
                        <label for="company_label" class="col-md-4 col-form-label text-md-end text-start">Company Label</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control @error('company_label') is-invalid @enderror" id="company_label" name="company_label" value="{{$user->company_label }}">
                            @error('company_label')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="roles" class="col-md-4 col-form-label text-md-end text-start">Roles</label>
                        <div class="col-md-6">           
                            <select class="form-select @error('roles') is-invalid @enderror"  aria-label="Roles" id="roles" name="roles">
                            @forelse ($roles as $role)

                                                                
                                @if (Auth::user()->hasRole('Super Admin') )   
                                    
                                        @if($user->hasRole('Super Admin') ) 

                                                @if($role == 'Super Admin')
                                                    <option value="{{ $role }}" {{$user->hasRole($role) == $role ? 'selected' : '' }}>
                                                        {{ $role }}
                                                    </option>
                                                @endif
                                            
                                            @else

                                                @if($role != 'Super Admin')
                                                    <option value="{{ $role }}" {{ $user->hasRole($role) == $role ? 'selected' : '' }}>
                                                        {{ $role }}
                                                    </option>
                                                @endif
                                            
                                        @endif
                                        
                                    @else

                                        @if( $role == 'User') 
                                            <option value="{{ $role }}" {{ $user->hasRole($role) == $role ? 'selected' : '' }}>
                                                {{ $role }}
                                            </option>
                                        @endif
                                @endif 

                                @empty

                                @endforelse
                            </select>
                            @if ($errors->has('roles'))
                                <span class="text-danger">{{ $errors->first('roles') }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Update User">
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>    
@endsection
