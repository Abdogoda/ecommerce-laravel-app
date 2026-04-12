@extends('layouts.admin-app')

@section('content')
    <div class="p-6">
        <!-- Page Header -->
        <div class="mb-8 fade-in-up">
            <div class="flex justify-between items-center">
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
                        <p class="text-2xl font-bold text-white">1,234</p>
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
                        <p class="text-2xl font-bold text-white">987</p>
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
                        <p class="text-2xl font-bold text-white">43</p>
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
                        <p class="text-2xl font-bold text-white">12</p>
                    </div>
                    <div class="icon w-12 h-12 bg-red-500/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-times-circle text-red-400 text-xl"></i>
                    </div>
                </div>
            </div>
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
                        <!-- Product rows -->
                        <tr class="table-row">
                            <td class="px-6 py-4">
                                <a href="./show.html"
                                    class="flex items-center text-white hover:text-blue-300 transition-colors">
                                    <img class="w-12 h-12 rounded-lg object-cover mr-4 transition-transform duration-300 hover:scale-110"
                                        src="https://picsum.photos/48/48?random=1" alt="Product" />
                                    <div>
                                        <div class="text-sm font-medium">
                                            Premium Wireless Headphones
                                        </div>
                                    </div>
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 bg-blue-500/20 text-blue-400 rounded-full text-xs">Electronics</span>
                            </td>
                            <td class="px-6 py-4 text-white">$299.99</td>
                            <td class="px-6 py-4">
                                <span class="text-green-400">45 units</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 bg-green-500/20 text-green-400 rounded-full text-xs">Active</span>
                            </td>
                        </tr>

                        <tr class="table-row">
                            <td class="px-6 py-4">
                                <a href="./show.html"
                                    class="flex items-center text-white hover:text-blue-300 transition-colors">
                                    <img class="w-12 h-12 rounded-lg object-cover mr-4 transition-transform duration-300 hover:scale-110"
                                        src="https://picsum.photos/48/48?random=2" alt="Product" />
                                    <div>
                                        <div class="text-sm font-medium">Smartphone Case</div>
                                    </div>
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 bg-blue-500/20 text-blue-400 rounded-full text-xs">Electronics</span>
                            </td>
                            <td class="px-6 py-4 text-white">$24.99</td>
                            <td class="px-6 py-4">
                                <span class="text-yellow-400">8 units</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 bg-green-500/20 text-green-400 rounded-full text-xs">Active</span>
                            </td>
                        </tr>

                        <tr class="table-row">
                            <td class="px-6 py-4">
                                <a href="./show.html"
                                    class="flex items-center text-white hover:text-blue-300 transition-colors">
                                    <img class="w-12 h-12 rounded-lg object-cover mr-4 transition-transform duration-300 hover:scale-110"
                                        src="https://picsum.photos/48/48?random=3" alt="Product" />
                                    <div>
                                        <div class="text-sm font-medium">Cotton T-Shirt</div>
                                    </div>
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2 py-1 bg-purple-500/20 text-purple-400 rounded-full text-xs">Clothing</span>
                            </td>
                            <td class="px-6 py-4 text-white">$19.99</td>
                            <td class="px-6 py-4">
                                <span class="text-red-400">0 units</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 bg-red-500/20 text-red-400 rounded-full text-xs">Out of Stock</span>
                            </td>
                        </tr>

                        <tr class="table-row">
                            <td class="px-6 py-4">
                                <a href="./show.html"
                                    class="flex items-center text-white hover:text-blue-300 transition-colors">
                                    <img class="w-12 h-12 rounded-lg object-cover mr-4"
                                        src="https://picsum.photos/48/48?random=4" alt="Product" />
                                    <div>
                                        <div class="text-sm font-medium">Programming Book</div>
                                    </div>
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 bg-green-500/20 text-green-400 rounded-full text-xs">Books</span>
                            </td>
                            <td class="px-6 py-4 text-white">$49.99</td>
                            <td class="px-6 py-4">
                                <span class="text-green-400">23 units</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 bg-green-500/20 text-green-400 rounded-full text-xs">Active</span>
                            </td>
                        </tr>

                        <tr class="table-row">
                            <td class="px-6 py-4">
                                <a href="./show.html"
                                    class="flex items-center text-white hover:text-blue-300 transition-colors">
                                    <img class="w-12 h-12 rounded-lg object-cover mr-4"
                                        src="https://picsum.photos/48/48?random=5" alt="Product" />
                                    <div>
                                        <div class="text-sm font-medium">Garden Tools Set</div>
                                    </div>
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 bg-orange-500/20 text-orange-400 rounded-full text-xs">Home &
                                    Garden</span>
                            </td>
                            <td class="px-6 py-4 text-white">$89.99</td>
                            <td class="px-6 py-4">
                                <span class="text-green-400">15 units</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 bg-gray-500/20 text-gray-400 rounded-full text-xs">Draft</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Table Footer with Pagination -->
            <div class="bg-gray-800/30 px-6 py-4 border-t border-gray-700">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-400">
                        Showing <span class="font-medium text-white">1</span> to
                        <span class="font-medium text-white">5</span> of
                        <span class="font-medium text-white">1,234</span> results
                    </div>
                    <div class="flex items-center space-x-2">
                        <button
                            class="pagination-btn px-3 py-2 bg-gray-700 text-gray-400 rounded-lg hover:bg-gray-600 hover:text-white transition-all duration-300 disabled:opacity-50"
                            disabled>
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="pagination-btn active px-3 py-2 text-white rounded-lg">
                            1
                        </button>
                        <button
                            class="pagination-btn px-3 py-2 bg-gray-700 text-gray-400 hover:bg-gray-600 hover:text-white rounded-lg transition-all duration-300">
                            2
                        </button>
                        <button
                            class="pagination-btn px-3 py-2 bg-gray-700 text-gray-400 hover:bg-gray-600 hover:text-white rounded-lg transition-all duration-300">
                            3
                        </button>
                        <span class="px-3 py-2 text-gray-400">...</span>
                        <button
                            class="pagination-btn px-3 py-2 bg-gray-700 text-gray-400 hover:bg-gray-600 hover:text-white rounded-lg transition-all duration-300">
                            247
                        </button>
                        <button
                            class="pagination-btn px-3 py-2 bg-gray-700 text-gray-400 rounded-lg hover:bg-gray-600 hover:text-white transition-all duration-300">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
