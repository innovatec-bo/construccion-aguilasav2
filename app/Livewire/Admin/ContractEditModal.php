<?php

namespace App\Livewire\Admin;

use App\Models\Contract;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ContractEditModal extends Component
{
    public $contract;
    #[Validate(as: 'número')]
    public $number;
    #[Validate(as: 'monto')]
    public $amount;
    #[Validate(as: 'desde')]
    public $from;
    #[Validate(as: 'hasta')]
    public $to;
    #[Validate(as: 'umbo')]
    public $umbo;
    public $active;

    public function mount(Contract $contract)
    {
        $this->contract = $contract;
        $this->number = $contract->contract_number_con;
        $this->amount = $contract->amount_con;
        $this->from = $contract->start_date_con->format('d/m/Y');
        $this->to = $contract->expiration_date_con->format('d/m/Y');
        $this->umbo = $contract->umbo;
        $this->active = $contract->active;
    }
    public function render()
    {
        return view('livewire.admin.contract-edit-modal');
    }

    public function rules()
    {
        return [
            'number' => ['required'],
            'amount' => ['required'],
            'from' => ['required', 'date_format:d/m/Y'],
            'to' => ['required', 'date_format:d/m/Y'],
            'umbo' => ['required', 'numeric']
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();
        $this->contract->contract_number_con = $this->number;
        $this->contract->amount_con = $this->amount;
        $this->contract->start_date_con = Carbon::createFromFormat('d/m/Y',$this->from)->format('Y-m-d 00:00:00');
        $this->contract->expiration_date_con = Carbon::createFromFormat('d/m/Y',$this->to)->format('Y-m-d 23:59:59');
        $this->contract->umbo = $this->umbo;
        $this->contract->active = (bool)$this->active;
        $this->contract->save();
    
        if($this->active)
            Contract::where('id_con','!=',$this->contract->id_con)->update(['active' => false]);

        $this->dispatch('hideModal');
        $this->dispatch('reloadContractIndex');
    }

    public function triggerLoading()
    {
        return 0;
    }
}
