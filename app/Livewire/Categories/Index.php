<?php

namespace App\Livewire\Categories;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $search = '';
    public $perPage = 10;

    // form fields
    public $categoryId;
    public $name;
    public $slug;
    public $description;

    public $isEdit = false;
    public $showModal = false;

    protected $rules = [
        'name' => 'required|string|max:255|unique:categories,name',
        'slug' => 'nullable|string|max:255|unique:categories,slug',
        'description' => 'nullable|string',
    ];

    protected $validationAttributes = [
        'name' => 'category name',
    ];

    protected $listeners = ['confirmDeleteCategory' => 'destroy']; // optional for JS confirm

    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function create()
    {
        $this->resetForm();
        $this->isEdit = false;
        $this->showModal = true;
    }

    public function edit(Category $category)
    {
        $this->resetValidation();
        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->description = $category->description;
        $this->isEdit = true;
        $this->showModal = true;
    }

    public function save()
    {
        $rules = $this->rules;

        // Adjust unique rules on update
        if ($this->isEdit && $this->categoryId) {
            $rules['name'] = 'required|string|max:255|unique:categories,name,' . $this->categoryId;
            $rules['slug'] = 'nullable|string|max:255|unique:categories,slug,' . $this->categoryId;
        }

        $data = $this->validate($rules);

        DB::transaction(function () use ($data) {
            if ($this->isEdit && $this->categoryId) {
                Category::findOrFail($this->categoryId)->update($data);
                session()->flash('message', 'Category updated.');
            } else {
                Category::create($data);
                session()->flash('message', 'Category created.');
            }
        });

        $this->showModal = false;
        $this->resetForm();
    }

    public function confirmDelete($id)
    {
        // You can implement browser confirm via JS and emit
        $this->dispatchBrowserEvent('confirm-delete', ['id' => $id]);
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $category = Category::findOrFail($id);

            // enforce safe delete policy: prevent delete if items exist
            if ($category->items()->exists()) {
                session()->flash('error', 'Cannot delete category with associated items.');
                return;
            }

            $category->delete();
            session()->flash('message', 'Category deleted.');
        });
    }

    public function resetForm()
    {
        $this->reset(['categoryId', 'name', 'slug', 'description', 'isEdit']);
        $this->resetValidation();
    }

    public function render()
    {
        $query = Category::query()
            ->when($this->search, function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('slug', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc');

        $categories = $query->paginate($this->perPage);

        return view('livewire.categories.index', compact('categories'));
    }
}
