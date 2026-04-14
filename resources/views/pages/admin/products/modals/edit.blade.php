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
            <div>
                <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Product Name</label>
                <input type="text" value="{{ $product->name }}" name="name" id="name"
                    class="w-full px-4 py-2 bg-gray-800/50 border border-gray-600 rounded-lg text-white focus:border-blue-500 focus:outline-none transition-colors" />
            </div>

            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-300 mb-2">Category</label>
                <select name="category_id" id="category_id"
                    class="w-full px-4 py-2 bg-gray-800/50 border border-gray-600 rounded-lg text-white focus:border-blue-500 focus:outline-none transition-colors">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
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
                <label for="description" class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                <textarea name="description" id="description" rows="3"
                    class="w-full px-4 py-2 bg-gray-800/50 border border-gray-600 rounded-lg text-white focus:border-blue-500 focus:outline-none transition-colors">
                    {{ $product->description }}
                    </textarea>
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
