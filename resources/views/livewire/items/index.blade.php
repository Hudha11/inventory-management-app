<div>
    <div class="flex items-center justify-between mb-4">
        <div class="flex gap-2">
            <input
                wire:model.debounce.300ms="search"
                type="text"
                placeholder="Search items..."
                class="input"
            />
            <select wire:model="perPage" class="select">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="25">25</option>
            </select>
        </div>
        <div>
            <button
                wire:click="create"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 cursor-pointer"
            >
                Create Item
            </button>
        </div>
    </div>

    @if(session()->has('message'))
    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
        {{ session('message') }}
    </div>
    @endif

    <div class="overflow-x-auto">
        <table
            class="min-w-full divide-y-2 divide-gray-200 dark:divide-gray-700"
        >
            <thead class="ltr:text-left rtl:text-right">
                <tr class="*:font-medium *:text-gray-900 dark:*:text-white">
                    <th class="px-3 py-2 whitespace-nowrap">SKU</th>
                    <th class="px-3 py-2 whitespace-nowrap">Name</th>
                    <th class="px-3 py-2 whitespace-nowrap">Category</th>
                    <th class="px-3 py-2 whitespace-nowrap">Price</th>
                    <th class="px-3 py-2 whitespace-nowrap">Stock</th>
                    <th class="px-3 py-2 whitespace-nowrap">Actions</th>
                </tr>
            </thead>

            <tbody
                class="divide-y divide-gray-200 *:even:bg-gray-50 dark:divide-gray-700 dark:*:even:bg-gray-800"
            >
                @forelse($items as $item)
                <tr
                    class="*:text-gray-900 *:first:font-medium dark:*:text-white"
                >
                    <td class="px-3 py-2 whitespace-nowrap">
                        {{ $item->sku }}
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap">
                        {{ $item->name }}
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap">
                        {{ $item->category?->name }}
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap">
                        {{ number_format($item->price,2) }}
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap">
                        {{ $item->stock_quantity }}
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap">
                        <button
                            wire:click="edit({{ $item->id }})"
                            class="px-2 py-1 text-white bg-yellow-500 rounded hover:bg-yellow-700 cursor-pointer"
                        >
                            Edit
                        </button>
                        <button
                            wire:click="destroy({{ $item->id }})"
                            class="px-2 py-1 text-white bg-red-600 rounded hover:bg-red-700 cursor-pointer"
                        >
                            Delete
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-4 text-center">No items</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">{{ $items->links() }}</div>
    </div>

    <!-- Modal -->
    @if($showModal)
    <!-- Backdrop -->
    <div
        class="fixed inset-0 z-40 bg-black/60"
        x-show="showModal"
        x-transition.opacity
    ></div>

    <!-- Modal Wrapper -->
    <div
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        x-show="showModal"
        x-transition
        x-cloak
    >
        <!-- Modal Box -->
        <div
            class="w-full max-w-md rounded-lg bg-gray-900 border border-gray-700 shadow-xl p-6"
        >
            <!-- Header -->
            <div
                class="flex items-center justify-between border-b border-gray-700 pb-4"
            >
                <h3 class="text-lg font-semibold text-white">
                    {{ $isEdit ? 'Edit' : 'Create' }} Item
                </h3>

                <button
                    wire:click="$set('showModal', false)"
                    class="w-9 h-9 flex items-center justify-center rounded-lg text-gray-400 hover:text-white hover:bg-gray-700"
                >
                    <svg
                        class="w-5 h-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 18L18 6M6 6l12 12"
                        />
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
                        class="w-full mt-1 px-3 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                    @error('name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="text-sm text-gray-400">SKU</label>
                    <input
                        type="text"
                        wire:model.defer="sku"
                        class="w-full mt-1 px-3 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                    @error('sku') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="text-sm text-gray-400">Price</label>
                    <input
                        type="number"
                        wire:model.defer="price"
                        class="w-full mt-1 px-3 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                    @error('price') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="text-sm text-gray-400">Stock</label>
                    <input
                        type="number"
                        wire:model.defer="stock_quantity"
                        class="w-full mt-1 px-3 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                    @error('stock_quantity') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="text-sm text-gray-400">Category</label>
                    <select
                        wire:model.defer="category_id"
                        class="w-full mt-1 px-3 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
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
                        class="w-full mt-1 px-3 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                    </textarea>
                    @error('description') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Footer -->
            <div class="flex justify-end gap-3 mt-6">
                <button
                    wire:click="$set('showModal', false)"
                    class="px-4 py-2 rounded-lg bg-gray-700 text-gray-300 hover:bg-gray-600"
                >
                    Cancel
                </button>

                <button
                    wire:click="save"
                    class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700"
                >
                    Save
                </button>
            </div>
        </div>
    </div>

    @endif
</div>
