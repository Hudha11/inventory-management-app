<?php

namespace App\Livewire\Items;

use App\Livewire\Forms\Items\ItemForm;
use Livewire\Component;

class ItemCreate extends Component
{
    public ItemForm $form;

    public function render()
    {
        return view('livewire.items.item-create');
    }
}
