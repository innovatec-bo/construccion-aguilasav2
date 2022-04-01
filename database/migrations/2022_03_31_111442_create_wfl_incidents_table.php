<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWflIncidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wfl_incidents', function (Blueprint $table) {
            $table->bigInteger('id_inc')->primary();
            $table->bigInteger('project_id_inc')->nullable();
            $table->bigInteger('status_id_inc')->nullable();
            $table->smallInteger('percentage_inc')->nullable();
            $table->text('detail_inc')->nullable();
            $table->dateTime('manual_entry_date_inc')->nullable();
            $table->smallInteger('paused_inc')->nullable();
            $table->smallInteger('stopped_inc')->nullable();
            $table->integer('incident_type_inc')->nullable();
            $table->smallInteger('need_to_be_solved_inc')->nullable();
            $table->dateTime('solved_on_date_inc')->nullable();
            $table->bigInteger('solved_by_inc')->nullable();
            $table->smallInteger('deleted_inc')->default(0);
            $table->dateTime('createdon_inc')->nullable();
            $table->bigInteger('createdby_inc')->nullable();
            $table->dateTime('editedon_inc')->nullable();
            $table->bigInteger('editedby_inc')->nullable();
            
            $table->foreign('project_id_inc', 'FK_1D150DF21E825C66')->references('id_pro')->on('wfl_projects');
            $table->foreign('status_id_inc', 'FK_1D150DF2B46C1F61')->references('id_pst')->on('wfl_project_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wfl_incidents');
    }
}
