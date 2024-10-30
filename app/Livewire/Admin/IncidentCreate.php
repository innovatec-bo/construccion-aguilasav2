<?php

namespace App\Livewire\Admin;

use App\Models\Project;
use Livewire\Component;
use Illuminate\Support\Str;

class IncidentCreate extends Component
{
    public $projectCodes;
    public $projectList;
    public $incidentDate;
    public $incidentType;
    public $incidentDetail;
    public $projectsNotFound;

    public $incidentTypeList;

    public function mount()
    {
        $this->incidentTypeList = config('serebo.incident_types');
    }

    public function render()
    {
        return view('livewire.admin.incident-create');
    }

    public function rules()
    {
        return [
            'projectCodes' => ['required'],
            'incidentDate' => ['required'],
            'incidentType' => ['required'],
            'incidentDetail' => ['required']
        ];
    }

    public function save()
    {
        $this->validate();
        $this->prepareProjectList();
        $incidentsToSave = [];
        foreach ($variable as $key => $value) 
        {
            $incidentsToSave = [
                [
                    'project_id_inc' => '',
                    'status_id_inc' => '',
                    'percentage_inc' => '',
                    'detail_inc' => '',
                    'manual_entry_date_inc' => '',
                    'paused_inc' => '',
                    'stopped_inc' => '',
                    'incident_type_inc' => '',
                    'need_to_be_solved_inc' => '',
                    'solved_by_inc' => ''
                ]
            ];
        }
    }

    public function prepareProjectList()
    {
        $projectCodes = Str::of($this->projectCodes)->explode(',')->toArray();
        foreach ($projectCodes as &$projectCode) 
        {
            $projectCode = Str::trim($projectCode);
        }
        
        $this->projectList = Project::whereIn('code_pro', $projectCodes)->get();
        dd($this->projectList, $projectCodes);
    }

    public function triggerLoading()
    {
        return 0;
    }
}
