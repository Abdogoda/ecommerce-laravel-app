@extends('layouts.auth-app')

@section('content')
    <div class="w-full max-w-md animate-scale-in">
        <!-- Logo Section -->
        <div class="text-center mb-8 animate-bounce-in">
            <a href="{{ route('home') }}"
                class="text-4xl font-bold text-white hover:text-blue-200 transition-colors duration-300 animate-fade-in-down mb-3 flex items-center justify-center">
                <i class="fas fa-store mr-2 text-blue-200"></i>E-Commerce
            </a>
            <p class="text-blue-100">Enter your email to receive a reset link</p>
        </div>

        <!-- Forgot Password Form -->
        <div class="glass rounded-2xl p-8 shadow-2xl animate-fade-in-up" style="animation-delay: 0.3s">
            <form action="#" method="POST" id="forgot-password-form" class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-semibold text-white mb-2">
                        <i class="fas fa-envelope mr-2 text-orange-300"></i>Email
                        Address
                    </label>
                    <input type="email" id="email" name="email" autofocus autocomplete="email"
                        class="input-focus w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-transparent transition-all duration-300"
                        placeholder="Enter your email address" required />
                    <div id="email-error" class="text-red-300 text-sm mt-2 hidden flex items-center">
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        <span></span>
                    </div>
                </div>

                <button type="submit"
                    class="w-full py-4 bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700 rounded-xl font-semibold text-white transition-all duration-300 hover:shadow-lg hover:shadow-orange-500/25 transform hover:scale-105 flex items-center justify-center">
                    <i class="fas fa-paper-plane mr-2"></i>
                    <span>Send Reset Link</span>
                </button>

                <div class="text-center space-y-2">
                    <p class="text-white/60 text-sm">
                        Remember your password?
                        <a href="{{ route('login') }}"
                            class="text-orange-300 hover:text-orange-200 font-semibold transition-colors duration-300 hover:underline">
                            Sign In
                        </a>
                    </p>
                    <p class="text-white/60 text-sm">
                        Don't have an account?
                        <a href="{{ route('register') }}"
                            class="text-orange-300 hover:text-orange-200 font-semibold transition-colors duration-300 hover:underline">
                            Create One
                        </a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Help Section -->
        <div class="text-center mt-6 animate-fade-in-up" style="animation-delay: 0.5s">
            <div class="glass rounded-xl p-4 mb-4">
                <h3 class="text-white font-semibold mb-2">
                    <i class="fas fa-info-circle mr-2 text-orange-300"></i>
                    Need Help?
                </h3>
                <p class="text-white/70 text-sm">
                    If you don't receive an email within a few minutes, check your
                    spam folder or contact our support team.
                </p>
            </div>

            <div class="flex justify-center space-x-6 text-sm">
                <a href="#" class="text-white/60 hover:text-white transition-colors duration-300">
                    <i class="fas fa-shield-alt mr-1"></i>Security
                </a>
                <a href="#" class="text-white/60 hover:text-white transition-colors duration-300">
                    <i class="fas fa-life-ring mr-1"></i>Support
                </a>
                <a href="#" class="text-white/60 hover:text-white transition-colors duration-300">
                    <i class="fas fa-question-circle mr-1"></i>FAQ
                </a>
            </div>
        </div>
    </div>
@endsection
