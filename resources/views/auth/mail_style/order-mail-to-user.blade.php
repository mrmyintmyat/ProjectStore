<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f5f5f5; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">
        <h2 style="color: #333; text-align: center; margin-top: 0;">Dear {{$user->name}},</h2>
        <p style="margin-bottom: 20px;">Thank you for choosing <strong>{{env("APP_NAME")}}</strong> for your recent purchase! We're thrilled that you've placed your trust in us for your <strong>{{$order->item->title}}</strong> needs.</p>

        <h3 style="color: #333; margin-bottom: 10px;">Order Details:</h3>
        <ul style="list-style-type: none; padding: 0;">
            <li><strong>Order Number:</strong> {{$order->id}}</li>
            <li><strong>Product:</strong> {{$order->item->title}}</li>
            <li><strong>Total Amount:</strong> {{$order->total}}</li>
        </ul>

        <p style="margin-top: 20px;">Your order has been received and is now being processed with care.</p>

        <p style="margin-top: 20px;">If you have any questions or concerns about your order, feel free to contact us at <a href="mailto:nextpjofficial@gmail.com" style="color: #007bff; text-decoration: none;">nextpjofficial@gmail.com</a>.</p>

        <p style="margin-top: 20px;">Thank you again for choosing <strong>{{env("APP_NAME")}}</strong>. We appreciate your business!</p>

        <p style="margin-top: 20px;">Sincerely,<br>{{env("APP_NAME")}} Team</p>
    </div>
</body>

</html>
