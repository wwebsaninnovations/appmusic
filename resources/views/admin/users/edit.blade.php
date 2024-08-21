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

                    <!-- Name -->
                    <div class="mb-3 row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $user->name }}" >
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-3 row">
                        <label for="email" class="col-md-4 col-form-label text-md-end text-start">Email Address</label>
                        <div class="col-md-6">
                          <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $user->email }}"  readonly>
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Mobile -->
                    <div class="mb-3 row">
                        <label for="mobile" class="col-md-4 col-form-label text-md-end text-start">Phone Number</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile" value="{{ $user->mobile }}">
                            @if ($errors->has('mobile'))
                                <span class="text-danger">{{ $errors->first('mobile') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-3 row">
                        <label for="password" class="col-md-4 col-form-label text-md-end text-start">Password</label>
                        <div class="col-md-6">
                          <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Confirm Password -->
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
                            <input type="text" class="form-control @error('company_label') is-invalid @enderror" id="company_label" name="company_label" value="{{ $user->company_label }}">
                            @error('company_label')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Roles -->
                    <div class="mb-3 row">
                        <label for="roles" class="col-md-4 col-form-label text-md-end text-start">Roles</label>
                        <div class="col-md-6">
                        <select class="form-select @error('roles') is-invalid @enderror" aria-label="Roles" id="roles" name="roles" {{ Auth::user()->id == $user->id ? 'disabled' : '' }}>
                            @forelse ($roles as $role)
                                @if (Auth::user()->id == $user->id)
                                    {{-- If the user is editing their own profile, show their current role and disable the select --}}
                                    @if($user->hasRole($role))
                                        <option value="{{ $role }}" selected>{{ $role }}</option>
                                    @endif
                                @elseif (Auth::user()->hasRole('Super Admin'))
                                    {{-- Super Admin cannot assign Super Admin role --}}
                                    @if($user->id !== Auth::user()->id && $role != 'Super Admin')
                                        <option value="{{ $role }}" {{ $user->hasRole($role) ? 'selected' : '' }}>{{ $role }}</option>
                                    @elseif($user->id == Auth::user()->id && $role == 'Super Admin')
                                        <option value="{{ $role }}" selected>{{ $role }}</option>
                                    @endif
                                @elseif (Auth::user()->can('create-user'))
                                    {{-- Users with create-user permission can only assign User role --}}
                                    @if($role == 'User')
                                        <option value="{{ $role }}" {{ $user->hasRole($role) ? 'selected' : '' }}>{{ $role }}</option>
                                    @endif
                                @else
                                    {{-- Normal users can see but not change their own role --}}
                                    @if($user->id == Auth::user()->id && $role == $user->roles->first()->name)
                                        <option value="{{ $role }}" selected>{{ $role }}</option>
                                    @endif
                                @endif
                            @empty
                                <option value="" disabled>No roles available</option>
                            @endforelse
                        </select>

                        {{-- Hidden input to store the role value when the select is disabled --}}
                        @if(Auth::user()->id == $user->id)
                            @foreach($roles as $role)
                                @if($user->hasRole($role))
                                    <input type="hidden" name="roles" value="{{ $role }}">
                                @endif
                            @endforeach
                        @endif

                            @if ($errors->has('roles'))
                                <span class="text-danger">{{ $errors->first('roles') }}</span>
                            @endif
                        </div>
                    </div>


                    <!-- Platform Selection -->
                    @canany(['create-user'])
                    <div class="mb-3 row">
                        <label for="platform" class="col-md-4 col-form-label text-md-end text-start">Select Platform</label>
                        <div class="col-md-6">
                            <div style="height: 200px; overflow-y: auto; border: 1px solid #ccc; padding: 10px;">
                                @php
                                    // Decode the JSON string into an array
                                    $selectedPlatforms = json_decode($user->platform_id, true) ?? [];
                                @endphp
                                @forelse($platforms as $platform)
                                    <div class="form-check">
                                        <input class="form-check-input @error('platform_id') is-invalid @enderror" type="checkbox" id="platform_id_{{ $platform->id }}" name="platform_id[]" value="{{ $platform->id }}"
                                            {{ in_array($platform->id, old('platform_id', $selectedPlatforms)) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="platform_id_{{ $platform->id }}">
                                            {{ $platform->name }}
                                        </label>
                                    </div>
                                @empty
                                    <span>No platforms available</span>
                                @endforelse
                            </div>
                            @error('platform_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    @endcanany

                       <!-- Social Links -->
                       <div class="mb-3 row">
                        <label for="social_links" class="col-md-4 col-form-label text-md-end text-start">Social Links</label>
                        <div class="col-md-6" id="social_links_container">
                            @php
                                $socialLinks = json_decode($user->sociallinks, true) ?? [];
                            @endphp
                            @foreach ($socialLinks as $name => $url)
                                <div class="input-group mb-2 social-link-item">
                                    <input type="text" class="form-control" name="social_links[name][]" placeholder="Social Link Name" value="{{ $name }}">
                                    <input type="url" class="form-control" name="social_links[url][]" placeholder="Social Link URL" value="{{ $url }}">
                                    <button type="button" class="btn btn-danger btn-remove-social-link">Remove</button>
                                </div>
                            @endforeach
                        </div>
                        <div class="col-md-6 offset-md-4">
                            <button type="button" class="btn btn-secondary" id="btn_add_social_link">Add Social Link</button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mb-3 row">
                        <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Update User">
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>    
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('btn_add_social_link').addEventListener('click', function() {
            var container = document.getElementById('social_links_container');
            var div = document.createElement('div');
            div.classList.add('input-group', 'mb-2', 'social-link-item');
            div.innerHTML = `
                <input type="text" class="form-control" name="social_links[name][]" placeholder="Social Link Name">
                <input type="url" class="form-control" name="social_links[url][]" placeholder="Social Link URL">
                <button type="button" class="btn btn-danger btn-remove-social-link">Remove</button>
            `;
            container.appendChild(div);
        });

        document.getElementById('social_links_container').addEventListener('click', function(event) {
            if (event.target.classList.contains('btn-remove-social-link')) {
                event.target.closest('.social-link-item').remove();
            }
        });
    });
</script>
@endsection
