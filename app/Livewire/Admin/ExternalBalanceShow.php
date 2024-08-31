<?php

namespace App\Livewire\Admin;

use App\Models\ExternalBalance;
use App\Models\ExternalBalanceMaterial;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class ExternalBalanceShow extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $deleteId = '';
    protected $queryString = ['search' => ['except' => '']];
    public $externalBalance;

    public function mount($externalBalance)
    {
        $this->externalBalance = $externalBalance;
    }

    public function render()
    {
        $externalBalanceMaterials = ExternalBalanceMaterial::where('external_balance_id', $this->externalBalance->id)
        ->when($this->search, function(Builder $query, $search){
            $query->where('Proyecto', 'like','%'.$this->search.'%');
        })
        ->orderBy($this->sort, $this->direction)
        ->paginate(6);
        return view('livewire.admin.external-balance-show', compact('externalBalanceMaterials'));
    }
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
}
