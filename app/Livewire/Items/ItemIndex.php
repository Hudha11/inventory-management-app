<?php

namespace App\Livewire\Items;

use Livewire\Component;
use App\Models\Item;

class ItemIndex extends Component
{
    // listen ke event global agar bisa refresh list setelah create/update
    protected $listeners = [
        'itemStored' => '$refresh',
        'itemUpdated' => '$refresh',
    ];

    public function render()
    {
        // ambil data item terbaru di view melalui Livewire
        $items = Item::latest()->get();

        // lempar data ke view
        return view('livewire.items.item-index', compact('items'));
    }

    // method untuk handle delete item
    public function deleteItem($itemId)
    {
        $item = Item::find($itemId);
        if ($item) {
            $item->delete();
            session()->flash('message', 'Item deleted successfully.');
            // refresh dilakukan otomatis karena kita mengubah data, tapi tetap emit agar komponen lain tahu
            $this->emit('itemDeleted');
        } else {
            session()->flash('error', 'Item not found.');
        }
    }
}
