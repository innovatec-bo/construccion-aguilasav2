<?php

namespace App\Http\Livewire\admin;

use App\Models\LaborDetail;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class LaborDetailIndex extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $sort = 'id_lad';
    public $direction = 'desc';
    public $deleteId = '';
    protected $queryString = ['search' => ['except' => '']];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {

        $laborDetails = LaborDetail::Where(function($query){
            if(isset($this->search) && $this->search != "")
            {
                $query->where('graph_number_lad','like','%'.$this->search.'%')
                ->orWhere('destiny_lad','like','%'.$this->search.'%')
                ->orWhereHas('project',function(Builder $query){
                    $query->where('code_pro','like','%'.$this->search.'%');
                });
            }
            
        })
        ->orderBy($this->sort, $this->direction)
        ->paginate(6);

        return view('livewire.admin.labor-detail-index', compact('laborDetails'));
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
}
