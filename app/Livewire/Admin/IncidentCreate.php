<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class IncidentCreate extends Component
{
    public $projectList;
    public $incidentDate;
    public $incidentType;
    public $incidentDetail;

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
            'projectList' => ['required'],
            'incidentDate' => ['required'],
            'incidentType' => ['required'],
            'incidentDetail' => ['required']
        ];
    }

    public function save()
    {
        $this->validate();
        dd($this->incidentDate, $this->incidentType, $this->incidentDetail);
    }

    public function triggerLoading()
    {
        return 0;
    }
}
