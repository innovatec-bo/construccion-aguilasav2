<?php

namespace App\Http\Livewire\Admin;

use App\Models\Contract;
use Carbon\Carbon;
use Livewire\Component;

class ContractCreateModal extends Component
{
    public $number;
    public $amount;
    public $from;
    public $to;
    public $umbo;
    public $listeners = ['fromChanged','toChanged'];

    public function render()
    {
        return view('livewire.admin.contract-create-modal');
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
        $contract = new Contract();
        $contract->contract_number_con = $this->number;
        $contract->amount_con = $this->amount;
        $contract->start_date_con = Carbon::createFromFormat('d/m/Y',$this->from)->format('Y-m-d 00:00:00');
        $contract->expiration_date_con = Carbon::createFromFormat('d/m/Y',$this->to)->format('Y-m-d 23:59:59');
        $contract->umbo = $this->umbo;
        $contract->save();
        $this->emit('hideModal');
        $this->emit('reloadContractIndex');
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
