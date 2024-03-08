<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .order-details {
            margin-bottom: 20px;
        }

        .order-details h2 {
            font-size: 18px;
            color: #333;
            margin: 0 0 10px;
        }

        .order-details p {
            font-size: 16px;
            color: #555;
            margin: 5px 0;
        }

        .user-details {
            margin-bottom: 20px;
        }

        .user-details h2 {
            font-size: 18px;
            color: #333;
            margin: 0 0 10px;
        }

        .user-details p {
            font-size: 16px;
            color: #555;
            margin: 5px 0;
        }

        .note {
            font-size: 16px;
            color: #555;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Order Confirmation</h1>
        </div>
        <div class="order-details">
            <h2>Order Details:</h2>
            <p><strong>Order ID:</strong> {{ $order->id }}</p>
            <p><strong>Product Name:</strong> {{ $order->item->title }}</p>
            <p><strong>Total Price:</strong> {{ $order->total }}</p>
            <p><strong>Count:</strong> {{ $order->count }}</p>
            <p><strong>Order Date:</strong> {{ $order->created_at }}</p>
        </div>
        <div class="user-details">
            <h2>User Details:</h2>
            <p><strong>User Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> <a href="mailto:{{ $user->email }}">{{ $user->email }}</a></p>
        </div>
        <div class="note">
            <p><strong>Note:</strong> {{ $order->note }}</p>
        </div>
    </div>
</body>
</html>
