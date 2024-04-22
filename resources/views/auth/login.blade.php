@extends('admin.layouts.app')
@section('content')
<div class="authentication-wrapper authentication-cover">
      <div class="authentication-inner row m-0">
        <!-- /Left Text -->
        <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center p-5">
          <div class="w-100 d-flex justify-content-center">
          <img src="{{ url('assets/img/boy-with-rocket-light.png') }}" class="img-fluid" alt="Login image" width="700" data-app-dark-img="{{ url('assets/img/boy-with-rocket-dark.png') }}" data-app-light-img="{{ url('assets/img/boy-with-rocket-light.png') }}"/>
          </div>
        </div>
        <!-- /Left Text -->

        <!-- Login -->
        <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-5 p-4">
         
          <div class="w-px-400 mx-auto">
          @if ($errors->has('status'))
                    <div class="alert alert-danger">
                        {{ $errors->first('status') }}
                    </div>
                @endif
            <p class="mb-4">Please sign-in to your account and start the adventure</p>
            <form method="POST" action="{{ route('login') }}" id="formAuthentication" class="mb-3" >
            @csrf
              <div class="mb-3">
                <label for="mobile" class=" form-label">Phone Number</label>
                <input id="mobile" type="mobile" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}"  autocomplete="mobile" autofocus>
                @error('mobile')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
                <div class="mb-3 form-password-toggle">
                    <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Password</label>
                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                        <small> {{ __('Forgot Your Password?') }}</small>  
                        </a>
                     @endif
                </div>
                <div class="input-group input-group-merge">
                
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                </div>
              </div>
              <div class="mb-3">
                <div class="form-check">
                  <input  class="form-check-input" type="checkbox" id="remember-me" {{ old('remember') ? 'checked' : '' }}> 
                  <label class="form-check-label" for="remember-me">{{ __('Remember Me') }}</label>
                </div>
              </div>
              <button type="submit" class="btn btn-primary d-grid w-100">{{ __('Sign in') }}</button>
            </form>
            </div>
          </div>
        </div>
        <!-- /Login -->
      </div>
    </div>
@endsection
