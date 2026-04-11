@extends('layouts.user-app')

@section('content')
    <main class="min-h-screen bg-gradient-to-br from-gray-900 to-gray-800 px-6 py-16">
        <div class="max-w-7xl mx-auto">
            <!-- Page Header -->
            <div class="text-center mb-16 animate-fade-in-up">
                <h1 class="text-5xl font-bold text-white mb-6">
                    <span class="bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">
                        All Categories
                    </span>
                </h1>
                <div class="w-32 h-1 bg-gradient-to-r from-blue-400 to-purple-500 mx-auto rounded-full mb-4"></div>
                <p class="text-gray-300 text-lg max-w-2xl mx-auto">
                    Explore our wide range of product categories and find exactly what
                    you're looking for
                </p>
            </div>

            <!-- Categories Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                <!-- Category 1: Electronics -->
                <div class="group animate-fade-in-up delay-100">
                    <a href="category.html?category=electronics"
                        class="block glass rounded-2xl p-8 text-center transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-blue-500/25 transform">
                        <div
                            class="w-24 h-24 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:rotate-12 transition-transform duration-300 animate-float">
                            <i class="fas fa-laptop text-3xl text-white"></i>
                        </div>
                        <h3
                            class="text-2xl font-semibold text-white group-hover:text-blue-400 transition-colors duration-300 mb-3">
                            Electronics
                        </h3>
                        <p class="text-gray-400 group-hover:text-gray-300 transition-colors duration-300">
                            Latest tech gadgets, smartphones, laptops, and accessories
                        </p>
                        <div class="mt-4 text-blue-400 group-hover:text-blue-300 transition-colors duration-300">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>
                </div>

                <!-- Category 2: Clothing -->
                <div class="group animate-fade-in-up delay-200">
                    <a href="category.html?category=clothing"
                        class="block glass rounded-2xl p-8 text-center transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-purple-500/25 transform">
                        <div class="w-24 h-24 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:rotate-12 transition-transform duration-300 animate-float"
                            style="animation-delay: 0.5s">
                            <i class="fas fa-tshirt text-3xl text-white"></i>
                        </div>
                        <h3
                            class="text-2xl font-semibold text-white group-hover:text-purple-400 transition-colors duration-300 mb-3">
                            Clothing
                        </h3>
                        <p class="text-gray-400 group-hover:text-gray-300 transition-colors duration-300">
                            Fashion & style for men, women, and children
                        </p>
                        <div class="mt-4 text-purple-400 group-hover:text-purple-300 transition-colors duration-300">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>
                </div>

                <!-- Category 3: Books -->
                <div class="group animate-fade-in-up delay-300">
                    <a href="category.html?category=books"
                        class="block glass rounded-2xl p-8 text-center transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-green-500/25 transform">
                        <div class="w-24 h-24 bg-gradient-to-br from-green-400 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:rotate-12 transition-transform duration-300 animate-float"
                            style="animation-delay: 1s">
                            <i class="fas fa-book text-3xl text-white"></i>
                        </div>
                        <h3
                            class="text-2xl font-semibold text-white group-hover:text-green-400 transition-colors duration-300 mb-3">
                            Books
                        </h3>
                        <p class="text-gray-400 group-hover:text-gray-300 transition-colors duration-300">
                            Knowledge & stories, fiction, non-fiction, and educational
                        </p>
                        <div class="mt-4 text-green-400 group-hover:text-green-300 transition-colors duration-300">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>
                </div>

                <!-- Category 4: Home & Garden -->
                <div class="group animate-fade-in-up delay-400">
                    <a href="category.html?category=home"
                        class="block glass rounded-2xl p-8 text-center transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-orange-500/25 transform">
                        <div class="w-24 h-24 bg-gradient-to-br from-orange-400 to-orange-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:rotate-12 transition-transform duration-300 animate-float"
                            style="animation-delay: 1.5s">
                            <i class="fas fa-home text-3xl text-white"></i>
                        </div>
                        <h3
                            class="text-2xl font-semibold text-white group-hover:text-orange-400 transition-colors duration-300 mb-3">
                            Home & Garden
                        </h3>
                        <p class="text-gray-400 group-hover:text-gray-300 transition-colors duration-300">
                            Comfort & beauty for your living spaces
                        </p>
                        <div class="mt-4 text-orange-400 group-hover:text-orange-300 transition-colors duration-300">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>
                </div>

                <!-- Category 5: Sports & Fitness -->
                <div class="group animate-fade-in-up delay-500">
                    <a href="category.html?category=sports"
                        class="block glass rounded-2xl p-8 text-center transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-red-500/25 transform">
                        <div class="w-24 h-24 bg-gradient-to-br from-red-400 to-red-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:rotate-12 transition-transform duration-300 animate-float"
                            style="animation-delay: 2s">
                            <i class="fas fa-dumbbell text-3xl text-white"></i>
                        </div>
                        <h3
                            class="text-2xl font-semibold text-white group-hover:text-red-400 transition-colors duration-300 mb-3">
                            Sports & Fitness
                        </h3>
                        <p class="text-gray-400 group-hover:text-gray-300 transition-colors duration-300">
                            Equipment and gear for active lifestyle
                        </p>
                        <div class="mt-4 text-red-400 group-hover:text-red-300 transition-colors duration-300">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>
                </div>

                <!-- Category 6: Beauty & Health -->
                <div class="group animate-fade-in-up delay-600">
                    <a href="category.html?category=beauty"
                        class="block glass rounded-2xl p-8 text-center transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-pink-500/25 transform">
                        <div class="w-24 h-24 bg-gradient-to-br from-pink-400 to-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:rotate-12 transition-transform duration-300 animate-float"
                            style="animation-delay: 2.5s">
                            <i class="fas fa-heart text-3xl text-white"></i>
                        </div>
                        <h3
                            class="text-2xl font-semibold text-white group-hover:text-pink-400 transition-colors duration-300 mb-3">
                            Beauty & Health
                        </h3>
                        <p class="text-gray-400 group-hover:text-gray-300 transition-colors duration-300">
                            Skincare, cosmetics, and wellness products
                        </p>
                        <div class="mt-4 text-pink-400 group-hover:text-pink-300 transition-colors duration-300">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>
                </div>

                <!-- Category 7: Automotive -->
                <div class="group animate-fade-in-up delay-700">
                    <a href="category.html?category=automotive"
                        class="block glass rounded-2xl p-8 text-center transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-indigo-500/25 transform">
                        <div class="w-24 h-24 bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:rotate-12 transition-transform duration-300 animate-float"
                            style="animation-delay: 3s">
                            <i class="fas fa-car text-3xl text-white"></i>
                        </div>
                        <h3
                            class="text-2xl font-semibold text-white group-hover:text-indigo-400 transition-colors duration-300 mb-3">
                            Automotive
                        </h3>
                        <p class="text-gray-400 group-hover:text-gray-300 transition-colors duration-300">
                            Car accessories, parts, and maintenance tools
                        </p>
                        <div class="mt-4 text-indigo-400 group-hover:text-indigo-300 transition-colors duration-300">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>
                </div>

                <!-- Category 8: Toys & Games -->
                <div class="group animate-fade-in-up delay-800">
                    <a href="category.html?category=toys"
                        class="block glass rounded-2xl p-8 text-center transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-yellow-500/25 transform">
                        <div class="w-24 h-24 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:rotate-12 transition-transform duration-300 animate-float"
                            style="animation-delay: 3.5s">
                            <i class="fas fa-gamepad text-3xl text-white"></i>
                        </div>
                        <h3
                            class="text-2xl font-semibold text-white group-hover:text-yellow-400 transition-colors duration-300 mb-3">
                            Toys & Games
                        </h3>
                        <p class="text-gray-400 group-hover:text-gray-300 transition-colors duration-300">
                            Fun and entertainment for all ages
                        </p>
                        <div class="mt-4 text-yellow-400 group-hover:text-yellow-300 transition-colors duration-300">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </main>
@endsection
