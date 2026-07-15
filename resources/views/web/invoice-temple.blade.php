@extends('layout.web.main-layout')

@section('content')

 <style>
    body .invoice { font-family: 'Inter', system-ui, -apple-system, sans-serif; }
    body .invoice { background: #f2f5f9; display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 2rem 1rem; margin: 0; }
    .invoice { max-width: 1200px; width: 100%; background: white; box-shadow: 0 4px 12px rgba(0,0,0,0.04); }
    .border-light { border-color: #e5e9f0; }
    .bg-soft { background-color: #f9fafc; }
  </style>

<div class="invoice">

  <!-- HEADER: aymanroayle + address + invoice meta -->
  <div class="border-b border-[#e5e9f0] px-6 py-5 md:px-8 md:py-6 flex flex-wrap items-start justify-between">
    <div>
      <div class="text-2xl font-bold tracking-tight text-[#0b1a33]">aymanroayle</div>
      <div class="text-sm text-[#4e5d73] mt-0.5">Craft · Quality · Trust</div>
      <div class="text-xs text-[#4e5d73] mt-3 leading-relaxed">
        Barasat, North 24 Parganas<br>
        Kolkata, West Bengal, India
      </div>
      <div class="text-xs text-[#4e5d73] mt-1">
        contact@aymanroayle.in · +91 800 555 0199
      </div>
      <div class="text-xs text-[#4e5d73] mt-1">
        <span class="font-medium">GSTIN:</span> 19AABCU1234D1Z9
      </div>
    </div>
    <div class="text-right mt-3 md:mt-0">
      <div class="text-2xl font-bold text-[#0b1a33] tracking-wide">INVOICE</div>
      <div class="text-sm text-[#2c3a4f] leading-relaxed mt-1">
        <span class="font-semibold">Invoice #</span> INV-2403-1098<br>
        <span class="font-semibold">Order #</span> ORD-9876-42<br>
        <span class="font-semibold">Date</span> 15 July 2026<br>
        <span class="font-semibold">Due</span> 29 July 2026
      </div>
    </div>
  </div>

  <!-- INVOICE TO & ORDER INFO -->
  <div class="border-b border-[#e5e9f0] bg-[#f9fafc] px-6 py-4 md:px-8 md:py-5 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
    <div>
      <div class="text-xs font-semibold uppercase tracking-wide text-[#4e5d73] mb-1">Invoice to:</div>
      <div class="font-medium text-[#0b1a33]">Ketut Susilo</div>
      <div class="text-[#2c3a4f]">123-456-7890</div>
      <div class="text-[#2c3a4f]">hello@reallygreatsite.com</div>
      <div class="text-[#2c3a4f]">123 Anywhere St., Any City</div>
    </div>
    <div class="sm:text-right">
      <div class="text-xs font-semibold uppercase tracking-wide text-[#4e5d73] mb-1">Invoice details</div>
      <div><span class="text-[#4e5d73]">Invoice no:</span> <span class="font-medium text-[#0b1a33]">12345</span></div>
      <div><span class="text-[#4e5d73]">Date:</span> <span class="font-medium text-[#0b1a33]">25 June 2022</span></div>
      <div class="mt-2"><span class="text-[#4e5d73]">Payment status:</span> <span class="bg-[#e1f7e3] px-2 py-0.5 text-[#0b1a33] font-medium text-xs">Paid</span></div>
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
          <th class="px-4 py-3 font-semibold text-right">TAXABLE</th>
          <th class="px-4 py-3 font-semibold text-right">CGST (9%)</th>
          <th class="px-4 py-3 font-semibold text-right">SGST (9%)</th>
          <th class="px-4 py-3 font-semibold text-right">TOTAL</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-[#e5e9f0]">
        <tr>
          <td class="px-4 py-3 text-[#2c3a4f]">1</td>
          <td class="px-4 py-3 font-medium text-[#0b1a33]">Logo Design</td>
          <td class="px-4 py-3 text-center text-[#0b1a33]">5</td>
          <td class="px-4 py-3 text-right text-[#0b1a33]">₹100</td>
          <td class="px-4 py-3 text-right text-[#0b1a33]">₹500</td>
          <td class="px-4 py-3 text-right text-[#0b1a33]">₹45.00</td>
          <td class="px-4 py-3 text-right text-[#0b1a33]">₹45.00</td>
          <td class="px-4 py-3 text-right font-medium text-[#0b1a33]">₹590.00</td>
        </tr>
        <tr>
          <td class="px-4 py-3 text-[#2c3a4f]">2</td>
          <td class="px-4 py-3 font-medium text-[#0b1a33]">Website Design</td>
          <td class="px-4 py-3 text-center text-[#0b1a33]">2</td>
          <td class="px-4 py-3 text-right text-[#0b1a33]">₹800</td>
          <td class="px-4 py-3 text-right text-[#0b1a33]">₹1,600</td>
          <td class="px-4 py-3 text-right text-[#0b1a33]">₹144.00</td>
          <td class="px-4 py-3 text-right text-[#0b1a33]">₹144.00</td>
          <td class="px-4 py-3 text-right font-medium text-[#0b1a33]">₹1,888.00</td>
        </tr>
        <tr>
          <td class="px-4 py-3 text-[#2c3a4f]">3</td>
          <td class="px-4 py-3 font-medium text-[#0b1a33]">Brand Design</td>
          <td class="px-4 py-3 text-center text-[#0b1a33]">3</td>
          <td class="px-4 py-3 text-right text-[#0b1a33]">₹300</td>
          <td class="px-4 py-3 text-right text-[#0b1a33]">₹900</td>
          <td class="px-4 py-3 text-right text-[#0b1a33]">₹81.00</td>
          <td class="px-4 py-3 text-right text-[#0b1a33]">₹81.00</td>
          <td class="px-4 py-3 text-right font-medium text-[#0b1a33]">₹1,062.00</td>
        </tr>
        <tr>
          <td class="px-4 py-3 text-[#2c3a4f]">4</td>
          <td class="px-4 py-3 font-medium text-[#0b1a33]">Banner Design</td>
          <td class="px-4 py-3 text-center text-[#0b1a33]">2</td>
          <td class="px-4 py-3 text-right text-[#0b1a33]">₹300</td>
          <td class="px-4 py-3 text-right text-[#0b1a33]">₹600</td>
          <td class="px-4 py-3 text-right text-[#0b1a33]">₹54.00</td>
          <td class="px-4 py-3 text-right text-[#0b1a33]">₹54.00</td>
          <td class="px-4 py-3 text-right font-medium text-[#0b1a33]">₹708.00</td>
        </tr>
        <tr>
          <td class="px-4 py-3 text-[#2c3a4f]">5</td>
          <td class="px-4 py-3 font-medium text-[#0b1a33]">Flyer Design</td>
          <td class="px-4 py-3 text-center text-[#0b1a33]">2</td>
          <td class="px-4 py-3 text-right text-[#0b1a33]">₹400</td>
          <td class="px-4 py-3 text-right text-[#0b1a33]">₹800</td>
          <td class="px-4 py-3 text-right text-[#0b1a33]">₹72.00</td>
          <td class="px-4 py-3 text-right text-[#0b1a33]">₹72.00</td>
          <td class="px-4 py-3 text-right font-medium text-[#0b1a33]">₹944.00</td>
        </tr>
        <tr>
          <td class="px-4 py-3 text-[#2c3a4f]">6</td>
          <td class="px-4 py-3 font-medium text-[#0b1a33]">Social Media Template</td>
          <td class="px-4 py-3 text-center text-[#0b1a33]">10</td>
          <td class="px-4 py-3 text-right text-[#0b1a33]">₹50</td>
          <td class="px-4 py-3 text-right text-[#0b1a33]">₹500</td>
          <td class="px-4 py-3 text-right text-[#0b1a33]">₹45.00</td>
          <td class="px-4 py-3 text-right text-[#0b1a33]">₹45.00</td>
          <td class="px-4 py-3 text-right font-medium text-[#0b1a33]">₹590.00</td>
        </tr>
        <tr>
          <td class="px-4 py-3 text-[#2c3a4f]">7</td>
          <td class="px-4 py-3 font-medium text-[#0b1a33]">Name Card</td>
          <td class="px-4 py-3 text-center text-[#0b1a33]">15</td>
          <td class="px-4 py-3 text-right text-[#0b1a33]">₹25</td>
          <td class="px-4 py-3 text-right text-[#0b1a33]">₹750</td>
          <td class="px-4 py-3 text-right text-[#0b1a33]">₹67.50</td>
          <td class="px-4 py-3 text-right text-[#0b1a33]">₹67.50</td>
          <td class="px-4 py-3 text-right font-medium text-[#0b1a33]">₹885.00</td>
        </tr>
        <tr>
          <td class="px-4 py-3 text-[#2c3a4f]">8</td>
          <td class="px-4 py-3 font-medium text-[#0b1a33]">Web Developer</td>
          <td class="px-4 py-3 text-center text-[#0b1a33]">2</td>
          <td class="px-4 py-3 text-right text-[#0b1a33]">₹1,000</td>
          <td class="px-4 py-3 text-right text-[#0b1a33]">₹2,000</td>
          <td class="px-4 py-3 text-right text-[#0b1a33]">₹180.00</td>
          <td class="px-4 py-3 text-right text-[#0b1a33]">₹180.00</td>
          <td class="px-4 py-3 text-right font-medium text-[#0b1a33]">₹2,360.00</td>
        </tr>
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
      <div class="flex justify-between text-sm py-1 border-b border-[#e5e9f0]"><span class="text-[#4e5d73]">Sub Total (Taxable)</span> <span class="font-medium text-[#0b1a33]">₹7,650</span></div>
      <div class="flex justify-between text-sm py-1 border-b border-[#e5e9f0]"><span class="text-[#4e5d73]">CGST (9%)</span> <span class="font-medium text-[#0b1a33]">₹688.50</span></div>
      <div class="flex justify-between text-sm py-1 border-b border-[#e5e9f0]"><span class="text-[#4e5d73]">SGST (9%)</span> <span class="font-medium text-[#0b1a33]">₹688.50</span></div>
      <div class="flex justify-between text-sm py-1 border-b border-[#e5e9f0]"><span class="text-[#4e5d73]">Total Tax (18%)</span> <span class="font-medium text-[#0b1a33]">₹1,377.00</span></div>
      
      <!-- Payment method row -->
      <div class="flex justify-between text-sm py-2 border-b border-[#e5e9f0] items-center">
        <span class="text-[#4e5d73] font-medium">PAYMENT METHOD:</span>
        <span class="text-[#0b1a33] font-medium">Borcelle</span>
      </div>
      <div class="flex justify-between text-sm py-1 border-b border-[#e5e9f0]">
        <span class="text-[#4e5d73]">Account Number</span>
        <span class="font-medium text-[#0b1a33]">123-456-7890</span>
      </div>
      
      <div class="flex justify-between text-base font-bold pt-2 mt-1 border-t-2 border-[#d0d7e2]">
        <span class="text-[#0b1a33]">GRAND TOTAL:</span>
        <span class="text-[#0b1a33]">₹9,027.00</span>
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
      <div class="font-semibold text-[#1f2a3f]">Henrietta Mitchell</div>
      <div class="text-[#4e5d73]">Administrator</div>
      <div class="text-[#4e5d73]">123-456-7890</div>
      <div class="text-[#4e5d73]">hello@reallygreatsite.com</div>
      <div class="text-[#4e5d73]">123 Anywhere St., Any City</div>
    </div>
  </div>

  <!-- footer with company name & location -->
  <div class="px-6 py-3 text-center text-[10px] text-[#8b9aaf] bg-white border-t border-[#e5e9f0]">
    aymanroayle · Barasat, North 24 Parganas, Kolkata, West Bengal, India · Invoice #INV-2403-1098 · GSTIN: 19AABCU1234D1Z9
  </div>
</div>
@endsection