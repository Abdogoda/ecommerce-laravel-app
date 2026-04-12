@extends('layouts.admin-app')

@section('content')
    <div class="p-6 page-enter">
        <!-- Product Details -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Product Images -->
            <div class="space-y-4 delay-200">
                <div class="admin-card rounded-xl p-6">
                    <div class="aspect-square bg-gray-800 rounded-lg overflow-hidden mb-4 relative group image-hover-effect">
                        <img id="mainProductImage" src="https://picsum.photos/500/500?random=1" alt="Product Image"
                            class="w-full h-full object-cover transition-all duration-300" />
                        <div
                            class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <button onclick="openImageModal()"
                                class="px-4 py-2 bg-white/20 backdrop-blur-sm rounded-lg text-white hover:bg-white/30 transition-colors">
                                <i class="fas fa-expand mr-2"></i>
                                View Full Size
                            </button>
                        </div>
                    </div>

                    <!-- Thumbnail Gallery -->
                    <div class="grid grid-cols-4 gap-2" id="thumbnailGallery">
                        <!-- Thumbnail 1 (Primary) -->
                        <div class="aspect-square bg-gray-800 rounded-lg overflow-hidden cursor-pointer hover:opacity-75 transition-opacity border-2 border-blue-500 relative group"
                            onclick="
                    changeMainImage(
                      'https://picsum.photos/500/500?random=1',
                      this,
                    )
                  "
                            data-image-id="1" data-is-primary="true">
                            <img src="https://picsum.photos/150/150?random=1" alt="Thumbnail 1"
                                class="w-full h-full object-cover" />
                            <!-- Action buttons -->
                            <div
                                class="absolute top-1 left-1 right-1 flex justify-between opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="bg-blue-500 text-white text-xs px-2 py-0.5 rounded-full opacity-90">
                                    Primary
                                </div>
                                <!-- <form action="" method="post">
                              <button
                              type="submit"
                              class="w-6 h-6 bg-green-500 hover:bg-green-600 rounded-full flex items-center justify-center text-white text-xs transition-all duration-300 hover:scale-110"
                              title="Set as Primary"
                              >
                                  ✓
                              </button>
                          </form> -->
                                <form action="" method="post">
                                    <button type="submit"
                                        class="w-6 h-6 bg-red-500 hover:bg-red-600 rounded-full flex items-center justify-center text-white text-xs transition-all duration-300 hover:scale-110"
                                        title="Delete Image">
                                        ×
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Thumbnail 2 -->
                        <div class="aspect-square bg-gray-800 rounded-lg overflow-hidden cursor-pointer hover:opacity-75 transition-opacity border-2 border-transparent relative group"
                            onclick="
                    changeMainImage(
                      'https://picsum.photos/500/500?random=2',
                      this,
                    )
                  "
                            data-image-id="2" data-is-primary="false">
                            <img src="https://picsum.photos/150/150?random=2" alt="Thumbnail 2"
                                class="w-full h-full object-cover" />
                            <!-- Action buttons -->
                            <div
                                class="absolute top-1 left-1 right-1 flex justify-between opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <form action="" method="post">
                                    <button type="submit"
                                        class="w-6 h-6 bg-green-500 hover:bg-green-600 rounded-full flex items-center justify-center text-white text-xs transition-all duration-300 hover:scale-110"
                                        title="Set as Primary">
                                        ✓
                                    </button>
                                </form>
                                <form action="" method="post">
                                    <button type="submit"
                                        class="w-6 h-6 bg-red-500 hover:bg-red-600 rounded-full flex items-center justify-center text-white text-xs transition-all duration-300 hover:scale-110"
                                        title="Delete Image">
                                        ×
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Thumbnail 3 -->
                        <div class="aspect-square bg-gray-800 rounded-lg overflow-hidden cursor-pointer hover:opacity-75 transition-opacity border-2 border-transparent relative group"
                            onclick="
                    changeMainImage(
                      'https://picsum.photos/500/500?random=3',
                      this,
                    )
                  "
                            data-image-id="3" data-is-primary="false">
                            <img src="https://picsum.photos/150/150?random=3" alt="Thumbnail 3"
                                class="w-full h-full object-cover" />
                            <!-- Action buttons -->
                            <div
                                class="absolute top-1 left-1 right-1 flex justify-between opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <form action="" method="post">
                                    <button type="submit"
                                        class="w-6 h-6 bg-green-500 hover:bg-green-600 rounded-full flex items-center justify-center text-white text-xs transition-all duration-300 hover:scale-110"
                                        title="Set as Primary">
                                        ✓
                                    </button>
                                </form>
                                <form action="" method="post">
                                    <button type="submit"
                                        class="w-6 h-6 bg-red-500 hover:bg-red-600 rounded-full flex items-center justify-center text-white text-xs transition-all duration-300 hover:scale-110"
                                        title="Delete Image">
                                        ×
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Add New Image Slot -->
                        <div class="aspect-square bg-gray-800/30 rounded-lg border-2 border-dashed border-gray-600 hover:border-blue-500 cursor-pointer transition-all duration-300 hover:bg-gray-800/50 flex items-center justify-center group"
                            onclick="openAddImageModal()" title="Add New Image">
                            <div class="text-center text-gray-400 group-hover:text-blue-400 transition-colors">
                                <i class="fas fa-plus text-2xl mb-2"></i>
                                <p class="text-xs">Add Image</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Information -->
            <div class="space-y-6 delay-300">
                <div class="admin-card rounded-xl p-6 pulse-glow">
                    <div>
                        <div class="flex gap-0 items-start flex-col mb-4">
                            <h1 class="text-3xl font-bold text-white mb-4">
                                Premium Wireless Headphones
                            </h1>
                            <div class="flex items-center space-x-4">
                                <div id="breadcrumb" class="text-sm text-gray-400">
                                    <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:underline">Admin</a>
                                    <i class="fas fa-chevron-right mx-2"></i>
                                    <a href="index.html" class="text-gray-400 hover:underline">
                                        Products
                                    </a>
                                    <i class="fas fa-chevron-right mx-2"></i>
                                    <span class="text-white">Premium Wireless Headphones</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <span
                                        class="px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-sm font-medium flex items-center">
                                        <i class="fas fa-check-circle mr-1 text-xs"></i>
                                        In Stock
                                    </span>
                                    <span class="px-3 py-1 bg-blue-500/20 text-blue-400 rounded-full text-sm font-medium">
                                        Electronics
                                    </span>
                                    <span
                                        class="px-3 py-1 bg-purple-500/20 text-purple-400 rounded-full text-sm font-medium">
                                        Featured
                                    </span>
                                </div>
                                <div class="flex items-center space-x-1 text-yellow-400">
                                    <i class="fas fa-fire text-xs"></i>
                                    <span class="text-xs font-medium">Hot Deal</span>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold mb-2">Price</h3>
                                <div class="flex items-center space-x-3">
                                    <span class="text-3xl font-bold text-blue-400">$299.99</span>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold mb-2">Description</h3>
                                <p class="text-gray-300 leading-relaxed mb-4">
                                    Experience exceptional sound quality with these premium
                                    wireless headphones. Featuring active noise cancellation,
                                    30-hour battery life, and comfortable over-ear design
                                    perfect for long listening sessions.
                                </p>
                            </div>

                            <div class="flex space-x-2">
                                <button onclick="openModal('editModal')"
                                    class="btn-warning btn-ripple px-4 py-2 rounded-lg text-white font-medium hover:shadow-lg transition-all">
                                    <i class="fas fa-edit mr-2"></i>
                                    Edit
                                </button>
                                <button onclick="openModal('deleteModal')"
                                    class="btn-danger btn-ripple px-4 py-2 rounded-lg text-white font-medium hover:shadow-lg transition-all">
                                    <i class="fas fa-trash mr-2"></i>
                                    Delete
                                </button>

                                <a href="../../user/product.html"
                                    class="btn-primary btn-ripple px-4 py-2 rounded-lg text-white font-medium hover:shadow-lg transition-all">
                                    <i class="fas fa-eye mr-2"></i>
                                    Preview
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Products Section -->
        <div class="admin-card rounded-2xl animate-slide-in mb-8">
            <div class="p-6 border-b border-white/10">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <h2 class="text-xl font-bold text-white">Similar Products</h2>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <!-- Product Card 1 -->
                    <a href="./show.html" class="product-card admin-card p-4 rounded-xl">
                        <div class="relative mb-4">
                            <img src="https://picsum.photos/200/150?random=4" alt="iPhone 15"
                                class="w-full h-36 object-cover rounded-lg" />
                            <div class="absolute top-2 right-2 bg-green-500 px-2 py-1 rounded-full text-xs text-white">
                                In Stock
                            </div>
                        </div>
                        <h3 class="text-white font-semibold mb-2">iPhone 15 Pro Max</h3>
                        <p class="text-gray-400 text-sm mb-3">
                            Latest flagship smartphone with advanced features
                        </p>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-blue-400 font-bold text-lg">$1,199</span>
                            <div class="flex items-center text-yellow-400">
                                <i class="fas fa-star mr-1"></i>
                                <span class="text-sm">4.9</span>
                            </div>
                        </div>
                    </a>

                    <!-- Product Card 2 -->
                    <a href="./show.html" class="product-card admin-card p-4 rounded-xl">
                        <div class="relative mb-4">
                            <img src="https://picsum.photos/200/150?random=5" alt="MacBook Pro"
                                class="w-full h-36 object-cover rounded-lg" />
                            <div class="absolute top-2 right-2 bg-green-500 px-2 py-1 rounded-full text-xs text-white">
                                In Stock
                            </div>
                        </div>
                        <h3 class="text-white font-semibold mb-2">MacBook Pro M3</h3>
                        <p class="text-gray-400 text-sm mb-3">
                            Professional laptop with M3 chip
                        </p>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-blue-400 font-bold text-lg">$2,499</span>
                            <div class="flex items-center text-yellow-400">
                                <i class="fas fa-star mr-1"></i>
                                <span class="text-sm">4.7</span>
                            </div>
                        </div>
                    </a>

                    <!-- Product Card 3 -->
                    <a href="./show.html" class="product-card admin-card p-4 rounded-xl">
                        <div class="relative mb-4">
                            <img src="https://picsum.photos/200/150?random=6" alt="AirPods Pro"
                                class="w-full h-36 object-cover rounded-lg" />
                            <div class="absolute top-2 right-2 bg-yellow-500 px-2 py-1 rounded-full text-xs text-white">
                                Low Stock
                            </div>
                        </div>
                        <h3 class="text-white font-semibold mb-2">
                            AirPods Pro 2nd Gen
                        </h3>
                        <p class="text-gray-400 text-sm mb-3">
                            Wireless earbuds with noise cancellation
                        </p>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-blue-400 font-bold text-lg">$249</span>
                            <div class="flex items-center text-yellow-400">
                                <i class="fas fa-star mr-1"></i>
                                <span class="text-sm">4.6</span>
                            </div>
                        </div>
                    </a>

                    <!-- Product Card 4 -->
                    <a href="./show.html" class="product-card admin-card p-4 rounded-xl">
                        <div class="relative mb-4">
                            <img src="https://picsum.photos/200/150?random=7" alt="iPad Air"
                                class="w-full h-36 object-cover rounded-lg" />
                            <div class="absolute top-2 right-2 bg-red-500 px-2 py-1 rounded-full text-xs text-white">
                                Out of Stock
                            </div>
                        </div>
                        <h3 class="text-white font-semibold mb-2">iPad Air 5th Gen</h3>
                        <p class="text-gray-400 text-sm mb-3">
                            Powerful tablet for creativity and productivity
                        </p>
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-blue-400 font-bold text-lg">$599</span>
                            <div class="flex items-center text-yellow-400">
                                <i class="fas fa-star mr-1"></i>
                                <span class="text-sm">4.8</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
