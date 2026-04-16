<!-- Edit Product Modal -->
<div id="editModal" class="hidden fixed inset-0 bg-black/50 z-50 backdrop-blur-sm items-center justify-center">
    <div
        class="modal-content bg-black/90 rounded-xl p-6 w-full max-w-2xl mx-4 animate-bounce-in transition-all duration-300">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-white">
                <i class="fas fa-edit mr-2 text-yellow-500"></i>
                Edit Product
            </h3>
            <button onclick="closeModal('editModal')" class="text-gray-400 hover:text-white text-xl transition-colors">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form action="{{ route('admin.products.update', $product) }}" method="POST" class="space-y-4">
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
                            for="product-name-{{ $locale }}">Product Name</label>
                        <input type="text" id="product-name-{{ $locale }}" name="name_{{ $locale }}"
                            value="{{ $product->getTranslation('name', $locale, false) }}"
                            class="w-full glass px-4 py-3 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        @error("name_$locale")
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2"
                            for="product-description-{{ $locale }}">Description</label>
                        <textarea rows="3" id="product-description-{{ $locale }}" name="description_{{ $locale }}"
                            class="w-full glass px-4 py-3 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ $product->getTranslation('description', $locale, false) }}</textarea>
                        @error("description_$locale")
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            @endforeach

            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-300 mb-2">Category</label>
                <select name="category_id" id="category_id"
                    class="w-full px-4 py-2 bg-gray-800/50 border border-gray-600 rounded-lg text-white focus:border-blue-500 focus:outline-none transition-colors">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->getTranslation('name', app()->getLocale()) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-300 mb-2">Price</label>
                    <input type="number" value="{{ $product->price }}" name="price" id="price" min="0"
                        step="0.01"
                        class="w-full px-4 py-2 bg-gray-800/50 border border-gray-600 rounded-lg text-white focus:border-blue-500 focus:outline-none transition-colors" />
                </div>
                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-300 mb-2">Stock</label>
                    <input type="number" value="{{ $product->stock }}" name="stock" id="stock" min="0"
                        class="w-full px-4 py-2 bg-gray-800/50 border border-gray-600 rounded-lg text-white focus:border-blue-500 focus:outline-none transition-colors" />
                </div>
                <div>
                    <label for="is_active" class="block text-sm font-medium text-gray-300 mb-3">Status</label>
                    <div class="relative inline-block w-12 h-6 bg-gray-700 rounded-full cursor-pointer transition-colors"
                        onclick="toggleCheckbox('is_active')" id="is_active_toggle"
                        style="background-color: {{ $product->is_active ? '#10b981' : '#4b5563' }}">
                        <input type="checkbox" name="is_active" id="is_active" class="hidden"
                            {{ $product->is_active ? 'checked' : '' }} />
                        <div class="absolute top-0.5 left-0.5 bg-white w-5 h-5 rounded-full transition-transform duration-300"
                            id="is_active_slider"
                            style="transform: {{ $product->is_active ? 'translateX(24px)' : 'translateX(0)' }}">
                        </div>
                    </div>
                    <span class="text-xs text-gray-400 ml-3">
                        {{ $product->is_active ? '✓ Active' : '○ Inactive' }}
                    </span>
                </div>
                <div>
                    <label for="is_featured" class="block text-sm font-medium text-gray-300 mb-3">Featured</label>
                    <div class="relative inline-block w-12 h-6 bg-gray-700 rounded-full cursor-pointer transition-colors"
                        onclick="toggleCheckbox('is_featured')" id="is_featured_toggle"
                        style="background-color: {{ $product->is_featured ? '#8b5cf6' : '#4b5563' }}">
                        <input type="checkbox" name="is_featured" id="is_featured" class="hidden"
                            {{ $product->is_featured ? 'checked' : '' }} />
                        <div class="absolute top-0.5 left-0.5 bg-white w-5 h-5 rounded-full transition-transform duration-300"
                            id="is_featured_slider"
                            style="transform: {{ $product->is_featured ? 'translateX(24px)' : 'translateX(0)' }}">
                        </div>
                    </div>
                    <span class="text-xs text-gray-400 ml-3">
                        {{ $product->is_featured ? '⭐ Featured' : '○ Regular' }}
                    </span>
                </div>
            </div>

            <div>
                <label for="product_tags" class="block text-sm font-medium text-gray-300 mb-2">Tags</label>
                <div class="relative">
                    <input type="text" id="editProductTagsInput" placeholder="Search or create tags..."
                        class="w-full px-4 py-2 bg-gray-800/50 border border-gray-600 rounded-lg text-white focus:border-blue-500 focus:outline-none transition-colors"
                        autocomplete="off" />
                    <div id="editProductTagsDropdown"
                        class="hidden absolute top-full left-0 right-0 mt-1 bg-gray-900 border border-gray-700 rounded-lg shadow-lg z-50 max-h-40 overflow-y-auto">
                    </div>
                </div>
                <div id="editProductSelectedTags" class="flex flex-wrap gap-2 mt-3">
                    @foreach ($product->tags as $tag)
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
                <input type="hidden" name="tags" id="editProductTagsHidden" />
            </div>

            <div class="flex justify-end space-x-3 pt-4">
                <button type="button" onclick="closeModal('editModal')"
                    class="px-6 py-2 bg-gray-600/50 hover:bg-gray-600/70 rounded-lg text-white font-medium transition-colors">
                    Cancel
                </button>
                <button type="submit" class="btn-primary px-6 py-2 rounded-lg text-white font-medium">
                    <i class="fas fa-save mr-2"></i>
                    Update Product
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

    // Initialize Tag Manager for Edit Product Modal
    document.addEventListener('DOMContentLoaded', () => {
        const existingTags = {
            @foreach ($product->tags as $tag)
                '{{ $tag->id }}': '{{ $tag->name }}',
            @endforeach
        };

        const editProductTagManager = initializeTagManager({
            inputId: 'editProductTagsInput',
            dropdownId: 'editProductTagsDropdown',
            selectedTagsId: 'editProductSelectedTags',
            hiddenInputId: 'editProductTagsHidden',
            searchUrl: '{{ route('tags.search') }}',
            createUrl: '{{ route('tags.store') }}',
            existingTags: existingTags,
        });

        editProductTagManager.submitForm('#editModal form');
    });
</script>

<script>
    function toggleCheckbox(fieldName) {
        const checkbox = document.getElementById(fieldName);
        const toggle = document.getElementById(fieldName + '_toggle');
        const slider = document.getElementById(fieldName + '_slider');

        checkbox.checked = !checkbox.checked;

        const isChecked = checkbox.checked;
        const colors = {
            'is_active': isChecked ? '#10b981' : '#4b5563', // Green for active
            'is_featured': isChecked ? '#8b5cf6' : '#4b5563' // Purple for featured
        };

        toggle.style.backgroundColor = colors[fieldName];
        slider.style.transform = isChecked ? 'translateX(24px)' : 'translateX(0)';
    }
</script>
