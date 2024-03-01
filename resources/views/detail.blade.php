@extends('layouts.home')
@section('title')
    {{$item->title}}
@endsection
@section('description')
<?php

function htmlToStr($html) {
    // Create a new DOMDocument
    $dom = new DOMDocument();

    // Load the HTML code into the DOMDocument
    @$dom->loadHTML($html);

    // Remove any HTML tags from the content
    $body = $dom->getElementsByTagName('body')->item(0);
    $str = $dom->saveHTML($body);
    $str = preg_replace('#<(.*?)>#', '', $str);

    // Return the string
    return $str;
}

$html = $item->about;
$str = htmlToStr($html);
echo $str;

?>
@endsection
@section('web_url')
    {{ request()->url() }}
@endsection
@section('main')
    <section class="pt-lg-3 pt-2 d-flex align-items-center shadow-sm container-lg">
        <div class="w-100 ">
            <div class="card my-2 border-0 mb-3 p-sm-2 d-flex justify-content-sm-center " style="">
                <div class="row g-0 d-flex justify-content-center">
                    <div class="row row-cols-md-2 row-cols-1 d-flex justify-content-center">
                        <div
                            class="img-zoom-container p-0 col-lg-7 d-flex flex-column justify-content-center align-items-center ">
                            <img id="webimage" class="rounded-3" style="width: 100%; object-fit: contain;"
                                src="/item_img/{{ $item->item_image }}" alt="">
                                <div class="card w-100 my-2 border-0">
                                    <div class="card-body">
                                            {!! $item->about !!}
                                    </div>
                                  </div>
                        </div>
                        <div id="myresult" class="img-zoom-result d-none"></div>

                        <input type="hidden" id="item_count" value="{{ $item->item_count }}">
                        {{-- <div class="col my-3 clearfix">
                            <div class="d-flex flex-wrap py-2">
                                <div>
                                    <form name="form_cart">
                                        <span href="" class="text-decoration-none">
                                            <script src="https://cdn.lordicon.com/ritcuqlt.js"></script>
                                            <lord-icon src="https://cdn.lordicon.com/hyhnpiza.json" trigger="hover">
                                            </lord-icon>
                                        </span>
                                    </form>
                                </div>
                            </div>
                            <div>
                                <a unselectable="unselectable" type="button"
                                    class="minus px-1 border border-1 border-opacity-50 bg-secondary text-black bg-opacity-25 user-select-none">
                                    <span unselectable="unselectable">
                                        <i class="fa-solid fa-minus"></i>
                                    </span>
                                </a>
                                <input type="hidden" id="item_count" value="{{ $item->item_count }}">
                                <span class="px-2 fs-6 count user-select-none">
                                    @if ($item->item_count == 0)
                                        0
                                    @else
                                        1
                                    @endif
                                </span>
                                <a unselectable="unselectable" type="button"
                                    class="plus px-1 border border-1 border-opacity-50 bg-secondary text-black bg-opacity-25 user-select-none">
                                    <span unselectable="unselectable">
                                        <i class="fa-solid fa-plus"></i>
                                    </span>
                                </a>
                            </div>
                            <p class="card-text mt-1">
                                <small class="text-muted">{{ $item->item_count }} items left</small>
                            </p>
                        </div> --}}
                        <div class="col-lg-4 disabled_tag h-100 p-0 ms-lg-4 px-md-3">
                            <div id="item_title" class="border rounded p-3 pb-4 pt-0">
                                <div class="d-flex justify-content-between align-items-center w-100 my-3 px-2">
                                    <h4 class="card-title fs-5 text-dark fw-semibold" id="title">
                                        {{ $item->title }}
                                    </h4>
                                    <div class="d-flex flex-column flex-wrap price_cart">
                                        @if ($item->reduced_price == null)
                                            <h4 class="my-0 price fw-semibold" style="">{{ $item->price }}</h4>
                                        @else
                                            <h4 class="my-0 price fw-semibold" id="reduced_price">{{ $item->reduced_price }}
                                            </h4>
                                            <p class="text-decoration-line-through my-0 text-muted">{{ $item->price }}</p>
                                        @endif
                                    </div>
                                </div>
                                @if (Auth::check())
                                    <form>
                                        @error('email')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <div class="input-group shadow-sm mb-2 border rounded-0"
                                            style="border-right: none;">
                                            <span class="input-group-addon border">
                                                <i class="fa-solid fa-envelope"></i>
                                            </span>
                                            {{-- @if (Auth::user()->email != null) --}}
                                            <input id="email-input" type="text" value="{{ Auth::user()->email }}"
                                                class="form-control bg-white rounded-0" name="email" disabled>
                                            {{-- @else
                                                <input id="email-input" type="text"
                                                    class="form-control bg-white border-end-0 @error('email') is-invalid @enderror"
                                                    name="email" placeholder="Please Add Your Email" autofocus>
                                                <input type="text" name="item_id" value="{{ $item->id }}" hidden>
                                            @endif
                                            <span class="input-group-addon border border-start-0">
                                                @if (Auth::user()->email == null)
                                                    <i class="fa-solid fa-circle-plus" style="cursor: pointer;"></i>
                                                @endif
                                            </span> --}}
                                        </div>

                                        @if (Auth::user()->email_verified_at == null)
                                            <div class="mb-0 d-flex justify-content-end">
                                                <a onclick="ChangeloadingIcon(event, null)" href="/verify-email?item_id={{ $item->id }}" type="submit"
                                                    id="em_verify_btn"
                                                    class="btn btn-sm shadow-sm w-100 border border-warning border-2 text-warning"
                                                    href=""><i
                                                        class="fa-solid fa-exclamation me-1 text-warning"></i>Verify
                                                    Email</a>
                                            </div>
                                        @endif
                                    </form>

                                    {{-- <div class="input-group p-0 col shadow-sm rounded-0 mb-2">
                                        <span class="input-group-addon border">
                                            Total
                                        </span>
                                        <div class="form-control text-dark rounded-0 total">
                                            @if ($item->reduced_price == null)
                                                {{ $item->price }}
                                            @else
                                                {{ $item->reduced_price }}
                                            @endif
                                        </div>
                                    </div> --}}
                                    {{-- <div class="input-group p-0 col shadow-sm rounded-0 mb-2">
                                        <span class="input-group-addon border">
                                            Count
                                        </span>
                                        <div class="form-control rounded-0 text-dark count_total">
                                            @if ($item->item_count == 0)
                                            0
                                        @else
                                            1
                                        @endif
                                        </div>
                                    </div> --}}
                                    {{-- <div class="d-flex justify-content-between">
                                        <a href="https://www.facebook.com/hmxdigital"
                                            class="text-info text-decoration-none">facebook page</a>
                                        <a href="https://www.facebook.com/htetmyataung1288"
                                            class="text-info text-decoration-none ms-4">facebook account</a>
                                    </div> --}}
                                @else
                                    <a href="/login" class="text-warning w-100 text-center">
                                        <h4>Login</h4>
                                    </a>
                                @endif
                                <div class="d-flex flex-column justify-content-center mt-2">
                                    <form action="{{ url('/create') }}" method="post" class="col-12">
                                        @csrf @method('GET')
                                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                                        @if ($item->reduced_price == null)
                                            <input type="hidden" name="price" value="price">
                                        @else
                                            <input type="hidden" name="price" value="reduced_price">
                                        @endif
                                        <input type="hidden" class="count" name="count" value="1">
                                        @if (Auth::check())
                                            <button
                                                class="btn w-100 rounded-1 fw-semibold  disabled_tag btn-secondary btn p-2">
                                                <i class="fa-solid me-2 fa-cart-plus"></i> Add to Cart
                                            </button>
                                        @else
                                            <a href="/login"
                                                class="btn w-100 rounded-1 fw-semibold  disabled_tag btn-secondary btn p-2">
                                                <i class="fa-solid me-2 fa-cart-plus"></i> Add to Cart
                                            </a>
                                        @endif
                                    </form>

                                    <button type="submit"
                                        class="btn col-12 rounded-1 fw-semibold  disabled_tag btn-primary btn mt-2 p-2"
                                        data-bs-toggle="modal" data-bs-target="#order_confirm" {{-- @if (Auth::check()) @if (Auth::user()->email == null || Auth::user()->email_verified_at == null)
                                        disabled @endif
                                    @else disabled @endif --}}>
                                        <i class="fa-solid me-2 fa-cart-shopping"></i> Order Now
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="my-3 d-flex justify-content-end pe-4">
                        @if (Auth::check())
                            <form action="{{ route('order.create_order', ['id' => $item->id]) }}" method="POST" id="orderform">
                                @csrf @method('POST')
                                @if ($item->reduced_price == null)
                                    <input type="hidden" name="price" value="price">
                                @else
                                    <input type="hidden" name="price" value="reduced_price">
                                @endif
                                <input type="hidden" class="count" name="count" value="1">
                                <div class="modal fade" id="order_confirm" data-bs-backdrop="static"
                                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header border-0 p-3 pb-0">
                                                <h5 class="modal-title">Confirm</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="input-group p-0 col rounded-0 mb-2">
                                                    <div class="form-control shadow-sm  rounded-3 ps-3 p-2 text-dark">
                                                        {{ $item->title }}
                                                    </div>
                                                </div>
                                                <div class="input-group p-0 col rounded-0 mb-2">
                                                    <div class="form-control shadow-sm text-dark rounded-3 ps-3 p-2 total">
                                                        @if ($item->reduced_price == null)
                                                            {{ $item->price }}
                                                        @else
                                                            {{ $item->reduced_price }}
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="input-group mb-2" style="border-right: none;">
                                                    <input id="email-input" type="text"
                                                        value="{{ Auth::user()->name }}"
                                                        class="form-control shadow-sm bg-white rounded-3 ps-3 p-2"
                                                        name="name" disabled>
                                                </div>

                                                <div class="input-group mb-2" style="border-right: none;">
                                                    <input id="email-input" type="email"
                                                        value="{{ Auth::user()->email }}"
                                                        class="form-control shadow-sm bg-white rounded-3 ps-3 p-2"
                                                        name="email" disabled>
                                                </div>

                                                @if (Auth::user()->email_verified_at == null)
                                                    <div class="mb-0 d-flex justify-content-end">
                                                        <a onclick="ChangeloadingIcon(event, null)" href="/verify-email?item_id={{ $item->id }}"
                                                            type="submit" id="em_verify_btn"
                                                            class="btn btn-sm shadow-sm w-100 border border-warning border-2 text-warning"
                                                            href=""><i
                                                                class="fa-solid fa-exclamation me-1 text-warning"></i>Verify
                                                            Email</a>
                                                    </div>
                                                @endif
                                                <div class="input-group p-0 col shadow-sm rounded-0 mb-0">
                                                    {{-- <span
                                    class="input-group-addon col-lg-2 col-3 d-flex align-items-center justify-content-center border">
                                    Count
                                </span>
                                <div class="form-control rounded-0 text-dark count_total">
                                    @if ($item->item_count == 0)
                                        0
                                    @else
                                        1
                                    @endif
                                </div> --}}
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0 p-0 px-3 pb-3">
                                                <button onclick="ChangeloadingIcon(event, 'orderform')" type="submit"
                                                    class="btn fw-semibold m-0 w-100 btn-primary rounded-2">Confirm</button>
                                            </div>
                                        </div>
                                    </div>
                            </form>
                        @else
                            <form action="{{ route('order.create_order', ['id' => $item->id]) }}" method="POST">
                                @csrf @method('POST')
                                @if ($item->reduced_price == null)
                                    <input type="hidden" name="price" value="price">
                                @else
                                    <input type="hidden" name="price" value="reduced_price">
                                @endif
                                <input type="hidden" class="count" name="count" value="1">
                                <div class="modal fade" id="order_confirm" data-bs-backdrop="static"
                                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header border-0 p-3 pb-0">
                                                <h5 class="modal-title">Confirm</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="input-group p-0 col shadow-sm rounded-0 mb-2">
                                                    <div class="form-control rounded-3 ps-3 p-2 text-dark">
                                                        {{ $item->title }}
                                                    </div>
                                                </div>
                                                <div class="input-group p-0 col shadow-sm rounded-0 mb-0">
                                                    {{-- <span
                                    class="input-group-addon col-lg-2 col-3 d-flex align-items-center justify-content-center border">
                                    Count
                                </span>
                                <div class="form-control rounded-0 text-dark count_total">
                                    @if ($item->item_count == 0)
                                        0
                                    @else
                                        1
                                    @endif
                                </div> --}}
                                                </div>
                                                <div class="input-group p-0 col mb-2">
                                                    <div class="form-control text-dark total rounded-3 ps-3 p-2 ">
                                                        @if ($item->reduced_price == null)
                                                            {{ $item->price }}
                                                        @else
                                                            {{ $item->reduced_price }}
                                                        @endif
                                                    </div>
                                                </div>

                                                {{-- <div class="input-group shadow-sm mb-2 rounded-3"
                                                    style="border-right: none;">
                                                    <input id="email-input" type="text" value=""
                                                        placeholder="Your name"
                                                        class="form-control bg-white m-0 rounded-3 ps-3 p-2"
                                                        name="name" autofocus required>
                                                </div>

                                                <div class="input-group shadow-sm mb-0 rounded-3"
                                                    style="border-right: none;">
                                                    <input id="email-input" type="email" value=""
                                                        placeholder="Your email"
                                                        class="form-control bg-white m-0 rounded-3 ps-3 p-2"
                                                        name="email" autofocus required>
                                                </div> --}}
                                            </div>

                                            <div class="modal-footer border-0 p-0 px-3 pb-3">
                                                <button type="submit"
                                                    class="btn fw-semibold m-0 btn-primary rounded-2 w-100">Confirm</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                        @endif
                    </div>
                </div>
            </div>
            <h2 class="mt-lg-3 px-3">Discount Products</h2>
            <div id="result" class="d-flex flex-row p-2 g-sm-2 g-1 overflow-auto row-cols-desktop-6">
                @if (count($reduced_items) === 0)
                    <div style="height: 10rem"
                        class="d-flex justify-content-center align-items-center justify-content-md-start ms-md-4 w-100">
                        <div class="text-center">
                            <span>
                                <i class="fa-regular fa-hourglass fa-spin fa-spin-reverse"></i>
                                <h4>Not Yet</h4>
                            </span>
                        </div>
                    </div>
                @endif
                @foreach ($reduced_items as $reduced_item)
                    @if ($reduced_item->item_count != 0)
                        <div class="col-sm-4 col-md-3 col-lg-2 col-6  m-2 mb-sm-2 mb-1 border-0 border-light rounded-4">
                            <a href="{{ url('detail/' . $reduced_item->id) }}" id="card"
                                class=" h-100 text-decoration-none text-dark" style="max-width: 540px;">
                                <div class="card h-100 home-card">
                                    <div class="parent">
                                        <div class="parent">
                                            <div style="border-radius: 1rem 1rem 0px 0px; background: url('/storage/item_img/{{ $reduced_item->item_image }}') no-repeat center; background-size: contain; height: 140px;"
                                                data-bs-toggle="modal" data-bs-target="#staticBackdrop" src=""
                                                class="card-img-top card_img d-flex justify-content-center align-items-center"
                                                alt="..."> </div>
                                        </div>
                                    </div>
                                    <div class="card-body" id="item_title">
                                        <h4 class="card-title m-0 mb-sm-1 text-truncate fs-5" style="max-width: 200px;"
                                            id="title">
                                            {{ $reduced_item->title }}
                                        </h4>
                                        <div class="d-flex flex-wrap align-items-center price_cart">
                                            @if ($reduced_item->reduced_price == null)
                                                <h4 class="my-0" style="">{{ $reduced_item->price }}</h4>
                                            @else
                                                <h4 class="my-0" id="reduced_price">{{ $reduced_item->reduced_price }}
                                                </h4>
                                                <p class="text-decoration-line-through my-0 text-muted">
                                                    {{ $reduced_item->price }}</p>
                                            @endif
                                        </div>
                                        <p class="card-text">
                                            <small class="text-muted">{{ $reduced_item->sales }} sales</small>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        function ChangeloadingIcon(e, formid) {
            // Prevent the default form submission behavior

            // Get the button element from the event object
            var submitBtn = e.target;

            // Disable the button to prevent multiple submissions
            submitBtn.disabled = true;

            // Change the button text to show the loading icon
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

            // Submit the form or perform other actions
            if (formid != null) {
                document.getElementById(formid).submit();
            }
        }
    </script>
    <script src="/js/plus.js"></script>
@endsection
