<div>
  <div class="flex items-center justify-between mb-4">
    <div class="flex gap-2">
      <input wire:model.debounce.300ms="search" type="text" placeholder="Search items..." class="input" />
      <select wire:model="perPage" class="select">
        <option value="5">5</option>
        <option value="10">10</option>
        <option value="25">25</option>
      </select>
    </div>
    <div>
      <button wire:click="create" class="px-4 py-2 bg-blue-600 text-white rounded">Create Item</button>
    </div>
  </div>

  @if(session()->has('message'))
    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('message') }}</div>
  @endif

  <div class="bg-white shadow rounded overflow-hidden">
    <table class="min-w-full divide-y">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-4 py-3">SKU</th>
          <th class="px-4 py-3">Name</th>
          <th class="px-4 py-3">Category</th>
          <th class="px-4 py-3">Price</th>
          <th class="px-4 py-3">Stock</th>
          <th class="px-4 py-3">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y">
        @forelse($items as $item)
          <tr>
            <td class="px-4 py-2">{{ $item->sku }}</td>
            <td class="px-4 py-2">{{ $item->name }}</td>
            <td class="px-4 py-2">{{ $item->category?->name }}</td>
            <td class="px-4 py-2">{{ number_format($item->price,2) }}</td>
            <td class="px-4 py-2">{{ $item->stock_quantity }}</td>
            <td class="px-4 py-2">
              <button wire:click="edit({{ $item->id }})" class="px-2 py-1 text-white bg-yellow-500 rounded">Edit</button>
              <button wire:click="destroy({{ $item->id }})" class="px-2 py-1 text-white bg-red-600 rounded">Delete</button>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="p-4 text-center">No items</td></tr>
        @endforelse
      </tbody>
    </table>

    <div class="p-4">
      {{ $items->links() }}
    </div>
  </div>

  <!-- Modal -->
  @if($showModal)
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
      <div class="bg-white rounded shadow-lg w-2/5 p-4">
        <h3 class="text-lg font-semibold mb-2">{{ $isEdit ? 'Edit' : 'Create' }} Item</h3>
        <div class="space-y-3">
          <div>
            <label class="block text-sm">Category</label>
            <select wire:model.defer="category_id" class="w-full border rounded px-2 py-1">
              <option value="">-- Select category --</option>
              @foreach($categories as $c)
                <option value="{{ $c->id }}">{{ $c->name }}</option>
              @endforeach
            </select>
            @error('category_id') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
          </div>
          <div>
            <label class="block text-sm">SKU</label>
            <input wire:model.defer="sku" type="text" class="w-full border rounded px-2 py-1" />
            @error('sku') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
          </div>
          <div>
            <label class="block text-sm">Name</label>
            <input wire:model.defer="name" type="text" class="w-full border rounded px-2 py-1" />
            @error('name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
          </div>
          <div class="grid grid-cols-2 gap-2">
            <div>
              <label class="block text-sm">Price</label>
              <input wire:model.defer="price" type="number" step="0.01" class="w-full border rounded px-2 py-1" />
              @error('price') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>
            <div>
              <label class="block text-sm">Stock</label>
              <input wire:model.defer="stock_quantity" type="number" class="w-full border rounded px-2 py-1" />
              @error('stock_quantity') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
            </div>
          </div>
          <div>
            <label class="block text-sm">Description</label>
            <textarea wire:model.defer="description" class="w-full border rounded px-2 py-1"></textarea>
            @error('description') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
          </div>

          <div class="flex justify-end gap-2">
            <button wire:click="$set('showModal', false)" class="px-3 py-1 border rounded">Cancel</button>
            <button wire:click="save" class="px-3 py-1 bg-blue-600 text-white rounded">Save</button>
          </div>
        </div>
      </div>
    </div>
  @endif
</div>
