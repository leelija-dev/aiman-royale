@extends('layout.web.main-layout')

@section('content')
<style>
    html,
    body {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .fashion-gradient {
        background: linear-gradient(135deg, #ec4899 0%, #a855f7 100%);
    }

    .fashion-gradient-light {
        background: linear-gradient(135deg, #fdf2f8 0%, #faf5ff 100%);
    }

    .glass-effect {
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.18);
    }

    .tab-active {
        background: linear-gradient(135deg, #ec4899 0%, #a855f7 100%);
        color: white;
    }
</style>

<main class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="container mx-auto flex justify-center items-center">

        <!-- Registration Form -->
        <div class="max-w-md w-full">
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900">Create Your Account</h2>
                    <p class="mt-2 text-gray-600">Join StyleHub and discover your perfect style</p>
                </div>

                <!-- Tab Selection -->
                <div class="flex bg-gray-100 rounded-xl p-1 mb-6">
                    <button type="button" id="emailTab" onclick="switchTab('email')" class="flex-1 py-3 px-4 rounded-lg text-sm font-medium transition tab-active">
                        <i class="fas fa-envelope mr-2"></i>Email
                    </button>
                    <button type="button" id="phoneTab" onclick="switchTab('phone')" class="flex-1 py-3 px-4 rounded-lg text-sm font-medium transition">
                        <i class="fas fa-phone mr-2"></i>Mobile
                    </button>
                </div>

                <form action="{{ route('web.register.send-otp') }}" method="post" id="registerForm" class="space-y-5" novalidate>
                    @csrf
                    
                    <!-- Email Field -->
                    <div id="emailField">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <div class="relative">
                            <input type="email" id="email" name="email" required
                                class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition">
                            <i class="fas fa-envelope absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                        <p class="error text-red-500 text-xs mt-1 hidden"></p>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone Field -->
                    <div id="phoneField" class="hidden">
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Mobile Number</label>
                        <div class="relative">
                            <input type="tel" id="phone" name="phone" required
                                class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                                placeholder="+1234567890">
                            <i class="fas fa-phone absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                        <p class="error text-red-500 text-xs mt-1 hidden"></p>
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full fashion-gradient text-white py-3 px-4 rounded-xl font-semibold hover:opacity-90 transition flex items-center justify-center">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Send OTP
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="text-purple-600 hover:text-purple-700 font-medium">
                            Sign In
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
function switchTab(type) {
    const emailTab = document.getElementById('emailTab');
    const phoneTab = document.getElementById('phoneTab');
    const emailField = document.getElementById('emailField');
    const phoneField = document.getElementById('phoneField');
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');

    if (type === 'email') {
        emailTab.classList.add('tab-active');
        phoneTab.classList.remove('tab-active');
        emailField.classList.remove('hidden');
        phoneField.classList.add('hidden');
        emailInput.required = true;
        phoneInput.required = false;
    } else {
        phoneTab.classList.add('tab-active');
        emailTab.classList.remove('tab-active');
        phoneField.classList.remove('hidden');
        emailField.classList.add('hidden');
        phoneInput.required = true;
        emailInput.required = false;
    }
}

// Form validation
document.getElementById('registerForm').addEventListener('submit', function(e) {
    const emailField = document.getElementById('emailField');
    const phoneField = document.getElementById('phoneField');
    const email = document.getElementById('email');
    const phone = document.getElementById('phone');
    
    // Clear previous errors
    document.querySelectorAll('.error').forEach(el => el.classList.add('hidden'));
    
    let isValid = true;
    
    if (!emailField.classList.contains('hidden')) {
        if (!email.value.trim()) {
            email.nextElementSibling.textContent = 'Email is required';
            email.nextElementSibling.classList.remove('hidden');
            isValid = false;
        } else if (!email.validity.valid) {
            email.nextElementSibling.textContent = 'Please enter a valid email';
            email.nextElementSibling.classList.remove('hidden');
            isValid = false;
        }
        // Clear phone field when submitting email
        phone.value = '';
        phone.required = false;
    } else {
        if (!phone.value.trim()) {
            phone.nextElementSibling.textContent = 'Phone number is required';
            phone.nextElementSibling.classList.remove('hidden');
            isValid = false;
        } else if (phone.value.length < 10) {
            phone.nextElementSibling.textContent = 'Please enter a valid phone number';
            phone.nextElementSibling.classList.remove('hidden');
            isValid = false;
        }
        // Clear email field when submitting phone
        email.value = '';
        email.required = false;
    }
    
    if (!isValid) {
        e.preventDefault();
    } else {
        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Sending OTP...';
        submitBtn.disabled = true;
    }
});
</script>
@endsection