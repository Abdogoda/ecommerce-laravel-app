@extends('layouts.admin-app')

@section('content')
    <!-- Category Header -->
    <div class="admin-card p-8 rounded-2xl mb-8 animate-bounce-in">
        <div class="flex flex-col lg:flex-row items-center lg:items-start gap-8">
            <!-- Category Icon -->
            <div class="relative">
                <div
                    class="w-32 h-32 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center category-icon">
                    <i class="fas fa-laptop text-white text-6xl"></i>
                </div>
                <div class="absolute -bottom-2 -right-2 bg-green-500 p-2 rounded-full">
                    <i class="fas fa-check text-white text-sm"></i>
                </div>
            </div>

            <!-- Category Info -->
            <div class="flex-1 text-center lg:text-left">
                <div class="flex gap-0 flex-col md:flex-row md:gap-5 items-center mb-2">
                    <h1 class="text-3xl font-bold text-white mb-2">Electronics</h1>
                    <div class="flex items-center space-x-4">
                        <div id="breadcrumb" class="text-sm text-gray-400">
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:underline">Admin</a>
                            <i class="fas fa-chevron-right mx-2"></i>
                            <a href="./index.html" class="text-gray-400 hover:underline">Categories</a>
                            <i class="fas fa-chevron-right mx-2"></i>
                            <span class="text-white">Electronics</span>
                        </div>
                    </div>
                </div>
                <p class="text-gray-400 text-lg mb-6">
                    Latest gadgets, smartphones, laptops, and electronic devices for
                    modern living
                </p>

                <div class="flex flex-wrap gap-4 justify-center lg:justify-start mb-6">
                    <div class="glass px-4 py-2 rounded-xl">
                        <i class="fas fa-box text-blue-400 mr-2"></i>
                        <span class="text-sm">342 Products</span>
                    </div>
                    <div class="glass px-4 py-2 rounded-xl">
                        <i class="fas fa-calendar text-green-400 mr-2"></i>
                        <span class="text-sm">Created Dec 15, 2023</span>
                    </div>
                    <div class="glass px-4 py-2 rounded-xl">
                        <i class="fas fa-check-circle text-green-400 mr-2"></i>
                        <span class="text-sm">Active Status</span>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3 justify-center lg:justify-start">
                    <button onclick="openModal('editCategoryModal')"
                        class="btn-warning px-6 py-3 rounded-xl text-white font-bold">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Category
                    </button>
                    <button onclick="openModal('deleteCategoryModal')"
                        class="btn-danger px-6 py-3 rounded-xl text-white font-bold">
                        <i class="fas fa-trash mr-2"></i>
                        Delete Category
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Products Section -->
    <div class="admin-card rounded-2xl animate-slide-in mb-8">
        <div class="p-6 border-b border-white/10">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h2 class="text-xl font-bold text-white">
                    Products in this Category
                </h2>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <!-- Product Card 1 -->
                <a href="../products/show.html" class="Product-card admin-card p-4 rounded-xl">
                    <div class="relative mb-4">
                        <img src="https://picsum.photos/200/150?random=8" alt="iPhone 15"
                            class="w-full h-36 object-cover rounded-lg" />
                        <div class="absolute top-2 right-2 bg-green-500 px-2 py-1 rounded-full text-xs text-white">
                            In Stock
                        </div>
                    </div>
                    <h3 class="text-white font-semibold mb-2">iPhone 15 Pro Max</h3>
                    <p class="text-gray-400 text-sm mb-3">
                        Latest flagship smartphone with advanced features
                    </p>
                    <div class="flex items-center justify-between">
                        <span class="text-blue-400 font-bold text-lg">$1,199</span>
                        <div class="flex items-center text-yellow-400">
                            <i class="fas fa-star mr-1"></i>
                            <span class="text-sm">4.9</span>
                        </div>
                    </div>
                </a>

                <!-- Product Card 2 -->
                <a href="../products/show.html" class="Product-card admin-card p-4 rounded-xl">
                    <div class="relative mb-4">
                        <img src="https://picsum.photos/200/150?random=9" alt="MacBook Pro"
                            class="w-full h-36 object-cover rounded-lg" />
                        <div class="absolute top-2 right-2 bg-green-500 px-2 py-1 rounded-full text-xs text-white">
                            In Stock
                        </div>
                    </div>
                    <h3 class="text-white font-semibold mb-2">MacBook Pro M3</h3>
                    <p class="text-gray-400 text-sm mb-3">
                        Professional laptop with M3 chip
                    </p>
                    <div class="flex items-center justify-between">
                        <span class="text-blue-400 font-bold text-lg">$2,499</span>
                        <div class="flex items-center text-yellow-400">
                            <i class="fas fa-star mr-1"></i>
                            <span class="text-sm">4.7</span>
                        </div>
                    </div>
                </a>

                <!-- Product Card 3 -->
                <a href="../products/show.html" class="Product-card admin-card p-4 rounded-xl">
                    <div class="relative mb-4">
                        <img src="https://picsum.photos/200/150?random=10" alt="AirPods Pro"
                            class="w-full h-36 object-cover rounded-lg" />
                        <div class="absolute top-2 right-2 bg-yellow-500 px-2 py-1 rounded-full text-xs text-white">
                            Low Stock
                        </div>
                    </div>
                    <h3 class="text-white font-semibold mb-2">
                        AirPods Pro 2nd Gen
                    </h3>
                    <p class="text-gray-400 text-sm mb-3">
                        Wireless earbuds with noise cancellation
                    </p>
                    <div class="flex items-center justify-between">
                        <span class="text-blue-400 font-bold text-lg">$249</span>
                        <div class="flex items-center text-yellow-400">
                            <i class="fas fa-star mr-1"></i>
                            <span class="text-sm">4.6</span>
                        </div>
                    </div>
                </a>

                <!-- Product Card 4 -->
                <a href="../products/show.html" class="Product-card admin-card p-4 rounded-xl">
                    <div class="relative mb-4">
                        <img src="https://picsum.photos/200/150?random=11" alt="iPad Air"
                            class="w-full h-36 object-cover rounded-lg" />
                        <div class="absolute top-2 right-2 bg-red-500 px-2 py-1 rounded-full text-xs text-white">
                            Out of Stock
                        </div>
                    </div>
                    <h3 class="text-white font-semibold mb-2">iPad Air 5th Gen</h3>
                    <p class="text-gray-400 text-sm mb-3">
                        Powerful tablet for creativity and Productivity
                    </p>
                    <div class="flex items-center justify-between">
                        <span class="text-blue-400 font-bold text-lg">$599</span>
                        <div class="flex items-center text-yellow-400">
                            <i class="fas fa-star mr-1"></i>
                            <span class="text-sm">4.8</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
