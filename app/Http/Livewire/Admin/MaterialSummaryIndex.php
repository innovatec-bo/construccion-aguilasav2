<?php

namespace App\Http\Livewire\admin;

use App\Models\MaterialSummary;
use App\Models\SummaryType;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class MaterialSummaryIndex extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $sort = 'id_msu';
    public $direction = 'desc';
    public $deleteId;
    public $materialSummaryTypeSelected;
    public $materialSummaryTypes;

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
        $materialSummaryList = MaterialSummary::whereNotNull('id_msu');
        if(isset($this->search) && $this->search != "")
        {
            $materialSummaryList = $materialSummaryList->where(function(Builder $query){
                $query->where('id_msu',$this->search)
                ->orWhereHas('project', function(Builder $query){
                    $query->where('code_pro','like', '%'.$this->search.'%');
                });
            });
        }
        
        if(isset($this->materialSummaryTypeSelected) && $this->materialSummaryTypeSelected != "")
        {
            $materialSummaryList = $materialSummaryList->whereHas('summaryType', function(Builder $query){
                $query->where('id_mqt',$this->materialSummaryTypeSelected);
            });
        }

        $materialSummaryList = $materialSummaryList->orderBy($this->sort, $this->direction)
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
