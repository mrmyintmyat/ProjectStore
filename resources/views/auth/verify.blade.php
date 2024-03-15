@extends('layouts.app')
@section('alert')
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
@endsection
@section('content')
    <main class="d-flex align-items-center justify-content-center container-md p-0">
        <div class="d-flex flex-column-reverse flex-md-row w-100" id="main">
            <section class="col-md-7 shadow-sm d-flex justify-content-center align-items-center">
                <div class="loginBox">
                    <h3 class="fs-1 fw-bold">Verify Email</h3>
                    @error('verification_code')
                        <span class="text-warning" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <form action="{{ route('verify_email') }}" method="post">
                        @csrf
                        <div class="inputBox">
                            <input id="verification_code" type="text"
                                class="@error('verification_code') is-invalid @enderror" name="verification_code" required
                                autofocus placeholder="Verify Code">
                        </div>
                        <input type="submit" name="" value="Verify">
                    </form>
                    <div class="text-center">
                        <p class="text-black mb-0">You don't have Code?</p>
                        <form class="d-inline" method="POST" action="{{ route('resend_code') }}">
                            @csrf
                            <input name="id" value="{{ session('id') }}" hidden>
                            <button type="submit"
                                class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                        </form>
                    </div>
                </div>
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
