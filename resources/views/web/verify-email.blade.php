@extends('layout.web.main-layout')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-indigo-100">
                <i class="fas fa-envelope text-indigo-600 text-xl"></i>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Verify Your Email
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                We've sent a 6-digit OTP to your email address
            </p>
        </div>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <form class="mt-8 space-y-6" action="{{ route('web.verify-email') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="otp" class="block text-sm font-medium text-gray-700">
                        Enter OTP
                    </label>
                    <div class="mt-1">
                        <input 
                            id="otp" 
                            name="otp" 
                            type="text" 
                            required 
                            maxlength="6"
                            pattern="[0-9]{6}"
                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm text-center text-2xl tracking-widest"
                            placeholder="000000"
                            autocomplete="one-time-code"
                        >
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Enter the 6-digit code sent to your email</p>
                </div>
            </div>

            <div>
                <button 
                    type="submit" 
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-shield-alt text-indigo-500 group-hover:text-indigo-400"></i>
                    </span>
                    Verify Email
                </button>
            </div>

            <div class="text-center">
                <button 
                    type="button" 
                    id="resend-otp-btn"
                    class="text-sm text-indigo-600 hover:text-indigo-500 font-medium"
                >
                    Didn't receive the code? <span id="resend-text">Resend OTP</span>
                </button>
            </div>
        </form>

        <div class="text-center">
            <a href="{{ route('page.register') }}" class="text-sm text-gray-600 hover:text-gray-500">
                <i class="fas fa-arrow-left mr-1"></i>
                Back to Registration
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const otpInput = document.getElementById('otp');
    const resendBtn = document.getElementById('resend-otp-btn');
    const resendText = document.getElementById('resend-text');
    let countdown = 0;

    // Auto-focus and format OTP input
    otpInput.addEventListener('input', function(e) {
        // Only allow numbers
        this.value = this.value.replace(/[^0-9]/g, '');
        
        // Auto-submit when 6 digits entered
        if (this.value.length === 6) {
            this.form.submit();
        }
    });

    // Resend OTP functionality
    resendBtn.addEventListener('click', function() {
        if (countdown > 0) return;

        // Disable button and start countdown
        resendBtn.disabled = true;
        countdown = 60;
        updateResendText();

        // Send AJAX request to resend OTP
        fetch('{{ route("web.resend-otp") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({})
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                showNotification(data.success, 'success');
            } else {
                // Show error message
                showNotification(data.error || 'Failed to resend OTP', 'error');
            }
        })
        .catch(error => {
            showNotification('Network error. Please try again.', 'error');
        })
        .finally(() => {
            // Re-enable button after countdown
            const countdownInterval = setInterval(() => {
                countdown--;
                updateResendText();
                
                if (countdown <= 0) {
                    clearInterval(countdownInterval);
                    resendBtn.disabled = false;
                    resendText.textContent = 'Resend OTP';
                }
            }, 1000);
        });
    });

    function updateResendText() {
        if (countdown > 0) {
            resendText.textContent = `Resend OTP (${countdown}s)`;
        } else {
            resendText.textContent = 'Resend OTP';
        }
    }

    function showNotification(message, type) {
        // Remove existing notifications
        const existing = document.querySelector('.notification');
        if (existing) {
            existing.remove();
        }

        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification mb-4 p-4 rounded-lg ${
            type === 'success' 
                ? 'bg-green-100 border border-green-400 text-green-700' 
                : 'bg-red-100 border border-red-400 text-red-700'
        }`;
        notification.innerHTML = `
            <span class="block sm:inline">${message}</span>
        `;

        // Insert before the form
        const form = document.querySelector('form');
        form.parentNode.insertBefore(notification, form);

        // Auto-remove after 5 seconds
        setTimeout(() => {
            notification.remove();
        }, 5000);
    }
});
</script>
@endsection
