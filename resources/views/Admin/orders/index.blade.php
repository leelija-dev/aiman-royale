@extends('Admin.layouts.master')

@section('title', 'Orders Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Orders Management</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-sm btn-primary" onclick="refreshStats()">
                            <i class="fas fa-sync"></i> Refresh Stats
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    <!-- Stats Cards -->
                    <div class="row mb-4" id="statsContainer">
                        <div class="col-md-2">
                            <div class="info-box">
                                <span class="info-box-icon bg-info">
                                    <i class="fas fa-shopping-cart"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Orders</span>
                                    <span class="info-box-number" id="totalOrders">0</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning">
                                    <i class="fas fa-clock"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Pending</span>
                                    <span class="info-box-number" id="pendingOrders">0</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="info-box">
                                <span class="info-box-icon bg-primary">
                                    <i class="fas fa-cog"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Processing</span>
                                    <span class="info-box-number" id="processingOrders">0</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="info-box">
                                <span class="info-box-icon bg-success">
                                    <i class="fas fa-truck"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Shipped</span>
                                    <span class="info-box-number" id="shippedOrders">0</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="info-box">
                                <span class="info-box-icon bg-success">
                                    <i class="fas fa-check"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Delivered</span>
                                    <span class="info-box-number" id="deliveredOrders">0</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger">
                                    <i class="fas fa-times"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Cancelled</span>
                                    <span class="info-box-number" id="cancelledOrders">0</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Search and Filters -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form method="GET" action="{{ route('admin.orders.index') }}" class="d-flex">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Search orders by ID, customer, or product..." value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 text-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-toggle="dropdown">
                                    <i class="fas fa-filter"></i> Filter by Status
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('admin.orders.index') }}">All</a>
                                    <a class="dropdown-item" href="{{ route('admin.orders.index', ['status' => 'pending']) }}">Pending</a>
                                    <a class="dropdown-item" href="{{ route('admin.orders.index', ['status' => 'processing']) }}">Processing</a>
                                    <a class="dropdown-item" href="{{ route('admin.orders.index', ['status' => 'shipped']) }}">Shipped</a>
                                    <a class="dropdown-item" href="{{ route('admin.orders.index', ['status' => 'delivered']) }}">Delivered</a>
                                    <a class="dropdown-item" href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}">Cancelled</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bulk Actions -->
                    <form action="{{ route('admin.orders.bulk-update') }}" method="POST" id="bulkActionForm">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="selectAll()">
                                        <i class="fas fa-check-square"></i> Select All
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="deselectAll()">
                                        <i class="fas fa-square"></i> Deselect All
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6 text-right">
                                <select name="status" class="form-control d-inline-block w-auto mr-2" required>
                                    <option value="">Bulk Action</option>
                                    <option value="pending">Mark as Pending</option>
                                    <option value="processing">Mark as Processing</option>
                                    <option value="shipped">Mark as Shipped</option>
                                    <option value="delivered">Mark as Delivered</option>
                                    <option value="cancelled">Mark as Cancelled</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-warning" onclick="return confirmBulkAction()">
                                    <i class="fas fa-play"></i> Execute
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Orders Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="50">
                                        <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll()">
                                    </th>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Products</th>
                                    <th>Total</th>
                                    <th>Waybill Number</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th width="150">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="order_ids[]" value="{{ $order->id }}" class="order-checkbox">
                                    </td>
                                    <td>
                                        <strong>#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</strong>
                                    </td>
                                    <td>
                                        <strong>{{ $order->user->name ?? 'Guest' }}</strong>
                                        @if($order->user->email)
                                        <br><small class="text-muted">{{ $order->user->email }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="product-list">
                                            @foreach($order->orderProducts as $index => $orderProduct)
                                            @if($index < 2)
                                                <div class="text-truncate" title="{{ $orderProduct->product->name }}">
                                                {{ $orderProduct->product->name }}
                                        </div>
                                        @endif
                                        @endforeach
                                        @if($order->orderProducts->count() > 2)
                                        <small class="text-muted">+{{ $order->orderProducts->count() - 2 }} more</small>
                                        @endif
                    </div>
                    </td>
                    <td>
                        <strong>{{ config('app.currency') }}{{ number_format($order->total_amount, 2) }}</strong>
                    </td>
                    <td>
                        @if($order->waybill_number)
                        <span class="text-success">{{ $order->waybill_number }}</span>
                        @else
                        <span class="text-muted">N/A</span>
                        @endif
                    </td>
                    <td>
                        @php
                        $statusClass = [
                        'pending' => 'warning',
                        'processing' => 'primary',
                        'shipped' => 'info',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                        ][$order->status] ?? 'secondary';
                        @endphp

                        <span class="badge badge-{{ $statusClass }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>
                        <small>{{ $order->created_at->format('M d, Y') }}</small>
                        <br><small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-info" title="View Order">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" title="Quick Actions">
                                <i class="fas fa-cog"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#" onclick="updateOrderStatus({{ $order->id }}, 'pending')">
                                    <i class="fas fa-clock text-warning"></i> Mark Pending
                                </a>
                                <a class="dropdown-item" href="#" onclick="updateOrderStatus({{ $order->id }}, 'processing')">
                                    <i class="fas fa-cog text-primary"></i> Mark Processing
                                </a>
                                <a class="dropdown-item" href="#" onclick="updateOrderStatus({{ $order->id }}, 'shipped')">
                                    <i class="fas fa-truck text-info"></i> Mark Shipped
                                </a>
                                <a class="dropdown-item" href="#" onclick="updateOrderStatus({{ $order->id }}, 'delivered')">
                                    <i class="fas fa-check text-success"></i> Mark Delivered
                                </a>
                                <a class="dropdown-item" href="#" onclick="updateOrderStatus({{ $order->id }}, 'cancelled')">
                                    <i class="fas fa-times text-danger"></i> Cancel Order
                                </a>
                            </div>
                        </div>
                    </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5>No orders found</h5>
                            <p class="text-muted">Start processing orders to see them here.</p>
                        </td>
                    </tr>
                    @endforelse
                    </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    function loadStats() {
        fetch('/admin/orders/stats')
            .then(response => response.json())
            .then(data => {
                document.getElementById('totalOrders').textContent = data.total_orders;
                document.getElementById('pendingOrders').textContent = data.pending_orders;
                document.getElementById('processingOrders').textContent = data.processing_orders;
                document.getElementById('shippedOrders').textContent = data.shipped_orders;
                document.getElementById('deliveredOrders').textContent = data.delivered_orders;
                document.getElementById('cancelledOrders').textContent = data.cancelled_orders;
            })
            .catch(error => console.error('Error loading stats:', error));
    }

    function refreshStats() {
        loadStats();
        // Show loading state
        const statsContainer = document.getElementById('statsContainer');
        statsContainer.style.opacity = '0.5';
        setTimeout(() => {
            statsContainer.style.opacity = '1';
        }, 500);
    }

    function toggleSelectAll() {
        const selectAllCheckbox = document.getElementById('selectAllCheckbox');
        const orderCheckboxes = document.querySelectorAll('.order-checkbox');

        orderCheckboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });
    }

    function selectAll() {
        document.getElementById('selectAllCheckbox').checked = true;
        toggleSelectAll();
    }

    function deselectAll() {
        document.getElementById('selectAllCheckbox').checked = false;
        toggleSelectAll();
    }

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

    function confirmBulkAction() {
        const selectedOrders = document.querySelectorAll('.order-checkbox:checked');
        if (selectedOrders.length === 0) {
            alert('Please select at least one order to perform bulk action.');
            return false;
        }

        const status = document.querySelector('select[name="status"]').value;
        if (!status) {
            alert('Please select an action to perform.');
            return false;
        }

        return confirm(`Are you sure you want to ${status.replace('_', ' ')} ${selectedOrders.length} selected order(s)?`);
    }

    // Load stats on page load
    document.addEventListener('DOMContentLoaded', loadStats);
</script>
@endsection