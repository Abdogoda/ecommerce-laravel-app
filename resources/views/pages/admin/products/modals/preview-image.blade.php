    <!-- Image View Modal -->
    <div id="imageModal" class="hidden fixed inset-0 bg-black/50 z-50 backdrop-blur-sm items-center justify-center">
        <div class="w-full h-full flex items-center justify-center p-4">
            <div class="relative max-w-full max-h-full">
                <button onclick="closeModal('imageModal')"
                    class="absolute -top-12 right-0 text-white hover:text-gray-300 text-2xl transition-colors z-10">
                    <i class="fas fa-times"></i>
                </button>
                <img id="modalImage" src="" alt="Product Image"
                    class="max-w-full max-h-full object-contain rounded-lg" />
            </div>
        </div>
    </div>
