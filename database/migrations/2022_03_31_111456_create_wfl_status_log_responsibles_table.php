<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWflStatusLogResponsiblesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wfl_status_log_responsibles', function (Blueprint $table) {
            $table->bigInteger('id_slr')->primary();
            $table->bigInteger('status_log_id_slr')->nullable();
            $table->bigInteger('responsible_id_slr')->nullable();
            $table->smallInteger('deleted_slr')->default(0);
            $table->dateTime('createdon_slr')->nullable();
            $table->bigInteger('createdby_slr')->nullable();
            $table->dateTime('editedon_slr')->nullable();
            $table->bigInteger('editedby_slr')->nullable();
            
            $table->foreign('status_log_id_slr', 'FK_482963F354B864DE')->references('id_psl')->on('wfl_project_status_log');
            $table->foreign('responsible_id_slr', 'FK_482963F3590FA3EE')->references('id_sre')->on('wfl_status_responsibles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wfl_status_log_responsibles');
    }
}
