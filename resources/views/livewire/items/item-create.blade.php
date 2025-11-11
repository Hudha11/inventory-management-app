<section>
    <form
        wire:submit="store"
        class="flex flex-col gap-6 bg-slate-900 shadow-2xl rounded-2xl p-8"
    >
        @csrf

        <!-- SKU (Stock Keeping Unit) unique code for Items -->
        <flux:input
            wire:model="sku"
            label="Stock Keeping Unit (SKU)"
            type="text"
            autofocus
        />

        <!-- Name Items -->
        <flux:input
            wire:model="name"
            label="Name"
            type="text"
            autofocus
        />

        <!-- Category Items -->
        <flux:input
            wire:model="category"
            label="Category"
            type="text"
            autofocus
        />

        <div class="flex items-center justify-end">
            <flux:button
                variant="primary"
                type="submit"
                class="w-full"
            >
                Add Item
            </flux:button>
        </div>
    </form>
</section>
