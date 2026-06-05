@extends('Admin.layouts.master')

@section('source', 'Contact')
@section('page-title', 'Contact Details')

@section('content')

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Contact Details</h5>
                </div>

                <div class="card-body">

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Name</div>
                        <div class="col-md-8">{{ $contact->name }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Email</div>
                        <div class="col-md-8">{{ $contact->email }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Mobile</div>
                        <div class="col-md-8">{{ $contact->mobile }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Inquiry Type</div>
                        <div class="col-md-8">{{ $contact->inquiry_type }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Message</div>
                        <div class="col-md-8">
                            {!! nl2br(e($contact->message)) !!}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Submitted On</div>
                        <div class="col-md-8">
                            {{ $contact->created_at->format('d M Y h:i A') }}
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('admin.contact') }}" class="btn btn-secondary">
                            Back
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection