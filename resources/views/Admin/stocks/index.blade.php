@extends('Admin.layouts.master')
@section('source', 'Stocks')
@section('page-title', 'Stock Management')

@section('title')
{{config('app.name')}} - Stocks
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex flex-md-nowrap flex-wrap justify-content-between align-items-center pb-0">
                    <div class="d-flex align-items-center flex-wrap  w-lg-50 w-md-75 w-100">
                        {{-- <h4 class="card-title">Stock Management</h4> --}}
                        <form method="GET" action="{{route('stocks.index')}}" class="col-12 d-flex w-100 ">
                            <div class="col-12 d-flex gap-2 flex-sm-nowrap flex-wrap justify-content-sm-start justify-content-end">
                                <div class="w-100">
                                    <input type="text" name="search" class="form-control" placeholder="Search by product name"
                                        value="{{ request('search') }}">
                                </div>

                                <button type="submit" class="btn btn-primary  mb-sm-3 mb-2">Search</button>
                                <a href="{{ route('stocks.index') }}" class="btn btn-danger mb-sm-3 mb-2">Reset</a>
                            </div>
                        </form>
                    </div>
                    <a href="{{ route('stocks.create') }}" class="btn btn-primary ms-sm-0 w-100 w-md-auto">
                        <i class="fas fa-plus"></i> Add Stock
                    </a>
                </div>
                <div class=" px-3 pt-0 pb-2">
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table align-items-center mb-0" id="stocksTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-8 text-center">P.Code</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-8">Product</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-8 text-center">In Stock</th>
                                    {{-- <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-8">Unit</th> --}}
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-8 text-end">Purchase Price</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-8 text-end">Selling Price</th>
                                    {{-- <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-8 text-center">In Stock</th> --}}
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-8 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($stocks->isNotEmpty())
                                @forelse($stocks as $stock)
                                <tr>
                                    <td class="text-center">{{ $stock->product->sku }}</td>
                                    <td>{{ optional($stock->product)->name ?? 'N/A' }} - {{$stock->product->unit_amount}}{{(($stock->product)->unit)->code}}
                                        <br><span class="text-small" style="font-size: 13px;">{{(($stock->product)->brand)->name ?? 'Other'}}</span>
                                    </td>
                                    <td class="text-center">{{ $stock->product_package_quantity }} {{ $stock->unit->code ?? '' }}</td>
                                    {{-- <td>{{ $stock->unit->name ?? 'N/A' }}</td> --}}
                                    <td class="text-center">{{ config('app.rupees')}}{{ number_format($stock->purchase_price, 2) }}</td>
                                    <td class="text-center">{{ config('app.rupees')}}{{ number_format($stock->selling_price, 2) }}</td>
                                    {{-- <td class="text-center font-weight-bold {{ $stock->quantity_in_stock < 10 ? 'text-danger' : '' }}">
                                    {{ $stock->quantity_in_stock }}
                                    </td> --}}
                                    <td class="text-center ">
                                        <div class="btn-group" role="group">
                                            <button type="button"
                                                class="btn btn-link text-info p-1 me-2"
                                                data-bs-toggle="modal"
                                                data-bs-target="#addStockModal{{ $stock->id }}"
                                                data-bs-toggle="tooltip"
                                                data-bs-original-title="Add Stock">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <!-- <button type="button" 
                                                        class="btn btn-link text-warning p-1" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#deductStockModal{{ $stock->id }}"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-original-title="Deduct Stock"
                                                        {{ $stock->quantity_in_stock <= 0 ? 'disabled' : '' }}>
                                                    <i class="fas fa-minus"></i>
                                                </button> -->
                                            <a href="{{ route('stocks.edit', $stock->id) }}"
                                                class="btn btn-link text-primary p-1 me-2"
                                                data-bs-toggle="tooltip"
                                                data-bs-original-title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            {{-- <button type="button" 
                                                        class="btn btn-link text-danger p-1"
                                                        onclick="deleteStock({{ $stock->id }})"
                                            data-bs-toggle="tooltip"
                                            data-bs-original-title="Delete">
                                            <i class="fas fa-trash"></i>
                                            </button>
                                            <form id="delete-form-{{ $stock->id }}"
                                                action="{{ route('stocks.destroy', $stock->id) }}"
                                                method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form> --}}
                                        </div>

                                        <!-- Add Stock Modal -->
                                        <div class="modal fade" id="addStockModal{{ $stock->id }}" tabindex="-1"
                                            aria-labelledby="addStockModalLabel{{ $stock->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                        @php
                                                            $product = $stock->product;
                                                            $isDeleted = $product && $product->trashed();
                                                        @endphp
                                                        <form id="addStockForm{{ $stock->id }}" class="add-stock-form" action="{{ route('stocks.add-stock', $stock->id) }}" method="POST" data-stock-id="{{ $stock->id }}" novalidate>
                                                        @csrf
                                                        @if ($isDeleted)
                                                            
                                                            <div class="modal-header">
                                                            <h5 class="modal-title" id="addStockModalLabel{{ $stock->id }}">
                                                                Product - {{ $stock->product->name ?? 'Other' }}
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <div class=" text-danger mb-0">
                                                                This product has been deleted. You cannot add stock for it.
                                                            </div>
                                                            </div>

                                                        </div>
                                                        @else
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="addStockModalLabel{{ $stock->id }}">
                                                                Add Stock - {{ $stock->product->name ?? 'Other' }}
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="quantity" class="form-label">Quantity to Add <span class="text-danger">*</span></label>
                                                                <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                                                    id="quantity" name="quantity"
                                                                    value="{{ old('quantity') }}"
                                                                    min="1" required>
                                                                @error('quantity')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Add Stock</button>
                                                        </div>
                                                        @endif
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Deduct Stock Modal -->
                                        <div class="modal fade" id="deductStockModal{{ $stock->id }}" tabindex="-1"
                                            aria-labelledby="deductStockModalLabel{{ $stock->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('stocks.deduct-stock', $stock->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deductStockModalLabel{{ $stock->id }}">
                                                                Deduct Stock - {{ $stock->product->name  ?? 'N/A'}}
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="quantity" class="form-label">Quantity to Deduct</label>
                                                                <input type="number" class="form-control" id="quantity" name="quantity"
                                                                    min="1" max="{{ $stock->quantity_in_stock }}" required>
                                                                <div class="form-text">
                                                                    Current stock: {{ $stock->quantity_in_stock }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-warning">Deduct Stock</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">No stock records found.</td>
                                </tr>
                                @endforelse
                                @else
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        Stock not available!
                                    </td>
                                </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>

                    <div class=" mt-3">
                        {{ $stocks->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Handle add stock form submission
        $(document).on('submit', '.add-stock-form', function(e) {
            e.preventDefault();

            const form = $(this);
            const stockId = form.data('stock-id');
            const submitBtn = form.find('button[type="submit"]');
            const originalBtnText = submitBtn.html();
            const url = form.attr('action');

            console.log('Form submitted to URL:', url); // Debug log

            // Show loading state
            submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Adding...');

            // Clear previous errors
            form.find('.is-invalid').removeClass('is-invalid');
            form.find('.invalid-feedback').remove();

            // Get the CSRF token
            const token = $('meta[name="csrf-token"]').attr('content');

            // Get form data
            const formData = form.serialize();
            console.log('Form data:', formData); // Debug log

            // Submit form via AJAX
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    console.log('Success response:', response); // Debug log
                    if (response && response.success) {
                        // Show success message
                        const modal = $('#addStockModal' + stockId);
                        modal.modal('hide');

                        // Update the stock quantity in the table
                        const quantityCell = $('#stock-quantity-' + stockId);
                        if (response.new_quantity) {
                            quantityCell.text(response.new_quantity);
                        }
                        // setTimeout(function() {
                        //     location.reload();
                        // }, 2000);
                        // Show success message
                        showAlert('success', response.message || 'Stock updated successfully!');
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                        // Reset form
                        form[0].reset();

                    }
                },
                error: function(xhr) {
                    console.log('Error response:', xhr); // Debug log

                    if (xhr.status === 422) {
                        // Validation errors
                        const errors = xhr.responseJSON.errors;
                        console.log('Validation errors:', errors); // Debug log

                        // Display errors
                        if (errors) {
                            $.each(errors, function(field, messages) {
                                console.log('Processing field:', field, messages); // Debug log
                                const input = form.find('[name="' + field + '"]');
                                input.addClass('is-invalid');

                                // Remove any existing error message for this field
                                input.next('.invalid-feedback').remove();

                                // Add error message
                                if (messages && messages.length > 0) {
                                    const errorDiv = $('<div class="invalid-feedback d-block">' + messages[0] + '</div>');
                                    input.after(errorDiv);
                                }
                            });
                        } else {
                            showAlert('error', 'Validation failed. Please check your input.');
                        }
                    } else {
                        // Other errors
                        const errorMessage = xhr.responseJSON && xhr.responseJSON.message ?
                            xhr.responseJSON.message :
                            'An error occurred. Please try again.';
                        showAlert('error', errorMessage);
                    }
                },
                complete: function() {
                    // Re-enable submit button
                    submitBtn.prop('disabled', false).html(originalBtnText);
                }
            });
        });

        // Reset form when modal is closed
        $('.modal').on('hidden.bs.modal', function() {
            const form = $(this).find('form');
            form[0].reset();
            form.find('.is-invalid').removeClass('is-invalid');
            form.find('.invalid-feedback').remove();
        });

        // Helper function to show alerts
        function showAlert(type, message) {
            const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;

            // Add alert to the alerts container or create one if it doesn't exist
            let alertsContainer = $('.alerts-container');
            if (alertsContainer.length === 0) {
                alertsContainer = $('<div class="alerts-container"></div>');
                $('.container-fluid.py-4').prepend(alertsContainer);
            }

            alertsContainer.append(alertHtml);

            // Auto-remove alert after 5 seconds
            setTimeout(() => {
                $('.alert').fadeOut(400, function() {
                    $(this).remove();
                });
            }, 5000);
        }
    });
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    function deleteStock(stockId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('delete-form-' + stockId);
                if (form) {
                    form.submit();
                } else {
                    console.error('Delete form not found for ID:', stockId);
                    Swal.fire(
                        'Error!',
                        'Could not find the form to submit. Please try again.',
                        'error'
                    );
                }
            }
        });
    }
</script>
@endpush