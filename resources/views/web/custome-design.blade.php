@extends('layout.web.main-layout')

@section('title', 'Custom Design Studio | Personalize Your Perfect Outfit')
@section('meta-description', 'Work with our expert designers to create custom-made outfits tailored to your style, measurements, and occasion.')

@section('content')

<style>
    /* Custom Design Studio Styles */
    .design-process-step {
        position: relative;
        counter-increment: step-counter;
    }
    
    .design-process-step::before {
        content: counter(step-counter);
        position: absolute;
        top: -20px;
        left: -20px;
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #ec4899, #8b5cf6);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.2rem;
        z-index: 2;
    }
    
    .fabric-swatch:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    
    .designer-card {
        transition: all 0.3s ease;
    }
    
    .designer-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    
    .customization-option {
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }
    
    .customization-option.selected {
        border-color: #ec4899;
        box-shadow: 0 5px 15px rgba(236, 72, 153, 0.2);
    }
    
    .timeline-step {
        position: relative;
        padding-left: 60px;
    }
    
    .timeline-step::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 40px;
        height: 40px;
        border: 3px solid #ec4899;
        border-radius: 50%;
        background: white;
    }
    
    .timeline-step::after {
        content: '';
        position: absolute;
        left: 19px;
        top: 40px;
        width: 2px;
        height: calc(100% + 20px);
        background: #e5e7eb;
    }
    
    .timeline-step:last-child::after {
        display: none;
    }
    
    .embroidery-preview {
        background: linear-gradient(45deg, #f9fafb, #f3f4f6);
        background-size: 400% 400%;
        animation: gradientShift 15s ease infinite;
    }
    
    @keyframes gradientShift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }
    
    .design-canvas {
        background: repeating-linear-gradient(
            45deg,
            transparent,
            transparent 10px,
            #f0f0f0 10px,
            #f0f0f0 20px
        );
        position: relative;
        overflow: hidden;
    }
    
    .design-canvas img {
        transition: all 0.5s ease;
    }
    
    /* Custom scrollbar for fabric selection */
    .fabric-scroll::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    
    .fabric-scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .fabric-scroll::-webkit-scrollbar-thumb {
        background: #ec4899;
        border-radius: 10px;
    }
    
    /* Floating action button for design summary */
    .design-summary-fab {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 100;
        animation: float 3s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    
    /* Color swatch selected indicator */
    .color-swatch.selected .selected-indicator {
        display: flex !important;
    }
    
    /* Zoom effect on hover for embroidery */
    .embroidery-pattern:hover img {
        transform: scale(1.1);
    }
</style>

<!-- Hero Section -->
<section class="relative overflow-hidden bg-gradient-to-br from-purple-50 via-pink-50 to-white py-16 lg:py-24">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-72 h-72 bg-purple-300 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-pink-300 rounded-full translate-x-1/2 translate-y-1/2"></div>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-6">
                Create Your <span class="bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent">Dream Outfit</span>
            </h1>
            <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                Work directly with our master designers to create custom-made clothing that fits perfectly and reflects your unique style.
            </p>
            <div class="flex flex-wrap gap-4 justify-center">
                <a href="#design-process" 
                   class="px-8 py-3 bg-gradient-to-r from-pink-600 to-purple-600 text-white font-semibold rounded-full hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                    Start Your Design
                </a>
                <a href="#meet-designers" 
                   class="px-8 py-3 bg-white text-gray-800 font-semibold rounded-full border border-gray-300 hover:border-pink-500 hover:shadow-lg transition-all duration-300">
                    Meet Our Designers
                </a>
            </div>
        </div>
        
        <!-- Hero Stats -->
        <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
            <div class="text-center">
                <div class="text-3xl font-bold text-pink-600">500+</div>
                <div class="text-gray-600">Fabrics</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-purple-600">50+</div>
                <div class="text-gray-600">Master Designers</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-pink-600">4-6</div>
                <div class="text-gray-600">Weeks Timeline</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-purple-600">1000+</div>
                <div class="text-gray-600">Happy Clients</div>
            </div>
        </div>
    </div>
</section>





<!-- Interactive Design Studio -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Virtual Design Studio
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Explore our interactive tools to visualize your custom design
            </p>
        </div>
        
        <div class="grid lg:grid-cols-2 gap-8 max-w-6xl mx-auto">
            <!-- Design Canvas -->
            <div class="bg-gray-50 rounded-2xl p-6 shadow-lg">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Design Preview</h3>
                <div class="design-canvas rounded-xl overflow-hidden h-[400px] relative">
                    <!-- Base Outfit -->
                    <img id="base-outfit" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                         alt="Base Outfit" class="absolute inset-0 w-full h-full object-cover">
                    
                    <!-- Fabric Overlay -->
                    <div id="fabric-overlay" class="absolute inset-0 opacity-30 mix-blend-multiply"></div>
                    
                    <!-- Color Overlay -->
                    <div id="color-overlay" class="absolute inset-0 mix-blend-overlay opacity-40"></div>
                    
                    <!-- Embellishment Layer -->
                    <div id="embellishment-layer" class="absolute inset-0 bg-contain bg-center bg-no-repeat opacity-70"></div>
                </div>
                
                <div class="mt-6 grid grid-cols-2 gap-4">
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-2">Selected Options</h4>
                        <div id="selected-options" class="space-y-2 text-sm">
                            <div id="selected-fabric" class="text-gray-600">No fabric selected</div>
                            <div id="selected-color" class="text-gray-600">No color selected</div>
                            <div id="selected-embroidery" class="text-gray-600">No embroidery selected</div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-2xl font-bold text-gray-900" id="design-price">Rs. 15,000</div>
                        <div class="text-sm text-gray-500">Base Price</div>
                    </div>
                </div>
            </div>
            
            <!-- Customization Options -->
            <div class="space-y-6">
                <!-- Fabric Selection -->
                <div class="bg-gray-50 rounded-xl p-6 shadow-lg">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Select Fabric</h3>
                    <div class="fabric-scroll overflow-x-auto pb-4">
                        <div class="flex gap-4">
                            <!-- Fabric 1 -->
                            <div class="fabric-swatch customization-option flex-shrink-0 w-24 cursor-pointer" 
                                 data-fabric-id="1"
                                 data-fabric-name="Pure Silk"
                                 data-fabric-price="5000"
                                 data-fabric-image="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80"
                                 data-fabric-color="#f472b6"
                                 onclick="selectFabric(this)">
                                <div class="aspect-square rounded-lg overflow-hidden mb-2 border-2 border-gray-300">
                                    <img src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" 
                                         alt="Pure Silk" 
                                         class="w-full h-full object-cover">
                                </div>
                                <div class="text-center">
                                    <div class="text-sm font-medium text-gray-900">Pure Silk</div>
                                    <div class="text-xs text-gray-500">Rs. 5,000</div>
                                </div>
                            </div>
                            
                            <!-- Fabric 2 -->
                            <div class="fabric-swatch customization-option flex-shrink-0 w-24 cursor-pointer" 
                                 data-fabric-id="2"
                                 data-fabric-name="Banarasi Brocade"
                                 data-fabric-price="8000"
                                 data-fabric-image="https://images.unsplash.com/photo-1558769132-cb1f458a43b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80"
                                 data-fabric-color="#7c3aed"
                                 onclick="selectFabric(this)">
                                <div class="aspect-square rounded-lg overflow-hidden mb-2 border-2 border-gray-300">
                                    <img src="https://images.unsplash.com/photo-1558769132-cb1f458a43b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" 
                                         alt="Banarasi Brocade" 
                                         class="w-full h-full object-cover">
                                </div>
                                <div class="text-center">
                                    <div class="text-sm font-medium text-gray-900">Banarasi</div>
                                    <div class="text-xs text-gray-500">Rs. 8,000</div>
                                </div>
                            </div>
                            
                            <!-- Fabric 3 -->
                            <div class="fabric-swatch customization-option flex-shrink-0 w-24 cursor-pointer" 
                                 data-fabric-id="3"
                                 data-fabric-name="Georgette"
                                 data-fabric-price="3000"
                                 data-fabric-image="https://images.unsplash.com/photo-1558769132-cb1f458a43b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80"
                                 data-fabric-color="#60a5fa"
                                 onclick="selectFabric(this)">
                                <div class="aspect-square rounded-lg overflow-hidden mb-2 border-2 border-gray-300">
                                    <img src="https://images.unsplash.com/photo-1558769132-cb1f458a43b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" 
                                         alt="Georgette" 
                                         class="w-full h-full object-cover">
                                </div>
                                <div class="text-center">
                                    <div class="text-sm font-medium text-gray-900">Georgette</div>
                                    <div class="text-xs text-gray-500">Rs. 3,000</div>
                                </div>
                            </div>
                            
                            <!-- Fabric 4 -->
                            <div class="fabric-swatch customization-option flex-shrink-0 w-24 cursor-pointer" 
                                 data-fabric-id="4"
                                 data-fabric-name="Velvet"
                                 data-fabric-price="6000"
                                 data-fabric-image="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80"
                                 data-fabric-color="#dc2626"
                                 onclick="selectFabric(this)">
                                <div class="aspect-square rounded-lg overflow-hidden mb-2 border-2 border-gray-300">
                                    <img src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" 
                                         alt="Velvet" 
                                         class="w-full h-full object-cover">
                                </div>
                                <div class="text-center">
                                    <div class="text-sm font-medium text-gray-900">Velvet</div>
                                    <div class="text-xs text-gray-500">Rs. 6,000</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Color Selection -->
                <div class="bg-gray-50 rounded-xl p-6 shadow-lg">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Choose Color</h3>
                    <div class="flex flex-wrap gap-3">
                        @foreach(['#FF6B8B', '#FF9E80', '#FFD166', '#06D6A0', '#118AB2', '#073B4C', '#7209B7', '#F72585', '#FF9E00', '#4CC9F0'] as $index => $color)
                        <div class="color-swatch customization-option w-10 h-10 rounded-full cursor-pointer border-2 border-gray-300 relative"
                             style="background-color: {{ $color }}"
                             data-color="{{ $color }}"
                             onclick="selectColor(this)">
                            <div class="selected-indicator hidden absolute inset-0 rounded-full border-4 border-white"></div>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <!-- Embroidery Patterns -->
                <div class="bg-gray-50 rounded-xl p-6 shadow-lg">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Add Embroidery</h3>
                    <div class="grid grid-cols-4 gap-3">
                        <!-- Pattern 1 -->
                        <div class="embroidery-pattern customization-option aspect-square rounded-lg overflow-hidden cursor-pointer border-2 border-gray-300"
                             data-pattern-id="1"
                             data-pattern-name="Zardozi Work"
                             data-pattern-price="7000"
                             data-pattern-image="https://images.unsplash.com/photo-1567401893414-76b7b1e5a7a5?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80"
                             onclick="selectEmbroidery(this)">
                            <img src="https://images.unsplash.com/photo-1567401893414-76b7b1e5a7a5?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" 
                                 alt="Zardozi Work"
                                 class="w-full h-full object-cover transition-transform duration-300">
                        </div>
                        
                        <!-- Pattern 2 -->
                        <div class="embroidery-pattern customization-option aspect-square rounded-lg overflow-hidden cursor-pointer border-2 border-gray-300"
                             data-pattern-id="2"
                             data-pattern-name="Sequins Border"
                             data-pattern-price="4000"
                             data-pattern-image="https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80"
                             onclick="selectEmbroidery(this)">
                            <img src="https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" 
                                 alt="Sequins Border"
                                 class="w-full h-full object-cover transition-transform duration-300">
                        </div>
                        
                        <!-- Pattern 3 -->
                        <div class="embroidery-pattern customization-option aspect-square rounded-lg overflow-hidden cursor-pointer border-2 border-gray-300"
                             data-pattern-id="3"
                             data-pattern-name="Mirror Work"
                             data-pattern-price="3500"
                             data-pattern-image="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80"
                             onclick="selectEmbroidery(this)">
                            <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" 
                                 alt="Mirror Work"
                                 class="w-full h-full object-cover transition-transform duration-300">
                        </div>
                        
                        <!-- Pattern 4 -->
                        <div class="embroidery-pattern customization-option aspect-square rounded-lg overflow-hidden cursor-pointer border-2 border-gray-300"
                             data-pattern-id="4"
                             data-pattern-name="Thread Embroidery"
                             data-pattern-price="2500"
                             data-pattern-image="https://images.unsplash.com/photo-1576566588028-4147f3842f27?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80"
                             onclick="selectEmbroidery(this)">
                            <img src="https://images.unsplash.com/photo-1576566588028-4147f3842f27?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80" 
                                 alt="Thread Embroidery"
                                 class="w-full h-full object-cover transition-transform duration-300">
                        </div>
                    </div>
                </div>
                
                <!-- Save Design Button -->
                <button onclick="saveDesign()" 
                        class="w-full px-6 py-4 bg-gradient-to-r from-pink-600 to-purple-600 text-white font-bold rounded-xl hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                    Save This Design
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Fabric & Materials Library -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Premium Materials Library
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Choose from our curated collection of premium fabrics, threads, and embellishments
            </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <!-- Fabrics -->
            <div class="bg-white rounded-2xl p-6 shadow-lg">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 bg-gradient-to-r from-pink-100 to-pink-200 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Premium Fabrics</h3>
                        <p class="text-sm text-gray-500">500+ varieties</p>
                    </div>
                </div>
                <ul class="space-y-3">
                    <li class="flex items-center justify-between">
                        <span class="text-gray-700">Silk & Banarasi</span>
                        <span class="text-pink-600 font-medium">From Rs. 3,000</span>
                    </li>
                    <li class="flex items-center justify-between">
                        <span class="text-gray-700">Georgette & Chiffon</span>
                        <span class="text-pink-600 font-medium">From Rs. 1,500</span>
                    </li>
                    <li class="flex items-center justify-between">
                        <span class="text-gray-700">Velvet & Brocade</span>
                        <span class="text-pink-600 font-medium">From Rs. 2,500</span>
                    </li>
                    <li class="flex items-center justify-between">
                        <span class="text-gray-700">Cotton & Linen</span>
                        <span class="text-pink-600 font-medium">From Rs. 800</span>
                    </li>
                </ul>
            </div>
            
            <!-- Embellishments -->
            <div class="bg-white rounded-2xl p-6 shadow-lg">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-100 to-purple-200 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Embellishments</h3>
                        <p class="text-sm text-gray-500">1000+ patterns</p>
                    </div>
                </div>
                <ul class="space-y-3">
                    <li class="flex items-center justify-between">
                        <span class="text-gray-700">Zardozi Work</span>
                        <span class="text-purple-600 font-medium">From Rs. 5,000</span>
                    </li>
                    <li class="flex items-center justify-between">
                        <span class="text-gray-700">Sequins & Beads</span>
                        <span class="text-purple-600 font-medium">From Rs. 2,000</span>
                    </li>
                    <li class="flex items-center justify-between">
                        <span class="text-gray-700">Mirror Work</span>
                        <span class="text-purple-600 font-medium">From Rs. 1,500</span>
                    </li>
                    <li class="flex items-center justify-between">
                        <span class="text-gray-700">Thread Embroidery</span>
                        <span class="text-purple-600 font-medium">From Rs. 800</span>
                    </li>
                </ul>
            </div>
            
            <!-- Accessories -->
            <div class="bg-white rounded-2xl p-6 shadow-lg">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-100 to-blue-200 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Accessories</h3>
                        <p class="text-sm text-gray-500">Complete the look</p>
                    </div>
                </div>
                <ul class="space-y-3">
                    <li class="flex items-center justify-between">
                        <span class="text-gray-700">Custom Dupattas</span>
                        <span class="text-blue-600 font-medium">From Rs. 1,000</span>
                    </li>
                    <li class="flex items-center justify-between">
                        <span class="text-gray-700">Belt & Kamarbandh</span>
                        <span class="text-blue-600 font-medium">From Rs. 500</span>
                    </li>
                    <li class="flex items-center justify-between">
                        <span class="text-gray-700">Neckline Designs</span>
                        <span class="text-blue-600 font-medium">From Rs. 800</span>
                    </li>
                    <li class="flex items-center justify-between">
                        <span class="text-gray-700">Sleeve Variations</span>
                        <span class="text-blue-600 font-medium">From Rs. 600</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Meet Our Designers -->
<section id="meet-designers" class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Master Designers
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Meet the talented artisans who bring your vision to life with decades of combined experience
            </p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <!-- Designer 1 -->
            <div class="designer-card bg-white rounded-2xl overflow-hidden shadow-lg group">
                <div class="relative overflow-hidden">
                    <img src="{{ asset('web/images/designers/designer1.jpg') }}" 
                         alt="Aisha Khan"
                         class="w-full h-64 object-cover object-center group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <!-- Designer Badge -->
                    <div class="absolute top-4 right-4">
                        <span class="bg-gradient-to-r from-pink-500 to-purple-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg">
                            15+ Years
                        </span>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Aisha Khan</h3>
                            <p class="text-pink-600 font-medium">Lead Bridal Designer</p>
                        </div>
                        <!-- Social Links -->
                        <div class="flex gap-2">
                            <a href="#" class="text-gray-400 hover:text-pink-600 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1112.324 0 6.162 6.162 0 01-12.324 0zM12 16a4 4 0 110-8 4 4 0 010 8zm4.965-10.405a1.44 1.44 0 112.881.001 1.44 1.44 0 01-2.881-.001z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-purple-600 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-2 16h-2v-6h2v6zm-1-6.891c-.607 0-1.1-.496-1.1-1.109 0-.612.492-1.109 1.1-1.109s1.1.497 1.1 1.109c0 .613-.493 1.109-1.1 1.109zm8 6.891h-1.998v-2.861c0-1.881-2.002-1.722-2.002 0v2.861h-2v-6h2v1.093c.872-1.616 4-1.736 4 1.548v3.359z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                    
                    <p class="text-gray-600 mb-4">Specializes in traditional Indian bridal wear with modern interpretations. Expert in zardozi and silk work.</p>
                    
                    <!-- Specializations -->
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-medium">Bridal Lehengas</span>
                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-medium">Zardozi Work</span>
                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-medium">Silk Sarees</span>
                    </div>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-4 border-t border-gray-200 pt-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">250+</div>
                            <div class="text-xs text-gray-500">Designs</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">150+</div>
                            <div class="text-xs text-gray-500">Clients</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">12</div>
                            <div class="text-xs text-gray-500">Awards</div>
                        </div>
                    </div>
                    
                    <!-- View Portfolio Button -->
                    <a href="#" 
                       class="mt-4 block text-center px-4 py-2 bg-pink-50 text-pink-600 font-semibold rounded-lg hover:bg-pink-100 transition-colors">
                        View Portfolio
                    </a>
                </div>
            </div>
            
            <!-- Designer 2 -->
            <div class="designer-card bg-white rounded-2xl overflow-hidden shadow-lg group">
                <div class="relative overflow-hidden">
                    <img src="{{ asset('web/images/designers/designer2.jpg') }}" 
                         alt="Rahul Verma"
                         class="w-full h-64 object-cover object-center group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <!-- Designer Badge -->
                    <div class="absolute top-4 right-4">
                        <span class="bg-gradient-to-r from-blue-500 to-cyan-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg">
                            12+ Years
                        </span>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Rahul Verma</h3>
                            <p class="text-blue-600 font-medium">Menswear Specialist</p>
                        </div>
                        <!-- Social Links -->
                        <div class="flex gap-2">
                            <a href="#" class="text-gray-400 hover:text-blue-600 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1112.324 0 6.162 6.162 0 01-12.324 0zM12 16a4 4 0 110-8 4 4 0 010 8zm4.965-10.405a1.44 1.44 0 112.881.001 1.44 1.44 0 01-2.881-.001z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-cyan-600 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-2 16h-2v-6h2v6zm-1-6.891c-.607 0-1.1-.496-1.1-1.109 0-.612.492-1.109 1.1-1.109s1.1.497 1.1 1.109c0 .613-.493 1.109-1.1 1.109zm8 6.891h-1.998v-2.861c0-1.881-2.002-1.722-2.002 0v2.861h-2v-6h2v1.093c.872-1.616 4-1.736 4 1.548v3.359z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                    
                    <p class="text-gray-600 mb-4">Modern menswear designer focusing on fusion wear. Expert in sherwanis, bandhgalas, and contemporary suits.</p>
                    
                    <!-- Specializations -->
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-medium">Sherwanis</span>
                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-medium">Bandhgalas</span>
                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-medium">Fusion Wear</span>
                    </div>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-4 border-t border-gray-200 pt-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">180+</div>
                            <div class="text-xs text-gray-500">Designs</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">120+</div>
                            <div class="text-xs text-gray-500">Clients</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">8</div>
                            <div class="text-xs text-gray-500">Awards</div>
                        </div>
                    </div>
                    
                    <!-- View Portfolio Button -->
                    <a href="#" 
                       class="mt-4 block text-center px-4 py-2 bg-blue-50 text-blue-600 font-semibold rounded-lg hover:bg-blue-100 transition-colors">
                        View Portfolio
                    </a>
                </div>
            </div>
            
            <!-- Designer 3 -->
            <div class="designer-card bg-white rounded-2xl overflow-hidden shadow-lg group">
                <div class="relative overflow-hidden">
                    <img src="{{ asset('web/images/designers/designer3.jpg') }}" 
                         alt="Priya Sharma"
                         class="w-full h-64 object-cover object-center group-hover:scale-110 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <!-- Designer Badge -->
                    <div class="absolute top-4 right-4">
                        <span class="bg-gradient-to-r from-emerald-500 to-green-500 text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg">
                            8+ Years
                        </span>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Priya Sharma</h3>
                            <p class="text-emerald-600 font-medium">Contemporary Fusion Expert</p>
                        </div>
                        <!-- Social Links -->
                        <div class="flex gap-2">
                            <a href="#" class="text-gray-400 hover:text-emerald-600 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1112.324 0 6.162 6.162 0 01-12.324 0zM12 16a4 4 0 110-8 4 4 0 010 8zm4.965-10.405a1.44 1.44 0 112.881.001 1.44 1.44 0 01-2.881-.001z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-green-600 transition-colors">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-2 16h-2v-6h2v6zm-1-6.891c-.607 0-1.1-.496-1.1-1.109 0-.612.492-1.109 1.1-1.109s1.1.497 1.1 1.109c0 .613-.493 1.109-1.1 1.109zm8 6.891h-1.998v-2.861c0-1.881-2.002-1.722-2.002 0v2.861h-2v-6h2v1.093c.872-1.616 4-1.736 4 1.548v3.359z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                    
                    <p class="text-gray-600 mb-4">Specializes in Indo-western fusion wear. Creates modern silhouettes with traditional Indian elements.</p>
                    
                    <!-- Specializations -->
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-medium">Indo-Western</span>
                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-medium">Cocktail Wear</span>
                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-medium">Modern Sarees</span>
                    </div>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-4 border-t border-gray-200 pt-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">200+</div>
                            <div class="text-xs text-gray-500">Designs</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">100+</div>
                            <div class="text-xs text-gray-500">Clients</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900">6</div>
                            <div class="text-xs text-gray-500">Awards</div>
                        </div>
                    </div>
                    
                    <!-- View Portfolio Button -->
                    <a href="#" 
                       class="mt-4 block text-center px-4 py-2 bg-emerald-50 text-emerald-600 font-semibold rounded-lg hover:bg-emerald-100 transition-colors">
                        View Portfolio
                    </a>
                </div>
            </div>
        </div>
        
        <!-- View All Designers Button -->
        <div class="text-center mt-12">
            <a href="#" class="inline-flex items-center gap-2 px-8 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-full hover:border-pink-500 hover:text-pink-600 transition-all duration-300">
                View All Designers
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </a>
        </div>
    </div>
</section>



<!-- Final CTA -->
<section class="py-16 bg-gradient-to-r from-pink-600 to-purple-600">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
            Ready to Create Your Dream Outfit?
        </h2>
        <p class="text-pink-100 text-xl mb-8 max-w-2xl mx-auto">
            Schedule your free consultation with our master designers today
        </p>
        <div class="flex flex-wrap gap-4 justify-center">
            <button onclick="openDesignModal()" 
                    class="px-8 py-3 bg-white text-pink-600 font-bold rounded-full hover:bg-gray-100 transform hover:scale-105 transition-all duration-300 shadow-lg">
                Book Free Consultation
            </button>
            <a href="tel:+911234567890" 
               class="px-8 py-3 bg-transparent border-2 border-white text-white font-bold rounded-full hover:bg-white/10 transition-all duration-300">
                Call: +91 1234567890
            </a>
        </div>
        <p class="text-pink-200 mt-6">
            Monday - Saturday: 10 AM - 7 PM | Sunday: 11 AM - 5 PM
        </p>
    </div>
</section>

<!-- Design Consultation Modal -->
<div id="designModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Book Design Consultation</h3>
                <button onclick="closeDesignModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <form id="consultationForm" class="space-y-4">
                @csrf
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent" placeholder="Enter your name">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent" placeholder="Enter your email">
                    </div>
                </div>
                
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input type="tel" name="phone" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent" placeholder="Enter your phone number">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Preferred Designer</label>
                        <select name="designer_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                            <option value="">Any Available Designer</option>
                            <option value="1">Aisha Khan - Bridal Specialist</option>
                            <option value="2">Rahul Verma - Menswear Expert</option>
                            <option value="3">Priya Sharma - Fusion Designer</option>
                        </select>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Occasion</label>
                    <select name="occasion" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                        <option value="">Select Occasion</option>
                        <option value="wedding">Wedding</option>
                        <option value="reception">Reception</option>
                        <option value="engagement">Engagement</option>
                        <option value="festival">Festival</option>
                        <option value="party">Party</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Design Ideas & Requirements</label>
                    <textarea name="requirements" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent" placeholder="Describe your vision, preferred colors, style, and any specific requirements..."></textarea>
                </div>
                
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Preferred Date</label>
                        <input type="date" name="preferred_date" min="{{ date('Y-m-d', strtotime('+2 days')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Preferred Time</label>
                        <select name="preferred_time" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                            <option value="">Any Time</option>
                            <option value="morning">Morning (9 AM - 12 PM)</option>
                            <option value="afternoon">Afternoon (12 PM - 4 PM)</option>
                            <option value="evening">Evening (4 PM - 7 PM)</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex items-center gap-3">
                    <input type="checkbox" id="virtual" name="virtual" class="w-4 h-4 text-pink-600 rounded focus:ring-pink-500">
                    <label for="virtual" class="text-sm text-gray-700">Virtual Consultation (Video Call)</label>
                </div>
                
                <div class="pt-4">
                    <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-pink-600 to-purple-600 text-white font-bold rounded-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                        Book Free Consultation
                    </button>
                    <p class="text-xs text-gray-500 text-center mt-2">Our team will contact you within 24 hours to confirm your appointment</p>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Floating Design Summary -->
<div class="design-summary-fab hidden" id="designSummary">
    <div class="bg-white rounded-xl shadow-2xl p-4 min-w-[300px] border border-gray-200">
        <div class="flex justify-between items-center mb-3">
            <h4 class="font-bold text-gray-900">Your Design Summary</h4>
            <button onclick="closeSummary()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="space-y-2 mb-4">
            <div id="summary-fabric" class="text-sm text-gray-600">No fabric selected</div>
            <div id="summary-color" class="text-sm text-gray-600">No color selected</div>
            <div id="summary-embroidery" class="text-sm text-gray-600">No embroidery selected</div>
        </div>
        <div class="flex justify-between items-center">
            <div>
                <div class="text-lg font-bold text-gray-900" id="summary-price">Rs. 15,000</div>
                <div class="text-xs text-gray-500">Estimated Total</div>
            </div>
            <button onclick="saveDesign()" 
                    class="px-4 py-2 bg-pink-600 text-white text-sm font-medium rounded-lg hover:bg-pink-700 transition-colors">
                Save Design
            </button>
        </div>
    </div>
</div>

<!-- second page code  -->

<style>
    /* Live Video Shopping Calendar Styles */
    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 8px;
        margin-top: 20px;
    }
    
    .calendar-day {
        aspect-ratio: 1;
        border: 2px solid transparent;
        border-radius: 12px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: linear-gradient(145deg, #ffffff, #f9fafb);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    .calendar-day:hover:not(.disabled):not(.today) {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(236, 72, 153, 0.2);
        border-color: #f472b6;
    }
    
    .calendar-day.selected {
        background: linear-gradient(135deg, #ec4899, #8b5cf6);
        color: white;
        border-color: #ec4899;
        box-shadow: 0 10px 20px rgba(236, 72, 153, 0.3);
        transform: scale(1.05);
    }
    
    .calendar-day.today {
        border-color: #f472b6;
        background: linear-gradient(135deg, #fce7f3, #fae8ff);
    }
    
    .calendar-day.disabled {
        opacity: 0.4;
        cursor: not-allowed;
        background: #f3f4f6;
    }
    
    .calendar-day-number {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 4px;
    }
    
    .calendar-day-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .time-slot {
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 12px 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .time-slot:hover:not(.booked) {
        border-color: #ec4899;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(236, 72, 153, 0.1);
    }
    
    .time-slot.selected {
        background: linear-gradient(135deg, #ec4899, #8b5cf6);
        color: white;
        border-color: transparent;
        box-shadow: 0 8px 16px rgba(236, 72, 153, 0.2);
    }
    
    .time-slot.booked {
        background: #f3f4f6;
        color: #9ca3af;
        cursor: not-allowed;
        position: relative;
        overflow: hidden;
    }
    
    .time-slot.booked::after {
        content: "BOOKED";
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-45deg);
        background: rgba(239, 68, 68, 0.9);
        color: white;
        padding: 2px 20px;
        font-size: 0.7rem;
        font-weight: bold;
        letter-spacing: 1px;
    }
    
    .stylist-card {
        border: 2px solid transparent;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
        background: white;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    .stylist-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        border-color: #ec4899;
    }
    
    .stylist-card.selected {
        border-color: #ec4899;
        box-shadow: 0 0 0 3px rgba(236, 72, 153, 0.2);
    }
    
    .availability-indicator {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 6px;
    }
    
    .availability-indicator.available {
        background: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
    }
    
    .availability-indicator.busy {
        background: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.2);
    }
    
    .availability-indicator.away {
        background: #f59e0b;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.2);
    }
    
    .video-call-preview {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 16px;
        overflow: hidden;
        position: relative;
    }
    
    .video-call-preview::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
        animation: shine 3s infinite linear;
    }
    
    @keyframes shine {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }
    
    .floating-cta {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 100;
        animation: float 6s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    
    .gradient-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .glass-effect {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .session-type-card {
        border: 2px solid transparent;
        border-radius: 16px;
        transition: all 0.3s ease;
        cursor: pointer;
        background: white;
    }
    
    .session-type-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }
    
    .session-type-card.selected {
        border-color: #ec4899;
        background: linear-gradient(135deg, #fdf2f8, #faf5ff);
        box-shadow: 0 10px 20px rgba(236, 72, 153, 0.1);
    }
    
    .confetti {
        position: fixed;
        width: 10px;
        height: 10px;
        background: #ec4899;
        border-radius: 50%;
        opacity: 0;
        z-index: 9999;
        pointer-events: none;
    }
    
    /* Calendar navigation */
    .calendar-nav-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 2px solid #e5e7eb;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .calendar-nav-btn:hover {
        border-color: #ec4899;
        background: #fdf2f8;
        transform: scale(1.1);
    }
    
    /* Pulse animation for selected time */
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(236, 72, 153, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(236, 72, 153, 0); }
        100% { box-shadow: 0 0 0 0 rgba(236, 72, 153, 0); }
    }
    
    .pulse-animation {
        animation: pulse 2s infinite;
    }
    
    /* Gradient text */
    .gradient-text {
        background: linear-gradient(135deg, #ec4899, #8b5cf6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    /* Loading animation */
    .loading-dots {
        display: inline-flex;
        gap: 4px;
    }
    
    .loading-dots span {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #ec4899;
        animation: bounce 1.4s infinite ease-in-out both;
    }
    
    .loading-dots span:nth-child(1) { animation-delay: -0.32s; }
    .loading-dots span:nth-child(2) { animation-delay: -0.16s; }
    
    @keyframes bounce {
        0%, 80%, 100% { transform: scale(0); }
        40% { transform: scale(1.0); }
    }
</style>



<!-- How It Works -->
<section id="how-it-works" class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                How Live Video Shopping Works
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Experience the future of fashion shopping from the comfort of your home
            </p>
        </div>
        
        <div class="grid md:grid-cols-4 gap-8 max-w-6xl mx-auto">
            <!-- Step 1 -->
            <div class="text-center">
                <div class="relative mb-6">
                    <div class="w-20 h-20 gradient-bg rounded-2xl flex items-center justify-center mx-auto">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="absolute -top-2 -left-2 w-8 h-8 bg-pink-500 text-white rounded-full flex items-center justify-center text-sm font-bold">
                        1
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Book Your Slot</h3>
                <p class="text-gray-600 text-sm">Choose your preferred date, time, and stylist</p>
            </div>
            
            <!-- Step 2 -->
            <div class="text-center">
                <div class="relative mb-6">
                    <div class="w-20 h-20 gradient-bg rounded-2xl flex items-center justify-center mx-auto">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="absolute -top-2 -left-2 w-8 h-8 bg-pink-500 text-white rounded-full flex items-center justify-center text-sm font-bold">
                        2
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Join Live Session</h3>
                <p class="text-gray-600 text-sm">Connect via video call at your scheduled time</p>
            </div>
            
            <!-- Step 3 -->
            <div class="text-center">
                <div class="relative mb-6">
                    <div class="w-20 h-20 gradient-bg rounded-2xl flex items-center justify-center mx-auto">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="absolute -top-2 -left-2 w-8 h-8 bg-pink-500 text-white rounded-full flex items-center justify-center text-sm font-bold">
                        3
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Try Outfits Virtually</h3>
                <p class="text-gray-600 text-sm">See outfits on models and get styling advice</p>
            </div>
            
            <!-- Step 4 -->
            <div class="text-center">
                <div class="relative mb-6">
                    <div class="w-20 h-20 gradient-bg rounded-2xl flex items-center justify-center mx-auto">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <div class="absolute -top-2 -left-2 w-8 h-8 bg-pink-500 text-white rounded-full flex items-center justify-center text-sm font-bold">
                        4
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Shop Instantly</h3>
                <p class="text-gray-600 text-sm">Purchase selected items with exclusive live discounts</p>
            </div>
        </div>
    </div>
</section>

<!-- Main Booking Section -->
<section id="book-now" class="py-16 bg-gradient-to-br from-pink-50 to-purple-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Book Your Live Shopping Session
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Select your preferred date, time, and stylist for a personalized virtual shopping experience
            </p>
        </div>
        
        <div class="grid lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <!-- Left Column - Session Type & Stylists -->
            <div class="space-y-8">
                <!-- Session Type Selection -->
                <div class="bg-white rounded-2xl p-6 shadow-lg">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Session Type</h3>
                    <div class="space-y-3">
                        <!-- Personal Styling -->
                        <div class="session-type-card p-4" onclick="selectSessionType('personal')" id="personal-session">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-gradient-to-r from-pink-100 to-purple-100 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">Personal Styling</h4>
                                        <p class="text-sm text-gray-500">30 mins • 1-on-1</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-gray-900">Rs. 999</div>
                                    <div class="text-xs text-gray-500">Free on first booking</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Group Shopping -->
                        <div class="session-type-card p-4" onclick="selectSessionType('group')" id="group-session">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-gradient-to-r from-blue-100 to-cyan-100 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">Group Shopping</h4>
                                        <p class="text-sm text-gray-500">60 mins • Up to 5 people</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-gray-900">Rs. 1,999</div>
                                    <div class="text-xs text-green-600">Save Rs. 500 per person</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Bridal Consultation -->
                        <div class="session-type-card p-4" onclick="selectSessionType('bridal')" id="bridal-session">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-gradient-to-r from-rose-100 to-pink-100 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">Bridal Consultation</h4>
                                        <p class="text-sm text-gray-500">90 mins • Complete look</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-gray-900">Rs. 2,999</div>
                                    <div class="text-xs text-gray-500">Includes accessory styling</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Available Stylists -->
                <div class="bg-white rounded-2xl p-6 shadow-lg">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Available Stylists</h3>
                    <div class="space-y-3">
                        <!-- Stylist 1 -->
                        <div class="stylist-card p-3" onclick="selectStylist(1)" id="stylist-1">
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <img src="https://images.unsplash.com/photo-1494790108755-2616b786d4d1?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" 
                                         alt="Aisha Khan" 
                                         class="w-14 h-14 rounded-xl object-cover">
                                    <span class="availability-indicator available absolute -bottom-1 -right-1"></span>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900">Aisha Khan</h4>
                                    <div class="flex items-center gap-2">
                                        <div class="text-sm text-gray-500">Bridal Specialist</div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            <span class="text-xs text-gray-600 ml-1">4.9</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-medium text-gray-900">Available</div>
                                    <div class="text-xs text-green-600">5 slots today</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Stylist 2 -->
                        <div class="stylist-card p-3" onclick="selectStylist(2)" id="stylist-2">
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" 
                                         alt="Rahul Verma" 
                                         class="w-14 h-14 rounded-xl object-cover">
                                    <span class="availability-indicator busy absolute -bottom-1 -right-1"></span>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900">Rahul Verma</h4>
                                    <div class="flex items-center gap-2">
                                        <div class="text-sm text-gray-500">Menswear Expert</div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            <span class="text-xs text-gray-600 ml-1">4.8</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-medium text-gray-900">Limited</div>
                                    <div class="text-xs text-yellow-600">2 slots left</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Stylist 3 -->
                        <div class="stylist-card p-3" onclick="selectStylist(3)" id="stylist-3">
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" 
                                         alt="Priya Sharma" 
                                         class="w-14 h-14 rounded-xl object-cover">
                                    <span class="availability-indicator available absolute -bottom-1 -right-1"></span>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900">Priya Sharma</h4>
                                    <div class="flex items-center gap-2">
                                        <div class="text-sm text-gray-500">Fusion Fashion</div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            <span class="text-xs text-gray-600 ml-1">4.9</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-medium text-gray-900">Available</div>
                                    <div class="text-xs text-green-600">8 slots today</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Center Column - Calendar -->
            <div class="bg-white rounded-2xl p-6 shadow-lg">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Select Date</h3>
                        <p class="text-gray-500 text-sm" id="current-month">February 2024</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button class="calendar-nav-btn" onclick="changeMonth(-1)">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button class="calendar-nav-btn" onclick="changeMonth(1)">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Day Headers -->
                <div class="grid grid-cols-7 gap-2 mb-4">
                    <div class="text-center text-sm font-semibold text-gray-500 py-2">SUN</div>
                    <div class="text-center text-sm font-semibold text-gray-500 py-2">MON</div>
                    <div class="text-center text-sm font-semibold text-gray-500 py-2">TUE</div>
                    <div class="text-center text-sm font-semibold text-gray-500 py-2">WED</div>
                    <div class="text-center text-sm font-semibold text-gray-500 py-2">THU</div>
                    <div class="text-center text-sm font-semibold text-gray-500 py-2">FRI</div>
                    <div class="text-center text-sm font-semibold text-gray-500 py-2">SAT</div>
                </div>
                
                <!-- Calendar Grid -->
                <div class="calendar-grid" id="calendar-grid">
                    <!-- Calendar days will be generated by JavaScript -->
                </div>
                
                <!-- Legend -->
                <div class="mt-8 flex flex-wrap gap-4 justify-center">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-gradient-to-r from-pink-500 to-purple-500"></div>
                        <span class="text-xs text-gray-600">Selected</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full border-2 border-pink-300 bg-pink-50"></div>
                        <span class="text-xs text-gray-600">Today</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-gray-200"></div>
                        <span class="text-xs text-gray-600">Unavailable</span>
                    </div>
                </div>
            </div>
            
            <!-- Right Column - Time Slots & Booking Summary -->
            <div class="space-y-8">
                <!-- Time Slots -->
                <div class="bg-white rounded-2xl p-6 shadow-lg">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-gray-900">Available Time Slots</h3>
                        <span class="text-sm text-gray-500" id="selected-date-display">Select a date</span>
                    </div>
                    
                    <div class="space-y-3" id="time-slots-container">
                        <!-- Time slots will be generated by JavaScript -->
                        <div class="text-center py-8 text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p>Select a date to view available time slots</p>
                        </div>
                    </div>
                </div>
                
                <!-- Booking Summary -->
                <div class="bg-gradient-to-br from-pink-500 to-purple-600 rounded-2xl p-6 shadow-lg">
                    <h3 class="text-xl font-bold text-white mb-4">Booking Summary</h3>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-pink-100">Session Type:</span>
                            <span class="font-semibold text-white" id="summary-session-type">Not selected</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-pink-100">Stylist:</span>
                            <span class="font-semibold text-white" id="summary-stylist">Not selected</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-pink-100">Date:</span>
                            <span class="font-semibold text-white" id="summary-date">Not selected</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-pink-100">Time:</span>
                            <span class="font-semibold text-white" id="summary-time">Not selected</span>
                        </div>
                        
                        <div class="border-t border-pink-300 pt-4 mt-4">
                            <div class="flex justify-between items-center">
                                <span class="text-pink-100 text-lg">Total:</span>
                                <span class="text-2xl font-bold text-white" id="summary-total">Rs. 0</span>
                            </div>
                        </div>
                        
                        <button onclick="confirmBooking()" 
                                id="confirm-booking-btn"
                                disabled
                                class="w-full mt-6 py-3 bg-white text-pink-600 font-bold rounded-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:transform-none">
                            Confirm Booking
                        </button>
                        
                        <p class="text-pink-200 text-xs text-center mt-4">
                            <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Secure payment • Free cancellation within 24 hours
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Video Call Preview -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="video-call-preview rounded-2xl overflow-hidden">
            <div class="p-8 md:p-12 text-white text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Experience Live Video Shopping</h2>
                <p class="text-xl text-pink-100 mb-8 max-w-2xl mx-auto">
                    See how our virtual styling sessions work with this interactive preview
                </p>
                
                <div class="grid md:grid-cols-2 gap-8 items-center max-w-4xl mx-auto">
                    <!-- Video Preview -->
                    <div class="relative">
                        <div class="aspect-video bg-black/30 rounded-2xl overflow-hidden border-4 border-white/20">
                            <!-- Mock video interface -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="text-center">
                                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <p class="text-white/80">Live video connection</p>
                                </div>
                            </div>
                            
                            <!-- Mock controls -->
                            <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-4">
                                <button class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                                <button class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Features -->
                    <div class="space-y-6 text-left">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-white mb-1">Secure Connection</h4>
                                <p class="text-pink-100 text-sm">End-to-end encrypted video calls for complete privacy</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-white mb-1">Screen Sharing</h4>
                                <p class="text-pink-100 text-sm">Stylist can share outfit catalog and styling tips</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-white mb-1">Instant Checkout</h4>
                                <p class="text-pink-100 text-sm">Purchase selected items directly during the session</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-12">
                    <button onclick="scrollToBooking()" 
                            class="px-8 py-3 bg-white text-purple-600 font-bold rounded-full hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
                        Book Your Session Now
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-16 bg-gradient-to-br from-gray-50 to-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                What Our Customers Say
            </h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Join thousands of happy customers who transformed their shopping experience
            </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <!-- Testimonial 1 -->
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                <div class="flex items-center gap-3 mb-4">
                    <img src="https://images.unsplash.com/photo-1494790108755-2616b786d4d1?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" 
                         alt="Neha Sharma"
                         class="w-12 h-12 rounded-full object-cover">
                    <div>
                        <h4 class="font-bold text-gray-900">Neha Sharma</h4>
                        <div class="flex items-center">
                            @for($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            @endfor
                        </div>
                    </div>
                </div>
                <p class="text-gray-600 italic mb-4">"The live video session with Aisha was amazing! She understood my style perfectly and showed me outfits I would have never picked myself."</p>
                <div class="text-sm text-gray-500">
                    <span class="font-medium">Session:</span> Personal Styling • 30 mins
                </div>
            </div>
            
            <!-- Testimonial 2 -->
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                <div class="flex items-center gap-3 mb-4">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" 
                         alt="Raj Malhotra"
                         class="w-12 h-12 rounded-full object-cover">
                    <div>
                        <h4 class="font-bold text-gray-900">Raj Malhotra</h4>
                        <div class="flex items-center">
                            @for($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            @endfor
                        </div>
                    </div>
                </div>
                <p class="text-gray-600 italic mb-4">"As someone who hates shopping, this was a game-changer! Rahul helped me pick 3 perfect sherwanis for my brother's wedding."</p>
                <div class="text-sm text-gray-500">
                    <span class="font-medium">Session:</span> Group Shopping • 60 mins
                </div>
            </div>
            
            <!-- Testimonial 3 -->
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100">
                <div class="flex items-center gap-3 mb-4">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" 
                         alt="Anjali Patel"
                         class="w-12 h-12 rounded-full object-cover">
                    <div>
                        <h4 class="font-bold text-gray-900">Anjali Patel</h4>
                        <div class="flex items-center">
                            @for($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            @endfor
                        </div>
                    </div>
                </div>
                <p class="text-gray-600 italic mb-4">"The bridal consultation was worth every penny! Priya created my complete wedding look including accessories."</p>
                <div class="text-sm text-gray-500">
                    <span class="font-medium">Session:</span> Bridal Consultation • 90 mins
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Frequently Asked Questions
            </h2>
        </div>
        
        <div class="max-w-3xl mx-auto space-y-4">
            <!-- FAQ 1 -->
            <div class="faq-item bg-gray-50 rounded-xl overflow-hidden border border-gray-200">
                <button class="faq-question w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-100 transition-colors">
                    <span class="font-semibold text-gray-900">What do I need for the video session?</span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div class="faq-answer px-6 py-4 hidden border-t border-gray-200">
                    <p class="text-gray-600">You'll need a smartphone, tablet, or computer with a camera and microphone. We recommend using Chrome or Safari browsers for the best experience.</p>
                </div>
            </div>
            
            <!-- FAQ 2 -->
            <div class="faq-item bg-gray-50 rounded-xl overflow-hidden border border-gray-200">
                <button class="faq-question w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-100 transition-colors">
                    <span class="font-semibold text-gray-900">Can I cancel or reschedule my session?</span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div class="faq-answer px-6 py-4 hidden border-t border-gray-200">
                    <p class="text-gray-600">Yes! You can cancel or reschedule up to 24 hours before your session without any charges. Late cancellations may incur a small fee.</p>
                </div>
            </div>
            
            <!-- FAQ 3 -->
            <div class="faq-item bg-gray-50 rounded-xl overflow-hidden border border-gray-200">
                <button class="faq-question w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-100 transition-colors">
                    <span class="font-semibold text-gray-900">Do you offer discounts for group sessions?</span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div class="faq-answer px-6 py-4 hidden border-t border-gray-200">
                    <p class="text-gray-600">Absolutely! Group sessions (2-5 people) offer significant savings per person. You also get exclusive group-only discounts on purchases made during the session.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Floating Booking CTA -->
<div class="floating-cta hidden" id="floatingBookingCTA">
    <div class="bg-gradient-to-r from-pink-600 to-purple-600 text-white rounded-full px-6 py-3 shadow-2xl flex items-center gap-3">
        <div class="loading-dots">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <span class="font-bold">Complete your booking!</span>
        <button onclick="scrollToBooking()" class="bg-white text-pink-600 px-3 py-1 rounded-full text-sm font-bold hover:bg-gray-100 transition-colors">
            Book Now
        </button>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-8 text-center">
        <div class="w-20 h-20 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        
        <h3 class="text-2xl font-bold text-gray-900 mb-2">Booking Confirmed!</h3>
        <p class="text-gray-600 mb-6">Your live video shopping session has been scheduled successfully.</p>
        
        <div class="space-y-3 mb-8">
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Session ID:</span>
                <span class="font-semibold text-gray-900">#LVS2024-001</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Date & Time:</span>
                <span class="font-semibold text-gray-900" id="confirmation-datetime"></span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-600">Stylist:</span>
                <span class="font-semibold text-gray-900" id="confirmation-stylist"></span>
            </div>
        </div>
        
        <div class="space-y-3">
            <button onclick="closeSuccessModal()" 
                    class="w-full px-6 py-3 bg-gradient-to-r from-pink-600 to-purple-600 text-white font-bold rounded-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                Add to Calendar
            </button>
            <button onclick="closeSuccessModal()" 
                    class="w-full px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:border-pink-500 hover:text-pink-600 transition-all duration-300">
                Close
            </button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Design Studio Functionality
    let currentDesign = {
        fabric: null,
        color: null,
        embroidery: null,
        basePrice: 15000
    };
    
    // Modal Functions
    function openDesignModal() {
        document.getElementById('designModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closeDesignModal() {
        document.getElementById('designModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    
    // Selection Functions
    function selectFabric(element) {
        // Remove selected class from all fabric swatches
        document.querySelectorAll('.fabric-swatch').forEach(el => el.classList.remove('selected'));
        
        // Add selected class to clicked element
        element.classList.add('selected');
        
        // Update current design
        currentDesign.fabric = {
            id: element.dataset.fabricId,
            name: element.dataset.fabricName,
            price: parseInt(element.dataset.fabricPrice),
            image: element.dataset.fabricImage,
            color: element.dataset.fabricColor
        };
        
        // Update fabric overlay in design canvas
        const fabricOverlay = document.getElementById('fabric-overlay');
        fabricOverlay.style.backgroundImage = `url('${currentDesign.fabric.image}')`;
        fabricOverlay.style.backgroundSize = 'cover';
        
        updateDesignSummary();
        calculatePrice();
    }
    
    function selectColor(element) {
        // Remove selected class from all color swatches
        document.querySelectorAll('.color-swatch').forEach(el => {
            el.classList.remove('selected');
        });
        
        // Add selected class to clicked element
        element.classList.add('selected');
        
        // Update current design
        currentDesign.color = element.dataset.color;
        
        // Update color overlay in design canvas
        const colorOverlay = document.getElementById('color-overlay');
        colorOverlay.style.backgroundColor = currentDesign.color;
        
        updateDesignSummary();
    }
    
    function selectEmbroidery(element) {
        // Remove selected class from all embroidery patterns
        document.querySelectorAll('.embroidery-pattern').forEach(el => el.classList.remove('selected'));
        
        // Add selected class to clicked element
        element.classList.add('selected');
        
        // Update current design
        currentDesign.embroidery = {
            id: element.dataset.patternId,
            name: element.dataset.patternName,
            price: parseInt(element.dataset.patternPrice),
            image: element.dataset.patternImage
        };
        
        // Update embroidery layer in design canvas
        const embLayer = document.getElementById('embellishment-layer');
        embLayer.style.backgroundImage = `url('${currentDesign.embroidery.image}')`;
        embLayer.style.backgroundSize = 'contain';
        embLayer.style.backgroundPosition = 'center';
        embLayer.style.backgroundRepeat = 'no-repeat';
        
        updateDesignSummary();
        calculatePrice();
    }
    
    // Price Calculation
    function calculatePrice() {
        let total = currentDesign.basePrice;
        
        if (currentDesign.fabric) {
            total += currentDesign.fabric.price;
        }
        
        if (currentDesign.embroidery) {
            total += currentDesign.embroidery.price;
        }
        
        // Update price display
        document.getElementById('design-price').textContent = `Rs. ${total.toLocaleString()}`;
        document.getElementById('summary-price').textContent = `Rs. ${total.toLocaleString()}`;
        
        // Show summary FAB if any selection is made
        if (currentDesign.fabric || currentDesign.color || currentDesign.embroidery) {
            document.getElementById('designSummary').classList.remove('hidden');
        }
    }
    
    // Update Summary
    function updateDesignSummary() {
        const fabricEl = document.getElementById('summary-fabric');
        const colorEl = document.getElementById('summary-color');
        const embroideryEl = document.getElementById('summary-embroidery');
        
        // Update fabric summary
        if (currentDesign.fabric) {
            fabricEl.innerHTML = `<span class="font-medium">Fabric:</span> ${currentDesign.fabric.name} <span class="text-pink-600">(+Rs. ${currentDesign.fabric.price.toLocaleString()})</span>`;
        } else {
            fabricEl.textContent = 'No fabric selected';
        }
        
        // Update color summary
        if (currentDesign.color) {
            colorEl.innerHTML = `<span class="font-medium">Color:</span> <span class="inline-block w-3 h-3 rounded-full mr-1 align-middle" style="background-color:${currentDesign.color}"></span> ${currentDesign.color}`;
        } else {
            colorEl.textContent = 'No color selected';
        }
        
        // Update embroidery summary
        if (currentDesign.embroidery) {
            embroideryEl.innerHTML = `<span class="font-medium">Embroidery:</span> ${currentDesign.embroidery.name} <span class="text-pink-600">(+Rs. ${currentDesign.embroidery.price.toLocaleString()})</span>`;
        } else {
            embroideryEl.textContent = 'No embroidery selected';
        }
        
        // Also update selected options in design canvas section
        const selectedFabricEl = document.getElementById('selected-fabric');
        const selectedColorEl = document.getElementById('selected-color');
        const selectedEmbroideryEl = document.getElementById('selected-embroidery');
        
        if (currentDesign.fabric) {
            selectedFabricEl.innerHTML = `<span class="font-medium">Fabric:</span> ${currentDesign.fabric.name}`;
        } else {
            selectedFabricEl.textContent = 'No fabric selected';
        }
        
        if (currentDesign.color) {
            selectedColorEl.innerHTML = `<span class="font-medium">Color:</span> ${currentDesign.color}`;
        } else {
            selectedColorEl.textContent = 'No color selected';
        }
        
        if (currentDesign.embroidery) {
            selectedEmbroideryEl.innerHTML = `<span class="font-medium">Embroidery:</span> ${currentDesign.embroidery.name}`;
        } else {
            selectedEmbroideryEl.textContent = 'No embroidery selected';
        }
    }
    
    function closeSummary() {
        document.getElementById('designSummary').classList.add('hidden');
    }
    
    // Save Design
    function saveDesign() {
        if (!currentDesign.fabric) {
            showNotification('Please select a fabric first', 'error');
            return;
        }
        
        // Show loading
        showNotification('Saving your design...', 'info');
        
        // In a real implementation, this would send to server
        // For now, simulate saving
        setTimeout(() => {
            showNotification('Design saved successfully! Our designer will contact you for consultation.', 'success');
            
            // Reset selections after saving
            resetDesign();
        }, 1500);
    }
    
    function resetDesign() {
        // Reset current design
        currentDesign = {
            fabric: null,
            color: null,
            embroidery: null,
            basePrice: 15000
        };
        
        // Reset UI
        document.querySelectorAll('.customization-option').forEach(el => el.classList.remove('selected'));
        document.getElementById('fabric-overlay').style.backgroundImage = 'none';
        document.getElementById('color-overlay').style.backgroundColor = 'transparent';
        document.getElementById('embellishment-layer').style.backgroundImage = 'none';
        document.getElementById('designSummary').classList.add('hidden');
        document.getElementById('design-price').textContent = 'Rs. 15,000';
        updateDesignSummary();
    }
    
    // FAQ Toggle
    document.querySelectorAll('.faq-question').forEach(button => {
        button.addEventListener('click', () => {
            const answer = button.nextElementSibling;
            const icon = button.querySelector('svg');
            
            answer.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        });
    });
    
    // Consultation Form Submission
    document.getElementById('consultationForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const button = this.querySelector('button[type="submit"]');
        const originalText = button.textContent;
        
        button.textContent = 'Booking...';
        button.disabled = true;
        
        // Simulate API call
        setTimeout(() => {
            showNotification('Consultation booked successfully! Our team will contact you within 24 hours.', 'success');
            closeDesignModal();
            button.textContent = originalText;
            button.disabled = false;
            this.reset();
        }, 2000);
    });
    
    // Notification Function
    function showNotification(message, type) {
        // Remove existing notifications
        const existingNotifications = document.querySelectorAll('.custom-notification');
        existingNotifications.forEach(notification => {
            notification.remove();
        });
        
        const notification = document.createElement('div');
        notification.className = `custom-notification fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white transform transition-all duration-300 translate-x-full ${
            type === 'success' ? 'bg-green-500' : 
            type === 'error' ? 'bg-red-500' : 
            'bg-blue-500'
        }`;
        notification.textContent = message;
        
        // Add close button
        const closeBtn = document.createElement('button');
        closeBtn.innerHTML = '&times;';
        closeBtn.className = 'ml-4 text-white hover:text-gray-200';
        closeBtn.onclick = () => notification.remove();
        notification.appendChild(closeBtn);
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    notification.remove();
                }
            }, 300);
        }, 5000);
    }
    
    // Close modal on outside click
    document.getElementById('designModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDesignModal();
        }
    });
    
    // Close summary when clicking outside
    document.addEventListener('click', function(e) {
        const summary = document.getElementById('designSummary');
        if (!summary.contains(e.target) && !e.target.closest('.customization-option')) {
            if (currentDesign.fabric || currentDesign.color || currentDesign.embroidery) {
                // Don't close if we have selections
                return;
            }
        }
    });
</script>

<!-- Add some demo data initialization -->
<script>
    // Initialize with some default selections for demo
    document.addEventListener('DOMContentLoaded', function() {
        // You can add any initialization here
        // For example, select first fabric by default
        // const firstFabric = document.querySelector('.fabric-swatch');
        // if (firstFabric) selectFabric(firstFabric);
    });
</script>

<script>
    // Global booking state
    const bookingState = {
        sessionType: null,
        stylist: null,
        date: null,
        time: null,
        price: 0
    };
    
    // Calendar state
    let currentMonth = new Date().getMonth();
    let currentYear = new Date().getFullYear();
    
    // Initialize calendar
    document.addEventListener('DOMContentLoaded', function() {
        generateCalendar(currentMonth, currentYear);
        updateMonthDisplay();
        
        // Show floating CTA after 10 seconds
        setTimeout(() => {
            document.getElementById('floatingBookingCTA').classList.remove('hidden');
        }, 10000);
    });
    
    // Generate calendar grid
    function generateCalendar(month, year) {
        const calendarGrid = document.getElementById('calendar-grid');
        calendarGrid.innerHTML = '';
        
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const daysInMonth = lastDay.getDate();
        const startingDay = firstDay.getDay();
        
        const today = new Date();
        const isToday = (day) => {
            return day === today.getDate() && 
                   month === today.getMonth() && 
                   year === today.getFullYear();
        };
        
        // Add empty cells for days before the first day of month
        for (let i = 0; i < startingDay; i++) {
            const emptyDay = document.createElement('div');
            emptyDay.className = 'calendar-day disabled';
            calendarGrid.appendChild(emptyDay);
        }
        
        // Add days of the month
        for (let day = 1; day <= daysInMonth; day++) {
            const dayElement = document.createElement('div');
            dayElement.className = 'calendar-day';
            
            // Check if date is in the past
            const date = new Date(year, month, day);
            const isPast = date < today.setHours(0, 0, 0, 0);
            
            // Check if date is weekend (Saturday or Sunday)
            const dayOfWeek = date.getDay();
            const isWeekend = dayOfWeek === 0 || dayOfWeek === 6;
            
            // Check if date has available slots (simulated)
            const hasSlots = Math.random() > 0.3; // 70% chance of having slots
            
            if (isPast) {
                dayElement.classList.add('disabled');
            } else if (isToday(day)) {
                dayElement.classList.add('today');
            } else if (!hasSlots || isWeekend) {
                dayElement.classList.add('disabled');
            }
            
            dayElement.innerHTML = `
                <div class="calendar-day-number">${day}</div>
                <div class="calendar-day-label">${getDayLabel(dayOfWeek)}</div>
            `;
            
            if (!isPast && hasSlots && !isWeekend) {
                dayElement.onclick = () => selectDate(year, month, day);
            }
            
            // Mark as selected if matches current booking
            if (bookingState.date && 
                bookingState.date.getDate() === day && 
                bookingState.date.getMonth() === month && 
                bookingState.date.getFullYear() === year) {
                dayElement.classList.add('selected');
            }
            
            calendarGrid.appendChild(dayElement);
        }
    }
    
    function getDayLabel(dayIndex) {
        const labels = ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'];
        return labels[dayIndex];
    }
    
    function changeMonth(direction) {
        currentMonth += direction;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        } else if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        generateCalendar(currentMonth, currentYear);
        updateMonthDisplay();
    }
    
    function updateMonthDisplay() {
        const monthNames = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];
        document.getElementById('current-month').textContent = 
            `${monthNames[currentMonth]} ${currentYear}`;
    }
    
    function selectDate(year, month, day) {
        bookingState.date = new Date(year, month, day);
        
        // Update calendar selection
        document.querySelectorAll('.calendar-day').forEach(dayEl => {
            dayEl.classList.remove('selected');
        });
        
        event.target.closest('.calendar-day').classList.add('selected');
        
        // Update date display
        const dateStr = bookingState.date.toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        document.getElementById('selected-date-display').textContent = dateStr;
        document.getElementById('summary-date').textContent = 
            bookingState.date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
        
        // Generate time slots
        generateTimeSlots();
        
        updateBookingSummary();
        checkBookingComplete();
    }
    
    function generateTimeSlots() {
        const container = document.getElementById('time-slots-container');
        container.innerHTML = '';
        
        // Generate time slots from 10 AM to 8 PM
        const timeSlots = [];
        for (let hour = 10; hour <= 20; hour++) {
            // Create slots every 30 minutes
            for (let minute of [0, 30]) {
                // Skip some slots randomly to simulate booked slots
                if (Math.random() > 0.6) continue;
                
                const timeStr = `${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;
                const displayTime = `${hour > 12 ? hour - 12 : hour}:${minute.toString().padStart(2, '0')} ${hour >= 12 ? 'PM' : 'AM'}`;
                
                const slot = document.createElement('div');
                slot.className = 'time-slot';
                slot.innerHTML = `
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-medium">${displayTime}</span>
                    </div>
                    <div class="text-sm text-gray-500">30 min session</div>
                `;
                
                slot.onclick = () => selectTimeSlot(slot, timeStr, displayTime);
                
                // Mark some slots as booked
                if (Math.random() > 0.7) {
                    slot.classList.add('booked');
                    slot.onclick = null;
                }
                
                container.appendChild(slot);
            }
        }
        
        if (container.children.length === 0) {
            container.innerHTML = `
                <div class="text-center py-8 text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p>No slots available for this date</p>
                    <p class="text-sm mt-1">Please select another date</p>
                </div>
            `;
        }
    }
    
    function selectTimeSlot(slotElement, timeValue, displayTime) {
        // Remove selected class from all slots
        document.querySelectorAll('.time-slot').forEach(slot => {
            slot.classList.remove('selected', 'pulse-animation');
        });
        
        // Add selected class to clicked slot
        slotElement.classList.add('selected', 'pulse-animation');
        
        // Remove pulse animation after 2 seconds
        setTimeout(() => {
            slotElement.classList.remove('pulse-animation');
        }, 2000);
        
        bookingState.time = timeValue;
        document.getElementById('summary-time').textContent = displayTime;
        
        updateBookingSummary();
        checkBookingComplete();
    }
    
    function selectSessionType(type) {
        bookingState.sessionType = type;
        
        // Remove selected class from all session cards
        document.querySelectorAll('.session-type-card').forEach(card => {
            card.classList.remove('selected');
        });
        
        // Add selected class to clicked card
        document.getElementById(`${type}-session`).classList.add('selected');
        
        // Update price based on session type
        switch(type) {
            case 'personal':
                bookingState.price = 999;
                break;
            case 'group':
                bookingState.price = 1999;
                break;
            case 'bridal':
                bookingState.price = 2999;
                break;
        }
        
        document.getElementById('summary-session-type').textContent = 
            type === 'personal' ? 'Personal Styling' :
            type === 'group' ? 'Group Shopping' : 'Bridal Consultation';
        
        updateBookingSummary();
        checkBookingComplete();
    }
    
    function selectStylist(id) {
        bookingState.stylist = id;
        
        // Remove selected class from all stylist cards
        document.querySelectorAll('.stylist-card').forEach(card => {
            card.classList.remove('selected');
        });
        
        // Add selected class to clicked card
        document.getElementById(`stylist-${id}`).classList.add('selected');
        
        // Update stylist name in summary
        const stylistNames = {
            1: 'Aisha Khan',
            2: 'Rahul Verma',
            3: 'Priya Sharma'
        };
        document.getElementById('summary-stylist').textContent = stylistNames[id];
        
        updateBookingSummary();
        checkBookingComplete();
    }
    
    function updateBookingSummary() {
        // Update total price
        if (bookingState.price > 0) {
            document.getElementById('summary-total').textContent = `Rs. ${bookingState.price}`;
        }
        
        // Show floating CTA if at least one selection is made
        if (bookingState.sessionType || bookingState.stylist || bookingState.date) {
            document.getElementById('floatingBookingCTA').classList.remove('hidden');
        }
    }
    
    function checkBookingComplete() {
        const isComplete = bookingState.sessionType && 
                          bookingState.stylist && 
                          bookingState.date && 
                          bookingState.time;
        
        const confirmBtn = document.getElementById('confirm-booking-btn');
        if (isComplete) {
            confirmBtn.disabled = false;
            confirmBtn.innerHTML = 'Confirm Booking';
        } else {
            confirmBtn.disabled = true;
            confirmBtn.innerHTML = 'Complete Selection';
        }
    }
    
    function confirmBooking() {
        if (!bookingState.sessionType || !bookingState.stylist || !bookingState.date || !bookingState.time) {
            showNotification('Please complete all selections before booking', 'error');
            return;
        }
        
        // Show loading state
        const confirmBtn = document.getElementById('confirm-booking-btn');
        confirmBtn.innerHTML = '<span class="loading-dots"><span></span><span></span><span></span></span>';
        confirmBtn.disabled = true;
        
        // Simulate API call
        setTimeout(() => {
            // Show success modal
            const modal = document.getElementById('successModal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            // Update confirmation details
            const stylistNames = {
                1: 'Aisha Khan',
                2: 'Rahul Verma',
                3: 'Priya Sharma'
            };
            
            const dateStr = bookingState.date.toLocaleDateString('en-US', {
                weekday: 'short',
                month: 'short',
                day: 'numeric'
            });
            
            const timeStr = bookingState.time;
            const [hours, minutes] = timeStr.split(':');
            const displayTime = `${hours > 12 ? hours - 12 : hours}:${minutes} ${hours >= 12 ? 'PM' : 'AM'}`;
            
            document.getElementById('confirmation-datetime').textContent = 
                `${dateStr} • ${displayTime}`;
            document.getElementById('confirmation-stylist').textContent = 
                stylistNames[bookingState.stylist];
            
            // Reset booking state
            resetBooking();
            
            // Create confetti effect
            createConfetti();
            
        }, 1500);
    }
    
    function resetBooking() {
        // Reset state
        bookingState.sessionType = null;
        bookingState.stylist = null;
        bookingState.date = null;
        bookingState.time = null;
        bookingState.price = 0;
        
        // Reset UI
        document.querySelectorAll('.session-type-card').forEach(card => {
            card.classList.remove('selected');
        });
        document.querySelectorAll('.stylist-card').forEach(card => {
            card.classList.remove('selected');
        });
        document.querySelectorAll('.calendar-day').forEach(day => {
            day.classList.remove('selected');
        });
        document.querySelectorAll('.time-slot').forEach(slot => {
            slot.classList.remove('selected');
        });
        
        // Reset summary
        document.getElementById('summary-session-type').textContent = 'Not selected';
        document.getElementById('summary-stylist').textContent = 'Not selected';
        document.getElementById('summary-date').textContent = 'Not selected';
        document.getElementById('summary-time').textContent = 'Not selected';
        document.getElementById('summary-total').textContent = 'Rs. 0';
        document.getElementById('selected-date-display').textContent = 'Select a date';
        
        // Reset time slots container
        document.getElementById('time-slots-container').innerHTML = `
            <div class="text-center py-8 text-gray-500">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p>Select a date to view available time slots</p>
            </div>
        `;
        
        // Hide floating CTA
        document.getElementById('floatingBookingCTA').classList.add('hidden');
    }
    
    function closeSuccessModal() {
        const modal = document.getElementById('successModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        
        // Reset confirm button
        const confirmBtn = document.getElementById('confirm-booking-btn');
        confirmBtn.innerHTML = 'Confirm Booking';
        confirmBtn.disabled = true;
    }
    
    function scrollToBooking() {
        document.getElementById('book-now').scrollIntoView({ 
            behavior: 'smooth' 
        });
    }
    
    function createConfetti() {
        const colors = ['#ec4899', '#8b5cf6', '#f472b6', '#a855f7', '#d946ef'];
        
        for (let i = 0; i < 100; i++) {
            const confetti = document.createElement('div');
            confetti.className = 'confetti';
            confetti.style.left = `${Math.random() * 100}vw`;
            confetti.style.top = '-10px';
            confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
            confetti.style.transform = `rotate(${Math.random() * 360}deg)`;
            confetti.style.width = `${Math.random() * 10 + 5}px`;
            confetti.style.height = confetti.style.width;
            
            document.body.appendChild(confetti);
            
            // Animate confetti
            const animation = confetti.animate([
                { 
                    top: '-10px', 
                    opacity: 1, 
                    transform: `rotate(0deg) translateX(0)` 
                },
                { 
                    top: `${Math.random() * 100 + 100}vh`, 
                    opacity: 0, 
                    transform: `rotate(${Math.random() * 720}deg) translateX(${Math.random() * 200 - 100}px)` 
                }
            ], {
                duration: Math.random() * 3000 + 2000,
                easing: 'cubic-bezier(0.215, 0.610, 0.355, 1)'
            });
            
            animation.onfinish = () => confetti.remove();
        }
    }
    
    // FAQ functionality
    document.querySelectorAll('.faq-question').forEach(button => {
        button.addEventListener('click', () => {
            const answer = button.nextElementSibling;
            const icon = button.querySelector('svg');
            
            answer.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        });
    });
    
    // Notification function
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white transform transition-all duration-300 translate-x-full ${
            type === 'error' ? 'bg-red-500' : 'bg-green-500'
        }`;
        notification.textContent = message;
        
        // Add close button
        const closeBtn = document.createElement('button');
        closeBtn.innerHTML = '&times;';
        closeBtn.className = 'ml-4 text-white hover:text-gray-200';
        closeBtn.onclick = () => notification.remove();
        notification.appendChild(closeBtn);
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (document.body.contains(notification)) {
                    notification.remove();
                }
            }, 300);
        }, 5000);
    }
    
    // Close success modal on outside click
    document.getElementById('successModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeSuccessModal();
        }
    });
</script>
@endsection

