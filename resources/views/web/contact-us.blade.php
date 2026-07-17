@extends('layout.web.main-layout')

@section('title', 'Contact Us - Aiman Royale Luxury Fashion')

@section('content')
<!-- Contact Page - Luxury Fashion Edition with Red/Pink Theme -->
<section class="relative overflow-hidden pt-8 pb-16 md:pb-24 lg:pb-32">
    <!-- Luxury Background Decor - Updated with red/pink tones -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-red-50/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-pink-50/20 rounded-full blur-3xl"></div>
        <div class="absolute top-1/3 left-1/4 w-64 h-64 bg-rose-50/40 rounded-full blur-2xl"></div>
        <!-- Subtle pattern overlay -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23A10000" fill-opacity="0.03"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-30"></div>
    </div>

    <div class="container mx-auto px-6 md:px-10 lg:px-16 relative z-10">
        
        <!-- SECTION 1: Hero Header - Fashion Editorial Style -->
        <div class="text-center max-w-3xl mx-auto mb-16 md:mb-20">
            <div class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-white/80 backdrop-blur-sm border border-primary/30 shadow-sm mb-6">
                <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                <span class="text-xs font-semibold tracking-[0.2em] uppercase text-primary">Concierge Service</span>
            </div>
            <h1 class="font-serif-alt text-4xl md:text-5xl lg:text-6xl font-bold text-stone-900 leading-tight mb-5">
                Let's <span class="text-primary italic">Connect</span> in Style
            </h1>
            <div class="w-20 h-0.5 bg-gradient-to-r from-primary via-secondary to-primary mx-auto my-6 rounded-full"></div>
            <p class="text-base md:text-lg text-stone-600 max-w-2xl mx-auto leading-relaxed">
                From custom tailoring to order help — our fashion experts are just a message away. 
                We reply within <span class="font-semibold text-primary">12 hours</span>.
            </p>
        </div>

        <!-- SECTION 2: Contact Info Cards & Elegant Form -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 xl:gap-14 mb-24">
            
            <!-- LEFT: Luxury Contact Information Cards -->
            <div class="space-y-7">
                <!-- Store Boutique Card -->
                <div class="group bg-white/90 backdrop-blur-sm rounded-3xl shadow-lg border border-[#E8DDD0] p-6 md:p-7 hover:shadow-2xl transition-all duration-500 hover:-translate-y-1.5">
                    <div class="flex items-start gap-5">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-red-50 to-pink-50 flex items-center justify-center text-primary group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-store text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-serif-alt text-xl md:text-2xl font-bold text-stone-800 mb-2">Our Store</h3>
                            <p class="text-stone-600 text-sm leading-relaxed">Islampur, Kadambagachhi,</p>
                            <p class="text-stone-600 text-sm">North 24 Parganas, Kol-700125, West Bengal, India</p>
                        </div>
                    </div>
                </div>

                <!-- Phone Concierge Card -->
                <div class="group bg-white/90 backdrop-blur-sm rounded-3xl shadow-lg border border-[#E8DDD0] p-6 md:p-7 hover:shadow-2xl transition-all duration-500 hover:-translate-y-1.5">
                    <div class="flex items-start gap-5">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-red-50 to-pink-50 flex items-center justify-center text-primary group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-phone-alt text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-serif-alt text-xl md:text-2xl font-bold text-stone-800 mb-2">Call Us</h3>
                            <p class="text-stone-600 text-sm"><span class="font-medium">Support:</span> <a href="tel:+{{env('WH_WHATSAPP_NUMBER')}}" class="hover:text-primary transition-colors">+91 {{env('WH_WHATSAPP_NUMBER')}}</a></p>
                            <p class="text-stone-600 text-sm mt-1"><span class="font-medium">WhatsApp:</span> <a href="https://wa.me/{{env('WH_WHATSAPP_NUMBER')}}" class="hover:text-primary transition-colors">+91 {{env('WH_WHATSAPP_NUMBER')}}</a></p>
                            <div class="flex items-center gap-1.5 mt-4 text-stone-500 text-xs">
                                <i class="far fa-clock"></i>
                                <span>Monday – Saturday, 10:00 AM – 7:00 PM IST</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Email Card -->
                <div class="group bg-white/90 backdrop-blur-sm rounded-3xl shadow-lg border border-[#E8DDD0] p-6 md:p-7 hover:shadow-2xl transition-all duration-500 hover:-translate-y-1.5">
                    <div class="flex items-start gap-5">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-red-50 to-pink-50 flex items-center justify-center text-primary group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-envelope-open-text text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-serif-alt text-xl md:text-2xl font-bold text-stone-800 mb-2">Email Us</h3>
                            <p class="text-stone-600 text-sm"><span class="font-medium">General:</span> <a href="mailto:contact.aimanroyale@gmail.com" class="hover:text-primary transition-colors">contact.aimanroyale@gmail.com</a></p>
                        </div>
                    </div>
                </div>

                <!-- Social Connect - Luxury Edition with red/pink theme -->
                <div class="bg-gradient-to-br from-red-50/80 via-stone-50/90 to-pink-50/80 rounded-3xl p-6 md:p-7 border border-primary/20 shadow-sm">
                    <h3 class="font-serif-alt text-xl font-bold text-center lg:text-left text-stone-800 mb-4">Follow Us</h3>
                    <div class="flex gap-5 justify-center lg:justify-start">
                        <a href="https://www.facebook.com/AimanRoyale" target="_blank" class="w-11 h-11 rounded-full bg-white shadow-sm flex items-center justify-center text-stone-700 hover:bg-[#1877F2] hover:text-white hover:scale-110 transition-all duration-300">
                            <i class="fab fa-facebook-f text-lg"></i>
                        </a>
                        <a href="https://www.instagram.com/aimanroyale/" target="_blank" class="w-11 h-11 rounded-full bg-white shadow-sm flex items-center justify-center text-stone-700 hover:bg-gradient-to-tr hover:from-[#833AB4] hover:via-[#E1306C] hover:to-[#F56040] hover:text-white hover:scale-110 transition-all duration-300">
                            <i class="fab fa-instagram text-lg"></i>
                        </a>
                        <a href="#" class="w-11 h-11 rounded-full bg-white shadow-sm flex items-center justify-center text-stone-700 hover:bg-[#000000] hover:text-white hover:scale-110 transition-all duration-300">
                            <i class="fab fa-tiktok text-lg"></i>
                        </a>
                        <a href="#" class="w-11 h-11 rounded-full bg-white shadow-sm flex items-center justify-center text-stone-700 hover:bg-[#0A66C2] hover:text-white hover:scale-110 transition-all duration-300">
                            <i class="fab fa-linkedin-in text-lg"></i>
                        </a>
                    </div>
                    <p class="text-center lg:text-left text-[11px] text-stone-500 mt-5 tracking-wide">Follow us for daily fashion inspiration and exclusive offers</p>
                </div>
            </div>

            <!-- RIGHT: Luxury Contact Form with red/pink accents -->
            <div class="bg-white rounded-3xl shadow-2xl border border-primary/20 p-7 md:p-9 transition-all hover:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.1)]">
                <div class="mb-7 border-b border-stone-100 pb-4">
                    <h3 class="font-serif-alt text-2xl md:text-3xl font-semibold text-stone-800">Send a <span class="text-primary">Message</span></h3>
                    <p class="text-stone-500 text-sm mt-1">Our style advisors reply within hours.</p>
                </div>

                <form action="{{ route('contact-us.store') }}" method="POST" id="luxuryContactForm" novalidate>
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-stone-700 mb-2">Full Name <span class="text-primary">*</span></label>
                            <input type="text" name="name" id="luxuryName" value="{{ old('name') }}" 
                                class="w-full px-5 py-3.5 rounded-xl border border-stone-200 bg-stone-50/40 focus:bg-white focus:border-primary focus:ring-2 focus:ring-red-200/60 transition-all @error('name') border-red-500 @enderror"
                                placeholder="Your full name">
                            <div id="nameError" class="text-red-500 text-xs mt-1 hidden"></div>
                            @error('name') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-stone-700 mb-2">Mobile (optional)</label>
                            <input type="tel" name="mobile" id="luxuryMobile" value="{{ old('mobile') }}"
                                class="w-full px-5 py-3.5 rounded-xl border border-stone-200 bg-stone-50/40 focus:bg-white focus:border-primary focus:ring-2 focus:ring-red-200/60 transition-all"
                                placeholder="+91 98765 43210">
                            <div id="mobileError" class="text-red-500 text-xs mt-1 hidden"></div>
                            @error('mobile') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-stone-700 mb-2">Email Address <span class="text-primary">*</span></label>
                        <input type="email" name="email" id="luxuryEmail" value="{{ old('email') }}"
                            class="w-full px-5 py-3.5 rounded-xl border border-stone-200 bg-stone-50/40 focus:bg-white focus:border-primary focus:ring-2 focus:ring-red-200/60 transition-all @error('email') border-red-500 @enderror"
                            placeholder="your@email.com">
                        <div id="emailError" class="text-red-500 text-xs mt-1 hidden"></div>
                        @error('email') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-stone-700 mb-2">Inquiry Type <span class="text-primary">*</span></label>
                        <select name="subject" id="luxurySubject" class="w-full px-5 py-3.5 rounded-xl border border-stone-200 bg-stone-50/40 focus:bg-white focus:border-primary focus:ring-2 focus:ring-red-200/60 transition-all cursor-pointer">
                            <option value="">— Select a subject —</option>
                            <option value="order" {{ old('subject') == 'order' ? 'selected' : '' }}>Order & Shipping</option>
                            <option value="product" {{ old('subject') == 'product' ? 'selected' : '' }}>Product Styling Advice</option>
                            <option value="return" {{ old('subject') == 'return' ? 'selected' : '' }}>Return / Exchange</option>
                            <option value="wholesale" {{ old('subject') == 'wholesale' ? 'selected' : '' }}>Wholesale / Private Label</option>
                            <option value="feedback" {{ old('subject') == 'feedback' ? 'selected' : '' }}>Feedback</option>
                            <option value="other" {{ old('subject') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        <div id="subjectError" class="text-red-500 text-xs mt-1 hidden"></div>
                        @error('subject') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-7">
                        <label class="block text-sm font-medium text-stone-700 mb-2">Your Message <span class="text-primary">*</span></label>
                        <textarea name="message" id="luxuryMessage" rows="5" 
                            class="w-full px-5 py-3.5 rounded-xl border border-stone-200 bg-stone-50/40 focus:bg-white focus:border-primary focus:ring-2 focus:ring-red-200/60 transition-all resize-none @error('message') border-red-500 @enderror"
                            placeholder="Tell us about your request...">{{ old('message') }}</textarea>
                        <div id="messageError" class="text-red-500 text-xs mt-1 hidden"></div>
                        @error('message') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-8">
                        <label class="flex items-start gap-3 cursor-pointer group">
                            <input type="checkbox" name="privacy_policy" id="luxuryPrivacy" value="1" {{ old('privacy_policy') ? 'checked' : '' }}
                                class="mt-0.5 w-4.5 h-4.5 rounded border-stone-300 text-primary focus:ring-red-400">
                            <span class="text-xs text-stone-600 leading-relaxed">I agree to the <a href="#" class="text-primary font-medium hover:underline">Privacy Policy</a> and accept that Aiman Royale may contact me.</span>
                        </label>
                        <div id="privacyError" class="text-red-500 text-xs mt-1 hidden"></div>
                        @error('privacy_policy') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div id="formStatusMsg" class="mb-5 text-center text-sm font-medium hidden transition-all"></div>

                    <button type="button" id="submitLuxuryBtn" 
                        class="w-full py-4 bg-primary hover:bg-secondary text-white font-semibold rounded-xl shadow-md hover:shadow-red-900/20 transition-all duration-300 flex items-center justify-center gap-3 group text-base tracking-wide">
                        <span>Send Message</span>
                        <i class="fas fa-feather-alt text-sm group-hover:translate-x-1 transition-transform"></i>
                    </button>
                    
                    <div class="flex items-center justify-center gap-2 text-center text-stone-400 text-[11px] mt-6">
                        <i class="fas fa-lock text-[10px]"></i>
                        <span>Your information is always kept private</span>
                    </div>
                </form>
            </div>
        </div>

        <!-- SECTION 3: FAQ Luxury Accordion Style with red/pink theme -->
        <div class="max-w-5xl mx-auto mt-8">
            <div class="text-center mb-12">
                <span class="inline-block px-4 py-1.5 bg-red-50 text-primary text-xs font-semibold tracking-wider rounded-full uppercase border border-primary/20">Help Guide</span>
                <h2 class="font-serif-alt text-3xl md:text-4xl font-bold text-stone-800 mt-5 mb-3">Frequently Asked Questions</h2>
                <p class="text-stone-500 max-w-2xl mx-auto">Everything you need to know about sizing, shipping, and our services.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-7">
                <!-- FAQ Items -->
                @php
                    $faqs = [
                        ['icon' => 'fa-shipping-fast', 'title' => 'Order tracking & delivery', 'desc' => 'After we ship your order, you\'ll get a tracking link via SMS and email. You can also log in to your account to see real-time updates.'],
                        ['icon' => 'fa-exchange-alt', 'title' => '14-day return policy', 'desc' => 'You can return unused items with original tags within 14 days. Custom orders cannot be returned because they are made just for you.'],
                        ['icon' => 'fa-rupee-sign', 'title' => 'Cash on Delivery?', 'desc' => 'Yes, we offer COD for orders under ₹12,000 (₹50 extra fee). For larger orders, we recommend prepaid payment.'],
                        ['icon' => 'fa-gem', 'title' => 'Quality guarantee', 'desc' => 'All our products are made in our own workshop. We guarantee 100% authentic materials and hand-finished quality.'],
                        ['icon' => 'fa-tshirt', 'title' => 'Size help', 'desc' => 'Our stylists offer free virtual size consultations. Contact us on WhatsApp for personalized size charts.'],
                        ['icon' => 'fa-globe-asia', 'title' => 'International shipping', 'desc' => 'We ship worldwide. Customs duties are calculated at checkout. Delivery takes 7-12 business days.']
                    ];
                @endphp

                @foreach($faqs as $faq)
                <div class="group bg-white/80 backdrop-blur-sm rounded-2xl border border-red-100/60 p-6 shadow-sm hover:shadow-lg hover:border-primary/30 transition-all duration-300">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                            <i class="fas {{ $faq['icon'] }} text-lg"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-stone-800 text-lg mb-1.5">{{ $faq['title'] }}</h4>
                            <p class="text-stone-600 text-sm leading-relaxed">{{ $faq['desc'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Extra Support CTA -->
            <div class="text-center mt-12 pt-6">
                <p class="text-stone-600 inline-flex items-center gap-3 bg-white/60 backdrop-blur-sm px-6 py-3 rounded-full shadow-sm border border-red-100">
                    <i class="fas fa-headset text-primary"></i>
                    <span>Still have questions?</span>
                    <a href="#" class="font-semibold text-primary hover:underline transition-all">Chat with us →</a>
                </p>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
// Luxury Contact Form Validation & AJAX Submission
document.addEventListener('DOMContentLoaded', function() {
    const submitBtn = document.getElementById('submitLuxuryBtn');
    if (submitBtn) {
        submitBtn.addEventListener('click', validateAndSubmitLuxuryContact);
    }
});

function validateAndSubmitLuxuryContact() {
    clearLuxuryErrors();
    hideLuxuryFormStatus();

    const name = document.getElementById('luxuryName')?.value.trim() || '';
    const email = document.getElementById('luxuryEmail')?.value.trim() || '';
    const subject = document.getElementById('luxurySubject')?.value || '';
    const message = document.getElementById('luxuryMessage')?.value.trim() || '';
    const mobile = document.getElementById('luxuryMobile')?.value.trim() || '';
    const privacy = document.getElementById('luxuryPrivacy')?.checked || false;

    let isValid = true;

    // Name validation
    if (!name) {
        showLuxuryError('nameError', 'Please enter your full name.');
        isValid = false;
    } else if (name.length < 2) {
        showLuxuryError('nameError', 'Name must be at least 2 characters.');
        isValid = false;
    } else if (name.length > 100) {
        showLuxuryError('nameError', 'Name cannot exceed 100 characters.');
        isValid = false;
    }

    // Email validation
    const emailRegex = /^[^\s@]+@([^\s@.,]+\.)+[^\s@.,]{2,}$/;
    if (!email) {
        showLuxuryError('emailError', 'Please enter your email address.');
        isValid = false;
    } else if (!emailRegex.test(email)) {
        showLuxuryError('emailError', 'Please enter a valid email address (e.g., name@example.com).');
        isValid = false;
    } else if (email.length > 255) {
        showLuxuryError('emailError', 'Email cannot exceed 255 characters.');
        isValid = false;
    }

    // Mobile validation (optional)
    if (mobile) {
        const mobileRegex = /^[6-9]\d{9}$|^\+91[6-9]\d{9}$|^0?[6-9]\d{9}$/;
        const cleanMobile = mobile.replace(/\s/g, '');
        if (!mobileRegex.test(cleanMobile) && !/^\+\d{10,15}$/.test(cleanMobile)) {
            showLuxuryError('mobileError', 'Please enter a valid mobile number (10 digits, Indian format).');
            isValid = false;
        }
    }

    // Subject validation
    if (!subject) {
        showLuxuryError('subjectError', 'Please select an inquiry type.');
        isValid = false;
    }

    // Message validation
    if (!message) {
        showLuxuryError('messageError', 'Please enter your message.');
        isValid = false;
    } else if (message.length < 10) {
        showLuxuryError('messageError', 'Message must be at least 10 characters.');
        isValid = false;
    } else if (message.length > 2000) {
        showLuxuryError('messageError', 'Message cannot exceed 2000 characters.');
        isValid = false;
    }

    // Privacy policy validation
    if (!privacy) {
        showLuxuryError('privacyError', 'You must agree to the Privacy Policy.');
        isValid = false;
    }

    if (isValid) {
        const form = document.getElementById('luxuryContactForm');
        const formData = new FormData(form);
        const submitBtn = document.getElementById('submitLuxuryBtn');
        const originalText = submitBtn.innerHTML;
        
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-pulse mr-2"></i> Sending...';
        submitBtn.disabled = true;

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')?.value || ''
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showLuxuryFormStatus('success', data.message || 'Thank you! Your message has been received. Our team will reply within 12 hours.');
                form.reset();
                clearLuxuryErrors();
            } else {
                if (data.errors) {
                    displayLuxuryServerErrors(data.errors);
                }
                showLuxuryFormStatus('error', data.message || 'Something went wrong. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showLuxuryFormStatus('error', 'Network error. Please check your connection and try again.');
        })
        .finally(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    }
}

function clearLuxuryErrors() {
    const errorDivs = ['nameError', 'emailError', 'mobileError', 'subjectError', 'messageError', 'privacyError'];
    errorDivs.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.classList.add('hidden');
            el.innerText = '';
        }
    });
}

function showLuxuryError(elementId, message) {
    const errorEl = document.getElementById(elementId);
    if (errorEl) {
        errorEl.innerText = message;
        errorEl.classList.remove('hidden');
        if (elementId === 'nameError') {
            document.getElementById('luxuryName')?.focus();
        }
    }
}

function showLuxuryFormStatus(type, message) {
    const statusDiv = document.getElementById('formStatusMsg');
    if (statusDiv) {
        statusDiv.innerText = message;
        statusDiv.classList.remove('hidden', 'text-green-700', 'text-red-600', 'bg-green-50', 'bg-red-50', 'p-3', 'rounded-xl');
        if (type === 'success') {
            statusDiv.classList.add('text-green-700', 'bg-green-50', 'p-3', 'rounded-xl');
        } else {
            statusDiv.classList.add('text-red-600', 'bg-red-50', 'p-3', 'rounded-xl');
        }
        setTimeout(() => {
            statusDiv.classList.add('hidden');
            statusDiv.classList.remove('bg-green-50', 'bg-red-50', 'p-3');
        }, 5000);
    }
}

function hideLuxuryFormStatus() {
    const statusDiv = document.getElementById('formStatusMsg');
    if (statusDiv) {
        statusDiv.classList.add('hidden');
    }
}

function displayLuxuryServerErrors(errors) {
    for (const [field, messages] of Object.entries(errors)) {
        let errorId = '';
        if (field === 'name') errorId = 'nameError';
        else if (field === 'email') errorId = 'emailError';
        else if (field === 'mobile') errorId = 'mobileError';
        else if (field === 'subject') errorId = 'subjectError';
        else if (field === 'message') errorId = 'messageError';
        else if (field === 'privacy_policy') errorId = 'privacyError';
        
        if (errorId) {
            const errorEl = document.getElementById(errorId);
            if (errorEl) {
                errorEl.innerText = messages[0];
                errorEl.classList.remove('hidden');
            }
        }
    }
}

// Real-time validation clearing
function setupLuxuryValidation() {
    const inputs = ['luxuryName', 'luxuryEmail', 'luxuryMobile', 'luxurySubject', 'luxuryMessage'];
    inputs.forEach(fieldId => {
        const element = document.getElementById(fieldId);
        if (element) {
            element.addEventListener('input', function() {
                const errorMap = {
                    'luxuryName': 'nameError',
                    'luxuryEmail': 'emailError',
                    'luxuryMobile': 'mobileError',
                    'luxurySubject': 'subjectError',
                    'luxuryMessage': 'messageError'
                };
                const errorId = errorMap[fieldId];
                if (errorId) {
                    const errorEl = document.getElementById(errorId);
                    if (errorEl && !errorEl.classList.contains('hidden')) {
                        errorEl.classList.add('hidden');
                    }
                }
            });
        }
    });
    
    const privacyCheck = document.getElementById('luxuryPrivacy');
    if (privacyCheck) {
        privacyCheck.addEventListener('change', function() {
            const errorEl = document.getElementById('privacyError');
            if (errorEl && !errorEl.classList.contains('hidden')) {
                errorEl.classList.add('hidden');
            }
        });
    }
}

setupLuxuryValidation();
</script>
@endsection