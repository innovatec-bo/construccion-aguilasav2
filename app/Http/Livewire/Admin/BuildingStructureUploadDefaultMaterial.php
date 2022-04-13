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

    public function rules()
    {
        return [
            'file' => 'required|file|max:2048|mimes:xlsx, csv, xls' // 1MB Max
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();
    }
}
