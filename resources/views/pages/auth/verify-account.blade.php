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
          <p class="text-blue-100">Enter the 6-digit code sent to your email</p>
        </div>

        <!-- Verify Account Form -->
        <div
          class="glass rounded-2xl p-8 shadow-2xl animate-fade-in-up"
          style="animation-delay: 0.3s"
        >
          <form id="otp-form" action="#" method="POST" class="space-y-6">
            <input type="hidden" name="email" value="user@example.com" />
            <input type="hidden" name="otp" id="otp-value" />
            <div class="text-center">
              <label class="block text-sm font-semibold text-white mb-4">
                <i class="fas fa-key mr-2 text-green-300"></i>Verification Code
              </label>

              <!-- OTP Input Fields -->
              <div
                class="flex justify-center space-x-3 mb-4"
                id="otp-container"
              >
                <input
                  type="text"
                  maxlength="1"
                  class="otp-input w-14 h-14 text-center text-2xl font-bold rounded-xl bg-white/10 border border-white/20 text-white focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent"
                  pattern="[0-9]"
                  required
                  autofocus
                />
                <input
                  type="text"
                  maxlength="1"
                  class="otp-input w-14 h-14 text-center text-2xl font-bold rounded-xl bg-white/10 border border-white/20 text-white focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent"
                  pattern="[0-9]"
                  required
                />
                <input
                  type="text"
                  maxlength="1"
                  class="otp-input w-14 h-14 text-center text-2xl font-bold rounded-xl bg-white/10 border border-white/20 text-white focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent"
                  pattern="[0-9]"
                  required
                />
                <input
                  type="text"
                  maxlength="1"
                  class="otp-input w-14 h-14 text-center text-2xl font-bold rounded-xl bg-white/10 border border-white/20 text-white focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent"
                  pattern="[0-9]"
                  required
                />
                <input
                  type="text"
                  maxlength="1"
                  class="otp-input w-14 h-14 text-center text-2xl font-bold rounded-xl bg-white/10 border border-white/20 text-white focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent"
                  pattern="[0-9]"
                  required
                />
                <input
                  type="text"
                  maxlength="1"
                  class="otp-input w-14 h-14 text-center text-2xl font-bold rounded-xl bg-white/10 border border-white/20 text-white focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent"
                  pattern="[0-9]"
                  required
                />
              </div>

              <div
                id="otp-error"
                class="text-red-300 text-sm mt-2 hidden flex items-center justify-center"
              >
                <i class="fas fa-exclamation-triangle mr-1"></i>
                <span></span>
              </div>
            </div>

            <button
              type="submit"
              class="w-full py-4 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 rounded-xl font-semibold text-white transition-all duration-300 hover:shadow-lg hover:shadow-green-500/25 transform hover:scale-105 flex items-center justify-center"
            >
              <i class="fas fa-check-circle mr-2"></i>
              <span>Verify Account</span>
            </button>
          </form>
        </div>

        <!-- Help Section -->
        <div
          class="text-center mt-6 animate-fade-in-up"
          style="animation-delay: 0.5s"
        >
          <div class="glass rounded-xl p-4 mb-4">
            <h3 class="text-white font-semibold mb-2">
              <i class="fas fa-lightbulb mr-2 text-green-300"></i>
              Verification Tips
            </h3>
            <div class="text-white/70 text-sm space-y-1">
              <p>
                <i class="fas fa-clock text-yellow-400 mr-2"></i>Code expires in
                60 seconds
              </p>
              <p>
                <i class="fas fa-inbox text-blue-400 mr-2"></i>Check your
                spam/junk folder
              </p>
              <p>
                <i class="fas fa-sync text-green-400 mr-2"></i>Request a new
                code if needed
              </p>
            </div>
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
      </div>
@endsection
