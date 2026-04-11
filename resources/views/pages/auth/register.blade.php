@extends('layouts.auth-app')

@section('content')
    <div class="w-full max-w-lg animate-scale-in">
        <!-- Logo Section -->
        <div class="text-center mb-8 animate-bounce-in">
            <a href="{{ route('home') }}"
                class="text-4xl font-bold text-white hover:text-blue-200 transition-colors duration-300 animate-fade-in-down mb-3 flex items-center justify-center">
                <i class="fas fa-store mr-2 text-blue-200"></i>E-Commerce
            </a>
            <p class="text-blue-100">Create your account to get started</p>
        </div>

        <!-- Register Form -->
        <div class="glass rounded-2xl p-8 shadow-2xl animate-fade-in-up mb-5" style="animation-delay: 0.3s">
            <!-- Success/Error Messages -->
            <div id="message-container" class="mb-6"></div>

            <form action="{{ route('register') }}" method="POST" id="register-form" class="space-y-6">
                @csrf
                <div class="space-y-4">
                    <!-- Full Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-white mb-2">
                            <i class="fas fa-user mr-2 text-green-300"></i>Full Name
                        </label>
                        <input type="text" id="name" name="name" autofocus autocomplete="name" required
                            class="input-focus w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition-all duration-300"
                            placeholder="Enter your full name" />
                        @error('name')
                            <div id="name-error" class="text-red-300 text-sm mt-2 flex items-center">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Email and Phone Row -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="email" class="block text-sm font-semibold text-white mb-2">
                                <i class="fas fa-envelope mr-2 text-green-300"></i>Email
                            </label>
                            <input type="email" id="email" name="email" autocomplete="email" required
                                class="input-focus w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition-all duration-300"
                                placeholder="your@email.com" />
                            @error('email')
                                <div id="email-error" class="text-red-300 text-sm mt-2 flex items-center">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-semibold text-white mb-2">
                                <i class="fas fa-phone mr-2 text-green-300"></i>Phone
                            </label>
                            <input type="tel" id="phone" name="phone" autocomplete="tel"
                                class="input-focus w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition-all duration-300"
                                placeholder="+1 234 567 8900" />
                            @error('phone')
                                <div id="phone-error" class="text-red-300 text-sm mt-2 flex items-center">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Password and Confirm Password Row -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-sm font-semibold text-white mb-2">
                                <i class="fas fa-lock mr-2 text-green-300"></i>Password
                            </label>
                            <div class="relative">
                                <input type="password" id="password" name="password" autocomplete="new-password"
                                    class="input-focus w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition-all duration-300 pr-12"
                                    placeholder="Create password" />
                                <button type="button"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-white/60 hover:text-white transition-colors duration-300"
                                    onclick="togglePassword('password')">
                                    <i class="fas fa-eye" id="password-toggle"></i>
                                </button>
                            </div>
                            @error('password')
                                <div id="password-error" class="text-red-300 text-sm mt-2 flex items-center">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-white mb-2">
                                <i class="fas fa-lock mr-2 text-green-300"></i>Confirm
                            </label>
                            <div class="relative">
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    autocomplete="new-password"
                                    class="input-focus w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition-all duration-300 pr-12"
                                    placeholder="Confirm password" />
                                <button type="button"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-white/60 hover:text-white transition-colors duration-300"
                                    onclick="togglePassword('password_confirmation')">
                                    <i class="fas fa-eye" id="password_confirmation-toggle"></i>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <div id="password_confirmation-error" class="text-red-300 text-sm mt-2 flex items-center">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <button type="submit"
                    class="w-full py-4 bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-700 hover:to-blue-700 rounded-xl font-semibold text-white transition-all duration-300 hover:shadow-lg hover:shadow-green-500/25 transform hover:scale-105 flex items-center justify-center">
                    <i class="fas fa-user-plus mr-2"></i>
                    <span>Create Account</span>
                </button>

                <div class="text-center">
                    <p class="text-white/60 text-sm">
                        Already have an account?
                        <a href="{{ route('login') }}"
                            class="text-green-300 hover:text-green-200 font-semibold transition-colors duration-300 hover:underline">
                            Sign In
                        </a>
                    </p>
                </div>
            </form>
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
@endsection
