@extends('Admin.layouts.master')
@section('source', 'Cancel Orders')
@section('page-title', 'Cancel Orders')

@section('title')
    {{ config('app.name') }} - Cancel Orders
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex flex-wrap flex-lg-nowrap justify-content-between align-items-center">
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('orders-cancel.index') }}" class="mb-2 mb-md-0 d-flex w-100 w-lg-50">
                        <div
                            class="d-flex gap-2 col-12 flex-sm-nowrap flex-wrap justify-content-sm-start justify-content-end">
                            <input type="text" name="search" class="form-control me-2" style="height:40px;width:100%;"
                                placeholder="Search by waybill, order ID or reverse order ID"
                                value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary me-2 mb-sm-3 mb-1" style="height:40px;">
                                <i class="fas fa-search"></i>
                            </button>
                            <a href="{{ route('orders-cancel.index') }}" class="btn btn-danger mb-sm-2 mb-1"
                                style="height:40px;">
                                </i> Reset
                            </a>
                        </div>
                    </form>
                </div>
                <div class="card px-4 pt-2 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table co-table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Customer
                                        / Order</th>
                                    
                                    <th
                                        class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                        Amount</th>
                                    <th
                                        class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status</th>
                                    <th
                                        class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                        Refund</th>
                                    <th
                                        class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                        Cancel Date</th>
                                    <th
                                        class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                        Cancel Reason</th>
                                    <th
                                        class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    @php
                                        $customer = $order->customer_name ?? '';
                                        $amount = $order->total_amount ?? 0;
                                        $refund = $order->refund_status ?? 'pending';
                                        $refundColor =
                                            [
                                                'pending' => 'warning',
                                                'processing' => 'info',
                                                'completed' => 'success',
                                                'refunded' => 'success',
                                                'failed' => 'danger',
                                                'cancelled' => 'secondary',
                                            ][$refund] ?? 'secondary';
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">

                                                <div class="d-flex flex-column">
                                                    <h6 class="mb-0 text-sm">{{ $customer }}</h6>
                                                    <small class="text-muted">Order
                                                        #{{ $order->order_id ?? $order->id }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="fw-bold">₹{{ number_format($amount, 2) }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-{{ $order->status_color ?? 'danger' }}">
                                                {{ ucfirst(str_replace('_', ' ', $order->order_status ?? 'cancelled')) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $refundStatus = $order->refund_status ?? 'pending';
                                                $badgeClass =
                                                    [
                                                        'pending' => 'warning',
                                                        'processing' => 'info',
                                                        'completed' => 'success',
                                                        'refunded' => 'success',
                                                        'failed' => 'danger',
                                                        'cancelled' => 'secondary',
                                                    ][$refundStatus] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $badgeClass }}">
                                                {{ ucfirst($refundStatus) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="text-sm">{{ $order->cancelled_at ? $order->cancelled_at->format('d M Y, h:i A') : '-' }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="text-sm">
                                                {{ \Illuminate\Support\Str::limit($order->cancel_reason ?? '-', 50, '...') }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1">
                                                <button type="button" class="btn btn-info co-action js-view"
                                                    title="View details" data-id="{{ $order->id }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                                @if ($refund !== 'refunded')
                                                    <button type="button" class="btn btn-success btn-sm js-refund"
                                                        title="Process refund" data-id="{{ $order->id }}"
                                                        data-waybill="{{ $order->waybill }}"
                                                        data-amount="{{ $amount }}">
                                                        <i class="fas fa-coins me-1"></i> Refund
                                                    </button>
                                                @else
                                                    <span class="co-pill success"><i class="fas fa-check"></i>
                                                        Refunded</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <i class="fas fa-box-open fa-2x text-secondary mb-2"></i>
                                            <p class="text-muted mb-0">No cancel orders found.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        @if (isset($orders) && method_exists($orders, 'links'))
                            <div>
                                {{ $orders->links('pagination::bootstrap-5') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== Return / Cancel Details ===== --}}
    <div class="modal fade co-modal" id="returnDetailsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex align-items-center gap-3">
                        <span class="co-icon bg-light text-info"><i class="fas fa-file-invoice"></i></span>
                        <div>
                            <h5 class="modal-title mb-0">Cancel Order Details</h5>
                            <small class="text-muted" id="detailsSubtitle">Loading…</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" id="returnDetailsContent"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== Refund ===== --}}
    <div class="modal fade co-modal" id="refundModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex align-items-center gap-3">
                        <span class="co-icon bg-light text-success"><i class="fas fa-coins"></i></span>
                        <div>
                            <h5 class="modal-title mb-0">Process Refund</h5>
                            <small class="text-muted">Refund is sent via Cashfree</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="refundForm" novalidate>
                    @csrf
                    <input type="hidden" id="refund_order_id" name="order_id">

                    <div class="modal-body p-4">
                        <div class="row g-2 mb-4">
                            <div class="col-4">
                                <div class="co-stat"><small>Order</small><strong id="refund_order_display">-</strong>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="co-stat"><small>Waybill</small><strong id="refund_waybill"
                                        class="text-sm">-</strong></div>
                            </div>
                            <div class="col-4">
                                <div class="co-stat"><small>Reverse ID</small><strong id="refund_reverse_order"
                                        class="text-sm">-</strong></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="refund_amount" class="form-label fw-bold">Refund Amount <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" class="form-control" id="refund_amount" name="amount"
                                    step="0.01" min="1" required>
                            </div>
                            <small class="text-muted">Max refundable: ₹<span id="refund_max">0.00</span></small>
                        </div>

                        <div class="mb-3">
                            <label for="refund_reason" class="form-label fw-bold">Reason <span
                                    class="text-danger">*</span></label>
                            <select class="form-select" id="refund_reason" name="reason" required>
                                <option value="">Select reason</option>
                                <option value="customer_request">Customer requested</option>
                                <option value="product_damaged">Product damaged</option>
                                <option value="wrong_item">Wrong item delivered</option>
                                <option value="not_delivered">Not delivered</option>
                                <option value="delivery_failed">Delivery failed</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="refund_comments" class="form-label fw-bold">Comments</label>
                            <textarea class="form-control" id="refund_comments" name="comments" rows="2" placeholder="Optional note…"></textarea>
                        </div>

                        <div class="alert alert-warning d-flex gap-2 mb-0 text-white">
                            <i class="fas fa-exclamation-triangle mt-1"></i>
                            <span class="text-sm">Make sure the return is delivered before refunding. This cannot be
                                undone.</span>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success" id="refundSubmitBtn">
                            <i class="fas fa-check me-1"></i> Confirm Refund
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const DETAILS_URL = @json(route('return-orders.details'));
        const REFUND_URL = @json(url('/api/refunds'));
        {{-- ⚠ replace with your real refund route --}}
        const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || @json(csrf_token());

        const $ = (id) => document.getElementById(id);
        const esc = (v) => String(v ?? '').replace(/[&<>"']/g, c => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#39;'
        } [c]));
        const money = (v) => '₹' + Number(v || 0).toLocaleString('en-IN', {
            minimumFractionDigits: 2
        });
        const fmtDate = (v) => v ? new Date(v).toLocaleString('en-IN', {
            dateStyle: 'medium',
            timeStyle: 'short'
        }) : 'N/A';
        const pill = (text, color = 'secondary') => `<span class="co-pill ${color}">${esc(text)}</span>`;
        const row = (k, v) => `<div class="co-row"><span>${k}</span><span>${v ?? 'N/A'}</span></div>`;
        const statusColor = (s) => ({
            completed: 'success',
            refunded: 'success',
            pending: 'warning',
            processing: 'info',
            failed: 'danger'
        } [s] || 'secondary');

        const detailsModal = bootstrap.Modal.getOrCreateInstance($('returnDetailsModal'));
        const refundModal = bootstrap.Modal.getOrCreateInstance($('refundModal'));

        /* ---------- Buttons ---------- */
        document.addEventListener('click', (e) => {
            const view = e.target.closest('.js-view');
            if (view) return viewReturnDetails(view.dataset.id);

            const refund = e.target.closest('.js-refund');
            if (refund) return showRefundModal(refund.dataset.id, refund.dataset.waybill, refund.dataset.amount);
        });

        /* ---------- Details modal ---------- */
        function viewReturnDetails(orderId) {
            $('detailsSubtitle').textContent = 'Loading…';
            $('returnDetailsContent').innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="mt-2 text-muted mb-0">Loading details…</p>
        </div>`;
            detailsModal.show();

            fetch(`${DETAILS_URL}?order_id=${encodeURIComponent(orderId)}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(r => r.ok ? r.json() : Promise.reject(r.status))
                .then(data => {
                    if (!data.success) throw new Error('failed');
                    $('detailsSubtitle').textContent =
                        `Order #${data.order.id} • ${data.order.waybill_number || 'No waybill'}`;
                    $('returnDetailsContent').innerHTML = renderDetails(data);
                })
                .catch(() => {
                    $('detailsSubtitle').textContent = 'Error';
                    $('returnDetailsContent').innerHTML = `
                <div class="text-center py-5">
                    <i class="fas fa-circle-exclamation fa-2x text-danger mb-2"></i>
                    <p class="mb-0">Could not load details. Please try again.</p>
                </div>`;
                });
        }

        function renderDetails({
            order = {},
            reverse_order: rev = {}
        }) {
            const refunds = order.refunds || [];

            return `
    <div class="row g-2 mb-4">
        <div class="col-6 col-md-3"><div class="co-stat"><small>Order Amount</small><strong>${money(order.total_amount)}</strong></div></div>
        <div class="col-6 col-md-3"><div class="co-stat"><small>Return Status</small><div class="mt-1">${pill(rev.status || 'N/A', rev.status_color || statusColor(rev.status))}</div></div></div>
        <div class="col-6 col-md-3"><div class="co-stat"><small>Refund</small><div class="mt-1">${pill(order.refund_status || 'Pending', statusColor(order.refund_status))}</div></div></div>
        <div class="col-6 col-md-3"><div class="co-stat"><small>Created</small><strong class="text-sm">${fmtDate(rev.created_at)}</strong></div></div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="co-card">
                <h6><i class="fas fa-box me-1"></i> Order Information</h6>
                ${row('Order ID', '#' + esc(order.id))}
                ${row('Customer', esc(order.customer_name))}
                ${row('Waybill', esc(order.waybill_number))}
                ${row('Total Amount', money(order.total_amount))}
            </div>
        </div>
        <div class="col-md-6">
            <div class="co-card">
                <h6><i class="fas fa-rotate-left me-1"></i> Return Information</h6>
                ${row('Reverse Order ID', esc(rev.reverse_order_id))}
                ${row('Return Waybill', esc(rev.waybill))}
                ${row('Reason', esc(rev.return_reason))}
                ${row('Created', fmtDate(rev.created_at))}
            </div>
        </div>
    </div>

    <div class="co-card mt-3">
        <h6><i class="fas fa-clock-rotate-left me-1"></i> Refund History</h6>
        ${refunds.length ? `
            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <thead><tr><th>Date</th><th>Reason</th><th class="text-end">Amount</th><th class="text-center">Status</th></tr></thead>
                    <tbody>
                    ${refunds.map(r => `
                    <tr>
                        <td>${fmtDate(r.created_at)}</td>
                        <td>${esc(r.reason)}</td>
                        <td class="text-end fw-bold">${money(r.amount)}</td>
                        <td class="text-center">${pill(r.status, statusColor(r.status))}</td>
                    </tr>`).join('')}
                    </tbody>
                </table>
            </div>` : `<p class="text-muted text-sm mb-0">No refunds processed yet.</p>`}
    </div>

    ${rev.payload ? `
        <div class="accordion mt-3" id="payloadAcc">
            <div class="accordion-item border rounded-3">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed py-2 text-sm" type="button" data-bs-toggle="collapse" data-bs-target="#payloadBody">
                        Raw payload
                    </button>
                </h2>
                <div id="payloadBody" class="accordion-collapse collapse" data-bs-parent="#payloadAcc">
                    <div class="accordion-body p-2">
                        <pre class="bg-light p-2 rounded mb-0" style="max-height:220px;overflow:auto;font-size:.75rem">${esc(JSON.stringify(rev.payload, null, 2))}</pre>
                    </div>
                </div>
            </div>
        </div>` : ''}`;
        }

        /* ---------- Refund modal ---------- */
        function fillRefund({
            id,
            display,
            waybill,
            reverse,
            amount
        }) {
            $('refund_order_id').value = id;
            $('refund_order_display').textContent = display;
            $('refund_waybill').textContent = waybill || 'N/A';
            $('refund_reverse_order').textContent = reverse || 'N/A';
            $('refund_amount').value = amount;
            $('refund_amount').max = amount;
            $('refund_max').textContent = Number(amount).toFixed(2);
            $('refundForm').classList.remove('was-validated');
            $('refund_reason').value = '';
            $('refund_comments').value = '';
        }

        function showRefundModal(orderId, waybill, amount) {
            const fallback = {
                id: orderId,
                display: `#${orderId}`,
                waybill,
                reverse: 'Not available',
                amount: amount || 0
            };

            fetch(`${DETAILS_URL}?order_id=${encodeURIComponent(orderId)}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(r => r.ok ? r.json() : Promise.reject())
                .then(data => {
                    if (!data.success) return fillRefund(fallback);
                    const o = data.order || {};
                    fillRefund({
                        id: o.id ?? orderId,
                        display: `#${o.id ?? orderId}`,
                        waybill: o.waybill_number || waybill,
                        reverse: data.reverse_order?.reverse_order_id,
                        amount: o.total_amount ?? amount ?? 0,
                    });
                })
                .catch(() => fillRefund({
                    ...fallback,
                    reverse: 'Unable to load'
                }))
                .finally(() => refundModal.show());
        }

        $('refundForm').addEventListener('submit', (e) => {
            e.preventDefault();
            const form = e.target;
            form.classList.add('was-validated');
            if (!form.checkValidity()) return;

            const btn = $('refundSubmitBtn');
            const original = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Processing…';

            fetch(REFUND_URL, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: new FormData(form),
                })
                .then(async r => ({
                    ok: r.ok,
                    body: await r.json().catch(() => ({}))
                }))
                .then(({
                    ok,
                    body
                }) => {
                    if (!ok || body.success === false) throw new Error(body.message || 'Refund failed');
                    refundModal.hide();
                    Swal.fire({
                            icon: 'success',
                            title: 'Refund initiated',
                            text: body.message || '',
                            timer: 2000,
                            showConfirmButton: false
                        })
                        .then(() => location.reload());
                })
                .catch(err => Swal.fire({
                    icon: 'error',
                    title: 'Refund failed',
                    text: err.message
                }))
                .finally(() => {
                    btn.disabled = false;
                    btn.innerHTML = original;
                });
        });
    </script>
@endsection
