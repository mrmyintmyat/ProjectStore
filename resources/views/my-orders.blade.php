@extends('layouts.home')
<?php
use App\Models\Item;
?>
@section('main')
    {{-- <div class="d-lg-none position-fixed bottom-0 col-12 border">
        <div class=" w-100 d-flex flex-row">
            <div class="col-7 d-flex flex-column justify-content-center ps-4">
                <div class="py-2">
                    <div class="d-flex flex-row mb-0">
                        <h6 class="mb-0">Total:</h6> &nbsp; <h6 class="total mb-0">MMK0</h6>
                    </div>
                </div>
            </div>
            <div class="bg-secondary col-5">
                <button class="btn w-100 btn-primary rounded-0 p-1 h-100 undisabled" data-bs-toggle="modal"
                    data-bs-target="#order_confirm" disabled>
                    Place Order
                </button>
            </div>
        </div>
    </div> --}}
    <section class="col-12 d-flex flex-lg-row flex-column justify-content-center p-1 container-lg">

        <div class="col-lg-8 col-12">
            <div class="row g-2">
                {{-- <div class="card-header shadow-sm p-2 d-flex justify-content-between px-4">
                    <div>
                        @if (count($orders) != 0)
                            <div class="card-header p-0 mt-0 d-flex justify-content-between">
                                <div>
                                    <div class="form-check form-check-reverse">
                                        <button class="btn btn-white p-0 py-1" onclick="deleteSelectedItems()">Cancel
                                            order</button>
                                    </div>

                                    <div class="modal fade" id="delete_item" data-bs-backdrop="static"
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
                                                    <button type="submit" class="btn btn-primary delete_btn">Yes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="alert_for_select" class="d-flex align-items-center">
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="form-check form-check-reverse">
                            <input class="form-check-input" type="checkbox" value="" id="reverseCheck1">
                            <label class="form-check-label" for="reverseCheck1">
                                Select All
                            </label>
                        </div>
                    </div>
                </div> --}}
                <div class="mt-0 cart_form p-lg-0" id="orderform">
                    @if (count($orders) != 0)
                        @foreach ($orders as $cart)
                            <?php
                            $item = Item::find($cart->item_id);
                            ?>
                            <div class="col-12 cart mb-1" style="height: 110px;">
                                <div class="row g-0 h-100 w-100 border">
                                    <div class="col-md-3 col-5 h-100">
                                        <a class="w-100" href="/detail/{{ $item->id }}">
                                            <img src="/storage/item-images/{{ $item->item_image }}"
                                                class="h-100 w-100 img-fluid" alt="Error">
                                        </a>
                                    </div>
                                    <div class="col-md-8 col-5 h-100">
                                        <div class="card-body d-flex flex-md-row flex-column justify-content-center h-100">
                                            <div class="col-md-6 d-flex align-items-center ps-2">
                                                <div class="w-100">
                                                    <h5 class="card-title">
                                                        {{ $item->title }}
                                                    </h5>
                                                    <p class="card-text m-0">
                                                        <small class=""
                                                            style="color:
                                                        @if ($cart->status === 'reviewing') blue;
                                                        @elseif($cart->status == 'cancelled')
                                                            red;
                                                        @elseif($cart->status == 'done')
                                                            green;
                                                        @else
                                                            black; @endif">
                                                            @if ($cart->status == 'done')
                                                                Completed
                                                            @else
                                                                {{ $cart->status }}
                                                            @endif
                                                        </small>
                                                    </p>

                                                    <div class="price">
                                                        {{ $cart->total }}
                                                    </div>
                                                </div>
                                            </div>
                                            <span id="item_count" class="d-none" value=""
                                                hidden>{{ $item->item_count }}</span>
                                            <span id="org_price" class="d-none" value="" hidden>
                                                @if ($cart->check_price == 'org_price')
                                                    {{ $item->price }}
                                                @else
                                                    {{ $item->reduced_price }}
                                                @endif
                                            </span>
                                            <span class="px-2 d-none fs-6 count user-select-none">
                                                {{ $cart->count }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-2 d-flex justify-content-center align-items-center">
                                        <div class="form-check d-flex justify-content-center align-items-center p-0">
                                            <div class="dropdown">
                                                @if ($cart->status == 'reviewing')
                                                <button class="btn btn-white dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-h"></i>
                                                </button>
                                                @endif
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <li>
                                                        <button type="button" class="dropdown-item btn btn-sm btn-primary rounded-0 w-100"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#staticBackdrop{{ $cart->id }}">Cancel</button>
                                                    </li>
                                                </ul>
                                                <div class="modal fade" id="staticBackdrop{{ $cart->id }}" data-bs-backdrop="static"
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
                                                                <form action="{{ url('orders/' . $cart->id) }}" method="post">
                                                                    @csrf @method('DELETE')
                                                                    <button type="submit" class="btn btn-primary">Yes</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- @if ($cart->status == 'reviewing')
                                                <input class="form-check-input" type="checkbox"
                                                    name="item_data[{{ $item->title }}][id]" value="{{ $cart->id }}">
                                            @endif --}}
                                            <input class="count_input" type="hidden"
                                                name="item_data[{{ $item->title }}][count]" value="{{ $cart->count }}">
                                            <input type="hidden" name="item_data[{{ $item->title }}][cart_id]"
                                                value="{{ $cart->id }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h3 class="text-center w-100 py-2">No Orders</h3>
                    @endif
                        </div>
                {{ $orders->links('layouts.bootstrap-5') }}

            </div>
        </div>

        <div class="col-lg-4 px-3 d-lg-block d-none">
            <div class="card px-3 py-4 rounded-2">
                <div class="">
                    <div class="input-group p-0 col shadow-sm rounded-0 mb-2">
                        <span class="input-group-addon col-4 border">
                            Reviewing
                        </span>
                        <div class="form-control text-dark rounded-0 total">
                            {{ count($orders_count->where('status', '=', 'reviewing')) }}
                        </div>
                    </div>
                    <div class="input-group p-0 col shadow-sm rounded-0 mb-2">
                        <span class="input-group-addon col-4 border">
                            Cancelled
                        </span>
                        <div class="form-control rounded-0 text-dark count_total">
                            {{ count($orders_count->where('status', '=', 'cancelled')) }}
                        </div>
                    </div>
                    <div class="input-group p-0 col shadow-sm rounded-0 mb-2">
                        <span class="input-group-addon col-4 border">
                            Completed
                        </span>
                        <div class="form-control text-dark rounded-0 total">
                            {{ count($orders_count->where('status', '=', 'done')) }}
                        </div>
                    </div>

                    {{-- <div class="d-flex justify-content-between">
                        <a href="https://www.facebook.com/hmxdigital" class="text-info text-center text-decoration-none">Fb
                            page</a>
                            <a href="https://www.facebook.com/hmxdigital" class="text-info text-center text-decoration-none">Telegram</a>
                        <a href="https://www.facebook.com/htetmyataung1288"
                            class="text-info text-center text-decoration-none">Fb
                            acc</a>
                    </div> --}}
                </div>
                {{-- <div class="my-2">
                    <button class="btn btn-primary btn w-100 rounded-2 undisabled" data-bs-toggle="modal"
                        data-bs-target="#order_confirm" disabled>
                        Buy Now
                    </button>
                </div> --}}
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        $("#reverseCheck1").change(function() {
            let isChecked = $(this).is(":checked");
            let check_input = $(".form-check-input:not(#reverseCheck1)");

            check_input.each(function() {
                let isCheckboxChecked = $(this).is(":checked");

                if (isChecked && !isCheckboxChecked) {
                    $(this).click();
                } else if (!isChecked && isCheckboxChecked) {
                    $(this).click();
                }
            });
        });

        function deleteSelectedItems() {

            const checkboxes = document.querySelectorAll('input[name^="item_data"][type="checkbox"]:checked');

            if (checkboxes.length > 0) {
                $('#delete_item').modal('show');
            } else {
                $('#alert_for_select').html('<p class="text-warning m-0">Please select item to cancel.</p>')
            }
        }
        // $(".delete_btn").click(function() {
        //     $(".cart_form").submit();
        // });

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
@endsection
