@props([
    'saleType' => '',
    'discount' => 0,
    'allowCuponCode' => false,
    'cuponCode' => '-------',
    'image' => null,
])



<div class="relative overflow-hidden rounded-[0px] shadow-lg bg-cover bg-center h-96 group">
    <div class="absolute top-0 left-0 w-full h-full">
        <img class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-110"
            src="{{ $image ? asset($image) : asset('assets/images/placeholder-category.jpg') }}" alt="" />
    </div>
    <!-- Blackish overlay that appears on hover -->
    <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
    </div>
    <!-- Content that slides up from bottom -->
    <div
        class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/90 via-black/70 to-transparent translate-y-full group-hover:translate-y-0 transition-transform duration-500 ease-out">
        <div class="relative flex flex-col justify-center p-12 h-full text-white">
            <div class="max-w-xs">
                <p class="text-sm uppercase tracking-widest font-sans mb-2 opacity-80">
                    Last Chance
                </p>
                <h1 class="lgg:text-[2rem] text-[1.3rem] font-serif uppercase leading-tight mb-4">
                    {{ $saleType }} Sale {{ $discount }}% Off Storewide
                </h1>
                <p class="text-lg font-sans uppercase tracking-wider bg-white/20 inline-block px-4 py-2">
                    C-1623B5OFF
                </p>


                @if ($allowCuponCode)
                    <p class="text-lg font-sans uppercase tracking-wider bg-white/20 inline-block px-4 py-2">
                        {{ $cuponCode }}
                        {{-- C-1623B5OFF --}}
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
