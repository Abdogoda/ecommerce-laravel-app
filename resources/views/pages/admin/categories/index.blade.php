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
                            Tags
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
                    @forelse ($categories as $category)
                        <tr class="table-row">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if ($category->icon)
                                        @if ($category->isIconImage())
                                            <img src="{{ asset('storage/' . $category->icon) }}"
                                                alt="{{ $category->getTranslation('name', app()->getLocale()) }} Icon"
                                                class="hidden md:block w-10 h-10 rounded-lg mr-3 object-contain">
                                        @else
                                            <div
                                                class="hidden md:flex w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg items-center justify-center mr-3">
                                                <i class="{{ $category->icon }}" class="text-white"></i>
                                            </div>
                                        @endif
                                    @endif
                                    <div>
                                        <a href="{{ route('admin.categories.show', $category->slug) }}"
                                            class="text-white hover:text-blue-400 transition-colors font-medium">{{ $category->getTranslation('name', app()->getLocale()) }}</a>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if ($category->tags->count() > 0)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($category->tags->take(2) as $tag)
                                            <span class="px-2 py-1 bg-purple-500/20 text-purple-400 rounded-full text-xs">
                                                {{ $tag->name }}
                                            </span>
                                        @endforeach
                                        @if ($category->tags->count() > 2)
                                            <span class="px-2 py-1 bg-purple-500/20 text-purple-400 rounded-full text-xs">
                                                +{{ $category->tags->count() - 2 }}
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-gray-500 text-xs">No tags</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-white">{{ $category->products_count }} products</span>
                            </td>
                            <td class="px-6 py-4">
                                @if ($category->is_active)
                                    <span class="px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-xs font-medium">
                                        Active
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-red-500/20 text-red-400 rounded-full text-xs font-medium">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-400">{{ $category->created_at->format('M j, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-400">
                                No categories found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        {{ $categories->links() }}
    </div>


    <!-- Add Category Modal -->
    <div id="addCategoryModal" class="hidden fixed inset-0 z-50 backdrop-blur-sm items-center justify-center">
        <div
            class="modal-content bg-black/90 rounded-xl p-6 w-full max-w-md mx-4 animate-bounce-in transition-all duration-300">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mr-3">
                        <i class="fas fa-plus text-xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white">Add Category</h3>
                </div>
                <button onclick="closeModal('addCategoryModal')" class="text-gray-400 hover:text-white">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf

                <!-- Language Tabs -->
                @if (count($locales) > 1)
                    <div class="flex gap-2 border-b border-white/10">
                        @foreach ($locales as $locale)
                            <button type="button" onclick="switchLanguageTab('add', '{{ $locale }}')"
                                class="lang-tab-add px-4 py-2 text-sm font-medium {{ $loop->first ? 'text-blue-400 border-b-2 border-blue-400' : 'text-gray-400 hover:text-white' }} transition-colors"
                                data-locale="{{ $locale }}">
                                {{ strtoupper($locale) }}
                            </button>
                        @endforeach
                    </div>
                @endif

                <!-- Language Content -->
                @foreach ($locales as $locale)
                    <div class="lang-content-add space-y-4 {{ !$loop->first ? 'hidden' : '' }}"
                        data-locale="{{ $locale }}">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">{{ __('Category Name') }}</label>
                            <input type="text" placeholder="Enter category name" name="name_{{ $locale }}"
                                class="w-full glass px-4 py-3 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required />
                            @error("name_$locale")
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">{{ __('Description') }}</label>
                            <textarea placeholder="Enter category description" rows="3" name="description_{{ $locale }}"
                                class="w-full glass px-4 py-3 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                            @error("description_$locale")
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @endforeach

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Icon Type</label>
                    <div class="flex gap-4 mb-4">
                        <label class="flex items-center text-gray-400">
                            <input type="radio" name="icon_type" value="class" checked onchange="toggleIconInput()"
                                class="mr-2">
                            <span>Icon Class</span>
                        </label>
                        <label class="flex items-center text-gray-400">
                            <input type="radio" name="icon_type" value="image" onchange="toggleIconInput()"
                                class="mr-2">
                            <span>Upload Image</span>
                        </label>
                    </div>
                </div>

                <div id="iconClassDiv">
                    <label for="iconClassInput"
                        class="text-sm font-medium text-gray-400 mb-2 flex gap-2 flex-wrap items-center">
                        Fontawesome Icon
                        <p class="text-gray-500 text-xs">Ex: <code>fas fa-laptop</code></p>
                    </label>
                    <input type="text" name="icon" id="iconClassInput"
                        placeholder="Enter your fontawesome icon class"
                        class="w-full glass px-4 py-3 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('icon')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div id="iconImageDiv" class="hidden">
                    <label for="iconImage"
                        class="text-sm font-medium text-gray-400 mb-2 flex gap-2 flex-wrap items-center">
                        Icon Image
                        <p class="text-gray-500 text-xs">Formats: JPG, PNG, GIF</p>
                    </label>
                    <input type="file" name="icon_file" id="iconImage" accept="image/*"
                        class="w-full glass px-4 py-3 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    @error('icon_file')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Status</label>
                    <select name="is_active"
                        class="w-full glass px-4 py-3 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Tags</label>
                    <div class="relative">
                        <input type="text" id="addCategoryTagsInput" placeholder="Search or create tags..."
                            class="w-full glass px-4 py-3 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            autocomplete="off" />
                        <div id="addCategoryTagsDropdown"
                            class="hidden absolute top-full left-0 right-0 mt-1 bg-gray-900 border border-gray-700 rounded-lg shadow-lg z-50 max-h-40 overflow-y-auto">
                        </div>
                    </div>
                    <div id="addCategorySelectedTags" class="flex flex-wrap gap-2 mt-3"></div>
                    <input type="hidden" name="tags" id="addCategoryTagsHidden" />
                </div>

                <div class="flex gap-3 pt-4 border-t border-white/10">
                    <button type="button" onclick="closeModal('addCategoryModal')"
                        class="flex-1 btn-gray px-6 py-3 rounded-xl text-white font-bold">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 btn-primary px-6 py-3 rounded-xl text-white font-bold">
                        Add Category
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

        function toggleIconInput() {
            document.getElementById('iconClassDiv').classList.toggle('hidden');
            document.getElementById('iconImageDiv').classList.toggle('hidden');
        }

        // Initialize Tag Manager for Add Category Modal
        document.addEventListener('DOMContentLoaded', () => {
            const categoryTagManager = initializeTagManager({
                inputId: 'addCategoryTagsInput',
                dropdownId: 'addCategoryTagsDropdown',
                selectedTagsId: 'addCategorySelectedTags',
                hiddenInputId: 'addCategoryTagsHidden',
                searchUrl: '{{ route('tags.search') }}',
                createUrl: '{{ route('tags.store') }}',
                existingTags: {},
            });

            categoryTagManager.submitForm('#addCategoryModal form');
        });
    </script>
@endsection
