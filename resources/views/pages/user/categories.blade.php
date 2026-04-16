@extends('layouts.user-app')

@section('title', 'Categories - E-Commerce Store')

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
                @forelse($categories as $category)
                    @php
                        $colors = [
                            'from-blue-400 to-blue-600',
                            'from-purple-400 to-purple-600',
                            'from-green-400 to-green-600',
                            'from-orange-400 to-orange-600',
                            'from-red-400 to-red-600',
                            'from-pink-400 to-pink-600',
                            'from-indigo-400 to-indigo-600',
                            'from-yellow-400 to-yellow-600',
                        ];
                        $shadowColors = [
                            'hover:shadow-blue-500/25',
                            'hover:shadow-purple-500/25',
                            'hover:shadow-green-500/25',
                            'hover:shadow-orange-500/25',
                            'hover:shadow-red-500/25',
                            'hover:shadow-pink-500/25',
                            'hover:shadow-indigo-500/25',
                            'hover:shadow-yellow-500/25',
                        ];
                        $textColors = [
                            'group-hover:text-blue-400',
                            'group-hover:text-purple-400',
                            'group-hover:text-green-400',
                            'group-hover:text-orange-400',
                            'group-hover:text-red-400',
                            'group-hover:text-pink-400',
                            'group-hover:text-indigo-400',
                            'group-hover:text-yellow-400',
                        ];
                        $colorIndex = $loop->index % count($colors);
                    @endphp
                    <div class="group animate-fade-in-up" style="animation-delay: {{ $loop->index * 100 }}ms">
                        <a href="{{ route('categories.show', $category->slug) }}"
                            class="block glass rounded-2xl p-8 text-center transition-all duration-300 hover:scale-105 hover:shadow-2xl {{ $shadowColors[$colorIndex] }} transform">
                            <div
                                class="w-24 h-24 bg-gradient-to-br {{ $colors[$colorIndex] }} rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:rotate-12 transition-transform duration-300 animate-float">
                                @if ($category->isIconImage())
                                    <img src="{{ asset('storage/' . $category->icon) }}" alt="{{ $category->name }}"
                                        class="w-full h-full object-cover rounded-2xl">
                                @else
                                    <i class="{{ $category->icon ?? 'fas fa-box' }} text-3xl text-white"></i>
                                @endif
                            </div>
                            <h3
                                class="text-2xl font-semibold text-white {{ $textColors[$colorIndex] }} transition-colors duration-300 mb-3">
                                {{ $category->name }}
                            </h3>
                            <p class="text-gray-400 group-hover:text-gray-300 transition-colors duration-300">
                                {{ $category->description }}
                            </p>
                            <p class="text-sm text-gray-500 mt-3">
                                {{ $category->products_count }} products
                            </p>
                            <div
                                class="mt-4 {{ $textColors[$colorIndex] }} group-hover:text-opacity-80 transition-colors duration-300">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16">
                        <p class="text-gray-400 text-lg">No categories available at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </main>
@endsection
