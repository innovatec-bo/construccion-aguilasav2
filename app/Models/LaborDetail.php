<?php

namespace App\Models;

use AppKit\Blameable\Traits\Blameable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class LaborDetail extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Blameable;
    
    protected $table = "bui_labor_details";
    protected $primaryKey = "id_lad";

    const CREATED_AT = 'createdon_lad';
    const UPDATED_AT = 'editedon_lad';

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id_lad');
    }

    public function laborCosts()
    {
        return $this->hasMany(LaborCost::class, 'labor_detail_id_lac');
    }

    public function getEnvironmentAttribute()
    {
        switch ($this->attributes['status_id_lad'])
        {
            case 11://Approved
                $response['label'] = "dise&ntilde;o";
                $response['key'] = "design";
                break;
            
            case 34://Conciliation reception
                $response['label'] = "construcci&oacute;n";
                $response['key'] = "construction";
                break;
            default:
                $response['label'] = "undefined";
                $response['key'] = "indefinido";
                $response['id'] = '0';
        }
        return $response;
    }

    public function defaultStructureMaterials()
    {
        $defaultMaterials = DefaultStructureMaterial::whereHas('structure', function(Builder $query){
            $query->whereHas('laborCosts', function(Builder $query){
                $query->whereHas('laborDetail', function(Builder $query){
                   $query->where('project_id_lad', $this->attributes['project_id_lad'])
                   ->where('status_id_lad', $this->status_id_lad);
                });
            });
        })->get();
        return $defaultMaterials;
    }

    public function customStructureMaterials()
    {
        $customMaterials = CustomStructureMaterial::whereHas('laborCost', function(Builder $query){
            $query->whereHas('laborDetail', function(Builder $query){
                $query->where('project_id_lad', $this->attributes['project_id_lad'])
                ->where('status_id_lad', $this->status_id_lad);
            });
        })->get();
        return $customMaterials;
    }

    public function getHasCustomMaterialsAttribute()
    {
        $defaultMaterials = $this->defaultStructureMaterials();
        $customMaterials = $this->customStructureMaterials();
        $response = true;
        if($defaultMaterials->count() > 0 && $customMaterials->count() == 0)
            $response = false;
        
        return $response;
    }

    public function applyCustomMaterials()
    {
        if(!$this->hasCustomMaterials)
        {
            $saveAsCustom = [];
            foreach ($this->laborCosts as $laborCost) 
            {
                foreach ($laborCost->buildingStructure->defaultStructureMaterials as $default) 
                {
                    $saveAsCustom[] = [
                        'labor_cost_id' => $laborCost->id_lac,
                        'material_id_csm' => $default->material_id_dsm,
                        'quantity_csm' => $default->quantity_dsm
                    ];
                }
            }
            $object = new CustomStructureMaterial();
                    $saveAsCustom = array_map(function ($data) use ($object) {
                        $timestamp = $object->freshTimestampString();
                        $data['created_at'] = $timestamp;
                        $data['created_by'] = Auth::user()->id_usr;
                        return $data;
                    }, $saveAsCustom);
            if(count($saveAsCustom) > 0)
            {
                CustomStructureMaterial::insert($saveAsCustom);
            }
        }
    }

    public function internalConciliationCreFormat()
    {
        $summaryTypes = [
            'materials_picked_up_from_cre', 
            'materials_delivered_to_builder', 
            'materials_delivered_to_builder_loan',
            'builder_returns_materials'
        ];
        $report = [];
        $summaries = $this->project->materialSummaries()->whereHas('summaryType', function(Builder $query)use($summaryTypes){
            $query->whereIn('keyword_mqt', $summaryTypes);
        })->get();

        foreach ($summaries as $key => $materialSummary) 
        {
            foreach ($materialSummary->projectMaterials as $key2 => $projectMaterial) 
            {
                if(!isset($report[$projectMaterial->material->code_mat]))
                {
                    $report[$projectMaterial->material->code_mat] = [
                        'material_code' => $projectMaterial->material->code_mat,
                        'material_description' => $projectMaterial->material->description_mat,
                        'unit_of_measurement_mat' => $projectMaterial->material->unit_of_measurement_mat,
                        'materials_picked_up_from_cre' => 0,
                        'materials_delivered_to_builder' => 0,
                        'materials_delivered_to_builder_loan' => 0,
                        'builder_returns_materials_nvo' => 0,
                        'total_used' => 0,
                        'return_to_cre' => 0,
                        'return_to_serebo' => 0,
                        'builder_returns_materials_meo' => 0
                    ];
                }
                switch ($materialSummary->summaryType->keyword_mqt) 
                {
                    case 'materials_picked_up_from_cre':
                        $report[$projectMaterial->material->code_mat]['materials_picked_up_from_cre'] += $projectMaterial->quantity_prm;
                        break;
                    case 'materials_delivered_to_builder':
                        $report[$projectMaterial->material->code_mat]['materials_delivered_to_builder'] += $projectMaterial->quantity_prm;
                        break;
                    case 'materials_delivered_to_builder_loan':
                        $report[$projectMaterial->material->code_mat]['materials_delivered_to_builder_loan'] += $projectMaterial->quantity_prm;
                        break;
                    case 'builder_returns_materials':
                        if($projectMaterial->status->code_mst == 'MEO')
                        {
                            $report[$projectMaterial->material->code_mat]['builder_returns_materials_meo'] += $projectMaterial->quantity_prm;
                        }
                        elseif($projectMaterial->status->code_mst == 'NVO')
                        {
                            $report[$projectMaterial->material->code_mat]['builder_returns_materials_nvo'] += $projectMaterial->quantity_prm;
                        }
                        break;
                }
            }
        }

        foreach ($report as &$row) 
        {
            $in = $row['materials_picked_up_from_cre'] + $row['builder_returns_materials_nvo'];
            $out = $row['materials_delivered_to_builder'] + $row['materials_delivered_to_builder_loan'];
            $row['total_used'] = $out - $row['builder_returns_materials_nvo'];
            if($in > $out)
            {
                $row['return_to_cre'] = $in - $out;    
            }
            elseif($out > $in)
            {
                $row['return_to_serebo'] = $out - $in;    
            }

            // $row['total_used'] = ($row['materials_picked_up_from_cre'] + $row['builder_returns_materials_nvo']) - ($row['materials_delivered_to_builder'] + $row['materials_delivered_to_builder_loan']);
        }
        return $report;
    }

    public function summary(MaterialSummary $materialSummary = NULL)
    {
        $materialSummaryId = NULL;
        $reservationNumber = NULL;
        if($materialSummary instanceof MaterialSummary)
        {
            $materialSummaryId = $materialSummary->id_msu;
            $reservationNumber = $materialSummary->reservation_number_msu;
        }

        $summaryTypes = [
            'materials_initial_list',
            'materials_additional_list',
            'materials_picked_up_from_cre',
            'entry_by_conciliation_221',
            'materials_delivered_to_builder', 
            'materials_delivered_to_builder_loan',
            'out_by_conciliation_222',
            'request_materials',
            'builder_returns_materials'
        ];
        $report = [];
        $summaries = $this->project->materialSummaries()
            ->when($materialSummaryId, function(Builder $query, $materialSummaryId){
                $query->where('id_msu','!=', $materialSummaryId);
            })
            ->whereHas('summaryType', function(Builder $query)use($summaryTypes){
                $query->whereIn('keyword_mqt', $summaryTypes);
            })
            ->get();
        
        foreach ($summaries as $key => $materialSummary) 
        {
            foreach ($materialSummary->projectMaterials as $key2 => $projectMaterial) 
            {
                if(!isset($report[$projectMaterial->material->code_mat]))
                {
                    $report[$projectMaterial->material->code_mat] = [
                        'material_code' => $projectMaterial->material->code_mat,
                        'material_description' => $projectMaterial->material->description_mat,
                        'unit_of_measurement_mat' => $projectMaterial->material->unit_of_measurement_mat,
                        'total_assigned' => 0,
                        'materials_initial_list' => 0,
                        'materials_additional_list' => 0,
                        'materials_picked_up_from_cre' => 0,
                        'entry_by_conciliation_221' => 0,
                        'pending_material_in_cre' => 0,
                        'total_materials_delivered_to_builder' => 0,
                        'materials_delivered_to_builder' => 0,
                        'materials_delivered_to_builder_loan' => 0,
                        'out_by_conciliation_222'=> 0, 
                        'request_materials' => 0,
                        'request_loans_materials' => 0,
                        'builder_returns_materials_nvo' => 0,
                        'quantity_in_warehouse' => 0,
                        'total_used' => 0,
                        'return_to_cre' => 0,
                        'return_to_serebo' => 0,
                        'builder_returns_materials_meo' => 0
                    ];
                }
                switch ($materialSummary->summaryType->keyword_mqt) 
                {
                    case 'materials_initial_list'://******************CONTROL_IN
                        if((isset($reservationNumber) && $materialSummary->reservation_number_msu == $reservationNumber) || is_null($reservationNumber))
                        {
                            $report[$projectMaterial->material->code_mat]['materials_initial_list'] += $projectMaterial->quantity_prm;
                            $report[$projectMaterial->material->code_mat]['total_assigned'] += $projectMaterial->quantity_prm;
                            $report[$projectMaterial->material->code_mat]['pending_material_in_cre'] += $projectMaterial->quantity_prm;
                        }
                        break;
                    case 'materials_additional_list'://******************CONTROL_IN
                        if((isset($reservationNumber) && $materialSummary->reservation_number_msu == $reservationNumber) || is_null($reservationNumber))
                        {
                            $report[$projectMaterial->material->code_mat]['materials_additional_list'] += $projectMaterial->quantity_prm;
                            $report[$projectMaterial->material->code_mat]['total_assigned'] += $projectMaterial->quantity_prm;
                            $report[$projectMaterial->material->code_mat]['pending_material_in_cre'] += $projectMaterial->quantity_prm;
                        }
                        break;
                    case 'materials_picked_up_from_cre'://******************IN
                        if((isset($reservationNumber) && $materialSummary->reservation_number_msu == $reservationNumber) || is_null($reservationNumber))
                        {
                            $report[$projectMaterial->material->code_mat]['materials_picked_up_from_cre'] += $projectMaterial->quantity_prm;
                            $report[$projectMaterial->material->code_mat]['pending_material_in_cre'] -= $projectMaterial->quantity_prm;
                            $report[$projectMaterial->material->code_mat]['quantity_in_warehouse'] += $projectMaterial->quantity_prm;
                        }
                        break;
                    case 'entry_by_conciliation_221'://******************IN
                        if((isset($reservationNumber) && $materialSummary->reservation_number_msu == $reservationNumber) || is_null($reservationNumber))
                        {
                            $report[$projectMaterial->material->code_mat]['entry_by_conciliation_221'] += $projectMaterial->quantity_prm;
                            $report[$projectMaterial->material->code_mat]['quantity_in_warehouse'] += $projectMaterial->quantity_prm;
                        }
                        break;
                    case 'builder_returns_materials'://******************IN
                        if($projectMaterial->status->code_mst == 'MEO')
                        {
                            $report[$projectMaterial->material->code_mat]['builder_returns_materials_meo'] += $projectMaterial->quantity_prm;
                        }
                        elseif($projectMaterial->status->code_mst == 'NVO')
                        {
                            $report[$projectMaterial->material->code_mat]['builder_returns_materials_nvo'] += $projectMaterial->quantity_prm;
                        }
                        $report[$projectMaterial->material->code_mat]['quantity_in_warehouse'] += $projectMaterial->quantity_prm;
                        break;
                    case 'materials_delivered_to_builder'://******************OUT
                        $report[$projectMaterial->material->code_mat]['materials_delivered_to_builder'] += $projectMaterial->quantity_prm;
                        $report[$projectMaterial->material->code_mat]['total_materials_delivered_to_builder'] += $projectMaterial->quantity_prm;
                        $report[$projectMaterial->material->code_mat]['quantity_in_warehouse'] -= $projectMaterial->quantity_prm;
                        break;
                    case 'materials_delivered_to_builder_loan'://******************OUT
                        $report[$projectMaterial->material->code_mat]['materials_delivered_to_builder_loan'] += $projectMaterial->quantity_prm;
                        $report[$projectMaterial->material->code_mat]['total_materials_delivered_to_builder'] += $projectMaterial->quantity_prm;
                        $report[$projectMaterial->material->code_mat]['quantity_in_warehouse'] -= $projectMaterial->quantity_prm;
                        break;
                    case 'out_by_conciliation_222'://******************OUT
                        if((isset($reservationNumber) && $materialSummary->reservation_number_msu == $reservationNumber) || is_null($reservationNumber))
                        {
                            $report[$projectMaterial->material->code_mat]['out_by_conciliation_222'] += $projectMaterial->quantity_prm;
                            $report[$projectMaterial->material->code_mat]['quantity_in_warehouse'] -= $projectMaterial->quantity_prm;
                        }
                        break;
                    case 'request_materials'://******************REQUEST
                        $report[$projectMaterial->material->code_mat]['request_materials'] += $projectMaterial->quantity_prm;
                        break;
                    
                }
            }
        }

        foreach ($report as &$row) 
        {
            $in = $row['materials_picked_up_from_cre'] + $row['builder_returns_materials_nvo'];
            $out = $row['materials_delivered_to_builder'] + $row['materials_delivered_to_builder_loan'];
            $row['total_used'] = $out - $row['builder_returns_materials_nvo'];
            if($in > $out)
            {
                $row['return_to_cre'] = $in - $out;    
            }
            elseif($out > $in)
            {
                $row['return_to_serebo'] = $out - $in;    
            }
        }
        return $report;
    }
}
