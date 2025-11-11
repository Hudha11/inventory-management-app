<?php

namespace App\Livewire\Forms\Items;

use Livewire\Attributes\Validate;
use Livewire\Form;

class ItemForm extends Form
{
    public $sku = '';
    public $name = '';
    public $category = '';

    public function store()
    {
        $data = $this->validate([
            'sku' => ['required', 'string', 'max:255', 'unique:items,sku'],
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
        ]);

        $data['slug'] = str()->slug($data['name']);
        // auth()->user()->items()->create($data);
        $this->reset();
    }
}
