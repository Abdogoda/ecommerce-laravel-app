@extends('layouts.auth-app')

@section('content')
    <div class="w-full max-w-md animate-scale-in">
        <!-- Logo Section -->
        <div class="text-center mb-8 animate-bounce-in">
            <a href="{{ route('home') }}"
                class="text-4xl font-bold text-white hover:text-blue-200 transition-colors duration-300 animate-fade-in-down mb-3 flex items-center justify-center">
                <i class="fas fa-store mr-2 text-blue-200"></i>E-Commerce
            </a>
            <p class="text-blue-100">Create a new secure password</p>
        </div>

        <!-- Reset Password Form -->
        <div class="glass rounded-2xl p-8 shadow-2xl animate-fade-in-up" style="animation-delay: 0.3s">
            <form action="{{ route('password.update') }}" method="POST" id="reset-password-form" class="space-y-6">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}" />

                <div>
                    <label for="email" class="block text-sm font-semibold text-white mb-2">
                        <i class="fas fa-envelope mr-2 text-purple-300"></i>Email
                        Address
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" autofocus
                        autocomplete="email"
                        class="input-focus w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent transition-all duration-300"
                        placeholder="Enter your email address" required />
                    @error('email')
                        <div id="email-error" class="text-red-300 text-sm mt-2 flex items-center">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-white mb-2">
                        <i class="fas fa-lock mr-2 text-purple-300"></i>New Password
                    </label>
                    <div class="relative">
                        <input type="password" id="password" name="password" autocomplete="new-password"
                            class="input-focus w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent transition-all duration-300 pr-12"
                            placeholder="Enter new password" required />
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
                        <i class="fas fa-check-double mr-2 text-purple-300"></i>Confirm
                        Password
                    </label>
                    <div class="relative">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            autocomplete="new-password"
                            class="input-focus w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent transition-all duration-300 pr-12"
                            placeholder="Confirm new password" required />
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

                <button type="submit"
                    class="w-full py-4 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 rounded-xl font-semibold text-white transition-all duration-300 hover:shadow-lg hover:shadow-purple-500/25 transform hover:scale-105 flex items-center justify-center">
                    <i class="fas fa-shield-alt mr-2"></i>
                    <span>Update Password</span>
                </button>
            </form>
        </div>

        <!-- Security Tips -->
        <div class="text-center mt-6 animate-fade-in-up" style="animation-delay: 0.5s">
            <div class="glass rounded-xl p-4 mb-4">
                <h3 class="text-white font-semibold mb-3">
                    <i class="fas fa-shield-alt mr-2 text-purple-300"></i>
                    Password Security Tips
                </h3>
                <div class="text-white/70 text-sm space-y-1">
                    <p>
                        <i class="fas fa-check text-green-400 mr-2"></i>Use at least 8
                        characters
                    </p>
                    <p>
                        <i class="fas fa-check text-green-400 mr-2"></i>Include
                        uppercase and lowercase letters
                    </p>
                    <p>
                        <i class="fas fa-check text-green-400 mr-2"></i>Add numbers and
                        special characters
                    </p>
                </div>
            </div>
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
