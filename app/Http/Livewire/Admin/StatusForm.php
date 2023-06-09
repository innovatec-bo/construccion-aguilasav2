<?php

namespace App\Http\Livewire\admin;

use App\Models\Project;
use App\Models\ProjectStatus;
use Livewire\Component;

class StatusForm extends Component
{
    public $project;
    public $status;
    public function mount(Project $project, ProjectStatus $status)
    {
        $this->project = $project;
        $this->status = $status;
    }

    public function render()
    {
        return view('livewire.status-form');
    }
}
