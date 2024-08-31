<?php

namespace App\Livewire;

use Livewire\Component;

class ConfirmDeleteModal extends Component
{
    public $objectToDelete;

    public function mount($objectToDelete, $model)
    {
        $this->objectToDelete = $model::find($objectToDelete);
    }

    public function render()
    {
        return view('livewire.confirm-delete-modal');
    }

    public function delete()
    {
        $this->objectToDelete->delete();
        $this->dispatch('render');
        $this->dispatch('hideModal');
    }
}
