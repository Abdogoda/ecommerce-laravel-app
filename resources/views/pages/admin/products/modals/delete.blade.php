<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black/50 z-50 backdrop-blur-sm items-center justify-center">
    <div
        class="modal-content bg-black/90 rounded-xl p-6 w-full max-w-lg mx-4 animate-bounce-in transition-all duration-300">
        <form action="{{ route('admin.products.destroy', $product) }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-red-500 to-pink-600 rounded-xl flex items-center justify-center mr-3">
                        <i class="fas fa-trash text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white">Delete Product</h3>
                </div>
                <button onclick="closeModal('deleteModal')" class="text-gray-400 hover:text-white transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="mb-6">
                <div class="bg-red-500/10 border border-red-500/20 rounded-xl p-4 mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-red-400 mr-3"></i>
                        <p class="text-red-400 font-medium">
                            Warning: This action cannot be undone!
                        </p>
                    </div>
                </div>
                <p class="text-gray-300 mb-6">
                    Are you sure you want to delete "{{ $product->name }}"? And all associated data will be removed.
                </p>
            </div>

            <div class="flex justify-end space-x-3">
                <button onclick="closeModal('deleteModal')"
                    class="px-6 py-2 bg-gray-600/50 hover:bg-gray-600/70 rounded-lg text-white font-medium transition-colors">
                    Cancel
                </button>
                <button type="submit" class="btn-danger px-6 py-2 rounded-lg text-white font-medium">
                    <i class="fas fa-trash mr-2"></i>
                    Delete Product
                </button>
            </div>
        </form>
    </div>
</div>
