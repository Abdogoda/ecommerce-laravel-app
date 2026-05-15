@extends('layouts.admin-app')

@section('content')
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">Dashboard</h1>
                <p class="text-gray-400">
                    Welcome back, Admin! Here's an overview of your store's
                    performance
                </p>
            </div>
            <div class="mt-4 sm:mt-0">
                <!-- Removed export and refresh buttons -->
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Orders -->
        <div class="admin-card stat-card p-6 rounded-2xl animate-slide-in">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm font-medium">Total Orders</p>
                    <p class="text-3xl font-bold text-white mt-2">{{ $stats['orders'] }}</p>
                </div>
                <div class="bg-blue-500/20 p-3 rounded-xl">
                    <i class="fas fa-shopping-cart text-blue-400 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Products -->
        <div class="admin-card stat-card p-6 rounded-2xl animate-slide-in" style="animation-delay: 0.1s">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm font-medium">Total Products</p>
                    <p class="text-3xl font-bold text-white mt-2">{{ $stats['products'] }}</p>
                </div>
                <div class="bg-emerald-500/20 p-3 rounded-xl">
                    <i class="fas fa-box text-emerald-400 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="admin-card stat-card p-6 rounded-2xl animate-slide-in" style="animation-delay: 0.2s">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm font-medium">Total Users</p>
                    <p class="text-3xl font-bold text-white mt-2">{{ $stats['users'] }}</p>
                </div>
                <div class="bg-purple-500/20 p-3 rounded-xl">
                    <i class="fas fa-users text-purple-400 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="admin-card stat-card p-6 rounded-2xl animate-slide-in" style="animation-delay: 0.3s">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm font-medium">Total Revenue</p>
                    <p class="text-3xl font-bold text-white mt-2">{{ $stats['revenue'] }}</p>
                </div>
                <div class="bg-amber-500/20 p-3 rounded-xl">
                    <i class="fas fa-dollar-sign text-amber-400 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Categories -->
        <div class="admin-card p-6 rounded-2xl animate-fade-in">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-white">Categories</h3>
                <i class="fas fa-tags text-yellow-400"></i>
            </div>
            <p class="text-2xl font-bold text-white">{{ $stats['categories'] }}</p>
            <p class="text-gray-400 text-sm mt-1">Active categories</p>
        </div>

        <!-- Verified Users -->
        <div class="admin-card p-6 rounded-2xl animate-fade-in" style="animation-delay: 0.1s">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-white">Verified Users</h3>
                <i class="fas fa-user-check text-green-400"></i>
            </div>
            <p class="text-2xl font-bold text-white">{{ $stats['verified_users'] }}</p>
            <p class="text-gray-400 text-sm mt-1">
                {{ $stats['verified_users'] > 0 ? number_format(($stats['verified_users'] / $stats['users']) * 100) : 0 }}%
                verification rate</p>
        </div>

        <!-- Pending Messages -->
        <div class="admin-card p-6 rounded-2xl animate-fade-in" style="animation-delay: 0.2s">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-white">Messages</h3>
                <div class="relative">
                    <i class="fas fa-envelope text-cyan-400"></i>
                    <span
                        class="absolute -top-2 -right-2 bg-red-500 text-white text-xs px-1.5 py-0.5 rounded-full">{{ $stats['unread_messages'] }}</span>
                </div>
            </div>
            <p class="text-2xl font-bold text-white">{{ $stats['messages'] }}</p>
            <p class="text-gray-400 text-sm mt-1">{{ $stats['unread_messages'] }} unread messages</p>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Orders Chart -->
        <div class="admin-card p-6 rounded-2xl animate-bounce-in">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-white">Orders Overview</h3>
                <div class="flex space-x-2">
                    <button
                        class="text-gray-400 hover:text-white text-sm px-3 py-1 rounded-lg bg-white/5 hover:bg-white/10 transition-colors">
                        Month
                    </button>
                    <button class="text-blue-400 text-sm px-3 py-1 rounded-lg bg-blue-500/20">
                        Year
                    </button>
                </div>
            </div>
            <div class="h-64">
                <canvas id="ordersChart"></canvas>
            </div>
        </div>

        <!-- Categories Distribution -->
        <div class="admin-card p-6 rounded-2xl animate-bounce-in" style="animation-delay: 0.1s">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-white">Products by Category</h3>
                <button class="text-gray-400 hover:text-white">
                    <i class="fas fa-ellipsis-h"></i>
                </button>
            </div>
            <div class="h-64">
                <canvas id="categoriesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Additional Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Top Products -->
        <div class="admin-card p-6 rounded-2xl animate-fade-in">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-white">Top Products</h3>
                <a href="" class="text-blue-400 hover:text-blue-300 text-sm">View All</a>
            </div>
            <div class="h-64">
                <canvas id="topProductsChart"></canvas>
            </div>
        </div>

        <!-- Top Users -->
        <div class="admin-card p-6 rounded-2xl animate-fade-in" style="animation-delay: 0.1s">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-white">Top Customers</h3>
                <a href="" class="text-blue-400 hover:text-blue-300 text-sm">View All</a>
            </div>
            <div class="h-64">
                <canvas id="bestSellerUsersChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Initialize animations and functionality
        document.addEventListener("DOMContentLoaded", function() {
            // Initialize progress bars animation
            setTimeout(() => {
                const progressBars = document.querySelectorAll(".progress-bar");
                progressBars.forEach((bar) => {
                    const width = bar.style.width;
                    bar.style.width = "0%";
                    setTimeout(() => {
                        bar.style.width = width;
                    }, 500);
                });
            }, 1000);
        });

        // Chart.js default configuration
        Chart.defaults.color = "#9CA3AF";
        Chart.defaults.borderColor = "rgba(255, 255, 255, 0.1)";
        Chart.defaults.backgroundColor = "rgba(255, 255, 255, 0.05)";

        // Real data from controller
        const monthlyData = {
            labels: @json($monthlyData['labels']),
            orders: @json($monthlyData['orders']),
            revenue: @json($monthlyData['revenue']),
        };

        const categoryData = {
            labels: @json($categoryData['labels']),
            data: @json($categoryData['data']),
            colors: @json($categoryData['colors']),
        };

        const topProducts = {
            labels: @json($topProducts['labels']),
            data: @json($topProducts['data']),
        };

        const topUsers = {
            labels: @json($topCustomers['labels']),
            data: @json($topCustomers['data']),
        };

        // Orders Chart
        const ordersCtx = document.getElementById("ordersChart").getContext("2d");
        new Chart(ordersCtx, {
            type: "line",
            data: {
                labels: monthlyData.labels,
                datasets: [{
                    label: "Orders",
                    data: monthlyData.orders,
                    borderColor: "#3B82F6",
                    backgroundColor: "rgba(59, 130, 246, 0.1)",
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: "#3B82F6",
                    pointBorderColor: "#ffffff",
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                }, ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    x: {
                        grid: {
                            color: "rgba(255, 255, 255, 0.1)",
                        },
                    },
                    y: {
                        grid: {
                            color: "rgba(255, 255, 255, 0.1)",
                        },
                        beginAtZero: true,
                    },
                },
                elements: {
                    line: {
                        borderJoinStyle: "round",
                    },
                },
            },
        });

        // Categories Chart
        const categoriesCtx = document
            .getElementById("categoriesChart")
            .getContext("2d");
        new Chart(categoriesCtx, {
            type: "doughnut",
            data: {
                labels: categoryData.labels,
                datasets: [{
                    data: categoryData.data,
                    backgroundColor: categoryData.colors,
                    borderWidth: 0,
                    hoverBorderWidth: 2,
                    hoverBorderColor: "#ffffff",
                }, ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: "bottom",
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: "circle",
                        },
                    },
                },
                cutout: "60%",
            },
        });

        // Top Products Chart
        const topProductsCtx = document
            .getElementById("topProductsChart")
            .getContext("2d");
        new Chart(topProductsCtx, {
            type: "bar",
            data: {
                labels: topProducts.labels,
                datasets: [{
                    label: "Orders",
                    data: topProducts.data,
                    backgroundColor: "rgba(239, 68, 68, 0.8)",
                    borderColor: "#EF4444",
                    borderWidth: 1,
                    borderRadius: 8,
                    borderSkipped: false,
                }, ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                        },
                    },
                    y: {
                        grid: {
                            color: "rgba(255, 255, 255, 0.1)",
                        },
                        beginAtZero: true,
                    },
                },
            },
        });

        // Top Users Chart
        const topUsersCtx = document
            .getElementById("bestSellerUsersChart")
            .getContext("2d");
        new Chart(topUsersCtx, {
            type: "bar",
            data: {
                labels: topUsers.labels,
                datasets: [{
                    label: "Orders",
                    data: topUsers.data,
                    backgroundColor: "rgba(16, 185, 129, 0.8)",
                    borderColor: "#10B981",
                    borderWidth: 1,
                    borderRadius: 8,
                    borderSkipped: false,
                }, ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                        },
                    },
                    y: {
                        grid: {
                            color: "rgba(255, 255, 255, 0.1)",
                        },
                        beginAtZero: true,
                    },
                },
            },
        });
    </script>
@endsection
