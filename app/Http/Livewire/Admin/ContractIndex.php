<?php

namespace App\Http\Livewire\Admin;

use App\Models\Contract;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class ContractIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $projectCode;
    public $sort = 'id_con';
    public $direction = 'desc';
    public $listeners = ['reloadContractIndex' => 'render'];

    public function render()
    {
        $contracts = Contract::orderBy($this->sort, $this->direction)->paginate(5);
        return view('livewire.admin.contract-index', compact('contracts'));
    }
}
