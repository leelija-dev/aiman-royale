@extends('web.layouts.app')

@section('content')
<div class="min-h-screen bg-white flex items-center justify-center p-6 pt-16">
    <div class="max-w-4xl w-full mx-auto text-center relative z-10">
        <!-- Animated 404 Text -->
        <div class="relative mb-8">
            <h1 class="text-9xl font-bold text-gray-200 relative">
                <span class="relative inline-block">
                    <span class="absolute inset-0 text-orange-400 opacity-20">404</span>
                    <span class="relative text-gray-800">404</span>
                </span>
            </h1>
            <div class="absolute -top-4 -left-6 w-12 h-12 bg-orange-400 rounded-full opacity-20 animate-pulse"></div>
            <div class="absolute -bottom-4 -right-6 w-16 h-16 bg-orange-500 rounded-full opacity-10 animate-pulse"></div>
        </div>

        <!-- Main Message -->
        <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">
            Oops! Page Not Found
        </h2>
        
        <p class="text-xl text-gray-600 mb-10 max-w-2xl mx-auto">
            The page you're looking for might have been removed, had its name changed, or is temporarily unavailable.
        </p>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row justify-center gap-4 mb-12">
            <a href="{{ url('/') }}" class="px-8 py-4 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-full transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-orange-200">
                <i class="fas fa-home mr-2"></i> Go to Homepage
            </a>
            <a href="{{ url('/contact') }}" class="px-8 py-4 bg-white hover:bg-gray-50 text-orange-500 font-semibold border-2 border-orange-500 rounded-full transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-orange-100">
                <i class="fas fa-envelope mr-2"></i> Contact Support
            </a>
        </div>

        <!-- Search Bar -->
        <div class="max-w-md mx-auto mb-12 relative">
            <div class="relative">
                <input type="text" placeholder="What are you looking for?" 
                    class="w-full px-6 py-4 pr-14 rounded-full border-2 border-gray-200 focus:border-orange-400 focus:ring-2 focus:ring-orange-200 focus:ring-opacity-50 transition-all duration-300 outline-none">
                <button class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-orange-500 hover:bg-orange-600 text-white p-3 rounded-full transition-all duration-300">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <!-- Social Links -->
        <div class="flex justify-center space-x-6">
            <a href="https://www.facebook.com/leelijaweb/" class="text-gray-500 hover:text-orange-500 transition-colors duration-300" aria-label="Facebook">
                <i class="fab fa-facebook-f text-2xl"></i>
            </a>
            <a href="https://twitter.com/lee_lija" class="text-gray-500 hover:text-orange-500 transition-colors duration-300" aria-label="Twitter">
                <i class="fab fa-twitter text-2xl"></i>
            </a>
            <a href="https://in.pinterest.com/leelijaa/" class="text-gray-500 hover:text-orange-500 transition-colors duration-300" aria-label="Pinterest">
                <i class="fab fa-pinterest-p text-2xl"></i>
            </a>
            <a href="https://www.linkedin.com/in/leelija" class="text-gray-500 hover:text-orange-500 transition-colors duration-300" aria-label="LinkedIn">
                <i class="fab fa-linkedin-in text-2xl"></i>
            </a>
        </div>
    </div>

    <!-- Decorative Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-32 h-32 bg-orange-100 rounded-full opacity-20 newAnimate-float-slow"></div>
        <div class="absolute bottom-1/4 right-1/4 w-24 h-24 bg-orange-200 rounded-full opacity-20 newAnimate-float-reverse"></div>
        <div class="absolute top-1/3 right-1/3 w-16 h-16 bg-orange-300 rounded-full opacity-20 animate-pulse"></div>
    </div>
</div>



@endsection

@section('scripts')

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add animation class to elements after page load
    const elements = document.querySelectorAll('h1, h2, p, .animate-on-load');
    elements.forEach((el, index) => {
        setTimeout(() => {
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
        }, 100 * index);
    });
});
</script>
@endsection