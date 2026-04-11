@extends('layouts.auth-app')

@section('content')
<div class="w-full max-w-md animate-scale-in">
        <!-- Logo Section -->
        <div class="text-center mb-8 animate-bounce-in">
          <a
            href="../user/home.html"
            class="text-4xl font-bold text-white hover:text-blue-200 transition-colors duration-300 animate-fade-in-down mb-3 flex items-center justify-center"
          >
            <i class="fas fa-store mr-2 text-blue-200"></i>E-Commerce
          </a>
          <p class="text-blue-100">Sign in to your account to continue</p>
        </div>

        <!-- Login Form -->
        <div
          class="glass rounded-2xl p-8 shadow-2xl animate-fade-in-up mb-5"
          style="animation-delay: 0.3s"
        >
          <!-- Success/Error Messages -->
          <div id="message-container" class="mb-6"></div>

          <form action="/login" method="POST" class="space-y-6" id="login-form">
            <div class="space-y-4">
              <div>
                <label
                  for="email"
                  class="block text-sm font-semibold text-white mb-2"
                >
                  <i class="fas fa-envelope mr-2 text-blue-300"></i>Email
                  Address
                </label>
                <input
                  type="email"
                  id="email"
                  name="email"
                  autocomplete="email"
                  autofocus
                  required
                  class="input-focus w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-300"
                  placeholder="Enter your email"
                />
                <div
                  id="email-error"
                  class="text-red-300 text-sm mt-2 hidden flex items-center"
                >
                  <i class="fas fa-exclamation-triangle mr-1"></i>
                  <span></span>
                </div>
              </div>

              <div>
                <label
                  for="password"
                  class="block text-sm font-semibold text-white mb-2"
                >
                  <i class="fas fa-lock mr-2 text-blue-300"></i>Password
                </label>
                <div class="relative">
                  <input
                    type="password"
                    id="password"
                    name="password"
                    autocomplete="current-password"
                    required
                    class="input-focus w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-300 pr-12"
                    placeholder="Enter your password"
                  />
                  <button
                    type="button"
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-white/60 hover:text-white transition-colors duration-300"
                    onclick="togglePassword('password')"
                  >
                    <i class="fas fa-eye" id="password-toggle"></i>
                  </button>
                </div>
                <div
                  id="password-error"
                  class="text-red-300 text-sm mt-2 hidden flex items-center"
                >
                  <i class="fas fa-exclamation-triangle mr-1"></i>
                  <span></span>
                </div>
              </div>
            </div>

            <div class="flex items-center justify-between">
              <div class="flex items-center">
                <input
                  type="checkbox"
                  name="remember"
                  id="remember"
                  class="w-4 h-4 bg-white/10 border-white/20 rounded focus:ring-2 focus:ring-blue-400"
                />
                <label for="remember" class="ml-2 text-sm text-white/80">
                  Remember me
                </label>
              </div>
              <a
                href="../auth/forgot-password.html"
                class="text-sm text-blue-300 hover:text-blue-200 transition-colors duration-300 hover:underline"
              >
                Forgot password?
              </a>
            </div>

            <button
              type="submit"
              class="w-full py-4 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 rounded-xl font-semibold text-white transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/25 transform hover:scale-105 flex items-center justify-center"
            >
              <i class="fas fa-sign-in-alt mr-2"></i>
              <span>Sign In</span>
            </button>

            <div class="text-center">
              <p class="text-white/60 text-sm">
                Don't have an account?
                <a
                  href="../auth/register.html"
                  class="text-blue-300 hover:text-blue-200 font-semibold transition-colors duration-300 hover:underline"
                >
                  Create Account
                </a>
              </p>
            </div>
          </form>
        </div>
        <div class="flex justify-center space-x-6 text-sm">
          <a
            href="#"
            class="text-white/60 hover:text-white transition-colors duration-300"
          >
            <i class="fas fa-shield-alt mr-1"></i>Security
          </a>
          <a
            href="#"
            class="text-white/60 hover:text-white transition-colors duration-300"
          >
            <i class="fas fa-life-ring mr-1"></i>Support
          </a>
          <a
            href="#"
            class="text-white/60 hover:text-white transition-colors duration-300"
          >
            <i class="fas fa-question-circle mr-1"></i>FAQ
          </a>
        </div>
      </div>
@endsection
