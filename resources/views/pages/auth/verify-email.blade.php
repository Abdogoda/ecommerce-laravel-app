@extends('layouts.auth-app')

@section('content')
    <div class="w-full max-w-md animate-scale-in">
        <!-- Logo Section -->
        <div class="text-center mb-8 animate-bounce-in">
            <a href="{{ route('home') }}"
                class="text-4xl font-bold text-white hover:text-blue-200 transition-colors duration-300 animate-fade-in-down mb-3 flex items-center justify-center">
                <i class="fas fa-store mr-2 text-blue-200"></i>E-Commerce
            </a>
            <p class="text-blue-100">Enter the 6-digit code sent to your email</p>
        </div>

        <!-- Verify Account Form -->
        <div class="glass rounded-2xl p-8 shadow-2xl animate-fade-in-up" style="animation-delay: 0.3s">
            <form id="otp-form" action="{{ url('/verify-email') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="email" value="{{ $email ?? '' }}" />
                <div class="text-center">
                    <label class="block text-sm font-semibold text-white mb-4">
                        <i class="fas fa-key mr-2 text-green-300"></i>Verification Code
                    </label>

                    <!-- OTP Input Fields -->
                    <div class="flex justify-center space-x-3 mb-4" id="otp-container">
                        <input type="text" maxlength="1"
                            class="otp-input w-14 h-14 text-center text-2xl font-bold rounded-xl bg-white/10 border border-white/20 text-white focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent"
                            pattern="[0-9]" required autofocus name="otp[]" />
                        <input type="text" maxlength="1"
                            class="otp-input w-14 h-14 text-center text-2xl font-bold rounded-xl bg-white/10 border border-white/20 text-white focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent"
                            pattern="[0-9]" required name="otp[]" />
                        <input type="text" maxlength="1"
                            class="otp-input w-14 h-14 text-center text-2xl font-bold rounded-xl bg-white/10 border border-white/20 text-white focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent"
                            pattern="[0-9]" required name="otp[]" />
                        <input type="text" maxlength="1"
                            class="otp-input w-14 h-14 text-center text-2xl font-bold rounded-xl bg-white/10 border border-white/20 text-white focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent"
                            pattern="[0-9]" required name="otp[]" />
                        <input type="text" maxlength="1"
                            class="otp-input w-14 h-14 text-center text-2xl font-bold rounded-xl bg-white/10 border border-white/20 text-white focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent"
                            pattern="[0-9]" required name="otp[]" />
                        <input type="text" maxlength="1"
                            class="otp-input w-14 h-14 text-center text-2xl font-bold rounded-xl bg-white/10 border border-white/20 text-white focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent"
                            pattern="[0-9]" required name="otp[]" />
                    </div>

                    @error('otp', 'email')
                        <div id="otp-error" class="text-red-300 text-sm mt-2 flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full py-4 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 rounded-xl font-semibold text-white transition-all duration-300 hover:shadow-lg hover:shadow-green-500/25 transform hover:scale-105 flex items-center justify-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>Verify Account</span>
                </button>
            </form>
        </div>

        <!-- Help Section -->
        <div class="text-center mt-6 animate-fade-in-up" style="animation-delay: 0.5s">
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

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("otp-form");
            const inputs = document.querySelectorAll(".otp-input");
            const resendBtn = document.getElementById("resend-btn");

            // OTP input handling
            inputs.forEach((input, index) => {
                input.addEventListener("input", function(e) {
                    const value = e.target.value;

                    // Only allow numbers
                    if (!/^\d$/.test(value) && value !== "") {
                        e.target.value = "";
                        return;
                    }

                    if (value !== "") {
                        e.target.classList.add("filled");

                        // Move to next input
                        if (index < inputs.length - 1) {
                            inputs[index + 1].focus();
                        }
                    } else {
                        e.target.classList.remove("filled");
                    }

                    // Clear error when user starts typing
                    if (value) {
                        showError(null);
                    }
                });

                input.addEventListener("keydown", function(e) {
                    // Handle backspace
                    if (e.key === "Backspace" && !e.target.value && index > 0) {
                        inputs[index - 1].focus();
                        inputs[index - 1].value = "";
                        inputs[index - 1].classList.remove("filled");
                    }

                    // Handle left/right arrow keys
                    if (e.key === "ArrowLeft" && index > 0) {
                        inputs[index - 1].focus();
                    }

                    if (e.key === "ArrowRight" && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }

                    // Handle paste
                    if (e.key === "v" && (e.ctrlKey || e.metaKey)) {
                        e.preventDefault();
                        navigator.clipboard.readText().then((text) => {
                            const digits = text.replace(/\D/g, "").slice(0, 6);
                            digits.split("").forEach((digit, i) => {
                                if (inputs[i]) {
                                    inputs[i].value = digit;
                                    inputs[i].classList.add("filled");
                                }
                            });
                            if (inputs[digits.length - 1]) {
                                inputs[digits.length - 1].focus();
                            }
                        });
                    }
                });
            });

            // Form submission
            form.addEventListener("submit", function(e) {
                e.preventDefault();

                // Show loading state
                const submitButton = form.querySelector('button[type="submit"]');
                const originalHTML = submitButton.innerHTML;
                submitButton.innerHTML =
                    '<i class="fas fa-spinner fa-spin mr-2"></i>Verifying...';
                submitButton.disabled = true;

                form.submit();
            });
        });
    </script>
@endpush
