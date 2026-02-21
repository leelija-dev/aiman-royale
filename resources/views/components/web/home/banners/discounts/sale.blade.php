@props(['saleType' => '', 'discount' => 0, 'image' => null])




<div class="item flex justify-center items-center">
    <div class="w-full bg-white shadow-sm hover:shadow-md transition-shadow">
        <div class="relative overflow-hidden">
            <img src="{{ $image ? asset($image) : asset('web/images/product-images/dark-red-plazo-2_12_11zon.webp') }}"
                alt="Silver Lehenga" class="w-full h-[400px] object-cover object-center" />
        </div>
        <div class="absolute bg-white p-4 bottom-[5%] left-[5%]">
            <div class="text-left">
                <!-- Top line: 01 — Spring Sale -->
                <div class="flex items-center justify-center gap-4 mb-1">
                    <span class="text-[1.1rem] font-medium text-gray-600">01</span>
                    <div class="h-px w-4 bg-gray-400"></div>
                    <span class="text-[1.1rem] font-medium text-gray-600 tracking-wider">{{ $saleType }}
                        Sale</span>
                </div>

                <!-- Big discount text -->
                <div class="text-[1.4rem] font-semibold text-gray-800 tracking-tight">
                    {{ $discount }}% OFF
                </div>
            </div>
        </div>
    </div>
</div>
