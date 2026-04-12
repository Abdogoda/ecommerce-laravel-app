@extends('layouts.admin-app')

@section('content')
    <!-- Messages Header -->
    <div class="admin-card p-8 rounded-2xl mb-8 animate-bounce-in">
        <div class="flex flex-col lg:flex-row items-center lg:items-start justify-between gap-6">
            <!-- Header Info -->
            <div class="text-center lg:text-left">
                <div class="flex gap-0 items-start flex-col sm:flex-row sm:gap-5 sm:items-center mb-2">
                    <h1 class="text-3xl font-bold text-white mb-2">
                        Message Management
                    </h1>
                    <div class="flex items-center space-x-4">
                        <div id="breadcrumb" class="text-sm text-gray-400">
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:underline">Admin</a>
                            <i class="fas fa-chevron-right mx-2"></i>
                            <span class="text-white">Messages</span>
                        </div>
                    </div>
                </div>
                <p class="text-gray-400 text-lg mb-6">
                    Manage customer inquiries, support requests, and communications
                </p>

                <!-- Quick Stats -->
                <div class="flex flex-wrap gap-4 justify-center lg:justify-start">
                    <div class="glass px-4 py-2 rounded-xl">
                        <i class="fas fa-envelope text-blue-400 mr-2"></i>
                        <span class="text-sm">5 New Messages</span>
                    </div>
                    <div class="glass px-4 py-2 rounded-xl">
                        <i class="fas fa-clock text-yellow-400 mr-2"></i>
                        <span class="text-sm">3 Pending</span>
                    </div>
                    <div class="glass px-4 py-2 rounded-xl">
                        <i class="fas fa-check-circle text-green-400 mr-2"></i>
                        <span class="text-sm">15 Resolved Today</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-3 justify-center lg:justify-end">
                <button onclick="openModal('markAllReadModal')"
                    class="btn-success px-6 py-3 rounded-xl text-white font-bold">
                    <i class="fas fa-check-double mr-2"></i>
                    Mark All Read
                </button>
            </div>
        </div>
    </div>

    <!-- Messages List -->
    <div class="admin-card rounded-2xl animate-slide-in">
        <div class="p-6 border-b border-white/10">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h2 class="text-xl font-bold text-white">Customer Messages</h2>
            </div>
        </div>

        <!-- Messages List Container -->
        <div class="p-6">
            <div class="space-y-4" id="messagesList">
                <!-- Message Card 1 - Unread -->
                <div class="message-card unread admin-card p-6 rounded-xl cursor-pointer"
                    onclick="
                  openMessageActionModal(
                    1,
                    'John Doe',
                    'Hello, I am interested in your iPhone 14 Pro. Can you please provide more details about the warranty and return policy? I would also like to know if you have any current promotions or discounts available. Thank you for your time and I look forward to hearing from you soon.',
                    'john.doe@example.com',
                    '2 hours ago',
                    false,
                    'high',
                  )
                ">
                    <div class="flex items-start space-x-4">
                        <!-- Avatar -->
                        <div class="flex-shrink-0">
                            <div
                                class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-lg">
                                J
                            </div>
                        </div>

                        <!-- Message Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-lg font-semibold text-white">John Doe</h3>
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm text-gray-400">2 hours ago</span>
                                    <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded-full">
                                        New
                                    </span>
                                </div>
                            </div>
                            <p class="text-blue-400 text-sm mb-3">
                                john.doe@example.com
                            </p>
                            <p class="text-gray-300 text-sm leading-relaxed">
                                Hello, I am interested in your iPhone 14 Pro. Can you
                                please provide more details about the warranty and return
                                policy?...
                            </p>
                            <div class="flex items-center mt-4 space-x-4">
                                <div class="flex items-center text-gray-400 text-sm">
                                    <i class="fas fa-tag mr-1"></i>
                                    <span>Product Inquiry</span>
                                </div>
                                <div class="flex items-center text-gray-400 text-sm">
                                    <i class="fas fa-mobile-alt mr-1"></i>
                                    <span>iPhone 14 Pro</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Message Card 2 - Unread -->
                <div class="message-card unread admin-card p-6 rounded-xl cursor-pointer"
                    onclick="
                  openMessageActionModal(
                    2,
                    'Jane Smith',
                    'I recently ordered a MacBook Pro from your store and I am having some issues with the delivery. The tracking shows it was delivered but I never received it. Can you help me resolve this issue? This is quite urgent as I need it for work. Please get back to me as soon as possible.',
                    'jane.smith@example.com',
                    '5 hours ago',
                    false,
                    'urgent',
                  )
                ">
                    <div class="flex items-start space-x-4">
                        <!-- Avatar -->
                        <div class="flex-shrink-0">
                            <div
                                class="w-12 h-12 rounded-full bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center text-white font-bold text-lg">
                                J
                            </div>
                        </div>

                        <!-- Message Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-lg font-semibold text-white">
                                    Jane Smith
                                </h3>
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm text-gray-400">5 hours ago</span>
                                    <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded-full">
                                        New
                                    </span>
                                </div>
                            </div>
                            <p class="text-blue-400 text-sm mb-3">
                                jane.smith@example.com
                            </p>
                            <p class="text-gray-300 text-sm leading-relaxed">
                                I recently ordered a MacBook Pro from your store and I am
                                having some issues with the delivery. The tracking shows
                                it was delivered...
                            </p>
                            <div class="flex items-center mt-4 space-x-4">
                                <div class="flex items-center text-gray-400 text-sm">
                                    <i class="fas fa-shipping-fast mr-1"></i>
                                    <span>Delivery Issue</span>
                                </div>
                                <div class="flex items-center text-gray-400 text-sm">
                                    <i class="fas fa-laptop mr-1"></i>
                                    <span>MacBook Pro</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Message Card 3 - Read -->
                <div class="message-card admin-card p-6 rounded-xl cursor-pointer opacity-75"
                    onclick="
                  openMessageActionModal(
                    3,
                    'Mike Johnson',
                    'Thank you for the excellent service! The AirPods Pro I ordered arrived quickly and in perfect condition. I really appreciate your fast shipping and great customer service. Keep up the good work! I will definitely recommend your store to my friends and family.',
                    'mike.johnson@example.com',
                    '1 day ago',
                    true,
                    'low',
                  )
                ">
                    <div class="flex items-start space-x-4">
                        <!-- Avatar -->
                        <div class="flex-shrink-0">
                            <div
                                class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg">
                                M
                            </div>
                        </div>

                        <!-- Message Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-lg font-semibold text-gray-300">
                                    Mike Johnson
                                </h3>
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm text-gray-400">1 day ago</span>
                                    <span class="bg-green-500 text-white text-xs px-2 py-1 rounded-full">
                                        <i class="fas fa-check mr-1"></i>Read
                                    </span>
                                </div>
                            </div>
                            <p class="text-blue-400 text-sm mb-3">
                                mike.johnson@example.com
                            </p>
                            <p class="text-gray-400 text-sm leading-relaxed">
                                Thank you for the excellent service! The AirPods Pro I
                                ordered arrived quickly and in perfect condition...
                            </p>
                            <div class="flex items-center mt-4 space-x-4">
                                <div class="flex items-center text-gray-400 text-sm">
                                    <i class="fas fa-heart mr-1"></i>
                                    <span>Feedback</span>
                                </div>
                                <div class="flex items-center text-gray-400 text-sm">
                                    <i class="fas fa-headphones mr-1"></i>
                                    <span>AirPods Pro</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Message Card 4 - Unread -->
                <div class="message-card unread admin-card p-6 rounded-xl cursor-pointer"
                    onclick="
                  openMessageActionModal(
                    4,
                    'Sarah Wilson',
                    'I would like to return the Designer Leather Jacket I purchased last week. It does not fit properly and I would like to exchange it for a different size. What is your return policy and how can I proceed with this exchange? Please provide me with the necessary steps.',
                    'sarah.wilson@example.com',
                    '2 days ago',
                    false,
                  )
                ">
                    <div class="flex items-start space-x-4">
                        <!-- Avatar -->
                        <div class="flex-shrink-0">
                            <div
                                class="w-12 h-12 rounded-full bg-gradient-to-br from-pink-500 to-pink-600 flex items-center justify-center text-white font-bold text-lg">
                                S
                            </div>
                        </div>

                        <!-- Message Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-lg font-semibold text-white">
                                    Sarah Wilson
                                </h3>
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm text-gray-400">2 days ago</span>
                                    <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded-full">
                                        New
                                    </span>
                                </div>
                            </div>
                            <p class="text-blue-400 text-sm mb-3">
                                sarah.wilson@example.com
                            </p>
                            <p class="text-gray-300 text-sm leading-relaxed">
                                I would like to return the Designer Leather Jacket I
                                purchased last week. It does not fit properly and I would
                                like to exchange...
                            </p>
                            <div class="flex items-center mt-4 space-x-4">
                                <div class="flex items-center text-gray-400 text-sm">
                                    <i class="fas fa-undo mr-1"></i>
                                    <span>Return Request</span>
                                </div>
                                <div class="flex items-center text-gray-400 text-sm">
                                    <i class="fas fa-tshirt mr-1"></i>
                                    <span>Leather Jacket</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Message Card 5 - Read -->
                <div class="message-card admin-card p-6 rounded-xl cursor-pointer opacity-75"
                    onclick="
                  openMessageActionModal(
                    5,
                    'David Brown',
                    'I am interested in bulk purchasing running shoes for my sports club. Do you offer any discounts for bulk orders? We would need about 20 pairs in various sizes. Please let me know your best pricing and if you can accommodate this order. Thank you for your assistance.',
                    'david.brown@example.com',
                    '3 days ago',
                    true,
                    'low',
                  )
                ">
                    <div class="flex items-start space-x-4">
                        <!-- Avatar -->
                        <div class="flex-shrink-0">
                            <div
                                class="w-12 h-12 rounded-full bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center text-white font-bold text-lg">
                                D
                            </div>
                        </div>

                        <!-- Message Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-lg font-semibold text-gray-300">
                                    David Brown
                                </h3>
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm text-gray-400">3 days ago</span>
                                    <span class="bg-green-500 text-white text-xs px-2 py-1 rounded-full">
                                        <i class="fas fa-check mr-1"></i>Read
                                    </span>
                                </div>
                            </div>
                            <p class="text-blue-400 text-sm mb-3">
                                david.brown@example.com
                            </p>
                            <p class="text-gray-400 text-sm leading-relaxed">
                                I am interested in bulk purchasing running shoes for my
                                sports club. Do you offer any discounts for bulk
                                orders?...
                            </p>
                            <div class="flex items-center mt-4 space-x-4">
                                <div class="flex items-center text-gray-400 text-sm">
                                    <i class="fas fa-shopping-cart mr-1"></i>
                                    <span>Bulk Order</span>
                                </div>
                                <div class="flex items-center text-gray-400 text-sm">
                                    <i class="fas fa-running mr-1"></i>
                                    <span>Running Shoes</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="p-6 border-t border-white/10">
            <div class="flex justify-center">
                <nav class="flex space-x-2">
                    <button
                        class="glass px-4 py-2 rounded-xl text-gray-400 hover:text-white hover:bg-white/10 transition-colors">
                        <i class="fas fa-chevron-left mr-2"></i>Previous
                    </button>
                    <button class="bg-blue-500 px-4 py-2 rounded-xl text-white font-medium">
                        1
                    </button>
                    <button
                        class="glass px-4 py-2 rounded-xl text-gray-400 hover:text-white hover:bg-white/10 transition-colors">
                        2
                    </button>
                    <button
                        class="glass px-4 py-2 rounded-xl text-gray-400 hover:text-white hover:bg-white/10 transition-colors">
                        3
                    </button>
                    <button
                        class="glass px-4 py-2 rounded-xl text-gray-400 hover:text-white hover:bg-white/10 transition-colors">
                        Next<i class="fas fa-chevron-right ml-2"></i>
                    </button>
                </nav>
            </div>
        </div>
    </div>
@endsection
