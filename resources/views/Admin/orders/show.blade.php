@extends('Admin.layouts.master')

@section('title', 'Order Details - #' . $order->id)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Order Details #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-default">
                            <i class="fas fa-arrow-left"></i> Back to Orders
                        </a>
                        <button type="button" class="btn btn-sm btn-primary" onclick="window.print()">
                            <i class="fas fa-print"></i> Print
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Order Summary -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-info">
                                    <i class="fas fa-shopping-cart"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Order Status</span>
                                    <span class="info-box-number">
                                        <span class="badge badge-{{ $order->order_status == 'delivered' ? 'success' : ($order->order_status == 'cancelled' ? 'danger' : ($order->order_status == 'shipped' ? 'primary' : ($order->order_status == 'paid' ? 'success' : ($order->order_status == 'confirmed' ? 'info' : 'warning')))) }}">
                                            {{ ucfirst($order->order_status) }}
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-success">
                                    <i class="fas fa-dollar-sign"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Amount</span>
                                    <span class="info-box-number">{{ config('app.currency') }}{{ number_format($order->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Information -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5><i class="fas fa-user"></i> Customer Information</h5>
                            <table class="table table-sm">
                                <tr>
                                    <td width="150"><strong>Name:</strong></td>
                                    <td>{{ $order->user->name ?? 'Guest User' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $order->user->email ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Phone:</strong></td>
                                    <td>{{ $order->user->phone ?? 'N/A' }}</td>
                                </tr>
                                @if($order->shipping_address)
                                <tr>
                                    <td><strong>Shipping Address:</strong></td>
                                    <td>
                                        {{ $order->shipping_address->address ?? '' }}<br>
                                        {{ $order->shipping_address->city ?? '' }}, {{ $order->shipping_address->state ?? '' }}<br>
                                        {{ $order->shipping_address->country ?? '' }}
                                    </td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5><i class="fas fa-truck"></i> Shipping Information</h5>
                            <table class="table table-sm">
                                <tr>
                                    <td width="150"><strong>Order Date:</strong></td>
                                    <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tracking Number:</strong></td>
                                    <td>
                                        @if($order->tracking_number)
                                            <code>{{ $order->tracking_number }}</code>
                                            <button type="button" class="btn btn-xs btn-info ml-2" onclick="copyTracking('{{ $order->tracking_number }}')">
                                                <i class="fas fa-copy"></i> Copy
                                            </button>
                                        @else
                                            <span class="text-muted">Not available</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Payment Status:</strong></td>
                                    <td>
                                        <span class="badge badge-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">
                                            {{ ucfirst($order->payment_status ?? 'pending') }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="row">
                        <div class="col-12">
                            <h5><i class="fas fa-box"></i> Order Items ({{ $order->orderProducts->count() }})</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Variant</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->orderProducts as $orderProduct)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="mr-3">
                                                            @if($orderProduct->product->images && $orderProduct->product->images->first())
                                                                <img src="{{ asset($orderProduct->product->images->first()->image) }}" 
                                                                     alt="{{ $orderProduct->product->name }}" 
                                                                     class="img-thumbnail" 
                                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                                            @else
                                                                <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                                                    <i class="fas fa-box text-gray-500"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <strong>{{ $orderProduct->product->name }}</strong>
                                                            @if($orderProduct->product->sku)
                                                                <br><small class="text-muted">SKU: {{ $orderProduct->product->sku }}</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge badge-info">
                                                        {{ $orderProduct->variant->size ?? 'N/A' }}
                                                    </span>
                                                    @if($orderProduct->variant && $orderProduct->variant->color)
                                                        <span class="badge badge-secondary ml-1">{{ ucfirst($orderProduct->variant->color) }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $orderProduct->quantity }}</td>
                                                <td>{{ config('app.currency') }}{{ number_format($orderProduct->price, 2) }}</td>
                                                <td><strong>{{ config('app.currency') }}{{ number_format($orderProduct->total, 2) }}</strong></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-light">
                                            <th colspan="3" class="text-right">Subtotal:</th>
                                            <td>{{ config('app.currency') }}{{ number_format($order->subtotal, 2) }}</td>
                                        </tr>
                                        <tr class="bg-light">
                                            <th colspan="3" class="text-right">Shipping:</th>
                                            <td>{{ config('app.currency') }}{{ number_format($order->shipping_cost, 2) }}</td>
                                        </tr>
                                        <tr class="bg-light">
                                            <th colspan="3" class="text-right">Tax:</th>
                                            <td>{{ config('app.currency') }}{{ number_format($order->tax_amount, 2) }}</td>
                                        </tr>
                                        <tr class="bg-primary text-white">
                                            <th colspan="3" class="text-right">Total:</th>
                                            <td><strong>{{ config('app.currency') }}{{ number_format($order->total_amount, 2) }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Order Actions -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">
                                        <i class="fas fa-tools"></i> Order Actions
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Status Update -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label font-weight-bold">
                                                <i class="fas fa-sync-alt text-primary"></i> Update Order Status
                                            </label>
                                            
                                            <!-- Current Status Display -->
                                            <div class="alert alert-light border mb-3">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <small class="text-muted">Current Status:</small>
                                                        <div class="mt-1">
                                                            @php
                                                            $statusClass = [
                                                            'pending' => 'warning',
                                                            'confirmed' => 'info', 
                                                            'paid' => 'success',
                                                            'shipped' => 'primary',
                                                            'delivered' => 'success',
                                                            'cancelled' => 'danger',
                                                            'returned' => 'secondary',
                                                            ][$order->order_status] ?? 'secondary';
                                                            @endphp
                                                            <span class="badge badge-{{ $statusClass }} badge-lg">
                                                                <i class="fas fa-{{ 
                                                                    $order->order_status == 'delivered' ? 'check-circle' : 
                                                                    ($order->order_status == 'cancelled' ? 'times-circle' : 
                                                                    ($order->order_status == 'shipped' ? 'truck' : 
                                                                    ($order->order_status == 'paid' ? 'dollar-sign' : 
                                                                    ($order->order_status == 'confirmed' ? 'check' : 'clock')))) 
                                                                }}"></i>
                                                                {{ ucfirst($order->order_status) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <small class="text-muted">Last Updated:</small>
                                                        <div class="mt-1">
                                                            <small>{{ $order->updated_at->format('M d, Y h:i A') }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="btn-group w-100" role="group">
                                                <button type="button" class="btn btn-outline-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-cog"></i> Change Status
                                                </button>
                                                <div class="dropdown-menu">
                                                    @if($order->order_status != 'pending')
                                                        <a class="dropdown-item" href="#" onclick="updateOrderStatus({{ $order->id }}, 'pending')">
                                                            <i class="fas fa-clock text-warning"></i> Mark as Pending
                                                        </a>
                                                    @endif
                                                    @if($order->order_status != 'confirmed')
                                                        <a class="dropdown-item" href="#" onclick="updateOrderStatus({{ $order->id }}, 'confirmed')">
                                                            <i class="fas fa-check text-info"></i> Mark as Confirmed
                                                        </a>
                                                    @endif
                                                    @if($order->order_status != 'paid')
                                                        <a class="dropdown-item" href="#" onclick="updateOrderStatus({{ $order->id }}, 'paid')">
                                                            <i class="fas fa-dollar-sign text-success"></i> Mark as Paid
                                                        </a>
                                                    @endif
                                                    @if($order->order_status != 'shipped')
                                                        <a class="dropdown-item" href="#" onclick="updateOrderStatus({{ $order->id }}, 'shipped')">
                                                            <i class="fas fa-truck text-primary"></i> Mark as Shipped
                                                        </a>
                                                    @endif
                                                    @if($order->order_status != 'delivered')
                                                        <a class="dropdown-item" href="#" onclick="updateOrderStatus({{ $order->id }}, 'delivered')">
                                                            <i class="fas fa-check-circle text-success"></i> Mark as Delivered
                                                        </a>
                                                    @endif
                                                    @if($order->order_status != 'cancelled')
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item text-danger" href="#" onclick="updateOrderStatus({{ $order->id }}, 'cancelled')">
                                                            <i class="fas fa-times"></i> Cancel Order
                                                        </a>
                                                    @endif
                                                    @if($order->order_status != 'returned')
                                                        <a class="dropdown-item text-secondary" href="#" onclick="updateOrderStatus({{ $order->id }}, 'returned')">
                                                            <i class="fas fa-undo"></i> Mark as Returned
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tracking Number -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label font-weight-bold">
                                                <i class="fas fa-shipping-fast text-info"></i> Tracking Number
                                            </label>
                                            <form action="{{ route('admin.orders.update-tracking', $order) }}" method="POST">
                                                @csrf
                                                <div class="input-group">
                                                    <input type="text" 
                                                           name="tracking_number" 
                                                           class="form-control" 
                                                           placeholder="Enter tracking number..." 
                                                           value="{{ $order->tracking_number ?? '' }}">
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn btn-info">
                                                            <i class="fas fa-save"></i> Update
                                                        </button>
                                                    </div>
                                                </div>
                                                @if($order->tracking_number)
                                                    <small class="text-muted mt-1 d-block">
                                                        <i class="fas fa-check-circle text-success"></i> 
                                                        Tracking: {{ $order->tracking_number }}
                                                    </small>
                                                @endif
                                            </form>
                                        </div>

                                        <!-- Additional Actions -->
                                        <div class="col-12">
                                            <div class="d-flex flex-wrap gap-2">
                                                <button type="button" class="btn btn-success" onclick="sendInvoice({{ $order->id }})">
                                                    <i class="fas fa-envelope"></i> Send Invoice
                                                </button>
                                                
                                                <button type="button" class="btn btn-primary" onclick="window.print()">
                                                    <i class="fas fa-print"></i> Print Order
                                                </button>
                                                
                                                <button type="button" class="btn btn-outline-secondary" onclick="copyOrderLink({{ $order->id }})">
                                                    <i class="fas fa-link"></i> Copy Link
                                                </button>

                                                <div class="dropdown">
                                                    <button type="button" class="btn btn-outline-info dropdown-toggle" data-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-h"></i> More Actions
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#" onclick="downloadInvoice({{ $order->id }})">
                                                            <i class="fas fa-download"></i> Download Invoice
                                                        </a>
                                                        <a class="dropdown-item" href="#" onclick="sendCustomerNotification({{ $order->id }})">
                                                            <i class="fas fa-bell"></i> Send Notification
                                                        </a>
                                                        <a class="dropdown-item" href="#" onclick="addOrderNotes({{ $order->id }})">
                                                            <i class="fas fa-sticky-note"></i> Add Notes
                                                        </a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item text-danger" href="#" onclick="confirmDeleteOrder({{ $order->id }})">
                                                            <i class="fas fa-trash"></i> Delete Order
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateOrderStatus(orderId, status) {
    if (confirm(`Are you sure you want to mark this order as ${status}?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/orders/${orderId}/status`;
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = csrfToken;
        
        const statusInput = document.createElement('input');
        statusInput.type = 'hidden';
        statusInput.name = 'status';
        statusInput.value = status;
        
        form.appendChild(tokenInput);
        form.appendChild(statusInput);
        document.body.appendChild(form);
        form.submit();
    }
}

function copyTracking(trackingNumber) {
    navigator.clipboard.writeText(trackingNumber).then(() => {
        // Show success message
        const toast = document.createElement('div');
        toast.className = 'position-fixed top-0 right-0 bg-green-500 text-white px-4 py-2 m-2 z-50';
        toast.innerHTML = 'Tracking number copied to clipboard!';
        document.body.appendChild(toast);
        
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 2000);
    });
}

function sendInvoice(orderId) {
    if (confirm('Send invoice to customer?')) {
        fetch(`/admin/orders/${orderId}/send-invoice`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Invoice sent successfully!');
            } else {
                alert('Failed to send invoice: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while sending invoice');
        });
    }
}

function copyOrderLink(orderId) {
    const orderLink = `${window.location.origin}/admin/orders/${orderId}`;
    navigator.clipboard.writeText(orderLink).then(() => {
        showToast('Order link copied to clipboard!', 'success');
    }).catch(err => {
        console.error('Failed to copy:', err);
        showToast('Failed to copy link', 'error');
    });
}

function downloadInvoice(orderId) {
    window.open(`/admin/orders/${orderId}/invoice/download`, '_blank');
}

function sendCustomerNotification(orderId) {
    if (confirm('Send notification to customer about this order?')) {
        fetch(`/admin/orders/${orderId}/notify`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Notification sent successfully!', 'success');
            } else {
                showToast('Failed to send notification: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('An error occurred while sending notification', 'error');
        });
    }
}

function addOrderNotes(orderId) {
    const notes = prompt('Enter order notes:');
    if (notes) {
        fetch(`/admin/orders/${orderId}/notes`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ notes: notes })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Notes added successfully!', 'success');
                location.reload();
            } else {
                showToast('Failed to add notes: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('An error occurred while adding notes', 'error');
        });
    }
}

function confirmDeleteOrder(orderId) {
    if (confirm('Are you sure you want to delete this order? This action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/orders/${orderId}`;
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = csrfToken;
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        
        form.appendChild(tokenInput);
        form.appendChild(methodInput);
        document.body.appendChild(form);
        form.submit();
    }
}

function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `position-fixed top-0 right-0 px-4 py-3 m-2 z-50 rounded text-white ${
        type === 'success' ? 'bg-success' : 
        type === 'error' ? 'bg-danger' : 
        'bg-info'
    }`;
    toast.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="fas fa-${
                type === 'success' ? 'check-circle' : 
                type === 'error' ? 'exclamation-triangle' : 
                'info-circle'
            } mr-2"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        if (toast.parentNode) {
            toast.parentNode.removeChild(toast);
        }
    }, 3000);
}
</script>

<style>
.img-thumbnail {
    border: 1px solid #ddd;
    border-radius: 4px;
}

.position-fixed {
    position: fixed;
    top: 0;
    right: 0;
}
</style>
@endsection
