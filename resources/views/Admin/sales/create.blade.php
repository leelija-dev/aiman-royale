@extends('Admin.layouts.master')

@section('title', 'Create Fake Order')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Create Fake Order</h1>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('Admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.sales.index') }}">Fake Orders</a></li>
                        <li class="breadcrumb-item active">Create Order</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Create New Fake Order</h3>
                        </div>
                        <div class="card-body">
                            @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <form action="{{ route('admin.sales.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="user_id">Customer ID</label>
                                            <input type="number" class="form-control" id="user_id" name="user_id" value="1" required>
                                            <small class="form-text text-muted">Enter user ID for this fake order</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="quantity">Quantity</label>
                                            <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" onchange="calculateAmount()">
                                            <small class="form-text text-muted">Product quantity</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="total_amount">Total Amount</label>
                                            <input type="text" class="form-control" id="total_amount" name="total_amount" readonly>
                                            <small class="form-text text-muted">Calculated automatically from product price and quantity</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="order_status">Order Status</label>
                                            <select class="form-control" id="order_status" name="order_status" required>
                                                <option value="pending">Pending</option>
                                                <option value="confirmed">Confirmed</option>
                                                <option value="paid">Paid</option>
                                                <option value="shipped">Shipped</option>
                                                <option value="delivered">Delivered</option>
                                                <option value="cancelled">Cancelled</option>
                                                <option value="returned">Returned</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="payment_status">Payment Status</label>
                                            <select class="form-control" id="payment_status" name="payment_status" required>
                                                <option value="pending">Pending</option>
                                                <option value="paid">Paid</option>
                                                <option value="failed">Failed</option>
                                                <option value="refunded">Refunded</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{--
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="product">Select Product</label>
                                            <select class="form-control" id="product" name="product" onchange="loadVariants()">
                                                <option value="">Select a product</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}"
                                data-price="{{ $product->price }}"
                                data-discount-price="{{ $product->discount_price }}">
                                {{ $product->name }} ({{ $product->design_no }})
                                - ₹{{ $product->price }}
                                @if($product->discount_price)
                                <span class="text-success">- ₹{{ $product->discount_price }}</span>
                                @endif
                                </option>
                                @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="variant">Select Variant</label>
                            <select class="form-control" id="variant" name="variant" onchange="calculateAmount()">
                                <option value="">Select variant (if available)</option>
                            </select>
                            <small class="form-text text-muted">Select product variant if applicable</small>
                        </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address_1">Address 1</label>
                                            <input type="text" class="form-control" id="address_1" name="address_1" placeholder="Enter address line 1">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address_2">Address 2</label>
                                            <input type="text" class="form-control" id="address_2" name="address_2" placeholder="Enter address line 2">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="state">State</label>
                                            <input type="text" class="form-control" id="state" name="state" placeholder="Enter state">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="city">City</label>
                                            <input type="text" class="form-control" id="city" name="city" placeholder="Enter city">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="pincode">Pincode</label>
                                            <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Enter pincode">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone_no">Phone Number</label>
                                            <input type="text" class="form-control" id="phone_no" name="phone_no" placeholder="Enter phone number">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="is_fake_order" name="is_fake_order" value="1" checked>
                                                <label class="form-check-label" for="is_fake_order">
                                                    Fake Order
                                                </label>
                                            </div>
                                            <small class="form-text text-muted">This will mark the order as fake</small>
                                        </div>
                                    </div>
                                </div>
                            <label for="address_1">Address 1</label>
                            <input type="text" class="form-control" id="address_1" name="address_1" placeholder="Enter address line 1">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address_2">Address 2</label>
                            <input type="text" class="form-control" id="address_2" name="address_2" placeholder="Enter address line 2">
                        </div>
                    </div>
                </div>
                --}}

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="product">Select Product</label>
                            <select class="form-control" id="product" name="product" onchange="calculateAmount()">
                                <option value="">Select a product</option>
                                @foreach($products as $product)
                                <option value="{{ $product->id }}"
                                    data-price="{{ $product->price }}"
                                    data-discount-price="{{ $product->discount_price }}">
                                    {{ $product->name }} ({{ $product->design_no }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address_1">Address 1</label>
                            <input type="text" class="form-control" id="address_1" name="address_1" placeholder="Enter address line 1" required>
                            <small class="form-text text-muted">Required field</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address_2">Address 2</label>
                            <input type="text" class="form-control" id="address_2" name="address_2" placeholder="Enter address line 2">
                            <small class="form-text text-muted">Optional field</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone_no">Phone Number</label>
                            <input type="text" class="form-control" id="phone_no" name="phone_no" placeholder="Enter phone number" required>
                            <small class="form-text text-muted">Required field</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_fake_order" name="is_fake_order" value="1" checked>
                                <label class="form-check-label" for="is_fake_order">
                                    Fake Order
                                </label>
                            </div>
                            <small class="form-text text-muted">This will mark the order as fake</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="state">State</label>
                            <input type="text" class="form-control" id="state" name="state" placeholder="Enter state" required>
                            <small class="form-text text-muted">Required field</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city" placeholder="Enter city" required>
                            <small class="form-text text-muted">Required field</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="pincode">Pincode</label>
                            <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Enter pincode" required>
                            <small class="form-text text-muted">Required field</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Create Fake Order
                        </button>
                        <a href="{{ route('admin.sales.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</section>
</div>
@endsection

@section('scripts')
<script>
    function calculateAmount() {
        const productSelect = document.getElementById('product');
        const quantityInput = document.getElementById('quantity');
        const totalAmountInput = document.getElementById('total_amount');

        const selectedProduct = productSelect.options[productSelect.selectedIndex];
        const quantity = parseInt(quantityInput.value) || 0;

        let unitPrice = 0;

        if (selectedProduct && selectedProduct.value) {
            // Use product price (prefer discount price if available)
            const productPrice = parseFloat(selectedProduct.getAttribute('data-price')) || 0;
            const discountPrice = parseFloat(selectedProduct.getAttribute('data-discount-price')) || 0;
            unitPrice = discountPrice > 0 ? discountPrice : productPrice;
        }

        const totalAmount = unitPrice * quantity;
        totalAmountInput.value = totalAmount > 0 ? totalAmount.toFixed(2) : '';
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        calculateAmount();
    });
</script>
@endsection