<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #fff;
            color: #333;
            padding: 40px;
            font-size: 14px;
        }
        
        .invoice-container {
            max-width: 1000px;
            margin: 0 auto;
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 40px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        /* Header */
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .company-info h1 {
            font-size: 28px;
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .company-info .subtitle {
            color: #7f8c8d;
            font-size: 14px;
        }
        
        .invoice-title {
            text-align: right;
        }
        
        .invoice-title h2 {
            font-size: 32px;
            color: #2c3e50;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .invoice-title .invoice-number {
            font-size: 16px;
            color: #7f8c8d;
            margin-top: 5px;
        }
        
        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            margin-top: 5px;
        }
        
        .status-delivered { background: #27ae60; color: #fff; }
        .status-cancelled { background: #e74c3c; color: #fff; }
        .status-shipped { background: #3498db; color: #fff; }
        .status-paid { background: #2ecc71; color: #fff; }
        .status-confirmed { background: #9b59b6; color: #fff; }
        .status-pending { background: #f39c12; color: #fff; }
        
        /* Address Section */
        .address-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        
        .address-box {
            flex: 1;
        }
        
        .address-box h4 {
            font-size: 14px;
            color: #7f8c8d;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }
        
        .address-box p {
            line-height: 1.6;
            font-size: 14px;
        }
        
        .address-box .name {
            font-weight: 600;
            font-size: 16px;
            color: #2c3e50;
        }
        
        /* Order Info */
        .order-info {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 30px;
            padding: 15px 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        
        .order-info-item {
            text-align: center;
        }
        
        .order-info-item .label {
            font-size: 12px;
            color: #7f8c8d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .order-info-item .value {
            font-size: 16px;
            font-weight: 600;
            color: #2c3e50;
            margin-top: 2px;
        }
        
        /* Table */
        .table-container {
            margin-bottom: 30px;
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        thead {
            background: #2c3e50;
            color: #fff;
        }
        
        th {
            padding: 12px 15px;
            text-align: left;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        td {
            padding: 12px 15px;
            border-bottom: 1px solid #e0e0e0;
        }
        
        tbody tr:hover {
            background: #f8f9fa;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .product-name {
            font-weight: 500;
        }
        
        .product-sku {
            font-size: 12px;
            color: #7f8c8d;
        }
        
        .variant-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            background: #ecf0f1;
            color: #2c3e50;
        }
        
        /* Totals */
        .totals-section {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }
        
        .totals-table {
            width: 350px;
        }
        
        .totals-table td {
            padding: 8px 15px;
            border: none;
        }
        
        .totals-table .total-label {
            font-weight: 500;
            color: #7f8c8d;
        }
        
        .totals-table .total-amount {
            font-weight: 600;
            font-size: 16px;
        }
        
        .totals-table .grand-total td {
            font-size: 18px;
            font-weight: 700;
            color: #2c3e50;
            border-top: 2px solid #2c3e50;
            padding-top: 12px;
        }
        
        /* Footer */
        .invoice-footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            color: #7f8c8d;
        }
        
        .footer-notes {
            flex: 1;
        }
        
        .footer-notes p {
            margin-bottom: 5px;
        }
        
        .footer-notes .thanks {
            font-size: 16px;
            font-weight: 500;
            color: #2c3e50;
        }
        
        /* Responsive */
        @media print {
            body {
                padding: 20px;
            }
            .invoice-container {
                border: none;
                padding: 20px;
                box-shadow: none;
            }
            .no-print {
                display: none !important;
            }
            .address-section, .order-info {
                background: #f8f9fa !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            thead {
                background: #2c3e50 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .status-badge {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
        
        @media (max-width: 768px) {
            .invoice-container {
                padding: 20px;
            }
            .invoice-header {
                flex-direction: column;
                align-items: flex-start;
            }
            .invoice-title {
                text-align: left;
                margin-top: 10px;
            }
            .address-section {
                flex-direction: column;
                gap: 15px;
            }
            .order-info {
                grid-template-columns: repeat(2, 1fr);
            }
            .totals-section {
                justify-content: flex-start;
            }
            .totals-table {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container" id="invoice-content">
        <!-- Header -->
        <div class="invoice-header">
            <div class="company-info">
                <h1>{{ config('app.name', 'Ayman Royale') }}</h1>
                <p class="subtitle">Premium Fashion & Lifestyle</p>
                <p style="font-size: 13px; color: #7f8c8d; margin-top: 5px;">
                    <i class="fas fa-map-marker-alt"></i> 123 Fashion Street, Mumbai, India<br>
                    <i class="fas fa-phone"></i> +91 9876543210<br>
                    <i class="fas fa-envelope"></i> info@aymanroyale.com
                </p>
            </div>
            <div class="invoice-title">
                <h2>INVOICE</h2>
                <div class="invoice-number">
                    #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                </div>
                <span class="status-badge status-{{ $order->order_status }}">
                    {{ ucfirst($order->order_status) }}
                </span>
            </div>
        </div>

        <!-- Address Section -->
        <div class="address-section">
            <div class="address-box">
                <h4>Bill To</h4>
                <p>
                    <span class="name">{{ $order->user->name ?? 'Guest User' }}</span><br>
                    {{ $order->address_1 ?? '' }}
                    @if($order->address_2)
                        , {{ $order->address_2 }}
                    @endif
                    <br>
                    {{ $order->city ?? '' }}, {{ $order->state ?? '' }}<br>
                    PIN: {{ $order->pincode ?? '' }}<br>
                    Phone: {{ $order->user->phone ?? 'N/A' }}<br>
                    Email: {{ $order->user->email ?? 'N/A' }}
                </p>
            </div>
            <div class="address-box" style="text-align: right;">
                <h4>Ship To</h4>
                <p>
                    <span class="name">{{ $order->user->name ?? 'Guest User' }}</span><br>
                    {{ $order->address_1 ?? '' }}
                    @if($order->address_2)
                        , {{ $order->address_2 }}
                    @endif
                    <br>
                    {{ $order->city ?? '' }}, {{ $order->state ?? '' }}<br>
                    PIN: {{ $order->pincode ?? '' }}<br>
                    Phone: {{ $order->user->phone ?? 'N/A' }}
                </p>
            </div>
        </div>

        <!-- Order Info -->
        <div class="order-info">
            <div class="order-info-item">
                <div class="label">Order Date</div>
                <div class="value">{{ $order->created_at->format('d M, Y') }}</div>
            </div>
            <div class="order-info-item">
                <div class="label">Payment Method</div>
                <div class="value">{{ ucfirst($order->payment_method ?? 'N/A') }}</div>
            </div>
            <div class="order-info-item">
                <div class="label">Payment Status</div>
                <div class="value">{{ ucfirst($order->payment_status ?? 'Pending') }}</div>
            </div>
            <div class="order-info-item">
                <div class="label">Waybill Number</div>
                <div class="value">{{ $order->waybill_number ?? 'N/A' }}</div>
            </div>
        </div>

        <!-- Order Items Table -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 40%;">Product</th>
                        <th style="width: 15%;">Variant</th>
                        <th style="width: 10%;" class="text-center">Qty</th>
                        <th style="width: 15%;" class="text-right">Price</th>
                        <th style="width: 20%;" class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderProducts as $item)
                        <tr>
                            <td>
                                <div class="product-name">{{ $item->product->name ?? 'Product' }}</div>
                                @if(isset($item->product->sku))
                                    <div class="product-sku">SKU: {{ $item->product->sku }}</div>
                                @endif
                                @if($item->coupon_code)
                                    <div style="font-size: 12px; color: #27ae60;">
                                        <i class="fas fa-tag"></i> Coupon: {{ $item->coupon_code }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if($item->variant)
                                    <span class="variant-badge">
                                        {{ $item->variant->size ?? 'N/A' }}
                                    </span>
                                    @if($item->variant->color)
                                        <span class="variant-badge" style="background: #e8f0fe; color: #1a73e8;">
                                            {{ ucfirst($item->variant->color) }}
                                        </span>
                                    @endif
                                @else
                                    <span class="variant-badge">Standard</span>
                                @endif
                            </td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-right">{{ config('app.currency') }}{{ number_format($item->price, 2) }}</td>
                            <td class="text-right"><strong>{{ config('app.currency') }}{{ number_format($item->total, 2) }}</strong></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Totals -->
        <div class="totals-section">
            <table class="totals-table">
                <tr>
                    <td class="total-label">Subtotal</td>
                    <td class="text-right">{{ config('app.currency') }}{{ number_format($order->subtotal ?? $order->total_amount, 2) }}</td>
                </tr>
                @if(isset($order->gst_amount) && $order->gst_amount > 0)
                    <tr>
                        <td class="total-label">GST ({{ $order->gst_percentage ?? 0 }}%)</td>
                        <td class="text-right">{{ config('app.currency') }}{{ number_format($order->gst_amount, 2) }}</td>
                    </tr>
                @endif
                @if(isset($order->special_discount_amount) && $order->special_discount_amount > 0)
                    <tr>
                        <td class="total-label">Discount <span style="color: #e74c3c; font-size: 12px;">({{ $order->special_discount_percentage ?? 0 }}% off)</span></td>
                        <td class="text-right" style="color: #e74c3c;">-{{ config('app.currency') }}{{ number_format($order->special_discount_amount, 2) }}</td>
                    </tr>
                @endif
                @if(isset($order->shipping_charge) && $order->shipping_charge > 0)
                    <tr>
                        <td class="total-label">Shipping</td>
                        <td class="text-right">{{ config('app.currency') }}{{ number_format($order->shipping_charge, 2) }}</td>
                    </tr>
                @endif
                <tr class="grand-total">
                    <td style="font-weight: 700; font-size: 18px;">Grand Total</td>
                    <td class="text-right" style="font-weight: 700; font-size: 18px;">
                        {{ config('app.currency') }}{{ number_format($order->total_amount, 2) }}
                    </td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <div class="invoice-footer">
            <div class="footer-notes">
                <p class="thanks">Thank you for your order!</p>
                <p>We hope you enjoy your purchase. For any queries, please contact our support team.</p>
                @if($order->order_status == 'pending' || $order->order_status == 'confirmed')
                    <p style="color: #e74c3c; margin-top: 5px;">
                        <i class="fas fa-clock"></i> Estimated delivery: 5-7 business days
                    </p>
                @endif
            </div>
            <div style="text-align: right;">
                <p style="font-size: 12px; color: #95a5a6;">
                    Invoice generated on {{ now()->format('d M, Y h:i A') }}
                </p>
                <p style="font-size: 12px; color: #95a5a6;">
                    This is a system generated invoice
                </p>
            </div>
        </div>
    </div>

    <!-- Print Button -->
    <div style="text-align: center; margin-top: 20px;" class="no-print">
        <button onclick="window.print()" class="btn btn-primary" style="padding: 10px 30px; font-size: 16px; background: #3498db; color: #fff; border: none; border-radius: 4px; cursor: pointer;">
            <i class="fas fa-print"></i> Print Invoice
        </button>
    </div>
</body>
</html>