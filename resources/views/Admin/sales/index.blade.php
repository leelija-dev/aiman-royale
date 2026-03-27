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
                            <h3 class="card-title">Fake Orders List</h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.sales.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Create Fake Order
                                </a>
                                <span class="badge badge-info">Total: {{ $sales->total() }}</span>
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
                                        <!-- <th>Actions</th> -->
                                    </tr>
                                </thead>
                                
                        </table>


                        {{ $sales->links() }}
                    </div>
                </div>
            </div>
        </div>
</div>
</section>



</div>
@endsection