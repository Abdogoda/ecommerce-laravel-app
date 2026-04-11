@extends('layouts.user-app')

@section('content')
    <main class="min-h-screen bg-gradient-to-br from-gray-900 to-gray-800 px-6 py-16">
        <div class="max-w-6xl mx-auto">
            <!-- Page Header -->
            <div class="text-center mb-12 animate-fade-in-up">
                <div
                    class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full mb-6 shadow-lg animate-float">
                    <i class="fas fa-receipt text-2xl text-white"></i>
                </div>
                <h1 class="text-4xl lg:text-5xl font-bold text-white mb-4">
                    <span class="bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">
                        Order Details
                    </span>
                </h1>
                <p class="text-xl text-gray-300 mb-2">Order #ORD-12345</p>
                <div class="w-24 h-1 bg-gradient-to-r from-blue-400 to-purple-500 mx-auto rounded-full"></div>
            </div>

            <!-- Tab Navigation -->
            <div class="flex flex-wrap justify-center gap-4 mb-8 animate-fade-in-up delay-200">
                <button
                    class="tab-button glass px-6 py-3 rounded-xl text-white font-semibold transition-all duration-300 hover:bg-white/20 hover:scale-105 transform focus:outline-none focus:ring-2 focus:ring-blue-500/50"
                    onclick="showTab('info')">
                    <i class="fas fa-info-circle mr-2"></i>Order Info
                </button>
                <button
                    class="tab-button glass px-6 py-3 rounded-xl text-white font-semibold transition-all duration-300 hover:bg-white/20 hover:scale-105 transform focus:outline-none focus:ring-2 focus:ring-blue-500/50"
                    onclick="showTab('items')">
                    <i class="fas fa-shopping-bag mr-2"></i>Order Items
                </button>
                <button
                    class="tab-button glass px-6 py-3 rounded-xl text-white font-semibold transition-all duration-300 hover:bg-white/20 hover:scale-105 transform focus:outline-none focus:ring-2 focus:ring-blue-500/50"
                    onclick="showTab('statuses')">
                    <i class="fas fa-truck mr-2"></i>Order Status
                </button>
            </div>

            <!-- Order Information Tab -->
            <div id="infoTab" class="order-tab-content animate-fade-in-up delay-300">
                <div class="glass rounded-2xl p-8 shadow-2xl">
                    <h3 class="text-2xl font-bold text-white mb-8 flex items-center">
                        <i class="fas fa-file-invoice text-blue-400 mr-3"></i>
                        Order Information
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-gray-800/50 rounded-xl">
                                <span class="text-gray-400 font-medium">Order Number:</span>
                                <span class="text-white font-bold">ORD-12345</span>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-gray-800/50 rounded-xl">
                                <span class="text-gray-400 font-medium">Placed on:</span>
                                <span class="text-white">Dec 15, 2024 2:30 PM</span>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-gray-800/50 rounded-xl">
                                <span class="text-gray-400 font-medium">Total:</span>
                                <span class="text-2xl font-bold text-green-400">$249.97</span>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-gray-800/50 rounded-xl">
                                <span class="text-gray-400 font-medium">Status:</span>
                                <span class="px-3 py-1 bg-green-500 text-white rounded-full text-sm font-semibold">
                                    <i class="fas fa-check-circle mr-1"></i>Completed
                                </span>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="p-4 bg-gray-800/50 rounded-xl">
                                <h4 class="text-gray-400 font-medium mb-2">
                                    Shipping Address:
                                </h4>
                                <p class="text-white">
                                    123 Main Street, Apt 4B<br />Los Angeles, California<br />United
                                    States
                                </p>
                            </div>
                            <div class="p-4 bg-gray-800/50 rounded-xl">
                                <h4 class="text-gray-400 font-medium mb-2">
                                    Shipping Phone:
                                </h4>
                                <p class="text-white">+1234567890</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-4 mt-8 hidden">
                        <button onclick="openModal('changeShippingAddressModal')"
                            class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/25 transform hover:scale-105">
                            <i class="fas fa-edit mr-2"></i>Change Shipping Address
                        </button>
                        <button onclick="openModal('cancelOrderModal')"
                            class="bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 text-white px-6 py-3 rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-red-500/25 transform hover:scale-105">
                            <i class="fas fa-times mr-2"></i>Cancel Order
                        </button>
                    </div>
                </div>
            </div>

            <!-- Order Items Tab -->
            <div id="itemsTab" class="order-tab-content hidden animate-fade-in-up delay-400">
                <div class="glass rounded-2xl p-8 shadow-2xl">
                    <h3 class="text-2xl font-bold text-white mb-8 flex items-center">
                        <i class="fas fa-shopping-bag text-purple-400 mr-3"></i>
                        Order Items
                    </h3>

                    <div class="space-y-4">
                        <!-- Order Item 1 -->
                        <div
                            class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6 hover:bg-gray-800/70 transition-all duration-300">
                            <div class="flex items-center space-x-6">
                                <div class="flex-shrink-0">
                                    <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80"
                                        class="w-20 h-20 object-cover rounded-xl shadow-lg"
                                        alt="Wireless Bluetooth Headphones" />
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-lg font-semibold text-white mb-2">
                                        Wireless Bluetooth Headphones
                                    </h4>
                                    <div class="flex items-center space-x-4 text-sm text-gray-400">
                                        <span>Quantity:
                                            <span class="text-white font-medium">1</span></span>
                                        <span>Price:
                                            <span class="text-green-400 font-bold">$129.99</span></span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-green-400">$129.99</p>
                                </div>
                            </div>
                        </div>

                        <!-- Order Item 2 -->
                        <div
                            class="bg-gray-800/50 backdrop-blur-sm rounded-xl p-6 hover:bg-gray-800/70 transition-all duration-300">
                            <div class="flex items-center space-x-6">
                                <div class="flex-shrink-0">
                                    <img src="https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80"
                                        class="w-20 h-20 object-cover rounded-xl shadow-lg" alt="Wireless Gaming Mouse" />
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-lg font-semibold text-white mb-2">
                                        Wireless Gaming Mouse
                                    </h4>
                                    <div class="flex items-center space-x-4 text-sm text-gray-400">
                                        <span>Quantity:
                                            <span class="text-white font-medium">2</span></span>
                                        <span>Price:
                                            <span class="text-green-400 font-bold">$59.99</span></span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-green-400">$119.98</p>
                                </div>
                            </div>
                        </div>

                        <!-- Order Summary -->
                        <div class="border-t border-gray-700 pt-6 mt-6">
                            <div class="flex justify-between items-center text-xl">
                                <span class="font-semibold text-gray-300">Total Amount:</span>
                                <span class="font-bold text-3xl text-green-400">$249.97</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Status Tab -->
            <div id="statusesTab" class="order-tab-content hidden animate-fade-in-up delay-500">
                <div class="glass rounded-2xl p-8 shadow-2xl">
                    <h3 class="text-2xl font-bold text-white mb-8 flex items-center">
                        <i class="fas fa-truck text-orange-400 mr-3"></i>
                        Order Status History
                    </h3>

                    <div class="relative">
                        <!-- Status Timeline -->
                        <div
                            class="absolute left-8 top-0 bottom-0 w-0.5 bg-gradient-to-b from-green-500 via-blue-500 to-yellow-500">
                        </div>

                        <div class="space-y-8">
                            <!-- Completed Status -->
                            <div class="relative flex items-start">
                                <div
                                    class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center shadow-lg">
                                    <i class="fas fa-check text-white text-xl"></i>
                                </div>
                                <div class="ml-6 bg-gray-800/50 backdrop-blur-sm rounded-xl p-6 flex-1">
                                    <div class="flex items-center justify-between mb-2">
                                        <h4 class="text-lg font-semibold text-green-400">
                                            Completed
                                        </h4>
                                        <span class="text-sm text-gray-400">Dec 18, 2024 4:30 PM</span>
                                    </div>
                                    <p class="text-gray-300">
                                        Order has been delivered successfully
                                    </p>
                                </div>
                            </div>

                            <!-- Processing Status -->
                            <div class="relative flex items-start">
                                <div
                                    class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center shadow-lg">
                                    <i class="fas fa-cog fa-spin text-white text-xl"></i>
                                </div>
                                <div class="ml-6 bg-gray-800/50 backdrop-blur-sm rounded-xl p-6 flex-1">
                                    <div class="flex items-center justify-between mb-2">
                                        <h4 class="text-lg font-semibold text-blue-400">
                                            Processing
                                        </h4>
                                        <span class="text-sm text-gray-400">Dec 16, 2024 10:15 AM</span>
                                    </div>
                                    <p class="text-gray-300">
                                        Order is being prepared for shipment
                                    </p>
                                </div>
                            </div>

                            <!-- Pending Status -->
                            <div class="relative flex items-start">
                                <div
                                    class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-full flex items-center justify-center shadow-lg">
                                    <i class="fas fa-clock text-white text-xl"></i>
                                </div>
                                <div class="ml-6 bg-gray-800/50 backdrop-blur-sm rounded-xl p-6 flex-1">
                                    <div class="flex items-center justify-between mb-2">
                                        <h4 class="text-lg font-semibold text-yellow-400">
                                            Pending
                                        </h4>
                                        <span class="text-sm text-gray-400">Dec 15, 2024 2:30 PM</span>
                                    </div>
                                    <p class="text-gray-300">
                                        Order has been placed and is awaiting confirmation
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
