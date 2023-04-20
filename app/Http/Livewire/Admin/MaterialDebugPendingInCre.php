<?php

namespace App\Http\Livewire\Admin;

use App\CustomLibraries\MaterialSummaryPaginationHandler;
use App\Models\ProjectStatus;
use Livewire\Component;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\WithPagination;
use Illuminate\Pagination\Paginator;

class MaterialDebugPendingInCre extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $statusKeywords;
    public $statusToDebug;
    public $toDebug;

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
        $ids = [];
        foreach ($this->statusToDebug as $value) 
        {
            $ids[] = $value->id_pst;
        }
        $additionalParameters = [
            'project-status-id' => implode(',',$ids),
            'show-material-pending-in-cre' => 1
        ];
        $list = new MaterialSummaryPaginationHandler(100000, 0,'project_code');
        $list->setAdditionalParameters($additionalParameters);
        $data = $list->getAll();
        $this->toDebug = [];
        foreach ($data as $key => $value) 
        {
            if (!isset($this->toDebug[$value->project_id])) 
            {
                $this->toDebug[$value->project_id]['project'] = $value;
                $this->toDebug[$value->project_id]['list'][] = $value;
                $this->toDebug[$value->project_id]['string'] = $value->project_id.',';
            }
            else
            {
                $this->toDebug[$value->project_id]['list'][] = $value;
                $this->toDebug[$value->project_id]['string'] .= $value->project_id.',';
            }
        }
        $this->toDebug = collect($this->toDebug);
        // dd(collect($toPaginate)->paginate(6));
    }

    public function render()
    {
        $page = $this->page;
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $data = new LengthAwarePaginator($this->toDebug->forPage($page,5), $this->toDebug->count(), 5, $page);
        return view('livewire.admin.material-debug-pending-in-cre', compact('data'));
    }
}
