<?php

namespace App\Livewire;

use Livewire\Component;

class ItemDeleteConfirm extends Component
{
    public $showDeleteModal = false;

    protected $listeners = [
        'openDeleteModal' => 'open',
        'closeDeleteModal' => 'close',
    ];

    public function open()
    {
        $this->showDeleteModal = true;
    }

    public function close()
    {
        $this->showDeleteModal = false;
    }

    /**
     * User tekan konfirmasi -> emit event 'deleteConfirmed'
     * Komponen ItemIndex mendengarkan event ini (lihat index)
     */
    public function confirm()
    {
        $this->emit('deleteConfirmed');
        $this->showDeleteModal = false;
    }

    public function render()
    {
        return view('livewire.items.delete-confirm');
    }
}
