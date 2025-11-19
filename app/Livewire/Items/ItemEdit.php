<?php

namespace App\Livewire\Items;

use Livewire\Component;
use App\Models\Item;

class ItemEdit extends Component
{
    // properties form
    public $item_id;
    public $sku;
    public $name;
    public $price;
    public $stock_quantity = 0;
    public $reserved_quantity = 0;
    public $isEdit = false;

    // dengarkan event agar bisa load data dari index (jika ingin meng-open edit via event)
    protected $listeners = [
        'editItem' => 'loadItem',
    ];

    // validation rules (untuk edit, sku harus unique kecuali untuk item yg sedang diedit)
    public function rules()
    {
        return [
            'sku' => 'required|unique:items,sku,' . $this->item_id . '|max:50',
            'name' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'reserved_quantity' => 'required|integer|min:0',
        ];
    }

    public function render()
    {
        return view('livewire.items.item-edit');
    }

    // load data item untuk diedit
    public function loadItem($item_id)
    {
        $item = Item::find($item_id);
        if (! $item) {
            session()->flash('error', 'Item not found.');
            return;
        }
        $this->item_id = $item->id;
        $this->sku = $item->sku;
        $this->name = $item->name;
        $this->price = $item->price;
        $this->stock_quantity = $item->stock_quantity;
        $this->reserved_quantity = $item->reserved_quantity;
        $this->isEdit = true;
    }

    // batal edit
    public function cancelEdit()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->item_id = null;
        $this->sku = '';
        $this->name = '';
        $this->price = '';
        $this->stock_quantity = 0;
        $this->reserved_quantity = 0;
        $this->isEdit = false;
    }

    // update item
    public function updateItem()
    {
        // validasi data
        $this->validate();

        if (! $this->item_id) {
            session()->flash('error', 'No item selected for update.');
            return;
        }

        $item = Item::find($this->item_id);

        if (! $item) {
            session()->flash('error', 'Item not found.');
            return;
        }
        // update data
        $item->update([
            'sku' => $this->sku,
            'name' => $this->name,
            'price' => $this->price,
            'stock_quantity' => $this->stock_quantity ?? 0,
            'reserved_quantity' => $this->reserved_quantity ?? 0,
        ]);

        // flash message sukses
        session()->flash('message', 'Item updated successfully.');

        // reset form
        $this->resetForm();

        // emit event global agar komponen lain bisa refresh list
        $this->emit('itemUpdated');
    }
}
