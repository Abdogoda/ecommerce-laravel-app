@extends('layouts.user-app')

@section('title', $category->name . ' - E-Commerce Store')

@section('content')
    <!-- Hero Section -->
    <section class="relative py-20 px-6 bg-gradient-to-br from-blue-900/50 to-purple-900/50 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-transparent"></div>
        <!-- Animated background elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-20 left-10 w-4 h-4 bg-blue-400 rounded-full animate-bounce"></div>
            <div class="absolute top-40 right-20 w-6 h-6 bg-purple-400 rounded-full animate-ping"></div>
            <div class="absolute bottom-40 left-20 w-8 h-8 bg-pink-400 rounded-full animate-pulse"></div>
            <div class="absolute bottom-20 right-10 w-3 h-3 bg-yellow-400 rounded-full animate-spin"></div>
        </div>

        <div class="relative z-10 max-w-6xl mx-auto">
            <div class="flex flex-col lg:flex-row items-center space-y-8 lg:space-y-0 lg:space-x-12">
                <div class="lg:w-1/2 text-center lg:text-left animate-fade-in-left">
                    <div class="relative mb-8">
                        <div
                            class="w-32 h-32 lg:w-40 lg:h-40 bg-gradient-to-br from-blue-400 to-purple-600 rounded-full flex items-center justify-center mx-auto lg:mx-0 shadow-2xl">
                            @if ($category->isIconImage())
                                <img src="{{ asset('storage/' . $category->icon) }}" alt="{{ $category->name }}"
                                    class="w-full h-full object-cover rounded-full">
                            @else
                                <i class="{{ $category->icon ?? 'fas fa-box' }} text-5xl lg:text-6xl text-white"></i>
                            @endif
                        </div>
                        <div
                            class="absolute -top-2 -right-2 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center border-4 border-gray-900">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                    </div>
                    <h1 class="text-5xl lg:text-6xl font-bold text-white mb-6">
                        <span class="bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">
                            {{ $category->name }}
                        </span>
                    </h1>
                    <p class="text-xl text-gray-300 mb-8 leading-relaxed">
                        {{ $category->description }}
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="#products"
                            class="inline-flex items-center bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-8 py-4 rounded-xl transition-all duration-300 hover:scale-105 transform hover:shadow-lg hover:shadow-blue-500/25 text-lg font-semibold">
                            <i class="fas fa-eye mr-2"></i>View Products
                        </a>
                        <a href="{{ route('categories.index') }}"
                            class="inline-flex items-center glass text-white px-8 py-4 rounded-xl hover:bg-white/20 transition-all duration-300 hover:scale-105 transform text-lg font-semibold">
                            <i class="fas fa-th-large mr-2"></i>All Categories
                        </a>
                    </div>
                </div>

                <div class="lg:w-1/2 animate-fade-in-right">
                    <div class="grid grid-cols-2 gap-4">
                        <div
                            class="bg-gray-800/50 backdrop-blur-sm p-6 rounded-2xl border border-gray-700/50 hover:border-blue-500/50 transition-all duration-300">
                            <i class="fas fa-cube text-3xl text-blue-400 mb-4"></i>
                            <h3 class="text-lg font-semibold text-white mb-2">
                                Total Products
                            </h3>
                            <p class="text-gray-400 text-sm">{{ $category->products_count }} items available</p>
                        </div>
                        <div
                            class="bg-gray-800/50 backdrop-blur-sm p-6 rounded-2xl border border-gray-700/50 hover:border-purple-500/50 transition-all duration-300">
                            <i class="fas fa-star text-3xl text-purple-400 mb-4"></i>
                            <h3 class="text-lg font-semibold text-white mb-2">Premium Quality</h3>
                            <p class="text-gray-400 text-sm">Curated selections</p>
                        </div>
                        <div
                            class="bg-gray-800/50 backdrop-blur-sm p-6 rounded-2xl border border-gray-700/50 hover:border-green-500/50 transition-all duration-300">
                            <i class="fas fa-truck text-3xl text-green-400 mb-4"></i>
                            <h3 class="text-lg font-semibold text-white mb-2">Fast Shipping</h3>
                            <p class="text-gray-400 text-sm">Quick delivery</p>
                        </div>
                        <div
                            class="bg-gray-800/50 backdrop-blur-sm p-6 rounded-2xl border border-gray-700/50 hover:border-orange-500/50 transition-all duration-300">
                            <i class="fas fa-lock text-3xl text-orange-400 mb-4"></i>
                            <h3 class="text-lg font-semibold text-white mb-2">Secure Payment</h3>
                            <p class="text-gray-400 text-sm">Safe transactions</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section id="products" class="py-16 px-6 bg-gray-900">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-bold text-center mb-12 text-white animate-fade-in-up">
                <span class="bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">
                    {{ $category->name }} Products
                </span>
                <div class="w-24 h-1 bg-gradient-to-r from-blue-400 to-purple-500 mx-auto mt-4 rounded-full"></div>
            </h2>

            @if ($category->products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @forelse($category->products as $product)
                        <div class="group bg-gray-800/50 backdrop-blur-sm rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl hover:shadow-blue-500/25 transition-all duration-300 hover:scale-105 transform animate-fade-in-up"
                            style="animation-delay: {{ $loop->index * 50 }}ms">
                            <div class="relative overflow-hidden">
                                <a href="{{ route('products.show', $product->id) }}">
                                    @if ($product->media->first())
                                        <img src="{{ $product->media->first()->getUrl() }}" alt="{{ $product->name }}"
                                            class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500" />
                                    @else
                                        <div
                                            class="w-full h-64 bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center">
                                            <i class="fas fa-image text-4xl text-gray-600"></i>
                                        </div>
                                    @endif
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    </div>
                                </a>
                                <div class="absolute top-4 right-4">
                                    <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                        @if ($product->is_featured)
                                            Featured
                                        @elseif($product->created_at->diffInDays() < 7)
                                            New
                                        @else
                                            Available
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="p-6">
                                <h3
                                    class="text-xl font-semibold text-white mb-2 group-hover:text-blue-400 transition-colors duration-300 line-clamp-1">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-gray-400 text-sm mb-4 line-clamp-2">
                                    {{ $product->description }}
                                </p>
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center space-x-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= floor($product->rating ?? 4))
                                                <i class="fas fa-star text-yellow-400"></i>
                                            @else
                                                <i class="fas fa-star text-gray-400"></i>
                                            @endif
                                        @endfor
                                        <span class="text-gray-400 text-sm ml-2">({{ $product->rating ?? 4 }})</span>
                                    </div>
                                    <p class="text-2xl font-bold text-blue-400">${{ number_format($product->price, 2) }}
                                    </p>
                                </div>
                                <button
                                    onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, 1, '{{ $product->media->first()?->getUrl() ?? '' }}')"
                                    class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold py-3 rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/25 transform hover:scale-105">
                                    <i class="fas fa-cart-plus mr-2"></i>Add to Cart
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-16">
                            <p class="text-gray-400 text-lg">No products available in this category.</p>
                        </div>
                    @endforelse
                </div>
            @else
                <div class="text-center py-16">
                    <p class="text-gray-400 text-lg">No products available in this category yet.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
