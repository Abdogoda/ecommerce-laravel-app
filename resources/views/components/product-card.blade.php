@props(['product', 'theme' => null, 'index' => 0])

@php
    $themeNames = ['blue', 'purple'];
    $theme = $theme ?? $themeNames[$index % count($themeNames)];

    $themes = [
        'blue' => [
            'badge' => 'bg-blue-500',
            'hover-text' => 'group-hover:text-blue-400',
            'button' => 'from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700',
            'shadow' => 'hover:shadow-blue-500/25',
            'price-color' => 'text-blue-400',
        ],
        'orange' => [
            'badge' => 'bg-orange-500',
            'hover-text' => 'group-hover:text-orange-400',
            'button' => 'from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700',
            'shadow' => 'hover:shadow-orange-500/25',
            'price-color' => 'text-orange-400',
        ],
        'purple' => [
            'badge' => 'bg-purple-500',
            'hover-text' => 'group-hover:text-purple-400',
            'button' => 'from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700',
            'shadow' => 'hover:shadow-purple-500/25',
            'price-color' => 'text-purple-400',
        ],
        'green' => [
            'badge' => 'bg-green-500',
            'hover-text' => 'group-hover:text-green-400',
            'button' => 'from-green-600 to-teal-600 hover:from-green-700 hover:to-teal-700',
            'shadow' => 'hover:shadow-green-500/25',
            'price-color' => 'text-green-400',
        ],
    ];

    $themeConfig = $themes[$theme] ?? $themes['blue'];
    $isBadgeNew = $product->created_at->diffInDays() < 7;
    $stockStatus =
        $product->stock > 0
            ? ($product->stock > $orderSettings->low_stock_threshold
                ? 'in-stock'
                : 'low-stock')
            : 'out-of-stock';
@endphp

<div class="group bg-gray-800/50 backdrop-blur-sm rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl {{ $themeConfig['shadow'] }} transition-all duration-300 hover:scale-105 transform animate-fade-in-up"
    style="animation-delay: {{ $index * 50 }}ms">
    <div class="relative overflow-hidden">
        <a href="{{ route('products.show', $product->slug) }}">
            @if ($product->media->first())
                <img src="{{ $product->media->first()->getUrl() }}" alt="{{ $product->name }}"
                    class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500" />
            @else
                <div class="w-full h-64 bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center">
                    <i class="fas fa-image text-4xl text-gray-600"></i>
                </div>
            @endif
            <div
                class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            </div>
        </a>
        <div class="absolute top-4 right-4">
            @if ($product->is_featured)
                <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                    Featured
                </span>
            @elseif ($isBadgeNew)
                <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold animate-pulse">
                    New
                </span>
            @endif
        </div>
        <div class="absolute top-4 left-4">
            @if ($stockStatus === 'in-stock')
                <span class=" bg-green-500 text-white px-3 py-1 text-sm font-semibold rounded-full">In Stock</span>
            @elseif ($stockStatus === 'low-stock')
                <span class=" bg-yellow-500 text-white px-3 py-1 text-sm font-semibold rounded-full">Low Stock</span>
            @else
                <span class=" bg-red-500 text-white px-3 py-1 text-sm font-semibold rounded-full">Out of Stock</span>
            @endif
        </div>
    </div>
    <div class="p-6">
        <a href="{{ route('products.show', $product->slug) }}">
            <h3
                class="text-xl font-semibold text-white mb-2 {{ $themeConfig['hover-text'] }} transition-colors duration-300 line-clamp-1">
                {{ $product->name }}
            </h3>
        </a>
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
            <p class="text-2xl font-bold {{ $themeConfig['price-color'] }}">
                ${{ number_format($product->price, 2) }}</p>
        </div>
        <button
            onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, 1, '{{ $product->media->first()?->getUrl() ?? '' }}')"
            class="w-full bg-gradient-to-r {{ $themeConfig['button'] }} text-white font-semibold py-3 rounded-xl transition-all duration-300 hover:shadow-lg {{ $themeConfig['shadow'] }} transform hover:scale-105">
            <i class="fas fa-cart-plus mr-2"></i>Add to Cart
        </button>
    </div>
</div>
