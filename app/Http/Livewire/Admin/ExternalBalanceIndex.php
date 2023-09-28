<?php

namespace App\Http\Livewire\Admin;

use App\Models\ExternalBalance;
use Livewire\Component;
use Livewire\WithPagination;

class ExternalBalanceIndex extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $deleteId = '';
    protected $queryString = ['search' => ['except' => '']];
    protected $listeners = [
        'render'
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $externalBalances = ExternalBalance::orderBy($this->sort, $this->direction)
        ->paginate(6);
        return view('livewire.admin.external-balance-index', compact('externalBalances'));
    }
}
