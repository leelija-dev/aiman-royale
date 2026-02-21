@props([
    'saleType' => '',
    'discount' => 0,
    'allowWebsiteLink' => false,
    'websiteLink' => 'www.collegewalk.com',
    'image' => null,
])


<div class="relative overflow-hidden rounded-[0px] shadow-lg bg-cover bg-center h-96 group">
    <div class="absolute top-0 left-0 w-full h-full">
        <img class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-110"
            src="{{ $image ? asset($image) : asset('assets/images/placeholder-category.jpg') }}" alt="" />
        {{-- src="{{ asset('web/images/product-images/gray-lahenga-3_40_11zon.webp') }}" --}}
    </div>
    <!-- Blackish overlay that appears on hover -->
    <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
    </div>
    
    <!-- Content that slides up from bottom -->
    <div
        class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/90 via-black/70 to-transparent translate-y-full group-hover:translate-y-0 transition-transform duration-500 ease-out">
        <div class="relative flex flex-col justify-end md:p-8 p-4 h-full text-white">
            <span
                class="lgg:text-[3rem] text-[2rem] font-script rotate-[-6deg] smx:mb-[-20px] mb-[-12px]">{{ $saleType }}</span>
            <span class="text-[2.7rem] font-bold font-serif uppercase tracking-wider lgg:mb-4 mb-2">
                Sale
            </span>
            <p class="lgg:text-3xl text-[1.2rem] font-serif lgg:mb-6 mb-3">
                Up to {{ $discount }}% off
            </p>
            <a href="{{ $websiteLink }}"
                class="inline-block w-fit text-center bg-black text-white lgg:px-8 px-4 py-2 lgg:text-md text-sm font-sans rounded-full uppercase tracking-wide hover:bg-gray-600 transition-all duration-300 ease-in-out">Shop
                Now</a>


            @if ($allowWebsiteLink)
                <p class="text-md lgg:mt-4 mt-2 font-sans opacity-80">
                    {{ $websiteLink }}
                    {{-- www.collegewalk.com --}}
                </p>
            @endif
        </div>
    </div>
</div>
