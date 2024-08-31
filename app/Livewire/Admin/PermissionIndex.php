<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

Class PermissionIndex extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $sort = 'name';
    public $direction = 'desc';
    public $deleteId = '';
    protected $queryString = ['search' => ['except' => '']];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {

        $permissions = Permission::Where(function($query){
            $query->where('name','like','%'.$this->search.'%')
            ->orWhere('detail','like','%'.$this->search.'%');
        })
        ->orderBy($this->sort, $this->direction)
        ->paginate(15);

        return view('class PermissionIndex', compact('permissions'));
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
