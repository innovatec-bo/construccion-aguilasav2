<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('workflows', function (Blueprint $table) {

            $table->id();

            // ─── Proyecto base (wfl_projects) ────────────────────────────────
            $table->integer('id_pro')->unique()->nullable()->default(null);
            $table->string('energized_pro', 5)->nullable()->default(null);
            $table->string('work_area_pro', 10)->nullable()->default(null);
            $table->integer('project_status_id')->nullable()->default(null);
            $table->integer('project_percentage_pro')->nullable()->default(null);
            $table->string('code_pro', 20)->nullable()->default(null);
            $table->string('secondary_code_pro', 20)->nullable()->default(null);
            $table->string('detail_pro')->nullable()->default(null);
            $table->integer('budgetary_position_pro')->nullable()->default(null);
            $table->dateTime('entry_date_pro')->nullable()->default(null);
            $table->dateTime('folder_date_pro')->nullable()->default(null);
            $table->string('minor_enlargement', 15)->nullable()->default(null);
            $table->integer('end_contract_pro')->nullable()->default(null);
            $table->string('system_pro', 30)->nullable()->default(null);
            $table->string('management_by_pro', 30)->nullable()->default(null);
            $table->string('address_pro', 100)->nullable()->default(null);
            $table->decimal('points_pro', 10, 2)->nullable()->default(null);
            $table->decimal('distance_pro', 10, 2)->nullable()->default(null);
            $table->integer('quality_level_pro')->nullable()->default(null);
            $table->string('project_latitude', 20)->nullable()->default(null);
            $table->string('project_longitude', 20)->nullable()->default(null);
            $table->dateTime('cre_design_completion_date_pro')->nullable()->default(null);
            $table->dateTime('cre_building_completion_date_pro')->nullable()->default(null);
            $table->dateTime('schedule_start')->nullable()->default(null);
            $table->dateTime('schedule_end')->nullable()->default(null);

            // ─── Estado del proyecto (wfl_project_status) ────────────────────
            $table->string('status_name_pst', 50)->nullable()->default(null);
            $table->string('keyword_pst', 50)->nullable()->default(null);       // CRÍTICO para filtros
            $table->integer('order_pst')->nullable()->default(null);

            // ─── Log de estado actual ─────────────────────────────────────────
            $table->dateTime('status_log_manual_entry_date')->nullable()->default(null);
            $table->string('responsible', 100)->nullable()->default(null);
            $table->integer('static_days')->nullable()->default(null);          // TIMESTAMPDIFF puede ser grande

            // ─── Stakes (status 2) ───────────────────────────────────────────
            $table->dateTime('stake_date')->nullable()->default(null);
            $table->string('stake_responsible_user_id', 50)->nullable()->default(null);
            $table->string('stake_responsible', 100)->nullable()->default(null);

            // ─── RD Digitization (status 16) ─────────────────────────────────
            $table->decimal('rd_digitization_points_quantity', 10, 2)->nullable()->default(null);
            $table->decimal('rd_digitization_distance', 10, 2)->nullable()->default(null);

            // ─── Returned (status 20) ────────────────────────────────────────
            $table->dateTime('returned_date')->nullable()->default(null);

            // ─── Digitization (status 3) ─────────────────────────────────────
            $table->decimal('digitization_points_quantity', 10, 2)->nullable()->default(null);
            $table->decimal('digitization_distance', 10, 2)->nullable()->default(null);
            $table->dateTime('digitization_date')->nullable()->default(null);

            // ─── Drawing (status 5) ──────────────────────────────────────────
            $table->dateTime('drawing_date')->nullable()->default(null);

            // ─── Schedule (status 6) ─────────────────────────────────────────
            $table->dateTime('schedule_date')->nullable()->default(null);
            $table->tinyInteger('trim_tree')->nullable()->default(null);
            $table->decimal('schedule_design_budget', 10, 2)->nullable()->default(null);
            $table->decimal('schedulee_tentative_total_budget', 10, 2)->nullable()->default(null);

            // ─── Presupuesto actual calculado ─────────────────────────────────
            $table->decimal('project_current_budget', 10, 2)->nullable()->default(null);
            $table->decimal('project_current_design_budget', 10, 2)->nullable()->default(null);

            // ─── Ready to send (status 9) ────────────────────────────────────
            $table->dateTime('ready_to_send_date')->nullable()->default(null);

            // ─── Already sent (status 10) ────────────────────────────────────
            $table->dateTime('already_sent_date')->nullable()->default(null);

            // ─── Approved (status 11) ────────────────────────────────────────
            $table->dateTime('approved_date')->nullable()->default(null);
            $table->string('approved_reservation_number', 50)->nullable()->default(null);
            $table->string('approved_graph_number', 50)->nullable()->default(null);
            $table->decimal('design_budget', 10, 2)->nullable()->default(null);
            $table->decimal('building_budget', 10, 2)->nullable()->default(null);
            $table->decimal('transportation_budget', 10, 2)->nullable()->default(null);
            $table->decimal('live_line_budget', 10, 2)->nullable()->default(null);
            $table->decimal('right_of_way_budget', 10, 2)->nullable()->default(null);
            $table->decimal('total_approved', 10, 2)->nullable()->default(null);
            $table->unsignedBigInteger('manpower_file_id')->nullable()->default(null);
            $table->string('live_line_assigned', 5)->nullable()->default(null);
            $table->unsignedBigInteger('construction_assignment_id')->nullable()->default(null);
            $table->unsignedBigInteger('project_manager_user_id')->nullable()->default(null);
            $table->string('project_manager_assigned', 100)->nullable()->default(null);

            // ─── Producción ──────────────────────────────────────────────────
            $table->decimal('production_percentage', 10, 2)->nullable()->default(null);
            $table->decimal('production_total_bs', 10, 2)->nullable()->default(null);

            // ─── Canceled (status 12) ────────────────────────────────────────
            $table->dateTime('canceled_date')->nullable()->default(null);

            // ─── Rectify design (status 13) ──────────────────────────────────
            $table->dateTime('rectify_design_date')->nullable()->default(null);

            // ─── Rectify illustration (status 14) ────────────────────────────
            $table->dateTime('rectify_illustration_date')->nullable()->default(null);

            // ─── Assign to (status 21) ───────────────────────────────────────
            $table->dateTime('assign_to_date')->nullable()->default(null);
            $table->string('assign_to_responsible', 100)->nullable()->default(null);
            $table->string('fiscal_responsible_id', 50)->nullable()->default(null);
            $table->string('fiscal_responsible', 100)->nullable()->default(null);
            $table->string('power_down_assigned', 5)->nullable()->default(null);
            $table->string('maneuver_assigned', 5)->nullable()->default(null);
            $table->dateTime('start_date_assigned')->nullable()->default(null);
            $table->dateTime('end_date_assigned')->nullable()->default(null);
            $table->integer('estimated_time_assigned')->nullable()->default(null);

            // ─── In progress (status 29) ─────────────────────────────────────
            $table->dateTime('in_progress_date')->nullable()->default(null);
            $table->dateTime('in_progress_first_detail_date')->nullable()->default(null);  // FIX: era string
            $table->string('builder_responsible', 100)->nullable()->default(null);
            $table->string('builder_responsible_id', 50)->nullable()->default(null);
            $table->unsignedBigInteger('builder_responsible_user_id')->nullable()->default(null);

            // ─── Completed (status 32) ───────────────────────────────────────
            $table->dateTime('completed_date')->nullable()->default(null);

            // ─── Paused (status 31) ──────────────────────────────────────────
            $table->dateTime('paused_date')->nullable()->default(null);
            $table->decimal('percentage_paused', 5, 2)->nullable()->default(null);

            // ─── Stopped (status 30) ─────────────────────────────────────────
            $table->dateTime('stopped_date')->nullable()->default(null);
            $table->decimal('percentage_stopped', 5, 2)->nullable()->default(null);

            // ─── As built (status 33) ────────────────────────────────────────
            $table->dateTime('as_built_date')->nullable()->default(null);
            $table->decimal('as_built_points_quantity', 10, 2)->nullable()->default(null);
            $table->decimal('as_built_distance', 10, 2)->nullable()->default(null);

            // ─── Conciliation reception (status 34) ──────────────────────────
            $table->dateTime('conciliation_reception_date')->nullable()->default(null);

            // ─── Conciliation shipment (status 35) ───────────────────────────
            $table->dateTime('conciliation_shipment_date')->nullable()->default(null);

            // ─── CRE return order (status 37) ────────────────────────────────
            $table->dateTime('cre_return_order_date')->nullable()->default(null);

            // ─── Project return materials (status 38) ────────────────────────
            $table->dateTime('project_return_materials_date')->nullable()->default(null);

            // ─── Project return materials 2 (status 39) ──────────────────────
            $table->dateTime('project_return_materials2_date')->nullable()->default(null);

            // ─── Project energized (status 47) ───────────────────────────────
            $table->dateTime('project_energized_entry_date')->nullable()->default(null);

            // ─── Payment order registered (status 42) ────────────────────────
            $table->dateTime('payment_order_registered_date')->nullable()->default(null);
            $table->string('payment_order_registered_order_number', 20)->nullable()->default(null);
            $table->string('payment_order_registered_contract_number', 30)->nullable()->default(null);  // FALTABA
            $table->string('payment_status', 50)->nullable()->default(null);
            $table->string('payment_order_registered_invoice_number', 30)->nullable()->default(null);
            $table->decimal('payment_order_registered_design_budget', 10, 2)->nullable()->default(null);
            $table->decimal('payment_order_registered_building_budget', 10, 2)->nullable()->default(null);
            $table->decimal('payment_order_registered_transportation_budget', 10, 2)->nullable()->default(null);
            $table->decimal('payment_order_registered_live_line_budget', 10, 2)->nullable()->default(null);
            $table->decimal('payment_order_registered_right_of_way_budget', 10, 2)->nullable()->default(null);
            $table->decimal('payment_order_registered_total_real_budget', 10, 2)->nullable()->default(null);

            // ─── Payment order invoice sent (status 43) ──────────────────────
            $table->dateTime('payment_order_invoice_sent_date')->nullable()->default(null);

            // ─── Payment order settled (status 44) ───────────────────────────
            $table->dateTime('payment_order_has_been_settled_date')->nullable()->default(null);

            // ─── Fiscal CRE ──────────────────────────────────────────────────
            $table->unsignedBigInteger('cre_fiscal_id')->nullable()->default(null);         // FALTABA
            $table->string('cre_fiscal_pro', 100)->nullable()->default(null);
            $table->string('cre_fiscal_email', 100)->nullable()->default(null);             // FALTABA

            // ─── Contratos ───────────────────────────────────────────────────
            $table->unsignedBigInteger('initial_id_con')->nullable()->default(null);        // FALTABA
            $table->string('initial_contract_number_con', 30)->nullable()->default(null);
            $table->unsignedBigInteger('final_id_con')->nullable()->default(null);          // FALTABA
            $table->string('final_contract_number_con', 30)->nullable()->default(null);

            // ─── Incidentes ──────────────────────────────────────────────────
            $table->decimal('percentage_inc', 5, 2)->nullable()->default(null);             // FALTABA
            $table->string('detail_inc')->nullable()->default(null);
            $table->decimal('last_week_percentage', 5, 2)->nullable()->default(null);       // FALTABA
            $table->decimal('previous_percentage', 5, 2)->nullable()->default(null);        // FALTABA
            $table->dateTime('previous_manual_entry_date')->nullable()->default(null);       // FALTABA
            $table->text('last_three_incidents')->nullable()->default(null);                 // FALTABA - texto con saltos de línea

            // ─── Materiales ──────────────────────────────────────────────────
            $table->decimal('quantity_picked_up_from_cre', 10, 2)->nullable()->default(null);   // FALTABA
            $table->decimal('materials_delivered_to_cre', 10, 2)->nullable()->default(null);    // FALTABA
            $table->decimal('quantity_materials_assigned', 10, 2)->nullable()->default(null);   // FALTABA
            $table->decimal('pending_material_in_cre', 10, 2)->nullable()->default(null);       // FALTABA

            // ─── Campos placeholder (siempre vacíos en el handler original) ──
            $table->string('record_building_materials_date')->nullable()->default(null);
            $table->string('get_materials_date')->nullable()->default(null);
            $table->string('deliver_materials_date')->nullable()->default(null);
            $table->string('materials_reception_date')->nullable()->default(null);

            // ─── Timestamps y auditoría ──────────────────────────────────────
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();

            // ─── Índices para filtros frecuentes ─────────────────────────────
            $table->index('project_status_id');
            $table->index('keyword_pst');
            $table->index('work_area_pro');
            $table->index('end_contract_pro');
            $table->index('cre_fiscal_id');
            $table->index('fiscal_responsible_id');
            $table->index('builder_responsible_id');
            $table->index('energized_pro');
            $table->index('system_pro');
            $table->index('management_by_pro');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workflows');
    }
};