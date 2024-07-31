@extends('admin.layouts.app')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-10 mt-5">
        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    Edit Profile
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('profileUpdate') }}" method="post">
                    @csrf
                    @method("PUT")

                    <!-- Name -->
                    <div class="mb-3 row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $user->name }}">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-3 row">
                        <label for="email" class="col-md-4 col-form-label text-md-end text-start">Email Address</label>
                        <div class="col-md-6">
                          <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $user->email }}">
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
                        <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Update">
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