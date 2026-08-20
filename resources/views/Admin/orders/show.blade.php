@extends('Admin.layouts.master')

@section('title', 'Order Details - #' . $order->id)
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Order Details #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h3>
                    {{--
                    <div class="card-tools">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-default">
                            <i class="fas fa-arrow-left"></i> Back to Orders
                        </a>
                        <button type="button" class="btn btn-sm btn-primary" onclick="window.print()">
                            <i class="fas fa-print"></i> Print
                        </button>
                    </div>
                    --}}
                    <div class="card-tools">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-default">
        <i class="fas fa-arrow-left"></i> Back to Orders
    </a>
    <button type="button" class="btn btn-sm btn-primary" onclick="window.print()">
        <i class="fas fa-print"></i> Print
    </button>
    <!-- 🔥 NEW: Invoice Button -->
    <a href="{{ route('admin.orders.invoice', $order->id) }}" 
       class="btn btn-sm btn-success" 
       target="_blank">
        <i class="fas fa-file-invoice"></i> View Invoice
    </a>
    <a href="{{ route('admin.orders.invoice.download', $order->id) }}" 
       class="btn btn-sm btn-info">
        <i class="fas fa-download"></i> Download Invoice
    </a>
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
                                    <span class="badge bg-{{ 
    $order->order_status == 'delivered' ? 'success' : 
    ($order->order_status == 'cancelled' ? 'danger' : 
    ($order->order_status == 'shipped' ? 'primary' : 
    ($order->order_status == 'paid' ? 'success' : 
    ($order->order_status == 'confirmed' ? 'info' : 'warning')))) 
}}">
    {{ ucfirst($order->order_status) }}
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
                                <tr>
                                    <td><strong>Address:</strong></td>
                                    <td>
                                        {{ $order->address_1 ?? '' }}
                                        @if($order->address_2)
                                            , {{ $order->address_2 }}
                                        @endif
                                        <br>
                                        {{ $order->city ?? '' }}, {{ $order->state ?? '' }}<br>
                                        PIN: {{ $order->pincode ?? '' }}
                                    </td>
                                </tr>
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
                                    <td><strong>Waybill Number:</strong></td>
                                    <td>
                                        @if($order->waybill_number)
                                            <code>{{ $order->waybill_number }}</code>
                                            <button type="button" class="btn btn-xs btn-info ml-2" onclick="copyTracking('{{ $order->waybill_number }}')">
                                                <i class="fas fa-copy"></i> Copy
                                            </button>
                                        @else
                                            <span class="text-muted">Not available</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Pickup ID:</strong></td>
                                    <td>{{ $order->pickup_id ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Courier:</strong></td>
                                    <td>{{ $order->courier_name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Payment Status:</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">
    {{ ucfirst($order->payment_status ?? 'pending') }}
</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Payment Method:</strong></td>
                                    <td>{{ ucfirst($order->payment_method ?? 'N/A') }}</td>
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
                                            <th>Applied Coupon</th>
                                            <th>Coupon Discount</th>
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
                                                                     style="width: 50px; height: 50px; object-fit: cover;"  onclick="showImagePreview(this.src, '{{ $orderProduct->product->name }}')">
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
    @if($orderProduct->variant)
        <span class="badge bg-info">
            {{ $orderProduct->variant->size ?? 'N/A' }}
        </span>
        @if($orderProduct->variant->color)
            <span class="badge bg-secondary ms-1">{{ ucfirst($orderProduct->variant->color) }}</span>
        @endif
    @else
        <span class="text-muted">N/A</span>
    @endif
</td>
                                                <td>{{ $orderProduct->quantity }}</td>
                                                <td>{{ config('app.currency') }}{{ number_format($orderProduct->price, 2) }}</td>
                                                
                                                <td>{{ $orderProduct->coupon_code ?? 'N/A' }}</td>
                                                <td><strong>{{ config('app.currency') }}{{ number_format($orderProduct->coupon_discount_amount, 2) }}</strong></td>
                                                <td><strong>{{ config('app.currency') }}{{ number_format($orderProduct->total, 2) }}</strong></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-light">
                                            <th colspan="3" class="text-right">Subtotal:</th>
                                            <td>{{ config('app.currency') }}{{ number_format($order->subtotal ?? $order->total_amount, 2) }}</td>
                                        </tr>
                                        @if(isset($order->gst_amount) && $order->gst_amount > 0)
                                        <tr class="bg-light">
                                            <th colspan="3" class="text-right">GST:</th>
                                            <td>{{ config('app.currency') }}{{ number_format($order->gst_amount, 2) }}</td>
                                        </tr>
                                        @endif
                                        @if(isset($order->special_discount_amount) && $order->special_discount_amount > 0)
                                        <tr class="bg-light">
                                            <th colspan="3" class="text-right">Discount:</th>
                                            <td>-{{ config('app.currency') }}{{ number_format($order->special_discount_amount, 2) }}</td>
                                        </tr>
                                        @endif
                                        <tr class="bg-primary text-white">
                                            <th colspan="3" class="text-right">Total:</th>
                                            <td><strong>{{ config('app.currency') }}{{ number_format($order->total_amount, 2) }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Tracking Information -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">
                                        <i class="fas fa-map-marker-alt text-info"></i> Track Shipment
                                    </h5>
                                </div>
                                <div class="card-body">
                                    @if($order->waybill_number)
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="d-flex align-items-center gap-3 mb-3">
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-light">
                                                            <i class="fas fa-tag"></i>
                                                        </span>
                                                        <input type="text" 
                                                               id="waybill-input" 
                                                               class="form-control" 
                                                               value="{{ $order->waybill_number }}" 
                                                               readonly>
                                                        <button class="btn btn-outline-secondary" 
                                                                onclick="copyWaybill('{{ $order->waybill_number }}')">
                                                            <i class="fas fa-copy"></i>
                                                        </button>
                                                        <button class="btn btn-primary" 
                                                                onclick="trackShipment('{{ $order->waybill_number }}')">
                                                            <i class="fas fa-sync-alt"></i> Track Now
                                                        </button>
                                                    </div>
                                                </div>
                                                
                                                <!-- Tracking Status Badge -->
                                                <div class="d-flex align-items-center gap-3 flex-wrap">
                                                    <span class="badge badge-{{ 
                                                        $order->tracking_status == 'Delivered' ? 'success' : 
                                                        ($order->tracking_status == 'Out for Delivery' ? 'warning' : 
                                                        ($order->tracking_status == 'In Transit' ? 'info' : 
                                                        ($order->tracking_status == 'Shipment Created' ? 'primary' : 'secondary'))) 
                                                    }} badge-lg">
                                                        <i class="fas fa-{{ 
                                                            $order->tracking_status == 'Delivered' ? 'check-circle' : 
                                                            ($order->tracking_status == 'Out for Delivery' ? 'truck' : 
                                                            ($order->tracking_status == 'In Transit' ? 'shipping-fast' : 
                                                            ($order->tracking_status == 'Shipment Created' ? 'box' : 'clock'))) 
                                                        }}"></i>
                                                        {{ $order->tracking_status ?? 'Pending' }}
                                                    </span>
                                                    
                                                    @if($order->last_tracking_location)
                                                        <span class="text-muted">
                                                            <i class="fas fa-map-pin"></i> 
                                                            {{ $order->last_tracking_location }}
                                                        </span>
                                                    @endif
                                                    
                                                    @if($order->updated_at)
                                                        <span class="text-muted small">
                                                            <i class="fas fa-clock"></i> 
                                                            Last updated: {{ $order->updated_at->format('M d, Y h:i A') }}
                                                        </span>
                                                    @endif
                                                </div>
                                                
                                                <!-- Tracking Details -->
                                                <div id="tracking-details" class="mt-4">
                                                    @if($order->tracking_data)
                                                        <div class="text-center text-muted py-3">
                                                            <i class="fas fa-check-circle text-success"></i>
                                                            <p class="mt-2">Tracking data available. Click "Track Now" to view latest updates.</p>
                                                        </div>
                                                    @else
                                                        <div class="text-center text-muted py-3">
                                                            <i class="fas fa-spinner fa-spin fa-2x"></i>
                                                            <p class="mt-2">Click "Track Now" to fetch latest tracking information</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <div class="bg-light p-3 rounded">
                                                    <h6 class="font-weight-bold">
                                                        <i class="fas fa-info-circle text-primary"></i> Quick Actions
                                                    </h6>
                                                    <div class="d-grid gap-2">
                                                        <a href="https://www.delhivery.com/track/{{ $order->waybill_number }}" 
                                                           target="_blank" 
                                                           class="btn btn-outline-info btn-sm">
                                                            <i class="fas fa-external-link-alt"></i> Track on Delhivery Website
                                                        </a>
                                                        <button class="btn btn-outline-success btn-sm" 
                                                                onclick="generateLabel('{{ $order->waybill_number }}')">
                                                            <i class="fas fa-print"></i> Generate Shipping Label
                                                        </button>
                                                        <button class="btn btn-outline-secondary btn-sm" 
                                                                onclick="refreshTracking('{{ $order->waybill_number }}')">
                                                            <i class="fas fa-refresh"></i> Refresh Status
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="alert alert-warning mb-0">
                                            <i class="fas fa-exclamation-triangle"></i> 
                                            No tracking number available for this order.
                                        </div>
                                    @endif
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
function copyTracking(trackingNumber) {
    navigator.clipboard.writeText(trackingNumber).then(() => {
        showToast('Tracking number copied to clipboard!', 'success');
    }).catch(() => {
        // Fallback
        const input = document.createElement('input');
        input.value = trackingNumber;
        document.body.appendChild(input);
        input.select();
        document.execCommand('copy');
        document.body.removeChild(input);
        showToast('Tracking number copied to clipboard!', 'success');
    });
}

// Track shipment function using your existing API
function trackShipment(waybill) {
    const trackingDetails = document.getElementById('tracking-details');
    
    // Show loading state
    trackingDetails.innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <p class="mt-2 text-muted">Fetching tracking details...</p>
        </div>
    `;
    
    // ✅ Using your existing API endpoint
    fetch(`/track-waybill/${waybill}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success && data.tracking) {
            displayTrackingDetails(data.tracking);
            showToast('Tracking updated successfully!', 'success');
        } else {
            showToast(data.error || 'Failed to fetch tracking details', 'error');
            trackingDetails.innerHTML = `
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> 
                    ${data.error || 'No tracking information available for this shipment'}
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred while fetching tracking details', 'error');
        trackingDetails.innerHTML = `
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> 
                Error fetching tracking details. Please try again later.
            </div>
        `;
    });
}

// Display tracking details
function displayTrackingDetails(trackingData) {
    const trackingDetails = document.getElementById('tracking-details');
    
    // Check if we have tracking data
    if (!trackingData || !trackingData.ShipmentData || trackingData.ShipmentData.length === 0) {
        trackingDetails.innerHTML = `
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> 
                No tracking information available for this shipment yet.
            </div>
        `;
        return;
    }
    
    const shipment = trackingData.ShipmentData[0];
    const status = shipment.Status || {};
    const scans = shipment.Scans || [];
    
    let html = `
        <div class="card border-0 bg-light">
            <div class="card-body">
                <!-- Current Status -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-${status.Status == 'Delivered' ? 'success' : (status.Status == 'Out for Delivery' ? 'warning' : 'primary')} 
                                        text-white rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 50px; height: 50px;">
                                <i class="fas fa-${status.Status == 'Delivered' ? 'check' : (status.Status == 'Out for Delivery' ? 'truck' : 'shipping-fast')} fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 font-weight-bold">${status.Status || 'In Transit'}</h6>
                                <small class="text-muted">${status.StatusDateTime || 'Last updated recently'}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-right">
                        <span class="badge badge-${status.Status == 'Delivered' ? 'success' : 'warning'} badge-lg">
                            ${status.Status || 'In Transit'}
                        </span>
                        ${status.Instruction ? `<br><small class="text-muted">${status.Instruction}</small>` : ''}
                    </div>
                </div>
                
                <!-- Tracking Timeline -->
                <h6 class="font-weight-bold mt-3">
                    <i class="fas fa-history text-primary"></i> Tracking History
                </h6>
                <div class="timeline">
    `;
    
    // Display scans in reverse chronological order (newest first)
    if (scans.length > 0) {
        const sortedScans = [...scans].sort((a, b) => {
            return new Date(b.ScanDateTime) - new Date(a.ScanDateTime);
        });
        
        sortedScans.forEach((scan, index) => {
            const isLatest = index === 0;
            const statusColor = scan.Status == 'Delivered' ? 'success' : 
                               (scan.Status == 'Out for Delivery' ? 'warning' : 
                               (scan.Status == 'In Transit' ? 'primary' : 'secondary'));
            
            html += `
                <div class="timeline-item ${isLatest ? 'active' : ''}">
                    <div class="timeline-marker bg-${statusColor}"></div>
                    <div class="timeline-content">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <strong>${scan.Status || 'Update'}</strong>
                                ${scan.Location ? `<br><small class="text-muted"><i class="fas fa-map-pin"></i> ${scan.Location}</small>` : ''}
                                ${scan.Reason ? `<br><small class="text-muted">${scan.Reason}</small>` : ''}
                            </div>
                            <small class="text-muted">${formatDate(scan.ScanDateTime)}</small>
                        </div>
                        ${scan.Instruction ? `<div class="mt-1"><small class="text-info">${scan.Instruction}</small></div>` : ''}
                    </div>
                </div>
            `;
        });
    } else {
        html += `
            <div class="text-center text-muted py-3">
                <i class="fas fa-clock"></i>
                <p>No tracking history available yet</p>
            </div>
        `;
    }
    
    html += `
                </div>
            </div>
        </div>
    `;
    
    // Add CSS for timeline if not already present
    if (!document.getElementById('tracking-styles')) {
        const styles = document.createElement('style');
        styles.id = 'tracking-styles';
        styles.innerHTML = `
            .timeline {
                position: relative;
                padding-left: 20px;
            }
            .timeline-item {
                position: relative;
                padding-bottom: 20px;
                padding-left: 20px;
            }
            .timeline-item:last-child {
                padding-bottom: 0;
            }
            .timeline-item::before {
                content: '';
                position: absolute;
                left: -10px;
                top: 0;
                bottom: 0;
                width: 2px;
                background: #e9ecef;
            }
            .timeline-item:last-child::before {
                bottom: 50%;
            }
            .timeline-marker {
                position: absolute;
                left: -14px;
                top: 4px;
                width: 12px;
                height: 12px;
                border-radius: 50%;
                border: 2px solid #fff;
            }
            .timeline-item.active .timeline-marker {
                width: 14px;
                height: 14px;
                left: -15px;
                animation: pulse 2s infinite;
            }
            @keyframes pulse {
                0% { transform: scale(1); }
                50% { transform: scale(1.2); }
                100% { transform: scale(1); }
            }
            .timeline-content {
                background: white;
                padding: 10px 15px;
                border-radius: 8px;
                border: 1px solid #f0f0f0;
                box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            }
        `;
        document.head.appendChild(styles);
    }
    
    trackingDetails.innerHTML = html;
}

// Format date for display
function formatDate(dateString) {
    if (!dateString) return 'N/A';
    try {
        const date = new Date(dateString);
        return date.toLocaleString('en-IN', {
            day: '2-digit',
            month: 'short',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
        });
    } catch (e) {
        return dateString;
    }
}

// Copy waybill number
function copyWaybill(waybill) {
    navigator.clipboard.writeText(waybill).then(() => {
        showToast('Waybill number copied to clipboard!', 'success');
    }).catch(() => {
        const input = document.getElementById('waybill-input');
        if (input) {
            input.select();
            document.execCommand('copy');
            showToast('Waybill number copied to clipboard!', 'success');
        }
    });
}

// Refresh tracking
function refreshTracking(waybill) {
    trackShipment(waybill);
}

// Generate shipping label (opens in new window)
function generateLabel(waybill) {
    window.open(`https://www.delhivery.com/print-label/${waybill}`, '_blank');
}

function showToast(message, type = 'info') {
    // Remove existing toast if any
    const existingToast = document.querySelector('.custom-toast');
    if (existingToast) {
        existingToast.remove();
    }
    
    const toast = document.createElement('div');
    toast.className = `custom-toast position-fixed top-0 right-0 px-4 py-3 m-2 z-50 rounded text-white ${
        type === 'success' ? 'bg-success' : 
        type === 'error' ? 'bg-danger' : 
        'bg-info'
    }`;
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 99999;
        min-width: 250px;
        max-width: 400px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        animation: slideInRight 0.5s ease;
    `;
    toast.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="fas fa-${
                type === 'success' ? 'check-circle' : 
                type === 'error' ? 'exclamation-triangle' : 
                'info-circle'
            } mr-2"></i>
            <span>${message}</span>
            <button type="button" class="close ml-3 text-white" onclick="this.parentElement.parentElement.remove()">
                <span>&times;</span>
            </button>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (toast.parentNode) {
            toast.style.animation = 'slideOutRight 0.5s ease';
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, 500);
        }
    }, 5000);
}

// Add animation styles if not present
if (!document.getElementById('toast-styles')) {
    const styles = document.createElement('style');
    styles.id = 'toast-styles';
    styles.innerHTML = `
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOutRight {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
    `;
    document.head.appendChild(styles);
}

function showImagePreview(imageSrc, productName) {
    // Create modal overlay
    const overlay = document.createElement('div');
    overlay.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        cursor: pointer;
    `;
    
    // Create image container
    const container = document.createElement('div');
    container.style.cssText = `
        max-width: 90%;
        max-height: 90%;
        padding: 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        position: relative;
    `;
    
    // Create image
    const img = document.createElement('img');
    img.src = imageSrc;
    img.alt = productName;
    img.style.cssText = `
        max-width: 100%;
        max-height: 80vh;
        object-fit: contain;
        display: block;
    `;
    
    // Create close button
    const closeBtn = document.createElement('button');
    closeBtn.innerHTML = '×';
    closeBtn.style.cssText = `
        position: absolute;
        top: 5px;
        right: 10px;
        font-size: 30px;
        background: none;
        border: none;
        cursor: pointer;
        color: #333;
    `;
    closeBtn.onclick = (e) => {
        e.stopPropagation();
        document.body.removeChild(overlay);
    };
    
    // Add click to close
    overlay.onclick = function(e) {
        if (e.target === overlay) {
            document.body.removeChild(overlay);
        }
    };
    
    // Build and append
    container.appendChild(img);
    container.appendChild(closeBtn);
    overlay.appendChild(container);
    document.body.appendChild(overlay);
}
</script>


<style>
.img-thumbnail {
    border: 1px solid #ddd;
    border-radius: 4px;
}

.badge-lg {
    font-size: 90%;
    padding: 0.5rem 0.75rem;
}

.info-box {
    display: flex;
    align-items: center;
    padding: 0.75rem 1.25rem;
    background: #fff;
    border-radius: 0.25rem;
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
    margin-bottom: 1rem;
}

.info-box-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 70px;
    height: 70px;
    border-radius: 0.25rem;
    color: #fff;
    font-size: 2rem;
}

.info-box-content {
    padding: 0 1rem;
}

.info-box-text {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    color: #6c757d;
}

.info-box-number {
    display: block;
    font-size: 1.25rem;
    font-weight: 600;
}

/* Print styles */
@media print {
    .btn {
        display: none !important;
    }
    .card-tools {
        display: none !important;
    }
    .no-print {
        display: none !important;
    }
}
</style>
@endsection