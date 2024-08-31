<?php

namespace App\Livewire\Admin;

use App\Models\Project;
use Livewire\Component;

class ConciliationManualApprovement extends Component
{
    public $project;

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function render()
    {
        return view('livewire.admin.conciliation-manual-approvement');
    }

    public function save()
    {
        $this->project->project_has_returned_materials_to_cre = true;
        $this->project->save();
        $this->dispatch('refreshProjectIndex');
        $this->dispatch('hideModal');
    }
}
