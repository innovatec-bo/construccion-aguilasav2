<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

Class RoleIndex extends Component
{
    use WithPagination;
    
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $deleteId = '';
    protected $queryString = ['search' => ['except' => '']];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {

        $roles = Role::Where(function($query){
            $query->where('name','like','%'.$this->search.'%');
        })
        ->orderBy($this->sort, $this->direction)
        ->paginate(6);
        
        return view('livewire.admin.role-index', compact('roles'));
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
