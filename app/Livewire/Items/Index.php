<?php

namespace App\Livewire\Items;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Item;

class Index extends Component
{
    use WithPagination;

    // state untuk filter / pagination
    public $search = '';
    public $perPage = 10;

    // id yang akan dihapus (diset saat confirmDelete dipanggil)
    public $deleteId = null;

    // listener untuk refresh setelah save atau hapus
    protected $listeners = [
        'refreshItems' => '$refresh',
    ];

    // reset page ketika search berubah
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Emit event untuk membuka form modal (create)
     */
    public function create()
    {
        $this->dispatch('showFormModal', id: null); // null => create mode
    }

    /**
     * Emit event untuk membuka form modal (edit)
     */
    public function edit($id)
    {
        $this->dispatch('showFormModal', id: $id);
    }

    /**
     * Siapkan delete - tampilkan modal konfirmasi
     */
    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->dispatch('showDeleteModal');
    }

    /**
     * Hapus data setelah konfirmasi datang dari ItemDeleteConfirm
     * (ItemDeleteConfirm akan emit event 'deleteConfirmed')
     */
    public function deleteConfirmed()
    {
        if (!$this->deleteId) return;

        $item = Item::find($this->deleteId);
        if ($item) {
            $item->delete();
            session()->flash('message', 'Item berhasil dihapus.');
        } else {
            session()->flash('message', 'Item tidak ditemukan.');
        }

        // reset & refresh
        $this->deleteId = null;
        $this->dispatch('refreshItems');
    }

    public function render()
    {
        $items = Item::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%")->orWhere('sku', 'like', "%{$this->search}%"))
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.items.index', compact('items'));
    }
}
