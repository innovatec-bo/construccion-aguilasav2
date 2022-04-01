<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWflConstructionAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wfl_construction_assignments', function (Blueprint $table) {
            $table->bigInteger('id_cas')->primary();
            $table->bigInteger('status_log_id_cas')->nullable();
            $table->dateTime('start_date_cas')->nullable();
            $table->dateTime('end_date_cas')->nullable();
            $table->smallInteger('estimated_time_cas')->nullable();
            $table->smallInteger('live_line_cas')->nullable();
            $table->smallInteger('power_down_cas')->nullable();
            $table->smallInteger('maneuver_cas')->nullable();
            $table->bigInteger('project_manager_cas')->nullable();
            $table->smallInteger('deleted_cas')->default(0);
            $table->dateTime('createdon_cas')->nullable();
            $table->bigInteger('createdby_cas')->nullable();
            $table->dateTime('editedon_cas')->nullable();
            $table->bigInteger('editedby_cas')->nullable();
            
            $table->foreign('status_log_id_cas', 'FK_FCB072038A378975')->references('id_psl')->on('wfl_project_status_log');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wfl_construction_assignments');
    }
}
