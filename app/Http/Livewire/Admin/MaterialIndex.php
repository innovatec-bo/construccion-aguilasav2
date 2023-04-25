<?php

namespace App\Http\Livewire\admin;

use App\CustomLibraries\MaterialSummaryPaginationHandler;
use App\Models\Material;
use Livewire\Component;
use Livewire\WithPagination;

class MaterialIndex extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $sort = 'id_mat';
    public $direction = 'desc';
    public $deleteId = '';
    protected $queryString = ['search' => ['except' => '']];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        
        $materials = Material::Where(function($query){
            $query->where('code_mat','like','%'.$this->search.'%')
            ->orWhere('name_mat','like','%'.$this->search.'%')
            ->orWhere('description_mat','like','%'.$this->search.'%');
        })
        ->orderBy($this->sort, $this->direction)
        ->paginate(6);

        $itemsID = [];
        foreach ($materials->items() as $key => $value) 
        {
            $itemsID[] = $value->id_mat;
        }
        $itemsID = implode(" ",$itemsID);
        $materialSummary = new MaterialSummaryPaginationHandler(20);
        $additionalParameters = [
            'grouping-criteria' => 'material_id_prm',
            'material-ids'  => $itemsID
        ];
        $materialSummary->setAdditionalParameters($additionalParameters);
        
        $summaryList = $materialSummary->getAll();
        $materialQuantity = [];
        foreach ($summaryList as $value) 
        {
            $materialQuantity[$value->material_id] = $value->quantity_in_warehouse;
        }

        return view('livewire.admin.material-index', compact('materials','materialQuantity'));
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
