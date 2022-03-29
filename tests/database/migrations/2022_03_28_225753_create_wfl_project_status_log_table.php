<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWflProjectStatusLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wfl_project_status_log', function (Blueprint $table) {
            $table->bigInteger('id_psl')->primary();
            $table->bigInteger('project_id_psl')->nullable();
            $table->bigInteger('status_id_psl')->nullable();
            $table->text('log_detail_psl')->nullable();
            $table->dateTime('manual_entry_date_psl')->nullable();
            $table->smallInteger('deleted_psl')->default(0);
            $table->dateTime('createdon_psl')->nullable();
            $table->bigInteger('createdby_psl')->nullable();
            $table->dateTime('editedon_psl')->default('2018-01-01 01:00:00');
            $table->bigInteger('editedby_psl')->nullable();
            
            $table->foreign('project_id_psl', 'FK_7CC8190862A6B514')->references('id_pro')->on('wfl_projects');
            $table->foreign('status_id_psl', 'FK_7CC81908C848F613')->references('id_pst')->on('wfl_project_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wfl_project_status_log');
    }
}
