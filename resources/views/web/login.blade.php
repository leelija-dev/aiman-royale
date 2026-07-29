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

    .input-focus:focus {
        box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.2);
        border-color: #a855f7;
    }

    /* Google Button Styles */
    .google-btn {
        background: #ffffff;
        color: #333;
        border: 2px solid #e0e0e0;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        padding: 14px 20px;
        border-radius: 12px;
        font-weight: 600;
        width: 100%;
        text-decoration: none;
        font-size: 15px;
    }

    .google-btn:hover {
        background: #f8f9fa;
        border-color: #a855f7;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(168, 85, 247, 0.2);
        text-decoration: none;
        color: #333;
    }

    .google-btn:active {
        transform: translateY(0);
    }

    .google-btn i {
        font-size: 22px;
    }

    .divider {
        display: flex;
        align-items: center;
        text-align: center;
        margin: 20px 0;
    }

    .divider::before,
    .divider::after {
        content: '';
        flex: 1;
        border-bottom: 1px solid #e5e7eb;
    }

    .divider:not(:empty)::before {
        margin-right: 15px;
    }

    .divider:not(:empty)::after {
        margin-left: 15px;
    }

    .divider-text {
        color: #9ca3af;
        font-size: 14px;
        font-weight: 500;
        background: white;
        padding: 0 10px;
    }

    /* Alert Messages */
    .alert {
        padding: 12px 16px;
        border-radius: 10px;
        margin-bottom: 16px;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-success {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
    }

    .alert-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
    }

    .alert i {
        font-size: 18px;
    }
</style>

<section class="px-4 lgg:py-12 py-6">
    <div class="container mx-auto">

        <!-- Login Form -->
        <div class="w-full max-w-md mx-auto">
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900">Welcome Back</h2>
                    <p class="mt-2 text-gray-600">Sign in to your account</p>
                </div>

                <!-- Display Success/Error Messages -->
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <!-- Google Login Button -->
                <a href="{{ route('google.redirect') }}" class="google-btn">
                    <i class="fab fa-google" style="color: #ea4335;"></i>
                    <span>Continue with Google</span>
                </a>

                <!-- Divider -->
                <div class="divider">
                    <span class="divider-text">or continue with email</span>
                </div>

                <!-- Email/Password Login Form -->
                <form action="{{ route('web.login') }}" method="post" class="space-y-5" id="loginForm" novalidate>
                    @csrf
                    <input type="hidden" name="redirect" value="{{ request('redirect') }}">
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" id="email" name="email" required
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl input-focus transition duration-200"
                                placeholder="you@example.com" value="{{ old('email') }}">
                        </div>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <a href="{{ route('page.forgot-password') }}" class="text-sm text-purple-600 hover:text-purple-500">Forgot password?</a>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input type="password" id="password" name="password" required
                                class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-xl input-focus transition duration-200"
                                placeholder="Enter your password">
                            <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" value="1"
                            class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Remember me for 30 days
                        </label>
                    </div>

                    <button type="submit"
                        class="w-full py-3 px-4 fashion-gradient text-white font-medium rounded-xl shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200 flex items-center justify-center">
                        <span>Sign In</span>
                        <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </form>

              
                
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Don't have an account?
                        <a href="{{ route('page.register') }}"
                            class="text-purple-600 font-medium hover:text-purple-500">
                            Create one
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

<script>
    (function() {
        'use strict'
        const form = document.getElementById('loginForm');
        if (form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        }
    })();

    document.addEventListener("DOMContentLoaded", function() {
        const togglePassword = document.getElementById("togglePassword");
        const passwordInput = document.getElementById("password");

        if (togglePassword && passwordInput) {
            togglePassword.addEventListener("click", function() {
                const icon = this.querySelector("i");
                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                    icon.classList.remove("fa-eye");
                    icon.classList.add("fa-eye-slash");
                } else {
                    passwordInput.type = "password";
                    icon.classList.remove("fa-eye-slash");
                    icon.classList.add("fa-eye");
                }
            });
        }
    });
</script>