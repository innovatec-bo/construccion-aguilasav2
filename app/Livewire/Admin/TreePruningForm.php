<?php

namespace App\Livewire\Admin;

use App\Models\ProjectBudget;
use Livewire\Component;

class TreePruningForm extends Component
{
    public $projectBudget;
    public $project;

    public function mount(ProjectBudget $projectBudget)
    {
        $this->projectBudget = $projectBudget;
        $this->project = $this->projectBudget->project;
    }

    public function render()
    {
        return view('livewire.admin.tree-pruning-form');
    }
}
