<?php

namespace App\Http\Livewire\Admin;

use App\CustomLibraries\MaterialSummaryPaginationHandler;
use App\Models\MaterialSummary;
use App\Models\Project;
use App\Models\ProjectMaterial;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MaterialDebugSingleProjectModal extends Component
{
    public $materialSummaries;
    public $projectId;

    public function mount($projectId)
    {
        $this->projectId = $projectId;
        $additionalParameters = [
             'project-id' => $projectId,
            'show-material-pending-in-cre' => 1
        ];
        $list = new MaterialSummaryPaginationHandler(100000, 0,'project_code');
        $list->setAdditionalParameters($additionalParameters);
        $this->materialSummaries = $list->getAll();
    }

    public function render()
    {
        return view('livewire.admin.material-debug-single-project-modal');
    }

    public function debug()
    {
        $materialSummary = MaterialSummary::where('project_id_msu', $this->projectId)->where('summary_type_id_msu',1)->first()->duplicate();
        $materialSummary->project_status_log_id_msu = null;
        $materialSummary->graph_number_msu = null;
        $materialSummary->entry_date_msu = date('Y-m-d H:i:s');
        $materialSummary->detail_msu = 'Depuracion realizada por el usuario '. Auth::user()->fullName;
        $materialSummary->correlative_counter_msu = 0;
        $materialSummary->deleted_msu = 0;
        $materialSummary->createdon_msu = date('Y-m-d H:i:s');
        $materialSummary->createdby_msu = Auth::user()->fullName;
        $materialSummary->save();

        $toSave = [];
        foreach ($this->materialSummaries as $key => $value) 
        {
            $toSave[] = new ProjectMaterial([
                // 'material_id'
            ]);
        }

        $materialSummary->projectMaterials()->saveMany();


    }
}
