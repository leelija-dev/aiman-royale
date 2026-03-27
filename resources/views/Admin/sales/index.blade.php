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


</div>
@endsection
