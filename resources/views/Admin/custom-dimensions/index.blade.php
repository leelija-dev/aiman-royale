@extends('Admin.layouts.master')
@section('source', 'Custom Dimensions')
@section('page-title', 'Custom Dimensions')

@section('title')
{{ config('app.name') }} - Custom Dimensions
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex flex-wrap flex-lg-nowrap justify-content-between align-items-center">
                <!-- Search Form -->
                <form method="GET" action="{{ route('admin.custom-dimensions.index') }}" class="mb-2 mb-md-0 d-flex w-100 w-lg-50">
                    <div class="d-flex gap-2 col-12 flex-sm-nowrap flex-wrap justify-content-sm-start justify-content-end">
                        <input type="text" name="search" class="form-control me-2" style="height:40px;width:100%;"
                            placeholder="Search by customer name, product, or request ID" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary me-2 mb-sm-3 mb-1" style="height:40px;">Search</button>
                        <a href="{{ route('admin.custom-dimensions.index') }}" class="btn btn-danger mb-sm-3 mb-1" style="height:40px;">Reset</a>
                    </div>
                </form>

                <!-- Action Buttons -->
                <div class="d-flex gap-2 flex-sm-nowrap flex-wrap justify-content-end w-100 w-xl-50">
                    <button class="btn btn-outline-secondary w-100 w-sm-auto mb-sm-3 mb-1" onclick="exportData()">
                        <i class="fas fa-download"></i> Export
                    </button>
                    <button class="btn btn-primary w-100 w-sm-auto mb-sm-3 mb-1" onclick="refreshData()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                </div>
            </div>

            <!-- Stats Cards -->
             {{--
            <div class="row mb-4 px-4 pt-2">
                <div class="col-md-2">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <h5 class="card-title mb-1">{{ $customRequests->total() }}</h5>
                            <p class="card-text text-muted small">Total Requests</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card bg-warning bg-opacity-10">
                        <div class="card-body text-center">
                            <h5 class="card-title mb-1 text-warning">{{ $customRequests->getCollection()->where('status', 'requested')->count() }}</h5>
                            <p class="card-text text-muted small">Requested</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card bg-info bg-opacity-10">
                        <div class="card-body text-center">
                            <h5 class="card-title mb-1 text-info">{{ $customRequests->getCollection()->where('status', 'viewed')->count() }}</h5>
                            <p class="card-text text-muted small">Viewed</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card bg-primary bg-opacity-10">
                        <div class="card-body text-center">
                            <h5 class="card-title mb-1 text-primary">{{ $customRequests->getCollection()->where('status', 'processing')->count() }}</h5>
                            <p class="card-text text-muted small">Processing</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card bg-success bg-opacity-10">
                        <div class="card-body text-center">
                            <h5 class="card-title mb-1 text-success">{{ $customRequests->getCollection()->where('status', 'accepted')->count() }}</h5>
                            <p class="card-text text-muted small">Accepted</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card bg-danger bg-opacity-10">
                        <div class="card-body text-center">
                            <h5 class="card-title mb-1 text-danger">{{ $customRequests->getCollection()->where('status', 'canceled')->count() }}</h5>
                            <p class="card-text text-muted small">Canceled</p>
                        </div>
                    </div>
                </div>
            </div>
              --}}
            <div class="card px-4 pt-2 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Request ID</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Customer</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Measurements</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Color</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                {{--
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customRequests->items() as $request)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">#{{ str_pad($request->id, 6, '0', STR_PAD_LEFT) }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 12px;">
                                                {{ strtoupper(substr($request->user->name ?? 'Unknown', 0, 2)) }}
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $request->user->name ?? 'Unknown User' }}</div>
                                                <div class="text-muted small">{{ $request->user->email ?? 'N/A' }}</div>
                                                <div class="text-muted small">{{ $request->user->phone ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex align-items-center">
                                            @if($request->product && $request->product->images->isNotEmpty())
                                            <img src="{{ asset($request->product->images->first()->image) }}" alt="{{ $request->product->name }}" class="me-2" style="width: 40px; height: 40px; object-fit: cover; border-radius: 8px;">
                                            @else
                                            <div class="bg-gray-200 d-flex align-items-center justify-content-center me-2" style="width: 40px; height: 40px; border-radius: 8px;">
                                                <i class="fas fa-image text-gray-400"></i>
                                            </div>
                                            @endif
                                            <div>
                                                <div class="fw-semibold">{{ $request->product->name ?? 'Unknown Product' }}</div>
                                                <div class="text-muted small">SKU: {{ $request->product->sku ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <div class="small">
                                                @if($request->bust)<div>Bust: {{ $request->bust }}cm</div>@endif
                                                @if($request->waist)<div>Waist: {{ $request->waist }}cm</div>@endif
                                                @if($request->hip)<div>Hip: {{ $request->hip }}cm</div>@endif
                                                @if($request->armhole)<div>Armhole: {{ $request->armhole }}cm</div>@endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            @if($request->color_code)
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="color-preview" style="background-color: {{ $request->color_code }};"></div>
                                                <span class="small">{{ $request->color_code }}</span>
                                            </div>
                                            @else
                                            <span class="text-muted">-</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <div class="d-flex align-items-center gap-2">
                                                <input type="number" 
                                                       class="form-control form-control-sm" 
                                                       style="width: 100px;" 
                                                       id="price-{{ $request->id }}" 
                                                       value="{{ $request->price ?? '' }}" 
                                                       placeholder="0.00" 
                                                       step="0.01" 
                                                       min="0">
                                                <button class="btn btn-sm btn-primary" onclick="updatePrice({{ $request->id }})">
                                                    <i class="fas fa-save"></i>
                                                </button>
                                            </div>
                                            @if($request->price)
                                                <small class="text-muted">Current: {{config('app.currency')}}{{ number_format($request->price, 2) }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <select class="form-select form-select-sm" onchange="updateStatus({{ $request->id }}, this.value)">
                                                <option value="requested" {{ $request->status == 'requested' ? 'selected' : '' }}>Requested</option>
                                                <option value="viewed" {{ $request->status == 'viewed' ? 'selected' : '' }}>Viewed</option>
                                                <option value="processing" {{ $request->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                                <option value="accepted" {{ $request->status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                                <option value="canceled" {{ $request->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                                            </select>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <div class="small">
                                                <div>{{ $request->created_at->format('M d, Y') }}</div>
                                                <div class="text-muted">{{ $request->created_at->format('h:i A') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                {{--
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" onclick="viewDetails({{ $request->id }})">
                                <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-outline-info" onclick="contactCustomer({{ $request->user->id ?? 0 }})">
                                    <i class="fas fa-envelope"></i>
                                </button>
                </div>
            </div>
            </td>
            --}}
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center py-5">
                    <i class="fas fa-ruler-combined text-muted mb-3" style="font-size: 48px;"></i>
                    <h5 class="text-muted">No Custom Dimension Requests</h5>
                    <p class="text-muted">There are no custom dimension requests to display.</p>
                </td>
            </tr>
            @endforelse
            </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $customRequests->links() }}
        </div>
    </div>
</div>
</div>
</div>

<!-- Details Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Custom Dimension Request Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detailsContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<style>
    .color-preview {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: 2px solid #e5e7eb;
    }
</style>

<script>
    function updateStatus(id, status) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]') ?
            document.querySelector('meta[name="csrf-token"]').getAttribute('content') :
            document.querySelector('meta[name="_token"]') ?
            document.querySelector('meta[name="_token"]').getAttribute('content') :
            '';

        fetch(`/admin/custom-dimensions/${id}/status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    status: status
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Status updated successfully',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                } else {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: data.message || 'Error updating status',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Error updating status',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            });
    }

    function updatePrice(id) {
        const priceInput = document.getElementById(`price-${id}`);
        const price = priceInput.value;
        
        if (!price || price < 0) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: 'Please enter a valid price',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
            return;
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]') ?
            document.querySelector('meta[name="csrf-token"]').getAttribute('content') :
            document.querySelector('meta[name="_token"]') ?
            document.querySelector('meta[name="_token"]').getAttribute('content') :
            '';

        fetch(`/admin/custom-dimensions/${id}/price`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    price: price
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Price updated successfully',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                    // Update the current price display
                    location.reload();
                } else {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: data.message || 'Error updating price',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Error updating price',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            });
    }

    function viewDetails(id) {
        // Load details into modal
        fetch(`/custom-dimensions/details/${id}`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('detailsContent').innerHTML = html;
                new bootstrap.Modal(document.getElementById('detailsModal')).show();
            })
            .catch(error => {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Error loading details',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            });
    }

    function contactCustomer(userId) {
        if (userId === 0) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: 'Customer information not available',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
            return;
        }
        // Implement contact customer functionality
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'info',
            title: 'Contact customer feature coming soon',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    }

    function refreshData() {
        location.reload();
    }

    function exportData() {
        // Implement export functionality
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'info',
            title: 'Export feature coming soon',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    }
</script>
@endsection