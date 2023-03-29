<?php
namespace App\Http\Livewire\Admin;

use App\Models\ProjectStatus;
use Livewire\Component;

class MaterialDebug extends Component
{
    public $projectStatusId;
    public $projectStatus;
    public $sort = '';

    public function mount()
    {
        $this->projectStatusId = 39;
        $this->projectStatus = ProjectStatus::find(39);
    }

    public function render()
    {
        return view('livewire.admin.material-debug');
    }
}
