<section class="px-4 lgg:py-8 py-6">
    <div class="container mx-auto">
        <div class="w-full text-center mb-6">
    <h2 class="text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl font-semibold text-gray-900 heading-font tracking-wide">
        Our Signature Standouts
    </h2>
    <p class="text-p-xs lgg:text-p-sm xl:text-p-md 2xl:text-p-lg text-gray-500 font-sans">
        Red Carpet Ready in Every Design We Create
    </p>
</div>
        <div class="grid-container">
            @php
            $editorBanners = \App\Models\Banner::active()->where('type', 'editor')->ordered()->get();
            @endphp
            <div class="owl-carousel banner-carousel lgg:hidden">
                @foreach($editorBanners as $banner)
                @php
                $editorImg = url('/img/' . 'uploads/banners/' . $banner->image . '?w=800&q=80');
                if (strpos($editorImg, 'cloudinary.com') !== false && strpos($editorImg, 'upload/') !== false) {
                $parts = explode('upload/', $editorImg);
                $editorImg = $parts[0] . 'upload/w_800,h_600,c_fill,f_auto,q_auto/' . $parts[1];
                }
                @endphp
                <div class="relative bg-[#b8a89a] "
                    @if($banner->filter_type === 'multiple' && $banner->filters)
                    data-filter="{{ $banner->filters }}"
                    @else
                    data-filter="{{ $banner->filter ?? ($banner->discount ?? '') }}" @endif>
                    <a href="{{ $banner->filter ? '/products?' . ($banner->filter ?? ($banner->discount ?? '')) : '#' }}" class="overflow-hidden aspect-[16/10] w-full relative block">
                        <img src="{{ $editorImg }}" alt="{{ $banner->title }}"
                            class="absolute inset-0 w-full h-full object-contain object-center object-top"
                            loading="lazy"
                            decoding="async"
                            width="800"
                            height="600" />
                    </a>
                    <!-- <div class="relative z-10 flex flex-col justify-center h-full p-10 bg-black/10">
                        @if ($banner->subtitle)
                        <span
                            class="lgg:text-[3rem] text-[2rem] font-script rotate-[-6deg] smx:mb-[-20px] mb-[-12px]">{{ $banner->subtitle }}</span>
                        @endif
                        <h2 class="heading-font text-4xl md:text-5xl text-white mb-4">
                            {{ $banner->title }}
                        </h2>
                        @if ($banner->description)
                        <p class="text-sm text-black mb-6">
                            Get <span class="font-semibold">{{ $banner->description }}</span> | Use Code:
                            <span class="text-white font-medium">{{ $banner->discount }}</span>
                        </p>
                        @endif
                        <a href="{{ $banner->filter ? '/products?' . ($banner->filter ?? ($banner->discount ?? '')) : '#' }}"
                            class="w-fit bg-black text-white px-6 py-2 text-sm tracking-wide hover:bg-gray-800 transition inline-block">
                            {{ $banner->button_text }}
                        </a>
                    </div> -->
                </div>
                @endforeach
            </div>

            <div class="hidden lgg:grid grid-cols-1 md:grid-cols-2 gap-6 ">
                @foreach ($editorBanners as $index => $banner)
                @php
                $editorImg = url('/img/' . 'uploads/banners/' . $banner->image . '?w=800&q=80');
                if (strpos($editorImg, 'cloudinary.com') !== false && strpos($editorImg, 'upload/') !== false) {
                $parts = explode('upload/', $editorImg);
                $editorImg = $parts[0] . 'upload/w_800,h_600,c_fill,f_auto,q_auto/' . $parts[1];
                }
                @endphp
                @if ($index % 2 == 0)
                <div class="relative bg-[#b8a89a] "
                    @if ($banner->filter_type === 'multiple' && $banner->filters) data-filter="{{ $banner->filters }}"
                    @else
                    data-filter="{{ $banner->filter ?? ($banner->discount ?? '') }}" @endif>
                    <a href="{{ $banner->filter ? '/products?' . ($banner->filter ?? ($banner->discount ?? '')) : '#' }}" class="overflow-hidden aspect-[16/10] relative block">
                        <img src="{{ $editorImg }}" alt="{{ $banner->title }}"
                            class="absolute inset-0 w-full h-full object-contain object-center object-top"
                            loading="lazy"
                            decoding="async"
                            width="800"
                            height="600" />

                    </a>

                    <!-- <div class="relative z-10 flex flex-col justify-center h-full p-10 bg-black/10">
                        @if ($banner->subtitle)
                        <span
                            class="lgg:text-[3rem] text-[2rem] font-script rotate-[-6deg] smx:mb-[-20px] mb-[-12px]">{{ $banner->subtitle }}</span>
                        @endif
                        <h2 class="heading-font text-4xl md:text-5xl text-white mb-4">
                            {{ $banner->title }}
                        </h2>
                        @if ($banner->description)
                        <p class="text-sm text-black mb-6">
                            Get <span class="font-semibold">{{ $banner->description }}</span> | Use Code:
                            <span class="text-white font-medium">{{ $banner->discount }}</span>
                        </p>
                        @endif
                        <a href="{{ $banner->filter ? '/products?' . ($banner->filter ?? ($banner->discount ?? '')) : '#' }}"
                            class="w-fit bg-black text-white px-6 py-2 text-sm tracking-wide hover:bg-gray-800 transition inline-block">
                            {{ $banner->button_text }}
                        </a>
                    </div> -->
                </div>
                @endif
                @endforeach

                @foreach ($editorBanners as $index => $banner)
                @php
                $editorImg = asset('uploads/banners/' . $banner->image);
                if (strpos($editorImg, 'cloudinary.com') !== false && strpos($editorImg, 'upload/') !== false) {
                $parts = explode('upload/', $editorImg);
                $editorImg = $parts[0] . 'upload/w_800,h_600,c_fill,f_auto,q_auto/' . $parts[1];
                }
                @endphp
                @if ($index % 2 == 1)
                <div class="relative bg-[#e8dcd6] "
                    @if ($banner->filter_type === 'multiple' && $banner->filters) data-filter="{{ $banner->filters }}"
                    @else
                    data-filter="{{ $banner->filter ?? ($banner->discount ?? '') }}" @endif>
                    <a href="{{ $banner->filter ? '/products?' . ($banner->filter ?? ($banner->discount ?? '')) : '#' }}" class="overflow-hidden aspect-[16/10] relative w-full block">
                        <img src="{{ $editorImg }}" alt="{{ $banner->title }}"
                            class="absolute inset-0 w-full h-full object-cover object-center object-top"
                            loading="lazy"
                            decoding="async"
                            width="800"
                            height="600" />
                    </a>
                    <!-- <div class="relative z-10 flex flex-col justify-center h-full p-10">
                        @if ($banner->subtitle)
                        <span
                            class="lgg:text-[3rem] text-[2rem] font-script rotate-[-6deg] smx:mb-[-20px] mb-[-12px]">{{ $banner->subtitle }}</span>
                        @endif
                        <h2 class="heading-font text-4xl md:text-5xl text-white mb-4">
                            {{ $banner->title }}
                        </h2>
                        @if ($banner->description)
                        <p class="text-sm text-black mb-6">
                            Get <span class="font-semibold">{{ $banner->description }}</span> | Use Code:
                            <span class="text-white font-medium">{{ $banner->discount }}</span>
                        </p>
                        @endif
                        <a href="{{ $banner->filter ? '/products?' . ($banner->filter ?? ($banner->discount ?? '')) : '#' }}"
                            class="w-fit bg-black text-white px-6 py-2 text-sm tracking-wide hover:bg-gray-800 transition inline-block">
                            {{ $banner->button_text }}
                        </a>
                    </div> -->
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
</section>