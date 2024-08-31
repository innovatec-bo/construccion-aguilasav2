<?php

namespace App\Livewire\Admin;

use App\Models\Incident;
use Livewire\Component;
use Livewire\WithPagination;

Class HomeIndex extends Component
{
    use WithPagination;
    
    public $search;
    public $sort = 'created_at';
    public $direction = 'desc';
    public $deleteId = '';
    protected $queryString = ['search' => ['except' => '']];
    public $incidentTypes;
    public $lastIncident;

    public function mount()
    {
        $this->incidentTypes = [
            1 => 'Permisos',
            2 => 'Fiscales',
            3 => 'Vecinos',
            4 => 'Linea Viva',
            5 => 'Mecanico',
            6 => 'Materiales incompletos',
            7 => 'Climatológico',
            8 => 'Otros',
            9 => 'Ninguno',
            10 => 'CRE'                
        ];        
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {

        //detail_inc not in('Construccion completada','En construccion','','En Contruccion')
        $incidents = Incident::whereNotIn('detail_inc',['Construccion completada','En construccion','','En Contruccion'])
        ->orderBy($this->sort, $this->direction)
        ->paginate(6);
        if (!$this->lastIncident) 
        {
            $this->lastIncident = $incidents[0];
        }
        
        return view('livewire.admin.home-index', compact('incidents'));
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
