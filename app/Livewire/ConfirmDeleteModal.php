<?php

namespace App\Livewire;

use Livewire\Component;

class ConfirmDeleteModal extends Component
{
    public $objectToDelete;
    public $confirmMessage;

    public function mount($objectToDelete, $model)
    {
        $this->objectToDelete = $model::find($objectToDelete);
        $this->confirmMessage = "";
        if (method_exists($this->objectToDelete,'deleteConfirmMessage')) 
        {
            $this->confirmMessage = $this->objectToDelete->deleteConfirmMessage();
        }
    }

    public function render()
    {
        return view('livewire.confirm-delete-modal');
    }

    public function delete()
    {
        $this->objectToDelete->delete();
        $this->dispatch('object-deleted');
        $this->dispatch('hideModal');
    }
}
