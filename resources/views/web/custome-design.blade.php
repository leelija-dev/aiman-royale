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



    /* Hero Section */
    .hero-bg {
        background-image: linear-gradient(rgba(20, 15, 35, 0.75), rgba(40, 25, 60, 0.85)), url('https://images.unsplash.com/photo-1595777457583-95e059d581b8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=80');
        background-size: cover;
        background-position: center 30%;
        background-repeat: no-repeat;
    }

    .btn-primary {
        background: linear-gradient(135deg, #d4a5c3 0%, #b76e79 100%);
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(183, 110, 121, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(183, 110, 121, 0.4);
    }

    .btn-outline {
        border-color: #f8e1e7;
        color: #f8e1e7;
        transition: all 0.3s ease;
    }

    .btn-outline:hover {
        background-color: rgba(248, 225, 231, 0.1);
        transform: translateY(-3px);
    }


    .step-badge {
        background: linear-gradient(135deg, #f8c8dc 0%, #e6b0d2 100%);
        box-shadow: 0 6px 20px rgba(230, 176, 210, 0.3);
        width: 70px;
        height: 70px;

        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        font-weight: 600;
        color: #7a4a76;
        border: 3px solid white;
    }

    .step-card {
        background-color: white;
        border-radius: 24px;
        box-shadow: 0 10px 30px rgba(168, 129, 163, 0.08);
        transition: all 0.4s ease;
        overflow: hidden;
        border: 1px solid rgba(245, 220, 240, 0.5);
    }

    .step-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(168, 129, 163, 0.15);
    }

    .step-image {
        height: 300px;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .step-card:hover .step-image {
        transform: scale(1.05);
    }

    .divider {
        height: 2px;
        background: linear-gradient(90deg, transparent, #e6b0d2, transparent);
        margin: 2rem 0;
    }

    .vertical-line {
        position: absolute;
        left: 50%;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(180deg, #f8c8dc, #d89fc1, #f8c8dc);
        transform: translateX(-50%);
        display: none;
    }

    @media (min-width: 768px) {
        .vertical-line {
            display: block;
        }
    }

    .section-title {
        background: linear-gradient(135deg, #9a6b8c, #d89fc1);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .step-title {
        color: #7a4a76;
        position: relative;
        display: inline-block;
    }

    .step-title:after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, #f8c8dc, #e6b0d2);
        border-radius: 2px;
    }

    .process-description {
        color: #6b556b;
        line-height: 1.7;
    }



    /* Gallery Section */
    .gallery-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(175, 135, 155, 0.08);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.1);
        position: relative;
        height: 100%;
    }

    .gallery-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(175, 135, 155, 0.15);
    }

    .gallery-image {
        height: 320px;
        width: 100%;
        object-fit: cover;
        transition: transform 0.7s ease;
    }

    .gallery-card:hover .gallery-image {
        transform: scale(1.05);
    }

    .custom-label {
        position: absolute;
        top: 20px;
        right: -100px;
        background: rgba(255, 255, 255, 0.92);
        color: #9a6b8c;
        padding: 8px 20px;
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 1px;
        transform: rotate(45deg);
        transition: all 0.5s ease;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        z-index: 10;
    }

    .gallery-card:hover .custom-label {
        right: -30px;
    }

    .overlay-content {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(90, 61, 92, 0.9), transparent);
        color: white;
        padding: 25px 20px 20px;
        transform: translateY(100%);
        transition: transform 0.5s ease;
    }

    .gallery-card:hover .overlay-content {
        transform: translateY(0);
    }

    /* Features Section */
    .feature-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(218, 165, 185, 0.08);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.1);
        height: 100%;
        border: 1px solid rgba(255, 240, 245, 0.8);
        overflow: hidden;
        position: relative;
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(218, 165, 185, 0.15);
        border-color: rgba(255, 200, 221, 0.5);
    }

    .feature-card:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #f8c8dc, #e6b0d2);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .feature-card:hover:before {
        opacity: 1;
    }

    .icon-circle {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        transition: all 0.4s ease;
        background: linear-gradient(135deg, #fff5f9, #fff0f6);
        box-shadow: 0 8px 25px rgba(218, 165, 185, 0.12);
        border: 2px solid rgba(255, 255, 255, 0.9);
    }

    .feature-card:hover .icon-circle {
        transform: scale(1.1);
        background: linear-gradient(135deg, #f8c8dc, #e6b0d2);
    }

    .feature-icon {
        font-size: 2.5rem;
        color: #9a6b8c;
        transition: all 0.4s ease;
    }

    .feature-card:hover .feature-icon {
        color: white;
        transform: scale(1.1);
    }

    /* Craftsmanship Section */
    .image-container {
        position: relative;
        overflow: hidden;
        border-radius: 24px;
        box-shadow: 0 25px 50px -12px rgba(175, 135, 155, 0.25);
    }

    .image-container img {
        transition: transform 1.2s cubic-bezier(0.165, 0.84, 0.44, 1);
        width: 100%;
        height: auto;
    }

    .image-container:hover img {
        transform: scale(1.05);
    }

    .image-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(90, 61, 92, 0.9), transparent);
        color: white;
        padding: 30px;
        transform: translateY(100%);
        transition: transform 0.6s ease;
    }

    .image-container:hover .image-overlay {
        transform: translateY(0);
    }

    .content-card {
        background: white;
        border-radius: 24px;
        padding: 60px;
        box-shadow: 0 20px 40px rgba(175, 135, 155, 0.1);
        border: 1px solid rgba(245, 220, 240, 0.5);
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .content-card:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, #f8c8dc, #e6b0d2, #f8c8dc);
    }

    .craftsmanship-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 24px;
        padding-bottom: 24px;
        border-bottom: 1px solid rgba(245, 220, 240, 0.5);
    }

    .craftsmanship-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .item-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #fff5f9, #fff0f6);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 20px;
        flex-shrink: 0;
        border: 2px solid white;
        box-shadow: 0 8px 20px rgba(218, 165, 185, 0.15);
    }

    .item-icon i {
        font-size: 1.5rem;
        color: #9a6b8c;
    }

    /* Testimonials */
    .testimonial-card {
        background: white;
        border-radius: 24px;
        box-shadow: 0 15px 40px rgba(175, 135, 155, 0.1);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.1);
        overflow: hidden;
        border: 1px solid rgba(245, 220, 240, 0.5);
        height: 100%;
        position: relative;
    }

    .testimonial-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 50px rgba(175, 135, 155, 0.2);
        border-color: rgba(255, 200, 221, 0.5);
    }

    .customer-photo {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        border: 5px solid white;
        box-shadow: 0 8px 25px rgba(218, 165, 185, 0.2);
        margin: 0 auto;
        overflow: hidden;
        position: relative;
        z-index: 2;
        transition: all 0.4s ease;
    }

    .testimonial-card:hover .customer-photo {
        transform: scale(1.05);
        box-shadow: 0 12px 30px rgba(218, 165, 185, 0.3);
    }

    .customer-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .stars {
        color: #FFC107;
        font-size: 1.1rem;
        letter-spacing: 2px;
    }

    /* Form Section */
    .form-section {
        background: linear-gradient(135deg, #ffffff 0%, #fafafa 100%);
    }

    .form-container {
        background: white;
        border-radius: 24px;
        box-shadow: 0 8px 40px rgba(0, 0, 0, 0.06);
        border: 1px solid #f0f0f5;
        position: relative;
        overflow: hidden;
    }

    .form-title {
        color: #222233;
        position: relative;
        display: inline-block;
    }

    .form-title:after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, #ff6b9d, #ff8fab);
        border-radius: 2px;
    }

    .form-input {
        background: #f9f9fb;
        border: 2px solid #e8e8f0;
        border-radius: 12px;
        padding: 14px 18px;
        font-size: 0.95rem;
        color: #333344;
        transition: all 0.2s ease;
        width: 100%;
    }

    .form-input:focus {
        outline: none;
        border-color: #ff8fab;
        background: white;
        box-shadow: 0 0 0 3px rgba(255, 143, 171, 0.1);
    }

    .form-input:hover {
        border-color: #d8d8e5;
    }

    .form-label {
        color: #555566;
        font-weight: 500;
        margin-bottom: 8px;
        display: block;
        font-size: 0.9rem;
    }

    .required-star {
        color: #ff6b9d;
    }

    .measurement-card {
        background: #f9f9fb;
        border-radius: 16px;
        padding: 20px;
        border: 2px solid #e8e8f0;
        transition: all 0.2s ease;
    }

    .measurement-card:hover {
        border-color: #ff8fab;
        background: white;
    }

    .measurement-unit {
        color: #777788;
        font-size: 0.85rem;
        margin-left: 4px;
    }

    .form-select {
        appearance: none;
        background: #f9f9fb url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23777788' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E") no-repeat right 18px center;
        border: 2px solid #e8e8f0;
        border-radius: 12px;
        padding: 14px 18px;
        font-size: 0.95rem;
        color: #333344;
        transition: all 0.2s ease;
        width: 100%;
    }

    .form-select:focus {
        outline: none;
        border-color: #ff8fab;
        background-color: white;
        box-shadow: 0 0 0 3px rgba(255, 143, 171, 0.1);
    }

    .form-checkbox {
        width: 20px;
        height: 20px;
        border-radius: 6px;
        border: 2px solid #d8d8e5;
        background: white;
        appearance: none;
        cursor: pointer;
        position: relative;
        transition: all 0.2s ease;
    }

    .form-checkbox:checked {
        background: #ff6b9d;
        border-color: #ff6b9d;
    }

    .form-checkbox:checked:after {
        content: '✓';
        position: absolute;
        color: white;
        font-size: 12px;
        font-weight: bold;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .form-checkbox:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(255, 107, 157, 0.1);
    }

    .form-radio {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 2px solid #d8d8e5;
        background: white;
        appearance: none;
        cursor: pointer;
        position: relative;
        transition: all 0.2s ease;
    }

    .form-radio:checked {
        border-color: #ff6b9d;
    }

    .form-radio:checked:after {
        content: '';
        position: absolute;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #ff6b9d;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .submit-button {
        background: linear-gradient(90deg, #ff6b9d, #ff8fab);
        color: white;
        border: none;
        padding: 16px 36px;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 20px rgba(255, 107, 157, 0.25);
        cursor: pointer;
    }

    .submit-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(255, 107, 157, 0.35);
    }

    .help-tooltip {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: #e8e8f0;
        color: #777788;
        font-size: 0.7rem;
        margin-left: 6px;
        cursor: help;
    }

    .step-indicator {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(90deg, #ff6b9d, #ff8fab);
        color: white;
        font-weight: 600;
        margin-right: 12px;
        flex-shrink: 0;
        font-size: 0.9rem;
    }

    .product-image {
        width: 100%;
        height: 240px;
        object-fit: cover;
        border-radius: 12px;
        transition: transform 0.3s ease;
    }

    .product-card {
        border: 2px solid #e8e8f0;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
        cursor: pointer;
        background: white;
    }

    .product-card:hover {
        border-color: #ff8fab;
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    }

    .product-card.selected {
        border-color: #ff6b9d;
        border-width: 3px;
        box-shadow: 0 0 0 3px rgba(255, 107, 157, 0.1);
    }

    .inspiration-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 12px;
    }

    .inspiration-image {
        width: 100%;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.2s ease;
    }

    .inspiration-image:hover {
        transform: scale(1.03);
        border-color: #ff8fab;
    }

    .inspiration-image.selected {
        border-color: #ff6b9d;
        border-width: 3px;
        box-shadow: 0 4px 12px rgba(255, 107, 157, 0.15);
    }

    .fabrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 12px;
    }

    .fabric-card {
        padding: 12px;
        border: 2px solid #e8e8f0;
        border-radius: 12px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
        background: white;
    }

    .fabric-card:hover {
        border-color: #ff8fab;
        transform: translateY(-2px);
    }

    .fabric-card.selected {
        border-color: #ff6b9d;
        background: rgba(255, 107, 157, 0.05);
        border-width: 3px;
    }

    .fabric-sample {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        margin: 0 auto 8px;
        background: #e8e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #777788;
    }

    .section-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, #e8e8f0, transparent);
        margin: 32px 0;
    }

    /* Common Styles */
    .section-title {
        background: linear-gradient(135deg, #9a6b8c, #d89fc1);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .fade-in {
        animation: fadeIn 1s ease-out;
    }

    .slide-up {
        animation: slideUp 0.8s ease-out 0.2s both;
    }

    .slide-up-delayed {
        animation: slideUp 0.8s ease-out 0.5s both;
    }

    .pulse {
        animation: pulse 2s infinite;
    }

    .badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: linear-gradient(135deg, #f8c8dc, #e6b0d2);
        color: white;
        font-size: 0.7rem;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 20px;
        letter-spacing: 0.5px;
        box-shadow: 0 3px 10px rgba(218, 165, 185, 0.2);
    }

    .design-type {
        display: inline-block;
        background: linear-gradient(135deg, #fff5f9, #fff0f6);
        color: #9a6b8c;
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-top: 10px;
        border: 1px solid rgba(248, 200, 220, 0.5);
    }

    .filter-btn {
        background: white;
        color: #7a4a76;
        border: 1px solid #f0d8e8;
        transition: all 0.3s ease;
        padding: 12px 24px;
        border-radius: 50px;
        font-weight: 500;
        cursor: pointer;
    }

    .filter-btn:hover,
    .filter-btn.active {
        background: linear-gradient(135deg, #f8c8dc 0%, #e6b0d2 100%);
        color: white;
        border-color: transparent;
    }

    .category-tag {
        display: inline-block;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(5px);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.8rem;
        margin-bottom: 10px;
    }

    .quote-icon {
        color: #f8c8dc;
        font-size: 2.5rem;
        opacity: 0.7;
        line-height: 1;
        margin-bottom: -0.5rem;
    }

    .quote-mark {
        font-size: 5rem;
        color: #f8c8dc;
        line-height: 1;
        margin-bottom: -1.5rem;
        opacity: 0.7;
    }

    .testimonial-text {
        position: relative;
        line-height: 1.7;
    }

    .testimonial-text:before {
        content: '"';
        position: absolute;
        top: -10px;
        left: -5px;
        font-size: 4rem;
        color: #f8c8dc;
        opacity: 0.3;
        font-family: Georgia, serif;
        line-height: 1;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }

        100% {
            transform: scale(1);
        }
    }
</style>

<section class="relative min-h-screen flex items-center justify-center px-4 py-16 overflow-hidden">
    <!-- Premium Fashion Background - Modern & Sophisticated -->
    <div class="absolute inset-0 z-0">
        <!-- Clean, modern gradient overlay - from charcoal to slate -->
        <div class="absolute inset-0 bg-gradient-to-br from-neutral-900/85 via-neutral-800/75 to-neutral-900/85 z-10"></div>
        
        <!-- Background Image - High fashion studio aesthetic -->
        <img src="https://images.unsplash.com/photo-1556905055-8f358a7a47b2?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
            alt="Minimalist fashion studio with mannequin and drafting tools"
            class="w-full h-full object-cover opacity-40">
        
        <!-- Subtle geometric pattern - modern & architectural -->
        <div class="absolute inset-0 opacity-10 z-20" 
             style="background-image: linear-gradient(45deg, #fff 1px, transparent 1px), linear-gradient(-45deg, #fff 1px, transparent 1px); 
                    background-size: 30px 30px;">
        </div>
    </div>
    
    <!-- Clean Animated Elements - Minimal & Architectural -->
    <div class="absolute top-20 left-10 md:left-20 z-30 opacity-20">
        <i class="fas fa-minus text-4xl text-white rotate-45 floating"></i>
    </div>
    
    <div class="absolute bottom-32 right-10 md:right-20 z-30 opacity-20">
        <i class="fas fa-plus text-4xl text-white floating-delayed"></i>
    </div>
    
    <div class="absolute top-1/3 left-1/4 z-20 opacity-10 hidden md:block">
        <i class="fas fa-circle text-3xl text-white"></i>
    </div>
    
    <div class="absolute bottom-1/3 right-1/4 z-20 opacity-10 hidden md:block">
        <i class="fas fa-square text-3xl text-white"></i>
    </div>
    
    <!-- Sophisticated gradient orbs - muted tones -->
    <div class="absolute top-0 left-0 w-96 h-96 bg-neutral-600 rounded-full mix-blend-soft-light filter blur-3xl opacity-20 animate-blob z-20"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-stone-700 rounded-full mix-blend-soft-light filter blur-3xl opacity-20 animate-blob animation-delay-2000 z-20"></div>
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gray-600 rounded-full mix-blend-soft-light filter blur-3xl opacity-10 animate-blob animation-delay-4000 z-20"></div>
    
    <!-- Main Content Container -->
    <div class="container mx-auto relative z-40">
        <div class="text-center text-white fade-in max-w-6xl mx-auto">
            
            <!-- Minimal Badge - Clean typography -->
            <div class="mb-6 slide-up">
                <span class="inline-flex items-center gap-3 px-5 py-2.5 bg-white/5 backdrop-blur-md border border-white/10 rounded-full text-xs md:text-sm font-light tracking-[0.2em] uppercase">
                    <span class="w-1.5 h-1.5 bg-white rounded-full"></span>
                    <span>Atelier Exclusive</span>
                    <span class="w-1.5 h-1.5 bg-white rounded-full"></span>
                </span>
            </div>
            
            <!-- Main Heading - Modern typography, reduced gradient -->
            <div class="mb-8 slide-up">
                <h1 class="text-5xl md:text-7xl lg:text-8xl font-light mb-6 tracking-tight leading-[1.1]">
                    <span class="block font-extralight text-white/90">Design Your</span>
                    <span class="font-medium bg-gradient-to-r from-white via-neutral-200 to-white bg-clip-text text-transparent">
                        Dream Outfit
                    </span>
                </h1>
                
                <!-- Minimal Divider -->
                <div class="flex items-center justify-center gap-2 mb-8">
                    <div class="w-8 h-px bg-white/20"></div>
                    <div class="w-1 h-1 bg-white/40 rounded-full"></div>
                    <div class="w-8 h-px bg-white/20"></div>
                </div>
            </div>
            
            <!-- Descriptive Text - Clean, editorial style -->
            <div class="max-w-2xl mx-auto mb-12 slide-up">
                <p class="text-base md:text-lg lg:text-xl font-light leading-relaxed text-white/80">
                    <span class="text-white font-normal">From sketch to silhouette.</span>
                    Work with our master artisans to create a 
                    <span class="italic text-white/90">singular piece</span> 
                    that exists only for you.
                </p>
            </div>
            
            <!-- CTA Buttons - Refined, minimal -->
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4 slide-up-delayed">
                <a href="#design-process" class="group relative inline-flex items-center justify-center gap-3 bg-white text-neutral-900 hover:bg-neutral-100 font-medium py-3.5 px-10 text-sm tracking-wide transition-all duration-300">
                    <span class="relative z-10">Begin Creation</span>
                    <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform relative z-10"></i>
                    <div class="absolute inset-0 bg-white scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300 -z-0"></div>
                </a>
                
                <a href="#design-gallery" class="inline-flex items-center justify-center gap-2 text-white/80 hover:text-white font-light py-3.5 px-10 text-sm tracking-wide border border-white/20 hover:border-white/50 transition-all duration-300">
                    <span>View Archive</span>
                </a>
            </div>
            
            <!-- Design Features - Clean cards, no background blur -->
            <div class="mt-24 grid grid-cols-1 md:grid-cols-3 gap-8 text-left slide-up-delayed">
                <!-- Feature 1: Minimal -->
                <div class="group border-t border-white/10 pt-6 transition-all duration-300">
                    <div class="flex flex-col">
                        <div class="mb-4">
                            <span class="text-4xl font-thin text-white/40 group-hover:text-white/80 transition-colors">01</span>
                        </div>
                        <h3 class="text-lg font-medium mb-3 text-white tracking-wide">Sketch to Sample</h3>
                        <p class="text-white/50 text-sm leading-relaxed font-light">Iterative development from concept to prototype, refined to your specifications</p>
                    </div>
                </div>
                
                <!-- Feature 2: Minimal -->
                <div class="group border-t border-white/10 pt-6 transition-all duration-300">
                    <div class="flex flex-col">
                        <div class="mb-4">
                            <span class="text-4xl font-thin text-white/40 group-hover:text-white/80 transition-colors">02</span>
                        </div>
                        <h3 class="text-lg font-medium mb-3 text-white tracking-wide">Material Curation</h3>
                        <p class="text-white/50 text-sm leading-relaxed font-light">Access to exclusive mills—Italian wools, Japanese cottons, French laces</p>
                    </div>
                </div>
                
                <!-- Feature 3: Minimal -->
                <div class="group border-t border-white/10 pt-6 transition-all duration-300">
                    <div class="flex flex-col">
                        <div class="mb-4">
                            <span class="text-4xl font-thin text-white/40 group-hover:text-white/80 transition-colors">03</span>
                        </div>
                        <h3 class="text-lg font-medium mb-3 text-white tracking-wide">Precision Fit</h3>
                        <p class="text-white/50 text-sm leading-relaxed font-light">Digital measurement + hand-finishing for architectural drape and movement</p>
                    </div>
                </div>
            </div>
            
            <!-- Trust Indicators - Clean stats -->
            <div class="mt-16 flex flex-wrap justify-center items-center gap-8 slide-up-delayed">
                <div class="flex items-center gap-3">
                    <div class="flex -space-x-2">
                        <img class="w-7 h-7 rounded-full border border-white/30" src="https://randomuser.me/api/portraits/women/33.jpg" alt="Designer">
                        <img class="w-7 h-7 rounded-full border border-white/30" src="https://randomuser.me/api/portraits/men/46.jpg" alt="Designer">
                        <img class="w-7 h-7 rounded-full border border-white/30" src="https://randomuser.me/api/portraits/women/55.jpg" alt="Designer">
                    </div>
                    <span class="text-white/60 text-sm"><span class="text-white font-medium">15</span> designers</span>
                </div>
                
                <div class="flex items-center gap-2">
                    <span class="text-white/40 text-xl font-thin">—</span>
                    <span class="text-white/60 text-sm"><span class="text-white font-medium">500+</span> pieces</span>
                </div>
                
                <div class="flex items-center gap-2">
                    <span class="text-white/40 text-xl font-thin">—</span>
                    <span class="text-white/60 text-sm"><span class="text-white font-medium">4.98</span> / 5.0</span>
                </div>
            </div>
            
            <!-- Minimal Scroll Indicator -->
            <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-50">
                <a href="#design-process" class="group flex flex-col items-center gap-2">
                    <span class="text-white/30 text-[10px] uppercase tracking-[0.3em] group-hover:text-white/60 transition-colors">Scroll</span>
                    <div class="w-[1px] h-10 bg-gradient-to-b from-white/30 to-transparent"></div>
                </a>
            </div>
        </div>
    </div>
</section>

<style>
    @keyframes blob {
        0%, 100% { transform: scale(1) translate(0, 0); }
        33% { transform: scale(1.05) translate(20px, -20px); }
        66% { transform: scale(0.95) translate(-20px, 20px); }
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(45deg); }
        50% { transform: translateY(-20px) rotate(45deg); }
    }
    
    @keyframes float-delayed {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-15px) rotate(0deg); }
    }
    
    .animate-blob {
        animation: blob 15s infinite;
    }
    
    .floating {
        animation: float 8s ease-in-out infinite;
    }
    
    .floating-delayed {
        animation: float-delayed 10s ease-in-out infinite;
    }
    
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    
    .animation-delay-4000 {
        animation-delay: 4s;
    }
    
    .fade-in {
        animation: fadeIn 1s ease-out;
    }
    
    .slide-up {
        animation: slideUp 0.8s ease-out;
    }
    
    .slide-up-delayed {
        animation: slideUp 0.8s ease-out 0.2s both;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes slideUp {
        from { 
            opacity: 0; 
            transform: translateY(20px); 
        }
        to { 
            opacity: 1; 
            transform: translateY(0); 
        }
    }
    
    /* Smooth transitions */
    * {
        transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 300ms;
    }
</style>

<!-- How Custom Design Works Section -->
<section class="py-16 md:py-24 px-4 md:px-8">
    <div class="container mx-auto max-w-6xl">
        <!-- Section Header -->
        <div class="text-center mb-16 md:mb-24">
            <h1 class="text-4xl md:text-5xl font-bold mb-6 section-title">How Custom Design Works</h1>
            <p class="text-xl md:text-2xl max-w-3xl mx-auto process-description">
                Our personalized process transforms your vision into a one-of-a-kind creation, crafted exclusively for you.
            </p>
            <div class="flex justify-center mt-8">
                <div class="w-24 h-1 bg-gradient-to-r from-pink-200 to-purple-300 rounded-full"></div>
            </div>
        </div>

        <!-- Process Steps -->
        <div class="relative">
            <!-- Vertical connecting line for desktop -->
            <div class="vertical-line hidden md:block"></div>

            <!-- Step 1: Share Your Idea -->
            <div class="flex flex-col md:flex-row items-center mb-20 md:mb-32">
                <!-- Step Badge (Mobile) -->
                <div class="md:hidden flex step-badge rounded-full mb-8">
                    <span>1</span>
                </div>

                <!-- Image for Step 1 -->
                <div class="w-full md:w-1/2 mb-10 md:mb-0 md:pr-12">
                    <div class="step-card overflow-hidden">
                        <img
                            src="https://images.unsplash.com/photo-1520006403909-838d6b92c22e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                            alt="Woman discussing fashion design with a designer"
                            class="w-full step-image">
                    </div>
                </div>

                <!-- Content for Step 1 -->
                <div class="w-full md:w-1/2 md:pl-12 relative">
                    <!-- Step Badge (Desktop) -->
                    <div class="hidden md:flex step-badge rounded-full absolute -left-10 top-6 z-10">
                        <span>1</span>
                    </div>

                    <div class="md:pl-8">
                        <h2 class="text-3xl md:text-4xl font-bold mb-6 step-title">Share Your Idea</h2>
                        <p class="text-lg md:text-xl mb-6 process-description">
                            Begin by sharing your vision with our design consultants. Whether you have a clear concept or just a feeling, we'll help translate your ideas into a tangible design direction.
                        </p>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-pink-400 mt-1 mr-3"></i>
                                <span class="process-description">One-on-one consultation with our design experts</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-pink-400 mt-1 mr-3"></i>
                                <span class="process-description">Share inspiration images, sketches, or fabric swatches</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-pink-400 mt-1 mr-3"></i>
                                <span class="process-description">Discuss occasion, style preferences, and personal aesthetic</span>
                            </li>
                        </ul>
                        <div class="inline-flex items-center text-pink-500 font-medium">
                            <span>Estimated time: 1-2 weeks</span>
                            <i class="fas fa-arrow-right ml-3"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <div class="divider"></div>

            <!-- Step 2: We Sketch Your Design -->
            <div class="flex flex-col md:flex-row-reverse items-center mb-20 md:mb-32">
                <!-- Step Badge (Mobile) -->
                <div class="md:hidden flex step-badge rounded-full mb-8">
                    <span>2</span>
                </div>

                <!-- Image for Step 2 -->
                <div class="w-full md:w-1/2 mb-10 md:mb-0 md:pl-12">
                    <div class="step-card overflow-hidden">
                        <img
                            src="https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1138&q=80"
                            alt="Fashion designer sketching a dress design"
                            class="w-full step-image">
                    </div>
                </div>

                <!-- Content for Step 2 -->
                <div class="w-full md:w-1/2 md:pr-12 relative">
                    <!-- Step Badge (Desktop) -->
                    <div class="hidden md:flex step-badge rounded-full absolute -right-10 top-6 z-10">
                        <span>2</span>
                    </div>

                    <div class="md:pr-8 text-right">
                        <h2 class="text-3xl md:text-4xl font-bold mb-6 step-title">We Sketch Your Design</h2>
                        <p class="text-lg md:text-xl mb-6 process-description">
                            Our designers create detailed sketches based on your consultation. You'll receive multiple design options to choose from, with revisions until it's perfect.
                        </p>
                        <ul class="space-y-3 mb-8 text-right">
                            <li class="flex items-start justify-end">
                                <span class="process-description">Custom sketches with multiple design variations</span>
                                <i class="fas fa-check-circle text-pink-400 mt-1 ml-3"></i>
                            </li>
                            <li class="flex items-start justify-end">
                                <span class="process-description">Digital renderings to visualize the final look</span>
                                <i class="fas fa-check-circle text-pink-400 mt-1 ml-3"></i>
                            </li>
                            <li class="flex items-start justify-end">
                                <span class="process-description">Collaborative refinement until you're completely satisfied</span>
                                <i class="fas fa-check-circle text-pink-400 mt-1 ml-3"></i>
                            </li>
                        </ul>
                        <div class="inline-flex items-center text-pink-500 font-medium">
                            <i class="fas fa-arrow-left mr-3"></i>
                            <span>Estimated time: 2-3 weeks</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <div class="divider"></div>

            <!-- Step 3: Fabric & Detail Selection -->
            <div class="flex flex-col md:flex-row items-center mb-20 md:mb-32">
                <!-- Step Badge (Mobile) -->
                <div class="md:hidden flex step-badge rounded-full mb-8">
                    <span>3</span>
                </div>

                <!-- Image for Step 3 -->
                <div class="w-full md:w-1/2 mb-10 md:mb-0 md:pr-12">
                    <div class="step-card overflow-hidden">
                        <img
                            src="https://images.unsplash.com/photo-1558769132-cb1f458e43b5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1074&q=80"
                            alt="Assortment of luxury fabrics and materials"
                            class="w-full step-image">
                    </div>
                </div>

                <!-- Content for Step 3 -->
                <div class="w-full md:w-1/2 md:pl-12 relative">
                    <!-- Step Badge (Desktop) -->
                    <div class="hidden md:flex step-badge rounded-full absolute -left-10 top-6 z-10">
                        <span>3</span>
                    </div>

                    <div class="md:pl-8">
                        <h2 class="text-3xl md:text-4xl font-bold mb-6 step-title">Fabric & Detail Selection</h2>
                        <p class="text-lg md:text-xl mb-6 process-description">
                            Choose from our curated collection of premium fabrics, trims, and embellishments. We'll guide you in selecting materials that bring your design to life.
                        </p>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-pink-400 mt-1 mr-3"></i>
                                <span class="process-description">Touch and feel actual fabric samples</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-pink-400 mt-1 mr-3"></i>
                                <span class="process-description">Select buttons, zippers, lace, and other details</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-pink-400 mt-1 mr-3"></i>
                                <span class="process-description">See how different materials drape and move</span>
                            </li>
                        </ul>
                        <div class="inline-flex items-center text-pink-500 font-medium">
                            <span>Estimated time: 1-2 weeks</span>
                            <i class="fas fa-arrow-right ml-3"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <div class="divider"></div>

            <!-- Step 4: Tailoring & Delivery -->
            <div class="flex flex-col md:flex-row-reverse items-center">
                <!-- Step Badge (Mobile) -->
                <div class="md:hidden flex step-badge rounded-full mb-8">
                    <span>4</span>
                </div>

                <!-- Image for Step 4 -->
                <div class="w-full md:w-1/2 mb-10 md:mb-0 md:pl-12">
                    <div class="step-card overflow-hidden">
                        <img
                            src="https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1074&q=80"
                            alt="Finished custom dress on a mannequin"
                            class="w-full step-image">
                    </div>
                </div>

                <!-- Content for Step 4 -->
                <div class="w-full md:w-1/2 md:pr-12 relative">
                    <!-- Step Badge (Desktop) -->
                    <div class="hidden md:flex step-badge rounded-full absolute -right-10 top-6 z-10">
                        <span>4</span>
                    </div>

                    <div class="md:pr-8 text-right">
                        <h2 class="text-3xl md:text-4xl font-bold mb-6 step-title">Tailoring & Delivery</h2>
                        <p class="text-lg md:text-xl mb-6 process-description">
                            Our master tailors bring your design to life with precision craftsmanship. After final fittings and adjustments, your custom creation is delivered to you.
                        </p>
                        <ul class="space-y-3 mb-8 text-right">
                            <li class="flex items-start justify-end">
                                <span class="process-description">Multiple fittings to ensure perfect fit</span>
                                <i class="fas fa-check-circle text-pink-400 mt-1 ml-3"></i>
                            </li>
                            <li class="flex items-start justify-end">
                                <span class="process-description">Hand-finishing and quality inspection</span>
                                <i class="fas fa-check-circle text-pink-400 mt-1 ml-3"></i>
                            </li>
                            <li class="flex items-start justify-end">
                                <span class="process-description">Personalized packaging and delivery</span>
                                <i class="fas fa-check-circle text-pink-400 mt-1 ml-3"></i>
                            </li>
                        </ul>
                        <div class="inline-flex items-center text-pink-500 font-medium">
                            <i class="fas fa-arrow-left mr-3"></i>
                            <span>Estimated time: 4-6 weeks</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="mt-24 text-center">
            <div class="max-w-4xl mx-auto bg-gradient-to-br from-pink-50 to-purple-50 rounded-3xl p-10 md:p-12 shadow-lg">
                <h3 class="text-3xl md:text-4xl font-bold mb-6 text-purple-800">Ready to Begin Your Design Journey?</h3>
                <p class="text-xl mb-10 text-purple-700">
                    Schedule a consultation with our design team to start creating your dream outfit.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-6">
                    <a href="#" class="bg-gradient-to-r from-pink-500 to-purple-500 text-white font-medium py-4 px-10 rounded-full text-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <i class="fas fa-calendar-check mr-3"></i>
                        Book a Consultation
                    </a>
                    <a href="#" class="bg-white text-purple-600 border-2 border-purple-200 font-medium py-4 px-10 rounded-full text-lg shadow-md hover:shadow-lg transition-all duration-300">
                        <i class="fas fa-images mr-3"></i>
                        View Portfolio
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Gallery Section -->
<section id="gallery" class="py-16 md:py-24 px-4 md:px-8 bg-gray-50">
    <div class="container mx-auto max-w-7xl">
        <!-- Section Header -->
        <div class="text-center mb-16 fade-in">
            <h1 class="text-4xl md:text-5xl font-bold mb-6 section-title">Our Custom Creations</h1>
            <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto mb-12">
                Each piece is a unique story, crafted with precision and passion. Explore our gallery of custom-designed outfits created for special moments.
            </p>

            <!-- Filter Buttons -->
            <div class="flex flex-wrap justify-center gap-3 md:gap-4 mb-12">
                <button class="filter-btn py-3 px-6 rounded-full text-sm md:text-base font-medium active" data-filter="all">
                    <i class="fas fa-star mr-2"></i>All Designs
                </button>
                <button class="filter-btn py-3 px-6 rounded-full text-sm md:text-base font-medium" data-filter="wedding">
                    <i class="fas fa-heart mr-2"></i>Wedding
                </button>
                <button class="filter-btn py-3 px-6 rounded-full text-sm md:text-base font-medium" data-filter="evening">
                    <i class="fas fa-moon mr-2"></i>Evening Gowns
                </button>
                <button class="filter-btn py-3 px-6 rounded-full text-sm md:text-base font-medium" data-filter="casual">
                    <i class="fas fa-sun mr-2"></i>Casual Wear
                </button>
                <button class="filter-btn py-3 px-6 rounded-full text-sm md:text-base font-medium" data-filter="accessories">
                    <i class="fas fa-gem mr-2"></i>Accessories
                </button>
            </div>
        </div>

        <!-- Gallery Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8">
            <!-- Item 1 -->
            <div class="gallery-card fade-in" data-category="wedding">
                <div class="relative overflow-hidden">
                    <img
                        src="https://images.unsplash.com/photo-1596461404969-9ae70f2830c1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                        alt="Elegant wedding gown with lace details"
                        class="gallery-image">
                    <div class="custom-label">CUSTOM MADE</div>
                    <div class="overlay-content">
                        <span class="category-tag">Wedding Gown</span>
                        <h3 class="text-xl font-bold mb-2">Ivory Lace Illusion</h3>
                        <p class="text-sm opacity-90">Hand-beaded lace with silk underlay</p>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="text-lg font-bold text-gray-800">Ivory Lace Illusion</h3>
                        <span class="text-pink-600 font-bold">$$$</span>
                    </div>
                    <p class="text-gray-600 text-sm mb-4">Custom designed for Sarah's vineyard wedding with French lace and silk details.</p>
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>Completed: June 2023</span>
                    </div>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="gallery-card fade-in" data-category="evening">
                <div class="relative overflow-hidden">
                    <img
                        src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1136&q=80"
                        alt="Red evening gown with dramatic silhouette"
                        class="gallery-image">
                    <div class="custom-label">CUSTOM MADE</div>
                    <div class="overlay-content">
                        <span class="category-tag">Evening Gown</span>
                        <h3 class="text-xl font-bold mb-2">Scarlet Mermaid</h3>
                        <p class="text-sm opacity-90">Silk satin with draped neckline</p>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="text-lg font-bold text-gray-800">Scarlet Mermaid</h3>
                        <span class="text-pink-600 font-bold">$$</span>
                    </div>
                    <p class="text-gray-600 text-sm mb-4">Designed for a gala event with custom draping and silk satin fabric.</p>
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>Completed: March 2023</span>
                    </div>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="gallery-card fade-in" data-category="casual">
                <div class="relative overflow-hidden">
                    <img
                        src="https://images.unsplash.com/photo-1564584217132-2271feaeb3c5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                        alt="Floral print dress with flutter sleeves"
                        class="gallery-image">
                    <div class="custom-label">CUSTOM MADE</div>
                    <div class="overlay-content">
                        <span class="category-tag">Day Dress</span>
                        <h3 class="text-xl font-bold mb-2">Garden Party Flutter</h3>
                        <p class="text-sm opacity-90">Floral chiffon with flutter sleeves</p>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="text-lg font-bold text-gray-800">Garden Party Flutter</h3>
                        <span class="text-pink-600 font-bold">$</span>
                    </div>
                    <p class="text-gray-600 text-sm mb-4">Lightweight chiffon dress for spring garden parties with custom floral print.</p>
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>Completed: May 2023</span>
                    </div>
                </div>
            </div>

            <!-- Item 4 -->
            <div class="gallery-card fade-in" data-category="wedding">
                <div class="relative overflow-hidden">
                    <img
                        src="https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1138&q=80"
                        alt="Bohemian wedding dress with floral embroidery"
                        class="gallery-image">
                    <div class="custom-label">CUSTOM MADE</div>
                    <div class="overlay-content">
                        <span class="category-tag">Wedding Gown</span>
                        <h3 class="text-xl font-bold mb-2">Bohemian Dream</h3>
                        <p class="text-sm opacity-90">Hand-embroidered with silk flowers</p>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="text-lg font-bold text-gray-800">Bohemian Dream</h3>
                        <span class="text-pink-600 font-bold">$$$</span>
                    </div>
                    <p class="text-gray-600 text-sm mb-4">Beach wedding gown with hand-embroidered floral details and flowing silhouette.</p>
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>Completed: August 2023</span>
                    </div>
                </div>
            </div>

            <!-- Item 5 -->
            <div class="gallery-card fade-in" data-category="evening">
                <div class="relative overflow-hidden">
                    <img
                        src="https://images.unsplash.com/photo-1539008835657-9e8e9680c956?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1134&q=80"
                        alt="Black velvet evening gown"
                        class="gallery-image">
                    <div class="custom-label">CUSTOM MADE</div>
                    <div class="overlay-content">
                        <span class="category-tag">Evening Gown</span>
                        <h3 class="text-xl font-bold mb-2">Midnight Velvet</h3>
                        <p class="text-sm opacity-90">Italian velvet with pearl beading</p>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="text-lg font-bold text-gray-800">Midnight Velvet</h3>
                        <span class="text-pink-600 font-bold">$$$</span>
                    </div>
                    <p class="text-gray-600 text-sm mb-4">Dramatic velvet gown with hand-sewn pearl beading for winter galas.</p>
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>Completed: December 2022</span>
                    </div>
                </div>
            </div>

            <!-- Item 6 -->
            <div class="gallery-card fade-in" data-category="casual">
                <div class="relative overflow-hidden">
                    <img
                        src="https://images.unsplash.com/photo-1595777457583-95e059d581b8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                        alt="Tailored linen suit for women"
                        class="gallery-image">
                    <div class="custom-label">CUSTOM MADE</div>
                    <div class="overlay-content">
                        <span class="category-tag">Tailored Suit</span>
                        <h3 class="text-xl font-bold mb-2">Executive Linen</h3>
                        <p class="text-sm opacity-90">Italian linen with silk lining</p>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="text-lg font-bold text-gray-800">Executive Linen</h3>
                        <span class="text-pink-600 font-bold">$$</span>
                    </div>
                    <p class="text-gray-600 text-sm mb-4">Tailored linen suit for professional settings with custom-fit trousers.</p>
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>Completed: April 2023</span>
                    </div>
                </div>
            </div>

            <!-- Item 7 -->
            <div class="gallery-card fade-in" data-category="accessories">
                <div class="relative overflow-hidden">
                    <img
                        src="https://images.unsplash.com/photo-1590649887896-6c8e6668407f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1130&q=80"
                        alt="Hand-beaded clutch purse"
                        class="gallery-image">
                    <div class="custom-label">CUSTOM MADE</div>
                    <div class="overlay-content">
                        <span class="category-tag">Accessory</span>
                        <h3 class="text-xl font-bold mb-2">Crystal Clutch</h3>
                        <p class="text-sm opacity-90">Hand-beaded with Swarovski crystals</p>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="text-lg font-bold text-gray-800">Crystal Clutch</h3>
                        <span class="text-pink-600 font-bold">$</span>
                    </div>
                    <p class="text-gray-600 text-sm mb-4">Evening clutch with hand-sewn crystals to match a custom gown.</p>
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>Completed: February 2023</span>
                    </div>
                </div>
            </div>

            <!-- Item 8 -->
            <div class="gallery-card fade-in" data-category="wedding">
                <div class="relative overflow-hidden">
                    <img
                        src="https://images.unsplash.com/photo-1539635278303-d4002c07eae3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                        alt="Modern minimalist wedding dress"
                        class="gallery-image">
                    <div class="custom-label">CUSTOM MADE</div>
                    <div class="overlay-content">
                        <span class="category-tag">Wedding Gown</span>
                        <h3 class="text-xl font-bold mb-2">Modern Minimalist</h3>
                        <p class="text-sm opacity-90">Crepe fabric with architectural lines</p>
                    </div>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="text-lg font-bold text-gray-800">Modern Minimalist</h3>
                        <span class="text-pink-600 font-bold">$$</span>
                    </div>
                    <p class="text-gray-600 text-sm mb-4">Architectural wedding gown with clean lines and minimalist aesthetic.</p>
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        <span>Completed: July 2023</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="text-center mt-16 fade-in">
            <p class="text-lg md:text-xl text-gray-600 mb-10">
                See something you love? Each design can be adapted to your personal style and measurements.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-6">
                <a href="#custom-form" class="bg-gradient-to-r from-pink-500 to-purple-500 text-white font-medium py-4 px-10 rounded-full text-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <i class="fas fa-pen-fancy mr-3"></i>
                    Start Your Custom Design
                </a>
                <a href="#" class="bg-white text-purple-600 border-2 border-purple-200 font-medium py-4 px-10 rounded-full text-lg shadow-md hover:shadow-lg transition-all duration-300">
                    <i class="fas fa-images mr-3"></i>
                    View Full Portfolio
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Our Custom Design Section -->
<section class="py-16 md:py-24 px-4 md:px-8" style="background: linear-gradient(135deg, #fff5f9 0%, #fff0f6 100%);">
    <div class="container mx-auto max-w-7xl">
        <!-- Section Header -->
        <div class="text-center mb-16 fade-in">
            <h1 class="text-4xl md:text-5xl font-bold mb-6 section-title">Why Choose Our Custom Design</h1>
            <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto mb-10">
                Experience the difference of truly personalized fashion. Every piece is created with exceptional care, quality, and attention to your unique style.
            </p>
            <div class="flex justify-center mt-8">
                <div class="w-24 h-1 bg-gradient-to-r from-pink-200 to-purple-300 rounded-full"></div>
            </div>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10">
            <!-- Feature 1: Perfect Fit Guarantee -->
            <div class="feature-card fade-in">
                <div class="p-8 text-center">
                    <div class="icon-circle mb-8">
                        <i class="fas fa-ruler-combined feature-icon"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Perfect Fit Guarantee</h3>
                    <p class="text-gray-600 mb-6">
                        Every garment is tailored to your exact measurements, ensuring a flawless fit that complements your unique body shape.
                    </p>
                    <div class="inline-flex items-center text-pink-600 font-medium text-sm">
                        <span>Included with every design</span>
                        <i class="fas fa-check-circle ml-2"></i>
                    </div>
                </div>
                <div class="badge">Guaranteed</div>
            </div>

            <!-- Feature 2: Premium Fabrics -->
            <div class="feature-card fade-in">
                <div class="p-8 text-center">
                    <div class="icon-circle mb-8">
                        <i class="fas fa-spool feature-icon"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Premium Fabrics</h3>
                    <p class="text-gray-600 mb-6">
                        Select from our curated collection of luxurious fabrics including silks, fine wools, organic cottons, and imported lace.
                    </p>
                    <div class="inline-flex items-center text-pink-600 font-medium text-sm">
                        <span>200+ fabric options</span>
                        <i class="fas fa-arrow-right ml-2"></i>
                    </div>
                </div>
                <div class="badge">Luxury</div>
            </div>

            <!-- Feature 3: Handmade Detailing -->
            <div class="feature-card fade-in">
                <div class="p-8 text-center">
                    <div class="icon-circle mb-8">
                        <i class="fas fa-hand-sparkles feature-icon"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Handmade Detailing</h3>
                    <p class="text-gray-600 mb-6">
                        Each piece features exquisite hand-finishing, from delicate embroidery to carefully placed beading and custom buttons.
                    </p>
                    <div class="inline-flex items-center text-pink-600 font-medium text-sm">
                        <span>Artisan craftsmanship</span>
                        <i class="fas fa-gem ml-2"></i>
                    </div>
                </div>
                <div class="badge">Artisanal</div>
            </div>

            <!-- Feature 4: Personal Designer Support -->
            <div class="feature-card fade-in">
                <div class="p-8 text-center">
                    <div class="icon-circle mb-8">
                        <i class="fas fa-user-cog feature-icon"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Personal Designer Support</h3>
                    <p class="text-gray-600 mb-6">
                        Work one-on-one with an experienced designer who guides you through every step, from concept to final fitting.
                    </p>
                    <div class="inline-flex items-center text-pink-600 font-medium text-sm">
                        <span>Dedicated expert</span>
                        <i class="fas fa-star ml-2"></i>
                    </div>
                </div>
                <div class="badge">Exclusive</div>
            </div>

            <!-- Feature 5: Custom Measurements -->
            <div class="feature-card fade-in">
                <div class="p-8 text-center">
                    <div class="icon-circle mb-8">
                        <i class="fas fa-vest feature-icon"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Custom Measurements</h3>
                    <p class="text-gray-600 mb-6">
                        Our detailed measurement process captures 20+ points for precision tailoring that standard sizes can't achieve.
                    </p>
                    <div class="inline-flex items-center text-pink-600 font-medium text-sm">
                        <span>20+ measurement points</span>
                        <i class="fas fa-ruler ml-2"></i>
                    </div>
                </div>
                <div class="badge">Precision</div>
            </div>

            <!-- Feature 6: Worldwide Shipping -->
            <div class="feature-card fade-in">
                <div class="p-8 text-center">
                    <div class="icon-circle mb-8">
                        <i class="fas fa-globe-americas feature-icon"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Worldwide Shipping</h3>
                    <p class="text-gray-600 mb-6">
                        We deliver your custom creations anywhere in the world with premium packaging and careful handling.
                    </p>
                    <div class="inline-flex items-center text-pink-600 font-medium text-sm">
                        <span>100+ countries served</span>
                        <i class="fas fa-shipping-fast ml-2"></i>
                    </div>
                </div>
                <div class="badge">Global</div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="mt-20 grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
            <div class="text-center fade-in">
                <div class="text-4xl md:text-5xl font-bold text-gray-800 mb-2" id="stat1">0</div>
                <div class="text-gray-600 font-medium">Custom Designs</div>
                <div class="text-xs text-gray-500 mt-1">Created with love</div>
            </div>

            <div class="text-center fade-in">
                <div class="text-4xl md:text-5xl font-bold text-gray-800 mb-2" id="stat2">0</div>
                <div class="text-gray-600 font-medium">Happy Clients</div>
                <div class="text-xs text-gray-500 mt-1">Across the globe</div>
            </div>

            <div class="text-center fade-in">
                <div class="text-4xl md:text-5xl font-bold text-gray-800 mb-2" id="stat3">0</div>
                <div class="text-gray-600 font-medium">Fabric Options</div>
                <div class="text-xs text-gray-500 mt-1">Luxury materials</div>
            </div>

            <div class="text-center fade-in">
                <div class="text-4xl md:text-5xl font-bold text-gray-800 mb-2" id="stat4">0</div>
                <div class="text-gray-600 font-medium">Countries Served</div>
                <div class="text-xs text-gray-500 mt-1">Worldwide delivery</div>
            </div>
        </div>

        <!-- Testimonial -->
        <div class="mt-20 max-w-3xl mx-auto fade-in">
            <div class="bg-white rounded-2xl p-8 md:p-10 shadow-lg border border-pink-100">
                <div class="flex items-center mb-6">
                    <div class="w-16 h-16 rounded-full overflow-hidden mr-6 border-4 border-pink-100">
                        <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=987&q=80" alt="Sarah Johnson" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h4 class="text-xl font-bold text-gray-800">Sarah Johnson</h4>
                        <p class="text-gray-600">Bride & Custom Gown Client</p>
                    </div>
                    <div class="ml-auto text-amber-400">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                <p class="text-gray-700 text-lg italic">
                    "Working with Boutique Couture was a dream. My custom wedding gown fit perfectly without a single alteration. The attention to detail and personal designer support made me feel like a true collaborator in creating my dream dress. The quality is unmatched!"
                </p>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="text-center mt-16 fade-in">
            <div class="max-w-4xl mx-auto bg-gradient-to-br from-white to-pink-50 rounded-3xl p-10 md:p-12 shadow-lg border border-pink-200 pulse">
                <h3 class="text-3xl md:text-4xl font-bold mb-6 text-gray-800">Ready to Experience Custom Design?</h3>
                <p class="text-xl mb-10 text-gray-600">
                    Begin your journey to a perfectly fitted, one-of-a-kind creation made just for you.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-6">
                    <a href="#custom-form" class="bg-gradient-to-r from-pink-500 to-purple-500 text-white font-medium py-4 px-10 rounded-full text-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <i class="fas fa-calendar-check mr-3"></i>
                        Book a Consultation
                    </a>
                    <a href="#contact" class="bg-white text-purple-600 border-2 border-purple-200 font-medium py-4 px-10 rounded-full text-lg shadow-md hover:shadow-lg transition-all duration-300">
                        <i class="fas fa-phone-alt mr-3"></i>
                        Contact Our Designers
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Crafted With Passion Section -->
<section class="py-16 md:py-24 px-4 md:px-8">
    <div class="container mx-auto max-w-7xl">
        <!-- Split Layout -->
        <div class="flex flex-col lg:flex-row gap-12 lg:gap-16 items-center">
            <!-- Left Side: Image -->
            <div class="w-full lg:w-1/2 fade-in">
                <div class="image-container">
                    <img
                        src="https://images.unsplash.com/photo-1595777457583-95e059d581b8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                        alt="Fashion designer working on a dress in her studio"
                        class="w-full h-auto">
                    <div class="image-overlay">
                        <h4 class="text-xl font-bold mb-2">Master Craftswoman at Work</h4>
                        <p class="text-sm opacity-90">Designer Elena carefully hand-finishes a custom gown</p>
                    </div>
                </div>

                <!-- Image Caption -->
                <div class="flex items-center justify-center mt-8">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full overflow-hidden border-4 border-pink-100 mr-4">
                            <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1061&q=80" alt="Designer" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h5 class="font-bold text-gray-800">Elena Martinez</h5>
                            <p class="text-sm text-gray-600">Lead Designer & Founder</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Content -->
            <div class="w-full lg:w-1/2 fade-in">
                <div class="content-card relative">
                    <!-- Content -->
                    <div class="mb-10">
                        <div class="quote-mark">"</div>
                        <h2 class="text-4xl md:text-5xl font-bold mb-8 section-title">Crafted With Passion</h2>
                    </div>

                    <p class="text-lg md:text-xl text-gray-700 mb-10 leading-relaxed">
                        Every stitch tells a story in our atelier. We believe that true luxury lies in the details—the careful hand-stitching, the precise draping, the thoughtful selection of materials that transform your vision into a wearable work of art.
                    </p>

                    <p class="text-gray-600 mb-12 leading-relaxed">
                        Our designs are born from a collaboration between your imagination and our expertise. From the initial sketch to the final fitting, we pour our passion into creating garments that don't just fit your body, but also reflect your personality and style. Each piece is a testament to the timeless art of couture craftsmanship.
                    </p>

                    <!-- Craftsmanship Highlights -->
                    <div class="mb-12">
                        <h4 class="text-2xl font-bold text-gray-800 mb-8">Our Craftsmanship Principles</h4>

                        <div class="craftsmanship-item">
                            <div class="item-icon">
                                <i class="fas fa-hand-holding-heart"></i>
                            </div>
                            <div>
                                <h5 class="text-xl font-bold text-gray-800 mb-2">Intentional Design</h5>
                                <p class="text-gray-600">Every element is thoughtfully considered, from silhouette to stitch type, to ensure harmony and purpose in the final creation.</p>
                            </div>
                        </div>

                        <div class="craftsmanship-item">
                            <div class="item-icon">
                                <i class="fas fa-award"></i>
                            </div>
                            <div>
                                <h5 class="text-xl font-bold text-gray-800 mb-2">Exceptional Quality</h5>
                                <p class="text-gray-600">We source only the finest materials and employ traditional techniques that stand the test of time and wear.</p>
                            </div>
                        </div>

                        <div class="craftsmanship-item">
                            <div class="item-icon">
                                <i class="fas fa-user-edit"></i>
                            </div>
                            <div>
                                <h5 class="text-xl font-bold text-gray-800 mb-2">Personal Connection</h5>
                                <p class="text-gray-600">Your journey with us is collaborative and personal, ensuring the final piece is a true reflection of you.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Signature -->
                    <div class="flex items-center justify-between pt-8 border-t border-pink-100">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">A message from our founder</p>
                            <p class="font-bold text-gray-800">"We don't just make clothes, we create heirlooms."</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-gray-800">Elena Martinez</p>
                            <p class="text-sm text-gray-600">Founder & Creative Director</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom CTA -->
        <div class="mt-20 text-center fade-in">
            <div class="max-w-4xl mx-auto bg-gradient-to-br from-white to-pink-50 rounded-3xl p-10 md:p-12 shadow-lg border border-pink-200">
                <h3 class="text-3xl md:text-4xl font-bold mb-6 text-gray-800">Experience True Craftsmanship</h3>
                <p class="text-xl mb-10 text-gray-600">
                    Begin your journey to a one-of-a-kind creation made with passion and precision.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-6">
                    <a href="#custom-form" class="bg-gradient-to-r from-pink-500 to-purple-500 text-white font-medium py-4 px-10 rounded-full text-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <i class="fas fa-pen-fancy mr-3"></i>
                        Start Your Design
                    </a>
                    <a href="#" class="bg-white text-purple-600 border-2 border-purple-200 font-medium py-4 px-10 rounded-full text-lg shadow-md hover:shadow-lg transition-all duration-300">
                        <i class="fas fa-video mr-3"></i>
                        Virtual Studio Tour
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-16 md:py-24 px-4 md:px-8 bg-gray-50">
    <div class="container mx-auto max-w-7xl">
        <!-- Section Header -->
        <div class="text-center mb-16 fade-in">
            <h1 class="text-4xl md:text-5xl font-bold mb-6 section-title">Client Stories</h1>
            <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto mb-10">
                Hear from our clients about their experience creating custom outfits that tell their unique stories.
            </p>
            <div class="flex justify-center mt-8">
                <div class="w-24 h-1 bg-gradient-to-r from-pink-200 to-purple-300 rounded-full"></div>
            </div>
        </div>

        <!-- Testimonials Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-10">
            <!-- Testimonial 1 -->
            <div class="testimonial-card fade-in">
                <div class="p-8 text-center">
                    <!-- Customer Photo -->
                    <div class="customer-photo mb-8">
                        <img
                            src="https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=987&q=80"
                            alt="Sarah Johnson">
                    </div>

                    <!-- Stars Rating -->
                    <div class="stars mb-6">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>

                    <!-- Testimonial Text -->
                    <div class="testimonial-text mb-8">
                        <p class="text-gray-700 italic">
                            "My custom wedding gown was beyond anything I could have imagined. The attention to detail and personal care made me feel so special. It fit perfectly without a single alteration needed!"
                        </p>
                    </div>

                    <!-- Customer Info -->
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Sarah Johnson</h3>
                        <p class="text-gray-600 mb-3">Bride & Custom Gown Client</p>
                        <div class="design-type">Wedding Gown</div>
                    </div>
                </div>
            </div>

            <!-- Testimonial 2 -->
            <div class="testimonial-card fade-in">
                <div class="p-8 text-center">
                    <!-- Customer Photo -->
                    <div class="customer-photo mb-8">
                        <img
                            src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                            alt="Maya Rodriguez">
                    </div>

                    <!-- Stars Rating -->
                    <div class="stars mb-6">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>

                    <!-- Testimonial Text -->
                    <div class="testimonial-text mb-8">
                        <p class="text-gray-700 italic">
                            "As a CEO, I needed a power suit that was both professional and feminine. The team created a custom suit that fits my body perfectly and makes me feel confident in every meeting."
                        </p>
                    </div>

                    <!-- Customer Info -->
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Maya Rodriguez</h3>
                        <p class="text-gray-600 mb-3">CEO & Business Client</p>
                        <div class="design-type">Executive Suit</div>
                    </div>
                </div>
            </div>

            <!-- Testimonial 3 -->
            <div class="testimonial-card fade-in">
                <div class="p-8 text-center">
                    <!-- Customer Photo -->
                    <div class="customer-photo mb-8">
                        <img
                            src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=988&q=80"
                            alt="Chloe Bennett">
                    </div>

                    <!-- Stars Rating -->
                    <div class="stars mb-6">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>

                    <!-- Testimonial Text -->
                    <div class="testimonial-text mb-8">
                        <p class="text-gray-700 italic">
                            "I've never found clothes that fit my petite frame properly until I discovered custom design. My entire wardrobe is now tailored to me, and I feel amazing in every piece."
                        </p>
                    </div>

                    <!-- Customer Info -->
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Chloe Bennett</h3>
                        <p class="text-gray-600 mb-3">Fashion Blogger</p>
                        <div class="design-type">Capsule Wardrobe</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Testimonial -->
        <div class="mt-12 fade-in">
            <div class="testimonial-card">
                <div class="p-10">
                    <div class="flex flex-col md:flex-row items-center">
                        <!-- Customer Photo -->
                        <div class="flex-shrink-0 mb-6 md:mb-0 md:mr-8">
                            <div class="customer-photo">
                                <img
                                    src="https://images.unsplash.com/photo-1488426862026-3ee34a7d66df?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=987&q=80"
                                    alt="Isabella Chen">
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="flex-grow text-center md:text-left">
                            <div class="stars mb-4">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>

                            <div class="testimonial-text mb-6">
                                <p class="text-gray-700 italic text-lg">
                                    "After having my second child, none of my old clothes fit right. The custom design process helped me create a wardrobe that celebrates my new body. The personal designer was so understanding and created pieces that make me feel beautiful again."
                                </p>
                            </div>

                            <div>
                                <h3 class="text-xl font-bold text-gray-800 mb-1">Isabella Chen</h3>
                                <p class="text-gray-600">Mother & Returning Client</p>
                                <div class="design-type mt-3">Postpartum Wardrobe</div>
                            </div>
                        </div>

                        <!-- Quote Icon -->
                        <div class="flex-shrink-0 mt-6 md:mt-0 md:ml-8">
                            <div class="quote-icon">
                                <i class="fas fa-quote-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="mt-20 grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8">
            <div class="text-center fade-in">
                <div class="text-4xl md:text-5xl font-bold text-gray-800 mb-2" id="testimonial-stat1">98%</div>
                <div class="text-gray-600 font-medium">Client Satisfaction</div>
                <div class="text-xs text-gray-500 mt-1">Based on post-design surveys</div>
            </div>

            <div class="text-center fade-in">
                <div class="text-4xl md:text-5xl font-bold text-gray-800 mb-2" id="testimonial-stat2">1500+</div>
                <div class="text-gray-600 font-medium">Custom Designs</div>
                <div class="text-xs text-gray-500 mt-1">Created with passion</div>
            </div>

            <div class="text-center fade-in">
                <div class="text-4xl md:text-5xl font-bold text-gray-800 mb-2" id="testimonial-stat3">72%</div>
                <div class="text-gray-600 font-medium">Return Clients</div>
                <div class="text-xs text-gray-500 mt-1">Come back for more designs</div>
            </div>

            <div class="text-center fade-in">
                <div class="text-4xl md:text-5xl font-bold text-gray-800 mb-2" id="testimonial-stat4">4.9</div>
                <div class="text-gray-600 font-medium">Average Rating</div>
                <div class="text-xs text-gray-500 mt-1">Out of 5 stars</div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="text-center mt-16 fade-in">
            <div class="max-w-4xl mx-auto bg-gradient-to-br from-white to-pink-50 rounded-3xl p-10 md:p-12 shadow-lg border border-pink-200">
                <h3 class="text-3xl md:text-4xl font-bold mb-6 text-gray-800">Ready for Your Custom Experience?</h3>
                <p class="text-xl mb-10 text-gray-600">
                    Join our community of satisfied clients and create a piece that's uniquely yours.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-6">
                    <a href="#custom-form" class="bg-gradient-to-r from-pink-500 to-purple-500 text-white font-medium py-4 px-10 rounded-full text-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <i class="fas fa-pen-fancy mr-3"></i>
                        Start Your Design Journey
                    </a>
                    <a href="#" class="bg-white text-purple-600 border-2 border-purple-200 font-medium py-4 px-10 rounded-full text-lg shadow-md hover:shadow-lg transition-all duration-300">
                        <i class="fas fa-comments mr-3"></i>
                        Read More Stories
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Custom Design Form Section -->
<section id="custom-form" class="form-section py-16 px-4 md:px-8">
    <div class="container mx-auto ">
        <!-- Header with Image -->
        <div class="flex flex-col lg:flex-row items-center gap-10 mb-12">
            <div class="lg:w-2/5">
                <div class="overflow-hidden rounded-2xl shadow-xl">
                    <img
                        src="https://images.unsplash.com/photo-1595777457583-95e059d581b8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                        alt="Custom Design Process"
                        class="w-full h-64 md:h-80 object-cover">
                </div>
            </div>
            <div class="lg:w-3/5 text-center lg:text-left">
                <h1 class="text-3xl md:text-4xl font-bold mb-4 form-title">Custom Design Request</h1>
                <p class="text-lg text-gray-600 mb-6">
                    Share your vision and measurements for a perfectly tailored creation. Our designers will bring your dream outfit to life.
                </p>
                <div class="flex flex-wrap gap-4 justify-center lg:justify-start">
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full bg-pink-500 mr-2"></div>
                        <span class="text-sm font-medium">Perfect Fit Guaranteed</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full bg-pink-500 mr-2"></div>
                        <span class="text-sm font-medium">Premium Materials</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full bg-pink-500 mr-2"></div>
                        <span class="text-sm font-medium">Expert Craftsmanship</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Form Container -->
        <div class="form-container p-6 md:p-10">
            <form id="design-form" class="space-y-12">
                <!-- Step 1: Design Inspiration -->
                <div class="space-y-8">
                    <div class="flex items-center">
                        <div class="step-indicator">1</div>
                        <h2 class="text-2xl font-bold text-gray-800">Design Inspiration</h2>
                    </div>

                    <div>
                        <label class="form-label mb-4">
                            Select a Design Category
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <!-- Product Cards -->
                            <div class="product-card" data-category="dress">
                                <img
                                    src="https://images.unsplash.com/photo-1596461404969-9ae70f2830c1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                                    alt="Evening Dress"
                                    class="product-image">
                                <div class="p-4">
                                    <h4 class="font-semibold text-gray-800">Evening Dress</h4>
                                    <p class="text-xs text-gray-500 mt-1">Elegant & Formal</p>
                                </div>
                            </div>

                            <div class="product-card" data-category="suit">
                                <img
                                    src="https://images.unsplash.com/photo-1595777457583-95e059d581b8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                                    alt="Tailored Suit"
                                    class="product-image">
                                <div class="p-4">
                                    <h4 class="font-semibold text-gray-800">Tailored Suit</h4>
                                    <p class="text-xs text-gray-500 mt-1">Professional & Modern</p>
                                </div>
                            </div>

                            <div class="product-card" data-category="casual">
                                <img
                                    src="https://images.unsplash.com/photo-1564584217132-2271feaeb3c5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                                    alt="Casual Wear"
                                    class="product-image">
                                <div class="p-4">
                                    <h4 class="font-semibold text-gray-800">Casual Wear</h4>
                                    <p class="text-xs text-gray-500 mt-1">Everyday Comfort</p>
                                </div>
                            </div>

                            <div class="product-card" data-category="gown">
                                <img
                                    src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1136&q=80"
                                    alt="Wedding Gown"
                                    class="product-image">
                                <div class="p-4">
                                    <h4 class="font-semibold text-gray-800">Wedding Gown</h4>
                                    <p class="text-xs text-gray-500 mt-1">Special Occasion</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="form-label mb-4">
                            Upload Inspiration Images <span class="text-sm font-normal text-gray-500">(Optional)</span>
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-2xl p-8 text-center">
                            <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-cloud-upload-alt text-2xl text-gray-400"></i>
                            </div>
                            <p class="text-gray-600 mb-2">Drag & drop images here or click to browse</p>
                            <p class="text-sm text-gray-500 mb-4">JPEG, PNG up to 5MB each</p>
                            <button type="button" class="px-6 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-gray-700 font-medium transition-colors">
                                Browse Files
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="form-label mb-4">
                            Design Description <span class="required-star">*</span>
                        </label>
                        <textarea class="form-input min-h-[120px]" placeholder="Describe your vision, style preferences, and any specific details..." required></textarea>
                    </div>
                </div>

                <div class="section-divider"></div>

                <!-- Step 2: Measurements -->
                <div class="space-y-8">
                    <div class="flex items-center">
                        <div class="step-indicator">2</div>
                        <h2 class="text-2xl font-bold text-gray-800">Your Measurements</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="measurement-card">
                            <div class="flex items-center justify-between mb-3">
                                <label class="form-label mb-0">Bust</label>
                                <span class="text-xs text-gray-500">Required</span>
                            </div>
                            <div class="flex items-center">
                                <input type="number" step="0.5" class="form-input" placeholder="36.5" required>
                                <span class="measurement-unit">inches</span>
                            </div>
                        </div>

                        <div class="measurement-card">
                            <div class="flex items-center justify-between mb-3">
                                <label class="form-label mb-0">Waist</label>
                                <span class="text-xs text-gray-500">Required</span>
                            </div>
                            <div class="flex items-center">
                                <input type="number" step="0.5" class="form-input" placeholder="28.0" required>
                                <span class="measurement-unit">inches</span>
                            </div>
                        </div>

                        <div class="measurement-card">
                            <div class="flex items-center justify-between mb-3">
                                <label class="form-label mb-0">Hips</label>
                                <span class="text-xs text-gray-500">Required</span>
                            </div>
                            <div class="flex items-center">
                                <input type="number" step="0.5" class="form-input" placeholder="38.5" required>
                                <span class="measurement-unit">inches</span>
                            </div>
                        </div>

                        <div class="measurement-card">
                            <div class="flex items-center justify-between mb-3">
                                <label class="form-label mb-0">Shoulder Width</label>
                                <span class="text-xs text-gray-500">Optional</span>
                            </div>
                            <div class="flex items-center">
                                <input type="number" step="0.5" class="form-input" placeholder="15.0">
                                <span class="measurement-unit">inches</span>
                            </div>
                        </div>

                        <div class="measurement-card">
                            <div class="flex items-center justify-between mb-3">
                                <label class="form-label mb-0">Arm Length</label>
                                <span class="text-xs text-gray-500">Optional</span>
                            </div>
                            <div class="flex items-center">
                                <input type="number" step="0.5" class="form-input" placeholder="23.5">
                                <span class="measurement-unit">inches</span>
                            </div>
                        </div>

                        <div class="measurement-card">
                            <div class="flex items-center justify-between mb-3">
                                <label class="form-label mb-0">Height</label>
                                <span class="text-xs text-gray-500">Optional</span>
                            </div>
                            <div class="flex items-center">
                                <input type="number" step="0.5" class="form-input" placeholder="65.0">
                                <span class="measurement-unit">inches</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-blue-50 rounded-2xl p-6 border border-blue-100">
                        <div class="flex items-start">
                            <div class="mr-4 text-blue-500">
                                <i class="fas fa-ruler-combined text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 mb-2">Measurement Tips</h4>
                                <p class="text-gray-600 text-sm">For best results, wear fitted clothing and have someone help you measure. Don't worry about perfection—we'll verify all measurements during your consultation.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-divider"></div>

                <!-- Step 3: Fabric & Details -->
                <div class="space-y-8">
                    <div class="flex items-center">
                        <div class="step-indicator">3</div>
                        <h2 class="text-2xl font-bold text-gray-800">Fabric & Details</h2>
                    </div>

                    <div>
                        <label class="form-label mb-4">Select Preferred Fabrics</label>
                        <div class="fabrics-grid">
                            <div class="fabric-card" data-fabric="silk">
                                <div class="fabric-sample" style="background: linear-gradient(45deg, #fff0f6, #ffd6e7)">
                                    <i class="fas fa-feather-alt"></i>
                                </div>
                                <span class="text-sm font-medium">Silk</span>
                            </div>

                            <div class="fabric-card" data-fabric="linen">
                                <div class="fabric-sample" style="background: linear-gradient(45deg, #f5f5f0, #e8e8d8)">
                                    <i class="fas fa-leaf"></i>
                                </div>
                                <span class="text-sm font-medium">Linen</span>
                            </div>

                            <div class="fabric-card" data-fabric="wool">
                                <div class="fabric-sample" style="background: linear-gradient(45deg, #f0f0f0, #d8d8d8)">
                                    <i class="fas fa-cloud"></i>
                                </div>
                                <span class="text-sm font-medium">Wool</span>
                            </div>

                            <div class="fabric-card" data-fabric="cotton">
                                <div class="fabric-sample" style="background: linear-gradient(45deg, #f8f8ff, #e8e8ff)">
                                    <i class="fas fa-seedling"></i>
                                </div>
                                <span class="text-sm font-medium">Cotton</span>
                            </div>

                            <div class="fabric-card" data-fabric="chiffon">
                                <div class="fabric-sample" style="background: linear-gradient(45deg, #fff8ff, #f0e8f0)">
                                    <i class="fas fa-wind"></i>
                                </div>
                                <span class="text-sm font-medium">Chiffon</span>
                            </div>

                            <div class="fabric-card" data-fabric="lace">
                                <div class="fabric-sample" style="background: linear-gradient(45deg, #ffffff, #f8f8f8)">
                                    <i class="fas fa-palette"></i>
                                </div>
                                <span class="text-sm font-medium">Lace</span>
                            </div>

                            <div class="fabric-card" data-fabric="velvet">
                                <div class="fabric-sample" style="background: linear-gradient(45deg, #2d1b3d, #4a2c5d)">
                                    <i class="fas fa-crown text-white"></i>
                                </div>
                                <span class="text-sm font-medium">Velvet</span>
                            </div>

                            <div class="fabric-card" data-fabric="satin">
                                <div class="fabric-sample" style="background: linear-gradient(45deg, #fffaf0, #ffe8d6)">
                                    <i class="fas fa-star"></i>
                                </div>
                                <span class="text-sm font-medium">Satin</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="form-label">
                                Color Preference <span class="required-star">*</span>
                            </label>
                            <div class="flex flex-wrap gap-3 mt-2">
                                <div class="w-8 h-8 rounded-full bg-black cursor-pointer border-2 border-gray-300 hover:scale-110 transition-transform"></div>
                                <div class="w-8 h-8 rounded-full bg-white cursor-pointer border-2 border-gray-300 hover:scale-110 transition-transform"></div>
                                <div class="w-8 h-8 rounded-full bg-red-500 cursor-pointer border-2 border-gray-300 hover:scale-110 transition-transform"></div>
                                <div class="w-8 h-8 rounded-full bg-blue-500 cursor-pointer border-2 border-gray-300 hover:scale-110 transition-transform"></div>
                                <div class="w-8 h-8 rounded-full bg-green-500 cursor-pointer border-2 border-gray-300 hover:scale-110 transition-transform"></div>
                                <div class="w-8 h-8 rounded-full bg-yellow-500 cursor-pointer border-2 border-gray-300 hover:scale-110 transition-transform"></div>
                                <div class="w-8 h-8 rounded-full bg-purple-500 cursor-pointer border-2 border-gray-300 hover:scale-110 transition-transform"></div>
                                <div class="w-8 h-8 rounded-full bg-pink-500 cursor-pointer border-2 border-gray-300 hover:scale-110 transition-transform"></div>
                                <div class="w-8 h-8 rounded-full bg-gray-300 cursor-pointer border-2 border-gray-300 hover:scale-110 transition-transform"></div>
                            </div>
                        </div>

                        <div>
                            <label class="form-label">
                                Desired Completion Date
                            </label>
                            <input type="date" class="form-input">
                        </div>
                    </div>
                </div>

                <div class="section-divider"></div>

                <!-- Step 4: Contact & Submit -->
                <div class="space-y-8">
                    <div class="flex items-center">
                        <div class="step-indicator">4</div>
                        <h2 class="text-2xl font-bold text-gray-800">Contact & Submit</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="form-label">
                                Your Name <span class="required-star">*</span>
                            </label>
                            <input type="text" class="form-input" placeholder="Enter your full name" required>
                        </div>

                        <div>
                            <label class="form-label">
                                Email Address <span class="required-star">*</span>
                            </label>
                            <input type="email" class="form-input" placeholder="your.email@example.com" required>
                        </div>

                        <div>
                            <label class="form-label">
                                Phone Number
                            </label>
                            <input type="tel" class="form-input" placeholder="(123) 456-7890">
                        </div>

                        <div>
                            <label class="form-label">
                                Budget Range <span class="required-star">*</span>
                            </label>
                            <select class="form-select" required>
                                <option value="">Select budget</option>
                                <option value="500-1500">$500 - $1,500</option>
                                <option value="1500-3000">$1,500 - $3,000</option>
                                <option value="3000-5000">$3,000 - $5,000</option>
                                <option value="5000-10000">$5,000 - $10,000</option>
                                <option value="10000+">$10,000+</option>
                            </select>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-2xl p-6">
                        <label class="flex items-start space-x-3 cursor-pointer">
                            <input type="checkbox" class="form-checkbox mt-1" required>
                            <div>
                                <span class="font-medium text-gray-800">I agree to the terms and privacy policy</span>
                                <p class="text-sm text-gray-600 mt-1">By submitting this form, I consent to being contacted about my custom design request.</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-8 border-t border-gray-200 text-center">
                    <button type="submit" class="submit-button">
                        <i class="fas fa-paper-plane mr-3"></i>
                        Submit Design Request
                    </button>
                    <p class="text-gray-500 mt-6 text-sm">
                        <i class="fas fa-shield-alt mr-2"></i>
                        Secure & confidential. Response within 24 hours.
                    </p>
                </div>
            </form>
        </div>

        <!-- Process Steps -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="text-center p-6 bg-white rounded-2xl border border-gray-200">
                <div class="w-12 h-12 rounded-full bg-pink-50 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-lightbulb text-pink-500 text-xl"></i>
                </div>
                <h4 class="font-semibold text-gray-800 mb-2">Share Vision</h4>
                <p class="text-sm text-gray-600">Tell us about your design ideas</p>
            </div>

            <div class="text-center p-6 bg-white rounded-2xl border border-gray-200">
                <div class="w-12 h-12 rounded-full bg-pink-50 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-ruler-combined text-pink-500 text-xl"></i>
                </div>
                <h4 class="font-semibold text-gray-800 mb-2">Add Measurements</h4>
                <p class="text-sm text-gray-600">Provide your sizing details</p>
            </div>

            <div class="text-center p-6 bg-white rounded-2xl border border-gray-200">
                <div class="w-12 h-12 rounded-full bg-pink-50 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-palette text-pink-500 text-xl"></i>
                </div>
                <h4 class="font-semibold text-gray-800 mb-2">Select Materials</h4>
                <p class="text-sm text-gray-600">Choose fabrics and colors</p>
            </div>

            <div class="text-center p-6 bg-white rounded-2xl border border-gray-200">
                <div class="w-12 h-12 rounded-full bg-pink-50 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-calendar-check text-pink-500 text-xl"></i>
                </div>
                <h4 class="font-semibold text-gray-800 mb-2">Consultation</h4>
                <p class="text-sm text-gray-600">Finalize details with designer</p>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;

            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Gallery filter functionality
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.filter-btn');
        const galleryItems = document.querySelectorAll('.gallery-card');

        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                filterButtons.forEach(btn => {
                    btn.classList.remove('active');
                });

                // Add active class to clicked button
                this.classList.add('active');

                const filterValue = this.getAttribute('data-filter');

                // Filter gallery items
                galleryItems.forEach(item => {
                    if (filterValue === 'all') {
                        item.style.display = 'block';
                        setTimeout(() => {
                            item.style.opacity = '1';
                            item.style.transform = 'translateY(0)';
                        }, 50);
                    } else {
                        if (item.getAttribute('data-category') === filterValue) {
                            item.style.display = 'block';
                            setTimeout(() => {
                                item.style.opacity = '1';
                                item.style.transform = 'translateY(0)';
                            }, 50);
                        } else {
                            item.style.opacity = '0';
                            item.style.transform = 'translateY(20px)';
                            setTimeout(() => {
                                item.style.display = 'none';
                            }, 400);
                        }
                    }
                });
            });
        });

        // Product card selection
        const productCards = document.querySelectorAll('.product-card');
        productCards.forEach(card => {
            card.addEventListener('click', function() {
                productCards.forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');

                const category = this.getAttribute('data-category');
                console.log('Selected category:', category);
            });
        });

        // Fabric card selection
        const fabricCards = document.querySelectorAll('.fabric-card');
        fabricCards.forEach(card => {
            card.addEventListener('click', function() {
                this.classList.toggle('selected');

                const fabric = this.getAttribute('data-fabric');
                console.log('Toggled fabric:', fabric, this.classList.contains('selected'));
            });
        });

        // Color selection
        const colorCircles = document.querySelectorAll('.w-8.h-8.rounded-full');
        colorCircles.forEach(circle => {
            circle.addEventListener('click', function() {
                colorCircles.forEach(c => {
                    c.style.borderColor = '#d1d5db';
                    c.style.borderWidth = '2px';
                });
                this.style.borderColor = '#ff6b9d';
                this.style.borderWidth = '3px';
            });
        });

        // Form submission
        const designForm = document.getElementById('design-form');
        if (designForm) {
            designForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Simple validation
                let isValid = true;
                const requiredFields = designForm.querySelectorAll('[required]');

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.style.borderColor = '#ff6b9d';
                        field.style.backgroundColor = '#fff5f7';

                        // Add error message if not present
                        if (!field.nextElementSibling || !field.nextElementSibling.classList.contains('error-msg')) {
                            const errorMsg = document.createElement('p');
                            errorMsg.className = 'error-msg text-pink-500 text-xs mt-2';
                            errorMsg.textContent = 'This field is required';
                            field.parentElement.appendChild(errorMsg);
                        }
                    } else {
                        field.style.borderColor = '';
                        field.style.backgroundColor = '';
                        const errorMsg = field.parentElement.querySelector('.error-msg');
                        if (errorMsg) {
                            errorMsg.remove();
                        }
                    }
                });

                // Validate checkbox
                const requiredCheckbox = designForm.querySelector('[required][type="checkbox"]');
                if (requiredCheckbox && !requiredCheckbox.checked) {
                    isValid = false;
                    requiredCheckbox.style.borderColor = '#ff6b9d';
                }

                if (isValid) {
                    // Show success state
                    const submitBtn = designForm.querySelector('.submit-button');
                    const originalText = submitBtn.innerHTML;

                    submitBtn.innerHTML = '<i class="fas fa-check mr-3"></i> Request Submitted!';
                    submitBtn.disabled = true;
                    submitBtn.style.background = 'linear-gradient(90deg, #10b981, #34d399)';

                    // Create success message
                    const successDiv = document.createElement('div');
                    successDiv.className = 'mt-8 p-6 bg-green-50 rounded-2xl border border-green-200';
                    successDiv.innerHTML = `
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mr-4">
                                <i class="fas fa-check text-green-500 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 text-lg mb-1">Design Request Submitted!</h4>
                                <p class="text-gray-600">Thank you for your submission. Our design team will contact you within 24 hours.</p>
                            </div>
                        </div>
                    `;

                    designForm.appendChild(successDiv);

                    // Scroll to success message
                    setTimeout(() => {
                        successDiv.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }, 500);
                }
            });
        }

        // File upload interaction
        const uploadArea = document.querySelector('.border-dashed');
        if (uploadArea) {
            uploadArea.addEventListener('click', function() {
                console.log('Upload area clicked - would open file dialog');
            });
        }

        // Animated counter for stats
        function animateCounter(id, start, end, duration) {
            let obj = document.getElementById(id);
            if (!obj) return;

            let startTime = null;
            const step = (timestamp) => {
                if (!startTime) startTime = timestamp;
                const progress = Math.min((timestamp - startTime) / duration, 1);
                const value = Math.floor(progress * (end - start) + start);
                obj.innerHTML = value.toLocaleString();
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }

        // Animate testimonial stats
        function animateTestimonialCounter(id, start, end, duration, suffix = '') {
            let obj = document.getElementById(id);
            if (!obj) return;

            let startTime = null;
            const step = (timestamp) => {
                if (!startTime) startTime = timestamp;
                const progress = Math.min((timestamp - startTime) / duration, 1);
                const value = Math.floor(progress * (end - start) + start);

                if (suffix === '%') {
                    obj.innerHTML = value + '%';
                } else if (suffix === '.') {
                    obj.innerHTML = (start + (end - start) * progress).toFixed(1);
                } else {
                    obj.innerHTML = value.toLocaleString() + suffix;
                }

                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }

        // Start counters when page loads
        setTimeout(() => {
            // Main stats
            animateCounter('stat1', 0, 1247, 2000);
            animateCounter('stat2', 0, 892, 2000);
            animateCounter('stat3', 0, 243, 2000);
            animateCounter('stat4', 0, 67, 2000);

            // Testimonial stats
            animateTestimonialCounter('testimonial-stat1', 0, 98, 1500, '%');
            animateTestimonialCounter('testimonial-stat2', 0, 1500, 1500, '+');
            animateTestimonialCounter('testimonial-stat3', 0, 72, 1500, '%');
            animateTestimonialCounter('testimonial-stat4', 0, 4.9, 1500, '');
        }, 1000);

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe elements for animation
        document.querySelectorAll('.fade-in').forEach(element => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(30px)';
            element.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
            observer.observe(element);
        });

        // Add hover effect for feature cards
        document.querySelectorAll('.feature-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Add hover effect for gallery cards
        document.querySelectorAll('.gallery-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Add hover effect for testimonial cards
        document.querySelectorAll('.testimonial-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });
</script>
<script>
    // Add hover effect for step cards
    document.querySelectorAll('.step-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px)';
            this.style.boxShadow = '0 20px 40px rgba(168, 129, 163, 0.2)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 10px 30px rgba(168, 129, 163, 0.08)';
        });
    });

    // Add scroll animation for step cards
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe step cards for animation
    document.querySelectorAll('.step-card').forEach(card => {
        card.style.opacity = '0.7';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
</script>
@endsection