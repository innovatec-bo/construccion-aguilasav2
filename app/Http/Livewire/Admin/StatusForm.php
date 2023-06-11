<?php

namespace App\Http\Livewire\admin;

use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\User;
use Livewire\Component;

class StatusForm extends Component
{
    public $project;
    public $status;
    public $entryDate;
    public $detail;
    public $stakers;
    public $responsibleList;

    public function mount(Project $project, ProjectStatus $status)
    {
        $this->project = $project;
        $this->status = $status;
        $this->stakers = User::role('Estaqueador')->get();
        $this->responsibleList = [];
    }

    public function render()
    {
        return view('livewire.status-form');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    protected $messages = [
        'entryDate.required' => 'Este campo es requerido.',
        'responsibleList.required' => 'Este campo es requerido.',
    ];

    public function rules()
    {
        $rules = [
            'entryDate' => ['required','date_format:d-m-Y'],
            'responsibleList' => ['required','array','min:1']
        ];
        switch ($this->status->keyword_pst) {
            case 'stakes':
                
                break;
            case 'digitization':

                break;
            case 'schedule':
                
                break;
            case 'drawing':
                
                break;
            case 'returned':

                break;
            case 'canceled':

                break;
            case 'rectify_design':
                
                break;
            case 'rd_stakes':
                
                break;
            case 'rd_digitization':
                
                break;
            case 'rd_drawing':

                break;
            case 'rectify_illustration':

                break;
            case 'ri_digitization':

                break;
            case 'ri_drawing':

                break;
            case 'already_sent':
                
                break;
            case 'approved':

                break;
            case 'assign_to':

                break;
            case 'in_progress':

                break;
            case 'paused':

                break;
            case 'completed':
                
                break;
            case 'project_energized':
                
                break;
            case 'as_built':

                break;
            case 'conciliation_reception':
                
                break;
            case 'conciliation_shipment':

                break;
            case 'cre_return_order':

                break;
            case 'stopped':

                break;
            

        }
        return $rules;
    }

    public function save()
    {
        $this->validate();
        $this->{$this->status->keyword_pst}();
    }

    public function stakes()
    {
        $data = [
            'entryDate' => $this->entryDate,
            'responsibleList' => $this->responsibleList,
            'detail' => $this->detail
        ];
        $this->project->moveToStatus('stakes', $data);
    }

    public function digitization()
    {
        dd('toc toc');
    }
}
