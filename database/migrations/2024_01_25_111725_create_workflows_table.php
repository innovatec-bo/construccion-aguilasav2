<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Type\Decimal;

class CreateWorkflowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workflows', function (Blueprint $table) {
            $table->id();
            $table->integer("id_pro")->unique()->nullable()->default(null);
            $table->string("energized_pro",5)->nullable()->default(null);
            $table->string("work_area_pro",5)->nullable()->default(null);
            $table->integer("project_status_id", false, 3)->nullable()->default(null);
            $table->integer("project_percentage_pro", false, 3)->nullable()->default(null);
            $table->string("code_pro",15)->nullable()->default(null);
            $table->string("secondary_code_pro",15)->nullable()->default(null);
            $table->string("detail_pro")->nullable()->default(null);
            $table->integer("budgetary_position_pro", false,3)->nullable()->default(null);
            $table->dateTime("entry_date_pro")->nullable()->default(null);
            $table->dateTime("folder_date_pro")->nullable()->default(null);
            $table->string("minor_enlargement", false,15)->nullable()->default(null);
            $table->integer("end_contract_pro")->nullable()->default(null);
            $table->string("system_pro", 30)->nullable()->default(null);
            $table->string("management_by_pro", 30)->nullable()->default(null);
            $table->string("address_pro", 50)->nullable()->default(null);
            $table->decimal("points_pro")->nullable()->default(null);
            $table->decimal("distance_pro")->nullable()->default(null);
            $table->integer("quality_level_pro", false,3)->nullable()->default(null);
            $table->string("project_latitude",20)->nullable()->default(null);
            $table->string("project_longitude",20)->nullable()->default(null);
            $table->dateTime("cre_design_completion_date_pro")->nullable()->default(null);
            $table->dateTime("cre_building_completion_date_pro")->nullable()->default(null);
            $table->dateTime("schedule_start")->nullable()->default(null);
            $table->dateTime("schedule_end")->nullable()->default(null);
            $table->dateTime("stake_date")->nullable()->default(null);
            $table->string("stake_responsible", 30)->nullable()->default(null);
            $table->decimal("rd_digitization_points_quantity")->nullable()->default(null);
            $table->decimal("rd_digitization_distance")->nullable()->default(null);
            $table->dateTime("returned_date")->nullable()->default(null);
            $table->decimal("digitization_points_quantity")->nullable()->default(null);
            $table->decimal("digitization_distance")->nullable()->default(null);
            $table->dateTime("digitization_date")->nullable()->default(null);
            $table->dateTime("drawing_date")->nullable()->default(null);
            $table->dateTime("schedule_date")->nullable()->default(null);
            $table->decimal("schedule_design_budget", 10,2)->nullable()->default(null);
            $table->decimal("project_current_budget", 10,2)->nullable()->default(null);
            $table->dateTime("ready_to_send_date")->nullable()->default(null);
            $table->dateTime("already_sent_date")->nullable()->default(null);
            $table->dateTime("approved_date")->nullable()->default(null);
            $table->decimal("design_budget", 10, 2)->nullable()->default(null);
            $table->decimal("building_budget", 10, 2)->nullable()->default(null);
            $table->decimal("transportation_budget", 10, 2)->nullable()->default(null);
            $table->decimal("live_line_budget", 10, 2)->nullable()->default(null);
            $table->decimal("right_of_way_budget", 10, 2)->nullable()->default(null);
            $table->decimal("total_approved", 10, 2)->nullable()->default(null);
            $table->string("live_line_assigned", 5)->nullable()->default(null);
            $table->string("project_manager_assigned", 50)->nullable()->default(null);
            $table->decimal("production_percentage")->nullable()->default(null);
            $table->dateTime("canceled_date")->nullable()->default(null);
            $table->dateTime("rectify_design_date")->nullable()->default(null);
            $table->dateTime("rectify_illustration_date")->nullable()->default(null);
            $table->dateTime("assign_to_date")->nullable()->default(null);
            $table->string("fiscal_responsible", 50)->nullable()->default(null);
            $table->string("power_down_assigned", 5)->nullable()->default(null);
            $table->string("maneuver_assigned", 5)->nullable()->default(null);
            $table->dateTime("start_date_assigned")->nullable()->default(null);
            $table->dateTime("end_date_assigned")->nullable()->default(null);
            $table->smallInteger("estimated_time_assigned", false, 6)->nullable()->default(null);
            $table->string("builder_responsible", 50)->nullable()->default(null);
            $table->dateTime("in_progress_date")->nullable()->default(null);
            $table->string("in_progress_first_detail_date")->nullable()->default(null);
            $table->dateTime("completed_date")->nullable()->default(null);
            $table->dateTime("paused_date")->nullable()->default(null);
            $table->decimal("percentage_paused")->nullable()->default(null);
            $table->dateTime("stopped_date")->nullable()->default(null);
            $table->decimal("percentage_stopped")->nullable()->default(null);
            $table->dateTime("as_built_date")->nullable()->default(null);
            $table->decimal("as_built_points_quantity")->nullable()->default(null);
            $table->decimal("as_built_distance")->nullable()->default(null);
            $table->dateTime("conciliation_reception_date")->nullable()->default(null);
            $table->dateTime("conciliation_shipment_date")->nullable()->default(null);
            $table->decimal("payment_order_registered_design_budget", 10,2)->nullable()->default(null);
            $table->decimal("payment_order_registered_building_budget", 10,2)->nullable()->default(null);
            $table->decimal("payment_order_registered_transportation_budget", 10,2)->nullable()->default(null);
            $table->decimal("payment_order_registered_live_line_budget", 10,2)->nullable()->default(null);
            $table->decimal("payment_order_registered_right_of_way_budget", 10,2)->nullable()->default(null);
            $table->decimal("payment_order_registered_total_real_budget", 10,2)->nullable()->default(null);
            $table->dateTime("cre_return_order_date")->nullable()->default(null);
            $table->dateTime("project_return_materials_date")->nullable()->default(null);
            $table->dateTime("project_return_materials2_date")->nullable()->default(null);
            $table->dateTime("project_energized_entry_date")->nullable()->default(null);
            $table->dateTime("payment_order_registered_date")->nullable()->default(null);
            $table->string("payment_order_registered_order_number", 20)->nullable()->default(null);
            $table->string("payment_status", 50)->nullable()->default(null);
            $table->string("payment_order_registered_invoice_number", 30)->nullable()->default(null);
            $table->dateTime("payment_order_invoice_sent_date")->nullable()->default(null);
            $table->dateTime("payment_order_has_been_settled_date")->nullable()->default(null);
            $table->string("status_name_pst", 50)->nullable()->default(null);
            $table->string("cre_fiscal_pro", 50)->nullable()->default(null);
            $table->string("initial_contract_number_con", 30)->nullable()->default(null);
            $table->string("final_contract_number_con",30)->nullable()->default(null);
            $table->smallInteger("static_days")->nullable()->default(null);
            $table->dateTime("status_log_manual_entry_date")->nullable()->default(null);
            $table->string("detail_inc")->nullable()->default(null);
            $table->decimal("production_total_bs", 10, 2)->nullable()->default(null);
            $table->dateTime("record_building_materials_date")->nullable()->default(null);
            $table->dateTime("get_materials_date")->nullable()->default(null);
            $table->dateTime("deliver_materials_date")->nullable()->default(null);
            $table->dateTime("materials_reception_date")->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
            $table->blameable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workflows');
    }
}
