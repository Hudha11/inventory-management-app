<div>
<!-- Modal -->
    @if($showFormModal)
    <!-- Backdrop -->
    <div
        class="fixed inset-0 z-40 bg-black/60"
        x-show="showFormModal"
        x-transition.opacity></div>

    <!-- Modal Wrapper -->
    <div
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        x-show="showFormModal"
        x-transition
        x-cloak>
        <!-- Modal Box -->
        <div
            class="w-full max-w-md rounded-lg bg-gray-900 border border-gray-700 shadow-xl p-6">
            <!-- Header -->
            <div
                class="flex items-center justify-between border-b border-gray-700 pb-4">
                <h3 class="text-lg font-semibold text-white">
                    {{ $isEdit ? 'Edit' : 'Create' }} Item
                </h3>

                <button
                    wire:click="$set('showFormModal', false)"
                    class="w-9 h-9 flex items-center justify-center rounded-lg text-gray-400 hover:text-white hover:bg-gray-700">
                    <svg
                        class="w-5 h-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        stroke-width="2">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Body -->
            <div class="mt-4 space-y-4 text-gray-300">
                <div>
                    <label class="text-sm text-gray-400">Name</label>
                    <input
                        type="text"
                        wire:model.defer="name"
                        class="w-full mt-1 px-3 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    @error('name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="text-sm text-gray-400">SKU</label>
                    <input
                        type="text"
                        wire:model.defer="sku"
                        class="w-full mt-1 px-3 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    @error('sku') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="text-sm text-gray-400">Price</label>
                    <input
                        type="number"
                        wire:model.defer="price"
                        class="w-full mt-1 px-3 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    @error('price') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="text-sm text-gray-400">Stock</label>
                    <input
                        type="number"
                        wire:model.defer="stock_quantity"
                        class="w-full mt-1 px-3 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    @error('stock_quantity') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="text-sm text-gray-400">Category</label>
                    <select
                        wire:model.defer="category_id"
                        class="w-full mt-1 px-3 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="text-sm text-gray-400">Description</label>
                    <textarea
                        wire:model.defer="description"
                        rows="3"
                        class="w-full mt-1 px-3 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </textarea>
                    @error('description') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Footer -->
            <div class="flex justify-end gap-3 mt-6">
                <button
                    wire:click="$set('showFormModal', false)"
                    class="px-4 py-2 rounded-lg bg-gray-700 text-gray-300 hover:bg-gray-600">
                    Cancel
                </button>

                <button
                    type="button"
                    wire:click="save"
                    wire:loading.attr="disabled"
                    wire:target="save"
                    class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 inline-flex items-center gap-2"
                    aria-busy="false"
                >
                    <!-- Spinner (tampil hanya ketika target save berjalan) -->
                    <svg wire:loading wire:target="save" class="w-4 h-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>

                    <!-- Teks tombol berubah saat loading (opsional) -->
                    <span class="save-text">
                        <span wire:loading.remove wire:target="save">Save</span>
                        <span wire:loading wire:target="save">Saving...</span>
                    </span>
                </button>
            </div>
        </div>
    </div>

@endif
<!-- End Modal -->
</div>