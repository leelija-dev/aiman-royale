<!DOCTYPE html>
<html>
<head>
    <title>New Order Notification</title>
</head>
<body>
    <h2>New Order Received!</h2>
    <p><strong>Order #:</strong> {{ $order->id }}</p>
    <p><strong>Customer:</strong> {{ $customerName }}</p>
    <p><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
    
    <h3>Order Items:</h3>
    <ul>
        @foreach($order->items as $item)
            <li>{{ $item->name }} - {{ $item->quantity }} x ${{ $item->price }}</li>
        @endforeach
    </ul>
    <p><strong>Total:</strong> ${{ $order->total }}</p>
    
    <p>Please process this order as soon as possible.</p>
</body>
</html>