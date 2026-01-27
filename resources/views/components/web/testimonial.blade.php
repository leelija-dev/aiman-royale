{{-- @props([
    'testimonials'
])

@php
    if (!isset($testimonials)) {
        throw new \InvalidArgumentException('Prop [testimonials] is required for <x-web.testimonial />');
    }
@endphp

{{-- @dd($testimonials) 

<section class=" lg:py-24 py-12 lg:px-8  px-6 relative ">

  <div class="container mx-auto px-4">
    <div class="flex flex-col lg:flex-row items-start justify-between gap-8 lg:gap-12">
      <!-- Left Content -->
      <div class="2xl:w-[50%] xl:w-[40%] lg:w-1/2 w-full relative">
        <span class="text-primary lg;text-left text-center lg:inline-block block lg:w-auto w-full lg:text-4xl text-2xl font-semibold mb-2">Testimonial</span>
        <h2 class="lg:text-left text-center xl:mb-[3rem] lg:mb-[2rem] mb-[1rem] text-black mx-auto w-full text-h2-xs sm:text-h2-sm md:text-h2-md lg:text-h2-lg lgg:text-h2-lgg xl:text-h2-xl 2xl:text-h2-2xl font-semibold  ">Don't Believe Me<br />Check What Client<br />Think Of Us</h2>
        <!-- <img loading="lazy" src="{{ asset('web/images/career/rocket.png') }}" alt="rocket" class="w-1/2 absolute -mt-20 md:-mt-28 rotate-[25deg]"> -->
        <div class="relative bottom-0 left-[4%] w-[300px] h-[300px] lg:block hidden">
          <img class="h-full relative z-10 w-auto" src="{{asset('web/images/testimonial-images/rocket.png')}}" alt="">
          <img class="absolute w-full h-auto  bottom-[-26%] left-[-69%]" src="{{asset('web/images/testimonial-images/oragen-curve.png')}}" alt="">
        </div>
      </div>

      <!-- Right Slider -->
      <div class="2xl:w-[50%] xl:w-[60%] lg:w-1/2 w-full relative ">
        <div class=" mx-auto h-fit">
          <!-- Carousel -->
          <div id="testimonial-track" class="owl-carousel owl-theme">
            <!-- Testimonial Cards -->
            @foreach ($testimonials as $testimonial)
            <div class="item px-2 my-8">
              <div class="testimonial-card smxl:max-w-[275px] max-w-[220px] smxl:min-w-[270px] min-w-[220px] mx-auto">
                <div class="w-full text-center">
                  <div class="w-[120px] relative shadow-[0_0_13px_#0000004d] h-[120px] md:w-[150px] md:h-[150px] lg:w-[160px] lg:h-[160px] mb-[-60px] md:mb-[-70px] lg:mb-[-80px] overflow-hidden  rounded-full mx-auto">
                    <img src="{{ asset('upload_image/'.$testimonial['image']) }}" class="w-full h-full object-cover" alt="">
                  </div>
                  <div class="test-card-inner mt-4 bg-white pt-16 md:pt-20 shadow-[3px_9px_14px_rgba(0,0,0,0.1)] rounded-[15px] p-4">
                    <img class="mx-auto h-auto mb-3" src="{{asset('web/images/testimonial-images/quote-right.png')}}" alt="" style="width:33px;">
                    <h3 class="font-bold text-lg text-gray-900">{{ $testimonial['name'] }}</h3>
                    <p class="text-sm text-gray-500 mb-3">{{ $testimonial['designation'] }}</p>
                    <p class="text-sm text-gray-600">{{ $testimonial['message'] }}</p>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>

          <!-- Custom Navigation -->
          <div class="flex justify-center mt-6 md:mt-8 space-x-4 ">
            <div class="absolute flex h-full z-10 lg:left-[-20px] left-0 top-0 items-center">
              <button id="prev" class="p-2 rounded-full bg-[#1C244B] hover:scale-[1.2]  focus:outline-none transition-all duration-300 ease-in-out">
                <img class="w-[20px]" src="{{asset('web/images/testimonial-images/arrow.png')}}" alt="">
              </button>
            </div>
            <div class="absolute flex h-full z-10 right-0 top-0 items-center">
              <button id="next" class="p-2 rounded-full bg-[#1C244B] hover:scale-[1.2]  focus:outline-none transition-all duration-300 ease-in-out">
                <img class="w-[20px] rotate-[180deg]" src="{{asset('web/images/testimonial-images/arrow.png')}}" alt="">
              </button>
            </div>


          </div>
        </div>


      </div>
    </div>
  </div>
</section> --}}

<!-- jQuery -->
{{-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Owl Carousel JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<script>
  $(document).ready(function() {
    let $carousel;
    let carouselInitialized = false;

    function equalizeCardHeights() {
      let maxHeight = 0;

      // Reset heights first to get accurate measurements
      $('.test-card-inner').css('min-height', '');

      // Find the tallest card
      $('.test-card-inner').each(function() {
        const currentHeight = $(this).outerHeight();
        if (currentHeight > maxHeight) {
          maxHeight = currentHeight;
        }
      });

      // Apply the max height to all cards
      $('.test-card-inner').css('min-height', maxHeight + 'px');
    }

    function initCarousel() {
      const windowWidth = $(window).width();

      // Destroy existing carousel if it's already initialized
      if (carouselInitialized) {
        $carousel.trigger('destroy.owl.carousel');
        $carousel.removeClass('owl-carousel owl-loaded');
        $carousel.find('.owl-stage-outer').children().unwrap();
        carouselInitialized = false;
      }

      // Initialize carousel with appropriate settings
      $carousel = $('#testimonial-track').addClass('owl-carousel');

      const options = {
        loop: true,
        margin: 16,
        autoplay: false,
        dots: false,
        responsive: {
          0: {
            items: 1,
            margin: 0
          },
          640: {
            items: 1,
            margin: 0
          },
          768: {
            items: 2,
            margin: 0
          },
          991: {
            items: 1,
            margin: 0
          },
          1280: {
            items: 2,
            margin: 0
          }
        },
        onInitialized: function() {
          // Equalize heights after carousel initialization
          equalizeCardHeights();
        },
        onChanged: function() {
          // Equalize heights when carousel changes (optional)
          equalizeCardHeights();
        }
      };

      $carousel.owlCarousel(options);
      carouselInitialized = true;
    }

    // Initialize carousel on page load
    initCarousel();

    // Custom Prev/Next Buttons
    $('#prev').click(function() {
      if (carouselInitialized) {
        $carousel.trigger('prev.owl.carousel');
      }
    });

    $('#next').click(function() {
      if (carouselInitialized) {
        $carousel.trigger('next.owl.carousel');
      }
    });

    // Reinitialize carousel on window resize with debounce
    let resizeTimer;
    $(window).on('resize', function() {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(function() {
        initCarousel();
        equalizeCardHeights();
      }, 250); // Adjust debounce time as needed
    });
  });
</script> --}}