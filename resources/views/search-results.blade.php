@foreach ($items as $item)
@if ($item->item_count != 0)
<div class="col">
    <a href="/item/detail/{{ $item->id }}" id="card"
        class="h-100 border-0 mb-sm-2 mb-1 border-light text-decoration-none text-dark">
        <div class="card home-card h-100 border border-1 rounded-3">
            <div class="">
                <div class="parent">
                    {{-- <div style="border-radius: 1rem 1rem 0px 0px; background: url('item_img/{{ $item->item_image }}') no-repeat center; background-size: contain;"
                        class="card-img-top card_img mb-1">
                    </div> --}}
                    <img src="item_img/{{ $item->item_image }}" alt=""
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
                    <p class="card-text">
                        <small class="text-muted">
                            {{ $item->sales }} sales
                        </small>
                    </p>
                </div>
            </div>
        </div>
    </a>
</div>
@endif
@endforeach
