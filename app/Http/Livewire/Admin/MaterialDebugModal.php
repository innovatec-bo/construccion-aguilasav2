<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class MaterialDebugModal extends Component
{
    public function render()
    {
        return view('livewire.admin.material-debug-modal');
    }

    public function debug()
    {        
        dd('toc toc');
    }
}
