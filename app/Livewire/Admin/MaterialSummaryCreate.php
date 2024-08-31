<?php

namespace App\Livewire\Admin;

use App\Models\SummaryType;
use Livewire\Component;

class MaterialSummaryCreate extends Component
{
    public $movementTypes;
    public $movementTypeSelected;
    public $requestId;
    public $manualEntryDate;
    public $project;
    public $reservationNumber;
    public $fiscal;
    public $builder;

    public function mount()
    {
        $visibleMovementTypes = [
            'materials_picked_up_from_cre',
            'materials_delivered_to_builder',
            'materials_delivered_to_builder_loan',
            'builder_returns_materials',
        ];
        $this->movementTypes = SummaryType::whereIn('keyword_mqt', $visibleMovementTypes)->get();
        $this->movementTypeSelected = SummaryType::where('keyword_mqt','materials_picked_up_from_cre')->first()->id_mqt;
    }

    public function render()
    {
        return view('livewire.admin.material-summary-create');
    }

    public function rules()
    {
        $rules = [
            'movementTypeSelected' => ['required']
        ];
        return $rules;
    }
}
