@extends('layouts.admin-app')

@section('content')
    <div class="p-6 page-enter">
        <!-- Product Details -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Product Images -->
            <div class="space-y-4 delay-200">
                <div class="admin-card rounded-xl p-6">
                    <div class="aspect-square bg-gray-800 rounded-lg overflow-hidden mb-4 relative group image-hover-effect">
                        @php
                            $primaryImage = $product->getFirstMedia('gallery');
                        @endphp
                        @if ($primaryImage)
                            <img id="mainProductImage" src="{{ $primaryImage->getUrl() }}" alt="{{ $product->name }}"
                                class="w-full h-full object-cover transition-all duration-300" />
                        @else
                            <div class="w-full h-full bg-gray-700 flex items-center justify-center">
                                <i class="fas fa-image text-gray-500 text-4xl"></i>
                            </div>
                        @endif
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
                    <div class="grid grid-cols-4 sm:grid-cols-6 gap-2" id="thumbnailGallery">
                        @forelse ($product->getProductImageUrls() as $index => $item)
                            <div class="aspect-square bg-gray-800 rounded-lg overflow-hidden cursor-pointer hover:opacity-75 transition-opacity border-2 {{ $item->is_primary ? 'border-blue-500' : 'border-transparent' }} relative group"
                                onclick="changeMainImage('{{ $item->media->getUrl() }}', this)"
                                data-image-id="{{ $item->media->id }}"
                                data-is-primary="{{ $item->is_primary ? 'true' : 'false' }}">
                                <img src="{{ $item->media->getUrl() }}" alt="Image {{ $index + 1 }}"
                                    class="w-full h-full object-cover" />
                                <!-- Action buttons -->
                                <div
                                    class="absolute top-1 left-1 right-1 flex justify-between opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    @if ($item->is_primary)
                                        <div class="bg-blue-500 text-white text-xs px-2 py-0.5 rounded-full opacity-90">
                                            Primary
                                        </div>
                                    @else
                                        @can(\App\Enums\PermissionEnum::EDIT_PRODUCTS->value)
                                            <form action="{{ route('admin.products.images.update', [$product, $item->media]) }}"
                                                method="post">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="w-6 h-6 bg-green-500 hover:bg-green-600 rounded-full flex items-center justify-center text-white text-xs transition-all duration-300 hover:scale-110"
                                                    title="Set as Primary">
                                                    ✓
                                                </button>
                                            </form>
                                        @endcan
                                    @endif
                                    @can(\App\Enums\PermissionEnum::EDIT_PRODUCTS->value)
                                        <form action="{{ route('admin.products.images.destroy', [$product, $item->media]) }}"
                                            method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="w-6 h-6 bg-red-500 hover:bg-red-600 rounded-full flex items-center justify-center text-white text-xs transition-all duration-300 hover:scale-110"
                                                title="Delete Image">
                                                ×
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                        @empty
                            <div class="col-span-4 text-center py-8 text-gray-400">
                                <i class="fas fa-image text-3xl mb-2"></i>
                                <p>No images yet</p>
                            </div>
                        @endforelse

                        <!-- Add New Image Slot -->
                        <div class="aspect-square bg-gray-800/30 rounded-lg border-2 border-dashed border-gray-600 hover:border-blue-500 cursor-pointer transition-all duration-300 hover:bg-gray-800/50 flex items-center justify-center group"
                            onclick="openModal('addImageModal')" id="addNewImageButton" title="Add New Image">
                            <div class="text-center text-gray-400 group-hover:text-blue-400 transition-colors">
                                <i class="fas fa-plus text-2xl"></i>
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
                                {{ $product->name }}
                            </h1>
                            <div class="flex items-center space-x-4">
                                <div id="breadcrumb" class="text-sm text-gray-400">
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="text-gray-400 hover:underline">Admin</a>
                                    <i class="fas fa-chevron-right mx-2"></i>
                                    <a href="{{ route('admin.products.index') }}"
                                        class="text-gray-400 hover:underline">Products</a>
                                    <i class="fas fa-chevron-right mx-2"></i>
                                    <span class="text-white">{{ $product->name }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    @if ($product->stock > 5)
                                        <span
                                            class="px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-sm font-medium flex items-center">
                                            <i class="fas fa-check-circle mr-1 text-xs"></i>
                                            In Stock
                                        </span>
                                    @elseif ($product->stock > 0)
                                        <span
                                            class="px-3 py-1 bg-yellow-500/20 text-yellow-400 rounded-full text-sm font-medium flex items-center">
                                            <i class="fas fa-exclamation-triangle mr-1 text-xs"></i>
                                            Low Stock
                                        </span>
                                    @elseif ($product->stock === 0)
                                        <span
                                            class="px-3 py-1 bg-red-500/20 text-red-400 rounded-full text-sm font-medium flex items-center">
                                            <i class="fas fa-times-circle mr-1 text-xs"></i>
                                            Out of Stock
                                        </span>
                                    @endif
                                    <a href="{{ route('admin.categories.show', $product->category) }}"
                                        class="px-3 py-1 bg-blue-500/20 text-blue-400 rounded-full text-sm font-medium">
                                        {{ $product->category->name }}
                                    </a>
                                    @if ($product->is_featured)
                                        <span
                                            class="px-3 py-1 bg-purple-500/20 text-purple-400 rounded-full text-sm font-medium">
                                            Featured
                                        </span>
                                    @endif
                                </div>
                            </div>

                            @if ($product->tags->count() > 0)
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-300 mb-2">Tags</h3>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($product->tags as $tag)
                                            <span
                                                class="px-3 py-1 bg-purple-500/20 text-purple-400 rounded-full text-xs font-medium">
                                                <i class="fas fa-tag mr-1"></i>{{ $tag->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div>
                                <h3 class="text-lg font-semibold mb-2">Price</h3>
                                <div class="flex items-center space-x-3">
                                    <span
                                        class="text-3xl font-bold text-blue-400">${{ number_format($product->price, 2) }}</span>
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold mb-2">Description</h3>
                                <p class="text-gray-300 leading-relaxed mb-4">
                                    {{ Str::limit($product->description, 100) }}
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($similarProducts->isNotEmpty())
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
                        @foreach ($similarProducts as $item)
                            <a href="{{ route('admin.products.show', $item) }}"
                                class="product-card admin-card p-4 rounded-xl">
                                <div class="relative mb-4">
                                    <img src="{{ $item->getPrimaryImageUrl() }}" alt="iPhone 15"
                                        class="w-full h-36 object-cover rounded-lg" />

                                    @if ($item->stock > 5)
                                        <div
                                            class="absolute top-2 right-2 bg-green-500 px-2 py-1 rounded-full text-xs text-white">
                                            In Stock
                                        </div>
                                    @elseif ($item->stock > 0)
                                        <div
                                            class="absolute top-2 right-2 bg-yellow-500 px-2 py-1 rounded-full text-xs text-white">
                                            Low Stock
                                        </div>
                                    @elseif ($item->stock === 0)
                                        <div
                                            class="absolute top-2 right-2 bg-red-500 px-2 py-1 rounded-full text-xs text-white">
                                            Out of Stock
                                        </div>
                                    @endif
                                </div>
                                <h3 class="text-white font-semibold mb-2">{{ $item->name }}</h3>
                                <p class="text-gray-400 text-sm mb-3">
                                    {{ $item->description }}
                                </p>
                                <div class="flex items-center justify-between mb-3">
                                    <span
                                        class="text-blue-400 font-bold text-lg">${{ number_format($item->price, 2) }}</span>
                                    <div class="flex items-center text-yellow-400">
                                        <i class="fas fa-star mr-1"></i>
                                        <span class="text-sm">4.9</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>

    @include('pages.admin.products.modals.preview-image')

    @can(\App\Enums\PermissionEnum::EDIT_PRODUCTS->value)
        @include('pages.admin.products.modals.edit')
    @endcan

    @can(\App\Enums\PermissionEnum::DELETE_PRODUCTS->value)
        @include('pages.admin.products.modals.delete')
    @endcan

    @can(\App\Enums\PermissionEnum::EDIT_PRODUCTS->value)
        @include('pages.admin.products.modals.upload-image')
    @endcan

@endsection

@push('scripts')
    <script>
        // Hide add image button if there are already 8 images
        document.addEventListener("DOMContentLoaded", function() {
            const currentImages = document.querySelectorAll("[data-image-id]").length;
            const addBtn = document.getElementById("addNewImageButton");
            if (currentImages >= 8 && addBtn) {
                addBtn.classList.add("hidden");
            }
        });

        // Image Gallery Functions
        function changeMainImage(imageSrc, thumbnailElement) {
            const mainImage = document.getElementById("mainProductImage");
            mainImage.src = imageSrc;

            // Remove border from all thumbnails
            const thumbnails = document.querySelectorAll(".aspect-square");
            thumbnails.forEach((thumb) => {
                if (thumb.querySelector("img")) {
                    // Only image thumbnails, not add button
                    thumb.classList.remove("border-blue-500");
                    thumb.classList.add("border-transparent");
                }
            });

            // Add border to clicked thumbnail
            thumbnailElement.classList.remove("border-transparent");
            thumbnailElement.classList.add("border-blue-500");
        }

        function openImageModal() {
            const mainImage = document.getElementById("mainProductImage");
            const modalImage = document.getElementById("modalImage");
            modalImage.src = mainImage.src;
            openModal("imageModal");
        }

        function handleImageUpload(input) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const uploadArea = document.getElementById("imageUploadArea");
                    const preview = document.getElementById("imagePreview");
                    const previewImg = document.getElementById("previewImg");
                    const fileName = document.getElementById("fileName");
                    const addBtn = document.getElementById("addImageBtn");

                    uploadArea.classList.add("hidden");
                    preview.classList.remove("hidden");
                    previewImg.src = e.target.result;
                    fileName.textContent = file.name;
                    addBtn.disabled = false;
                };
                reader.readAsDataURL(file);
            }
        }

        function removeImagePreview() {
            const uploadArea = document.getElementById("imageUploadArea");
            const preview = document.getElementById("imagePreview");
            const input = document.getElementById("imageInput");
            const addBtn = document.getElementById("addImageBtn");

            uploadArea.classList.remove("hidden");
            preview.classList.add("hidden");
            input.value = "";
            addBtn.disabled = true;
        }
    </script>
@endpush
