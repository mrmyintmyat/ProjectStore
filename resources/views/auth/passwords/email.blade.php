@extends('layouts.app')

@section('content')
@if (session('status'))
<div aria-live="polite" aria-atomic="true" class="position-relative">
    <div class="toast-container top-0 end-0 p-3">
      <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true" data-aos="fade-left">
        <div class="toast-header">
          <i class="fa-solid fa-circle-check rounded me-2" style="color: #13C39C;"></i>
          <strong class="me-auto">Success</strong>
          <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            {{ session('status') }}
        </div>
      </div>
    </div>
  </div>
@endif
<div class="container">

    <div class="loginBox">
        <h3 class="fs-2 fw-bold">{{ __('Reset Password') }}</h3>
        @error('email')
        <span class="text-warning" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
        <form action="{{ route('password.email') }}" method="post">
            @csrf
            <div class="inputBox">
                <input id="email" type="text" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
            </div>
                <input type="submit" name="" value="{{ __('Send Password Reset Link') }}">
        </form>
        <div class="text-center">
            <p class="text-black mb-0"></p>
            <a href="/login">Login here</a>
        </div>
    </div>
    {{-- <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
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

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
</div>
@endsection
