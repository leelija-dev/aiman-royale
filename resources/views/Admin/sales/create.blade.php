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

                            <div id="validation-errors" class="alert alert-danger" style="display: none;">
                                <ul id="error-list"></ul>
                            </div>

                            <form action="{{ route('admin.sales.store') }}" method="POST" onsubmit="return validateForm()">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="user_id">Customer ID</label>
                                            <input type="number" class="form-control" id="user_id" name="user_id" value="1" required oninput="clearFieldError('user_id')">
                                            <small class="form-text text-muted">Enter user ID for this fake order</small>
                                            <div id="user_id_error" class="text-danger" style="font-size: 0.875em; margin-top: 0.25rem;"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="quantity">Quantity</label>
                                            <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" onchange="calculateAmount()" oninput="clearFieldError('quantity')">
                                            <small class="form-text text-muted">Product quantity</small>
                                            <div id="quantity_error" class="text-danger" style="font-size: 0.875em; margin-top: 0.25rem;"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="total_amount">Total Amount</label>
                                            <input type="text" class="form-control" id="total_amount" name="total_amount" readonly oninput="clearFieldError('total_amount')">
                                            <small class="form-text text-muted">Calculated automatically from product price and quantity</small>
                                            <div id="total_amount_error" class="text-danger" style="font-size: 0.875em; margin-top: 0.25rem;"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="order_status">Order Status</label>
                                            <select class="form-control" id="order_status" name="order_status" onchange="clearFieldError('order_status')">
                                                <option value="">Select order status</option>
                                                <option value="pending">Pending</option>
                                                <option value="confirmed">Confirmed</option>
                                                <option value="paid">Paid</option>
                                                <option value="shipped">Shipped</option>
                                                <option value="delivered">Delivered</option>
                                                <option value="cancelled">Cancelled</option>
                                                <option value="returned">Returned</option>
                                            </select>
                                            <div id="order_status_error" class="text-danger" style="font-size: 0.875em; margin-top: 0.25rem;"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="payment_status">Payment Status</label>
                                            <select class="form-control" id="payment_status" name="payment_status" onchange="clearFieldError('payment_status')">
                                                <option value="">Select payment status</option>
                                                <option value="pending">Pending</option>
                                                <option value="paid">Paid</option>
                                                <option value="failed">Failed</option>
                                                <option value="refunded">Refunded</option>
                                            </select>
                                            <div id="payment_status_error" class="text-danger" style="font-size: 0.875em; margin-top: 0.25rem;"></div>
                                        </div>
                                    </div>
                                </div>

                                {{--

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="product">Select Product</label>
                                            <select class="form-control" id="product" name="product" onchange="calculateAmount(); clearFieldError('product')">
                                                <option value="">Select a product</option>
                                                @foreach($products as $product)
                                                <option value="{{ $product->id }}"
                                                    data-price="{{ $product->price }}"
                                                    data-discount-price="{{ $product->discount_price }}">
                                                    {{ $product->name }} ({{ $product->design_no }})
                                                </option>
                                                @endforeach
                                            </select>
                                            <div id="product_error" class="text-danger" style="font-size: 0.875em; margin-top: 0.25rem;"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address_1">Address 1</label>
                                            <input type="text" class="form-control" id="address_1" name="address_1" placeholder="Enter address line 1" required oninput="clearFieldError('address_1')">
                                            <small class="form-text text-muted">Required field</small>
                                            <div id="address_1_error" class="text-danger" style="font-size: 0.875em; margin-top: 0.25rem;"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address_2">Address 2</label>
                                            <input type="text" class="form-control" id="address_2" name="address_2" placeholder="Enter address line 2" oninput="clearFieldError('address_2')">
                                            <small class="form-text text-muted">Optional field</small>
                                            <div id="address_2_error" class="text-danger" style="font-size: 0.875em; margin-top: 0.25rem;"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone_no">Phone Number</label>
                                            <input type="text" class="form-control" id="phone_no" name="phone_no" placeholder="Enter phone number" required oninput="clearFieldError('phone_no')">
                                            <small class="form-text text-muted">Required field</small>
                                            <div id="phone_no_error" class="text-danger" style="font-size: 0.875em; margin-top: 0.25rem;"></div>
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
                            <div id="product_error" class="text-danger" style="font-size: 0.875em; margin-top: 0.25rem;"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address_1">Address 1</label>
                            <input type="text" class="form-control" id="address_1" name="address_1" placeholder="Enter address line 1">
                            <div id="address_1_error" class="text-danger" style="font-size: 0.875em; margin-top: 0.25rem;"></div>
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone_no">Phone Number</label>
                            <input type="text" class="form-control" id="phone_no" name="phone_no" placeholder="Enter phone number">
                            <div id="phone_no_error" class="text-danger" style="font-size: 0.875em; margin-top: 0.25rem;"></div>
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
                            <input type="text" class="form-control" id="state" name="state" placeholder="Enter state">
                            <div id="state_error" class="text-danger" style="font-size: 0.875em; margin-top: 0.25rem;"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city" placeholder="Enter city">
                            <div id="city_error" class="text-danger" style="font-size: 0.875em; margin-top: 0.25rem;"></div>
                            
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="pincode">Pincode</label>
                            <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Enter pincode">
                            <div id="pincode_error" class="text-danger" style="font-size: 0.875em; margin-top: 0.25rem;"></div>
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
    function clearFieldError(fieldId) {
        const errorElement = document.getElementById(fieldId + '_error');
        if (errorElement) {
            errorElement.textContent = '';
        }
    }

    function showFieldError(fieldId, message) {
        const errorElement = document.getElementById(fieldId + '_error');
        if (errorElement) {
            errorElement.textContent = message;
        }
    }

    function validateForm() {
        let hasErrors = false;
        
        // Clear all field errors
        const fields = ['user_id', 'product', 'quantity', 'total_amount', 'order_status', 'payment_status', 'address_1', 'state', 'city', 'pincode', 'phone_no'];
        fields.forEach(field => clearFieldError(field));
        
        // Validate User ID
        const userId = document.getElementById('user_id').value.trim();
        if (!userId) {
            showFieldError('user_id', 'Customer ID is required');
            hasErrors = true;
        } else if (isNaN(userId) || parseInt(userId) <= 0) {
            showFieldError('user_id', 'Customer ID must be a positive number');
            hasErrors = true;
        }
        
        // Validate Product
        const product = document.getElementById('product').value.trim();
        if (!product) {
            showFieldError('product', 'Please select a product');
            hasErrors = true;
        }
        
        // Validate Quantity
        const quantity = document.getElementById('quantity').value.trim();
        if (!quantity) {
            showFieldError('quantity', 'Quantity is required');
            hasErrors = true;
        } else if (isNaN(quantity) || parseInt(quantity) <= 0) {
            showFieldError('quantity', 'Quantity must be a positive number');
            hasErrors = true;
        }
        
        // Validate Total Amount
        const totalAmount = document.getElementById('total_amount').value.trim();
        if (!totalAmount) {
            showFieldError('total_amount', 'Total amount is required');
            hasErrors = true;
        } else if (isNaN(totalAmount) || parseFloat(totalAmount) <= 0) {
            showFieldError('total_amount', 'Total amount must be a positive number');
            hasErrors = true;
        }
        
        // Validate Order Status
        const orderStatus = document.getElementById('order_status').value.trim();
        if (!orderStatus) {
            showFieldError('order_status', 'Order status is required');
            hasErrors = true;
        }
        
        // Validate Payment Status
        const paymentStatus = document.getElementById('payment_status').value.trim();
        if (!paymentStatus) {
            showFieldError('payment_status', 'Payment status is required');
            hasErrors = true;
        }
        
        // Validate Address 1
        const address1 = document.getElementById('address_1').value.trim();
        if (!address1) {
            showFieldError('address_1', 'Address 1 is required');
            hasErrors = true;
        } else if (address1.length > 100) {
            showFieldError('address_1', 'Address 1 must be less than 100 characters');
            hasErrors = true;
        }
        
        // Validate State
        const state = document.getElementById('state').value.trim();
        if (!state) {
            showFieldError('state', 'State is required');
            hasErrors = true;
        } else if (state.length > 50) {
            showFieldError('state', 'State must be less than 50 characters');
            hasErrors = true;
        }
        
        // Validate City
        const city = document.getElementById('city').value.trim();
        if (!city) {
            showFieldError('city', 'City is required');
            hasErrors = true;
        } else if (city.length > 25) {
            showFieldError('city', 'City must be less than 25 characters');
            hasErrors = true;
        }
        
        // Validate Pincode
        const pincode = document.getElementById('pincode').value.trim();
        if (!pincode) {
            showFieldError('pincode', 'Pincode is required');
            hasErrors = true;
        } else if (!/^\d{6}$/.test(pincode)) {
            showFieldError('pincode', 'Pincode must be exactly 6 digits');
            hasErrors = true;
        }
        
        // Validate Phone Number
        const phoneNo = document.getElementById('phone_no').value.trim();
        if (!phoneNo) {
            showFieldError('phone_no', 'Phone number is required');
            hasErrors = true;
        } else if (!/^\d{10,12}$/.test(phoneNo)) {
            showFieldError('phone_no', 'Phone number must be 10-12 digits');
            hasErrors = true;
        }
        
        // Prevent form submission if there are errors
        if (hasErrors) {
            // Find first field with error and scroll to it
            const firstErrorField = fields.find(field => {
                const errorElement = document.getElementById(field + '_error');
                return errorElement && errorElement.textContent.trim() !== '';
            });
            
            if (firstErrorField) {
                const fieldElement = document.getElementById(firstErrorField);
                if (fieldElement) {
                    fieldElement.focus();
                    fieldElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
            
            return false;
        }
        
        return true; // Allow form submission
    }

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