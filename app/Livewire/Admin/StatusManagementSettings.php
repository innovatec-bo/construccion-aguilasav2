<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Settings\StatusManagementSettings as AppStatusManagementSettings;

class StatusManagementSettings extends Component
{
    private AppStatusManagementSettings $statusManagementSettings;
    public bool $enableManualApprovementForConciliations;
    public bool $noPendingMaterialsInCreForAsBuilt;

    public function mount()
    {
        $this->statusManagementSettings = app(AppStatusManagementSettings::class);
        $this->enableManualApprovementForConciliations =$this->statusManagementSettings->enable_manual_approvement_for_conciliations;
        $this->noPendingMaterialsInCreForAsBuilt =$this->statusManagementSettings->no_pending_materials_in_cre_for_as_built;
    }

    public function rules(): array
    {
        return [
            'enableManualApprovementForConciliations' => ['required', 'boolean'],
            'noPendingMaterialsInCreForAsBuilt'       => ['required', 'boolean'],
        ];
    }

    public function save()
    {
        $this->validate();
        $this->statusManagementSettings = app(AppStatusManagementSettings::class);
        $this->statusManagementSettings->enable_manual_approvement_for_conciliations =$this->enableManualApprovementForConciliations;
        $this->statusManagementSettings->no_pending_materials_in_cre_for_as_built =$this->noPendingMaterialsInCreForAsBuilt;

        $this->statusManagementSettings->save();

        session()->flash('success', 'Configuraciones actualizadas correctamente.');
    }

    public function render()
    {
        return view('livewire.admin.status-management-settings');
    }
}