@extends('Admin.layouts.master')
@section('source', 'Stocks')
@section('page-title', 'Edit Stocks')

@section('title')
{{config('app.name')}} - Edit Stocks

@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Edit Stock - {{ $stock->product->name }}</h4>
                </div>
                <div class="px-3 pt-0 pb-2">
                    <form action="{{ route('stocks.update', $stock->id) }}" method="POST" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Product</label>
                                    <input type="text" class="form-control" value="{{ $stock->product->name }} ({{ $stock->product->sku }})" readonly>
                                </div>
                            </div>

                            {{-- <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Package Type<sup class="text-danger">*</sup></label> --}}
                            {{-- <input type="text" class="form-control" value="{{ $stock->packageType->package_type }}" readonly> --}}
                            {{-- <select class="form-select @error('product_package_id') is-invalid @enderror" id="product_package_id" name="product_package_id" required>
                                        <option value="{{$stock->packageType->id}}" hidden>{{$stock->packageType->package_type}}</option>
                            @foreach($packageTypes as $package)
                            <option value="{{ $package->id }}" {{ old('product_package_id') == $package->id ? 'selected' : '' }}>
                                {{ $package->package_type }}
                            </option>
                            @endforeach
                            </select>
                            @error('product_package_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                </div> --}}

                {{-- <div class="col-md-6"> --}}
                {{-- <div class="mb-3"> --}}
                {{-- <label class="form-label">Unit<sup class="text-danger">*</sup></label> --}}
                {{-- <input type="text" class="form-control" value="{{ $stock->unit->name }} ({{ $stock->unit->symbol }})" readonly> --}}

                {{-- <select class="form-select @error('unit_id') is-invalid @enderror" id="unit_id" name="unit_id" required>
                                        <option value="{{$stock->unit->id}}" hidden>{{$stock->unit->name}}</option>
                @foreach($units as $unit)
                <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                    {{ $unit->name }}({{ $unit->code }})
                </option>
                @endforeach
                </select>
                @error('unit_id')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror

            </div> --}}
            {{-- </div> --}}

            {{-- <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="product_package_quantity" class="form-label">Package Quantity <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('product_package_quantity') is-invalid @enderror" 
                                           id="product_package_quantity" name="product_package_quantity" 
                                           value="{{ old('product_package_quantity', $stock->product_package_quantity) }}" min="1" required>
            @error('product_package_quantity')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div> --}}

    <div class="col-md-6">
        <div class="mb-3">
            <label for="product_package_quantity" class="form-label">Package Quantity & Type <span class="text-danger">*</span></label>
            <div class="input-group">
                <!-- Quantity Input -->
                <input
                    type="number"
                    class="form-control @error('product_package_quantity') is-invalid @enderror"
                    id="product_package_quantity"
                    name="product_package_quantity"
                    value="{{ old('product_package_quantity', $stock->product_package_quantity) }}"
                    min="1"
                    placeholder="Enter Quantity"
                    style="height:43px;"
                    required
                    readonly>

                <!-- Dropdown Button -->
                <button
                    class="btn btn-outline-secondary dropdown-toggle"
                    type="button"
                    id="packageTypeDropdown"
                    data-bs-toggle="dropdown"
                    aria-expanded="false" style="width:150px">
                    {{ $stock->unit->code ?? 'Select Type' }}
                </button>

                <!-- Dropdown Menu -->
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="packageTypeDropdown">
                    @foreach($units as $unit)
                    <li>
                        <a class="dropdown-item" href="#" data-id="{{ $unit->id }}">
                            {{ ucfirst($unit->code) }} ({{ $unit->name }})
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Hidden field to store selected package ID -->
            <input type="hidden" name="product_package_id" id="product_package_id" value="{{ $stock->unit->id ?? '' }}">

            @error('product_package_quantity')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            @error('product_package_id')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>


    <div class="col-md-6">
        <div class="mb-3">
            <label for="purchase_price" class="form-label">Purchase Price (per unit) <span class="text-danger">*</span></label>
            <div class="input-group @error('purchase_price') has-validation @enderror">
                <span class="input-group-text">{{config('app.rupees')}}</span>
                <input type="number" step="0.01" class="form-control @error('purchase_price') is-invalid @enderror"
                    id="purchase_price" name="purchase_price"
                    value="{{ old('purchase_price', $stock->purchase_price) }}" min="0" required>
                @error('purchase_price')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="selling_price" class="form-label">Selling Price (MRP) <span class="text-danger">*</span></label>
            <div class="input-group @error('selling_price') has-validation @enderror">
                <span class="input-group-text">{{config('app.rupees')}}</span>
                <input type="number" step="0.01" class="form-control @error('selling_price') is-invalid @enderror"
                    id="selling_price" name="selling_price"
                    value="{{ old('selling_price', $stock->selling_price) }}" min="0" required>
                @error('selling_price')
                <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>


</div>

<div class="mt-4 text-end">
    <a href="{{ route('stocks.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to List
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> Update Stock
    </button>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropdownItems = document.querySelectorAll('.dropdown-menu a.dropdown-item');
        const dropdownButton = document.getElementById('packageTypeDropdown');
        const hiddenInput = document.getElementById('product_package_id');

        dropdownItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const selectedText = this.textContent.trim();
                const selectedId = this.dataset.id;

                // Update button label
                dropdownButton.textContent = selectedText;

                // Set selected ID in hidden input
                hiddenInput.value = selectedId;
            });
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const purchaseInput = document.getElementById('purchase_price');
        const sellingInput = document.getElementById('selling_price');
        const form = purchaseInput.closest('form');

        function validatePrices() {
            const purchase = parseFloat(purchaseInput.value) || 0;
            const selling = parseFloat(sellingInput.value) || 0;
            const errorMessage = 'Selling price cannot be less than or equal to purchase price.';

            // If selling < purchase → invalid
            if (selling <= purchase) {
                sellingInput.classList.add('is-invalid');

                let feedback = sellingInput.parentElement.parentElement.querySelector('.invalid-feedback');
                if (!feedback) {
                    feedback = document.createElement('div');
                    feedback.classList.add('invalid-feedback', 'd-block');
                    sellingInput.parentElement.parentElement.appendChild(feedback);
                }
                feedback.textContent = errorMessage;
                return false;
            } else {
                sellingInput.classList.remove('is-invalid');
                const feedback = sellingInput.parentElement.parentElement.querySelector('.invalid-feedback');
                if (feedback) feedback.remove();
                return true;
            }
        }

        // Check while typing
        sellingInput.addEventListener('input', validatePrices);
        purchaseInput.addEventListener('input', validatePrices);

        // Prevent form submission if invalid
        form.addEventListener('submit', function(e) {
            if (!validatePrices()) {
                e.preventDefault();
                sellingInput.focus();
            }
        });
    });
</script>

@endsection