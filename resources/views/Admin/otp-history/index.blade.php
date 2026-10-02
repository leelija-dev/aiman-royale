@extends('Admin.layouts.master')
@section('source', 'Registration OTP History')
@section('page-title', 'Registration OTP History')

@section('title')
{{ config('app.name') }} - Registration OTP History
@endsection


@section('content')
<div class="container-fluid py-4">
    {{-- OTP Summary Cards --}}
<div class="row mb-4">

    {{-- Total OTP --}}
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body p-3">
                <div class="row">

                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-uppercase font-weight-bold">
                                Total OTP
                            </p>

                            <h5 class="font-weight-bolder mb-0">
                                {{ $totalOtp }}
                            </h5>
                        </div>
                    </div>

                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-primary shadow text-center border-radius-md">
                            <i class="fa-solid fa-key text-white"></i>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    {{-- Sent OTP --}}
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body p-3">
                <div class="row">

                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-uppercase font-weight-bold">
                                OTP Sent
                            </p>

                            <h5 class="font-weight-bolder mb-0">
                                {{ $sentOtp }}
                            </h5>
                        </div>
                    </div>

                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-success shadow text-center border-radius-md">
                            <i class="fa-solid fa-paper-plane text-white"></i>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    {{-- Failed OTP --}}
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body p-3">
                <div class="row">

                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-uppercase font-weight-bold">
                                OTP Failed
                            </p>

                            <h5 class="font-weight-bolder mb-0">
                                {{ $failedOtp }}
                            </h5>
                        </div>
                    </div>

                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-danger shadow text-center border-radius-md">
                            <i class="fa-solid fa-circle-exclamation text-white"></i>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex flex-wrap flex-lg-nowrap justify-content-between align-items-center">
                <!-- Search Form -->
                <form method="GET" action="{{ route('registration-otp-history.index') }}" class="mb-2 mb-md-0 d-flex w-100 w-lg-50 ">
                    <div class="d-flex gap-2 col-12 flex-sm-nowrap flex-wrap justify-content-sm-start justify-content-end">
                        <input type="text" name="search" class="form-control me-2" style="height:40px;width:100%;"
                            placeholder="Search by email,phone,status,message,failed reason....." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary me-2 mb-sm-3 mb-1"
                            style="height:40px;">Search</button>
                        <a href="{{ route('registration-otp-history.index') }}" class="btn btn-danger mb-sm-3 mb-1"
                            style="height:40px;">Reset</a>
                    </div>
                </form>

            </div>
            <div class="card px-4 pt-2 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Sl No</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Send To</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Status</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Message</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Failed Reason (if otp failed)</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Sent At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($allOtp as $otp)
                            <tr>
                                <td class="text-center">
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            
                                          {{ $allOtp->firstItem() + $loop->index }}
                                            
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex px-2 py-1">
                                        {{$otp->otp_send_to ? $otp->otp_send_to : ''}}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ $otp->status == 'sent' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $otp->status == 'sent' ? 'Sent' : 'Failed' }}
                                            </span>
                                </td>
                                <td class="text-center">
                                    <div class="px-2 py-1" style="font-size: 12px !important;">
                                        {!! wordwrap(e($otp->message ?? ''), 40, '<br>', true) !!}
                                    </div>
                                </td>
                                <td class="text-center">
    <div class="d-flex px-2 py-1 justify-content-center">

        @if($otp->failed_reason)
            <button
                type="button"
                class="btn btn-sm btn-outline-primary mb-0"
                data-bs-toggle="modal"
                data-bs-target="#failedReasonModal"
                data-reason="{{ $otp->failed_reason }}"
            >
                <i class="fas fa-eye me-1"></i>
                View
            </button>
        @else
            <span class="text-muted">-</span>
        @endif

    </div>
</td>
                                <td class="text-center">
                                    <div class="d-flex px-2 py-1">
                                        
                                            
                                               {{ $otp->created_at->format('d-m-Y h:i A') }}
                                            
                                        
                                    </div>
                                </td>
                               
                            </tr>
                            @empty
                            <tr>
                                <td colspan="11" class="text-center py-4">
                                    <p class="text-muted">Registration otp not found.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    <div>
                        {{ $allOtp->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Failed Reason Modal -->
<div class="modal fade" id="failedReasonModal" tabindex="-1"
     aria-labelledby="failedReasonModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="failedReasonModalLabel">
                    <i class="fas fa-circle-exclamation text-danger me-2"></i>
                    OTP Failed Reason
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                </button>
            </div>

            <div class="modal-body">
                <div class="alert text-red mb-0">
                    <span id="failedReasonText"></span>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button"
                        class="btn btn-secondary mb-0"
                        data-bs-dismiss="modal">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const failedReasonModal = document.getElementById('failedReasonModal');

    failedReasonModal.addEventListener('show.bs.modal', function (event) {

        const button = event.relatedTarget;

        const reason = button.getAttribute('data-reason');

        document.getElementById('failedReasonText').textContent = reason || 'No failed reason available.';
    });

});
</script>
@endsection