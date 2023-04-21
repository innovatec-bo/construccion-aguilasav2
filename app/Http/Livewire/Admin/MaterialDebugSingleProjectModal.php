<?php

namespace App\Http\Livewire\Admin;

use App\CustomLibraries\MaterialSummaryPaginationHandler;
use App\Models\MaterialSummary;
use App\Models\Project;
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
        $materialSummary = new MaterialSummary([
            'project_status_log_id_msu' => NULL,
            'tension_level_msu' => 'TODOS',
            'project_id_msu' => $this->projectId,
            'applicant_project_id_msu' => $this->projectId,
            'graph_number_msu' => NULL,
            'destiny_msu' => '',
            'entry_date_msu' => date('d-m-y H:i:s'),
            'detail_msu' => 'Depuracion realizada por el usuario '. Auth::user()->fullName,
            'builder_responsible_msu' => '',
            'summary_type_id_msu',
            'reservation_number_msu',
            'file_id_msu',
            'parent_summary_id_msu',
            'is_loan_msu',
            'loan_closed_msu',
            'loan_closed_date_msu',
            'correlative_counter_msu',
            'fiscal_responsible_msu',
            'deleted_msu',
            'createdon_msu',
            'createdby_msu',
            'editedon_msu',
            'status_id_msu',
            'canceled_on_msu',
            'withdrawn_on_msu',
            'canceledby_msu',
        ]);
    }
}
