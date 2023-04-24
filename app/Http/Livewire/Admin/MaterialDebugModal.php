<?php

namespace App\Http\Livewire\Admin;

use App\CustomLibraries\MaterialSummaryPaginationHandler;
use App\Models\Project;
use App\Models\ProjectStatus;
use Livewire\Component;

class MaterialDebugModal extends Component
{
    public $statusKeywords;
    public $statusToDebug;
    
    public function mount()
    {
        $this->statusKeywords = [
            'project_return_materials',
            'project_real_budget',
            'project_closed',
            'payment_order_registered',
            'payment_order_invoice_sent',
            'payment_order_has_been_settled',
            'project_real_budget_confirmation'
        ];

        $this->statusToDebug = ProjectStatus::whereIn('keyword_pst', $this->statusKeywords)->get();
    }
    public function render()
    {
        return view('livewire.admin.material-debug-modal');
    }

    public function debug()
    {
        dd('Aun en desarrollo');
    }

    public function debug_()
    {        
        $ids = [];
        foreach ($this->statusToDebug as $value) 
        {
            $ids[] = $value->id_pst;
        }
        // $projectToTest = Project::where('code_pro','RY.21.0021')->first();
        // dd($projectToTest);
        $additionalParameters = [
            'project-status-id' => implode(',',$ids),
            // 'project-id' => $projectToTest->id_pro,
            'show-material-pending-in-cre' => 1
        ];
        $list = new MaterialSummaryPaginationHandler(100000, 0,'project_code');
        $list->setAdditionalParameters($additionalParameters);
        $data = $list->getAll();
        $toSave = [];
        foreach ($data as $key => $value) 
        {
            if (!isset($toSave[$value->project_id])) 
            {
                $toSave[$value->project_id]['project'] = $value;
                $toSave[$value->project_id]['list'][] = $value;
                $toSave[$value->project_id]['string'] = $value->project_id.',';
            }
            else
            {
                $toSave[$value->project_id]['list'][] = $value;
                $toSave[$value->project_id]['string'] .= $value->project_id.',';
            }
        }
        dd($toSave);
    }
}
