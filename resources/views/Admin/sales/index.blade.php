@extends('Admin.layouts.master')
@section('title', 'Fake Orders Management')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Fake Orders Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('Admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Fake Orders</li>
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
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title">Fake Orders List</h3>
                                <div class="d-flex gap-2">
                                    <form method="GET" action="{{ route('admin.sales.index') }}" class="d-flex">
                                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search orders..." value="{{ request('search') }}">
                                        <button type="submit" class="btn btn-outline-secondary btn-sm ml-2">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.sales.create') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i> Create Fake Order
                                    </a>
                                </div>
                            </div>
                            <div class="mt-2">
                                <span class="badge badge-info">Total: {{ $sales->total() }}</span>
                                @if(request('search'))
                                    <span class="badge badge-secondary">Search: {{ request('search') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                            @endif

                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Products</th>
                                        <th>Total Amount</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($sales))
                                    @foreach($sales as $sale)
                                    <tr>
                                        <td>{{ $sale->id }}</td>
                                        <td>{{ $sale->user_id ?? 'N/A' }}</td>
                                        <td>
                                            @if($sale->orderProducts && $sale->orderProducts->isNotEmpty())
                                                @foreach($sale->orderProducts as $item)
                                                    @if($item && $item->product)
                                                    <div class="mb-1">
                                                        <strong>{{ $item->product->name ?? 'Unknown Product' }}</strong><br>
                                                        <small class="text-muted">
                                                            {{ $item->product->design_no ?? 'N/A' }} |
                                                            Qty: {{ $item->quantity ?? 0 }} |
                                                            Price: {{ $item->price ?? 0 }}
                                                        </small>
                                                    </div>
                                                    @endif
                                                @endforeach
                                            @else
                                                <span class="text-muted">No products</span>
                                            @endif
                                        </td>
                                        <td>{{ $sale->total_amount ?? 0 }}</td>
                                        <td>
                                            <span class="badge badge-{{ $sale->order_status == 'completed' ? 'success' : 'warning' }}">
                                                {{ $sale->order_status ?? 'pending' }}
                                            </span>
                                        </td>
                                        <td>{{ $sale->created_at ? $sale->created_at->format('M d, Y H:i') : 'N/A' }}</td>

                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="7" class="text-center">No fake orders found.</td>
                                    </tr>
                                    @endif
                                </tbody>

                            </table>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="text-muted">
                                    Showing {{ $sales->firstItem() ?? 0 }} to {{ $sales->lastItem() ?? 0 }} of {{ $sales->total() }} entries
                                    @if(request('search'))
                                        (filtered from search: "{{ request('search') }}")
                                    @endif
                                </div>
                                <div>
                                    {{-- Debug info - remove this once pagination works --}}
                                    {{-- 
                                    @php
                                        dump([
                                            'hasPages' => $sales->hasPages(),
                                            'currentPage' => $sales->currentPage(),
                                            'lastPage' => $sales->lastPage(),
                                            'total' => $sales->total(),
                                            'perPage' => $sales->perPage(),
                                            'count' => $sales->count()
                                        ]);
                                    @endphp
                                    --}}
                                    @if($sales->hasPages())
                                        {{ $sales->links() }}
                                    @endif
                                </div>
                            </div>
                            @if(request('search'))
                            <div class="mt-2">
                                <a href="{{ route('admin.sales.index') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-times"></i> Clear Search
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



</div>
@endsection