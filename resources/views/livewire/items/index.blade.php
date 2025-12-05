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
                            wire:click="confirmDelete({{ $item->id }})"
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
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $items->links() }}
    </div>

    {{-- Include modals (komponen terpisah) --}}
    @livewire('items.item-form')
    {{-- @livewire('item-delete-confirm', key('delete-confirm'))  --}}

    {{-- Listener: ketika ItemDeleteConfirm konfirmasi, emit 'deleteConfirmed' --}}
    {{-- <script>
        // Pastikan Livewire menerima event deleteConfirmed dan meneruskannya ke ItemIndex
        Livewire.on('deleteConfirmed', () => {
        Livewire.emitTo('{{ \Livewire\Livewire::getAlias(get_class($this)) }}', 'deleteConfirmed');
        });
    </script> --}}
</div>
