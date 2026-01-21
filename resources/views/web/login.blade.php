@extends('layout.web.main-layout')








@section('content')

<style>
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
    </style>

  <section class="px-4 lgg:py-12 py-6">
        <div class="container mx-auto">
            
            <!-- Login Form -->
            <div class="w-full max-w-md mx-auto ">
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-900">Welcome Back</h2>
                        <p class="mt-2 text-gray-600">Sign in to your StyleHub account</p>
                    </div>

                    <!-- Social Login Options -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <button class="flex items-center justify-center gap-2 py-3 px-4 border border-gray-300 rounded-xl hover:bg-gray-50 transition duration-200">
                            <svg class="w-5 h-5" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                            <span class="text-sm font-medium">Google</span>
                        </button>
                        <button class="flex items-center justify-center gap-2 py-3 px-4 border border-gray-300 rounded-xl hover:bg-gray-50 transition duration-200">
                            <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
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

                    <form class="space-y-5" id="loginForm">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input type="email" id="email" name="email" required 
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl input-focus transition duration-200"
                                    placeholder="you@example.com">
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                <a href="#" class="text-sm text-purple-600 hover:text-purple-500">Forgot password?</a>
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
                        </div>

                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox" 
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

                    <!-- Security Notice -->
                    <div class="mt-6 p-4 bg-blue-50 rounded-xl border border-blue-100">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-shield-alt text-blue-500"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800">Secure Login</h3>
                                <div class="mt-1 text-sm text-blue-700">
                                    <p>Your information is protected with 256-bit SSL encryption.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

           
        </div>
    </section>



<script src="{{asset('web/js/login.js')}}"></script>


@endsection