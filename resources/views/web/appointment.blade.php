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

  

    .hero-bg {
        background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.3)), url('https://images.unsplash.com/photo-1490481651871-ab68de25d43d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    @media (max-width: 768px) {
        .hero-bg {
            background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.3)), url('https://images.unsplash.com/photo-1526178613552-2b45c6c302f0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');
        }
    }

    /* CTA Button Styles */
    .cta-button {
        background-color: #EC4899;
        color: white;
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
        border: none;
        cursor: pointer;
    }

    .cta-button:hover {
        background-color: #FCE7F3;
        color: #831843;
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(236, 72, 153, 0.25);
    }

    .cta-button::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.7s ease;
    }

    .cta-button:hover::after {
        left: 100%;
    }

    /* Appointment Button */
    .appointment-btn {
        background-color: #EC4899;
        color: white;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .appointment-btn:hover {
        background-color: #FCE7F3;
        color: #831843;
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    /* Submit Button */
    .submit-btn {
        background-color: #EC4899;
        color: white;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .submit-btn:hover {
        background-color: #FCE7F3;
        color: #831843;
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(236, 72, 153, 0.2);
    }

    /* Profile Button */
    .profile-btn {
        background-color: #EC4899;
        color: white;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .profile-btn:hover {
        background-color: #FCE7F3;
        color: #831843;
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(236, 72, 153, 0.2);
    }

    /* Animation Classes */
    .fade-up {
        opacity: 0;
        transform: translateY(30px);
        transition: opacity 0.8s ease-out, transform 0.8s ease-out;
    }

    .fade-up.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .fade-in {
        opacity: 0;
        transition: opacity 0.5s ease-out;
    }

    .fade-in.visible {
        opacity: 1;
    }

    .fade-in-left {
        opacity: 0;
        transform: translateX(-30px);
        transition: opacity 0.8s ease-out, transform 0.8s ease-out;
    }

    .fade-in-left.visible {
        opacity: 1;
        transform: translateX(0);
    }

    .fade-in-right {
        opacity: 0;
        transform: translateX(30px);
        transition: opacity 0.8s ease-out, transform 0.8s ease-out;
    }

    .fade-in-right.visible {
        opacity: 1;
        transform: translateX(0);
    }

    .slide-up {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.8s ease-out 0.3s, transform 0.8s ease-out 0.3s;
    }

    .slide-up.visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* Hover Effects */
    .hover-lift {
        transition: transform 0.3s ease;
    }

    .hover-lift:hover {
        transform: translateY(-5px);
    }

    .hover-float {
        transition: all 0.4s ease;
    }

    .hover-float:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.08);
    }

    .hover-scale {
        transition: transform 0.3s ease;
    }

    .hover-scale:hover {
        transform: scale(1.05);
    }

    /* Text Gradient */
    .text-gradient {
        background: linear-gradient(135deg, #EC4899 0%, #F472B6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Testimonial Card */
    .testimonial-card {
        transition: all 0.4s ease;
        background-color: white;
        cursor: pointer;
    }

    .testimonial-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.08);
    }

    .client-photo {
        border: 4px solid white;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .testimonial-card:hover .client-photo {
        transform: scale(1.05);
        border-color: #FCE7F3;
    }

    /* Step Card */
    .step-card {
        transition: all 0.4s ease;
        background-color: #f9fafb;
        cursor: pointer;
    }

    .step-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.08);
    }

    .step-badge {
        background-color: #EC4899;
        color: white;
        transition: all 0.3s ease;
    }

    .step-card:hover .step-badge {
        transform: scale(1.1);
        box-shadow: 0 10px 20px rgba(236, 72, 153, 0.2);
    }

    /* Feature Card */
    .feature-card {
        transition: all 0.3s ease;
        background-color: #f9fafb;
        cursor: pointer;
    }

    .feature-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
    }

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
    }

    .time-slot:hover:not(.time-slot-booked) {
        background-color: #FCE7F3;
        color: #831843;
    }

    .time-slot-selected {
        background-color: #EC4899;
        color: white;
    }

    .time-slot-booked {
        background-color: #f3f4f6;
        color: #9ca3af;
        cursor: not-allowed;
    }

    /* Form Styles */
    .form-input:focus {
        border-color: #EC4899;
        box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.1);
        outline: none;
    }

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
        position: relative;
        height: 2px;
        background: linear-gradient(90deg, #EC4899, #FCE7F3);
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

    /* Stat Item */
    .stat-item {
        transition: all 0.3s ease;
    }

    .stat-item:hover {
        transform: translateY(-5px);
    }

    /* Benefit Item */
    .benefit-item {
        transition: transform 0.3s ease;
    }

    .benefit-item:hover {
        transform: translateY(-5px);
    }
</style>

<!-- Hero Section -->
<section class="hero-bg min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="container mx-auto text-center text-white px-6 py-12 rounded-2xl bg-black/30">
        <!-- Logo/Brand -->
        <div class="mb-8 fade-in">
            <h1 class="text-2xl md:text-3xl font-light tracking-widest">ÉLÉGANCE BOUTIQUE</h1>
            <div class="w-24 h-0.5 bg-pink-300 mx-auto mt-3"></div>
        </div>

        <!-- Main Heading -->
        <h1 class="section-heading text-4xl md:text-5xl lg:text-6xl leading-tight mb-6 fade-in">
            Book Your Personal Styling Appointment
        </h1>

        <!-- Subtext -->
        <p class="text-xl md:text-2xl text-gray-100 mb-10 max-w-2xl mx-auto leading-relaxed slide-up">
            Get expert guidance and create your perfect custom look.
        </p>

        <!-- Button -->
        <div class="slide-up">
            <button class="appointment-btn text-white font-medium py-4 px-10 rounded-full text-lg shadow-lg">
                <i class="fas fa-calendar-check mr-3"></i> Schedule Your Appointment
            </button>
        </div>

        <!-- Benefits Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-16 pt-10 border-t border-white/20">
            <div class="benefit-item p-4">
                <div class="w-14 h-14 bg-pink-100/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-check text-2xl text-pink-200"></i>
                </div>
                <h3 class="text-xl font-medium mb-2">One-on-One Consultation</h3>
                <p class="text-gray-200">Personalized attention from our expert stylists.</p>
            </div>

            <div class="benefit-item p-4">
                <div class="w-14 h-14 bg-pink-100/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-tshirt text-2xl text-pink-200"></i>
                </div>
                <h3 class="text-xl font-medium mb-2">Custom Style Selection</h3>
                <p class="text-gray-200">Curated outfits tailored to your preferences.</p>
            </div>

            <div class="benefit-item p-4">
                <div class="w-14 h-14 bg-pink-100/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-truck text-2xl text-pink-200"></i>
                </div>
                <h3 class="text-xl font-medium mb-2">Free Home Delivery</h3>
                <p class="text-gray-200">Selected items delivered to your doorstep.</p>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="mt-12 pt-8 border-t border-white/20 slide-up">
            <p class="text-gray-200 mb-2">
                <i class="fas fa-clock text-pink-200 mr-2"></i> Appointments available: Monday - Saturday, 9am - 7pm
            </p>
            <p class="text-gray-200">
                <i class="fas fa-info-circle text-pink-200 mr-2"></i> Virtual or in-person appointments available
            </p>
        </div>
    </div>
</section>

<!-- Why Book an Appointment? Section -->
<section class="bg-white py-16 md:py-24 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Section Header -->
        <div class="text-center mb-16 fade-up">
            <h2 class="section-heading text-3xl md:text-4xl lg:text-5xl text-gray-900 mb-6">
                Why Book an Appointment?
            </h2>
            <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto">
                Our personal styling experience is designed to transform your wardrobe and elevate your style with expert guidance tailored just for you.
            </p>
            <div class="w-24 h-1 bg-pink-400 mx-auto mt-8"></div>
        </div>

        <!-- Feature Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

            <!-- Card 1: Personal Style Consultation -->
            <div class="feature-card rounded-2xl p-8 shadow-md fade-up">
                <div class="icon-wrapper w-16 h-16 rounded-full bg-pink-50 flex items-center justify-center mb-6 mx-auto">
                    <i class="fas fa-user-friends text-2xl text-[#EC4899]"></i>
                </div>

                <h3 class="text-xl font-semibold text-gray-900 mb-4 text-center">
                    Personal Style Consultation
                </h3>

                <p class="text-gray-600 text-center leading-relaxed">
                    One-on-one session with our expert stylists to understand your lifestyle, preferences, and style goals for a completely personalized experience.
                </p>

                <div class="mt-6 pt-6 border-t border-gray-100 text-center">
                    <span class="text-sm font-medium text-pink-500">60 min session</span>
                </div>
            </div>

            <!-- Card 2: Custom Fit Guidance -->
            <div class="feature-card rounded-2xl p-8 shadow-md fade-up">
                <div class="icon-wrapper w-16 h-16 rounded-full bg-pink-50 flex items-center justify-center mb-6 mx-auto">
                    <i class="fas fa-ruler-combined text-2xl text-[#EC4899]"></i>
                </div>

                <h3 class="text-xl font-semibold text-gray-900 mb-4 text-center">
                    Custom Fit Guidance
                </h3>

                <p class="text-gray-600 text-center leading-relaxed">
                    Learn how clothing should fit your unique body type. Get expert advice on alterations and sizing for a flawless, confidence-boosting fit.
                </p>

                <div class="mt-6 pt-6 border-t border-gray-100 text-center">
                    <span class="text-sm font-medium text-pink-500">Body measurements included</span>
                </div>
            </div>

            <!-- Card 3: Fabric & Color Selection -->
            <div class="feature-card rounded-2xl p-8 shadow-md fade-up">
                <div class="icon-wrapper w-16 h-16 rounded-full bg-pink-50 flex items-center justify-center mb-6 mx-auto">
                    <i class="fas fa-palette text-2xl text-[#EC4899]"></i>
                </div>

                <h3 class="text-xl font-semibold text-gray-900 mb-4 text-center">
                    Fabric & Color Selection
                </h3>

                <p class="text-gray-600 text-center leading-relaxed">
                    Discover which fabrics and colors complement your skin tone and lifestyle. Build a versatile wardrobe with pieces that work harmoniously together.
                </p>

                <div class="mt-6 pt-6 border-t border-gray-100 text-center">
                    <span class="text-sm font-medium text-pink-500">Color palette analysis</span>
                </div>
            </div>

            <!-- Card 4: Designer Recommendations -->
            <div class="feature-card rounded-2xl p-8 shadow-md fade-up">
                <div class="icon-wrapper w-16 h-16 rounded-full bg-pink-50 flex items-center justify-center mb-6 mx-auto">
                    <i class="fas fa-crown text-2xl text-[#EC4899]"></i>
                </div>

                <h3 class="text-xl font-semibold text-gray-900 mb-4 text-center">
                    Designer Recommendations
                </h3>

                <p class="text-gray-600 text-center leading-relaxed">
                    Receive curated suggestions from our collection of designers that align with your style, budget, and values for a truly elevated wardrobe.
                </p>

                <div class="mt-6 pt-6 border-t border-gray-100 text-center">
                    <span class="text-sm font-medium text-pink-500">Personalized lookbook</span>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="mt-20 pt-12 border-t border-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="fade-up">
                    <div class="text-4xl md:text-5xl font-bold text-gray-900 mb-2">98%</div>
                    <div class="text-gray-600">Client satisfaction rate</div>
                </div>
                <div class="fade-up">
                    <div class="text-4xl md:text-5xl font-bold text-gray-900 mb-2">5,000+</div>
                    <div class="text-gray-600">Successful styling sessions</div>
                </div>
                <div class="fade-up">
                    <div class="text-4xl md:text-5xl font-bold text-gray-900 mb-2">50+</div>
                    <div class="text-gray-600">Expert stylists</div>
                </div>
            </div>
        </div>

        <!-- CTA Button -->
        <div class="mt-16 text-center fade-up">
            <button class="bg-[#EC4899] text-white font-medium py-4 px-10 rounded-full text-lg shadow-lg hover:bg-pink-600 transition duration-300">
                <i class="fas fa-calendar-alt mr-3"></i> Book Your Appointment Now
            </button>
            <p class="text-gray-500 mt-6">Flexible scheduling • Virtual or in-person • No commitment required</p>
        </div>
    </div>
</section>

<!-- Appointment Booking Section -->
<section class="bg-gray-50 py-12 md:py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Section Header -->
        <div class="text-center mb-12 fade-in">
            <h2 class="section-heading text-3xl md:text-4xl text-gray-900 mb-4">
                Book Your Personal Styling Appointment
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Select your preferred date and time for a one-on-one consultation with our expert stylists.
            </p>
        </div>

        <!-- Booking Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden fade-in">
            <div class="md:flex">
                <!-- Left Column: Calendar -->
                <div class="md:w-1/2 p-6 md:p-8 border-b md:border-b-0 md:border-r border-gray-100">
                    <div class="mb-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-1">Select a Date</h3>
                        <p class="text-gray-500 text-sm">Choose your preferred appointment date</p>
                    </div>

                    <!-- Calendar Header -->
                    <div class="flex items-center justify-between mb-6">
                        <button id="prev-month" class="text-gray-500 hover:text-gray-700 p-2 rounded-full hover:bg-gray-100">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <h4 id="current-month" class="text-lg font-medium text-gray-900">February 2023</h4>
                        <button id="next-month" class="text-gray-500 hover:text-gray-700 p-2 rounded-full hover:bg-gray-100">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>

                    <!-- Calendar Days of Week -->
                    <div class="grid grid-cols-7 gap-1 mb-3">
                        <div class="text-center text-sm font-medium text-gray-500 py-2">Sun</div>
                        <div class="text-center text-sm font-medium text-gray-500 py-2">Mon</div>
                        <div class="text-center text-sm font-medium text-gray-500 py-2">Tue</div>
                        <div class="text-center text-sm font-medium text-gray-500 py-2">Wed</div>
                        <div class="text-center text-sm font-medium text-gray-500 py-2">Thu</div>
                        <div class="text-center text-sm font-medium text-gray-500 py-2">Fri</div>
                        <div class="text-center text-sm font-medium text-gray-500 py-2">Sat</div>
                    </div>

                    <!-- Calendar Grid -->
                    <div id="calendar-grid" class="grid grid-cols-7 gap-1 mb-6">
                        <!-- Calendar days will be generated by JavaScript -->
                    </div>

                    <!-- Selected Date Display -->
                    <div class="bg-gray-50 rounded-xl p-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center mr-3">
                                <i class="fas fa-calendar-alt text-pink-500"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Selected Date</p>
                                <p id="selected-date-display" class="font-medium text-gray-900">No date selected</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Time Slots & Form -->
                <div class="md:w-1/2 p-6 md:p-8">
                    <!-- Time Slots -->
                    <div class="mb-8">
                        <div class="mb-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-1">Available Time Slots</h3>
                            <p class="text-gray-500 text-sm">Choose your preferred time (Duration: 60 minutes)</p>
                        </div>

                        <!-- Time Slot Grid -->
                        <div id="time-slots" class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-6">
                            <!-- Time slots will be generated by JavaScript -->
                        </div>

                        <!-- Selected Time Display -->
                        <div id="selected-time-display" class="hidden bg-gray-50 rounded-xl p-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center mr-3">
                                    <i class="fas fa-clock text-pink-500"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Selected Time</p>
                                    <p id="selected-time-text" class="font-medium text-gray-900"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Appointment Form -->
                    <div class="border-t border-gray-100 pt-8">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6">Personal Details</h3>

                        <form id="appointment-form">
                            <div class="space-y-5">
                                <!-- Full Name -->
                                <div>
                                    <label for="full-name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                    <input
                                        type="text"
                                        id="full-name"
                                        class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none"
                                        placeholder="Enter your full name"
                                        required>
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                    <input
                                        type="email"
                                        id="email"
                                        class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none"
                                        placeholder="you@example.com"
                                        required>
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                    <input
                                        type="tel"
                                        id="phone"
                                        class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none"
                                        placeholder="(123) 456-7890"
                                        required>
                                </div>

                                <!-- Appointment Type -->
                                <div>
                                    <label for="appointment-type" class="block text-sm font-medium text-gray-700 mb-1">Appointment Type</label>
                                    <select
                                        id="appointment-type"
                                        class="form-select w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none"
                                        required>
                                        <option value="" disabled selected>Select appointment type</option>
                                        <option value="virtual">Virtual Consultation</option>
                                        <option value="in-store">In-Store Appointment</option>
                                        <option value="video-call">Video Call</option>
                                    </select>
                                </div>

                                <!-- Submit Button -->
                                <div class="pt-4">
                                    <button
                                        type="submit"
                                        class="submit-btn w-full text-white font-medium py-4 rounded-xl text-lg shadow-md">
                                        <i class="fas fa-check-circle mr-2"></i> Confirm Appointment
                                    </button>
                                    <p class="text-gray-500 text-sm text-center mt-3">
                                        You'll receive a confirmation email with further details.
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6 text-center fade-in">
            <div class="bg-white p-6 rounded-xl shadow-sm hover-lift">
                <div class="w-12 h-12 rounded-full bg-pink-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-clock text-pink-500"></i>
                </div>
                <h4 class="font-medium text-gray-900 mb-2">60-Minute Sessions</h4>
                <p class="text-gray-600 text-sm">Each appointment includes a full hour of dedicated styling time.</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm hover-lift">
                <div class="w-12 h-12 rounded-full bg-pink-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-calendar-check text-pink-500"></i>
                </div>
                <h4 class="font-medium text-gray-900 mb-2">Flexible Rescheduling</h4>
                <p class="text-gray-600 text-sm">Change your appointment up to 24 hours in advance.</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm hover-lift">
                <div class="w-12 h-12 rounded-full bg-pink-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-headset text-pink-500"></i>
                </div>
                <h4 class="font-medium text-gray-900 mb-2">24/7 Support</h4>
                <p class="text-gray-600 text-sm">Our team is here to help with any questions or concerns.</p>
            </div>
        </div>
    </div>
</section>

<!-- What Happens During Your Appointment Section -->
<section class="bg-white py-16 md:py-24 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Section Header -->
        <div class="text-center mb-16 md:mb-20 fade-up">
            <h2 class="section-heading text-3xl md:text-4xl lg:text-5xl text-gray-900 mb-6">
                What Happens During Your Appointment
            </h2>
            <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Experience a personalized styling journey designed to understand your unique style and create a wardrobe that reflects your personality.
            </p>
            <div class="w-24 h-1 bg-pink-400 mx-auto mt-8"></div>
        </div>

        <!-- Steps with Connector Lines (Desktop) -->
        <div class="hidden md:block relative">
            <!-- Connector Line -->
            <div class="connector-line absolute top-1/2 left-0 right-0 -translate-y-1/2 z-0">
                <div class="connector-dot left-1/4"></div>
                <div class="connector-dot left-1/2"></div>
                <div class="connector-dot left-3/4"></div>
            </div>

            <!-- Step Cards -->
            <div class="relative z-10 grid grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="step-card rounded-2xl p-8 shadow-lg fade-up">
                    <div class="step-badge w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mb-8 mx-auto">
                        1
                    </div>

                    <h3 class="text-2xl font-semibold text-gray-900 mb-6 text-center">
                        Discuss Your Style & Occasion
                    </h3>

                    <div class="mb-8">
                        <div class="w-20 h-1 bg-pink-300 mx-auto mb-6"></div>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <i class="fas fa-check text-pink-500 mt-1 mr-3"></i>
                                <p class="text-gray-600">Share your style preferences, lifestyle needs, and upcoming events</p>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-check text-pink-500 mt-1 mr-3"></i>
                                <p class="text-gray-600">Discuss your comfort zone and areas you'd like to explore</p>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-check text-pink-500 mt-1 mr-3"></i>
                                <p class="text-gray-600">Define color palettes that complement your skin tone</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-5 border border-gray-100">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center mr-3">
                                <i class="fas fa-clock text-pink-500"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Duration</p>
                                <p class="font-medium">20-25 minutes</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="step-card rounded-2xl p-8 shadow-lg fade-up">
                    <div class="step-badge w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mb-8 mx-auto">
                        2
                    </div>

                    <h3 class="text-2xl font-semibold text-gray-900 mb-6 text-center">
                        Explore Fabrics & Design Options
                    </h3>

                    <div class="mb-8">
                        <div class="w-20 h-1 bg-pink-300 mx-auto mb-6"></div>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <i class="fas fa-check text-pink-500 mt-1 mr-3"></i>
                                <p class="text-gray-600">Touch and feel various fabric samples and textures</p>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-check text-pink-500 mt-1 mr-3"></i>
                                <p class="text-gray-600">Explore design options, patterns, and silhouettes</p>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-check text-pink-500 mt-1 mr-3"></i>
                                <p class="text-gray-600">Review seasonal trends and timeless classics</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-5 border border-gray-100">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center mr-3">
                                <i class="fas fa-tshirt text-pink-500"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Includes</p>
                                <p class="font-medium">Fabric swatch book</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="step-card rounded-2xl p-8 shadow-lg fade-up">
                    <div class="step-badge w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mb-8 mx-auto">
                        3
                    </div>

                    <h3 class="text-2xl font-semibold text-gray-900 mb-6 text-center">
                        Measurements & Custom Planning
                    </h3>

                    <div class="mb-8">
                        <div class="w-20 h-1 bg-pink-300 mx-auto mb-6"></div>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <i class="fas fa-check text-pink-500 mt-1 mr-3"></i>
                                <p class="text-gray-600">Precise body measurements for perfect fit</p>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-check text-pink-500 mt-1 mr-3"></i>
                                <p class="text-gray-600">Create your personalized style roadmap</p>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-check text-pink-500 mt-1 mr-3"></i>
                                <p class="text-gray-600">Receive tailored recommendations and next steps</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-5 border border-gray-100">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center mr-3">
                                <i class="fas fa-list-check text-pink-500"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">You Receive</p>
                                <p class="font-medium">Personalized style guide</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Steps (Stacked) -->
        <div class="md:hidden space-y-8">
            <!-- Step 1 Mobile -->
            <div class="step-card rounded-2xl p-8 shadow-lg fade-up">
                <div class="flex items-start mb-6">
                    <div class="step-badge w-14 h-14 rounded-full flex items-center justify-center text-xl font-bold mr-5 flex-shrink-0">
                        1
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 pt-2">
                        Discuss Your Style & Occasion
                    </h3>
                </div>

                <div class="mb-6">
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <i class="fas fa-check text-pink-500 mt-1 mr-3"></i>
                            <p class="text-gray-600">Share your style preferences, lifestyle needs, and upcoming events</p>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-check text-pink-500 mt-1 mr-3"></i>
                            <p class="text-gray-600">Discuss your comfort zone and areas you'd like to explore</p>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-check text-pink-500 mt-1 mr-3"></i>
                            <p class="text-gray-600">Define color palettes that complement your skin tone</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-4 border border-gray-100">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center mr-3">
                            <i class="fas fa-clock text-pink-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Duration: 20-25 minutes</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2 Mobile -->
            <div class="step-card rounded-2xl p-8 shadow-lg fade-up">
                <div class="flex items-start mb-6">
                    <div class="step-badge w-14 h-14 rounded-full flex items-center justify-center text-xl font-bold mr-5 flex-shrink-0">
                        2
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 pt-2">
                        Explore Fabrics & Design Options
                    </h3>
                </div>

                <div class="mb-6">
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <i class="fas fa-check text-pink-500 mt-1 mr-3"></i>
                            <p class="text-gray-600">Touch and feel various fabric samples and textures</p>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-check text-pink-500 mt-1 mr-3"></i>
                            <p class="text-gray-600">Explore design options, patterns, and silhouettes</p>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-check text-pink-500 mt-1 mr-3"></i>
                            <p class="text-gray-600">Review seasonal trends and timeless classics</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-4 border border-gray-100">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center mr-3">
                            <i class="fas fa-tshirt text-pink-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Includes fabric swatch book</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3 Mobile -->
            <div class="step-card rounded-2xl p-8 shadow-lg fade-up">
                <div class="flex items-start mb-6">
                    <div class="step-badge w-14 h-14 rounded-full flex items-center justify-center text-xl font-bold mr-5 flex-shrink-0">
                        3
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 pt-2">
                        Measurements & Custom Planning
                    </h3>
                </div>

                <div class="mb-6">
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <i class="fas fa-check text-pink-500 mt-1 mr-3"></i>
                            <p class="text-gray-600">Precise body measurements for perfect fit</p>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-check text-pink-500 mt-1 mr-3"></i>
                            <p class="text-gray-600">Create your personalized style roadmap</p>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-check text-pink-500 mt-1 mr-3"></i>
                            <p class="text-gray-600">Receive tailored recommendations and next steps</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-4 border border-gray-100">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center mr-3">
                            <i class="fas fa-list-check text-pink-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Receive personalized style guide</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Appointment Outcome -->
        <div class="mt-20 fade-up">
            <div class="bg-gradient-to-r from-pink-50 to-white rounded-2xl p-8 md:p-12 shadow-lg">
                <div class="md:flex items-center">
                    <div class="md:w-2/3 mb-8 md:mb-0 md:pr-12">
                        <h3 class="text-2xl font-semibold text-gray-900 mb-4">After Your Appointment</h3>
                        <p class="text-gray-600 mb-6">
                            Within 48 hours, you'll receive a comprehensive digital style guide with all recommendations,
                            measurements, fabric choices, and a personalized shopping list tailored specifically for you.
                        </p>
                        <div class="flex flex-wrap gap-4">
                            <div class="flex items-center">
                                <i class="fas fa-envelope text-pink-500 mr-2"></i>
                                <span class="text-gray-700">Digital Style Guide</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-shopping-bag text-pink-500 mr-2"></i>
                                <span class="text-gray-700">Curated Shopping List</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-percent text-pink-500 mr-2"></i>
                                <span class="text-gray-700">15% Discount on First Purchase</span>
                            </div>
                        </div>
                    </div>
                    <div class="md:w-1/3">
                        <div class="bg-white rounded-xl p-6 text-center shadow-sm hover-lift">
                            <div class="w-16 h-16 rounded-full bg-pink-100 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-gift text-2xl text-pink-500"></i>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-2">Special Bonus</h4>
                            <p class="text-gray-600 text-sm mb-4">Book your first appointment and receive our exclusive style starter kit.</p>
                            <button class="bg-[#EC4899] text-white font-medium py-3 px-6 rounded-full text-sm w-full hover:bg-pink-600 transition duration-300">
                                <i class="fas fa-calendar-plus mr-2"></i> Book Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Preview -->
        <div class="mt-20 pt-12 border-t border-gray-100 fade-up">
            <div class="text-center mb-10">
                <h3 class="text-2xl font-semibold text-gray-900 mb-4">Frequently Asked Questions</h3>
                <p class="text-gray-600 max-w-2xl mx-auto">Get answers to common questions about our styling appointments.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-50 rounded-xl p-6 hover-lift">
                    <h4 class="font-medium text-gray-900 mb-3 flex items-center">
                        <i class="fas fa-question-circle text-pink-500 mr-3"></i>
                        What should I bring to my appointment?
                    </h4>
                    <p class="text-gray-600 text-sm">Bring inspiration photos, favorite clothing items, and any specific items you're shopping for. Comfortable clothing is recommended for accurate measurements.</p>
                </div>

                <div class="bg-gray-50 rounded-xl p-6 hover-lift">
                    <h4 class="font-medium text-gray-900 mb-3 flex items-center">
                        <i class="fas fa-question-circle text-pink-500 mr-3"></i>
                        Can I bring a friend to my appointment?
                    </h4>
                    <p class="text-gray-600 text-sm">Absolutely! We welcome up to two guests. Having a second opinion can be helpful during the styling process.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Meet Your Designer Section -->
<section class="bg-gray-50 py-16 md:py-24 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Section Title -->
        <div class="text-center mb-16 fade-in-left">
            <h2 class="section-heading text-3xl md:text-4xl lg:text-5xl text-gray-900 mb-6">
                Meet Your <span class="text-[#EC4899]">Designer</span>
            </h2>
            <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto">
                Your personal style journey begins with a dedicated fashion expert who understands your vision.
            </p>
            <div class="w-24 h-1 bg-pink-400 mx-auto mt-8"></div>
        </div>

        <!-- Two Column Layout -->
        <div class="lg:flex items-center gap-12 lg:gap-16">
            <!-- Left Column: Designer Image -->
            <div class="lg:w-1/2 mb-12 lg:mb-0 fade-in-left">
                <div class="designer-image-container shadow-2xl">
                    <img
                        src="https://images.unsplash.com/photo-1581044777550-4cfa60707c03?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1206&q=80"
                        alt="Sophia Laurent - Fashion Designer at Élégance Boutique"
                        class="w-full h-auto object-cover rounded-2xl">

                    <!-- Badge on Image -->
                    <div class="absolute top-6 right-6 bg-white rounded-full py-2 px-4 shadow-lg">
                        <div class="flex items-center">
                            <div class="w-2 h-2 rounded-full bg-[#EC4899] mr-2"></div>
                            <span class="text-sm font-medium text-gray-800">Lead Stylist</span>
                        </div>
                    </div>

                    <!-- Experience Badge -->
                    <div class="absolute bottom-6 left-6 bg-white rounded-xl p-4 shadow-lg max-w-xs">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-full bg-pink-100 flex items-center justify-center mr-4">
                                <i class="fas fa-award text-xl text-[#EC4899]"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Experience</p>
                                <p class="font-bold text-lg text-gray-900">12+ Years</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image Caption -->
                <p class="text-center text-gray-500 text-sm mt-4 italic">
                    Sophia in her design studio, working on a custom evening gown
                </p>
            </div>

            <!-- Right Column: Designer Info -->
            <div class="lg:w-1/2 fade-in-right">
                <div class="mb-8">
                    <div class="inline-flex items-center px-4 py-2 rounded-full bg-pink-100 text-pink-700 text-sm font-medium mb-6">
                        <i class="fas fa-star mr-2"></i>
                        Most Requested Stylist
                    </div>

                    <h3 class="section-heading text-3xl md:text-4xl text-gray-900 mb-4">
                        Sophia Laurent
                    </h3>

                    <p class="text-lg text-gray-500 mb-6">
                        Lead Fashion Designer & Personal Stylist
                    </p>

                    <div class="w-16 h-1 bg-pink-300 mb-8"></div>
                </div>

                <!-- About Text -->
                <div class="mb-10">
                    <p class="text-gray-700 text-lg leading-relaxed mb-6">
                        With over a decade of experience in haute couture and bespoke fashion, Sophia brings a
                        <span class="font-medium text-[#EC4899]">passionate, detail-oriented approach</span> to every styling session.
                        She believes that true style comes from understanding the individual, not just following trends.
                    </p>

                    <p class="text-gray-700 text-lg leading-relaxed mb-8">
                        Sophia specializes in creating
                        <span class="font-medium text-[#EC4899]">custom, personalized looks</span> that reflect her clients' personalities,
                        lifestyles, and unique beauty. Her philosophy is that every woman deserves to feel confident
                        and beautiful in clothing designed specifically for her.
                    </p>
                </div>

                <!-- Specialties -->
                <div class="mb-10">
                    <h4 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                        <i class="fas fa-heart text-[#EC4899] mr-3"></i>
                        Specialties
                    </h4>

                    <div class="flex flex-wrap gap-3 mb-8">
                        <span class="bg-white px-4 py-2 rounded-full text-gray-700 shadow-sm border border-gray-100">
                            Custom Evening Wear
                        </span>
                        <span class="bg-white px-4 py-2 rounded-full text-gray-700 shadow-sm border border-gray-100">
                            Personal Color Analysis
                        </span>
                        <span class="bg-white px-4 py-2 rounded-full text-gray-700 shadow-sm border border-gray-100">
                            Body Shape Styling
                        </span>
                        <span class="bg-white px-4 py-2 rounded-full text-gray-700 shadow-sm border border-gray-100">
                            Wardrobe Transformation
                        </span>
                    </div>
                </div>

                <!-- Button -->
                <div class="mb-12">
                    <button class="profile-btn font-medium py-4 px-10 rounded-full text-lg shadow-lg inline-flex items-center">
                        <i class="fas fa-user-circle mr-3"></i> View Designer Profile
                    </button>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                    <div class="stat-item bg-white p-6 rounded-2xl shadow-sm text-center hover-lift">
                        <div class="text-3xl font-bold text-gray-900 mb-2">850+</div>
                        <div class="text-gray-600">Happy Clients</div>
                    </div>
                    <div class="stat-item bg-white p-6 rounded-2xl shadow-sm text-center hover-lift">
                        <div class="text-3xl font-bold text-gray-900 mb-2">98%</div>
                        <div class="text-gray-600">Satisfaction Rate</div>
                    </div>
                    <div class="stat-item bg-white p-6 rounded-2xl shadow-sm text-center hover-lift">
                        <div class="text-3xl font-bold text-gray-900 mb-2">Paris</div>
                        <div class="text-gray-600">Trained In</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Designer Philosophy -->
        <div class="mt-20 pt-12 border-t border-gray-200 fade-in-left">
            <div class="md:flex items-start">
                <div class="md:w-1/3 mb-8 md:mb-0">
                    <h4 class="text-2xl font-semibold text-gray-900 mb-4">
                        <span class="text-[#EC4899]">Design</span> Philosophy
                    </h4>
                    <div class="w-16 h-1 bg-pink-300 mb-6"></div>
                </div>

                <div class="md:w-2/3">
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover-lift">
                        <div class="flex items-start mb-6">
                            <div class="w-12 h-12 rounded-full bg-pink-100 flex items-center justify-center mr-4 flex-shrink-0">
                                <i class="fas fa-quote-left text-xl text-[#EC4899]"></i>
                            </div>
                            <p class="text-xl italic text-gray-700">
                                "Fashion is not just about clothing; it's about telling your unique story. My goal is to help every woman discover her authentic style and express it with confidence."
                            </p>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900">Sophia Laurent</p>
                                <p class="text-gray-500 text-sm">Lead Designer, Élégance Boutique</p>
                            </div>

                            <div class="flex space-x-2">
                                <a href="#" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-pink-100 hover:text-[#EC4899] transition">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="#" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-pink-100 hover:text-[#EC4899] transition">
                                    <i class="fab fa-pinterest"></i>
                                </a>
                                <a href="#" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-pink-100 hover:text-[#EC4899] transition">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Other Designers CTA -->
        <div class="mt-16 fade-in-right">
            <div class="bg-gradient-to-r from-pink-50 to-white rounded-2xl p-8 md:p-10 text-center hover-lift">
                <h4 class="text-2xl font-semibold text-gray-900 mb-4">Meet Our Entire Team</h4>
                <p class="text-gray-600 max-w-2xl mx-auto mb-8">
                    Sophia is just one of our talented designers. We have a team of 10+ expert stylists, each with their own unique specialties and approach to fashion.
                </p>
                <a href="#" class="inline-flex items-center text-[#EC4899] font-medium hover:text-pink-700">
                    <span>View All Designers</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="bg-white py-16 md:py-24 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Section Header -->
        <div class="text-center mb-16 md:mb-20 fade-up">
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-pink-50 text-pink-700 text-sm font-medium mb-6">
                <i class="fas fa-heart mr-2"></i>
                Loved by Clients
            </div>

            <h2 class="section-heading text-3xl md:text-4xl lg:text-5xl text-gray-900 mb-6">
                Client <span class="text-[#EC4899]">Testimonials</span>
            </h2>
            <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Hear from women who transformed their style and confidence through our personal styling appointments.
            </p>
            <div class="w-24 h-1 bg-pink-400 mx-auto mt-8"></div>
        </div>

        <!-- Testimonial Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12 mb-16">
            <!-- Testimonial 1 -->
            <div class="testimonial-card rounded-2xl p-8 shadow-lg fade-up">
                <!-- Quote Icon -->
                <div class="flex justify-end mb-6">
                    <i class="fas fa-quote-right text-pink-500 text-3xl"></i>
                </div>

                <!-- Rating -->
                <div class="flex mb-6">
                    <i class="fas fa-star text-yellow-400 mr-1"></i>
                    <i class="fas fa-star text-yellow-400 mr-1"></i>
                    <i class="fas fa-star text-yellow-400 mr-1"></i>
                    <i class="fas fa-star text-yellow-400 mr-1"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                </div>

                <!-- Review Text -->
                <p class="text-gray-700 text-lg leading-relaxed italic mb-8">
                    "Sophia completely transformed my wardrobe for my promotion. I went from feeling insecure to confident in every meeting. Her eye for detail is incredible!"
                </p>

                <!-- Client Info -->
                <div class="flex items-center">
                    <!-- Circular Client Photo -->
                    <div class="mr-4">
                        <img
                            src="https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=774&q=80"
                            alt="Alexandra Chen"
                            class="client-photo w-16 h-16 rounded-full object-cover">
                    </div>

                    <div>
                        <h4 class="text-[#EC4899] font-semibold text-lg">Alexandra Chen</h4>
                        <p class="text-gray-500 text-sm">Marketing Director</p>
                        <p class="text-gray-400 text-xs mt-1">Booked: Personal Style Consultation</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial 2 -->
            <div class="testimonial-card rounded-2xl p-8 shadow-lg fade-up">
                <!-- Quote Icon -->
                <div class="flex justify-end mb-6">
                    <i class="fas fa-quote-right text-pink-500 text-3xl"></i>
                </div>

                <!-- Rating -->
                <div class="flex mb-6">
                    <i class="fas fa-star text-yellow-400 mr-1"></i>
                    <i class="fas fa-star text-yellow-400 mr-1"></i>
                    <i class="fas fa-star text-yellow-400 mr-1"></i>
                    <i class="fas fa-star text-yellow-400 mr-1"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                </div>

                <!-- Review Text -->
                <p class="text-gray-700 text-lg leading-relaxed italic mb-8">
                    "After having my second child, I felt lost with my style. The custom fit guidance was a game-changer. I finally have clothes that fit my new body perfectly."
                </p>

                <!-- Client Info -->
                <div class="flex items-center">
                    <!-- Circular Client Photo -->
                    <div class="mr-4">
                        <img
                            src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                            alt="Maya Rodriguez"
                            class="client-photo w-16 h-16 rounded-full object-cover">
                    </div>

                    <div>
                        <h4 class="text-[#EC4899] font-semibold text-lg">Maya Rodriguez</h4>
                        <p class="text-gray-500 text-sm">Graphic Designer & Mom</p>
                        <p class="text-gray-400 text-xs mt-1">Booked: Custom Fit Guidance</p>
                    </div>
                </div>
            </div>

            <!-- Testimonial 3 -->
            <div class="testimonial-card rounded-2xl p-8 shadow-lg fade-up">
                <!-- Quote Icon -->
                <div class="flex justify-end mb-6">
                    <i class="fas fa-quote-right text-pink-500 text-3xl"></i>
                </div>

                <!-- Rating -->
                <div class="flex mb-6">
                    <i class="fas fa-star text-yellow-400 mr-1"></i>
                    <i class="fas fa-star text-yellow-400 mr-1"></i>
                    <i class="fas fa-star text-yellow-400 mr-1"></i>
                    <i class="fas fa-star text-yellow-400 mr-1"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                </div>

                <!-- Review Text -->
                <p class="text-gray-700 text-lg leading-relaxed italic mb-8">
                    "The fabric and color selection session opened my eyes to colors I never thought would work for me. My wardrobe is now cohesive and truly reflects my personality."
                </p>

                <!-- Client Info -->
                <div class="flex items-center">
                    <!-- Circular Client Photo -->
                    <div class="mr-4">
                        <img
                            src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=776&q=80"
                            alt="Isabella Thompson"
                            class="client-photo w-16 h-16 rounded-full object-cover">
                    </div>

                    <div>
                        <h4 class="text-[#EC4899] font-semibold text-lg">Isabella Thompson</h4>
                        <p class="text-gray-500 text-sm">Lawyer</p>
                        <p class="text-gray-400 text-xs mt-1">Booked: Fabric & Color Selection</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="mb-16 fade-up">
            <div class="bg-gradient-to-r from-pink-50 to-white rounded-2xl p-8 md:p-10">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                    <div>
                        <div class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">4.9<span class="text-[#EC4899]">/5</span></div>
                        <div class="text-gray-600">Average Rating</div>
                    </div>
                    <div>
                        <div class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">1,200+</div>
                        <div class="text-gray-600">Styling Sessions</div>
                    </div>
                    <div>
                        <div class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">98%</div>
                        <div class="text-gray-600">Would Recommend</div>
                    </div>
                    <div>
                        <div class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">50+</div>
                        <div class="text-gray-600">Repeat Clients</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Testimonials (Hidden on Mobile) -->
        <div class="hidden md:block fade-up">
            <div class="text-center mb-10">
                <h3 class="text-2xl font-semibold text-gray-900 mb-4">More Client Stories</h3>
                <p class="text-gray-600 max-w-2xl mx-auto">Hear from other women who transformed their style with us.</p>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-16">
                <div class="bg-gray-50 rounded-2xl p-6 hover-lift">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-full overflow-hidden mr-4">
                            <img
                                src="https://images.unsplash.com/photo-1488426862026-3ee34a7d66df?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1727&q=80"
                                alt="Sarah Johnson"
                                class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">Sarah Johnson</h4>
                            <p class="text-gray-500 text-sm">Wedding Styling</p>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm italic">
                        "My wedding dress consultation was magical. They understood my vision perfectly and created a gown that made me feel like a princess."
                    </p>
                </div>

                <div class="bg-gray-50 rounded-2xl p-6 hover-lift">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-full overflow-hidden mr-4">
                            <img
                                src="https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1771&q=80"
                                alt="Jennifer Lee"
                                class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">Jennifer Lee</h4>
                            <p class="text-gray-500 text-sm">Career Wardrobe Update</p>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm italic">
                        "As a CEO, my appearance matters. The professional wardrobe overhaul gave me the polished, powerful look I needed."
                    </p>
                </div>
            </div>
        </div>

        <!-- Mobile Swipe Indicator -->
        <div class="md:hidden text-center mb-10">
            <div class="flex items-center justify-center text-gray-400 text-sm">
                <span class="mr-2">Swipe for more</span>
                <i class="fas fa-chevron-right"></i>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="text-center fade-up">
            <div class="inline-block bg-gradient-to-r from-pink-500 to-pink-600 rounded-2xl p-1 shadow-xl mb-8">
                <div class="bg-white rounded-xl p-8 md:p-10">
                    <h3 class="text-2xl md:text-3xl font-semibold text-gray-900 mb-6">Ready to Transform Your Style?</h3>
                    <p class="text-gray-600 max-w-2xl mx-auto mb-8">
                        Join hundreds of satisfied clients who have discovered their perfect style through our personal consultations.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <button class="bg-[#EC4899] text-white font-medium py-4 px-10 rounded-full text-lg shadow-lg hover:bg-pink-600 transition duration-300">
                            <i class="fas fa-calendar-check mr-3"></i> Book Your Appointment
                        </button>
                        <button class="bg-white border border-gray-300 text-gray-700 font-medium py-4 px-10 rounded-full text-lg hover:bg-gray-50 transition duration-300">
                            <i class="fas fa-play-circle mr-3"></i> Watch Client Stories
                        </button>
                    </div>
                </div>
            </div>

            <p class="text-gray-500 text-sm">
                All client photos are used with permission. Real names may be changed for privacy.
            </p>
        </div>
    </div>
</section>

<!-- Call-to-Action Section -->
<section class="bg-gray-50 py-20 md:py-32 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Background decorative elements -->
    <div class="absolute top-10 left-10 w-24 h-24 rounded-full bg-pink-100 opacity-30"></div>
    <div class="absolute bottom-20 right-10 w-32 h-32 rounded-full bg-pink-50 opacity-40"></div>
    <div class="absolute top-1/2 left-1/4 w-16 h-16 rounded-full bg-pink-100 opacity-20"></div>
    
    <div class="max-w-4xl mx-auto relative z-10">
        <!-- Main CTA Content -->
        <div class="text-center mb-16 fade-up">
            <!-- Icon/Emblem -->
            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-pink-100 to-pink-50 flex items-center justify-center mx-auto mb-8 shadow-lg">
                <i class="fas fa-star text-3xl text-pink-500"></i>
            </div>
            
            <!-- Heading -->
            <h1 class="section-heading text-4xl md:text-5xl lg:text-6xl text-gray-900 mb-8">
                Ready to Plan Your 
                <span class="text-gradient">Perfect Outfit</span>?
            </h1>
            
            <!-- Supporting Text -->
            <p class="text-xl md:text-2xl text-gray-600 max-w-2xl mx-auto leading-relaxed mb-12">
                Transform your style with a one-on-one consultation from our expert stylists. 
                Discover pieces that make you look and feel absolutely confident.
            </p>
            
            <!-- Button -->
            <div>
                <button class="cta-button font-semibold py-5 px-12 rounded-full text-xl shadow-xl">
                    <i class="fas fa-calendar-alt mr-4"></i> Book Your Appointment Now
                </button>
            </div>
            
            <!-- Subtext under button -->
            <p class="text-gray-500 mt-8">
                <i class="fas fa-lock text-pink-400 mr-2"></i> Secure booking • Free consultation • Flexible scheduling
            </p>
        </div>
        
        <!-- Benefits Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16 fade-up">
            <div class="bg-white p-8 rounded-2xl shadow-sm text-center hover-lift">
                <div class="w-14 h-14 rounded-full bg-pink-50 flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-user-check text-2xl text-pink-500"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Personalized Experience</h3>
                <p class="text-gray-600">One-on-one attention from expert stylists who understand your unique style.</p>
            </div>
            
            <div class="bg-white p-8 rounded-2xl shadow-sm text-center hover-lift">
                <div class="w-14 h-14 rounded-full bg-pink-50 flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-gem text-2xl text-pink-500"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Premium Quality</h3>
                <p class="text-gray-600">Access to exclusive fabrics and designer collections not available in stores.</p>
            </div>
            
            <div class="bg-white p-8 rounded-2xl shadow-sm text-center hover-lift">
                <div class="w-14 h-14 rounded-full bg-pink-50 flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-truck text-2xl text-pink-500"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Free Delivery</h3>
                <p class="text-gray-600">Selected pieces delivered to your home with free shipping and returns.</p>
            </div>
        </div>
        
        <!-- Trust Indicators -->
        <div class="fade-up">
            <div class="bg-white rounded-2xl p-8 md:p-10 shadow-sm hover-lift">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="mb-8 md:mb-0 md:pr-10">
                        <h3 class="text-2xl font-semibold text-gray-900 mb-4">
                            <i class="fas fa-shield-alt text-pink-500 mr-3"></i>
                            Book With Confidence
                        </h3>
                        <p class="text-gray-600">
                            Our 100% satisfaction guarantee ensures you'll love your personalized styling experience.
                        </p>
                    </div>
                    
                    <div class="text-center md:text-right">
                        <div class="flex items-center justify-center md:justify-end mb-4">
                            <i class="fas fa-star text-yellow-400 text-xl mr-1"></i>
                            <i class="fas fa-star text-yellow-400 text-xl mr-1"></i>
                            <i class="fas fa-star text-yellow-400 text-xl mr-1"></i>
                            <i class="fas fa-star text-yellow-400 text-xl mr-1"></i>
                            <i class="fas fa-star text-yellow-400 text-xl"></i>
                            <span class="ml-3 font-bold text-gray-900">4.9/5</span>
                        </div>
                        <p class="text-gray-500 text-sm">Based on 1,200+ client reviews</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- FAQ Preview -->
        <div class="mt-16 text-center fade-up">
            <p class="text-gray-600 mb-4">
                <i class="fas fa-question-circle text-pink-400 mr-2"></i>
                Have questions about the appointment process?
            </p>
            <a href="#" class="inline-flex items-center text-pink-600 font-medium hover:text-pink-700">
                <span>View Frequently Asked Questions</span>
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
    
    <!-- Bottom decorative border -->
    <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-pink-300 to-transparent"></div>
</section>

@endsection

@section('scripts')
<script>
    // Initialize scroll animations
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

        // Add hover effect to appointment button in hero
        const heroButton = document.querySelector('.appointment-btn');
        if (heroButton) {
            heroButton.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#FCE7F3';
                this.style.color = '#831843';
            });

            heroButton.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '#EC4899';
                this.style.color = '#ffffff';
            });

            heroButton.addEventListener('click', function() {
                alert("Welcome to Élégance Boutique! Our booking system would open here. Thank you for your interest in our personal styling services.");
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 200);
            });
        }

        // Add hover effect to other appointment buttons
        const appointmentButtons = document.querySelectorAll('button.bg-\\[\\#EC4899\\]');
        appointmentButtons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#db2777';
            });

            button.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '#EC4899';
            });

            button.addEventListener('click', function() {
                alert("Redirecting to appointment booking... Thank you for choosing Élégance Boutique!");
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 200);
            });
        });

        // CTA button hover effect
        const ctaButton = document.querySelector('.cta-button');
        if (ctaButton) {
            ctaButton.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#FCE7F3';
                this.style.color = '#831843';
            });

            ctaButton.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '#EC4899';
                this.style.color = 'white';
            });

            ctaButton.addEventListener('click', function() {
                alert("Welcome to Élégance Boutique!\n\nYou are being redirected to our appointment booking system. Our next available slot is tomorrow at 10:00 AM.\n\nThank you for choosing us for your styling journey!");
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 200);
            });
        }

        // Profile button hover effect
        const profileButton = document.querySelector('.profile-btn');
        if (profileButton) {
            profileButton.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#FCE7F3';
                this.style.color = '#831843';
            });

            profileButton.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '#EC4899';
                this.style.color = 'white';
            });

            profileButton.addEventListener('click', function() {
                alert("Opening Sophia Laurent's full profile...\n\nExperience: 12+ years in fashion design\nEducation: Parsons School of Design, Paris\nSpecialties: Custom evening wear, personal color analysis, body shape styling\nAwards: 2022 Fashion Stylist of the Year, 2020 Couture Excellence Award\n\nContact: sophia@eleganceboutique.com");
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 200);
            });
        }

        // Submit button hover effect
        const submitButton = document.querySelector('.submit-btn');
        if (submitButton) {
            submitButton.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#FCE7F3';
                this.style.color = '#831843';
            });

            submitButton.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '#EC4899';
                this.style.color = 'white';
            });
        }

        // Watch Client Stories button
        const watchButton = document.querySelector('button.bg-white.border');
        if (watchButton) {
            watchButton.addEventListener('click', function() {
                alert("Opening client testimonial videos... Hear directly from our satisfied clients about their styling journey.");
            });
        }

        // Testimonial card click interactions
        const testimonialCards = document.querySelectorAll('.testimonial-card');
        testimonialCards.forEach(card => {
            card.addEventListener('click', function() {
                const clientName = this.querySelector('.client-name').textContent;
                const review = this.querySelector('p.text-gray-700').textContent;
                alert(`${clientName}'s Full Story:\n\n${review}\n\n"In my full testimonial, I share more details about my experience with Élégance Boutique..."`);
            });
        });

        // Social media links interaction
        const socialLinks = document.querySelectorAll('a.w-10');
        socialLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const platform = this.querySelector('i').className.includes('instagram') ? 'Instagram' :
                    this.querySelector('i').className.includes('pinterest') ? 'Pinterest' : 'LinkedIn';
                alert(`Redirecting to Sophia's ${platform} profile...`);
            });
        });

        // FAQ link interaction
        const faqLink = document.querySelector('a[href="#"]');
        if (faqLink && faqLink.textContent.includes('Frequently Asked Questions')) {
            faqLink.addEventListener('click', function(e) {
                e.preventDefault();
                alert("Opening FAQ page...\n\nCommon questions:\n\n1. How long does an appointment last?\n   - 60 minutes for the initial consultation\n\n2. What should I bring to my appointment?\n   - Inspiration photos and any specific items you're shopping for\n\n3. Can I reschedule my appointment?\n   - Yes, up to 24 hours in advance\n\n4. Is there a cancellation fee?\n   - No fee for cancellations made 24+ hours in advance");
            });
        }

        // Initialize calendar functionality
        initializeCalendar();
    });

    // Calendar functionality
    function initializeCalendar() {
        let currentDate = new Date();
        let selectedDate = null;
        let selectedTimeSlot = null;

        // Time slots data
        const timeSlots = [
            '9:00 AM', '10:30 AM', '12:00 PM',
            '1:30 PM', '3:00 PM', '4:30 PM',
            '6:00 PM', '7:30 PM'
        ];

        // Pre-booked slots (for demo)
        const bookedSlots = ['10:30 AM', '1:30 PM', '6:00 PM'];

        // Render calendar for current month
        function renderCalendar() {
            const calendarGrid = document.getElementById('calendar-grid');
            const currentMonthElement = document.getElementById('current-month');

            // Clear previous calendar
            calendarGrid.innerHTML = '';

            // Set current month display
            const monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];
            currentMonthElement.textContent = `${monthNames[currentDate.getMonth()]} ${currentDate.getFullYear()}`;

            // Get first day of month and total days
            const firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
            const lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
            const totalDays = lastDay.getDate();
            const startingDay = firstDay.getDay();

            // Add empty cells for days before the first day of the month
            for (let i = 0; i < startingDay; i++) {
                const emptyCell = document.createElement('div');
                emptyCell.classList.add('h-10');
                calendarGrid.appendChild(emptyCell);
            }

            // Add day cells
            const today = new Date();
            const isCurrentMonth = today.getMonth() === currentDate.getMonth() &&
                today.getFullYear() === currentDate.getFullYear();

            for (let day = 1; day <= totalDays; day++) {
                const dayElement = document.createElement('button');
                dayElement.classList.add('calendar-day', 'h-10', 'w-10', 'rounded-full', 'flex', 'items-center', 'justify-center', 'text-sm', 'font-medium');

                // Check if this day is today
                if (isCurrentMonth && day === today.getDate()) {
                    dayElement.classList.add('border', 'border-pink-300');
                }

                // Check if this day is selected
                if (selectedDate && selectedDate === day) {
                    dayElement.classList.add('calendar-day-selected');
                }

                // Disable past dates in current month
                if (isCurrentMonth && day < today.getDate()) {
                    dayElement.classList.add('calendar-day-disabled', 'text-gray-300');
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

        // Render time slots
        function renderTimeSlots() {
            const timeSlotsContainer = document.getElementById('time-slots');
            timeSlotsContainer.innerHTML = '';

            timeSlots.forEach(time => {
                const timeSlotElement = document.createElement('button');
                timeSlotElement.classList.add('time-slot', 'py-3', 'px-4', 'rounded-xl', 'text-sm', 'font-medium');

                // Check if this slot is booked
                if (bookedSlots.includes(time)) {
                    timeSlotElement.classList.add('time-slot-booked');
                    timeSlotElement.disabled = true;
                    timeSlotElement.innerHTML = `${time} <span class="text-xs ml-1">(Booked)</span>`;
                } else {
                    timeSlotElement.classList.add('bg-gray-50', 'text-gray-700');
                    timeSlotElement.textContent = time;

                    // Check if this slot is selected
                    if (selectedTimeSlot === time) {
                        timeSlotElement.classList.add('time-slot-selected');
                        timeSlotElement.classList.remove('bg-gray-50', 'text-gray-700');
                    }
                }

                timeSlotElement.dataset.time = time;

                if (!bookedSlots.includes(time)) {
                    timeSlotElement.addEventListener('click', function() {
                        selectTimeSlot(this.dataset.time);
                    });
                }

                timeSlotsContainer.appendChild(timeSlotElement);
            });
        }

        // Select a date
        function selectDate(day) {
            selectedDate = day;

            // Update calendar display
            const dayElements = document.querySelectorAll('.calendar-day:not(.calendar-day-disabled)');
            dayElements.forEach(element => {
                element.classList.remove('calendar-day-selected');

                if (parseInt(element.dataset.day) === day) {
                    element.classList.add('calendar-day-selected');
                }
            });

            // Update selected date display
            const monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];
            const displayElement = document.getElementById('selected-date-display');
            displayElement.textContent = `${monthNames[currentDate.getMonth()]} ${day}, ${currentDate.getFullYear()}`;

            // Clear selected time when date changes
            if (selectedTimeSlot) {
                selectedTimeSlot = null;
                renderTimeSlots();
                document.getElementById('selected-time-display').classList.add('hidden');
            }
        }

        // Select a time slot
        function selectTimeSlot(time) {
            selectedTimeSlot = time;

            // Update time slots display
            renderTimeSlots();

            // Update selected time display
            const displayElement = document.getElementById('selected-time-display');
            const timeTextElement = document.getElementById('selected-time-text');

            timeTextElement.textContent = time;
            displayElement.classList.remove('hidden');
        }

        // Month navigation
        document.getElementById('prev-month').addEventListener('click', function() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar();

            // Clear selected date when month changes
            selectedDate = null;
            document.getElementById('selected-date-display').textContent = 'No date selected';

            // Clear selected time
            if (selectedTimeSlot) {
                selectedTimeSlot = null;
                renderTimeSlots();
                document.getElementById('selected-time-display').classList.add('hidden');
            }
        });

        document.getElementById('next-month').addEventListener('click', function() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar();

            // Clear selected date when month changes
            selectedDate = null;
            document.getElementById('selected-date-display').textContent = 'No date selected';

            // Clear selected time
            if (selectedTimeSlot) {
                selectedTimeSlot = null;
                renderTimeSlots();
                document.getElementById('selected-time-display').classList.add('hidden');
            }
        });

        // Form submission
        document.getElementById('appointment-form').addEventListener('submit', function(e) {
            e.preventDefault();

            // Validate selections
            if (!selectedDate) {
                alert('Please select a date for your appointment.');
                return;
            }

            if (!selectedTimeSlot) {
                alert('Please select a time slot for your appointment.');
                return;
            }

            // Get form values
            const name = document.getElementById('full-name').value;
            const email = document.getElementById('email').value;
            const phone = document.getElementById('phone').value;
            const appointmentType = document.getElementById('appointment-type').value;

            // In a real app, this would submit to a server
            const monthNames = ["January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];
            const appointmentDate = `${monthNames[currentDate.getMonth()]} ${selectedDate}, ${currentDate.getFullYear()}`;

            // Show confirmation message
            alert(`Thank you, ${name}! Your appointment has been scheduled for ${appointmentDate} at ${selectedTimeSlot}. A confirmation email has been sent to ${email}.`);

            // Reset form (in a real app, you might redirect or show a success message)
            this.reset();
            selectedDate = null;
            selectedTimeSlot = null;

            // Reset displays
            document.getElementById('selected-date-display').textContent = 'No date selected';
            document.getElementById('selected-time-display').classList.add('hidden');

            // Re-render to clear selections
            renderCalendar();
            renderTimeSlots();
        });

        // Initialize
        renderCalendar();
        renderTimeSlots();

        // Set default selected date to today
        selectDate(new Date().getDate());
    }
</script>
@endsection