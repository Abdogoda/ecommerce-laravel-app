@extends('layouts.admin-app')

@section('content')
    <!-- Category Header -->
    <div class="admin-card p-8 rounded-2xl mb-8 animate-bounce-in">
        <div class="flex flex-col lg:flex-row items-center lg:items-start gap-8">
            <!-- Category Icon -->
            <div class="relative">
                @if ($category->isIconImage())
                    <img src="{{ asset('storage/' . $category->icon) }}"
                        alt="{{ $category->getTranslation('name', app()->getLocale()) }} Icon"
                        class="w-32 h-32 object-cover rounded-2xl category-icon" />
                @else
                    <div
                        class="w-32 h-32 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center category-icon">
                        <i class="{{ $category->icon }} text-white text-6xl"></i>
                    </div>
                @endif
                @can(\App\Enums\PermissionEnum::EDIT_CATEGORIES->value)
                    <button onclick="openModal('categoryIconModal')"
                        class="absolute -bottom-2 -right-2 bg-green-500 p-2 rounded-full">
                        <i class="fas fa-edit text-white text-sm"></i>
                    </button>
                @endcan
            </div>

            <!-- Category Info -->
            <div class="flex-1 text-center lg:text-left">
                <div class="flex gap-0 flex-col md:flex-row md:gap-5 items-center mb-2">
                    <h1 class="text-3xl font-bold text-white mb-2">
                        {{ $category->getTranslation('name', app()->getLocale()) }}</h1>
                    <div class="flex items-center space-x-4">
                        <div id="breadcrumb" class="text-sm text-gray-400">
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:underline">Admin</a>
                            <i class="fas fa-chevron-right mx-2"></i>
                            <a href="{{ route('admin.categories.index') }}"
                                class="text-gray-400 hover:underline">Categories</a>
                            <i class="fas fa-chevron-right mx-2"></i>
                            <span class="text-white">{{ $category->getTranslation('name', app()->getLocale()) }}</span>
                        </div>
                    </div>
                </div>
                <p class="text-gray-400 text-lg mb-6">{{ $category->getTranslation('description', app()->getLocale()) }}</p>

                <div class="flex flex-wrap gap-4 justify-center lg:justify-start mb-6">
                    <div class="glass px-4 py-2 rounded-xl">
                        <i class="fas fa-box text-blue-400 mr-2"></i>
                        <span class="text-sm">{{ $category->products->count() }} Products</span>
                    </div>
                    <div class="glass px-4 py-2 rounded-xl">
                        <i class="fas fa-calendar text-green-400 mr-2"></i>
                        <span class="text-sm">Created {{ $category->created_at->format('M j, Y') }}</span>
                    </div>
                    <div class="glass px-4 py-2 rounded-xl">
                        <i
                            class="fas fa-{{ $category->is_active ? 'check-circle' : 'times-circle' }} text-{{ $category->is_active ? 'green' : 'red' }}-400 mr-2"></i>
                        <span class="text-sm">{{ $category->is_active ? 'Active' : 'Inactive' }} Status</span>
                    </div>
                    @if ($category->tags->count() > 0)
                        <div class="glass px-4 py-2 rounded-xl">
                            <i class="fas fa-tags text-purple-400 mr-2"></i>
                            <span class="text-sm">{{ $category->tags->count() }} Tags</span>
                        </div>
                    @endif
                </div>

                @if ($category->tags->count() > 0)
                    <div class="mb-6">
                        <h3 class="text-sm font-semibold text-gray-300 mb-3">Tags</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($category->tags as $tag)
                                <span class="px-3 py-1 bg-purple-500/20 text-purple-400 rounded-full text-xs font-medium">
                                    <i class="fas fa-tag mr-1"></i>{{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="flex flex-wrap gap-3 justify-center lg:justify-start">
                    @can(\App\Enums\PermissionEnum::EDIT_CATEGORIES->value)
                        <button onclick="openModal('editCategoryModal')"
                            class="btn-warning px-6 py-3 rounded-xl text-white font-bold">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Category
                        </button>
                    @endcan
                    @can(\App\Enums\PermissionEnum::DELETE_CATEGORIES->value)
                        <button onclick="openModal('deleteCategoryModal')"
                            class="btn-danger px-6 py-3 rounded-xl text-white font-bold">
                            <i class="fas fa-trash mr-2"></i>
                            Delete Category
                        </button>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <!-- Category Products Section -->
    <div class="admin-card rounded-2xl animate-slide-in mb-8">
        <div class="p-6 border-b border-white/10">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h2 class="text-xl font-bold text-white">
                    Products in this Category
                </h2>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse ($category->products as $product)
                    <a href="{{ route('admin.products.show', $product->slug) }}"
                        class="Product-card admin-card p-4 rounded-xl">
                        <div class="relative mb-4">
                            <img src="https://picsum.photos/200/150?random=8" alt="iPhone 15"
                                class="w-full h-36 object-cover rounded-lg" />
                            <div class="absolute top-2 right-2 bg-green-500 px-2 py-1 rounded-full text-xs text-white">
                                In Stock
                            </div>
                        </div>
                        <h3 class="text-white font-semibold mb-2">iPhone 15 Pro Max</h3>
                        <p class="text-gray-400 text-sm mb-3">
                            Latest flagship smartphone with advanced features
                        </p>
                        <div class="flex items-center justify-between">
                            <span class="text-blue-400 font-bold text-lg">$1,199</span>
                            <div class="flex items-center text-yellow-400">
                                <i class="fas fa-star mr-1"></i>
                                <span class="text-sm">4.9</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="text-gray-400 text-sm col-span-full">No products found in this category.</p>
                @endforelse
            </div>
        </div>
    </div>

    @can(\App\Enums\PermissionEnum::EDIT_CATEGORIES->value)
        <!-- Category Icon Modal -->
        <div id="categoryIconModal" class="hidden fixed inset-0 bg-black/50 z-50 backdrop-blur-sm items-center justify-center">
            <div
                class="modal-content bg-black/90 rounded-xl p-6 w-full max-w-md mx-4 animate-bounce-in transition-all duration-300">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-edit text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white">Edit Category Icon</h3>
                    </div>
                    <button onclick="closeModal('categoryIconModal')" class="text-gray-400 hover:text-white">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form class="space-y-6" method="POST" action="{{ route('admin.categories.update', $category->slug) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Icon Type</label>
                        <div class="flex gap-4 mb-4">
                            <label class="flex items-center text-gray-400">
                                <input type="radio" name="icon_type" value="class"
                                    {{ !$category->isIconImage() ? 'checked' : '' }} onchange="toggleIconInput()"
                                    class="mr-2">
                                <span>Icon Class</span>
                            </label>
                            <label class="flex items-center text-gray-400">
                                <input type="radio" name="icon_type" value="image"
                                    {{ $category->isIconImage() ? 'checked' : '' }} onchange="toggleIconInput()"
                                    class="mr-2">
                                <span>Upload Image</span>
                            </label>
                        </div>
                    </div>

                    <div id="iconClassDiv" class="{{ $category->isIconImage() ? 'hidden' : '' }}">
                        <label for="iconClassInput"
                            class="text-sm font-medium text-gray-400 mb-2 flex gap-2 flex-wrap items-center">
                            Fontawesome Icon
                            <p class="text-gray-500 text-xs">Ex: <code>fas fa-laptop</code></p>
                        </label>
                        <input type="text" name="icon" id="iconClassInput"
                            value="{{ $category->isIconImage() ? '' : $category->icon }}"
                            placeholder="Enter your fontawesome icon class"
                            class="w-full glass px-4 py-3 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('icon')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="iconImageDiv" class="{{ $category->isIconImage() ? '' : 'hidden' }}">
                        <div class="flex items-center space-x-4">
                            <label for="categoryImageInput"
                                class="cursor-pointer w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center relative group">
                                <input type="file" id="categoryImageInput" accept="image/*" name="icon_file"
                                    class="hidden" onchange="previewCategoryImage(event)" />
                                @if ($category->isIconImage())
                                    <img id="categoryImagePreview" src="{{ asset('storage/' . $category->icon) }}"
                                        alt="Category Image" class="w-16 h-16 object-cover rounded-full absolute inset-0" />
                                @else
                                    <img id="categoryImagePreview" alt="Category Image"
                                        class="w-16 h-16 object-cover rounded-full absolute inset-0 hidden" />
                                    <i id="categoryImageIcon"
                                        class="fas fa-camera text-white text-2xl group-hover:opacity-80"></i>
                                @endif
                            </label>
                            <div>
                                <p class="text-gray-400 text-sm">Category Image</p>
                                <p class="text-xs text-gray-500">Click to change image</p>
                            </div>
                        </div>
                        @error('icon_file')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="flex items-center space-x-4">
                        <button type="button" onclick="closeModal('categoryIconModal')"
                            class="flex-1 glass px-6 py-3 rounded-xl text-gray-400 hover:text-white transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                            class="flex-1 bg-gradient-to-r from-green-500 to-green-600 px-6 py-3 rounded-xl text-white font-bold hover:scale-105 transition-transform">
                            Update Icon
                        </button>
                    </div>
                </form>
            </div>
        </div>


        <!-- Edit Category Modal -->
        <div id="editCategoryModal"
            class="hidden fixed inset-0 bg-black/50 z-50 backdrop-blur-sm items-center justify-center">
            <div
                class="modal-content bg-black/90 rounded-xl p-6 w-full max-w-md mx-4 animate-bounce-in transition-all duration-300">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-edit text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white">Edit Category</h3>
                    </div>
                    <button onclick="closeModal('editCategoryModal')" class="text-gray-400 hover:text-white">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form class="space-y-6" method="POST" action="{{ route('admin.categories.update', $category->slug) }}">
                    @csrf
                    @method('PUT')

                    <!-- Language Tabs -->
                    @if (count($locales) > 1)
                        <div class="flex gap-2 border-b border-white/10">
                            @foreach ($locales as $locale)
                                <button type="button" onclick="switchLanguageTab('edit', '{{ $locale }}')"
                                    class="lang-tab-edit px-4 py-2 text-sm font-medium {{ $loop->first ? 'text-blue-400 border-b-2 border-blue-400' : 'text-gray-400 hover:text-white' }} transition-colors"
                                    data-locale="{{ $locale }}">
                                    {{ strtoupper($locale) }}
                                </button>
                            @endforeach
                        </div>
                    @endif

                    <!-- Language Content -->
                    @foreach ($locales as $locale)
                        <div class="lang-content-edit space-y-4 {{ !$loop->first ? 'hidden' : '' }}"
                            data-locale="{{ $locale }}">
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-2"
                                    for="category-name-{{ $locale }}">{{ __('Category Name') }}</label>
                                <input type="text" id="category-name-{{ $locale }}"
                                    name="name_{{ $locale }}"
                                    value="{{ $category->getTranslation('name', $locale, false) }}"
                                    class="w-full glass px-4 py-3 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required />
                                @error("name_$locale")
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-2"
                                    for="category-description-{{ $locale }}">{{ __('Description') }}</label>
                                <textarea rows="3" id="category-description-{{ $locale }}" name="description_{{ $locale }}"
                                    class="w-full glass px-4 py-3 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ $category->getTranslation('description', $locale, false) }}</textarea>
                                @error("description_$locale")
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    @endforeach

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2"
                            for="category-status">{{ __('Category Status') }}</label>
                        <select id="category-status" name="is_active"
                            class="w-full glass px-4 py-3 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="1" {{ $category->is_active ? 'selected' : '' }}>{{ __('Active') }}</option>
                            <option value="0" {{ !$category->is_active ? 'selected' : '' }}>{{ __('Inactive') }}
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2"
                            for="category-tags">{{ __('Tags') }}</label>
                        <div class="relative">
                            <input type="text" id="editCategoryTagsInput" placeholder="Search or create tags..."
                                class="w-full glass px-4 py-3 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                autocomplete="off" />
                            <div id="editCategoryTagsDropdown"
                                class="hidden absolute top-full left-0 right-0 mt-1 bg-gray-900 border border-gray-700 rounded-lg shadow-lg z-50 max-h-40 overflow-y-auto">
                            </div>
                        </div>
                        <div id="editCategorySelectedTags" class="flex flex-wrap gap-2 mt-3">
                            @foreach ($category->tags as $tag)
                                <span
                                    class="px-3 py-1 bg-purple-500/20 text-purple-400 rounded-full text-xs font-medium flex items-center gap-2">
                                    <i class="fas fa-tag"></i>
                                    {{ $tag->name }}
                                    <button type="button" class="text-purple-300 hover:text-purple-200 remove-tag-btn"
                                        data-tag-id="{{ $tag->id }}">
                                        <i class="fas fa-times text-xs"></i>
                                    </button>
                                </span>
                            @endforeach
                        </div>
                        <input type="hidden" name="tags" id="editCategoryTagsHidden" />
                    </div>

                    <div class="flex items-center space-x-4">
                        <button type="button" onclick="closeModal('editCategoryModal')"
                            class="flex-1 glass px-6 py-3 rounded-xl text-gray-400 hover:text-white transition-colors">
                            {{ __('Cancel') }}
                        </button>
                        <button type="submit"
                            class="flex-1 bg-gradient-to-r from-yellow-500 to-orange-600 px-6 py-3 rounded-xl text-white font-bold hover:scale-105 transition-transform">
                            {{ __('Update Category') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function switchLanguageTab(context, locale) {
                // Hide all content
                document.querySelectorAll(`.lang-content-${context}`).forEach(el => {
                    el.classList.add('hidden');
                });

                // Remove active styling from all tabs
                document.querySelectorAll(`.lang-tab-${context}`).forEach(el => {
                    el.classList.remove('text-blue-400', 'border-b-2', 'border-blue-400');
                    el.classList.add('text-gray-400');
                });

                // Show selected content
                document.querySelector(`.lang-content-${context}[data-locale="${locale}"]`).classList.remove('hidden');

                // Add active styling to selected tab
                document.querySelector(`.lang-tab-${context}[data-locale="${locale}"]`).classList.remove('text-gray-400');
                document.querySelector(`.lang-tab-${context}[data-locale="${locale}"]`).classList.add('text-blue-400',
                    'border-b-2', 'border-blue-400');
            }

            // Initialize Tag Manager for Edit Category Modal
            document.addEventListener('DOMContentLoaded', () => {
                const existingTags = {
                    @foreach ($category->tags as $tag)
                        '{{ $tag->id }}': '{{ $tag->name }}',
                    @endforeach
                };

                const editCategoryTagManager = initializeTagManager({
                    inputId: 'editCategoryTagsInput',
                    dropdownId: 'editCategoryTagsDropdown',
                    selectedTagsId: 'editCategorySelectedTags',
                    hiddenInputId: 'editCategoryTagsHidden',
                    searchUrl: '{{ route('tags.search') }}',
                    createUrl: '{{ route('tags.store') }}',
                    existingTags: existingTags,
                });

                editCategoryTagManager.submitForm('#editCategoryModal form');
            });
        </script>
    @endcan

    @can(\App\Enums\PermissionEnum::DELETE_CATEGORIES->value)
        <!-- Delete Category Modal -->
        <div id="deleteCategoryModal"
            class="hidden fixed inset-0 bg-black/50 z-50 backdrop-blur-sm items-center justify-center">
            <form action="{{ route('admin.categories.destroy', $category->slug) }}" method="POST"
                class="modal-content bg-black/90 rounded-xl p-6 w-full max-w-md mx-4 animate-bounce-in transition-all duration-300">
                @csrf
                @method('DELETE')
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center mr-3">
                            <i class="fas fa-trash text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white">Delete Category</h3>
                    </div>
                    <button type="button" onclick="closeModal('deleteCategoryModal')"
                        class="text-gray-400 hover:text-white">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="space-y-6">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-red-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-exclamation-triangle text-red-400 text-2xl"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-white mb-2">Are you sure?</h4>
                        <p class="text-gray-400 text-sm">
                            This action will permanently delete the
                            \"{{ $category->getTranslation('name', app()->getLocale()) }}\" category and
                            all associated data. This cannot be undone.
                        </p>
                    </div>

                    <div class="bg-red-500/10 border border-red-500/20 rounded-xl p-4">
                        <h5 class="text-red-400 font-medium mb-2">This will also:</h5>
                        <ul class="text-sm text-gray-300 space-y-1">
                            <li>• Remove {{ $category->products->count() }} Products from this category</li>
                            <li>• Update affected Category listings</li>
                        </ul>
                    </div>

                    <div class="flex items-center space-x-4">
                        <button type="button" onclick="closeModal('deleteCategoryModal')"
                            class="flex-1 glass px-6 py-3 rounded-xl text-gray-400 hover:text-white transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                            class="flex-1 bg-gradient-to-r from-red-500 to-red-600 px-6 py-3 rounded-xl text-white font-bold hover:scale-105 transition-transform">
                            Delete Category
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endcan
@endsection

@push('scripts')
    <script>
        function toggleIconInput() {
            document.getElementById('iconClassDiv').classList.toggle('hidden');
            document.getElementById('iconImageDiv').classList.toggle('hidden');
        }

        function previewCategoryImage(event) {
            const input = event.target;
            const preview = document.getElementById("categoryImagePreview");
            const icon = document.getElementById("categoryImageIcon");
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove("hidden");
                    icon.classList.add("hidden");
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
