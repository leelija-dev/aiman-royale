@extends('Admin.layouts.master')
@section('source', 'Bill History')
@section('page-title', 'Print Bill')
@section('title')
{{config('app.name')}} - Bill History
@endsection

@section('content')

<style>
    .cash-memo {
        padding: 0;

        max-width: $ {
            paperWidth
        }

        ;
        margin: auto;
        font-family: Arial,
        sans-serif;

        font-size: $ {
            fontSize
        }

        ;
    }

    .cash-memo h5 {
        text-align: center;
        font-weight: bold;
        border-bottom: 1px dashed #000;
        padding-bottom: 5px;
        margin-bottom: 15px;
        font-size: 14px;
        margin-top: 0px !important;
    }

    .memo-details {
        display: flex;
        justify-content: space-between;
    }

    .memo-details p {
        margin: 0;
        line-height: 1.4;
        font-size: 0.7rem;
    }

    .cash-memo table {
        width: 100%;
        border-collapse: collapse;
    }

    .cash-memo table th {
        text-align: center;
        vertical-align: middle;
        border: 1px solid #000;
        font-size: 9px;
        padding: 3px;
    }

    .cash-memo table td {
        text-align: center;
        vertical-align: middle;
        border: 1px solid #000;
        font-size: 0.7rem;
        padding: 0.4rem 0.2rem;
    }

    .no-border {
        border-top: none !important;
        border-bottom: none !important;
    }

    .amount-box {
        font-weight: bold;
    }

    .amount-text {
        font-family: Arial, sans-serif;
        font-size: 0.5rem;
    }

    #receipt p,
    #receipt span,
    #receipt h1,
    #receipt h2,
    #receipt h3,
    #receipt h4,
    #receipt h5,
    #receipt td,
    #receipt th,
    #receipt tr {
        color: black !important;
    }

    #receipt {
        border-bottom: 1px dashed black;
        padding-bottom: 6px;
    }

    .footer {
        text-align: center !important;
        display: none !important;
    }

    .footer p {
        font-size: 11px !important;
        margin-bottom: 5px !important;
    }

    #receipt p,
    #receipt span,
    #receipt h1,
    #receipt h2,
    #receipt h3,
    #receipt h4,
    #receipt h5,
    #receipt td,
    #receipt th,
    #receipt tr {
        color: black !important;
    }

    .cash-memo h5 {
        font-size: 14px;
        border-bottom: 1px dashed #000;
        margin-top: 0px !important;
    }

    .cash-memo {
        padding: 0;

        max-width: $ {
            paperWidth
        }

        ;
        margin: auto;

        font-size: $ {
            fontSize
        }

        ;
    }

    .cash-memo table {
        width: 100% !important;
        border-collapse: collapse !important;
    }

    .cash-memo table th {
        text-align: center;
        vertical-align: middle;
        border: 1px solid #000;
        font-size: 9px;
        padding: 3px;
    }

    .cash-memo table td {
        text-align: center;
        vertical-align: middle;
        border: 1px solid #000;
        font-size: 0.7rem;
        padding: 0.4rem 0.2rem;
    }

    .memo-details {
        display: flex;
        justify-content: space-between;
    }

    .memo-details p {
        line-height: 1.2 !important;
    }

    .amount-text,
    .amount-box {
        font-size: $ {
            fontSize
        }

        !important;
    }

    .amount-text span {
        font-size: 20px !important;
    }

    .cash-memo td span {
        font-weight: 600 !important;
    }

    .footer {
        text-align: center !important;
        display: none !important;
    }

    .footer p {
        font-size: 11px !important;
        margin-bottom: 5px !important;
    }

    #receipt {
        border-bottom: 1px dashed black;
        padding-bottom: 6px;
    }
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="p-4">
                    <div class="col-12 d-flex flex-md-nowrap flex-wrap gap-2 justify-content-between">
                        <form method="GET" action="{{ route('admin.print-bill') }}" class="col-lg-6 col-md-9 col-12 d-flex  gap-2 flex-sm-nowrap flex-wrap justify-content-sm-start justify-content-end">
                            <div class="w-100">
                                <input type="text" name="search" class="form-control" placeholder="Search by Bill ID and Shop Name"
                                    value="{{ request('search') }}">

                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary mb-0 ">Search</button>
                            </div>
                            <div>
                                <a href="{{ route('admin.print-bill') }}" class="btn btn-danger mb-0">Reset</a>
                            </div>
                        </form>
                        <div class="w-100 w-md-auto">
                            <a href="{{ route('admin.new-bill') }}" class="btn btn-primary ms-sm-0 w-100 w-md-auto">
                                <i class="fa-solid fa-receipt"></i> New Bill
                            </a>
                        </div>
                    </div>



                    <div class="table-responsive">
                        <table class="table align-middle mb-0" id="billsTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-8 text-center">Bill ID</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-8 text-center">Date</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-8 text-center">shop Name</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-8 text-center">Items</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-8 text-center">Total (INR)</th>
                                    {{-- <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-8 text-center">Discount</th> --}}
                                    {{-- <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-8 text-center">Discount Amount</th> --}}
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-8 text-center">Paid Amount</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-8 text-center">Due</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-8 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($invoices->isNotEmpty())
                                @foreach($invoices as $invoice)
                              
                                <tr>
                                    <td class="text-center">#{{$invoice->id}}</td>
                                    <td class="text-center">{{date_format($invoice->bill_date, 'd M, Y') ?? $invoice->bill_date}}</td>
                                    <td class="text-center">{{$invoice->shop->shop_name ?? 'Unknown Shop'}}</td>
                                    <td class="text-center">{{$invoice->total_items}}</td>
                                    <td class="text-center">{{config('app.rupees')}}{{$invoice->total_amount}}</td>
                                    {{-- <td class="text-center">{{ rtrim(rtrim(number_format($invoice->discount, 2, '.', ''), '0'), '.') }}%</td> --}}
                                    {{-- <td class="text-center">{{config('app.rupees')}}{{$invoice->discount_amount ? $invoice->discount_amount : 0}}</td> --}}
                                    <td class="text-center">{{config('app.rupees')}}{{$invoice->paid_amount ? $invoice->paid_amount : 0}}</td>
                                    <td class="text-center">
                                        {{ config('app.rupees') }}{{ number_format($invoice->total_amount - ($invoice->paid_amount + $invoice->discount_amount), 2) }}
                                    </td>

                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button class="btn btn-outline-primary mb-0" onclick="viewBill({{$invoice->id}})">View</button>
                                            <button class="btn btn-primary mb-0" onclick="printBill({{$invoice->id}})">Print</button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="8" class="text-center">Bill history not available!</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="  mt-3">
                        {{ $invoices->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hidden iframe – will be created automatically, but you can also put it manually -->
<iframe id="__receiptPrintIframe" style="display:none;"></iframe>
</div>

<!-- View Bill Modal -->
<div class="modal fade" id="viewBillModal" tabindex="-1" aria-labelledby="viewBillModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewBillModalLabel">Bill Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="billModalBody">
                <!-- Bill detail content injected by JS -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="printThisBillBtn">Print</button>
            </div>
        </div>
    </div>
</div>

<?php
// Prepare the bills data in PHP
$billsData = [];

foreach ($invoices as $invoice) {
   
    $items = [];
    foreach ($invoice->items as $item) {
        // dd($item); 
        $items[] = [
            'productId' => $item->product_id,
            'productName' => $item->product_name,
            'price' => (float)$item->unit_price,
            'qty' => $item->quantity,//(string) number_format($item->quantity, 2, '.', ''),
            'qty_unit' => $item->quantity_unit,
            'total' => (float)$item->total_amount,
            'sku' => $item->product_sku ?? 'N/A',
            'company' => $item->brand ?? 'N/A'
        ];
    }

// dd($items);


    $billsData[] = [
        'id' => $invoice->id,
        //'customer' => $invoice->shop_id ?? 'Walk-in Customer',
        'customer' => optional($invoice->shop)->shop_name ?? 'Walk-in Customer',
        'date' => $invoice->bill_date,
        'items' => $items,
        //'subtotal' => (float)$invoice->total_amount,
        'totalItems' => $invoice->items->sum('quantity'),
        'paid_amount' => $invoice->paid_amount,
        'date'      => $invoice->created_at,
        'shop_id'   => $invoice->shop_id,
        'shop_name' => optional($invoice->shop)->shop_name,
        'shop_mobile' => optional($invoice->shop)->mobile_number,
        'shop_address' => optional($invoice->shop)->shop_address,
        'discount' => $invoice->discount,
        'total_amount' => $invoice->total_amount,
        'discount_amount' => $invoice->discount_amount,
        //'total_amount' =>(($invoice->total_amount/(100-$invoice->discount))*100)

    ];
}


?>

<script>
    const INR_CURRENCY_FORMAT = new Intl.NumberFormat('en-IN', {
        style: 'currency',
        currency: 'INR',
        minimumFractionDigits: 2
    });

    const RECEIPT_DEFAULTS = {
        paperWidth: '80mm',
        fontSize: '11px'
    };

    const SHOP_DETAILS = {
        name: 'AHAMED STORE',
        number: '131',
        mobile: '7076583469',
        address: 'GOLABARI, GOLABARI BAZAR, SHASAN, NORTH 24 PARGANAS'
    };

    // Convert PHP $billsData to JavaScript (assumed to be JSON-parsed)
    const bills = @json($billsData);
    // Create a Map of products for faster lookup
    const productById = new Map();
    bills.forEach(bill => {
        if (!bill?.items) return;
        bill.items.forEach(item => {
            if (!item?.productId) return;
            if (!productById.has(item.productId)) {
                productById.set(item.productId, {
                    id: item.productId,
                    name: item.productName ?? 'Unknown',
                    price: item.price ?? 0,
                    sku: item.sku ?? '',
                    company: item.company ?? ''
                });
            }
        });
    });

    const currency = (value) => INR_CURRENCY_FORMAT.format(value);

    const billToReceiptHTML = (bill, options = RECEIPT_DEFAULTS) => {
        if (!bill?.items) return '';

        const {
            paperWidth,
            fontSize
        } = {
            ...RECEIPT_DEFAULTS,
            ...options
        };
        const date = new Date(bill.date);

        const rows = bill.items.map((item, index) => {
            console.log(item)
            const product = productById.get(item.productId) || {};
            const unitPrice = item.price ?? 0;
            const lineTotal = unitPrice * (item.qty ?? 0);

            const name = product.sku ?
                `${product.sku} - ${product.name ? product.name : 'Unknown'}` :
                (product.name ? product.name : 'Other');

            return `
            <tr>
                <td class="no-border" style="color:black !important;text-align: center !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 13px !important; font-weight: 600 !important; padding: 0.4rem 0.2rem !important;
">${index + 1}</td>
                <td class="no-border text-start" style="word-break:break-all;text-align:left !important;color:black !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 13px !important; font-weight: 600 !important; padding: 0.4rem 0.2rem !important;
">${name}</td>
                <td class="no-border" style="color:black !important; text-align: center !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 13px !important; font-weight: 600 !important; padding: 0.4rem 0.2rem !important;
">${item.qty ?? 0} ${item.qty_unit}</td>
                <td class="no-border" style="color:black !important; text-align: center !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 13px !important; font-weight: 600 !important; padding: 0.4rem 0.2rem !important;
">${currency(unitPrice)}</td>
                <td class="no-border" style="text-align:right !important;color:black !important;  vertical-align: middle !important; border: 1px solid #000 !important; font-size: 13px !important; font-weight: 600 !important; padding: 0.4rem 0.2rem !important;
">${currency(lineTotal)}</td>
            </tr>
        `;
        }).join('');

        return `
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
            <title>Bill ${bill.id}</title>
            <style>
                /* Reset for print document */
                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                }
                
                body {
                   
                }
                
               

                /* Print styles */
                @media print {
                    @page {
                        size: 80mm auto;
                        margin: 3px;
                        padding: 0;
                    }
                    
                    body {
                       
                    }
                    
                   
                }
            </style>
        </head>
        <body>
            <div class="cash-memo" style=" font-family: Arial, sans-serif;
                    font-weight: 600 !important;width: 100% !important; max-width: 80mm !important; margin: 0 auto !important; padding: 0 !important; border-bottom: 1px dashed black !important; page-break-inside: avoid !important;">
               <div style="text-align:center !important; width:100% important;">
                <h5 style="font-size: 16px !important; border-bottom: 1px dashed #000 !important; margin-top: 0 !important;">CASH MEMO</h5>
               </div>
                <div class="memo-details mb-3" style="gap:0.7rem !important; display:flex !important;margin-bottom:1rem !important;margin-top:1rem !important;">
                    <div style="width:50%;">
                        <p style="font-size:14px !important;color:black !important; line-height: 1.2 !important;"><strong>Name:</strong> ${bill.shop_id ? bill.shop_id + ' - ' : ''}${bill.customer ? (bill.customer.length > 20 ? bill.customer.slice(0, 37) : bill.customer) : 'N/A'}</p>
                        <p style="font-size:14px !important;color:black !important; line-height: 1.2 !important;"><strong>Mobile:</strong> ${bill.shop_mobile ?? 'N/A'}</p>
                        <p style="font-size:14px !important;color:black !important;word-break:break-all;  line-height: 1.2 !important;"><strong>Address:</strong> ${bill.shop_address ?? 'N/A'}</p>
                    </div>
                    <div style="width:50%;">
                        <p style="font-size:14px !important;color:black !important; line-height: 1.2 !important;"><strong>Bill NO:</strong> ${bill.id ?? 'N/A'}</p>
                        <p style="font-size:14px !important;color:black !important; line-height: 1.2 !important;"><strong>Date:</strong> ${date.toLocaleDateString('en-IN')}</p>
                        <p style="font-size:14px !important;color:black !important; line-height: 1.2 !important;"><strong>Time:</strong> ${date.toLocaleTimeString()}</p>
                    </div>
                </div>

                <div style="margin-top:1rem !important;">
                    <table class="w-100" style="margin-bottom:1rem !important;width: 100% !important; border-collapse: collapse !important;">
                        <thead>
                            <tr>
                                <th style="color:black !important;text-align: center !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 12px !important; padding: 3px !important;">NO.</th>
                                <th style="color:black !important;text-align: center !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 12px !important; padding: 3px !important;">NAME</th>
                                <th style="color:black !important;text-align: center !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 12px !important; padding: 3px !important;">QTY</th>
                                <th style="color:black !important;text-align: center !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 12px !important; padding: 3px !important;">RATE</th>
                                <th style="color:black !important;text-align: center !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 12px !important; padding: 3px !important;">TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${rows}
                        </tbody>
                        
                        <tfoot>
                            <tr>
                                <td rowspan="4" colspan="3" class="amount-text " style="color:black !important;border-left:1px solid black !important;border-bottom:1px solid black !important;border-right:none !important;text-align:center !important;">
                                    <strong>Total Payable:</strong><br>
                                    <span class="fw-bold fs-4" style="color:black !important;font-size: 22px !important;font-weight: 600 !important;"> ${currency(bill.total_amount - bill.discount_amount ?? 0)}</span>
                                </td>
                               
                                <td style="color:black !important;text-align: center !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 12px !important; padding: 0.4rem 0.2rem !important;
">Amount</td>
                                <td style="color:black !important;text-align:right !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 12px !important; padding: 0.4rem 0.2rem !important;
">${currency(bill.total_amount)}</td>
                            </tr>
                            <tr>
                                <td style="color:black !important;text-align: center !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 12px !important; padding: 0.4rem 0.2rem !important;
">Paid</td>
                                <td style="color:black !important;text-align:right !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 12px !important; padding: 0.4rem 0.2rem !important;
">${currency(bill.paid_amount)}</td>
                            </tr>
                            <tr>
                                <td class="amount-box" style="color:black !important;text-align: center !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 12px !important; padding: 0.4rem 0.2rem !important;
">Due</td>
                                <td class="amount-box" style="color:black !important;text-align:right !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 12px !important; padding: 0.4rem 0.2rem !important;
">${currency((bill.total_amount - bill.discount_amount) - bill.paid_amount)}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </body>
        </html>
    `;
    };

    const viewBill = (id) => {
        const bill = bills.find(b => b.id === id);
        if (!bill) {
            console.error(`Bill with ID ${id} not found`);
            return;
        }

        // For modal display, use simplified version without full HTML document
        const simplifiedHTML = `
        <div class="cash-memo" style=" font-family: Arial, sans-serif;
                    font-weight: 600 !important;width: 100% !important; max-width: 72mm !important; margin: 0 auto !important; padding: 0 !important; border-bottom: 1px dashed black !important; page-break-inside: avoid !important;">
            <div style="text-align:center !important; width:100% important;">
                <h5 style="font-size: 16px !important;color:black !important; border-bottom: 1px dashed #000 !important; margin-top: 0 !important;">CASH MEMO</h5>
               </div>
            <div class="memo-details mb-3" style="gap:0.7rem !important; display:flex !important;margin-bottom:1rem !important;margin-top:1rem !important;">
                    <div style="width:50%;">
                        <p style="font-size:14px !important;color:black !important; line-height: 1.2 !important;"><strong>Name:</strong> ${bill.shop_id ? bill.shop_id + ' - ' : ''}${bill.customer ? (bill.customer.length > 20 ? bill.customer.slice(0, 37) : bill.customer) : 'N/A'}</p>
                        <p style="font-size:14px !important;color:black !important; line-height: 1.2 !important;"><strong>Mobile:</strong> ${bill.shop_mobile ?? 'N/A'}</p>
                        <p style="font-size:14px !important;word-break:break-all !important;color:black !important; line-height: 1.2 !important;"><strong>Address:</strong> ${bill.shop_address ?? 'N/A'}</p>
                    </div>
                    <div style="width:50%;">
                        <p style="font-size:14px !important;color:black !important; line-height: 1.2 !important;"><strong>Bill NO:</strong> ${bill.id ?? 'N/A'}</p>
                        <p style="font-size:14px !important;color:black !important; line-height: 1.2 !important;"><strong>Date:</strong> ${new Date(bill.date).toLocaleDateString('en-IN')}</p>
                        <p style="font-size:14px !important;color:black !important; line-height: 1.2 !important;"><strong>Time:</strong> ${new Date(bill.date).toLocaleTimeString()}</p>
                    </div>
            </div>

            <div style="margin-top:1rem !important;">
                <table class="w-100" style="margin-bottom:1rem !important;width: 100% !important; border-collapse: collapse !important;">
                    <thead>
                        <tr>
                            <th style="color:black !important;text-align: center !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 12px !important; padding: 3px !important;">NO.</th>
                            <th style="color:black !important;text-align: center !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 12px !important; padding: 3px !important;">NAME</th>
                            <th style="color:black !important;text-align: center !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 12px !important; padding: 3px !important;">QTY</th>
                            <th style="color:black !important;text-align: center !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 12px !important; padding: 3px !important;">RATE</th>
                            <th style="color:black !important;text-align: center !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 12px !important; padding: 3px !important;">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${bill.items.map((item, index) => {
                            const product = productById.get(item.productId) || {};
                            const unitPrice = item.price ?? 0;
                            const lineTotal = unitPrice * (item.qty ?? 0);
                            const name = product.sku ?
                                `${product.sku} - ${product.name ? (product.name.length > 28 ? product.name.slice(0, 28) : product.name) : 'Unknown'}` :
                                (product.name ? (product.name.length > 28 ? product.name.slice(0, 28) : product.name) : 'Other');

                            return `
                            <tr>
                                <td class="no-border" style="color:black !important;text-align: center !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 13px !important; font-weight: 600 !important; padding: 0.4rem 0.2rem !important;
">${index + 1}</td>
                                <td class="no-border text-start" style="color:black !important;text-align: left !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 13px !important; font-weight: 600 !important; padding: 0.4rem 0.2rem !important;
">${name}</td>
                                <td class="no-border" style="color:black !important;text-align: center !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 13px !important; font-weight: 600 !important; padding: 0.4rem 0.2rem !important;
">${item.qty ?? 0} ${item.qty_unit}</td>
                                <td class="no-border" style="color:black !important;text-align: center !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 13px !important; font-weight: 600 !important; padding: 0.4rem 0.2rem !important;
">${currency(unitPrice)}</td>
                                <td class="no-border" style="color:black !important;text-align: center !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 13px !important; font-weight: 600 !important; padding: 0.4rem 0.2rem !important;
">${currency(lineTotal)}</td>
                            </tr>
                        `;
                        }).join('')}
                    </tbody>
                    
                    <tfoot>
                        <tr>
                            <td rowspan="4" colspan="3" class="amount-text " style="color:black !important;border-left:1px solid black !important;border-bottom:1px solid black !important;border-right:none !important;text-align:center !important;">
                                <strong>Total Payable:</strong><br>
                                <span class="fw-bold fs-4" style="color:black !important;font-size: 22px !important;font-weight: 600 !important;"> ${currency(bill.total_amount - bill.discount_amount ?? 0)}</span>
                            </td>
                           
                            <td style="color:black !important;text-align: center !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 12px !important; padding: 0.4rem 0.2rem !important;
">Amount</td>
                            <td style="color:black !important;text-align: right !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 12px !important; padding: 0.4rem 0.2rem !important;
">${currency(bill.total_amount)}</td>
                        </tr>
                        <tr>
                            <td style="color:black !important;text-align: center !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 12px !important; padding: 0.4rem 0.2rem !important;
">Paid</td>
                            <td style="color:black !important;text-align: right !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 12px !important; padding: 0.4rem 0.2rem !important;
">${currency(bill.paid_amount)}</td>
                        </tr>
                        <tr>
                            <td class="amount-box" style="color:black !important;text-align: center !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 12px !important; padding: 0.4rem 0.2rem !important;
">Due</td>
                            <td class="amount-box" style="color:black !important;text-align: right !important; vertical-align: middle !important; border: 1px solid #000 !important; font-size: 12px !important; padding: 0.4rem 0.2rem !important;
">${currency((bill.total_amount - bill.discount_amount) - bill.paid_amount)}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>`;

        const container = document.getElementById('billModalBody');
        if (!container) {
            console.error('Bill modal container not found');
            return;
        }

        container.innerHTML = simplifiedHTML;
        const modalEl = document.getElementById('viewBillModal');
        if (!modalEl) {
            console.error('View bill modal not found');
            return;
        }

        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();

        const printBtn = document.getElementById('printThisBillBtn');
        if (printBtn) {
            printBtn.onclick = () => printBill(id);
        }
    };

    /* -------------------------------------------------------------
   1. PRINT USING A HIDDEN <iframe>
   ------------------------------------------------------------- */
const printBill = (id) => {
    const bill = bills.find(b => b.id === id);
    if (!bill) {
        console.error(`Bill with ID ${id} not found`);
        return;
    }

    // ---- create (or reuse) the hidden iframe -----------------
    let iframe = document.getElementById('__receiptPrintIframe');
    if (!iframe) {
        iframe = document.createElement('iframe');
        iframe.id = '__receiptPrintIframe';
        iframe.style.position = 'fixed';
        iframe.style.right = '0';
        iframe.style.bottom = '0';
        iframe.style.width = '0';
        iframe.style.height = '0';
        iframe.style.border = 'none';
        iframe.style.visibility = 'hidden';
        document.body.appendChild(iframe);
    }

    const doc = iframe.contentDocument || iframe.contentWindow.document;
    doc.open();
    doc.write(billToReceiptHTML(bill));   // <-- same HTML you already generate
    doc.close();

    // ---- wait for the iframe to finish rendering -------------
    const waitForLoad = () => new Promise(resolve => {
        if (iframe.contentWindow.document.readyState === 'complete') {
            resolve();
        } else {
            iframe.onload = resolve;
        }
    });

    // ---- trigger the native print dialog --------------------
    const startPrint = async () => {
        await waitForLoad();

        // give the browser a moment to layout the 80 mm page
        setTimeout(() => {
            const win = iframe.contentWindow;
            win.focus();
            win.print();

            // OPTIONAL: add a tiny “Close” button inside the iframe
            // (visible only after the print dialog is dismissed)
            // const closeBtn = win.document.createElement('div');
            // closeBtn.innerHTML = `
            //     <div style="
            //         position:fixed; bottom:10px; left:0; right:0;
            //         text-align:center; z-index:9999; font-family:Arial;">
            //         <button onclick="window.top.document.getElementById('__receiptPrintIframe').remove()"
            //                 style="
            //                 padding:8px 16px; font-size:14px;
            //                 background:#000; color:#fff; border:none;
            //                 border-radius:4px; cursor:pointer;">
            //             Close
            //         </button>
            //     </div>`;
            // win.document.body.appendChild(closeBtn);

            // safety-net: remove iframe after 2 minutes if user forgets
            setTimeout(() => {
                if (document.getElementById('__receiptPrintIframe')) {
                    document.getElementById('__receiptPrintIframe').remove();
                }
            }, 120_000);
        }, 800);               // 800 ms works reliably on Android / iOS
    };

    startPrint().catch(err => console.error('Print error:', err));
};
</script>
@endsection