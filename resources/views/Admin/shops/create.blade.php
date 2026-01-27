@extends('Admin.layouts.master')
@section('source', 'Shops')
@section('page-title', 'Add Shop')

@section('title')
{{config('app.name')}} - Add Shop

@endsection

@section('content')
    <div class="row w-100 px-3 mt-3 m-0">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create New Shop</h4>
                    <a href="{{ route('shops.index') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
                <div class="card-body overflow-visible mh-100 py-0">
                    <form id="shopForm" action="{{ route('shops.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        
                        <div class="form-group mb-4">
                            <label for="shop_name" class="text-uppercase text-secondary fw-bold">Shop Name <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('shop_name') is-invalid @enderror" 
                                   id="shop_name" 
                                   name="shop_name" 
                                   value="{{ old('shop_name') }}" 
                                   required
                                   minlength="3"
                                   maxlength="100"
                                   pattern="^[a-zA-Z0-9][a-zA-Z0-9\s\-\&\',.()]*[a-zA-Z0-9]$"
                                   oninput="validateShopName(this)">
                            <div class="invalid-feedback">
                                @error('shop_name')
                                    {{ $message }}
                                @else
                                    Please enter a valid shop name (3-100 characters). Must start and end with a letter or number. Allowed: letters, numbers, spaces, hyphens, &, ', comma, ., and parentheses.
                                @enderror
                            </div>
                            <div class="valid-feedback">
                                Shop name looks good!
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="shop_address" class="text-uppercase text-secondary fw-bold">Address</label>
                            <textarea class="form-control @error('shop_address') is-invalid @enderror" 
                                     id="shop_address" 
                                     name="shop_address" 
                                     rows="3"
                                     maxlength="255">{{ old('shop_address') }}</textarea>
                            <div class="invalid-feedback">
                                @error('shop_address')
                                    {{ $message }}
                                @else
                                    Address cannot exceed 255 characters.
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="due_amount" class="text-uppercase text-secondary fw-bold">Due Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">{{ config('app.rupees') }}</span>
                                <input type="number" 
                                       class="form-control @error('due_amount') is-invalid @enderror" 
                                       id="due_amount" 
                                       name="due_amount" 
                                       value="{{ old('due_amount', 0) }}" 
                                       min="0" 
                                       
                                       step="0.01"
                                       placeholder="0.00">
                            </div>
                            <div class="invalid-feedback">
                                @error('due_amount')
                                    {{ $message }}
                                @else
                                    Please enter a valid amount (0 - 999,999.99).
                                @enderror
                            </div>
                            <small class="form-text text-muted">Enter the initial due amount (if any) maximum ₹999,99,999.99</small>
                        </div>

                        {{-- <div class="form-group mb-4">
                            <label for="mobile_number" class="text-uppercase text-secondary fw-bold">Mobile Number <span class="text-danger">*</span></label>
                            <input type="tel" 
                                   class="form-control @error('mobile_number') is-invalid @enderror" 
                                   id="mobile_number" 
                                   name="mobile_number" 
                                   value="{{ old('mobile_number') }}" 
                                   placeholder="+1234567890 or 123-456-7890"
                                   required
                                   pattern="^(\+?\d{1,3}[-.\s]?)?\(?\d{3}\)?[-.\s]?\d{3}[-.\s]?\d{4}$"
                                   oninput="formatPhoneNumber(this)">
                            <div class="invalid-feedback">
                                @error('mobile_number')
                                    {{ $message }}
                                @else
                                    Please enter a valid mobile number (e.g., +1234567890 or 123-456-7890)
                                @enderror
                            </div>
                            <small class="form-text text-muted">Format: +1 (123) 456-7890 or 123-456-7890 (10-13 digits)</small>
                            <div class="invalid-feedback">
                                @error('mobile_number')
                                    {{ $message }}
                                @else
                                   
                                @enderror
                            </div> --}}
                            <div class="form-group mb-4">
                            <label for="mobile_number" class="text-uppercase text-secondary fw-bold">
                                Mobile Number <span class="text-danger">*</span>
                            </label>
                            <input type="tel"
                                class="form-control @error('mobile_number') is-invalid @enderror"
                                id="mobile_number"
                                name="mobile_number"
                                value="{{ old('mobile_number') }}"
                                placeholder="Enter mobile number"
                                required
                                pattern="^\d{10}$"
                                maxlength="10"
                                oninput="formatPhoneNumber(this)">

                            <div class="invalid-feedback">
                                @error('mobile_number')
                                    {{ $message }}
                                @else
                                    Please enter a valid mobile number.
                                @enderror
                            </div>
                            <small class="form-text text-muted">Example: 9876543210</small>
                        </div>



                            <div class="valid-feedback">
                                Valid mobile number format.
                            </div>
                        </div>

                        <div class="form-group mt-4  text-end px-4">
                            <a href="{{ route('shops.index') }}" class="btn btn-danger ms-2">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Save Shop
                            </button>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Format phone number as user types
        // function formatPhoneNumber(input) {
        //     // Remove all non-digit characters
        //     let value = input.value.replace(/\D/g, '');
            
        //     // Format based on input length
        //     if (value.length > 0) {
        //         // If starts with +, format as international
        //         if (input.value.startsWith('+')) {
        //             if (value.length > 1) {
        //                 value = '+' + value.substring(1, Math.min(4, value.length)) + 
        //                        (value.length > 4 ? ' ' + value.substring(4, Math.min(7, value.length)) : '') + 
        //                        (value.length > 7 ? ' ' + value.substring(7, Math.min(11, value.length)) : '');
        //             }
        //         } else {
        //             // Format as local number
        //             if (value.length > 3) {
        //                 value = value.substring(0, 3) + '-' + value.substring(3, Math.min(6, value.length)) + 
        //                        (value.length > 6 ? '-' + value.substring(6, 10) : '');
        //             }
        //         }
        //     }
            
        //     // Update input value
        //     input.value = value;
        // }
        
            function formatPhoneNumber(input) {
                input.value = input.value.replace(/[^0-9]/g, '').slice(0, 10);
            }

        
        // Validate shop name
        function validateShopName(input) {
            // Remove leading/trailing spaces
           // input.value = input.value.trim();
            // Ensure first and last characters are alphanumeric
            if (input.value.length > 0 && !/^[a-zA-Z0-9].*[a-zA-Z0-9]$/.test(input.value.trim())) {
                input.setCustomValidity('Shop name must start and end with a letter or number');
            } else {
                input.setCustomValidity('');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Form validation
            const form = document.getElementById('shopForm');
            const fields = ['shop_name', 'shop_address', 'mobile_number'];
            
            // Add real-time validation on input change
            fields.forEach(field => {
                const input = document.getElementById(field);
                if (input) {
                    input.addEventListener('input', function() {
                        if (input.checkValidity()) {
                            input.classList.remove('is-invalid');
                            input.classList.add('is-valid');
                        } else {
                            input.classList.remove('is-valid');
                            input.classList.add('is-invalid');
                        }
                    });
                }
            });
            
            // Form submission validation
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                
                if (!form.checkValidity()) {
                    event.stopPropagation();
                    // Show validation messages for all invalid fields
                    fields.forEach(field => {
                        const input = document.getElementById(field);
                        if (input && !input.checkValidity()) {
                            input.classList.add('is-invalid');
                        }
                    });
                } else {
                    // If form is valid, submit it
                    form.submit();
                }
                
                form.classList.add('was-validated');
            }, false);
            
            // Clear validation on modal close if needed
            const modal = document.getElementById('shopForm').closest('.modal');
            if (modal) {
                modal.addEventListener('hidden.bs.modal', function() {
                    form.reset();
                    form.classList.remove('was-validated');
                    fields.forEach(field => {
                        const input = document.getElementById(field);
                        if (input) {
                            input.classList.remove('is-valid', 'is-invalid');
                        }
                    });
                });
            }
        });
    </script>
    @endpush
@endsection
