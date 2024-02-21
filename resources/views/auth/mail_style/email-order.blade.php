<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <?php
      use App\Models\Item;
      use App\Models\User;
      $item = Item::find($order->item_id);
    ?>
    <div>
        <div class="col d-flex flex-column align-items-center p-3">
            <div class="shadow-sm border p-3">
                <h5> Order-id: {{ $order->id }}</h5>
                <h5> Product_Name: {{ $item->title }}</h5>
                <h5>Total Price: {{ $order->total }}</h5>
                <h5> Count: {{ $order->count }}</h5>
                <h5> Order date: {{ $order->created_at }}</p></h5>
                <h5> User_Name: {{ $user->name }}</h5>
                <h5>Email: <a href="mailto:{{ $user->email }}">{{ $user->email }}</a></h5>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>
