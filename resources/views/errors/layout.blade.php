<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    @php
        $storeName = isset($generalSettings) ? $generalSettings->name : 'E-Commerce';
        $favicon = (isset($generalSettings) && $generalSettings->favicon) ? asset('storage/' . $generalSettings->favicon) : asset('assets/icon.png');
    @endphp
</head>
<body class="bg-gray-900 text-white">
    <!-- Header -->
    <header class="bg-gray-800/95 backdrop-blur-sm py-6 px-6 shadow-2xl sticky top-0 z-50">
        <div class="w-full md:max-w-7xl mx-auto flex justify-between items-center gap-3">
            <h1 class="text-2xl font-bold">
                <a href="{{ route('home') }}" class="hover:text-blue-400 transition-colors duration-300 flex items-center gap-2">
                    @if (isset($generalSettings) && $generalSettings->logo)
                        <img src="{{ asset('storage/' . $generalSettings->logo) }}" alt="Logo" class="w-10 h-10 rounded-xl object-contain" />
                    @else
                        <i class="fas fa-store text-blue-400"></i>
                    @endif
                    {{ $storeName }}
                </a>
            </h1>
            <nav class="hidden md:flex space-x-6 items-center">
                <a href="{{ route('home') }}" class="hover:text-blue-400 transition-all duration-300">
                    <span>Home</span>
                </a>
                <a href="{{ route('categories.index') }}" class="hover:text-blue-400 transition-all duration-300">
                    <span>Categories</span>
                </a>
                <a href="{{ route('products.index') }}" class="hover:text-blue-400 transition-all duration-300">
                    <span>Products</span>
                </a>
            </nav>
        </div>
    </header>

    <!-- Error Content -->
    <div class="min-h-[calc(100vh-80px)] flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full text-center">
            <!-- Error Icon -->
            <div class="mb-8 flex justify-center">
                <div class="relative">
                    <div class="absolute inset-0 bg-blue-500/20 rounded-full blur-xl"></div>
                    <div class="relative bg-gray-800 rounded-full p-6 border border-gray-700">
                        @yield('icon', '<i class="fas fa-circle-exclamation text-4xl text-blue-400"></i>')
                    </div>
                </div>
            </div>

            <!-- Error Code -->
            <h1 class="text-6xl md:text-7xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-blue-600 mb-4">
                @yield('code')
            </h1>
            
            <!-- Error Message -->
            <h2 class="text-2xl md:text-3xl font-bold text-white mb-3">
                @yield('message')
            </h2>
            
            <!-- Error Description -->
            <p class="text-gray-400 mb-8 text-lg leading-relaxed">
                @yield('exception')
            </p>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg transition-all duration-300 transform hover:scale-105 active:scale-95">
                    <i class="fas fa-arrow-left"></i>
                    Go Home
                </a>
                <a href="javascript:history.back()" class="inline-flex items-center justify-center gap-2 border border-gray-600 hover:border-gray-400 text-gray-400 hover:text-white font-semibold py-3 px-8 rounded-lg transition-all duration-300">
                    <i class="fas fa-arrow-left-long"></i>
                    Go Back
                </a>
            </div>
        </div>
    </div>
</body>
</html>
