@extends('layout.web.main-layout')

@section('title', 'About Us - Aiman Royale Luxury Fashion')

@section('content')
<!-- About Us Page - 5 Sections with Pink/Secondary Theme -->
<section class="relative overflow-hidden bg-[#FFFBF5]">
    
    <!-- SECTION 1: Hero Banner with Story Introduction -->
    <div class="relative min-h-[70vh] flex items-center">
        <!-- Background with overlay -->
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-r from-secondary/90 via-secondary/70 to-transparent z-10"></div>
            <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1445205170230-053b83016050?w=1600')] bg-cover bg-center bg-no-repeat"></div>
        </div>
        
        <div class="container mx-auto px-6 md:px-10 lg:px-16 relative z-20 py-20 md:py-28">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-md border border-white/30 mb-6">
                    <span class="w-1.5 h-1.5 rounded-full bg-secondary-light animate-pulse"></span>
                    <span class="text-xs font-semibold tracking-[0.2em] uppercase text-white">Our Legacy Since 2012</span>
                </div>
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-white leading-tight mb-6">
                    Where <span class="text-secondary-light">Tradition</span><br>
                    Meets Modern Elegance
                </h1>
                <p class="text-base md:text-lg text-white/90 max-w-2xl leading-relaxed mb-8">
                    We don't just create fashion — we craft stories, preserve heritage, and redefine luxury for the contemporary connoisseur.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="#journey" class="inline-flex items-center gap-2 px-6 py-3 bg-primary hover:bg-secondary text-white font-semibold rounded-full transition-all duration-300 shadow-lg hover:shadow-xl">
                        <span>Discover Our Journey</span>
                        <i class="fas fa-arrow-right text-sm"></i>
                    </a>
                    <a href="#collection" class="inline-flex items-center gap-2 px-6 py-3 bg-white/10 backdrop-blur-sm border border-white/30 hover:bg-white/20 text-white font-semibold rounded-full transition-all duration-300">
                        <span>Explore Collection</span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Scroll indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce z-20">
            <div class="w-6 h-10 border-2 border-white/50 rounded-full flex justify-center">
                <div class="w-1 h-2 bg-white/70 rounded-full mt-2 animate-pulse"></div>
            </div>
        </div>
    </div>

    <!-- SECTION 2: Our Story & Philosophy -->
    <div id="journey" class="py-20 md:py-28 lg:py-32 relative">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 right-0 w-96 h-96 bg-secondary-light/30 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-secondary/10 rounded-full blur-3xl"></div>
        </div>
        
        <div class="container mx-auto px-6 md:px-10 lg:px-16 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <!-- Left Side - Content -->
                <div>
                    <div class="mb-6">
                        <span class="inline-block px-4 py-1.5 bg-secondary-light/30 text-secondary text-xs font-semibold tracking-wider rounded-full border border-secondary/20">Our Philosophy</span>
                    </div>
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-stone-800 mb-6 leading-tight">
                        Crafting <span class="text-secondary">Excellence</span><br>
                        Since A Decade
                    </h2>
                    <div class="w-16 h-0.5 bg-gradient-to-r from-secondary to-secondary-light mb-6"></div>
                    <p class="text-stone-600 text-base md:text-lg leading-relaxed mb-4">
                        Founded in 2012, Aiman Royale emerged from a passionate vision to bridge the gap between traditional craftsmanship and contemporary luxury. What started as a small atelier in the heart of Mumbai has now blossomed into a celebrated fashion house.
                    </p>
                    <p class="text-stone-600 text-base md:text-lg leading-relaxed mb-6">
                        Every creation tells a story — of meticulous hand-embroidery, of fabric sourced from the finest mills, and of a relentless pursuit of perfection. Our designs don't just follow trends; they set benchmarks for elegance.
                    </p>
                    <div class="flex flex-wrap gap-6 mt-8">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-secondary/10 flex items-center justify-center">
                                <i class="fas fa-award text-secondary text-xl"></i>
                            </div>
                            <div>
                                <div class="font-bold text-2xl text-stone-800">15+</div>
                                <div class="text-sm text-stone-500">Industry Awards</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-secondary/10 flex items-center justify-center">
                                <i class="fas fa-users text-secondary text-xl"></i>
                            </div>
                            <div>
                                <div class="font-bold text-2xl text-stone-800">50k+</div>
                                <div class="text-sm text-stone-500">Happy Clients</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-secondary/10 flex items-center justify-center">
                                <i class="fas fa-globe text-secondary text-xl"></i>
                            </div>
                            <div>
                                <div class="font-bold text-2xl text-stone-800">25+</div>
                                <div class="text-sm text-stone-500">Countries Served</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Side - Image Grid -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-4">
                        <div class="rounded-2xl overflow-hidden shadow-xl group">
                            <img src="https://images.unsplash.com/photo-1539109136881-3be0616acf4b?w=600" alt="Fashion Design" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="rounded-2xl overflow-hidden shadow-xl group">
                            <img src="https://images.unsplash.com/photo-1509631179647-0177331693ae?w=600" alt="Fabric Selection" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                    </div>
                    <div class="space-y-4 pt-8">
                        <div class="rounded-2xl overflow-hidden shadow-xl group">
                            <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?w=600" alt="Boutique" class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="rounded-2xl overflow-hidden shadow-xl group">
                            <img src="https://images.unsplash.com/photo-1567401893414-76b7b1e5a7a5?w=600" alt="Design Process" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 3: Our Values - 4 Pillars -->
    <div class="py-20 md:py-28 bg-gradient-to-br from-secondary-light/30 via-white to-secondary/5 relative">
        <div class="container mx-auto px-6 md:px-10 lg:px-16">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="inline-block px-4 py-1.5 bg-white text-secondary text-xs font-semibold tracking-wider rounded-full border border-secondary/20 shadow-sm">Core Values</span>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-stone-800 mt-5 mb-4">
                    The <span class="text-secondary">Pillars</span> of Our Promise
                </h2>
                <div class="w-20 h-0.5 bg-gradient-to-r from-secondary via-secondary-light to-secondary mx-auto"></div>
                <p class="text-stone-600 mt-5 text-lg">What guides every decision, every stitch, and every smile at Aiman Royale.</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Value 1 -->
                <div class="group text-center">
                    <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-secondary/10 to-secondary-light/30 flex items-center justify-center mx-auto mb-5 group-hover:scale-110 transition-all duration-300 shadow-md group-hover:shadow-xl">
                        <i class="fas fa-gem text-4xl text-secondary"></i>
                    </div>
                    <h3 class="text-xl font-bold text-stone-800 mb-3">Authenticity</h3>
                    <p class="text-stone-600 text-sm leading-relaxed">100% genuine materials sourced ethically. Every piece carries a certificate of authenticity.</p>
                </div>
                
                <!-- Value 2 -->
                <div class="group text-center">
                    <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-secondary/10 to-secondary-light/30 flex items-center justify-center mx-auto mb-5 group-hover:scale-110 transition-all duration-300 shadow-md group-hover:shadow-xl">
                        <i class="fas fa-hand-sparkles text-4xl text-secondary"></i>
                    </div>
                    <h3 class="text-xl font-bold text-stone-800 mb-3">Artisanship</h3>
                    <p class="text-stone-600 text-sm leading-relaxed">Master craftsmen with decades of experience. Hand-finished details in every creation.</p>
                </div>
                
                <!-- Value 3 -->
                <div class="group text-center">
                    <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-secondary/10 to-secondary-light/30 flex items-center justify-center mx-auto mb-5 group-hover:scale-110 transition-all duration-300 shadow-md group-hover:shadow-xl">
                        <i class="fas fa-leaf text-4xl text-secondary"></i>
                    </div>
                    <h3 class="text-xl font-bold text-stone-800 mb-3">Sustainability</h3>
                    <p class="text-stone-600 text-sm leading-relaxed">Eco-conscious practices, zero-waste cutting, and biodegradable packaging.</p>
                </div>
                
                <!-- Value 4 -->
                <div class="group text-center">
                    <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-secondary/10 to-secondary-light/30 flex items-center justify-center mx-auto mb-5 group-hover:scale-110 transition-all duration-300 shadow-md group-hover:shadow-xl">
                        <i class="fas fa-concierge-bell text-4xl text-secondary"></i>
                    </div>
                    <h3 class="text-xl font-bold text-stone-800 mb-3">Excellence</h3>
                    <p class="text-stone-600 text-sm leading-relaxed">White-glove service, from personalized styling to after-sales care.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 4: Milestones & Achievements Timeline -->
    <div id="collection" class="py-20 md:py-28 relative">
        <div class="container mx-auto px-6 md:px-10 lg:px-16">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="inline-block px-4 py-1.5 bg-secondary-light/30 text-secondary text-xs font-semibold tracking-wider rounded-full border border-secondary/20">Our Journey</span>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-stone-800 mt-5 mb-4">
                    Milestones of <span class="text-secondary">Excellence</span>
                </h2>
                <div class="w-20 h-0.5 bg-gradient-to-r from-secondary via-secondary-light to-secondary mx-auto"></div>
                <p class="text-stone-600 mt-5 text-lg">Celebrating a decade of passion, creativity, and unparalleled craftsmanship.</p>
            </div>
            
            <div class="relative">
                <!-- Timeline Line -->
                <div class="absolute left-1/2 transform -translate-x-1/2 w-0.5 h-full bg-gradient-to-b from-secondary via-secondary-light to-secondary hidden lg:block"></div>
                
                <div class="space-y-12 lg:space-y-0">
                    <!-- 2012 -->
                    <div class="flex flex-col lg:flex-row items-center gap-8 lg:gap-12 mb-12">
                        <div class="lg:w-1/2 lg:text-right">
                            <div class="bg-white rounded-2xl p-6 shadow-lg border-l-4 border-secondary hover:shadow-xl transition-all duration-300">
                                <span class="text-3xl font-bold text-secondary">2012</span>
                                <h3 class="text-xl font-bold text-stone-800 mt-2 mb-3">The Humble Beginning</h3>
                                <p class="text-stone-600 text-sm">Aiman Royale opens its first atelier in Mumbai with just 5 artisans and a dream to redefine ethnic luxury.</p>
                            </div>
                        </div>
                        <div class="lg:w-12 flex justify-center">
                            <div class="w-12 h-12 rounded-full bg-secondary text-white flex items-center justify-center z-10 shadow-lg">
                                <i class="fas fa-store text-sm"></i>
                            </div>
                        </div>
                        <div class="lg:w-1/2"></div>
                    </div>
                    
                    <!-- 2015 -->
                    <div class="flex flex-col lg:flex-row items-center gap-8 lg:gap-12 mb-12">
                        <div class="lg:w-1/2"></div>
                        <div class="lg:w-12 flex justify-center">
                            <div class="w-12 h-12 rounded-full bg-secondary-light text-secondary flex items-center justify-center z-10 shadow-lg">
                                <i class="fas fa-award text-sm"></i>
                            </div>
                        </div>
                        <div class="lg:w-1/2">
                            <div class="bg-white rounded-2xl p-6 shadow-lg border-r-4 border-secondary-light hover:shadow-xl transition-all duration-300">
                                <span class="text-3xl font-bold text-secondary">2015</span>
                                <h3 class="text-xl font-bold text-stone-800 mt-2 mb-3">First Major Award</h3>
                                <p class="text-stone-600 text-sm">Recipient of the "Emerging Designer of the Year" at India Fashion Week, putting Aiman Royale on the national map.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- 2018 -->
                    <div class="flex flex-col lg:flex-row items-center gap-8 lg:gap-12 mb-12">
                        <div class="lg:w-1/2 lg:text-right">
                            <div class="bg-white rounded-2xl p-6 shadow-lg border-l-4 border-secondary hover:shadow-xl transition-all duration-300">
                                <span class="text-3xl font-bold text-secondary">2018</span>
                                <h3 class="text-xl font-bold text-stone-800 mt-2 mb-3">Flagship Boutique Launch</h3>
                                <p class="text-stone-600 text-sm">Opened our flagship store in Mumbai's luxury district, featuring exclusive bridal and couture collections.</p>
                            </div>
                        </div>
                        <div class="lg:w-12 flex justify-center">
                            <div class="w-12 h-12 rounded-full bg-secondary text-white flex items-center justify-center z-10 shadow-lg">
                                <i class="fas fa-store-alt text-sm"></i>
                            </div>
                        </div>
                        <div class="lg:w-1/2"></div>
                    </div>
                    
                    <!-- 2021 -->
                    <div class="flex flex-col lg:flex-row items-center gap-8 lg:gap-12 mb-12">
                        <div class="lg:w-1/2"></div>
                        <div class="lg:w-12 flex justify-center">
                            <div class="w-12 h-12 rounded-full bg-secondary-light text-secondary flex items-center justify-center z-10 shadow-lg">
                                <i class="fas fa-globe text-sm"></i>
                            </div>
                        </div>
                        <div class="lg:w-1/2">
                            <div class="bg-white rounded-2xl p-6 shadow-lg border-r-4 border-secondary-light hover:shadow-xl transition-all duration-300">
                                <span class="text-3xl font-bold text-secondary">2021</span>
                                <h3 class="text-xl font-bold text-stone-800 mt-2 mb-3">Global Expansion</h3>
                                <p class="text-stone-600 text-sm">Launched international shipping, reaching fashion enthusiasts across 15+ countries worldwide.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- 2024 -->
                    <div class="flex flex-col lg:flex-row items-center gap-8 lg:gap-12">
                        <div class="lg:w-1/2 lg:text-right">
                            <div class="bg-white rounded-2xl p-6 shadow-lg border-l-4 border-secondary hover:shadow-xl transition-all duration-300">
                                <span class="text-3xl font-bold text-secondary">2024</span>
                                <h3 class="text-xl font-bold text-stone-800 mt-2 mb-3">Digital Atelier</h3>
                                <p class="text-stone-600 text-sm">Launched virtual consultations and 3D fitting rooms, bringing personalized luxury to digital screens.</p>
                            </div>
                        </div>
                        <div class="lg:w-12 flex justify-center">
                            <div class="w-12 h-12 rounded-full bg-secondary text-white flex items-center justify-center z-10 shadow-lg">
                                <i class="fas fa-laptop text-sm"></i>
                            </div>
                        </div>
                        <div class="lg:w-1/2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION 5: Team & CTA -->
    <div class="py-20 md:py-28 bg-stone-900 relative overflow-hidden">
        <!-- Background pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23FFFFFF" fill-opacity="0.1"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]"></div>
        </div>
        
        <div class="container mx-auto px-6 md:px-10 lg:px-16 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="inline-block px-4 py-1.5 bg-white/10 backdrop-blur text-secondary-light text-xs font-semibold tracking-wider rounded-full border border-white/20">The Faces Behind the Magic</span>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mt-5 mb-4">
                    Meet Our <span class="text-secondary-light">Visionaries</span>
                </h2>
                <div class="w-20 h-0.5 bg-gradient-to-r from-secondary via-secondary-light to-secondary mx-auto"></div>
                <p class="text-stone-300 mt-5 text-lg">A team of passionate designers, master craftsmen, and dedicated stylists.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <!-- Team Member 1 -->
                <div class="group">
                    <div class="relative rounded-2xl overflow-hidden mb-5">
                        <img src="https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=600" alt="Creative Director" class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-stone-900 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-1">Aiman Khan</h3>
                    <p class="text-secondary-light text-sm mb-3">Founder & Creative Director</p>
                    <p class="text-stone-400 text-sm leading-relaxed">With a vision to revive traditional crafts, Aiman leads the creative soul of the brand.</p>
                </div>
                
                <!-- Team Member 2 -->
                <div class="group">
                    <div class="relative rounded-2xl overflow-hidden mb-5">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600" alt="Master Craftsman" class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-stone-900 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-1">Rajesh Sharma</h3>
                    <p class="text-secondary-light text-sm mb-3">Master Craftsman</p>
                    <p class="text-stone-400 text-sm leading-relaxed">30+ years of experience in hand-embroidery and traditional techniques.</p>
                </div>
                
                <!-- Team Member 3 -->
                <div class="group">
                    <div class="relative rounded-2xl overflow-hidden mb-5">
                        <img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?w=600" alt="Head Stylist" class="w-full h-80 object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-stone-900 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-1">Priya Mehta</h3>
                    <p class="text-secondary-light text-sm mb-3">Head Stylist</p>
                    <p class="text-stone-400 text-sm leading-relaxed">Award-winning stylist curating looks for celebrities and bridal couture.</p>
                </div>
            </div>
            
            <!-- CTA Button -->
            <div class="text-center">
                <div class="inline-block p-0.5 bg-gradient-to-r from-secondary via-secondary-light to-secondary rounded-full">
                    <a href="" class="inline-flex items-center gap-3 px-8 py-4 bg-stone-900 hover:bg-stone-800 text-white font-semibold rounded-full transition-all duration-300 group">
                        <span>Join the Aiman Royale Family</span>
                        <i class="fas fa-heart text-secondary-light group-hover:scale-110 transition-transform"></i>
                    </a>
                </div>
                <p class="text-stone-400 text-sm mt-6">Experience luxury that speaks to your soul. Book a personal consultation today.</p>
            </div>
        </div>
    </div>
</section>

<!-- Font Awesome (if not already included) -->
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@endsection