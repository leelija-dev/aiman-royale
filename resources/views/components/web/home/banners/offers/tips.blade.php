@props([
    'saleType' => '',
    'tipsType' => '',
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
        <div class="relative flex flex-col justify-center items-center text-center lgg:p-8 p-4 h-full text-white">
            <h1 class="lgg:text-7xl text-[3rem] font-script italic tracking-wider">
                {{ $saleType }}
            </h1>
            <h2 class="lgg:text-5xl text-[2rem] font-serif-alt italic mt-[-20px]">
                {{ $tipsType }} Tips
            </h2>
        </div>
    </div>
</div>
