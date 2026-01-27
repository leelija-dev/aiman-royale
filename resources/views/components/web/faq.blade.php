{{-- @isset($faqs)
    <section class=" min-h-screen h-auto flex  justify-center items-center lg:py-16 py-8 px-10 relative ">
        <div
            class="bg-primary w-[400px] h-[400px] top-[-15%] left-[-10%] lg:w-[30vw] lg:h-[30vw] lg:-max-w-[440px] lg:max-h-[440px]  opacity-40 absolute blur-custom1 rounded-full">

        </div>
        <div
            class="bg-primary w-[400px] h-[400px] top-[25%] right-[-10%] lg:w-[30vw] lg:h-[30vw] lg:-max-w-[440px] lg:max-h-[440px]  opacity-40 absolute blur-custom1 rounded-full">
        </div>
        <div class="container mx-auto relative z-10 ">
            <h2
                class=" text-center  text-black mx-auto w-full text-h2-xs sm:text-h2-sm md:text-h2-md lg:text-h2-lg lgg:text-h2-lgg xl:text-h2-xl 2xl:text-h2-2xl font-medium">
                Frequently <span class="text-primary">Asked</span> Questions
            </h2>
            <p
                class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl font-normal text-black text-center xll:w-[75%] xl:w-[80%] lg:w-[85%] w-full mx-auto my-4 ">
                Endurix is a community-driven running club dedicated to helping runners
                of all levels train smarter, race harder and recover better.
            </p>
            <div class="xll:w-[75%] xl:w-[80%] lg:w-[85%] w-full mx-auto lg:mt-6 mt-3">
                <!-- items -->
                @if (count($faqs))
                    @foreach ($faqs as $faq)
                        <div
                            class="bg-white faq-wrapper border-[2px] shadow-[1px_8px_10px_#e3e3e3]  border-primary rounded-[10px] lg:mb-6 mb-4">
                            <div class="w-full px-6 py-4 flex justify-between items-center cursor-pointer">
                                <h3 class="xl:text-2xl  lg:text-xl   text-lg">{{ $faq->question }}</span>
                                </h3>
                                <img class="faq-chevaron lg:w-[25px] w-[18px] rotate-[90deg] transition-all duration-300 ease-in-out "
                                    src="{{ asset('web/images/icons/right-chevron.webp') }}" alt="">

                            </div>
                            <hr class="bg-black line-border-block transition-all duration-300 ease-in-out h-[2px]">
                            <div class="faq-content-block transition-all duration-300 ease-in-out px-6 py-4">
                                <p
                                    class="text-p-xs sm:text-p-sm md:text-p-md lg:text-p-lg lgg:text-p-lgg xl:text-p-xl 2xl:text-p-2xl  mb-2">
                                    {!! $faq->answer !!}
                                </p>
                            </div>

                        </div>
                    @endforeach
                @endif

            </div>

        </div>
    </section>
@endisset --}}
