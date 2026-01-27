@extends('Admin.layouts.master')
@section('source', 'Shops')
@section('page-title', 'Shop Details')

@section('title')
{{ config('app.name') }} - Shop Details
@endsection

@section('content')
<style>
    .icon-shape-shru{
        min-width: 48px;
        min-height: 48px;
    }
</style>

<div class="container-fluid py-4">
    <div class="row mx-0 w-100">
        <div class="col-12 px-0">
            <div class="bg-white p-3 rounded-3  mb-4 px-0">
                <div class="card-header px-3 d-flex justify-content-between align-items-center flex-md-nowrap flex-wrap">
                    <h4 class="card-title">Shop Details</h4>
                    <div class="mt-md-0 mt-2">
                        <form id="delete-form-{{ $shop->id }}" action="{{ route('shops.destroy', $shop->id) }}"
                            method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                        </form>
                        <button type="button" class="btn btn-sm btn-danger me-2" onclick="confirmDelete({{ $shop->id }})"
                            data-bs-toggle="tooltip" data-bs-original-title="Delete">Delete Shop
                            {{-- <i class="fas fa-trash"></i> Delete Shop --}}
                        </button>

                        <a href="{{ route('shops.edit', $shop->id) }}" class="btn btn-sm btn-primary me-2">
                            <i class="fas fa-edit me-2"></i> Edit
                        </a>
                        <a href="{{ route('shops.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="mt-4 pt-0 pb-2">
                    <div class="row w-100 mx-0">
                        <div class="col-md-3">
                            <div class="d-flex flex-column h-100">
                                <h5 class="text-uppercase text-muted mb-3">Shop Information</h5>
                                <div class="d-flex flex-column">
                                    <div class="d-flex align-items-center mb-3">
                                        <div
                                            class="icon icon-shape icon-shape-shru bg-gradient-info rounded-circle text-white text-center me-3">
                                            <i class="fas fa-id-badge"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Shop ID</h6>
                                            <p class="text-sm mb-0">{{ $shop->id }}</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <div
                                            class="icon icon-shape icon-shape-shru bg-gradient-primary rounded-circle text-white text-center me-3">
                                            <i class="fas fa-store"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Shop Name</h6>
                                            <p class="text-sm mb-0" style="word-break: break-all;">{{ $shop->shop_name }}</p>
                                        </div>
                                    </div>


                                    @if($shop->shop_address)
                                    <div class="d-flex align-items-center mb-3">
                                        <div
                                            class="icon icon-shape icon-shape-shru bg-gradient-info rounded-circle text-white text-center me-3">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Address</h6>
                                            <p class="text-sm mb-0">{{ $shop->shop_address }}</p>
                                        </div>
                                    </div>
                                    @endif

                                    @if ($shop->mobile_number)
                                    <div class="d-flex align-items-center mb-3">
                                        <div
                                            class="icon icon-shape icon-shape-shru bg-gradient-success rounded-circle text-white text-center me-3">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Mobile Number</h6>
                                            <p class="text-sm mb-0">{{ $shop->mobile_number }}</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-9 shadow rounded-3">
                            <div class=" p-3  h-100 px-0">
                                <div class="card-header px-3">
                                    <h5 class="mb-0">Additional Information</h5>
                                </div>
                                <div class="p-3">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item px-0 py-2 d-flex justify-content-between">
                                            <span class="text-sm">Created</span>
                                            <span
                                                class="text-sm font-weight-bold">{{ $shop->created_at->format('M d, Y') }}</span>
                                        </li>
                                        <li class="list-group-item px-0 py-2 d-flex justify-content-between">
                                            <span class="text-sm">Last Updated</span>
                                            <span
                                                class="text-sm font-weight-bold">{{ $shop->updated_at->format('M d, Y') }}</span>
                                        </li>
                                        <li
                                            class="list-group-item px-0 py-2 d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="text-sm">Due Amount</span>
                                                <span
                                                    class="d-block font-weight-bold due-amount">{{ config('app.rupees') }}{{ number_format($shop->due_amount, 2) }}</span>
                                            </div>
                                            @if ($shop->due_amount > 0)
                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="modal" data-bs-target="#updateDueAmountModal">
                                                <i class="fas fa-edit"></i>Pay
                                            </button>
                                            @else
                                            <span class="badge bg-gradient-success">completed</span>
                                            @endif
                                        </li>
                                        {{-- <li class="list-group-item px-0 py-2 d-flex justify-content-between">
                                                <span class="text-sm">Status</span>
                                                <span class="badge bg-gradient-success">Active</span>
                                            </li> --}}


                                    </ul>
                                    <h5>Payment History</h5>
                                    <div class="table-responsive">
                                        <table class="table table-sm align-middle" style="width:100%; font-size:13px;">
                                            <thead>
                                                <tr>
                                                    <td class="text-center"><b>Date</b></td>
                                                    <td class="text-center"><b>Payment For</b></td>
                                                    <td class="text-center"><b>Remark</b></td>
                                                    <td class="text-center"><b>Total Amount</b></td>
                                                    <td class="text-center"><b>Paid Amount</b></td>
                                                    <td class="text-center"><b>Due Amount</b></td>
                                                    <td class="text-center"><b>Actions</b></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($data->isNotEmpty())
                                                @foreach ($data as $transection)
                                                <tr>
                                                    <td class="text-center">
                                                        {{ $transection->created_at->format('M d, Y') }}
                                                    </td>
                                                    <td class="text-center">{{ $transection->payment_from }}
                                                    </td>
                                                    <td class="text-center text-wrap" style="white-space: normal; word-wrap: break-word; max-width: 250px; min-width: 150px;">
                                                        {{$transection->remark ?? ''}}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ config('app.rupees') }}{{ $transection->paid_amount + ($transection->due_amount ?? 0) }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ config('app.rupees') }}{{ $transection->paid_amount }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ config('app.rupees') }}{{ $transection->due_amount }}
                                                    </td>
                                                    <td class="text-center">
                                                       <button type="button"
                                                                    class="btn mb-0 btn-sm btn-info"
                                                                    onclick="printReceipt({
                                                                        id: {{ $transection->id }},
                                                                        shopId: {{ $shop->id }},
                                                                        shopName: '{{ addslashes($shop->shop_name) }}',
                                                                        date: '{{ $transection->created_at->format('M d, Y') }}',
                                                                        paymentFrom: '{{ addslashes($transection->payment_from) }}',
                                                                        remark: '{{ addslashes($transection->remark ?? 'N/A') }}',
                                                                        totalAmount: {{ $transection->paid_amount + ($transection->due_amount ?? 0) }},
                                                                        paidAmount: {{ $transection->paid_amount }},
                                                                        dueAmount: {{ $transection->due_amount }}
                                                                    })">
                                                                <i class="fas fa-print"></i> Print
                                                            </button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @else
                                                <tr class="text-center">
                                                    <td class="text-center" colspan="7">Payment history not
                                                        available!</td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="card-footer">
                        <div class="d-flex justify-content-end"> --}}
                {{-- <form id="deleteForm" action="{{ route('shops.destroy', $shop->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="button" id="deleteButton" class="btn btn-danger">
                    <i class="fas fa-trash me-1"></i> Delete Shop
                </button>
                </form> --}}
                {{-- <form id="delete-form-{{ $shop->id }}" action="{{ route('shops.destroy', $shop->id) }}"
                method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                </form>
                <button type="button" class="btn btn-danger " onclick="confirmDelete({{ $shop->id }})"
                    data-bs-toggle="tooltip" data-bs-original-title="Delete">
                    <i class="fas fa-trash"></i>Delete Shop
                </button>
                --}}
                {{-- </div>
                    </div> --}}
            </div>
        </div>
    </div>
</div>

<!-- Update Due Amount Modal -->
<div class="modal fade" id="updateDueAmountModal" tabindex="-1" role="dialog"
    aria-labelledby="updateDueAmountModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateDueAmountModalLabel">Update Due Amount</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateDueAmountForm" action="{{ route('shops.update-due-amount', $shop->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="due_amount" class="form-label">Pay due amount ({{ config('app.rupees') }})
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">{{ config('app.rupees') }}</span>
                            <input type="number" class="form-control @error('due_amount') is-invalid @enderror"
                                id="due_amount" name="due_amount" step="0.01" min="0" max="{{ $shop->due_amount }}"
                                required>
                            @error('due_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="form-text text-muted">Enter the updated due amount for this shop.</small>
                    </div>
                    <div class="form-group">
                        <label for="due_amount" class="form-label">Remark</label>
                        <textarea class="form-control" name="remark" rows="3"></textarea>

                        @error('remark')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Due Amount</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Hidden iframe for printing (created once) --}}
<iframe id="__receiptPrintIframe" style="display:none;"></iframe>

@push('scripts')
<script>
    const rupeesSymbol = '{{ config('
    app.rupees ') }}';
    const appName = '{{ config('
    app.name ') }}';
    const INR = new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR', minimumFractionDigits: 2 });

    const rupees = (v) => INR.format(v);

    const getPrintDateTime = () => {
        const d = new Date();
        const day = String(d.getDate()).padStart(2, '0');
        const month = String(d.getMonth() + 1).padStart(2, '0');
        const year = String(d.getFullYear()).slice(-2);
        const time = d.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true }).replace(/ AM| PM/i, m => m.toUpperCase());
        return `${day}/${month}/${year} - ${time}`;
    };

    /** --------------------------------------------------------------
     *  Print receipt – 80 mm thermal-printer layout
     *  -------------------------------------------------------------- */
    // Re-use the same iframe for every print (created once)
    const getPrintIframe = () => {
        let iframe = document.getElementById('__receiptPrintIframe');
        if (!iframe) {
            iframe = document.createElement('iframe');
            iframe.id = '__receiptPrintIframe';
            iframe.style.position = 'fixed';
            iframe.style.right = iframe.style.bottom = '0';
            iframe.style.width = iframe.style.height = '0';
            iframe.style.border = 'none';
            iframe.style.visibility = 'hidden';
            document.body.appendChild(iframe);
        }
        return iframe;
    };

    const waitForIframe = (iframe) => new Promise(resolve => {
        if (iframe.contentDocument.readyState === 'complete') return resolve();
        iframe.onload = resolve;
    });

    // -------------------------------------------------------------------------
    // 2. Receipt HTML generator (same style as Bill History)
    // -------------------------------------------------------------------------
    const receiptHTML = (payload) => {
        const {
            id, shopId, shopName, date, paymentFrom, remark,
            totalAmount, paidAmount, dueAmount
        } = payload;

        const printDateTime = getPrintDateTime();

        return `
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Receipt – ${shopName}</title>
           <style>
               /* ---------- 80 mm paper ---------- */
                            @page { size: 80mm auto; margin: 0mm; }
                            body {
                                font-family: "Courier New", monospace;
                                font-size: 13pt;
                                line-height: 1.4;
                                margin: 0;
                                padding: 5mm;
                                padding-top:1rem !important;
                                width: 80mm;               /* 80 mm – 5 mm left + 5 mm right */
                                box-sizing: border-box;
                                margin-left:auto;
                                margin-right:auto;
                            }

                            .receipt { width: 100%; }

                            .header { text-align: center; margin-bottom: 0mm; }
                            .header h2 { margin: 0; font-size: 12pt; }
                            .header p  { margin: 2mm 0; font-size: 11pt;font-weight:600; }

                            table { width: 100%; border-collapse: collapse; margin: 1mm 0; }
                            th, td { padding: 1.5mm 0; font-size: 11pt;font-weight:600; }
                            th { text-align: left; font-weight: bold; }
                            .amt { text-align: right; }

                            .footer { margin-top: 4mm; text-align: center; font-size: 9pt;font-weight:600; }

                            @media print {
                                body { -webkit-print-color-adjust: exact; }
                                .no-print { display: none; }
                            }
            </style>
        </head>
        <body>
            <div class="receipt">
                <div class="header">
                    <h2>Payment Receipt</h2>
                    <p>Printed: ${printDateTime}</p>
                </div>

                <table>
                    <tr><th>Shop</th><td style="word-break: break-all;">${shopName} - ${shopId}</td></tr>
                    <tr><th>Txn ID</th><td>${id}</td></tr>
                    <tr><th>Paid For</th><td>${paymentFrom}</td></tr>
                    <tr><th>Remark</th><td>${remark}</td></tr>
                </table>

                <table>
                    <tr><th>Total</th><td class="amt"><strong>${rupees(totalAmount)}</strong></td></tr>
                    <tr><th>Paid</th><td class="amt">${rupees(paidAmount)}</td></tr>
                    <tr><th>Due</th><td class="amt">${rupees(dueAmount)}</td></tr>
                </table>

                <div class="footer">
                    <p>Thank you for your payment!</p>
                    <p>Computer-generated receipt.</p>
                </div>
            </div>
        </body>
        </html>`;
    };

    // -------------------------------------------------------------------------
    // 3. Public print function – identical to printBill() from the first file
    // -------------------------------------------------------------------------
    window.printReceipt = async function (payload) {
        const iframe = getPrintIframe();
        const doc = iframe.contentDocument || iframe.contentWindow.document;

        doc.open();
        doc.write(receiptHTML(payload));
        doc.close();

        await waitForIframe(iframe);

        setTimeout(() => {
            const win = iframe.contentWindow;
            win.focus();
            win.print();

            // safety-net – remove iframe after 2 min
            setTimeout(() => {
                if (document.getElementById('__receiptPrintIframe')) {
                    document.getElementById('__receiptPrintIframe').remove();
                }
            }, 120_000);
        }, 800);
    };
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Delete confirmation
        const deleteButton = document.getElementById('deleteButton');
        const deleteForm = document.getElementById('deleteForm');

        if (deleteButton && deleteForm) {
            deleteButton.addEventListener('click', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteForm.submit();
                    }
                });
            });
        }

        // Update Due Amount Form Submission
        const updateDueAmountForm = document.getElementById('updateDueAmountForm');
        if (updateDueAmountForm) {
            updateDueAmountForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const url = this.action;
                const submitButton = this.querySelector('button[type="submit"]');
                const originalButtonText = submitButton.innerHTML;

                // Show loading state
                submitButton.disabled = true;
                submitButton.innerHTML =
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...';
                formData.append('_method', 'PUT');

                fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            //'Content-Type': 'application/json',
                        },
                        // body: JSON.stringify({
                        //     due_amount: formData.get('due_amount'),
                        //     _method: 'PUT'
                        // })
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update the displayed due amount
                            document.querySelector('.due-amount').textContent = {
                                {
                                    config('app.rupees')
                                }
                            } + data.due_amount;

                            // Close the modal
                            const modal = bootstrap.Modal.getInstance(document.getElementById(
                                'updateDueAmountModal'));
                            if (modal) {
                                modal.hide();
                            }

                            // Show success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: data.message,
                                timer: 2000,
                                showConfirmButton: false
                            });

                            // Close the modal
                            const modal = bootstrap.Modal.getInstance(document.getElementById(
                                'updateDueAmountModal'));
                            if (modal) {
                                modal.hide();
                            }
                        } else {
                            throw new Error(data.message || 'Failed to update due amount');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: error.message ||
                                'An error occurred while updating the due amount. Please try again.',
                        });
                    })
                    .finally(() => {
                        // Reset button state
                        submitButton.disabled = false;
                        submitButton.innerHTML = originalButtonText;
                    });
            });

            // Reset form when modal is closed
            const modal = document.getElementById('updateDueAmountModal');
            if (modal) {
                modal.addEventListener('hidden.bs.modal', function() {
                    updateDueAmountForm.reset();
                    // Reset validation errors
                    const errorElements = modal.querySelectorAll('.is-invalid, .invalid-feedback');
                    errorElements.forEach(el => el.remove());
                });
            }
        }
    });
</script>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('delete-form-' + id);
                if (form) {
                    form.submit();
                } else {
                    console.error('Delete form not found for ID:', id);
                    Swal.fire(
                        'Error!',
                        'Could not find the form to submit. Please try again.',
                        'error'
                    );
                }
            }
        });
    }
</script>
@endpush

@endsection