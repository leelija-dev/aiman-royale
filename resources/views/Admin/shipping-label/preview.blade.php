@extends('Admin.layouts.master')

@section('page-title', 'Shipping Label Preview')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6>Shipping Label Preview - {{ $waybill }}</h6>
                </div>
                <div class="card-body">
                    <pre style="background: #f5f5f5; padding: 20px; border-radius: 5px; max-height: 600px; overflow: auto;">
                        {{ json_encode($data, JSON_PRETTY_PRINT) }}
                    </pre>
                    
                    <div class="mt-3">
                        <a href="{{ route('shipping-label.generate', ['waybill' => $waybill, 'format' => 'pdf']) }}" 
                           class="btn btn-primary" target="_blank">
                            <i class="fas fa-file-pdf me-1"></i> Download PDF
                        </a>
                        <a href="{{ route('shipping-label.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection