@extends('layouts.admin')
@section('content')
<button class="btn btn-danger w-100 rounded-0" onclick="Delete_item()">Delete</button>
    <div class="table-responsive">
        <table class="table table-bordered">
            {{-- <h2 class="text-primary m-2 w-100">Items (<span id="cart_count">{{ count($items) }})</span>
                <button class="btn btn-danger ms-auto me-0" onclick="Delete_item()">Delete</button>
            </h2> --}}
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Photos</th>
                    <th scope="col">Titles</th>
                    {{-- <th scope="col">about</th> --}}
                    {{-- <th scope="col">count</th> --}}
                    <th scope="col">prices</th>
                    <th scope="col">reduced_price</th>
                    {{-- <th scope="col">Date</th> --}}
                    <th scope="col">Actions</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr id="{{ $item->id }}">
                        <th scope="row">{{ $item->id }}</th>
                        <td class="col-1">
                            <a href="/item/detail/{{ $item->id }}">
                                <img style="height: 100px; width:auto;" src="/item_img/{{ $item->item_image }}"
                                    alt="">
                            </a>
                        </td>
                        <td>
                            <h6> {{ $item->title }} </h6>
                        </td>
                        {{-- <td class="text-truncate" style="max-width: 150px;">{{ $item->about }}</td> --}}
                        {{-- <td>{{ $item->item_count }}</td> --}}
                        <td>
                            @if ($item->reduced_price == null)
                                <p class="mb-0">{{ $item->price }}</p>
                            @else
                                <p class="text-decoration-line-through">{{ $item->price }}</p>
                            @endif
                        </td>
                        <td>
                            @if ($item->reduced_price == null)
                                NULL
                            @endif
                            {{ $item->reduced_price }}
                        </td>
                        {{-- <td>{{ $item->created_at }}</td> --}}
                        <td class="d-flex">
                            {{-- <form action="{{ url('/delete/item/'. $item->id) }}" method="POST">
                    @csrf --}}
                            {{-- </form> --}}
                            <a href="{{ url('admin/' . $item->id . '/edit') }}" class="btn btn-primary">Edit</a>
                        </td>
                        <td>
                            <div>
                                <input type="checkbox" name="items[]" value="{{ $item->id }}">
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $items->links('layouts.bootstrap-5') }}
@endsection
