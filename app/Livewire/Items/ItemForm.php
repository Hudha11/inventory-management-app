<?php

namespace App\Livewire\Items;

use Livewire\Component;
use App\Models\Item;

class ItemForm extends Component
{
    // kontrol tampil modal
    public $showFormModal = false;

    // item state
    public $itemId = null;
    public $sku;
    public $name;
    public $price;
    public $stock_quantity;
    public $description;
    public $isEdit = false;

    // listen event untuk buka modal
    protected $listeners = [
        'showFormModal' => 'open',
    ];

    // validasi
    protected $rules = [
        'sku' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'price' => 'nullable|numeric',
        'stock_quantity' => 'nullable|integer',
        'description' => 'nullable|string',
    ];

    /**
     * Buka modal form (create jika $id null, edit jika ada id)
     */
    public function open($id = null)
    {
        $this->resetValidation();
        $this->itemId = $id;

        // cek mode
        $this->isEdit = $id ? true : false;

        if ($id) {
            $item = Item::findOrFail($id);
            $this->sku = $item->sku;
            $this->name = $item->name;
            $this->price = $item->price;
            $this->stock_quantity = $item->stock_quantity;
            $this->description = $item->description;
        } else {
            // default kosong untuk create
            $this->reset(['sku', 'name', 'price', 'stock_quantity', 'description']);
        }

        $this->showFormModal = true;
    }

    /**
     * Simpan data (create / update). Set flash message apakah created atau updated.
     */
    public function save()
    {
        $this->validate();

        // Buat atau update
        $item = Item::updateOrCreate(
            ['id' => $this->itemId],
            [
                'sku' => $this->sku,
                'name' => $this->name,
                'price' => $this->price ?? 0,
                'stock_quantity' => $this->stock_quantity ?? 0,
                'description' => $this->description,
            ]
        );

        // Flash message kondisi create / update
        $message = $this->itemId ? 'Item berhasil diperbarui.' : 'Item berhasil dibuat.';
        session()->flash('message', $message);

        // tutup modal dan refresh list
        $this->showFormModal = false;
        $this->itemId = null;

        $this->emit('refreshItems');
    }

    public function render()
    {
        return view('livewire.items.item-form');
    }
}
