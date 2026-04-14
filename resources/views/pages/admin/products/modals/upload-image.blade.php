    <!-- Add New Image Modal -->
    <div id="addImageModal" class="hidden fixed inset-0 bg-black/50 z-50 backdrop-blur-sm items-center justify-center">
        <div
            class="modal-content bg-black/90 rounded-xl p-6 w-full max-w-lg mx-4 animate-bounce-in transition-all duration-300">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-white">
                    <i class="fas fa-plus mr-2 text-blue-500"></i>
                    Add New Image
                </h3>
                <button onclick="closeModal('addImageModal')"
                    class="text-gray-400 hover:text-white text-xl transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form action="{{ route('admin.products.images.store', $product) }}" method="post" class="space-y-4"
                enctype="multipart/form-data">
                @csrf
                <!-- Image Upload Area -->
                <div id="dropZone"
                    class="border-2 border-dashed border-gray-600 rounded-lg p-8 text-center hover:border-blue-500 transition-colors">
                    <div id="imageUploadArea" class="space-y-4">
                        <div class="text-gray-400">
                            <i class="fas fa-cloud-upload-alt text-4xl mb-4"></i>
                            <p class="text-sm">Click to browse</p>
                        </div>
                        <input type="file" id="imageInput" name="image" accept="image/*" class="hidden"
                            onchange="handleImageUpload(this)" />
                        <button type="button" onclick="document.getElementById('imageInput').click()"
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg text-white font-medium transition-colors">
                            <i class="fas fa-folder-open mr-2"></i>
                            Choose File
                        </button>
                    </div>

                    <!-- Image Preview -->
                    <div id="imagePreview" class="hidden">
                        <img id="previewImg" src="" alt="Preview"
                            class="max-w-full h-48 object-contain mx-auto rounded-lg" />
                        <p id="fileName" class="text-gray-400 text-sm mt-2"></p>
                        <button type="button" onclick="removeImagePreview()"
                            class="mt-2 px-4 py-1 bg-red-600 hover:bg-red-700 rounded text-white text-sm transition-colors">
                            Remove
                        </button>
                    </div>
                </div>

                <!-- Image Options -->
                <div class="space-y-3">
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" id="setPrimary" name="set_as_primary"
                            class="w-4 h-4 text-blue-600 bg-gray-800 border-gray-600 rounded focus:ring-blue-500" />
                        <label for="setPrimary" class="text-sm text-gray-300">
                            Set as primary image
                        </label>
                    </div>
                </div>

                <!-- Modal Actions -->
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeModal('addImageModal')"
                        class="px-6 py-2 bg-gray-600/50 hover:bg-gray-600/70 rounded-lg text-white font-medium transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="btn-primary px-6 py-2 rounded-lg text-white font-medium"
                        id="addImageBtn" disabled>
                        <i class="fas fa-plus mr-2"></i>
                        Add Image
                    </button>
                </div>
            </form>
        </div>
    </div>
