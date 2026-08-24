<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
</head>
<body>
    <h2>Thank you for your order!</h2>
    <p>Dear {{ $customerName }},</p>
    <p>Your order #{{ $order->id }} has been confirmed.</p>
    
    <h3>Order Details:</h3>
    <ul>
        @foreach($order->items as $item)
            <li>{{ $item->name }} - {{ $item->quantity }} x {{ $item->price }}</li>
        @endforeach
    </ul>
    <p><strong>Total: </strong>${{ $order->total }}</p>
    
    <p>We will notify you once your order is shipped.</p>
    <p>Thank you for shopping with us!</p>
</body>
</html>