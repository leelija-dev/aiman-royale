@extends('layout.web.main-layout')

@section('head')
<script>
    // Track CompleteRegistration event with Facebook Pixel on successful registration
    @if(session('registration_success'))
    if (typeof fbq !== 'undefined') {
        fbq('track', 'CompleteRegistration', {
            status: 'completed',
            currency: 'INR',
            value: 0
        });
        // Clear session after firing event
        @php session()->forget('registration_success'); @endphp
    }
    @endif
</script>
@parent
@endsection

@section('content')
<style>
    /* Your original gradient colors */
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

    /* Password strength styles */
    .password-strength {
        height: 6px;
        border-radius: 3px;
        transition: all 0.3s ease;
        margin-top: 10px;
        background: #e5e7eb;
        overflow: hidden;
        position: relative;
    }

    .password-strength::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: var(--strength-width, 0%);
        background: linear-gradient(90deg, #ef4444, #f59e0b, #10b981);
        transition: width 0.3s ease;
        border-radius: 3px;
    }

    .strength-weak::before {
        --strength-width: 33%;
    }

    .strength-medium::before {
        --strength-width: 66%;
    }

    .strength-strong::before {
        --strength-width: 100%;
    }

    /* Requirement styles */
    .requirement {
        transition: all 0.3s ease;
        padding: 6px 10px;
        border-radius: 8px;
        background: white;
        border: 1px solid #f3e8ff;
    }

    .requirement.met {
        background: #f0fdf4;
        border-color: #86efac;
    }

    .requirement.met i {
        color: #10b981;
    }

    .requirement i {
        color: #d1d5db;
        transition: all 0.3s ease;
    }

    /* Input styles */
    .input-group {
        position: relative;
        margin-bottom: 1rem;
    }

    .input-field {
        width: 100%;
        padding: 14px 16px;
        padding-right: 45px;
        border: 2px solid #e5e7eb;
        border-radius: 16px;
        font-size: 15px;
        transition: all 0.3s ease;
        background: white;
    }

    .input-field:focus {
        border-color: #a855f7;
        outline: none;
        box-shadow: 0 0 0 4px rgba(168, 85, 247, 0.1);
    }

    .input-field.error {
        border-color: #ef4444;
        background: #fef2f2;
    }

    .input-toggle {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: #9ca3af;
        transition: color 0.3s ease;
        padding: 5px;
    }

    .input-toggle:hover {
        color: #a855f7;
    }

    /* Animations */
    @keyframes float {
        0% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-10px);
        }

        100% {
            transform: translateY(0px);
        }
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.5;
        }
    }

    .animate-float {
        animation: float 3s ease-in-out infinite;
    }

    .animate-slideDown {
        animation: slideDown 0.3s ease-out;
    }

    .animate-slideUp {
        animation: slideUp 0.3s ease-out;
    }

    .animate-pulse-slow {
        animation: pulse 2s ease-in-out infinite;
    }

    /* Custom checkbox */
    .checkbox-custom {
        appearance: none;
        -webkit-appearance: none;
        width: 20px;
        height: 20px;
        border: 2px solid #e5e7eb;
        border-radius: 6px;
        background: white;
        cursor: pointer;
        position: relative;
        transition: all 0.3s ease;
    }

    .checkbox-custom:checked {
        background: linear-gradient(135deg, #ec4899 0%, #a855f7 100%);
        border-color: transparent;
    }

    .checkbox-custom:checked::after {
        content: '\f00c';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        font-size: 12px;
        color: white;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .checkbox-custom:focus {
        outline: none;
        border-color: #a855f7;
        box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.2);
    }

    /* Responsive */
    @media (max-width: 640px) {
        .input-field {
            padding: 12px 14px;
            padding-right: 40px;
            font-size: 14px;
        }

        .requirement {
            padding: 4px 8px;
            font-size: 12px;
        }
    }

    /* Blob animation for background */
    @keyframes blob {
        0% {
            transform: translate(0px, 0px) scale(1);
        }

        33% {
            transform: translate(30px, -50px) scale(1.1);
        }

        66% {
            transform: translate(-20px, 20px) scale(0.9);
        }

        100% {
            transform: translate(0px, 0px) scale(1);
        }
    }

    .animate-blob {
        animation: blob 7s infinite;
    }

    .animation-delay-2000 {
        animation-delay: 2s;
    }

    .animation-delay-4000 {
        animation-delay: 4s;
    }
</style>

<div class="min-h-screen fashion-gradient-light flex items-center justify-center py-8 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Decorative background elements with your colors -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 rounded-full animate-blob"
            style="background: #ec4899; filter: blur(80px); opacity: 0.15;"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 rounded-full animate-blob animation-delay-2000"
            style="background: #a855f7; filter: blur(80px); opacity: 0.15;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 rounded-full animate-blob animation-delay-4000"
            style="background: linear-gradient(135deg, #ec4899 0%, #a855f7 100%); filter: blur(100px); opacity: 0.1;"></div>
    </div>

    <!-- Main Container -->
    <div class="max-w-md w-full relative z-10">
        <!-- Brand/Logo with gradient -->
        <div class="text-center mb-6 sm:mb-8">
            <div class="inline-block p-1 fashion-gradient rounded-2xl shadow-lg animate-float">
                <div class="bg-white rounded-xl px-6 py-3">
                    <h1 class="text-xl sm:text-2xl font-bold">
                        <span class="fashion-gradient bg-clip-text text-transparent">Create Password</span>
                    </h1>
                </div>
            </div>
        </div>

        <!-- Password Setup Card -->
        <div class="bg-white rounded-3xl shadow-2xl p-6 sm:p-8 relative overflow-hidden">
            <!-- Decorative top gradient line -->
            <div class="absolute top-0 left-0 right-0 h-1 fashion-gradient"></div>

            <!-- Success Icon with animation -->
            <div class="text-center mb-6 animate-slideDown">
                <div class="w-20 h-20 fashion-gradient rounded-full flex items-center justify-center mx-auto shadow-lg mb-4 relative">
                    <i class="fas fa-check-circle text-white text-3xl"></i>
                    <div class="absolute inset-0 fashion-gradient rounded-full animate-ping opacity-20"></div>
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Set Your Password</h2>
                <p class="text-gray-600 text-sm sm:text-base">
                    Your identity has been verified. Create a strong password to secure your account.
                </p>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg animate-slideDown">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
            </div>
            @endif


            @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg animate-slideDown">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                    <p class="text-sm text-red-700">{{ $errors->first() }}</p>
                </div>
            </div>
            @endif


            <!-- User Info Card -->
            <div class="fashion-gradient-light rounded-2xl p-4 mb-6 border border-purple-100 animate-slideUp">
                <div class="flex items-center justify-between flex-wrap gap-3">
                    <div class="flex items-center min-w-0">
                        <div class="w-10 h-10 fashion-gradient rounded-full flex items-center justify-center flex-shrink-0">
                            @if(session()->has('email'))
                            <i class="fas fa-envelope text-white text-sm"></i>
                            @else
                            <i class="fas fa-phone text-white text-sm"></i>
                            @endif
                        </div>
                        <div class="ml-3 truncate">
                            <p class="text-xs text-gray-500">Verifying</p>
                            <p class="text-sm font-semibold text-gray-800 truncate">
                                @if(session()->has('email'))
                                {{ session('email') }}
                                @else
                                {{ session('phone') }}
                                @endif
                            </p>
                        </div>
                    </div>
                    <button type="button" onclick="changeContact()"
                        class="text-sm font-medium px-4 py-2 rounded-lg transition-all flex-shrink-0"
                        style="color: #a855f7; background: white; border: 1px solid #a855f7;">
                        <i class="fas fa-edit mr-1"></i>Change
                    </button>
                </div>
            </div>

            <!-- Password Form -->
            <form action="{{ route('web.register.set-password') }}" method="post" id="passwordForm" class="space-y-5">
                @csrf

                <!-- Password Field -->
                <div class="input-group animate-slideUp" style="animation-delay: 0.1s;">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2" style="color: #a855f7;"></i>Password
                    </label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required
                            class="input-field" placeholder="Enter your password">
                        <button type="button" id="togglePassword" class="input-toggle">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div id="passwordStrength" class="password-strength"></div>
                    <p id="passwordError" class="text-red-500 text-xs mt-1 hidden animate-slideDown"></p>
                </div>

                <!-- Confirm Password Field -->
                <div class="input-group animate-slideUp" style="animation-delay: 0.2s;">
                    <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-check-circle mr-2" style="color: #a855f7;"></i>Confirm Password
                    </label>
                    <div class="relative">
                        <input type="password" id="confirmPassword" name="confirmPassword" required
                            class="input-field" placeholder="Re-enter your password">
                        <button type="button" id="toggleConfirmPassword" class="input-toggle">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <p id="confirmPasswordError" class="text-red-500 text-xs mt-1 hidden animate-slideDown"></p>
                </div>

                <!-- Password Requirements -->
                <div class="fashion-gradient-light rounded-2xl p-4 animate-slideUp" style="animation-delay: 0.3s;">
                    <p class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                        <i class="fas fa-shield-alt mr-2" style="color: #a855f7;"></i>
                        Password must contain:
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        <div class="requirement flex items-center text-xs sm:text-sm text-gray-600" id="req-length">
                            <i class="fas fa-circle text-xs mr-2"></i>
                            8+ characters
                        </div>
                        <div class="requirement flex items-center text-xs sm:text-sm text-gray-600" id="req-uppercase">
                            <i class="fas fa-circle text-xs mr-2"></i>
                            Uppercase letter
                        </div>
                        <div class="requirement flex items-center text-xs sm:text-sm text-gray-600" id="req-lowercase">
                            <i class="fas fa-circle text-xs mr-2"></i>
                            Lowercase letter
                        </div>
                        <div class="requirement flex items-center text-xs sm:text-sm text-gray-600" id="req-number">
                            <i class="fas fa-circle text-xs mr-2"></i>
                            One number
                        </div>
                        <div class="requirement flex items-center text-xs sm:text-sm text-gray-600 sm:col-span-2" id="req-special">
                            <i class="fas fa-circle text-xs mr-2"></i>
                            Special character (!@#$%^&*)
                        </div>
                    </div>
                </div>

                <!-- Password Strength Indicator Text -->
                <div class="flex items-center justify-between text-xs animate-slideUp" style="animation-delay: 0.35s;">
                    <span class="text-gray-500">Password strength:</span>
                    <span id="strengthText" class="font-semibold" style="color: #9ca3af;">Not entered</span>
                </div>

                <!-- Terms and Conditions with custom checkbox -->
                <div class="flex items-start space-x-3 animate-slideUp" style="animation-delay: 0.4s;">
                    <input type="checkbox" id="terms" name="terms" required class="checkbox-custom mt-0.5">
                    <label for="terms" class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                        I agree to the
                        <a href="#" class="font-medium transition-colors" style="color: #ec4899;">Terms of Service</a>
                        and
                        <a href="#" class="font-medium transition-colors" style="color: #a855f7;">Privacy Policy</a>
                    </label>
                </div>
                <p id="termsError" class="text-red-500 text-xs mt-1 hidden animate-slideDown"></p>

                <!-- Submit Button with gradient -->
                <button type="submit" class="w-full fashion-gradient text-white py-4 px-4 rounded-xl font-semibold hover:opacity-90 transition-all transform hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center mt-6 shadow-lg animate-slideUp" style="animation-delay: 0.5s;">
                    <i class="fas fa-user-plus mr-2"></i>
                    Complete Registration
                </button>
            </form>

            <!-- Footer Links -->
            <div class="mt-6 text-center animate-slideUp" style="animation-delay: 0.6s;">
                <p class="text-xs sm:text-sm text-gray-600">
                    Already have an account?
                    <a href="{{ route('login') }}" class="font-medium transition-colors" style="color: #a855f7;">
                        Sign In <i class="fas fa-arrow-right ml-1 text-xs"></i>
                    </a>
                </p>
            </div>

            <!-- Security Note -->
            <div class="mt-6 text-center">
                <p class="text-xs text-gray-400">
                    <i class="fas fa-shield-alt mr-1" style="color: #ec4899;"></i>
                    Your password is encrypted and secure
                </p>
            </div>
        </div>

        <!-- Help Link -->
        <div class="text-center mt-4">
            <a href="#" class="text-xs sm:text-sm transition-colors" style="color: #a855f7;">
                <i class="fas fa-question-circle mr-1"></i>
                Need help? Contact support
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.getElementById('togglePassword');
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirmPassword');
        const passwordStrength = document.getElementById('passwordStrength');
        const strengthText = document.getElementById('strengthText');

        // Toggle password visibility
        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });

        toggleConfirmPassword.addEventListener('click', function() {
            const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPassword.setAttribute('type', type);
            const icon = this.querySelector('i');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });

        // Password strength checker
        password.addEventListener('input', function() {
            const value = this.value;
            let strength = 0;
            let strengthLevel = '';

            // Check requirements
            const requirements = {
                length: value.length >= 8,
                uppercase: /[A-Z]/.test(value),
                lowercase: /[a-z]/.test(value),
                number: /[0-9]/.test(value),
                special: /[!@#$%^&*(),.?":{}|<>]/.test(value)
            };

            // Update requirement indicators
            updateRequirement('req-length', requirements.length);
            updateRequirement('req-uppercase', requirements.uppercase);
            updateRequirement('req-lowercase', requirements.lowercase);
            updateRequirement('req-number', requirements.number);
            updateRequirement('req-special', requirements.special);

            // Calculate strength
            strength = Object.values(requirements).filter(Boolean).length;

            // Update strength indicator
            passwordStrength.className = 'password-strength';
            if (value.length === 0) {
                strengthLevel = 'Not entered';
                passwordStrength.classList.remove('strength-weak', 'strength-medium', 'strength-strong');
            } else if (strength <= 2) {
                passwordStrength.classList.add('strength-weak');
                strengthLevel = 'Weak';
            } else if (strength <= 4) {
                passwordStrength.classList.add('strength-medium');
                strengthLevel = 'Medium';
            } else {
                passwordStrength.classList.add('strength-strong');
                strengthLevel = 'Strong';
            }

            strengthText.textContent = strengthLevel;
            strengthText.style.color = strengthLevel === 'Weak' ? '#ef4444' :
                strengthLevel === 'Medium' ? '#f59e0b' :
                strengthLevel === 'Strong' ? '#10b981' : '#9ca3af';

            // Check if passwords match
            checkPasswordMatch();
        });

        confirmPassword.addEventListener('input', checkPasswordMatch);

        function updateRequirement(id, met) {
            const element = document.getElementById(id);
            if (met) {
                element.classList.add('met');
                element.querySelector('i').className = 'fas fa-check-circle text-xs mr-2';
            } else {
                element.classList.remove('met');
                element.querySelector('i').className = 'fas fa-circle text-xs mr-2';
            }
        }

        function checkPasswordMatch() {
            const confirmPasswordError = document.getElementById('confirmPasswordError');
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirmPassword');
            
            if (confirmPassword.value) {
                if (password.value !== confirmPassword.value) {
                    confirmPasswordError.textContent = 'Passwords do not match';
                    confirmPasswordError.classList.remove('hidden');
                    confirmPassword.classList.add('error');
                } else {
                    confirmPasswordError.classList.add('hidden');
                    confirmPassword.classList.remove('error');
                }
            } else {
                confirmPasswordError.classList.add('hidden');
                confirmPassword.classList.remove('error');
            }
        }

        // Form validation
        document.getElementById('passwordForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirmPassword');
            let isValid = true;

            // Clear previous errors
            document.querySelectorAll('.text-red-500').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.input-field').forEach(el => el.classList.remove('error'));

            // Validate password
            if (!password.value.trim()) {
                showError('passwordError', 'Password is required');
                password.classList.add('error');
                isValid = false;
            } else if (password.value.length < 8) {
                showError('passwordError', 'Password must be at least 8 characters');
                password.classList.add('error');
                isValid = false;
            } else if (!/(?=.*[a-z])/.test(password.value)) {
                showError('passwordError', 'Password must contain at least one lowercase letter');
                password.classList.add('error');
                isValid = false;
            } else if (!/(?=.*[A-Z])/.test(password.value)) {
                showError('passwordError', 'Password must contain at least one uppercase letter');
                password.classList.add('error');
                isValid = false;
            } else if (!/(?=.*\d)/.test(password.value)) {
                showError('passwordError', 'Password must contain at least one number');
                password.classList.add('error');
                isValid = false;
            } else if (!/(?=.*[!@#$%^&*(),.?":{}|<>])/.test(password.value)) {
                showError('passwordError', 'Password must contain at least one special character');
                password.classList.add('error');
                isValid = false;
            }

            // Validate confirm password
            if (!confirmPassword.value.trim()) {
                showError('confirmPasswordError', 'Please confirm your password');
                confirmPassword.classList.add('error');
                isValid = false;
            } else if (password.value !== confirmPassword.value) {
                showError('confirmPasswordError', 'Passwords do not match');
                confirmPassword.classList.add('error');
                isValid = false;
            }

            // Validate terms
            const terms = document.getElementById('terms');
            if (!terms.checked) {
                showError('termsError', 'You must agree to the terms and conditions');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                // Scroll to first error
                const firstError = document.querySelector('.error, .text-red-500:not(.hidden)');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            } else {
                // Show loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Creating Account...';
                submitBtn.disabled = true;
            }
        });

        function showError(elementId, message) {
            const errorElement = document.getElementById(elementId);
            errorElement.textContent = message;
            errorElement.classList.remove('hidden');
        }

        function changeContact() {
            // Go back to registration page
            window.location.href = '{{ route("page.register") }}';
        }
    });
</script>
@endsection