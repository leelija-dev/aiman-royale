@extends('Admin.layouts.master')
@section('source', 'Return Orders')
@section('page-title', 'Return Orders')

@section('title')
{{ config('app.name') }} - Return Orders
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h6 class="text-muted text-sm mb-1">Total Returns</h6>
                            <h3 class="mb-0">{{ $stats['total'] ?? 0 }}</h3>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fas fa-undo-alt fa-2x text-primary opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h6 class="text-muted text-sm mb-1">Pending Returns</h6>
                            <h3 class="mb-0">{{ $stats['pending'] ?? 0 }}</h3>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fas fa-clock fa-2x text-warning opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h6 class="text-muted text-sm mb-1">Refunded</h6>
                            <h3 class="mb-0">{{ $stats['refunded'] ?? 0 }}</h3>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fas fa-check-circle fa-2x text-success opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h6 class="text-muted text-sm mb-1">Total Refund Amount</h6>
                            <h3 class="mb-0">₹{{ number_format($stats['total_refund_amount'] ?? 0, 2) }}</h3>
                        </div>
                        <div class="col-4 text-end">
                            <i class="fas fa-rupee-sign fa-2x text-info opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex flex-wrap flex-lg-nowrap justify-content-between align-items-center">
                <form method="GET" action="{{ route('return-orders.index') }}" class="mb-2 mb-md-0 d-flex w-100 w-lg-50">
                    <div class="d-flex gap-2 col-12 flex-sm-nowrap flex-wrap justify-content-sm-start justify-content-end">
                        <input type="text" name="search" class="form-control me-2" style="height:40px;width:100%;"
                            placeholder="Search by waybill, order ID or reverse order ID" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary me-2 mb-sm-3 mb-1" style="height:40px;">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <a href="{{ route('return-orders.index') }}" class="btn btn-danger mb-sm-3 mb-1" style="height:40px;">
                            <i class="fas fa-times"></i> Reset
                        </a>
                    </div>
                </form>

                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-info mb-sm-3 mb-1" style="height:40px;" onclick="showBulkRefundModal()">
                        <i class="fas fa-coins me-1"></i> Bulk Refund
                    </button>
                </div>
            </div>

            <div class="card-body px-4 pt-2 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    <input type="checkbox" id="selectAll" onchange="toggleAllCheckboxes(this)">
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Order Details</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Reverse Order</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amount</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Payment Method</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Refund Status</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($orders as $order)
                            @php
                                // 👇 COD detection
                                $paymentMethod = strtolower(str_replace([' ', '-'], '_', $order->order->payment_method ?? ''));
                                $isCod = in_array($paymentMethod, ['cash_on_delivery', 'cod'], true);
                                $refundStatus = $order->refund_status ?? 'pending';
                            @endphp
                            <tr>
                                <td>
                                    <input type="checkbox" class="order-checkbox"
                                        value="{{ $order->order_id }}"
                                        data-waybill="{{ $order->waybill }}"
                                        data-amount="{{ $order->order->total_amount ?? 0 }}"
                                        data-order-id="{{ $order->order_id }}"
                                        data-reverse-id="{{ $order->id }}"
                                        data-payment-method="{{ $order->order->payment_method ?? '' }}"
                                        data-is-cod="{{ $isCod ? '1' : '0' }}"
                                        {{ $refundStatus === 'refunded' || $refundStatus === 'completed' ? 'disabled' : '' }}>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-0 text-sm">Order #{{ $order->order_id }}</h6>
                                        <small class="text-muted">Waybill: {{ $order->waybill }}</small>
                                        <small class="text-muted">{{ $order->order->user->name ?? 'N/A' }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="text-sm">{{ $order->reverse_order_id ?? $order->id }}</span>
                                        <small class="text-muted">AWB: {{ $order->waybill ?? 'N/A' }}</small>
                                        <small class="text-muted">{{ $order->created_at->format('M d, Y') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bold">₹{{ number_format($order->order->total_amount ?? 0, 2) }}</span>
                                </td>
                                <td>
                                    <span class="text-sm">{{ ucfirst(str_replace('_', ' ', $order->order->payment_method ?? 'N/A')) }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $order->status_color ?? 'secondary' }}">
                                        {{ ucfirst(str_replace('_', ' ', $order->status ?? 'pending')) }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                    $badgeClass = [
                                    'pending' => 'warning',
                                    'processing' => 'info',
                                    'completed' => 'success',
                                    'refunded' => 'success',
                                    'failed' => 'danger',
                                    'cancelled' => 'secondary'
                                    ][$refundStatus] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $badgeClass }}">
                                        {{ ucfirst($refundStatus) }}
                                    </span>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <!-- View Details Button -->
                                        <button type="button" class="btn btn-sm btn-info"
                                            onclick="viewReturnDetails({{ $order->order_id }})" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        {{-- 👇 Refund button — conditional on payment method --}}
                                        @if(!in_array($refundStatus, ['refunded', 'completed']))
                                            @if($isCod)
                                                {{-- COD: opens Payout modal --}}
                                                <button type="button" class="btn btn-sm btn-warning"
                                                    onclick="showCodPayoutModal({{ $order->order_id }}, '{{ $order->waybill }}', {{ $order->order->total_amount ?? 0 }})"
                                                    title="Process COD Payout Refund">
                                                    <i class="fas fa-university"></i> Payout Refund
                                                </button>
                                            @else
                                                {{-- Online: opens existing Cashfree refund modal --}}
                                                <button type="button" class="btn btn-sm btn-success"
                                                    onclick="showRefundModal({{ $order->id }}, '{{ $order->waybill }}', {{ $order->order->total_amount ?? 0 }})"
                                                    title="Process Refund via Cashfree">
                                                    <i class="fas fa-coins"></i> Refund
                                                </button>
                                            @endif
                                        @else
                                            <span class="text-success small">
                                                <i class="fas fa-check-circle"></i> Refunded
                                            </span>
                                        @endif

                                        <!-- Auto Refund Button — only for online orders -->
                                        @if(!$isCod && $order->status === 'delivered' && !in_array($refundStatus, ['refunded', 'completed']))
                                        <button type="button" class="btn btn-sm btn-warning"
                                            onclick="processAutoRefund({{ $order->id }})"
                                            title="Auto Refund">
                                            <i class="fas fa-robot"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <p class="text-muted">No return orders found.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    @if(isset($orders) && method_exists($orders, 'links'))
                    <div>
                        {{ $orders->links('pagination::bootstrap-5') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Refund Modal (Cashfree - Online Orders) -->
<div class="modal fade" id="refundModal" tabindex="-1" aria-labelledby="refundModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="refundModalLabel">
                    <i class="fas fa-coins me-2"></i> Process Refund (Cashfree)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="refundForm">
                    @csrf
                    <input type="hidden" id="refund_order_id" name="order_id">
                    <input type="hidden" id="real_order_id" name="real_order_id">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Order</label>
                        <p class="form-control-static" id="refund_order_display">-</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Waybill Number</label>
                        <p class="form-control-static" id="refund_waybill">-</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Reverse Order ID</label>
                        <p class="form-control-static" id="refund_reverse_order">-</p>
                    </div>
                    <div class="mb-3">
                        <label for="refund_amount" class="form-label fw-bold">Refund Amount <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" class="form-control" id="refund_amount" name="amount" step="0.01" min="0" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="refund_reason" class="form-label fw-bold">Refund Reason <span class="text-danger">*</span></label>
                        <select class="form-control" id="refund_reason" name="reason" required>
                            <option value="">Select Reason</option>
                            <option value="customer_request">Customer Requested</option>
                            <option value="product_damaged">Product Damaged</option>
                            <option value="wrong_item">Wrong Item Delivered</option>
                            <option value="not_delivered">Not Delivered</option>
                            <option value="delivery_failed">Delivery Failed</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="refund_comments" class="form-label fw-bold">Comments</label>
                        <textarea class="form-control" id="refund_comments" name="comments" rows="2" placeholder="Additional refund details..."></textarea>
                    </div>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Note:</strong> Refund will be processed through Cashfree. Please ensure the order has been delivered before processing refund.
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" onclick="submitRefund()">
                    <i class="fas fa-check me-1"></i> Process Refund
                </button>
            </div>
        </div>
    </div>
</div>

{{-- 👇 NEW: COD Payout Refund Modal --}}
<div class="modal fade" id="codPayoutModal" tabindex="-1" aria-labelledby="codPayoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning-subtle">
                <h5 class="modal-title" id="codPayoutModalLabel">
                    <i class="fas fa-university me-2"></i> Process COD Payout Refund
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="codPayoutForm">
                    @csrf
                    <input type="hidden" id="payout_order_id" name="order_id">
                    <input type="hidden" id="payout_cod_refund_id" name="cod_refund_detail_id">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Order</label>
                        <p class="form-control-static" id="payout_order_display">-</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Waybill Number</label>
                        <p class="form-control-static" id="payout_waybill">-</p>
                    </div>

                    <hr>

                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-user-check me-1"></i> Beneficiary Bank Details
                    </h6>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label small text-muted">Account Holder</label>
                            <p class="fw-bold mb-0" id="payout_holder_name">-</p>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label small text-muted">Bank Name</label>
                            <p class="fw-bold mb-0" id="payout_bank_name">-</p>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label small text-muted">Account Number</label>
                            <p class="fw-bold mb-0" id="payout_account_number">-</p>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label small text-muted">IFSC Code</label>
                            <p class="fw-bold mb-0" id="payout_ifsc_code">-</p>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label for="payout_amount" class="form-label fw-bold">Refund Amount <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" class="form-control" id="payout_amount" name="amount" step="0.01" min="0" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="payout_transfer_mode" class="form-label fw-bold">Transfer Mode <span class="text-danger">*</span></label>
                        <select class="form-control" id="payout_transfer_mode" name="transfer_mode" required>
                            <option value="imps">IMPS (Instant)</option>
                            <option value="neft">NEFT</option>
                            <option value="rtgs">RTGS</option>
                            <option value="upi">UPI</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="payout_reason" class="form-label fw-bold">Reason <span class="text-danger">*</span></label>
                        <select class="form-control" id="payout_reason" name="reason" required>
                            <option value="">Select Reason</option>
                            <option value="customer_request">Customer Requested</option>
                            <option value="product_damaged">Product Damaged</option>
                            <option value="wrong_item">Wrong Item Delivered</option>
                            <option value="return">Order Returned</option>
                        </select>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Note:</strong> This will initiate a <strong>direct bank transfer</strong> to the customer's account via Cashfree Payouts. Please verify the bank details before proceeding.
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" onclick="submitCodPayout()">
                    <i class="fas fa-paper-plane me-1"></i> Process Payout
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Refund Modal -->
<div class="modal fade" id="bulkRefundModal" tabindex="-1" aria-labelledby="bulkRefundModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkRefundModalLabel">
                    <i class="fas fa-coins me-2"></i> Bulk Refund
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="bulkRefundForm">
                    @csrf

                    <div class="alert alert-info">
                        <strong>Selected Orders:</strong> <span id="bulkSelectedCount">0</span> order(s)
                        <br>
                        <small>Total Amount: ₹<span id="bulkTotalAmount">0.00</span></small>
                        <br>
                        {{-- 👇 Show COD vs Online breakdown --}}
                        <small class="text-warning">
                            <i class="fas fa-university"></i> COD (Payout): <strong id="bulkCodCount">0</strong> orders — ₹<span id="bulkCodAmount">0.00</span>
                        </small>
                        <br>
                        <small class="text-success">
                            <i class="fas fa-coins"></i> Online (Cashfree): <strong id="bulkOnlineCount">0</strong> orders — ₹<span id="bulkOnlineAmount">0.00</span>
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Selected Orders Details</label>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Waybill</th>
                                        <th>Amount</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="bulkSelectedOrdersList">
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No orders selected</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="bulk_refund_reason" class="form-label fw-bold">Refund Reason <span class="text-danger">*</span></label>
                        <select class="form-control" id="bulk_refund_reason" name="reason" required>
                            <option value="">Select Reason</option>
                            <option value="customer_request">Customer Requested</option>
                            <option value="product_damaged">Product Damaged</option>
                            <option value="wrong_item">Wrong Item Delivered</option>
                            <option value="bulk_return">Bulk Return</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="bulk_refund_comments" class="form-label fw-bold">Comments</label>
                        <textarea class="form-control" id="bulk_refund_comments" name="comments" rows="2" placeholder="Bulk refund comments..."></textarea>
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Note:</strong> Bulk refund will process all selected orders. This action cannot be undone.
                        COD orders will be paid out via bank transfer; online orders via Cashfree refund.
                    </div>

                    <input type="hidden" id="bulk_order_ids" name="order_ids">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" onclick="submitBulkRefund()">
                    <i class="fas fa-check me-1"></i> Process Bulk Refund
                </button>
            </div>
        </div>
    </div>
</div>

<!-- View Return Details Modal -->
<div class="modal fade" id="returnDetailsModal" tabindex="-1" aria-labelledby="returnDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="returnDetailsModalLabel">
                    <i class="fas fa-info-circle me-2"></i> Return Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="returnDetailsContent">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading return details...</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let selectedOrderIds = [];
    let selectedWaybills = [];

    function toggleAllCheckboxes(selectAll) {
        const checkboxes = document.querySelectorAll('.order-checkbox:not(:disabled)');
        checkboxes.forEach(checkbox => { checkbox.checked = selectAll.checked; });
    }

    // 👇 Updated: include payment method info
    function getSelectedOrders() {
        const checkboxes = document.querySelectorAll('.order-checkbox:checked');
        const orders = [];
        let totalAmount = 0;
        let codAmount = 0, onlineAmount = 0;
        let codCount = 0, onlineCount = 0;

        checkboxes.forEach(checkbox => {
            const amt = parseFloat(checkbox.dataset.amount || 0);
            const isCod = checkbox.dataset.isCod === '1';

            orders.push({
                id: checkbox.value,
                waybill: checkbox.dataset.waybill,
                amount: amt,
                orderId: checkbox.dataset.orderId || checkbox.value,
                reverseId: checkbox.dataset.reverseId,
                isCod: isCod,
                paymentMethod: checkbox.dataset.paymentMethod || '',
            });

            totalAmount += amt;
            if (isCod) { codAmount += amt; codCount++; }
            else { onlineAmount += amt; onlineCount++; }
        });

        return {
            orders: orders,
            orderIds: orders.map(o => o.id),
            waybills: orders.map(o => o.waybill),
            totalAmount: totalAmount,
            codAmount: codAmount,
            onlineAmount: onlineAmount,
            codCount: codCount,
            onlineCount: onlineCount,
        };
    }

    /* =========================================================
       ONLINE REFUND (Cashfree) — Existing
    ========================================================= */
    function showRefundModal(orderId, waybill, amount) {
        const url = `/api/return-orders/details?order_id=${orderId}`;

        fetch(url, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
            }
        })
        .then(response => response.ok ? response.json() : Promise.reject(`HTTP ${response.status}`))
        .then(data => {
            if (data.success) {
                document.getElementById('refund_order_id').value = data.order.order_id;
                document.getElementById('refund_order_display').textContent = `Order #${data.order.order_id}`;
                document.getElementById('refund_waybill').textContent = data.order?.waybill_number || waybill || 'N/A';
                document.getElementById('refund_reverse_order').textContent = data.reverse_order?.reverse_order_id || 'N/A';
                document.getElementById('refund_amount').value = data.order?.total_amount || amount || 0;
                document.getElementById('refund_amount').max = data.order?.total_amount || amount || 0;
            } else {
                document.getElementById('refund_order_id').value = orderId;
                document.getElementById('refund_order_display').textContent = `Order #${orderId}`;
                document.getElementById('refund_waybill').textContent = waybill || 'N/A';
                document.getElementById('refund_reverse_order').textContent = 'Not available';
                document.getElementById('refund_amount').value = amount || 0;
                document.getElementById('refund_amount').max = amount || 0;
            }

            new bootstrap.Modal(document.getElementById('refundModal')).show();
        })
        .catch(error => {
            console.error('Error fetching details:', error);
            document.getElementById('refund_order_id').value = orderId;
            document.getElementById('refund_order_display').textContent = `Order #${orderId}`;
            document.getElementById('refund_waybill').textContent = waybill || 'N/A';
            document.getElementById('refund_reverse_order').textContent = 'Unable to load';
            document.getElementById('refund_amount').value = amount || 0;
            document.getElementById('refund_amount').max = amount || 0;
            new bootstrap.Modal(document.getElementById('refundModal')).show();
        });
    }

    function submitRefund() {
        const orderId = document.getElementById('refund_order_id').value;
        const amount = document.getElementById('refund_amount').value;
        const reason = document.getElementById('refund_reason').value;
        const comments = document.getElementById('refund_comments').value;

        if (!amount || parseFloat(amount) <= 0) {
            Swal.fire({ icon: 'error', title: 'Invalid Amount', text: 'Please enter a valid refund amount.' });
            return;
        }
        if (!reason) {
            Swal.fire({ icon: 'error', title: 'Missing Reason', text: 'Please select a refund reason.' });
            return;
        }

        Swal.fire({
            title: 'Processing Refund',
            text: `Refunding ₹${amount} for order #${orderId}`,
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => Swal.showLoading(),
        });

        fetch('{{ route("return-orders.refund") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({ order_id: orderId, amount, reason, comments }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Refund Processed!',
                    html: `
                        <p>Successfully refunded ₹${data.amount || amount} for order #${orderId}</p>
                        ${data.transaction_id ? `<p><strong>Transaction ID:</strong> ${data.transaction_id}</p>` : ''}
                    `,
                    confirmButtonColor: '#28a745',
                }).then(() => {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('refundModal'));
                    if (modal) modal.hide();
                    location.reload();
                });
            } else {
                Swal.fire({ icon: 'error', title: 'Refund Failed', text: data.message || 'Something went wrong.' });
            }
        })
        .catch(error => {
            Swal.fire({ icon: 'error', title: 'Error', text: 'An error occurred while processing refund.' });
            console.error('Error:', error);
        });
    }

    /* =========================================================
       👇 COD PAYOUT REFUND — NEW
    ========================================================= */
    function showCodPayoutModal(orderId, waybill, amount) {
        console.log('Opening COD payout modal for order:', orderId);

        // Load the CodRefundDetail (bank details) for this order
        fetch(`/admin/api/cod-refund-details?order_id=${orderId}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(r => r.ok ? r.json() : Promise.reject(`HTTP ${r.status}`))
        .then(data => {
            if (data.success && data.cod_refund_detail) {
                const d = data.cod_refund_detail;

                document.getElementById('payout_order_id').value = orderId;
                document.getElementById('payout_cod_refund_id').value = d.id;
                document.getElementById('payout_order_display').textContent = `Order #${orderId}`;
                document.getElementById('payout_waybill').textContent = waybill || 'N/A';
                document.getElementById('payout_holder_name').textContent = d.account_holder_name || 'N/A';
                document.getElementById('payout_bank_name').textContent = d.bank_name || 'N/A';
                document.getElementById('payout_account_number').textContent = d.masked_account_number || 'N/A';
                document.getElementById('payout_ifsc_code').textContent = d.ifsc_code || 'N/A';
                document.getElementById('payout_amount').value = d.refund_amount || amount || 0;
                document.getElementById('payout_amount').max = d.refund_amount || amount || 0;

                new bootstrap.Modal(document.getElementById('codPayoutModal')).show();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Bank Details Not Found',
                    text: 'No COD refund details found for this order. The customer may not have submitted bank details.',
                    confirmButtonColor: '#d33',
                });
            }
        })
        .catch(error => {
            console.error('Error fetching COD details:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to load bank details. Please try again.',
            });
        });
    }

    function submitCodPayout() {
        const orderId = document.getElementById('payout_order_id').value;
        const codRefundId = document.getElementById('payout_cod_refund_id').value;
        const amount = document.getElementById('payout_amount').value;
        const transferMode = document.getElementById('payout_transfer_mode').value;
        const reason = document.getElementById('payout_reason').value;

        if (!amount || parseFloat(amount) <= 0) {
            Swal.fire({ icon: 'error', title: 'Invalid Amount', text: 'Please enter a valid amount.' });
            return;
        }
        if (!reason) {
            Swal.fire({ icon: 'error', title: 'Missing Reason', text: 'Please select a reason.' });
            return;
        }

        // Explicit confirmation — this moves real money
        Swal.fire({
            title: 'Confirm Payout',
            html: `You are about to transfer <strong>₹${amount}</strong> to the customer's bank account.<br><br>
                   <span class="text-danger">This action cannot be undone.</span>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ffc107',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, process payout',
        }).then((result) => {
            if (!result.isConfirmed) return;

            Swal.fire({
                title: 'Processing Payout...',
                text: 'Initiating bank transfer via Cashfree',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => Swal.showLoading(),
            });

            fetch('{{ route("return-orders.cod-payout") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    cod_refund_detail_id: codRefundId,
                    order_id: orderId,
                    amount: amount,
                    transfer_mode: transferMode,
                    reason: reason,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Payout Initiated!',
                        html: `
                            <p>Refund of ₹${data.amount || amount} has been initiated.</p>
                            ${data.utr_number ? `<p><strong>UTR:</strong> ${data.utr_number}</p>` : ''}
                            <p class="text-muted small">It may take a few hours to reflect in the customer's account.</p>
                        `,
                        confirmButtonColor: '#28a745',
                    }).then(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('codPayoutModal'));
                        if (modal) modal.hide();
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Payout Failed',
                        text: data.message || 'Something went wrong.',
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while processing the payout.',
                });
                console.error('Error:', error);
            });
        });
    }

    /* =========================================================
       BULK REFUND — Updated with breakdown
    ========================================================= */
    function showBulkRefundModal() {
        const selected = getSelectedOrders();

        if (selected.orderIds.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Orders Selected',
                text: 'Please select at least one order for bulk refund.',
            });
            return;
        }

        // Update summary
        document.getElementById('bulkSelectedCount').textContent = selected.orderIds.length;
        document.getElementById('bulkTotalAmount').textContent = selected.totalAmount.toFixed(2);
        document.getElementById('bulkCodCount').textContent = selected.codCount;
        document.getElementById('bulkCodAmount').textContent = selected.codAmount.toFixed(2);
        document.getElementById('bulkOnlineCount').textContent = selected.onlineCount;
        document.getElementById('bulkOnlineAmount').textContent = selected.onlineAmount.toFixed(2);
        document.getElementById('bulk_order_ids').value = JSON.stringify(selected.orderIds);

        // Update orders list
        const tbody = document.getElementById('bulkSelectedOrdersList');
        if (selected.orders.length > 0) {
            let html = '';
            selected.orders.forEach(order => {
                const typeBadge = order.isCod
                    ? `<span class="badge bg-warning"><i class="fas fa-university"></i> COD</span>`
                    : `<span class="badge bg-success"><i class="fas fa-coins"></i> Online</span>`;

                html += `
                    <tr>
                        <td>#${order.orderId}</td>
                        <td>${order.waybill}</td>
                        <td>₹${order.amount.toFixed(2)}</td>
                        <td>${typeBadge}</td>
                        <td><span class="badge bg-info">Pending</span></td>
                    </tr>
                `;
            });
            tbody.innerHTML = html;
        } else {
            tbody.innerHTML = `<tr><td colspan="5" class="text-center text-muted">No orders selected</td></tr>`;
        }

        new bootstrap.Modal(document.getElementById('bulkRefundModal')).show();
    }

    function submitBulkRefund() {
        const orderIds = JSON.parse(document.getElementById('bulk_order_ids').value);
        const reason = document.getElementById('bulk_refund_reason').value;
        const comments = document.getElementById('bulk_refund_comments').value;

        if (!reason) {
            Swal.fire({ icon: 'error', title: 'Missing Reason', text: 'Please select a refund reason.' });
            return;
        }

        // 👇 Confirm before processing real money
        Swal.fire({
            title: 'Confirm Bulk Refund',
            html: `You are about to refund <strong>${orderIds.length}</strong> order(s).<br>
                   <small>COD orders will be paid out via bank transfer.<br>
                   Online orders will be refunded via Cashfree.</small>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, process',
        }).then((result) => {
            if (!result.isConfirmed) return;

            Swal.fire({
                title: 'Processing Bulk Refund',
                text: `Refunding ${orderIds.length} order(s)`,
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => Swal.showLoading(),
            });

            fetch('{{ route("return-orders.bulk-refund") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ order_ids: orderIds, reason, comments }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Bulk Refund Processed!',
                        html: `
                            <p>Successfully refunded ${data.count || orderIds.length} order(s).</p>
                            ${data.total_amount ? `<p><strong>Total Amount:</strong> ₹${data.total_amount}</p>` : ''}
                            ${data.failed_count ? `<p class="text-danger"><strong>Failed:</strong> ${data.failed_count} order(s)</p>` : ''}
                            ${data.failed_orders ? `<p class="text-danger"><strong>Failed Orders:</strong> ${data.failed_orders.join(', ')}</p>` : ''}
                        `,
                        confirmButtonColor: '#28a745',
                    }).then(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('bulkRefundModal'));
                        if (modal) modal.hide();
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Bulk Refund Failed',
                        text: data.message || 'Something went wrong.',
                    });
                }
            })
            .catch(error => {
                Swal.fire({ icon: 'error', title: 'Error', text: 'An error occurred while processing bulk refund.' });
                console.error('Error:', error);
            });
        });
    }

    /* =========================================================
       VIEW DETAILS — Existing
    ========================================================= */
    function viewReturnDetails(orderId) {
        const modal = new bootstrap.Modal(document.getElementById('returnDetailsModal'));
        modal.show();

        fetch(`{{ route("return-orders.details") }}?order_id=${orderId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('returnDetailsContent').innerHTML = generateReturnDetailsHTML(data);
                } else {
                    document.getElementById('returnDetailsContent').innerHTML = `<div class="alert alert-danger">Failed to load return details.</div>`;
                }
            })
            .catch(error => {
                document.getElementById('returnDetailsContent').innerHTML = `<div class="alert alert-danger">Error loading return details.</div>`;
                console.error('Error:', error);
            });
    }

    function generateReturnDetailsHTML(data) {
        const order = data.order;
        const reverse = data.reverse_order;

        return `
            <div class="row">
                <div class="col-md-6">
                    <h6 class="fw-bold">Order Information</h6>
                    <table class="table table-sm table-bordered">
                        <tr><th>Order ID</th><td>${order.order_id}</td></tr>
                        <tr><th>Waybill</th><td>${order.waybill_number}</td></tr>
                        <tr><th>Customer</th><td>${order.customer_name || 'N/A'}</td></tr>
                        <tr><th>Total Amount</th><td>₹${order.total_amount}</td></tr>
                        <tr><th>Payment Method</th><td>${order.payment_method || 'N/A'}</td></tr>
                        <tr><th>Refund Status</th><td>${order.refund_status || 'Pending'}</td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold">Return Information</h6>
                    <table class="table table-sm table-bordered">
                        <tr><th>Reverse Order ID</th><td>${reverse.reverse_order_id}</td></tr>
                        <tr><th>Status</th><td><span class="badge bg-${reverse.status_color || 'secondary'}">${reverse.status}</span></td></tr>
                        <tr><th>Waybill</th><td>${reverse.waybill || 'N/A'}</td></tr>
                        <tr><th>Created</th><td>${new Date(reverse.created_at).toLocaleString()}</td></tr>
                        ${reverse.return_reason ? `<tr><th>Return Reason</th><td>${reverse.return_reason}</td></tr>` : ''}
                    </table>
                </div>
            </div>
        `;
    }

    function processAutoRefund(orderId) {
        Swal.fire({
            title: 'Process Auto Refund?',
            text: "This will automatically process refund for this delivered return.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, process refund',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                const checkbox = document.querySelector(`.order-checkbox[value="${orderId}"]`);
                const amount = checkbox ? checkbox.dataset.amount : 0;
                const waybill = checkbox ? checkbox.dataset.waybill : '';
                showRefundModal(orderId, waybill, amount);
            }
        });
    }
</script>
@endsection