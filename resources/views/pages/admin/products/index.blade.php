@extends('layouts.admin-app')

@section('content')
    <div class="p-6">
        <!-- Page Header -->
        <div class="mb-8 fade-in-up">
            <div class="flex justify-between items-center flex-wrap gap-3">
                <div>
                    <div class="flex gap-0 items-start flex-col sm:flex-row sm:gap-5 sm:items-center mb-2">
                        <h1 class="text-3xl font-bold text-white mb-2">
                            Product Management
                        </h1>
                        <div class="flex items-center space-x-4">
                            <div id="breadcrumb" class="text-sm text-gray-400">
                                <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:underline">Admin</a>
                                <i class="fas fa-chevron-right mx-2"></i>
                                <span class="text-white">Products</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-400">Manage your product inventory</p>
                </div>
                <button onclick="openModal('addProductModal')"
                    class="btn-primary px-6 py-3 rounded-lg text-white font-medium hover:shadow-xl transition-all duration-300">
                    <i class="fas fa-plus mr-2"></i>
                    Add Product
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="stats-card admin-card rounded-xl p-6 fade-in-up delay-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Total Products</p>
                        <p class="text-2xl font-bold text-white">{{ $stats['total'] }}</p>
                    </div>
                    <div class="icon w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-box text-blue-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="stats-card admin-card rounded-xl p-6 fade-in-up delay-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">In Stock</p>
                        <p class="text-2xl font-bold text-white">{{ $stats['in_stock'] }}</p>
                    </div>
                    <div class="icon w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="stats-card admin-card rounded-xl p-6 fade-in-up delay-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Low Stock</p>
                        <p class="text-2xl font-bold text-white">{{ $stats['low_stock'] }}</p>
                    </div>
                    <div class="icon w-12 h-12 bg-yellow-500/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-yellow-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="stats-card admin-card rounded-xl p-6 fade-in-up delay-400">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Out of Stock</p>
                        <p class="text-2xl font-bold text-white">{{ $stats['out_of_stock'] }}</p>
                    </div>
                    <div class="icon w-12 h-12 bg-red-500/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-times-circle text-red-400 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search & Filter Section -->
        <div class="admin-card rounded-xl p-6 mb-8 fade-in-up delay-100">
            <form method="GET" action="{{ route('admin.products.index') }}" class="space-y-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-white">Search & Filter</h3>
                    @if (request()->hasAny(['search', 'category_id', 'min_price', 'max_price', 'status']))
                        <a href="{{ route('admin.products.index') }}" class="text-sm text-blue-400 hover:text-blue-300">
                            <i class="fas fa-times mr-1"></i>Clear Filters
                        </a>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    <!-- Search Input -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Search Products</label>
                        <input type="text" name="search" placeholder="Product name or description..."
                            value="{{ request('search') }}"
                            class="w-full px-4 py-2 bg-gray-700 text-white placeholder-gray-500 rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500 transition-colors">
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Category</label>
                        <select name="category_id"
                            class="w-full px-4 py-2 bg-gray-700 text-white rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500 transition-colors">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Min Price Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Min Price</label>
                        <input type="number" name="min_price" placeholder="0.00" step="0.01" min="0"
                            value="{{ request('min_price') }}"
                            class="w-full px-4 py-2 bg-gray-700 text-white placeholder-gray-500 rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500 transition-colors">
                    </div>

                    <!-- Max Price Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Max Price</label>
                        <input type="number" name="max_price" placeholder="No limit" step="0.01" min="0"
                            value="{{ request('max_price') }}"
                            class="w-full px-4 py-2 bg-gray-700 text-white placeholder-gray-500 rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500 transition-colors">
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Stock Status</label>
                        <select name="status"
                            class="w-full px-4 py-2 bg-gray-700 text-white rounded-lg border border-gray-600 focus:outline-none focus:border-blue-500 transition-colors">
                            <option value="">All Status</option>
                            <option value="in_stock" {{ request('status') == 'in_stock' ? 'selected' : '' }}>In Stock
                            </option>
                            <option value="low_stock" {{ request('status') == 'low_stock' ? 'selected' : '' }}>Low Stock
                            </option>
                            <option value="out_of_stock" {{ request('status') == 'out_of_stock' ? 'selected' : '' }}>Out of
                                Stock</option>
                        </select>
                    </div>
                </div>

                <!-- Search Button -->
                <div class="flex gap-3">
                    <button type="submit"
                        class="btn-primary px-6 py-2 rounded-lg text-white font-medium hover:shadow-xl transition-all duration-300">
                        <i class="fas fa-search mr-2"></i>Search
                    </button>
                </div>
            </form>
        </div>

        <!-- Products Table -->
        <div class="admin-card rounded-xl overflow-hidden fade-in-right">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full">
                    <thead class="bg-gray-800/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                Product
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                Category
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                Tags
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                Price
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                Stock
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @forelse ($products as $product)
                            <tr class="table-row">
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.products.show', $product) }}"
                                        class="flex items-center text-white hover:text-blue-300 transition-colors">
                                        <img class="w-12 h-12 rounded-lg object-cover mr-4 transition-transform duration-300 hover:scale-110"
                                            src="{{ $product->getPrimaryImageUrl() }}" alt="Product" />
                                        <div>
                                            <div class="text-sm font-medium">
                                                {{ $product->name }}
                                            </div>
                                        </div>
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 py-1 bg-blue-500/20 text-blue-400 rounded-full text-xs">{{ $product->category->name }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($product->tags->count() > 0)
                                        <div class="flex flex-wrap gap-1">
                                            @foreach ($product->tags->take(2) as $tag)
                                                <span
                                                    class="px-2 py-1 bg-purple-500/20 text-purple-400 rounded-full text-xs">
                                                    {{ $tag->name }}
                                                </span>
                                            @endforeach
                                            @if ($product->tags->count() > 2)
                                                <span
                                                    class="px-2 py-1 bg-purple-500/20 text-purple-400 rounded-full text-xs">
                                                    +{{ $product->tags->count() - 2 }}
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-gray-500 text-xs">No tags</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-white">${{ number_format($product->price, 2) }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="text-{{ $product->stock > $orderSettings->low_stock_threshold ? 'green' : ($product->stock > 0 ? 'yellow' : 'red') }}-400">{{ $product->stock }}
                                        units</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($product->is_active)
                                        <span
                                            class="px-2 py-1 bg-green-500/20 text-green-400 rounded-full text-xs">Active</span>
                                    @else
                                        <span
                                            class="px-2 py-1 bg-red-500/20 text-red-400 rounded-full text-xs">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-400">
                                    No products found.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-white/10">
                {{ $products->links('pagination::tailwind') }}
            </div>
        </div>
    </div>


    @can(\App\Enums\PermissionEnum::CREATE_PRODUCTS->value)
        @include('pages.admin.products.modals.create')
    @endcan
@endsection
