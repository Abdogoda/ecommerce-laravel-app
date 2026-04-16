<!-- Add Product Modal -->
<div id="addProductModal" class="hidden fixed inset-0 bg-black/50 z-50 backdrop-blur-sm items-center justify-center">
    <div
        class="modal-content bg-black/90 rounded-xl p-6 w-full max-w-lg mx-4 animate-bounce-in transition-all duration-300">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div
                    class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mr-3">
                    <i class="fas fa-plus text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-white">Add New Product</h3>
            </div>
            <button onclick="closeModal('addProductModal')" class="text-gray-400 hover:text-white">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" class="space-y-6"
            enctype="multipart/form-data">
            @csrf

            <!-- Language Tabs -->
            @if (count($locales) > 1)
                <div class="flex gap-2 border-b border-white/10">
                    @foreach ($locales as $locale)
                        <button type="button" onclick="switchLanguageTab('create', '{{ $locale }}')"
                            class="lang-tab-create px-4 py-2 text-sm font-medium {{ $loop->first ? 'text-blue-400 border-b-2 border-blue-400' : 'text-gray-400 hover:text-white' }} transition-colors"
                            data-locale="{{ $locale }}">
                            {{ strtoupper($locale) }}
                        </button>
                    @endforeach
                </div>
            @endif

            <!-- Language Content -->
            @foreach ($locales as $locale)
                <div class="lang-content-create space-y-4 {{ !$loop->first ? 'hidden' : '' }}"
                    data-locale="{{ $locale }}">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2"
                            for="product-name-{{ $locale }}">Product Name</label>
                        <input type="text" id="product-name-{{ $locale }}" name="name_{{ $locale }}"
                            placeholder="Enter product name"
                            class="w-full glass px-4 py-3 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required value="{{ old("name_$locale") }}" />
                        @error("name_$locale")
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2"
                            for="product-description-{{ $locale }}">Description</label>
                        <textarea rows="3" id="product-description-{{ $locale }}" name="description_{{ $locale }}"
                            placeholder="Enter product description"
                            class="w-full glass px-4 py-3 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old("description_$locale") }}</textarea>
                        @error("description_$locale")
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            @endforeach

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Category</label>
                    <select name="category_id"
                        class="w-full glass px-4 py-3 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option {{ old('category_id') == $category->id ? 'selected' : '' }}
                                value="{{ $category->id }}">
                                {{ $category->getTranslation('name', app()->getLocale()) }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Price ($)</label>
                    <input type="number" name="price" step="0.01" placeholder="0.00"
                        class="w-full glass px-4 py-3 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required value="{{ old('price') }}" min="0" />
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Stock Quantity</label>
                    <input type="number" name="stock" placeholder="0"
                        class="w-full glass px-4 py-3 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required value="{{ old('stock') }}" min="0" step="1" />
                    @error('stock')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Product Images</label>
                <input type="file" name="images[]" accept="image/*" multiple required
                    class="w-full glass px-4 py-3 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                @error('images')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Status</label>
                <select name="is_active"
                    class="w-full glass px-4 py-3 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
                    <option {{ old('is_active') == '1' ? 'selected' : '' }} value="1">Active</option>
                    <option {{ old('is_active') == '0' ? 'selected' : '' }} value="0">Inactive</option>
                </select>
                @error('is_active')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Tags</label>
                <div class="relative">
                    <input type="text" id="addProductTagsInput" placeholder="Search or create tags..."
                        class="w-full glass px-4 py-3 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        autocomplete="off" />
                    <div id="addProductTagsDropdown"
                        class="hidden absolute top-full left-0 right-0 mt-1 bg-gray-900 border border-gray-700 rounded-lg shadow-lg z-50 max-h-40 overflow-y-auto">
                    </div>
                </div>
                <div id="addProductSelectedTags" class="flex flex-wrap gap-2 mt-3"></div>
                <input type="hidden" name="tags" id="addProductTagsHidden" />
            </div>

            <div class="flex justify-end space-x-3 pt-4">
                <button type="button" onclick="closeModal('addProductModal')"
                    class="px-6 py-2 bg-gray-600/50 hover:bg-gray-600/70 rounded-lg text-white font-medium transition-colors">
                    Cancel
                </button>
                <button type="submit" class="btn-primary px-6 py-2 rounded-lg text-white font-medium">
                    <i class="fas fa-plus mr-2"></i>
                    Add Product
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

    // Initialize Tag Manager for Add Product Modal
    document.addEventListener('DOMContentLoaded', () => {
        const productTagManager = initializeTagManager({
            inputId: 'addProductTagsInput',
            dropdownId: 'addProductTagsDropdown',
            selectedTagsId: 'addProductSelectedTags',
            hiddenInputId: 'addProductTagsHidden',
            searchUrl: '{{ route('tags.search') }}',
            createUrl: '{{ route('tags.store') }}',
            existingTags: {},
        });

        productTagManager.submitForm('#addProductModal form');
    });
</script>
