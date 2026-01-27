@extends('Admin.layouts.master')
@section('source', 'Shops')
@section('page-title', 'Edit Shop')

@section('title')
{{config('app.name')}} - Edit Shop

@endsection

@section('content')
    <div class="row w-100 px-3 mt-3 m-0">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Shop: {{ $shop->shop_name }}</h4>
                    <a href="{{ route('shops.index') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
                <div class="card-body overflow-visible mh-100 py-0">
                    <form id="shopForm" action="{{ route('shops.update', $shop->id) }}" method="POST" novalidate>
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="shop_name" class="text-uppercase text-secondary">Shop Name <sup class="text-danger">*</sup></label>
                            <input type="text" 
                                   class="form-control @error('shop_name') is-invalid @enderror" 
                                   id="shop_name" 
                                   name="shop_name" 
                                   value="{{ old('shop_name', $shop->shop_name) }}" 
                                   required>
                            <div class="invalid-feedback">Shop name is required!</div>
                            @error('shop_name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="shop_address" class="text-uppercase text-secondary">Address</label>
                            <textarea class="form-control @error('shop_address') is-invalid @enderror" 
                                     id="shop_address" 
                                     name="shop_address" 
                                     rows="3">{{ old('shop_address', $shop->shop_address) }}</textarea>
                            @error('shop_address')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="due_amount" class="text-uppercase text-secondary">Due Amount</label>
                            @if(!$invoiceData == null)
                            
                                <div class="input-group">
                                    <span class="input-group-text">{{  config('app.rupees') }}</span>
                                    <input type="number" 
                                        class="form-control @error('due_amount') is-invalid @enderror" 
                                        id="due_amount" 
                                        name="due_amount" 
                                        value="{{ old('due_amount', $shop->due_amount) }}" 
                                        min="0" 
                                        step="0.01"
                                        placeholder="0.00" readonly>
                                </div>
                            @elseif(optional($paymentData)->paid_amount >0)
                                <div class="input-group">
                                    <span class="input-group-text">{{  config('app.rupees') }}</span>
                                    <input type="number" 
                                        class="form-control @error('due_amount') is-invalid @enderror" 
                                        id="due_amount" 
                                        name="due_amount" 
                                        value="{{ old('due_amount', $shop->due_amount) }}" 
                                        min="0"  
                                        step="0.01"
                                        placeholder="0.00" readonly>
                                </div>

                            @else
                                <div class="input-group">
                                    <span class="input-group-text">{{  config('app.rupees') }}</span>
                                    <input type="number" 
                                        class="form-control @error('due_amount') is-invalid @enderror" 
                                        id="due_amount" 
                                        name="due_amount" 
                                        value="{{ old('due_amount', $shop->due_amount ) }}" 
                                        min="0" 
                                        step="0.01"
                                        placeholder="0.00" >
                                </div>
                            @endif
                            <small class="form-text text-muted">Current due amount</small>
                            @error('due_amount')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="mobile_number" class="text-uppercase text-secondary">Mobile Number<sup class="text-danger">*</sup></label>
                            <input type="text" 
                                   class="form-control @error('mobile_number') is-invalid @enderror" 
                                   id="mobile_number" 
                                   name="mobile_number" 
                                   value="{{ old('mobile_number', $shop->mobile_number) }}" 
                                   placeholder="+1234567890" required>
                            <small class="form-text text-muted">Example: 2345678901</small>
                            @error('mobile_number')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mt-4 text-end">
                             <a href="{{ route('shops.index') }}" class="btn btn-danger">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Shop
                            </button>
                           
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form validation
            const form = document.getElementById('shopForm');
            
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    </script>
    @endpush
@endsection
