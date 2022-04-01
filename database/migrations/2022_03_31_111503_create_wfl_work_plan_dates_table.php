<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWflWorkPlanDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wfl_work_plan_dates', function (Blueprint $table) {
            $table->bigInteger('id_wpd')->primary();
            $table->bigInteger('project_id_wpd')->nullable();
            $table->bigInteger('work_plan_id_wpd')->nullable();
            $table->date('date_wpd')->nullable();
            $table->text('detail_wpd')->nullable();
            $table->text('observation_wpd')->nullable();
            $table->smallInteger('deleted_wpd')->default(0);
            $table->dateTime('createdon_wpd')->nullable();
            $table->bigInteger('createdby_wpd')->nullable();
            $table->dateTime('editedon_wpd')->nullable();
            $table->bigInteger('editedby_wpd')->nullable();
            
            $table->foreign('project_id_wpd', 'FK_95632510421F7860')->references('id_pro')->on('wfl_projects');
            $table->foreign('work_plan_id_wpd', 'FK_95632510FE226B9B')->references('id_wpl')->on('wfl_work_plans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wfl_work_plan_dates');
    }
}
