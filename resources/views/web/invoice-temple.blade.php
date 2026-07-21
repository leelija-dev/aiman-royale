@extends('layout.web.main-layout')

@section('content')

 <style>
    body  { font-family: 'Inter', system-ui, -apple-system, sans-serif; }
   
    .invoice { max-width: 1200px; width: 100%; background: white; box-shadow: 0 4px 12px rgba(0,0,0,0.04); }
    .border-light { border-color: #e5e9f0; }
    .bg-soft { background-color: #f9fafc; }
  </style>

<div class="flex justify-center items-center">
  <div class="invoice">

  <!-- HEADER: aymanroayle + address + invoice meta -->
  <div class="border-b border-[#e5e9f0] px-6 py-5 md:px-8 md:py-6 flex flex-wrap items-start justify-between">
    <div>
      <div class="text-2xl font-bold tracking-tight text-[#0b1a33]">{{$store->name ? $store->name : 'Ayman Roayle'}}</div>
      {{-- <div class="text-sm text-[#4e5d73] mt-0.5">{{$store->gst_number ? $store->gst_number : ''}}</div> --}}
      <div class="text-xs text-[#4e5d73] mt-1">
        {{$store->email ? $store->email : ''}}
      </div>
      <div class="text-xs text-[#4e5d73] mt-1">
        <span class="font-medium">GST:</span> {{$store->gst_number ? $store->gst_number : ''}}
      </div>
      <div class="text-xs text-[#4e5d73] mt-3 leading-relaxed">
        {{$store->address ? $store->address : ''}}<br>
        {{$store->state ? $store->state : ''}} ,
        {{$store->country ? $store->country : ''}}
      </div>
      
    </div>
    <div class="text-right mt-3 md:mt-0">
      <div class="text-2xl font-bold text-[#0b1a33] tracking-wide">INVOICE</div>
      <div class="text-sm text-[#2c3a4f] leading-relaxed mt-1">
        {{-- <span class="font-semibold">Invoice #</span>{{$orderDetails->id}}<br> --}}
        <span class="font-semibold">Order : #</span>{{$orderDetails->id}}<br>
        <span class="font-semibold">Date :</span> {{$orderDetails->created_at->format('d M Y, h:i A')}}<br>
        {{-- <span class="font-semibold">Due</span> 29 July 2026 --}}
      </div>
    </div>
  </div>

  <!-- INVOICE TO & ORDER INFO -->
  <div class="border-b border-[#e5e9f0] bg-[#f9fafc] px-6 py-4 md:px-8 md:py-5 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
    <div>
      <div class="text-xs font-semibold uppercase tracking-wide text-[#4e5d73] mb-1">Invoice to:</div>
      <div class="font-medium text-[#0b1a33]">{{$orderDetails->user->name ? $orderDetails->user->name : ''}}</div>
      <div class="text-[#2c3a4f]">{{$orderDetails->phone_no ? $orderDetails->phone_no : ''}}</div>
      {{-- <div class="text-[#2c3a4f]">{{$orderDetails->user->email}}</div> --}}
      <div class="text-[#2c3a4f]">{{$orderDetails->address_1 ? $orderDetails->address_1 : '' }} , {{$orderDetails->address_2 ? $orderDetails->address_2 : ''}} , {{$orderDetails->city ? $orderDetails->city  : ''}} , {{ $orderDetails->pincode ? $orderDetails->pincode : ''}} , {{ $orderDetails->state ? $orderDetails->state  :'' }}.</div>
    </div>
    <div class="sm:text-right">
      <div class="text-xs font-semibold uppercase tracking-wide text-[#4e5d73] mb-1">Invoice details</div>
      <div><span class="text-[#4e5d73]">Invoice no: </span> <span class="font-medium text-[#0b1a33]">#{{$orderDetails->id ?$orderDetails->id :''}}</span></div>
      <div><span class="text-[#4e5d73]">Date:</span> <span class="font-medium text-[#0b1a33]">{{$orderDetails->created_at->format('d M Y, h:i A')}}</span></div>
      @php
    $status = strtolower($orderDetails->payment_status ?? '');

    $statusClass = match ($status) {
        'paid' => 'bg-green-100 text-green-800',
        'pending' => 'bg-yellow-100 text-yellow-800',
        'failed' => 'bg-red-100 text-red-800',
        'cancelled' => 'bg-gray-200 text-gray-800',
        'refunded' => 'bg-blue-100 text-blue-800',
        default => 'bg-gray-100 text-gray-700',
    };
@endphp

<div class="mt-2">
    <span class="text-[#4e5d73]">Payment Status:</span>
    <span class="px-2 py-0.5 rounded text-xs font-medium {{ $statusClass }}">
        {{ ucfirst($orderDetails->payment_status ?? '') }}
    </span>
</div>
    </div>
  </div>

  <!-- TABLE: items with CGST & SGST columns -->
  <div class="overflow-x-auto border-b border-[#e5e9f0]">
    <table class="w-full text-sm text-left">
      <thead class="bg-[#f1f4f9] text-[#1f2a3f] text-xs uppercase tracking-wide">
        <tr>
          <th class="px-4 py-3 font-semibold">NO</th>
          <th class="px-4 py-3 font-semibold">DESCRIPTION</th>
          <th class="px-4 py-3 font-semibold text-center">QTY</th>
          <th class="px-4 py-3 font-semibold text-right">PRICE</th>
          <th class="px-4 py-3 font-semibold text-right">Discount</th>
          {{-- <th class="px-4 py-3 font-semibold text-right">TAXABLE</th> --}}
          {{-- <th class="px-4 py-3 font-semibold text-right">GST (%)</th>
          <th class="px-4 py-3 font-semibold text-right">CGST</th>
          <th class="px-4 py-3 font-semibold text-right">SGST</th> --}}
          <th class="px-4 py-3 font-semibold text-right">TOTAL</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-[#e5e9f0]">
        @foreach($orderDetails->orderProducts as $orderProduct)
        <tr>
          <td class="px-4 py-3 text-[#2c3a4f]">{{$loop->iteration}}</td>
          <td class="px-4 py-3 font-medium text-[#0b1a33]">{{$orderProduct->product->name}} , Size: {{$orderProduct->variant->size ? $orderProduct->variant->size : ''}} , Colour: {{$orderProduct->variant->color ?$orderProduct->variant->color :''}}</td>
          <td class="px-4 py-3 text-center text-[#0b1a33]">{{$orderProduct->quantity ? $orderProduct->quantity : 0 }}</td>
          <td class="px-4 py-3 text-right text-[#0b1a33]">₹{{$orderProduct->price ? $orderProduct->price : 0}}</td>
          <td class="px-4 py-3 text-right text-[#0b1a33]">₹{{$orderProduct->coupon_discount_amount ? $orderProduct->coupon_discount_amount : 0}}</td>
          {{-- <td class="px-4 py-3 text-right text-[#0b1a33]">₹{{$orderProduct->total ? $orderProduct->total : 0}}</td> --}}
          {{-- <td class="px-4 py-3 text-right text-[#0b1a33]">{{$orderDetails->gst_percentage ? $orderDetails->gst_percentage : 0}}%</td>
          <td class="px-4 py-3 text-right text-[#0b1a33]">₹{{$orderDetails->gst_percentage ? ($orderDetails->gst_percentage/2) : 0}}%</td>
          <td class="px-4 py-3 text-right text-[#0b1a33]">{{$orderDetails->gst_percentage ? ($orderDetails->gst_percentage/2) : 0}}%</td> --}}
          <td class="px-4 py-3 text-right font-medium text-[#0b1a33]">₹{{$orderProduct->total ? $orderProduct->total : 0}}</td>
        </tr>
      @endforeach
        
      </tbody>
    </table>
  </div>

  <!-- TOTALS with GST breakdown -->
  <div class="border-b border-[#e5e9f0] px-6 py-5 md:px-8 md:py-6 flex flex-wrap justify-end gap-6">
    <div class="text-xs text-[#4e5d73] max-w-[200px]">
      <span class="block font-semibold text-[#1f2a3f]">Notes</span>
      <span class="block mt-1">Thank you for business with us!</span>
      <span class="block mt-2 text-[10px] leading-relaxed">Term and Conditions:<br>Please send payment within 30 days of receiving this invoice. There will be 10% interest charge per month on late invoice.</span>
    </div>
    <div class="min-w-[260px] bg-[#f9fafc] px-5 py-4 border border-[#e5e9f0]">
      <div class="flex justify-between text-sm py-1 border-b border-[#e5e9f0]"><span class="text-[#4e5d73]">Sub Total (Taxable)</span> <span class="font-medium text-[#0b1a33]">₹{{$orderDetails->total_amount ? (float)($orderDetails->total_amount + ($orderDetails->special_discount_amount ? $orderDetails->special_discount_amount  : 0) ) - ($orderDetails->gst_amount ? $orderDetails->gst_amount : 0): 0 }}</span></div>
      @if((float)$orderDetails->special_discount_amount > 0 && (float)$orderDetails->special_discount_id != null )
        <div class="flex justify-between text-sm py-1 border-b border-[#e5e9f0]"><span class="text-[#4e5d73]">Special Discount ({{$orderDetails->special_discount ? $orderDetails->special_discount : 0}}%)</span> <span class="font-medium text-[#0b1a33]">₹{{$orderDetails->special_discount_amount ? $orderDetails->special_discount_amount : 0}}</span></div>
      @endif
      <div class="flex justify-between text-sm py-1 border-b border-[#e5e9f0]"><span class="text-[#4e5d73]">CGST ({{$orderDetails->gst_percentage ? ((float)$orderDetails->gst_percentage/2) : 0}}%)</span> <span class="font-medium text-[#0b1a33]">₹{{$orderDetails->gst_amount ? ((float)$orderDetails->gst_amount/2) : 0}}</span></div>
      <div class="flex justify-between text-sm py-1 border-b border-[#e5e9f0]"><span class="text-[#4e5d73]">SGST ({{$orderDetails->gst_percentage ? ((float)$orderDetails->gst_percentage/2) : 0}}%)</span> <span class="font-medium text-[#0b1a33]">₹{{$orderDetails->gst_amount ? ((float)$orderDetails->gst_amount/2) : 0}}</span></div>
      <div class="flex justify-between text-sm py-1 border-b border-[#e5e9f0]"><span class="text-[#4e5d73]">Total Tax (0%)</span> <span class="font-medium text-[#0b1a33]">₹{{$orderDetails->gst_amount ? $orderDetails->gst_amount : 0}}</span></div>
      
      <!-- Payment method row -->
      <div class="flex justify-between text-sm py-2 border-b border-[#e5e9f0] items-center">
        <span class="text-[#4e5d73] font-medium">PAYMENT METHOD:</span>
        <span class="text-[#0b1a33] font-medium">{{$orderDetails->payment_method ? $orderDetails->payment_method : ''}}</span>
      </div>
      <div class="flex justify-between text-sm py-1 border-b border-[#e5e9f0]">
        <span class="text-[#4e5d73]">Transection Id:</span>
        <span class="font-medium text-[#0b1a33]">{{$orderDetails->transaction_id ? $orderDetails->transaction_id : ''}}</span>
      </div>
      
      <div class="flex justify-between text-base font-bold pt-2 mt-1 border-t-2 border-[#d0d7e2]">
        <span class="text-[#0b1a33]">GRAND TOTAL:</span>
        <span class="text-[#0b1a33]">₹{{$orderDetails->total_amount ? $orderDetails->total_amount : 0 }}</span>
      </div>
      <div class="text-right text-[10px] text-[#4e5d73] mt-1">(inclusive of all taxes)</div>
    </div>
  </div>

  <!-- FOOTER: signature / administrator -->
  <div class="px-6 py-4 md:px-8 md:py-5 flex flex-wrap justify-between text-xs text-[#4e5d73] border-b border-[#e5e9f0]">
    <div>
      <span class="font-semibold text-[#1f2a3f]">Thank you for business with us!</span><br>
      <span class="block mt-1">Term and Conditions:<br>Please send payment within 30 days of receiving this invoice. There will be 10% interest charge per month on late invoice.</span>
    </div>
    <div class="text-right">
      <div class="font-semibold text-[#1f2a3f]">{{$store->name ? $store->name : ''}}</div>
      <div class="text-[#4e5d73]">{{$store->phone_number ? $store->phone_number : ''}}</div>
      <div class="text-[#4e5d73]">{{$store->email ? $store->email : ''}}</div>
      <div class="text-[#4e5d73]">{{$store->address ? $store->address : ''}}</div>
      <div class="text-[#4e5d73]">{{$store->state ? $store->state : ''}} , {{$store->country ? $store->country : ''}}</div>
      
    </div>
  </div>

  <!-- footer with company name & location -->
  <div class="px-6 py-3 text-center text-[10px] text-[#8b9aaf] bg-white border-t border-[#e5e9f0]">
  
    {{$store->name ? $store->name : ''}} · {{$store->address ? $store->address : ''}} · {{$store->state ? $store->state : ''}} · {{$store->country ? $store->country : ''}} · Invoice #{{$orderDetails->id ? $orderDetails->id : ''}} · GST: {{$store->gst_number ? $store->gst_number : ''}}
  </div>
</div>
</div>
@endsection