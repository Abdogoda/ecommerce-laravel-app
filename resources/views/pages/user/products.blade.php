@extends('layouts.user-app')

@section('title', 'Products - E-Commerce Store')

@section('content')
    <div class="max-w-7xl mx-auto px-6 py-16">
        <h1 class="text-5xl font-bold text-center mb-12 text-white animate-fade-in-up">
            <span class="bg-gradient-to-r from-blue-400 to-purple-500 bg-clip-text text-transparent">
                Our Products
            </span>
            <div class="w-24 h-1 bg-gradient-to-r from-blue-400 to-purple-500 mx-auto mt-4 rounded-full"></div>
        </h1>

        <!-- Mobile Filter Toggle Button -->
        <div class="lg:hidden mb-6">
            <button onclick="toggleFilters()"
                class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold py-3 rounded-xl transition-all duration-300 flex items-center justify-center gap-2">
                <i class="fas fa-sliders-h"></i>Filters & Search
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar Filters -->
            <aside id="filterPanel"
                class="hidden lg:block lg:col-span-1 animate-fade-in-left fixed lg:static inset-0 z-50 lg:z-auto">
                <!-- Mobile Close Button -->
                <button onclick="toggleFilters()"
                    class="lg:hidden fixed top-4 right-4 z-50 bg-red-500 hover:bg-red-600 text-white p-3 rounded-full">
                    <i class="fas fa-times"></i>
                </button>

                <!-- Mobile Overlay -->
                <div onclick="toggleFilters()" class="lg:hidden fixed inset-0 bg-black/50 backdrop-blur-sm"></div>

                <div
                    class="bg-gray-800/50 backdrop-blur-sm p-6 rounded-2xl shadow-2xl border border-gray-700/50 lg:bg-gray-800/50 relative lg:relative z-50 lg:z-auto max-h-[100vh] lg:max-h-none overflow-y-auto lg:overflow-visible">
                    <form method="GET" action="{{ route('products.index') }}" id="filterForm">
                        <h3 class="text-2xl font-semibold text-center text-white mb-6">
                            <i class="fas fa-filter mr-2 text-blue-400"></i>Filters
                        </h3>
                        <div class="w-16 h-0.5 bg-gradient-to-r from-blue-400 to-purple-500 mx-auto mb-6"></div>

                        <!-- Search -->
                        <div class="mb-8">
                            <h4 class="font-semibold text-gray-200 mb-4 flex items-center">
                                <i class="fas fa-search mr-2 text-blue-400"></i>Search
                            </h4>
                            <input type="text" name="search" placeholder="Search products..."
                                value="{{ request('search') }}"
                                class="w-full p-3 bg-gray-700/50 border border-gray-600 rounded-xl text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" />
                        </div>

                        <div class="w-full h-px bg-gradient-to-r from-transparent via-gray-600 to-transparent my-6"></div>

                        <!-- Category Filter -->
                        <div class="mb-8">
                            <h4 class="font-semibold text-gray-200 mb-4 flex items-center">
                                <i class="fas fa-tags mr-2 text-purple-400"></i>Category
                            </h4>
                            <div class="space-y-3">
                                @foreach ($categories as $category)
                                    <label
                                        class="flex items-center space-x-3 text-gray-300 cursor-pointer hover:text-white transition-colors duration-300">
                                        <input type="checkbox" name="category_ids[]" value="{{ $category->id }}"
                                            {{ in_array($category->id, (array) request('category_ids', [])) ? 'checked' : '' }}
                                            class="w-5 h-5 text-blue-500 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 transition-all duration-300" />
                                        <span>{{ $category->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="w-full h-px bg-gradient-to-r from-transparent via-gray-600 to-transparent my-6"></div>

                        <!-- Price Filter -->
                        <div class="mb-8">
                            <h4 class="font-semibold text-gray-200 mb-4 flex items-center">
                                <i class="fas fa-dollar-sign mr-2 text-green-400"></i>Price Range
                            </h4>
                            <div class="space-y-3">
                                <input type="number" name="min_price" min="0" placeholder="Min Price"
                                    value="{{ request('min_price') }}"
                                    class="w-full p-3 bg-gray-700/50 border border-gray-600 rounded-xl text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" />
                                <input type="number" name="max_price" min="0" placeholder="Max Price"
                                    value="{{ request('max_price') }}"
                                    class="w-full p-3 bg-gray-700/50 border border-gray-600 rounded-xl text-gray-100 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300" />
                            </div>
                        </div>

                        <div class="w-full h-px bg-gradient-to-r from-transparent via-gray-600 to-transparent my-6"></div>

                        <!-- Sort By -->
                        <div class="mb-8">
                            <h4 class="font-semibold text-gray-200 mb-4 flex items-center">
                                <i class="fas fa-sort mr-2 text-yellow-400"></i>Sort By
                            </h4>
                            <select name="sort_by"
                                class="w-full p-3 bg-gray-700/50 border border-gray-600 rounded-xl text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                                <option value="latest" {{ request('sort_by') === 'latest' ? 'selected' : '' }}>Latest
                                </option>
                                <option value="popular" {{ request('sort_by') === 'popular' ? 'selected' : '' }}>Most
                                    Popular</option>
                                <option value="price_low" {{ request('sort_by') === 'price_low' ? 'selected' : '' }}>Price:
                                    Low to High</option>
                                <option value="price_high" {{ request('sort_by') === 'price_high' ? 'selected' : '' }}>
                                    Price: High to Low</option>
                            </select>
                        </div>

                        <div class="w-full h-px bg-gradient-to-r from-transparent via-gray-600 to-transparent my-6"></div>

                        <!-- Featured Filter -->
                        <div class="mb-8">
                            <h4 class="font-semibold text-gray-200 mb-4 flex items-center">
                                <i class="fas fa-star mr-2 text-yellow-400"></i>Featured
                            </h4>
                            <label
                                class="flex items-center space-x-3 text-gray-300 cursor-pointer hover:text-white transition-colors duration-300">
                                <input type="checkbox" name="featured" value="1"
                                    {{ request('featured') ? 'checked' : '' }}
                                    class="w-5 h-5 text-blue-500 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 transition-all duration-300" />
                                <span>Show Featured Products</span>
                            </label>
                        </div>

                        <div class="flex gap-3">
                            <button type="submit"
                                class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold py-3 rounded-xl transition-all duration-300 hover:scale-105 transform hover:shadow-lg hover:shadow-blue-500/25">
                                <i class="fas fa-search mr-2"></i>Apply
                            </button>
                            <a href="{{ route('products.index') }}"
                                class="flex-1 bg-gradient-to-r from-gray-600 to-gray-500 hover:from-gray-500 hover:to-gray-400 text-center text-white font-semibold py-3 rounded-xl transition-all duration-300 hover:scale-105 transform hover:shadow-lg">
                                <i class="fas fa-undo mr-2"></i>Clear
                            </a>
                        </div>
                    </form>
                </div>
            </aside>

            <!-- Products Grid -->
            <div class="lg:col-span-3 animate-fade-in-right">
                @if ($products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">
                        @forelse($products as $product)
                            <x-product-card :product="$product" :index="$loop->index" />
                        @empty
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if ($products->hasPages())
                        <div class="mt-12 flex justify-center animate-fade-in-up">
                            {{ $products->links('pagination::tailwind') }}
                        </div>
                    @endif
                @else
                    <div class="col-span-full text-center py-16">
                        <i class="fas fa-box text-6xl text-gray-600 mb-4"></i>
                        <p class="text-gray-400 text-xl">No products found. Try adjusting your filters.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function toggleFilters() {
            const filterPanel = document.getElementById('filterPanel');
            filterPanel.classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden');
        }

        // Close filters when clicking apply button on mobile
        document.getElementById('filterForm')?.addEventListener('submit', function() {
            if (window.innerWidth < 1024) {
                toggleFilters();
            }
        });
    </script>
@endsection
