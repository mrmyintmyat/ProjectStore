@extends('layouts.home')
@section('main')
    <div class="w-100 p-3">
        <div class="row g-2">
            @if (Auth::check())
                @if (count($notices) == 0)
                <div class="d-flex justify-content-center align-items-center w-100">
                    <div class="text-center">
                        <span>
                            <h3>Not Yet</h3>
                        </span>
                    </div>
                </div>
                @endif
                @foreach ($notices as $notice)
                    <div class="col-lg-6 col-12 shadow-sm">
                        <div class="p-3">
                            <div class="w-100">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        {{ $notice->title }}
                                    </h5>
                                    <p class="card-text mb-0">
                                        {{ $notice->message }}
                                    </p>
                                    <p class="m-0 text-primary">
                                        {{ $notice->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                {{ $notices }}
            @endif
            {{ $notices->links('layouts.bootstrap-5') }}

        </div>
    </div>
@endsection
