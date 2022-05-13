<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampsToOldTables extends Migration
{
    private $_oldTables = [
        ['sec_roles', 'id_rol','editedon_rol'],
        ['mat_internal_warehouse_operations', 'id_iwo','editedon_iwo'],
        ['wfl_project_status_log', 'id_psl','editedon_psl'],
        ['wfl_incidents', 'id_inc','editedon_inc'],
        ['bui_building_structures', 'id_bus','editedon_bus'],
        ['mat_materials_summary', 'id_msu','editedon_msu'],
        ['wfl_warehouse_setup', 'id_wsu','editedon_wsu'],
        ['wfl_work_plans', 'id_wpl','editedon_wpl'],
        ['mat_material_status', 'id_mst','editedon_mst'],
        ['bui_blocked_log_date_ranges', 'id_bld','editedon_bld'],
        ['sec_executive_summary_log', 'id_esl','editedon_esl'],
        ['bui_labor_cost', 'id_lac','editedon_lac'],
        ['wfl_external_fiscal_observations', 'id_efo','editedon_efo'],
        ['bui_labor_details', 'id_lad','editedon_lad'],
        ['mat_materials_summary_types', 'id_mqt','editedon_mqt'],
        ['mat_internals', 'id_int','editedon_int'],
        ['sec_user_supervisor_by_period', 'id_usp','editedon_usp'],
        ['wfl_project_stakes', 'id_prs','editedon_prs'],
        ['bui_custom_structure_materials', 'id_csm','editedon_csm'],
        ['wfl_work_plan_dates', 'id_wpd','editedon_wpd'],
        ['bui_building_points', 'id_bpo','editedon_bpo'],
        ['wfl_project_status', 'id_pst','editedon_pst'],
        ['sec_users', 'id_usr','editedon_usr'],
        ['wfl_workflow_column_groups', 'id_wcg','editedon_wcg'],
        ['base_table', 'id_','editedon_'],
        ['sec_features', 'id_fes','editedon_fes'],
        ['bui_builders_in_manpower', 'id_bim','editedon_bim'],
        ['wfl_production_limits', 'id_prl','editedon_prl'],
        ['sys_files', 'id_fil','editedon_fil'],
        ['wfl_project_budgets', 'id_prb','editedon_prb'],
        ['wfl_stakes_team_leader', 'id_stl','editedon_stl'],
        ['wfl_dates_to_work', 'id_wpl','editedon_wpl'],
        ['mat_materials', 'id_mat','editedon_mat'],
        ['wfl_status_log_responsibles', 'id_slr','editedon_slr'],
        ['bui_labor_cost_log', 'id_lal','editedon_lal'],
        ['wfl_payment_orders_projects', 'id_pop','editedon_pop'],
        ['mat_material_tensions', 'id_mte','editedon_mte'],
        ['mat_projects_materials', 'id_prm','editedon_prm'],
        ['bui_structure_by_points', 'id_sbp','editedon_sbp'],
        ['wfl_project_real_budgets', 'id_reb','editedon_reb'],
        ['wfl_project_status_files', 'id_psf','editedon_psf'],
        ['wfl_construction_assignments', 'id_cas','editedon_cas'],
        ['bui_worked_up_structures', 'id_wus','editedon_wus'],
        ['wfl_status_line_management', 'id_','editedon_'],
        ['bui_point_to_point_master', 'id_ptp','editedon_ptp'],
        ['wfl_cre_fiscal', 'id_cfi','editedon_cfi'],
        ['sec_deleted_status_logs', 'id_dsl','editedon_dsl'],
        ['wfl_project_points', 'id_prp','editedon_prp'],
        ['bui_default_structure_materials', 'id_dsm','editedon_dsm'],
        ['wfl_process_line', 'id_prl','editedon_prl'],
        ['sec_userroles', 'id_uro','editedon_uro'],
        ['sec_permissions', 'id_per','editedon_per'],
        ['wfl_tracking_list', 'id_trl','editedon_trl'],
        ['wfl_user_ubmos', 'id_uub','editedon_uub'],
        ['wfl_warehouses', 'id_war','editedon_war'],
        ['wfl_contracts', 'id_con','editedon_con'],
        ['wfl_warehouse_status_log', 'id_wsl','editedon_wsl'],
        ['wfl_payment_orders', 'id_pao','editedon_pao'],
        ['wfl_projects', 'id_pro','editedon_pro'],
        ['mat_internal_warehouse_operation_types', 'id_oty','editedon_oty'],
        ['wfl_status_responsibles', 'id_sre','editedon_sre'],
        ['wfl_payment_orders_status_log', 'id_pos','editedon_pos']
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        foreach ($this->_oldTables as $oldTable) 
        {
            Schema::table($oldTable[0], function(Blueprint $table) use($oldTable) {
                $table->timestamps();
            });
        }
        Schema::enableForeignKeyConstraints();
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
            Schema::table($oldTable[0], function(Blueprint $table) use($oldTable) {
                $table->dropTimestamps();
            });
        }
    }
}
