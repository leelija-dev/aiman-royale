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
</style>

<main class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="container mx-auto flex justify-center items-center">

        <!-- Registration Form -->
        <div class=" max-w-xl  ">
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900">Create Your Account</h2>
                    <p class="mt-2 text-gray-600">Join StyleHub and discover your perfect style</p>
                </div>

                <!-- Social Login Options -->
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <button class="flex items-center justify-center gap-2 py-3 px-4 border border-gray-300 rounded-xl hover:bg-gray-50 transition">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                        </svg>
                        <span class="text-sm font-medium">Google</span>
                    </button>
                    <button class="flex items-center justify-center gap-2 py-3 px-4 border border-gray-300 rounded-xl hover:bg-gray-50 transition">
                        <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                        <span class="text-sm font-medium">Facebook</span>
                    </button>
                </div>

                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Or continue with email</span>
                    </div>
                </div>

                <form action="{{ route('web.register.add') }}" method="post" id="registerForm" class="space-y-5"  novalidate >
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="firstName" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                            <input type="text" id="firstName" name="firstName" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition">
                        <p class="error text-red-500 text-xs mt-1 hidden"></p>
                        @error('firstName')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        </div>
                        <div>
                            <label for="lastName" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                            <input type="text" id="lastName" name="lastName" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition">
                       <p class="error text-red-500 text-xs mt-1 hidden"></p>
                        @error('lastName')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" id="email" name="email" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition">
                        <p class="error text-red-500 text-xs mt-1 hidden"></p>
                         @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                            Password
                        </label>

                        <div class="relative">
                            <input type="password" id="password" name="password" 
                                class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl 
                                    focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition">
                            
                            <button type="button" id="togglePassword"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                            </button>
                             
                        </div>
                        <p id="passwordError" class="text-red-500 text-sm mt-1 hidden"></p>
                        
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                          <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                        <div class="relative">

                            <input type="password" id="confirmPassword" name="confirmPassword" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition">
                            <button type="button" id="togglePassword1"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <i class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                            </button>

                        </div>
                        <p id="confirmPasswordError" class="text-red-500 text-sm mt-1 hidden"></p>
                        <p class="error text-red-500 text-xs mt-1 hidden"></p>
                        @error('confirmPassword')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input id="newsletter" name="newsletter" type="checkbox"
                            class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="newsletter" class="ml-2 block text-sm text-gray-700">
                            Send me style tips, trends, and exclusive offers (optional)
                        </label>
                        @error('newsletter')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input id="terms" name="terms" type="checkbox" 
                            class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="terms" class="ml-2 block text-sm text-gray-700">
                            I agree to the <a href="#" class="text-purple-600 hover:text-purple-500">Terms of Service</a> and <a href="#" class="text-purple-600 hover:text-purple-500">Privacy Policy</a>
                        </label>
                        @error('terms')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full py-3 px-4 fashion-gradient text-white font-medium rounded-xl shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition duration-200">
                        Create Account
                    </button>
                </form>
            </div>
        </div>


    </div>
</main>



<script src="{{asset('web/js/register.js')}}"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const togglePassword = document.getElementById("togglePassword");
         const togglePassword1 = document.getElementById("togglePassword1");
        const passwordInput = document.getElementById("password");
        const passwordInput1 = document.getElementById("confirmPassword");

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
        if (togglePassword1 && passwordInput1) {

            togglePassword1.addEventListener("click", function() {

                const icon = this.querySelector("i");

                if (passwordInput1.type === "password") {
                    passwordInput1.type = "text";
                    icon.classList.remove("fa-eye");
                    icon.classList.add("fa-eye-slash");
                } else {
                    passwordInput1.type = "password";
                    icon.classList.remove("fa-eye-slash");
                    icon.classList.add("fa-eye");
                }
               

            });

        }


    });
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("registerForm");

    const firstName = document.getElementById("firstName");
    const lastName = document.getElementById("lastName");
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirmPassword");

    function showError(input, message) {
        const parent = input.closest("div");
        const error = parent.querySelector(".error");

        if (error) {
            error.textContent = message;
            error.classList.remove("hidden");
        }

        input.classList.add("border-red-500");
    }

    function clearError(input) {
        const parent = input.closest("div");
        const error = parent.querySelector(".error");

        if (error) {
            error.textContent = "";
            error.classList.add("hidden");
        }

        input.classList.remove("border-red-500");
    }

    function validateEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }
  password.addEventListener('input', function () {
        passwordError.classList.add('hidden');
    });

    confirmPassword.addEventListener('input', function () {
        confirmPasswordError.classList.add('hidden');
    });
    form.addEventListener("submit", function (e) {

        let valid = true;

        // First Name
        if (firstName.value.trim() === "") {
            showError(firstName, "First name is required");
            valid = false;
        } else {
            clearError(firstName);
        }

        // Last Name
        if (lastName.value.trim() === "") {
            showError(lastName, "Last name is required");
            valid = false;
        } else {
            clearError(lastName);
        }

        // Email
        if (!validateEmail(email.value.trim())) {
            showError(email, "Enter a valid email address");
            valid = false;
        } else {
            clearError(email);
        }

        // Password
        if (password.value.length < 8) {
            showError(password, "Password must be at least 8 characters long.");
            valid = false;
        } else {
            clearError(password);
        }

        // Confirm Password
        if (confirmPassword.value !== password.value) {
            showError(confirmPassword, "Passwords do not match");
            valid = false;
        } else {
            clearError(confirmPassword);
        }

        if (!valid) {
            e.preventDefault();
        }

    });

});
</script>
@endsection