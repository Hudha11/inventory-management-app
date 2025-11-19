<?php

namespace App\Livewire\Items;

use App\Livewire\Forms\Items\ItemForm;
use Livewire\Component;
use App\Models\Item;

class ItemCreate extends Component
{
    // public ItemForm $form;

    // properties form
    public $sku;
    public $name;
    public $price;
    public $stock_quantity = 0;
    public $reserved_quantity = 0;

    // validation rules
    protected $rules = [
        'sku' => 'required|unique:items,sku|max:50',
        'name' => 'required|max:255',
        'price' => 'required|numeric|min:0',
        'stock_quantity' => 'required|integer|min:0',
        'reserved_quantity' => 'required|integer|min:0',
    ];

    public function render()
    {
        return view('livewire.items.item-create');
    }

    // reset fields form after submit
    public function resetForm()
    {
        $this->sku = '';
        $this->name = '';
        $this->price = '';
        $this->stock_quantity = 0;
        $this->reserved_quantity = 0;
    }

    // store item baru
    public function storeItem()
    {
        // validasi data
        $this->validate();

        // simpan ke database
        Item::create([
            'sku' => $this->sku,
            'name' => $this->name,
            'price' => $this->price,
            'stock_quantity' => $this->stock_quantity ?? 0,
            'reserved_quantity' => $this->reserved_quantity ?? 0,
        ]);

        // flash message sukses
        session()->flash('message', 'Item created successfully.');

        // reset form setelah submit
        $this->resetForm();

        // emit event global (beri tahu) agar komponen lain bisa refresh list
        $this->emit('itemStored');
    }
}
