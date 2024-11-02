<?php

namespace App\Livewire\Admin;

use App\Models\Incident;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;

class IncidentCreate extends Component
{
    #[Validate(['required','string','max:1700'], as: 'proyecto(s)')]
    public $projectCodes;
    public $projectCodesArray;
    public $projectList;
    #[Validate(['required','date_format:d-m-Y'], as: 'fecha de la incidencia')]
    public $incidentDate;
    #[Validate(['required','numeric'], as: 'tipo de incidente')]
    public $incidentType;
    #[Validate(['required','string'], as: 'detalle')]
    public $incidentDetail;
    public $formHidden;
    public $showProjectsNotFound;

    public $incidentTypeList;

    public function mount()
    {
        $this->formHidden = FALSE;
        $this->showProjectsNotFound = FALSE;
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
        $userId = Auth::user()->id_usr;
        $date = date('Y-m-d H:i:s');
        $incidentsToSave = [];
        foreach ($this->projectList as $project) 
        {
            $incidentsToSave[] = [
                'project_id_inc' => $project->id_pro,
                'status_id_inc' => $project->status_pro,
                'percentage_inc' => $project->productionPercentage,
                'detail_inc' => $this->incidentDetail,
                'manual_entry_date_inc' => Carbon::createFromFormat('d-m-Y',$this->incidentDate)->format('Y-m-d H:i:s'),
                'paused_inc' => 0,
                'stopped_inc' => 0,
                'incident_type_inc' => $this->incidentType,
                'need_to_be_solved_inc' => 0,
                'solved_by_inc' => null,
                'created_by' => $userId,
                'created_at' => $date,
                'createdby_inc' => $userId,
                'createdon_inc' => $date
            ];
            $posInCodesArray = array_search(strtolower($project->code_pro), array_map('strtolower',$this->projectCodesArray));
            
            if($posInCodesArray !== FALSE)
            {
                unset($this->projectCodesArray[$posInCodesArray]);
            }
        }
        
        if(count($incidentsToSave) > 0)
        {
            Incident::insert($incidentsToSave);
        }

        $this->formHidden = TRUE;
        if (count($this->projectCodesArray) > 0 && count($this->projectList) > 0)
        {
            $this->showProjectsNotFound = TRUE;
        }
    }

    public function prepareProjectList()
    {
        $this->projectCodesArray = Str::of($this->projectCodes)->explode(',')->toArray();
        $this->projectCodesArray = array_unique($this->projectCodesArray);
        foreach ($this->projectCodesArray as &$projectCode) 
        {
            $projectCode = Str::trim($projectCode);
        }
        
        $this->projectList = Project::whereIn('code_pro', $this->projectCodesArray)->get();
    }

    public function triggerLoading()
    {
        return 0;
    }
}
