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
                        <h3 class="fs-1 fw-bold">{{ __('Reset Password') }}</h3>
                        @error('email')
                            <span class="text-warning" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        @error('password')
                        <span class="text-warning" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="inputBox">
                                <input id="email" type="email" class=" @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email">
                                <input id="password" type="password" class=" @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">
                                <input id="password-confirm" type="password" class="" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                            </div>
                                <input type="submit" name="" value="{{ __('Reset Password') }}">
                        </form>
                </section>
                <section class="col-md-5 d-flex justify-content-center align-items-center">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <h3 class="fw-bold text-white d-none d-lg-block">Welcome to</h3>
                        <h4 class="text-white fw-bold fs-1 d-md-block d-none">NextPj</h4>
                        <p class="mt-md-5 m-0 text-center fw-semibold w-75 text-white w-100 fs-5">Find your next project here!</p>
                    </div>
                </section>
            </div>
        </main>
    @endsection
