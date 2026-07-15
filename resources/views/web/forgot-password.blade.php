@extends('layout.web.main-layout')

@section('content')
<style>
    /* Reset and Base Styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        --primary: #ec4899;
        --primary-dark: #db2777;
        --secondary: #a855f7;
        --secondary-dark: #9333ea;
        --success: #10b981;
        --error: #ef4444;
        --warning: #f59e0b;
    }

    /* Main Container - Forces centering */
    .forgot-page-wrapper {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        overflow-y: auto;
        padding: 20px;
        z-index: 1000;
    }

    /* Ensure no other elements interfere */
    .forgot-page-wrapper::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: inherit;
        z-index: -1;
    }

    /* Main Card Container */
    .forgot-card-container {
        width: 100%;
        max-width: 460px;
        margin: auto;
        animation: slideUpFade 0.6s ease-out;
    }

    @keyframes slideUpFade {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Card Design */
    .forgot-card {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(10px);
        border-radius: 32px;
        padding: 40px 32px;
        box-shadow: 
            0 25px 50px -12px rgba(0, 0, 0, 0.25),
            0 0 0 1px rgba(255, 255, 255, 0.1) inset;
        position: relative;
        overflow: hidden;
    }

    /* Decorative Elements */
    .forgot-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(236, 72, 153, 0.03) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
        pointer-events: none;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    /* Header Section */
    .forgot-header {
        text-align: center;
        margin-bottom: 32px;
        position: relative;
    }

    .icon-circle {
        width: 88px;
        height: 88px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
        box-shadow: 0 20px 30px -10px rgba(236, 72, 153, 0.4);
        position: relative;
        animation: pulseIcon 2s infinite;
    }

    @keyframes pulseIcon {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .icon-circle i {
        font-size: 40px;
        color: white;
        filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
    }

    .forgot-header h1 {
        font-size: 32px;
        font-weight: 800;
        background: linear-gradient(135deg, #1a1a1a 0%, #4a4a4a 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 12px;
        letter-spacing: -0.5px;
    }

    .forgot-header p {
        color: #6b7280;
        font-size: 15px;
        line-height: 1.6;
        max-width: 320px;
        margin: 0 auto;
    }

    /* Tab Container */
    .tab-wrapper {
        background: #f3f4f6;
        padding: 6px;
        border-radius: 60px;
        margin-bottom: 32px;
        display: flex;
        gap: 6px;
        position: relative;
    }

    .tab-btn {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 20px;
        border: none;
        border-radius: 50px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: transparent;
        color: #6b7280;
        position: relative;
        z-index: 1;
    }

    .tab-btn i {
        font-size: 16px;
        transition: transform 0.3s ease;
    }

    .tab-btn:hover i {
        transform: translateY(-2px);
    }

    .tab-btn.active {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        box-shadow: 0 10px 20px -5px rgba(236, 72, 153, 0.4);
    }

    /* Form Groups */
    .form-group {
        margin-bottom: 28px;
        transition: all 0.3s ease;
    }

    .form-group.hidden {
        display: none;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        letter-spacing: 0.3px;
    }

    .input-wrapper {
        position: relative;
        transition: all 0.3s ease;
    }

    .input-icon {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 18px;
        transition: all 0.3s ease;
        z-index: 2;
    }

    .form-input {
        width: 100%;
        padding: 16px 18px 16px 52px;
        border: 2px solid #e5e7eb;
        border-radius: 20px;
        font-size: 15px;
        transition: all 0.3s ease;
        background: white;
        color: #1f2937;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(236, 72, 153, 0.1);
    }

    .form-input:hover:not(:focus) {
        border-color: var(--secondary);
    }

    .input-wrapper:focus-within .input-icon {
        color: var(--primary);
        transform: translateY(-50%) scale(1.1);
    }

    /* Error States */
    .form-input.error {
        border-color: var(--error);
        background-color: #fef2f2;
    }

    .error-message {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-top: 8px;
        color: var(--error);
        font-size: 13px;
        font-weight: 500;
        animation: slideInError 0.3s ease-out;
        padding-left: 4px;
    }

    @keyframes slideInError {
        from {
            opacity: 0;
            transform: translateY(-5px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .error-message i {
        font-size: 14px;
    }

    /* Success Message */
    .success-alert {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        padding: 16px 20px;
        border-radius: 20px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        animation: slideDown 0.4s ease-out;
        box-shadow: 0 10px 20px -5px rgba(16, 185, 129, 0.4);
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

    .success-alert i {
        font-size: 20px;
    }

    .success-alert span {
        font-size: 14px;
        font-weight: 500;
        flex: 1;
    }

    /* Submit Button */
    .submit-btn {
        width: 100%;
        padding: 18px 24px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        border: none;
        border-radius: 60px;
        font-size: 16px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 15px 25px -8px rgba(236, 72, 153, 0.4);
        position: relative;
        overflow: hidden;
    }

    .submit-btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .submit-btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .submit-btn:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 20px 30px -8px rgba(236, 72, 153, 0.5);
    }

    .submit-btn:active:not(:disabled) {
        transform: translateY(0);
    }

    .submit-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    /* Footer Links */
    .footer-links {
        text-align: center;
        margin-top: 28px;
        padding-top: 20px;
        border-top: 2px solid #f3f4f6;
    }

    .back-link {
        color: #6b7280;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        padding: 8px 16px;
        border-radius: 40px;
    }

    .back-link:hover {
        color: var(--primary);
        background: #fef2f8;
        transform: translateX(-5px);
    }

    .back-link i {
        font-size: 14px;
        transition: transform 0.3s ease;
    }

    .back-link:hover i {
        transform: translateX(-3px);
    }

    /* Loading Animation */
    .fa-spinner {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    /* Mobile Responsive Design */
    @media (max-width: 480px) {
        .forgot-page-wrapper {
            padding: 12px;
            align-items: flex-start;
            padding-top: 20px;
        }

        .forgot-card {
            padding: 30px 20px;
            border-radius: 28px;
        }

        .icon-circle {
            width: 72px;
            height: 72px;
            margin-bottom: 20px;
        }

        .icon-circle i {
            font-size: 32px;
        }

        .forgot-header h1 {
            font-size: 26px;
        }

        .forgot-header p {
            font-size: 14px;
            padding: 0 10px;
        }

        .tab-btn {
            padding: 12px 10px;
            font-size: 14px;
            gap: 6px;
        }

        .tab-btn i {
            font-size: 14px;
        }

        .form-input {
            padding: 14px 14px 14px 48px;
            font-size: 14px;
        }

        .input-icon {
            left: 16px;
            font-size: 16px;
        }

        .submit-btn {
            padding: 16px 20px;
            font-size: 15px;
        }

        .success-alert {
            padding: 14px 16px;
        }
    }

    /* Extra Small Devices */
    @media (max-width: 360px) {
        .forgot-card {
            padding: 24px 16px;
        }

        .tab-btn {
            padding: 10px 8px;
            font-size: 13px;
        }

        .tab-btn i {
            display: none;
        }

        .forgot-header h1 {
            font-size: 22px;
        }

        .icon-circle {
            width: 64px;
            height: 64px;
        }

        .icon-circle i {
            font-size: 28px;
        }
    }

    /* Landscape Mode */
    @media (max-height: 600px) and (orientation: landscape) {
        .forgot-page-wrapper {
            align-items: center;
            padding: 20px;
        }

        .forgot-card {
            padding: 20px;
        }

        .icon-circle {
            width: 56px;
            height: 56px;
            margin-bottom: 12px;
        }

        .icon-circle i {
            font-size: 24px;
        }

        .forgot-header {
            margin-bottom: 16px;
        }

        .form-group {
            margin-bottom: 16px;
        }
    }

    /* Tablet Devices */
    @media (min-width: 481px) and (max-width: 768px) {
        .forgot-card-container {
            max-width: 440px;
        }

        .forgot-card {
            padding: 36px 28px;
        }
    }

    /* Ensure no layout shift */
    .hidden {
        display: none !important;
    }
</style>

<!-- Main Wrapper - Forces centering regardless of layout -->
<div class="forgot-page-wrapper">
    <div class="forgot-card-container">
        <div class="forgot-card">
            <!-- Header with Icon -->
            <div class="forgot-header">
                <div class="icon-circle">
                    <i class="fas fa-lock"></i>
                </div>
                <h1>Forgot Password?</h1>
                <p>Choose your preferred method to reset your password securely</p>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="success-alert">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Tab Selector -->
            <div class="tab-wrapper">
                <button type="button" id="emailTab" onclick="switchTab('email')" class="tab-btn active">
                    <i class="fas fa-envelope"></i>
                    <span>Email</span>
                </button>
                <button type="button" id="phoneTab" onclick="switchTab('phone')" class="tab-btn">
                    <i class="fas fa-mobile-alt"></i>
                    <span>Mobile</span>
                </button>
            </div>

            <!-- Form -->
            <form action="{{ route('web.forgot-password.send-otp') }}" method="POST" id="forgotPasswordForm" novalidate>
                @csrf
                
                <!-- Email Field -->
                <div id="emailField" class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               class="form-input @error('email') error @enderror" 
                               placeholder="name@example.com"
                               value="{{ old('email') }}"
                               autocomplete="off"
                               aria-label="Email address">
                    </div>
                    <div class="error-message hidden" id="emailError">
                        <i class="fas fa-exclamation-circle"></i>
                        <span></span>
                    </div>
                    @error('email')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <!-- Phone Field -->
                <div id="phoneField" class="form-group hidden">
                    <label for="phone" class="form-label">Mobile Number</label>
                    <div class="input-wrapper">
                        <i class="fas fa-mobile-alt input-icon"></i>
                        <input type="tel" 
                               id="phone" 
                               name="phone" 
                               class="form-input @error('phone') error @enderror" 
                               placeholder="+1 234 567 8900"
                               value="{{ old('phone') }}"
                               autocomplete="off"
                               aria-label="Phone number">
                    </div>
                    <div class="error-message hidden" id="phoneError">
                        <i class="fas fa-exclamation-circle"></i>
                        <span></span>
                    </div>
                    @error('phone')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="submit-btn" id="submitBtn">
                    <i class="fas fa-paper-plane"></i>
                    <span>Send Reset Code</span>
                </button>
            </form>

            <!-- Footer -->
            <div class="footer-links">
                <a href="{{ route('login') }}" class="back-link">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Login</span>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    'use strict';

    // DOM Elements
    const elements = {
        emailTab: document.getElementById('emailTab'),
        phoneTab: document.getElementById('phoneTab'),
        emailField: document.getElementById('emailField'),
        phoneField: document.getElementById('phoneField'),
        emailInput: document.getElementById('email'),
        phoneInput: document.getElementById('phone'),
        emailError: document.getElementById('emailError'),
        phoneError: document.getElementById('phoneError'),
        form: document.getElementById('forgotPasswordForm'),
        submitBtn: document.getElementById('submitBtn')
    };

    // Validation Functions
    const validators = {
        email: (email) => {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email.trim());
        },
        
        phone: (phone) => {
            // International phone number validation
            const cleaned = phone.replace(/[\s\-\(\)]/g, '');
            const re = /^[\+]?[0-9]{10,15}$/;
            return re.test(cleaned);
        }
    };

    // UI Functions
    const ui = {
        hideAllErrors: () => {
            document.querySelectorAll('.error-message').forEach(el => {
                el.classList.add('hidden');
            });
            document.querySelectorAll('.form-input').forEach(el => {
                el.classList.remove('error');
            });
        },

        showError: (field, message) => {
            const errorDiv = field === 'email' ? elements.emailError : elements.phoneError;
            const input = field === 'email' ? elements.emailInput : elements.phoneInput;
            
            errorDiv.querySelector('span').textContent = message;
            errorDiv.classList.remove('hidden');
            input.classList.add('error');
        },

        setLoading: (isLoading) => {
            if (isLoading) {
                elements.submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Sending...</span>';
                elements.submitBtn.disabled = true;
            } else {
                elements.submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i><span>Send Reset Code</span>';
                elements.submitBtn.disabled = false;
            }
        },

        clearFields: () => {
            if (!elements.emailField.classList.contains('hidden')) {
                elements.phoneInput.value = '';
                elements.phoneInput.required = false;
            } else {
                elements.emailInput.value = '';
                elements.emailInput.required = false;
            }
        }
    };

    // Tab Switching
    window.switchTab = function(type) {
        ui.hideAllErrors();
        
        if (type === 'email') {
            // Update tabs
            elements.emailTab.classList.add('active');
            elements.phoneTab.classList.remove('active');
            
            // Show/hide fields
            elements.emailField.classList.remove('hidden');
            elements.phoneField.classList.add('hidden');
            
            // Update required attributes
            elements.emailInput.required = true;
            elements.phoneInput.required = false;
            
            // Clear phone field
            elements.phoneInput.value = '';
            
            // Focus email input
            setTimeout(() => elements.emailInput.focus(), 100);
        } else {
            // Update tabs
            elements.phoneTab.classList.add('active');
            elements.emailTab.classList.remove('active');
            
            // Show/hide fields
            elements.phoneField.classList.remove('hidden');
            elements.emailField.classList.add('hidden');
            
            // Update required attributes
            elements.phoneInput.required = true;
            elements.emailInput.required = false;
            
            // Clear email field
            elements.emailInput.value = '';
            
            // Focus phone input
            setTimeout(() => elements.phoneInput.focus(), 100);
        }
    };

    // Form Validation
    elements.form.addEventListener('submit', function(e) {
        e.preventDefault();
        ui.hideAllErrors();
        
        const isEmailActive = !elements.emailField.classList.contains('hidden');
        let isValid = true;
        
        if (isEmailActive) {
            const email = elements.emailInput.value.trim();
            
            if (!email) {
                ui.showError('email', 'Email address is required');
                isValid = false;
            } else if (!validators.email(email)) {
                ui.showError('email', 'Please enter a valid email address');
                isValid = false;
            }
        } else {
            const phone = elements.phoneInput.value.trim();
            
            if (!phone) {
                ui.showError('phone', 'Mobile number is required');
                isValid = false;
            } else if (!validators.phone(phone)) {
                ui.showError('phone', 'Please enter a valid mobile number');
                isValid = false;
            }
        }
        
        if (isValid) {
            ui.setLoading(true);
            ui.clearFields();
            this.submit();
        }
    });

    // Real-time Validation
    elements.emailInput.addEventListener('input', function() {
        if (this.value.trim() && !validators.email(this.value.trim())) {
            ui.showError('email', 'Please enter a valid email address');
        } else {
            elements.emailError.classList.add('hidden');
            this.classList.remove('error');
        }
    });

    elements.phoneInput.addEventListener('input', function() {
        if (this.value.trim() && !validators.phone(this.value.trim())) {
            ui.showError('phone', 'Please enter a valid mobile number');
        } else {
            elements.phoneError.classList.add('hidden');
            this.classList.remove('error');
        }
    });

    // Prevent form submission on enter in inactive field
    elements.emailInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && elements.emailField.classList.contains('hidden')) {
            e.preventDefault();
        }
    });

    elements.phoneInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && elements.phoneField.classList.contains('hidden')) {
            e.preventDefault();
        }
    });

    // Handle back button
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            ui.setLoading(false);
        }
    });

    // Initialize based on old input
    if (elements.phoneInput.value.trim()) {
        switchTab('phone');
    }
})();
</script>
@endsection