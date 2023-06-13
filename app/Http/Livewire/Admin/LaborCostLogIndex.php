<?php

namespace App\Http\Livewire\Admin;

use App\Models\BuildingStructure;
use App\Models\LaborCostLog;
use App\Models\WorkedUpStructure;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class LaborCostLogIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $projectCode;
    public $structureCode;
    public $from;
    public $to;
    public $sort = 'id_wus';
    public $direction = 'desc';
    protected $queryString = [
        'projectCode' => ['except' => '', 'as' => 'projecto'],
        'structureCode' => ['except' => '', 'as' => 'estructura'],
        'from' => ['except' => '', 'as' => 'desde'],
        'to' => ['except' => '', 'as' => 'hasta']
    ];
    protected $listeners = [
        'fromChanged' => 'fromChanged',
        'toChanged' => 'toChanged'
    ];

    public function mount()
    {
        
    }

    public function updating($attribute)
    {
        $toValidate = ['projectCode','structureCode','from', 'to'];
        if (array_search($attribute, $toValidate) !== FALSE) 
        {
            $this->resetPage();
        }
    }

    public function render()
    {
        $workedUpStructures = WorkedUpStructure::orderBy($this->sort, $this->direction)
        ->when($this->projectCode, function(Builder $query, $projectCode){
            $query->whereHas('laborCost', function(Builder $query){
                $query->whereHas('laborDetail', function(Builder $query){
                    $query->whereHas('project', function(Builder $query){
                        $query->where('code_pro', $this->projectCode);
                    });
                });
            });
        })
        ->when($this->structureCode, function(Builder $query, $structureCode){
            $query->whereHas('laborCost', function(Builder $query){
                $query->whereHas('buildingStructure', function(Builder $query){
                    $query->where('structure_code_bus', $this->structureCode);
                });
            });
        })
        ->when($this->from, function(Builder $query, $from){
            $query->whereHas('log', function(Builder $query)use($from){
                $from = Carbon::createFromFormat('d-m-Y',$from)->format('Y-m-d 00:00:00');
                $query->where('manual_entry_date_lal', '>=', $from);
            });
        })
        ->when($this->to, function(Builder $query, $to){
            $query->whereHas('log', function(Builder $query)use($to){
                $to = Carbon::createFromFormat('d-m-Y',$to)->format('Y-m-d 00:00:00');
                $query->where('manual_entry_date_lal', '<=', $to);
            });
        })
        ->paginate(10);
        return view('livewire.admin.labor-cost-log-index', compact('workedUpStructures'));
    }
    
    public function triggerLoading()
    {
        return 0;
    }
}
