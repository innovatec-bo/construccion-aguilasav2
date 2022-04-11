<?php

namespace App\Http\Livewire\admin;

use App\Models\MaterialSummary;
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

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {

        $materialSummaryList = MaterialSummary::where(function(Builder $query){
            if(isset($this->search) && $this->search != "")
                $query->where('id_msu',$this->search);
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
