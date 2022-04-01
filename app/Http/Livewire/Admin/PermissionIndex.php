<?php

namespace App\Http\Livewire\admin;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class PermissionIndex extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $sort = 'id';
    public $direction = 'desc';
    public $deleteId = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {

        $permissions = Permission::Where(function($query){
            $query->where('name','like','%'.$this->search.'%');
        })
        ->orderBy($this->sort, $this->direction)
        ->paginate(6);

        return view('livewire.admin.permission-index', compact('permissions'));
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
