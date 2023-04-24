<?php

namespace App\Http\Livewire\Admin;

use App\CustomLibraries\MaterialSummaryPaginationHandler;
use App\Models\Project;
use App\Models\ProjectStatus;
use Livewire\Component;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\WithPagination;
use Illuminate\Pagination\Paginator;

class MaterialDebugPendingInCre extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['refreshMaterialDebugPendingInCre' => 'render'];
    public $statusKeywords;
    public $statusToDebug;
    public $toDebug;
    public $projectCode;
    
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
        $ids = [];
        foreach ($this->statusToDebug as $value) 
        {
            $ids[] = $value->id_pst;
        }

        $additionalParameters = [
            'project-status-id' => implode(',',$ids),
            'show-material-pending-in-cre' => 1
        ];
        if ($this->projectCode) 
        {
            $project = Project::where('code_pro', $this->projectCode)->first();
            $additionalParameters['project-id'] = $project->id_pro;
        }
        $list = new MaterialSummaryPaginationHandler(100000, 0,'project_code');
        
        $list->setAdditionalParameters($additionalParameters);
        
        $data = $list->getAll();
        $this->toDebug = [];
        foreach ($data as $key => $value) 
        {
            if (!isset($this->toDebug[$value->project_id])) 
            {
                $this->toDebug[$value->project_id]['project_id'] = $value->project_id;
                
                $this->toDebug[$value->project_id]['project_code'] = $this->projectCode;
                $this->toDebug[$value->project_id]['string'] = $value->project_id.',';
            }
                $this->toDebug[$value->project_id]['project_code'] = $value->project_code;
                $this->toDebug[$value->project_id]['project_status_name'] = $value->project_status_name;
                $this->toDebug[$value->project_id]['list'][] = $value;
                $this->toDebug[$value->project_id]['string'] .= $value->project_id.',';
        }
        $this->toDebug = collect($this->toDebug);

        $page = $this->page;
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $data = new LengthAwarePaginator($this->toDebug->forPage($page,5), $this->toDebug->count(), 5, $page);
        // dd($data);
        return view('livewire.admin.material-debug-pending-in-cre', compact('data'));
    }
}
