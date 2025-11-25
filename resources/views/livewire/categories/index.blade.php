<div>
  <div class="flex items-center justify-between mb-4">
    <div class="flex gap-2">
      <input wire:model.debounce.300ms="search" type="text" placeholder="Search categories..." class="input" />
      <select wire:model="perPage" class="select">
        <option value="5">5</option>
        <option value="10">10</option>
        <option value="25">25</option>
      </select>
    </div>
    <div>
      <button wire:click="create" class="px-4 py-2 bg-blue-600 text-white rounded">Create Category</button>
    </div>
  </div>

  @if(session()->has('message'))
    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('message') }}</div>
  @endif
  @if(session()->has('error'))
    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
  @endif

  <div class="bg-white shadow rounded overflow-hidden">
    <table class="min-w-full divide-y">
      <thead class="bg-gray-50">
        <tr>
          <th class="px-4 py-3 text-left">Name</th>
          <th class="px-4 py-3 text-left">Slug</th>
          <th class="px-4 py-3">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y">
        @forelse($categories as $cat)
          <tr>
            <td class="px-4 py-2">{{ $cat->name }}</td>
            <td class="px-4 py-2">{{ $cat->slug }}</td>
            <td class="px-4 py-2">
              <button wire:click="edit({{ $cat->id }})" class="px-2 py-1 text-white bg-yellow-500 rounded">Edit</button>
              <button wire:click="confirmDelete({{ $cat->id }})" class="px-2 py-1 text-white bg-red-600 rounded">Delete</button>
            </td>
          </tr>
        @empty
          <tr><td colspan="3" class="p-4 text-center">No categories</td></tr>
        @endforelse
      </tbody>
    </table>

    <div class="p-4">
      {{ $categories->links() }}
    </div>
  </div>

  <!-- Modal (simple conditional) -->
  @if($showModal)
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
      <div class="bg-white rounded shadow-lg w-96 p-4">
        <h3 class="text-lg font-semibold mb-2">{{ $isEdit ? 'Edit' : 'Create' }} Category</h3>
        <div class="space-y-3">
          <div>
            <label class="block text-sm">Name</label>
            <input wire:model.defer="name" type="text" class="w-full border rounded px-2 py-1" />
            @error('name') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
          </div>
          <div>
            <label class="block text-sm">Slug</label>
            <input wire:model.defer="slug" type="text" class="w-full border rounded px-2 py-1" />
            @error('slug') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
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

  <script>
    window.addEventListener('confirm-delete', event => {
      if (confirm('Are you sure to delete?')) {
        Livewire.emit('confirmDeleteCategory', event.detail.id);
      }
    });
  </script>
</div>

