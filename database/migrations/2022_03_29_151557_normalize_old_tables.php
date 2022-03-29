<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NormalizeOldTables extends Migration
{
    private $_oldTables = [
        'sec_roles',
        'mat_internal_warehouse_operations',
        'wfl_project_status_log',
        'wfl_incidents',
        'bui_building_structures',
        'mat_materials_summary',
        'wfl_warehouse_setup',
        'wfl_work_plans',
        'mat_material_status',
        'bui_blocked_log_date_ranges',
        'sec_executive_summary_log',
        'bui_labor_cost',
        'wfl_external_fiscal_observations',
        'bui_labor_details',
        'mat_materials_summary_types',
        'mat_internals',
        'sec_user_supervisor_by_period',
        'wfl_project_stakes',
        'bui_custom_structure_materials',
        'wfl_work_plan_dates',
        'bui_building_points',
        'wfl_project_status',
        'sec_users',
        'wfl_workflow_column_groups',
        'base_table',
        'sec_features',
        'bui_builders_in_manpower',
        'wfl_production_limits',
        'sys_files',
        'wfl_project_budgets',
        'wfl_stakes_team_leader',
        'wfl_dates_to_work',
        'mat_materials',
        'wfl_status_log_responsibles',
        'bui_labor_cost_log',
        'wfl_payment_orders_projects',
        'mat_material_tensions',
        'mat_projects_materials',
        'bui_structure_by_points',
        'wfl_project_real_budgets',
        'wfl_project_status_files',
        'wfl_construction_assignments',
        'bui_worked_up_structures',
        'wfl_status_line_management',
        'bui_point_to_point_master',
        'wfl_cre_fiscal',
        'sec_deleted_status_logs',
        'wfl_project_points',
        'bui_default_structure_materials',
        'wfl_process_line',
        'sec_userroles',
        'sec_permissions',
        'wfl_tracking_list',
        'wfl_user_ubmos',
        'wfl_warehouses',
        'wfl_contracts',
        'wfl_warehouse_status_log',
        'wfl_payment_orders',
        'wfl_projects',
        'mat_internal_warehouse_operation_types',
        'wfl_status_responsibles',
        'wfl_payment_orders_status_log'
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->_oldTables as $oldTable) 
        {
            Schema::table($oldTable, function(Blueprint $table) {
                $table->softDeletes();
                $table->blameable(true);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->_oldTables as $oldTable) 
        {
            Schema::table($oldTable, function(Blueprint $table) {
                $table->dropSoftDeletes();
                $table->dropColumn(['created_by','updated_by','deleted_by']);
            });
        }
    }
}
