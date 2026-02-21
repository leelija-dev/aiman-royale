@props(['eventType' => '', 'eventFocus' => '', 'image' => null])




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
        <div class="relative flex flex-col justify-end p-8 h-full text-white">
            <div class="text-right">
                <p class="text-sm uppercase tracking-widest font-sans mb-2">
                    {{ $eventType }}
                    {{-- New Arrival --}}
                </p>
                <h1 class="text-[2.5rem] font-serif-alt italic leading-none">
                    {{ $eventFocus }}
                    {{-- Latest Fashion --}}
                </h1>
                {{-- <h2 class="text-[2.2rem] font-serif-alt italic mt-[-10px]">
                    Vibe
                </h2> --}}
            </div>
        </div>
    </div>
</div>
