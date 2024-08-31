<?php

namespace App\Livewire\Admin;

use App\Models\ExternalObservation;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

Class ExternalObservationIndex extends Component
{
    use WithPagination;
    
    public $search;
    public $sort = 'id_efo';
    public $direction = 'desc';
    public $deleteId = '';
    protected $queryString = ['search' => ['except' => '']];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $externalObservations = ExternalObservation::when($this->search, function(Builder $query, $search){
            $query->where('observation_efo','like','%'.$search.'%');
        })
        ->orderBy($this->sort, $this->direction)
        ->paginate(6);

        return view('livewire.admin.external-observation-index', compact('externalObservations'));
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
