@extends('layouts.app')

@section('content')
@if (session('success'))
<div aria-live="polite" aria-atomic="true" class="position-relative">
    <div class="toast-container top-0 end-0 p-3">
      <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true" data-aos="fade-left">
        <div class="toast-header">
          <i class="fa-solid fa-circle-check rounded me-2" style="color: #13C39C;"></i>
          <strong class="me-auto">Success</strong>
          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            {{ session('success') }}
        </div>
      </div>
    </div>
  </div>
@endif
<div class="container">
    <div class="loginBox">
        <h3 class="fs-1 fw-bold">LOGIN</h3>
        @error('email')
        <span class="text-warning mb-3">
            <strong>Your Password Wrong Or Email Not found.</strong>
        </span>
         @enderror
         @error('password')
         <span class="text-danger mb-3">
             <strong>{{ $message }}</strong>
         </span>
         @enderror
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="inputBox">

                  <input id="email" type="text" class="@error('email') is-invalid @enderror" name="email" @if (session('em_ph'))
                      value="{{session('em_ph')}}"

                      @else
                      value="{{ old('email') }}"

                  @endif required autocomplete="email" autofocus placeholder="Email Or Phone">

                   <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                   <div class="form-check p-0">
                    <input style="width: 20px;" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                     Remember Me
                </div>
            </div>
                <input type="submit" name="" value="Login">
        </form>
        @if (Route::has('password.request'))
        <a href="{{ route('password.request') }}">
            Forget Password?<br>
        </a>
        @endif
        <div class="text-center">
            <p class="text-black mb-0">You don't have an account?</p>
            <a href="/register">Register here</a>
        </div>
    </div>
    {{-- <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
</div>
@endsection
