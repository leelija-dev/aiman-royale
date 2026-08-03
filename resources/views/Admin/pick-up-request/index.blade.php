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
                    <button type="button" class="btn btn-success mb-sm-3 mb-1" style="height:40px;" onclick="showPickupModal()">
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
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Design No</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created Date</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pickup Requested</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Show</th>
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
                                            <h6 class="mb-0 text-sm">{{ $order->id }}</h6>
                                        </div>
                                    </div>
                                </td>

                                <td>
    <div class="d-flex align-items-center px-2 py-1">
        <div class="d-flex flex-column justify-content-center">
            @php
                $productNames = $order->orderProducts->map(function($op) {
                    return ($op->product->design_no ?? 'Product') . ' x' . $op->quantity;
                })->implode(', ');
            @endphp
            
            <span class="text-sm text-gray-800">
                {{ $productNames ?: 'No products' }}
            </span>
            
            @if($order->orderProducts->count() > 3)
                <span class="text-xs text-gray-400">
                    + {{ $order->orderProducts->count() - 3 }} more
                </span>
            @endif
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
                                <td >
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-info" title="View Order">
                                <i class="fas fa-eye"></i>
                            </a>
                                <td class="align-middle text-center">
                                    @if(!$order->pick_up_request_added)
                                    <button type="button" class="btn btn-sm btn-primary" onclick="showSinglePickupModal('{{ $order->waybill_number }}', {{ $order->id }})">
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

<!-- Pickup Request Modal -->
<div class="modal fade" id="pickupModal" tabindex="-1" aria-labelledby="pickupModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pickupModalLabel">
                    <i class="fas fa-truck me-2"></i> Create Pickup Request
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="pickupForm">
                    @csrf
                    
                    <!-- Selected Orders Summary -->
                    <div class="alert alert-info">
                        <strong>Selected Orders:</strong> <span id="selectedOrdersCount">0</span> order(s)
                        <br>
                        <small>Waybills: <span id="selectedWaybillsList">None</span></small>
                    </div>

                    <!-- Pickup Date & Time -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="pickup_date" class="form-label fw-bold">Pickup Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="pickup_date" name="pickup_date" 
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}" 
                                   value="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                            <small class="text-muted">Minimum 1 day advance booking required</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="pickup_time" class="form-label fw-bold">Pickup Time <span class="text-danger">*</span></label>
                            <select class="form-control" id="pickup_time" name="pickup_time" required>
                                <option value="">Select Pickup Time</option>
                                <option value="09:00:00">09:00 AM</option>
                                <option value="09:30:00">09:30 AM</option>
                                <option value="10:00:00">10:00 AM</option>
                                <option value="10:30:00">10:30 AM</option>
                                <option value="11:00:00">11:00 AM</option>
                                <option value="11:30:00">11:30 AM</option>
                                <option value="12:00:00">12:00 PM</option>
                                <option value="12:30:00">12:30 PM</option>
                                <option value="13:00:00">01:00 PM</option>
                                <option value="13:30:00">01:30 PM</option>
                                <option value="14:00:00" selected>02:00 PM</option>
                                <option value="14:30:00">02:30 PM</option>
                                <option value="15:00:00">03:00 PM</option>
                                <option value="15:30:00">03:30 PM</option>
                                <option value="16:00:00">04:00 PM</option>
                                <option value="16:30:00">04:30 PM</option>
                                <option value="17:00:00">05:00 PM</option>
                            </select>
                            <small class="text-muted">Pickup time must be at least 3 hours from now</small>
                        </div>
                    </div>

                    <!-- Additional Options -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="pickup_location" class="form-label fw-bold">Pickup Location</label>
                            <input type="text" class="form-control" id="pickup_location" name="pickup_location" 
                                   value="{{ config('delhivery.pickup_location', 'Your Warehouse') }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="expected_packages" class="form-label fw-bold">Expected Packages</label>
                            <input type="number" class="form-control" id="expected_packages" name="expected_packages" 
                                   value="0" readonly>
                        </div>
                    </div>

                    <input type="hidden" id="waybills_hidden" name="waybills">
                    <input type="hidden" id="order_ids_hidden" name="order_ids">
                    <input type="hidden" id="is_single" name="is_single" value="0">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" onclick="submitPickupRequest()">
                    <i class="fas fa-check me-1"></i> Create Pickup Request
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Global variables
    let selectedWaybills = [];
    let selectedOrderIds = [];
    let isSingleRequest = false;

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

    // Show pickup modal for multiple orders
    function showPickupModal() {
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

        // Set selected data
        selectedWaybills = selected.waybills;
        selectedOrderIds = selected.orderIds;
        isSingleRequest = false;
        
        // Update modal with selected data
        document.getElementById('selectedOrdersCount').textContent = selected.waybills.length;
        document.getElementById('selectedWaybillsList').textContent = selected.waybills.join(', ');
        document.getElementById('expected_packages').value = selected.waybills.length;
        document.getElementById('waybills_hidden').value = JSON.stringify(selected.waybills);
        document.getElementById('order_ids_hidden').value = JSON.stringify(selected.orderIds);
        document.getElementById('is_single').value = '0';
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('pickupModal'));
        modal.show();
    }

    // Show pickup modal for single order
    function showSinglePickupModal(waybill, orderId) {
        selectedWaybills = [waybill];
        selectedOrderIds = [orderId];
        isSingleRequest = true;
        
        // Update modal
        document.getElementById('selectedOrdersCount').textContent = '1';
        document.getElementById('selectedWaybillsList').textContent = waybill;
        document.getElementById('expected_packages').value = '1';
        document.getElementById('waybills_hidden').value = JSON.stringify([waybill]);
        document.getElementById('order_ids_hidden').value = JSON.stringify([orderId]);
        document.getElementById('is_single').value = '1';
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('pickupModal'));
        modal.show();
    }

    // Submit pickup request
    function submitPickupRequest() {
        // Validate
        const pickupDate = document.getElementById('pickup_date').value;
        const pickupTime = document.getElementById('pickup_time').value;
        
        if (!pickupDate || !pickupTime) {
            Swal.fire({
                icon: 'error',
                title: 'Missing Information',
                text: 'Please select both pickup date and time.',
                confirmButtonColor: '#3085d6',
            });
            return;
        }

        // Validate date and time (minimum 3 hours from now)
        const selectedDateTime = new Date(`${pickupDate}T${pickupTime}`);
        const now = new Date();
        const minDateTime = new Date(now.getTime() + 3 * 60 * 60 * 1000); // 3 hours from now
        
        if (selectedDateTime < minDateTime) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Pickup Time',
                text: 'Pickup time must be at least 3 hours from now. Please select a later time.',
                confirmButtonColor: '#3085d6',
            });
            return;
        }

        // Prepare data
        const data = {
            waybills: JSON.parse(document.getElementById('waybills_hidden').value),
            order_ids: JSON.parse(document.getElementById('order_ids_hidden').value),
            pickup_date: pickupDate,
            pickup_time: pickupTime,
            is_single: document.getElementById('is_single').value,
        };

        // Show loading
        Swal.fire({
            title: 'Creating Pickup Request...',
            text: `Creating pickup for ${data.waybills.length} order(s)`,
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            },
        });

        // Submit
        fetch('{{ route("pickup.create") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Pickup Request Created!',
                    html: `
                        <p>Successfully created pickup request for ${data.count} order(s).</p>
                        <p><strong>Pickup ID:</strong> ${data.pickup_id || 'N/A'}</p>
                        <p><strong>Scheduled Time:</strong> ${data.actual_pickup_time || data.requested_pickup_time}</p>
                    `,
                    confirmButtonColor: '#28a745',
                }).then(() => {
                    // Close modal and reload page
                    const modal = bootstrap.Modal.getInstance(document.getElementById('pickupModal'));
                    if (modal) {
                        modal.hide();
                    }
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Failed to Create Pickup',
                    text: data.message || 'Something went wrong. Please try again.',
                    confirmButtonColor: '#d33',
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while creating pickup request. Please try again.',
                confirmButtonColor: '#d33',
            });
            console.error('Error:', error);
        });
    }

    // Request pickup for a single order
    function requestSinglePickup(waybill, orderId) {
        showSinglePickupModal(waybill, orderId);
    }
</script>
@endsection