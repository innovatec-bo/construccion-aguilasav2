<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWflProjectPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wfl_project_points', function (Blueprint $table) {
            $table->bigInteger('id_prp')->primary();
            $table->bigInteger('status_log_id_prp')->nullable();
            $table->smallInteger('points_quantity_prp')->nullable();
            $table->double('distance_prp')->nullable();
            $table->smallInteger('deleted_prp')->nullable();
            $table->dateTime('createdon_prp')->nullable();
            $table->bigInteger('createdby_prp')->nullable();
            $table->dateTime('editedon_prp')->nullable();
            $table->bigInteger('editedby_prp')->nullable();
            
            $table->foreign('status_log_id_prp', 'FK_3E5BD4236CB18474')->references('id_psl')->on('wfl_project_status_log');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wfl_project_points');
    }
}
