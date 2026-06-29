@extends('Admin.layouts.master')
@section('source', 'Pickup Request')
@section('page-title', 'Pickup Requests')

@section('title')
{{ config('app.name') }} - Pickup Requests
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex flex-wrap flex-lg-nowrap justify-content-between align-items-center">
                <!-- Search Form -->
                <form method="GET" action="{{ route('pickup.index') }}" class="mb-2 mb-md-0 d-flex w-100 w-lg-50">
                    <div class="d-flex gap-2 col-12 flex-sm-nowrap flex-wrap justify-content-sm-start justify-content-end">
                        <input type="text" name="search" class="form-control me-2" style="height:40px;width:100%;" placeholder="Search by waybill or order ID" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary me-2 mb-sm-3 mb-1" style="height:40px;">Search</button>
                        <a href="{{ route('pickup.index') }}" class="btn btn-danger mb-sm-3 mb-1" style="height:40px;">Reset</a>
                    </div>
                </form>

                <!-- Action Button -->
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-success mb-sm-3 mb-1" style="height:40px;" onclick="createPickupRequest()">
                        <i class="fas fa-truck me-1"></i> Create Pickup Request
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
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Waybill Number</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Order ID</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created Date</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pickup Requested</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td>
                                    <input type="checkbox" class="order-checkbox" value="{{ $order->waybill_number }}" 
                                           data-order-id="{{ $order->id }}" 
                                           {{ $order->pick_up_request_added ? 'disabled' : '' }}>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $order->waybill_number }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $order->order_id }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <span class="text-sm">{{ $order->created_at->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $order->pick_up_request_added ? 'success' : 'warning' }}">
                                        {{ $order->pick_up_request_added ? 'Requested' : 'Pending' }}
                                    </span>
                                </td>
                                <td class="align-middle text-center">
                                    @if(!$order->pick_up_request_added)
                                    <button type="button" class="btn btn-sm btn-primary" onclick="requestSinglePickup('{{ $order->waybill_number }}', {{ $order->id }})">
                                        <i class="fas fa-truck"></i> Request Pickup
                                    </button>
                                    @else
                                    <span class="text-muted">Already Requested</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <p class="text-muted">No orders available for pickup.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
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
@endsection

@section('scripts')
<script>
    // Select/Deselect all checkboxes
    function toggleAllCheckboxes(selectAll) {
        const checkboxes = document.querySelectorAll('.order-checkbox:not(:disabled)');
        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAll.checked;
        });
    }

    // Get selected waybills
    function getSelectedWaybills() {
        const checkboxes = document.querySelectorAll('.order-checkbox:checked');
        const waybills = [];
        const orderIds = [];
        
        checkboxes.forEach(checkbox => {
            waybills.push(checkbox.value);
            orderIds.push(checkbox.dataset.orderId);
        });
        
        return { waybills, orderIds };
    }

    // Create pickup request for selected orders
    function createPickupRequest() {
        const selected = getSelectedWaybills();
        
        if (selected.waybills.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No Orders Selected',
                text: 'Please select at least one order to create a pickup request.',
                confirmButtonColor: '#3085d6',
            });
            return;
        }

        // Show confirmation dialog
        Swal.fire({
            title: 'Create Pickup Request?',
            text: `You are about to create a pickup request for ${selected.waybills.length} order(s).`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, create pickup!',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return fetch('{{ route("pickup.create") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        waybills: selected.waybills,
                        order_ids: selected.orderIds,
                    }),
                })
                .then(response => {
                    if (!response.ok) {
                        console.log('Network response was not ok', response);
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (!data.success) {
                        throw new Error(data.message || 'Failed to create pickup request');
                    }
                    return data;
                })
                .catch(error => {
                    Swal.showValidationMessage(`Request failed: ${error.message}`);
                });
            },
            allowOutsideClick: () => !Swal.isLoading(),
        }).then((result) => {
            if (result.isConfirmed) {
                // Success message
                Swal.fire({
                    icon: 'success',
                    title: 'Pickup Request Created!',
                    text: `Successfully created pickup request for ${result.data.count || 0} order(s).`,
                    confirmButtonColor: '#28a745',
                }).then(() => {
                    // Reload the page to show updated status
                    location.reload();
                });
            }
        });
    }

    // Request pickup for a single order
    function requestSinglePickup(waybill, orderId) {
        Swal.fire({
            title: 'Request Pickup?',
            text: `Do you want to request pickup for order with waybill: ${waybill}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, request pickup!',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return fetch('{{ route("pickup.create") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        waybills: [waybill],
                        order_ids: [orderId],
                    }),
                })
                .then(response => {
                    console.log('Response:', response);
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (!data.success) {
                        throw new Error(data.message || 'Failed to create pickup request');
                    }
                    return data;
                })
                .catch(error => {
                    Swal.showValidationMessage(`Request failed: ${error.message}`);
                });
            },
            allowOutsideClick: () => !Swal.isLoading(),
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: 'Pickup Request Created!',
                    text: `Successfully requested pickup for order.`,
                    confirmButtonColor: '#28a745',
                }).then(() => {
                    location.reload();
                });
            }
        });
    }
</script>
@endsection