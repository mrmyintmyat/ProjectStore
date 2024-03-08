@extends('layouts.admin')
@section('content')
    <?php
    use App\Models\Item;
    use App\Models\User;
    ?>
    <div class="row row-cols-3">
        <a class="btn rounded-0 btn-white {{ !request()->has('status') || request('status') == 'reviewing' ? 'btn-info text-white' : 'border' }}"
            href="?status=reviewing">Reviewing</a>
        <a class="btn rounded-0 btn-white {{ request('status') == 'done' ? 'btn-info text-white' : 'border' }}"
            href="?status=done">Done</a>
        <a class="btn rounded-0 btn-white {{ request('status') == 'cancelled' ? 'btn-info text-white' : 'border' }}"
            href="?status=cancelled">Cancelled</a>
    </div>
    <div class="d-flex">
        <button class="btn btn-warning text-white w-50 rounded-0" onclick="cancel_order()">Cancel orders</button>
        <button class="btn btn-success text-white w-50 rounded-0" onclick="done_order()">Done</button>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered">
            {{-- <h2 class="text-primary m-2">Orders (<span id="cart_count">{{ count($orders) }})</span> <button class="btn btn-warning text-white ms-3" onclick="cancel_order()">Cancel orders</button></h2> --}}
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Image</th>
                    <th scope="col">Name</th>
                    {{-- <th scope="col">about</th> --}}
                    <th scope="col">total</th>
                    {{-- <th scope="col">count</th> --}}
                    <th scope="col">Date</th>
                    <th scope="col">Name</th>
                    <th scope="col">Chat Id</th>
                    <th scope="col">Note</th>
                    <th scope="col">Email</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>

                @foreach ($orders as $order)
                    <?php
                    $item = Item::find($order->item_id);

                    $user = $order->user;
                    if (!$user) {
                        $user_email = $order->user_id;
                    } else {
                        $user_email = $user->email;
                    }
                    ?>
                    <tr id="{{ $order->id }}">
                        <th scope="row">{{ $order->id }}
                        </th>
                        @if ($item)
                        <td scope="row">
                            <img style="height: 100px; width:auto;" src="/storage/item-images/{{ $item->item_image }}"
                                alt="">
                        </td>
                        <td scope="row">{{ $item->title }}</td>
                @else
                    <td scope="row">
                        <img style="height: 100px; width:auto;" src="" alt="item deleted">
                    </td>
                    <td scope="row">item deleted</td>
                @endif
                <th scope="row">{{ $order->total }}</th>
                {{-- <th scope="row">{{ $order->count }}</th> --}}
                <th scope="row">{{ $order->created_at->diffForHumans(null, true) }} <p>{{ $order->created_at }}
                    </p>
                </th>
                <th scope="row">{{ $order->user_name }}</th>
                <th scope="row">
                    @if ($order->user->chat_id != null)
                        @php
                            $chatIdData = json_decode($order->user->chat_id, true); // Decode JSON string into an associative array
                        @endphp
                        @foreach ($chatIdData as $key => $value)
                            <h6>{{ $key }}: {{ $value }}</h6>
                        @endforeach
                    @endif
                </th>
                <th scope="row">{{ $order->note }}</th>
                <th scope="row"><a href="mailto:{{ $user_email }}">{{ $user_email }}</a></th>
                {{-- <th class="d-flex">


                        <div class="modal fade" id="staticBackdrop{{ $order->id }}" data-bs-backdrop="static"
                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body pb-1">
                                        Are you sure?
                                    </div>
                                    <div class="modal-footer border-0 p-0 px-2 pb-2">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                        <form action="{{ url('/admin/cancel_order/' . $order->id) }}" method="post">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-primary">Yes</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="{{ url('admin/' . $item->id . '/edit') }}" class="btn btn-success btn-sm">Accept</a>
                    </th> --}}
                <th>
                    <div>
                        <input type="checkbox" name="orders[]" value="{{ $order->id }}">
                    </div>
                </th>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $orders->links('layouts.bootstrap-5') }}

    <div class="position-fixed start-0 bottom-50">
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body pb-1">
                        Are you sure?
                    </div>
                    <div class="modal-footer border-0 p-0 px-2 pb-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <form action="{{ url('/admin/cancel_order') }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-primary">Yes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function cancel_order() {
            if (confirm("Are you sure?") == true) {
                var checkedItems = $('input[name="orders[]"]:checked')
                    .map(function() {
                        return $(this).val();
                    })
                    .get();

                if (checkedItems.length === 0) {
                    alert('Please select items to cancel.');
                    return;
                }

                axios.post('/admin/cancel_order', {
                        order_ids: checkedItems
                    })
                    .then(function(response) {
                        // Remove the deleted items from the table
                        checkedItems.forEach(function(itemId) {
                            $('#' + itemId).remove();
                        });
                        var toast = document.getElementById('toast');
                        toast.classList.add('show');
                    })
                    .catch(function(error) {
                        console.log(error);
                        alert('An error occurred while deleting the items.');
                    });
            }
        }

        function done_order() {
            if (confirm("Are you sure?") == true) {
                var checkedItems = $('input[name="orders[]"]:checked')
                    .map(function() {
                        return $(this).val();
                    })
                    .get();

                if (checkedItems.length === 0) {
                    alert('Please select items to done.');
                    return;
                }

                axios.post('/admin/done_order', {
                        order_ids: checkedItems
                    })
                    .then(function(response) {
                        // Remove the deleted items from the table
                        checkedItems.forEach(function(itemId) {
                            $('#' + itemId).remove();
                        });
                        var toast = document.getElementById('toast');
                        toast.classList.add('show');
                    })
                    .catch(function(error) {
                        console.log(error);
                        alert('An error occurred while deleting the items.');
                    });
            }
        }
    </script>
@endsection
