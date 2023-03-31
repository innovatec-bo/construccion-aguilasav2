<?php

namespace App\Http\Livewire\admin;

use App\Models\MaterialSummary;
use App\Models\SummaryType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class MaterialSummaryIndex extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $idMSU;
    public $projectCode;
    public $from;
    public $to;
    public $sort = 'id_msu';
    public $direction = 'desc';
    public $deleteId;
    public $materialSummaryTypeSelected;
    public $materialSummaryTypes;
    protected $queryString = [
        'idMSU' => ['except' => '', 'as' => 'id-de-movimiento'],
        'materialSummaryTypeSelected' => ['except' => '', 'as' => 'tipo-de-movimiento']
    ];

    public function mount()
    {
        $this->materialSummaryTypes = SummaryType::all();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $materialSummaryList = MaterialSummary::whereNotNull('id_msu')
        ->when($this->idMSU, function(Builder $query, $idMSU){
            $query->where('id_msu', $this->idMSU);
        })
        ->when($this->projectCode, function(Builder $query, $projectCode){
            $query->orWhereHas('project', function(Builder $query){
                $query->where('code_pro','like', '%'.$this->projectCode.'%');
            });
        })
        ->when($this->from, function(Builder $query, $from){
            $from = Carbon::createFromFormat('d/m/Y',$from)->format('Y-m-d 00:00:00');
            $query->where('entry_date_msu', '>=', $from);
        })
        ->when($this->from, function(Builder $query, $to){
            $to = Carbon::createFromFormat('d/m/Y', $to)->format('Y-m-d 23:59:59');
            $query->where('entry_date_msu', '<=', $to);
        })
        ->when($this->materialSummaryTypeSelected, function(Builder $query, $materialSummaryTypeSelected){
            $query->whereHas('summaryType', function(Builder $query){
                $query->where('id_mqt',$this->materialSummaryTypeSelected);
            });
        })
        ->orderBy($this->sort, $this->direction)
        ->paginate(6);

        return view('livewire.admin.material-summary-index', compact('materialSummaryList'));
    }

    public function order($sort)
    {
        if ($this->sort == $sort) 
        {
            if ($this->direction == 'desc') 
            {
                $this->direction = 'asc';
            } 
            else 
            {
                $this->direction = 'desc';
            }
            
        } 
        else 
        {
            $this->sort = $sort;
            $this->direction = 'asc';
        }   
    }

    public function delete(MaterialSummary $materialSummary)
    {
        $materialSummary->delete();
        $this->dispatchBrowserEvent('alert',['successMessage', 'Movimiento eliminado exitosamente.']);
        return back();
    }
}
