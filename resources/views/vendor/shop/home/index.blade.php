<x-shop::layouts>

  @push('styles')

  <link rel="stylesheet" href="{{ asset('css/main.css') }}">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <!-- Owl Carousel CSS -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
  <link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Great+Vibes&family=Montserrat:wght@300;400;500;600&family=Cormorant+Garamond:wght@300;400;500&display=swap"
    rel="stylesheet" />



  <link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Inter:wght@400;500&display=swap"
    rel="stylesheet" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer" />
  
  @endpush


  <!-- hero section  -->
  <x-hero-section />

  <!-- filter by categories  -->
  <x-categories />

  <!-- item cards slider  -->
  <x-item-slider />

  <!-- our policies cta -->
  <x-our-policy />

  <!-- item cards slider -->
  <x-item-slider />

  <!-- cta  -->
  <x-cta />

  <!-- item cards slider -->
  <x-item-slider />

  <!-- features  -->
  <x-features />

  <!-- editors picks  -->
  <x-editor-pics />

  <!-- item cards slider -->
  <x-item-slider />
















  @push('scripts')
  <!-- jQuery (required for Owl Carousel) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Owl Carousel JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <script src="{{ asset('js/main.js') }}"></script>

  @endpush


</x-shop::layouts>