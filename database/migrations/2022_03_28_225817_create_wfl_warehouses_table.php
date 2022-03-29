<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWflWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wfl_warehouses', function (Blueprint $table) {
            $table->bigInteger('id_war')->primary();
            $table->bigInteger('status_id_war')->nullable();
            $table->bigInteger('project_id_war')->nullable();
            $table->smallInteger('deleted_war')->default(0);
            $table->dateTime('createdon_war')->nullable();
            $table->bigInteger('createdby_war')->nullable();
            $table->dateTime('editedon_war')->default('2018-01-01 01:00:00');
            $table->bigInteger('editedby_war')->nullable();
            
            $table->foreign('status_id_war', 'FK_7A72C76B4FFCAD26')->references('id_pst')->on('wfl_project_status');
            $table->foreign('project_id_war', 'FK_7A72C76BE512EE21')->references('id_pro')->on('wfl_projects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wfl_warehouses');
    }
}
