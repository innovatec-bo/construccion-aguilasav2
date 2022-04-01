<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWflWarehouseStatusLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wfl_warehouse_status_log', function (Blueprint $table) {
            $table->bigInteger('id_wsl')->primary();
            $table->bigInteger('warehouse_id_wsl')->nullable();
            $table->bigInteger('status_id_wsl')->nullable();
            $table->text('log_detail_wsl')->nullable();
            $table->dateTime('manual_entry_date_wsl')->nullable();
            $table->smallInteger('deleted_wsl')->default(0);
            $table->dateTime('createdon_wsl')->nullable();
            $table->bigInteger('createdby_wsl')->nullable();
            $table->dateTime('editedon_wsl')->nullable();
            $table->bigInteger('editedby_wsl')->nullable();
            
            $table->foreign('warehouse_id_wsl', 'FK_8E1AADF9951997AA')->references('id_pro')->on('wfl_projects');
            $table->foreign('status_id_wsl', 'FK_8E1AADF9CD07E096')->references('id_pst')->on('wfl_project_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wfl_warehouse_status_log');
    }
}
