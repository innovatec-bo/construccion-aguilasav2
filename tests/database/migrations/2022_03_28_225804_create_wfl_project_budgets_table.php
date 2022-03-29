<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWflProjectBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wfl_project_budgets', function (Blueprint $table) {
            $table->bigInteger('id_prb')->primary();
            $table->bigInteger('status_log_id_prb')->nullable();
            $table->double('design_prb')->nullable();
            $table->double('building_prb')->nullable();
            $table->string('graph_number_prb', 20)->nullable();
            $table->string('reservation_number_prb', 20)->nullable();
            $table->double('transportation_prb')->nullable();
            $table->double('live_line_prb')->nullable();
            $table->double('right_of_way_prb')->nullable();
            $table->double('tentative_total_budget_prb')->nullable();
            $table->bigInteger('manpower_file_id_prb')->nullable();
            $table->bigInteger('building_structure_file_id_prb')->nullable();
            $table->bigInteger('materials_file_id_prb')->nullable();
            $table->smallInteger('trim_tree_prb')->nullable();
            $table->smallInteger('deleted_prb')->default(0);
            $table->dateTime('createdon_prb')->nullable();
            $table->bigInteger('createdby_prb')->nullable();
            $table->dateTime('editedon_prb')->default('2018-01-01 01:00:00');
            $table->bigInteger('editedby_prb')->nullable();
            
            $table->foreign('status_log_id_prb', 'FK_3C669D0C9F08F53C')->references('id_psl')->on('wfl_project_status_log');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wfl_project_budgets');
    }
}
