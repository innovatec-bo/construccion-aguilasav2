<?php

namespace App\Livewire\Admin;

use App\Models\Contract;
use App\Models\User;
use Livewire\Component;

use function PHPSTORM_META\map;

class ProjectCreate extends Component
{
    public 
    $designBudget,
    $buildingBudget,
    $code,
    $workArea,
    $projectYear,
    $contractId,
    $projectDetail,
    $projectAddress,
    $entryDate,
    $folderDate,
    $CREFiscal,
    $system,
    $management,
    $qualityLevel,
    $creDesignCompletionDate,
    $creBuildingCompletionDate,
    $projectBudgetaryPosition,
    $points,
    $distance,
    $latitude,
    $longitude
    ;

    public 
    $contracts,
    $CREFiscals,
    $systems,
    $managements,
    $showLabels;

    protected $messages = [
        'code.unique' => 'Este codigo ya se encuentra en uso.',
        'projectYear.digits' => ':attribute deben ser 4 digitos.',
        'entryDate.date_format' => 'El formato debe ser yyyy-mm-dd',
        'folderDate.date_format' => 'El formato debe ser yyyy-mm-dd',
        'creDesignCompletionDate.date_format' => 'El formato debe ser yyyy-mm-dd',
        'creBuildingCompletionDate.date_format' => 'El formato debe ser yyyy-mm-dd'
    ];

    protected $validationAttributes = [
        'designBudget' => 'Diseño Bs',
        'buildingBudget' => 'Construcción Bs',
        'code' => 'Código',
        'workArea' => 'Area de trabajo',
        'projectYear' => 'Año del proyecto',
        'contractId' => 'Contrato',
        'projectDetail' => 'Detalle del proyecto',
        'projectAddress' => 'Dirección',
        'entryDate' => 'Fecha de ingreso',
        'folderDate' => 'Fecha de folder',
        'CREFiscal' => 'Fiscal de CRE',
        'system' => 'Sistema',
        'management' => 'Administracion',
        'qualityLevel' => 'Nivel de calidad',
        'creDesignCompletionDate' => 'Fin de diseño(CRE)',
        'creBuildingCompletionDate' => 'Fin de construcción(CRE)',
        'projectBudgetaryPosition' => 'Posicion presupuestaria',
        'points' => 'Puntos',
        'distance' => 'Distancia'
    ];

    public function mount()
    {
        $this->contracts = Contract::all();
        $this->CREFiscals = User::role('Fiscal de CRE')->orderBy('firstname_usr')->get();
        $this->systems = [
            1 => 'Sistema Santa Cruz',
            2 => 'Sistema Velasco',
            3 => 'Sistema Misiones',
            4 => 'Sistema Camiri',
            5 => 'Sistema German bush',
            6 => 'Sistema Robore',
            7 => 'Sistema Valles'
        ];
        $this->managements = [
            1 => 'Sistema Santa Cruz',
            2 => 'Sistema Velasco',
            3 => 'Sistema Misiones',
            4 => 'Sistema Camiri',
            5 => 'Sistema German bush',
            6 => 'Sistema Robore',
            7 => 'Sistema Valles'
        ];
        $this->showLabels = false;
    }

    public function render()
    {
        return view('livewire.admin.project-create');
    }

    public function rules()
    {
        return [
            'designBudget' => ['required','numeric'],
            'buildingBudget' => ['required','numeric'],
            'code' => ['required','unique:wfl_projects,code_pro'],
            'workArea' => ['required','string','in:GIS,GIR'],
            'projectYear' => ['required', 'digits:4'],
            'contractId' => ['required','exists:wfl_contracts,id_con'],
            'projectDetail' => ['required','string','max:100'],
            'projectAddress' => ['required','string','max:100'],
            'entryDate' => ['required','date_format:Y-m-d'],
            'folderDate' => ['required','date_format:Y-m-d'],
            'CREFiscal' => ['required','exists:sec_users,id_usr'],
            'system' => ['required'],
            'management' => ['required'],
            'qualityLevel' => ['required', 'between:0,3'],
            'creDesignCompletionDate' => ['required','date_format:Y-m-d'],
            'creBuildingCompletionDate' => ['required','date_format:Y-m-d'],
            'projectBudgetaryPosition' => ['required','in:10,20,30,40,50,60,70,80,90,100,110'],
            'points' => ['required','numeric'],
            'distance' => ['required','numeric'],
            // 'latitude' => [],
            // 'longitude' => []
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();
    }
}
