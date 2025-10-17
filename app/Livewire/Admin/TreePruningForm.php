<?php

namespace App\Livewire\Admin;

use App\Models\ProjectBudget;
use Livewire\Component;
use Livewire\Attributes\On;

class TreePruningForm extends Component
{
    public $projectBudget;
    public $project;
    public $listeners = ['tree-pruning-created' => 'render'];

    public function mount(ProjectBudget $projectBudget)
    {
        $this->projectBudget = $projectBudget;
        $this->project = $this->projectBudget->project;
    }

    #[On('tree-pruning-created')]
    public function refreshComponent()
    {
        // Si solo quieres recargar los datos:
        $this->projectBudget->refresh();
        $this->project = $this->projectBudget->project;
    }

    public function render()
    {
        return view('livewire.admin.tree-pruning-form');
    }
}
