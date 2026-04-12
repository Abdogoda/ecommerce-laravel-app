@extends('layouts.admin-app')

@section('content')
    <!-- Content will go here -->
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-4">
            <div class="p-3 bg-gradient-to-br from-red-500 to-pink-600 rounded-xl">
                <i class="fas fa-receipt text-white text-xl"></i>
            </div>
            <div>
                <div class="flex gap-0 items-start flex-col mb-2">
                    <h1 class="text-3xl font-bold text-white mb-2">
                        Order #ORD-2024-001
                    </h1>
                    <div class="flex items-center space-x-4">
                        <div id="breadcrumb" class="text-sm text-gray-400">
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:underline">Admin</a>
                            <i class="fas fa-chevron-right mx-2"></i>
                            <a href="./index.html" class="text-gray-400 hover:underline">
                                Orders
                            </a>
                            <i class="fas fa-chevron-right mx-2"></i>
                            <span class="text-white">#ORD-2024-001</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex space-x-3">
            <button onclick="openModal('updateStatusModal')"
                class="btn-primary px-6 py-3 rounded-xl text-white font-bold hover:scale-105 transition-transform">
                <i class="fas fa-edit mr-2"></i>
                Update Status
            </button>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="animate-slide-up">
        <div class="flex space-x-1 p-1 bg-white/5 rounded-xl mb-6">
            <button id="infoTabBtn" onclick="switchTab('infoTab')"
                class="tab-button active flex-1 py-3 px-4 rounded-lg text-white font-medium transition-all">
                <i class="fas fa-info-circle mr-2"></i>
                Order Info
            </button>
            <button id="itemsTabBtn" onclick="switchTab('itemsTab')"
                class="tab-button flex-1 py-3 px-4 rounded-lg text-gray-400 font-medium transition-all">
                <i class="fas fa-shopping-bag mr-2"></i>
                Order Items
            </button>
            <button id="statusesTabBtn" onclick="switchTab('statusesTab')"
                class="tab-button flex-1 py-3 px-4 rounded-lg text-gray-400 font-medium transition-all">
                <i class="fas fa-history mr-2"></i>
                Status History
            </button>
        </div>

        <!-- Order Information Tab -->
        <div id="infoTab" class="tab-content">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Order Details Card -->
                <div class="glass p-6 rounded-xl">
                    <div class="flex items-center mb-4">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-file-invoice text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white">
                            Order Information
                        </h3>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-2 border-b border-white/10">
                            <span class="text-gray-400">Order Number:</span>
                            <span class="font-bold text-blue-400">#ORD-2024-001</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-white/10">
                            <span class="text-gray-400">Customer:</span>
                            <span class="text-white font-medium">John Doe</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-white/10">
                            <span class="text-gray-400">Email:</span>
                            <span class="text-white">john.doe@example.com</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-white/10">
                            <span class="text-gray-400">Order Date:</span>
                            <span class="text-white">Jan 15, 2024 2:30 PM</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-white/10">
                            <span class="text-gray-400">Total Amount:</span>
                            <span class="text-green-400 font-bold text-lg">$1,248.00</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-gray-400">Status:</span>
                            <span
                                class="px-3 py-1 text-sm font-medium rounded-full bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                <i class="fas fa-clock mr-1"></i>
                                Pending
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Shipping Information Card -->
                <div class="glass p-6 rounded-xl">
                    <div class="flex items-center mb-4">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-green-500 to-teal-600 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-shipping-fast text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white">
                            Shipping Information
                        </h3>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-start py-2 border-b border-white/10">
                            <span class="text-gray-400">Address:</span>
                            <span class="text-white text-right">123 Main Street, Apt 4B</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-white/10">
                            <span class="text-gray-400">City:</span>
                            <span class="text-white">New York</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-white/10">
                            <span class="text-gray-400">State:</span>
                            <span class="text-white">NY</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-white/10">
                            <span class="text-gray-400">Country:</span>
                            <span class="text-white">United States</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-gray-400">Phone:</span>
                            <span class="text-white">+1 (555) 123-4567</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items Tab -->
        <div id="itemsTab" class="tab-content hidden">
            <div class="glass p-6 rounded-xl">
                <div class="flex items-center mb-6">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-orange-500 to-red-600 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-shopping-bag text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white">Order Items</h3>
                </div>

                <!-- Order Items List -->
                <div class="space-y-4">
                    <!-- Item 1 -->
                    <div class="glass p-4 rounded-xl border border-white/10">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=80&h=80&fit=crop&crop=center"
                                    class="w-16 h-16 rounded-lg object-cover" alt="iPhone 14 Pro" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="text-lg font-semibold text-white">
                                            iPhone 14 Pro
                                        </h4>
                                        <p class="text-sm text-gray-400">
                                            128GB, Deep Purple
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-green-400">$999.00</p>
                                        <p class="text-sm text-gray-400">Qty: 1</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Item 2 -->
                    <div class="glass p-4 rounded-xl border border-white/10">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <img src="https://images.unsplash.com/photo-1583394838336-acd977736f90?w=80&h=80&fit=crop&crop=center"
                                    class="w-16 h-16 rounded-lg object-cover" alt="AirPods Pro" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="text-lg font-semibold text-white">
                                            AirPods Pro
                                        </h4>
                                        <p class="text-sm text-gray-400">2nd Generation</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-green-400">$249.00</p>
                                        <p class="text-sm text-gray-400">Qty: 1</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="mt-6 pt-6 border-t border-white/10">
                    <div class="flex justify-between items-center">
                        <span class="text-xl font-semibold text-white">Total Amount:</span>
                        <span class="text-2xl font-bold text-green-400">$1,248.00</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status History Tab -->
        <div id="statusesTab" class="tab-content hidden">
            <div class="glass p-6 rounded-xl">
                <div class="flex items-center mb-6">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-history text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white">Status History</h3>
                </div>

                <!-- Status Timeline -->
                <div class="space-y-6">
                    <!-- Current Status -->
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 flex flex-col items-center">
                            <div class="w-4 h-4 bg-red-500 rounded-full ring-4 ring-red-500/20"></div>
                        </div>
                        <div class="flex-1 glass p-4 rounded-xl border-l-4 border-red-500">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <span
                                        class="inline-flex items-center gap-2 font-semibold cursor-default text-lg text-red-400 text-lg">
                                        <i class="fas fa-times"></i>
                                        Order Cancelled
                                    </span>
                                    <p class="text-sm text-gray-400">
                                        Jan 15, 2024 2:30 PM
                                    </p>
                                    <p class="text-sm text-gray-400">by Admin User</p>
                                </div>
                                <span
                                    class="px-2 py-1 text-xs font-medium rounded-full bg-red-500/20 text-red-400 border border-yellow-500/30">
                                    Current
                                </span>
                            </div>
                            <p class="text-gray-300">
                                Order has been placed and is waiting for confirmation.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 flex flex-col items-center">
                            <div class="w-4 h-4 bg-blue-500 rounded-full ring-4 ring-blue-500/20"></div>
                        </div>
                        <div class="flex-1 glass p-4 rounded-xl border-l-4 border-blue-500">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <span
                                        class="inline-flex items-center gap-2 font-semibold cursor-default text-lg text-blue-400 text-lg">
                                        <i class="fas fa-truck"></i>
                                        Order Shipped
                                    </span>
                                    <p class="text-sm text-gray-400">
                                        Jan 15, 2024 2:30 PM
                                    </p>
                                    <p class="text-sm text-gray-400">by Admin User</p>
                                </div>
                            </div>
                            <p class="text-gray-300">
                                Order has been placed and is waiting for confirmation.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 flex flex-col items-center">
                            <div class="w-4 h-4 bg-yellow-500 rounded-full ring-4 ring-yellow-500/20"></div>
                        </div>
                        <div class="flex-1 glass p-4 rounded-xl border-l-4 border-yellow-500">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <span
                                        class="inline-flex items-center gap-2 font-semibold cursor-default text-lg text-yellow-400 text-lg">
                                        <i class="fas fa-clock"></i>
                                        Pending
                                    </span>
                                    <p class="text-sm text-gray-400">
                                        Jan 15, 2024 2:30 PM
                                    </p>
                                    <p class="text-sm text-gray-400">by Admin User</p>
                                </div>
                            </div>
                            <p class="text-gray-300">
                                Order has been placed and is waiting for confirmation.
                            </p>
                        </div>
                    </div>

                    <!-- Previous Status -->
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 flex flex-col items-center">
                            <div class="w-4 h-4 bg-green-500 rounded-full ring-4 ring-green-500/20"></div>
                        </div>
                        <div class="flex-1 glass p-4 rounded-xl border-l-4 border-green-500">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <span
                                        class="inline-flex items-center gap-2 font-semibold cursor-default text-lg text-green-400 text-lg">
                                        <i class="fas fa-check-circle"></i>
                                        Order Placed
                                    </span>
                                    <p class="text-sm text-gray-400">
                                        Jan 15, 2024 2:30 PM
                                    </p>
                                    <p class="text-sm text-gray-400">by System</p>
                                </div>
                            </div>
                            <p class="text-gray-300">
                                Order has been successfully placed by the customer.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
