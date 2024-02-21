@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="loginBox">
            <h3 class="fs-2 fw-bold">Verify Phone</h3>
            @error('verification_code')
            <span class="text-warning" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
            <form action="{{ route('verification.verify_phone') }}" method="post">
                @csrf
                <div class="inputBox">
                    <input id="verification_code" type="number" class="@error('verification_code') is-invalid @enderror" name="verification_code" required autofocus placeholder="Verify Code">
                </div>
                    <input type="submit" name="" value="Verify">
            </form>
            <div class="text-center">
                <p class="text-black mb-0">You don't have Code?</p>
                <form class="d-inline" method="POST" action="{{ route('verification.resend_phone') }}">
                    @csrf
                    <input name="id" value="{{ session('id') }}" hidden>
                    <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                </form>
            </div>
        </div>
        {{-- <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Verify Phone Number') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('verification.verify_phone') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="verification_code" class="col-md-4 col-form-label text-md-right">{{ __('Verification Code') }}</label>

                                <div class="col-md-6">
                                    <input id="verification_code" type="text" class="form-control @error('verification_code') is-invalid @enderror" name="verification_code" required autofocus>

                                    @error('verification_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Verify') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                        <form class="d-inline" method="POST" action="{{ route('verification.resend_phone') }}">
                            @csrf
                            <input name="id" value="{{ session('id') }}" hidden>
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
@endsection
