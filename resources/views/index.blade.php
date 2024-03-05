@extends('layouts.home')
@section('title')
    Find your next project here!
@endsection
@section('description')
    Find your next project here!
@endsection
@section('web_url')
    {{ request()->url() }}
@endsection
@section('btn')
    <section class="pt-lg-3 my-2 px-2 d-lg-none d-block">
        <article class="">
            <form id="searchForm2" method="post">
                @csrf
                <input name="query" id="search" type="search" class="search form-control px-4 border-1 shadow-sm"
                    placeholder="Search">
                <meta name="csrf-token" content="{{ csrf_token() }}">
            </form>
        </article>
        {{-- <article class="">
            <ul id="btn-mother" class="list-unstyled py-3 mb-0">

                <button id="btn-item" class="btn rounded-5 px-3 shadow-sm btn-sm" href="#"
                    role="button">Bestselling</button>
                <button id="btn-item" class="btn rounded-5 px-3 shadow-sm btn-sm" href="#"
                    role="button">Bestselling</button>
                <button id="btn-item" class="btn rounded-5 px-3 shadow-sm btn-sm" href="#"
                    role="button">Bestselling</button>
                <button id="btn-item" class="btn rounded-5 px-3 shadow-sm btn-sm" href="#"
                    role="button">Bestselling</button>
                <button id="btn-item" class="btn rounded-5 px-3 shadow-sm btn-sm" href="#"
                    role="button">Bestselling</button>

            </ul>
        </article> --}}
    </section>
@endsection
@section('main')
    <section class="px-2 container-lg mt-2">
        {{-- <h1 class="my-2">News</h1> --}}
        <div class="">
            <ul id="item_container"
                class="list-unstyled row row-cols-2 row-cols-sm-3 row-cols-lg-4 row-cols-xxl-5 g-2 mb-3">
                @foreach ($items as $item)
                    @if ($item->item_count != 0)
                        <div class="col">
                            <a href="/detail/{{ $item->id }}" id="card"
                                class="h-100 border-0 mb-sm-2 mb-1 border-light text-decoration-none text-dark">
                                <div class="card home-card h-100 border border-1 rounded-3">
                                    <div class="">
                                        <div class="parent">
                                            {{-- <div style="border-radius: 1rem 1rem 0px 0px; background: url('item-images/{{ $item->item_image }}') no-repeat center; background-size: contain;"
                                                class="card-img-top card_img mb-1">
                                            </div> --}}
                                            <img src="/storage/item-images/{{ $item->item_image }}" alt=""
                                                class="card-img-top card_img mb-1 rounded-top">
                                        </div>
                                        <div onclick="" class="card-body pt-0 pb-2 ps-2" id="item_title">
                                            <h6 class="card-title m-0 text-truncate" style="max-width: 200px; "
                                                id="title">
                                                {{ $item->title }}</h6>
                                            <p class="card-text m-0 d-lg-block d-none">
                                                <?php
                                                // $about = strlen($item->about) > 20 ? substr($item->about, 0, 20) . '...' : $item->about;
                                                // echo $about;
                                                ?>
                                            </p>
                                            <div class="d-flex flex-wrap align-items-center price_cart">
                                                @if ($item->reduced_price == null)
                                                    <h5 class="my-0 text-dark">{{ $item->price }}</h5>
                                                @else
                                                    <h5 class="my-0 m-0" id="reduced_price">{{ $item->reduced_price }}</h5>
                                                    <p class="text-decoration-line-through my-0 text-muted">
                                                        {{ $item->price }}
                                                    </p>
                                                @endif
                                            </div>
                                            <div class="card-text d-flex align-items-center">
                                                <small class="text-muted">
                                                    {{ $item->item_count }} left
                                                </small>
                                                <div class="mx-2" style="width: 1.5px; height: 0.6rem; background: #acaeb0;"></div>
                                                <small class="text-muted">
                                                    {{ $item->sales }} sales
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                @endforeach
            </ul>
            <ul id="item_container_search"
                class="list-unstyled row row-cols-2 row-cols-sm-3 row-cols-lg-4 row-cols-xxl-5 g-2 mb-3"
                style="display: none">
            </ul>
            <div class="auto-load text-center w-100" style="display: none;">
                <div class="spinner-border text-info auto-load" role="status">
                    <span class="visually-hidden mb-2">Loading...</span>
                </div>
            </div>
            {{--
                        <svg version="1.1" id="L9" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            x="0px" y="0px" height="60" viewBox="0 0 100 100" enable-background="new 0 0 0 0" xml:space="preserve">
                            <path fill="#3498db"
                                d="M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50">
                                <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s"
                                    from="0 50 50" to="360 50 50" repeatCount="indefinite" />
                            </path>
                        </svg>
                    </div> --}}

            <span class="text-center w-100 error-message m-5" style="display: none;">

            </span>
        </div>
    </section>
@endsection
@section('script')
    <script src="/js/scroll_data.js?v=<?php echo time()?>"></script>
@endsection
