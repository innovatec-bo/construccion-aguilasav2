<?php

namespace App\Http\Livewire\admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use PhpParser\Node\Expr\BinaryOp\Concat;

class BuilderDebtReportIndex extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $sort = 'id_usr';
    public $direction = 'desc';
    public $deleteId = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $builders = User::role('builder')->orderBy('firstname_usr','asc')->get()->pluck('full_name','id_usr');
        $users = User::Where(function($query){
            $query->where('first_name','like','%'.$this->search.'%')
            ->orWhere('last_name','like','%'.$this->search.'%')
            ->orWhere('email','like','%'.$this->search.'%');
        })
        ->orderBy($this->sort, $this->direction)
        ->paginate(6);

        return view('livewire.admin.builder-debt-report-index', compact('users', 'builders'));
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
