<?php

namespace App\Models;

use App\CustomLibraries\WorkflowPaginationHandler;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workflow extends Model
{
    use HasFactory;
    use SoftDeletes;
    use BlameableTrait;

    protected $casts = [
        //Datetime
        'entry_date_pro' => 'datetime',
        'folder_date_pro' => 'datetime',
        'cre_design_completion_date_pro' => 'datetime',
        'cre_building_completion_date_pro' => 'datetime',
        'schedule_start' => 'datetime',
        'schedule_end' => 'datetime',
        'stake_date' => 'datetime',
        'returned_date' => 'datetime',
        'digitization_date' => 'datetime',
        'drawing_date' => 'datetime',
        'schedule_date' => 'datetime',
        'ready_to_send_date' => 'datetime',
        'already_sent_date' => 'datetime',
        'approved_date' => 'datetime',
        'canceled_date' => 'datetime',
        'rectify_design_date' => 'datetime',
        'rectify_illustration_date' => 'datetime',
        'assign_to_date' => 'datetime',
        'start_date_assigned' => 'datetime',
        'end_date_assigned' => 'datetime',
        'in_progress_date' => 'datetime',
        'completed_date' => 'datetime',
        'paused_date' => 'datetime',
        'stopped_date' => 'datetime',
        'as_built_date' => 'datetime',
        'conciliation_reception_date' => 'datetime',
        'conciliation_shipment_date' => 'datetime',
        'cre_return_order_date' => 'datetime',
        'project_return_materials_date' => 'datetime',
        'project_return_materials2_date' => 'datetime',
        'project_energized_entry_date' => 'datetime',
        'payment_order_registered_date' => 'datetime',
        'payment_order_invoice_sent_date' => 'datetime',
        'payment_order_has_been_settled_date' => 'datetime',
        'status_log_manual_entry_date' => 'datetime',
        'record_building_materials_date' => 'datetime',
        'get_materials_date' => 'datetime',
        'deliver_materials_date' => 'datetime',
        'materials_reception_date' => 'datetime'
    ];

    protected $fillable = [
        "code_pro",
        "initial_contract_number_con",
        "work_area_pro",
        "detail_pro",
        "production_percentage",
        "detail_inc",
        "status_name_pst",
        "project_percentage_pro",
        "status_log_manual_entry_date",
        "static_days",
        "entry_date_pro",
        "folder_date_pro",
        "cre_fiscal_pro",
        "system_pro",
        "management_by_pro",
        "address_pro",
        "points_pro",
        "distance_pro",
        "quality_level_pro",
        "budgetary_position_pro",
        "cre_design_completion_date_pro",
        "cre_building_completion_date_pro",            
        "stake_date",
        "stake_responsible",
        "digitization_points_quantity",
        "digitization_distance",
        "rd_digitization_points_quantity",
        "rd_digitization_distance",
        "returned_date",
        "digitization_date",
        "drawing_date",
        "schedule_date",
        "schedule_start",
        "schedule_end",
        "schedule_design_budget",
        "already_sent_date",
        "approved_date",
        "canceled_date",
        "rectify_design_date",
        "rectify_illustration_date",
        "design_budget",
        "building_budget",
        "transportation_budget",
        "live_line_budget",
        "right_of_way_budget",
        "total_approved",
        "record_building_materials_date",
        "get_materials_date",
        "deliver_materials_date",
        "materials_reception_date",
        "assign_to_date",
        "live_line_assigned",
        "power_down_assigned",
        "maneuver_assigned",
        "builder_responsible",
        "fiscal_responsible",
        "start_date_assigned",
        "end_date_assigned",
        "estimated_time_assigned",
        "in_progress_date",
        "completed_date",
        "energized_pro",
        "project_energized_entry_date",
        "paused_date",
        "percentage_paused",
        "stopped_date",
        "percentage_stopped",
        "as_built_date",
        "as_built_points_quantity",
        "as_built_distance",
        "conciliation_reception_date",
        "conciliation_shipment_date",
        "cre_return_order_date",
        "project_return_materials_date",
        "payment_order_registered_date",
        "payment_order_registered_order_number",
        "payment_order_registered_design_budget",
        "payment_order_registered_transportation_budget",
        "payment_order_registered_live_line_budget",
        "payment_order_registered_building_budget",
        "payment_order_registered_right_of_way_budget",
        "payment_order_registered_total_real_budget",
        "payment_order_registered_invoice_number",
        "payment_order_invoice_sent_date",
        "payment_order_has_been_settled_date",
        "project_manager_assigned",
        "payment_status",
        "project_return_materials2_date",
        "in_progress_first_detail_date",
        'ready_to_send_date' => 'datetime',
        'project_current_budget' => 'datetime',
        'production_total_bs' => 'datetime',
        'final_contract_number_con' => 'datetime',
        'minor_enlargement'
    ];

    public static function updateAllData($projectIds = '')
    {
        //First let's delete all data
        Workflow::truncate();
        $newWorkflow = new Workflow();
        $fillable = $newWorkflow->getFillable();
        $paginationHandler = new WorkflowPaginationHandler(10000, 0);
        if($projectIds != "")
        {
            $paginationHandler->setAdditionalParameters(['id-list' => $projectIds]);
        }
        
        // $paginationHandler->setColumnsToShow($fillable);
        $projects = $paginationHandler->getAll();
        dd($projects);
        $sections = array_chunk($projects, 500);
        foreach ($sections as $section) 
        {
            $upsertData = [];
            foreach ($section as $value) 
            {
                $upsertData[] = (array)$value;
            }
            Workflow::upsert($upsertData, ['id_pro']);
        }
        
        // $migration = "";
        // foreach ($projects[0] as $key => $value) 
        // {
        //     $migration .= " \$table->string(\"$key\");\n";
        // }

        // dd((array)$projects[0], $fillable, $migration);
    }
}
