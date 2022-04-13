<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;

class BuildingStructureUploadDefaultMaterial extends Component
{
    use WithFileUploads;

    public $file;

    public function render()
    {
        return view('livewire.admin.building-structure-upload-default-material');
    }

    public function save()
    {
        $this->validate([
            'file' => 'required|file|max:2048|mimes:xlsx, csv, xls' // 1MB Max
        ]);
    }
}
