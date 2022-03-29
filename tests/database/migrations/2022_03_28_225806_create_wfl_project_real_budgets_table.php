<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWflProjectRealBudgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wfl_project_real_budgets', function (Blueprint $table) {
            $table->bigInteger('id_reb')->primary();
            $table->bigInteger('status_log_id_reb')->nullable();
            $table->double('design_reb')->nullable();
            $table->double('building_reb')->nullable();
            $table->double('transportation_reb')->nullable();
            $table->double('live_line_reb')->nullable();
            $table->double('right_of_way_reb')->nullable();
            $table->smallInteger('deleted_reb')->default(0);
            $table->dateTime('createdon_reb')->nullable();
            $table->bigInteger('createdby_reb')->nullable();
            $table->dateTime('editedon_reb')->default('2018-01-01 01:00:00');
            $table->bigInteger('editedby_reb')->nullable();
            
            $table->foreign('status_log_id_reb', 'FK_75991F72990FA5C4')->references('id_psl')->on('wfl_project_status_log');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wfl_project_real_budgets');
    }
}
