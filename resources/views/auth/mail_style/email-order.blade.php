<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .order-details {
            max-width: 400px;
            width: 100%;
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            padding: 20px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .order-details h5 {
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 1.25rem;
            font-weight: bold;
        }

        .order-details p {
            margin-top: 10px;
            margin-bottom: 0;
        }

        .order-details a {
            color: #007bff;
            text-decoration: none;
        }

        .order-details a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <?php
    use App\Models\Item;
    use App\Models\User;
    $item = Item::find($order->item_id);
    ?>
    <div class="container">
        <div class="order-details">
            <h5>Order id: {{ $order->id }}</h5>
            <h5>Product Name: {{ $item->title }}</h5>
            <h5>Total Price: {{ $order->total }}</h5>
            <h5>Count: {{ $order->count }}</h5>
            <h5>Order Date: {{ $order->created_at }}</h5>
            <h5>User Name: {{ $user->name }}</h5>
            @if ($user->chat_id)
                @php
                    $chatIdData = json_decode($user->chat_id, true); // Decode JSON string into an associative array
                @endphp
                @foreach ($chatIdData as $key => $value)
                    <h5>{{ $key }}: {{ $value }}</h5>
                @endforeach
            @endif
            <h5>Email: <a href="mailto:{{ $user->email }}">{{ $user->email }}</a></h5>
            <p>{{ $order->note }}</p>
        </div>
    </div>
</body>

</html>
