@extends('Admin.layouts.master')

@section('title', 'Edit Sale')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Edit Sale</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.sales.index') }}">Sales</a></li>
                        <li class="breadcrumb-item active">Edit</li>
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
                            <h3 class="card-title">Edit Sale: {{ $sale->name }}</h3>
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

                            <form action="{{ route('admin.sales.update', $sale->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Sale Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name" 
                                                   value="{{ old('name', $sale->name) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="discount_percentage">Discount Percentage (%)</label>
                                            <input type="number" class="form-control" id="discount_percentage" 
                                                   name="discount_percentage" value="{{ old('discount_percentage', $sale->discount_percentage) }}" 
                                                   min="0" max="100" step="0.01">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="starts_at">Start Date</label>
                                            <input type="datetime-local" class="form-control" id="starts_at" 
                                                   name="starts_at" value="{{ old('starts_at', $sale->starts_at ? $sale->starts_at->format('Y-m-d\TH:i') : '') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="ends_at">End Date</label>
                                            <input type="datetime-local" class="form-control" id="ends_at" 
                                                   name="ends_at" value="{{ old('ends_at', $sale->ends_at ? $sale->ends_at->format('Y-m-d\TH:i') : '') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" id="description" name="description" 
                                                      rows="3">{{ old('description', $sale->description) }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="banner_image">Banner Image</label>
                                            <input type="file" class="form-control" id="banner_image" 
                                                   name="banner_image" accept="image/*">
                                            @if($sale->banner_image)
                                                <div class="mt-2">
                                                    <img src="{{ asset('uploads/sales/' . $sale->banner_image) }}" 
                                                         alt="{{ $sale->name }}" style="max-width: 200px; max-height: 100px;">
                                                    <br>
                                                    <small class="form-text text-muted">Current image: {{ $sale->banner_image }}</small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="is_active" 
                                                       name="is_active" value="1" {{ old('is_active', $sale->is_active) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active">
                                                    Active
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="products">Select Products <span class="text-danger">*</span></label>
                                            <select class="form-control" id="products" name="products[]" multiple>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}" 
                                                            {{ in_array($product->id, $selectedProducts) ? 'selected' : '' }}>
                                                        {{ $product->name }} ({{ $product->design_no }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="form-text text-muted">Hold Ctrl/Cmd to select multiple products</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Update Sale
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
