@extends('Admin.layouts.master')

@section('title', 'Orders Management')

@section('content')
    <div class="container-fluid mt-4 md-4">
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
                    <div class="card py-4 px-4">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Stats Cards -->
                        <div class="row g-3 mb-4" id="statsContainer">

                            <!-- Total Orders -->
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="card border-0 shadow-sm h-100" style="background-color: #0d6efd;">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex align-items-center justify-content-center rounded-circle bg-white me-3"
                                                style="width: 55px; height: 55px;">
                                                <i class="fas fa-shopping-cart fa-lg text-primary"></i>
                                            </div>

                                            <div>
                                                <div class="text-white fw-semibold">Total Orders</div>
                                                <div class="fs-3 fw-bold text-white" id="totalOrders">0</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pending -->
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="card border-0 shadow-sm h-100" style="background-color: #f1ce04;">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex align-items-center justify-content-center rounded-circle bg-white me-3"
                                                style="width: 55px; height: 55px;">
                                                <i class="fas fa-clock fa-lg text-warning"></i>
                                            </div>

                                            <div>
                                                <div class="text-white fw-semibold">Pending</div>
                                                <div class="fs-3 fw-bold text-white" id="pendingOrders">0</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Processing -->
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="card border-0 shadow-sm h-100" style="background-color: #d8ca09;">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex align-items-center justify-content-center rounded-circle bg-white me-3"
                                                style="width: 55px; height: 55px;">
                                                <i class="fas fa-cog fa-lg text-warning"></i>
                                            </div>

                                            <div>
                                                <div class="text-white fw-semibold">Processing</div>
                                                <div class="fs-3 fw-bold text-white" id="processingOrders">0</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Shipped -->
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="card border-0 shadow-sm h-100" style="background-color: #429e0c;">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex align-items-center justify-content-center rounded-circle bg-white me-3"
                                                style="width: 55px; height: 55px;">
                                                <i class="fas fa-truck fa-lg text-success"></i>
                                            </div>

                                            <div>
                                                <div class="text-white fw-semibold">Shipped</div>
                                                <div class="fs-3 fw-bold text-white" id="shippedOrders">0</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Delivered -->
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="card border-0 shadow-sm h-100" style="background-color: #176308;">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex align-items-center justify-content-center rounded-circle bg-white me-3"
                                                style="width: 55px; height: 55px;">
                                                <i class="fas fa-check fa-lg text-success"></i>
                                            </div>

                                            <div>
                                                <div class="text-white fw-semibold">Delivered</div>
                                                <div class="fs-3 fw-bold text-white" id="deliveredOrders">0</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Cancelled -->
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="card border-0 shadow-sm h-100" style="background-color: #f11616;">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex align-items-center justify-content-center rounded-circle bg-white me-3"
                                                style="width: 55px; height: 55px;">
                                                <i class="fas fa-times fa-lg text-danger"></i>
                                            </div>

                                            <div>
                                                <div class="text-white fw-semibold">Cancelled</div>
                                                <div class="fs-3 fw-bold text-white" id="cancelledOrders">0</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Search and Filters -->
                        <div class="row mb-3 d-flex justify-content-center">
                            <div class="col-md-12">
                                <form method="GET" action="{{ route('admin.orders.index') }}" >
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Search orders by ID, customer, or product..."
                                            value="{{ request('search') }}">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary h-100 px-4 ms-2" >
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            {{-- <div class="col-md-6 text-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                        data-toggle="dropdown">
                                        <i class="fas fa-filter"></i> Filter by Status
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('admin.orders.index') }}">All</a>
                                        <a class="dropdown-item"
                                            href="{{ route('admin.orders.index', ['status' => 'pending']) }}">Pending</a>
                                        <a class="dropdown-item"
                                            href="{{ route('admin.orders.index', ['status' => 'processing']) }}">Processing</a>
                                        <a class="dropdown-item"
                                            href="{{ route('admin.orders.index', ['status' => 'shipped']) }}">Shipped</a>
                                        <a class="dropdown-item"
                                            href="{{ route('admin.orders.index', ['status' => 'delivered']) }}">Delivered</a>
                                        <a class="dropdown-item"
                                            href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}">Cancelled</a>
                                    </div>
                                </div>
                            </div> --}}
                        </div>

                        <!-- Bulk Actions -->
                        <form action="{{ route('admin.orders.bulk-update') }}" method="POST" id="bulkActionForm">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary"
                                            onclick="selectAll()">
                                            <i class="fas fa-check-square"></i> Select All
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary"
                                            onclick="deselectAll()">
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
                                    <button type="submit" class="btn btn-sm btn-warning"
                                        onclick="return confirmBulkAction()">
                                        <i class="fas fa-play"></i> Execute
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Orders Table -->
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0 ">
                                <thead class="bg-light">
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
                                                <input type="checkbox" name="order_ids[]" value="{{ $order->id }}"
                                                    class="order-checkbox">
                                            </td>
                                            <td>
                                                <strong>#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</strong>
                                            </td>
                                            <td>
                                                <strong>{{ $order->user->name ?? 'Guest' }}</strong>
                                                @if ($order->user->email)
                                                    <br><small class="text-muted">{{ $order->user->email }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="product-list">
                                                    @foreach ($order->orderProducts as $index => $orderProduct)
                                                        @if ($index < 2)
                                                            <div class="text-truncate"
                                                                title="{{ $orderProduct->product->name }}">
                                                                {{ $orderProduct->product->name }}
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                    @if ($order->orderProducts->count() > 2)
                                                        <small
                                                            class="text-muted">+{{ $order->orderProducts->count() - 2 }}
                                                            more</small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <strong>{{ config('app.currency') }}{{ number_format($order->total_amount, 2) }}</strong>
                                            </td>
                                            <td>
                                                @if ($order->waybill_number)
                                                    <span class="text-success">{{ $order->waybill_number }}</span>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $statusClass =
                                                        [
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
                                                <br><small
                                                    class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('admin.orders.show', $order) }}"
                                                        class="btn btn-info" title="View Order">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-warning dropdown-toggle"
                                                        data-toggle="dropdown" title="Quick Actions">
                                                        <i class="fas fa-cog"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#"
                                                            onclick="updateOrderStatus({{ $order->id }}, 'pending')">
                                                            <i class="fas fa-clock text-warning"></i> Mark Pending
                                                        </a>
                                                        <a class="dropdown-item" href="#"
                                                            onclick="updateOrderStatus({{ $order->id }}, 'processing')">
                                                            <i class="fas fa-cog text-primary"></i> Mark Processing
                                                        </a>
                                                        <a class="dropdown-item" href="#"
                                                            onclick="updateOrderStatus({{ $order->id }}, 'shipped')">
                                                            <i class="fas fa-truck text-info"></i> Mark Shipped
                                                        </a>
                                                        <a class="dropdown-item" href="#"
                                                            onclick="updateOrderStatus({{ $order->id }}, 'delivered')">
                                                            <i class="fas fa-check text-success"></i> Mark Delivered
                                                        </a>
                                                        <a class="dropdown-item" href="#"
                                                            onclick="updateOrderStatus({{ $order->id }}, 'cancelled')">
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
                        <div class="justify-content-right mt-3">
                            {{ $orders->links('pagination::bootstrap-5') }}
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

            return confirm(
                `Are you sure you want to ${status.replace('_', ' ')} ${selectedOrders.length} selected order(s)?`);
        }

        // Load stats on page load
        document.addEventListener('DOMContentLoaded', loadStats);
    </script>
@endsection
