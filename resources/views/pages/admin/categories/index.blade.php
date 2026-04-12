@extends('layouts.admin-app')

@section('content')
    <!-- Page Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-8 animate-slide-in">
        <div>
            <div class="flex gap-0 items-start flex-col sm:flex-row sm:gap-5 sm:items-center mb-2">
                <h1 class="text-3xl font-bold text-white mb-2">
                    Category Management
                </h1>
                <div class="flex items-center space-x-4">
                    <div id="breadcrumb" class="text-sm text-gray-400">
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:underline">Admin</a>
                        <i class="fas fa-chevron-right mx-2"></i>
                        <span class="text-white">Categories</span>
                    </div>
                </div>
            </div>
            <p class="text-gray-400">
                Organize your products into categories for better navigation
            </p>
        </div>
        <div class="mt-4 lg:mt-0">
            <button onclick="openModal('addCategoryModal')"
                class="btn-primary px-6 py-3 rounded-xl text-white font-bold hover:scale-105 transition-transform">
                <i class="fas fa-plus mr-2"></i>
                Add New Category
            </button>
        </div>
    </div>

    <!-- Categories Table -->
    <div class="admin-card rounded-2xl overflow-hidden animate-slide-in">
        <div class="p-6 border-b border-white/10">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h2 class="text-xl font-bold text-white">All Categories</h2>
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full">
                <thead class="glass border-b border-white/10">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            Category
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            Products
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            Created
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    <tr class="table-row">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div
                                    class="hidden md:flex w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg items-center justify-center mr-3">
                                    <i class="fas fa-laptop text-white"></i>
                                </div>
                                <div>
                                    <a href="./show.html"
                                        class="text-white hover:text-blue-400 transition-colors font-medium">Electronics</a>
                                    <p class="text-gray-400 text-sm">Gadgets and devices</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-white">342 products</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-xs font-medium">
                                Active
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-400">Dec 15, 2023</td>
                    </tr>

                    <tr class="table-row">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div
                                    class="hidden md:flex w-10 h-10 bg-gradient-to-br from-pink-500 to-pink-600 rounded-lg items-center justify-center mr-3">
                                    <i class="fas fa-tshirt text-white"></i>
                                </div>
                                <div>
                                    <a href="./show.html"
                                        class="text-white hover:text-blue-400 transition-colors font-medium">Fashion</a>
                                    <p class="text-gray-400 text-sm">
                                        Clothing and accessories
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-white">158 products</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-xs font-medium">
                                Active
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-400">Dec 10, 2023</td>
                    </tr>

                    <tr class="table-row">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div
                                    class="hidden md:flex w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg items-center justify-center mr-3">
                                    <i class="fas fa-home text-white"></i>
                                </div>
                                <div>
                                    <a href="./show.html"
                                        class="text-white hover:text-blue-400 transition-colors font-medium">Home &
                                        Garden</a>
                                    <p class="text-gray-400 text-sm">
                                        Home improvement items
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-white">89 products</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-xs font-medium">
                                Active
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-400">Dec 8, 2023</td>
                    </tr>

                    <tr class="table-row">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div
                                    class="hidden md:flex w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg items-center justify-center mr-3">
                                    <i class="fas fa-dumbbell text-white"></i>
                                </div>
                                <div>
                                    <a href="./show.html"
                                        class="text-white hover:text-blue-400 transition-colors font-medium">Sports &
                                        Fitness</a>
                                    <p class="text-gray-400 text-sm">Exercise equipment</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-white">67 products</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-yellow-500/20 text-yellow-400 rounded-full text-xs font-medium">
                                Inactive
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-400">Dec 5, 2023</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-6 border-t border-white/10 flex items-center justify-between">
            <div class="text-gray-400 text-sm">
                Showing 1 to 4 of 28 entries
            </div>
            <div class="flex items-center">
                <button class="glass px-3 py-2 rounded-lg text-gray-400 hover:text-white transition-colors">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="bg-blue-500 px-3 py-2 rounded-lg text-white">
                    1
                </button>
                <button class="glass px-3 py-2 rounded-lg text-gray-400 hover:text-white transition-colors">
                    2
                </button>
                <button class="glass px-3 py-2 rounded-lg text-gray-400 hover:text-white transition-colors">
                    3
                </button>
                <button class="glass px-3 py-2 rounded-lg text-gray-400 hover:text-white transition-colors">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
@endsection
