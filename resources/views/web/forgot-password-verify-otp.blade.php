@extends('layout.web.main-layout')

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

    /* OTP Input Styles - matching your design */
    .otp-input {
        width: 50px;
        height: 50px;
        text-align: center;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 20px;
        font-weight: 600;
        transition: all 0.3s ease;
        background: white;
    }

    .otp-input:focus {
        border-color: #a855f7;
        outline: none;
        box-shadow: 0 0 0 4px rgba(168, 85, 247, 0.1);
        transform: scale(1.05);
    }

    .otp-input.filled {
        border-color: #ec4899;
        background: #fdf2f8;
    }

    /* Timer styles */
    .timer-progress {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: conic-gradient(#ec4899 0deg, #e5e7eb 0deg);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .timer-text {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
        color: #4b5563;
    }

    /* Animation */
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }

    .float-animation {
        animation: float 3s ease-in-out infinite;
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

    .animate-slideDown {
        animation: slideDown 0.3s ease-out;
    }

    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
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

    /* Responsive */
    @media (max-width: 640px) {
        .otp-input {
            width: 40px;
            height: 40px;
            font-size: 18px;
        }
    }
</style>

<div class="min-h-screen fashion-gradient-light flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Decorative blurred circles with your colors -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 rounded-full" 
             style="background: #ec4899; filter: blur(80px); opacity: 0.15;"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 rounded-full" 
             style="background: #a855f7; filter: blur(80px); opacity: 0.15;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 rounded-full" 
             style="background: linear-gradient(135deg, #ec4899 0%, #a855f7 100%); filter: blur(100px); opacity: 0.1;"></div>
    </div>

    <!-- Main Container -->
    <div class="max-w-md w-full relative z-10">
        <!-- Brand/Logo with your gradient -->
        <div class="text-center mb-8">
            <div class="inline-block p-1 fashion-gradient rounded-2xl shadow-lg float-animation">
                <div class="bg-white rounded-xl px-6 py-3">
                    <h1 class="text-2xl font-bold">
                        <span class="fashion-gradient bg-clip-text text-transparent">Verify Reset Code</span>
                    </h1>
                </div>
            </div>
        </div>

        <!-- OTP Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8 relative overflow-hidden">
            <!-- Decorative gradient line at top -->
            <div class="absolute top-0 left-0 right-0 h-1 fashion-gradient"></div>
            
            <!-- Icon with your gradient -->
            <div class="text-center mb-6">
                <div class="w-20 h-20 fashion-gradient rounded-full flex items-center justify-center mx-auto shadow-lg">
                    <i class="fas fa-key text-white text-3xl"></i>
                </div>
            </div>

            <!-- Title -->
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Reset Code Verification</h2>
                <p class="text-gray-600 text-sm">
                    Enter the 6-digit code sent to
                </p>
                <p class="font-semibold text-lg mt-2 break-all" style="color: #a855f7;">
                    @if(session()->has('forgot_email'))
                        <i class="fas fa-envelope mr-2 text-sm" style="color: #ec4899;"></i>{{ session('forgot_email') }}
                    @else
                        <i class="fas fa-phone-alt mr-2 text-sm" style="color: #ec4899;"></i>{{ session('forgot_phone') }}
                    @endif
                </p>
            </div>

            <!-- Alert Messages with your colors -->
            @if(session('success'))
                <div class="mb-6 p-4" style="background: #fdf2f8; border-left: 4px solid #ec4899; border-radius: 8px;">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-3" style="color: #ec4899;"></i>
                        <p class="text-sm" style="color: #be185d;">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4" style="background: #fef2f2; border-left: 4px solid #ef4444; border-radius: 8px;">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-3 text-red-500"></i>
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <!-- OTP Form -->
            <form action="{{ route('web.forgot-password.verify-otp') }}" method="post" id="otpForm" class="space-y-6">
                @csrf
                
                <!-- OTP Input Fields -->
                <div class="flex justify-center gap-2 sm:gap-3 flex-wrap">
                    <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric" 
                           class="otp-input" name="otp1" id="otp1" required autofocus>
                    <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric" 
                           class="otp-input" name="otp2" id="otp2" required>
                    <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric" 
                           class="otp-input" name="otp3" id="otp3" required>
                    <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric" 
                           class="otp-input" name="otp4" id="otp4" required>
                    <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric" 
                           class="otp-input" name="otp5" id="otp5" required>
                    <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric" 
                           class="otp-input" name="otp6" id="otp6" required>
                </div>

                <!-- Hidden combined OTP field -->
                <input type="hidden" name="otp" id="combinedOtp">

                <!-- Timer and Resend Section with your colors -->
                <div class="rounded-xl p-5" style="background: #fdf2f8;">
                    <div class="flex items-center justify-between flex-wrap gap-3">
                        <div class="flex items-center">
                            <div class="timer-progress mr-3" id="timerProgress">
                                <div class="timer-text" id="timerDisplay">02:00</div>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Code expires in</p>
                                <div class="text-xl font-bold" style="color: #ec4899;" id="timer">02:00</div>
                            </div>
                        </div>
                        <div>
                            <button type="button" id="resendBtn" onclick="resendOTP()" 
                                    class="text-sm font-medium disabled:opacity-50 transition-colors px-4 py-2 rounded-lg"
                                    style="color: #a855f7; background: white; border: 1px solid #a855f7;"
                                    disabled>
                                <i class="fas fa-redo-alt mr-1"></i>Resend Code
                            </button>
                            <p class="text-xs text-gray-500 mt-1 text-right">Didn't receive?</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-3">
                    <button type="submit" class="w-full fashion-gradient text-white py-3 px-4 rounded-xl font-semibold hover:opacity-90 transition-all transform hover:scale-[1.02] flex items-center justify-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        Verify & Continue
                    </button>
                    
                    <a href="{{ route('page.forgot-password') }}" 
                       class="w-full block text-center py-3 px-4 rounded-xl font-semibold transition-all"
                       style="background: white; color: #a855f7; border: 2px solid #a855f7;">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Change Email/Phone
                    </a>
                </div>
            </form>

            <!-- Security Note -->
            <div class="mt-6 text-center">
                <p class="text-xs text-gray-500">
                    <i class="fas fa-lock mr-1" style="color: #ec4899;"></i>
                    This code is for password reset only. Never share it with anyone.
                </p>
            </div>
        </div>

        <!-- Help Link -->
        <div class="text-center mt-6">
            <a href="#" class="text-sm transition-colors" style="color: #a855f7;">
                <i class="fas fa-question-circle mr-1"></i>
                Need help? Contact support
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const otpInputs = document.querySelectorAll('.otp-input');
    const timerElement = document.getElementById('timer');
    const timerDisplay = document.getElementById('timerDisplay');
    const timerProgress = document.getElementById('timerProgress');
    const resendBtn = document.getElementById('resendBtn');
    
    let timeLeft = 120; // 2 minutes in seconds

    // OTP Input Handling
    otpInputs.forEach((input, index) => {
        // Auto-focus next input
        input.addEventListener('input', function(e) {
            if (e.target.value.length === 1) {
                this.classList.add('filled');
                if (index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                } else {
                    this.blur();
                }
            }
            updateCombinedOTP();
        });

        // Handle backspace
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace') {
                if (e.target.value === '') {
                    if (index > 0) {
                        otpInputs[index - 1].focus();
                        otpInputs[index - 1].classList.remove('filled');
                    }
                } else {
                    e.target.value = '';
                    e.target.classList.remove('filled');
                }
                updateCombinedOTP();
            }
        });

        // Handle paste
        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedData = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);
            
            for (let i = 0; i < pastedData.length; i++) {
                if (i < otpInputs.length) {
                    otpInputs[i].value = pastedData[i];
                    otpInputs[i].classList.add('filled');
                }
            }
            
            updateCombinedOTP();
            
            if (pastedData.length === 6) {
                otpInputs[5].focus();
            } else if (pastedData.length > 0) {
                otpInputs[pastedData.length].focus();
            }
        });

        // Allow only numbers
        input.addEventListener('keypress', function(e) {
            if (!/^\d$/.test(e.key)) {
                e.preventDefault();
            }
        });
    });

    function updateCombinedOTP() {
        const combinedOTP = Array.from(otpInputs).map(input => input.value).join('');
        document.getElementById('combinedOtp').value = combinedOTP;
    }

    // Timer functionality
    function updateTimer() {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        const timeString = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        
        timerElement.textContent = timeString;
        if (timerDisplay) timerDisplay.textContent = timeString;
        
        if (timerProgress) {
            const degrees = ((120 - timeLeft) / 120) * 360;
            timerProgress.style.background = `conic-gradient(#ec4899 ${degrees}deg, #e5e7eb 0deg)`;
        }
        
        if (timeLeft > 0) {
            timeLeft--;
            setTimeout(updateTimer, 1000);
        } else {
            resendBtn.disabled = false;
            timerElement.textContent = '00:00';
            if (timerDisplay) timerDisplay.textContent = '00:00';
            timerElement.classList.add('text-red-500');
            
            if (!document.querySelector('.expired-message')) {
                const message = document.createElement('div');
                message.className = 'expired-message mt-2 text-center text-sm animate-slideDown';
                message.style.color = '#ef4444';
                message.innerHTML = '<i class="fas fa-exclamation-triangle mr-1"></i>Code expired. Please request a new one.';
                document.querySelector('[style*="background: #fdf2f8;"]').appendChild(message);
            }
        }
    }

    // Start timer
    updateTimer();

    // Form validation
    document.getElementById('otpForm').addEventListener('submit', function(e) {
        const combinedOTP = document.getElementById('combinedOtp').value;
        
        if (combinedOTP.length !== 6) {
            e.preventDefault();
            
            // Show error toast
            const toast = document.createElement('div');
            toast.className = 'fixed top-4 right-4 text-white px-6 py-3 rounded-lg shadow-lg animate-slideDown z-50';
            toast.style.background = 'linear-gradient(135deg, #ec4899 0%, #a855f7 100%)';
            toast.innerHTML = '<i class="fas fa-exclamation-circle mr-2"></i>Please enter all 6 digits of the OTP';
            document.body.appendChild(toast);
            
            setTimeout(() => toast.remove(), 3000);
            
            // Highlight empty fields
            otpInputs.forEach(input => {
                if (!input.value) {
                    input.style.borderColor = '#ef4444';
                    setTimeout(() => input.style.borderColor = '', 3000);
                }
            });
            
            return false;
        }
        
        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Verifying...';
        submitBtn.disabled = true;
    });
});

function resendOTP() {
    const resendBtn = document.getElementById('resendBtn');
    
    if (!resendBtn.disabled) {
        // Show loading state
        resendBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Sending...';
        resendBtn.disabled = true;
        
        // Submit form to resend OTP
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("web.forgot-password.resend-otp") }}';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        @if(session()->has('forgot_email'))
            const email = document.createElement('input');
            email.type = 'hidden';
            email.name = 'email';
            email.value = '{{ session("forgot_email") }}';
            form.appendChild(email);
        @else
            const phone = document.createElement('input');
            phone.type = 'hidden';
            phone.name = 'phone';
            phone.value = '{{ session("forgot_phone") }}';
            form.appendChild(phone);
        @endif
        
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection
