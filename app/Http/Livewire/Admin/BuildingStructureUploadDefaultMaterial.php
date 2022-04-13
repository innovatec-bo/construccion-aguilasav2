<?php

namespace App\Http\Livewire\Admin;

use App\Models\BuildingStructure;
use App\Models\DefaultStructureMaterial;
use App\Models\Material;
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
        
        //Getting materials and structures in database
        $arrayBuildingStructures = BuildingStructure::all()->keyBy('structure_code_bus')->toArray();
        $arrayMaterials = Material::all()->keyBy('code_mat')->toArray();
        //Getting info from excel file
        $temporaryFile = $this->file->getPath().'/'.$this->file->getFileName();
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($temporaryFile);
        $items = $spreadsheet->getSheet(1);
		$arrayItemsBuildingStructures = $items->toArray();

        $i = 0;
		$notFoundStructures = array();
		$newMaterialsToSave = array();
        foreach ($arrayItemsBuildingStructures as $row)
        {
            if($i > 1)
			{
                $structureCode = $row[0];
                $structureDescription = $row[1];
				$materialCode = $row[3];
				$quantity = $row[4];
				$description = $row[5];
				$completedData = TRUE;
				$structureId = NULL;

                if(isset($arrayBuildingStructures[$structureCode]))
				{
					$structureId = $arrayBuildingStructures[$structureCode]['id_bus'];
				}
				else
				{
					$completedData = FALSE;
					$notFoundStructures[$structureCode] = [
                        'structure_code_bus' => $structureCode,
                        'description_bus' => $structureDescription,
                        'unit_of_measurement_bus' => 'Pza'
                    ];
				}

                $materialId = NULL;
                
                if(isset($arrayMaterials[$materialCode]))
				{
					$materialId = $arrayMaterials[$materialCode]['id_mat'];
				}
				else
				{
					$completedData = FALSE;
					$newMaterialsToSave[$materialCode] = array(
						'code_mat' => $materialCode,
						'description_mat' => $description
					);
				}

				if($completedData)
				{
					$dataToSave[] = [
						'structure_id_dsm' => $structureId,
						'material_id_dsm' => $materialId,
						'quantity_dsm' => $quantity
					];
				}
            }
            $i++;
        }

        if(count($dataToSave) > 0)
        {
            DefaultStructureMaterial::whereNotNull('id_dsm')->update(['deleted_dsm' => 1]);
            DefaultStructureMaterial::whereNotNull('id_dsm')->delete();
            DefaultStructureMaterial::insert($dataToSave);
        }

        $loadAgain = false;
        if(count($newMaterialsToSave) > 0)
        {
            $loadAgain = true;
            Material::insert($newMaterialsToSave);
        }
        if(count($notFoundStructures) > 0)
        {
            $loadAgain = true; 
            BuildingStructure::insert($notFoundStructures);
        }
        if($loadAgain)
        {
            $this->dispatchBrowserEvent('alert',['warningMessage', 'Se encontraron nuevas estructuras y materiales, por favor cargue de nuevo el archivo.']);
        }
        else
        {
            $this->dispatchBrowserEvent('alert',['successMessage', 'Se han establecido materiales x estructuras de forma exitosa']);
        }
    }
}
