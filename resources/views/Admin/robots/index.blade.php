@extends('Admin.layouts.master')

@section('source', 'Robots')
@section('page-title', 'Robots')

@section('title')
    {{ config('app.name') }} - Robots
@endsection

<style>
    .hr-line {
        border-top: 2px solid #0408382d !important;
        opacity: 1 !important;
    }
</style>

@section('content')

<div class="container-fluid py-4">

    <div class="col-12">

        <div class="card mb-4">

            <div class="card-header px-5 pb-0">
                <h6>Robots.txt</h6>
            </div>

            <div class="card px-5 pt-2 pb-3">

                {{-- Success message --}}
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif


                {{-- Currently uploaded file --}}
                @if($robotsFile)

                    <div class="mb-4">

                        <label class="form-label fw-bold">
                            Current File
                        </label>

                        <div class="border rounded p-3">

                            <div class="d-flex justify-content-between align-items-center">

                                <div>
                                    <div class="fw-bold">
                                        <i class="fas fa-file-alt me-2"></i>
                                        {{ $robotsFile['name'] }}
                                    </div>

                                    <small class="text-muted">
                                        Size:
                                        {{ number_format($robotsFile['size'] / 1024, 2) }} KB

                                        &nbsp; | &nbsp;

                                        Updated:
                                        {{ date('d M Y h:i A', $robotsFile['updated_at']) }}
                                    </small>
                                </div>

                                <div>
                                    <a href="{{ url('/robots.txt') }}"
                                       target="_blank"
                                       class="btn btn-sm btn-info">
                                        <i class="fas fa-eye me-1"></i>
                                        View
                                    </a>
                                </div>

                            </div>

                        </div>

                    </div>

                    <hr class="hr-line">

                @else

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        No robots.txt file has been uploaded yet.
                    </div>

                @endif


                {{-- Upload / Update --}}
                <form action="{{ route('robots.store') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      novalidate>

                    @csrf

                    <div class="row">

                        <div class="col-12 mb-3">

                            <label for="robots_file" class="form-label">
                                {{ $robotsFile ? 'Update robots.txt' : 'Upload robots.txt' }}
                            </label>

                            <input
                                type="file"
                                class="form-control"
                                id="robots_file"
                                name="robots_file"
                                accept=".txt"
                                required
                            >

                            @error('robots_file')
                                <div class="text-danger small">
                                    {{ $message }}
                                </div>
                            @enderror

                            <small class="text-muted">
                                File name must be exactly <strong>robots.txt</strong>.
                            </small>

                        </div>

                    </div>


                    <div class="row">

                        <div class="col-12 text-end">

                            <a href="{{ route('robots.index') }}"
                               class="btn btn-danger">
                                <i class="fas fa-times me-2"></i>
                                Cancel
                            </a>

                            <button type="submit" class="btn btn-primary">

                                @if($robotsFile)
                                    <i class="fas fa-sync-alt me-2"></i>
                                    Update robots.txt
                                @else
                                    <i class="fas fa-upload me-2"></i>
                                    Upload robots.txt
                                @endif

                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection