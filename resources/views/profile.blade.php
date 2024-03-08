<?php
use App\Models\Item;
use App\Models\Order;
$orders = Order::where('user_id', Auth::user()->id)
    ->latest()
    ->paginate(10);
$items = Item::inRandomOrder()->take(5)->get();
?>
@extends('layouts.home')

@section('main')

    <section class="mb-3 container-lg">
        <div class="shadow-sm p-lg-3 h-100 px-2">
            <h3 class="my-3 text-center">My Profile</h3>
            <section class="d-flex justify-content-center my-2 mb-lg-5">
                <form id="pf_form" class="w-100" action="{{ route('password.email') }}" method="post">
                    @csrf
                    <input type="hidden" name="" value="{{ Auth::user()->id }}" id="user_id">
                    @error('email')
                        <span class="text-danger mb-3">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="row row-cols-1 row-cols-lg-2">
                        <div class="col">
                            <div class="input-group p-0 shadow-sm rounded-0 mb-2">
                                <span class="input-group-addon border">
                                    Name
                                </span>
                                <input id="name-input" type="text" value="{{ Auth::user()->name }}"
                                    class="form-control bg-white rounded-0" name="name" disabled required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="input-group p-0 shadow-sm rounded-0 mb-2">
                                <span
                                    class="input-group-addon border @if (Auth::user()->email_verified_at == null) border-warning @endif">
                                    Email
                                </span>
                                <input id="email-input" type="email" value="{{ Auth::user()->email }}" name="email"
                                    class="form-control bg-white rounded-0 @if (Auth::user()->email_verified_at == null) border-warning @endif"
                                    aria-describedby="emailHelp" disabled>
                            </div>
                            @if (Auth::user()->email_verified_at == null)
                                <div class="mb-2 d-flex justify-content-end">
                                    <a class="btn btn-sm shadow-sm border border-warning border-2 text-warning"
                                        href="/verify-email"><i class="fa-solid fa-exclamation me-1 text-warning"></i>Verify
                                        Email</a>
                                </div>
                            @endif
                        </div>
                        @if (Auth::user()->chat_id)
                            @php
                                $chatIds = json_decode(Auth::user()->chat_id, true);
                            @endphp
                            @foreach ($chatIds as $name => $id)
                                <div class="col">
                                    <div class="input-group p-0 shadow-sm rounded-0 mb-2">
                                        <select id="chat_id_name" class="input-group-addon" name="select_chat_id"
                                            id="select_chat_id" disabled required>
                                            <option value="messenger" {{ $name == 'messenger' ? 'selected' : '' }}>Messenger
                                            </option>
                                            <option value="telegram" {{ $name == 'telegram' ? 'selected' : '' }}>Telegram
                                            </option>
                                            <option value="skype" {{ $name == 'skype' ? 'selected' : '' }}>Skype</option>
                                            <option value="whatsapp" {{ $name == 'whatsapp' ? 'selected' : '' }}>Whatsapp
                                            </option>
                                            <option value="viber" {{ $name == 'viber' ? 'selected' : '' }}>Viber</option>
                                        </select>
                                        <input id="name-input" type="text" value="{{ $id }}"
                                            class="form-control bg-white rounded-0" name="chat_id"
                                            disabled required>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        <div id="btn_mt">
                            <button type="button" class="btn btn-info text-white rounded-0" id="edit-profile">Edit
                                Profile</button>
                            @if (Auth::user()->email_verified_at != null)
                                <button onclick="$('#email-input').prop('disabled', !$('#email-input').prop('disabled'))"
                                    type="submit" class="btn btn-info text-white rounded-0">Change Password</button>
                            @endif
                        </div>
                        <div id="post_edit" style="display: none;">
                            <button type="submit" class="btn btn-info text-white rounded-0">Edit</button>
                        </div>
                    </div>
                </form>
            </section>
            {{-- <h3 class="m-2">My Orders</h3>

             <div id="result" class="d-flex flex-row g-sm-2 g-1 overflow-auto scroll_style p-0">
                @if (count($orders) === 0)
                    <div style="height: 10rem" class="d-flex justify-content-center align-items-center w-100">
                        <div class="text-center">
                            <span>
                                <i class="fa-regular fa-hourglass fa-spin fa-spin-reverse"></i>
                                <h3>No Order</h3>
                                <h4>Place your order now!</h4>
                            </span>
                        </div>
                    </div>
                @endif
                @foreach ($orders as $order)
                    <?php
                    $item = $order->item;
                    ?>
                    <div class="col-sm-4 col-md-3 col-lg-2 col-6 m-2 mb-sm-2 mb-1 border rounded" style="max-width: 540px;">
                        <div id="card" class="card border-0 border-light shadow-sm h-100 border">
                            <div class="parent">
                                <a class="parent">
                                    <img class="card-img-top card_img" src="/storage/item-images/{{ $item->item_image }}"
                                        alt="">
                                </a>
                            </div>
                            <div class="card-body p-0" id="item_title">
                                <div class="d-flex flex-wrap align-items-center price_cart">
                                    <div class="input-group p-0 shadow-sm rounded-0">
                                        <span
                                            class="fw-semibold col-lg-3 col-4  input-group-addon border d-flex align-items-center justify-content-center p-1">
                                            Name
                                        </span>
                                        <input id="name-input" type="text" value="{{ $item->title }}"
                                            class="fw-semibold col-lg-9 col-8 form-control bg-white rounded-0"
                                            name="name" disabled="" required="">
                                    </div>
                                    <div class="input-group p-0 shadow-sm rounded-0">
                                        <span
                                            class="fw-semibold col-lg-3 col-4 input-group-addon border d-flex align-items-center justify-content-center p-1">
                                            Total
                                        </span>
                                        <input id="name-input" type="text" value="{{ $order->total }}"
                                            class="fw-semibold col-lg-9 col-8 form-control bg-white rounded-0"
                                            name="name" disabled="" required="">
                                    </div>
                                </div>

                                @if ($order->status === 'reviewing')
                                    <button type="button" class="btn btn-sm btn-primary rounded-0 w-100"
                                        data-bs-toggle="modal"
                                        data-bs-target="#staticBackdrop{{ $order->id }}">Cancle</button>
                                @elseif ($order->status === 'done')
                                <button type="button" class="btn btn-sm btn-success rounded-0 w-100">Successed</button>
                                @elseif ($order->status === 'cancelled')
                                <button type="button" class="btn btn-sm btn-warning text-white rounded-0 w-100">Cancelled</button>
                                @endif

                                <div class="modal fade" id="staticBackdrop{{ $order->id }}" data-bs-backdrop="static"
                                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body pb-1">
                                                Are you sure?
                                            </div>
                                            <div class="modal-footer border-0 p-0 px-2 pb-2">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">No</button>
                                                <form action="{{ url('orders/' . $order->id) }}" method="post">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-primary">Yes</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div> --}}
            <h2 class="m-2 mt-5">For you</h2>
            <div id="result" class="d-flex flex-row p-0 g-sm-2 g-1 overflow-auto row-cols-desktop-6">
                @if (count($items) === 0)
                    <div style="height: 10rem" class="d-flex justify-content-center align-items-center w-100">
                        <div class="text-center">
                            <span>
                                <i class="fa-regular fa-hourglass fa-spin fa-spin-reverse"></i>
                                <h3>Not Yet</h3>
                            </span>
                        </div>
                    </div>
                @endif
                @foreach ($items as $item)
                    @if ($item->item_count != 0)
                        <div class="col-sm-4 col-md-3 col-lg-2 col-6 m-2 mb-sm-2 mb-1 border-0 border-light rounded-4">
                            <a href="{{ url('detail/' . $item->id) }}" id="card"
                                class=" h-100 text-decoration-none text-dark" style="max-width: 540px;">
                                <div class="card h-100 home-card">
                                    <div class="parent">
                                        <div class="parent">
                                            {{-- <div style="border-radius: 1rem 1rem 0px 0px; background: url('/item-images/{{ $item->item_image }}') no-repeat center; background-size: contain; height: 140px;"
                                    data-bs-toggle="modal" data-bs-target="#staticBackdrop" src=""
                                    class="card-img-top card_img d-flex justify-content-center align-items-center"
                                    alt="..."> </div> --}}
                                            <img src="/storage/item-images/{{ $item->item_image }}"
                                                class="card-img-top card_img" alt="">
                                        </div>
                                    </div>
                                    <div class="card-body" id="item_title">
                                        <h5 class="card-title m-0 mb-sm-1 text-truncate fs-5" style="max-width: 200px;"
                                            id="title">
                                            {{ $item->title }}
                                        </h5>
                                        <div class="d-flex flex-wrap align-items-center price_cart">
                                            @if ($item->reduced_price == null)
                                                <h5 class="my-0" style="">{{ $item->price }}</h5>
                                            @else
                                                <h5 class="my-0" id="reduced_price">{{ $item->reduced_price }}</h5>
                                                <p class="text-decoration-line-through my-0 text-muted">
                                                    {{ $item->price }}</p>
                                            @endif
                                        </div>
                                        <p class="card-text">
                                            <small class="text-muted">
                                                {{ $item->sales }} sales
                                            </small>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script src="/js/profile.js?v=<?php echo time(); ?>"></script>
@endsection
