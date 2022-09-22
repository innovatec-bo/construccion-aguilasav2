<?php

namespace App\Http\Livewire\admin;

use App\Exports\UsersExport;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;

class UserIndex extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $sort = 'id_usr';
    public $direction = 'desc';
    public $deleteId = '';
    protected $queryString = ['search' => ['except' => '']];
    public $usersToExport;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {

        $users = User::Where(function($query){
            $query->where('firstname_usr','like','%'.$this->search.'%')
            ->orWhere('lastname_usr','like','%'.$this->search.'%')
            ->orWhere('email_usr','like','%'.$this->search.'%');
        });
        $users = $users->orderBy($this->sort, $this->direction);
        $this->usersToExport = $users->get();
        $users = $users->paginate(6);

        return view('livewire.admin.user-index', compact('users'));
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

    public function export()
    {
        $export = new UsersExport($this->usersToExport);
        return Excel::download($export, 'Usuarios.xlsx');
    }
}
