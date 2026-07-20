@extends('layout.web.main-layout')

@section('title', 'Custom Design Studio | Personalize Your Perfect Outfit')
@section('meta-description', 'Work with our expert designers to create custom-made outfits tailored to your style, measurements, and occasion.')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Hero Background */
    .hero-bg {
        background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.3)), url('https://images.unsplash.com/photo-1490481651871-ab68de25d43d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    @media (max-width: 768px) {
        .hero-bg {
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.4)), url('https://images.unsplash.com/photo-1526178613552-2b45c6c302f0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');
        }
    }

    /* Button Styles */
    .cta-button,
    .appointment-btn,
    .submit-btn,
    .profile-btn,
    .btn-primary {
        background-color: #EC4899;
        color: white;
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
        border: none;
        cursor: pointer;
    }

    .cta-button:hover,
    .appointment-btn:hover,
    .submit-btn:hover,
    .profile-btn:hover,
    .btn-primary:hover {
        background-color: #FCE7F3;
        color: #831843;
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(236, 72, 153, 0.25);
    }

    .cta-button::after,
    .appointment-btn::after,
    .btn-primary::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.7s ease;
    }

    .cta-button:hover::after,
    .appointment-btn:hover::after,
    .btn-primary:hover::after {
        left: 100%;
    }

    /* Animation Classes */
    .fade-up,
    .fade-in,
    .fade-in-left,
    .fade-in-right,
    .slide-up {
        opacity: 0;
        transition: all 0.8s ease-out;
    }

    .fade-up {
        transform: translateY(30px);
    }

    .fade-in {
        opacity: 0;
    }

    .fade-in-left {
        transform: translateX(-30px);
    }

    .fade-in-right {
        transform: translateX(30px);
    }

    .slide-up {
        transform: translateY(20px);
        transition-delay: 0.3s;
    }

    .fade-up.visible,
    .fade-in.visible,
    .fade-in-left.visible,
    .fade-in-right.visible,
    .slide-up.visible {
        opacity: 1;
        transform: translate(0);
    }

    /* Hover Effects */
    .hover-lift,
    .hover-float,
    .hover-scale,
    .testimonial-card,
    .step-card,
    .feature-card,
    .stat-item {
        transition: all 0.4s ease;
    }

    .hover-lift:hover,
    .testimonial-card:hover,
    .step-card:hover,
    .feature-card:hover,
    .stat-item:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.08);
    }

    /* Text Gradient */
    .text-gradient {
        background: linear-gradient(135deg, #EC4899 0%, #F472B6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Client Photo */
    .client-photo {
        border: 4px solid white;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .testimonial-card:hover .client-photo {
        transform: scale(1.05);
        border-color: #FCE7F3;
    }

    /* Step Badge */
    .step-badge {
        background-color: #EC4899;
        color: white;
        transition: all 0.3s ease;
    }

    .step-card:hover .step-badge {
        transform: scale(1.1);
        box-shadow: 0 10px 20px rgba(236, 72, 153, 0.2);
    }

    /* Icon Wrapper */
    .icon-wrapper {
        transition: all 0.3s ease;
    }

    .feature-card:hover .icon-wrapper {
        transform: scale(1.1);
    }

    /* Calendar Styles */
    .calendar-day {
        transition: all 0.2s ease;
        border: none;
        background: none;
        cursor: pointer;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .calendar-day:hover:not(.calendar-day-disabled) {
        background-color: #FCE7F3;
        color: #831843;
    }

    .calendar-day-selected {
        background-color: #EC4899;
        color: white;
    }

    .calendar-day-disabled {
        color: #9ca3af;
        cursor: not-allowed;
    }

    /* Time Slot */
    .time-slot {
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
        padding: 0.75rem 1rem;
        border-radius: 0.75rem;
        font-size: 0.875rem;
        font-weight: 500;
        background-color: #f9fafb;
        color: #4b5563;
    }

    .time-slot:hover:not(.time-slot-booked) {
        background-color: #FCE7F3;
        color: #831843;
    }

    .time-slot-selected {
        background-color: #EC4899 !important;
        color: white !important;
    }

    .time-slot-booked {
        background-color: #f3f4f6;
        color: #9ca3af;
        cursor: not-allowed;
    }

    /* Form Styles */
    .form-input,
    .form-select {
        width: 100%;
        padding: 0.875rem 1.25rem;
        border: 1px solid #e5e7eb;
        border-radius: 9999px;
        font-size: 1rem;
        transition: all 0.2s ease;
    }

    .form-input:focus,
    .form-select:focus {
        border-color: #EC4899;
        box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1);
        outline: none;
    }

    /* Designer Image Container */
    .designer-image-container {
        position: relative;
        overflow: hidden;
        border-radius: 1.5rem;
    }

    /* Connector Line */
    .connector-line {
        position: absolute;
        height: 2px;
        background: linear-gradient(90deg, #EC4899, #FCE7F3);
        top: 50%;
        left: 0;
        right: 0;
        transform: translateY(-50%);
    }

    .connector-dot {
        width: 12px;
        height: 12px;
        background-color: #EC4899;
        border-radius: 50%;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
    }

    .connector-dot:nth-child(1) {
        left: 25%;
    }

    .connector-dot:nth-child(2) {
        left: 50%;
    }

    .connector-dot:nth-child(3) {
        left: 75%;
    }

    /* Stat Badge */
    .stat-badge {
        display: inline-block;
        padding: 0.5rem 1.25rem;
        background-color: #FCE7F3;
        color: #831843;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* Section Heading */
    .section-heading {
        font-weight: 300;
        line-height: 1.2;
    }

    /* Calendar Grid Responsive */
    @media (max-width: 640px) {
        .calendar-day {
            width: 35px;
            height: 35px;
            font-size: 0.75rem;
        }

        .time-slot {
            padding: 0.625rem 0.75rem;
            font-size: 0.75rem;
        }

        .form-input,
        .form-select {
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
        }
    }
</style>

<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-pink-50 via-white to-purple-50 overflow-hidden">
    <!-- Background Image with Overlay -->
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-black/30 z-10"></div>
        <img src="{{asset('web/images/section-banner/couple-banner.webp')}}"
            alt="Fashion background"
            class="w-full h-full object-cover object-top">
    </div>

    <!-- Simple decorative elements (adjusted opacity for overlay) -->
    <div class="absolute top-0 right-0 w-64 h-64 bg-pink-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob z-20"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000 z-20"></div>

    <div class="relative z-30 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
        <div class="grid lg:grid-cols-2 gap-12 items-center">

            <!-- Left Content -->
            <div class="text-center lg:text-left">
                <!-- Badge -->
                <a href="#appoint-book-section" class="inline-flex items-center bg-pink-100/95 backdrop-blur-sm text-pink-700 px-4 py-2 rounded-full text-sm font-medium mb-6 shadow-lg">
                    <i class="fas fa-calendar-check mr-2"></i>
                    Book Your Session
                </a>

                <!-- Main Heading -->
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight drop-shadow-lg">
                    Style that
                    <span class="bg-gradient-to-r from-pink-300 to-purple-300 bg-clip-text text-transparent">fits you</span>
                    perfectly
                </h1>

                <!-- Subtext -->
                <p class="text-lg md:text-xl text-white/90 mb-8 max-w-lg mx-auto lg:mx-0 drop-shadow">
                    Schedule a 1-on-1 session with our stylists. Get personalized advice, find your perfect fit, and transform your wardrobe.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col md:flex-row gap-4 justify-center lg:justify-start">
                    <a href="#appoint-book-section" class="bg-pink-500 text-white px-8 py-4 rounded-full font-medium hover:bg-pink-600 transition-all transform hover:scale-105 shadow-lg hover:shadow-xl inline-flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-calendar-alt mr-3"></i>
                        Book Free Consultation
                    </a>
                    <button class="bg-white/20 backdrop-blur-sm text-white px-8 py-4 rounded-full font-medium border border-white/30 hover:border-white hover:bg-white/30 transition-all inline-flex items-center justify-center shadow-lg">
                        <i class="fas fa-play-circle mr-3"></i>
                        See How It Works
                    </button>
                </div>

                <!-- Trust Badges - Updated for dark background -->
                <div class="mt-10 flex flex-wrap items-center gap-6 justify-center lg:justify-start">
                    <div class="flex items-center bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full">
                        <div class="flex -space-x-2">
                            <img class="w-8 h-8 rounded-full border-2 border-white" src="https://randomuser.me/api/portraits/women/44.jpg" alt="">
                            <img class="w-8 h-8 rounded-full border-2 border-white" src="https://randomuser.me/api/portraits/women/68.jpg" alt="">
                            <img class="w-8 h-8 rounded-full border-2 border-white" src="https://randomuser.me/api/portraits/women/65.jpg" alt="">
                        </div>
                        <span class="ml-3 text-sm text-white">
                            <span class="font-semibold text-white">500+</span> happy clients
                        </span>
                    </div>
                    <div class="flex items-center bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full">
                        <div class="flex text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="ml-2 text-sm text-white">4.9/5</span>
                    </div>
                </div>
            </div>

            <!-- Right Content - Simple Calendar Preview -->
            <a href="#appoint-book-section" class="hidden lg:block" id="calendarWrapper">
                <div class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-8 transform rotate-1 hover:rotate-0 transition-transform">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="font-semibold text-gray-900" id="monthYearDisplay">March 2024</h3>
                        <div class="flex gap-2">
                            <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center cursor-pointer hover:bg-pink-100" id="prevMonthBtn">
                                <i class="fas fa-chevron-left text-sm text-gray-600"></i>
                            </div>
                            <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center cursor-pointer hover:bg-pink-100" id="nextMonthBtn">
                                <i class="fas fa-chevron-right text-sm text-gray-600"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Day Names -->
                    <div class="grid grid-cols-7 gap-1 mb-4" id="dayNames">
                        <div class="text-xs text-gray-400 text-center">S</div>
                        <div class="text-xs text-gray-400 text-center">M</div>
                        <div class="text-xs text-gray-400 text-center">T</div>
                        <div class="text-xs text-gray-400 text-center">W</div>
                        <div class="text-xs text-gray-400 text-center">T</div>
                        <div class="text-xs text-gray-400 text-center">F</div>
                        <div class="text-xs text-gray-400 text-center">S</div>
                    </div>

                    <!-- Calendar Grid -->
                    <div class="grid grid-cols-7 gap-1" id="calendarGrid">
                        <!-- JS will populate this -->
                    </div>

                    <!-- Available Slots -->
                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600" id="availabilityLabel">Available tomorrow</span>
                            <span class="text-sm font-medium text-pink-600" id="availabilityTime">9:00 AM - 4:00 PM</span>
                        </div>
                        <div class="mt-3 flex gap-2" id="slotContainer">
                            <span class="text-xs bg-green-100 text-green-700 px-3 py-1.5 rounded-full">10:30 AM</span>
                            <span class="text-xs bg-green-100 text-green-700 px-3 py-1.5 rounded-full">1:00 PM</span>
                            <span class="text-xs bg-green-100 text-green-700 px-3 py-1.5 rounded-full">3:30 PM</span>
                        </div>
                    </div>

                    <!-- Booking Badge -->
                    <div class="mt-4 flex items-center text-sm text-gray-500">
                        <i class="fas fa-clock text-pink-400 mr-2"></i>
                        <span>60 min session • Free rescheduling</span>
                    </div>
                </div>
            </a>
        </div>

        <!-- Simple Stats Bar - Updated for dark background -->
        <div class="mt-16 pt-8 grid grid-cols-2 md:grid-cols-4 gap-8 border-t border-white/30">
            <div class="text-center">
                <div class="text-2xl font-bold text-white">15+</div>
                <div class="text-sm text-white/80">Expert Stylists</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-white">5k+</div>
                <div class="text-sm text-white/80">Sessions Done</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-white">98%</div>
                <div class="text-sm text-white/80">Satisfaction</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-white">24h</div>
                <div class="text-sm text-white/80">Fast Booking</div>
            </div>
        </div>
    </div>
</section>

<style>
    @keyframes blob {
        0% {
            transform: scale(1);
        }

        33% {
            transform: scale(1.1);
        }

        66% {
            transform: scale(0.9);
        }

        100% {
            transform: scale(1);
        }
    }

    .animate-blob {
        animation: blob 7s infinite;
    }

    .animation-delay-2000 {
        animation-delay: 2s;
    }
</style>

<!-- Why Book an Appointment? Section -->
<section class="bg-white py-16 md:py-24 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Section Header -->
        <div class="text-center mb-12 md:mb-16 fade-up">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-light text-gray-900 mb-4 md:mb-6">
                Why Book an Appointment?
            </h2>
            <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto px-4">
                Our personal styling experience is designed to transform your wardrobe and elevate your style with expert guidance tailored just for you.
            </p>
            <div class="w-20 md:w-24 h-1 bg-pink-400 mx-auto mt-6 md:mt-8"></div>
        </div>

        <!-- Feature Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
            <!-- Card 1 -->
            <div class="feature-card bg-white rounded-2xl p-6 md:p-8 shadow-md hover:shadow-xl fade-up">
                <div class="icon-wrapper w-14 md:w-16 h-14 md:h-16 rounded-full bg-pink-50 flex items-center justify-center mb-4 md:mb-6 mx-auto">
                    <i class="fas fa-user-friends text-xl md:text-2xl text-[#EC4899]"></i>
                </div>
                <h3 class="text-lg md:text-xl font-semibold text-gray-900 mb-3 md:mb-4 text-center">
                    Personal Style Consultation
                </h3>
                <p class="text-sm md:text-base text-gray-600 text-center leading-relaxed">
                    One-on-one session with our expert stylists to understand your lifestyle, preferences, and style goals.
                </p>
                <div class="mt-4 md:mt-6 pt-4 md:pt-6 border-t border-gray-100 text-center">
                    <span class="text-xs md:text-sm font-medium text-pink-500">60 min session</span>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="feature-card bg-white rounded-2xl p-6 md:p-8 shadow-md hover:shadow-xl fade-up">
                <div class="icon-wrapper w-14 md:w-16 h-14 md:h-16 rounded-full bg-pink-50 flex items-center justify-center mb-4 md:mb-6 mx-auto">
                    <i class="fas fa-ruler-combined text-xl md:text-2xl text-[#EC4899]"></i>
                </div>
                <h3 class="text-lg md:text-xl font-semibold text-gray-900 mb-3 md:mb-4 text-center">
                    Custom Fit Guidance
                </h3>
                <p class="text-sm md:text-base text-gray-600 text-center leading-relaxed">
                    Learn how clothing should fit your unique body type. Get expert advice on alterations and sizing.
                </p>
                <div class="mt-4 md:mt-6 pt-4 md:pt-6 border-t border-gray-100 text-center">
                    <span class="text-xs md:text-sm font-medium text-pink-500">Body measurements included</span>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="feature-card bg-white rounded-2xl p-6 md:p-8 shadow-md hover:shadow-xl fade-up">
                <div class="icon-wrapper w-14 md:w-16 h-14 md:h-16 rounded-full bg-pink-50 flex items-center justify-center mb-4 md:mb-6 mx-auto">
                    <i class="fas fa-palette text-xl md:text-2xl text-[#EC4899]"></i>
                </div>
                <h3 class="text-lg md:text-xl font-semibold text-gray-900 mb-3 md:mb-4 text-center">
                    Fabric & Color Selection
                </h3>
                <p class="text-sm md:text-base text-gray-600 text-center leading-relaxed">
                    Discover which fabrics and colors complement your skin tone and lifestyle.
                </p>
                <div class="mt-4 md:mt-6 pt-4 md:pt-6 border-t border-gray-100 text-center">
                    <span class="text-xs md:text-sm font-medium text-pink-500">Color palette analysis</span>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="feature-card bg-white rounded-2xl p-6 md:p-8 shadow-md hover:shadow-xl fade-up sm:col-span-2 lg:col-span-1">
                <div class="icon-wrapper w-14 md:w-16 h-14 md:h-16 rounded-full bg-pink-50 flex items-center justify-center mb-4 md:mb-6 mx-auto">
                    <i class="fas fa-crown text-xl md:text-2xl text-[#EC4899]"></i>
                </div>
                <h3 class="text-lg md:text-xl font-semibold text-gray-900 mb-3 md:mb-4 text-center">
                    Designer Recommendations
                </h3>
                <p class="text-sm md:text-base text-gray-600 text-center leading-relaxed">
                    Receive curated suggestions from our collection of designers that align with your style.
                </p>
                <div class="mt-4 md:mt-6 pt-4 md:pt-6 border-t border-gray-100 text-center">
                    <span class="text-xs md:text-sm font-medium text-pink-500">Personalized lookbook</span>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="mt-16 md:mt-20 pt-10 md:pt-12 border-t border-gray-100">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 md:gap-8 text-center">
                <div class="fade-up">
                    <div class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-2">98%</div>
                    <div class="text-sm md:text-base text-gray-600">Client satisfaction rate</div>
                </div>
                <div class="fade-up">
                    <div class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-2">5,000+</div>
                    <div class="text-sm md:text-base text-gray-600">Successful styling sessions</div>
                </div>
                <div class="fade-up">
                    <div class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-2">50+</div>
                    <div class="text-sm md:text-base text-gray-600">Expert stylists</div>
                </div>
            </div>
        </div>

        <!-- CTA Button -->
        <div class="mt-12 md:mt-16 text-center fade-up">
            <a href="#appoint-book-section" class="bg-[#EC4899] text-white font-medium py-3 md:py-4 px-8 md:px-10 rounded-full text-base md:text-lg shadow-lg hover:bg-pink-600 transition duration-300 inline-flex items-center justify-center">
                <i class="fas fa-calendar-alt mr-2 md:mr-3"></i> Book Your Appointment Now
            </a>
            <p class="text-xs md:text-sm text-gray-500 mt-4 md:mt-6">Flexible scheduling • Virtual or in-person • No commitment required</p>
        </div>
    </div>
</section>

{{--
<!-- Appointment Booking Section -->
<section class="relative py-16 md:py-24 px-4 sm:px-6 lg:px-8 overflow-hidden">
    <!-- Background Image with Overlay -->
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-br from-pink-900/40 via-purple-900/30 to-gray-900/40 z-10"></div>
        <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=1600&auto=format&fit=crop" 
             alt="Luxury fashion background" 
             class="w-full h-full object-cover">
    </div>
    
    <!-- Decorative Elements -->
    <div class="absolute top-20 right-20 w-96 h-96 bg-pink-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob z-20"></div>
    <div class="absolute bottom-20 left-20 w-96 h-96 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000 z-20"></div>
    
    <div class="relative z-30 max-w-7xl mx-auto">
        <!-- Section Header - Updated for dark background -->
        <div class="text-center mb-8 md:mb-12 fade-up">
            <span class="stat-badge inline-block px-4 py-2 bg-white/20 backdrop-blur-sm text-white border border-white/30 rounded-full text-xs md:text-sm font-semibold uppercase tracking-wider shadow-lg">
                <i class="fas fa-calendar-alt mr-2 text-pink-200"></i>booking calendar
            </span>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-light text-white mt-4 md:mt-6 mb-3 md:mb-4 drop-shadow-lg">Reserve your hour</h2>
            <p class="text-sm md:text-base text-white/90 max-w-xl mx-auto px-4 drop-shadow">Pick a date, choose your slot — we'll take it from there.</p>
        </div>

        <!-- Booking Card - Enhanced with backdrop blur -->
        <div class="bg-white/90 backdrop-blur-md rounded-3xl md:rounded-[40px] shadow-2xl border border-white/60 p-5 sm:p-7 md:p-10 fade-in">
            <div class="grid lg:grid-cols-2 gap-6 md:gap-10">
                <!-- LEFT: CALENDAR -->
                <div>
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-5 md:mb-7 gap-4">
                        <h3 class="text-xl md:text-2xl font-light text-gray-800">Select date</h3>
                        <div class="flex items-center gap-2 md:gap-3">
                            <button id="prev-month" class="w-10 md:w-12 h-10 md:h-12 rounded-full border border-gray-200 hover:bg-pink-100 transition flex items-center justify-center bg-white shadow-sm">
                                <i class="fas fa-chevron-left text-pink-600 text-sm md:text-base"></i>
                            </button>
                            <span id="current-month" class="text-sm md:text-lg font-medium text-gray-800 py-2 px-3 md:py-3 md:px-4 bg-gradient-to-r from-pink-50 to-purple-50 rounded-full shadow-sm">February 2025</span>
                            <button id="next-month" class="w-10 md:w-12 h-10 md:h-12 rounded-full border border-gray-200 hover:bg-pink-100 transition flex items-center justify-center bg-white shadow-sm">
                                <i class="fas fa-chevron-right text-pink-600 text-sm md:text-base"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Day Names -->
                    <div class="grid grid-cols-7 gap-1 mb-2 md:mb-3 text-center">
                        <div class="text-xs md:text-sm font-medium text-gray-500">S</div>
                        <div class="text-xs md:text-sm font-medium text-gray-500">M</div>
                        <div class="text-xs md:text-sm font-medium text-gray-500">T</div>
                        <div class="text-xs md:text-sm font-medium text-gray-500">W</div>
                        <div class="text-xs md:text-sm font-medium text-gray-500">T</div>
                        <div class="text-xs md:text-sm font-medium text-gray-500">F</div>
                        <div class="text-xs md:text-sm font-medium text-gray-500">S</div>
                    </div>

                    <!-- Calendar Grid -->
                    <div id="calendar-grid" class="grid grid-cols-7 gap-1 mb-6 md:mb-8 justify-items-center"></div>

                    <!-- Selected Date Display - Enhanced styling -->
                    <div class="bg-gradient-to-r from-gray-50 to-white rounded-2xl p-4 md:p-5 flex items-center gap-3 md:gap-4 shadow-sm border border-gray-100">
                        <div class="w-10 md:w-12 h-10 md:h-12 rounded-full bg-gradient-to-br from-pink-500 to-purple-600 shadow-md flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-calendar text-white text-sm md:text-base"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-gray-500 uppercase tracking-wider">Your selected date</p>
                            <p id="selected-date-display" class="text-base md:text-lg font-medium text-gray-900 mt-1 truncate">No date selected</p>
                        </div>
                    </div>
                </div>

                <!-- RIGHT: TIME SLOTS + FORM -->
                <div>
                    <div class="mb-6 md:mb-10">
                        <h3 class="text-xl md:text-2xl font-light text-gray-800 mb-4 md:mb-5">Available time</h3>
                        <div id="time-slots" class="grid grid-cols-2 sm:grid-cols-3 gap-2 md:gap-3"></div>
                        <div id="selected-time-display" class="hidden mt-5 md:mt-7 bg-gradient-to-r from-gray-50 to-white rounded-2xl p-4 flex items-center gap-3 md:gap-4 shadow-sm border border-gray-100">
                            <div class="w-8 md:w-10 h-8 md:h-10 rounded-full bg-gradient-to-br from-pink-500 to-purple-600 flex items-center justify-center flex-shrink-0 shadow-md">
                                <i class="fas fa-clock text-white text-sm md:text-base"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Your time</p>
                                <p id="selected-time-text" class="text-sm md:text-base font-medium text-gray-800"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Form - Enhanced styling -->
                    <form id="appointment-form" class="space-y-4 md:space-y-5">
                        <div>
                            <input type="text" id="full-name" placeholder="Full name" 
                                   class="w-full px-4 md:px-5 py-3 md:py-3.5 text-sm md:text-base rounded-xl border border-gray-200 focus:border-pink-300 focus:ring focus:ring-pink-200 focus:ring-opacity-50 transition bg-white/90 backdrop-blur-sm" 
                                   required>
                        </div>
                        <div>
                            <input type="email" id="email" placeholder="Email address" 
                                   class="w-full px-4 md:px-5 py-3 md:py-3.5 text-sm md:text-base rounded-xl border border-gray-200 focus:border-pink-300 focus:ring focus:ring-pink-200 focus:ring-opacity-50 transition bg-white/90 backdrop-blur-sm" 
                                   required>
                        </div>
                        <div>
                            <input type="tel" id="phone" placeholder="Phone (optional)" 
                                   class="w-full px-4 md:px-5 py-3 md:py-3.5 text-sm md:text-base rounded-xl border border-gray-200 focus:border-pink-300 focus:ring focus:ring-pink-200 focus:ring-opacity-50 transition bg-white/90 backdrop-blur-sm">
                        </div>
                        <div>
                            <select id="appointment-type" 
                                    class="w-full px-4 md:px-5 py-3 md:py-3.5 text-sm md:text-base rounded-xl border border-gray-200 focus:border-pink-300 focus:ring focus:ring-pink-200 focus:ring-opacity-50 transition bg-white/90 backdrop-blur-sm">
                                <option value="" disabled selected>I'd prefer ...</option>
                                <option value="virtual">Virtual (video call)</option>
                                <option value="in-store">In-store</option>
                            </select>
                        </div>
                        <button type="submit" 
                                class="w-full mt-5 md:mt-7 py-3 md:py-4 px-6 rounded-full text-sm md:text-base font-medium inline-flex items-center justify-center bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700 text-white shadow-lg hover:shadow-xl transform hover:scale-[1.02] transition-all duration-300">
                            <i class="fas fa-check-circle mr-2"></i> Confirm appointment
                        </button>
                        <p class="text-gray-500 text-xs md:text-sm text-center pt-2 md:pt-3">
                            <i class="fas fa-shield-alt mr-1 text-pink-500"></i> No commitment · free to reschedule
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
--}}

<!-- Appointment Booking Section with Calendly -->
<section id="appoint-book-section" class="relative py-16 md:py-24 px-4 sm:px-6 lg:px-8 overflow-hidden">
    <!-- Background Image with Overlay (keep the same) -->
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-br from-pink-900/40 via-purple-900/30 to-gray-900/40 z-10"></div>
        <img src="{{asset('web/images/section-banner/couple-banner-2.webp')}}"
            alt="Luxury fashion background"
            class="w-full h-full object-cover object-top">
    </div>

    <!-- Decorative Elements (keep the same) -->
    <div class="absolute top-20 right-20 w-96 h-96 bg-pink-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob z-20"></div>
    <div class="absolute bottom-20 left-20 w-96 h-96 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000 z-20"></div>

    <div class="relative z-30 max-w-7xl mx-auto">
        <!-- Section Header -->
        <div class="text-center mb-8 md:mb-12 fade-up">
            <span class="stat-badge inline-block px-4 py-2 bg-white/20 backdrop-blur-sm text-white border border-white/30 rounded-full text-xs md:text-sm font-semibold uppercase tracking-wider shadow-lg">
                <i class="fas fa-calendar-alt mr-2 text-pink-200"></i>booking calendar
            </span>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-light text-white mt-4 md:mt-6 mb-3 md:mb-4 drop-shadow-lg">Reserve your hour</h2>
            <p class="text-sm md:text-base text-white/90 max-w-xl mx-auto px-4 drop-shadow">Pick a date, choose your slot — we'll take it from there.</p>
        </div>

        <!-- Calendly Widget Container -->
        {{--
        <div class="">
            <div class="calendly-inline-widget"
                data-url="https://calendly.com/susmitaghosh-leelija/30min?primary_color={{ config('colors.primary', 'A10000') }}&text_color={{ config('colors.secondary', 'EC4899') }}&background_color={{ config('colors.secondary-light', 'FCE7F3') }}&hide_gdpr_banner=1"
        style="min-width:320px;height:700px;">
    </div>
    </div>
    --}}


    <!-- Calendly Widget Container -->

    <div class="">
        @php
        $calendlyUrl = env('CALENDLY_URL') ?: 'https://calendly.com/aiman-royale/30min';
        $primaryColor = env('CALENDLY_PRIMARY_COLOR', '#0066FF');
        $textColor = env('CALENDLY_TEXT_COLOR', '#FFFFFF');
        $backgroundColor = env('CALENDLY_BACKGROUND_COLOR', '#FFFFFF');
        @endphp

        <div class="calendly-inline-widget"
            data-url="{{ $calendlyUrl }}?primary_color={{ $primaryColor }}&text_color={{ $textColor }}&background_color={{ $backgroundColor }}&hide_gdpr_banner=1"
            style="min-width:320px;height:700px;">
        </div>
    </div>

    </div>
</section>


<style>
    @keyframes blob {
        0% {
            transform: scale(1);
        }

        33% {
            transform: scale(1.1);
        }

        66% {
            transform: scale(0.9);
        }

        100% {
            transform: scale(1);
        }
    }

    .animate-blob {
        animation: blob 7s infinite;
    }

    .animation-delay-2000 {
        animation-delay: 2s;
    }

    .fade-up {
        animation: fadeUp 0.6s ease-out;
    }

    .fade-in {
        animation: fadeIn 0.8s ease-out;
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }
</style>

<!-- What Happens During Your Appointment Section -->
<section class="bg-white py-16 md:py-24 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Section Header -->
        <div class="text-center mb-12 md:mb-16 fade-up">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-light text-gray-900 mb-4 md:mb-6">
                What Happens During Your Appointment
            </h2>
            <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto px-4 leading-relaxed">
                Experience a personalized styling journey designed to understand your unique style and create a wardrobe that reflects your personality.
            </p>
            <div class="w-20 md:w-24 h-1 bg-pink-400 mx-auto mt-6 md:mt-8"></div>
        </div>

        <!-- Steps with Connector Lines (Desktop) -->
        <div class="hidden md:block relative px-4">
            <!-- Connector Line -->
            <div class="connector-line absolute top-1/2 left-0 right-0 -translate-y-1/2 z-0">
                <div class="connector-dot"></div>
                <div class="connector-dot"></div>
                <div class="connector-dot"></div>
            </div>

            <!-- Step Cards -->
            <div class="relative z-10 grid grid-cols-3 gap-6 lg:gap-8">
                <!-- Step 1 -->
                <div class="step-card bg-white rounded-2xl p-6 lg:p-8 shadow-lg hover:shadow-xl">
                    <div class="step-badge w-14 lg:w-16 h-14 lg:h-16 rounded-full flex items-center justify-center text-xl lg:text-2xl font-bold mb-6 lg:mb-8 mx-auto">
                        1
                    </div>
                    <h3 class="text-xl lg:text-2xl font-semibold text-gray-900 mb-4 lg:mb-6 text-center">
                        Discuss Your Style
                    </h3>
                    <div class="mb-6 lg:mb-8">
                        <div class="w-16 lg:w-20 h-1 bg-pink-300 mx-auto mb-4 lg:mb-6"></div>
                        <div class="space-y-3 lg:space-y-4">
                            <div class="flex items-start">
                                <i class="fas fa-check text-pink-500 mt-1 mr-2 lg:mr-3 text-sm lg:text-base"></i>
                                <p class="text-sm lg:text-base text-gray-600">Share your style preferences and needs</p>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-check text-pink-500 mt-1 mr-2 lg:mr-3 text-sm lg:text-base"></i>
                                <p class="text-sm lg:text-base text-gray-600">Discuss comfort zone and style goals</p>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-check text-pink-500 mt-1 mr-2 lg:mr-3 text-sm lg:text-base"></i>
                                <p class="text-sm lg:text-base text-gray-600">Define your color palette</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4 lg:p-5">
                        <div class="flex items-center">
                            <div class="w-8 lg:w-10 h-8 lg:h-10 rounded-full bg-pink-100 flex items-center justify-center mr-2 lg:mr-3">
                                <i class="fas fa-clock text-pink-500 text-sm lg:text-base"></i>
                            </div>
                            <div>
                                <p class="text-xs lg:text-sm text-gray-500">Duration</p>
                                <p class="text-sm lg:text-base font-medium">20-25 minutes</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="step-card bg-white rounded-2xl p-6 lg:p-8 shadow-lg hover:shadow-xl">
                    <div class="step-badge w-14 lg:w-16 h-14 lg:h-16 rounded-full flex items-center justify-center text-xl lg:text-2xl font-bold mb-6 lg:mb-8 mx-auto">
                        2
                    </div>
                    <h3 class="text-xl lg:text-2xl font-semibold text-gray-900 mb-4 lg:mb-6 text-center">
                        Explore Fabrics
                    </h3>
                    <div class="mb-6 lg:mb-8">
                        <div class="w-16 lg:w-20 h-1 bg-pink-300 mx-auto mb-4 lg:mb-6"></div>
                        <div class="space-y-3 lg:space-y-4">
                            <div class="flex items-start">
                                <i class="fas fa-check text-pink-500 mt-1 mr-2 lg:mr-3 text-sm lg:text-base"></i>
                                <p class="text-sm lg:text-base text-gray-600">Touch fabric samples and textures</p>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-check text-pink-500 mt-1 mr-2 lg:mr-3 text-sm lg:text-base"></i>
                                <p class="text-sm lg:text-base text-gray-600">Explore design options & patterns</p>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-check text-pink-500 mt-1 mr-2 lg:mr-3 text-sm lg:text-base"></i>
                                <p class="text-sm lg:text-base text-gray-600">Review seasonal trends</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4 lg:p-5">
                        <div class="flex items-center">
                            <div class="w-8 lg:w-10 h-8 lg:h-10 rounded-full bg-pink-100 flex items-center justify-center mr-2 lg:mr-3">
                                <i class="fas fa-tshirt text-pink-500 text-sm lg:text-base"></i>
                            </div>
                            <div>
                                <p class="text-xs lg:text-sm text-gray-500">Includes</p>
                                <p class="text-sm lg:text-base font-medium">Fabric swatch book</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="step-card bg-white rounded-2xl p-6 lg:p-8 shadow-lg hover:shadow-xl">
                    <div class="step-badge w-14 lg:w-16 h-14 lg:h-16 rounded-full flex items-center justify-center text-xl lg:text-2xl font-bold mb-6 lg:mb-8 mx-auto">
                        3
                    </div>
                    <h3 class="text-xl lg:text-2xl font-semibold text-gray-900 mb-4 lg:mb-6 text-center">
                        Measurements & Planning
                    </h3>
                    <div class="mb-6 lg:mb-8">
                        <div class="w-16 lg:w-20 h-1 bg-pink-300 mx-auto mb-4 lg:mb-6"></div>
                        <div class="space-y-3 lg:space-y-4">
                            <div class="flex items-start">
                                <i class="fas fa-check text-pink-500 mt-1 mr-2 lg:mr-3 text-sm lg:text-base"></i>
                                <p class="text-sm lg:text-base text-gray-600">Precise body measurements</p>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-check text-pink-500 mt-1 mr-2 lg:mr-3 text-sm lg:text-base"></i>
                                <p class="text-sm lg:text-base text-gray-600">Create your style roadmap</p>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-check text-pink-500 mt-1 mr-2 lg:mr-3 text-sm lg:text-base"></i>
                                <p class="text-sm lg:text-base text-gray-600">Receive tailored recommendations</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4 lg:p-5">
                        <div class="flex items-center">
                            <div class="w-8 lg:w-10 h-8 lg:h-10 rounded-full bg-pink-100 flex items-center justify-center mr-2 lg:mr-3">
                                <i class="fas fa-list-check text-pink-500 text-sm lg:text-base"></i>
                            </div>
                            <div>
                                <p class="text-xs lg:text-sm text-gray-500">You Receive</p>
                                <p class="text-sm lg:text-base font-medium">Personalized style guide</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Steps -->
        <div class="md:hidden space-y-6">
            <!-- Step 1 Mobile -->
            <div class="step-card bg-white rounded-2xl p-6 shadow-lg">
                <div class="flex items-start mb-4">
                    <div class="step-badge w-12 h-12 rounded-full flex items-center justify-center text-lg font-bold mr-4 flex-shrink-0">
                        1
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 pt-2">
                        Discuss Your Style
                    </h3>
                </div>
                <div class="mb-4 ml-16">
                    <div class="space-y-2">
                        <div class="flex items-start">
                            <i class="fas fa-check text-pink-500 mt-1 mr-2 text-sm"></i>
                            <p class="text-sm text-gray-600">Share style preferences and needs</p>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-check text-pink-500 mt-1 mr-2 text-sm"></i>
                            <p class="text-sm text-gray-600">Discuss comfort zone</p>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-check text-pink-500 mt-1 mr-2 text-sm"></i>
                            <p class="text-sm text-gray-600">Define color palette</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 ml-16">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-pink-100 flex items-center justify-center mr-3">
                            <i class="fas fa-clock text-pink-500 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Duration: 20-25 min</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2 Mobile -->
            <div class="step-card bg-white rounded-2xl p-6 shadow-lg">
                <div class="flex items-start mb-4">
                    <div class="step-badge w-12 h-12 rounded-full flex items-center justify-center text-lg font-bold mr-4 flex-shrink-0">
                        2
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 pt-2">
                        Explore Fabrics
                    </h3>
                </div>
                <div class="mb-4 ml-16">
                    <div class="space-y-2">
                        <div class="flex items-start">
                            <i class="fas fa-check text-pink-500 mt-1 mr-2 text-sm"></i>
                            <p class="text-sm text-gray-600">Touch fabric samples</p>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-check text-pink-500 mt-1 mr-2 text-sm"></i>
                            <p class="text-sm text-gray-600">Explore design options</p>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-check text-pink-500 mt-1 mr-2 text-sm"></i>
                            <p class="text-sm text-gray-600">Review seasonal trends</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 ml-16">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-pink-100 flex items-center justify-center mr-3">
                            <i class="fas fa-tshirt text-pink-500 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Fabric swatch book</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3 Mobile -->
            <div class="step-card bg-white rounded-2xl p-6 shadow-lg">
                <div class="flex items-start mb-4">
                    <div class="step-badge w-12 h-12 rounded-full flex items-center justify-center text-lg font-bold mr-4 flex-shrink-0">
                        3
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 pt-2">
                        Measurements
                    </h3>
                </div>
                <div class="mb-4 ml-16">
                    <div class="space-y-2">
                        <div class="flex items-start">
                            <i class="fas fa-check text-pink-500 mt-1 mr-2 text-sm"></i>
                            <p class="text-sm text-gray-600">Precise measurements</p>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-check text-pink-500 mt-1 mr-2 text-sm"></i>
                            <p class="text-sm text-gray-600">Style roadmap</p>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-check text-pink-500 mt-1 mr-2 text-sm"></i>
                            <p class="text-sm text-gray-600">Tailored recommendations</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 ml-16">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-pink-100 flex items-center justify-center mr-3">
                            <i class="fas fa-list-check text-pink-500 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Style guide included</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Appointment Outcome -->
        <div class="mt-16 md:mt-20 fade-up px-4">
            <div class="bg-gradient-to-r from-pink-50 to-white rounded-2xl p-6 md:p-8 lg:p-12 shadow-lg">
                <div class="flex flex-col md:flex-row items-center">
                    <div class="md:w-2/3 mb-6 md:mb-0 md:pr-8 lg:pr-12">
                        <h3 class="text-xl md:text-2xl font-semibold text-gray-900 mb-3 md:mb-4">After Your Appointment</h3>
                        <p class="text-sm md:text-base text-gray-600 mb-4 md:mb-6">
                            Within 48 hours, you'll receive a comprehensive digital style guide with all recommendations,
                            measurements, fabric choices, and a personalized shopping list.
                        </p>
                        <div class="flex flex-wrap gap-3 md:gap-4">
                            <div class="flex items-center">
                                <i class="fas fa-envelope text-pink-500 mr-2 text-sm"></i>
                                <span class="text-xs md:text-sm text-gray-700">Digital Style Guide</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-shopping-bag text-pink-500 mr-2 text-sm"></i>
                                <span class="text-xs md:text-sm text-gray-700">Shopping List</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-percent text-pink-500 mr-2 text-sm"></i>
                                <span class="text-xs md:text-sm text-gray-700">15% Off First Purchase</span>
                            </div>
                        </div>
                    </div>
                    <div class="md:w-1/3 w-full">
                        <div class="bg-white rounded-xl p-5 md:p-6 text-center shadow-sm">
                            <div class="w-12 md:w-16 h-12 md:h-16 rounded-full bg-pink-100 flex items-center justify-center mx-auto mb-3 md:mb-4">
                                <i class="fas fa-gift text-xl md:text-2xl text-pink-500"></i>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-2 text-base md:text-lg">Special Bonus</h4>
                            <p class="text-xs md:text-sm text-gray-600 mb-3 md:mb-4">Book first appointment & receive style starter kit.</p>
                            <a href="#appoint-book-section" class="bg-[#EC4899] text-white font-medium py-2 md:py-3 px-4 md:px-6 rounded-full text-xs md:text-sm w-full hover:bg-pink-600 transition duration-300">
                                <i class="fas fa-calendar-plus mr-2"></i> Book Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Meet Your Designer Section -->
<section class="bg-gray-50 py-16 md:py-24 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Section Title -->
        <div class="text-center mb-12 md:mb-16 fade-in-left">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-light text-gray-900 mb-4 md:mb-6">
                Meet Your <span class="text-[#EC4899]">Designer</span>
            </h2>
            <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto px-4">
                Your personal style journey begins with a dedicated fashion expert who understands your vision.
            </p>
            <div class="w-20 md:w-24 h-1 bg-pink-400 mx-auto mt-6 md:mt-8"></div>
        </div>

        <!-- Two Column Layout -->
        <div class="flex flex-col lg:flex-row items-center gap-8 lg:gap-12 xl:gap-16">
            <!-- Left Column: Designer Image -->
            <div class="lg:w-1/2 w-full mb-8 lg:mb-0 fade-in-left">
                <div class="designer-image-container shadow-2xl rounded-2xl">
                    <img
                        src="{{asset('web/images/appointment/DSC_2148 (1).webp')}}"
                        alt="Sophia Laurent - Fashion Designer"
                        class="w-full h-auto object-cover rounded-2xl">

                    <!-- Badge on Image -->
                    <div class="absolute top-4 right-4 sm:top-6 sm:right-6 bg-white rounded-full py-2 px-3 sm:px-4 shadow-lg">
                        <div class="flex items-center">
                            <div class="w-1.5 sm:w-2 h-1.5 sm:h-2 rounded-full bg-[#EC4899] mr-1.5 sm:mr-2"></div>
                            <span class="text-xs sm:text-sm font-medium text-gray-800">Lead Stylist</span>
                        </div>
                    </div>

                    <!-- Experience Badge -->
                    <div class="absolute bottom-4 left-4 sm:bottom-6 sm:left-6 bg-white rounded-xl p-3 sm:p-4 shadow-lg max-w-[200px] sm:max-w-xs">
                        <div class="flex items-center">
                            <div class="w-8 sm:w-12 h-8 sm:h-12 rounded-full bg-pink-100 flex items-center justify-center mr-2 sm:mr-4">
                                <i class="fas fa-award text-sm sm:text-xl text-[#EC4899]"></i>
                            </div>
                            <div>
                                <p class="text-xs sm:text-sm text-gray-500">Experience</p>
                                <p class="font-bold text-base sm:text-lg text-gray-900">12+ Years</p>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="text-center text-gray-500 text-xs sm:text-sm mt-3 sm:mt-4 italic">
                    Sophia in her design studio, working on a custom evening gown
                </p>
            </div>

            <!-- Right Column: Designer Info -->
            <div class="lg:w-1/2 w-full fade-in-right px-4 lg:px-0">
                <div class="mb-6 md:mb-8">
                    <div class="inline-flex items-center px-3 sm:px-4 py-1.5 sm:py-2 rounded-full bg-pink-100 text-pink-700 text-xs sm:text-sm font-medium mb-4 md:mb-6">
                        <i class="fas fa-star mr-1.5 sm:mr-2"></i>
                        Most Requested Stylist
                    </div>

                    <h3 class="text-2xl md:text-3xl lg:text-4xl font-light text-gray-900 mb-2 md:mb-4">
                        Sophia Laurent
                    </h3>

                    <p class="text-base md:text-lg text-gray-500 mb-4 md:mb-6">
                        Lead Fashion Designer & Personal Stylist
                    </p>

                    <div class="w-12 md:w-16 h-1 bg-pink-300 mb-6 md:mb-8"></div>
                </div>

                <!-- About Text -->
                <div class="mb-8 md:mb-10">
                    <p class="text-sm md:text-base lg:text-lg text-gray-700 leading-relaxed mb-4 md:mb-6">
                        With over a decade of experience in haute couture and bespoke fashion, Sophia brings a
                        <span class="font-medium text-[#EC4899]">passionate, detail-oriented approach</span> to every styling session.
                    </p>

                    <p class="text-sm md:text-base lg:text-lg text-gray-700 leading-relaxed">
                        Sophia specializes in creating
                        <span class="font-medium text-[#EC4899]">custom, personalized looks</span> that reflect her clients' personalities,
                        lifestyles, and unique beauty.
                    </p>
                </div>

                <!-- Specialties -->
                <div class="mb-8 md:mb-10">
                    <h4 class="text-lg md:text-xl font-semibold text-gray-900 mb-4 md:mb-6 flex items-center">
                        <i class="fas fa-heart text-[#EC4899] mr-2 md:mr-3"></i>
                        Specialties
                    </h4>

                    <div class="flex flex-wrap gap-2 md:gap-3 mb-6 md:mb-8">
                        <span class="bg-white px-3 py-1.5 md:px-4 md:py-2 rounded-full text-xs md:text-sm text-gray-700 shadow-sm border border-gray-100">
                            Custom Evening Wear
                        </span>
                        <span class="bg-white px-3 py-1.5 md:px-4 md:py-2 rounded-full text-xs md:text-sm text-gray-700 shadow-sm border border-gray-100">
                            Color Analysis
                        </span>
                        <span class="bg-white px-3 py-1.5 md:px-4 md:py-2 rounded-full text-xs md:text-sm text-gray-700 shadow-sm border border-gray-100">
                            Body Shape Styling
                        </span>
                        <span class="bg-white px-3 py-1.5 md:px-4 md:py-2 rounded-full text-xs md:text-sm text-gray-700 shadow-sm border border-gray-100">
                            Wardrobe Transformation
                        </span>
                    </div>
                </div>

                

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-3 md:gap-4 lg:gap-6">
                    <div class="stat-item bg-white p-4 md:p-5 lg:p-6 rounded-2xl shadow-sm text-center">
                        <div class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-900 mb-1 md:mb-2">850+</div>
                        <div class="text-xs md:text-sm text-gray-600">Happy Clients</div>
                    </div>
                    <div class="stat-item bg-white p-4 md:p-5 lg:p-6 rounded-2xl shadow-sm text-center">
                        <div class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-900 mb-1 md:mb-2">98%</div>
                        <div class="text-xs md:text-sm text-gray-600">Satisfaction</div>
                    </div>
                    <div class="stat-item bg-white p-4 md:p-5 lg:p-6 rounded-2xl shadow-sm text-center">
                        <div class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-900 mb-1 md:mb-2">Paris</div>
                        <div class="text-xs md:text-sm text-gray-600">Trained In</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Designer Philosophy -->
        <div class="mt-16 md:mt-20 pt-10 md:pt-12 border-t border-gray-200 fade-in-left px-4 lg:px-0">
            <div class="flex flex-col md:flex-row items-start gap-6 md:gap-8">
                <div class="md:w-1/3 w-full mb-4 md:mb-0">
                    <h4 class="text-xl md:text-2xl font-semibold text-gray-900 mb-3 md:mb-4">
                        <span class="text-[#EC4899]">Design</span> Philosophy
                    </h4>
                    <div class="w-12 md:w-16 h-1 bg-pink-300"></div>
                </div>
                <div class="md:w-2/3 w-full">
                    <div class="bg-white rounded-2xl p-6 md:p-8 shadow-lg">
                        <div class="flex flex-col sm:flex-row sm:items-start mb-4 md:mb-6">
                            <div class="w-10 md:w-12 h-10 md:h-12 rounded-full bg-pink-100 flex items-center justify-center mr-0 sm:mr-4 mb-3 sm:mb-0 flex-shrink-0">
                                <i class="fas fa-quote-left text-lg md:text-xl text-[#EC4899]"></i>
                            </div>
                            <p class="text-base md:text-lg italic text-gray-700">
                                "Fashion is about telling your unique story. My goal is to help every woman discover her authentic style and express it with confidence."
                            </p>
                        </div>
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <div>
                                <p class="font-medium text-gray-900">Sophia Laurent</p>
                                <p class="text-xs md:text-sm text-gray-500">Lead Designer, Élégance Boutique</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="#" class="w-8 md:w-10 h-8 md:h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-pink-100 hover:text-[#EC4899] transition">
                                    <i class="fab fa-instagram text-sm md:text-base"></i>
                                </a>
                                <a href="#" class="w-8 md:w-10 h-8 md:h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-pink-100 hover:text-[#EC4899] transition">
                                    <i class="fab fa-pinterest text-sm md:text-base"></i>
                                </a>
                                <a href="#" class="w-8 md:w-10 h-8 md:h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-pink-100 hover:text-[#EC4899] transition">
                                    <i class="fab fa-linkedin-in text-sm md:text-base"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section - Indian Women's Fashion -->
<section class="bg-white py-16 md:py-24 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Section Header -->
        <div class="text-center mb-12 md:mb-16 fade-up">
            <div class="inline-flex items-center px-3 sm:px-4 py-1.5 sm:py-2 rounded-full bg-pink-50 text-pink-700 text-xs sm:text-sm font-medium mb-4 md:mb-6">
                <i class="fas fa-heart mr-1.5 sm:mr-2"></i>
                Loved by Indian Women
            </div>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-light text-gray-900 mb-4 md:mb-6">
                Client <span class="text-[#EC4899]">Testimonials</span>
            </h2>
            <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto px-4 leading-relaxed">
                Hear from women across India who transformed their ethnic style through our personal styling appointments.
            </p>
            <div class="w-20 md:w-24 h-1 bg-pink-400 mx-auto mt-6 md:mt-8"></div>
        </div>

        <!-- Testimonial Cards Grid - Indian Clients -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 lg:gap-12 mb-12 md:mb-16">
            <!-- Testimonial 1 - Hindu / Diwali -->
            <div class="testimonial-card bg-white rounded-2xl p-6 md:p-8 shadow-lg hover:shadow-xl">
                <div class="flex justify-end mb-4 md:mb-6">
                    <i class="fas fa-quote-right text-pink-500 text-2xl md:text-3xl"></i>
                </div>
                <div class="flex mb-4 md:mb-6">
                    <i class="fas fa-star text-yellow-400 text-sm md:text-base"></i>
                    <i class="fas fa-star text-yellow-400 text-sm md:text-base ml-1"></i>
                    <i class="fas fa-star text-yellow-400 text-sm md:text-base ml-1"></i>
                    <i class="fas fa-star text-yellow-400 text-sm md:text-base ml-1"></i>
                    <i class="fas fa-star text-yellow-400 text-sm md:text-base ml-1"></i>
                </div>
                <p class="text-sm md:text-base text-gray-700 leading-relaxed italic mb-6 md:mb-8">
                    "I booked a bridal consultation for my sister's wedding during Diwali. The lehenga edit was stunning — I received so many compliments at every function!"
                </p>
                <div class="flex items-center">
                    <div class="mr-3 md:mr-4 flex-shrink-0">
                        <img
                            src="https://images.unsplash.com/photo-1531123897727-8f129e1688ce?ixlib=rb-4.0.3&auto=format&fit=crop&w=774&q=80"
                            alt="Priya Sharma"
                            class="client-photo w-12 md:w-16 h-12 md:h-16 rounded-full object-cover">
                    </div>
                    <div class="min-w-0">
                        <h4 class="text-[#EC4899] font-semibold text-sm md:text-lg truncate">Priya Sharma</h4>
                        <p class="text-gray-500 text-xs md:text-sm">Software Engineer, Bengaluru</p>
                        <p class="text-gray-400 text-xs mt-0.5 md:mt-1 truncate">Bridal Consultation · Diwali 2025</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial 2 - Muslim / Eid -->
            <div class="testimonial-card bg-white rounded-2xl p-6 md:p-8 shadow-lg hover:shadow-xl">
                <div class="flex justify-end mb-4 md:mb-6">
                    <i class="fas fa-quote-right text-pink-500 text-2xl md:text-3xl"></i>
                </div>
                <div class="flex mb-4 md:mb-6">
                    <i class="fas fa-star text-yellow-400 text-sm md:text-base"></i>
                    <i class="fas fa-star text-yellow-400 text-sm md:text-base ml-1"></i>
                    <i class="fas fa-star text-yellow-400 text-sm md:text-base ml-1"></i>
                    <i class="fas fa-star text-yellow-400 text-sm md:text-base ml-1"></i>
                    <i class="fas fa-star text-yellow-400 text-sm md:text-base ml-1"></i>
                </div>
                <p class="text-sm md:text-base text-gray-700 leading-relaxed italic mb-6 md:mb-8">
                    "The premium salwar suit I purchased for Eid was absolutely gorgeous. The fabric quality and fit were perfect — I felt like royalty during our family gathering."
                </p>
                <div class="flex items-center">
                    <div class="mr-3 md:mr-4 flex-shrink-0">
                        <img
                            src="https://images.unsplash.com/photo-1488716820095-cbe80883c496?ixlib=rb-4.0.3&auto=format&fit=crop&w=774&q=80"
                            alt="Zara Khan"
                            class="client-photo w-12 md:w-16 h-12 md:h-16 rounded-full object-cover">
                    </div>
                    <div class="min-w-0">
                        <h4 class="text-[#EC4899] font-semibold text-sm md:text-lg truncate">Zara Khan</h4>
                        <p class="text-gray-500 text-xs md:text-sm">Content Creator, Lucknow</p>
                        <p class="text-gray-400 text-xs mt-0.5 md:mt-1 truncate">Premium Salwar Suit · Eid-ul-Fitr 2025</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial 3 - Sikh / Vaisakhi -->
            <div class="testimonial-card bg-white rounded-2xl p-6 md:p-8 shadow-lg hover:shadow-xl">
                <div class="flex justify-end mb-4 md:mb-6">
                    <i class="fas fa-quote-right text-pink-500 text-2xl md:text-3xl"></i>
                </div>
                <div class="flex mb-4 md:mb-6">
                    <i class="fas fa-star text-yellow-400 text-sm md:text-base"></i>
                    <i class="fas fa-star text-yellow-400 text-sm md:text-base ml-1"></i>
                    <i class="fas fa-star text-yellow-400 text-sm md:text-base ml-1"></i>
                    <i class="fas fa-star text-yellow-400 text-sm md:text-base ml-1"></i>
                    <i class="fas fa-star text-yellow-400 text-sm md:text-base ml-1"></i>
                </div>
                <p class="text-sm md:text-base text-gray-700 leading-relaxed italic mb-6 md:mb-8">
                    "For Vaisakhi celebrations, I wanted something traditional yet modern. The designer ensemble I bought was perfect — elegant, comfortable, and truly special."
                </p>
                <div class="flex items-center">
                    <div class="mr-3 md:mr-4 flex-shrink-0">
                        <img
                            src="https://images.unsplash.com/photo-1506368083636-6defb2e2c5f9?ixlib=rb-4.0.3&auto=format&fit=crop&w=774&q=80"
                            alt="Gurpreet Kaur"
                            class="client-photo w-12 md:w-16 h-12 md:h-16 rounded-full object-cover">
                    </div>
                    <div class="min-w-0">
                        <h4 class="text-[#EC4899] font-semibold text-sm md:text-lg truncate">Gurpreet Kaur</h4>
                        <p class="text-gray-500 text-xs md:text-sm">Teacher, Amritsar</p>
                        <p class="text-gray-400 text-xs mt-0.5 md:mt-1 truncate">Designer Ensemble · Vaisakhi 2025</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial 4 - Christian / Christmas & New Year -->
            <div class="testimonial-card bg-white rounded-2xl p-6 md:p-8 shadow-lg hover:shadow-xl">
                <div class="flex justify-end mb-4 md:mb-6">
                    <i class="fas fa-quote-right text-pink-500 text-2xl md:text-3xl"></i>
                </div>
                <div class="flex mb-4 md:mb-6">
                    <i class="fas fa-star text-yellow-400 text-sm md:text-base"></i>
                    <i class="fas fa-star text-yellow-400 text-sm md:text-base ml-1"></i>
                    <i class="fas fa-star text-yellow-400 text-sm md:text-base ml-1"></i>
                    <i class="fas fa-star text-yellow-400 text-sm md:text-base ml-1"></i>
                    <i class="fas fa-star text-yellow-400 text-sm md:text-base ml-1"></i>
                </div>
                <p class="text-sm md:text-base text-gray-700 leading-relaxed italic mb-6 md:mb-8">
                    "The Christmas and New Year party collection was exactly what I needed. The fusion gown was a showstopper — I felt confident and glamorous all night!"
                </p>
                <div class="flex items-center">
                    <div class="mr-3 md:mr-4 flex-shrink-0">
                        <img
                            src="https://images.unsplash.com/photo-1489424731084-a5d8b219a5bb?ixlib=rb-4.0.3&auto=format&fit=crop&w=774&q=80"
                            alt="Anjali D'Souza"
                            class="client-photo w-12 md:w-16 h-12 md:h-16 rounded-full object-cover">
                    </div>
                    <div class="min-w-0">
                        <h4 class="text-[#EC4899] font-semibold text-sm md:text-lg truncate">Anjali D'Souza</h4>
                        <p class="text-gray-500 text-xs md:text-sm">Event Planner, Mumbai</p>
                        <p class="text-gray-400 text-xs mt-0.5 md:mt-1 truncate">Festive Gown · Christmas 2024</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial 5 - Hindu / Durga Puja / Navratri -->
            <div class="testimonial-card bg-white rounded-2xl p-6 md:p-8 shadow-lg hover:shadow-xl">
                <div class="flex justify-end mb-4 md:mb-6">
                    <i class="fas fa-quote-right text-pink-500 text-2xl md:text-3xl"></i>
                </div>
                <div class="flex mb-4 md:mb-6">
                    <i class="fas fa-star text-yellow-400 text-sm md:text-base"></i>
                    <i class="fas fa-star text-yellow-400 text-sm md:text-base ml-1"></i>
                    <i class="fas fa-star text-yellow-400 text-sm md:text-base ml-1"></i>
                    <i class="fas fa-star text-yellow-400 text-sm md:text-base ml-1"></i>
                    <i class="fas fa-star text-yellow-400 text-sm md:text-base ml-1"></i>
                </div>
                <p class="text-sm md:text-base text-gray-700 leading-relaxed italic mb-6 md:mb-8">
                    "For Navratri Garba nights, the designer lehenga I picked was an absolute dream. The mirror work and draping were flawless — I danced all night in style!"
                </p>
                <div class="flex items-center">
                    <div class="mr-3 md:mr-4 flex-shrink-0">
                        <img
                            src="https://images.unsplash.com/photo-1489424731084-a5d8b219a5bb?ixlib=rb-4.0.3&auto=format&fit=crop&w=774&q=80"
                            alt="Riddhi Patel"
                            class="client-photo w-12 md:w-16 h-12 md:h-16 rounded-full object-cover">
                    </div>
                    <div class="min-w-0">
                        <h4 class="text-[#EC4899] font-semibold text-sm md:text-lg truncate">Riddhi Patel</h4>
                        <p class="text-gray-500 text-xs md:text-sm">Dancer, Ahmedabad</p>
                        <p class="text-gray-400 text-xs mt-0.5 md:mt-1 truncate">Navratri Lehenga · Sep 2025</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial 6 - Muslim / Ramadan & Eid Special -->
            <div class="testimonial-card bg-white rounded-2xl p-6 md:p-8 shadow-lg hover:shadow-xl">
                <div class="flex justify-end mb-4 md:mb-6">
                    <i class="fas fa-quote-right text-pink-500 text-2xl md:text-3xl"></i>
                </div>
                <div class="flex mb-4 md:mb-6">
                    <i class="fas fa-star text-yellow-400 text-sm md:text-base"></i>
                    <i class="fas fa-star text-yellow-400 text-sm md:text-base ml-1"></i>
                    <i class="fas fa-star text-yellow-400 text-sm md:text-base ml-1"></i>
                    <i class="fas fa-star text-yellow-400 text-sm md:text-base ml-1"></i>
                    <i class="fas fa-star text-yellow-400 text-sm md:text-base ml-1"></i>
                </div>
                <p class="text-sm md:text-base text-gray-700 leading-relaxed italic mb-6 md:mb-8">
                    "The Ramadan edit was so thoughtfully curated. I bought the most elegant abaya and matching hijab for Eid prayers — the quality is unmatched."
                </p>
                <div class="flex items-center">
                    <div class="mr-3 md:mr-4 flex-shrink-0">
                        <img
                            src="https://images.unsplash.com/photo-1488716820095-cbe80883c496?ixlib=rb-4.0.3&auto=format&fit=crop&w=774&q=80"
                            alt="Fatima Ansari"
                            class="client-photo w-12 md:w-16 h-12 md:h-16 rounded-full object-cover">
                    </div>
                    <div class="min-w-0">
                        <h4 class="text-[#EC4899] font-semibold text-sm md:text-lg truncate">Fatima Ansari</h4>
                        <p class="text-gray-500 text-xs md:text-sm">Doctor, Hyderabad</p>
                        <p class="text-gray-400 text-xs mt-0.5 md:mt-1 truncate">Ramadan Edit · Mar 2025</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="mb-12 md:mb-16 fade-up px-4">
            <div class="bg-gradient-to-r from-pink-50 to-white rounded-2xl p-6 md:p-8 lg:p-10">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 text-center">
                    <div>
                        <div class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 mb-1 md:mb-2">4.9<span class="text-[#EC4899]">/5</span></div>
                        <div class="text-xs md:text-sm text-gray-600">Average Rating</div>
                    </div>
                    <div>
                        <div class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 mb-1 md:mb-2">3,200+</div>
                        <div class="text-xs md:text-sm text-gray-600">Styling Sessions</div>
                    </div>
                    <div>
                        <div class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 mb-1 md:mb-2">99%</div>
                        <div class="text-xs md:text-sm text-gray-600">Would Recommend</div>
                    </div>
                    <div>
                        <div class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 mb-1 md:mb-2">180+</div>
                        <div class="text-xs md:text-sm text-gray-600">Repeat Clients</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="text-center fade-up px-4">
            <div class="inline-block bg-gradient-to-r from-pink-500 to-pink-600 rounded-2xl p-0.5 shadow-xl mb-6 md:mb-8 w-full sm:w-auto">
                <div class="bg-white rounded-xl p-6 md:p-8 lg:p-10">
                    <h3 class="text-xl md:text-2xl lg:text-3xl font-semibold text-gray-900 mb-4 md:mb-6">Ready to Transform Your Style?</h3>
                    <p class="text-sm md:text-base text-gray-600 max-w-2xl mx-auto mb-6 md:mb-8 px-4">
                        Join thousands of Indian women who have discovered their perfect ethnic style through our personal consultations.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3 md:gap-4 justify-center">
                        <button class="bg-[#EC4899] text-white font-medium py-3 md:py-4 px-6 md:px-8 lg:px-10 rounded-full text-sm md:text-base lg:text-lg shadow-lg hover:bg-pink-600 transition duration-300 inline-flex items-center justify-center">
                            <i class="fas fa-calendar-check mr-2 md:mr-3"></i> Book Your Appointment
                        </button>
                        <button class="bg-white border border-gray-300 text-gray-700 font-medium py-3 md:py-4 px-6 md:px-8 lg:px-10 rounded-full text-sm md:text-base lg:text-lg hover:bg-gray-50 transition duration-300 inline-flex items-center justify-center">
                            <i class="fas fa-play-circle mr-2 md:mr-3"></i> Watch Client Stories
                        </button>
                    </div>
                </div>
            </div>
            <p class="text-xs md:text-sm text-gray-500">
                All client photos are used with permission. Real names may be changed for privacy.
            </p>
        </div>
    </div>
</section>

<!-- Call-to-Action Section -->
<section class="bg-gray-50 py-16 md:py-20 lg:py-24 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Background decorative elements -->
    <div class="absolute top-5 sm:top-10 left-5 sm:left-10 w-16 sm:w-20 md:w-24 h-16 sm:h-20 md:h-24 rounded-full bg-pink-100 opacity-30"></div>
    <div class="absolute bottom-10 sm:bottom-20 right-5 sm:right-10 w-20 sm:w-24 md:w-32 h-20 sm:h-24 md:h-32 rounded-full bg-pink-50 opacity-40"></div>
    <div class="absolute top-1/3 left-1/4 w-12 sm:w-16 h-12 sm:h-16 rounded-full bg-pink-100 opacity-20"></div>

    <div class="max-w-4xl mx-auto relative z-10">
        <!-- Main CTA Content -->
        <div class="text-center mb-12 md:mb-16 fade-up px-4">
            <!-- Icon/Emblem -->
            <div class="w-16 md:w-20 h-16 md:h-20 rounded-full bg-gradient-to-br from-pink-100 to-pink-50 flex items-center justify-center mx-auto mb-6 md:mb-8 shadow-lg">
                <i class="fas fa-star text-2xl md:text-3xl text-pink-500"></i>
            </div>

            <!-- Heading -->
            <h1 class="text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-light text-gray-900 mb-4 md:mb-6 lg:mb-8">
                Ready to Plan Your
                <span class="text-gradient">Perfect Outfit</span>?
            </h1>

            <!-- Supporting Text -->
            <p class="text-lg md:text-xl lg:text-2xl text-gray-600 max-w-2xl mx-auto leading-relaxed mb-8 md:mb-10 lg:mb-12 px-4">
                Transform your style with a one-on-one consultation from our expert stylists.
            </p>

            <!-- Button -->
            <div>
                <a href="#appoint-book-section" class="hover:bg-pink-600 bg-[#EC4899] text-white font-semibold py-4 md:py-5 px-8 md:px-10 lg:px-12 rounded-full text-base md:text-lg lg:text-xl shadow-xl inline-flex items-center justify-center">
                    <i class="fas fa-calendar-alt mr-2 md:mr-3 lg:mr-4"></i> Book Your Appointment Now
                </a>
            </div>

            <!-- Subtext under button -->
            <p class="text-xs md:text-sm text-gray-500 mt-4 md:mt-6 lg:mt-8">
                <i class="fas fa-lock text-pink-400 mr-1 md:mr-2"></i> Secure booking • Free consultation • Flexible scheduling
            </p>
        </div>

        <!-- Benefits Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-6 lg:gap-8 mb-12 md:mb-16 fade-up px-4">
            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm text-center hover-lift">
                <div class="w-12 md:w-14 h-12 md:h-14 rounded-full bg-pink-50 flex items-center justify-center mx-auto mb-4 md:mb-6">
                    <i class="fas fa-user-check text-lg md:text-2xl text-pink-500"></i>
                </div>
                <h3 class="text-base md:text-lg lg:text-xl font-semibold text-gray-900 mb-2 md:mb-4">Personalized Experience</h3>
                <p class="text-xs md:text-sm text-gray-600">One-on-one attention from expert stylists.</p>
            </div>

            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm text-center hover-lift">
                <div class="w-12 md:w-14 h-12 md:h-14 rounded-full bg-pink-50 flex items-center justify-center mx-auto mb-4 md:mb-6">
                    <i class="fas fa-gem text-lg md:text-2xl text-pink-500"></i>
                </div>
                <h3 class="text-base md:text-lg lg:text-xl font-semibold text-gray-900 mb-2 md:mb-4">Premium Quality</h3>
                <p class="text-xs md:text-sm text-gray-600">Access to exclusive fabrics and collections.</p>
            </div>

            <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm text-center hover-lift sm:col-span-2 md:col-span-1">
                <div class="w-12 md:w-14 h-12 md:h-14 rounded-full bg-pink-50 flex items-center justify-center mx-auto mb-4 md:mb-6">
                    <i class="fas fa-truck text-lg md:text-2xl text-pink-500"></i>
                </div>
                <h3 class="text-base md:text-lg lg:text-xl font-semibold text-gray-900 mb-2 md:mb-4">Free Delivery</h3>
                <p class="text-xs md:text-sm text-gray-600">Free shipping and returns on selected pieces.</p>
            </div>
        </div>

        <!-- Trust Indicators -->
        <div class="fade-up px-4">
            <div class="bg-white rounded-2xl p-6 md:p-8 lg:p-10 shadow-sm hover-lift">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4 md:gap-6">
                    <div class="text-center md:text-left md:pr-6 lg:pr-10">
                        <h3 class="text-lg md:text-xl lg:text-2xl font-semibold text-gray-900 mb-2 md:mb-4">
                            <i class="fas fa-shield-alt text-pink-500 mr-2"></i>
                            Book With Confidence
                        </h3>
                        <p class="text-sm md:text-base text-gray-600">
                            100% satisfaction guarantee on your styling experience.
                        </p>
                    </div>
                    <div class="text-center md:text-right">
                        <div class="flex items-center justify-center md:justify-end mb-2 md:mb-3">
                            <i class="fas fa-star text-yellow-400 text-sm md:text-base lg:text-xl"></i>
                            <i class="fas fa-star text-yellow-400 text-sm md:text-base lg:text-xl ml-1"></i>
                            <i class="fas fa-star text-yellow-400 text-sm md:text-base lg:text-xl ml-1"></i>
                            <i class="fas fa-star text-yellow-400 text-sm md:text-base lg:text-xl ml-1"></i>
                            <i class="fas fa-star text-yellow-400 text-sm md:text-base lg:text-xl ml-1"></i>
                            <span class="ml-2 md:ml-3 font-bold text-gray-900 text-base md:text-lg">4.9/5</span>
                        </div>
                        <p class="text-xs md:text-sm text-gray-500">Based on 1,200+ client reviews</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Preview -->
        <div class="mt-12 md:mt-16 text-center fade-up px-4">
            <p class="text-xs md:text-sm text-gray-600 mb-3 md:mb-4">
                <i class="fas fa-question-circle text-pink-400 mr-1 md:mr-2"></i>
                Have questions about the appointment process?
            </p>
            <a href="#" class="inline-flex items-center text-pink-600 font-medium hover:text-pink-700 text-sm md:text-base">
                <span>View Frequently Asked Questions</span>
                <i class="fas fa-arrow-right ml-1 md:ml-2 text-xs md:text-sm"></i>
            </a>
        </div>
    </div>

    <!-- Bottom decorative border -->
    <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-transparent via-pink-300 to-transparent"></div>
</section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Scroll animation observer
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        // Observe all animation elements
        document.querySelectorAll('.fade-up, .fade-in, .fade-in-left, .fade-in-right, .slide-up').forEach(el => {
            observer.observe(el);
        });

        // Initialize calendar
        initializeCalendar();

        // Button interactions
        setupButtonInteractions();
    });

    // Calendar functionality
    function initializeCalendar() {
        let currentDate = new Date();
        let selectedDate = null;
        let selectedTimeSlot = null;

        const timeSlots = ['9:00 AM', '10:30 AM', '12:00 PM', '1:30 PM', '3:00 PM', '4:30 PM', '6:00 PM', '7:30 PM'];
        const bookedSlots = ['10:30 AM', '1:30 PM', '6:00 PM'];

        const calendarGrid = document.getElementById('calendar-grid');
        const currentMonthElement = document.getElementById('current-month');
        const selectedDateDisplay = document.getElementById('selected-date-display');
        const timeSlotsContainer = document.getElementById('time-slots');
        const selectedTimeDisplay = document.getElementById('selected-time-display');
        const selectedTimeText = document.getElementById('selected-time-text');

        if (!calendarGrid || !currentMonthElement) return;

        function renderCalendar() {
            calendarGrid.innerHTML = '';

            const monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];
            currentMonthElement.textContent = `${monthNames[currentDate.getMonth()]} ${currentDate.getFullYear()}`;

            const firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
            const lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
            const totalDays = lastDay.getDate();
            const startingDay = firstDay.getDay();

            // Add empty cells
            for (let i = 0; i < startingDay; i++) {
                const emptyCell = document.createElement('div');
                emptyCell.classList.add('h-8', 'sm:h-10');
                calendarGrid.appendChild(emptyCell);
            }

            const today = new Date();
            const isCurrentMonth = today.getMonth() === currentDate.getMonth() &&
                today.getFullYear() === currentDate.getFullYear();

            for (let day = 1; day <= totalDays; day++) {
                const dayElement = document.createElement('button');
                dayElement.classList.add('calendar-day');

                if (isCurrentMonth && day === today.getDate()) {
                    dayElement.classList.add('border', 'border-pink-300');
                }

                if (selectedDate === day) {
                    dayElement.classList.add('calendar-day-selected');
                }

                if (isCurrentMonth && day < today.getDate()) {
                    dayElement.classList.add('calendar-day-disabled');
                    dayElement.disabled = true;
                } else {
                    dayElement.classList.add('text-gray-700');
                }

                dayElement.textContent = day;
                dayElement.dataset.day = day;

                dayElement.addEventListener('click', function() {
                    selectDate(parseInt(this.dataset.day));
                });

                calendarGrid.appendChild(dayElement);
            }
        }

        function renderTimeSlots() {
            if (!timeSlotsContainer) return;
            timeSlotsContainer.innerHTML = '';

            timeSlots.forEach(time => {
                const timeSlotElement = document.createElement('button');
                timeSlotElement.classList.add('time-slot');

                if (bookedSlots.includes(time)) {
                    timeSlotElement.classList.add('time-slot-booked');
                    timeSlotElement.disabled = true;
                    timeSlotElement.innerHTML = `${time} <span class="text-xs ml-1">(Booked)</span>`;
                } else {
                    timeSlotElement.classList.add('bg-gray-50', 'text-gray-700');
                    timeSlotElement.textContent = time;

                    if (selectedTimeSlot === time) {
                        timeSlotElement.classList.add('time-slot-selected');
                    }

                    timeSlotElement.addEventListener('click', function() {
                        selectTimeSlot(this.dataset.time);
                    });
                }

                timeSlotElement.dataset.time = time;
                timeSlotsContainer.appendChild(timeSlotElement);
            });
        }

        function selectDate(day) {
            selectedDate = day;

            const dayElements = document.querySelectorAll('.calendar-day:not(.calendar-day-disabled)');
            dayElements.forEach(element => {
                element.classList.remove('calendar-day-selected');
                if (parseInt(element.dataset.day) === day) {
                    element.classList.add('calendar-day-selected');
                }
            });

            const monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];
            if (selectedDateDisplay) {
                selectedDateDisplay.textContent = `${monthNames[currentDate.getMonth()]} ${day}, ${currentDate.getFullYear()}`;
            }

            if (selectedTimeSlot) {
                selectedTimeSlot = null;
                renderTimeSlots();
                if (selectedTimeDisplay) {
                    selectedTimeDisplay.classList.add('hidden');
                }
            }
        }

        function selectTimeSlot(time) {
            selectedTimeSlot = time;
            renderTimeSlots();

            if (selectedTimeText) {
                selectedTimeText.textContent = time;
            }
            if (selectedTimeDisplay) {
                selectedTimeDisplay.classList.remove('hidden');
            }
        }

        // Month navigation
        const prevMonthBtn = document.getElementById('prev-month');
        const nextMonthBtn = document.getElementById('next-month');

        if (prevMonthBtn) {
            prevMonthBtn.addEventListener('click', function() {
                currentDate.setMonth(currentDate.getMonth() - 1);
                renderCalendar();
                selectedDate = null;
                if (selectedDateDisplay) {
                    selectedDateDisplay.textContent = 'No date selected';
                }
                if (selectedTimeSlot) {
                    selectedTimeSlot = null;
                    renderTimeSlots();
                    if (selectedTimeDisplay) {
                        selectedTimeDisplay.classList.add('hidden');
                    }
                }
            });
        }

        if (nextMonthBtn) {
            nextMonthBtn.addEventListener('click', function() {
                currentDate.setMonth(currentDate.getMonth() + 1);
                renderCalendar();
                selectedDate = null;
                if (selectedDateDisplay) {
                    selectedDateDisplay.textContent = 'No date selected';
                }
                if (selectedTimeSlot) {
                    selectedTimeSlot = null;
                    renderTimeSlots();
                    if (selectedTimeDisplay) {
                        selectedTimeDisplay.classList.add('hidden');
                    }
                }
            });
        }

        // Form submission
        const form = document.getElementById('appointment-form');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                if (!selectedDate) {
                    alert('Please select a date for your appointment.');
                    return;
                }

                if (!selectedTimeSlot) {
                    alert('Please select a time slot for your appointment.');
                    return;
                }

                const name = document.getElementById('full-name')?.value;
                const email = document.getElementById('email')?.value;
                const appointmentType = document.getElementById('appointment-type')?.value;

                const monthNames = ["January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December"
                ];
                const appointmentDate = `${monthNames[currentDate.getMonth()]} ${selectedDate}, ${currentDate.getFullYear()}`;

                alert(`Thank you, ${name || 'Guest'}! Your appointment has been scheduled for ${appointmentDate} at ${selectedTimeSlot}. A confirmation email has been sent to ${email || 'your email'}.`);

                this.reset();
                selectedDate = null;
                selectedTimeSlot = null;

                if (selectedDateDisplay) {
                    selectedDateDisplay.textContent = 'No date selected';
                }
                if (selectedTimeDisplay) {
                    selectedTimeDisplay.classList.add('hidden');
                }

                renderCalendar();
                renderTimeSlots();
            });
        }

        // Initialize
        renderCalendar();
        renderTimeSlots();

        // Set default selected date to today
        const today = new Date();
        if (today.getMonth() === currentDate.getMonth() &&
            today.getFullYear() === currentDate.getFullYear()) {
            selectDate(today.getDate());
        }
    }

    function setupButtonInteractions() {
        // Appointment buttons
        const appointmentButtons = document.querySelectorAll('.appointment-btn, .cta-button, .btn-primary, .profile-btn');

        appointmentButtons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#FCE7F3';
                this.style.color = '#831843';
            });

            button.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '#EC4899';
                this.style.color = 'white';
            });

            button.addEventListener('click', function(e) {
                e.preventDefault();
                const message = this.classList.contains('profile-btn') ?
                    "Opening Sophia Laurent's full profile..." :
                    "Thank you for your interest! Our booking system is ready to help you schedule your appointment.";

                alert(message);
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 200);
            });
        });

        // Watch Stories button
        const watchButton = document.querySelector('button.bg-white.border');
        if (watchButton) {
            watchButton.addEventListener('click', function() {
                alert("Opening client testimonial videos... Hear directly from our satisfied clients about their styling journey.");
            });
        }

        // Social links
        const socialLinks = document.querySelectorAll('a.w-8, a.w-10');
        socialLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const platform = this.querySelector('i')?.className.includes('instagram') ? 'Instagram' :
                    this.querySelector('i')?.className.includes('pinterest') ? 'Pinterest' : 'LinkedIn';
                alert(`Redirecting to Sophia's ${platform} profile...`);
            });
        });
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const appointLink = document.querySelector('a[href="#appoint-book-section"]');

        if (appointLink) {
            appointLink.addEventListener('click', function(event) {
                event.preventDefault();

                const targetSection = document.querySelector('#appoint-book-section');

                if (targetSection) {
                    targetSection.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    // No URL hash will be added
                }
            });
        }
    });
</script>
<script>
    (function() {
        // Get DOM elements
        const monthYearDisplay = document.getElementById('monthYearDisplay');
        const calendarGrid = document.getElementById('calendarGrid');
        const prevBtn = document.getElementById('prevMonthBtn');
        const nextBtn = document.getElementById('nextMonthBtn');
        const availabilityLabel = document.getElementById('availabilityLabel');
        const availabilityTime = document.getElementById('availabilityTime');
        const slotContainer = document.getElementById('slotContainer');

        // Current date state
        let currentDate = new Date();
        let currentMonth = currentDate.getMonth();
        let currentYear = currentDate.getFullYear();

        // Track selected date (initially today)
        let selectedDate = new Date();
        let selectedDay = selectedDate.getDate();
        let selectedMonth = selectedDate.getMonth();
        let selectedYear = selectedDate.getFullYear();

        // Sample slots data
        const sampleSlots = ['10:30 AM', '1:00 PM', '3:30 PM'];

        // Render calendar
        function renderCalendar(month, year) {
            // Update month/year display
            const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];
            monthYearDisplay.textContent = `${monthNames[month]} ${year}`;

            // Get first day of month and number of days
            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const daysInPrevMonth = new Date(year, month, 0).getDate();

            // Get today's date
            const today = new Date();
            const todayDate = today.getDate();
            const todayMonth = today.getMonth();
            const todayYear = today.getFullYear();

            // Build calendar grid
            let gridHTML = '';

            // Previous month days
            const prevMonthStart = daysInPrevMonth - firstDay + 1;
            for (let i = prevMonthStart; i <= daysInPrevMonth; i++) {
                gridHTML += `<div class="text-xs text-gray-300 text-center py-2 day-cell other-month" data-day="${i}" data-month="${month-1}" data-year="${year}">${i}</div>`;
            }

            // Current month days
            for (let i = 1; i <= daysInMonth; i++) {
                const isToday = (i === todayDate && month === todayMonth && year === todayYear);
                const isSelected = (i === selectedDay && month === selectedMonth && year === selectedYear);

                let classes = 'text-xs text-center py-2 day-cell cursor-pointer hover:bg-pink-500 transition rounded-[100px] hover:text-white';

                if (isSelected) {
                    classes += ' bg-pink-600 text-white rounded-full font-semibold';
                } else if (isToday) {
                    classes += ' bg-pink-100 text-pink-700 rounded-full font-medium';
                } else {
                    classes += ' text-gray-600';
                }

                gridHTML += `<div class="${classes}" data-day="${i}" data-month="${month}" data-year="${year}">${i}</div>`;
            }

            // Next month days (to fill remaining grid)
            const totalCells = firstDay + daysInMonth;
            const remainingCells = (7 - (totalCells % 7)) % 7;
            for (let i = 1; i <= remainingCells; i++) {
                gridHTML += `<div class="text-xs text-gray-300 text-center py-2 day-cell other-month" data-day="${i}" data-month="${month+1}" data-year="${year}">${i}</div>`;
            }

            calendarGrid.innerHTML = gridHTML;

            // Add click listeners to all day cells
            document.querySelectorAll('.day-cell').forEach(cell => {
                cell.addEventListener('click', function(e) {
                    const day = parseInt(this.dataset.day);
                    const month = parseInt(this.dataset.month);
                    const year = parseInt(this.dataset.year);

                    // Update selected date
                    selectedDay = day;
                    selectedMonth = month;
                    selectedYear = year;

                    // If clicked on different month, navigate there
                    if (month !== currentMonth || year !== currentYear) {
                        currentMonth = month;
                        currentYear = year;
                        renderCalendar(currentMonth, currentYear);
                    } else {
                        // Just re-render to update selection
                        renderCalendar(currentMonth, currentYear);
                    }

                    // Update availability for selected date
                    updateAvailabilityForDate(month, year, day);
                });
            });

            // Update availability based on current view
            updateAvailability(month, year);
        }

        // Update availability for a specific date
        function updateAvailabilityForDate(month, year, day) {
            const selectedDateObj = new Date(year, month, day);
            const today = new Date();
            const todayDate = new Date(today.getFullYear(), today.getMonth(), today.getDate());

            // Check if selected date is today
            const isToday = selectedDateObj.getTime() === todayDate.getTime();

            if (isToday) {
                availabilityLabel.textContent = 'Available Today';
                availabilityTime.textContent = 'Limited slots available';
                slotContainer.innerHTML = `
                <span class="text-xs bg-yellow-100 text-yellow-700 px-3 py-1.5 rounded-full slot-badge">12:00 PM</span>
                <span class="text-xs bg-yellow-100 text-yellow-700 px-3 py-1.5 rounded-full slot-badge">2:30 PM</span>
                <span class="text-xs bg-gray-100 text-gray-400 px-3 py-1.5 rounded-full">4:00 PM (Booked)</span>
            `;
            } else if (selectedDateObj > todayDate) {
                // Future date
                const dayOfWeek = selectedDateObj.getDay();
                const dateStr = selectedDateObj.toLocaleDateString('en-US', {
                    weekday: 'long',
                    month: 'short',
                    day: 'numeric'
                });
                availabilityLabel.textContent = `Available ${dateStr}`;

                let slots = [];
                if (dayOfWeek === 0 || dayOfWeek === 6) {
                    slots = ['11:00 AM', '2:00 PM'];
                } else {
                    slots = ['9:00 AM', '10:30 AM', '1:00 PM', '3:30 PM', '5:00 PM'];
                }

                slotContainer.innerHTML = slots.map(slot =>
                    `<span class="text-xs bg-green-100 text-green-700 px-3 py-1.5 rounded-full slot-badge">${slot}</span>`
                ).join('');

                availabilityTime.textContent = `${slots[0]} - ${slots[slots.length-1]}`;
            } else {
                // Past date
                availabilityLabel.textContent = '📅 Past Date';
                availabilityTime.textContent = 'No availability';
                slotContainer.innerHTML = `
                <span class="text-xs bg-gray-100 text-gray-400 px-3 py-1.5 rounded-full">Unavailable</span>
            `;
            }
        }

        // Update availability section
        function updateAvailability(month, year) {
            const today = new Date();
            const currentDateObj = new Date(year, month, 1);

            // Check if we're viewing current month
            const isCurrentMonth = (month === today.getMonth() && year === today.getFullYear());

            if (isCurrentMonth) {
                // If viewing current month, show tomorrow by default
                const tomorrow = new Date(today);
                tomorrow.setDate(today.getDate() + 1);
                const tomorrowStr = tomorrow.toLocaleDateString('en-US', {
                    weekday: 'long',
                    month: 'short',
                    day: 'numeric'
                });
                availabilityLabel.textContent = `Available ${tomorrowStr}`;

                const dayOfWeek = tomorrow.getDay();
                let slots = [];
                if (dayOfWeek === 0 || dayOfWeek === 6) {
                    slots = ['11:00 AM', '2:00 PM'];
                } else {
                    slots = ['9:00 AM', '10:30 AM', '1:00 PM', '3:30 PM', '5:00 PM'];
                }

                slotContainer.innerHTML = slots.map(slot =>
                    `<span class="text-xs bg-green-100 text-green-700 px-3 py-1.5 rounded-full slot-badge">${slot}</span>`
                ).join('');

                availabilityTime.textContent = `${slots[0]} - ${slots[slots.length-1]}`;
            } else {
                // Not current month
                const monthName = new Date(year, month).toLocaleDateString('en-US', {
                    month: 'long'
                });
                availabilityLabel.textContent = `Available in ${monthName}`;
                availabilityTime.textContent = 'Check back soon';

                slotContainer.innerHTML = `
                <span class="text-xs bg-gray-100 text-gray-500 px-3 py-1.5 rounded-full">Coming soon</span>
            `;
            }
        }

        // Navigate months
        function changeMonth(delta) {
            currentMonth += delta;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            } else if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            renderCalendar(currentMonth, currentYear);
        }

        // Event listeners
        prevBtn.addEventListener('click', function(e) {
            e.preventDefault();
            changeMonth(-1);
        });

        nextBtn.addEventListener('click', function(e) {
            e.preventDefault();
            changeMonth(1);
        });

        // Initial render
        renderCalendar(currentMonth, currentYear);

    })();
</script>

<!-- Add Calendly script at the end of the section or in your scripts section -->
<script src="https://assets.calendly.com/assets/external/widget.js" async></script>
@endsection