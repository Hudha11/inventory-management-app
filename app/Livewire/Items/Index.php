<?php

namespace App\Livewire\Items;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';

    public $search = '';
    public $perPage = 10;

    public $itemId;
    public $category_id;
    public $sku;
    public $name;
    public $price;
    public $stock_quantity;
    public $description;

    public $isEdit = false;
    public $showModal = false;

    protected $rules = [
        'category_id' => 'required|exists:categories,id',
        'sku' => 'required|string|max:50|unique:items,sku',
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'stock_quantity' => 'required|integer|min:0',
        'description' => 'nullable|string',
    ];

    public function create()
    {
        $this->resetForm();
        $this->isEdit = false;
        $this->showModal = true;
    }

    public function edit(Item $item)
    {
        $this->resetValidation();
        $this->itemId = $item->id;
        $this->category_id = $item->category_id;
        $this->sku = $item->sku;
        $this->name = $item->name;
        $this->price = $item->price;
        $this->stock_quantity = $item->stock_quantity;
        $this->description = $item->description;
        $this->isEdit = true;
        $this->showModal = true;
    }

    public function save()
    {
        $rules = $this->rules;
        if ($this->isEdit && $this->itemId) {
            $rules['sku'] = 'required|string|max:50|unique:items,sku,' . $this->itemId;
        }

        $data = $this->validate($rules);

        DB::transaction(function () use ($data) {
            if ($this->isEdit && $this->itemId) {
                Item::findOrFail($this->itemId)->update($data);
                session()->flash('message', 'Item updated.');
            } else {
                Item::create($data);
                session()->flash('message', 'Item created.');
            }
        });

        $this->showModal = false;
        $this->resetForm();
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $item = Item::findOrFail($id);
            $item->delete();
            session()->flash('message', 'Item deleted.');
        });
    }

    public function resetForm()
    {
        $this->reset(['itemId', 'category_id', 'sku', 'name', 'price', 'stock_quantity', 'description', 'isEdit']);
        $this->resetValidation();
    }

    public function render()
    {
        $query = Item::with('category')
            ->when($this->search, function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('sku', 'like', '%' . $this->search . '%')
                    ->orWhereHas('category', fn($q2) => $q2->where('name', 'like', '%' . $this->search . '%'));
            })
            ->orderBy('created_at', 'desc');

        $items = $query->paginate($this->perPage);
        $categories = Category::orderBy('name')->get();

        return view('livewire.items.index', compact('items', 'categories'));
    }
}
