<?php

namespace App\Http\Livewire\Admin;

use App\Models\Contract;
use Livewire\Component;

class ContractEditModal extends Component
{
    public $contract;
    public $number;
    public $amount;
    public $from;
    public $to;
    public $umbo;

    public function mount(Contract $contract)
    {
        $this->contract = $contract;
        $this->number = $contract->contract_number_con;
        $this->amount = $contract->amount_con;
        $this->from = $contract->start_date_con->format('d/m/Y');
        $this->to = $contract->expiration_date_con->format('d/m/Y');
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
            'umbo' => ['required']
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
        $this->contract->start_date_con = $this->from;
        $this->contract->expiration_date_con = $this->to;
        // $this->
        $this->contract->save();
    }

    public function fromChanged($date)
    {
        $this->from = $date;
    }

    public function toChanged($date)
    {
        $this->to = $date;
    }
}
