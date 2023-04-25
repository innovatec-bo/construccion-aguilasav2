<?php

namespace App\Http\Livewire\admin;

use App\CustomLibraries\MaterialSummaryPaginationHandler;
use App\Models\Material;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

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
        $itemsID = implode(",",$itemsID);
        $sql = "
        select material_id_prm material_id, x.entry, x.exit, x.entry-x.exit 'stock' from (
            select
                mat_materials_summary.id_msu,
                movement_type_mqt,
                SUM(CASE 
                WHEN movement_type_mqt = 'in' 
                THEN quantity_prm
                ELSE 0 
                END) AS 'entry',
                SUM(CASE 
                WHEN movement_type_mqt = 'out' 
                THEN quantity_prm
                ELSE 0 
                END) AS 'exit',
                mat_projects_materials.*
            from 
                mat_projects_materials 
                LEFT join mat_materials_summary on id_msu = materials_summary_id_prm
                left join mat_materials_summary_types on mat_materials_summary.summary_type_id_msu = id_mqt
                where 
                movement_type_mqt in ('in','out')
                and material_id_prm in ($itemsID)
                and deleted_prm != 1
                and mat_projects_materials.deleted_at is null
                and deleted_msu != 1
                and mat_materials_summary.deleted_at is null
                group by material_id_prm
            ) x
        order by stock;
        ";
        $result = DB::select($sql);
        $summaryList = $result;
        
        $materialQuantity = [];
        foreach ($summaryList as $value) 
        {
            $materialQuantity[$value->material_id] = $value->stock;
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
