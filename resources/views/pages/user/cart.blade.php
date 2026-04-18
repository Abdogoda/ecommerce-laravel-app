@extends('layouts.user-app')

@section('content')
    <main class="min-h-screen bg-gradient-to-br from-gray-900 to-gray-800 px-6 py-16">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-5xl font-bold text-center mb-12 text-white animate-fade-in-up">
                <i class="fas fa-shopping-cart mr-4 text-blue-400"></i>
                <span class="bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">
                    Your Shopping Cart
                </span>
                <div class="w-24 h-1 bg-gradient-to-r from-blue-400 to-purple-500 mx-auto mt-4 rounded-full"></div>
            </h1>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2 animate-fade-in-left">
                    <div id="cart-items" class="space-y-6">

                        <!-- Empty cart message (hidden by default) -->
                        <div id="empty-cart" class="text-center text-gray-400 hidden py-12">
                            <i class="fas fa-shopping-cart text-6xl text-gray-600 mb-4"></i>
                            <p class="text-xl mb-4">Your cart is empty</p>
                            <a href="{{ route('products.index') }}"
                                class="inline-flex items-center bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl transition-all duration-300 hover:scale-105 transform">
                                <i class="fas fa-shopping-bag mr-2"></i>Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Cart Summary -->
                <div class="lg:col-span-1 animate-fade-in-right">
                    <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl p-8 border border-gray-700/50 sticky top-24">
                        <h3 class="text-2xl font-semibold text-white mb-6 flex items-center">
                            <i class="fas fa-receipt mr-3 text-green-400"></i>Order Summary
                        </h3>

                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between items-center py-3 border-b border-blue-500">
                                <span class="text-gray-300">Subtotal:</span>
                                <span class="text-white font-semibold" id="cart-subtotal">$249.98</span>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <button id="clearCartButton" onclick="openModal('clearCartModal')"
                                class="w-full bg-gradient-to-r from-red-600 to-red-500 hover:from-red-700 hover:to-red-600 text-white font-semibold py-3 rounded-xl transition-all duration-300 hover:scale-105 transform hover:shadow-lg hover:shadow-red-500/25">
                                <i class="fas fa-trash mr-2"></i>Clear Cart
                            </button>

                            <a id="checkoutButton" href="{{ route('checkout') }}"
                                class="w-full bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-700 hover:to-blue-700 text-white font-semibold py-4 rounded-xl transition-all duration-300 hover:scale-105 transform hover:shadow-lg hover:shadow-green-500/25 block text-center">
                                <i class="fas fa-credit-card mr-2"></i>Proceed to Checkout
                            </a>

                            <a href="{{ route('products.index') }}"
                                class="w-full bg-gradient-to-r from-gray-600 to-gray-500 hover:from-gray-500 hover:to-gray-400 text-white font-semibold py-3 rounded-xl transition-all duration-300 hover:scale-105 transform hover:shadow-lg text-center block">
                                <i class="fas fa-shopping-bag mr-2"></i>Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <!-- Clear Cart Confirmation Modal -->
    <div id="clearCartModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 items-center justify-center p-4">
        <div
            class="bg-gray-800/90 backdrop-blur-sm p-8 rounded-2xl shadow-2xl border border-gray-700/50 w-full max-w-md animate-fade-in-up">
            <div class="text-center">
                <div class="w-16 h-16 bg-red-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-trash text-2xl text-red-400"></i>
                </div>
                <h3 class="text-2xl font-bold text-white mb-4">Clear Cart?</h3>
                <p class="text-gray-300 mb-6">
                    Are you sure you want to remove all items from your cart? This
                    action cannot be undone.
                </p>
                <div class="flex justify-center space-x-3">
                    <button type="button" onclick="closeModal('clearCartModal')"
                        class="px-6 py-3 bg-gray-600 hover:bg-gray-500 text-white rounded-xl transition-all duration-300 hover:scale-105 transform">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </button>
                    <button type="button"
                        onclick="
                clearCart();
                closeModal('clearCartModal');
              "
                        class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl transition-all duration-300 hover:scale-105 transform hover:shadow-lg hover:shadow-red-500/25">
                        <i class="fas fa-trash mr-2"></i>Clear Cart
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
