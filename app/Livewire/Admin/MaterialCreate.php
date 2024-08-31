<?php

namespace App\Livewire\Admin;

use App\Models\Material;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Illuminate\Validation\Rule;

class MaterialCreate extends Component
{
    public $code, $description, $unitOfMeasurement;

    public function mount()
    {
        $this->unitOfMeasurement = 'Pza';
    }

    public function rules()
    {
        return [
            'code' => 'required|unique:mat_materials,code_mat',
            'description' => 'required|unique:mat_materials,description_mat',
            'unitOfMeasurement' => ['required', Rule::in(['Pza', 'M'])]
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.admin.material-create');
    }

    public function save()
    {
        $this->validate();
        Material::insert([
            'code_mat' => $this->code,
            'description_mat' => $this->description,
            'unit_of_measurement_mat' => $this->unitOfMeasurement
        ]);
        Session::flash('successMessage','Material agregado exitosamente');
        return redirect()->route('admin.materials.index');
    }
}
