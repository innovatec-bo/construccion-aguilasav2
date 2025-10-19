<?php

namespace App\Livewire\Admin;

use App\Models\Incident;
use App\Models\ProjectBudget;
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
        ->paginate(6, pageName: 'incident-page');
        if (!$this->lastIncident) 
        {
            $this->lastIncident = $incidents[0];
        }
        
        $budgets = ProjectBudget::query()
            ->where('trim_tree_prb', 1)
            ->whereHas('projectStatusLog')
            ->with(['project', 'treePruning'])
            // ->when($this->projectCode, function ($query) {
            //     $query->whereHas('project', function ($q) {
            //         $q->where('code_pro', 'like', '%' . $this->projectCode . '%');
            //     });
            // })
            ->orderByDesc('id_prb')
            ->paginate(10, pageName: 'budget-page');
        return view('livewire.admin.home-index', compact('incidents', 'budgets'));
    }

    public function paginationView()
    {
        return 'livewire.custom-paginations-links';
    }
}
