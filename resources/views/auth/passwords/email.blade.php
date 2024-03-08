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
        <main class="d-flex align-items-center justify-content-center container-md p-0">
            <div class="d-flex flex-column-reverse flex-md-row w-100" id="main">
                <section class="col-md-7 shadow-sm d-flex justify-content-center align-items-center">
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
                </section>
                <section class="col-md-5 d-flex justify-content-center align-items-center">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <h3 class="fw-bold text-white d-none d-lg-block fs-4">Welcome to</h3>
                        <h4 class="text-white fw-bold fs-1">NextPj</h4>
                        <p class="mt-5 text-center fw-semibold w-75 text-white d-md-block d-none w-100 fs-5">Find your next project here!</p>
                    </div>
                </section>
            </div>
        </main>
    @endsection
