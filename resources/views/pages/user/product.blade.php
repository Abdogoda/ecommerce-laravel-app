@extends('layouts.user-app')

@section('title', $product->name . ' - E-Commerce Store')

@section('content')
    <main class="min-h-screen bg-gradient-to-br from-gray-900 to-gray-800 px-6 py-16">
        <div class="max-w-7xl mx-auto">
            <!-- Product Details Section -->
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-12 mb-16">
                <!-- Product Images -->
                <div class="animate-fade-in-left lg:col-span-2">
                    <div class="mb-6">
                        <div
                            class="relative overflow-hidden rounded-2xl bg-gray-800/50 backdrop-blur-sm border border-gray-700/50 shadow-2xl">
                            <img id="mainImage"
                                src="{{ $product->media->first()?->getUrl() ?? 'https://via.placeholder.com/600x400?text=' . urlencode($product->name) }}"
                                class="w-full h-80 lg:h-96 object-cover transition-transform duration-500 hover:scale-105"
                                alt="{{ $product->name }}" />
                            <div class="absolute top-4 right-4">
                                <span
                                    class="bg-blue-500 text-white px-3 py-1 rounded-full text-sm font-semibold animate-pulse">
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
                    </div>

                    <!-- Thumbnail Images -->
                    @if ($product->media->count() > 1)
                        <div class="grid gap-4"
                            style="grid-template-columns: repeat({{ min(6, $product->media->count()) }}, 1fr);">
                            @foreach ($product->media as $media)
                                <div class="group cursor-pointer">
                                    <img src="{{ $media->getUrl() }}"
                                        class="w-full h-20 object-cover rounded-xl border-2 border-transparent group-hover:border-blue-500 transition-all duration-300 hover:scale-105"
                                        onclick="document.getElementById('mainImage').src='{{ $media->getUrl() }}'"
                                        alt="{{ $product->name }}" />
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Product Information -->
                <div class="animate-fade-in-right lg:col-span-3">
                    <div class="glass rounded-2xl p-8 shadow-2xl">
                        <h1 class="text-4xl font-bold text-white mb-6">
                            {{ $product->name }}
                        </h1>

                        <!-- Rating -->
                        <div class="flex items-center space-x-2 mb-6">
                            <div class="flex items-center space-x-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= floor($product->rating ?? 4))
                                        <i class="fas fa-star text-yellow-400"></i>
                                    @else
                                        <i class="fas fa-star text-gray-400"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-gray-400">({{ $product->rating ?? 4 }})</span>
                            <span class="text-blue-400">|</span>
                            <span class="text-gray-400">{{ rand(10, 150) }} reviews</span>
                        </div>

                        <!-- Price & Stock -->
                        <div class="mb-6">
                            <p class="text-4xl font-bold text-blue-400 mb-2">${{ number_format($product->price, 2) }}</p>
                            <div class="flex items-center space-x-4">
                                <p class="text-gray-400">
                                    Category:
                                    <a href="{{ route('categories.show', $product->category->slug) }}"
                                        class="text-blue-300 hover:text-blue-400 transition-colors duration-300">
                                        {{ $product->category->name }}
                                    </a>
                                </p>
                                <div class="flex items-center space-x-2">
                                    @if ($product->stock > 0)
                                        <span class="inline-block w-2 h-2 bg-green-400 rounded-full"></span>
                                        <span class="text-green-400">In Stock ({{ $product->stock }})</span>
                                    @else
                                        <span class="inline-block w-2 h-2 bg-red-400 rounded-full"></span>
                                        <span class="text-red-400">Out of Stock</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Product Tags -->
                        @if ($product->tags->count() > 0)
                            <div class="flex flex-wrap gap-3 mb-6">
                                @foreach ($product->tags as $tag)
                                    <a href="{{ route('products.index', ['tags' => $tag->name]) }}"
                                        class="inline-flex items-center px-3 py-2 bg-gradient-to-r text-sm from-blue-500/20 to-purple-500/20 hover:from-blue-500/40 hover:to-purple-500/40 border border-blue-500/50 rounded-full text-blue-300 hover:text-blue-200 transition-all duration-300 hover:scale-105 transform">
                                        <i class="fas fa-tag mr-2 text-purple-400"></i>
                                        {{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        <!-- Quantity Selector -->
                        @if ($product->stock > 0)
                            <div class="mb-8">
                                <h4 class="font-semibold text-gray-200 mb-4">Quantity <span id="cartCountBadge"
                                        class="text-xs text-blue-400 ml-2">(In cart: 0)</span></h4>
                                <div class="flex items-center space-x-4">
                                    <button onclick="decrementQuantity()" id="decrementBtn"
                                        class="w-12 h-12 bg-gray-700/50 hover:bg-gray-600/50 rounded-lg text-white flex items-center justify-center transition-all duration-300">
                                        -
                                    </button>
                                    <input type="number" id="quantityInput" value="1" min="1"
                                        max="{{ $product->stock }}"
                                        class="w-20 px-4 py-2 bg-gray-700/50 border border-gray-600 rounded-lg text-center text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                    <button onclick="incrementQuantity()" id="incrementBtn"
                                        class="w-12 h-12 bg-gray-700/50 hover:bg-gray-600/50 rounded-lg text-white flex items-center justify-center transition-all duration-300">
                                        +
                                    </button>
                                </div>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="space-y-4">
                            @if ($product->stock > 0)
                                <button
                                    onclick="addToCartWithUpdate({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, getQuantity(), '{{ $product->media->first()?->getUrl() ?? '' }}')"
                                    class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold py-4 rounded-xl text-lg transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/25 transform hover:scale-105">
                                    <i class="fas fa-cart-plus mr-2"></i>Add to Cart
                                </button>
                            @else
                                <button disabled
                                    class="w-full bg-gray-600 text-gray-400 font-semibold py-4 rounded-xl text-lg cursor-not-allowed">
                                    <i class="fas fa-times mr-2"></i>Out of Stock
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Description Section -->
            @if ($product->description)
                <div class="animate-fade-in-up delay-200 mb-16">
                    <div class="glass rounded-2xl p-8 shadow-2xl">
                        <h2 class="text-3xl font-bold text-white mb-6">
                            <span class="bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">
                                Product Description
                            </span>
                        </h2>
                        <p class="text-gray-300 leading-relaxed text-lg">
                            {{ $product->description }}
                        </p>
                    </div>
                </div>
            @endif

            <!-- Related Products -->
            @if ($relatedProducts->count() > 0)
                <div class="animate-fade-in-up delay-300">
                    <div class="text-center mb-12">
                        <h2 class="text-4xl font-bold text-white mb-4">
                            <span class="bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">
                                Related Products
                            </span>
                        </h2>
                        <div class="w-24 h-1 bg-gradient-to-r from-blue-400 to-purple-500 mx-auto rounded-full"></div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                        @foreach ($relatedProducts as $relatedProduct)
                            <div class="group bg-gray-800/50 backdrop-blur-sm rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl hover:shadow-blue-500/25 transition-all duration-300 hover:scale-105 transform animate-fade-in-up"
                                style="animation-delay: {{ $loop->index * 100 }}ms">
                                <div class="relative overflow-hidden">
                                    <a href="{{ route('products.show', $relatedProduct->slug) }}">
                                        @if ($relatedProduct->media->first())
                                            <img src="{{ $relatedProduct->media->first()->getUrl() }}"
                                                alt="{{ $relatedProduct->name }}"
                                                class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500" />
                                        @else
                                            <div
                                                class="w-full h-48 bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center">
                                                <i class="fas fa-image text-3xl text-gray-600"></i>
                                            </div>
                                        @endif
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        </div>
                                    </a>
                                    <div class="absolute top-4 right-4">
                                        <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                            @if ($relatedProduct->is_featured)
                                                Featured
                                            @else
                                                New
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <h3
                                        class="text-lg font-semibold text-white mb-2 group-hover:text-blue-400 transition-colors duration-300 line-clamp-1">
                                        {{ $relatedProduct->name }}
                                    </h3>
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center space-x-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= floor($relatedProduct->rating ?? 4))
                                                    <i class="fas fa-star text-yellow-400 text-xs"></i>
                                                @else
                                                    <i class="fas fa-star text-gray-400 text-xs"></i>
                                                @endif
                                            @endfor
                                            <span
                                                class="text-gray-400 text-xs ml-1">({{ $relatedProduct->rating ?? 4 }})</span>
                                        </div>
                                        <p class="text-xl font-bold text-blue-400">
                                            ${{ number_format($relatedProduct->price, 2) }}</p>
                                    </div>
                                    <button
                                        onclick="addToCart({{ $relatedProduct->id }}, '{{ addslashes($relatedProduct->name) }}', {{ $relatedProduct->price }}, 1, '{{ $relatedProduct->media->first()?->getUrl() ?? '' }}')"
                                        class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold py-2 text-sm rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/25 transform hover:scale-105">
                                        <i class="fas fa-cart-plus mr-2"></i>Add
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </main>

    <script>
        const productId = {{ $product->id }};

        function updateCartCount() {
            const cartCount = getProductQuantityInCart(productId);
            const cartCountBadge = document.getElementById('cartCountBadge');
            if (cartCountBadge) {
                cartCountBadge.innerText = `(In cart: ${cartCount})`;
            }
        }

        function addToCartWithUpdate(productId, name, price, quantity = 1, image = "") {
            addToCart(productId, name, price, quantity, image);
            updateCartCount();
        }

        function getQuantity() {
            const input = document.getElementById('quantityInput');
            return input ? parseInt(input.value) || 1 : 1;
        }

        function incrementQuantity() {
            const input = document.getElementById('quantityInput');
            const max = input.max;
            if (input.value < max) {
                input.value = parseInt(input.value) + 1;
            }
        }

        function decrementQuantity() {
            const input = document.getElementById('quantityInput');
            if (input.value > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }

        // Initialize cart count on page load
        document.addEventListener('DOMContentLoaded', () => {
            updateCartCount();
        });
    </script>
@endsection
